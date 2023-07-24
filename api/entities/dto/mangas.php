<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/mangas_quearies.php');


class mangas extends mangas_quearies{

    //campos declaracion
    public $idMan = null;
    public $titulo = null;
    public $portada = null;
    public $descripcion = null;
    public $demografia = null;
    public $anio = null;
    public $volumenes = null;
    public $revista = null;
    public $autor = null;
    public $estado = null;
    protected $ruta = '../../images/mangas/';
    protected $rutaPreview = '../../images/mangas/previews/';

    //generos 
    public $idDetalle = null;
    public $idGen = null;
    public $genero = null;

    //usuario
    public $usuario = null;

    //setter's

    public function setIdMan($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idMan = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTitulo($value)
    {

            $this->titulo = $value;
            return true;
    }

    public function setPortada($file)
    {
        if (Validator::validateImageFile($file, 250, 350)) {
            $this->portada = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
            $this->descripcion = $value;
            return true;
            
    }

    public function setDemografia($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->demografia = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAnio($value)
    {
            $this->anio = $value;
            return true;
    }

    public function setVolumes($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->volumenes = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRevista($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->revista = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setAutor($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->autor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    //genero
    public function setIdGen($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idGen = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idDetalle = $value;
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

    //getter's

    public function getIdMan()
    {
        return $this->idGen;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getPortada()
    {
        return $this->portada;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getDemografia()
    {
        return $this->demografia;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function getVolumenes()
    {
        return $this->volumenes;
    }

    public function getRevista()
    {
        return $this->revista;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getruta()
    {
        return $this->ruta;
    }

    public function getrutaPreview()
    {
        return $this->rutaPreview;
    }

    //generos
    public function getIdGen()
    {
        return $this->idGen;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getIdDetalle()
    {
        return $this->idDetalle;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }


}