<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad usuario_cliente.
*/
class usuario_cliente_queries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre, apellido,correo,contrasenia,telefono,direccion
                FROM clientes
                WHERE clientes LIKE ? OR id_cliente LIKE ?
                ORDER BY clientes';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //verificar usuario existente
    public function VerifyUser()
    {
        $sql = 'SELECT usuario from usuarios_clientes where usuario = ?';
        $params = array($this->usuario);
        return Database::getRow($sql, $params);
    }
    //obtener id usuario
    public function obtenerIdUsuario()
    {
        $sql = 'SELECT id_usuario_cliente from usuarios_clientes where usuario = ?';
        $params = array($this->usuario);
        $array =  Database::getRow($sql, $params);
        if($array == null){
            return false;
        }else{
            return $array['id_usuario_cliente'];
        }
        
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia FROM usuarios_clientes WHERE usuario = ?';
        $params = array($this->usuario);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia'])) {
            return true;
        } else {
            return false;
        }
    }

    /*OPERACIONES REGISTRO*/
    public function CrearCliente()
    {
        $sql = 'INSERT INTO clientes(
            nombre, apellido, correo, direccion, telefono)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->correo, $this->direccion, $this->telefono);
        return Database::executeRow($sql, $params);
    }

    public function ObtenerIdUsEmail()
    {
        $sql = 'SELECT id_cliente from clientes where correo = ?';
        $params = array($this->correo);
        $array =  Database::getRow($sql, $params);
        return $array['id_cliente'];
    }

    public function CrearUsuario()
    {
        $sql = 'INSERT INTO usuarios_clientes(
            usuario, contrasenia, id_estado, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->usuario, $this->contrasenia, 1, $this->id);
        return Database::executeRow($sql, $params);
    }

    


    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre, apellido,correo,telefono,direccion
        FROM clientes
        ORDER BY id_cliente asc';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre, apellido,correo,direccion,telefono
                FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE clientes
        SET  nombre=?, apellido=?, correo=?, direccion=?, telefono=?
        WHERE id_cliente = ?';
        $params = array( $this->nombre, $this->apellido, $this->correo, $this->direccion, $this->telefono, $this->id);
        return Database::executeRow($sql, $params);
    }
    public function updateUs()
    {
        $sql = 'UPDATE usuarios_clientes
        SET  usuario=?, id_estado=?
        WHERE id_usuario_cliente = ?';
        $params = array( $this->usuario, $this->id_estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function GetEUsuario()
    {
        $sql = 'SELECT usuarios_clientes.id_usuario_cliente, usuarios_clientes.usuario, usuarios_clientes.id_estado,
        clientes.nombre, clientes.apellido
        from usuarios_clientes INNER JOIN clientes ON
        clientes.id_cliente = usuarios_clientes.id_cliente where usuarios_clientes.id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function Buscar($search)
    {
        $sql = 'SELECT id_cliente, nombre, apellido,correo,telefono,direccion
                FROM clientes
                where nombre LIKE ? or apellido LIKE ? ORDER BY clientes';
        $params = array('%'.$search.'%', '%'.$search.'%');
        return Database::getRows($sql, $params);
    }

    //validación de logIn
    public function ValidarUsuario()
    {
        $sql = 'SELECT usuario, id_estado from usuarios_clientes where usuario = ? and id_estado = 2';
        $params = array($this->usuario);
        return Database::getRow($sql, $params);
    }

    public function ObtenerUsuarioCliente()
    {
        $sql = 'SELECT id_usuario_cliente, clientes.id_cliente, usuario, clientes.nombre, clientes.apellido, clientes.correo, clientes.direccion,clientes.telefono
        FROM usuarios_clientes
        INNER JOIN clientes
        ON usuarios_clientes.id_cliente = clientes.id_cliente
        WHERE usuarios_clientes.usuario = ?';
                $params = array($this->usuario);
                return Database::getRow($sql, $params);
    }
}
