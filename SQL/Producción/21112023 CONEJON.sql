-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-11-2023 a las 14:20:27
-- Versión del servidor: 10.5.19-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u854920720_conejon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoraCaja`
--

CREATE TABLE `bitacoraCaja` (
  `id` int(11) NOT NULL,
  `idTienda` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUsuario` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaApertura` datetime NOT NULL,
  `fechaCierre` datetime DEFAULT NULL,
  `efectivoInicial` decimal(10,2) NOT NULL,
  `totalEfectivoEnCaja` float NOT NULL,
  `efectivoFinal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CAT_estatusPedido`
--

CREATE TABLE `CAT_estatusPedido` (
  `id` int(11) NOT NULL,
  `idEstatus` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `CAT_estatusPedido`
--

INSERT INTO `CAT_estatusPedido` (`id`, `idEstatus`, `nombre`, `isActive`) VALUES
(1, 'EP-1', 'Pedido Recibido', 1),
(2, 'EP-2', 'Pago Confirmado', 1),
(3, 'EP-3', 'En camino', 1),
(4, 'EP-4', 'Entregado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CAT_metodoDePago`
--

CREATE TABLE `CAT_metodoDePago` (
  `id` int(11) NOT NULL,
  `idMetodoDePago` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(1000) NOT NULL,
  `icono` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasOnlinePayment` tinyint(1) NOT NULL DEFAULT 0,
  `hasDeliveryPayment` tinyint(1) NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallePedido`
--

CREATE TABLE `detallePedido` (
  `id` int(11) NOT NULL,
  `idPedido` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idProducto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idTienda` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` float NOT NULL,
  `costoUnitario` float NOT NULL,
  `precioUnitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enviostiendas`
--

CREATE TABLE `enviostiendas` (
  `id` int(11) NOT NULL,
  `idTipoEnvio` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idTienda` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombreEnvio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `precioEnvio` float NOT NULL,
  `hasOnlinePayment` tinyint(1) NOT NULL,
  `hasDeliveryPayment` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expositores`
--

CREATE TABLE `expositores` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `whatsapp` varchar(10) NOT NULL,
  `nombre_negocio` varchar(255) NOT NULL,
  `giro_negocio` varchar(255) DEFAULT NULL,
  `contacto_negocio` varchar(255) DEFAULT NULL,
  `como_te_enteraste` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `expositores`
--

INSERT INTO `expositores` (`id`, `correo`, `nombre`, `whatsapp`, `nombre_negocio`, `giro_negocio`, `contacto_negocio`, `como_te_enteraste`, `fecha_registro`) VALUES
(8, 'axelcoreos@gmail.com', 'asd', '3333333333', 'VENDY', '\r\n', 'jblnjkl', 'jkl', NULL),
(9, 'pankhurst.zoe@yahoo.com', 'Jimmy Pankhurst', '7299606841', 'Jimmy Pankhurst', 'Hi there,\r\nMonthly Seo Services - Professional/ Affordable Seo Services\r\nHire the leading seo marketing company and get your website ranked on search engines. Are you looking to rank your website on search engines? Contact us now to get started - https://', 'Hi there,\r\nMonthly Seo Services - Professional/ Affordable Seo Services\r\nHire the leading seo marketing company and get your website ranked on search engines. Are you looking to rank your website on search engines? Contact us now to get started - https://', 'Vrlpg Vy', NULL),
(10, 'aespinozabgx@gmail.com', 'AXEL ESPINOZA', '5584309008', 'vendy', 'comida\r\n', '', '', NULL),
(11, 'gabriela.rios.h@hotmail.com', 'Gabriela Rios Hernandez ', '5623410905', 'Mamá coneja ', 'Hotel de conejos y venta de productos', '', '', NULL),
(12, 'axelcoreos2@gmail.com', 'asd', '3333333333', 'Instituto Politecnico Nacional', 'hh', '', '', NULL),
(13, 'brendaaudit@hotmail.com', 'Brenda Ramos ', '5532304773', 'Fat Bunny', 'Moda y accesorios ', '', '', NULL),
(14, 'thebunnykingdommx@gmail.com', 'Miguel Lara eseiza ', '4491294011', 'The Bunny Kingdom ', 'Hábitat para conejitos, casitas y castillitos', '', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_egresos_Tienda`
--

CREATE TABLE `ingresos_egresos_Tienda` (
  `id` int(11) NOT NULL,
  `idTienda` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idTipoMovimiento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaMovimiento` datetime NOT NULL,
  `concepto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id` int(11) NOT NULL,
  `idMascota` varchar(200) NOT NULL,
  `imgPerfil` varchar(500) DEFAULT NULL,
  `idOwner` varchar(255) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `raza` varchar(200) DEFAULT NULL,
  `sexo` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `recompensa` float NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id`, `idMascota`, `imgPerfil`, `idOwner`, `nombre`, `fechaNacimiento`, `raza`, `sexo`, `color`, `recompensa`, `isActive`) VALUES
(5, 'MSP3', 'foto.jpg', 'axelcoreos@gmail.com', 'mabel', '2020-11-26', NULL, NULL, NULL, 0, 1),
(6, 'MSP4', 'foto.jpg', 'gabriela.rios.h@hotmail.com', 'Werejo ', '2017-10-05', 'Orejas caidas', 'Macho', 'Beige', 0, 1),
(8, 'MSP6', 'foto.png', 'gabriela.rios.h@hotmail.com', 'Lua Dipa Garritas', '2022-09-08', 'Cabeza de león ', 'Hembra', 'Gris', 0, 1),
(9, 'MSP7', 'foto.jpg', 'usagi.lb23@gmail.com', 'Moon', '2020-06-02', NULL, NULL, NULL, 0, 1),
(10, 'MSP8', 'foto.jpg', 'usagi.lb23@gmail.com', 'Bailey', '2018-05-17', NULL, NULL, NULL, 0, 1),
(11, 'MSP9', 'foto.jpg', 'jennifermendoza458@gmail.com', 'Turín', '2022-08-10', NULL, NULL, NULL, 0, 1),
(12, 'MSP10', 'foto.jpeg', 'vanessa_sg@icloud.com', 'Chilly Willy', '2019-01-10', NULL, NULL, NULL, 0, 1),
(13, 'MSP11', 'foto.jpg', 'miguellaraeseiza@gmail.com', 'Travis', '2022-10-26', NULL, NULL, NULL, 0, 1),
(14, 'MSP12', 'foto.jpg', 'miguellaraeseiza@gmail.com', 'Bello', '2021-07-10', NULL, NULL, NULL, 0, 1),
(15, 'MSP13', 'foto.jpeg', 'miguellaraeseiza@gmail.com', 'Princesita', '2023-10-03', NULL, NULL, NULL, 0, 1),
(16, 'MSP14', 'foto.jpg', 'miguellaraeseiza@gmail.com', 'Pingolin', '2021-07-15', NULL, NULL, NULL, 0, 1),
(17, 'MSP15', 'foto.jpg', 'miguellaraeseiza@gmail.com', 'Grisito ', '2022-05-14', NULL, NULL, NULL, 0, 1),
(19, 'MSP16', 'foto.jpg', 'axelcoreos@gmail.com', 'Federico', '2023-10-03', NULL, NULL, NULL, 0, 1),
(21, 'MSP18', 'foto.jpeg', 'tfreynasoto@gmail.com', 'Rabbit', '2022-12-13', 'Hollad lop', 'Macho', 'Café claro con blanco ', 0, 1),
(22, 'MSP19', 'foto.jpg', 'mare_vig@hotmail.com', 'Snowball ', '2018-01-16', NULL, NULL, NULL, 0, 1),
(23, 'MSP20', 'foto.jpg', 'arlette.molina90@gmail.com', 'Lolo ', '2021-01-31', 'Rex ', 'Macho', 'Beige con tonos grises ', 0, 1),
(24, 'MSP21', 'foto.jpg', 'laura.mt942@gmail.com', 'CORNIE', '2022-09-19', 'Enano holandés ', 'Hembra', 'Café con blanco', 0, 1),
(25, 'MSP22', 'foto.jpg', 'rodmequit1104@gmail.com', 'Michael ', '2023-05-11', NULL, NULL, NULL, 0, 1),
(26, 'MSP23', 'foto.jpg', 'fatimaolverasantos@gmail.com', 'Luca Turin ', '2022-02-05', NULL, NULL, NULL, 0, 1),
(27, 'MSP24', 'foto.jpg', 'arlette.molina90@gmail.com', 'Lola ', '2021-04-01', NULL, NULL, NULL, 0, 1),
(28, 'MSP25', 'foto.jpg', 'kayacra@gmail.com', 'Pancho pelusito', '2022-05-09', NULL, NULL, NULL, 0, 1),
(29, 'MSP26', 'foto.jpg', 'ja251699@gmail.com', 'Panela ', '2022-11-29', 'Enano holandes ', 'Hembra', 'Blanco', 0, 1),
(30, 'MSP27', 'foto.jpg', 'tonalliari@hotmail.com', 'Robbie ', '2023-05-09', 'Rex', 'Macho', 'Cafe', 0, 1),
(31, 'MSP28', 'foto.jpg', 'ale.olmos.140384@gmail.com', 'Nube', '2022-09-25', NULL, NULL, NULL, 0, 1),
(32, 'MSP29', 'foto.jpeg', 'pilariqaa@gmail.com', 'Lolo', '2019-02-06', NULL, NULL, NULL, 0, 1),
(33, 'MSP30', 'foto.jpeg', 'pilariqaa@gmail.com', 'Loly ', '2019-03-06', NULL, NULL, NULL, 0, 1),
(34, 'MSP31', 'foto.jpg', 'dagri_46@hotmail.com', 'YUKI', '2018-06-01', 'Doméstico ', 'Hembra', 'Blanco ', 0, 1),
(35, 'MSP32', 'foto.jpg', 'keyrinimayer26@gmail.com', 'Copito ', '2022-05-20', 'Cabeza de león doble melena ', 'Macho', 'Blanco ', 0, 1),
(36, 'MSP33', 'foto.jpg', 'dagri_46@hotmail.com', 'Moka', '2019-05-05', 'Doméstico ', 'Hembra', 'Cafe', 0, 1),
(37, 'MSP34', 'foto.jpg', 'delfin3082@outlook.com', 'Sally Bendeck ', '2022-11-15', 'Minilop', 'Hembra', 'Naranja', 0, 1),
(38, 'MSP35', 'foto.jpg', 'dagri_46@hotmail.com', 'Panqueca', '2022-07-10', 'Doméstico ', 'Hembra', 'Blanco con café ', 0, 1),
(39, 'MSP36', 'foto.jpg', 'ferdc94@hotmail.com', 'Baphomet', '2022-12-27', NULL, NULL, NULL, 0, 1),
(40, 'MSP37', 'foto.jpg', 'delfin3082@outlook.com', 'Molly Bendeck', '2021-12-06', 'Cabeza de león ', 'Hembra', 'Blanca con manchas negras ', 0, 1),
(41, 'MSP38', 'foto.jpg', 'coritellezcruz26@gmail.com', 'Bati-conejo', '2022-03-15', 'Mestizo ', 'Macho', 'Negro ', 0, 1),
(42, 'MSP39', 'foto.jpg', '', 'Momo Giro ', '2023-05-05', 'Belier ', 'Hembra', 'Gris manchada ', 0, 1),
(43, 'MSP40', 'foto.jpg', 'jazpiolin@hotmail.com', 'LOLY', '2021-09-19', NULL, NULL, NULL, 0, 1),
(44, 'MSP41', 'foto.jpg', 'isa_als19@hotmail.com', 'Rabit', '2020-03-05', 'Belier', 'Hembra', 'Blanco con cafe', 0, 1),
(45, 'MSP42', 'foto.jpg', '', 'Pana Oreo ', '2021-07-15', 'Cabeza de León doble melena. ', 'Macho', 'Negro sólido con motas grises dispersas', 0, 1),
(46, 'MSP43', 'foto.jpg', 'mitbotong1704@gmail.com', 'Ramón ', '2019-06-28', NULL, NULL, NULL, 0, 1),
(47, 'MSP44', 'foto.jpg', 'mitbotong1704@gmail.com', 'Ramón ', '2019-06-28', NULL, NULL, NULL, 0, 1),
(49, 'MSP46', 'foto.jpeg', 'valevivanco165@gmail.com', 'Tambor ', '2015-03-16', 'Holland Lop ', 'Macho', 'Blanco y café', 0, 1),
(50, 'MSP47', 'foto.jpeg', 'anilupina@gmail.com', 'Heno', '2022-11-02', NULL, NULL, NULL, 0, 1),
(51, 'MSP48', 'foto.jpg', 'parias2202@gmail.com', 'Borrita', '2021-10-22', 'Belier', 'Hembra', 'Blanco con manchitas cafés', 0, 1),
(52, 'MSP49', 'foto.jpg', 'angelesjalomo4@gmail.com', 'Bonnie ', '2020-10-07', 'Cabeza de León ', 'Hembra', 'Gris y blanco ', 0, 1),
(53, 'MSP50', 'foto.jpeg', 'sayuri6690@gmail.com', 'Algodona', '2021-04-30', '-', 'Hembra', 'Blanco con gris', 0, 1),
(54, 'MSP51', 'foto.jpg', 'alinearteaga62@gmail.com', 'Lolo', '2021-05-10', NULL, NULL, NULL, 0, 1),
(55, 'MSP52', 'foto.jpeg', 'miss_yepez@hotmail.com', 'Gazapo', '2020-05-02', 'Común ', 'Macho', 'Gris', 0, 1),
(56, 'MSP53', 'foto.jpeg', 'bren_rs@hotmail.com', 'Milky & Holly', '2022-04-19', NULL, NULL, NULL, 0, 1),
(57, 'MSP54', 'foto.jpeg', 'pumakristen208@hotmail.com', 'Pachito Bebé ', '2022-07-18', NULL, NULL, NULL, 0, 1),
(59, 'MSP56', 'foto.jpg', 'ronyjimnz@hotmail.com', 'Tequila', '2022-09-20', NULL, NULL, NULL, 0, 1),
(60, 'MSP57', 'foto.jpg', 'jeal_sc94@outlook.com', 'Asagi', '2018-10-15', 'Común', 'Hembra', 'Blanca con miel', 0, 1),
(61, 'MSP58', 'foto.jpg', 'lizbeth_hdez12@hotmail.com', 'Canelo', '2022-09-25', 'conejo', 'Macho', 'Cafe claro.', 0, 1),
(62, 'MSP59', 'foto.jpeg', 'naidumadera@gmail.com', 'Tequila Konijn', '2018-12-15', 'Mariposa gigante', 'Hembra', 'Blanco con gris', 0, 1),
(63, 'MSP60', 'foto.jpg', 'erikaval307@hotmail.com', 'Sra Gull', '2021-08-18', NULL, NULL, NULL, 0, 1),
(64, 'MSP61', 'foto.jpg', 'atton10@hotmail.com', 'TOTORO', '2020-09-01', NULL, NULL, NULL, 0, 1),
(65, 'MSP62', 'foto.jpg', 'smichelleahernandez00@gmail.com', 'Snowball', '2021-06-14', 'Domestico con ', 'Hembra', 'Blanco', 0, 1),
(66, 'MSP63', 'foto.jpg', 'blancheyura@gmail.com', 'Manchas', '2019-02-15', 'Cabeza de león', 'Macho', 'Café con blanco', 0, 1),
(67, 'MSP64', 'foto.jpeg', 'pryscillacordova27@gmail.com', 'Buggs', '2022-08-12', 'Mini lop cabeza de Leon ', 'Macho', 'Gris ', 0, 1),
(68, 'MSP65', 'foto.jpg', 'yukariseguranegrete@gmail.com', 'Príncipe ', '2022-11-04', NULL, NULL, NULL, 0, 1),
(69, 'MSP66', 'foto.jpg', 'yukariseguranegrete@gmail.com', 'Tambor', '2021-05-16', NULL, NULL, NULL, 0, 1),
(70, 'MSP67', 'foto.jpg', 'quien_romo@outlook.com', 'Joe', '2022-12-13', '?', 'Macho', 'Beige con manchas grises y blancas', 0, 1),
(71, 'MSP68', 'foto.jpg', 'franrodri2089@gmail.com', 'Bola ', '2023-02-12', NULL, NULL, NULL, 0, 1),
(72, 'MSP69', 'foto.jpeg', 'Sabatt.black@gmail.com', 'Kimpy', '2019-09-10', NULL, NULL, NULL, 0, 1),
(73, 'MSP70', 'foto.jpeg', 'Sabatt.black@gmail.com', 'Coco', '2020-02-14', NULL, NULL, NULL, 0, 1),
(74, 'MSP71', 'foto.jpeg', 'Sabatt.black@gmail.com', 'Po', '2021-11-11', NULL, NULL, NULL, 0, 1),
(75, 'MSP72', 'foto.jpeg', 'mauriciogovz@gmail.com', 'Bethel', '2019-07-31', 'Cruza de enano', 'Hembra', 'Blanco con manchas cafés y negritas', 0, 1),
(77, 'MSP74', 'foto.jpeg', 'marianapink.mf@gmail.com', 'Sasho ', '2019-10-18', NULL, NULL, NULL, 0, 1),
(78, 'MSP75', 'foto.jpeg', 'lic.nut.alondrasanchez@gmail.com', 'Burbuja ', '2021-09-23', 'Angora ', 'Hembra', 'Blanco ', 0, 1),
(79, 'MSP76', 'foto.jpeg', 'sandillescas26@gmail.com', 'Molly Illescas', '2019-03-10', 'mini lop ', 'Macho', 'blanco con gris', 0, 1),
(80, 'MSP77', 'foto.jpeg', 'marianapink.mf@gmail.com', 'Blanca ', '2020-10-10', NULL, NULL, NULL, 0, 1),
(81, 'MSP78', 'foto.jpeg', 'amarelramosximenez10@gmail.com', 'Chemita ', '2022-02-28', 'Enano holandés ', 'Macho', 'Blanco con negro', 0, 1),
(82, 'MSP79', 'foto.jpeg', 'vanesarubio1010@gmail.com', 'Madelyn', '2021-11-16', NULL, NULL, NULL, 0, 1),
(83, 'MSP80', 'foto.jpeg', 'vanesarubio1010@gmail.com', 'Chiclesito', '2022-01-07', NULL, NULL, NULL, 0, 1),
(84, 'MSP81', 'foto.jpg', '', 'Luciano', '2021-12-01', 'Cabecita de leon', 'Macho', 'Gris', 0, 1),
(85, 'MSP82', 'foto.jpeg', 'bobesfel@live.com.mx', 'Luca', '2023-08-16', 'Mini loop', 'Macho', 'Blanco con beige', 0, 1),
(86, 'MSP83', 'foto.jpeg', 'dsarai.gv@hotmail.es', 'Gracie', '2022-12-13', NULL, NULL, NULL, 0, 1),
(87, 'MSP84', 'foto.jpg', '', 'Robin ', '2023-05-10', 'Holandés ', 'Macho', 'Blanco con gris', 0, 1),
(88, 'MSP85', 'foto.jpeg', 'kasm280999@gmail.com', 'Oreo Sánchez ', '2022-12-10', NULL, NULL, NULL, 0, 1),
(89, 'MSP86', 'foto.jpeg', 'kasm280999@gmail.com', 'Cajeta Sánchez ', '2023-04-02', NULL, NULL, NULL, 0, 1),
(90, 'MSP87', 'foto.jpg', 'kastillo28@hotmail.com', 'MARIA LUNETA', '2021-02-11', NULL, NULL, NULL, 0, 1),
(91, 'MSP88', 'foto.jpg', 'maliz99952@gmail.com', 'Blaki y boni', '2023-01-31', NULL, NULL, NULL, 0, 1),
(92, 'MSP89', 'foto.jpg', 'jazmin.eacj@gmail.com', 'Ardillita ', '2021-06-01', 'Conejo ', 'Hembra', 'Miel', 0, 1),
(93, 'MSP90', 'foto.jpg', 'erikasias4@gmail.com', 'Copito ', '2020-08-28', NULL, NULL, NULL, 0, 1),
(94, 'MSP91', 'foto.jpg', 'aylinpoeta@gmail.com', 'Jimbo', '2021-04-03', NULL, NULL, NULL, 0, 1),
(95, 'MSP92', 'foto.jpeg', 'atzinrosas24@gmail.com', 'Onix', '2021-08-24', NULL, NULL, NULL, 0, 1),
(96, 'MSP93', 'foto.jpg', 'jalbertoc99@gmail.com', 'Malvavisco', '2021-08-28', NULL, NULL, NULL, 0, 1),
(97, 'MSP94', 'foto.jpg', 'cesar_050205@hotmail.com', 'Coris', '2022-01-14', NULL, NULL, NULL, 0, 1),
(98, 'MSP95', 'foto.jpg', 'kattystephany@gmail.com', 'Derek', '2019-06-04', 'Enano Holandes cruza con Rex', 'Macho', 'gris azulado', 0, 1),
(99, 'MSP96', 'foto.jpeg', 'kattystephany@gmail.com', 'Eli', '2021-03-18', 'Enano Holandes cruza con cabeza de leon', 'Macho', 'blanco', 0, 1),
(100, 'MSP97', 'foto.webp', 'valeria06af@gmail.com', 'Olivia', '2022-02-06', 'Rex', 'Hembra', 'Bicolor', 0, 1),
(101, 'MSP98', 'foto.jpg', 'valeria06af@gmail.com', 'Tambor', '2023-06-26', NULL, NULL, NULL, 0, 1),
(102, 'MSP99', 'foto.jpeg', 'nanisnancy7@gmail.com', 'Oscars', '2019-12-31', NULL, NULL, NULL, 0, 1),
(103, 'MSP100', 'foto.jpeg', 'nanisnancy7@gmail.com', 'Malvavisco ', '2021-09-26', NULL, NULL, NULL, 0, 1),
(104, 'MSP101', 'foto.jpeg', 'maria.pinac@outlook.com', 'Bolita', '2016-05-04', NULL, NULL, NULL, 0, 1),
(105, 'MSP102', 'foto.jpeg', 'maria.pinac@outlook.com', 'Micaelo', '2022-11-02', NULL, NULL, NULL, 0, 1),
(106, 'MSP103', 'foto.jpg', 'mrsvioletparanoia@gmail.com', 'Hades', '2021-01-08', NULL, NULL, NULL, 0, 1),
(107, 'MSP104', 'foto.jpg', 'mrsvioletparanoia@gmail.com', 'Kore', '2021-02-14', NULL, NULL, NULL, 0, 1),
(108, 'MSP105', 'foto.jpg', 'lizi-lo-e@hotmail.com', 'Bugs', '2022-09-20', NULL, NULL, NULL, 0, 1),
(109, 'MSP106', 'foto.jpeg', 'vannysan12@hotmail.com', 'Holly', '2023-02-28', NULL, NULL, NULL, 0, 1),
(110, 'MSP107', 'foto.jpeg', 'abigailromeroh@gmail.com', 'Manchita ', '2022-04-03', NULL, NULL, NULL, 0, 1),
(111, 'MSP108', 'foto.jpeg', 'abigailromeroh@gmail.com', 'Gazapito', '2023-01-06', NULL, NULL, NULL, 0, 1),
(112, 'MSP109', 'foto.jpeg', 'evecucue@hotmail.com', 'Jojo', '2020-02-20', NULL, NULL, NULL, 0, 1),
(113, 'MSP110', 'foto.jpg', 'big_dan@live.com.mx', 'Carboncillo ', '2022-06-25', 'Enano holandés ', 'Macho', 'Negro ', 0, 1),
(114, 'MSP111', 'foto.jpeg', 'aira.pmartinez@gmail.com', 'Luna', '2022-03-27', 'Enano holandés ', 'Hembra', 'Negro', 0, 1),
(115, 'MSP112', 'foto.jpg', 'esmeetinez@gmail.com', 'Bonnie ', '2021-03-02', 'T rex', 'Hembra', 'Miel', 0, 1),
(116, 'MSP113', 'foto.jpg', 'Oscarzm1981@gmail.com', 'VALENTINO', '2022-03-01', NULL, NULL, NULL, 0, 1),
(117, 'MSP114', 'foto.jpg', '', 'Borrita', '2021-10-22', NULL, NULL, NULL, 0, 1),
(118, 'MSP115', 'foto.jpg', 'jjjjulieta92@gmail.com', 'Lupe', '2021-10-10', 'Cabeza de Leon', 'Macho', 'Blanco', 0, 1),
(119, 'MSP116', 'foto.jpg', 'karlyhouse16@gmail.com', 'Gloober ', '2019-06-27', NULL, NULL, NULL, 0, 1),
(120, 'MSP117', 'foto.jpg', 'maskevil27@gmail.com', 'Chupa', '2021-10-10', 'Cabeza de león ', 'Macho', 'Blanco', 0, 1),
(121, 'MSP118', 'foto.jpg', 'segurosjst@gmail.com', 'Manchitas', '2023-02-12', NULL, NULL, NULL, 0, 1),
(122, 'MSP119', 'foto.jpg', 'Aneemix2805@gmail.com', 'Bonie ', '2021-12-06', 'Cabeza de león. ', 'Hembra', 'Café con blanco. ', 0, 1),
(123, 'MSP120', 'foto.jpg', 'jealsaav11@gmail.com', 'Franquito', '2021-10-10', 'Cabeza de leon', 'Macho', 'Blanco con gris ', 0, 1),
(124, 'MSP121', 'foto.jpg', 'fabilaj977@gmail.com', 'Pelusa', '2023-03-12', NULL, NULL, NULL, 0, 1),
(125, 'MSP122', 'foto.jpg', 'jealsaav11@gmail.com', 'Manin', '2012-07-11', 'Cabeza de porqui', 'Macho', 'Carnita', 0, 1),
(126, 'MSP123', 'foto.jpg', 'fabilaj977@gmail.com', 'Burbuja', '2023-03-05', NULL, NULL, NULL, 0, 1),
(127, 'MSP124', 'foto.jpeg', 'dany.estrada.1711@gmail.com', 'Emilia ', '2019-10-17', NULL, NULL, NULL, 0, 1),
(128, 'MSP125', 'foto.jpeg', 'cazilicam@gmail.com', 'Flor', '2023-04-29', NULL, NULL, NULL, 0, 1),
(129, 'MSP126', 'foto.jpg', 'anna.urbina90@outlook.com', 'BENITO', '2023-01-28', NULL, NULL, NULL, 0, 1),
(130, 'MSP127', 'foto.jpeg', 'cazilicam@gmail.com', 'Matildo', '2022-10-22', NULL, NULL, NULL, 0, 1),
(131, 'MSP128', 'foto.jpg', 'anna.urbina90@outlook.com', 'Kendall', '2023-05-28', NULL, NULL, NULL, 0, 1),
(132, 'MSP129', 'foto.jpeg', 'cazilicam@gmail.com', 'Lunito', '2023-05-09', NULL, NULL, NULL, 0, 1),
(133, 'MSP130', 'foto.jpeg', 'ferdaval@yahoo.com.mx', 'Nico', '2018-03-19', NULL, NULL, NULL, 0, 1),
(134, 'MSP131', 'foto.jpg', 'angeles.vanessa99@gmail.com', 'Nita', '2022-09-14', NULL, NULL, NULL, 0, 1),
(135, 'MSP132', 'foto.jpeg', 'naalp2199@gmail.com', 'Benito', '2021-07-14', NULL, NULL, NULL, 0, 1),
(136, 'MSP133', 'foto.jpg', 'sara17cuanalo@gmail.com', 'Parchi', '2021-05-12', 'Cabeza de león ', 'Macho', 'Blanco con negro', 0, 1),
(137, 'MSP134', 'foto.jpeg', '', 'Molly', '2023-05-26', 'Cabeza de León ', 'Hembra', 'Blanca con mancha negra ', 0, 1),
(138, 'MSP135', 'foto.jpg', 'elizaroman1510@gmail.com', 'Píndaro', '2019-03-30', NULL, NULL, NULL, 0, 1),
(139, 'MSP136', 'foto.jpg', 'iris.puqkita@gmail.com', 'Taco', '2017-03-06', 'Cabeza de león ', 'Macho', 'Blanco con gris ', 0, 1),
(140, 'MSP137', 'foto.jpg', 'magui222513@gmail.com', 'Judy', '2020-09-13', NULL, NULL, NULL, 0, 1),
(141, 'MSP138', 'foto.jpeg', 'dianucha99@gmail.com', 'Anakin ', '2022-01-20', NULL, NULL, NULL, 0, 1),
(142, 'MSP139', 'foto.jpg', 'jessi.mun.vaz3264@gmail.com', 'Chiqui', '2023-06-03', 'Enano holandes ', 'Macho', 'Blanco/ cafe', 0, 1),
(143, 'MSP140', 'foto.jpg', 'bunibunx3@gmail.com', 'Merengue', '2022-11-07', NULL, NULL, NULL, 0, 1),
(144, 'MSP141', 'foto.jpg', 'bunibunx3@gmail.com', 'Mazapán ', '2022-10-27', NULL, NULL, NULL, 0, 1),
(145, 'MSP142', 'foto.jpg', 'bunibunx3@gmail.com', 'Moge', '2014-07-20', NULL, NULL, NULL, 0, 1),
(146, 'MSP143', 'foto.jpg', 'jazminagueros@gmail.com', 'Fluff', '2023-01-23', 'Enano holandes', 'Hembra', 'Gris con blanco', 0, 1),
(147, 'MSP144', 'foto.jpeg', 'karla.marks15@gmail.com', 'Chloe', '2020-06-08', NULL, NULL, NULL, 0, 1),
(148, 'MSP145', 'foto.jpeg', 'karla.marks15@gmail.com', 'Chloe', '2020-06-08', NULL, NULL, NULL, 0, 1),
(149, 'MSP146', 'foto.jpeg', 'karla.marks15@gmail.com', 'Chloe', '2020-06-08', NULL, NULL, NULL, 0, 1),
(150, 'MSP147', 'foto.jpeg', 'karla.marks15@gmail.com', 'Chloe', '2020-06-08', NULL, NULL, NULL, 0, 1),
(151, 'MSP148', 'foto.jpeg', 'karla.marks15@gmail.com', 'Chloe', '2020-06-08', NULL, NULL, NULL, 0, 1),
(152, 'MSP149', 'foto.jpg', 'yazytavo@hotmail.com', 'Ashi', '2023-07-27', 'No se', 'Macho', 'Blanco con gris', 0, 1),
(153, 'MSP150', 'foto.jpeg', 'epo267.brendasanluiscastillo@gmail.com', 'Estrella ', '2023-08-08', 'Mini Lop', '', '', 0, 1),
(154, 'MSP151', 'foto.jpg', 'nathanzellet@gmail.com', 'Boro', '2021-09-01', NULL, NULL, NULL, 0, 1),
(155, 'MSP152', 'foto.jpeg', 'epo267.brendasanluiscastillo@gmail.com', 'Nube', '2023-07-14', 'Cabeza de León ', 'Hembra', 'Blanca ', 0, 1),
(157, 'MSP154', 'foto.jpeg', 'dm13le.bae@gmail.com', 'Quesito', '2022-04-30', 'Desconocida ', 'Macho', 'Negro con blanco ', 0, 1),
(158, 'MSP155', 'foto.jpeg', 'zdiana256@gmail.com', 'Tadeo', '2021-09-07', NULL, NULL, NULL, 0, 1),
(159, 'MSP156', 'foto.jpg', 'melisacelina04@gmail.com', 'Didra', '2021-11-20', NULL, NULL, NULL, 0, 1),
(160, 'MSP157', 'foto.jpg', '', 'Pana rabit alias rabito', '2023-04-07', NULL, NULL, NULL, 0, 1),
(161, 'MSP158', 'foto.jpeg', 'zunigadriana1106@gmail.com', 'Lucrecia ', '2021-02-09', 'N/A', 'Hembra', 'Blanco/café', 0, 1),
(162, 'MSP159', 'foto.jpeg', 'zunigadriana1106@gmail.com', 'Lorenza', '2022-09-10', 'Criolla ', 'Hembra', 'Café ', 0, 1),
(164, 'MSP160', 'foto.jpeg', 'zunigadriana1106@gmail.com', 'Jacinta ', '2023-05-16', 'N/a', 'Hembra', 'Blanco ', 0, 1),
(165, 'MSP161', 'foto.jpeg', '', 'Frijol ', '2023-03-13', NULL, NULL, NULL, 0, 1),
(166, 'MSP162', 'foto.jpeg', 'dany.estrada.1711@gmail.com', 'Frijol ', '2023-03-13', NULL, NULL, NULL, 0, 1),
(167, 'MSP163', 'foto.jpeg', 'vmeeds@gmail.com', 'Luna', '2020-03-11', NULL, NULL, NULL, 0, 1),
(168, 'MSP164', 'foto.jpg', 'montserrat.ortega.r@gmail.com', 'Haru', '2021-04-30', NULL, NULL, NULL, 0, 1),
(169, 'MSP165', 'foto.jpeg', 'nopi_fire@hotmail.com', 'Jacinta', '2019-02-21', 'Cabeza de León ', 'Hembra', 'Gris/Marrón', 0, 1),
(170, 'MSP166', 'foto.jpeg', 'nopi_fire@hotmail.com', 'Jacobo', '2019-06-28', 'Cabeza de León/Loop', 'Macho', 'Blanco', 0, 1),
(171, 'MSP167', 'foto.jpg', 'apullay1@gmail.com', 'Nena', '2020-08-04', NULL, NULL, NULL, 0, 1),
(172, 'MSP168', 'foto.jpg', 'apullay1@gmail.com', 'Copito', '2021-08-07', NULL, NULL, NULL, 0, 1),
(173, 'MSP169', 'foto.jpg', 'apullay1@gmail.com', 'Phirii', '2022-07-23', NULL, NULL, NULL, 0, 1),
(174, 'MSP170', 'foto.jpg', 'danli.rodri112@gmail.com', 'Moonshine ', '2021-05-27', NULL, NULL, NULL, 0, 1),
(175, 'MSP171', 'foto.jpg', 'danli.rodri112@gmail.com', 'Grey', '2020-10-28', NULL, NULL, NULL, 0, 1),
(176, 'MSP172', 'foto.jpg', 'caroc705@gmail.com', 'Tikky', '2017-04-07', NULL, NULL, NULL, 0, 1),
(177, 'MSP173', 'foto.jpg', 'caroc705@gmail.com', 'Peter', '2018-01-26', NULL, NULL, NULL, 0, 1),
(178, 'MSP174', 'foto.jpeg', 'alecitaxsandoval@hotmail.com', 'Snowball', '2022-03-25', ' Cabeza de León', 'Macho', 'Blanco', 0, 1),
(179, 'MSP175', 'foto.jpg', 'fernandastefjm@gmail.com', 'Moka', '2022-05-26', NULL, NULL, NULL, 0, 1),
(180, 'MSP176', 'foto.jpg', 'fati_rdz0710@outlook.com', 'Aruma', '2021-02-28', NULL, NULL, NULL, 0, 1),
(181, 'MSP177', 'foto.jpeg', '', 'Jacobo', '2019-06-28', NULL, NULL, NULL, 0, 1),
(182, 'MSP178', 'foto.jpeg', '', 'Jacinta', '2019-02-21', NULL, NULL, NULL, 0, 1),
(183, 'MSP179', 'foto.jpeg', '', 'Jacinta', '2019-02-21', NULL, NULL, NULL, 0, 1),
(184, 'MSP180', 'foto.jpeg', 'andichg8@gmail.com', 'Chai ', '2021-11-17', NULL, NULL, NULL, 0, 1),
(185, 'MSP181', 'foto.jpg', 'yanin.giordano@gmail.com', 'Po', '2022-02-15', 'Enano Holandés ', 'Macho', 'Blanco y negro', 0, 1),
(186, 'MSP182', 'foto.jpeg', 'maurapamela29@gmail.com', 'ESTELA', '2023-03-29', NULL, NULL, NULL, 0, 1),
(187, 'MSP183', 'foto.jpg', 'ingcasaadin2609dan@gmail.com', 'HITLER CALDERÓN', '2020-12-13', 'Belier', 'Hembra', 'Blanca ', 0, 1),
(189, 'MSP184', 'foto.jpg', 'ingcasaadin2609dan@gmail.com', 'QUESO CALDERÓN', '2023-05-24', 'MEZCLA DE BELIER CON GIGANTE DE FLANDES', 'Macho', 'BLANCO', 0, 1),
(190, 'MSP185', 'foto.jpg', 'kasuss29@gmail.com', 'Coquito', '2019-11-08', 'Cabeza de león ', 'Macho', 'Blanco ', 0, 1),
(191, 'MSP186', 'foto.jpg', 'sadrakarp@outlook.com', 'Aisha Bruna', '2023-01-08', 'Enano ingles', 'Hembra', 'Cafe', 0, 1),
(192, 'MSP187', 'foto.jpeg', 'dulluna14@gmail.com', 'Renato', '2022-11-12', NULL, NULL, NULL, 0, 1),
(193, 'MSP188', 'foto.jpg', 'gonzalezadelfo@gmail.com', 'Bolis', '2021-04-02', 'Belier', 'Hembra', 'Blanco', 0, 1),
(194, 'MSP189', 'foto.jpg', '', 'Renato ', '2022-11-12', NULL, NULL, NULL, 0, 1),
(195, 'MSP190', 'foto.jpeg', 'psic.paulinanunez@gmail.com', 'Moti', '2020-03-08', 'Conejo de Castilla', 'Macho', 'Negro con guantes blancos', 0, 1),
(196, 'MSP191', 'foto.jpg', 'eticha.cc.13@hotmail.com', 'Canelo', '2018-08-13', NULL, NULL, NULL, 0, 1),
(197, 'MSP192', 'foto.jpg', 'eticha.cc.13@hotmail.com', 'Pelusa ', '2023-03-23', NULL, NULL, NULL, 0, 1),
(198, 'MSP193', 'foto.jpg', 'karis021185@gmail.com', 'Simba', '2022-12-27', NULL, NULL, NULL, 0, 1),
(199, 'MSP194', 'foto.jpg', 'karis021185@gmail.com', 'Nala', '2023-03-15', NULL, NULL, NULL, 0, 1),
(200, 'MSP195', 'foto.jpg', 'valeriatello17@gmail.com', 'Salem', '2018-02-14', NULL, NULL, NULL, 0, 1),
(201, 'MSP196', 'foto.jpg', 'valeriatello17@gmail.com', 'Orejoncio ', '2018-02-14', NULL, NULL, NULL, 0, 1),
(202, 'MSP197', 'foto.jpg', 'avhh0407@gmail.com', 'Confeti ', '2023-06-30', NULL, NULL, NULL, 0, 1),
(203, 'MSP198', 'foto.jpg', 'monylovestitch@gmail.com', 'Lua', '2021-12-06', NULL, NULL, NULL, 0, 1),
(204, 'MSP199', 'foto.jpg', 'monylovestitch@gmail.com', 'Kuu Maktub', '2023-05-18', 'Cabeza de león ', 'Hembra', 'Blanco', 0, 1),
(205, 'MSP200', 'foto.jpg', 'yaazmin4554@gmail.com', 'Ozzy', '2023-09-04', NULL, NULL, NULL, 0, 1),
(206, 'MSP201', 'foto.jpg', 'yaazmin4554@gmail.com', 'Nahuel', '2023-09-04', NULL, NULL, NULL, 0, 1),
(207, 'MSP202', 'foto.jpg', 'yaazmin4554@gmail.com', 'Peluchin', '2023-09-04', NULL, NULL, NULL, 0, 1),
(208, 'MSP203', 'foto.jpeg', 'omacdonel@gmail.com', 'Milky', '2022-05-06', 'Arlequín ', 'Macho', 'Multicolor ', 0, 1),
(209, 'MSP204', 'foto.jpg', 'yeslar_18@hotmail.com', 'PANCHITO', '2022-11-04', 'Cabeza de león', 'Macho', 'Gris', 0, 1),
(210, 'MSP205', 'foto.jpg', 'mary_09c@hotmail.com', 'Alfonsa', '2023-08-12', NULL, NULL, NULL, 0, 1),
(211, 'MSP206', 'foto.jpg', 'mary_09c@hotmail.com', 'Eleanor ', '2023-10-13', NULL, NULL, NULL, 0, 1),
(212, 'MSP207', 'foto.jpg', 'angelpau2016@gmail.com', 'Paco', '2021-12-14', NULL, NULL, NULL, 0, 1),
(213, 'MSP208', 'foto.jpg', '', 'Paco', '2021-12-14', 'Belier', 'Macho', 'Negro con blanco', 0, 1),
(214, 'MSP209', 'foto.jpg', 'teremario2701@gmail.com', 'Lolo', '2021-02-18', 'Gigante flandes', 'Macho', 'Gris', 0, 1),
(215, 'MSP210', 'foto.jpg', 'teremario2701@gmail.com', 'Mia', '2022-01-11', 'Mariposa', 'Hembra', '', 0, 1),
(216, 'MSP211', 'foto.jpg', 'teremario2701@gmail.com', 'Tusa', '2022-09-06', 'California ', 'Hembra', '', 0, 1),
(217, 'MSP212', 'foto.jpg', 'tellojanet32@gmail.com', 'Bundy ', '2021-04-14', NULL, NULL, NULL, 0, 1),
(218, 'MSP213', 'foto.jpg', 'karina.mtzsandoval@gmail.com', 'COPITO ', '2021-12-22', 'California', 'Macho', 'Blanco/Gris', 0, 1),
(219, 'MSP214', 'foto.jpg', 'vlhuerta@outlook.es', 'Kiki', '2022-09-22', 'NA', 'Hembra', 'Negro', 0, 1),
(220, 'MSP215', 'foto.jpg', 'gabymz9627@gmail.com', 'Orejitas carambola ', '2022-08-12', NULL, NULL, NULL, 0, 1),
(221, 'MSP216', 'foto.jpg', 'gabymz9627@gmail.com', 'Lola late con vainilla ', '2023-04-16', NULL, NULL, NULL, 0, 1),
(222, 'MSP217', 'foto.jpeg', 'irideca16@gmail.com', 'Motita', '2023-10-13', 'Mini loop', 'Hembra', 'Gris ', 0, 1),
(223, 'MSP218', 'foto.jpeg', '', 'Madelyn ', '2021-11-16', 'Liebre con cruza de rex', 'Hembra', 'Cafe ', 0, 1),
(224, 'MSP219', 'foto.png', '', 'Chiclesito ', '2022-06-07', 'Enano ', 'Macho', 'Cafe oscuro', 0, 1),
(225, 'MSP220', 'foto.jpg', 'migatomiu@gmail.com', 'Guantes ', '2021-10-20', NULL, NULL, NULL, 0, 1),
(226, 'MSP221', 'foto.jpg', 'princesa_5589@hotmail.com', 'Miyuki', '2020-11-26', NULL, NULL, NULL, 0, 1),
(227, 'MSP222', 'foto.jpeg', 'nanvarelamax@gmail.com', 'Copo', '2022-11-06', NULL, NULL, NULL, 0, 1),
(228, 'MSP223', 'foto.jpg', 'annie.hopper32@gmail.com', 'Bonnie Oronzor', '2020-07-12', NULL, NULL, NULL, 0, 1),
(229, 'MSP224', 'foto.jpg', 'PragaZenai29@gmail.com', 'Tambor', '2021-12-07', 'Belier holandés ', '', 'Café claro ', 0, 1),
(230, 'MSP225', 'foto.jpg', 'ringog93@gmail.com', 'Chocolatin', '2021-05-22', 'Rex', 'Hembra', 'Negro', 0, 1),
(231, 'MSP226', 'foto.jpeg', 'm.h21g@outlook.com', 'Rabbita', '2023-05-29', NULL, NULL, NULL, 0, 1),
(232, 'MSP227', 'foto.jpg', 'aniluap19@live.com.mx', 'Sergio Berlín ', '2020-09-10', NULL, NULL, NULL, 0, 1),
(233, 'MSP228', 'foto.jpg', 'magaliabigaild@gmail.com', 'Cassy', '2023-08-17', 'Genérica ', 'Hembra', 'Negra con machas blancas', 0, 1),
(234, 'MSP229', 'foto.jpg', 'psic.sandradavila@gmail.com', 'Palanqueta ', '2023-01-28', NULL, NULL, NULL, 0, 1),
(237, 'MSP232', 'foto.jpeg', 'loorzcordova@gmail.com', 'Loki', '2017-10-28', NULL, NULL, NULL, 0, 1),
(238, 'MSP233', 'foto.jpeg', 'loorzcordova@gmail.com', 'Lyana', '2019-12-22', NULL, NULL, NULL, 0, 1),
(239, 'MSP234', 'foto.jpeg', 'palacios.rebeca@gmail.com', 'Boxy', '2023-07-16', NULL, NULL, NULL, 0, 1),
(240, 'MSP235', 'foto.jpg', 'alvaradop.cecilia@gmail.com', 'Rae', '2020-11-07', 'Cabeza de león ', 'Macho', 'Gris con blanco', 0, 1),
(241, 'MSP236', 'foto.jpeg', 'marcelin2489@gmail.com', 'Totora', '2020-05-11', NULL, NULL, NULL, 0, 1),
(242, 'MSP237', 'foto.jpg', 'roxana.jimenez.ayd@gmail.com', 'Brincos,', '2023-01-02', 'No sé ', 'Hembra', 'Blanca ', 0, 1),
(243, 'MSP238', 'foto.png', 'roxana.jimenez.ayd@gmail.com', 'Greñas ', '2023-02-01', 'Cruza de Belier con cabeza de leon', 'Macho', 'Cafe', 0, 1),
(244, 'MSP239', 'foto.jpg', 'taveramiranda1989@gmail.com', 'RITO', '2023-02-17', 'Leporido', 'Macho', 'Blanco ', 0, 1),
(245, 'MSP240', 'foto.jpg', 'lhernandez@pavel.com.mx', 'Lucifer', '2021-12-01', 'Cabeza de leon', 'Macho', 'Gris', 0, 1),
(246, 'MSP241', 'foto.jpg', 'lhernandez@pavel.com.mx', 'Lucifer', '2021-12-01', NULL, NULL, NULL, 0, 1),
(247, 'MSP242', 'foto.jpg', 'baflte.af@gmail.com', 'Ellie', '2021-09-04', NULL, NULL, NULL, 0, 1),
(248, 'MSP243', 'foto.jpg', 'dogezp13@gmail.com', 'Mora', '2023-06-13', NULL, NULL, NULL, 0, 1),
(249, 'MSP244', 'foto.jpg', 'dogezp13@gmail.com', 'Cookie', '2023-08-20', NULL, NULL, NULL, 0, 1),
(250, 'MSP245', 'foto.jpg', 'chivis_monsis84@hotmail.com', 'Bonifacio', '2023-07-12', 'Enano', 'Macho', 'Blanco con gris', 0, 1),
(251, 'MSP246', 'foto.jpg', 'daguilareyes@hotmail.com', 'Luca Turin', '2022-02-05', NULL, NULL, NULL, 0, 1),
(252, 'MSP247', 'foto.jpg', 'bialdo10@yahoo.com.mx', 'Poppy', '2021-02-14', 'Himalaya', 'Hembra', 'Blanco', 0, 1),
(253, 'MSP248', 'foto.jpg', 'gcrgaby584@gmail.com', 'Oreo', '2023-10-01', NULL, NULL, NULL, 0, 1),
(254, 'MSP249', 'foto.jpg', 'cr7aragon@gmail.com', 'Canela ', '2022-01-07', NULL, NULL, NULL, 0, 1),
(255, 'MSP250', 'foto.jpg', 'fcpalafoxpsic@hotmail.com', 'Taquito ', '2023-10-20', 'Rex', 'Macho', 'Café tostadito', 0, 1),
(256, 'MSP251', 'foto.jpg', 'fcpalafoxpsic@hotmail.com', 'Petotina gordita', '2023-10-20', 'Rex', 'Hembra', 'Blanco con motitas negras', 0, 1),
(257, 'MSP252', 'foto.jpg', 'lauraroblescastilla@gmail.com', 'Gris', '2019-05-01', NULL, NULL, NULL, 0, 1),
(258, 'MSP253', 'foto.jpg', 'conyham81@gmail.com', 'Muñeco', '2015-04-15', NULL, NULL, NULL, 0, 1),
(259, 'MSP254', 'foto.jpg', 'emiliomarroquina@gmail.com', 'Gorda', '2019-11-11', NULL, NULL, NULL, 0, 1),
(260, 'MSP255', 'foto.jpg', 'pozosf1314@gmail.com', 'Estropajo', '2018-02-05', NULL, NULL, NULL, 0, 1),
(261, 'MSP256', 'foto.webp', 'mendozajor31@gmail.com', 'Rabbi ', '2021-03-05', 'Rex', '', 'Blanco con tono gris/café ', 0, 1),
(262, 'MSP257', 'foto.jpg', 'soap9431@gmail.com', 'Eeve', '2023-07-24', 'Minilop', 'Hembra', '', 0, 1),
(263, 'MSP258', 'foto.jpg', 'agpto.gip@gmail.com', 'Pelusa', '2022-07-20', 'Enano Holandés ', 'Hembra', 'Gris', 0, 1),
(264, 'MSP259', 'foto.jpg', 'agpto.gip@gmail.com', 'Wilson', '2022-06-20', 'Mini lop Belier', 'Macho', 'Cafe', 0, 1),
(265, 'MSP260', 'foto.jpg', 'israelteamo230610@gmail.com', 'Wilburt Renato ', '2023-08-20', 'Enano Holandes', 'Macho', 'Blanco con manchas cafés ', 0, 1),
(266, 'MSP261', 'foto.jpeg', '', 'Tambor', '2023-09-01', NULL, NULL, NULL, 0, 1),
(267, 'MSP262', 'foto.jpeg', '', 'Tambor', '2023-09-01', NULL, NULL, NULL, 0, 1),
(268, 'MSP263', 'foto.jpeg', '', 'Tixie', '2023-09-01', NULL, NULL, NULL, 0, 1),
(269, 'MSP264', 'foto.jpeg', 'fannyguevara78313@gmail.com', 'Tambor', '2023-09-01', NULL, NULL, NULL, 0, 1),
(270, 'MSP265', 'foto.jpeg', 'fannyguevara78313@gmail.com', 'Tixie', '2023-09-01', NULL, NULL, NULL, 0, 1),
(271, 'MSP266', 'foto.jpeg', 'mary_risos@hotmail.com', 'Leía ', '2021-10-30', 'Belier ', 'Hembra', '', 0, 1),
(272, 'MSP267', 'foto.jpeg', 'mary_risos@hotmail.com', 'Padme', '2021-10-30', NULL, NULL, NULL, 0, 1),
(273, 'MSP268', 'foto.jpg', 'carrilloanalilia0@gmail.com', 'Ate', '2022-12-12', NULL, NULL, NULL, 0, 1),
(274, 'MSP269', 'foto.jpg', 'gomita_malosa@outlook.com', 'LUNA', '2020-06-19', NULL, NULL, NULL, 0, 1),
(275, 'MSP270', 'foto.jpg', 'gomita_malosa@outlook.com', 'Gus', '2022-01-19', NULL, NULL, NULL, 0, 1),
(276, 'MSP271', 'foto.jpg', 'hanayeli894@gmail.com', 'Coco', '2020-05-28', 'Desconozco ', 'Macho', 'Manchado ', 0, 1),
(277, 'MSP272', 'foto.jpeg', 'gaidamb@hotmail.com', 'Tobias ', '2021-04-30', NULL, NULL, NULL, 0, 1),
(278, 'MSP273', 'foto.jpg', 'lucero.bernardino.96@gmail.com', 'Coneja', '2022-12-01', NULL, NULL, NULL, 0, 1),
(279, 'MSP274', 'foto.jpg', 'lucero.bernardino.96@gmail.com', 'Chirris', '2023-01-01', NULL, NULL, NULL, 0, 1),
(280, 'MSP275', 'foto.jpg', '', 'Molly', '2020-03-10', NULL, NULL, NULL, 0, 1),
(281, 'MSP276', 'foto.jpg', 'hanayeli894@gmail.com', 'Molly ', '2020-03-10', NULL, NULL, NULL, 0, 1),
(282, 'MSP277', 'foto.jpg', 'hanayeli894@gmail.com', 'Luna', '2021-05-28', NULL, NULL, NULL, 0, 1),
(283, 'MSP278', 'foto.jpg', 'aihp_0208@hotmail.com', 'Petunia', '2020-03-30', NULL, NULL, NULL, 0, 1),
(284, 'MSP279', 'foto.jpg', 'hanayeli894@gmail.com', 'Isis e Isa', '2020-05-28', NULL, NULL, NULL, 0, 1),
(285, 'MSP280', 'foto.jpg', 'hanayeli894@gmail.com', 'Nino', '2020-10-25', NULL, NULL, NULL, 0, 1),
(286, 'MSP281', 'foto.jpg', 'hanayeli894@gmail.com', 'Enano ', '2022-06-03', 'Desconozco ', 'Macho', 'Blanco ', 0, 1),
(287, 'MSP282', 'foto.jpg', '', 'Tocha ', '2020-01-01', 'Rex', 'Hembra', 'Miel', 0, 1),
(288, 'MSP283', 'foto.jpg', 'hanayeli894@gmail.com', 'Nala', '2022-06-03', NULL, NULL, NULL, 0, 1),
(289, 'MSP284', 'foto.jpg', 'burbuja79_@hotmail.com', 'Raditz', '2023-07-04', 'Holandes', 'Macho', 'Gris con Blanco', 0, 1),
(290, 'MSP285', 'foto.jpg', 'burbuja79_@hotmail.com', 'Tochi', '2023-08-05', 'Mini Rex', 'Macho', 'Miel', 0, 1),
(291, 'MSP286', 'foto.jpg', '', 'Raditz', '2023-07-04', 'Holandés ', 'Macho', 'Gris con Blanco', 0, 1),
(292, 'MSP287', 'foto.jpg', '', 'Tochi', '2023-08-05', 'Mini Rex', 'Macho', 'Miel', 0, 1),
(293, 'MSP288', 'foto.jpg', '', 'Ayamezuka ', '2023-06-03', 'Cabeza de león ', 'Hembra', 'Gris con blanco', 0, 1),
(294, 'MSP289', 'foto.jpg', 'dianajera92@gmail.com', 'Kiev', '2021-05-15', 'Enano holandés ', 'Macho', 'Arlequín ', 0, 1),
(295, 'MSP290', 'foto.jpg', 'dianajera92@gmail.com', 'Bonn', '2021-06-30', 'Belier', 'Macho', 'Blanco/Gris', 0, 1),
(296, 'MSP291', 'foto.jpeg', 'montsemdk@hotmail.com', 'Poli', '2019-12-14', NULL, NULL, NULL, 0, 1),
(298, 'MSP293', 'foto.jpg', 'mariafernandarubio54@gmail.com', 'Cabecita de nuez ', '2023-07-22', 'Enano', 'Macho', 'Café miel', 0, 1),
(299, 'MSP294', 'foto.jpg', '', 'Cabecita de nuez ', '2023-07-22', 'Enano', 'Macho', 'Color miel ', 0, 1),
(300, 'MSP295', 'foto.jpg', '', 'Cabecita de nuez ', '2023-07-22', NULL, NULL, NULL, 0, 1),
(301, 'MSP296', 'foto.jpg', 'dayana1890@gmail.com', 'Rory', '2023-08-26', NULL, NULL, NULL, 0, 1),
(302, 'MSP297', 'foto.jpg', 'gabyoss3022@gmail.com', 'Srto Coppi', '2023-09-22', NULL, NULL, NULL, 0, 1),
(303, 'MSP298', 'foto.jpg', 'gabyoss3022@gmail.com', 'Capuchina', '2023-09-01', NULL, NULL, NULL, 0, 1),
(304, 'MSP299', 'foto.jpg', 'sparklylollipop05@gmail.com', 'Luna', '2018-06-05', 'Enano', 'Macho', 'Blanco y negro', 0, 1),
(305, 'MSP300', 'foto.jpeg', 'mc20sarm2157@facmed.unam.mx', 'Cotton', '2021-06-06', NULL, NULL, NULL, 0, 1),
(306, 'MSP301', 'foto.jpg', 'lupitaherreraroa@gmail.com', 'Harry', '2023-11-05', NULL, NULL, NULL, 0, 1),
(307, 'MSP302', 'foto.jpg', 'terexa2307@gmail.com', 'Topito', '2021-06-14', 'Belier', 'Macho', 'Blanco ', 0, 1),
(308, 'MSP303', 'foto.jpg', 'liliplata95@gmail.com', 'Frediie ', '2020-10-24', 'Cabeza de león ', 'Macho', 'Blanco y gris oscuro', 0, 1),
(309, 'MSP304', 'foto.jpg', 'yue.teru@gmail.com', 'Teru', '2013-04-30', NULL, NULL, NULL, 0, 1),
(310, 'MSP305', 'foto.jpg', 'jcjacinto1982@gmail.com', 'Canelo ', '2023-04-08', NULL, NULL, NULL, 0, 1),
(311, 'MSP306', 'foto.jpg', 'jcjacinto1982@gmail.com', 'La Eliot ', '2022-10-02', NULL, NULL, NULL, 0, 1),
(312, 'MSP307', 'foto.jpg', 'zurissa25@gmail.com', 'Coneja', '2021-12-03', 'Mini ', 'Hembra', 'Gris', 0, 1),
(313, 'MSP308', 'foto.jpeg', 'zurissa25@gmail.com', 'Camelia', '2023-08-21', 'Gigante de Flandes', 'Hembra', 'Arlequín blanco- negro ', 0, 1),
(314, 'MSP309', 'foto.jpg', 'maryferponce@gmail.com', 'Nico', '2017-12-01', NULL, NULL, NULL, 0, 1),
(317, 'MSP311', 'foto.jpg', 'cnig_knox@hotmail.com', 'Toño', '2022-05-15', NULL, NULL, NULL, 0, 1),
(318, 'MSP312', 'foto.jpg', 'estrada.ximena2739@gmail.com', 'Panda', '2020-05-15', NULL, NULL, NULL, 0, 1),
(319, 'MSP313', 'foto.jpg', 'estrada.ximena2739@gmail.com', 'Capuchina ', '2020-05-15', NULL, NULL, NULL, 0, 1),
(320, 'MSP314', 'foto.jpg', 'myep_i@hotmail.com', 'Mis conejitos', '2023-11-07', NULL, NULL, NULL, 0, 1),
(321, 'MSP315', 'foto.jpg', 'johanesgarcialimon@gmail.com', 'Cirilla ', '2022-08-20', 'Belier ', 'Hembra', 'Champagne', 0, 1),
(322, 'MSP316', 'foto.jpg', 'mari_balderas23@outlook.com', 'Smog', '2018-10-12', 'Rex', 'Macho', 'Gris oxford', 0, 1),
(323, 'MSP317', 'foto.jpg', 'g.galvezabrego@gmail.com', 'Momo Giro ', '2023-05-05', 'Belier', 'Hembra', 'Gris con blanco manchada ', 0, 1),
(324, 'MSP318', 'foto.jpg', 'g.galvezabrego@gmail.com', 'Pana Oreo ', '2021-07-15', 'Cabeza de león doble melena', 'Macho', 'Negro sólido con motas grises dispersas', 0, 1),
(325, 'MSP319', 'foto.png', 'licha.coral@live.com', 'Nena', '2023-04-01', NULL, NULL, NULL, 0, 1),
(326, 'MSP320', 'foto.png', 'licha.coral@live.com', 'Twinky', '2022-03-02', NULL, NULL, NULL, 0, 1),
(327, 'MSP321', 'foto.jpeg', 'f_bonilla88@hotmail.com', 'Charlie', '2022-01-24', 'Belier', 'Macho', 'Blanco', 0, 1),
(328, 'MSP322', 'foto.jpeg', 'f_bonilla88@hotmail.com', 'Hayley', '2023-01-06', 'Belier', 'Hembra', 'Blanco con café', 0, 1),
(329, 'MSP323', 'foto.jpeg', 'lauraisabelmatamala@gmail.com', 'Marozio', '2021-08-08', NULL, NULL, NULL, 0, 1),
(330, 'MSP324', 'foto.jpeg', 'lauraisabelmatamala@gmail.com', 'Niña Bachelet', '2021-12-08', NULL, NULL, NULL, 0, 1),
(331, 'MSP325', 'foto.jpeg', 'lauraisabelmatamala@gmail.com', 'Chiniwini', '2022-12-08', NULL, NULL, NULL, 0, 1),
(332, 'MSP326', 'foto.jpeg', 'lauraisabelmatamala@gmail.com', 'Chalino', '2022-12-08', NULL, NULL, NULL, 0, 1),
(333, 'MSP327', 'foto.jpg', 'giselaesum@gmail.com', 'Canelo', '2022-04-19', NULL, NULL, NULL, 0, 1),
(334, 'MSP328', 'foto.jpg', 'giselaesum@gmail.com', 'Bombón', '2020-10-08', NULL, NULL, NULL, 0, 1),
(335, 'MSP329', 'foto.jpg', 'araujo.urrutia@gmail.com', 'Francis', '2023-06-07', 'Cabeza de León', 'Macho', 'Tarantula', 0, 1),
(336, 'MSP330', 'foto.jpg', 'yazminixchel10@gmail.com', 'Ibbie', '2023-10-25', NULL, NULL, NULL, 0, 1),
(337, 'MSP331', 'foto.jpeg', 'lcpalanis@gmail.com', 'Totopo', '2022-05-16', 'Cabeza de León y Rex', 'Macho', 'Café', 0, 1),
(338, 'MSP332', 'foto.jpg', 'donagit_luna@hotmail.com', 'Goldi', '2020-09-15', NULL, NULL, NULL, 0, 1),
(339, 'MSP333', 'foto.jpg', 'beatriz073022@gmail.com', 'Cacerolo ', '2023-05-03', NULL, NULL, NULL, 0, 1),
(340, 'MSP334', 'foto.jpg', 'karen.vega.o@gmail.com', 'Saltitos', '2022-05-01', 'Comun', 'Macho', 'Varios', 0, 1),
(342, 'MSP336', 'foto.jpg', 'mariafernandarubio54@gmail.com', 'Darla ', '2023-11-12', 'Enano belier orejas caídas ', 'Hembra', 'Color café Claro ', 0, 1),
(343, 'MSP337', 'foto.jpeg', 'betty.grcavila@gmail.com', 'Leonora', '2023-06-17', NULL, NULL, NULL, 0, 1),
(344, 'MSP338', 'foto.jpg', 'huerta_8806@hotmail.com', 'Tamborcito ', '2022-12-24', NULL, NULL, NULL, 0, 1),
(345, 'MSP339', 'foto.jpg', 'pumas4191@hotmail.com', 'Tigre', '2023-05-26', NULL, NULL, NULL, 0, 1),
(346, 'MSP340', 'foto.jpg', 'pumas4191@hotmail.com', 'Atenea', '2023-08-17', NULL, NULL, NULL, 0, 1),
(347, 'MSP341', 'foto.jpg', 'cortesjimenezm65@gmail.com', 'Ruty', '2021-03-10', 'Cabeza de León ', 'Hembra', 'Gris', 0, 1),
(348, 'MSP342', 'foto.jpg', 'monsevanegas@hotmail.com', 'Blue', '2023-05-12', 'Belier', 'Macho', 'Blanco con gris ', 0, 1),
(349, 'MSP343', 'foto.jpg', 'javierc66@hotmail.es', 'Tix', '2020-06-25', NULL, NULL, NULL, 0, 1),
(350, 'MSP344', 'foto.jpg', 'javierc66@hotmail.es', 'Fresita ', '2023-07-15', NULL, NULL, NULL, 0, 1),
(351, 'MSP345', 'foto.jpeg', 'karlaalegria13@gmail.com', 'Copito', '2022-04-26', NULL, NULL, NULL, 0, 1),
(352, 'MSP346', 'foto.jpg', 'araujo.urrutia@gmail.com', 'Limones', '2023-07-30', 'Rex', 'Hembra', 'Blanco con negro', 0, 1),
(353, 'MSP347', 'foto.jpg', 'araujo.urrutia@gmail.com', 'Gaby Junior.', '2023-07-30', 'Rex', 'Hembra', 'Negro', 0, 1),
(354, 'MSP348', 'foto.jpg', 'araujo.urrutia@gmail.com', 'Fredy coconut', '2023-07-30', 'Rex', 'Macho', 'Cafe, con blanco', 0, 1),
(355, 'MSP349', 'foto.jpg', 'soria.astrid.1999@gmail.com', 'Trufa', '2020-08-03', 'Desconocido ', 'Macho', 'Gris con blanco ', 0, 1),
(356, 'MSP350', 'foto.jpg', 'sarale0245@gmail.com', 'Tambor', '2020-10-06', NULL, NULL, NULL, 0, 1),
(357, 'MSP351', 'foto.png', 'karlarebeca1997@gmail.com', 'Altanero ', '2020-09-23', NULL, NULL, NULL, 0, 1),
(358, 'MSP352', 'foto.jpeg', 'karlarebeca1997@gmail.com', 'Saleroso ', '2021-02-10', NULL, NULL, NULL, 0, 1),
(359, 'MSP353', 'foto.jpeg', 'karlarebeca1997@gmail.com', 'Josuke ', '2020-12-23', NULL, NULL, NULL, 0, 1),
(360, 'MSP354', 'foto.webp', 'dr7715249@gmail.com', 'Chantanino', '2022-04-01', NULL, NULL, NULL, 0, 1),
(361, 'MSP355', 'foto.jpeg', 'valegarciavelda@gmail.com', 'Peluson Garcia ', '2022-07-27', NULL, NULL, NULL, 0, 1),
(362, 'MSP356', 'foto.jpg', 'andreacornejoreyes2@gmail.com', 'Cloe ', '2023-10-01', 'Enano holandes', 'Hembra', 'Negro con blanco ', 0, 1),
(363, 'MSP357', 'foto.jpeg', 'chikis8trikis@gmail.com', 'Litchi', '2020-03-11', NULL, NULL, NULL, 0, 1),
(364, 'MSP358', 'foto.jpg', 'abigail.qa@outlook.es', 'Simba', '2022-11-15', 'Cabeza de leon', 'Macho', 'Café ', 0, 1),
(365, 'MSP359', 'foto.jpg', 'raaee.2619@gmail.com', 'Molly', '2020-10-13', NULL, NULL, NULL, 0, 1),
(366, 'MSP360', 'foto.jpg', 'raaee.2619@gmail.com', 'Lilo', '2022-06-28', 'Cabeza de león ', 'Hembra', 'amarillo jaspeado', 0, 1),
(367, 'MSP361', 'foto.jpg', 'raaee.2619@gmail.com', 'Coneflais', '2020-09-23', NULL, NULL, NULL, 0, 1),
(368, 'MSP362', 'foto.jpg', 'raaee.2619@gmail.com', 'Frijol', '2022-07-18', NULL, NULL, NULL, 0, 1),
(369, 'MSP363', 'foto.jpg', 'odin.pizano_bvb@outlook.com', 'Blue', '2019-09-25', '.', 'Macho', 'Blanco', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `pagadoPor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idTienda` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `montoPago` decimal(10,2) NOT NULL,
  `fechaInicioPlan` datetime NOT NULL,
  `fechaFinPlan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idPedido` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idCliente` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idVendedor` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaPedido` datetime NOT NULL,
  `idTipoPedido` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idSucursalVenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `idTienda` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `requiereEnvio` int(11) DEFAULT NULL,
  `idTipoEnvio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccionEnvio` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaEnvio` datetime DEFAULT NULL,
  `guiaEnvio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `paqueteriaEnvio` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `precioEnvio` float NOT NULL,
  `fechaPago` datetime DEFAULT NULL,
  `idMetodoDePago` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `comprobantePago` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaCierrePedido` datetime DEFAULT NULL,
  `idEstatusPedido` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idCodigoPromocional` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `descuentoCodigoPromocional` float DEFAULT NULL,
  `subtotal` float NOT NULL,
  `descuentos` float NOT NULL,
  `total` float NOT NULL,
  `isActive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idPedido`, `idCliente`, `idVendedor`, `fechaPedido`, `idTipoPedido`, `idSucursalVenta`, `idTienda`, `requiereEnvio`, `idTipoEnvio`, `direccionEnvio`, `fechaEnvio`, `guiaEnvio`, `paqueteriaEnvio`, `precioEnvio`, `fechaPago`, `idMetodoDePago`, `comprobantePago`, `fechaCierrePedido`, `idEstatusPedido`, `idCodigoPromocional`, `descuentoCodigoPromocional`, `subtotal`, `descuentos`, `total`, `isActive`) VALUES
(5, 'CD1', 'axelcoreos@gmail.com', NULL, '2023-11-09 02:53:57', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'spinOxxo', NULL, NULL, 'EP-1', NULL, NULL, 270, 0, 270, 1),
(6, 'CD2', 'gabriela.rios.h@hotmail.com', NULL, '2023-11-09 09:40:22', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-09 09:41:22', 'transferenciaBancaria', 'comprobantePago.jpg', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(7, 'CD3', 'peraltahannia25@gmail.com', NULL, '2023-11-11 22:26:25', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-11 22:32:26', 'transferenciaBancaria', 'comprobantePago.jpeg', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(8, 'CD4', 'ale.olmos.140384@gmail.com', NULL, '2023-11-16 11:46:11', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'spinOxxo', NULL, NULL, 'EP-1', NULL, NULL, 180, 0, 180, 1),
(9, 'CD5', 'lic.nut.alondrasanchez@gmail.com', NULL, '2023-11-16 11:49:23', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-16 11:51:34', 'transferenciaBancaria', 'comprobantePago.png', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(10, 'CD6', 'bernalsara14@gmail.com', NULL, '2023-11-16 12:38:52', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-16 12:42:35', 'transferenciaBancaria', 'comprobantePago.png', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(11, 'CD7', 'axelcoreos@gmail.com', NULL, '2023-11-16 14:36:39', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'transferenciaBancaria', NULL, NULL, 'EP-1', NULL, NULL, 90, 0, 90, 1),
(12, 'CD8', 'g.galvezabrego@gmail.com', NULL, '2023-11-16 23:52:18', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'transferenciaBancaria', NULL, NULL, 'EP-1', NULL, NULL, 90, 0, 90, 1),
(13, 'CD9', 'espectro.azteca@gmail.com', NULL, '2023-11-17 03:02:11', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'transferenciaBancaria', NULL, NULL, 'EP-1', NULL, NULL, 90, 0, 90, 1),
(14, 'CD10', 'espectro.azteca@gmail.com', NULL, '2023-11-17 03:07:22', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-17 03:07:33', 'transferenciaBancaria', 'comprobantePago.jpg', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(15, 'CD11', 'fati_rdz0710@outlook.com', NULL, '2023-11-19 09:02:24', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'transferenciaBancaria', NULL, NULL, 'EP-1', NULL, NULL, 90, 0, 90, 1),
(16, 'CD12', 'g.galvezabrego@gmail.com', NULL, '2023-11-20 22:04:04', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, '2023-11-20 22:07:03', 'transferenciaBancaria', 'comprobantePago.jpg', NULL, 'EP-2', NULL, NULL, 90, 0, 90, 1),
(17, 'CD13', 'lilusamano@gmail.com', NULL, '2023-11-20 23:50:52', NULL, NULL, 'conejondigital', NULL, 'PIK', 'Dirección de usuario 88', NULL, NULL, NULL, 0, NULL, 'spinOxxo', NULL, NULL, 'EP-1', NULL, NULL, 90, 0, 90, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `idProducto` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `barcode` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idTienda` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idCategoria` varchar(33) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `costo` float NOT NULL,
  `precio` float NOT NULL,
  `precioOferta` float NOT NULL DEFAULT 0,
  `unidadVenta` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inventario` float NOT NULL DEFAULT 0,
  `inventarioMinimo` float NOT NULL DEFAULT 0,
  `requiereEnvio` tinyint(1) NOT NULL,
  `isActiveOnlineStore` tinyint(1) NOT NULL DEFAULT 1,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_asistencia`
--

CREATE TABLE `registro_asistencia` (
  `id` int(11) NOT NULL,
  `usuario_id` varchar(255) NOT NULL,
  `evento_id` varchar(11) NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `urlqr` varchar(500) DEFAULT NULL,
  `asistio` tinyint(1) DEFAULT 0,
  `fecha_hora_asistencia` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `registro_asistencia`
--

INSERT INTO `registro_asistencia` (`id`, `usuario_id`, `evento_id`, `fecha_hora_registro`, `urlqr`, `asistio`, `fecha_hora_asistencia`) VALUES
(10, 'montsemdk@hotmail.com', 'CN2023', '2023-11-03 00:53:23', NULL, 0, NULL),
(11, 'sharona.g.flores@gmail.com', 'CN2023', '2023-11-03 10:29:39', NULL, 0, NULL),
(12, 'rubio.reyes.mariafernandac571f@gmail.com', 'CN2023', '2023-11-03 17:45:03', NULL, 0, NULL),
(13, 'mariafernandarubio54@gmail.com', 'CN2023', '2023-11-03 17:52:09', NULL, 0, NULL),
(14, 'beatriz.martinez.gonzalez09@gmail.com', 'CN2023', '2023-11-04 16:25:20', NULL, 0, NULL),
(15, 'dayana1890@gmail.com', 'CN2023', '2023-11-05 16:31:04', NULL, 0, NULL),
(16, 'fher.ariz@gmail.com', 'CN2023', '2023-11-05 16:44:13', NULL, 0, NULL),
(23, 'g.unit.oss22@gmail.com', 'CN2023', '2023-11-06 10:56:08', NULL, 0, NULL),
(24, 'gabyoss3022@gmail.com', 'CN2023', '2023-11-06 11:05:44', NULL, 0, NULL),
(25, 'sparklylollipop05@gmail.com', 'CN2023', '2023-11-06 11:53:54', NULL, 0, NULL),
(26, 'anakaren.huitron@gmail.com', 'CN2023', '2023-11-06 12:38:12', NULL, 0, NULL),
(27, 'pamela.resendiz.336@gmail.com', 'CN2023', '2023-11-06 12:44:46', NULL, 0, NULL),
(28, 'eli_legna@hotmail.com', 'CN2023', '2023-11-06 14:56:07', NULL, 0, NULL),
(29, 'mc20sarm2157@facmed.unam.mx', 'CN2023', '2023-11-06 18:39:41', NULL, 0, NULL),
(30, 'fabianordaz2@gmail.com', 'CN2023', '2023-11-06 22:13:32', NULL, 0, NULL),
(31, 'aespinozabgx@gmail.com', 'CN2023', '2023-11-06 22:50:44', NULL, 0, NULL),
(32, 'lupitaherreraroa@gmail.com', 'CN2023', '2023-11-07 07:04:55', NULL, 0, NULL),
(33, 'terexa2307@gmail.com', 'CN2023', '2023-11-07 10:12:18', NULL, 0, NULL),
(34, 'dash230216@gmail.com', 'CN2023', '2023-11-07 10:29:49', NULL, 0, NULL),
(35, 'yue.teru@gmail.com', 'CN2023', '2023-11-07 19:41:58', NULL, 0, NULL),
(36, 'arale_rd24@live.com.mx', 'CN2023', '2023-11-07 20:12:49', NULL, 0, NULL),
(37, 'carballido_31@hotmail.com', 'CN2023', '2023-11-07 21:39:34', NULL, 0, NULL),
(38, 'maryferponce@gmail.com', 'CN2023', '2023-11-07 21:56:17', NULL, 0, NULL),
(39, 'estrada.ximena2739@gmail.com', 'CN2023', '2023-11-07 22:05:17', NULL, 0, NULL),
(40, 'myep_i@hotmail.com', 'CN2023', '2023-11-07 22:17:38', NULL, 0, NULL),
(41, 'cnig_knox@hotmail.com', 'CN2023', '2023-11-07 22:22:50', NULL, 0, NULL),
(42, 'johanesgarcialimon@gmail.com', 'CN2023', '2023-11-07 23:49:59', NULL, 0, NULL),
(43, 'valehvivanco@yahoo.com', 'CN2023', '2023-11-07 23:59:01', NULL, 0, NULL),
(44, 'mari_balderas23@outlook.com', 'CN2023', '2023-11-08 06:54:51', NULL, 0, NULL),
(45, 'yanis20053@hotmail.com', 'CN2023', '2023-11-08 07:24:29', NULL, 0, NULL),
(46, 'mar.grunge.fran@hotmail.com', 'CN2023', '2023-11-08 08:06:11', NULL, 0, NULL),
(47, 'juanboscoo1969@gmail.com', 'CN2023', '2023-11-08 09:54:11', NULL, 0, NULL),
(48, 'gonzalcala.dianalorena@gmail.com', 'CN2023', '2023-11-08 10:49:42', NULL, 0, NULL),
(49, 'anacdepina@hotmail.com', 'CN2023', '2023-11-08 11:00:24', NULL, 0, NULL),
(50, 'g.galvezabrego@gmail.com', 'CN2023', '2023-11-08 11:06:11', NULL, 0, NULL),
(51, 'licha.coral@live.com', 'CN2023', '2023-11-08 11:10:43', NULL, 0, NULL),
(52, 'dr7715249@gmail.com', 'CN2023', '2023-11-08 12:02:35', NULL, 0, NULL),
(53, 'arisfields_29@hotmail.com', 'CN2023', '2023-11-08 13:30:22', NULL, 0, NULL),
(54, 'lauraisabelmatamala@gmail.com', 'CN2023', '2023-11-08 14:57:57', NULL, 0, NULL),
(55, 'giselaesum@gmail.com', 'CN2023', '2023-11-08 18:16:12', NULL, 0, NULL),
(56, 'sebastian.carry@gmail.com', 'CN2023', '2023-11-08 19:03:04', NULL, 0, NULL),
(57, 'araujo.urrutia@gmail.com', 'CN2023', '2023-11-08 21:22:47', NULL, 0, NULL),
(59, 'axelcoreos@gmail.com', 'CN2023', '2023-11-09 02:43:29', NULL, 0, NULL),
(60, 'gabriela.rios.h@hotmail.com', 'CN2023', '2023-11-09 09:38:23', NULL, 0, NULL),
(61, 'yazminixchel10@gmail.com', 'CN2023', '2023-11-09 11:52:08', NULL, 0, NULL),
(62, 'lcpalanis@gmail.com', 'CN2023', '2023-11-09 13:57:34', NULL, 0, NULL),
(63, 'donagit_luna@hotmail.com', 'CN2023', '2023-11-09 16:32:27', NULL, 0, NULL),
(64, 'lizzespi650@gmail.com', 'CN2023', '2023-11-09 17:27:24', NULL, 0, NULL),
(65, 'beatriz073022@gmail.com', 'CN2023', '2023-11-10 00:48:43', NULL, 0, NULL),
(66, 'b.adriana.silvestre@gmail.com', 'CN2023', '2023-11-10 06:25:06', NULL, 0, NULL),
(67, 'dianita.galindo98@gmail.com', 'CN2023', '2023-11-10 09:33:50', NULL, 0, NULL),
(68, 'katexiiviixii@gmail.com', 'CN2023', '2023-11-10 21:54:25', NULL, 0, NULL),
(69, 'figue.isc@gmail.com', 'CN2023', '2023-11-11 00:18:23', NULL, 0, NULL),
(70, 'karen.vega.o@gmail.com', 'CN2023', '2023-11-11 16:09:46', NULL, 0, NULL),
(71, 'hanniaperalta03@gmail.com', 'CN2023', '2023-11-11 18:16:40', NULL, 0, NULL),
(72, 'peraltahannia25@gmail.com', 'CN2023', '2023-11-11 22:25:08', NULL, 0, NULL),
(73, 'yeslar_18@hotmail.com', 'CN2023', '2023-11-11 22:47:29', NULL, 0, NULL),
(74, 'adrianommorelli@gmail.com', 'CN2023', '2023-11-12 15:49:09', NULL, 0, NULL),
(75, 'harry.izard@gmail.com', 'CN2023', '2023-11-13 08:03:00', NULL, 0, NULL),
(76, 'ferrubioreyes@gmail.com', 'CN2023', '2023-11-13 09:05:18', NULL, 0, NULL),
(77, 'DANIELAVEG@HOTMAIL.COM', 'CN2023', '2023-11-13 12:36:25', NULL, 0, NULL),
(78, 'betty.grcavila@gmail.com', 'CN2023', '2023-11-13 13:59:57', NULL, 0, NULL),
(79, 'crotalosatrox@gmail.com', 'CN2023', '2023-11-13 14:05:50', NULL, 0, NULL),
(80, 'kaarenrq@gmail.com', 'CN2023', '2023-11-14 20:12:48', NULL, 0, NULL),
(81, 'quetzal2405@hotmail.com', 'CN2023', '2023-11-15 18:33:44', NULL, 0, NULL),
(82, 'fcpalafoxpsic@hotmail.com', 'CN2023', '2023-11-16 08:57:53', NULL, 0, NULL),
(83, 'bernalsara14@gmail.com', 'CN2023', '2023-11-16 09:10:48', NULL, 0, NULL),
(84, 'mary_risos@hotmail.com', 'CN2023', '2023-11-16 09:50:20', NULL, 0, NULL),
(85, 'ale.olmos.140384@gmail.com', 'CN2023', '2023-11-16 11:33:48', NULL, 0, NULL),
(86, 'lic.nut.alondrasanchez@gmail.com', 'CN2023', '2023-11-16 11:42:34', NULL, 0, NULL),
(87, 'fatimaolverasantos@gmail.com', 'CN2023', '2023-11-16 11:47:58', NULL, 0, NULL),
(88, 'Sabatt.black@gmail.com', 'CN2023', '2023-11-16 12:01:44', NULL, 0, NULL),
(89, 'quien_romo@outlook.com', 'CN2023', '2023-11-16 12:06:42', NULL, 0, NULL),
(90, 'elymtzhdz1@gmail.com', 'CN2023', '2023-11-16 12:29:59', NULL, 0, NULL),
(91, 'ringog93@gmail.com', 'CN2023', '2023-11-16 12:56:30', NULL, 0, NULL),
(92, 'nangmontoya@gmail.com', 'CN2023', '2023-11-16 13:52:44', NULL, 0, NULL),
(93, 'brendaaudit@hotmail.com', 'CN2023', '2023-11-16 14:03:24', NULL, 0, NULL),
(94, 'gonzalezadelfo@gmail.com', 'CN2023', '2023-11-16 14:29:17', NULL, 0, NULL),
(95, 'pryscillacordova27@gmail.com', 'CN2023', '2023-11-16 14:35:07', NULL, 0, NULL),
(96, 'moll951114@outlook.com', 'CN2023', '2023-11-16 14:46:27', NULL, 0, NULL),
(97, 'huerta_8806@hotmail.com', 'CN2023', '2023-11-16 15:33:08', NULL, 0, NULL),
(98, 'pumas4191@hotmail.com', 'CN2023', '2023-11-16 15:37:27', NULL, 0, NULL),
(99, 'kattystephany@gmail.com', 'CN2023', '2023-11-16 15:54:02', NULL, 0, NULL),
(100, 'evecucue@hotmail.com', 'CN2023', '2023-11-16 16:50:37', NULL, 0, NULL),
(101, 'bialdo10@yahoo.com.mx', 'CN2023', '2023-11-16 20:59:53', NULL, 0, NULL),
(102, 'monsevanegas@hotmail.com', 'CN2023', '2023-11-17 01:16:29', NULL, 0, NULL),
(103, 'espectro.azteca@gmail.com', 'CN2023', '2023-11-17 02:57:56', NULL, 0, NULL),
(104, 'tonalliari@hotmail.com', 'CN2023', '2023-11-17 10:06:43', NULL, 0, NULL),
(105, 'lolite.s.m@hotmail.com', 'CN2023', '2023-11-17 10:17:47', NULL, 0, NULL),
(106, 'anilupina@gmail.com', 'CN2023', '2023-11-17 10:53:28', NULL, 0, NULL),
(107, 'javierc66@hotmail.es', 'CN2023', '2023-11-17 15:29:15', NULL, 0, NULL),
(108, 'chuychuyita13@gmail.com', 'CN2023', '2023-11-18 18:13:14', NULL, 0, NULL),
(109, 'fati_rdz0710@outlook.com', 'CN2023', '2023-11-19 08:58:56', NULL, 0, NULL),
(110, 'acosta1karla2@gmail.com', 'CN2023', '2023-11-19 15:00:48', NULL, 0, NULL),
(111, 'danamvera14@gmail.com', 'CN2023', '2023-11-19 18:33:48', NULL, 0, NULL),
(112, 'karlaalegria13@gmail.com', 'CN2023', '2023-11-19 18:43:41', NULL, 0, NULL),
(113, 'odin.pizano_bvb@outlook.com', 'CN2023', '2023-11-20 07:13:27', NULL, 0, NULL),
(114, 'soria.astrid.1999@gmail.com', 'CN2023', '2023-11-20 09:08:57', NULL, 0, NULL),
(115, 'sarale0245@gmail.com', 'CN2023', '2023-11-20 12:08:31', NULL, 0, NULL),
(116, 'karlarebeca1997@gmail.com', 'CN2023', '2023-11-20 13:33:48', NULL, 0, NULL),
(117, 'skholemoore@gmail.com', 'CN2023', '2023-11-20 13:52:22', NULL, 0, NULL),
(118, 'cotu_307@hotmail.com', 'CN2023', '2023-11-20 13:56:04', NULL, 0, NULL),
(119, 'valegarciavelda@gmail.com', 'CN2023', '2023-11-20 14:48:02', NULL, 0, NULL),
(120, 'vlhuerta@outlook.es', 'CN2023', '2023-11-20 15:45:06', NULL, 0, NULL),
(121, 'rommigonzalez1@gmail.com', 'CN2023', '2023-11-20 16:50:01', NULL, 0, NULL),
(122, 'andreacornejoreyes2@gmail.com', 'CN2023', '2023-11-20 17:12:46', NULL, 0, NULL),
(123, 'raque.osoriod@hotmail.com', 'CN2023', '2023-11-20 18:09:48', NULL, 0, NULL),
(124, 'ashleycmlunes@gmail.com', 'CN2023', '2023-11-20 20:59:36', NULL, 0, NULL),
(125, 'chikis8trikis@gmail.com', 'CN2023', '2023-11-20 21:34:09', NULL, 0, NULL),
(126, 'abigail.qa@outlook.es', 'CN2023', '2023-11-20 21:48:51', NULL, 0, NULL),
(127, 'raaee.2619@gmail.com', 'CN2023', '2023-11-20 23:27:53', NULL, 0, NULL),
(128, 'lilusamano@gmail.com', 'CN2023', '2023-11-20 23:47:42', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_gafetes`
--

CREATE TABLE `tabla_gafetes` (
  `id` int(11) NOT NULL,
  `idUsuario` varchar(255) NOT NULL,
  `idPedido` varchar(100) DEFAULT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `diseno` varchar(255) NOT NULL,
  `isPurchased` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tabla_gafetes`
--

INSERT INTO `tabla_gafetes` (`id`, `idUsuario`, `idPedido`, `nombre_archivo`, `diseno`, `isPurchased`) VALUES
(19, 'axelcoreos@gmail.com', 'CD1', '654c9cd3b2732_396697603_1368465770451371_8860579296611084031_n.jpg', '3.jpg', 1),
(20, 'axelcoreos@gmail.com', 'CD1', '654c9d32ce25d_394277243_723202046515766_1939347580035555857_n.jpg', '3.jpg', 1),
(21, 'axelcoreos@gmail.com', 'CD1', '654c9e0cae249_IMG_8732.jpeg', '4.jpg', 1),
(22, 'gabriela.rios.h@hotmail.com', 'CD2', '654cfd51b260e_FB_IMG_1699491891769.jpg', '2.jpg', 1),
(23, 'yazminixchel10@gmail.com', NULL, '654d1c9de8787_inbound4350598947772740298.jpg', '1.jpg', 0),
(24, 'beatriz073022@gmail.com', NULL, '654dd304658c1_inbound1852731776539723882.jpg', '3.jpg', 0),
(26, 'hanniaperalta03@gmail.com', NULL, '65501a1dbc1fe_8A04B842284C435393F8AED778A6EC47.jpeg', '2.jpg', 0),
(27, 'hanniaperalta03@gmail.com', NULL, '6550522825d01_3FE705A0D99F4E9C917F32E4273D33DE.jpeg', '2.jpg', 0),
(28, 'peraltahannia25@gmail.com', 'CD3', '655053d87e8ca_F43AA749DAC248B2BEA76008768C6EE2.jpeg', '2.jpg', 1),
(29, 'yeslar_18@hotmail.com', NULL, '65505d05bf0e3_Screenshot_20231111_230440_WhatsApp.jpg', '4.jpg', 0),
(30, 'harry.izard@gmail.com', NULL, '65522d075954f_inbound1991021953803403283.jpg', '3.jpg', 0),
(31, 'mariafernandarubio54@gmail.com', NULL, '65523d755d550_inbound8622646783313134628.jpg', '4.jpg', 0),
(32, 'betty.grcavila@gmail.com', NULL, '6552ba9a6e2c7_WhatsAppImage20231113at17.39.33.jpeg', '3.jpg', 0),
(33, 'fcpalafoxpsic@hotmail.com', NULL, '65562eb6c307f_inbound2006256440427046512.jpg', '3.jpg', 0),
(35, 'mary_risos@hotmail.com', NULL, '65563a728c9d2_IMG_5993.jpeg', '2.jpg', 0),
(36, 'ale.olmos.140384@gmail.com', 'CD4', '65565457c8c70_inbound358832861396147168.jpg', '4.jpg', 1),
(37, 'ale.olmos.140384@gmail.com', 'CD4', '655654904d234_inbound7718471019430167768.jpg', '4.jpg', 1),
(38, 'lic.nut.alondrasanchez@gmail.com', 'CD5', '65565609e45d5_IMG_7125.heic', '2.jpg', 1),
(41, 'bernalsara14@gmail.com', 'CD6', '65566197bf7d2_IMG_9732.jpeg', '3.jpg', 1),
(42, 'nangmontoya@gmail.com', NULL, '65567d320334b_inbound5271769823716112778.jpg', '1.jpg', 0),
(43, 'axelcoreos@gmail.com', 'CD7', '65567d4c2fbe1_214928781200auto.webp', '3.jpg', 1),
(44, 'huerta_8806@hotmail.com', NULL, '65568b6fa5bbf_inbound3320816272930124977.jpg', '3.jpg', 0),
(45, 'pumas4191@hotmail.com', NULL, '65568dadb1208_inbound480715243664468238.jpg', '2.jpg', 0),
(47, 'bialdo10@yahoo.com.mx', NULL, '6556d76668691_Picsart_230531_222211558.jpg', '4.jpg', 0),
(48, 'g.galvezabrego@gmail.com', 'CD8', '6556ff6e3c702_IMG20231116WA0085.jpg', '3.jpg', 1),
(49, 'monsevanegas@hotmail.com', NULL, '6557137912d63_inbound1658067406334394851.jpg', '1.jpg', 0),
(51, 'espectro.azteca@gmail.com', 'CD9', '65572bf9dbaa3_inbound6094762593653252743.jpg', '2.jpg', 1),
(52, 'espectro.azteca@gmail.com', 'CD10', '65572d410fefc_inbound3415870301310323097.jpg', '2.jpg', 1),
(54, 'lolite.s.m@hotmail.com', NULL, '6557945737e67_20231117_102558_0000_edit_408483038950116.png', '2.jpg', 0),
(57, 'axelcoreos@gmail.com', NULL, '65580a5e3cde1_00780432075008l.webp', '5.jpg', 0),
(58, 'fati_rdz0710@outlook.com', 'CD11', '655a23702e2ed_inbound1414851935287462695.jpg', '2.jpg', 1),
(59, 'acosta1karla2@gmail.com', NULL, '655a78107770f_IMG_3429.jpeg', '4.jpg', 0),
(60, 'odin.pizano_bvb@outlook.com', NULL, '655b5bb2a75a0_inbound5842291250454506300.jpg', '3.jpg', 0),
(61, 'skholemoore@gmail.com', NULL, '655bb9f800d17_IMG_0904.jpeg', '4.jpg', 0),
(63, 'raque.osoriod@hotmail.com', NULL, '655bf6900c48d_inbound5850284384015155816.jpg', '5.jpg', 0),
(64, 'chikis8trikis@gmail.com', NULL, '655c27c9e9c4e_d9e17b9e13224fc38be9d51f0d147e4f.jpeg', '3.jpg', 0),
(65, 'g.galvezabrego@gmail.com', 'CD12', '655c2c1ecba37_IMG20231116WA0085.jpg', '3.jpg', 1),
(67, 'lilusamano@gmail.com', 'CD13', '655c44f89a008_inbound9117320992488571245.jpg', '1.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendas`
--

CREATE TABLE `tiendas` (
  `id` int(11) NOT NULL,
  `idTienda` varchar(28) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombreTienda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `administradoPor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tiendas`
--

INSERT INTO `tiendas` (`id`, `idTienda`, `nombreTienda`, `administradoPor`, `isActive`) VALUES
(1, 'conejondigital', 'Mamá Coneja', 'axelcoreos@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `paterno` varchar(255) DEFAULT NULL,
  `materno` varchar(255) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT current_timestamp(),
  `token` varchar(255) NOT NULL,
  `rol` varchar(10) DEFAULT NULL,
  `fechaActivacion` datetime DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 0,
  `isVerified` int(11) DEFAULT 0,
  `isPartner` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `paterno`, `materno`, `telefono`, `email`, `password`, `fechaRegistro`, `token`, `rol`, `fechaActivacion`, `isActive`, `isVerified`, `isPartner`) VALUES
(5, 'Alfredo Espinoza', NULL, NULL, NULL, 'aespinozabgx@gmail.com', NULL, '2023-08-21 06:42:30', '9028', NULL, NULL, 0, 0, 0),
(6, 'Israel Vázquez G', NULL, NULL, NULL, 'israel.vazquez.gonzalez@outlook.com', 'Zamarel7777$', '2023-08-21 17:00:02', 'NULL', '', '2023-08-21 17:01:06', 1, 0, 0),
(7, 'Gabriela Ríos ', NULL, NULL, NULL, 'gabriela.rios.h@hotmail.com', 'Garihe1990', '2023-09-05 16:18:14', 'NULL', 'admin', '2023-09-05 16:21:12', 1, 0, 1),
(15, 'Miguel Lara eseiza ', NULL, NULL, NULL, 'miguellaraeseiza@gmail.com', '222222', '2023-10-02 16:23:05', 'NULL', '', '2023-10-04 00:33:29', 1, 0, 0),
(16, 'Axel Espinoza', NULL, NULL, NULL, 'axelcoreos@gmail.com', '123', '2023-10-02 20:32:21', 'NULL', 'admin', '2023-10-02 20:33:06', 1, 0, 1),
(17, 'Laura Berenice Resendiz Rodriguez ', NULL, NULL, NULL, 'usagi.lb23@gmail.com', 'Naranjita2317', '2023-10-03 13:49:31', 'NULL', '', '2023-10-03 13:50:09', 1, 0, 0),
(18, 'Jenn Mendoza ', NULL, NULL, NULL, 'jennifermendoza458@gmail.com', '130296', '2023-10-03 14:10:49', 'NULL', '', '2023-10-03 14:11:20', 1, 0, 0),
(19, 'Vanessa', NULL, NULL, NULL, 'vanessa_sg@icloud.com', 'Bunnybo84', '2023-10-03 21:54:55', 'NULL', '', '2023-10-03 21:56:19', 1, 0, 0),
(20, 'Ursula Espinola', NULL, NULL, NULL, 'pepinaymilajo@gmail.com', 'U2ra6zexom', '2023-10-04 08:35:09', 'NULL', '', '2023-10-04 08:35:44', 1, 0, 0),
(21, 'Etni Mendoza', NULL, NULL, NULL, 'chenolpoyo@gmail', NULL, '2023-10-04 09:52:43', '1007', '', NULL, 0, 0, 0),
(22, 'Etni Mendoza', NULL, NULL, NULL, 'chenolpoyo@gmail.com', NULL, '2023-10-04 09:52:58', '6973', '', NULL, 0, 0, 0),
(23, 'Laura Patricia Muñoz Torres ', NULL, NULL, NULL, 'laura.mt942@gmail.com', 'laurapatricia', '2023-10-10 10:28:16', 'NULL', '', '2023-10-10 10:29:17', 1, 0, 0),
(24, 'Reyna Irene Soto Jacinto', NULL, NULL, NULL, 'tfreynasoto@gmail.com', 'Rabbit', '2023-10-10 10:28:21', 'NULL', '', '2023-10-10 10:29:22', 1, 0, 0),
(25, 'Maylet Beltrán ', NULL, NULL, NULL, 'mayletina@hotmail.com', NULL, '2023-10-10 10:28:35', '0455', '', NULL, 0, 0, 0),
(26, 'Merari Marlene Reyes Vigueras ', NULL, NULL, NULL, 'mare_vig@hotmail.com', '100116', '2023-10-10 10:28:59', 'NULL', '', '2023-10-10 10:29:58', 1, 0, 0),
(27, 'Fernanda Tavera Miranda ', NULL, NULL, NULL, 'taveramiranda1989@gmail.com', 'RITOTAVERARRNDON', '2023-10-10 10:29:32', 'NULL', '', '2023-10-24 08:58:23', 1, 0, 0),
(28, 'Arlette Zuleima Molina Rivero ', NULL, NULL, NULL, 'arlette.molina90@gmail.com', 'Riveroleozu9013', '2023-10-10 10:29:39', 'NULL', '', '2023-10-10 10:30:32', 1, 0, 0),
(29, 'Lesly Araceli Nava Sánchez ', NULL, NULL, NULL, 'les.ara.12.9@gmail.com', 'leslyara12', '2023-10-10 10:29:55', 'NULL', '', '2023-10-10 10:30:37', 1, 0, 0),
(30, 'Fernanda Rodríguez ', NULL, NULL, NULL, 'rodmequit1104@gmail.com', 'maicol123', '2023-10-10 10:30:11', 'NULL', '', '2023-10-10 10:31:23', 1, 0, 0),
(31, 'Fatima Olvera Santos ', NULL, NULL, NULL, 'fatimaolverasantos@gmail.com', 'Luca2023', '2023-10-10 10:30:46', 'NULL', '', '2023-10-10 10:31:22', 1, 0, 0),
(32, 'Alma Alejandra Olmos Lision ', NULL, NULL, NULL, 'ale.olmos.140384@gmail.com', 'Italia34', '2023-10-10 10:31:43', 'NULL', '', '2023-10-10 10:32:48', 1, 0, 0),
(33, 'Itxumy Aylin Basurto Vazquez ', NULL, NULL, NULL, 'ja251699@gmail.com', 'panela', '2023-10-10 10:32:51', 'NULL', '', '2023-10-10 10:33:24', 1, 0, 0),
(34, 'Claudia Romo', NULL, NULL, NULL, 'quien_romo@outlook.com', 'Patopato', '2023-10-10 10:33:30', 'NULL', '', '2023-10-10 10:38:16', 1, 0, 0),
(35, 'Karla Yazmin Cruz Rayon ', NULL, NULL, NULL, 'kayacra@gmail.com', '931104', '2023-10-10 10:34:13', 'NULL', '', '2023-10-10 10:34:49', 1, 0, 0),
(36, 'Ana García ', NULL, NULL, NULL, 'anni_rosa@hotmail.com', 'cocoa2306', '2023-10-10 10:34:37', 'NULL', '', '2023-10-10 10:35:40', 1, 0, 0),
(37, 'Jessica luis ', NULL, NULL, NULL, 'jessygu2012@gmail.com', 'Wicho12', '2023-10-10 10:35:32', 'NULL', '', '2023-10-10 10:37:15', 1, 0, 0),
(38, 'Pilar Ortiz Lucas ', NULL, NULL, NULL, 'pilariqaa@gmail.com', 'l0l05_24', '2023-10-10 10:36:18', 'NULL', '', '2023-10-10 10:39:05', 1, 0, 0),
(39, 'Arianne Ríos Hernández ', NULL, NULL, NULL, 'tonalliari@hotmail.com', 'robbie', '2023-10-10 10:38:00', 'NULL', '', '2023-10-10 10:38:51', 1, 0, 0),
(40, 'Keyri', NULL, NULL, NULL, 'keyrinimayer26@gmail.com', '261200key', '2023-10-10 10:40:22', 'NULL', '', '2023-10-10 10:40:53', 1, 0, 0),
(41, 'Leslie Bendeck Lazcano ', NULL, NULL, NULL, 'delfin3082@outlook.com', '071182', '2023-10-10 10:42:34', 'NULL', '', '2023-10-10 10:43:53', 1, 0, 0),
(42, 'Raúl Iván Dávila González', NULL, NULL, NULL, 'dagri_46@hotmail.com', '377iag7..C', '2023-10-10 10:42:35', 'NULL', '', '2023-10-10 10:43:12', 1, 0, 0),
(43, 'Jorge Daniel Gutierrez Avilés ', NULL, NULL, NULL, 'big_dan@live.com.mx', '198612', '2023-10-10 10:44:15', 'NULL', '', '2023-10-10 14:41:59', 1, 0, 0),
(44, 'Cinthia García Arteaga', NULL, NULL, NULL, 'cinthiagrc2889@gmail.com', 'garcia2889', '2023-10-10 10:46:01', 'NULL', '', '2023-10-10 10:46:40', 1, 0, 0),
(45, 'Leonor Reyes Galarza ', NULL, NULL, NULL, 'leonoraRTJM4@hotmail.com', 'leonor123', '2023-10-10 10:49:37', 'NULL', '', '2023-10-10 10:50:30', 1, 0, 0),
(46, 'JAZMIN VEGA', NULL, NULL, NULL, 'jazvega.psico@gmail.com', NULL, '2023-10-10 10:50:35', '3158', '', NULL, 0, 0, 0),
(47, 'Guillermo Rafael Galvez Abrego', NULL, NULL, NULL, 'g.galvezabrego@gmail.com', '130219', '2023-10-10 10:50:41', 'NULL', '', '2023-10-10 10:51:38', 1, 0, 0),
(48, 'JAZMIN VEGA', NULL, NULL, NULL, 'jazpiolin@hotmail.com', 'JAZM1N44', '2023-10-10 10:51:01', 'NULL', '', '2023-10-10 10:55:25', 1, 0, 0),
(49, 'Isabel ', NULL, NULL, NULL, 'isa_als19@hotmail.com', '050383', '2023-10-10 10:51:52', 'NULL', '', '2023-10-10 10:53:27', 1, 0, 0),
(50, 'Coral ', NULL, NULL, NULL, 'coritellezcruz26@gmail.com', 'baticonejo', '2023-10-10 10:52:12', 'NULL', '', '2023-10-10 10:55:36', 1, 0, 0),
(51, 'Claudia Ledesma', NULL, NULL, NULL, 'clauledsgarcia@gmail.com', NULL, '2023-10-10 10:52:20', '6321', '', NULL, 0, 0, 0),
(52, 'Fernanda de la cruz', NULL, NULL, NULL, 'ferdc94@hotmail.com', 'Tokio483', '2023-10-10 10:52:24', 'NULL', '', '2023-10-10 10:53:11', 1, 0, 0),
(53, 'Angelica Hernández ', NULL, NULL, NULL, 'aihp_0208@hotmail.com', 'Morado28', '2023-10-10 10:55:14', 'NULL', '', '2023-10-30 17:23:44', 1, 0, 0),
(54, 'Iris garcia ', NULL, NULL, NULL, 'iris221020fernando@gmail.com', NULL, '2023-10-10 10:57:49', '6116', '', NULL, 0, 0, 0),
(55, 'Mitzi Garcia ', NULL, NULL, NULL, 'mitbotong1704@gmail.com', 'losamoositos', '2023-10-10 11:01:18', 'NULL', '', '2023-10-10 11:02:09', 1, 0, 0),
(56, 'Adrián Martínez ', NULL, NULL, NULL, 'defmoy@hotmail.com', NULL, '2023-10-10 11:02:14', '7726', '', NULL, 0, 0, 0),
(57, 'Valentina Vivanco  ', NULL, NULL, NULL, 'valevivanco165@gmail.com', 'muasval16', '2023-10-10 11:03:22', 'NULL', '', '2023-10-10 11:03:54', 1, 0, 0),
(58, 'Ana Lourdes Pina Cervantes ', NULL, NULL, NULL, 'anilupina@gmail.com', 'Hermosisimo', '2023-10-10 11:03:50', 'NULL', '', '2023-10-10 11:05:42', 1, 0, 0),
(59, 'Paulina Montiel Arias ', NULL, NULL, NULL, 'parias2202@gmail.com', 'mamoniyo0212', '2023-10-10 11:04:54', 'NULL', '', '2023-10-10 11:05:37', 1, 0, 0),
(60, 'ELIZABETH SARA MEDINA LOPEZ', NULL, NULL, NULL, 'esmlopez24@gmail.com', 'Interpol2323', '2023-10-10 11:05:24', 'NULL', '', '2023-10-10 11:06:19', 1, 0, 0),
(61, 'Annie Jalomo ', NULL, NULL, NULL, 'angelesjalomo4@gmail.com', 'annie19', '2023-10-10 11:06:16', 'NULL', '', '2023-10-10 11:06:58', 1, 0, 0),
(62, 'Angie Avellaneda', NULL, NULL, NULL, 'kattystephany@gmail.com', 'Kakiri21', '2023-10-10 11:07:14', 'NULL', '', '2023-10-10 11:07:35', 1, 0, 0),
(63, 'Jennifer Lucía Chiché Ruiz ', NULL, NULL, NULL, 'jennifer204ruiz@gmail.com', NULL, '2023-10-10 11:08:03', '9777', '', NULL, 0, 0, 0),
(64, 'Julieta Juárez Gutiérrez ', NULL, NULL, NULL, 'julietita03@hotmail.com', 'R5Family248', '2023-10-10 11:09:29', 'NULL', '', '2023-10-10 11:10:06', 1, 0, 0),
(65, 'Diana Cordova', NULL, NULL, NULL, 'dianalaucordova@gmail.com', 'Marley26', '2023-10-10 11:09:44', 'NULL', '', '2023-10-10 11:10:21', 1, 0, 0),
(66, 'Jennifer Alexandra Sosa Cervantes ', NULL, NULL, NULL, 'jeal_sc94@outlook.com', '051194', '2023-10-10 11:36:16', 'NULL', '', '2023-10-10 11:41:31', 1, 0, 0),
(67, 'Ashley sayuri beristain ', NULL, NULL, NULL, 'sayuri6690@gmail.com', 'Sayuri6690', '2023-10-10 11:36:59', 'NULL', '', '2023-10-10 11:37:39', 1, 0, 0),
(68, 'Pachito Gómez Mont Fernández y Sánchez ', NULL, NULL, NULL, 'pumakristen208@hotmail.com', 'Pachito2803', '2023-10-10 11:39:55', 'NULL', '', '2023-10-10 11:42:38', 1, 0, 0),
(69, 'Fabiola Ivonne Yépez Alfaro', NULL, NULL, NULL, 'miss_yepez@hotmail.com', 'Hamasaki1', '2023-10-10 11:40:04', 'NULL', '', '2023-10-10 11:41:35', 1, 0, 0),
(70, 'Aline', NULL, NULL, NULL, 'alinearteaga62@gmail.com', 'Aline1993', '2023-10-10 11:40:49', 'NULL', '', '2023-10-10 11:41:09', 1, 0, 0),
(71, 'Brenda', NULL, NULL, NULL, 'bren_rs@hotmail.com', 'gordos', '2023-10-10 11:41:43', 'NULL', '', '2023-10-10 11:43:07', 1, 0, 0),
(72, 'Ana Laura ', NULL, NULL, NULL, 'lauraserna5600@gmail.com', NULL, '2023-10-10 11:44:23', '5345', '', NULL, 0, 0, 0),
(73, 'Fatima Nohemí Sánchez Alvarado ', NULL, NULL, NULL, 'fatiiiiyoi13@gmail.com', 'Yuri&Vikto1', '2023-10-10 11:46:18', 'NULL', '', '2023-10-10 11:46:55', 1, 0, 0),
(74, 'Verónica Jiménez ', NULL, NULL, NULL, 'ronyjimnz@hotmail.com', 'VERO10', '2023-10-10 11:50:35', 'NULL', '', '2023-10-10 11:51:32', 1, 0, 0),
(75, 'Bamby ', NULL, NULL, NULL, 'valenciayuris848@gmail.com', '123456', '2023-10-10 11:50:36', 'NULL', '', '2023-10-10 11:51:12', 1, 0, 0),
(76, 'Sara Margarita García Cuanalo ', NULL, NULL, NULL, 'sara17cuanalo@gmail.com', 'parchi12', '2023-10-10 11:50:48', 'NULL', '', '2023-10-10 20:03:04', 1, 0, 0),
(77, 'Ismael Vázquez ', NULL, NULL, NULL, 'mayelo5089@gmail.com', 'Isma1299', '2023-10-10 11:51:19', 'NULL', '', '2023-10-10 11:54:22', 1, 0, 0),
(78, 'Félix Alejandro GUILLERMO YAPIAS ', NULL, NULL, NULL, 'Alex_8_f@hotmail.com', NULL, '2023-10-10 11:54:23', '0806', '', NULL, 0, 0, 0),
(79, 'Fabiola Sánchez ', NULL, NULL, NULL, 'ursulaconeja@gmail.com', 'ivonne', '2023-10-10 11:57:24', 'NULL', '', '2023-10-10 13:34:12', 1, 0, 0),
(80, 'Erika valtierra ', NULL, NULL, NULL, 'erikaval307@hotmail.com', '1804', '2023-10-10 11:59:07', 'NULL', '', '2023-10-10 12:02:35', 1, 0, 0),
(81, 'Lizbeth sanjuan hernandez', NULL, NULL, NULL, 'lizbeth_hdez12@hotmail.com', 'Liiz310702', '2023-10-10 12:00:41', 'NULL', '', '2023-10-10 12:01:50', 1, 0, 0),
(82, 'Tequila Konijn', NULL, NULL, NULL, 'naidumadera@gmail.com', 'Tequila', '2023-10-10 12:02:01', 'NULL', '', '2023-10-10 12:02:23', 1, 0, 0),
(83, 'Donagit Luna', NULL, NULL, NULL, 'donagit_luna@hotmail', NULL, '2023-10-10 12:04:57', '0987', '', NULL, 0, 0, 0),
(84, 'Jesus de los santos', NULL, NULL, NULL, 'atton10@hotmail.com', 'Slayers3', '2023-10-10 12:05:23', 'NULL', '', '2023-10-10 12:06:57', 1, 0, 0),
(85, 'Donagit Luna ', NULL, NULL, NULL, 'donagit_luna@hotmail.com', 'Bech7483', '2023-10-10 12:05:25', 'NULL', '', '2023-11-09 16:32:27', 1, 0, 0),
(86, 'Cintia', NULL, NULL, NULL, 'cintia-mc@hotmail.com', '25604532n', '2023-10-10 12:05:34', 'NULL', '', '2023-10-10 12:08:47', 1, 0, 0),
(87, 'Samantha Hernández', NULL, NULL, NULL, 'smichelleahernandez00@gmail.com', 'Sadam2135', '2023-10-10 12:06:59', 'NULL', '', '2023-10-10 12:07:30', 1, 0, 0),
(88, 'Nayelli Gómez perez ', NULL, NULL, NULL, 'nayelliperez06@gmail.com', 'kokoa0517', '2023-10-10 12:07:37', 'NULL', '', '2023-10-10 12:08:27', 1, 0, 0),
(89, 'Sandra Nallely Herrera Cruz ', NULL, NULL, NULL, 'sandranallely0609@gmail.com', 'titito2021', '2023-10-10 12:09:03', 'NULL', '', '2023-10-10 12:11:26', 1, 0, 0),
(90, 'Adriana', NULL, NULL, NULL, 'blancheyura@gmail.com', 'Nana1502', '2023-10-10 12:12:24', 'NULL', '', '2023-10-10 12:13:13', 1, 0, 0),
(91, 'Ana Enciso ', NULL, NULL, NULL, 'ana.encisog@hotmail.com', '310891', '2023-10-10 12:13:48', 'NULL', '', '2023-10-10 12:14:44', 1, 0, 0),
(92, 'Liz', NULL, NULL, NULL, 'lizarrache@gmail.com', '05107818', '2023-10-10 12:15:37', 'NULL', '', '2023-10-10 12:16:09', 1, 0, 0),
(93, 'Priscila Córdova ', NULL, NULL, NULL, 'pryscillacordova27@gmail.com', 'Buggs1210', '2023-10-10 12:25:44', 'NULL', '', '2023-10-10 12:27:02', 1, 0, 0),
(94, 'Yukari segura Negrete ', NULL, NULL, NULL, 'yukariseguranegrete@gmail.com', 'tamboras0299', '2023-10-10 12:25:59', 'NULL', '', '2023-10-10 12:26:38', 1, 0, 0),
(95, 'Francisco Javier Moreno Rodríguez ', NULL, NULL, NULL, 'franrodri2089@gmail.com', 'cecybj', '2023-10-10 12:32:29', 'NULL', '', '2023-10-10 12:33:52', 1, 0, 0),
(96, 'Mauricio Sánchez Govea ', NULL, NULL, NULL, 'mauriciogovz@gmail.com', 'Puchuni', '2023-10-10 12:36:52', 'NULL', '', '2023-10-10 12:37:47', 1, 0, 0),
(97, 'Lorena Hernández ', NULL, NULL, NULL, 'airavir@hotmail.com', 'LoJo1708', '2023-10-10 12:37:19', 'NULL', '', '2023-10-10 12:38:45', 1, 0, 0),
(98, 'Fabiola Pozos ', NULL, NULL, NULL, 'fabi_unam@hotmail.com', '131409', '2023-10-10 12:37:33', 'NULL', '', '2023-10-10 12:38:28', 1, 0, 0),
(99, 'Erwin Francisco Bautista', NULL, NULL, NULL, 'Sabatt.black@gmail.com', 'Magaly06', '2023-10-10 12:38:40', 'NULL', '', '2023-10-10 12:39:22', 1, 0, 0),
(100, 'Missael ', NULL, NULL, NULL, 'missael150196@outlook.com', 'decatlon15', '2023-10-10 12:45:57', 'NULL', '', '2023-10-10 12:46:40', 1, 0, 0),
(101, 'Soledad', NULL, NULL, NULL, 'solcito014@gmail.com', 'lacurva6161', '2023-10-10 12:54:07', 'NULL', '', '2023-10-10 12:54:41', 1, 0, 0),
(102, 'Lucero Berenice Garnica Rodríguez ', NULL, NULL, NULL, 'lucasmilyteodoz@gmail.com', NULL, '2023-10-10 12:59:06', '4425', '', NULL, 0, 0, 0),
(103, 'SANDRA ILLESCAS', NULL, NULL, NULL, 'sandillescas26@gmail.com', 'sandra26', '2023-10-10 13:02:13', 'NULL', '', '2023-10-10 13:02:40', 1, 0, 0),
(104, 'Mariana Feregrino Sánchez ', NULL, NULL, NULL, 'marianapink.mf@gmail.com', 'Sasho2122', '2023-10-10 13:03:07', 'NULL', '', '2023-10-10 13:03:31', 1, 0, 0),
(105, 'Alondra Rico Sanchez', NULL, NULL, NULL, 'lic.nut.alondrasanchez@gmail.com', 'Burbuj@2020', '2023-10-10 13:03:24', 'NULL', '', '2023-10-10 13:03:57', 1, 0, 0),
(106, 'Ariadna Gómez Carrión ', NULL, NULL, NULL, 'aria.dna@outlook.com', 'Arihagne18110921', '2023-10-10 13:05:51', 'NULL', '', '2023-10-10 13:26:42', 1, 0, 0),
(107, 'Valeria Amarel Ximenez Flores', NULL, NULL, NULL, 'amarelximenez@gmail.com', NULL, '2023-10-10 13:07:11', '7967', '', NULL, 0, 0, 0),
(108, 'Valeria Amarel Ximenez Flores', NULL, NULL, NULL, 'amarelramosximenez10@gmail.com', 'Chemita005', '2023-10-10 13:09:22', 'NULL', '', '2023-10-10 13:10:59', 1, 0, 0),
(109, 'Gina Aguilar ', NULL, NULL, NULL, 'georgina.ma@ucad.edu.mx', NULL, '2023-10-10 13:18:51', '0987', '', NULL, 0, 0, 0),
(110, 'Vanesa rubio', NULL, NULL, NULL, 'vanesarubio1010@gmail.com', 'madelyn16', '2023-10-10 13:20:36', 'NULL', '', '2023-10-10 13:21:07', 1, 0, 0),
(111, 'Gina Aguilar ', NULL, NULL, NULL, 'georgina_18@live.com.mx', NULL, '2023-10-10 13:22:43', '2205', '', NULL, 0, 0, 0),
(112, 'Saraí García', NULL, NULL, NULL, 'dsarai.gv@hotmail.es', 'lovyadotty', '2023-10-10 13:23:01', 'NULL', '', '2023-10-10 13:23:43', 1, 0, 0),
(113, 'Felipe Hernandez U', NULL, NULL, NULL, 'bobesfel@live.com.mx', 'Feli56854433', '2023-10-10 13:24:59', 'NULL', '', '2023-10-10 13:26:44', 1, 0, 0),
(114, 'Gina Aguilar ', NULL, NULL, NULL, 'mansongirl12@gmail.com', 'nachito18', '2023-10-10 13:26:08', 'NULL', '', '2023-10-10 13:28:28', 1, 0, 0),
(115, 'Karla Anahí Sánchez Morales', NULL, NULL, NULL, 'kasm280999@gmail.com', '2665kasm', '2023-10-10 13:31:04', 'NULL', '', '2023-10-10 13:31:30', 1, 0, 0),
(116, 'Miguel Angel Rodriguez Vega ', NULL, NULL, NULL, 'mike50899@gmail.com', 'Suzuki1300', '2023-10-10 13:37:31', 'NULL', '', '2023-10-10 13:39:30', 1, 0, 0),
(117, 'ERIKA HERNÁNDEZ CASTILLO ', NULL, NULL, NULL, 'kastillo28@hotmail.com', 'M@zinngerZ4', '2023-10-10 13:37:48', 'NULL', '', '2023-10-10 13:41:36', 1, 0, 0),
(118, 'Tania Guadalupe Bernardino Guerrero ', NULL, NULL, NULL, 'bernardinotania27@gmail.com', 'AustinDanna', '2023-10-10 13:38:36', 'NULL', '', '2023-10-10 13:41:14', 1, 0, 0),
(119, 'Ericka Sánchez zavala ', NULL, NULL, NULL, 'rojiblanca14213@gmail.com', 'Razi1427', '2023-10-10 13:39:31', 'NULL', '', '2023-10-10 13:40:04', 1, 0, 0),
(120, 'Martha Elizabeth Ramírez Olvera', NULL, NULL, NULL, 'maliz99952@gmail.com', 'blabon999333', '2023-10-10 13:42:09', 'NULL', '', '2023-10-10 13:48:44', 1, 0, 0),
(121, 'Marisol Tirado Cortez', NULL, NULL, NULL, 'mar.grunge.fran@hotmail.com', 'cheñolconejo', '2023-10-10 13:42:21', 'NULL', '', '2023-11-08 08:06:11', 1, 0, 0),
(122, 'Luis Antonio Martínez ', NULL, NULL, NULL, 'luismtz3271@hotmail.com', NULL, '2023-10-10 13:44:28', '2334', '', NULL, 0, 0, 0),
(123, 'Evelin Chimal Garcia', NULL, NULL, NULL, 'evelinchg26@gmail.com', 'Tolouse23', '2023-10-10 13:47:26', 'NULL', '', '2023-10-10 13:48:04', 1, 0, 0),
(124, 'Jazmín Escalante Castillo ', NULL, NULL, NULL, 'jazmin.eacj@gmail.com', 'Ardillita11', '2023-10-10 13:51:53', 'NULL', '', '2023-10-10 13:52:28', 1, 0, 0),
(125, 'Erika ', NULL, NULL, NULL, 'erikasias4@gmail.com', '230214', '2023-10-10 14:01:19', 'NULL', '', '2023-10-10 14:02:06', 1, 0, 0),
(126, 'Aylin Osiris López Sánchez ', NULL, NULL, NULL, 'aylinpoeta@gmail.com', 'jimb0nas10', '2023-10-10 14:15:41', 'NULL', '', '2023-10-10 14:16:12', 1, 0, 0),
(127, 'Atzin Rosas', NULL, NULL, NULL, 'atzinrosas24@gmail.com', 'Zamurabu1995', '2023-10-10 14:34:07', 'NULL', '', '2023-10-10 14:35:01', 1, 0, 0),
(128, 'Jorge Alberto Sánchez Cruz', NULL, NULL, NULL, 'jalbertoc99@gmail.com', '081499', '2023-10-10 14:34:13', 'NULL', '', '2023-10-10 14:34:57', 1, 0, 0),
(129, 'César Alzaga', NULL, NULL, NULL, 'cesar_050205@hotmail.com', 'corazon', '2023-10-10 14:36:43', 'NULL', '', '2023-10-10 14:40:13', 1, 0, 0),
(130, 'César ', NULL, NULL, NULL, 'logistica.mx@ubscode.com', NULL, '2023-10-10 14:38:24', '2255', '', NULL, 0, 0, 0),
(131, 'Yani', NULL, NULL, NULL, 'yanira.everlast@gmail.com', NULL, '2023-10-10 14:41:06', '5535', '', NULL, 0, 0, 0),
(132, 'Nancy Becerril', NULL, NULL, NULL, 'nanisnancy7@gmail.com', '593291', '2023-10-10 14:46:24', 'NULL', '', '2023-10-10 14:46:48', 1, 0, 0),
(133, 'Valeria Ambriz Flores ', NULL, NULL, NULL, 'valeria06af@gmail.com', 'v4l3ry06AF', '2023-10-10 14:48:20', 'NULL', '', '2023-10-10 14:49:02', 1, 0, 0),
(134, 'Ariana Tapia', NULL, NULL, NULL, 'usagiari@hotmail.com', 'copito1204', '2023-10-10 14:48:22', 'NULL', '', '2023-10-10 14:48:48', 1, 0, 0),
(135, 'María Teresa Pina Cervantes ', NULL, NULL, NULL, 'maria.pinac@outlook.com', 'Bolita', '2023-10-10 14:58:44', 'NULL', '', '2023-10-10 14:59:27', 1, 0, 0),
(136, 'Maribel Flores Flores ', NULL, NULL, NULL, 'mrsvioletparanoia@gmail.com', 'H&Klove*7', '2023-10-10 15:06:55', 'NULL', '', '2023-10-10 15:07:37', 1, 0, 0),
(137, 'Elizabeth loredo estrada', NULL, NULL, NULL, 'lizi-lo-e@hotmail.com', '123456#', '2023-10-10 15:12:42', 'NULL', '', '2023-10-10 15:13:50', 1, 0, 0),
(138, 'Diana', NULL, NULL, NULL, 'diana.gbr@gmsil.com', NULL, '2023-10-10 15:13:14', '0457', '', NULL, 0, 0, 0),
(139, 'Vanny Gisselle Sandoval Padilla', NULL, NULL, NULL, 'vannysan12@hotmail.com', 'bernand9', '2023-10-10 15:13:52', 'NULL', '', '2023-10-10 15:15:31', 1, 0, 0),
(140, 'Diana', NULL, NULL, NULL, 'diana.gbr@gmail.com', 'Zoebb', '2023-10-10 15:19:31', 'NULL', '', '2023-10-10 15:46:13', 1, 0, 0),
(141, 'Abigail Romero ', NULL, NULL, NULL, 'abigailromeroh@gmail.com', '11021983', '2023-10-10 15:22:19', 'NULL', '', '2023-10-10 15:24:18', 1, 0, 0),
(142, 'Juan Carlos ', NULL, NULL, NULL, 'jcjacinto1982@gmail.com', 'selene16', '2023-10-10 15:25:55', 'NULL', '', '2023-10-10 15:26:40', 1, 0, 0),
(143, 'Teresa', NULL, NULL, NULL, 'tere.djsa@gmail.com', NULL, '2023-10-10 15:34:42', '6116', '', NULL, 0, 0, 0),
(144, 'Evelyn Gutiérrez ', NULL, NULL, NULL, 'evecucue@hotmail.com', 'Dany050903', '2023-10-10 15:38:58', 'NULL', '', '2023-10-10 15:39:48', 1, 0, 0),
(145, 'Monserrat Vanegas Cuevas ', NULL, NULL, NULL, 'monsevanegas@hotmail.com', 'yolotzin2800', '2023-10-10 15:59:50', 'NULL', '', '2023-10-10 16:03:30', 1, 0, 0),
(146, 'Hillary ', NULL, NULL, NULL, 'iranayalaa@gmail.com', 'Aguadelima20', '2023-10-10 16:12:11', 'NULL', '', '2023-10-10 16:13:11', 1, 0, 0),
(147, 'Maria Fernanda Mendoza ', NULL, NULL, NULL, 'imaryfer@yahoo.com.mx', '1991', '2023-10-10 16:14:16', 'NULL', '', '2023-10-10 16:14:48', 1, 0, 0),
(148, 'Jessica itzel Perez chavez ', NULL, NULL, NULL, 'itzyperez.27@gmail.com', 'santiago27', '2023-10-10 16:24:23', 'NULL', '', '2023-10-10 16:24:59', 1, 0, 0),
(149, 'Alasha Nahoni Flores Ramírez ', NULL, NULL, NULL, 'alasha.r@outlook.com', NULL, '2023-10-10 16:27:59', '9249', '', NULL, 0, 0, 0),
(150, 'Aira M Pérez Martínez ', NULL, NULL, NULL, 'aira.pmartinez@gmail.com', '99231880', '2023-10-10 16:32:14', 'NULL', '', '2023-10-10 16:32:47', 1, 0, 0),
(151, 'Esmeralda Martinez ', NULL, NULL, NULL, 'esmeetinez@gmail.com', 'bonnie', '2023-10-10 16:33:38', 'NULL', '', '2023-10-10 16:34:31', 1, 0, 0),
(152, 'Oscar Zepeda', NULL, NULL, NULL, 'Oscarzm1981@gmail.com', 'Tecate01', '2023-10-10 16:39:29', 'NULL', '', '2023-10-10 16:40:27', 1, 0, 0),
(153, 'Mariana Fiesco Cardenas ', NULL, NULL, NULL, 'mariana.fiesco.c@gmail.com', '01171510.', '2023-10-10 16:47:26', 'NULL', '', '2023-10-15 18:22:41', 1, 0, 0),
(154, 'Rayas', NULL, NULL, NULL, 'basigsan2@gmail.com', 'CULITO', '2023-10-10 17:10:16', 'NULL', '', '2023-10-10 17:11:03', 1, 0, 0),
(155, 'Marco Antonio Sabas González ', NULL, NULL, NULL, 'maskevil27@gmail.com', '81081327', '2023-10-10 17:27:31', 'NULL', '', '2023-10-10 17:29:57', 1, 0, 0),
(156, 'Julieta Ávila', NULL, NULL, NULL, 'jjjjulieta92@gmail.com', 'juls121091', '2023-10-10 17:30:46', 'NULL', '', '2023-10-10 17:31:14', 1, 0, 0),
(157, 'Yessica Salvador', NULL, NULL, NULL, 'bettyboop31@live.com', NULL, '2023-10-10 17:34:34', '1653', '', NULL, 0, 0, 0),
(158, 'Yessica Salvador', NULL, NULL, NULL, 'bettyboop31@live.com.com.mx', NULL, '2023-10-10 17:34:51', '3310', '', NULL, 0, 0, 0),
(159, 'Karla Guadalupe  Casas de Jesús ', NULL, NULL, NULL, 'karlyhouse16@gmail.com', 'karly0702', '2023-10-10 17:35:48', 'NULL', '', '2023-10-10 17:36:33', 1, 0, 0),
(160, 'Esmeralda ', NULL, NULL, NULL, 'jadenet33@gmail.com', 'Amairany', '2023-10-10 17:36:51', 'NULL', '', '2023-10-10 17:38:01', 1, 0, 0),
(161, 'Yessica Salvador', NULL, NULL, NULL, 'yessica.salvador.tolentino@correo.cjf.gob.mx', NULL, '2023-10-10 17:37:53', '2246', '', NULL, 0, 0, 0),
(162, 'Daniela Estrada ', NULL, NULL, NULL, 'dany.estrada.1711@gmail.com', 'Estrada7', '2023-10-10 17:38:46', 'NULL', '', '2023-10-10 18:28:03', 1, 0, 0),
(163, 'Jeshua', NULL, NULL, NULL, 'jealsaav11@gmail.com', 'manin1', '2023-10-10 17:40:01', 'NULL', '', '2023-10-10 17:48:03', 1, 0, 0),
(164, 'Yessica Salvador', NULL, NULL, NULL, 'segurosjst@gmail.com', 'Roma131122', '2023-10-10 17:40:02', 'NULL', '', '2023-10-10 17:40:29', 1, 0, 0),
(165, 'XIMENA NÚÑEZ ', NULL, NULL, NULL, 'Aneemix2805@gmail.com', 'Bonie28', '2023-10-10 17:44:17', 'NULL', '', '2023-10-10 17:45:09', 1, 0, 0),
(166, 'Litzy Urueta ', NULL, NULL, NULL, 'litzysweed@gmail.com', 'litzyxd123', '2023-10-10 17:55:02', 'NULL', '', '2023-10-10 17:55:32', 1, 0, 0),
(167, 'Katya Aguila ', NULL, NULL, NULL, 'fabilaj977@gmail.com', 'Pelusa03', '2023-10-10 17:55:18', 'NULL', '', '2023-10-10 17:55:53', 1, 0, 0),
(168, 'Blanca Abigail Cervantes Barrios ', NULL, NULL, NULL, 'habbycervantes@gmail.com', 'Ba2247912', '2023-10-10 17:58:15', 'NULL', '', '2023-10-10 18:00:14', 1, 0, 0),
(169, 'Deyanira González', NULL, NULL, NULL, 'deya.gb1989@gmail.com', 'Lover13', '2023-10-10 18:06:16', 'NULL', '', '2023-10-10 18:06:45', 1, 0, 0),
(170, 'Constantino Castro', NULL, NULL, NULL, 'arconscorp@gmail.com', '910023', '2023-10-10 18:10:43', 'NULL', '', '2023-10-10 18:11:27', 1, 0, 0),
(171, 'Dani Mejia', NULL, NULL, NULL, 'danis.meyia@gmail.com', 'Changoleon2401', '2023-10-10 18:16:24', 'NULL', '', '2023-10-10 18:18:15', 1, 0, 0),
(172, 'Fanny gallegos ', NULL, NULL, NULL, 'gallegosfanny806@gmail.com', '20082019', '2023-10-10 18:24:16', 'NULL', '', '2023-10-10 18:24:45', 1, 0, 0),
(173, 'Viridiana Montero ', NULL, NULL, NULL, 'vi.monteroe@gmail.com', '17122019', '2023-10-10 18:32:07', 'NULL', '', '2023-10-10 18:32:53', 1, 0, 0),
(174, 'Karla Rebeca Ávila Carrasco', NULL, NULL, NULL, 'karlarebeca1997@gmail.com', '20feb1998', '2023-10-10 18:39:51', 'NULL', '', '2023-11-20 13:33:48', 1, 0, 0),
(175, 'Iliana Cazares', NULL, NULL, NULL, 'cazilicam@outlook.com', NULL, '2023-10-10 18:42:13', '8333', '', NULL, 0, 0, 0),
(176, 'Iliana Cazares', NULL, NULL, NULL, 'cazilicam@gmail.com', 'RichCam79', '2023-10-10 18:43:01', 'NULL', '', '2023-10-10 18:44:32', 1, 0, 0),
(177, 'Edith ', NULL, NULL, NULL, 'eemarquez81@hotmail.com', '050618', '2023-10-10 18:43:02', 'NULL', '', '2023-10-10 18:46:06', 1, 0, 0),
(178, 'Ana Vargas ', NULL, NULL, NULL, 'anna.urbina90@outlook.com', '011190', '2023-10-10 18:46:36', 'NULL', '', '2023-10-10 18:47:43', 1, 0, 0),
(179, 'Fátima Rodríguez ', NULL, NULL, NULL, 'fati_rdz0710@outlook.com', 'Sao.3847', '2023-10-10 18:50:21', 'NULL', '', '2023-10-10 18:57:41', 1, 0, 0),
(180, 'Sandra Dávila ', NULL, NULL, NULL, 'psic.sandradavila@gmail.com', 'Sandyl84', '2023-10-10 19:02:50', 'NULL', '', '2023-10-21 19:18:20', 1, 0, 0),
(181, 'Nancy Ivonne ', NULL, NULL, NULL, 'nanvarelamax@gmail.com', 'Maximiliano2130', '2023-10-10 19:13:02', 'NULL', '', '2023-10-10 19:13:30', 1, 0, 0),
(182, 'Abigail Gómez Angeles ', NULL, NULL, NULL, 'angeles.vanessa99@gmail.com', 'Nita1122', '2023-10-10 19:17:22', 'NULL', '', '2023-10-10 19:18:57', 1, 0, 0),
(183, 'Fernanda Davalos', NULL, NULL, NULL, 'ferdaval@yahoo.com.mx', 'Nico1985', '2023-10-10 19:18:14', 'NULL', '', '2023-10-10 19:20:23', 1, 0, 0),
(184, 'Lorena Córdova ', NULL, NULL, NULL, 'loorzcordova@gmail.com', 'Moshi27.', '2023-10-10 19:21:37', 'NULL', '', '2023-10-10 19:22:05', 1, 0, 0),
(185, 'Bonitila', NULL, NULL, NULL, 'jackie_jmj@live.com', 'Jackie8921', '2023-10-10 19:24:29', 'NULL', '', '2023-10-10 19:26:27', 1, 0, 0),
(186, 'Nancy Alpuing', NULL, NULL, NULL, 'naalp2199@gmail.com', 'Benito', '2023-10-10 19:52:20', 'NULL', '', '2023-10-10 19:52:41', 1, 0, 0),
(187, 'Britanny Rodriguez torres ', NULL, NULL, NULL, 'britanny_rodriguez2526@hotmail.com', '260293BRT', '2023-10-10 20:01:04', 'NULL', '', '2023-10-10 20:02:01', 1, 0, 0),
(188, 'Yazmin Lara gonzalez', NULL, NULL, NULL, 'yazytavo@hotmail.com', 'superman15', '2023-10-10 20:07:41', 'NULL', '', '2023-10-10 21:26:58', 1, 0, 0),
(189, 'Elizabeth Román Zárate ', NULL, NULL, NULL, 'elizaroman1510@gmail.com', '1328', '2023-10-10 20:09:06', 'NULL', '', '2023-10-10 20:09:33', 1, 0, 0),
(190, 'Lupita  rubio', NULL, NULL, NULL, 'guadaluperubioreyes31@gmail.com', '123456y', '2023-10-10 20:18:52', 'NULL', '', '2023-10-10 20:19:31', 1, 0, 0),
(191, 'Iris Yoselin Garcia Perez ', NULL, NULL, NULL, 'iris.puqkita@gmail.com', 'Maxi2468', '2023-10-10 20:25:44', 'NULL', '', '2023-10-10 20:26:27', 1, 0, 0),
(192, 'Jessica ', NULL, NULL, NULL, 'jessi.mun.vaz3264@gmail.com', '326454', '2023-10-10 20:37:09', 'NULL', '', '2023-10-10 20:39:10', 1, 0, 0),
(193, 'Sarvia Margarita Pérez Ruiz ', NULL, NULL, NULL, 'magui222513@gmail.com', '220204', '2023-10-10 20:39:53', 'NULL', '', '2023-10-10 20:40:36', 1, 0, 0),
(194, 'Reyes Castillo Diana Michelle ', NULL, NULL, NULL, 'dianucha99@gmail.com', 'asdfgnlkjh', '2023-10-10 20:40:16', 'NULL', '', '2023-10-10 20:41:03', 1, 0, 0),
(195, 'Emmanuel Hernandez', NULL, NULL, NULL, 'Emmanuelhdez97@outlook.com', 'genios15', '2023-10-10 20:48:25', 'NULL', '', '2023-10-10 20:53:02', 1, 0, 0),
(196, 'Diego Germán Sandoval Rosas ', NULL, NULL, NULL, 'diegosandoval282@outlook.com', '318343', '2023-10-10 20:51:47', 'NULL', '', '2023-10-10 20:52:27', 1, 0, 0),
(197, 'Jessica Peñaloza Terrazas ', NULL, NULL, NULL, 'bunibunx3@gmail.com', 'bunibun14', '2023-10-10 20:55:14', 'NULL', '', '2023-10-10 20:56:22', 1, 0, 0),
(198, 'Paola Bermudez Lazcano ', NULL, NULL, NULL, 'paola_205@msn.com', 'paola22102014', '2023-10-10 21:01:13', 'NULL', '', '2023-10-10 21:01:53', 1, 0, 0),
(199, 'Jazmib agueros', NULL, NULL, NULL, 'jazminagueros@gmail.com', 'fluff2426', '2023-10-10 21:17:08', 'NULL', '', '2023-10-10 21:17:46', 1, 0, 0),
(200, 'Karla Vázquez Marcos', NULL, NULL, NULL, 'karla.marks15@gmail.com', '150818', '2023-10-10 21:19:51', 'NULL', '', '2023-10-10 21:20:11', 1, 0, 0),
(201, 'Itzel Casas B ', NULL, NULL, NULL, 'la_sisi@hotmail.com', 'Minimo13', '2023-10-10 21:25:02', 'NULL', '', '2023-10-10 21:27:48', 1, 0, 0),
(202, 'Dulce Pineda ', NULL, NULL, NULL, 'djossenely.pineda@gmail.com', 'savp2516', '2023-10-10 21:26:51', 'NULL', '', '2023-10-10 21:27:37', 1, 0, 0),
(203, 'Monserrat Gea ', NULL, NULL, NULL, 'eclipse_ec17@hotmail.com', '110194', '2023-10-10 21:38:51', 'NULL', '', '2023-10-10 21:40:17', 1, 0, 0),
(204, 'Brenda San Luis ', NULL, NULL, NULL, 'epo267.brendasanluiscastillo@gmail.com', 'bs020920', '2023-10-10 22:27:16', 'NULL', '', '2023-10-10 22:29:04', 1, 0, 0),
(205, 'Jonathan Tellez Lagunas', NULL, NULL, NULL, 'nathanzellet@gmail.com', 'Sauris.97', '2023-10-10 22:29:58', 'NULL', '', '2023-10-10 22:30:41', 1, 0, 0),
(206, 'Diana Evelyn Mendoza Lorenzo ', NULL, NULL, NULL, 'dm13le.bae@gmail.com', 'quesitolindo', '2023-10-10 22:39:11', 'NULL', '', '2023-10-10 22:39:37', 1, 0, 0),
(207, 'Jimena Romero ', NULL, NULL, NULL, 'jimenacanchola271102@gmail.com', 'Jime2711', '2023-10-10 23:40:12', 'NULL', '', '2023-10-10 23:40:44', 1, 0, 0),
(208, 'Zaira Moncayo ', NULL, NULL, NULL, 'zaira.gmn@gmail.com', 'Makena123', '2023-10-11 00:32:47', 'NULL', '', '2023-10-11 00:33:20', 1, 0, 0),
(209, 'Diana Zamora Castro', NULL, NULL, NULL, 'zdiana256@gmail.com', '210780', '2023-10-11 00:35:54', 'NULL', '', '2023-10-11 00:37:06', 1, 0, 0),
(210, 'Tzintli Nikte Tobón Vazquez ', NULL, NULL, NULL, 'tzinredfield@gmail.com', 'Chris051004', '2023-10-11 01:35:38', 'NULL', '', '2023-10-11 01:36:32', 1, 0, 0),
(211, 'Luis Alberto Gamez ', NULL, NULL, NULL, 'worldgh@hotmail.com', 'conejosrabito', '2023-10-11 01:56:03', 'NULL', '', '2023-10-11 02:00:02', 1, 0, 0),
(212, 'Melisa Ávila ', NULL, NULL, NULL, 'melisacelina04@gmail.com', 'meli181201', '2023-10-11 02:13:42', 'NULL', '', '2023-10-11 02:14:38', 1, 0, 0),
(213, 'Karina monje', NULL, NULL, NULL, 'monmargabi27@gmail.com', 'monje2027', '2023-10-11 02:17:10', 'NULL', '', '2023-10-11 02:18:02', 1, 0, 0),
(214, 'Sofía Antonia Quezada Maldonado', NULL, NULL, NULL, 'squezadamaldonado@gmail.com', 'SaQM**270419', '2023-10-11 07:19:44', 'NULL', '', '2023-10-11 07:20:35', 1, 0, 0),
(215, 'Adriana Zúñiga ', NULL, NULL, NULL, 'zunigadriana1106@gmail.com', 'lucreLoreJass', '2023-10-11 08:30:37', 'NULL', '', '2023-10-11 08:31:05', 1, 0, 0),
(216, 'Karen Daniela Rivera Beltrán ', NULL, NULL, NULL, 'karenrivera52696@gmail.com', 'Ariana74', '2023-10-11 09:10:46', 'NULL', '', '2023-10-11 09:11:22', 1, 0, 0),
(217, 'Luna', NULL, NULL, NULL, 'vmeeds@gmail.com', 'P7g4J2r9', '2023-10-11 09:37:33', 'NULL', '', '2023-10-11 09:38:36', 1, 0, 0),
(218, 'Noemi Pineda ', NULL, NULL, NULL, 'nopi_fire@hotmail.com', 'pawino984', '2023-10-11 09:49:41', 'NULL', '', '2023-10-11 10:19:05', 1, 0, 0),
(219, 'Diana Laura Piña Huerta ', NULL, NULL, NULL, 'pidianitahu009@gmail.com', 'Liliciffe21', '2023-10-11 09:55:20', 'NULL', '', '2023-10-11 09:55:46', 1, 0, 0),
(220, 'Tatiana Ortega Ramirez', NULL, NULL, NULL, 'montserrat.ortega.r@gmail.com', 'M9ntserrat36', '2023-10-11 10:19:07', 'NULL', '', '2023-10-11 10:19:45', 1, 0, 0),
(221, 'Saúl Gaspar ', NULL, NULL, NULL, 'saulgr3319@gmail.com', 'Rebeca09', '2023-10-11 10:45:49', 'NULL', '', '2023-10-11 10:46:32', 1, 0, 0),
(222, 'Ana Lucía ', NULL, NULL, NULL, 'apullay1@gmail.com', 'ana.1997', '2023-10-11 11:02:56', 'NULL', '', '2023-10-11 11:03:30', 1, 0, 0),
(223, 'Alejandra Chavarría Trejo ', NULL, NULL, NULL, 'achavarria.tr@gmail.com', NULL, '2023-10-11 11:28:55', '8230', '', NULL, 0, 0, 0),
(224, 'Victoria Lozano ', NULL, NULL, NULL, 'vlhuerta@outlook.es', 'Piramide12!', '2023-10-11 11:53:05', 'NULL', '', '2023-10-11 11:54:43', 1, 0, 0),
(225, 'Daniela Rodriguez Mosqueda ', NULL, NULL, NULL, 'danli.rodri112@gmail.com', 'Jerry.Dani1', '2023-10-11 12:58:09', 'NULL', '', '2023-10-11 13:05:05', 1, 0, 0),
(226, 'Carolina Castillo', NULL, NULL, NULL, 'caroc705@gmail.com', 'TikkyPeter17', '2023-10-11 13:09:48', 'NULL', '', '2023-10-11 13:10:33', 1, 0, 0),
(227, 'ALEJANDRA SANDOVAL HERNÁNDEZ', NULL, NULL, NULL, 'alecitaxsandoval@hotmail.com', 'Mueganito0206', '2023-10-11 14:01:29', 'NULL', '', '2023-10-11 14:03:11', 1, 0, 0),
(228, 'Fernanda Jimenez ', NULL, NULL, NULL, 'fernandastefjm@gmail.com', 'moka1407', '2023-10-11 14:29:07', 'NULL', '', '2023-10-11 14:30:04', 1, 0, 0),
(229, 'Andrea Chavarría González ', NULL, NULL, NULL, 'andichg8@gmail.com', 'sallyChai3', '2023-10-11 16:46:07', 'NULL', '', '2023-10-11 16:47:06', 1, 0, 0),
(230, 'Miroslava López', NULL, NULL, NULL, 'miroslc2110@gmail.com', 'GoloNdrita21', '2023-10-11 17:11:33', 'NULL', '', '2023-10-11 17:12:04', 1, 0, 0),
(231, 'Yanin Jimenez Olvera', NULL, NULL, NULL, 'yanin.giordano@gmail.com', '2117', '2023-10-11 18:46:42', 'NULL', '', '2023-10-11 18:47:17', 1, 0, 0),
(232, 'Pamela ', NULL, NULL, NULL, 'maurapamela29@gmail.com', 'estela2903', '2023-10-11 18:58:43', 'NULL', '', '2023-10-11 18:59:36', 1, 0, 0),
(233, 'Ingrid Calderón', NULL, NULL, NULL, 'ingcasaadin2609dan@gmail.com', '170391', '2023-10-11 20:34:59', 'NULL', '', '2023-10-11 20:35:59', 1, 0, 0),
(234, 'Jesús Carrillo Pelaes ', NULL, NULL, NULL, 'kasuss29@gmail.com', '291218', '2023-10-11 21:49:49', 'NULL', '', '2023-10-11 21:50:22', 1, 0, 0),
(235, 'Sadrak alexander Ramírez patlan ', NULL, NULL, NULL, 'sadrakarp@outlook.com', 'bruna1628', '2023-10-11 23:42:52', 'NULL', '', '2023-10-11 23:44:19', 1, 0, 0),
(236, 'URSULA GONZALEZ', NULL, NULL, NULL, 'karina.gonzalez.mat@gmail.com', 'ursula124', '2023-10-12 00:07:53', 'NULL', '', '2023-10-12 00:08:45', 1, 0, 0),
(237, 'Monica Rodriguez ', NULL, NULL, NULL, 'monylovestitch@gmail.com', 'Monica.30', '2023-10-12 01:49:20', 'NULL', '', '2023-10-12 01:49:49', 1, 0, 0),
(238, 'Gisel Arizmendi Salamanca ', NULL, NULL, NULL, 'gisellenippi@gmail.com', NULL, '2023-10-12 02:21:38', '5257', '', NULL, 0, 0, 0),
(239, 'Masiel Cortés Jiménez ', NULL, NULL, NULL, 'cortesjimenezm65@gmail.com', 'ruty', '2023-10-12 10:47:55', 'NULL', '', '2023-10-12 10:49:19', 1, 0, 0),
(240, 'Romero Luna Dulce ', NULL, NULL, NULL, 'dulluna14@gmail.com', 'RenatoR', '2023-10-12 11:42:18', 'NULL', '', '2023-10-12 11:43:08', 1, 0, 0),
(241, 'Edgar Adelfo Gonzalez Gonzalez', NULL, NULL, NULL, 'gonzalezadelfo@gmail.com', '28333111', '2023-10-12 12:28:46', 'NULL', '', '2023-10-12 12:29:21', 1, 0, 0),
(242, 'Ana Pau Núñez', NULL, NULL, NULL, 'psic.paulinanunez@gmail.com', 'Spellman22', '2023-10-12 13:12:55', 'NULL', '', '2023-10-12 13:13:32', 1, 0, 0),
(243, 'Carmen Tejada', NULL, NULL, NULL, 'eticha.cc.13@hotmail.com', '130810', '2023-10-12 13:26:13', 'NULL', '', '2023-10-12 13:26:55', 1, 0, 0),
(244, 'Karina Trejo Chávez ', NULL, NULL, NULL, 'karis021185@gmail.com', '021185', '2023-10-12 15:33:14', 'NULL', '', '2023-10-12 15:34:14', 1, 0, 0),
(245, 'Maria claudia', NULL, NULL, NULL, 'mccg2604@gmail.com', NULL, '2023-10-12 16:32:09', '8282', '', NULL, 0, 0, 0),
(246, 'Valeria Tello ', NULL, NULL, NULL, 'valeriatello17@gmail.com', '309287759', '2023-10-12 16:57:29', 'NULL', '', '2023-10-12 16:58:21', 1, 0, 0),
(247, 'Alma Victoria Hernández Hernández ', NULL, NULL, NULL, 'avhh0407@gmail.com', 'Confeti', '2023-10-12 20:01:19', 'NULL', '', '2023-10-12 20:02:07', 1, 0, 0),
(248, 'Lesly Estephanie Delgadillo Rosales ', NULL, NULL, NULL, 'ledr02051996@gmail.com', 'Leslina23', '2023-10-12 20:20:47', 'NULL', '', '2023-10-12 20:21:26', 1, 0, 0),
(249, 'Nayeli yazmin avila aguilar ', NULL, NULL, NULL, 'yaazmin4554@gmail.com', 'Yazmin23$', '2023-10-13 14:21:04', 'NULL', '', '2023-10-13 14:21:48', 1, 0, 0),
(250, 'Marylolis', NULL, NULL, NULL, 'mary_09c@hotmail.com', 'Alfonsa2', '2023-10-13 14:28:42', 'NULL', '', '2023-10-13 14:36:46', 1, 0, 0),
(251, 'María Ferro', NULL, NULL, NULL, 'omacdonel@gmail.com', 'Milkys', '2023-10-13 22:27:31', 'NULL', '', '2023-10-13 22:28:09', 1, 0, 0),
(252, 'Yesenia Larios', NULL, NULL, NULL, 'yeslar_18@hotmail.com', 'hachiMASCOTA', '2023-10-13 22:36:02', 'NULL', '', '2023-10-13 22:37:31', 1, 0, 0),
(253, 'Angélica Ramírez ', NULL, NULL, NULL, 'angelpau2016@gmail.com', 'conejitolindo', '2023-10-14 00:03:59', 'NULL', '', '2023-10-14 00:04:43', 1, 0, 0),
(254, 'Teresa rivera', NULL, NULL, NULL, 'teremario2701@gmail.com', '040308', '2023-10-14 12:39:45', 'NULL', '', '2023-10-14 12:40:26', 1, 0, 0),
(255, 'Iliana nieto', NULL, NULL, NULL, '13082009ferjr@gmail.com', NULL, '2023-10-14 23:19:11', '7275', '', NULL, 0, 0, 0),
(256, 'Jessica Janet Tello Eslava ', NULL, NULL, NULL, 'tellojanet32@gmail.com', '12269536', '2023-10-15 13:15:47', 'NULL', '', '2023-10-15 13:16:44', 1, 0, 0),
(257, 'Dulce Karina Martínez Sandoval', NULL, NULL, NULL, 'karina.mtzsandoval@gmail.com', 'Army1607', '2023-10-15 21:23:01', 'NULL', '', '2023-10-15 21:23:46', 1, 0, 0),
(258, 'Liliana Plata ', NULL, NULL, NULL, 'liliplata95@gmail.com', 'denko95142', '2023-10-16 08:46:36', 'NULL', '', '2023-10-16 08:52:18', 1, 0, 0),
(259, 'Orejitas carambola ', NULL, NULL, NULL, 'gabymz9627@gmail.com', '129607', '2023-10-17 13:36:45', 'NULL', NULL, '2023-10-17 13:37:55', 1, 0, 0),
(260, 'Fatima Ysusi', NULL, NULL, NULL, 'faysusi@hotmail.com', '3gordoa', '2023-10-17 21:59:43', 'NULL', NULL, '2023-10-17 22:00:44', 1, 0, 0),
(261, 'Iride Campos ', NULL, NULL, NULL, 'irideca16@gmail.com', '161002', '2023-10-18 08:52:50', 'NULL', NULL, '2023-10-18 08:53:34', 1, 0, 0),
(262, 'Daniela Torres ', NULL, NULL, NULL, 'danielatorres.cienciayvino@gmail.com', 'marvin', '2023-10-18 22:46:24', 'NULL', NULL, '2023-10-18 22:46:53', 1, 0, 0),
(263, 'Diana Murillo', NULL, NULL, NULL, 'murillocdi@gmail.com', '612761', '2023-10-19 12:58:05', 'NULL', NULL, '2023-10-19 12:58:57', 1, 0, 0),
(264, 'Alejandra Rodríguez ', NULL, NULL, NULL, 'rodriguezalejandra436@gmail.com', '7012', '2023-10-19 16:13:49', 'NULL', NULL, '2023-10-19 16:14:13', 1, 0, 0),
(265, 'Maria Rubi', NULL, NULL, NULL, 'migatomiu@gmail.com', '0825', '2023-10-19 17:48:27', 'NULL', NULL, '2023-10-19 17:49:02', 1, 0, 0),
(266, 'Maricela ', NULL, NULL, NULL, 'maricelabgg@gmail.com', '080717', '2023-10-19 19:55:20', 'NULL', NULL, '2023-10-19 19:55:59', 1, 0, 0),
(267, 'Ilian Cruz', NULL, NULL, NULL, 'princesa_5589@hotmail.com', 'Megumi_17', '2023-10-19 22:11:38', 'NULL', NULL, '2023-10-19 22:12:31', 1, 0, 0),
(268, 'Susana García García ', NULL, NULL, NULL, 'garciasusanha@gmail.com', '6708', '2023-10-19 22:34:38', 'NULL', NULL, '2023-10-19 22:35:04', 1, 0, 0),
(269, 'Anahí Joselyn Velázquez Oronzor ', NULL, NULL, NULL, 'annie.hopper32@gmail.com', '308326253', '2023-10-20 09:06:44', 'NULL', NULL, '2023-10-20 09:10:38', 1, 0, 0),
(270, 'Brenda Rocha', NULL, NULL, NULL, 'brandyroch@gmail.com', 'Cones1234', '2023-10-20 10:10:37', 'NULL', NULL, '2023-10-20 10:11:12', 1, 0, 0),
(271, 'Laura Gutiérrez García', NULL, NULL, NULL, 'guariz_06@hotmail.com', NULL, '2023-10-20 12:25:05', '1983', NULL, NULL, 0, 0, 0),
(272, 'Ana Pamela Godinez García ', NULL, NULL, NULL, 'PragaZenai29@gmail.com', '071221', '2023-10-20 16:10:40', 'NULL', NULL, '2023-10-20 16:11:43', 1, 0, 0),
(273, 'Jessica luis ', NULL, NULL, NULL, 'jessygu_1289@hotmail.com', 'Wichito12', '2023-10-20 17:53:16', 'NULL', NULL, '2023-10-20 17:54:29', 1, 0, 0),
(274, 'Ringo Garcia', NULL, NULL, NULL, 'ringog93@gmail.com', 'Huawei123*', '2023-10-20 18:30:47', 'NULL', NULL, '2023-10-20 18:31:57', 1, 0, 0),
(275, 'Montserrat Huerta Gutiérrez ', NULL, NULL, NULL, 'm.h21g@outlook.com', 'f21M01_8', '2023-10-20 19:58:32', 'NULL', NULL, '2023-10-20 19:59:21', 1, 0, 0),
(276, 'Diana Vazquez Aragon ', NULL, NULL, NULL, 'diaragones@icloud.com', 'Powder.2022', '2023-10-20 21:15:55', 'NULL', NULL, '2023-10-20 21:16:26', 1, 0, 0),
(277, 'Fernando Bonilla Vega', NULL, NULL, NULL, 'f_bonilla88@hotmail.com', 'Mkblackops2', '2023-10-20 22:01:23', 'NULL', NULL, '2023-10-20 22:02:07', 1, 0, 0),
(278, 'Ignacio Pablo ', NULL, NULL, NULL, 'ignaciopabloreyes@hotmail.com', '13081309', '2023-10-20 22:44:27', 'NULL', NULL, '2023-10-20 22:45:10', 1, 0, 0),
(279, 'Karla Sarahi Romero Paredes Gomez', NULL, NULL, NULL, 'sarahirpg.24@gmail.com', NULL, '2023-10-20 22:49:44', '3719', NULL, NULL, 0, 0, 0),
(280, 'Johanes Moisés García Limón ', NULL, NULL, NULL, 'johanesgarcia@hotmail.com', NULL, '2023-10-20 22:54:45', '2948', NULL, NULL, 0, 0, 0),
(281, 'Karen nabil', NULL, NULL, NULL, 'karen.nabil@gmail.com', NULL, '2023-10-21 04:46:45', '8854', NULL, NULL, 0, 0, 0),
(282, 'Karen nabil', NULL, NULL, NULL, 'karen.nabil00@gmail.com', NULL, '2023-10-21 04:48:28', '0108', NULL, NULL, 0, 0, 0),
(283, 'Paulina Castro ', NULL, NULL, NULL, 'aniluap19@live.com.mx', 'sergio20', '2023-10-21 07:59:43', 'NULL', NULL, '2023-10-21 08:01:46', 1, 0, 0),
(284, 'Angelica Castañeda', NULL, NULL, NULL, 'gely26.casta@gmail.com', 'chopcito', '2023-10-21 09:07:35', 'NULL', NULL, '2023-10-21 09:08:50', 1, 0, 0),
(285, 'Magali Abigail Díaz Campos ', NULL, NULL, NULL, 'magaliabigaild@gmail.com', 'lolatrailera', '2023-10-21 15:10:58', 'NULL', NULL, '2023-10-21 15:12:13', 1, 0, 0),
(286, 'Rodrigo Fabián Barron Romero', NULL, NULL, NULL, '14decorafyd@gmail.com', '130507rm.', '2023-10-21 19:25:23', 'NULL', NULL, '2023-10-21 19:26:03', 1, 0, 0),
(287, 'Yesenia García Sánchez ', NULL, NULL, NULL, 'bygsgarcia@hotmail.com', NULL, '2023-10-22 07:34:05', '4168', NULL, NULL, 0, 0, 0),
(288, 'Jessica Nieto Cuamatitla', NULL, NULL, NULL, 'jessicanietocuama@gmail.com', 'JessNic0418&', '2023-10-22 19:40:28', 'NULL', NULL, '2023-10-22 19:42:03', 1, 0, 0),
(289, 'Christian Isaías Vazquez Tovar ', NULL, NULL, NULL, 'lrl.cerocinco@gmail.com', NULL, '2023-10-23 07:19:47', '9922', NULL, NULL, 0, 0, 0),
(290, 'Uriel ', NULL, NULL, NULL, 'urijuarezmar764@gmail.com', NULL, '2023-10-23 11:55:08', '9392', NULL, NULL, 0, 0, 0),
(291, 'Alejandra ', NULL, NULL, NULL, 'alejandradcp01@gmail.com', 'Bunnyfacia', '2023-10-23 22:36:02', 'NULL', NULL, '2023-10-23 22:37:08', 1, 0, 0),
(292, 'Ayesia Enriquez Rodriguez', NULL, NULL, NULL, 'ayesia_sharlott@hotmail.com', 'Chichona19', '2023-10-23 22:38:12', 'NULL', NULL, '2023-10-23 22:39:26', 1, 0, 0),
(293, 'Abigail Quintanilla ', NULL, NULL, NULL, 'abigail.qa@outlook.es', '343035', '2023-10-23 22:38:39', 'NULL', NULL, '2023-11-20 21:48:51', 1, 0, 0),
(294, 'Rebeca Palacios Herrera', NULL, NULL, NULL, 'palacios.rebeca@gmail.com', '310720', '2023-10-23 23:13:24', 'NULL', NULL, '2023-10-23 23:13:57', 1, 0, 0),
(295, 'Janet ', NULL, NULL, NULL, 'aleinad_ct@hotmail.com', 'dannapaola', '2023-10-23 23:22:00', 'NULL', NULL, '2023-10-23 23:23:27', 1, 0, 0),
(296, 'Ilse Monserrat Camargo Pérez ', NULL, NULL, NULL, 'ilsecamargoperez@gmail.com', 'bigotes', '2023-10-23 23:26:53', 'NULL', NULL, '2023-10-23 23:27:46', 1, 0, 0),
(297, 'Cecilia Alvarado Peña ', NULL, NULL, NULL, 'alvaradop.cecilia@gmail.com', 'Rae14579~', '2023-10-23 23:28:34', 'NULL', NULL, '2023-10-23 23:29:16', 1, 0, 0),
(298, 'Celina ledesma', NULL, NULL, NULL, 'marcelin2489@gmail.com', 'skully2489', '2023-10-23 23:30:56', 'NULL', NULL, '2023-10-23 23:32:02', 1, 0, 0),
(299, 'Ana Chávez ', NULL, NULL, NULL, 'anjechabe@yahoo.com.mx', NULL, '2023-10-24 00:33:44', '9309', NULL, NULL, 0, 0, 0),
(300, 'Diego zoe Espinosa Alvarez ', NULL, NULL, NULL, 'espinosaalvarezzoe@gmail.com', 'dzea2608', '2023-10-24 02:18:01', 'NULL', NULL, '2023-10-24 02:18:57', 1, 0, 0),
(301, 'Irving david perez martinez ', NULL, NULL, NULL, 'irving878@gmail.com', '0159dias', '2023-10-24 08:14:01', 'NULL', NULL, '2023-10-24 08:14:47', 1, 0, 0),
(302, 'Roxana Jiménez ', NULL, NULL, NULL, 'roxana.jimenez.ayd@gmail.com', '290814', '2023-10-24 08:48:21', 'NULL', NULL, '2023-10-24 08:49:13', 1, 0, 0),
(303, 'Fernanda Tenorio', NULL, NULL, NULL, 'ferllatrix_tagle@hotmail.com', '162321', '2023-10-24 08:56:21', 'NULL', NULL, '2023-10-24 08:58:54', 1, 0, 0),
(304, 'Zoe Isabella Hdz', NULL, NULL, NULL, 'lhernandez@pavel.com.mx', 'zois27', '2023-10-24 09:31:38', 'NULL', NULL, '2023-10-24 09:33:05', 1, 0, 0),
(305, 'Daniel Aguilar Reyes', NULL, NULL, NULL, 'daguilareyes@hotmail.com', 'Luca2023', '2023-10-24 11:12:27', 'NULL', NULL, '2023-10-26 22:23:39', 1, 0, 0),
(306, 'Mariel Nataly ', NULL, NULL, NULL, 'natalynayar18@gmail.com', 'Makoto18', '2023-10-24 21:06:12', 'NULL', NULL, '2023-10-24 21:10:11', 1, 0, 0),
(307, 'Teresa Barron', NULL, NULL, NULL, 'baflte.af@gmail.com', 'elliebebe', '2023-10-24 22:39:13', 'NULL', NULL, '2023-10-24 22:40:24', 1, 0, 0),
(308, 'Felipe Cruz ', NULL, NULL, NULL, 'felipecruzfabian@gmail.com', 'master1109', '2023-10-24 23:12:57', 'NULL', NULL, '2023-10-24 23:15:35', 1, 0, 0),
(309, 'Angélica Núñez González ', NULL, NULL, NULL, 'angee.gonzalez@hotmail.com', NULL, '2023-10-25 01:17:52', '5237', NULL, NULL, 0, 0, 0),
(310, 'Demian Galeana Morales', NULL, NULL, NULL, 'dogezp13@gmail.com', 'DDRzp13earj', '2023-10-25 13:24:53', 'NULL', NULL, '2023-10-25 13:25:31', 1, 0, 0),
(311, 'Fer', NULL, NULL, NULL, 'sethkallig97@gmail.com', 'M0m097?!', '2023-10-25 14:00:30', 'NULL', NULL, '2023-10-25 14:01:48', 1, 0, 0),
(312, 'Elizabeth Porras Pérez ', NULL, NULL, NULL, 'elizabeth.1904@yahoo.com.mx', NULL, '2023-10-25 22:12:57', '9058', NULL, NULL, 0, 0, 0),
(313, 'Rocio Torres Miranda ', NULL, NULL, NULL, 'chivis_monsis84@hotmail.com', 'mandriles13', '2023-10-26 04:28:55', 'NULL', NULL, '2023-10-26 04:29:54', 1, 0, 0),
(314, 'Zuri Monroy', NULL, NULL, NULL, 'zurissa25@gmail.com', 'osito2010', '2023-10-26 15:14:21', 'NULL', NULL, '2023-10-26 15:14:58', 1, 0, 0),
(315, 'Aldo Javier Martínez Martínez', NULL, NULL, NULL, 'bialdo10@yahoo.com.mx', 'aldojavierwwe16', '2023-10-27 01:36:33', 'NULL', NULL, '2023-10-27 01:38:23', 1, 0, 0),
(316, 'Gabriela Cornejo Reyes ', NULL, NULL, NULL, 'gcrgaby584@gmail.com', 'conreyoss', '2023-10-27 06:19:25', 'NULL', NULL, '2023-10-27 06:20:01', 1, 0, 0),
(317, 'Leobardo Pedro ', NULL, NULL, NULL, 'cr7aragon@gmail.com', 'Rabito411081515', '2023-10-27 11:35:03', 'NULL', NULL, '2023-10-27 11:36:09', 1, 0, 0),
(318, 'Jessica Patricia Cordero Piñeiro ', NULL, NULL, NULL, 'burbuja79_@hotmail.com', 'aguijess5379', '2023-10-27 11:51:25', 'NULL', NULL, '2023-10-27 11:53:21', 1, 0, 0),
(319, 'Francisco Palafox', NULL, NULL, NULL, 'fcpalafoxpsic@hotmail.com', '5871palafox', '2023-10-27 12:12:57', 'NULL', NULL, '2023-10-27 12:15:22', 1, 0, 0),
(320, 'Laura Priscila Robles Castilla ', NULL, NULL, NULL, 'lauraroblescastilla@gmail.com', 'gris19', '2023-10-27 13:58:53', 'NULL', NULL, '2023-10-27 13:59:39', 1, 0, 0),
(321, 'Santa Yurai Silva López ', NULL, NULL, NULL, 'yurai.santa12@gmail.com', 'CriRoXi18', '2023-10-28 09:56:20', 'NULL', NULL, '2023-10-28 19:02:20', 1, 0, 0),
(322, 'Concepcion monterrubio muñiz ', NULL, NULL, NULL, 'conyham81@gmail.com', 'cuyaloca81', '2023-10-28 17:54:37', 'NULL', NULL, '2023-10-28 17:55:25', 1, 0, 0),
(323, 'Emilio Marroquín ', NULL, NULL, NULL, 'emarroquina@hotmal.com', NULL, '2023-10-28 19:40:47', '7861', NULL, NULL, 0, 0, 0),
(324, 'Emilio Marroquín ', NULL, NULL, NULL, 'emiliomarroquina@gmail.com', 'tumamameama', '2023-10-28 19:43:41', 'NULL', NULL, '2023-10-28 19:45:29', 1, 0, 0),
(325, 'Fabiola Pozos ', NULL, NULL, NULL, 'pozosf1314@gmail.com', 'estropajo', '2023-10-28 19:48:51', 'NULL', NULL, '2023-10-28 19:49:22', 1, 0, 0),
(326, 'Analilia Carrillo González ', NULL, NULL, NULL, 'carrilloanalilia0@gmail.com', 'TereyLili4ever', '2023-10-28 20:03:31', 'NULL', NULL, '2023-10-28 20:04:33', 1, 0, 0),
(327, 'Naomi Mendez ', NULL, NULL, NULL, 'naomimendez795@gmail.com', NULL, '2023-10-28 21:13:25', '5024', NULL, NULL, 0, 0, 0),
(328, 'Nuria Hernández Alás', NULL, NULL, NULL, 'yuri.nurialas@gmail.com', 'Suzuki-san22', '2023-10-28 22:52:26', 'NULL', NULL, '2023-10-28 22:52:51', 1, 0, 0),
(329, 'Jazmin Del Carmen ', NULL, NULL, NULL, 'kitty25jazmin@gmail.com', 'KillerMa54', '2023-10-29 11:30:12', 'NULL', NULL, '2023-10-29 11:32:15', 1, 0, 0),
(330, 'Jorge Mendoza ', NULL, NULL, NULL, 'mendozajor31@gmail.com', 'RoomelDP31', '2023-10-29 11:51:42', 'NULL', NULL, '2023-10-29 11:52:16', 1, 0, 0),
(331, 'Deyanira Janet Hernández Mendoza ', NULL, NULL, NULL, 'toshelyn@gmail.com', 'jacintitos3', '2023-10-29 14:39:08', 'NULL', NULL, '2023-10-29 14:40:13', 1, 0, 0),
(332, 'Sheila Aguilar ', NULL, NULL, NULL, 'soap9431@gmail.com', '190416', '2023-10-29 15:05:02', 'NULL', NULL, '2023-10-29 15:07:28', 1, 0, 0),
(333, 'Norma García Sandoval', NULL, NULL, NULL, 'agpto.gip@gmail.com', '061801', '2023-10-29 17:11:19', 'NULL', NULL, '2023-10-29 17:11:59', 1, 0, 0),
(334, 'Lesly Garcia', NULL, NULL, NULL, 'israelteamo230610@gmail.com', '061801', '2023-10-29 17:17:21', 'NULL', NULL, '2023-10-29 17:17:58', 1, 0, 0),
(335, 'Daniela Andrade ', NULL, NULL, NULL, 'danielagoan08@gmail.com', '081310', '2023-10-29 21:22:51', 'NULL', NULL, '2023-10-29 21:23:48', 1, 0, 0),
(336, 'Estefani Noemí Guevara Márquez ', NULL, NULL, NULL, 'fannyguevara78313@gmail.com', 'Verdeagua91', '2023-10-29 22:32:37', 'NULL', NULL, '2023-10-29 22:33:15', 1, 0, 0),
(337, 'María Elena Hernández ', NULL, NULL, NULL, 'mary_risos@hotmail.com', 'Anakin2020', '2023-10-30 00:20:27', 'NULL', NULL, '2023-10-30 00:21:07', 1, 0, 0),
(338, 'Oralia Baltazar ', NULL, NULL, NULL, 'gomita_malosa@hotmail.com', NULL, '2023-10-30 08:35:35', '6290', NULL, NULL, 0, 0, 0),
(339, 'Oralia Baltazar ', NULL, NULL, NULL, 'gomita_malosa@outlook.com', '1626art1626', '2023-10-30 08:36:47', 'NULL', NULL, '2023-10-30 08:37:11', 1, 0, 0),
(340, 'Anayeli Hernández Benito ', NULL, NULL, NULL, 'hanayeli894@gmail.com', '5610642264', '2023-10-30 09:05:00', 'NULL', NULL, '2023-10-30 09:07:51', 1, 0, 0),
(341, 'Gabriela morales ', NULL, NULL, NULL, 'gaidamb@hotmail.com', '271108', '2023-10-30 12:46:35', 'NULL', NULL, '2023-10-30 12:47:17', 1, 0, 0),
(342, 'Lucero Bernardino Guerrero', NULL, NULL, NULL, 'lucero.bernardino.96@gmail.com', 'Eduardo18', '2023-10-30 14:21:06', 'NULL', NULL, '2023-10-30 14:21:31', 1, 0, 0),
(343, 'Diana Nájera ', NULL, NULL, NULL, 'dianajera92@gmail.com', 'Phy11ophaga', '2023-10-30 15:30:41', 'NULL', NULL, '2023-10-30 15:31:12', 1, 0, 0),
(344, 'Michell Tapia ', NULL, NULL, NULL, 'michellmarilyn777@gmail.com', 'Bomba*1945', '2023-10-30 19:49:29', 'NULL', NULL, '2023-10-30 19:50:03', 1, 0, 0);
INSERT INTO `usuarios` (`id`, `nombre`, `paterno`, `materno`, `telefono`, `email`, `password`, `fechaRegistro`, `token`, `rol`, `fechaActivacion`, `isActive`, `isVerified`, `isPartner`) VALUES
(345, 'Esteban Ramirez Castro', NULL, NULL, NULL, 'stella.5555@hotmail.com', '191286', '2023-10-30 20:08:10', 'NULL', NULL, '2023-10-30 20:09:14', 1, 0, 0),
(346, 'Ayame Nicole Ramírez Cordero', NULL, NULL, NULL, 'ayame.nicole.r@gmail.com', '130613', '2023-10-30 20:13:00', 'NULL', NULL, '2023-10-30 20:13:22', 1, 0, 0),
(347, 'Maricela Elías Castañeda ', NULL, NULL, NULL, 'mariceelaelcast@gmail.com', 'familiakpq2', '2023-10-31 17:22:15', 'NULL', NULL, '2023-10-31 17:23:00', 1, 0, 0),
(348, 'MARIA DEL CARMEN LAZCANO CASIQUE', NULL, NULL, NULL, 'carmenlazcano51@gmail.com', '071182', '2023-11-01 14:04:38', 'NULL', NULL, '2023-11-01 14:06:06', 1, 0, 0),
(349, 'adrian', NULL, NULL, NULL, 'antbgx@gmail.com', '123', NULL, 'NULL', NULL, '2023-11-02 13:06:47', 1, 0, 0),
(350, 'Montserrat Hernandez Espinoza', NULL, NULL, NULL, 'montsemdk@hotmail.com', 'Polilove1', '2023-11-03 00:52:12', 'NULL', NULL, '2023-11-03 00:53:23', 1, 0, 0),
(351, 'Sharon García ', NULL, NULL, NULL, 'sharona.g.flores@gmail.com', '280890', '2023-11-03 10:25:46', 'NULL', NULL, '2023-11-03 10:29:39', 1, 0, 0),
(352, 'Maria Fernanda Rubio Reyes ', NULL, NULL, NULL, 'rubio.reyes.mariafernandac571f@gmail.com', '220218', '2023-11-03 17:44:31', 'NULL', NULL, '2023-11-03 17:45:03', 1, 0, 0),
(353, 'Maria Fernanda Rubio Reyes ', NULL, NULL, NULL, 'mariafernandarubio54@gmail.com', '220218', '2023-11-03 17:51:40', 'NULL', NULL, '2023-11-03 17:52:09', 1, 0, 0),
(354, 'Beatriz Del Carmen Martínez González ', NULL, NULL, NULL, 'beatriz.martinez.gonzalez09@gmail.com', 'Rusher.23', '2023-11-04 16:24:33', 'NULL', NULL, '2023-11-04 16:25:20', 1, 0, 0),
(355, 'Díana Cecilia González ', NULL, NULL, NULL, 'dayana1890@gmail.com', 'Rasmus01', '2023-11-05 16:30:33', 'NULL', NULL, '2023-11-05 16:31:04', 1, 0, 0),
(356, 'Fernando Olivares ', NULL, NULL, NULL, 'fher.ariz@gmail.com', 'conejito1310', '2023-11-05 16:41:59', 'NULL', NULL, '2023-11-05 16:44:13', 1, 0, 0),
(357, 'Oswaldo Sosa Sánchez ', NULL, NULL, NULL, 'g.unit.oss22@gmail.com', 'Conreyoss3022', '2023-11-06 10:55:32', 'NULL', NULL, '2023-11-06 10:56:08', 1, 0, 0),
(358, 'Gabriela Cornejo Reyes ', NULL, NULL, NULL, 'gabyoss3022@gmail.com', 'ConreyOss3022', '2023-11-06 11:05:06', 'NULL', NULL, '2023-11-06 11:05:44', 1, 0, 0),
(359, 'Viridiana Márquez González ', NULL, NULL, NULL, 'sparklylollipop05@gmail.com', 'Luna2805', '2023-11-06 11:53:18', 'NULL', NULL, '2023-11-06 11:53:54', 1, 0, 0),
(360, 'Ana Karen Huitrón Apolinar ', NULL, NULL, NULL, 'anakaren.huitron@gmail.com', 'serandaluz', '2023-11-06 12:37:41', 'NULL', NULL, '2023-11-06 12:38:12', 1, 0, 0),
(361, 'Pamela Resendiz', NULL, NULL, NULL, 'pamela.resendiz.336@gmail.com', 'Pamela08', '2023-11-06 12:44:28', 'NULL', NULL, '2023-11-06 12:44:46', 1, 0, 0),
(362, 'Elizabeth Espinoza ', NULL, NULL, NULL, 'eli_legna@hotmail.com', 'Legna5z21204', '2023-11-06 14:55:36', 'NULL', NULL, '2023-11-06 14:56:07', 1, 0, 0),
(363, 'Monserrat Sánchez Romero ', NULL, NULL, NULL, 'mc20sarm2157@facmed.unam.mx', 'Mons3108200.', '2023-11-06 18:38:58', 'NULL', NULL, '2023-11-06 18:39:41', 1, 0, 0),
(364, 'Fabián Ordaz ', NULL, NULL, NULL, 'fabianordaz2@gmail.com', 'conejito', '2023-11-06 22:12:53', 'NULL', NULL, '2023-11-06 22:13:32', 1, 0, 0),
(365, 'Guadalupe herrera roa ', NULL, NULL, NULL, 'lupitaherreraroa@gmail.com', 'caramelo', '2023-11-07 07:04:04', 'NULL', NULL, '2023-11-07 07:04:55', 1, 0, 0),
(366, 'Tere Morales ', NULL, NULL, NULL, 'terexa2307@gmail.com', '598723', '2023-11-07 10:11:21', 'NULL', NULL, '2023-11-07 10:12:18', 1, 0, 0),
(367, 'Susana Osorio Serrano ', NULL, NULL, NULL, 'dash230216@gmail.com', 'picoslocos', '2023-11-07 10:28:21', 'NULL', NULL, '2023-11-07 10:29:49', 1, 0, 0),
(368, 'Selene Sarai Muñoz Luna', NULL, NULL, NULL, 'yue.teru@gmail.com', 'Kerokerocola03', '2023-11-07 19:41:12', 'NULL', NULL, '2023-11-07 19:41:58', 1, 0, 0),
(369, 'Arely Rueda', NULL, NULL, NULL, 'arale_rd24@live.com.mx', 'bubuja', '2023-11-07 20:12:22', 'NULL', NULL, '2023-11-07 20:12:49', 1, 0, 0),
(370, 'Fernando Ulises Carballido Estrada', NULL, NULL, NULL, 'carballido_31@hotmail.com', '139040', '2023-11-07 21:38:59', 'NULL', NULL, '2023-11-07 21:39:34', 1, 0, 0),
(371, 'María Fernanda Ponce Cruz', NULL, NULL, NULL, 'maryferponce@gmail.com', 'Nicolas.87', '2023-11-07 21:55:29', 'NULL', NULL, '2023-11-07 21:56:17', 1, 0, 0),
(372, 'Ximena Estrada', NULL, NULL, NULL, 'estrada.ximena2739@gmail.com', '2003x07g34', '2023-11-07 22:03:04', 'NULL', NULL, '2023-11-07 22:05:17', 1, 0, 0),
(373, 'Mirna', NULL, NULL, NULL, 'myep_i@hotmail.com', 'conejo05', '2023-11-07 22:14:00', 'NULL', NULL, '2023-11-07 22:17:38', 1, 0, 0),
(374, 'Itzel Gabriela Cruz Nadales ', NULL, NULL, NULL, 'cnig_knox@hotmail.com', '314233129', '2023-11-07 22:19:01', 'NULL', NULL, '2023-11-07 22:22:50', 1, 0, 0),
(375, 'Johanes García ', NULL, NULL, NULL, 'johanesgarcialimon@gmail.com', '571004', '2023-11-07 23:49:29', 'NULL', NULL, '2023-11-07 23:49:59', 1, 0, 0),
(376, 'Valentina Vivanco', NULL, NULL, NULL, 'valehvivanco@yahoo.com', 'muasval16', '2023-11-07 23:57:40', 'NULL', NULL, '2023-11-07 23:59:01', 1, 0, 0),
(377, 'Cristina Garcia', NULL, NULL, NULL, 'cristinagz90z@gmail.com', NULL, '2023-11-08 01:37:14', '2985', NULL, NULL, 0, 0, 0),
(378, 'Élise', NULL, NULL, NULL, 'hellarad24@hotmail.com', NULL, '2023-11-08 02:24:49', '9121', NULL, NULL, 0, 0, 0),
(379, 'Maria Fernanda Romero Martinez', NULL, NULL, NULL, 'mari_balderas23@outlook.com', '231199', '2023-11-08 06:50:56', 'NULL', NULL, '2023-11-08 06:54:51', 1, 0, 0),
(380, 'Erika Perez ', NULL, NULL, NULL, 'yanis20053@hotmail.com', '2301', '2023-11-08 07:23:53', 'NULL', NULL, '2023-11-08 07:24:29', 1, 0, 0),
(381, 'Violeta Cerón ', NULL, NULL, NULL, 'violeta.ceron18@gmail.com', NULL, '2023-11-08 08:07:06', '6051', NULL, NULL, 0, 0, 0),
(382, 'Juan Bosco', NULL, NULL, NULL, 'juanboscoo1969@gmail.com', 'boda110694', '2023-11-08 09:53:39', 'NULL', NULL, '2023-11-08 09:54:11', 1, 0, 0),
(383, 'Ana Carmina Cervantes Ambriz', NULL, NULL, NULL, 'anacdepina@hotmail.com', 'Hermosisimo', '2023-11-08 09:58:16', 'NULL', NULL, '2023-11-08 11:00:24', 1, 0, 0),
(384, 'Diana Lorena González Alcalá ', NULL, NULL, NULL, 'gonzalcala.dianalorena@gmail.com', '1313kyuMIN@', '2023-11-08 10:49:15', 'NULL', NULL, '2023-11-08 10:49:42', 1, 0, 0),
(385, 'Alicia del Carmen Gordillo Gonzalez', NULL, NULL, NULL, 'licha.coral@live.com', 'Carm3l1ta', '2023-11-08 11:02:55', 'NULL', NULL, '2023-11-08 11:10:43', 1, 0, 0),
(386, 'Diana Laura Ramírez García ', NULL, NULL, NULL, 'dr7715249@gmail.com', 'erikjosue060215', '2023-11-08 12:01:57', 'NULL', NULL, '2023-11-08 12:02:35', 1, 0, 0),
(387, 'Arisbe ', NULL, NULL, NULL, 'arisfields_29@hotmail.com', '202629', '2023-11-08 13:29:10', 'NULL', NULL, '2023-11-08 13:30:22', 1, 0, 0),
(388, 'Laura', NULL, NULL, NULL, 'lauraisabelmatamala@gmail.com', 'marozio', '2023-11-08 14:57:26', 'NULL', NULL, '2023-11-08 14:57:57', 1, 0, 0),
(389, 'Gisela', NULL, NULL, NULL, 'giselaesum@gmail.com', 'Gisela11', '2023-11-08 18:14:40', 'NULL', NULL, '2023-11-08 18:16:12', 1, 0, 0),
(390, 'Pablo', NULL, NULL, NULL, 'sebastian.carry@gmail.com', 'Chivas15', '2023-11-08 18:55:33', 'NULL', NULL, '2023-11-08 19:03:04', 1, 0, 0),
(391, 'Carla Cardenas ', NULL, NULL, NULL, 'carla.cardenas.c@gmail.com', NULL, '2023-11-08 21:00:46', '8839', NULL, NULL, 0, 0, 0),
(392, 'Christie Lourdes Araujo Urrutia', NULL, NULL, NULL, 'araujo.urrutia@gmail.com', 'burritamacias', '2023-11-08 21:21:52', 'NULL', NULL, '2023-11-08 21:22:47', 1, 0, 0),
(393, 'Yazmin Ixchel Alcántara Bravo ', NULL, NULL, NULL, 'yazminixchel10@gmail.com', 'ibbie26', '2023-11-09 11:51:38', 'NULL', NULL, '2023-11-09 11:52:08', 1, 0, 0),
(394, 'Luis Alanis', NULL, NULL, NULL, 'lcpalanis@gmail.com', 'TotopoB203', '2023-11-09 13:57:07', 'NULL', NULL, '2023-11-09 13:57:34', 1, 0, 0),
(395, 'Litzy', NULL, NULL, NULL, 'lizzespi650@gmail.com', 'litzyxD123', '2023-11-09 17:26:56', 'NULL', NULL, '2023-11-09 17:27:24', 1, 0, 0),
(396, 'Beatriz Sanchez ', NULL, NULL, NULL, 'beatriz073022@gmail.com', 'Cacerolo22', '2023-11-10 00:48:11', 'NULL', NULL, '2023-11-10 00:48:43', 1, 0, 0),
(397, 'Adriana Silvestre Cruz', NULL, NULL, NULL, 'b.adriana.silvestre@gmail.com', 'Depp1006', '2023-11-10 06:24:14', 'NULL', NULL, '2023-11-10 06:25:06', 1, 0, 0),
(398, 'Diana Galindo ', NULL, NULL, NULL, 'dianita.galindo98@gmail.com', 'dianitaAmy', '2023-11-10 09:33:12', 'NULL', NULL, '2023-11-10 09:33:50', 1, 0, 0),
(399, 'Kate Franco', NULL, NULL, NULL, 'katexiiviixii@gmail.com', 'Franco', '2023-11-10 21:53:41', 'NULL', NULL, '2023-11-10 21:54:25', 1, 0, 0),
(400, 'José Manuel Figueroa', NULL, NULL, NULL, 'figue.isc@gmail.com', 'figueroa2', '2023-11-11 00:17:42', 'NULL', NULL, '2023-11-11 00:18:23', 1, 0, 0),
(401, 'Karen Vega', NULL, NULL, NULL, 'karen.vega.o@gmail.com', 'zukarita', '2023-11-11 16:09:06', 'NULL', NULL, '2023-11-11 16:09:46', 1, 0, 0),
(402, 'Hannia Evee Peralta Parada ', NULL, NULL, NULL, 'hanniaperalta03@gmail.com', 'Bodoquitos3', '2023-11-11 18:16:06', 'NULL', NULL, '2023-11-11 18:16:40', 1, 0, 0),
(403, 'Hannia Evee Peralta Parada ', NULL, NULL, NULL, 'peraltahannia25@gmail.com', 'Coffito', '2023-11-11 22:24:24', 'NULL', NULL, '2023-11-11 22:25:08', 1, 0, 0),
(404, 'Adriano Meiken Morelli', NULL, NULL, NULL, 'adrianommorelli@gmail.com', '09051995', '2023-11-12 15:48:27', 'NULL', NULL, '2023-11-12 15:49:09', 1, 0, 0),
(405, 'Gabriela', NULL, NULL, NULL, 'stinnky_3@hotmail.com', NULL, '2023-11-12 21:09:16', '6430', NULL, NULL, 0, 0, 0),
(406, 'Paulina Cruz Trujillo ', NULL, NULL, NULL, 'harry.izard@gmail.com', 'Meissa0520', '2023-11-13 08:02:15', 'NULL', NULL, '2023-11-13 08:03:00', 1, 0, 0),
(407, 'Maria Fernanda ', NULL, NULL, NULL, 'ferrubioreyes@gmail.com', '220218', '2023-11-13 09:04:53', 'NULL', NULL, '2023-11-13 09:05:18', 1, 0, 0),
(408, 'DAN VEGA', NULL, NULL, NULL, 'DANIELAVEG@HOTMAIL.COM', '1683', '2023-11-13 12:34:10', 'NULL', NULL, '2023-11-13 12:36:25', 1, 0, 0),
(409, 'Tania Beatriz Gacía Avila', NULL, NULL, NULL, 'betty.grcavila@gmail.com', '321214', '2023-11-13 13:59:13', 'NULL', NULL, '2023-11-13 13:59:57', 1, 0, 0),
(410, 'René Fabián Díaz de León Flores ', NULL, NULL, NULL, 'crotalosatrox@gmail.com', 'Gael1976', '2023-11-13 14:04:06', 'NULL', NULL, '2023-11-13 14:05:50', 1, 0, 0),
(411, 'Karen Romero', NULL, NULL, NULL, 'kaarenrq@gmail.com', 'newton16', '2023-11-14 20:12:23', 'NULL', NULL, '2023-11-14 20:12:48', 1, 0, 0),
(412, 'Melina Reyes ', NULL, NULL, NULL, 'o.n.i.x815@gmail.com', NULL, '2023-11-15 11:33:05', '9171', NULL, NULL, 0, 0, 0),
(413, 'Roxana', NULL, NULL, NULL, 'quetzal2405@hotmail.com', '011175', '2023-11-15 18:32:47', 'NULL', NULL, '2023-11-15 18:33:44', 1, 0, 0),
(414, 'Francisco Palafox ', NULL, NULL, NULL, 'fxpalafoxpsic@hotmail.com', NULL, '2023-11-16 08:57:11', '1266', NULL, NULL, 0, 0, 0),
(415, 'Sara Esmeralda caballero Bernal ', NULL, NULL, NULL, 'bernalsara14@gmail.com', 'conejos88', '2023-11-16 09:09:44', 'NULL', NULL, '2023-11-16 09:10:48', 1, 0, 0),
(416, 'Elizabeth ', NULL, NULL, NULL, 'elymtzhdz1@gmail.com', 'palitroshe', '2023-11-16 12:28:48', 'NULL', NULL, '2023-11-16 12:29:59', 1, 0, 0),
(417, 'Deneice', NULL, NULL, NULL, 'deneicelmu@yahoo.com', NULL, '2023-11-16 13:47:21', '4908', NULL, NULL, 0, 0, 0),
(418, 'Nancy Montoya', NULL, NULL, NULL, 'nangmontoya@gmail.com', 'Conejobb84', '2023-11-16 13:51:56', 'NULL', NULL, '2023-11-16 13:52:44', 1, 0, 0),
(419, 'Brenda Ramos Onofre ', NULL, NULL, NULL, 'brendaaudit@hotmail.com', 'Felix100', '2023-11-16 14:02:26', 'NULL', NULL, '2023-11-16 14:03:24', 1, 0, 0),
(420, 'Maria de la Luz Morales ', NULL, NULL, NULL, 'moll951114@outlook.com', 'Morales95', '2023-11-16 14:45:27', 'NULL', NULL, '2023-11-16 14:46:27', 1, 0, 0),
(421, 'Elizabeth Huerta Cleto ', NULL, NULL, NULL, 'huerta_8806@hotmail.com', '20388351a', '2023-11-16 15:31:56', 'NULL', NULL, '2023-11-16 15:33:08', 1, 0, 0),
(422, 'Yesenia cruz', NULL, NULL, NULL, 'pumas4191@hotmail.com', 'sombras6720', '2023-11-16 15:36:26', 'NULL', NULL, '2023-11-16 15:37:27', 1, 0, 0),
(423, 'Raúl Arellano ', NULL, NULL, NULL, 'raulmejarell12@gmail.com', NULL, '2023-11-16 20:11:05', '7081', NULL, NULL, 0, 0, 0),
(424, 'Oscar Espinosa', NULL, NULL, NULL, 'espectro.azteca@gmail.com', 'tito', '2023-11-17 02:57:31', 'NULL', NULL, '2023-11-17 02:57:56', 1, 0, 0),
(425, 'Dolores Teresa Moreno Serrano', NULL, NULL, NULL, 'lolite.s.m@hotmail.com', 'Inuyasha25', '2023-11-17 10:16:34', 'NULL', NULL, '2023-11-17 10:17:47', 1, 0, 0),
(426, 'Jorge Javier Cornejo ', NULL, NULL, NULL, 'javierc66@hotmail.es', 'Dady2707', '2023-11-17 15:28:46', 'NULL', NULL, '2023-11-17 15:29:15', 1, 0, 0),
(427, 'Melissa Albarran', NULL, NULL, NULL, 'chuychuyita13@gmail.com', 'Carton31', '2023-11-18 18:12:51', 'NULL', NULL, '2023-11-18 18:13:14', 1, 0, 0),
(428, 'Camila', NULL, NULL, NULL, 'acosta1karla2@gmail.com', 'chaparro', '2023-11-19 14:59:07', 'NULL', NULL, '2023-11-19 15:00:48', 1, 0, 0),
(429, 'Dana Vera ', NULL, NULL, NULL, 'danamvera14@gmail.com', '123Onedurection', '2023-11-19 18:32:43', 'NULL', NULL, '2023-11-19 18:33:48', 1, 0, 0),
(430, 'Karla Maya', NULL, NULL, NULL, 'karlaalegria13@gmail.com', '123dana', '2023-11-19 18:43:06', 'NULL', NULL, '2023-11-19 18:43:41', 1, 0, 0),
(431, 'Odin Arturo Pizano Mendoza ', NULL, NULL, NULL, 'odin.pizano_bvb@outlook.com', 'Aveng7x666.', '2023-11-20 06:45:15', 'NULL', NULL, '2023-11-20 07:13:27', 1, 0, 0),
(432, 'Katya Abigail Vargas Montiel', NULL, NULL, NULL, 'abbyvm43@gmail.com', NULL, '2023-11-20 08:16:19', '0854', NULL, NULL, 0, 0, 0),
(433, 'Astrid Soria', NULL, NULL, NULL, 'soria.astrid.1999@gmail.com', 'Caramelos9.', '2023-11-20 09:08:19', 'NULL', NULL, '2023-11-20 09:08:57', 1, 0, 0),
(434, 'Sarahi Olvera ', NULL, NULL, NULL, 'sarale0245@gmail.com', 'tambor', '2023-11-20 12:07:16', 'NULL', NULL, '2023-11-20 12:08:31', 1, 0, 0),
(435, 'Ma Fernanda Paredes Moreno ', NULL, NULL, NULL, 'skholemoore@gmail.com', '8358', '2023-11-20 13:52:01', 'NULL', NULL, '2023-11-20 13:52:22', 1, 0, 0),
(436, 'Claudia Olguin', NULL, NULL, NULL, 'cotu_307@hotmail.com', 'Ch1l3!!--', '2023-11-20 13:54:25', 'NULL', NULL, '2023-11-20 13:56:04', 1, 0, 0),
(437, 'Valeria García Velda', NULL, NULL, NULL, 'valegarciavelda@gmail.com', 'Puppet22', '2023-11-20 14:47:28', 'NULL', NULL, '2023-11-20 14:48:02', 1, 0, 0),
(438, 'Guillermo ', NULL, NULL, NULL, 'rommigonzalez1@gmail.com', '123456', '2023-11-20 16:49:22', 'NULL', NULL, '2023-11-20 16:50:01', 1, 0, 0),
(439, 'Andrea Cornejo Reyes ', NULL, NULL, NULL, 'andreacornejoreyes2@gmail.com', '(LIAGMGCR)', '2023-11-20 17:12:08', 'NULL', NULL, '2023-11-20 17:12:46', 1, 0, 0),
(440, 'Raque Osorio ', NULL, NULL, NULL, 'raque.osoriod@hotmail.com', '252630', '2023-11-20 18:09:11', 'NULL', NULL, '2023-11-20 18:09:48', 1, 0, 0),
(441, 'Ashley Hernandez ', NULL, NULL, NULL, 'ashleycmlunes@gmail.com', 'ninA0303', '2023-11-20 20:58:54', 'NULL', NULL, '2023-11-20 20:59:36', 1, 0, 0),
(442, 'Katia ', NULL, NULL, NULL, 'chikis8trikis@gmail.com', 'Litchibebe', '2023-11-20 21:33:22', 'NULL', NULL, '2023-11-20 21:34:09', 1, 0, 0),
(443, 'Raquel Montoya Hernández ', NULL, NULL, NULL, 'raaee.2619@gmail.com', '26190604', '2023-11-20 23:27:02', 'NULL', NULL, '2023-11-20 23:27:53', 1, 0, 0),
(444, 'Lilian Sámano', NULL, NULL, NULL, 'lilusamano@gmail.com', '220286', '2023-11-20 23:46:50', 'NULL', NULL, '2023-11-20 23:47:42', 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacoraCaja`
--
ALTER TABLE `bitacoraCaja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `CAT_estatusPedido`
--
ALTER TABLE `CAT_estatusPedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `CAT_metodoDePago`
--
ALTER TABLE `CAT_metodoDePago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallePedido`
--
ALTER TABLE `detallePedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `enviostiendas`
--
ALTER TABLE `enviostiendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expositores`
--
ALTER TABLE `expositores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos_egresos_Tienda`
--
ALTER TABLE `ingresos_egresos_Tienda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario_index` (`pagadoPor`),
  ADD KEY `date_index` (`fechaInicioPlan`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_gafetes`
--
ALTER TABLE `tabla_gafetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacoraCaja`
--
ALTER TABLE `bitacoraCaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `CAT_estatusPedido`
--
ALTER TABLE `CAT_estatusPedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `CAT_metodoDePago`
--
ALTER TABLE `CAT_metodoDePago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detallePedido`
--
ALTER TABLE `detallePedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enviostiendas`
--
ALTER TABLE `enviostiendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expositores`
--
ALTER TABLE `expositores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ingresos_egresos_Tienda`
--
ALTER TABLE `ingresos_egresos_Tienda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `tabla_gafetes`
--
ALTER TABLE `tabla_gafetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `tiendas`
--
ALTER TABLE `tiendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
