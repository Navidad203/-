<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report_productos.php');
require_once('../../entities/dto/productos.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
$pdf->startReport('Listado de productos');
$producto = new Productos;
$dataProductos = null;
$parametros = true;

$pdf->setFillColor(255, 255, 255);


if ($dataProductos = $producto->ObtenerProductos()) {
    $manga = null;
    $first = false;
    foreach ($dataProductos as $rowProducto) {
        if ($manga != $rowProducto['titulo']) {
            $pdf->ln(10);
            $pdf->setFont('Arial', 'B', 10);
            $pdf->cell(30, 10, 'Manga:', 1, 0, 'C', 1);
            $pdf->cell(150, 10, $rowProducto['titulo'], 1, 1, 'C', 1);
            $manga = $rowProducto['titulo'];
        }
        $pdf->setFont('Arial', 'B', 10);
        $pdf->cell(30, 10, 'volumen:', 1, 0, 'C', 1);
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(30, 10, $rowProducto['volumen'], 1, 0, 'C', 1);
        $pdf->setFont('Arial', 'B', 10);
        $pdf->cell(30, 10, 'Unidades:', 1, 0, 'C', 1);
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(30, 10, $rowProducto['cantidad'], 1, 0, 'C', 1);
        $pdf->setFont('Arial', 'B', 10);
        $pdf->cell(30, 10, 'Precio:', 1, 0, 'C', 1);
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(30, 10, '$'.$rowProducto['precio'], 1, 1, 'C', 1);
        /*if ($salto == true) {
            if ($first != true) {
                $pdf->ln(10);
            }

        }*/
    }
} else {
    $pdf->cell(30, 10, 'ocurrio un error', 1, 0, 'C', 1);
}


$pdf->output('I', 'categoria.pdf');
