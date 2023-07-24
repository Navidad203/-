<?php
require_once("../../helpers/database.php");


class Pedidos_Queries{
    /*
    **funciones para manejar el historial de pedidos**
    */

    //función para obtener las facturas de un usuario (id, fecha y usuario) parametro: usuario y estado
    //factura = 1 siendo 1 = factura en progreso
    public function ObtenerFacturas()
    {
        $sql = "SELECT SUM(sub_total) as total, id_factura, fecha  
        from (select facturas.id_factura, facturas.fecha, detalles_facturas.cantidad*productos.precio as sub_total
        from detalles_facturas
        INNER JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
        INNER JOIN productos ON productos.id_producto = detalles_facturas.id_producto
        INNER JOIN mangas ON mangas.id_manga = productos.id_manga
        INNER JOIN clientes ON clientes.id_cliente = facturas.id_cliente
        INNER JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
        where usuarios_clientes.usuario = ? and facturas.id_estado_factura != 1) 
		as consulta group by id_factura, fecha order by fecha desc";
        $params = array($this->usuario);
        return Database::getRows($sql, $params);
    }

    //función para obtener los detalles de una factura()
    public function ObtenerDetalleFactura()
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
        $params = array($this->id_factura);
        return Database::getRows($sql, $params);
    }

    /*
    **funciones para manejar la funcionalidad del carrito**
    */
    //obtener los detalles de una factura en progreso. Parametros: nombre del usuario, estado factura
    public function ObtenerDetalleFacturaCarrito()
    {
        $sql = "SELECT facturas.id_factura, detalles_facturas.id_detalle_factura, productos.cover, productos.id_producto, CONCAT(mangas.titulo, ' V', productos.volumen) as producto,
        CONCAT(clientes.nombre,' ', clientes.apellido) as nombre, 
        detalles_facturas.cantidad, productos.precio, 
                detalles_facturas.cantidad*productos.precio as sub_total
                from detalles_facturas
                INNER JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
                INNER JOIN productos ON productos.id_producto = detalles_facturas.id_producto
                INNER JOIN mangas ON mangas.id_manga = productos.id_manga
                INNER JOIN clientes ON clientes.id_cliente = facturas.id_cliente
				INNER JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
                where usuarios_clientes.usuario = ? and facturas.id_estado_factura = 1";
        $params = array($this->usuario);
        return Database::getRows($sql, $params);
    }

    //eliminar un elemento de el carrito. Parametros: id_detalle_factura
    public function EliminarElementoCarrito()
    {
        $sql = "DELETE from detalles_facturas where id_detalle_factura = ?";
        $params = array($this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    //Pagar una factura en progreso y actualizar el estado a cancelada. Parametros: nombre del usuario, estado factura
    public function CancelarCarrito()
    {
        $t=time();
        $fecha = date("Y-m-d",$t);

        $sql = 'UPDATE facturas set id_estado_factura = 2, fecha = ? where id_factura = ?';
        $params = array($fecha, $this->id_factura);
        return Database::executeRow($sql, $params);
    }

    //Restar los productos cancelados del inventario
    public function RestablecerProductos($cantidad, $id_producto)
    {
        $sql = 'UPDATE productos set cantidad = (cantidad+?)where id_producto = ?';
        $params = array($cantidad, $id_producto);
        return Database::executeRow($sql, $params);
    }
    
    public function ProductoMasVendido()
    {
        $sql = "SELECT mangas.titulo, productos.volumen, COUNT(detalles_facturas.id_producto) as cuenta from detalles_facturas INNER JOIN productos USING(id_producto) INNER JOIN mangas USING (id_manga)
                GROUP BY mangas.titulo, productos.volumen
                ORDER BY cuenta DESC";
        return Database::getRows($sql);
    }

    public function GeneroMasVendido()
    {
        $sql = "SELECT COUNT(productos.id_producto) as cuenta, generos.genero from productos 
                INNER JOIN mangas USING (id_manga) 
                INNER JOIN generos_mangas USING (id_manga) 
                INNER JOIN generos USING (id_genero)
                WHERE generos_mangas.id_genero = generos_mangas.id_genero
                GROUP BY generos.genero
                ORDER BY cuenta DESC;";
        return Database::getRows($sql);
    }
}
