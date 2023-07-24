<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_cliente_queries.php');
/*
 *	Clase para manejar la transferencia de datos de la entidad usuario_cliente
 */
class usuario_cliente extends usuario_cliente_queries
{
    // Declaración de atributos (propiedades).
    public $id = null;
    public $nombre = null;
    public $apellido = null;
    public $correo = null;
    public $contrasenia = null;
    public $telefono = null;
    public $direccion = null;
    public $id_estado = null;
    public $id_cliente = null;
    public $usuario = null;
    public $pfp = null;

    /*
     *   Métodos para validar y asignar valores de los atributos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setnombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 35)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setapellido($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 35)) {
            $this->apellido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setContrasenia($value)
    {
        if (Validator::validatePassword($value)) {
            $this->contrasenia = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }
    public function setDireccion($value)
    {
        $this->direccion = $value;
        return true;
    }
    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setpfp($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->pfp = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setid_estado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_estado = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setid_cliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setusuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    /*
     *   Métodos para obtener valores de los atributos.
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getContasenia()
    {
        return $this->contrasenia;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getpfp()
    {
        return $this->pfp;
    }
    public function getid_estado()
    {
        return $this->id_estado;
    }
    public function getid_cliente()
    {
        return $this->id_cliente;
    }
    public function getusuario()
    {
        return $this->usuario;
    }
}
