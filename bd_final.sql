-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2019 a las 23:17:56
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oswa_inv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(16, 'generico'),
(19, 'Jarabes'),
(20, 'OTROS'),
(17, 'Pastillas de marca'),
(18, 'Perfumes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`) VALUES
(6, 'Maria', '923412354', 'maria_ppuente@hotmail.com', 'carabayllo', 0, '2019-06-24 16:35:49'),
(7, 'Mario Namoc', '954706231', 'mario.namoc@gmail.com', 'puente piedra', 0, '2019-06-25 01:52:08'),
(8, 'Dani Colmenares', '999666444', 'dani@gmail.com', 'puente piedra ', 0, '2019-06-25 15:01:42'),
(9, 'juan relicario', '987578465', 'juan@outlook.com', 'Los Olivos', 0, '2019-06-25 15:23:08'),
(10, 'pollo', '23432423', 'polloqq@dfsdf.com', 'ficus city', 0, '2019-06-28 22:32:26'),
(11, 'segundo espinoza', '987654345', 'segundo@hotmail.com', 'puente piedra', 0, '2019-06-30 14:56:27'),
(14, 'eventual', '', ' ', ' ', 0, '2019-08-29 20:15:20'),
(13, 'omar', '989789765', 'omar@hotmail.com', 'puente piedra', 0, '2019-08-02 19:07:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` varchar(20) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(193, 9, 72, '0F5', 7.5),
(191, 7, 72, '0F50', 8),
(192, 8, 72, '1F0', 100),
(189, 5, 72, '1F0', 100),
(190, 6, 91, '1F0', 110),
(194, 10, 72, '1F20', 130),
(195, 11, 98, '0F1', 45),
(196, 12, 72, '0F15', 22.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` varchar(30) NOT NULL,
  `total_venta` varchar(20) NOT NULL,
  `estado_factura` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `total_venta`, `estado_factura`) VALUES
(181, 12, '2019-09-29 16:03:09', 0, 1, '1', '22.50', 1),
(180, 11, '2019-09-18 11:54:18', 0, 1, '1', '45.00', 1),
(179, 10, '2019-09-17 13:17:41', 0, 1, '1', '130.00', 1),
(176, 7, '2019-09-17 12:15:07', 0, 1, '1', '8.00', 1),
(177, 8, '2019-09-17 12:17:02', 0, 1, '1', '100.00', 1),
(178, 9, '2019-09-17 13:17:17', 0, 1, '1', '7.50', 1),
(174, 5, '2019-09-16 23:19:17', 0, 1, '1', '100.00', 1),
(175, 6, '2019-09-16 23:26:11', 0, 1, '1', '110.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `codigo_producto` varchar(20) NOT NULL,
  `precio_producto` int(11) NOT NULL,
  `status_producto` tinyint(11) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` datetime NOT NULL,
  `prov` varchar(30) NOT NULL,
  `compuesto_prod` varchar(50) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `visto` varchar(2) NOT NULL,
  `cantidad_blister` int(10) NOT NULL,
  `precio_blister` varchar(50) NOT NULL,
  `cantidad_unidad` int(5) NOT NULL,
  `precio_unidad` varchar(50) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `laboratorio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `codigo_producto`, `precio_producto`, `status_producto`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `date`, `prov`, `compuesto_prod`, `id_sucursal`, `visto`, `cantidad_blister`, `precio_blister`, `cantidad_unidad`, `precio_unidad`, `fecha_caducidad`, `laboratorio`) VALUES
(72, 'naproxeno 500mg X100 unid', 'P01', 0, 0, '1F5', '50.00', '100.00', 16, 0, '2019-09-14 01:20:15', 'farmacos SAC', 'naproxeno 500mg', 5, 'no', 4, '4', 25, '1.5', '2020-06-27', 'bago'),
(91, 'bactrim forte x100', 'P02', 0, 0, '2F48', '100.00', '110.00', 17, 0, '2019-09-16 00:30:48', 'farmacos SAC', 'Prednisona 500mg', 5, 'no', 5, '22', 10, '2.2', '2020-03-06', 'bago'),
(92, 'prueba de generico', 'P03', 0, 0, '1F22', '50.00', '100.00', 16, 0, '2019-09-17 23:57:46', 'farmacos SAC', 'generical', 4, 'no', 4, '20', 10, '2', '2020-04-24', 'gene'),
(95, 'de marca prueba', 'P04', 0, 0, '0F22', '20.00', '22.40', 17, 0, '2019-09-18 00:11:35', 'farmacos SAC', 'marquel', 4, 'no', 4, '5.6', 8, '0.7', '2020-04-09', 'marc'),
(98, 'Nitro 250ml ', 'P05', 0, 0, '0F14', '20.00', '45.00', 18, 0, '2019-09-18 11:51:26', 'farmacos SAC', ' ', 4, 'no', 1000, '2000', 1000, '45', '2090-12-25', ' '),
(106, 'prueba de generico', 'P093', 0, 0, '0F12', '50.00', '100.00', 16, 0, '2019-09-17 23:57:46', 'farmacos SAC', 'generical', 5, 'no', 4, '20', 10, '2', '2020-04-24', 'gene'),
(107, 'de marca prueba', 'P096', 0, 0, '0F10', '20.00', '22.40', 17, 0, '2019-09-18 00:11:35', 'farmacos SAC', 'marquel', 5, 'no', 4, '5.6', 8, '0.7', '2020-04-09', 'marc'),
(108, 'Nitro 250ml ', 'P099', 0, 0, '0F4', '20.00', '45.00', 18, 0, '2019-09-18 11:51:26', 'farmacos SAC', ' ', 5, 'no', 1000, '2000', 1000, '45', '2090-12-25', ' '),
(109, 'naproxeno 500mg X100 unid', 'P073', 0, 0, '0F4', '50.00', '100.00', 16, 0, '2019-09-14 01:20:15', 'farmacos SAC', 'naproxeno 500mg', 4, 'no', 4, '4', 25, '1.5', '2020-06-27', 'bago'),
(110, 'OTRO DE PRUEBA', 'P010', 0, 0, '0F14', '10.00', '20.00', 20, 0, '2019-09-28 12:50:12', 'farmacos SAC', ' ', 4, 'no', 1000, '2000', 1000, '20', '2090-12-25', ' '),
(111, 'Nitro 250ml ', 'P099', 0, 0, '0F10', '20.00', '45.00', 18, 0, '2019-09-18 11:51:26', 'farmacos SAC', ' ', 5, 'no', 1000, '2000', 1000, '45', '2090-12-25', ' ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_prov` int(10) UNSIGNED NOT NULL,
  `nom_empresa` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `telef_prov` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `nom_contacto` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_producto` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_prov`, `nom_empresa`, `telef_prov`, `nom_contacto`, `tipo_producto`, `date`) VALUES
(18, 'farmacos SAC', '987654321', 'Dr Mendez', 'Pastillass', '2019-09-02 19:42:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` varchar(20) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  `nom_cliente` varchar(50) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`, `nom_cliente`, `id_vendedor`, `id_sucursal`) VALUES
(138, 72, '0F50', '8.00', '2019-09-17', '', 3, 5),
(139, 72, '1F0', '100.00', '2019-09-17', '', 1, 5),
(140, 72, '0F5', '7.50', '2019-09-17', '', 1, 5),
(141, 72, '1F20', '130.00', '2019-09-17', '', 1, 5),
(142, 98, '0F1', '45.00', '2019-09-18', '', 1, 4),
(143, 72, '0F15', '22.50', '2019-09-29', '', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(10) NOT NULL,
  `direccion_sucursal` varchar(50) NOT NULL,
  `nombre_sucursal` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `direccion_sucursal`, `nombre_sucursal`) VALUES
(4, 'santa luisa cerca a primera de pro', 'segundo local'),
(5, 'puente piedra lecaros 182', 'primer local'),
(6, 'Puente piedra lima peru', 'ambos'),
(7, 'primera de pro lima- los olivos- lima- peru ', 'ultimo local ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp`
--

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_tmp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `precio_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_envio`
--

CREATE TABLE `tmp_envio` (
  `id_tmp_envio` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_producto` varchar(20) NOT NULL,
  `session_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`, `id_sucursal`) VALUES
(1, 'Administrador', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'qtuqzoym1.jpeg', 1, '2019-10-03 16:16:13', 6),
(2, 'Special User', 'Special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.jpg', 1, '2019-07-23 00:54:30', 0),
(3, 'Default User', 'User', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.jpg', 1, '2019-09-17 12:18:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Special', 2, 1),
(3, 'User', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `codigo_producto` (`nombre_cliente`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `numero_cotizacion` (`numero_factura`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `prov` (`prov`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_prov`),
  ADD UNIQUE KEY `nom_empresa` (`nom_empresa`),
  ADD UNIQUE KEY `id_prov` (`id_prov`),
  ADD KEY `nom_empresa_2` (`nom_empresa`),
  ADD KEY `nom_empresa_3` (`nom_empresa`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp`
--
ALTER TABLE `tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `tmp_envio`
--
ALTER TABLE `tmp_envio`
  ADD PRIMARY KEY (`id_tmp_envio`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_prov` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tmp`
--
ALTER TABLE `tmp`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;

--
-- AUTO_INCREMENT de la tabla `tmp_envio`
--
ALTER TABLE `tmp_envio`
  MODIFY `id_tmp_envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
