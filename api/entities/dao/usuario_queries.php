<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($usuario)
    {
        $sql = 'SELECT id_usuario_administrador FROM usuarios_administradores WHERE usuario = ?';
        $params = array($usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario_administrador'];
            $this->usuario = $usuario;
            return true;
        } else {
            return false;
        }
    }

    //metodo para buscar la

    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia FROM usuarios_administradores WHERE id_usuario_administrador = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios_administradores SET contrasenia = ? WHERE id_usuario_administrador = ?';
        $params = array($this->clave, $_SESSION['id_usuario_administrador']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
         $sql = 'SELECT id_usuario_administrador, usuario, estado
                 FROM usuarios_administradores
                 INNER JOIN estados_usuarios
                 ON usuarios_administradores.id_estado = estados_usuarios.id_estado
                 WHERE id_usuario_administrador = ?';
        $params = array($_SESSION['id_usuario_administrador']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios_administradores
                SET  usuario=?, contrasenia=?, id_estado=?
                WHERE id_usuario_administrador=?';
        $params = array($this->usuario, $this->contrasenia, $this->id_estado, $_SESSION['id_usuario_administrador']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario_administrador, usuario, estado
                FROM usuarios_administradores
                INNER JOIN estados_usuarios
                ON usuarios_administradores.id_estado = estados_usuarios.id_estado
                WHERE usuario LIKE ?';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios_administradores(usuario, contrasenia, id_estado)
                VALUES(?, ?, ?)';
                
        $params = array($this->usuario, $this->clave, $this->estado);
        return Database::executeRow($sql, $params);
    }

    //leer los usuarios administradores
    public function readAll()
    {
        $sql = 'SELECT id_usuario_administrador, usuario
                FROM usuarios_administradores';
        return Database::getRows($sql);
    }

    //leer los usuarios de los clientes
    public function readAllClients()
    {
        $sql = 'SELECT id_usuario_cliente, usuario
                FROM usuarios_clientes';
        return Database::getRows($sql);
    }

    public function readAdmin()
    {
        $sql = 'SELECT id_usuario_administrador, usuario, estado
                FROM usuarios_administradores
                INNER JOIN estados_usuarios
                ON usuarios_administradores.id_estado = estados_usuarios.id_estado';
        return Database::getRows($sql);
    }

    public function readEst()
    {
        $sql = 'SELECT id_estado, estado
                FROM estados_usuarios';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario_administrador, usuario
                FROM usuarios_administradores
                WHERE id_usuario_administrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios_administradores
                SET  usuario=?, id_estado=?
                WHERE id_usuario_administrador=?';
        $params = array($this->usuario, $this->estado,$this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios_administradores
                WHERE id_usuario_administrador=?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    

}
