<?php
require_once('../../entities/dto/mangas.php');
require_once('../../entities/dto/productos.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $mangas = new mangas();
    $productos = new productos();
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    //arreglo para cuando se utilizen los filtros de busqueda
    $filtro = array('search' => null, 'genero' => 0, 'revista' => 0, 'autor' => 0, 'demografia' => 0);

    // Se verifica si existe una sesión iniciada. Si no se le envia a hacer la sesion estanfo offline.
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            //obtener todos los mangas existentes
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
                //metodo para filtrar los mangas segun sea conveniente
            case 'FiltrosManga':
                $_POST = Validator::validateForm($_POST);
                $filtro['search'] = $_POST['search'];
                $filtro['genero'] = $_POST['genero'];
                $filtro['revista'] = $_POST['revista'];
                $filtro['demografia'] = $_POST['demografia'];
                $filtro['autor'] = $_POST['autor'];
                if ($result['dataset'] = $mangas->FiltrarManga($filtro)) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Cargar un manga mediante un titulo como parametro
            case 'CargarCatalogoId':
                if (!$mangas->setTitulo($_POST['titulo'])) {
                    $result['exception'] = 'Rev xd';
                } elseif ($result['dataset'] = $mangas->CargarCatalogoObtId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Manga inexistente';
                }
                break;
                //Obtener los generos de un manga en especifico
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

                //Obtener los productos de un manga en especifico
            case 'ObtenerProductoPorManga':
                if (!$productos->setManga($_POST['manga'])) {
                    $result['exception'] = 'id malo';
                } elseif ($result['dataset'] = $productos->CargarProductoPorManga()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygnero';
                }

                break;
                //obtener los datos de un producto mediante el id_producto como parametro
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
                break;
            case 'AniadirACarrito':
                if (!$mangas->setUsuario($_SESSION['usuario'])) {
                    $result['exception'] = 'usuario malo';
                } elseif (!$mangas->VerificarFactura()) {
                    if (!$mangas->AgregarFactura()) {
                        $result['exception'] = 'ocurrio un error al guadar la factura';
                    } elseif (!$mangas->RestarProductos($_POST['producto'], $_POST['cantidad'])) {
                        $result['exception'] = 'Error. No hay suficientes existencias de este producto';
                    } elseif (!$mangas->AgregarDetalle($_POST['producto'], $_POST['cantidad'])) {
                        $result['exception'] = 'Error. ya hay un producto como este en el carrito';
                        $mangas->RestablecerProductos($_POST['producto'], $_POST['cantidad']);
                    } else {
                        $result['status'] = 1;
                        $result['message'] = 'Producto añadido al carrito';
                    }
                } elseif (!$mangas->RestarProductos($_POST['producto'], $_POST['cantidad'])) {
                    $result['exception'] = 'Error. No hay suficientes existencias de este producto';
                } elseif (!$mangas->AgregarDetalle($_POST['producto'], $_POST['cantidad'])) {
                    $result['exception'] = 'Error. ya hay un producto como este en el carrito';
                    $mangas->RestablecerProductos($_POST['producto'], $_POST['cantidad']);
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Producto añadido al carrito';
                }
                break;

            case 'ObtenerValoracionesProducto':
                if (!$result['dataset'] = $mangas->CargarValoracionesProducto($_POST['producto'])) {
                    $result['exception'] = 'No se pudo cargar las valoraciones';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Valoraciones Cargadas';
                }
                break;

                //-----------------------Volumenes/productos



            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        //acciones para cuando el usuario no esta conectado
        switch ($_GET['action']) {
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
            case 'FiltrosManga':
                $_POST = Validator::validateForm($_POST);
                $filtro['search'] = $_POST['search'];
                $filtro['genero'] = $_POST['genero'];
                $filtro['revista'] = $_POST['revista'];
                $filtro['demografia'] = $_POST['demografia'];
                $filtro['autor'] = $_POST['autor'];
                if ($result['dataset'] = $mangas->FiltrarManga($filtro)) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
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
            case 'ObtenerProductoPorManga':
                if (!$productos->setManga($_POST['manga'])) {
                    $result['exception'] = 'id malo';
                } elseif ($result['dataset'] = $productos->CargarProductoPorManga()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'nohaygnero';
                }

                break;

                //obtener's metodos
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
                //bug
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
            case 'CargarCatalogoId':
                if (!$mangas->setTitulo($_POST['titulo'])) {
                    $result['exception'] = 'Rev xd';
                } elseif ($result['dataset'] = $mangas->CargarCatalogoObtId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Manga inexistente';
                }
                break;
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

            case 'ObtenerGeneroId':
                if (!$mangas->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Genero xd xd';
                } elseif ($result['dataset'] = $mangas->BuscarGeneroId()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'no hay genero';
                }
                break;

            case 'ObtenerValoracionesProducto':
                if (!$result['dataset'] = $mangas->CargarValoracionesProducto($_POST['producto'])) {
                    $result['exception'] = 'No se pudo cargar las valoraciones';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Valoraciones Cargadas';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
