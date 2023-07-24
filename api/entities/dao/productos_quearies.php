<?php
require_once('../../helpers/database.php');



class Productos_Quearies{
    public function ObtenerProductos()
    {
        $sql = 'SELECT productos.id_producto, productos.cover, mangas.titulo, 
        productos.volumen, productos.cantidad,
        productos.precio
        from productos
        INNER JOIN mangas ON productos.id_manga = mangas.id_manga
        ORDER BY mangas.titulo ASC
        ';
        return Database::getRows($sql);
    }

    //reporte parametrizado producto
    public function productoReporte($id)
    {
        $sql = 'SELECT mangas.titulo, productos.volumen, detalles_facturas.cantidad, 
        detalles_facturas.id_factura, clientes.nombre, clientes.apellido, usuarios_clientes.usuario 
        from detalles_facturas INNER JOIN productos USING (id_producto) INNER JOIN mangas USING (id_manga) 
        INNER JOIN facturas USING (id_factura) INNER JOIN clientes USING (id_cliente) 
        INNER JOIN usuarios_clientes USING (id_cliente) where productos.id_producto = ?
        ';
        $params = array($id);
        return Database::getRows($sql, $params);
    }

    public function InsertarProducto()
    {
        $sql = 'INSERT INTO productos(
            id_manga, cover, volumen, cantidad, precio)
            VALUES (?, ?, ?, ?, ?)';
        $params = array($this->manga, $this->cover, $this->volumen, $this->cantidad, $this->precio);
        return Database::executeRow($sql, $params);
    }

    public function ActualizarPruducto($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->cover) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->cover = $current_image;

        $sql = 'UPDATE productos
        SET id_manga=?, cover=?, volumen=?, cantidad=?, precio=?
        WHERE id_producto =?';
        $params = array($this->manga, $this->cover, $this->volumen, $this->cantidad, $this->precio, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function EliminarProducto()
    {
        $sql = 'DELETE from productos where id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function CargarProductoPorId()
    {
        $sql = 'SELECT id_producto, id_manga, cover, volumen, cantidad, precio
        FROM productos where id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function ValidarVolumenProducto()
    {
        $sql = 'SELECT id_producto, id_manga, volumen from productos
        where
        id_manga = ? and
        volumen = ?
        ';
        $params = array($this->manga, $this->volumen);
        return Database::getRow($sql, $params);
    }

    public function FiltrarProductos($filtros)
    {
        $sql = null;
        //verificar si se estan filtrando los generos
        if($filtros['manga'] != 'Mangas')
        {
            $sql = 'SELECT productos.id_producto, productos.cover, mangas.titulo, 
            productos.volumen, productos.cantidad,
            productos.precio
            from productos
            INNER JOIN mangas ON productos.id_manga = mangas.id_manga
            WHERE productos.id_manga = '.$filtros['manga'].' ORDER BY';
            //si no es el caso se manda a llamar una consulta mas simple
        }else{
            $sql = 'SELECT productos.id_producto, productos.cover, mangas.titulo, 
            productos.volumen, productos.cantidad,
            productos.precio
            from productos
            INNER JOIN mangas ON productos.id_manga = mangas.id_manga ORDER BY
             ';
        };
        //revisa los demas parametros
        if($filtros['unidades'] == '1')
        {
            $sql = $sql.' productos.cantidad DESC ';

            
        }else if($filtros['unidades'] == '2'){
            $sql = $sql.' productos.cantidad ASC';
        };

        if($filtros['unidades'] == "No filtrar")
        {
            if($filtros['volumen'] == '1' ){
                $sql = $sql.' productos.volumen ASC';
            }else{
                $sql = $sql.' productos.volumen DESC';
            };

        }

        $sql = $sql.', mangas.titulo ASC';
        return Database::getRows($sql);
    }

    //REGISTROs
    public function ObtenerRegistros()
    {
        $sql = 'SELECT mangas.titulo, productos.volumen, productos_registros.cantidad,
        productos_registros.fecha, usuarios_administradores.usuario 
        from productos_registros 
        INNER JOIN productos ON 
        productos_registros.id_producto=productos.id_producto
        INNER JOIN mangas ON 
        productos.id_manga=mangas.id_manga
        INNER JOIN usuarios_administradores ON 
        productos_registros.id_usuario_administrador=
        usuarios_administradores.id_usuario_administrador
        ORDER BY productos_registros.fecha DESC
        ';
        return Database::getRows($sql);
    }

    //registros prametrizados
    public function obtenerRegistrosFecha($fecha1, $fecha2)
    {
        $sql = "SELECT mangas.titulo, productos.volumen, productos_registros.cantidad,
        productos_registros.fecha, usuarios_administradores.usuario 
        from productos_registros 
        INNER JOIN productos ON 
        productos_registros.id_producto=productos.id_producto
        INNER JOIN mangas ON 
        productos.id_manga=mangas.id_manga
        INNER JOIN usuarios_administradores ON 
        productos_registros.id_usuario_administrador=
        usuarios_administradores.id_usuario_administrador
        where productos_registros.fecha BETWEEN ? and ?
        ORDER BY productos_registros.fecha DESC
        ";
        /*$sql = "SELECT mangas.titulo, productos.volumen, productos_registros.cantidad,
        productos_registros.fecha, usuarios_administradores.usuario 
        from productos_registros 
        INNER JOIN productos ON 
        productos_registros.id_producto=productos.id_producto
        INNER JOIN mangas ON 
        productos.id_manga=mangas.id_manga
        INNER JOIN usuarios_administradores ON 
        productos_registros.id_usuario_administrador=
        usuarios_administradores.id_usuario_administrador
        where productos_registros.fecha BETWEEN ."."'".$fecha1."'"." and "."'".$fecha2."'"." 
        ORDER BY productos_registros.fecha DESC
        ";*/
        $params = array($fecha1, $fecha2);
        return Database::getRows($sql, $params);
    }


    public function InsertarRegistro($mod, $user)
    {
            $t=time();
            $fecha = date("Y-m-d",$t);

        $sql = 'INSERT INTO productos_registros(
            id_producto, cantidad, fecha, id_usuario_administrador)
            VALUES (?, ?, ?, ?)';
        $params = array($this->id, $mod, $fecha, $user);
        return Database::executeRow($sql, $params);
    }

    public function ObtenerPedidos()
    {
        $sql = 'SELECT facturas.id_factura, clientes.nombre ,clientes.apellido, facturas.id_estado_factura, facturas.fecha  from facturas 
        INNER JOIN clientes ON facturas.id_cliente = clientes.id_cliente
        ORDER BY facturas.fecha desc';
        return Database::getRows($sql);
    }

    public function BuscarPedidos($value, $fecha1, $fecha2)
    {
        $params = array();
        $sql = 'SELECT facturas.id_factura, clientes.nombre ,clientes.apellido, facturas.id_estado_factura, facturas.fecha  from facturas 
        INNER JOIN clientes ON facturas.id_cliente = clientes.id_cliente WHERE ';
        $first = false;
        if($value != null){
            $sql = $sql.'clientes.nombre LIKE ? or clientes.apellido LIKE ? ';
            array_push($params, "%$value%", "%$value%");
        };
        if($fecha1 != null && $fecha2 != null){
            if($first == true){
                $sql = $sql.'and ';
            }
            $sql = $sql.'facturas.fecha BETWEEN ? and ? ';
            array_push($params, $fecha1, $fecha2);
        }
        $sql = $sql. 'ORDER BY facturas.fecha desc';
        return Database::getRows($sql, $params);
    }

    public function ObtenerPedidosFecha()
    {
        $sql = 'SELECT facturas.id_factura, clientes.nombre ,clientes.apellido, facturas.id_estado_factura, facturas.fecha  from facturas 
        INNER JOIN clientes ON facturas.id_cliente = clientes.id_cliente
        ORDER BY facturas.fecha desc';
        return Database::getRows($sql);
    }

    

    public function ObtenerEstadosFacturas()
    {
        $sql = 'SELECT id_estado, estado from estados_facturas';
        return Database::getRows($sql);
    }

    public function ActualizarEstado($estado)
    {
        $sql = 'UPDATE facturas
        SET id_estado_factura=?
        WHERE id_factura = ?';
        $params = array($estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function ObtenerValoraciones()
    {
        $sql = 'SELECT valoraciones.id_valoracion, detalles_facturas.id_detalle_factura, productos.cover, mangas.titulo, productos.volumen, clientes.nombre, clientes.apellido, valoraciones.valoracion, valoraciones.comentario, valoraciones.estado
        FROM detalles_facturas
        INNER JOIN productos
        ON detalles_facturas.id_producto = productos.id_producto
        INNER JOIN mangas
        ON productos.id_manga = mangas.id_manga
        INNER JOIN facturas
        ON detalles_facturas.id_factura = facturas.id_factura
        INNER JOIN clientes
        ON facturas.id_cliente = clientes.id_cliente
        INNER JOIN valoraciones
        ON detalles_facturas.id_detalle_factura = valoraciones.id_detalle_factura
        where productos.id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function ActualizarEst($estado)
    {
        $sql = 'UPDATE valoraciones
                SET estado=?
                WHERE id_valoracion=?';
        $params = array($estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function ObtenerDetalle()
    {
        $sql = "SELECT facturas.id_factura, estados_facturas.estado, CONCAT(mangas.titulo, ' V', productos.volumen) as producto,
        CONCAT(clientes.nombre,' ', clientes.apellido) as nombre, 
        detalles_facturas.cantidad, productos.precio, 
                detalles_facturas.cantidad*productos.precio as sub_total
                from detalles_facturas
                INNER JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
                INNER JOIN productos ON productos.id_producto = detalles_facturas.id_producto
                INNER JOIN mangas ON mangas.id_manga = productos.id_manga
                INNER JOIN clientes ON clientes.id_cliente = facturas.id_cliente
				INNER JOIN estados_facturas ON facturas.id_estado_factura = estados_facturas.id_estado
                where detalles_facturas.id_factura = ?";
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }



    public function CargarProductoPorManga()
    {
        $sql = 'SELECT productos.id_producto, cover, mangas.titulo, volumen, precio, ROUND(AVG(valoraciones.valoracion), 2) as promedio
        FROM productos
        INNER JOIN mangas
        ON productos.id_manga = mangas.id_manga
        LEFT JOIN detalles_facturas ON productos.id_producto = detalles_facturas.id_producto
        LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
        WHERE mangas.id_manga = ?
        GROUP BY productos.id_producto, mangas.titulo';
        $params = array($this->manga);
        return Database::getRows($sql, $params);
    }

    public function ProductoMasVendido()
    {
        $sql = "SELECT mangas.titulo, COUNT(detalles_facturas.id_producto) as cuenta from detalles_facturas INNER JOIN productos USING(id_producto) INNER JOIN mangas USING (id_manga)
                GROUP BY mangas.titulo, productos.volumen
                ORDER BY cuenta DESC
                LIMIT 5";
        return Database::getRows($sql);
    }

    public function GeneroMasVendido()
    {
        $sql = "SELECT COUNT(productos.id_producto) AS cuenta, generos.genero FROM productos 
                INNER JOIN mangas USING (id_manga) 
                INNER JOIN generos_mangas USING (id_manga) 
                INNER JOIN generos USING (id_genero)
                WHERE generos_mangas.id_genero = generos_mangas.id_genero
                GROUP BY generos.genero
                ORDER BY cuenta DESC
                LIMIT 5";
        return Database::getRows($sql);
    }
    public function graficoProductos()
    {
        $sql = 'SELECT id_manga, cantidad
        FROM productos
        INNER JOIN mangas USING(id_manga)
        ORDER BY cantidad';
        return Database::getRows($sql);
    }

}
