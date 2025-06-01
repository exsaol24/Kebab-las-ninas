-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 01-06-2025 a las 18:19:09
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE USER 'symfony_user'@'localhost' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON `kebablasninas`.* TO 'symfony_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

--
-- Base de datos: `kebablasninas`
--
CREATE DATABASE kebablasninas;
use kebablasninas;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creadoen` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `creadoen`) VALUES
(1, 'Entradas', '2025-05-05 19:17:26'),
(2, 'Kebabs', '2025-05-05 19:17:26'),
(3, 'Hamburguesas', '2025-05-05 19:17:26'),
(4, 'Bebidas', '2025-05-05 19:17:26'),
(5, 'Postres', '2025-05-05 19:17:26'),
(6, 'Falafel', '2025-05-05 19:30:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallespedidos`
--

CREATE TABLE `detallespedidos` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `platos_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `preciounitario` double NOT NULL,
  `personalizacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detallespedidos`
--

INSERT INTO `detallespedidos` (`id`, `pedido_id`, `platos_id`, `cantidad`, `preciounitario`, `personalizacion`) VALUES
(5, 4, 6, 1, 7, '[]'),
(6, 4, 11, 1, 9, '[]'),
(7, 5, 1, 2, 8.5, '[]'),
(8, 8, 1, 1, 8.5, '[]'),
(9, 9, 1, 1, 8.5, '[]'),
(10, 10, 1, 1, 8.5, '[]'),
(11, 10, 2, 1, 8.5, '[]'),
(12, 11, 1, 1, 8.5, '[]'),
(13, 11, 2, 1, 8.5, '[]'),
(14, 12, 1, 1, 8.5, '[]'),
(15, 13, 1, 1, 8.5, '[]'),
(16, 14, 1, 1, 8.5, '[]'),
(17, 15, 1, 1, 8.5, '[]'),
(18, 16, 2, 1, 8.5, '{\"salsa_yogurt\":\"1\",\"maiz\":\"1\",\"lombarda\":\"1\"}'),
(19, 16, 3, 1, 8.5, '{\"lombarda\":\"1\"}'),
(20, 16, 19, 1, 8.5, '[]'),
(21, 17, 3, 1, 8.5, '[]'),
(22, 18, 7, 1, 7.5, '[]'),
(23, 19, 3, 1, 8.5, '[]'),
(24, 20, 7, 1, 7.5, '[]'),
(25, 20, 5, 1, 8, '[]'),
(26, 21, 2, 5, 8.5, '[]'),
(28, 23, 2, 1, 8.5, '[]'),
(30, 25, 2, 1, 8.5, '[]'),
(31, 26, 2, 1, 8.5, '[]'),
(32, 27, 2, 1, 8.5, '[]'),
(33, 28, 2, 1, 8.5, '{\"cebolla\":\"1\",\"salsa_yogurt\":\"1\",\"tomate\":\"1\",\"maiz\":\"1\",\"lombarda\":\"1\"}'),
(34, 29, 2, 1, 8.5, 'Tomate, Maíz, Lombarda, Salsa picante'),
(35, 30, 2, 1, 8.5, 'Salsa yogurt, Tomate, Maíz, Queso feta'),
(36, 31, 1, 1, 8.5, 'Queso feta, Lombarda, Salsa picante'),
(37, 32, 3, 1, 8.5, 'Tomate, Queso feta'),
(38, 33, 2, 1, 8.5, 'Cebolla, Salsa yogurt, Lechuga, Tomate, Maíz, Queso feta, Lombarda, Salsa picante'),
(39, 34, 2, 1, 8.5, 'Lechuga, Queso feta, Salsa picante'),
(40, 35, 26, 1, 2.5, 'Sin personalización'),
(41, 35, 1, 1, 8.5, 'Salsa yogurt, Lechuga, Maíz, Salsa picante'),
(42, 35, 2, 1, 8.5, 'Cebolla, Salsa yogurt, Maíz, Queso feta, Lombarda'),
(43, 36, 25, 2, 2.5, 'Sin personalización'),
(44, 36, 2, 1, 8.5, 'Salsa yogurt, Maíz, Queso feta, Lombarda, Salsa picante'),
(45, 37, 1, 1, 8.5, 'Cebolla, Salsa yogurt, Lechuga, Tomate, Maíz, Queso feta'),
(46, 37, 7, 1, 7.5, 'Sin personalización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250319193757', '2025-03-19 20:38:06', 167),
('DoctrineMigrations\\Version20250319194907', '2025-03-19 20:49:13', 483),
('DoctrineMigrations\\Version20250408172305', '2025-04-08 19:23:15', 89),
('DoctrineMigrations\\Version20250408173449', '2025-04-08 19:35:02', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadospedidos`
--

CREATE TABLE `estadospedidos` (
  `id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estadospedidos`
--

INSERT INTO `estadospedidos` (`id`, `nombre`) VALUES
(1, 'Pendiente'),
(2, 'En preparación'),
(3, 'En reparto'),
(4, 'Entregado'),
(6, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialventas`
--

CREATE TABLE `historialventas` (
  `id` int NOT NULL,
  `pedido_id` int NOT NULL,
  `fechaventa` datetime NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historialventas`
--

INSERT INTO `historialventas` (`id`, `pedido_id`, `fechaventa`, `total`) VALUES
(1, 3, '2025-05-19 23:29:03', 8.5),
(2, 4, '2025-05-21 18:20:21', 41.5),
(3, 5, '2025-05-21 18:20:59', 17),
(4, 6, '2025-05-28 22:29:23', 0),
(5, 7, '2025-05-28 22:30:05', 0),
(6, 8, '2025-05-28 22:33:13', 8.5),
(7, 9, '2025-05-28 22:33:58', 8.5),
(8, 10, '2025-05-28 22:36:03', 17),
(9, 11, '2025-05-28 22:36:52', 17),
(11, 13, '2025-05-28 22:42:09', 8.5),
(12, 14, '2025-05-28 22:47:44', 8.5),
(13, 15, '2025-05-28 22:48:29', 8.5),
(14, 16, '2025-05-28 22:52:14', 25.5),
(15, 17, '2025-05-28 23:20:09', 8.5),
(16, 18, '2025-05-28 23:22:32', 7.5),
(17, 19, '2025-05-28 23:23:30', 8.5),
(21, 23, '2025-05-29 19:48:22', 8.5),
(23, 25, '2025-05-31 18:49:41', 8.5),
(24, 26, '2025-05-31 18:50:50', 8.5),
(25, 27, '2025-05-31 18:55:03', 8.5),
(26, 28, '2025-05-31 18:58:27', 8.5),
(27, 29, '2025-05-31 19:01:04', 8.5),
(28, 30, '2025-05-31 19:06:55', 8.5),
(29, 31, '2025-05-31 19:08:16', 8.5),
(30, 32, '2025-05-31 19:10:15', 8.5),
(31, 33, '2025-05-31 19:11:16', 8.5),
(32, 34, '2025-05-31 19:41:55', 8.5),
(33, 35, '2025-05-31 20:23:18', 19.5),
(34, 36, '2025-06-01 11:49:19', 13.5),
(35, 37, '2025-06-01 13:09:27', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `estado_id` int NOT NULL,
  `direccionentrega` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `metodopago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechapedido` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuarios_id`, `estado_id`, `direccionentrega`, `total`, `metodopago`, `fechapedido`) VALUES
(3, 8, 4, '1', 8.5, 'Efectivo', '2025-05-19 23:29:00'),
(4, 8, 1, '1', 41.5, 'Efectivo', '2025-05-21 18:20:20'),
(5, 8, 1, '1', 17, 'Efectivo', '2025-05-21 18:20:59'),
(6, 8, 1, 'calle 2', 0, 'Efectivo', '2025-05-28 22:29:23'),
(7, 8, 1, 'calle 2', 0, 'Efectivo', '2025-05-28 22:30:05'),
(8, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:33:13'),
(9, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:33:58'),
(10, 8, 1, 'calle 2', 17, 'Efectivo', '2025-05-28 22:36:03'),
(11, 8, 1, 'calle 2', 17, 'Efectivo', '2025-05-28 22:36:52'),
(12, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:40:13'),
(13, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:42:09'),
(14, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:47:43'),
(15, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 22:48:29'),
(16, 8, 1, 'calle 2', 25.5, 'Efectivo', '2025-05-28 22:52:14'),
(17, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 23:20:09'),
(18, 8, 1, 'calle 2', 7.5, 'Efectivo', '2025-05-28 23:22:32'),
(19, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-28 23:23:30'),
(20, 8, 1, 'calle 2', 15.5, 'Efectivo', '2025-05-29 18:04:58'),
(21, 8, 2, 'calle 2', 42.5, 'Efectivo', '2025-05-29 18:09:00'),
(23, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-29 19:48:22'),
(24, 8, 1, 'calle 2', 12, 'Efectivo', '2025-05-29 20:08:36'),
(25, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 18:49:41'),
(26, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 18:50:50'),
(27, 8, 1, 'calle 2', 8.5, 'Tarjeta', '2025-05-31 18:55:03'),
(28, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 18:58:27'),
(29, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:01:03'),
(30, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:06:54'),
(31, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:08:16'),
(32, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:10:15'),
(33, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:11:16'),
(34, 8, 1, 'calle 2', 8.5, 'Efectivo', '2025-05-31 19:41:55'),
(35, 8, 1, 'calle 2', 19.5, 'Efectivo', '2025-05-31 20:23:18'),
(36, 8, 1, 'calle 2', 13.5, 'Efectivo', '2025-06-01 11:49:18'),
(37, 24, 1, 'Calle fragua', 16, 'Efectivo', '2025-06-01 13:09:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` double NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredientes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alergenos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `creadoen` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `imagen`, `ingredientes`, `alergenos`, `disponible`, `creadoen`) VALUES
(1, 2, 'Menú Kebab De Pollo', 'Con ensalada, patatas fritas y bebida', 8.5, 'kebabmenu.avif', 'Carne de pollo, pan pita, salsa yogurt ,lechuga ,tomate ,cebolla ,maíz ,queso feta', 'Gluten, lácteos, huevo', 1, '2025-05-05 19:24:21'),
(2, 2, 'Menú Kebab De Mixto', 'Con ensalada, patatas fritas y bebida', 8.5, 'kebabmenu.avif', 'Carne de pollo, pan pita, salsa yogurt ,lechuga ,tomate ,cebolla ,maíz ,queso feta', 'Gluten, lácteos, huevo', 1, '2025-05-05 19:24:21'),
(3, 2, 'Menú Kebab De Ternera', 'Con ensalada, patatas fritas y bebida', 8.5, 'kebabmenu.avif', 'Carne de Ternera, pan pita, salsa yogurt ,lechuga ,tomate ,cebolla ,maíz ,queso feta', 'Gluten, lácteos, huevo', 1, '2025-05-05 19:31:22'),
(4, 6, 'Menú Kebab De Falafel', 'Con ensalada, patatas fritas y bebida', 8.5, 'falafelmenu.avif', 'Falafel, pan pita, salsa yogurt ,lechuga ,tomate ,cebolla ,maíz ,queso feta', 'Gluten, lácteos, huevo', 1, '2025-05-05 19:31:22'),
(5, 1, 'Box Carne Kebab', 'Con patatas, bacón y salsa cheddar o yogurt', 8, 'box.avif', 'Carne de pollo o ternera, patatas, salsa yogurt ,lechuga ,tomate ,cebolla ,maíz ,queso feta', 'Lácteos, huevo', 1, '2025-05-05 19:33:43'),
(6, 1, 'Croquetas', 'Croquetas de cocido servidas con una guarnición de patatas', 7, 'croquetas.avif', 'pollo , bechamel', 'Gluten, lácteos, huevo', 1, '2025-05-05 19:33:43'),
(7, 1, 'Fingers De Pollo', 'Tiras de pollo empanadas,posiblemente con una variante de patatas o chetos', 7.5, 'finger.avif', 'finger de pollo', 'ninguna', 1, '2025-05-05 19:45:04'),
(8, 1, 'Nuggets', 'Nuggets de pollo acompañados de patatas', 7, 'nuggets.jpg', 'pollo', 'huevo', 1, '2025-05-05 19:52:10'),
(9, 1, 'Atos De Cebolla', 'Aros de cebolla crujientes, servidos con patatas', 6, 'aros.avif', 'Cebolla, huevo', 'huevo', 1, '2025-05-05 19:52:10'),
(10, 1, 'Patatas fritas', 'Una ración de patatas fritas, posiblemente especialidad bistona', 3, 'patatas.jpg', 'patatas', 'ninguna', 1, '2025-05-05 19:55:05'),
(11, 1, 'Ensalada Las Niñas', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,carne de pollo o ternera y salsa de yogurt.', 9, 'ensaladaninas.jpg', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,carne de pollo o ternera y salsa de yogurt.', 'Lactosa, huevo', 1, '2025-05-05 19:55:05'),
(12, 1, 'Ensalada Griega', 'Lechuga, tomate, cebolla, zanahoria y queso feta', 8, 'ensaladagriega.jpg', 'Lechuga, tomate, cebolla, zanahoria y queso feta', 'Lacteos', 1, '2025-05-05 20:00:39'),
(13, 1, 'Ensalada Mixta', 'Lechuga ,tomate ,cebolla ,atún y maíz', 7, 'ensaladamixta.jpg', 'Lechuga ,tomate ,cebolla ,atún y maíz', 'ninguno', 1, '2025-05-05 20:02:21'),
(14, 2, 'Kebab De Pollo', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de pollo y salsa de yogurt.', 6.5, 'kebab.avif', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de pollo y salsa de yogurt.', 'Gluten,lacteos y huevo', 1, '2025-05-05 20:02:21'),
(15, 2, 'Kebab De Ternera', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de ternera y salsa de yogurt.', 6.5, 'kebab.avif', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de pollo y salsa de yogurt.', 'Gluten, huevos y lacteos', 1, '2025-05-05 20:06:21'),
(16, 2, 'Kebab Mixto', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de pollo , ternera y salsa de yogurt.', 6.5, 'kebab.avif', 'Lechuga, tomate ,cebolla ,zanahoria ,maíz ,queso feta ,carne de pollo , ternera y salsa de yogurt.', 'Gluten, lácteos y huevo', 1, '2025-05-05 20:06:21'),
(17, 3, 'Menú Hamburguesa Completa', 'Ternera Angus ,huevo ,lechuga ,tomate ,queso ,bacón ,patatas y bebida', 8.5, 'hamburguesacompleta.jpg', 'Ternera Angus ,huevo ,lechuga ,tomate ,queso ,bacón ,patatas', 'Gluten, lácteos y huevo', 1, '2025-05-05 20:11:02'),
(18, 3, 'Hamburguesa Sencilla', 'Ternera Angus, lechuga ,tomate ,queso ,patatas y bebida', 7, 'hamburguesasencilla.jpg', 'Ternera Angus, lechuga ,tomate ,queso ,patatas', 'Gluten, lácteos y huevo', 1, '2025-05-05 20:11:02'),
(19, 1, 'Plato De Carne', 'Carne de pollo o ternera con patatas ,ensalada y salsa', 8.5, 'platocarne.avif', 'Carne de pollo o ternera con patatas ,ensalada y salsa', 'lácteos y huevo', 1, '2025-05-05 20:11:02'),
(20, 6, 'Plato Falafel', 'Con ensalada, patatas fritas y bebida', 8, 'platofalafel.jpg', 'Falafel ,ensalada y patatas', 'Gluten, lácteos y huevo', 1, '2025-05-05 20:11:02'),
(21, 1, 'Plato Con Patatas', 'Carne patatas y salsa yogurt', 7, 'patatas.jpg', 'Carne, patatas y salsa yogur', 'Huevos, lácteos', 1, '2025-05-05 20:11:02'),
(22, 4, 'Aquarius Limón', 'Aquarius Limón lata 330ml.', 2.5, 'aquariuslimo.jpg', 'Aquarius Limón lata 330ml.', 'Ninguno', 1, '2025-05-05 20:29:22'),
(23, 4, 'Coca-Cola Sabor Original', 'Coca-Cola Sabor Original lata 330ml', 2.5, 'cocanormal.jpg', 'Coca-Cola Sabor Original lata 330ml.', 'ninguno', 1, '2025-05-05 20:29:22'),
(24, 4, 'Coca-Cola Zero Azúcar', 'Coca-Cola Zero Azúcar lata 330ml', 2.5, 'cocazero.jpg', 'Coca-Cola Zero Azúcar lata 330ml.', 'Ninguno', 1, '2025-05-05 20:29:22'),
(25, 4, 'Fanta Limón lata', 'Fanta Limón lata 330ml.', 2.5, 'fantalimon.jpg', 'Fanta Limón lata 330ml.', 'ninguno', 1, '2025-05-05 20:29:22'),
(26, 4, 'Fanta Naranja', 'Fanta Naranja lata 330ml.', 2.5, 'fantanaranja.jpg', 'Fanta Naranja lata 330ml.', 'Ninguno', 1, '2025-05-05 20:29:22'),
(27, 4, 'Nestea Té Negro Limón', 'Nestea Té Negro Limón lata 330ml', 2.5, 'nestealimon.png', 'Nestea Té Negro Limón lata 330ml.', 'Ninguno', 1, '2025-05-05 20:29:22'),
(28, 4, 'Agua botella', 'Agua botella (500 Ml.)', 2, 'agua.avif', 'Agua botella (500 Ml.)', 'Ninguno', 1, '2025-05-05 20:29:22'),
(29, 4, 'Victoria', 'Victoria Lata 33cl', 2.5, 'cerverza.avif', 'Victoria Lata 33cl', 'Ninguno', 1, '2025-05-05 20:29:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `personas` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `nombre`, `telefono`, `personas`, `fecha`, `hora`) VALUES
(2, '123', '123123123', 2, '2025-05-30', '21:15:00'),
(3, '123', '123312123', 2, '2025-05-27', '19:15:00'),
(4, 'asd', '615255786', 2, '2025-06-19', '01:00:00'),
(5, 'asd', '615255732', 3, '2025-05-31', '19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verificado` tinyint(1) NOT NULL,
  `creadoen` datetime NOT NULL,
  `administrador` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contrasena`, `direccion`, `telefono`, `verificado`, `creadoen`, `administrador`) VALUES
(8, 'alvaro', 'exsaol24@gmail.com', '1234', 'calle 2', '111', 1, '2025-04-08 19:35:44', 1),
(10, 'Juan Sánche', 'juan@example.com', 'pass1234', 'Calle Falsa 123', '600123456', 1, '2025-05-05 19:17:32', 1),
(11, 'María López', 'maria@example.com', 'pass1234', 'Avenida Siempre Viva 789', '610987654', 1, '2025-05-05 19:17:32', 0),
(12, 'Carlos Ruiz', 'carlos@example.com', 'pass1234', 'Plaza Mayor 1', '622334455', 0, '2025-05-05 19:17:32', 0),
(13, 'Admin User', 'admin@example.com', 'admin123', 'Oficina Central', '600000000', 1, '2025-05-05 19:17:32', 1),
(18, 'asd', 'alvarocio69@hotmail.com', '1234', 'asd', '1233', 1, '2025-05-12 19:13:24', 0),
(19, 'leo', 'leo@gmail.com', '1234', 'calle fragua', '1234', 1, '2025-05-15 13:05:13', 0),
(20, 'albertito', 'albertito@gmail.com', '1234', 'calle fragua', '1234', 1, '2025-05-15 16:59:24', 0),
(24, 'zacarias', 'peloton920@gmail.com', 'zACARIAS1234?', 'Calle fragua', '615255786', 1, '2025-06-01 13:07:17', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8111551B4854653A` (`pedido_id`),
  ADD KEY `IDX_8111551BD77499C5` (`platos_id`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B0B0BECBF01D3B25` (`usuarios_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `estadospedidos`
--
ALTER TABLE `estadospedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historialventas`
--
ALTER TABLE `historialventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_78D8FA064854653A` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6716CCAAF01D3B25` (`usuarios_id`),
  ADD KEY `IDX_6716CCAA9F5A440B` (`estado_id`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1D29312A3397707A` (`categoria_id`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EF687F2E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estadospedidos`
--
ALTER TABLE `estadospedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historialventas`
--
ALTER TABLE `historialventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  ADD CONSTRAINT `FK_8111551B4854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `FK_8111551BD77499C5` FOREIGN KEY (`platos_id`) REFERENCES `platos` (`id`);

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `FK_B0B0BECBF01D3B25` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `historialventas`
--
ALTER TABLE `historialventas`
  ADD CONSTRAINT `FK_78D8FA064854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_6716CCAA9F5A440B` FOREIGN KEY (`estado_id`) REFERENCES `estadospedidos` (`id`),
  ADD CONSTRAINT `FK_6716CCAAF01D3B25` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `platos`
--
ALTER TABLE `platos`
  ADD CONSTRAINT `FK_1D29312A3397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
