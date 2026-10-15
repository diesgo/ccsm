-- ============================================================
-- CCSM · Esquema de PRODUCCIÓN (limpio, sin datos de prueba)
-- Generado a partir de bbdd.sql: mantiene la estructura completa
-- y solo conserva los catálogos de sistema (países, géneros, roles,
-- impuestos, destinos, ajustes...). Las tablas de negocio (socios,
-- productos, ventas, compras, usuarios, etc.) se crean VACÍAS.
--
-- Este archivo lo ejecuta automáticamente el instalador (/install.php).
-- No contiene CREATE DATABASE: se aplica sobre la base de datos ya
-- creada y seleccionada por el instalador.
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `categorias` (
  `id_categoria` int(9) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_categoria` varchar(40) DEFAULT NULL,
  `icono` varchar(40) NOT NULL DEFAULT '',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `servicio_id` int(9) NOT NULL DEFAULT 2,
  `date_add_categoria` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_categoria` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(9) NOT NULL,
  `date_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `proveedor_id` int(9) NOT NULL,
  `producto_id` int(9) NOT NULL,
  `pcm` decimal(9,2) NOT NULL,
  `unidades` int(9) NOT NULL,
  `iva` int(9) NOT NULL,
  `subtotal` decimal(9,2) NOT NULL,
  `total` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_sistema`
--

CREATE TABLE `configuracion_sistema` (
  `id_config` int(11) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion_sistema`
--

INSERT INTO `configuracion_sistema` (`id_config`, `clave`, `valor`, `descripcion`) VALUES
(1, 'imprimir_ticket_termico', '1', 'Habilita la simulación e impresión de tickets térmicos de mostrador (80mm).'),
(2, 'generar_factura_pdf', '1', 'Habilita la exportación e impresión de facturas simplificadas en tamaño folio (A4).'),
(3, 'margen_beneficio', '30', 'Porcentaje de beneficio sobre el precio de compra para calcular el precio orientativo de venta.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id_cuota` int(11) NOT NULL,
  `nombre_cuota` varchar(100) NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delete_products`
--

CREATE TABLE `delete_products` (
  `id` int(9) NOT NULL,
  `product_id` int(9) NOT NULL,
  `product` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `strain` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `delete` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` float NOT NULL,
  `shop` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id_destino` int(9) NOT NULL,
  `destino` varchar(40) DEFAULT '-',
  `descripcion_destino` text DEFAULT NULL,
  `date_add_destino` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_destino` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id_destino`, `destino`, `descripcion_destino`, `date_add_destino`, `date_upd_destino`) VALUES
(1, 'Dispensario', 'Punto de venta', '2022-03-17 06:17:11', '2025-11-12 16:32:20'),
(2, 'Retirar', 'Sacar productos del stock', '2022-03-30 03:43:08', '2025-11-13 21:43:11'),
(3, 'Almacén central', 'Almacén principal', '2025-11-13 21:50:49', '2025-11-13 21:50:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id_gasto` int(9) NOT NULL,
  `proveedor_id` int(9) DEFAULT 0,
  `tienda` varchar(40) DEFAULT NULL,
  `producto_id` int(9) DEFAULT NULL,
  `articulo` varchar(40) DEFAULT NULL,
  `pcm` decimal(9,2) NOT NULL,
  `unidades` int(9) NOT NULL,
  `impuesto_id` int(9) DEFAULT NULL,
  `total` decimal(9,2) NOT NULL,
  `date_add_gasto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id_genero` int(9) NOT NULL,
  `genero` varchar(40) NOT NULL,
  `signo` varchar(40) NOT NULL,
  `date_add_genero` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_genero` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id_genero`, `genero`, `signo`, `date_add_genero`, `date_upd_genero`) VALUES
(1, 'Hombre', '&#x2642;&#xfe0f;', '2022-02-20 22:52:05', '2022-02-22 09:40:19'),
(2, 'Mujer', '&#x2640;&#xfe0f;', '2022-02-20 22:52:36', '2022-02-22 09:39:52'),
(3, 'Otro', '&#x26a7;&#xfe0f;', '2022-02-20 22:53:10', '2022-02-22 09:41:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iconos`
--

CREATE TABLE `iconos` (
  `id_icono` int(9) NOT NULL,
  `nombre_icono` varchar(40) NOT NULL,
  `icono` varchar(40) NOT NULL,
  `date_add_icono` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_icono` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `iconos`
--

INSERT INTO `iconos` (`id_icono`, `nombre_icono`, `icono`, `date_add_icono`, `date_upd_icono`) VALUES
(1, 'Default', '&#x1f4c1;', '2021-05-07 12:51:03', '2022-02-23 17:30:26'),
(2, 'weed', '&#x1f331;', '2021-05-07 18:39:47', '2022-02-22 09:52:20'),
(3, 'Hash', '&#x1f9f1;', '2021-05-08 07:40:45', '2022-02-22 09:36:43'),
(4, 'snack', ' &#x1f36a;', '2021-05-12 07:26:04', '2022-02-22 09:54:45'),
(5, 'cigar', '&#x1f6ac;', '2021-05-24 19:15:27', '2022-02-22 10:06:56'),
(6, 'Editar', '&#x1f58a;&#xfe0f;', '2022-02-22 09:45:46', '2022-02-22 10:06:12'),
(7, 'Masculino', '&#x2642;&#xfe0f;', '2022-02-22 09:46:46', '2022-02-22 09:46:46'),
(8, 'Femenino', '&#x2640;&#xfe0f;', '2022-02-22 09:47:14', '2022-02-22 09:47:14'),
(9, 'Transgénero', '&#x26a7;&#xfe0f;', '2022-02-22 09:48:08', '2022-02-22 09:48:08'),
(10, 'Bebidas calientes', '&#x2615;', '2022-02-22 09:48:55', '2022-02-22 09:48:55'),
(11, 'Minusvalia', '&#x267f;', '2022-02-22 09:50:09', '2022-02-22 09:50:09'),
(12, 'Paleta', '&#x1f3a8;', '2022-02-22 09:55:19', '2022-02-22 09:55:19'),
(13, 'Ver', '&#x1f441;&#xfe0f;', '2022-02-22 09:56:36', '2022-02-22 09:56:36'),
(14, 'Yen_bill', '&#x1f4b4;', '2022-02-22 09:57:20', '2022-02-22 09:57:35'),
(15, 'dollar_bill', '&#x1f4b5', '2022-02-22 09:57:57', '2022-02-22 09:58:15'),
(16, 'Euro_bill', '&#x1f4b6;', '2022-02-22 09:58:43', '2022-02-22 09:58:43'),
(17, 'Pound_bill', '&#x1f4b7;', '2022-02-22 09:59:08', '2022-02-22 09:59:08'),
(18, 'Balance', '&#x1f4ca;', '2022-02-22 09:59:53', '2022-02-22 10:02:04'),
(19, 'Foto', '&#x1f4f7;', '2022-02-22 10:02:43', '2022-02-22 10:02:43'),
(20, 'Candado y llave', '&#x1f510;', '2022-02-22 10:03:52', '2022-02-22 10:03:52'),
(21, 'Llave', '&#x1f511;', '2022-02-22 10:04:11', '2022-02-22 10:04:11'),
(22, 'Candado cerrado', '&#x1f512;', '2022-02-22 10:04:38', '2022-02-22 10:04:38'),
(23, 'Candado abierto', '&#x1f513;', '2022-02-22 10:04:58', '2022-02-22 10:04:58'),
(24, 'Prohibido menores', '&#x1f51e;', '2022-02-22 10:05:28', '2022-02-22 10:05:28'),
(25, 'regalo', ' &#x1f381;', '2022-02-22 10:16:14', '2022-02-22 10:16:14'),
(26, 'Notas', '&#x1f4dd;', '2022-02-22 10:17:35', '2022-02-22 10:17:35'),
(27, 'Imprimir', '&#x1f5a8;&#xfe0f;', '2022-02-22 10:18:40', '2022-02-22 10:18:40'),
(28, 'papelera', '&#x1f5d1;&#xfe0f;', '2022-02-22 10:19:05', '2022-02-22 10:19:05'),
(29, 'Cocktail', '&#x1f378;', '2022-02-23 17:27:12', '2022-02-23 17:27:12'),
(30, 'Bombilla encendida', '&#x1f4a1;', '2022-02-28 09:30:14', '2022-02-28 09:30:14'),
(31, 'Bombilla on', 'fas fa-lightbulb', '2022-02-28 09:38:32', '2022-02-28 09:38:32'),
(32, 'Bombilla off', 'far fa-lightbulb', '2022-02-28 09:39:13', '2022-02-28 09:39:13'),
(33, 'Archivar', 'fas fa-archive', '2022-02-28 09:39:21', '2022-03-18 21:30:11'),
(34, 'Tropical Drink', '&#x1f379;', '2022-03-14 10:25:35', '2022-03-14 10:25:35'),
(35, 'calabera', '&#x2620;', '2022-03-17 20:24:14', '2022-03-17 20:24:14'),
(36, 'Balanza', 'fas fa-balance-scale', '2022-03-18 21:31:33', '2022-03-18 21:31:33'),
(37, 'Jarra', 'fas fa-beer', '2022-03-18 21:33:07', '2022-03-18 21:33:07'),
(38, 'Caja', 'fas fa-box', '2022-03-18 21:33:07', '2022-03-18 21:33:07'),
(39, 'Caja abierta', 'fas fa-box-open', '2022-03-18 21:34:15', '2022-03-18 21:34:15'),
(40, 'Cajas', 'fas fa-boxes', '2022-03-18 21:34:15', '2022-03-18 21:34:15'),
(41, 'Cannabis', 'fas fa-cannabis', '2022-03-18 21:35:29', '2022-03-18 21:35:29'),
(42, 'Caja registradora', 'fas fa-cash-register', '2022-03-18 21:35:29', '2022-03-18 21:35:29'),
(43, 'café', 'fas fa-coffee', '2022-03-18 21:36:24', '2022-03-18 21:36:24'),
(44, 'Cookie mordida', 'fas fa-cookie-bite', '2022-03-18 21:37:20', '2022-03-18 21:37:20'),
(45, 'cookie', 'fas fa-cookie', '2022-03-18 21:37:20', '2022-03-18 21:37:20'),
(46, 'CSS 3', 'fab fa-css3', '2022-03-18 21:38:49', '2022-03-18 21:38:49'),
(47, 'CSS3', 'fab fa-css3-alt', '2022-03-18 21:38:49', '2022-03-18 21:38:49'),
(48, 'Dizzy', 'fas fa-dizzy', '2022-03-18 21:41:01', '2022-03-18 21:41:01'),
(49, 'Ojo', 'far fa-eye', '2022-03-18 21:41:01', '2022-03-18 21:41:01'),
(50, 'Ojo tachado', 'far fa-eye-slash', '2022-03-18 21:42:05', '2022-03-18 21:42:05'),
(51, 'Female', 'fas fa-female', '2022-03-18 21:42:05', '2022-03-18 21:42:05'),
(52, 'Regalo', 'fas fa-gift', '2022-03-18 21:45:16', '2022-03-18 21:45:16'),
(53, 'Joint', 'fas fa-joint', '2022-03-18 21:45:16', '2022-03-18 21:45:16'),
(54, 'Male', 'fas fa-male', '2022-03-18 21:48:23', '2022-03-18 21:48:23'),
(55, 'Seeding', 'fas fa-seedling', '2022-03-18 21:48:23', '2022-03-18 21:48:23'),
(56, 'Smoking', 'fas fa-smoking', '2022-03-18 21:50:17', '2022-03-18 21:50:17'),
(57, 'Transgender', 'fas fa-transgender-alt', '2022-03-18 21:50:17', '2022-03-18 21:50:17'),
(58, 'in', 'fas fa-sign-in-alt', '2022-03-27 18:36:05', '2022-03-27 18:36:05'),
(59, 'out', 'fas fa-sign-out-alt', '2022-03-27 18:36:56', '2022-03-27 18:36:56'),
(60, 'Times', 'fas fa-times', '2022-04-07 20:23:32', '2022-04-07 20:23:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `id_impuesto` int(9) NOT NULL,
  `impuesto` varchar(40) NOT NULL,
  `valor` int(9) NOT NULL,
  `date_add_impuesto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`id_impuesto`, `impuesto`, `valor`, `date_add_impuesto`) VALUES
(1, 'ES Books Rate (4%)', 4, '2025-11-14 01:24:43'),
(2, 'ES Foodstuff Rate (4%)', 4, '2025-11-14 01:24:43'),
(3, 'ES Reduced Rate (10%)', 10, '2025-11-14 01:25:20'),
(4, 'ES Standard rate (21%)', 21, '2025-11-14 01:25:20'),
(5, 'ES Super Reduced Rate (4%)', 4, '2025-11-14 01:26:22'),
(6, 'EU VAT For Virtual Products', 21, '2025-11-14 01:26:22'),
(7, 'Sin impuestos', 0, '2025-11-14 01:26:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornadas`
--

CREATE TABLE `jornadas` (
  `id_jornada` int(9) NOT NULL,
  `fecha_apertura` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_cierre` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `saldo_apertura` float NOT NULL DEFAULT 0,
  `saldo_cierre` float NOT NULL,
  `diferencia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_stock`
--

CREATE TABLE `movimientos_stock` (
  `id_movimiento` int(9) NOT NULL,
  `proveedor_id` int(9) DEFAULT 1,
  `producto_id` int(9) NOT NULL,
  `stock_antes` float DEFAULT NULL,
  `unidades` float DEFAULT 0,
  `retirada` float DEFAULT 0,
  `destino_id` int(9) DEFAULT 1,
  `stock_despues` float DEFAULT NULL,
  `pcm` float DEFAULT 0,
  `date_add_movimiento_stock` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id_pais` int(9) NOT NULL,
  `pais` varchar(40) NOT NULL,
  `bandera` varchar(255) NOT NULL,
  `date_add_pais` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `pais`, `bandera`, `date_add_pais`) VALUES
(1, 'Afganistán', '&#x1f1e6;&#x1f1eb; ', '2021-06-07 12:56:17'),
(2, 'Albania', '&#x1f1e6;&#x1f1f1;', '2021-06-07 12:56:17'),
(3, 'Alemania', '&#x1f1e9;&#x1f1ea;', '2021-06-07 12:56:17'),
(4, 'Andorra', '&#x1f1e6;&#x1f1e9;', '2021-06-07 12:56:17'),
(5, 'Angola', '&#x1f1e6;&#x1f1f4;', '2021-06-07 12:56:17'),
(6, 'Anguilla', '&#x1f1e6;&#x1f1ee;', '2021-06-07 12:56:17'),
(7, 'Antártida', '&#x1f1e6;&#x1f1f6;', '2021-06-07 12:56:17'),
(8, 'Antigua y Barbuda', '&#x1f1e6;&#x1f1ec;', '2021-06-07 12:56:17'),
(9, 'Antillas Holandesas', '&#x1f1e7;&#x1f1f6;', '2021-06-07 12:56:17'),
(10, 'Arabia Saudí', '&#x1f1f8;&#x1f1e6;', '2021-06-07 12:56:17'),
(11, 'Argelia', '&#x1f1e9;&#x1f1ff;', '2021-06-07 12:56:17'),
(12, 'Argentina', '&#x1f1e6;&#x1f1f7;', '2021-06-07 12:56:17'),
(13, 'Armenia', '&#x1f1e6;&#x1f1f2;', '2021-06-07 12:56:17'),
(14, 'Aruba', '&#x1f1e6;&#x1f1fc;', '2021-06-07 12:56:17'),
(15, 'Australia', '&#x1f1e6;&#x1f1fa;', '2021-06-07 12:56:17'),
(16, 'Austria', '&#x1f1e6;&#x1f1f9;', '2021-06-07 12:56:17'),
(17, 'Arzebaiyan ', '&#x1f1e6;&#x1f1ff;', '2021-06-07 12:56:17'),
(18, 'Bahamas', '&#x1f1e7;&#x1f1f8;', '2021-06-07 12:56:17'),
(19, 'Bahrein', '&#x1f1e7;&#x1f1ed;', '2021-06-07 12:56:17'),
(20, 'Bangladesh', '&#x1f1e7;&#x1f1e9;', '2021-06-07 12:56:17'),
(21, 'Barbados', '&#x1f1e7;&#x1f1e7;', '2021-06-07 12:56:17'),
(22, 'Bélgica', '&#x1f1e7;&#x1f1ea;', '2021-06-07 12:56:17'),
(23, 'Belice', '&#x1f1e7;&#x1f1ff;', '2021-06-07 12:56:17'),
(24, 'Benin', '&#x1f1e7;&#x1f1ef;', '2021-06-07 12:56:17'),
(25, 'Bermudas', '&#x1f1e7;&#x1f1f2;', '2021-06-07 12:56:17'),
(26, 'Bhutan', '&#x1f1e7;&#x1f1f9;', '2021-06-07 12:56:17'),
(27, 'Bielorusia', '&#x1f1e7;&#x1f1fe;', '2021-06-07 12:56:17'),
(28, 'Birmania', '&#x1f1f2;&#x1f1f2;', '2021-06-07 12:56:17'),
(29, 'Bolivia', '&#x1f1e7;&#x1f1f4;', '2021-06-07 12:56:17'),
(30, 'Bosnia y Herzegovina', '&#x1f1e7;&#x1f1e6;', '2021-06-07 12:56:17'),
(31, 'Botsuana', '&#x1f1e7;&#x1f1fc;', '2021-06-07 12:56:17'),
(32, 'Brasil', '&#x1f1e7;&#x1f1f7;', '2021-06-07 12:56:17'),
(33, 'Brunei', '&#x1f1e7;&#x1f1f3;', '2021-06-07 12:56:17'),
(34, 'Bulgaria', '&#x1f1e7;&#x1f1ec;', '2021-06-07 12:56:17'),
(35, 'Burkina Faso', '&#x1f1e7;&#x1f1eb;', '2021-06-07 12:56:17'),
(36, 'Burundi', '&#x1f1e7;&#x1f1ee;', '2021-06-07 12:56:17'),
(37, 'Cabo Verde', '&#x1f1e8;&#x1f1fb;', '2021-06-07 12:56:17'),
(38, 'Camboya', '&#x1f1f0;&#x1f1ed;', '2021-06-07 12:56:17'),
(39, 'Camerún', '&#x1f1e8;&#x1f1f2;', '2021-06-07 12:56:17'),
(40, 'Canada', '&#x1f1e8;&#x1f1e6;', '2021-06-07 12:56:17'),
(41, 'Chad', '&#x1f1f9;&#x1f1e9;', '2021-06-07 12:56:17'),
(42, 'Chequia', '&#x1f1e8;&#x1f1ff;', '2021-06-07 16:31:52'),
(43, 'Chile', '&#x1f1e8;&#x1f1f1;', '2021-06-07 12:56:17'),
(44, 'China', '&#x1f1e8;&#x1f1f3;', '2021-06-07 12:56:17'),
(45, 'Chipre', '&#x1f1e8;&#x1f1fe;', '2021-06-07 12:56:17'),
(46, 'Ciudad del Vaticano', '&#x1f1fb;&#x1f1e6;', '2021-06-07 12:56:17'),
(47, 'Colombia', '&#x1f1e8;&#x1f1f4;', '2021-06-07 12:56:17'),
(48, 'Comores', '&#x1f1f0;&#x1f1f2;', '2021-06-07 12:56:17'),
(49, 'Congo - Kinhasa', '&#x1f1e8;&#x1f1e9;', '2021-06-07 16:34:52'),
(50, 'Corea del Norte', '&#x1f1f0;&#x1f1f5;', '2021-06-07 12:56:17'),
(51, 'Corea del Sur', '&#x1f1f0;&#x1f1f7;', '2021-06-07 12:56:17'),
(52, 'Costa de Marfil', '&#x1f1e8;&#x1f1ee;', '2021-06-07 12:56:17'),
(53, 'Costa Rica', '&#x1f1e8;&#x1f1f7;', '2021-06-07 12:56:17'),
(54, 'Croacia', '&#x1f1ed;&#x1f1f7;', '2021-06-07 12:56:17'),
(55, 'Cuba', '&#x1f1e8;&#x1f1fa;', '2021-06-07 12:56:17'),
(56, 'Dinamarca', '&#x1f1e9;&#x1f1f0;', '2021-06-07 12:56:17'),
(57, 'Dominica', '&#x1f1e9;&#x1f1f2;', '2021-06-07 12:56:17'),
(58, 'Ecuador', '&#x1f1ea;&#x1f1e8;', '2021-06-07 12:56:17'),
(59, 'Egipto', '&#x1f1ea;&#x1f1ec;', '2021-06-07 12:56:17'),
(60, 'El Salvador', '&#x1f1f8;&#x1f1fb;', '2021-06-07 12:56:17'),
(61, 'Emiratos Árabes Unidos', '&#x1f1e6;&#x1f1ea;', '2021-06-07 12:56:17'),
(62, 'England', '&#x1f3f4;&#xe0067;&#xe0062;&#xe0065;&#xe006e;&#xe0067;&#xe007f;', '0000-00-00 00:00:00'),
(63, 'Eritrea', '&#x1f1ea;&#x1f1f7;', '2021-06-07 12:56:17'),
(64, 'Eslovaquia', '&#x1f1f8;&#x1f1f0;', '2021-06-07 12:56:17'),
(65, 'Eslovenia', '&#x1f1f8;&#x1f1ee;', '2021-06-07 12:56:17'),
(66, 'España', '&#x1f1ea;&#x1f1f8;', '2021-06-07 12:56:17'),
(67, 'Estados Unidos', '&#x1f1fa;&#x1f1f8;', '2021-06-07 12:56:17'),
(68, 'Estonia', '&#x1f1ea;&#x1f1ea;', '2021-06-07 12:56:17'),
(69, 'Etiopia', '&#x1f1ea;&#x1f1f9;', '2021-06-07 12:56:17'),
(70, 'Filipinas', '&#x1f1f5;&#x1f1ed;', '2021-06-07 12:56:17'),
(71, 'Francia', '&#x1f1eb;&#x1f1f7;', '2021-06-07 12:56:17'),
(72, 'Finlandia', '&#x1f1eb;&#x1f1ee;', '2021-06-07 12:56:17'),
(73, 'Gabon', '&#x1f1ec;&#x1f1e6;', '2021-06-07 12:56:17'),
(74, 'Gambia', '&#x1f1ec;&#x1f1f2;', '2021-06-07 12:56:17'),
(75, 'Georgia', '&#x1f1ec;&#x1f1ea;', '2021-06-07 12:56:17'),
(76, 'Georgia del Sur', '&#x1f1ec;&#x1f1f8;', '2021-06-07 12:56:17'),
(77, 'Ghana', '&#x1f1ec;&#x1f1ed;', '2021-06-07 12:56:17'),
(78, 'Gibraltar', '&#x1f1ec;&#x1f1ee;', '2021-06-07 12:56:17'),
(79, 'Granada', '&#x1f1ec;&#x1f1e9;', '2021-06-07 12:56:17'),
(80, 'Grecia', '&#x1f1ec;&#x1f1f7;', '2021-06-07 12:56:17'),
(81, 'Groenlandia', '&#x1f1ec;&#x1f1f1;', '2021-06-07 12:56:17'),
(82, 'Guadalupe', '&#x1f1ec;&#x1f1f5;', '2021-06-07 12:56:17'),
(83, 'Guam', '&#x1f1ec;&#x1f1fa;', '2021-06-07 12:56:17'),
(84, 'Guatemala', '&#x1f1ec;&#x1f1f9;', '2021-06-07 12:56:17'),
(85, 'Guayana', '&#x1f1ec;&#x1f1fe;', '2021-06-07 12:56:17'),
(86, 'Guayana Francesa', '&#x1f1ec;&#x1f1eb;', '2021-06-07 12:56:17'),
(87, 'Guinea', '&#x1f1ec;&#x1f1f3;', '2021-06-07 12:56:17'),
(88, 'Guinea Ecuatorial', '&#x1f1ec;&#x1f1f6;', '2021-06-07 12:56:17'),
(89, 'Guinea Bissau', '&#x1f1ec;&#x1f1fc;', '2021-06-07 12:56:17'),
(90, 'Haiti', '&#x1f1ed;&#x1f1f9;', '2021-06-07 12:56:17'),
(91, 'Holanda', '&#x1f1f3;&#x1f1f1;', '2021-06-07 12:56:17'),
(92, 'Honduras', '&#x1f1ed;&#x1f1f3;', '2021-06-07 12:56:17'),
(93, 'Hong Kong', '&#x1f1ed;&#x1f1f0;', '2021-06-07 12:56:17'),
(94, 'Hungría', '&#x1f1ed;&#x1f1fa;', '2021-06-07 12:56:17'),
(95, 'India', '&#x1f1ee;&#x1f1f3;', '2021-06-07 12:56:17'),
(96, 'Indonesia', '&#x1f1ee;&#x1f1e9;', '2021-06-07 12:56:17'),
(97, 'Irak', '&#x1f1ee;&#x1f1f6;', '2021-06-07 12:56:17'),
(98, 'Iran', '&#x1f1ee;&#x1f1f7;', '2021-06-07 12:56:17'),
(99, 'Irlanda', '&#x1f1ee;&#x1f1ea;', '2021-06-07 12:56:17'),
(100, 'Isla Heard e Islas Mcdonald', '&#x1f1ed;&#x1f1f2;', '2021-06-07 13:05:55'),
(101, 'Islandia', '&#x1f1ee;&#x1f1f8;', '2021-06-07 13:05:55'),
(102, 'Islas Aland', '&#x1f1e6;&#x1f1fd;', '2021-06-22 16:45:54'),
(103, 'Islas Caimán', '&#x1f1f0;&#x1f1fe;', '2021-06-07 14:11:48'),
(104, 'Islas Cook', '&#x1f1e8;&#x1f1f0;', '2021-06-07 14:11:48'),
(105, 'Islas de Cocos', '&#x1f1e8;&#x1f1e8;', '2021-06-07 14:14:08'),
(106, 'Islas Feroe', '&#x1f1eb;&#x1f1f4;', '2021-06-07 14:14:08'),
(107, 'Fiji', '&#x1f1eb;&#x1f1ef;', '2021-06-07 14:25:22'),
(108, 'Islas Malvinas', '&#x1f1eb;&#x1f1f0;', '2021-06-07 14:25:22'),
(109, 'Islas Marianas', '&#x1f1f2;&#x1f1f5;', '2021-06-07 14:28:08'),
(110, 'Islas Marshall', '&#x1f1f2;&#x1f1ed;', '2021-06-07 14:28:08'),
(111, 'Islas Menores USA', '&#x1f1fa;&#x1f1f2;', '2021-06-07 14:30:35'),
(112, 'Islas Pitcairn', '&#x1f1f5;&#x1f1f3;', '2021-06-07 16:27:47'),
(113, 'Islas Salomon', '&#x1f1f8;&#x1f1e7;', '2021-06-07 14:31:45'),
(114, 'Islas Turcas y Caicos', '&#x1f1f9;&#x1f1e8;', '2021-06-07 14:34:05'),
(115, 'Islas Vírgenes USA', '&#x1f1fb;&#x1f1ee;', '2021-06-07 14:34:05'),
(116, 'Islas Vírgenes Británicas', '&#x1f1fb;&#x1f1ec;', '2021-06-07 14:35:57'),
(117, 'Israel', '&#x1f1ee;&#x1f1f1;', '2021-06-07 14:35:57'),
(118, 'Italia', '&#x1f1ee;&#x1f1f9;', '2021-06-07 14:38:15'),
(119, 'Jamaica', '&#x1f1ef;&#x1f1f2;', '2021-06-07 14:38:15'),
(120, 'Japón', '&#x1f1ef;&#x1f1f5;', '2021-06-07 14:40:01'),
(121, 'Jolly Rogers', '&#x1f3f4;&#x200d;&#x2620;&#xfe0f;', '0000-00-00 00:00:00'),
(122, 'Jordania', '&#x1f1ef;&#x1f1f4;', '2021-06-07 14:40:01'),
(123, 'Kazajistśn', '&#x1f1f0;&#x1f1ff;', '2021-06-07 14:47:02'),
(124, 'Kenia', '&#x1f1f0;&#x1f1ea;', '2021-06-07 14:47:02'),
(125, 'Kirguizistan', '&#x1f1f0;&#x1f1ec;', '2021-06-07 14:49:39'),
(126, 'Kiribati', '&#x1f1f0;&#x1f1ee;', '2021-06-07 14:49:39'),
(127, 'Kuwait', '&#x1f1f0;&#x1f1fc;', '2021-06-07 14:50:38'),
(128, 'Laos', '&#x1f1f1;&#x1f1e6;', '2021-06-07 14:50:38'),
(129, 'Lesoto', '&#x1f1f1;&#x1f1f8', '2021-06-07 14:51:55'),
(130, 'Letonia', '&#x1f1f1;&#x1f1fb;', '2021-06-07 14:51:55'),
(131, 'Líbano', '&#x1f1f1;&#x1f1e7;', '2021-06-07 14:53:37'),
(132, 'Liberia', '&#x1f1f1;&#x1f1f7;', '2021-06-07 14:53:37'),
(133, 'Libia', '&#x1f1f1;&#x1f1fe;', '2021-06-07 14:55:05'),
(134, 'Liechtenstein', '&#x1f1f1;&#x1f1ee;', '2021-06-07 14:55:05'),
(135, 'Lituania', '&#x1f1f1;&#x1f1f9;', '2021-06-07 14:56:41'),
(136, 'Luxemburgo', '&#x1f1f1;&#x1f1fa;', '2021-06-07 14:56:41'),
(137, 'Macao', '&#x1f1f2;&#x1f1f4;', '2021-06-07 14:58:33'),
(138, 'Macedonia del norte', '&#x1f1f2;&#x1f1f0;', '2021-06-07 12:56:17'),
(139, 'Madagascar', '&#x1f1f2;&#x1f1ec;', '2021-06-07 14:58:33'),
(140, 'Malasia', '&#x1f1f2;&#x1f1fe;', '2021-06-07 14:59:45'),
(141, 'Malawi', '&#x1f1f2;&#x1f1fc;', '2021-06-07 14:59:45'),
(142, 'Maldivas', '&#x1f1f2;&#x1f1fb;', '2021-06-07 15:01:01'),
(143, 'Mali', '&#x1f1f2;&#x1f1f1;', '2021-06-07 15:01:01'),
(144, 'Malta', '&#x1f1f2;&#x1f1f9;', '2021-06-07 15:03:25'),
(145, 'Marruecos', '&#x1f1f2;&#x1f1e6;', '2021-06-07 15:03:25'),
(146, 'Martinica', '&#x1f1f2;&#x1f1f6;', '2021-06-07 15:05:45'),
(147, 'Mauricio', '&#x1f1f2;&#x1f1fa;', '2021-06-07 15:05:45'),
(148, 'Mauritania', '&#x1f1f2;&#x1f1f7;', '2021-06-07 15:09:14'),
(149, 'Mayotte', '&#x1f1fe;&#x1f1f9;', '2021-06-07 15:09:14'),
(150, 'México', '&#x1f1f2;&#x1f1fd;', '2021-06-07 15:09:34'),
(151, 'Micronesia', '&#x1f1eb;&#x1f1f2;', '2021-06-07 15:09:34'),
(152, 'Moldavia', '&#x1f1f2;&#x1f1e9;', '2021-06-07 15:13:11'),
(153, 'Mónaco', '&#x1f1f2;&#x1f1e8;', '2021-06-07 15:13:11'),
(154, 'Mongolia', '&#x1f1f2;&#x1f1f3;', '2021-06-07 15:15:12'),
(155, 'Montserrat', '&#x1f1f2;&#x1f1f8;', '2021-06-07 15:15:12'),
(156, 'Mozambique', '&#x1f1f2;&#x1f1ff;', '2021-06-07 15:21:21'),
(157, 'Namibia', '&#x1f1f3;&#x1f1e6;', '2021-06-07 15:21:21'),
(158, 'Nauru', '&#x1f1f3;&#x1f1f7;', '2021-06-07 15:27:38'),
(159, 'Nepal', '&#x1f1f3;&#x1f1f5;', '2021-06-07 15:27:38'),
(160, 'Nicaragua', '&#x1f1f3;&#x1f1ee;', '2021-06-07 15:47:02'),
(161, 'Niger', '&#x1f1f3;&#x1f1ea;', '2021-06-07 15:47:02'),
(162, 'Nigeria', '&#x1f1f3;&#x1f1ec;', '2021-06-07 15:50:33'),
(163, 'Niue', '&#x1f1f3;&#x1f1fa;', '2021-06-07 15:50:33'),
(164, 'Norfolk', '&#x1f1f3;&#x1f1eb;', '2021-06-07 16:19:47'),
(165, 'Noruega', '&#x1f1f3;&#x1f1f4;', '2021-06-07 16:19:47'),
(166, 'Nueva Caledonia', '&#x1f1f3;&#x1f1e8;', '2021-06-07 16:23:13'),
(167, 'Nueva Zelanda', '&#x1f1f3;&#x1f1ff;', '2021-06-07 16:23:13'),
(168, 'Omán', '&#x1f1f4;&#x1f1f2;', '2021-06-07 16:24:05'),
(169, 'Palau', '&#x1f1f5;&#x1f1fc', '2021-06-07 14:30:35'),
(170, 'Panamá', '&#x1f1f5;&#x1f1e6;', '2021-06-07 16:24:05'),
(171, 'Papua Nueva Guinea', '&#x1f1f5;&#x1f1ec;', '2021-06-07 16:25:41'),
(172, 'Paquistán', '&#x1f1f5;&#x1f1f0;', '2021-06-07 16:25:41'),
(173, 'Paraguay', '&#x1f1f5;&#x1f1fe;', '2021-06-07 16:26:36'),
(174, 'Perú', '&#x1f1f5;&#x1f1ea;', '2021-06-07 16:26:36'),
(175, 'Polinesia Francesa', '&#x1f1f5;&#x1f1eb;', '2021-06-07 16:27:47'),
(176, 'Polonia', '&#x1f1f5;&#x1f1f1;', '2021-06-07 16:28:34'),
(177, 'Portugal', '&#x1f1f5;&#x1f1f9;', '2021-06-07 16:28:34'),
(178, 'Puerto Rico', '&#x1f1f5;&#x1f1f7;', '2021-06-07 16:29:00'),
(179, 'Qatar', '&#x1f1f6;&#x1f1e6;', '2021-06-07 16:29:00'),
(180, 'Rainow Flag', '&#x1f3f3;&#xfe0f;&#x200d;&#x1f308;', '0000-00-00 00:00:00'),
(181, 'Reino Unido', '&#x1f1ec;&#x1f1e7;', '2021-06-07 16:30:38'),
(182, 'Republica Centroafricana', '&#x1f1e8;&#x1f1eb;', '2021-06-07 16:30:38'),
(183, 'Republica de Sudáfrica', '&#x1f1ff;&#x1f1e6;', '2021-06-07 16:31:52'),
(184, 'República del Congo', '&#x1f1e8;&#x1f1ec;', '2021-06-07 12:56:17'),
(185, 'República Dominicana', '&#x1f1e9;&#x1f1f4;', '2021-06-07 16:34:52'),
(186, 'Reunión', '&#x1f1f7;&#x1f1ea;', '2021-06-07 16:36:07'),
(187, 'Ruanda', '&#x1f1f7;&#x1f1fc;', '2021-06-07 16:36:07'),
(188, 'Rumania', '&#x1f1f7;&#x1f1f4;', '2021-06-07 16:37:07'),
(189, 'Rusia', '&#x1f1f7;&#x1f1fa;', '2021-06-07 16:37:07'),
(190, 'Samoa USA', '&#x1f1e6;&#x1f1f8;', '2021-06-07 16:37:07'),
(191, 'Samoa', '&#x1f1fc;&#x1f1f8;', '2021-06-07 16:40:27'),
(192, 'San Cristobal y Nieves', '&#x1f1f0;&#x1f1f3;', '2021-06-07 16:40:27'),
(193, 'San Marino', '&#x1f1f8;&#x1f1f2;', '2021-06-07 16:41:51'),
(194, 'San Pierre y Miquelón', '&#x1f1f5;&#x1f1f2;', '2021-06-07 16:41:51'),
(195, 'San Vicente e Islas Granadinas', '&#x1f1fb;&#x1f1e8;', '2021-06-07 16:44:11'),
(196, 'Santa Helena', '&#x1f1f8;&#x1f1ed;', '2021-06-07 16:44:11'),
(197, 'Santa Lucía', '&#x1f1f1;&#x1f1e8;', '2021-06-07 16:45:36'),
(198, 'Santo Tome y Principe', '&#x1f1f8;&#x1f1f9;', '2021-06-07 16:45:36'),
(199, 'Scotland', '&#x1f3f4;&#xe0067;&#xe0062;&#xe0073;&#xe0063;&#xe0074;&#xe007f;', '0000-00-00 00:00:00'),
(200, 'Senegal', '&#x1f1f8;&#x1f1f3;', '2021-06-07 16:46:28'),
(201, 'Servia', '&#x1f1f7;&#x1f1f8;', '2021-06-07 16:46:28'),
(202, 'Seychelles', '&#x1f1f8;&#x1f1e8;', '2021-06-07 16:47:22'),
(203, 'Sierra Leona', '&#x1f1f8;&#x1f1f1;', '2021-06-07 16:47:22'),
(204, 'Singapur', '&#x1f1f8;&#x1f1ec;', '2021-06-07 16:48:35'),
(205, 'Siria', '&#x1f1f8;&#x1f1fe;', '2021-06-07 16:48:35'),
(206, 'Somalia', '&#x1f1f8;&#x1f1f4;', '2021-06-07 16:48:55'),
(207, 'Sri Lanka', '&#x1f1f1;&#x1f1f0;', '2021-06-07 16:48:55'),
(208, 'Suazilandia', '&#x1f1f8;&#x1f1ff;', '2021-06-07 16:50:05'),
(209, 'Sudán', '&#x1f1f8;&#x1f1e9;', '2021-06-07 16:50:05'),
(210, 'Suecia', '&#x1f1f8;&#x1f1ea;', '2021-06-07 16:50:48'),
(211, 'Suiza', '&#x1f1e8;&#x1f1ed;', '2021-06-07 16:50:48'),
(212, 'Surinam', '&#x1f1f8;&#x1f1f7;', '2021-06-07 16:51:47'),
(213, 'Svalbard', '&#x1f1f8;&#x1f1ef;', '2021-06-07 16:51:47'),
(214, 'Tailandia', '&#x1f1f9;&#x1f1ed;', '2021-06-07 16:57:34'),
(215, 'Taiwan', '&#x1f1f9;&#x1f1fc;', '2021-06-07 16:57:34'),
(216, 'Tanzania', '&#x1f1f9;&#x1f1ff;', '2021-06-07 16:58:34'),
(217, 'Tayikistan', '&#x1f1f9;&#x1f1ef;', '2021-06-07 16:58:34'),
(218, 'Territorios Britanicos del Oceano Índico', '&#x1f1ee;&#x1f1f4;', '2021-06-07 17:02:06'),
(219, 'Territorios Franceses Del Sur', '&#x1f1f9;&#x1f1eb;', '2021-06-07 17:02:06'),
(220, 'Timor Oriental', '&#x1f1f9;&#x1f1f1;', '2021-06-07 17:03:51'),
(221, 'Togo', '&#x1f1f9;&#x1f1ec;', '2021-06-07 17:03:51'),
(222, 'Tokelau', '&#x1f1f9;&#x1f1f0;', '2021-06-07 14:31:45'),
(223, 'Tonga', '&#x1f1f9;&#x1f1f4;', '2021-06-07 17:05:04'),
(224, 'Transgender Flag', '&#x1f3f3;&#xfe0f;&#x200d;&#x26a7;&#xfe0f', '0000-00-00 00:00:00'),
(225, 'Trinidad y Tobago', '&#x1f1f9;&#x1f1f9;', '2021-06-07 17:05:04'),
(226, 'Tunez', '&#x1f1f9;&#x1f1f3;', '2021-06-07 17:06:22'),
(227, 'Turkmenistan', '&#x1f1f9;&#x1f1f2;', '2021-06-07 17:06:22'),
(228, 'Turquía', '&#x1f1f9;&#x1f1f7;', '2021-06-07 17:07:08'),
(229, 'Tuvalu', '&#x1f1f9;&#x1f1fb;', '2021-06-07 17:07:08'),
(230, 'Ucrania', '&#x1f1fa;&#x1f1e6;', '2021-06-07 17:08:00'),
(231, 'Uganda', '&#x1f1fa;&#x1f1ec;', '2021-06-07 17:08:00'),
(232, 'Uruguay', '&#x1f1fa;&#x1f1fe;', '2021-06-07 17:08:45'),
(233, 'Uzbekistan', '&#x1f1fa;&#x1f1ff;', '2021-06-07 17:08:45'),
(234, 'Vanuatu', '&#x1f1fb;&#x1f1fa;', '2021-06-07 17:10:50'),
(235, 'Venezuela', '&#x1f1fb;&#x1f1ea;', '2021-06-07 17:10:50'),
(236, 'Vietnam', '&#x1f1fb;&#x1f1f3;', '2021-06-07 17:23:05'),
(237, 'Wallis y Futuna', '&#x1f1fc;&#x1f1eb;', '2021-06-07 17:23:05'),
(238, 'Wales', '&#x1f3f4;&#xe0067;&#xe0062;&#xe0077;&#xe006c;&#xe0073;&#xe007f;', '0000-00-00 00:00:00'),
(239, 'Yemen', '&#x1f1fe;&#x1f1ea;', '2021-06-07 17:24:27'),
(240, 'Yibuti', '&#x1f1e9;&#x1f1ef;', '2021-06-07 12:56:17'),
(241, 'Zambia', '&#x1f1ff;&#x1f1f2;', '2021-06-07 17:24:27'),
(242, 'Zimbaue', '&#x1f1ff;&#x1f1fc;', '2021-06-07 17:24:27'),
(243, 'Sark', '&#x1f1e8;&#x1f1f6;', '2026-06-21 21:38:10'),
(244, 'Jolly Rogers', '&#x1f3f4;&#x200d;&#x2620;', '2026-06-21 21:41:22'),
(245, 'rainbow flag', '&#x1f3f3;&#xfe0f;&#x200d;&#x1f308;', '2026-06-21 21:41:22'),
(246, 'transgender flag', '&#x1f3f3;&#xfe0f;&#x200d;&#x26a7;', '2026-06-21 21:43:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(9) NOT NULL,
  `perfil` varchar(40) NOT NULL,
  `ver_categorias` tinyint(1) NOT NULL DEFAULT 0,
  `crear_categorias` tinyint(1) NOT NULL DEFAULT 0,
  `edit_categorias` tinyint(1) NOT NULL DEFAULT 0,
  `ver_personal` tinyint(1) NOT NULL DEFAULT 0,
  `crear_personal` tinyint(1) NOT NULL DEFAULT 0,
  `edit_personal` tinyint(1) NOT NULL DEFAULT 0,
  `ver_roles` tinyint(1) NOT NULL DEFAULT 0,
  `crear_roles` tinyint(1) NOT NULL DEFAULT 0,
  `edit_roles` tinyint(1) NOT NULL DEFAULT 0,
  `ver_proveedores` tinyint(1) NOT NULL DEFAULT 0,
  `crear_proveedores` tinyint(1) NOT NULL DEFAULT 0,
  `edit_proveedores` tinyint(1) NOT NULL DEFAULT 0,
  `ver_socios` tinyint(1) NOT NULL DEFAULT 0,
  `crear_socios` tinyint(1) NOT NULL DEFAULT 0,
  `edit_socios` tinyint(1) NOT NULL DEFAULT 0,
  `ver_productos` tinyint(1) NOT NULL DEFAULT 0,
  `crear_productos` tinyint(1) NOT NULL DEFAULT 0,
  `edit_productos` tinyint(1) NOT NULL DEFAULT 0,
  `ver_variedades` tinyint(1) NOT NULL DEFAULT 0,
  `crear_variedades` tinyint(1) NOT NULL DEFAULT 0,
  `edit_variedades` tinyint(1) NOT NULL DEFAULT 0,
  `ver_cuotas` tinyint(1) NOT NULL DEFAULT 0,
  `crear_cuotas` tinyint(1) NOT NULL DEFAULT 0,
  `edit_cuotas` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `perfil`, `ver_categorias`, `crear_categorias`, `edit_categorias`, `ver_personal`, `crear_personal`, `edit_personal`, `ver_roles`, `crear_roles`, `edit_roles`, `ver_proveedores`, `crear_proveedores`, `edit_proveedores`, `ver_socios`, `crear_socios`, `edit_socios`, `ver_productos`, `crear_productos`, `edit_productos`, `ver_variedades`, `crear_variedades`, `edit_variedades`, `ver_cuotas`, `crear_cuotas`, `edit_cuotas`) VALUES
(1, 'administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'colaborador', 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0),
(3, 'ventas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
(4, 'dependiente', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'compras', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(9) NOT NULL,
  `producto` varchar(40) NOT NULL,
  `categoria_id` int(9) NOT NULL,
  `variedad_id` int(9) DEFAULT NULL,
  `bote` float DEFAULT 0,
  `cantidad` float DEFAULT 0,
  `imagen_producto` varchar(40) DEFAULT 'default.png',
  `pvp` decimal(9,2) DEFAULT 0.00,
  `precio_compra` decimal(9,2) DEFAULT NULL,
  `impuesto_id` int(9) DEFAULT 1,
  `dispensario` float DEFAULT 0,
  `visible` tinyint(9) NOT NULL DEFAULT 1,
  `date_add_producto` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_producto` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(9) NOT NULL,
  `proveedor` varchar(40) DEFAULT '-',
  `descripcion_proveedor` text DEFAULT NULL,
  `date_add_proveedor` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_proveedor` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(9) NOT NULL,
  `servicio` varchar(40) DEFAULT NULL,
  `date_add_servicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_upd_servicio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `servicio`, `date_add_servicio`, `date_upd_servicio`) VALUES
(1, 'Granel', '2022-03-26 02:12:58', '2022-03-26 02:12:58'),
(2, 'Unidades', '2022-03-17 06:06:28', '2022-03-17 06:06:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` int(8) NOT NULL,
  `tema` varchar(30) NOT NULL,
  `fuente` varchar(30) NOT NULL,
  `titulos` varchar(30) NOT NULL,
  `date_add_setting` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_setting` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `tema`, `fuente`, `titulos`, `date_add_setting`, `date_upd_setting`) VALUES
(1, 'azul-1', 'arima-madurai', 'comfortaa-bold', '2021-05-21 01:07:38', '2025-10-23 14:01:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id_socio` int(9) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `apellidos` varchar(40) DEFAULT NULL,
  `genero_id` int(9) DEFAULT NULL,
  `card_id` varchar(40) DEFAULT NULL,
  `birth` date NOT NULL DEFAULT current_timestamp(),
  `pais_id` int(9) DEFAULT NULL,
  `cuota_id` int(11) NOT NULL DEFAULT 1,
  `exento` tinyint(1) NOT NULL DEFAULT 0,
  `consumo` float DEFAULT 0,
  `saldo` decimal(9,2) DEFAULT 0.00,
  `imagen_perfil` varchar(25) DEFAULT NULL,
  `idFront` varchar(25) DEFAULT NULL,
  `idBack` varchar(25) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `date_add_socio` date NOT NULL DEFAULT current_timestamp(),
  `date_upd_socio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp_productos`
--

CREATE TABLE `temp_productos` (
  `id_producto` int(9) NOT NULL DEFAULT 0,
  `producto` varchar(40) NOT NULL,
  `categoria_id` int(9) NOT NULL,
  `variedad_id` int(9) DEFAULT NULL,
  `bote` float DEFAULT 0,
  `cantidad` float DEFAULT 0,
  `imagen_producto` varchar(40) DEFAULT 'default.png',
  `pvp` decimal(9,2) DEFAULT 0.00,
  `impuesto_id` int(9) DEFAULT 1,
  `dispensario` float DEFAULT 0,
  `visible` tinyint(9) NOT NULL DEFAULT 1,
  `date_add_producto` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_producto` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(9) UNSIGNED NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `perfil_id` int(9) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `date_add_user` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_user` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variedades`
--

CREATE TABLE `variedades` (
  `id_variedad` int(9) NOT NULL,
  `variedad` varchar(40) DEFAULT NULL,
  `descripcion_variedad` varchar(150) DEFAULT NULL,
  `date_add_variedad` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_upd_variedad` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(9) NOT NULL,
  `socio_id` int(9) NOT NULL,
  `producto_id` int(9) NOT NULL,
  `cantidad` float NOT NULL,
  `total` decimal(9,2) NOT NULL,
  `date_add_venta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `servicio_id` (`servicio_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  ADD PRIMARY KEY (`id_config`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id_cuota`);

--
-- Indices de la tabla `delete_products`
--
ALTER TABLE `delete_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gasto`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD UNIQUE KEY `id_genero` (`id_genero`);

--
-- Indices de la tabla `iconos`
--
ALTER TABLE `iconos`
  ADD PRIMARY KEY (`id_icono`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`id_impuesto`);

--
-- Indices de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  ADD PRIMARY KEY (`id_jornada`);

--
-- Indices de la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `destino_id` (`destino_id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `variedad_id` (`variedad_id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id_socio`),
  ADD KEY `genero_id` (`genero_id`),
  ADD KEY `pais_id_2` (`pais_id`),
  ADD KEY `pais_id` (`pais_id`) USING BTREE,
  ADD KEY `activo` (`activo`),
  ADD KEY `fk_socios_cuotas` (`cuota_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `variedades`
--
ALTER TABLE `variedades`
  ADD PRIMARY KEY (`id_variedad`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `socio_id` (`socio_id`),
  ADD KEY `producto_id` (`producto_id`);


--
-- AUTO_INCREMENT de las tablas volcadas
--

-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `configuracion_sistema`
--
ALTER TABLE `configuracion_sistema`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id_cuota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `delete_products`
--
ALTER TABLE `delete_products`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id_destino` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_gasto` int(9) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id_genero` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT de la tabla `iconos`
--
ALTER TABLE `iconos`
  MODIFY `id_icono` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `id_impuesto` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- AUTO_INCREMENT de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  MODIFY `id_jornada` int(9) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT de la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  MODIFY `id_movimiento` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id_pais` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id_socio` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `variedades`
--
ALTER TABLE `variedades`
  MODIFY `id_variedad` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos_stock`
--
ALTER TABLE `movimientos_stock`
  ADD CONSTRAINT `movimientos_stock_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_stock_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movimientos_stock_ibfk_3` FOREIGN KEY (`destino_id`) REFERENCES `destinos` (`id_destino`);

--
-- Filtros para la tabla `socios`
--
ALTER TABLE `socios`
  ADD CONSTRAINT `fk_socios_cuotas` FOREIGN KEY (`cuota_id`) REFERENCES `cuotas` (`id_cuota`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ventas_socios` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id_socio`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS demo_usos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    token_hash CHAR(64) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL,
    inicio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expira DATETIME NOT NULL,
    fin DATETIME DEFAULT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'activa',
    sugerencias TEXT DEFAULT NULL,
    sugerencias_fecha DATETIME DEFAULT NULL,
    INDEX demo_email_inicio (email, inicio),
    INDEX demo_inicio (inicio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE demo_usos
    ADD COLUMN ultima_actividad DATETIME DEFAULT NULL,
    ADD COLUMN segundos_activos INT UNSIGNED NOT NULL DEFAULT 0,
    ADD COLUMN facilidad TINYINT UNSIGNED DEFAULT NULL,
    ADD COLUMN instalaria VARCHAR(10) DEFAULT NULL;

CREATE TABLE demo_eventos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uso_id BIGINT UNSIGNED NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    seccion VARCHAR(30) NOT NULL,
    accion VARCHAR(40) NOT NULL,
    resultado VARCHAR(15) NOT NULL,
    INDEX demo_eventos_uso (uso_id, id),
    CONSTRAINT demo_eventos_visita FOREIGN KEY (uso_id) REFERENCES demo_usos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE contacto_mensajes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL DEFAULT '',
    email VARCHAR(254) NOT NULL,
    tema VARCHAR(30) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    leido TINYINT NOT NULL DEFAULT 0,
    INDEX contacto_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
