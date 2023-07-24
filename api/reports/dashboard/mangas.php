<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/mangas.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Mangas');
// Se instancia el módelo Categoría para obtener los datos.
$mangas = new Mangas;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($datamangas = $mangas->CargarMangasReport()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(255, 255, 255);
    // Se establece la fuente para los encabezados.
    //$pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->setFont('Arial', 'B', 10);
    $pdf->cell(125, 10, 'Manga', "L, B, R", 0, 'C', 1);
    $pdf->cell(30, 10, 'volumenes', "L, R, B", 0, 'C', 1);
    $pdf->cell(30, 10, $pdf->encodeString('valoración'), "L, B, R", 1, 'C', 1);
    $pdf->setFillColor(255, 255, 255);
    $pdf->setFont('Arial', '', 10);
    /*
    $pdf->cell(126, 10, 'Manga', "T", 0, 'C', 1);
    $pdf->cell(30, 10, 'Valoración', "T", 0, 'C', 1);
    $pdf->cell(30, 10, 'Volumenes', "T", 1, 'C', 1);
    $pdf->cell(126, 10, 'Manga', "T", 0, 'C', 1);
    $pdf->cell(30, 10, 'Valoración', "T", 0, 'C', 1);
    */
    //$pdf->Write(5, '');
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    //$pdf->setFillColor(225);

    // Se establece la fuente para los datos de los productos.
    //$pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($datamangas as $rowmanga) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(125, 10, $pdf->encodeString($rowmanga['titulo']), 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowmanga['volumenes'], 1, 0, 'C', 1);
        $valo;
        if($rowmanga['promedio'] == null){
            $valo = "Sin valoraciones";
        }else{
            $valo = $rowmanga['promedio'];
        }
        $pdf->cell(30, 10, $valo, 1, 1, 'C', 1);
        //$pdf->cell(0, 10, $rowmanga['valoracion'], 1, 1, 'C', 1);
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error. 
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No se Han encontrado registros'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'mangas.pdf');
