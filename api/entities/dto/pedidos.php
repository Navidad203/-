<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');


class Pedidos extends Pedidos_Queries
{
    //declaracion de atributos (parametros)
    public $id_factura = null;
    public $usuario = null;
    public $id_detalle = null;


    //gets
    public function setId_factura($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_factura = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setId_Detalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle = $value;
            return true;
        } else {
            return false;
        }
    }

    //sets

    public function getId_factura()
    {
        return $this->id_factura;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getId_Detalle()
    {
        return $this->id_detalle;
    }


}

?>