<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report_productos.php');
require_once('../../entities/dto/productos.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
$pdf->startReport('Listado de pedidos');
$producto = new Productos;
$dataProductos = null;
$parametros = true;

/*
$pdf->setFont('Arial', '', 10);
$pdf->cell(60, 10, 'asfsdfsdgfsfdgsdfgfsdf', 1, 0, 'C', 1);
$pdf->setFont('Arial', 'B', 10);
$pdf->cell(30, 10, 'Precio:', 1, 0, 'C', 1);
$pdf->setFont('Arial', '', 10);
*/
if ($dataProductos = $producto->productoReporte($_GET['id'])) {
    $pdf->setFillColor(199, 199, 199);
    $pdf->setFont('Arial', 'B', 10);
    $pdf->cell(0, 10, 'Black Clover' . 'uwu', 1, 1, 'C', 1);
    $pdf->setFillColor(255, 255, 255);
    $pdf->cell(96, 10, 'nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'usuario', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'cantidad', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'id factura', 1, 1, 'C', 1);
    foreach ($dataProductos as $rowProducto) {
        $pdf->setFont('Arial', '', 10);
        $pdf->cell(96, 10, $rowProducto['nombre'].' '.$rowProducto['apellido'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['usuario'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['cantidad'], 1, 0, 'C', 1);
        $pdf->cell(30, 10, $rowProducto['id_factura'], 1, 1, 'C', 1);
        
    }
} else {
    $pdf->setFillColor(255, 255, 255);
    $pdf->cell(30, 10, 'No hay registros', 1, 0, 'C', 1);
}

$pdf->output('I', 'categoria.pdf');
