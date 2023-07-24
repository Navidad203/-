<?php
require_once('../../entities/dto/mangas.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $mangas = new mangas();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    //arreglo para el filtro de busqueda
    $filtro = array('search' => null, 'genero' => 0, 'revista' => 0, 'autor' => 0, 'demografia' => 0);

     // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            //Obtener los mangas
            case 'ObtenerMangas':
                if ($result['dataset'] = $mangas->CargarMangas()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Cargar la imagen como vista previa en operaciones actualziar y eliminar
            case 'PreviewImagen':
                $_POST = Validator::validateForm($_POST);
                if (!$mangas->setPortada($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } else {
                    if (Validator::saveFile($_FILES['archivo'], $mangas->getrutaPreview(), $mangas->getPortada())) {
                        $result['dataset'] = $mangas->getPortada();
                        $result['estatus'] = 1;
                        $result['message'] = 'Manga creado correctamente';
                    }
                }
                break;
                //metodo para filtrar los mangas segun sea conveniente
            case 'FiltrosManga':
                $_POST = Validator::validateForm($_POST);
                $filtro['search'] = $_POST['search'];
                $filtro['genero'] = $_POST['genero'];
                $filtro['revista'] = $_POST['revista'];
                $filtro['demografia'] = $_POST['demografia'];
                $filtro['autor']=$_POST['autor'];
                if ($result['dataset'] = $mangas->FiltrarManga($filtro)) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //metodo para borrar el archivo de la imagen de vista previa
            case 'DeletePreviewImagen':
                $_POST = Validator::validateForm($_POST);
                    if (Validator::deleteFile($mangas->getrutaPreview(), $_POST['ruta'])) {
                        $result['estatus'] = 1;
                        $result['message'] = 'Archivo Eliminado correctamente';
                    } else {
                        $result['message'] = 'XDDDD';
                    }
                break;
                //metodo para agregar un manga
            case 'InsertarManga':
                $_POST = Validator::validateForm($_POST);
                if (!$mangas->setTitulo($_POST['titulo'])) {
                    $result['exception'] = 'titulo incorrecto';
                } elseif (!$mangas->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'descipcion';
                } elseif (!$mangas->setDemografia($_POST['demografia'])) {
                    $result['exception'] = 'Demografia incorrecta';
                } elseif (!$mangas->setAnio($_POST['anio'])) {
                    $result['exception'] = 'anio malo';
                } elseif (!$mangas->setVolumes($_POST['volumenes'])) {
                    $result['exception'] = 'Precio descipcion';
                } elseif (!$mangas->setRevista($_POST['revista'])) {
                    $result['exception'] = 'revista incorrecta';
                } elseif (!$mangas->setAutor($_POST['autor'])) {
                    $result['exception'] = 'autor incorrecta';
                } elseif (!$mangas->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$mangas->setPortada($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($mangas->InsertarManga()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $mangas->getRuta(), $mangas->getPortada())) {
                        $result['message'] = 'Manga creado correctamente';
                    } else {
                        $result['message'] = 'manga creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException() + "XD";
                }
                break;
                //metodo actualizar un manga
            case 'ActualizarManga':
                $_POST = Validator::validateForm($_POST);
                if (!$mangas->setIdMan($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $mangas->CargarMangaPorId()) {
                    $result['exception'] = 'Manga inexistente';
                } elseif (!$mangas->setTitulo($_POST['titulo'])) {
                    $result['exception'] = 'titulo incorrecto';
                } elseif (!$mangas->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'descipcion';
                } elseif (!$mangas->setDemografia($_POST['demografia'])) {
                    $result['exception'] = 'Demografia incorrecta';
                } elseif (!$mangas->setAnio($_POST['anio'])) {
                    $result['exception'] = 'anio malo';
                } elseif (!$mangas->setVolumes($_POST['volumenes'])) {
                    $result['exception'] = 'Precio descipcion';
                } elseif (!$mangas->setRevista($_POST['revista'])) {
                    $result['exception'] = 'revista incorrecta';
                } elseif (!$mangas->setAutor($_POST['autor'])) {
                    $result['exception'] = 'autor incorrecta';
                } elseif (!$mangas->setEstado($_POST['estado'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($mangas->ActualizarManga($data['portada'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Manga modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$mangas->setPortada($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($mangas->ActualizarManga($data['portada'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $mangas->getruta(), $mangas->getPortada())) {
                        $result['message'] = 'Manga modificado correctamente';
                    } else {
                        $result['message'] = 'Manga modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //metodo para agregar generos
            case 'InsertarGeneros':
                $_POST = Validator::validateForm($_POST);
                if (!$mangas->setIdGen($_POST['genero'])) {
                    $result['exception'] = 'No Hay id genero';
                } elseif (!$mangas->setIdMan($_POST['id'])) {
                    $result['exception'] = 'No Hay id manga';
                } elseif ($mangas->InsertarGenero()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //metodo para obtener el id de un manga mediante el titulo como parametro
            case 'ObtenerMangaId':
                if (!$mangas->setTitulo($_POST['titulo'])) {
                    $result['exception'] = 'Rev xd';
                } elseif ($result['dataset'] = $mangas->CargarMangaObtId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Manga inexistente';
                }
                break;
                //metodo para obtener un manga mediante un id como parametro
            case 'ObtenerMangaPorId':
                if (!$mangas->setIdMan($_POST['id'])) {
                    $result['exception'] = 'manga xd xd';
                } elseif ($result['dataset'] = $mangas->CargarMangaPorId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Manga inexistente';
                }
                break;
                //metodo para obtener un genero mediante el genero como parametro
            case 'ObtenerGeneroId':
                if (!$mangas->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero xd xd';
                } elseif ($result['dataset'] = $mangas->BuscarGeneroId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygnero';
                }

                //metodo obtener los genros de un manga especifico
            case 'ObtenerGenerosMangas':
                if (!$mangas->setIdMan($_POST['id'])) {
                    $result['exception'] = 'Genero xd xd';
                } elseif ($result['dataset'] = $mangas->CargarGenerosMangas()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygeneros';
                }
                break;
            case 'DeleteGenerosMangas':
                //metodo eliminar los generos de un manga especifico
                if (!$mangas->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Revista incorrecta';
                } elseif ($mangas->EliminarGenerosMangas()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //metodo eliminar un manga
            case 'DeleteManga':
                if (!$mangas->setIdMan($_POST['id'])) {
                    $result['exception'] = 'Id manga incorrecto';
                } elseif (!$data = $mangas->CargarMangaPorId()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($mangas->EliminarManga()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($mangas->getruta(), $data['portada'])) {
                        $result['message'] = 'manga eliminado correctamente';
                    } else {
                        $result['message'] = 'Manga eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //registros
                
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
?>