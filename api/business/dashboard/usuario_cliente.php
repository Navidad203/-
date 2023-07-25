<?php
require_once('../../entities/dto/usuario_cliente.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new usuario_cliente;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'usuario' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.

        switch ($_GET['action']) {
                //obtener el usuario de la sesion activa
            case 'getUser':
                if (isset($_SESSION['usuario'])) {
                    $usuario->setusuario($_SESSION['usuario']);
                    if ($usuario->ValidarUsuario() == null) {
                        $result['status'] = 1;
                        $result['usuario'] = $_SESSION['usuario'];
                    } else {
                        $result['exception'] = 'El usuario con el que desea acceder se encuentra bloqueado. Contacte a un administr';
                    }
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
                //verifiar si hay un usuario en la sesion iniciada
            case 'verifyusers':
                if (isset($_SESSION['usuario'])) {
                    $result['usuario'] = $_SESSION['usuario'];
                    if (!$usuario->setusuario($_SESSION['usuario'])) {
                        $result['exception'] = 'Ocurrio un error al validar la sesión, por favor inicie sesión';
                    } elseif (!$usuario->VerifyUser()) {
                        $result['exception'] = 'Ocurrio un error al validar la sesión, por favor inicie sesión';
                    } else {
                        if ($usuario->ValidarUsuario() == null) {
                            $result['status'] = 1;
                            $result['usuario'] = $_SESSION['usuario'];
                        } else {
                            $result['exception'] = 'El usuario con el que desea acceder se encuentra bloqueado. Contacte a un administr';
                        }
                    }
                } else {
                    $result['exception'] = 'No se encuentra usuario';
                }

                break;
                //eliminar cualquier sesión del navegador
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
                //buscar todos los usuarios
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //buscar clietes mediante nombre y apellido
            case 'Buscar':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['buscar'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->Buscar($_POST['buscar'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //buscar un cliente en especifico mediante el id
            case 'readOne':
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                //actualizar cliente
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->setnombre($_POST['nombre'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$usuario->setapellido($_POST['apellido'])) {
                    $result['exception'] = 'apellido incorrecto';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'correo incorrecto';
                } elseif (!$usuario->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'telefono incorrecto';
                } elseif (!$usuario->setdireccion($_POST['direccion'])) {
                    $result['exception'] = 'direccion incorrecto';
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'updateUs':
                //actualizar usuario
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['idUs'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->setusuario($_POST['usuario'])) {
                    $result['exception'] = 'nombre incorrecto';
                } elseif (!$usuario->setid_estado($_POST['estado'])) {
                    $result['exception'] = 'estado incorrecto';
                } elseif ($usuario->updateUs()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'GetUsuario':
                //obtener un usuario mediante el id
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->GetEUsuario()) {
                    $result['status'] = 1;
                    $result['message'] = 'ususario encontrado';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'delete':
                //eliminar el usuario mediante el id_cliente
                if (!$usuario->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'getUser_cliente':
                if (isset($_SESSION['usuario'])) {
                    $usuario->setusuario($_SESSION['usuario']);
                    if ($usuario->ValidarUsuario() == null) {
                        $result['status'] = 1;
                        $result['usuario'] = $_SESSION['usuario'];
                    } else {
                        $result['exception'] = 'El usuario con el que desea acceder se encuentra bloqueado. Contacte a un administrar';
                    }
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'ObtenerUsuarioCliente':
                if (!$usuario->setusuario($_SESSION['usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->ObtenerUsuarioCliente()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                //registrar un cliente y su usario respectivo
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setnombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$usuario->setapellido($_POST['apellido'])) {
                    $result['exception'] = "apellido incorrecto";
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = "correo incorrecto";
                } elseif (!$usuario->setDireccion($_POST['direccion'])) {
                    $result['exception'] = "direccion incorrecto";
                } elseif (!$usuario->setTelefono($_POST['telefono'])) {
                    $result['exception'] = "telefono incorrecto";
                } elseif ($_POST['password'] != $_POST['passwordCon']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setContrasenia($_POST['password'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->CrearCliente()) {
                    if (!$usuario->setId($usuario->ObtenerIdUsEmail())) {
                        $result['exception'] = 'Fallo id';
                    } elseif (!$usuario->setusuario($_POST['usuario'])) {
                        $result['exception'] = 'Fallo usuario';
                    } elseif ($usuario->CrearUsuario()) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario registrado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } else {
                    $result['exception'] = 'Error al crear el cliente';
                    $result['exception'] = Database::getException();
                }
                break;
                //iniciar sesión sitio publico
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setusuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario no valido';
                } elseif ($_POST['password'] == null) {
                    $result['exception'] = 'Ingrese una contraseña';
                } elseif (!$usuario->setId($usuario->obtenerIdUsuario())) {
                    $result['exception'] = 'Usuario no encontrado';
                } elseif ($usuario->checkPassword($_POST['password'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['usuario'] = $_POST['usuario'];
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
                   //grafica de productos
                    case 'graficoUsuario':
                    if ($result['dataset'] = $productos->graficoUsuario()) {
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
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
