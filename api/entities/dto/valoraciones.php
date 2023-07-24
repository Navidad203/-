<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/valoraciones_queries.php');


class Valoraciones extends Valoraciones_Queries
{
    //declaracion de atributos (parametros)
    public $usuario = null;
    public $id_valoracion = null;
    public $valoracion = null;
    public $comentario = null;
    public $id_detalle_factura = null;


    //gets
    public function setUsuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_valoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setComentario($value)
    {
            $this->comentario = $value;
            return true;
            
    }

    public function setValoracion($value)
    {
        if ($value <= 5 && $value > 0) {
            $this->valoracion = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setId_Detalle_factura($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_factura = $value;
            return true;
        } else {
            return false;
        }
    }

    //sets

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getId_valoracion()
    {
        return $this->id_valoracion;
    }

    public function getValoracion()
    {
        return $this->valoracion;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function getId_Detalle_factura()
    {
        return $this->id_detalle_factura;
    }


}

?>