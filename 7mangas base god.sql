-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2023 a las 19:48:37
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `7mangas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `autor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_autor`, `autor`) VALUES
(14, 'Aka Akasaka'),
(7, 'Akira Toriyama'),
(12, 'Bizen, Yasunori'),
(2, 'Eiichirō Oda'),
(13, 'Fujimoto Tatsuki'),
(9, 'Gege Akutami'),
(8, 'Hajime Isayama'),
(10, 'Koyoharu Gotouge'),
(5, 'Nanashi'),
(3, 'Tomohito Oda'),
(6, 'Tsugumi Ohba'),
(11, 'Tumama Tanga'),
(4, 'Yūki Tabata');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `pfp` varchar(50) DEFAULT NULL,
  `nombre` varchar(35) NOT NULL,
  `apellido` varchar(35) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demografias`
--

CREATE TABLE `demografias` (
  `id_demografia` int(11) NOT NULL,
  `demografia` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `demografias`
--

INSERT INTO `demografias` (`id_demografia`, `demografia`) VALUES
(2, 'Kodomo'),
(3, 'Seinen'),
(4, 'Shōjo'),
(1, 'Shonen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_facturas`
--

CREATE TABLE `detalles_facturas` (
  `id_detalle_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_facturas`
--

CREATE TABLE `estados_facturas` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_facturas`
--

INSERT INTO `estados_facturas` (`id_estado`, `estado`) VALUES
(1, 'En progreso'),
(2, 'cancelada'),
(3, 'suspendida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_mangas`
--

CREATE TABLE `estados_mangas` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_mangas`
--

INSERT INTO `estados_mangas` (`id_estado`, `estado`) VALUES
(1, 'Finalizado'),
(2, 'En Publicación'),
(3, 'Pausado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_usuarios`
--

CREATE TABLE `estados_usuarios` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_usuarios`
--

INSERT INTO `estados_usuarios` (`id_estado`, `estado`) VALUES
(1, 'En linea'),
(2, 'Bloqueado'),
(3, 'Desconectado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_estado_factura` int(11) NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id_genero` int(11) NOT NULL,
  `genero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id_genero`, `genero`) VALUES
(1, 'Acción'),
(2, 'Aventura'),
(6, 'Drama'),
(14, 'espacial'),
(20, 'Fantasia'),
(18, 'Gore'),
(8, 'Policial'),
(4, 'Romance'),
(3, 'Sci. Ficción'),
(5, 'Slice of life'),
(19, 'Supernatural'),
(11, 'suspenso'),
(10, 'terror'),
(7, 'Vida escolar'),
(9, 'yuri');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos_mangas`
--

CREATE TABLE `generos_mangas` (
  `id_detalle` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `generos_mangas`
--

INSERT INTO `generos_mangas` (`id_detalle`, `id_genero`, `id_manga`) VALUES
(38, 2, 14),
(39, 1, 14),
(45, 6, 20),
(46, 1, 20),
(47, 5, 20),
(48, 8, 20),
(58, 2, 24),
(60, 3, 24),
(61, 8, 24),
(62, 18, 24),
(63, 19, 24),
(64, 19, 14),
(65, 1, 25),
(66, 2, 25),
(67, 19, 25),
(68, 20, 25),
(69, 1, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mangas`
--

CREATE TABLE `mangas` (
  `id_manga` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `portada` varchar(50) DEFAULT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_demografia` int(11) NOT NULL,
  `anio` varchar(4) NOT NULL,
  `volumenes` int(11) NOT NULL,
  `id_revista` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mangas`
--

INSERT INTO `mangas` (`id_manga`, `titulo`, `portada`, `descripcion`, `id_demografia`, `anio`, `volumenes`, `id_revista`, `id_autor`, `id_estado`) VALUES
(14, 'Black Clover', '64405cd41a891.jpg', 'In a world full of magic, Asta—an orphan who is overly loud and energetic—possesses none whatsoever. Despite this, he dreams of becoming the Wizard King, a title bestowed upon the strongest mage in the Clover Kingdom. Possessing the same aspiration, Asta\'\'s childhood friend and rival Yuno has been blessed with the ability to control powerful wind magic. Even with this overwhelming gap between them, hoping to somehow awaken his magical abilities and catch up to Yuno, Asta trains his body relentle', 1, '2015', 34, 1, 4, 2),
(20, 'Lycoris Recoil', '64407ad9d57ed.jpg', 'For these peaceful days―there\'\'s a secret behind it all. A secret organization that prevents crimes: \'DA - Direct Attack.\' And their group of all-girl agents: \'Lycoris.\' This peaceful everyday life is all thanks to these young girls. The elite Chisato Nishikigi is the strongest Lycoris agent of all time. Alongside is Takina Inoue, the talented but mysterious Lycoris. They work together at one of its branches―Café LycoReco.\r\n\r\nHere, the orders this café takes range from coffee and sweets to child', 3, '2022', 1, 14, 12, 2),
(24, 'Chain Saw Man', '644304f1d29cf.jpg', 'Denji has a simple dream—to live a happy and peaceful life, spending time with a girl he likes. This is a far cry from reality, however, as Denji is forced by the yakuza into killing devils in order to pay off his crushing debts. Using his pet devil Pochita as a weapon, he is ready to do anything for a bit of cash.\r\n\r\nUnfortunately, he has outlived his usefulness and is murdered by a devil in contract with the yakuza. However, in an unexpected turn of events, Pochita merges with Denji\'\'s dead bo', 1, '2018', 14, 1, 13, 2),
(25, 'One Piece', '6443060ecab86.jpg', 'Gol D. Roger, a man referred to as the \'Pirate King,\' is set to be executed by the World Government. But just before his demise, he confirms the existence of a great treasure, One Piece, located somewhere within the vast ocean known as the Grand Line. Announcing that One Piece can be claimed by anyone worthy enough to reach it, the Pirate King is executed and the Great Age of Pirates begins.\r\n\r\nTwenty-two years later, a young man by the name of Monkey D. Luffy is ready to embark on his own adven', 1, '1997', 105, 2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `cover` varchar(50) DEFAULT NULL,
  `volumen` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_manga`, `cover`, `volumen`, `cantidad`, `precio`) VALUES
(15, 24, '6444a91482bec.jpg', 1, 19, '15.00'),
(16, 24, '6444aad7b6b5d.png', 4, 25, '3.00'),
(18, 14, '6444bd2bbc64d.jpg', 1, 54, '14.00'),
(21, 14, '644535598630f.png', 2, 62, '13.00'),
(31, 14, '644560fdc3628.png', 3, 19, '20.00'),
(32, 20, '6445c99044df6.jpg', 1, 16, '20.00'),
(40, 25, '64460677e87ea.jpg', 1, 1, '20.00'),
(41, 25, '644606ce6138c.jpg', 2, 8, '12.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_registros`
--

CREATE TABLE `productos_registros` (
  `id_registro` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_usuario_administrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos_registros`
--

INSERT INTO `productos_registros` (`id_registro`, `id_producto`, `cantidad`, `fecha`, `id_usuario_administrador`) VALUES
(1, 31, 4, '2023-07-10', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revistas`
--

CREATE TABLE `revistas` (
  `id_revista` int(11) NOT NULL,
  `revista` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `revistas`
--

INSERT INTO `revistas` (`id_revista`, `revista`) VALUES
(15, 'Bessatsu Shounen Magazine'),
(14, 'Comic Flapper'),
(7, 'CoroCoro Comic'),
(5, 'Jump Square'),
(12, 'Miracle Jumps'),
(11, 'MisBolasJump'),
(4, 'Nakayoshi'),
(10, 'Ribon'),
(1, 'Shonen Jump'),
(2, 'Weekly Shōnen Jump'),
(8, 'Weekly Shōnen Magazine'),
(3, 'Weekly Shōnen Sunday'),
(13, 'Young Jump');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_administradores`
--

CREATE TABLE `usuarios_administradores` (
  `id_usuario_administrador` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios_administradores`
--

INSERT INTO `usuarios_administradores` (`id_usuario_administrador`, `usuario`, `contrasenia`, `id_estado`) VALUES
(8, 'inglis', '$2y$10$pR5ewZK9P5H/ZL3ceMJ/5e30lv1pfIvrh.27YAQzXtrn3E5hZoVoG', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_clientes`
--

CREATE TABLE `usuarios_clientes` (
  `id_usuario_cliente` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id_valoracion` int(11) NOT NULL,
  `valoracion` int(11) NOT NULL,
  `comentario` varchar(500) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL,
  `id_detalle_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`),
  ADD UNIQUE KEY `autorUNI` (`autor`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `demografias`
--
ALTER TABLE `demografias`
  ADD PRIMARY KEY (`id_demografia`),
  ADD UNIQUE KEY `demografiaUNI` (`demografia`);

--
-- Indices de la tabla `detalles_facturas`
--
ALTER TABLE `detalles_facturas`
  ADD PRIMARY KEY (`id_detalle_factura`),
  ADD KEY `fk_facturas_detalles_facturas` (`id_factura`),
  ADD KEY `fk_producto_detalles_facturas` (`id_producto`);

--
-- Indices de la tabla `estados_facturas`
--
ALTER TABLE `estados_facturas`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estados_mangas`
--
ALTER TABLE `estados_mangas`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estados_usuarios`
--
ALTER TABLE `estados_usuarios`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `fk_cliente_factura` (`id_cliente`),
  ADD KEY `fk_estado_factura` (`id_estado_factura`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id_genero`),
  ADD UNIQUE KEY `uniqueGender` (`genero`);

--
-- Indices de la tabla `generos_mangas`
--
ALTER TABLE `generos_mangas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_manga_genero` (`id_genero`),
  ADD KEY `fk_genero_manga` (`id_manga`);

--
-- Indices de la tabla `mangas`
--
ALTER TABLE `mangas`
  ADD PRIMARY KEY (`id_manga`),
  ADD KEY `fk_demografia_manga` (`id_demografia`),
  ADD KEY `fk_revista_manga` (`id_revista`),
  ADD KEY `fk_autor_manga` (`id_autor`),
  ADD KEY `fk_estado_manga` (`id_estado`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_manga_productos` (`id_manga`);

--
-- Indices de la tabla `productos_registros`
--
ALTER TABLE `productos_registros`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_product` (`id_producto`),
  ADD KEY `ususarioa` (`id_usuario_administrador`);

--
-- Indices de la tabla `revistas`
--
ALTER TABLE `revistas`
  ADD PRIMARY KEY (`id_revista`),
  ADD UNIQUE KEY `revistaUNI` (`revista`);

--
-- Indices de la tabla `usuarios_administradores`
--
ALTER TABLE `usuarios_administradores`
  ADD PRIMARY KEY (`id_usuario_administrador`),
  ADD UNIQUE KEY `uniquefk` (`usuario`),
  ADD KEY `fk_estado_administrador` (`id_estado`);

--
-- Indices de la tabla `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  ADD PRIMARY KEY (`id_usuario_cliente`),
  ADD UNIQUE KEY `uniquefkclit` (`usuario`),
  ADD KEY `fk_estado_cliente_us` (`id_estado`),
  ADD KEY `fk_cliente_usuario` (`id_cliente`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `valor_detalle` (`id_detalle_factura`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `demografias`
--
ALTER TABLE `demografias`
  MODIFY `id_demografia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalles_facturas`
--
ALTER TABLE `detalles_facturas`
  MODIFY `id_detalle_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `estados_facturas`
--
ALTER TABLE `estados_facturas`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_mangas`
--
ALTER TABLE `estados_mangas`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_usuarios`
--
ALTER TABLE `estados_usuarios`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `generos_mangas`
--
ALTER TABLE `generos_mangas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `mangas`
--
ALTER TABLE `mangas`
  MODIFY `id_manga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `productos_registros`
--
ALTER TABLE `productos_registros`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `revistas`
--
ALTER TABLE `revistas`
  MODIFY `id_revista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios_administradores`
--
ALTER TABLE `usuarios_administradores`
  MODIFY `id_usuario_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  MODIFY `id_usuario_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_facturas`
--
ALTER TABLE `detalles_facturas`
  ADD CONSTRAINT `fk_facturas_detalles_facturas` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_detalles_facturas` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_cliente_factura` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estado_factura` FOREIGN KEY (`id_estado_factura`) REFERENCES `estados_facturas` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `generos_mangas`
--
ALTER TABLE `generos_mangas`
  ADD CONSTRAINT `fk_genero_manga` FOREIGN KEY (`id_manga`) REFERENCES `mangas` (`id_manga`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_manga_genero` FOREIGN KEY (`id_genero`) REFERENCES `generos` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mangas`
--
ALTER TABLE `mangas`
  ADD CONSTRAINT `fk_autor_manga` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id_autor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_demografia_manga` FOREIGN KEY (`id_demografia`) REFERENCES `demografias` (`id_demografia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estado_manga` FOREIGN KEY (`id_estado`) REFERENCES `estados_mangas` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_revista_manga` FOREIGN KEY (`id_revista`) REFERENCES `revistas` (`id_revista`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_manga_productos` FOREIGN KEY (`id_manga`) REFERENCES `mangas` (`id_manga`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_registros`
--
ALTER TABLE `productos_registros`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ususarioa` FOREIGN KEY (`id_usuario_administrador`) REFERENCES `usuarios_administradores` (`id_usuario_administrador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_administradores`
--
ALTER TABLE `usuarios_administradores`
  ADD CONSTRAINT `fk_estado_administrador` FOREIGN KEY (`id_estado`) REFERENCES `estados_usuarios` (`id_estado`);

--
-- Filtros para la tabla `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  ADD CONSTRAINT `fk_cliente_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_estado_cliente_us` FOREIGN KEY (`id_estado`) REFERENCES `estados_usuarios` (`id_estado`);

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valor_detalle` FOREIGN KEY (`id_detalle_factura`) REFERENCES `detalles_facturas` (`id_detalle_factura`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
