<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report_productos.php');
require_once('../../entities/dto/report_productos.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
$pdf->startReport('Productos');
$producto = new Productos;
$dataProductos = null;
$parametros = true;

$pdf->setFillColor(255, 255, 255);

if ($_GET['fecha1']!= null && $_GET['fecha2']!= null) {
    $parametros = true;
    $pdf->cell(0, 10, "Desde ".$_GET['fecha1']." hasta el ". $_GET['fecha2'], 0, 0, 'C', 1);
    $pdf->ln(10);
}else{
    $parametros = false;
    $pdf->cell(0, 10, "Desde siempre", 0, 0, 'C', 1);
    $pdf->ln(10);
}



$pdf->setFont('Arial', 'B', 10);
$pdf->cell(100, 10, 'Manga', 1, 0, 'C', 1);
$pdf->cell(18, 10, 'volumen', 1, 0, 'C', 1);
$pdf->cell(18, 10, 'cantidad', 1, 0, 'C', 1);
$pdf->cell(20, 10, 'fecha', 1, 0, 'C', 1);
$pdf->cell(30, 10, 'usuario', 1, 1, 'C', 1);

$pdf->setFont('Arial', '', 10);
// Se verifica si hay parametros para las fechas
if ($parametros == true) {
    if ($consulta = $producto->obtenerRegistrosFecha($_GET['fecha1'], $_GET['fecha2'])) {
        $dataProductos = $consulta;
    } else {
        $pdf->cell(0, 10, $pdf->encodeString('error en consulta fechas'), 1, 1);
    }
} else if ($consulta = $producto->obtenerRegistros()) {
    $dataProductos = $consulta;
} else {
    $pdf->cell(0, 10, $pdf->encodeString('error en consulta sin fechas'), 1, 1);
};

if($dataProductos != null){
    foreach ($dataProductos as $rowProducto) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(100, 10, $pdf->encodeString($rowProducto['titulo']), 1, 0, 'C');
        $pdf->cell(18, 10, $rowProducto['volumen'], 1, 0, 'C', 1);
        $pdf->cell(18, 10, $rowProducto['cantidad'], 1, 0, 'C', 1);
        $pdf->cell(20, 10, $rowProducto['fecha'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['usuario'], 1, 1, 'C', 1);
    }
}


$pdf->output('I', 'categoria.pdf');
/*
foreach ($dataProductos as $rowProducto) {
    // Se imprimen las celdas con los datos de los productos.
    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['titulo']), 1, 0);
    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
    $pdf->cell(30, 10, $estado, 1, 1);
}
    //Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/productos.php');
    // Se instancian las entidades correspondientes.
    $producto = new Productos;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($categoria->setId($_GET['id_categoria']) && $producto->setCategoria($_GET['id_categoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowCategoria = $categoria->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la categoría ' . $rowCategoria['nombre_categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosCategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'categoria.pdf');
        } else {
            print('Categoría inexistente');
        }
    } else {
        print('Categoría incorrecta');
    }
*/