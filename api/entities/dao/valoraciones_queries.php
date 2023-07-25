<?php
require_once("../../helpers/database.php");


class Valoraciones_Queries
{
    /*
    **funciones para manejar la interaccion de valoraciones con el usuario**
    */

    //función para obtener los mangas que no ha valorado el usuario
    public function ObtenerNoValoraciones()
    {

        $sql = " SELECT usuarios_clientes.usuario, CONCAT(mangas.titulo, ' V', productos.volumen) AS producto, 
                productos.id_producto, detalles_facturas.id_detalle_factura, productos.cover, valoraciones.id_valoracion, valoraciones.valoracion, promedios.promedio
                FROM mangas
                LEFT JOIN productos ON productos.id_manga = mangas.id_manga
                LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
                LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
                LEFT JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
                LEFT JOIN clientes ON clientes.id_cliente = facturas.id_cliente
                LEFT JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
                LEFT JOIN (
                    SELECT productos.id_producto, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
                    FROM productos
                    LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
                    LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
                    GROUP BY productos.id_producto
                ) AS promedios ON promedios.id_producto = productos.id_producto
                WHERE usuarios_clientes.usuario = ? and facturas.id_estado_factura != 1
                GROUP BY usuarios_clientes.usuario, producto,detalles_facturas.id_detalle_factura, valoraciones.id_valoracion,
                productos.id_producto, valoraciones.valoracion, productos.cover, promedios.promedio
                ORDER BY id_valoracion asc
                ";
        $params = array($this->usuario);
        return Database::getRows($sql, $params);
    }

    //funcion para obtener todos los productos que ya tengan una valoracion
    public function ObtenerValoraciones()
    {

        $sql = "SELECT usuarios_clientes.usuario, mangas.id_manga, CONCAT(mangas.titulo, ' V', productos.volumen) AS producto, 
        productos.id_producto, productos.cover, valoraciones.id_valoracion, valoraciones.valoracion, promedios.promedio
        FROM mangas
        LEFT JOIN productos ON productos.id_manga = mangas.id_manga
        LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
        LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
        LEFT JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
        LEFT JOIN clientes ON clientes.id_cliente = facturas.id_cliente
        LEFT JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
        LEFT JOIN (
            SELECT productos.id_producto, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
            FROM productos
            LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
            LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
            GROUP BY productos.id_producto
        ) AS promedios ON promedios.id_producto = productos.id_producto
        WHERE usuarios_clientes.usuario = ? and facturas.id_estado_factura != 1 AND valoraciones.id_valoracion IS NOT NULL
        GROUP BY usuarios_clientes.usuario, mangas.id_manga, producto, valoraciones.id_valoracion,
        productos.id_producto, valoraciones.valoracion, productos.cover, promedios.promedio";
        $params = array($this->usuario);
        return Database::getRows($sql, $params);
    }

    public function AgregarValoracion()
    {
        $sql = "INSERT INTO valoraciones(
            valoracion, comentario, id_detalle_factura)
            VALUES (?, ?, ?)";
        $params = array($this->valoracion, $this->comentario, $this->id_detalle_factura);
        return Database::executeRow($sql, $params);
    }

    public function ActualizarValoracion()
    {
        $sql = "UPDATE valoraciones SET
        valoracion=?, comentario=? WHERE id_valoracion=?";
        $params = array($this->valoracion, $this->comentario, $this->id_valoracion);
        return Database::executeRow($sql, $params);
    }

    public function ObtenerValoracionId()
    {
        $sql = "SELECT id_valoracion, valoracion, comentario
        FROM valoraciones where id_valoracion = ?";
        $params = array($this->id_valoracion);
        return Database::getRow($sql, $params);
    }
    public function graficaValoraciones()
    {
        $sql = "SELECT  CONCAT(mangas.titulo, ' V', productos.volumen) AS producto, 
        valoraciones.valoracion
               FROM mangas
               LEFT JOIN productos ON productos.id_manga = mangas.id_manga
               LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
               LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
               LEFT JOIN facturas ON facturas.id_factura = detalles_facturas.id_factura
               LEFT JOIN clientes ON clientes.id_cliente = facturas.id_cliente
               LEFT JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
               LEFT JOIN (
                   SELECT productos.id_producto, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
                   FROM productos
                   LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
                   LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
                   GROUP BY productos.id_producto
               ) AS promedios ON promedios.id_producto = productos.id_producto
               GROUP BY usuarios_clientes.usuario, mangas.id_manga, producto, valoraciones.id_valoracion,
               productos.id_producto, valoraciones.valoracion, productos.cover, promedios.promedio DESC
               LIMIT 5";
        $params = array($this->usuario);
        return Database::getRows($sql, $params);
    }

}
