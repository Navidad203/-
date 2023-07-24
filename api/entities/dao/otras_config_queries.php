<?php
require_once('../../helpers/database.php');

class Otras_Config_Queries{

    //operaciones sql

    //obtener
    public function ObtenerGeneros(){

        $sql = 'SELECT id_genero, genero from generos  order by genero ASC';
        
        return Database::getRows($sql);   
    }

    public function ObtenerDemografias(){
        
        $sql = 'SELECT id_demografia, demografia from demografias  order by demografia ASC';
        return Database::getRows($sql);
    }

    public function ObtenerAutores(){
        
        $sql = 'SELECT id_autor, autor from autores  order by autor ASC';
        return Database::getRows($sql);
    }

    public function ObtenerRevistas(){
        
        $sql = 'SELECT id_revista, revista from revistas  order by revista ASC';
        return Database::getRows($sql);
    }

    public function ObtenerEstados(){
        
        $sql = 'SELECT id_estado, estado from estados_mangas  order by estado ASC';
        return Database::getRows($sql);
    }



    //obtener un dato especifico
    public function ObtenerGenerosId(){

        $sql = 'SELECT id_genero, genero from generos where id_genero = ?';
        $params = array($this->idGen);
        return Database::getRow($sql, $params);   
    }

    public function ObtenerDemografiaId(){

        $sql = 'SELECT id_demografia, demografia from demografias where id_demografia = ?';
        $params = array($this->idDem);
        return Database::getRow($sql, $params);   
    }

    public function ObtenerAutorId(){

        $sql = 'SELECT id_autor, autor from autores where id_autor = ? ';
        $params = array($this->idAut);
        return Database::getRow($sql, $params);   
    }

    public function ObtenerRevistaId(){

        $sql = 'SELECT id_revista, revista from revistas where id_revista = ? ';
        $params = array($this->idRev);
        return Database::getRow($sql, $params);   
    }
    


    //buscar
    public function BuscarDemografias($value){
        
        $sql = 'SELECT id_demografia, demografia from demografias where 
            demografia LIKE ?  order by demografia ASC';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    
    public function BuscarGeneros($value){
        
        $sql = 'SELECT id_genero, genero from generos where 
            genero LIKE ?  order by genero ASC';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function BuscarAutores($value){
        
        $sql = 'SELECT id_autor, autor from autores where 
            autor LIKE ?  order by autor ASC';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function BuscarRevistas($value){
        
        $sql = 'SELECT id_revista, revista from revistas where 
            revista LIKE ?  order by revista ASC';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Insertar
    public function InsertarGenero(){
        $sql = 'INSERT into generos (genero) values
            (?)';
        $params = array($this->genero);
        return Database::executeRow($sql, $params);
    }

    public function InsertarDemografia(){
        $sql = 'INSERT into demografias (demografia) values
            (?)';
        $params = array($this->demografia);
        return Database::executeRow($sql, $params);
    }

    public function InsertarAutor(){
        $sql = 'INSERT into autores (autor) values
            (?)';
        $params = array($this->autor);
        return Database::executeRow($sql, $params);
    }

    public function InsertarRevista(){
        $sql = 'INSERT into revistas (revista) values
            (?)';
        $params = array($this->revista);
        return Database::executeRow($sql, $params);
    }

    //actualizar
    public function ActualizacionGenero(){
        $sql = 'UPDATE generos SET genero = ? WHERE id_genero = ?';
        $params = array($this->genero, $this->idGen);
        return Database::executeRow($sql, $params);
    }

    public function ActualizacionDemografia(){
        $sql = 'UPDATE demografias
                SET demografia = ?
                WHERE id_demografia = ?';
        $params = array( $this->demografia, $this->idDem);
        return Database::executeRow($sql, $params);
    }

    public function ActualizacionAutor(){
        $sql = 'UPDATE autores
                SET autor = ?
                WHERE id_autor = ?';
        $params = array($this->autor, $this->idAut);
        return Database::executeRow($sql, $params);
    }

    public function ActualizacionRevista(){
        $sql = 'UPDATE revistas
                SET revista = ?
                WHERE id_revista = ?';
        $params = array($this->revista, $this->idRev);
        return Database::executeRow($sql, $params);
    }

    //Eliminacion
    public function deleteGenero()
    {
        $sql = 'DELETE FROM generos
                WHERE id_genero = ?';
        $params = array($this->idGen);
        return Database::executeRow($sql, $params);
    }

    public function deleteDemografia()
    {
        $sql = 'DELETE FROM demografias
                WHERE id_demografia = ?';
        $params = array($this->idDem);
        return Database::executeRow($sql, $params);
    }

    public function deleteAutor()
    {
        $sql = 'DELETE FROM autores
                WHERE id_autor = ?';
        $params = array($this->idAut);
        return Database::executeRow($sql, $params);
    }

    public function deleteRevista()
    {
        $sql = 'DELETE FROM revistas
                WHERE id_revista = ?';
        $params = array($this->idRev);
        return Database::executeRow($sql, $params);
    }

}

?>