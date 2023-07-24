<?php
require_once('../../helpers/database.php');

class mangas_quearies
{


    //operaciones sql
    //agregar un genero para los mangas
    public function InsertarGenero()
    {
        $sql = 'INSERT into generos_mangas (id_genero, id_manga) values
            (?, ?)';
        $params = array($this->idGen, $this->idMan);
        return Database::executeRow($sql, $params);
    }


    //Filtro de busqueda
    public function FiltrarManga($filtros)
    {
        $sql = null;
        $first = false;
        //verificar si se estan filtrando los generos
        if ($filtros['genero'] != 'Géneros') {
            $sql = 'SELECT mangas.id_manga, mangas.portada, mangas.titulo, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
            FROM mangas
            LEFT JOIN productos ON productos.id_manga = mangas.id_manga
            LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
            LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
            INNER JOIN generos_mangas ON mangas.id_manga=generos_mangas.id_manga
            INNER JOIN generos ON generos.id_genero=generos_mangas.id_genero
            where generos_mangas.id_genero =' . $filtros['genero'];
            $first = true;
            //si no es el caso se manda a llamar una consulta mas simple
        } else {
            $sql = 'SELECT mangas.id_manga, mangas.portada, mangas.titulo, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
            FROM mangas
            LEFT JOIN productos ON productos.id_manga = mangas.id_manga
            LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
            LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
            where ';
        };
        //revisa los demas parametros
        if ($filtros['autor'] != 'Autores') {
            if ($first == false) {
                $sql = $sql . ' id_autor = ' . $filtros['autor'];
                $first = true;
            } else {
                $sql = $sql . ' AND id_autor = ' . $filtros['autor'];
            }
        };
        if ($filtros['demografia'] != 'Demografías') {
            if ($first == false) {
                $sql = $sql . 'id_demografia = ' . $filtros['demografia'];
                $first = true;
            } else {
                $sql = $sql . ' AND id_demografia = ' . $filtros['demografia'];
            }
        };
        if ($filtros['revista'] != 'Revistas') {

            if ($first == false) {
                $sql = $sql . ' id_revista = ' . $filtros['revista'];
                $first = true;
            } else {
                $sql = $sql . ' AND id_revista = ' . $filtros['revista'];
            }
        };

        if ($filtros['search'] != null) {
            if ($first == false) {
                $sql = $sql . ' titulo LIKE ' . "'%" . $filtros['search'] . "%'";
                $first = true;
            } else {
                $sql = $sql . ' AND titulo LIKE ' . "'%" . $filtros['search'] . "%'";
            }
        };
        $sql = $sql . ' GROUP BY mangas.id_manga, mangas.portada, mangas.titulo
        ORDER BY mangas.titulo ASC';
        return Database::getRows($sql);
    }

    //insertar mangas en la base 
    public function InsertarManga()
    {
        $sql = 'INSERT INTO mangas(
            titulo, portada, descripcion, id_demografia, anio, volumenes, id_revista, id_autor, id_estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array(
            $this->titulo, $this->portada, $this->descripcion, $this->demografia, $this->anio,
            $this->volumenes, $this->revista, $this->autor, $this->estado
        );
        return Database::executeRow($sql, $params);
    }

    //buscar un mango especifico obteniendo el id mediando el titulo como parametro
    public function BuscarMangaId()
    {
        $sql = 'SELECT id_manga FROM mangas WHERE titulo = ?';
        $params = array($this->titulo);
        return Database::getRow($sql, $params);
    }

    //operacion para buscar el id_genero
    public function BuscarGeneroId()
    {
        $sql = 'SELECT id_genero FROM generos WHERE genero = ?';
        $params = array($this->genero);
        return Database::getRow($sql, $params);
    }

    //Cargar un solo manga mediante el id
    public function CargarMangaPorId()
    {
        $sql = 'SELECT id_manga, titulo, portada, descripcion, id_demografia, anio, volumenes, 
        id_revista, id_autor, id_estado
        FROM mangas where id_manga = ?';
        $params = array($this->idMan);
        return Database::getRow($sql, $params);
    }

    //Cargar un solo manga mediante el parametro de titulo
    public function CargarMangaObtId()
    {
        $sql = 'SELECT id_manga, titulo, portada, descripcion, id_demografia, anio, volumenes, 
        id_revista, id_autor, id_estado
        FROM mangas where titulo = ?';
        $params = array($this->titulo);
        return Database::getRow($sql, $params);
    }

    //Cargar los mangas en general
    public function CargarMangas()
    {
        $sql = "SELECT mangas.id_manga, mangas.titulo, mangas.volumenes, mangas.portada, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
        FROM mangas
        LEFT JOIN productos ON productos.id_manga = mangas.id_manga
        LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
        LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
        GROUP BY mangas.id_manga, mangas.portada, mangas.titulo
        ORDER BY mangas.titulo ASC";
        return Database::getRows($sql);
    }

    //Cargar los mangas en general - Reportes
    public function CargarMangasReport()
    {
        $sql = "SELECT mangas.id_manga, mangas.titulo, mangas.volumenes, mangas.portada, ROUND(AVG(valoraciones.valoracion), 2) AS promedio
            FROM mangas
            LEFT JOIN productos ON productos.id_manga = mangas.id_manga
            LEFT JOIN detalles_facturas ON detalles_facturas.id_producto = productos.id_producto
            LEFT JOIN valoraciones ON valoraciones.id_detalle_factura = detalles_facturas.id_detalle_factura
            GROUP BY mangas.id_manga, mangas.portada, mangas.titulo
            ORDER BY mangas.titulo ASC";
        return Database::getRows($sql);
    }

    //Cargar los genereros en base a su id_manga
    public function CargarGenerosMangas()
    {
        $sql = 'SELECT generos_mangas.id_detalle, generos.genero, generos_mangas.id_manga FROM generos_mangas
        INNER JOIN generos
        ON generos.id_genero = generos_mangas.id_genero
        WHERE
        generos_mangas.id_manga = ?';
        $params = array($this->idMan);
        return Database::getRows($sql, $params);
    }
    //eliminar un genero de un manga
    public function EliminarGenerosMangas()
    {
        $sql = 'DELETE from generos_mangas where id_detalle = ?';
        $params = array($this->idDetalle);
        return Database::executeRow($sql, $params);
    }

    //eliminar un manga entero
    public function EliminarManga()
    {
        $sql = 'DELETE from mangas where id_manga = ?';
        $params = array($this->idMan);
        return Database::executeRow($sql, $params);
    }

    //actualizar un manga
    public function ActualizarManga($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->portada) ? Validator::deleteFile($this->getruta(), $current_image) : $this->portada = $current_image;

        $sql = 'UPDATE mangas
        SET titulo=?, portada=?, descripcion=?, id_demografia=?, anio=?, volumenes=?,
         id_revista=?, id_autor=?, id_estado=?
        WHERE id_manga = ?';
        $params = array(
            $this->titulo, $this->portada, $this->descripcion, $this->demografia, $this->anio, $this->volumenes,
            $this->revista, $this->autor, $this->estado, $this->idMan
        );
        return Database::executeRow($sql, $params);
    }

    // Cargar modal catalogo .
    public function CargarCatalogoObtId()
    {
        $sql = 'SELECT id_manga, titulo, portada, descripcion, demografias.demografia, anio, volumenes, revistas.revista, autores.autor, estados_mangas.estado
        FROM mangas
        INNER JOIN demografias
        ON mangas.id_demografia = demografias.id_demografia
        INNER JOIN revistas
        ON mangas.id_revista = revistas.id_revista
        INNER JOIN autores
        ON mangas.id_autor = autores.id_autor
        INNER JOIN estados_mangas
        ON mangas.id_estado = estados_mangas.id_estado
        where titulo = ?';
        $params = array($this->titulo);
        return Database::getRow($sql, $params);
    }

    //verficar que haya una factura valida en el carrito
    public function VerificarFactura()
    {
        $sql = 'SELECT usuarios_clientes.usuario, facturas.id_factura, facturas.id_estado_factura from facturas
        INNER JOIN clientes on clientes.id_cliente = facturas.id_cliente
        INNER JOIN usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
        where usuario = ? and id_estado_factura = 1';
        $params = array($this->usuario);
        return Database::getRow($sql, $params);
    }
    //crear una factura para el carrito
    public function AgregarFactura()
    {
        $sql = "INSERT INTO facturas(id_cliente, id_estado_factura)
            VALUES ((select id_cliente from usuarios_clientes where usuario = ?), 1)";
        $params = array($this->usuario);
        return Database::executeRow($sql, $params);
    }

    //inserta un detalle en el la puerta lo hizo
    public function AgregarDetalle($producto, $cantidad)
    {
        $sql = "INSERT INTO detalles_facturas(
            id_producto, cantidad, id_factura)
            VALUES (?, ?, (SELECT facturas.id_factura from facturas
        LEFT JOIN  clientes ON clientes.id_cliente = facturas.id_cliente
        LEFT JOIN  usuarios_clientes ON usuarios_clientes.id_cliente = clientes.id_cliente
        where usuarios_clientes.usuario = ? and facturas.id_estado_factura = 1))";
        $params = array($producto, $cantidad, $this->usuario);
        return Database::executeRow($sql, $params);
    }
    //restar los productos que se ponen al carrito
    public function RestarProductos($producto, $cantidad)
    {
        $sql = 'UPDATE productos set cantidad = (cantidad-?)where id_producto = ?';
        $params = array($cantidad, $producto);
        return Database::executeRow($sql, $params);
    }
    //suma los productos que se elimienen del carrito
    public function RestablecerProductos($producto, $cantidad)
    {
        $sql = 'UPDATE productos set cantidad = (cantidad+?)where id_producto = ?';
        $params = array($cantidad, $id_producto);
        return Database::executeRow($sql, $params);
    }

    //Carga las valoraciones segun un id_producto
    public function CargarValoracionesProducto($producto)
    {
        $sql = "SELECT valoraciones.valoracion, valoraciones.comentario from valoraciones
        INNER JOIN detalles_facturas ON detalles_facturas.id_detalle_factura = valoraciones.id_detalle_factura
        where detalles_facturas.id_producto = ? and estado = true";
        $params = array($producto);
        return Database::getRows($sql, $params);
    }
}
