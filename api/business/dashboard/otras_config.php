<?php
require_once('../../entities/dto/otras_config.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $otras_config = new otras_config();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.

    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
                //obtener's metodos
            case 'ObtenerGeneros':
                if ($result['dataset'] = $otras_config->ObtenerGeneros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'ObtenerDemografias':
                if ($result['dataset'] = $otras_config->ObtenerDemografias()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'ObtenerAutores':
                if ($result['dataset'] = $otras_config->ObtenerAutores()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'ObtenerRevistas':
                if ($result['dataset'] = $otras_config->ObtenerRevistas()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'ObtenerEstados':
                if ($result['dataset'] = $otras_config->ObtenerEstados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                //obtener un dato metodos
            case 'ObtenerGeneroId':
                if (!$otras_config->setIdGen($_POST['id_genero'])) {
                    $result['exception'] = 'XD';
                } elseif ($result['dataset'] = $otras_config->ObtenerGenerosId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'ObtenerDemografiaId':
                if (!$otras_config->setIdDem($_POST['id_demografia'])) {
                    $result['exception'] = 'Demografia incorrecto';
                } elseif ($result['dataset'] = $otras_config->ObtenerDemografiaId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'ObtenerAutorId':
                if (!$otras_config->setIdAut($_POST['id_autor'])) {
                    $result['exception'] = 'Autor xd';
                } elseif ($result['dataset'] = $otras_config->ObtenerAutorId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'ObtenerRevistaId':
                if (!$otras_config->setIdRev($_POST['id_revista'])) {
                    $result['exception'] = 'Rev xd';
                } elseif ($result['dataset'] = $otras_config->ObtenerRevistaId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;


                //Search Metodos
            case 'BuscarDemografias':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $otras_config->BuscarDemografias($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'BuscarGeneros':
                if ($result['dataset'] = $otras_config->BuscarGeneros($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'BuscarAutores':
                if ($result['dataset'] = $otras_config->BuscarAutores($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'BuscarRevistas':
                if ($result['dataset'] = $otras_config->BuscarRevistas($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

                //Inserciones
            case 'AgregarGenero':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setGen($_POST['dato'])) {
                    $result['exception'] = 'No Hay Dato';
                } elseif ($otras_config->InsertarGenero()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'AgregarDemografia':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setDem($_POST['dato'])) {
                    $result['exception'] = 'No Hay Dato';
                } elseif ($otras_config->InsertarDemografia()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'AgregarAutor':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setAut($_POST['dato'])) {
                    $result['exception'] = 'No Hay Dato';
                } elseif ($otras_config->InsertarAutor()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'AgregarRevista':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setRev($_POST['dato'])) {
                    $result['exception'] = 'No Hay Dato';
                } elseif ($otras_config->InsertarRevista()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //actualizar
            case 'ActualizarGenero':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setIdGen($_POST['id'])) {
                    $result['exception'] = 'dato incorrecto';
                } elseif (!$otras_config->setGen($_POST['dato'])) {
                    $result['exception'] = ' xd';
                } elseif ($otras_config->ActualizacionGenero()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'ActualizarDemografia':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setIdDem($_POST['id'])) {
                    $result['exception'] = 'dato incorrecto';
                } elseif (!$cotras_config->setDem($_POST['dato'])) {
                    $result['exception'] = ' xd';
                } elseif ($otras_config->ActualizacionDemografia()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'ActualizarAutor':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setIdAut($_POST['id'])) {
                    $result['exception'] = 'dato incorrecto';
                } elseif (!$otras_config->setAut($_POST['dato'])) {
                    $result['exception'] = ' xd';
                } elseif ($otras_config->ActualizacionAutor()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'ActualizarRevista':
                $_POST = Validator::validateForm($_POST);
                if (!$otras_config->setIdRev($_POST['id'])) {
                    $result['exception'] = 'dato incorrecto';
                } elseif (!$otras_config->setRev($_POST['dato'])) {
                    $result['exception'] = ' xd';
                } elseif ($otras_config->ActualizacionRevista()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría modificada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //deletes
            case 'DeleteGenero':
                if (!$otras_config->setIdGen($_POST['id_genero'])) {
                    $result['exception'] = 'Genero incorrecta';
                } elseif (!$data = $otras_config->ObtenerGenerosId()) {
                    $result['exception'] = 'Genero inexistente';
                } elseif ($otras_config->deleteGenero()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'DeleteDemografia':
                if (!$otras_config->setIdDem($_POST['id_demografia'])) {
                    $result['exception'] = 'Demografia incorrecta';
                } elseif (!$data = $otras_config->ObtenerDemografiaId()) {
                    $result['exception'] = 'Genero inexistente';
                } elseif ($otras_config->deleteDemografia()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'DeleteAutor':
                if (!$otras_config->setIdAut($_POST['id_autor'])) {
                    $result['exception'] = 'Autyor incorrecta';
                } elseif (!$data = $otras_config->ObtenerAutorId()) {
                    $result['exception'] = 'Genero inexistente';
                } elseif ($otras_config->deleteAutor()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'DeleteRevista':
                if (!$otras_config->setIdRev($_POST['id_revista'])) {
                    $result['exception'] = 'Revista incorrecta';
                } elseif (!$data = $otras_config->ObtenerRevistaId()) {
                    $result['exception'] = 'Rev inexistente';
                } elseif ($otras_config->deleteRevista()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Por favor, Selecciona una tabla';
        }
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        switch ($_GET['action']) {
            case 'ObtenerGeneros':
                if ($result['dataset'] = $otras_config->ObtenerGeneros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'ObtenerDemografias':
                if ($result['dataset'] = $otras_config->ObtenerDemografias()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'ObtenerAutores':
                if ($result['dataset'] = $otras_config->ObtenerAutores()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'ObtenerRevistas':
                if ($result['dataset'] = $otras_config->ObtenerRevistas()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'ObtenerEstados':
                if ($result['dataset'] = $otras_config->ObtenerEstados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                //obtener un dato metodos
            case 'ObtenerGeneroId':
                if (!$otras_config->setIdGen($_POST['id_genero'])) {
                    $result['exception'] = 'XD';
                } elseif ($result['dataset'] = $otras_config->ObtenerGenerosId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'ObtenerDemografiaId':
                if (!$otras_config->setIdDem($_POST['id_demografia'])) {
                    $result['exception'] = 'Demografia incorrecto';
                } elseif ($result['dataset'] = $otras_config->ObtenerDemografiaId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            case 'ObtenerAutorId':
                if (!$otras_config->setIdAut($_POST['id_autor'])) {
                    $result['exception'] = 'Autor xd';
                } elseif ($result['dataset'] = $otras_config->ObtenerAutorId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'ObtenerRevistaId':
                if (!$otras_config->setIdRev($_POST['id_revista'])) {
                    $result['exception'] = 'Rev xd';
                } elseif ($result['dataset'] = $otras_config->ObtenerRevistaId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;


                //Search Metodos
            case 'BuscarDemografias':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $otras_config->BuscarDemografias($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'BuscarGeneros':
                if ($result['dataset'] = $otras_config->BuscarGeneros($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'BuscarAutores':
                if ($result['dataset'] = $otras_config->BuscarAutores($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'BuscarRevistas':
                if ($result['dataset'] = $otras_config->BuscarRevistas($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } 
} else {
    print(json_encode('Recurso no disponible'));
}
?>