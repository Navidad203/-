<?php
require_once('../../entities/dto/productos.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $productos = new productos();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);

    $filtro = array('manga' => 0, 'unidades' => 0, 'volumen' => 0);

    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'ObtenerProductos':
                if ($result['dataset'] = $productos->ObtenerProductos()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'PreviewImagen':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setCover($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } else {
                    if (Validator::saveFile($_FILES['archivo'], $productos->getRutaPreview(), $productos->getCover())) {
                        $result['dataset'] = $productos->getCover();
                        $result['estatus'] = 1;
                        $result['message'] = 'Preview Ingresada creado correctamente';
                    }
                }
                break;
            case 'FiltrosProductos':
                $_POST = Validator::validateForm($_POST);
                $filtro['manga'] = $_POST['manga'];
                $filtro['unidades'] = $_POST['unidades'];
                $filtro['volumen'] = $_POST['volumen'];
                if ($result['dataset'] = $productos->FiltrarProductos($filtro)) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'DeletePreviewImagen':
                $_POST = Validator::validateForm($_POST);
                if (Validator::deleteFile($productos->getrutaPreview(), $_POST['ruta'])) {
                    $result['estatus'] = 1;
                    $result['message'] = 'Archivo Eliminado correctamente';
                } else {
                    $result['message'] = 'XDDDD';
                }
                break;
                //obtener's metodos
            case 'InsertarProducto':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setManga($_POST['manga'])) {
                    $result['exception'] = 'manga incorrecto';
                } elseif (!$productos->setVolumen($_POST['volumen'])) {
                    $result['exception'] = 'voluemn xd';
                } elseif (!$productos->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'cantidad incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'precio malo';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$productos->setCover($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($productos->InsertarProducto()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $productos->getRuta(), $productos->getCover())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException() + "XD";
                }
                break;
            case 'ActualizarProducto':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $productos->CargarProductoPorId()) {
                    $result['exception'] = 'producto inexistente';
                } elseif (!$productos->setManga($_POST['manga'])) {
                    $result['exception'] = 'manga incorrecto';
                } elseif (!$productos->setVolumen($_POST['volumen'])) {
                    $result['exception'] = 'volumen';
                } elseif (!$productos->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif (!$productos->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'anio malo';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($productos->ActualizarPruducto($data['cover'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$productos->setCover($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($productos->ActualizarPruducto($data['cover'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $productos->getRuta(), $productos->getCover())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //bug
            case 'ValidarVolumenesProducto':
                if (!$productos->setManga($_POST['manga'])) {
                    $result['exception'] = 'id xd';
                } elseif (!$productos->setVolumen($_POST['volumen'])) {
                    $result['exception'] = 'volumen xd';
                } elseif ($result['dataset'] = $productos->ValidarVolumenProducto()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Ya hay un producto asignado a este manga y volumen';
                }
                break;
            case 'ObtenerProductoPorId':
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'id malo';
                } elseif ($result['dataset'] = $productos->CargarProductoPorId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygnero';
                }

                /*case 'ObtenerMangaIdUp':
                if (!$mangas->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero xd xd';
                } elseif ($result['dataset'] = $mangas->BuscarMangaId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygnero';
                }
                */
                break;
            case 'DeleteProducto':
                if (!$productos->setId($_POST['id_del'])) {
                    $result['exception'] = 'Id producto incorrecto';
                } elseif (!$data = $productos->CargarProductoPorId()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($productos->EliminarProducto()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($productos->getruta(), $data['cover'])) {
                        $result['message'] = 'producto eliminado correctamente';
                    } else {
                        $result['message'] = 'producto eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //registros
            case 'ObtenerRegistros':
                if ($result['dataset'] = $productos->ObtenerRegistros()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'InsertarRegistros':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id_reg'])) {
                    $result['exception'] = 'No Hay id';
                } elseif ($productos->InsertarRegistro($_POST['mod'], $_SESSION['id_usuario'])) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

                //pedidos
            case 'ObtenerPedidos':

                if ($result['dataset'] = $productos->ObtenerPedidos()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'BuscarPedidos':
                $_POST = Validator::validateForm($_POST);
                if ($result['dataset'] = $productos->BuscarPedidos($_POST['buscar'], $_POST['fecha1'], $_POST['fecha2'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'ObtenerEstadosFacturas':
                if ($result['dataset'] = $productos->ObtenerEstadosFacturas()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'ActualizarEstado':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'No Hay id';
                } elseif ($productos->ActualizarEstado($_POST['estado'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado Actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'ObtenerValoraciones':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'No Hay id';
                } elseif ($result['dataset'] = $productos->ObtenerValoraciones()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'ActualizarEst':
                $_POST = Validator::validateForm($_POST);
                if (!$productos->setId($_POST['id'])) {
                    $result['exception'] = 'No Hay id';
                } elseif ($productos->ActualizarEst($_POST['estado'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado Actualizado exitosamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'ObtenerDetalle':
                if (!$productos->setId($_POST['id_pro'])) {
                    $result['exception'] = 'No Hay id';
                } elseif ($result['dataset'] = $productos->ObtenerDetalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'ProductoMasVendido':
                if ($result['dataset'] = $productos->ProductoMasVendido()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'GeneroMasVendido':
                if ($result['dataset'] = $productos->GeneroMasVendido()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                                 //grafica de productos
                                 case 'graficoProductos':
                                    if ($result['dataset'] = $productos->graficoProductos()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                                    } elseif (Database::getException()) {
                                        $result['exception'] = Database::getException();
                                    } else {
                                        $result['exception'] = 'No hay datos registrados';
                                    }
                                    break;

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
