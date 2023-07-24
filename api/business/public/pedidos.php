<?php
require_once('../../entities/dto/pedidos.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedidos = new Pedidos();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    $filtro = array('search' => null, 'genero' => 0, 'revista' => 0, 'autor' => 0, 'demografia' => 0);

    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
                //obtener las facturas de un usuario
            case 'ObtenerFacturas':
                if (!$pedidos->setUsuario($_SESSION['usuario'])) {
                    $result['exception'] = 'error al obtener el usuario';
                } elseif (!$result['dataset'] = $pedidos->ObtenerFacturas()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'facturas cargadas';
                }
                break;
                //obtener los detalles de una factura
            case 'ObtenerDetallesFacturas':
                if (!$pedidos->setId_factura($_POST['id_factura'])) {
                    $result['exception'] = 'error al definir id_factura';
                } elseif (!$result['dataset'] = $pedidos->ObtenerDetalleFactura()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'detalles obtenidos';
                }
                break;

            case 'ObtenerDetallesCarrito':
                if (!$pedidos->setUsuario($_SESSION['usuario'])) {
                    $result['exception'] = 'error al obtener el usuario';
                } elseif (!$result['dataset'] = $pedidos->ObtenerDetalleFacturaCarrito()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'carrito Cargado';
                }
                break;

            case 'EliminarElementoCarrito':
                $_POST = Validator::validateForm($_POST);
                if (!$pedidos->setId_Detalle($_POST['id_detalle'])) {
                    $result['exception'] = 'error al id_detalle';
                } elseif (!$pedidos->EliminarElementoCarrito()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Elemento eliminado del carrito';
                }
                break;

            case 'CancelarCarrito':
                $_POST = Validator::validateForm($_POST);
                if (!$pedidos->setId_factura($_POST['id'])) {
                    $result['exception'] = 'error al obtener el id';
                } elseif (!$pedidos->CancelarCarrito()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Enhorabuena!! Tu pedido se a realizado correctamente';
                }
                break;
                case 'RestablecerProductos':
                    $_POST = Validator::validateForm($_POST);
                    if (!$pedidos->RestablecerProductos($_POST['cantidad'], $_POST['id_producto'])) {
                        $result['exception'] = 'Error al restablecer el producto';
                    }
                    else {
                        $result['status'] = 1;
                    }
                    break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        $result['exception'] = 'Acción no disponible dentro de la sesión';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
