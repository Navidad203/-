<?php
require_once('../../entities/dto/valoraciones.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoraciones = new Valoraciones();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);

    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
                //obtener las facturas de un usuario
            case 'ObtenerNoValoraciones':
                if (!$valoraciones->setUsuario($_SESSION['usuario'])) {
                    $result['exception'] = 'error al obtener el usuario';
                } elseif (!$result['dataset'] = $valoraciones->ObtenerNoValoraciones()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Cargado no valoraciones';
                }
                break;
            case 'ObtenerValoraciones':
                if (!$valoraciones->setUsuario($_SESSION['usuario'])) {
                    $result['exception'] = 'error al obtener el usuario';
                } elseif (!$result['dataset'] = $valoraciones->ObtenerValoraciones()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Cargado valoraciones';
                }
                break;
            case 'ActualizarValoracion':
                $_POST = Validator::validateForm($_POST);
                if (!$valoraciones->setId_valoracion($_POST['idvalo'])) {
                    $result['exception'] = 'error al obtener el id';
                } elseif (!$valoraciones->setValoracion($_POST['valoracion'])) {
                    $result['exception'] = 'error al obtener la valoracion';
                } elseif (!$valoraciones->setComentario($_POST['comentario'])) {
                    $result['exception'] = 'error al obtener el comentario';
                } elseif (!$valoraciones->ActualizarValoracion()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Has actualizado tu comentario exitosamente!';
                }
                break;
            case 'AgregarValoracion':
                $_POST = Validator::validateForm($_POST);
                if (!$valoraciones->setValoracion($_POST['valoracion'])) {
                    $result['exception'] = 'error al obtener la valoracion';
                } elseif (!$valoraciones->setComentario($_POST['comentario'])) {
                    $result['exception'] = 'error al obtener el comentario';
                } elseif (!$valoraciones->setId_Detalle_factura($_POST['id_detalle'])) {
                    $result['exception'] = 'error al obtener la factura';
                }elseif (!$valoraciones->AgregarValoracion()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha subido tu comentario exitosamente';
                }
                break;
            case 'ObtenerValoracionId':
                $_POST = Validator::validateForm($_POST);
                if (!$valoraciones->setId_valoracion($_POST['id'])) {
                    $result['exception'] = 'error al obtener la valoracion';
                } elseif (!$result['dataset'] = $valoraciones->ObtenerValoracionId()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion cargada';
                }
                break;
                case 'graficaValoraciones':
                    $_POST = Validator::validateForm($_POST);
                    if (!$valoraciones->graficaValoraciones($_POST['id'])) {
                        $result['exception'] = 'error al obtener la valoracion';
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['status'] = 1;
                        $result['message'] = 'Valoracion cargada';
                    }
                    break;
                //obtener los detalles de una factura

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
