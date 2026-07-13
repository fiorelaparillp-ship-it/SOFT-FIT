SET SESSION sql_require_primary_key = 0;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2026 a las 03:04:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `softfit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `cliente_id`, `fecha`, `hora`) VALUES
(1, 1, '2026-06-23', '21:37:33'),
(2, 4, '2026-06-23', '19:24:18'),
(3, 7, '2026-06-23', '19:30:16'),
(4, 8, '2026-06-24', '14:44:40'),
(5, 13, '2026-06-24', '14:45:06'),
(6, 14, '2026-06-25', '04:48:50'),
(7, 7, '2026-06-26', '20:34:35'),
(8, 11, '2026-06-27', '12:01:50'),
(9, 11, '2026-06-27', '12:03:53'),
(10, 10, '2026-06-27', '12:07:13'),
(11, 8, '2026-06-27', '12:14:09'),
(12, 8, '2026-06-27', '12:26:35'),
(13, 19, '2026-06-27', '12:30:58'),
(14, 20, '2026-06-27', '12:37:15'),
(15, 21, '2026-06-27', '12:43:19'),
(16, 3, '2026-06-27', '12:56:38'),
(17, 13, '2026-06-27', '13:00:28'),
(18, 10, '2026-06-29', '10:44:26'),
(19, 9, '2026-06-29', '18:29:40'),
(20, 3, '2026-06-29', '19:32:49'),
(21, 8, '2026-06-29', '19:39:56'),
(22, 22, '2026-06-29', '22:52:08'),
(23, 24, '2026-07-01', '16:05:51'),
(24, 25, '2026-07-01', '19:30:12'),
(25, 26, '2026-07-01', '19:38:59'),
(26, 27, '2026-07-01', '19:43:58'),
(27, 28, '2026-07-01', '19:49:54'),
(28, 29, '2026-07-01', '20:53:29'),
(29, 15, '2026-07-01', '23:12:26'),
(30, 30, '2026-07-01', '23:21:29'),
(31, 31, '2026-07-02', '09:15:50'),
(32, 32, '2026-07-02', '10:23:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `monto_inicial` decimal(10,2) DEFAULT NULL,
  `total_ventas` decimal(10,2) DEFAULT NULL,
  `ventas_turno` int(11) NOT NULL DEFAULT 0,
  `total_final` decimal(10,2) DEFAULT NULL,
  `fecha_apertura` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_cierre` datetime DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `usuario_apertura` int(11) NOT NULL,
  `usuario_cierre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `usuario_id`, `monto_inicial`, `total_ventas`, `ventas_turno`, `total_final`, `fecha_apertura`, `fecha_cierre`, `estado`, `usuario_apertura`, `usuario_cierre`) VALUES
(1, 0, 185.00, 1307.80, 0, 1492.80, '2026-06-30 05:11:45', '2026-06-30 00:12:42', 'cerrada', 0, NULL),
(2, 0, 45.00, 1307.80, 0, 1352.80, '2026-06-30 05:27:12', '2026-06-30 00:27:25', 'cerrada', 17, 17),
(3, 0, 85.00, 0.00, 0, 85.00, '2026-06-30 05:43:03', '2026-06-30 00:43:43', 'cerrada', 17, 17),
(4, 0, 198.00, 2.80, 1, 200.80, '2026-06-30 05:44:14', '2026-06-30 00:45:39', 'cerrada', 21, 21),
(5, 0, 196.00, 38.00, 2, 234.00, '2026-06-30 06:21:10', '2026-06-30 01:23:13', 'cerrada', 17, 17),
(6, 0, 197.00, 5.70, 1, 202.70, '2026-06-30 07:09:28', '2026-06-30 03:20:48', 'cerrada', 20, 20),
(7, 20, 89.00, 98.40, 1, 187.40, '2026-06-30 13:17:02', '2026-06-30 08:17:51', 'cerrada', 20, 20),
(8, 17, 50.00, 131.30, 2, 181.30, '2026-07-01 01:21:23', '2026-06-30 20:25:07', 'cerrada', 17, 17),
(9, 17, 48.00, 89.90, 1, 137.90, '2026-07-01 01:36:18', '2026-06-30 20:36:52', 'cerrada', 17, 17),
(10, 21, 55.00, 17.50, 1, 72.50, '2026-07-01 01:44:47', '2026-06-30 20:45:24', 'cerrada', 21, 21),
(11, 17, 15.00, 0.00, 0, 15.00, '2026-07-01 02:28:39', '2026-06-30 21:42:06', 'cerrada', 17, 21),
(12, 21, 50.00, 0.00, 0, 50.00, '2026-07-01 02:47:08', '2026-07-01 15:39:47', 'cerrada', 21, 17),
(13, 21, 0.00, 17.50, 1, -0.50, '2026-07-01 20:54:25', '2026-07-01 16:06:27', 'cerrada', 21, 21),
(14, 21, 89.00, 98.90, 1, 163.90, '2026-07-01 21:22:06', '2026-07-01 16:23:45', 'cerrada', 21, 21),
(15, 24, 50.00, 229.80, 1, 199.80, '2026-07-01 21:29:00', '2026-07-01 16:31:03', 'cerrada', 24, 24),
(16, 24, 150.00, 0.00, 0, 150.00, '2026-07-01 21:35:04', '2026-07-01 16:35:17', 'cerrada', 24, 24),
(17, 24, 900.00, 0.00, 0, 834.00, '2026-07-01 21:39:51', '2026-07-01 16:41:37', 'cerrada', 24, 24),
(18, 17, 58.00, 0.00, 0, 58.00, '2026-07-01 23:12:03', '2026-07-01 18:12:21', 'cerrada', 17, 17),
(19, 17, 45.00, 1.50, 1, 46.50, '2026-07-01 23:38:18', '2026-07-01 18:46:30', 'cerrada', 17, 17),
(20, 24, 0.00, 2.60, 1, 2.60, '2026-07-02 02:57:40', '2026-07-01 21:58:48', 'cerrada', 24, 24),
(21, 17, 0.00, 89.90, 1, 89.90, '2026-07-02 04:05:10', '2026-07-01 23:05:46', 'cerrada', 17, 17),
(22, 17, 85.00, 7.00, 1, 92.00, '2026-07-02 04:15:25', '2026-07-01 23:26:48', 'cerrada', 17, 17),
(23, 24, 0.00, 16.30, 2, 16.30, '2026-07-02 14:12:34', '2026-07-02 09:23:29', 'cerrada', 24, 24),
(24, 17, 0.00, 0.00, 0, -8.00, '2026-07-02 14:39:23', '2026-07-02 09:40:19', 'cerrada', 17, 17),
(25, 17, 50.00, 0.00, 0, 41.00, '2026-07-02 15:34:10', '2026-07-02 10:36:54', 'cerrada', 17, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Suplementos'),
(2, 'Creatinas'),
(3, 'Bebidas'),
(4, 'Snacks'),
(5, 'Accesorios'),
(6, 'Equipamiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_diarias`
--

CREATE TABLE `clases_diarias` (
  `id` int(11) NOT NULL,
  `nombre_cliente` varchar(150) NOT NULL,
  `tipo_clase` varchar(50) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `forma_pago` varchar(30) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases_diarias`
--

INSERT INTO `clases_diarias` (`id`, `nombre_cliente`, `tipo_clase`, `monto`, `forma_pago`, `fecha`, `usuario_id`) VALUES
(1, 'juan', 'Diario', 10.00, 'Yape', '2026-07-01 21:04:10', 17),
(2, 'joel', 'Diario + Duchas', 15.00, 'Transferencia', '2026-07-01 21:08:22', 17),
(3, 'manuel', 'Diario + Duchas', 15.00, 'Transferencia', '2026-07-01 21:13:33', 17),
(4, 'manuel', 'Diario', 8.00, 'Yape', '2026-07-01 21:17:41', 17),
(5, 'jazmin', 'Diario', 8.00, 'Yape', '2026-07-01 21:22:19', 17),
(6, 'Sebastian', 'Diario + Duchas', 15.00, 'Plin', '2026-07-01 23:31:20', 17),
(7, 'cliente varios', 'Diario + Duchas', 15.00, 'Yape', '2026-07-02 09:16:44', 24),
(8, 'cliente varios', 'Diario + Duchas', 15.00, 'Transferencia', '2026-07-02 09:38:33', 17),
(9, 'cliente varios', 'Diario + Duchas', 15.00, 'Transferencia', '2026-07-02 10:25:25', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `dni`, `telefono`, `correo`, `codigo`, `usuario`, `foto`) VALUES
(1, 'Julio Sanchez', '60123485', '950235687', 'juliosan@gmail.com', NULL, NULL, 'avatar.png'),
(2, 'Juan Pérez Gómez', '71234567', '987654321', 'juan.perez@gmail.com', NULL, NULL, 'avatar.png'),
(3, 'María López Torres', '72345678', '976543210', 'maria.lopez@hotmail.com', NULL, NULL, 'avatar.png'),
(4, 'Carlos Ramírez Díaz', '73456789', '965432109', 'carlos.ramirez@yahoo.com', NULL, NULL, 'avatar.png'),
(5, 'Ana Fernández Ruiz', '74567890', '954321098', 'ana.ferna@gmail.com', NULL, NULL, 'avatar.png'),
(6, 'Luis Mendoza Castro', '75678901', '943210987', 'luis.mendoza@gmail.com', NULL, NULL, 'avatar.png'),
(7, 'Sofía Vargas León', '76789012', '932109876', 'sofia.vargas@gmail.com', NULL, NULL, 'avatar.png'),
(8, 'Pedro Castillo Rojas', '77890123', '921098765', 'castillo@yahoo.com', NULL, NULL, 'avatar.png'),
(9, 'Lucía Herrera Flores', '78901234', '910987654', 'herrera@hotmail.com', NULL, NULL, 'avatar.png'),
(10, 'Jorge Silva Paredes', '79012345', '998877665', 'jorge.silva@gmail.com', NULL, NULL, 'avatar.png'),
(11, 'Valeria Torres Salas', '70123456', '987123456', 'vale.torres@yahoo.com', NULL, NULL, 'avatar.png'),
(12, 'Miguel Sánchez Romero', '71239876', '976234567', 'miguel.san@gmail.com', NULL, NULL, 'avatar.png'),
(13, 'Daniela Cruz Mendoza', '72349876', '965345678', 'danielacruz@gmail.com', NULL, NULL, 'avatar.png'),
(14, 'Fernando Quispe Huamán', '73459877', '954456789', 'fernaqui@gmail.com', NULL, NULL, 'avatar.png'),
(15, 'Patricia Navarro Vega', '74569877', '943567890', 'patrinava@gmail.com', NULL, NULL, '1782966341.jpeg'),
(22, 'Brenda Quispe ', '60670550', '948562347', 'brenda@gmail.com', NULL, NULL, '1782791566.jpg'),
(24, 'Gyan Salazar', '06398528', '963586325', 'gyanjusa@gmail.com', NULL, NULL, '1782939850.avif'),
(25, 'Alison Yudith Sanchez', '63256987', '963258747', 'aliyu@gmail.com', NULL, NULL, '1782952157.jpeg'),
(26, 'Andre Sebastian Salas', '60369852', '963256325', 'sebas@gmail.com', NULL, NULL, '1782952636.jpeg'),
(27, 'Allison Samira Anco', '89653214', '965478523', 'alisaan@gamil.com', NULL, NULL, '1782952966.jpeg'),
(28, 'Stiven Andre Quispe', '02365987', '985632569', 'stiven@gmail.com', NULL, NULL, '1782953195.jpeg'),
(29, 'Oscar Rodriguez', '60498628', '956238974', 'oscarrro@gmail.com', NULL, NULL, '1782957070.jpg'),
(30, 'Gustavo Jhon', '77789630', '955663365', 'gustavope@gmail.com', NULL, NULL, '1782966307.jpeg'),
(31, 'Ander Peres', '63698527', '963635987', 'anderr@gmail.com', NULL, NULL, '1783001701.jpg'),
(32, 'David ', '60065425', '956231478', 'david@gmail.com', NULL, NULL, '1783005342.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre_gimnasio` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `color_principal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre_gimnasio`, `telefono`, `correo`, `direccion`, `logo`, `color_principal`) VALUES
(1, 'SOFTFIT GYM', '', '', '', '', '#7c3aed');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `venta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `producto_id`, `cantidad`, `subtotal`, `venta_id`) VALUES
(1, 2, 5, 225.00, 1),
(2, 2, 1, 45.00, 2),
(3, 7, 1, 8.50, 3),
(4, 8, 1, 8.50, 3),
(5, 3, 1, 1.50, 4),
(6, 8, 1, 8.50, 4),
(7, 10, 1, 9.00, 4),
(8, 1, 1, 100.00, 5),
(9, 3, 1, 1.50, 5),
(10, 1, 1, 100.00, 6),
(11, 2, 1, 45.00, 6),
(12, 3, 1, 1.50, 6),
(13, 1, 1, 100.00, 7),
(14, 2, 1, 45.00, 7),
(15, 8, 1, 8.50, 8),
(16, 7, 1, 8.50, 8),
(17, 1, 1, 100.00, 9),
(18, 2, 1, 45.00, 9),
(19, 2, 1, 45.00, 10),
(20, 1, 1, 100.00, 10),
(21, 2, 1, 45.00, 11),
(22, 3, 1, 1.50, 12),
(23, 21, 2, 17.00, 13),
(24, 9, 3, 27.00, 14),
(25, 1, 1, 100.00, 15),
(26, 8, 1, 8.50, 15),
(27, 3, 1, 1.50, 16),
(28, 7, 1, 8.50, 16),
(29, 2, 1, 45.00, 17),
(30, 2, 1, 45.00, 18),
(31, 3, 1, 1.50, 19),
(32, 4, 1, 1.30, 19),
(33, 3, 1, 1.50, 20),
(34, 4, 1, 1.30, 20),
(35, 2, 2, 90.00, 21),
(36, 13, 1, 35.00, 22),
(37, 3, 1, 1.50, 22),
(38, 3, 1, 1.50, 23),
(39, 17, 1, 4.50, 24),
(40, 20, 1, 1.20, 24),
(41, 11, 1, 89.90, 25),
(42, 7, 1, 8.50, 25),
(43, 4, 1, 1.30, 26),
(44, 6, 1, 85.00, 26),
(45, 2, 1, 45.00, 27),
(46, 11, 1, 89.90, 28),
(47, 8, 1, 8.50, 29),
(48, 9, 1, 9.00, 29),
(49, 8, 1, 8.50, 30),
(50, 9, 1, 9.00, 30),
(51, 11, 1, 89.90, 31),
(52, 10, 1, 9.00, 31),
(53, 15, 1, 99.90, 32),
(54, 25, 1, 129.90, 32),
(55, 3, 1, 1.50, 33),
(56, 4, 2, 2.60, 35),
(57, 11, 1, 89.90, 36),
(58, 16, 2, 7.00, 37),
(59, 4, 1, 1.30, 39),
(60, 9, 1, 9.00, 43),
(61, 15, 1, 99.90, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_caja`
--

CREATE TABLE `gastos_caja` (
  `id` int(11) NOT NULL,
  `caja_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_caja`
--

INSERT INTO `gastos_caja` (`id`, `caja_id`, `usuario_id`, `concepto`, `monto`, `fecha`) VALUES
(1, 13, 21, 'Limpieza - se necesito 3 botellas de limpiador Poet', 18.00, '2026-07-01 20:55:01'),
(2, 14, 21, 'Agua - NINGUNA', 24.00, '2026-07-01 21:22:41'),
(3, 15, 24, 'Mantenimiento - mantenimiento de maquinas', 80.00, '2026-07-01 21:29:38'),
(4, 17, 24, 'Bebidas - 3 PAQUETES DE AGUA', 41.00, '2026-07-01 21:40:15'),
(5, 17, 24, 'Limpieza - ESCOBA', 25.00, '2026-07-01 21:40:29'),
(6, 24, 17, 'Limpieza - compro bolsas de basura', 8.00, '2026-07-02 14:39:47'),
(7, 25, 17, 'Limpieza - 9 paquetes de basura', 9.00, '2026-07-02 15:35:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias`
--

CREATE TABLE `membresias` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresias`
--

INSERT INTO `membresias` (`id`, `cliente_id`, `plan_id`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(1, 1, 1, '2026-05-24', '2026-06-24', 'Vencida'),
(2, 6, 4, '2026-05-26', '2026-06-26', 'Vencida'),
(3, 3, 9, '2026-06-23', '2027-06-23', 'Activa'),
(4, 4, 11, '2026-06-23', '2026-07-23', 'Activa'),
(5, 5, 7, '2026-06-23', '2026-12-23', 'Activa'),
(6, 7, 5, '2026-06-24', '2026-09-24', 'Activa'),
(7, 8, 8, '2026-06-25', '2026-12-25', 'Activa'),
(10, 9, 6, '2026-06-23', '2026-06-23', 'Vencida'),
(11, 10, 1, '2026-06-23', '2026-07-23', 'Activa'),
(12, 11, 6, '2026-06-23', '2026-09-23', 'Activa'),
(13, 12, 11, '2026-07-01', '2026-08-01', 'Activa'),
(14, 13, 7, '2026-07-01', '2026-10-01', 'Activa'),
(15, 14, 1, '2026-07-01', '2026-08-01', 'Activa'),
(16, 15, 9, '2026-07-01', '2027-07-01', 'Activa'),
(17, 16, 9, '2026-08-01', '2026-08-01', 'Activa'),
(21, 19, 11, '2026-12-02', '2027-01-02', 'Activa'),
(22, 20, 12, '2026-12-23', '2027-01-23', 'Activa'),
(23, 21, 16, '2026-10-20', '2027-10-20', 'Activa'),
(24, 9, 3, '2026-07-01', '2026-08-01', 'Activa'),
(25, 22, 16, '2026-06-29', '2027-06-29', 'Activa'),
(26, 24, 6, '2026-07-12', '2026-10-12', 'Activa'),
(27, 25, 16, '2026-07-01', '2027-07-01', 'Activa'),
(28, 26, 14, '2026-07-02', '2026-08-02', 'Activa'),
(29, 27, 5, '2026-07-02', '2026-10-02', 'Activa'),
(30, 28, 8, '2026-07-02', '2027-01-02', 'Activa'),
(31, 29, 10, '2026-07-01', '2027-07-01', 'Activa'),
(32, 30, 8, '2026-08-02', '2027-02-02', 'Activa'),
(33, 31, 16, '2026-07-02', '2027-07-02', 'Activa'),
(34, 32, 19, '2026-07-02', '2026-08-02', 'Activa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresias_clientes`
--

CREATE TABLE `membresias_clientes` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `membresia_id` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_inventario`
--

CREATE TABLE `movimientos_inventario` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `tipo` enum('entrada','salida') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_anterior` int(11) NOT NULL,
  `stock_nuevo` int(11) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_inventario`
--

INSERT INTO `movimientos_inventario` (`id`, `producto_id`, `tipo`, `cantidad`, `stock_anterior`, `stock_nuevo`, `observacion`, `fecha`) VALUES
(1, 1, 'salida', 12, 15, 3, 'Ventas', '2026-06-23 19:32:20'),
(2, 3, 'entrada', 12, 10, 22, 'ninguna', '2026-06-23 19:32:42'),
(3, 7, 'entrada', 12, 7, 19, 'ninguna', '2026-06-24 15:46:27'),
(4, 1, 'entrada', 3, -2, 1, 'ninguna', '2026-06-28 20:49:50'),
(5, 2, 'entrada', 14, -4, 10, 'ninguna', '2026-06-28 20:50:02'),
(6, 14, 'salida', 5, 5, 0, 'Ventas', '2026-06-28 21:21:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_cliente`
--

CREATE TABLE `perfil_cliente` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `grasa` decimal(5,2) DEFAULT NULL,
  `masa_muscular` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `permitido` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol`, `modulo`, `permitido`) VALUES
(1, 'Administrador', 'dashboard', 1),
(2, 'Recepcionista', 'dashboard', 1),
(3, 'Administrador', 'clientes', 1),
(4, 'Recepcionista', 'clientes', 1),
(5, 'Administrador', 'membresias', 1),
(6, 'Recepcionista', 'membresias', 1),
(7, 'Administrador', 'asignar_membresia', 1),
(8, 'Recepcionista', 'asignar_membresia', 1),
(9, 'Administrador', 'rutinas', 1),
(10, 'Recepcionista', 'rutinas', 1),
(11, 'Administrador', 'progreso', 1),
(12, 'Recepcionista', 'progreso', 1),
(13, 'Administrador', 'checkin', 1),
(14, 'Recepcionista', 'checkin', 1),
(15, 'Administrador', 'productos', 1),
(16, 'Recepcionista', 'productos', 1),
(17, 'Administrador', 'inventario', 1),
(18, 'Recepcionista', 'inventario', 0),
(19, 'Administrador', 'pos', 1),
(20, 'Recepcionista', 'pos', 1),
(21, 'Administrador', 'ventas', 1),
(22, 'Recepcionista', 'ventas', 1),
(23, 'Administrador', 'reportes', 1),
(24, 'Recepcionista', 'reportes', 0),
(25, 'Administrador', 'ajustes', 1),
(26, 'Recepcionista', 'ajustes', 1),
(27, 'Administrador', 'usuarios', 1),
(28, 'Recepcionista', 'usuarios', 0),
(29, 'Administrador', 'permisos', 1),
(30, 'Recepcionista', 'permisos', 0),
(31, 'Administrador', 'gimnasio', 1),
(32, 'Recepcionista', 'gimnasio', 0),
(33, 'Administrador', 'apariencia', 1),
(34, 'Recepcionista', 'apariencia', 0),
(35, 'Administrador', 'backup', 1),
(36, 'Recepcionista', 'backup', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_membresia`
--

CREATE TABLE `planes_membresia` (
  `id` int(11) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `duracion` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes_membresia`
--

INSERT INTO `planes_membresia` (`id`, `plan`, `duracion`, `precio`) VALUES
(1, 'Mensual', 1, 90.00),
(2, 'Básico Mensual', 1, 80.00),
(3, 'Estándar Mensual', 1, 100.00),
(4, 'Premium Mensual', 1, 130.00),
(5, 'Básico Trimestral', 3, 220.00),
(6, 'Premium Trimestral', 3, 350.00),
(7, 'Básico Semestral', 6, 420.00),
(8, 'Premium Semestral', 6, 650.00),
(9, 'Básico Anual', 12, 780.00),
(10, 'Premium Anual', 12, 1200.00),
(11, 'Estudiantil', 1, 60.00),
(12, 'Mensual', 1, 90.00),
(13, 'Mensual', 1, 90.00),
(14, 'Premium Mensual', 1, 130.00),
(15, 'Premium Mensual', 1, 130.00),
(16, 'Anual Parejas', 12, 630.00),
(18, 'Plan Semestral Premium', 6, 210.00),
(19, 'Plan universitario', 1, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `precio_mayor` decimal(10,2) DEFAULT 0.00,
  `cantidad_mayor` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `stock`, `precio`, `imagen`, `categoria_id`, `precio_mayor`, `cantidad_mayor`) VALUES
(1, 'Creatina Monohidratada', 'Mejora la fuerza, energía y rendimiento físico en ejercicios intensos.', 0, 100.00, 'Creatina Monohidratada.jpeg', 2, 0.00, 0),
(2, 'PROTEINA-Level Pro Iso Gold Whey ', 'Proteína de rápida absorción ideal para definición muscular y recuperación.', 6, 45.00, 'PROTEINA-Level Pro Iso Gold Whey.jpeg', 1, 0.00, 0),
(3, 'Agua San Carlos ', 'agua de mesa purificada y alcalina', 14, 1.50, '1782244846_Agua Mineral sancarlos.jpeg', 3, 0.00, 0),
(4, 'SAN LUIS', 'agua de mesa purificada y alcalina', 18, 1.30, '1782307181_SAN LUIS.jpeg', 3, 0.00, 0),
(6, 'Mass Gainer', 'Aumenta peso y masa muscular (alto en calorías).', 7, 85.00, '1782307892_Mass Gainer.jpeg', 1, 0.00, 0),
(7, 'Barra Proteico Chocolates ', 'Barra alta en proteina sabor chocolate ', 16, 8.50, '1782332257_Barra Proteica Chocolate.jpeg', 4, 0.00, 0),
(8, 'Barra Proteica Cookies', 'barra proteica sabor a cookies', 6, 8.50, '1782332320_Barra Proteica Cookies.jpeg', 4, 0.00, 0),
(9, 'Barra Protein Chocolate Bitter', 'Barra proteica chocolate amargo', 24, 9.00, '1782332391_Barra Protein Chocolate bitter.jpeg', 4, 0.00, 0),
(10, 'Barra Protein Cookies & Cream', 'barra proteica sabor cookies & cream', 28, 9.00, '1782332442_Barra Protein Cookies & Cream.jpeg', 4, 0.00, 0),
(11, 'BCAA', 'Aminoacido de cadena ramificada para recuperación muscular', 26, 89.90, '1782332817_BCAA.jpeg', 1, 0.00, 0),
(12, 'Bebida isotonica Blue', 'Bebida deportiva con electrolitos', 43, 4.50, '1782332900_Bebida Isotónica Blue.jpeg', 3, 0.00, 0),
(13, 'Cinta de Resistencia Fuerte', 'Banda elástica de alta resistencia', 7, 35.00, '1782332986_Cinta de Resistencia Fuerte.jpeg', 5, 0.00, 0),
(14, 'Cinta de Resistencia Ligera', 'Banda elástica de baja resistencia', 0, 25.00, '1782333026_Cinta de Resistencia Ligera.jpeg', 5, 0.00, 0),
(15, 'Creatina Monohidratada', 'Creatina pura para fuerza y potencia', 16, 99.90, '1782333065_Creatina Monohidratada.jpeg', 1, 0.00, 0),
(16, 'Galleta Fitness Avena', 'Galleta saludable rica en fibra', 23, 3.50, '1782333186_Galletas Fitness Avena.jpeg', 4, 0.00, 0),
(17, 'Gatorade Frutos Tropicales', 'Bebida rehidratante sabor tropical', 49, 4.50, '1782333227_Gatorade Frutos Tropicales.jpeg', 3, 0.00, 0),
(18, 'Glutamina', 'Suplemento para recuperación muscular', 10, 89.90, '1782333278_Glutamina.jpeg', 1, 0.00, 0),
(19, 'Guantes de Gimnasio Básicos Rosas', 'Guantes deportivos básicos', 12, 29.90, '1782333312_Guantes de Gimnasio Básicos rosa.jpeg', 5, 0.00, 0),
(20, 'Agua Loa', 'Agua mineral embotellada', 39, 1.20, '1782333382_LOA.jpeg', 3, 0.00, 0),
(21, 'Monster Energy Original', 'Bebida energética original', 28, 8.50, '1782333448_Monster Energy Original.jpeg', 3, 0.00, 0),
(22, 'Powerade Mountain Blast', 'Bebida isotónica sabor Mountain Blast', 40, 4.50, '1782333477_Powerade Mountain Blast.jpeg', 3, 0.00, 0),
(23, 'Pre Entreno Energy Boost', 'Suplemento pre-entreno', 12, 99.90, '1782333528_Pre Entreno Energy Boost.jpeg', 1, 0.00, 0),
(24, 'Preworkout', 'Fórmula avanzada pre-entreno', 6, 149.90, '1782333564_preworkout.jpeg', 1, 0.00, 0),
(25, 'Proteína Chocolate', 'Proteína whey sabor chocolate', 14, 129.90, '1782333694_proteinachocolate.jpeg', 1, 0.00, 0),
(26, 'Quemador de Grasa Thermofit', 'Suplemento termogénico', 12, 89.90, '1782333725_Quemador de Grasa ThermoFit.jpeg', 1, 0.00, 0),
(27, 'Red Bull Energy Drink', 'Bebida energética 250 ml', 35, 7.50, '1782333766_Red Bull Energy Drink.jpeg', 3, 0.00, 0),
(28, 'Shaker', 'Mezclador para suplementos', 20, 15.00, '1782333815_Shaker (mezclador).jpeg', 5, 0.00, 0),
(29, 'Shaker Premium', 'Mezclador premium con compartimentos', 12, 29.90, '1782333869_Shaker Premium 38.jpeg', 5, 0.00, 0),
(30, 'Yogurt Proteico Fresa', 'Yogurt alto en proteína sabor fresa', 25, 6.50, '1782333905_Yogurt Proteico Fresa.jpeg', 3, 0.00, 0),
(31, 'Yogurt Proteico Vainilla', 'Yogurt alto en proteína sabor vainilla', 25, 6.50, '1782333935_Yogurt Proteico Vainilla.jpeg', 4, 0.00, 0),
(32, 'AGUA CIELO', 'agua de mesa purificada y alcalina', 12, 1.20, '1782791649_CIELO.jpeg', 3, 0.00, 0),
(33, 'yogurt DanLac', 'sabor arandanos', 12, 8.00, '1783005994_yogurt danlac.jpeg', 4, 0.00, 0),
(34, 'salchipapa', 'snack', 5, 8.00, '1783006091_salchipapa.jpeg', 4, 0.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_cliente`
--

CREATE TABLE `progreso_cliente` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `imc` decimal(5,2) DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `altura` decimal(4,2) DEFAULT NULL,
  `meta_peso` decimal(5,2) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `progreso_cliente`
--

INSERT INTO `progreso_cliente` (`id`, `cliente_id`, `peso`, `imc`, `objetivo`, `fecha_registro`, `altura`, `meta_peso`, `fecha`) VALUES
(2, 10, 80.00, 27.36, 'TONIFICAR', '2026-06-29 17:34:36', 1.71, 65.00, '2026-06-29 12:34:36'),
(3, 5, 65.00, 22.49, 'TONIFICAR', '2026-06-29 17:39:40', 1.70, 55.00, '2026-06-29 12:39:40'),
(5, 7, 49.00, 19.63, 'TONIFICAR', '2026-06-29 22:18:32', 1.58, 56.00, '2026-06-29 17:18:32'),
(7, 1, 50.00, 18.82, '+ masa muscular', '2026-06-29 22:19:01', 1.63, 65.00, '2026-06-29 17:19:01'),
(10, 28, 65.00, 22.49, 'TONIFICAR', '2026-07-02 00:53:31', 1.70, 60.00, '2026-07-01 19:53:31'),
(11, 32, 55.00, 15.24, 'TONIFICAR', '2026-07-02 15:22:02', 1.90, 70.00, '2026-07-02 10:22:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_ventas_diarias`
--

CREATE TABLE `reporte_ventas_diarias` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `membresias` int(11) DEFAULT 0,
  `total_membresias` decimal(10,2) DEFAULT 0.00,
  `clientes_diarios` int(11) DEFAULT 0,
  `total_clientes_diarios` decimal(10,2) DEFAULT 0.00,
  `suplementos` int(11) DEFAULT 0,
  `total_suplementos` decimal(10,2) DEFAULT 0.00,
  `creatinas` int(11) DEFAULT 0,
  `total_creatinas` decimal(10,2) DEFAULT 0.00,
  `bebidas` int(11) DEFAULT 0,
  `total_bebidas` decimal(10,2) DEFAULT 0.00,
  `snacks` int(11) DEFAULT 0,
  `total_snacks` decimal(10,2) DEFAULT 0.00,
  `accesorios` int(11) DEFAULT 0,
  `total_accesorios` decimal(10,2) DEFAULT 0.00,
  `equipamiento` int(11) DEFAULT 0,
  `total_equipamiento` decimal(10,2) DEFAULT 0.00,
  `total_general` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte_ventas_diarias`
--

INSERT INTO `reporte_ventas_diarias` (`id`, `fecha`, `membresias`, `total_membresias`, `clientes_diarios`, `total_clientes_diarios`, `suplementos`, `total_suplementos`, `creatinas`, `total_creatinas`, `bebidas`, `total_bebidas`, `snacks`, `total_snacks`, `accesorios`, `total_accesorios`, `equipamiento`, `total_equipamiento`, `total_general`) VALUES
(1, '2026-07-02', 5, 1680.00, 3, 45.00, 1, 99.90, 0, 0.00, 1, 1.30, 1, 9.00, 0, 0.00, 0, 0.00, 0.00),
(2, '2026-07-01', 7, 3280.00, 5, 56.00, 4, 409.60, 0, 0.00, 3, 4.10, 5, 33.50, 0, 0.00, 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas`
--

CREATE TABLE `rutinas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas`
--

INSERT INTO `rutinas` (`id`, `cliente_id`, `titulo`, `descripcion`, `fecha_registro`) VALUES
(1, 1, 'Principiante Full Body ', ' Días: Lunes, Miércoles, Viernes \r\n Sentadillas: 3x12 \r\nPress de pecho: 3x12 \r\nJalón al pecho: 3x12 \r\nCurl de bíceps: 3x12 \r\nAbdominales: 3x15', '2026-06-23 19:37:10'),
(2, 32, 'Adaptación Inicial', '\r\nLunes – Pecho y Tríceps\r\n\r\nPress de banca – 3×12\r\n\r\nPress inclinado – 3×12\r\n\r\nAperturas con mancuernas – 3×15\r\n\r\nFondos asistidos – 3×10\r\n\r\nExtensión de tríceps – 3×12\r\n\r\n\r\nMiércoles – Espalda y Bíceps\r\n\r\nJalón al pecho – 3×12\r\n\r\nRemo sentado – 3×12\r\n\r\nRemo con mancuerna – 3×10\r\n\r\nCurl con barra – 3×12\r\n\r\nCurl martillo – 3×12\r\n\r\n\r\nViernes – Piernas\r\n\r\nSentadilla – 4×10\r\n\r\nPrensa – 3×12\r\n\r\nCurl femoral – 3×12\r\n\r\nExtensión de piernas – 3×15\r\n\r\nPantorrillas – 4×15', '2026-07-02 15:19:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rol` enum('Administrador','Recepcionista') NOT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `nombre`, `rol`, `estado`, `fecha_registro`) VALUES
(17, 'fiorela', '$2y$10$HMhmqkCSmhYEHsAC6r0NKuEhDoVoJyn6f22vU1RMGOloEXa/IeMRm', 'Fiorela', 'Administrador', 'Activo', '2026-06-29 19:18:20'),
(20, 'brenda', '$2y$10$il1Nb0Y8QAVmsehiLkmeL.H.hfsLP4jic7olZIkx99VRM/LOkdxdS', 'Brenda', 'Recepcionista', 'Activo', '2026-06-30 04:19:21'),
(21, 'nataly', '$2y$10$WK5yToWFd4C4CDey8Dopt.nb8mOXO0VUayHJDx1uon8l6mt96Qn0G', 'Natali G.', 'Recepcionista', 'Activo', '2026-06-30 04:43:59'),
(24, 'recep2', '$2y$10$X1piAr1Lipyb7pHgF1HCYuWHns4MxtnR1aLe4uJlxdqdqN1bPj0Gi', 'Anahi P.', 'Recepcionista', 'Activo', '2026-07-01 21:27:53'),
(25, 'recep3', '$2y$10$mlEo4WyfansEslzpJG6E5eCJCv7NO1OcfTNOf9BwCo81ETR37BYNW', 'Juan', 'Recepcionista', 'Activo', '2026-07-02 14:20:59'),
(26, 'yessmi', '$2y$10$r49nX0CUOMtHD1b5UteCaeAAtwyny4Bd4ioXQH.xW2qLRW7v5c3Tq', 'Yesmi', 'Recepcionista', 'Activo', '2026-07-02 15:13:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `rol`, `estado`) VALUES
(1, 'Fiorela', '2905', 'Admin', 'Activo'),
(2, 'Nataly', '2003', 'recepcionista', 'Activo'),
(3, 'julio sanchez', '60123485', 'Cliente', 'Activo'),
(4, 'alexandra mamani torres', '60762598', 'Cliente', 'Activo'),
(5, 'rosa yanos mamani', '60762597', 'Cliente', 'Activo'),
(7, 'juan pablo', '26356987', 'Cliente', 'Activo'),
(8, 'guian franco', '26357987', 'Cliente', 'Activo'),
(9, 'brenda quispe', '60670550', 'Cliente', 'Activo'),
(10, 'carmen mamani', '60670550', 'Cliente', 'Activo'),
(11, 'gyan salazar', '06398528', 'Cliente', 'Activo'),
(12, 'alison yudith sanchez', '63256987', 'Cliente', 'Activo'),
(13, 'andre sebastian salas', '60369852', 'Cliente', 'Activo'),
(14, 'allison samira anco', '89653214', 'Cliente', 'Activo'),
(15, 'stiven andre quispe', '02365987', 'Cliente', 'Activo'),
(16, 'oscar rodriguez', '60498628', 'Cliente', 'Activo'),
(17, 'gustavo jhon', '77789630', 'Cliente', 'Activo'),
(18, 'ander perez', '63698527', 'Cliente', 'Activo'),
(19, 'david', '60065425', 'Cliente', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` varchar(50) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Completada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total`, `fecha`, `metodo_pago`, `cliente_id`, `estado`) VALUES
(1, 225.00, '2026-06-23 20:01:53', 'Efectivo', 1, 'Completada'),
(2, 45.00, '2026-06-23 20:02:42', 'Efectivo', 1, 'Completada'),
(3, 17.00, '2026-06-24 23:15:46', 'Yape', 9, 'Completada'),
(4, 19.00, '2026-06-25 09:58:48', 'Yape', 3, 'Completada'),
(5, 101.50, '2026-06-29 00:53:20', 'Efectivo', 7, 'Completada'),
(6, 146.50, '2026-06-29 00:56:41', 'Tarjeta', 1, 'Completada'),
(7, 145.00, '2026-06-29 00:59:34', 'Transferencia', 8, 'Completada'),
(8, 17.00, '2026-06-29 01:00:18', 'Efectivo', 3, 'Completada'),
(9, 145.00, '2026-06-29 01:08:58', 'Efectivo', 7, 'Completada'),
(10, 145.00, '2026-06-29 01:11:18', 'Efectivo', 6, 'Completada'),
(11, 45.00, '2026-06-29 03:29:08', 'Yape', 8, 'Completada'),
(12, 1.50, '2026-06-29 03:29:29', 'Efectivo', 14, 'Anulada'),
(13, 17.00, '2026-06-29 03:31:41', 'Efectivo', 21, 'Completada'),
(14, 27.00, '2026-06-29 03:36:02', 'Efectivo', 9, 'Completada'),
(15, 108.50, '2026-06-29 04:03:43', 'Efectivo', 11, 'Completada'),
(16, 10.00, '2026-06-29 04:05:53', 'Yape', 3, 'Anulada'),
(17, 45.00, '2026-06-29 04:07:14', 'Transferencia', 13, 'Anulada'),
(18, 45.00, '2026-06-29 15:50:40', 'Tarjeta', 13, 'Anulada'),
(19, 2.80, '2026-06-30 03:59:00', 'Yape', 22, 'Completada'),
(20, 2.80, '2026-06-30 05:44:45', 'Yape', 1, 'Completada'),
(21, 90.00, '2026-06-30 05:50:33', 'Efectivo', 13, 'Completada'),
(22, 36.50, '2026-06-30 06:21:52', 'Efectivo', 22, 'Completada'),
(23, 1.50, '2026-06-30 06:22:47', 'Efectivo', 13, 'Completada'),
(24, 5.70, '2026-06-30 07:10:09', 'Efectivo', 11, 'Completada'),
(25, 98.40, '2026-06-30 13:17:31', 'Efectivo', 7, 'Completada'),
(26, 86.30, '2026-07-01 01:21:42', 'Efectivo', 7, 'Completada'),
(27, 45.00, '2026-07-01 01:24:45', 'Efectivo', 5, 'Completada'),
(28, 89.90, '2026-07-01 01:36:31', 'Efectivo', 10, 'Completada'),
(29, 17.50, '2026-07-01 01:45:04', 'Efectivo', 11, 'Completada'),
(30, 17.50, '2026-07-01 21:01:24', 'Efectivo', 7, 'Completada'),
(31, 98.90, '2026-07-01 21:22:19', 'Yape', 3, 'Completada'),
(32, 229.80, '2026-07-01 21:30:36', 'Transferencia', 24, 'Completada'),
(33, 1.50, '2026-07-01 23:38:45', 'Yape', 22, 'Completada'),
(34, 8.00, '2026-07-02 02:22:19', 'Yape', NULL, 'Completada'),
(35, 2.60, '2026-07-02 02:58:17', 'Yape', 26, 'Completada'),
(36, 89.90, '2026-07-02 04:05:26', 'Yape', 24, 'Completada'),
(37, 7.00, '2026-07-02 04:16:06', 'Efectivo', 9, 'Completada'),
(38, 15.00, '2026-07-02 04:31:20', 'Plin', NULL, 'Completada'),
(39, 1.30, '2026-07-02 14:13:03', 'Efectivo', 26, 'Completada'),
(40, 15.00, '2026-07-02 14:16:44', 'Yape', NULL, 'Completada'),
(41, 15.00, '2026-07-02 14:38:33', 'Transferencia', NULL, 'Completada'),
(42, 15.00, '2026-07-02 15:25:25', 'Transferencia', NULL, 'Completada'),
(43, 108.90, '2026-07-02 15:31:58', 'Yape', 32, 'Completada');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clases_diarias`
--
ALTER TABLE `clases_diarias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastos_caja`
--
ALTER TABLE `gastos_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `membresias`
--
ALTER TABLE `membresias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `membresias_clientes`
--
ALTER TABLE `membresias_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil_cliente`
--
ALTER TABLE `perfil_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `planes_membresia`
--
ALTER TABLE `planes_membresia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indices de la tabla `progreso_cliente`
--
ALTER TABLE `progreso_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_ventas_diarias`
--
ALTER TABLE `reporte_ventas_diarias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fecha` (`fecha`);

--
-- Indices de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clases_diarias`
--
ALTER TABLE `clases_diarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `gastos_caja`
--
ALTER TABLE `gastos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `membresias`
--
ALTER TABLE `membresias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `membresias_clientes`
--
ALTER TABLE `membresias_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `perfil_cliente`
--
ALTER TABLE `perfil_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `planes_membresia`
--
ALTER TABLE `planes_membresia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `progreso_cliente`
--
ALTER TABLE `progreso_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `reporte_ventas_diarias`
--
ALTER TABLE `reporte_ventas_diarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gastos_caja`
--
ALTER TABLE `gastos_caja`
  ADD CONSTRAINT `gastos_caja_ibfk_1` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`),
  ADD CONSTRAINT `gastos_caja_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
