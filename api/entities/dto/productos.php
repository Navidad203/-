<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/productos_quearies.php');

class Productos extends Productos_Quearies{
    public $id = null;
    public $manga = null;
    public $cover = null;
    public $volumen = null;
    public $cantidad = null;
    public $precio = null;

    public $ruta = '../../images/productos/';
    public $rutaPreview = '../../images/productos/previews/';

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setManga($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->manga = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCover($file)
    {
        if (Validator::validateImageFile($file, 300, 400)) {
            $this->cover = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setVolumen($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->volumen = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    //getters
    public function getId()
    {
        return $this->id;
    }

    
    public function getManga()
    {
        return $this->manga;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function getVolumen()
    {
        return $this->volumen;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function getRutaPreview()
    {
        return $this->rutaPreview;
    }

}
?>