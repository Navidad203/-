<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/otras_config_queries.php');


class otras_config extends Otras_Config_Queries{

    //id's
    public $idGen = null;
    public $idDem = null;
    public $idAut = null;
    public $idRev = null;

    public $genero = null;
    public $demografia = null;
    public $autor = null;
    public $revista = null;

    //setter's

    public function setIdGen($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idGen = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdDem($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idDem = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdAut($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idAut = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdRev($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idRev = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setGen($value)
    {
            $this->genero = $value;
            return true;
    }

    public function setDem($value)
    {
            $this->demografia = $value;
            return true;
    }

    public function setAut($value)
    {
            $this->autor = $value;
            return true;
    }

    public function setRev($value)
    {
            $this->revista = $value;
            return true;
    }

    //getter's

    public function getIdGen()
    {
        return $this->idGen;
    }

    public function getIdDem()
    {
        return $this->idDem;
    }

    public function getIdAut()
    {
        return $this->idAut;
    }

    public function getIdRev()
    {
        return $this->idRev;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getDemografia()
    {
        return $this->demografia;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getRev()
    {
        return $this->revista;
    }


}