-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-10-2023 a las 15:27:51
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
(9, 'pankhurst.zoe@yahoo.com', 'Jimmy Pankhurst', '7299606841', 'Jimmy Pankhurst', 'Hi there,\r\nMonthly Seo Services - Professional/ Affordable Seo Services\r\nHire the leading seo marketing company and get your website ranked on search engines. Are you looking to rank your website on search engines? Contact us now to get started - https://', 'Hi there,\r\nMonthly Seo Services - Professional/ Affordable Seo Services\r\nHire the leading seo marketing company and get your website ranked on search engines. Are you looking to rank your website on search engines? Contact us now to get started - https://', 'Vrlpg Vy', NULL);

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
(67, 'MSP64', 'foto.jpeg', 'pryscillacordova27@gmail.com', 'Buggs', '2022-08-12', NULL, NULL, NULL, 0, 1),
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
(170, 'MSP166', 'foto.jpeg', 'nopi_fire@hotmail.com', 'Jacobo', '2019-06-28', 'Cabeza de León/Loop', 'Macho', 'Blanco', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_asistencia`
--

CREATE TABLE `registro_asistencia` (
  `id` int(11) NOT NULL,
  `usuario_id` varchar(255) NOT NULL,
  `evento_id` varchar(11) NOT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `asistio` tinyint(1) DEFAULT 0,
  `fecha_hora_asistencia` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `fechaActivacion` datetime DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 0,
  `isVerified` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `paterno`, `materno`, `telefono`, `email`, `password`, `fechaRegistro`, `token`, `fechaActivacion`, `isActive`, `isVerified`) VALUES
(5, 'Alfredo Espinoza', NULL, NULL, NULL, 'aespinozabgx@gmail.com', NULL, '2023-08-21 06:42:30', '9028', NULL, 0, 0),
(6, 'Israel Vázquez G', NULL, NULL, NULL, 'israel.vazquez.gonzalez@outlook.com', 'Zamarel7777$', '2023-08-21 17:00:02', 'NULL', '2023-08-21 17:01:06', 1, 0),
(7, 'Gabriela Ríos ', NULL, NULL, NULL, 'gabriela.rios.h@hotmail.com', 'Garihe1990', '2023-09-05 16:18:14', 'NULL', '2023-09-05 16:21:12', 1, 0),
(15, 'Miguel Lara eseiza ', NULL, NULL, NULL, 'miguellaraeseiza@gmail.com', '222222', '2023-10-02 16:23:05', 'NULL', '2023-10-04 00:33:29', 1, 0),
(16, 'Axel Espinoza', NULL, NULL, NULL, 'axelcoreos@gmail.com', '123', '2023-10-02 20:32:21', 'NULL', '2023-10-02 20:33:06', 1, 0),
(17, 'Laura Berenice Resendiz Rodriguez ', NULL, NULL, NULL, 'usagi.lb23@gmail.com', 'Naranjita2317', '2023-10-03 13:49:31', 'NULL', '2023-10-03 13:50:09', 1, 0),
(18, 'Jenn Mendoza ', NULL, NULL, NULL, 'jennifermendoza458@gmail.com', '130296', '2023-10-03 14:10:49', 'NULL', '2023-10-03 14:11:20', 1, 0),
(19, 'Vanessa', NULL, NULL, NULL, 'vanessa_sg@icloud.com', 'Bunnybo84', '2023-10-03 21:54:55', 'NULL', '2023-10-03 21:56:19', 1, 0),
(20, 'Ursula Espinola', NULL, NULL, NULL, 'pepinaymilajo@gmail.com', 'U2ra6zexom', '2023-10-04 08:35:09', 'NULL', '2023-10-04 08:35:44', 1, 0),
(21, 'Etni Mendoza', NULL, NULL, NULL, 'chenolpoyo@gmail', NULL, '2023-10-04 09:52:43', '1007', NULL, 0, 0),
(22, 'Etni Mendoza', NULL, NULL, NULL, 'chenolpoyo@gmail.com', NULL, '2023-10-04 09:52:58', '6973', NULL, 0, 0),
(23, 'Laura Patricia Muñoz Torres ', NULL, NULL, NULL, 'laura.mt942@gmail.com', 'laurapatricia', '2023-10-10 10:28:16', 'NULL', '2023-10-10 10:29:17', 1, 0),
(24, 'Reyna Irene Soto Jacinto', NULL, NULL, NULL, 'tfreynasoto@gmail.com', 'Rabbit', '2023-10-10 10:28:21', 'NULL', '2023-10-10 10:29:22', 1, 0),
(25, 'Maylet Beltrán ', NULL, NULL, NULL, 'mayletina@hotmail.com', NULL, '2023-10-10 10:28:35', '0455', NULL, 0, 0),
(26, 'Merari Marlene Reyes Vigueras ', NULL, NULL, NULL, 'mare_vig@hotmail.com', '100116', '2023-10-10 10:28:59', 'NULL', '2023-10-10 10:29:58', 1, 0),
(27, 'Fernanda Tavera Miranda ', NULL, NULL, NULL, 'taveramiranda1989@gmail.com', NULL, '2023-10-10 10:29:32', '8057', NULL, 0, 0),
(28, 'Arlette Zuleima Molina Rivero ', NULL, NULL, NULL, 'arlette.molina90@gmail.com', 'Riveroleozu9013', '2023-10-10 10:29:39', 'NULL', '2023-10-10 10:30:32', 1, 0),
(29, 'Lesly Araceli Nava Sánchez ', NULL, NULL, NULL, 'les.ara.12.9@gmail.com', 'leslyara12', '2023-10-10 10:29:55', 'NULL', '2023-10-10 10:30:37', 1, 0),
(30, 'Fernanda Rodríguez ', NULL, NULL, NULL, 'rodmequit1104@gmail.com', 'maicol123', '2023-10-10 10:30:11', 'NULL', '2023-10-10 10:31:23', 1, 0),
(31, 'Fatima Olvera Santos ', NULL, NULL, NULL, 'fatimaolverasantos@gmail.com', 'Luca2023', '2023-10-10 10:30:46', 'NULL', '2023-10-10 10:31:22', 1, 0),
(32, 'Alma Alejandra Olmos Lision ', NULL, NULL, NULL, 'ale.olmos.140384@gmail.com', 'Italia34', '2023-10-10 10:31:43', 'NULL', '2023-10-10 10:32:48', 1, 0),
(33, 'Itxumy Aylin Basurto Vazquez ', NULL, NULL, NULL, 'ja251699@gmail.com', 'panela', '2023-10-10 10:32:51', 'NULL', '2023-10-10 10:33:24', 1, 0),
(34, 'Claudia Romo', NULL, NULL, NULL, 'quien_romo@outlook.com', 'Patopato', '2023-10-10 10:33:30', 'NULL', '2023-10-10 10:38:16', 1, 0),
(35, 'Karla Yazmin Cruz Rayon ', NULL, NULL, NULL, 'kayacra@gmail.com', '931104', '2023-10-10 10:34:13', 'NULL', '2023-10-10 10:34:49', 1, 0),
(36, 'Ana García ', NULL, NULL, NULL, 'anni_rosa@hotmail.com', 'cocoa2306', '2023-10-10 10:34:37', 'NULL', '2023-10-10 10:35:40', 1, 0),
(37, 'Jessica luis ', NULL, NULL, NULL, 'jessygu2012@gmail.com', 'Wicho12', '2023-10-10 10:35:32', 'NULL', '2023-10-10 10:37:15', 1, 0),
(38, 'Pilar Ortiz Lucas ', NULL, NULL, NULL, 'pilariqaa@gmail.com', 'l0l05_24', '2023-10-10 10:36:18', 'NULL', '2023-10-10 10:39:05', 1, 0),
(39, 'Arianne Ríos Hernández ', NULL, NULL, NULL, 'tonalliari@hotmail.com', 'robbie', '2023-10-10 10:38:00', 'NULL', '2023-10-10 10:38:51', 1, 0),
(40, 'Keyri', NULL, NULL, NULL, 'keyrinimayer26@gmail.com', '261200key', '2023-10-10 10:40:22', 'NULL', '2023-10-10 10:40:53', 1, 0),
(41, 'Leslie Bendeck Lazcano ', NULL, NULL, NULL, 'delfin3082@outlook.com', '071182', '2023-10-10 10:42:34', 'NULL', '2023-10-10 10:43:53', 1, 0),
(42, 'Raúl Iván Dávila González', NULL, NULL, NULL, 'dagri_46@hotmail.com', '377iag7..C', '2023-10-10 10:42:35', 'NULL', '2023-10-10 10:43:12', 1, 0),
(43, 'Jorge Daniel Gutierrez Avilés ', NULL, NULL, NULL, 'big_dan@live.com.mx', '198612', '2023-10-10 10:44:15', 'NULL', '2023-10-10 14:41:59', 1, 0),
(44, 'Cinthia García Arteaga', NULL, NULL, NULL, 'cinthiagrc2889@gmail.com', 'garcia2889', '2023-10-10 10:46:01', 'NULL', '2023-10-10 10:46:40', 1, 0),
(45, 'Leonor Reyes Galarza ', NULL, NULL, NULL, 'leonoraRTJM4@hotmail.com', 'leonor123', '2023-10-10 10:49:37', 'NULL', '2023-10-10 10:50:30', 1, 0),
(46, 'JAZMIN VEGA', NULL, NULL, NULL, 'jazvega.psico@gmail.com', NULL, '2023-10-10 10:50:35', '3158', NULL, 0, 0),
(47, 'Guillermo Rafael Galvez Abrego', NULL, NULL, NULL, 'g.galvezabrego@gmail.com', '130219', '2023-10-10 10:50:41', 'NULL', '2023-10-10 10:51:38', 1, 0),
(48, 'JAZMIN VEGA', NULL, NULL, NULL, 'jazpiolin@hotmail.com', 'JAZM1N44', '2023-10-10 10:51:01', 'NULL', '2023-10-10 10:55:25', 1, 0),
(49, 'Isabel ', NULL, NULL, NULL, 'isa_als19@hotmail.com', '050383', '2023-10-10 10:51:52', 'NULL', '2023-10-10 10:53:27', 1, 0),
(50, 'Coral ', NULL, NULL, NULL, 'coritellezcruz26@gmail.com', 'baticonejo', '2023-10-10 10:52:12', 'NULL', '2023-10-10 10:55:36', 1, 0),
(51, 'Claudia Ledesma', NULL, NULL, NULL, 'clauledsgarcia@gmail.com', NULL, '2023-10-10 10:52:20', '6321', NULL, 0, 0),
(52, 'Fernanda de la cruz', NULL, NULL, NULL, 'ferdc94@hotmail.com', 'Tokio483', '2023-10-10 10:52:24', 'NULL', '2023-10-10 10:53:11', 1, 0),
(53, 'Angelica Hernández ', NULL, NULL, NULL, 'aihp_0208@hotmail.com', NULL, '2023-10-10 10:55:14', '5808', NULL, 0, 0),
(54, 'Iris garcia ', NULL, NULL, NULL, 'iris221020fernando@gmail.com', NULL, '2023-10-10 10:57:49', '6116', NULL, 0, 0),
(55, 'Mitzi Garcia ', NULL, NULL, NULL, 'mitbotong1704@gmail.com', 'losamoositos', '2023-10-10 11:01:18', 'NULL', '2023-10-10 11:02:09', 1, 0),
(56, 'Adrián Martínez ', NULL, NULL, NULL, 'defmoy@hotmail.com', NULL, '2023-10-10 11:02:14', '7726', NULL, 0, 0),
(57, 'Valentina Vivanco  ', NULL, NULL, NULL, 'valevivanco165@gmail.com', 'muasval16', '2023-10-10 11:03:22', 'NULL', '2023-10-10 11:03:54', 1, 0),
(58, 'Ana Lourdes Pina Cervantes ', NULL, NULL, NULL, 'anilupina@gmail.com', 'Hermosisimo', '2023-10-10 11:03:50', 'NULL', '2023-10-10 11:05:42', 1, 0),
(59, 'Paulina Montiel Arias ', NULL, NULL, NULL, 'parias2202@gmail.com', 'mamoniyo0212', '2023-10-10 11:04:54', 'NULL', '2023-10-10 11:05:37', 1, 0),
(60, 'ELIZABETH SARA MEDINA LOPEZ', NULL, NULL, NULL, 'esmlopez24@gmail.com', 'Interpol2323', '2023-10-10 11:05:24', 'NULL', '2023-10-10 11:06:19', 1, 0),
(61, 'Annie Jalomo ', NULL, NULL, NULL, 'angelesjalomo4@gmail.com', 'annie19', '2023-10-10 11:06:16', 'NULL', '2023-10-10 11:06:58', 1, 0),
(62, 'Angie Avellaneda', NULL, NULL, NULL, 'kattystephany@gmail.com', 'Kakiri21', '2023-10-10 11:07:14', 'NULL', '2023-10-10 11:07:35', 1, 0),
(63, 'Jennifer Lucía Chiché Ruiz ', NULL, NULL, NULL, 'jennifer204ruiz@gmail.com', NULL, '2023-10-10 11:08:03', '9777', NULL, 0, 0),
(64, 'Julieta Juárez Gutiérrez ', NULL, NULL, NULL, 'julietita03@hotmail.com', 'R5Family248', '2023-10-10 11:09:29', 'NULL', '2023-10-10 11:10:06', 1, 0),
(65, 'Diana Cordova', NULL, NULL, NULL, 'dianalaucordova@gmail.com', 'Marley26', '2023-10-10 11:09:44', 'NULL', '2023-10-10 11:10:21', 1, 0),
(66, 'Jennifer Alexandra Sosa Cervantes ', NULL, NULL, NULL, 'jeal_sc94@outlook.com', '051194', '2023-10-10 11:36:16', 'NULL', '2023-10-10 11:41:31', 1, 0),
(67, 'Ashley sayuri beristain ', NULL, NULL, NULL, 'sayuri6690@gmail.com', 'Sayuri6690', '2023-10-10 11:36:59', 'NULL', '2023-10-10 11:37:39', 1, 0),
(68, 'Pachito Gómez Mont Fernández y Sánchez ', NULL, NULL, NULL, 'pumakristen208@hotmail.com', 'Pachito2803', '2023-10-10 11:39:55', 'NULL', '2023-10-10 11:42:38', 1, 0),
(69, 'Fabiola Ivonne Yépez Alfaro', NULL, NULL, NULL, 'miss_yepez@hotmail.com', 'Hamasaki1', '2023-10-10 11:40:04', 'NULL', '2023-10-10 11:41:35', 1, 0),
(70, 'Aline', NULL, NULL, NULL, 'alinearteaga62@gmail.com', 'Aline1993', '2023-10-10 11:40:49', 'NULL', '2023-10-10 11:41:09', 1, 0),
(71, 'Brenda', NULL, NULL, NULL, 'bren_rs@hotmail.com', 'gordos', '2023-10-10 11:41:43', 'NULL', '2023-10-10 11:43:07', 1, 0),
(72, 'Ana Laura ', NULL, NULL, NULL, 'lauraserna5600@gmail.com', NULL, '2023-10-10 11:44:23', '5345', NULL, 0, 0),
(73, 'Fatima Nohemí Sánchez Alvarado ', NULL, NULL, NULL, 'fatiiiiyoi13@gmail.com', 'Yuri&Vikto1', '2023-10-10 11:46:18', 'NULL', '2023-10-10 11:46:55', 1, 0),
(74, 'Verónica Jiménez ', NULL, NULL, NULL, 'ronyjimnz@hotmail.com', 'VERO10', '2023-10-10 11:50:35', 'NULL', '2023-10-10 11:51:32', 1, 0),
(75, 'Bamby ', NULL, NULL, NULL, 'valenciayuris848@gmail.com', '123456', '2023-10-10 11:50:36', 'NULL', '2023-10-10 11:51:12', 1, 0),
(76, 'Sara Margarita García Cuanalo ', NULL, NULL, NULL, 'sara17cuanalo@gmail.com', 'parchi12', '2023-10-10 11:50:48', 'NULL', '2023-10-10 20:03:04', 1, 0),
(77, 'Ismael Vázquez ', NULL, NULL, NULL, 'mayelo5089@gmail.com', 'Isma1299', '2023-10-10 11:51:19', 'NULL', '2023-10-10 11:54:22', 1, 0),
(78, 'Félix Alejandro GUILLERMO YAPIAS ', NULL, NULL, NULL, 'Alex_8_f@hotmail.com', NULL, '2023-10-10 11:54:23', '0806', NULL, 0, 0),
(79, 'Fabiola Sánchez ', NULL, NULL, NULL, 'ursulaconeja@gmail.com', 'ivonne', '2023-10-10 11:57:24', 'NULL', '2023-10-10 13:34:12', 1, 0),
(80, 'Erika valtierra ', NULL, NULL, NULL, 'erikaval307@hotmail.com', '1804', '2023-10-10 11:59:07', 'NULL', '2023-10-10 12:02:35', 1, 0),
(81, 'Lizbeth sanjuan hernandez', NULL, NULL, NULL, 'lizbeth_hdez12@hotmail.com', 'Liiz310702', '2023-10-10 12:00:41', 'NULL', '2023-10-10 12:01:50', 1, 0),
(82, 'Tequila Konijn', NULL, NULL, NULL, 'naidumadera@gmail.com', 'Tequila', '2023-10-10 12:02:01', 'NULL', '2023-10-10 12:02:23', 1, 0),
(83, 'Donagit Luna', NULL, NULL, NULL, 'donagit_luna@hotmail', NULL, '2023-10-10 12:04:57', '0987', NULL, 0, 0),
(84, 'Jesus de los santos', NULL, NULL, NULL, 'atton10@hotmail.com', 'Slayers3', '2023-10-10 12:05:23', 'NULL', '2023-10-10 12:06:57', 1, 0),
(85, 'Donagit Luna ', NULL, NULL, NULL, 'donagit_luna@hotmail.com', NULL, '2023-10-10 12:05:25', '0015', NULL, 0, 0),
(86, 'Cintia', NULL, NULL, NULL, 'cintia-mc@hotmail.com', '25604532n', '2023-10-10 12:05:34', 'NULL', '2023-10-10 12:08:47', 1, 0),
(87, 'Samantha Hernández', NULL, NULL, NULL, 'smichelleahernandez00@gmail.com', 'Sadam2135', '2023-10-10 12:06:59', 'NULL', '2023-10-10 12:07:30', 1, 0),
(88, 'Nayelli Gómez perez ', NULL, NULL, NULL, 'nayelliperez06@gmail.com', 'kokoa0517', '2023-10-10 12:07:37', 'NULL', '2023-10-10 12:08:27', 1, 0),
(89, 'Sandra Nallely Herrera Cruz ', NULL, NULL, NULL, 'sandranallely0609@gmail.com', 'titito2021', '2023-10-10 12:09:03', 'NULL', '2023-10-10 12:11:26', 1, 0),
(90, 'Adriana', NULL, NULL, NULL, 'blancheyura@gmail.com', 'Nana1502', '2023-10-10 12:12:24', 'NULL', '2023-10-10 12:13:13', 1, 0),
(91, 'Ana Enciso ', NULL, NULL, NULL, 'ana.encisog@hotmail.com', '310891', '2023-10-10 12:13:48', 'NULL', '2023-10-10 12:14:44', 1, 0),
(92, 'Liz', NULL, NULL, NULL, 'lizarrache@gmail.com', '05107818', '2023-10-10 12:15:37', 'NULL', '2023-10-10 12:16:09', 1, 0),
(93, 'Priscila Córdova ', NULL, NULL, NULL, 'pryscillacordova27@gmail.com', 'Buggs1210', '2023-10-10 12:25:44', 'NULL', '2023-10-10 12:27:02', 1, 0),
(94, 'Yukari segura Negrete ', NULL, NULL, NULL, 'yukariseguranegrete@gmail.com', 'tamboras0299', '2023-10-10 12:25:59', 'NULL', '2023-10-10 12:26:38', 1, 0),
(95, 'Francisco Javier Moreno Rodríguez ', NULL, NULL, NULL, 'franrodri2089@gmail.com', 'cecybj', '2023-10-10 12:32:29', 'NULL', '2023-10-10 12:33:52', 1, 0),
(96, 'Mauricio Sánchez Govea ', NULL, NULL, NULL, 'mauriciogovz@gmail.com', 'Puchuni', '2023-10-10 12:36:52', 'NULL', '2023-10-10 12:37:47', 1, 0),
(97, 'Lorena Hernández ', NULL, NULL, NULL, 'airavir@hotmail.com', 'LoJo1708', '2023-10-10 12:37:19', 'NULL', '2023-10-10 12:38:45', 1, 0),
(98, 'Fabiola Pozos ', NULL, NULL, NULL, 'fabi_unam@hotmail.com', '131409', '2023-10-10 12:37:33', 'NULL', '2023-10-10 12:38:28', 1, 0),
(99, 'Erwin Francisco Bautista', NULL, NULL, NULL, 'Sabatt.black@gmail.com', 'Magaly06', '2023-10-10 12:38:40', 'NULL', '2023-10-10 12:39:22', 1, 0),
(100, 'Missael ', NULL, NULL, NULL, 'missael150196@outlook.com', 'decatlon15', '2023-10-10 12:45:57', 'NULL', '2023-10-10 12:46:40', 1, 0),
(101, 'Soledad', NULL, NULL, NULL, 'solcito014@gmail.com', 'lacurva6161', '2023-10-10 12:54:07', 'NULL', '2023-10-10 12:54:41', 1, 0),
(102, 'Lucero Berenice Garnica Rodríguez ', NULL, NULL, NULL, 'lucasmilyteodoz@gmail.com', NULL, '2023-10-10 12:59:06', '4425', NULL, 0, 0),
(103, 'SANDRA ILLESCAS', NULL, NULL, NULL, 'sandillescas26@gmail.com', 'sandra26', '2023-10-10 13:02:13', 'NULL', '2023-10-10 13:02:40', 1, 0),
(104, 'Mariana Feregrino Sánchez ', NULL, NULL, NULL, 'marianapink.mf@gmail.com', 'Sasho2122', '2023-10-10 13:03:07', 'NULL', '2023-10-10 13:03:31', 1, 0),
(105, 'Alondra Rico Sanchez', NULL, NULL, NULL, 'lic.nut.alondrasanchez@gmail.com', 'Burbuj@2020', '2023-10-10 13:03:24', 'NULL', '2023-10-10 13:03:57', 1, 0),
(106, 'Ariadna Gómez Carrión ', NULL, NULL, NULL, 'aria.dna@outlook.com', 'Arihagne18110921', '2023-10-10 13:05:51', 'NULL', '2023-10-10 13:26:42', 1, 0),
(107, 'Valeria Amarel Ximenez Flores', NULL, NULL, NULL, 'amarelximenez@gmail.com', NULL, '2023-10-10 13:07:11', '7967', NULL, 0, 0),
(108, 'Valeria Amarel Ximenez Flores', NULL, NULL, NULL, 'amarelramosximenez10@gmail.com', 'Chemita005', '2023-10-10 13:09:22', 'NULL', '2023-10-10 13:10:59', 1, 0),
(109, 'Gina Aguilar ', NULL, NULL, NULL, 'georgina.ma@ucad.edu.mx', NULL, '2023-10-10 13:18:51', '0987', NULL, 0, 0),
(110, 'Vanesa rubio', NULL, NULL, NULL, 'vanesarubio1010@gmail.com', 'madelyn16', '2023-10-10 13:20:36', 'NULL', '2023-10-10 13:21:07', 1, 0),
(111, 'Gina Aguilar ', NULL, NULL, NULL, 'georgina_18@live.com.mx', NULL, '2023-10-10 13:22:43', '3725', NULL, 0, 0),
(112, 'Saraí García', NULL, NULL, NULL, 'dsarai.gv@hotmail.es', 'lovyadotty', '2023-10-10 13:23:01', 'NULL', '2023-10-10 13:23:43', 1, 0),
(113, 'Felipe Hernandez U', NULL, NULL, NULL, 'bobesfel@live.com.mx', 'Feli56854433', '2023-10-10 13:24:59', 'NULL', '2023-10-10 13:26:44', 1, 0),
(114, 'Gina Aguilar ', NULL, NULL, NULL, 'mansongirl12@gmail.com', 'nachito18', '2023-10-10 13:26:08', 'NULL', '2023-10-10 13:28:28', 1, 0),
(115, 'Karla Anahí Sánchez Morales', NULL, NULL, NULL, 'kasm280999@gmail.com', '2665kasm', '2023-10-10 13:31:04', 'NULL', '2023-10-10 13:31:30', 1, 0),
(116, 'Miguel Angel Rodriguez Vega ', NULL, NULL, NULL, 'mike50899@gmail.com', 'Suzuki1300', '2023-10-10 13:37:31', 'NULL', '2023-10-10 13:39:30', 1, 0),
(117, 'ERIKA HERNÁNDEZ CASTILLO ', NULL, NULL, NULL, 'kastillo28@hotmail.com', 'M@zinngerZ4', '2023-10-10 13:37:48', 'NULL', '2023-10-10 13:41:36', 1, 0),
(118, 'Tania Guadalupe Bernardino Guerrero ', NULL, NULL, NULL, 'bernardinotania27@gmail.com', 'AustinDanna', '2023-10-10 13:38:36', 'NULL', '2023-10-10 13:41:14', 1, 0),
(119, 'Ericka Sánchez zavala ', NULL, NULL, NULL, 'rojiblanca14213@gmail.com', 'Razi1427', '2023-10-10 13:39:31', 'NULL', '2023-10-10 13:40:04', 1, 0),
(120, 'Martha Elizabeth Ramírez Olvera', NULL, NULL, NULL, 'maliz99952@gmail.com', 'blabon999333', '2023-10-10 13:42:09', 'NULL', '2023-10-10 13:48:44', 1, 0),
(121, 'Marisol Tirado Cortez', NULL, NULL, NULL, 'mar.grunge.fran@hotmail.com', NULL, '2023-10-10 13:42:21', '5383', NULL, 0, 0),
(122, 'Luis Antonio Martínez ', NULL, NULL, NULL, 'luismtz3271@hotmail.com', NULL, '2023-10-10 13:44:28', '2334', NULL, 0, 0),
(123, 'Evelin Chimal Garcia', NULL, NULL, NULL, 'evelinchg26@gmail.com', 'Tolouse23', '2023-10-10 13:47:26', 'NULL', '2023-10-10 13:48:04', 1, 0),
(124, 'Jazmín Escalante Castillo ', NULL, NULL, NULL, 'jazmin.eacj@gmail.com', 'Ardillita11', '2023-10-10 13:51:53', 'NULL', '2023-10-10 13:52:28', 1, 0),
(125, 'Erika ', NULL, NULL, NULL, 'erikasias4@gmail.com', '230214', '2023-10-10 14:01:19', 'NULL', '2023-10-10 14:02:06', 1, 0),
(126, 'Aylin Osiris López Sánchez ', NULL, NULL, NULL, 'aylinpoeta@gmail.com', 'jimb0nas10', '2023-10-10 14:15:41', 'NULL', '2023-10-10 14:16:12', 1, 0),
(127, 'Atzin Rosas', NULL, NULL, NULL, 'atzinrosas24@gmail.com', 'Zamurabu1995', '2023-10-10 14:34:07', 'NULL', '2023-10-10 14:35:01', 1, 0),
(128, 'Jorge Alberto Sánchez Cruz', NULL, NULL, NULL, 'jalbertoc99@gmail.com', '081499', '2023-10-10 14:34:13', 'NULL', '2023-10-10 14:34:57', 1, 0),
(129, 'César Alzaga', NULL, NULL, NULL, 'cesar_050205@hotmail.com', 'corazon', '2023-10-10 14:36:43', 'NULL', '2023-10-10 14:40:13', 1, 0),
(130, 'César ', NULL, NULL, NULL, 'logistica.mx@ubscode.com', NULL, '2023-10-10 14:38:24', '2255', NULL, 0, 0),
(131, 'Yani', NULL, NULL, NULL, 'yanira.everlast@gmail.com', NULL, '2023-10-10 14:41:06', '5535', NULL, 0, 0),
(132, 'Nancy Becerril', NULL, NULL, NULL, 'nanisnancy7@gmail.com', '593291', '2023-10-10 14:46:24', 'NULL', '2023-10-10 14:46:48', 1, 0),
(133, 'Valeria Ambriz Flores ', NULL, NULL, NULL, 'valeria06af@gmail.com', 'v4l3ry06AF', '2023-10-10 14:48:20', 'NULL', '2023-10-10 14:49:02', 1, 0),
(134, 'Ariana Tapia', NULL, NULL, NULL, 'usagiari@hotmail.com', 'copito1204', '2023-10-10 14:48:22', 'NULL', '2023-10-10 14:48:48', 1, 0),
(135, 'María Teresa Pina Cervantes ', NULL, NULL, NULL, 'maria.pinac@outlook.com', 'Bolita', '2023-10-10 14:58:44', 'NULL', '2023-10-10 14:59:27', 1, 0),
(136, 'Maribel Flores Flores ', NULL, NULL, NULL, 'mrsvioletparanoia@gmail.com', 'H&Klove*7', '2023-10-10 15:06:55', 'NULL', '2023-10-10 15:07:37', 1, 0),
(137, 'Elizabeth loredo estrada', NULL, NULL, NULL, 'lizi-lo-e@hotmail.com', '123456#', '2023-10-10 15:12:42', 'NULL', '2023-10-10 15:13:50', 1, 0),
(138, 'Diana', NULL, NULL, NULL, 'diana.gbr@gmsil.com', NULL, '2023-10-10 15:13:14', '0457', NULL, 0, 0),
(139, 'Vanny Gisselle Sandoval Padilla', NULL, NULL, NULL, 'vannysan12@hotmail.com', 'bernand9', '2023-10-10 15:13:52', 'NULL', '2023-10-10 15:15:31', 1, 0),
(140, 'Diana', NULL, NULL, NULL, 'diana.gbr@gmail.com', 'Zoebb', '2023-10-10 15:19:31', 'NULL', '2023-10-10 15:46:13', 1, 0),
(141, 'Abigail Romero ', NULL, NULL, NULL, 'abigailromeroh@gmail.com', '11021983', '2023-10-10 15:22:19', 'NULL', '2023-10-10 15:24:18', 1, 0),
(142, 'Juan Carlos ', NULL, NULL, NULL, 'jcjacinto1982@gmail.com', 'selene16', '2023-10-10 15:25:55', 'NULL', '2023-10-10 15:26:40', 1, 0),
(143, 'Teresa', NULL, NULL, NULL, 'tere.djsa@gmail.com', NULL, '2023-10-10 15:34:42', '6116', NULL, 0, 0),
(144, 'Evelyn Gutiérrez ', NULL, NULL, NULL, 'evecucue@hotmail.com', 'Dany050903', '2023-10-10 15:38:58', 'NULL', '2023-10-10 15:39:48', 1, 0),
(145, 'Monserrat Vanegas Cuevas ', NULL, NULL, NULL, 'monsevanegas@hotmail.com', 'yolotzin2800', '2023-10-10 15:59:50', 'NULL', '2023-10-10 16:03:30', 1, 0),
(146, 'Hillary ', NULL, NULL, NULL, 'iranayalaa@gmail.com', 'Aguadelima20', '2023-10-10 16:12:11', 'NULL', '2023-10-10 16:13:11', 1, 0),
(147, 'Maria Fernanda Mendoza ', NULL, NULL, NULL, 'imaryfer@yahoo.com.mx', '1991', '2023-10-10 16:14:16', 'NULL', '2023-10-10 16:14:48', 1, 0),
(148, 'Jessica itzel Perez chavez ', NULL, NULL, NULL, 'itzyperez.27@gmail.com', 'santiago27', '2023-10-10 16:24:23', 'NULL', '2023-10-10 16:24:59', 1, 0),
(149, 'Alasha Nahoni Flores Ramírez ', NULL, NULL, NULL, 'alasha.r@outlook.com', NULL, '2023-10-10 16:27:59', '9249', NULL, 0, 0),
(150, 'Aira M Pérez Martínez ', NULL, NULL, NULL, 'aira.pmartinez@gmail.com', '99231880', '2023-10-10 16:32:14', 'NULL', '2023-10-10 16:32:47', 1, 0),
(151, 'Esmeralda Martinez ', NULL, NULL, NULL, 'esmeetinez@gmail.com', 'bonnie', '2023-10-10 16:33:38', 'NULL', '2023-10-10 16:34:31', 1, 0),
(152, 'Oscar Zepeda', NULL, NULL, NULL, 'Oscarzm1981@gmail.com', 'Tecate01', '2023-10-10 16:39:29', 'NULL', '2023-10-10 16:40:27', 1, 0),
(153, 'Mariana Fiesco Cardenas ', NULL, NULL, NULL, 'mariana.fiesco.c@gmail.com', NULL, '2023-10-10 16:47:26', '3950', NULL, 0, 0),
(154, 'Rayas', NULL, NULL, NULL, 'basigsan2@gmail.com', 'CULITO', '2023-10-10 17:10:16', 'NULL', '2023-10-10 17:11:03', 1, 0),
(155, 'Marco Antonio Sabas González ', NULL, NULL, NULL, 'maskevil27@gmail.com', '81081327', '2023-10-10 17:27:31', 'NULL', '2023-10-10 17:29:57', 1, 0),
(156, 'Julieta Ávila', NULL, NULL, NULL, 'jjjjulieta92@gmail.com', 'juls121091', '2023-10-10 17:30:46', 'NULL', '2023-10-10 17:31:14', 1, 0),
(157, 'Yessica Salvador', NULL, NULL, NULL, 'bettyboop31@live.com', NULL, '2023-10-10 17:34:34', '1653', NULL, 0, 0),
(158, 'Yessica Salvador', NULL, NULL, NULL, 'bettyboop31@live.com.com.mx', NULL, '2023-10-10 17:34:51', '3310', NULL, 0, 0),
(159, 'Karla Guadalupe  Casas de Jesús ', NULL, NULL, NULL, 'karlyhouse16@gmail.com', 'karly0702', '2023-10-10 17:35:48', 'NULL', '2023-10-10 17:36:33', 1, 0),
(160, 'Esmeralda ', NULL, NULL, NULL, 'jadenet33@gmail.com', 'Amairany', '2023-10-10 17:36:51', 'NULL', '2023-10-10 17:38:01', 1, 0),
(161, 'Yessica Salvador', NULL, NULL, NULL, 'yessica.salvador.tolentino@correo.cjf.gob.mx', NULL, '2023-10-10 17:37:53', '2246', NULL, 0, 0),
(162, 'Daniela Estrada ', NULL, NULL, NULL, 'dany.estrada.1711@gmail.com', 'Estrada7', '2023-10-10 17:38:46', 'NULL', '2023-10-10 18:28:03', 1, 0),
(163, 'Jeshua', NULL, NULL, NULL, 'jealsaav11@gmail.com', 'manin1', '2023-10-10 17:40:01', 'NULL', '2023-10-10 17:48:03', 1, 0),
(164, 'Yessica Salvador', NULL, NULL, NULL, 'segurosjst@gmail.com', 'Roma131122', '2023-10-10 17:40:02', 'NULL', '2023-10-10 17:40:29', 1, 0),
(165, 'XIMENA NÚÑEZ ', NULL, NULL, NULL, 'Aneemix2805@gmail.com', 'Bonie28', '2023-10-10 17:44:17', 'NULL', '2023-10-10 17:45:09', 1, 0),
(166, 'Litzy Urueta ', NULL, NULL, NULL, 'litzysweed@gmail.com', 'litzyxd123', '2023-10-10 17:55:02', 'NULL', '2023-10-10 17:55:32', 1, 0),
(167, 'Katya Aguila ', NULL, NULL, NULL, 'fabilaj977@gmail.com', 'Pelusa03', '2023-10-10 17:55:18', 'NULL', '2023-10-10 17:55:53', 1, 0),
(168, 'Blanca Abigail Cervantes Barrios ', NULL, NULL, NULL, 'habbycervantes@gmail.com', 'Ba2247912', '2023-10-10 17:58:15', 'NULL', '2023-10-10 18:00:14', 1, 0),
(169, 'Deyanira González', NULL, NULL, NULL, 'deya.gb1989@gmail.com', 'Lover13', '2023-10-10 18:06:16', 'NULL', '2023-10-10 18:06:45', 1, 0),
(170, 'Constantino Castro', NULL, NULL, NULL, 'arconscorp@gmail.com', '910023', '2023-10-10 18:10:43', 'NULL', '2023-10-10 18:11:27', 1, 0),
(171, 'Dani Mejia', NULL, NULL, NULL, 'danis.meyia@gmail.com', 'Changoleon2401', '2023-10-10 18:16:24', 'NULL', '2023-10-10 18:18:15', 1, 0),
(172, 'Fanny gallegos ', NULL, NULL, NULL, 'gallegosfanny806@gmail.com', '20082019', '2023-10-10 18:24:16', 'NULL', '2023-10-10 18:24:45', 1, 0),
(173, 'Viridiana Montero ', NULL, NULL, NULL, 'vi.monteroe@gmail.com', '17122019', '2023-10-10 18:32:07', 'NULL', '2023-10-10 18:32:53', 1, 0),
(174, 'Karla Rebeca Ávila Carrasco', NULL, NULL, NULL, 'karlarebeca1997@gmail.com', NULL, '2023-10-10 18:39:51', '7300', NULL, 0, 0),
(175, 'Iliana Cazares', NULL, NULL, NULL, 'cazilicam@outlook.com', NULL, '2023-10-10 18:42:13', '8333', NULL, 0, 0),
(176, 'Iliana Cazares', NULL, NULL, NULL, 'cazilicam@gmail.com', 'RichCam79', '2023-10-10 18:43:01', 'NULL', '2023-10-10 18:44:32', 1, 0),
(177, 'Edith ', NULL, NULL, NULL, 'eemarquez81@hotmail.com', '050618', '2023-10-10 18:43:02', 'NULL', '2023-10-10 18:46:06', 1, 0),
(178, 'Ana Vargas ', NULL, NULL, NULL, 'anna.urbina90@outlook.com', '011190', '2023-10-10 18:46:36', 'NULL', '2023-10-10 18:47:43', 1, 0),
(179, 'Fátima Rodríguez ', NULL, NULL, NULL, 'fati_rdz0710@outlook.com', 'Sao.3847', '2023-10-10 18:50:21', 'NULL', '2023-10-10 18:57:41', 1, 0),
(180, 'Sandra Dávila ', NULL, NULL, NULL, 'psic.sandradavila@gmail.com', NULL, '2023-10-10 19:02:50', '7354', NULL, 0, 0),
(181, 'Nancy Ivonne ', NULL, NULL, NULL, 'nanvarelamax@gmail.com', 'Maximiliano2130', '2023-10-10 19:13:02', 'NULL', '2023-10-10 19:13:30', 1, 0),
(182, 'Abigail Gómez Angeles ', NULL, NULL, NULL, 'angeles.vanessa99@gmail.com', 'Nita1122', '2023-10-10 19:17:22', 'NULL', '2023-10-10 19:18:57', 1, 0),
(183, 'Fernanda Davalos', NULL, NULL, NULL, 'ferdaval@yahoo.com.mx', 'Nico1985', '2023-10-10 19:18:14', 'NULL', '2023-10-10 19:20:23', 1, 0),
(184, 'Lorena Córdova ', NULL, NULL, NULL, 'loorzcordova@gmail.com', 'Moshi27.', '2023-10-10 19:21:37', 'NULL', '2023-10-10 19:22:05', 1, 0),
(185, 'Bonitila', NULL, NULL, NULL, 'jackie_jmj@live.com', 'Jackie8921', '2023-10-10 19:24:29', 'NULL', '2023-10-10 19:26:27', 1, 0),
(186, 'Nancy Alpuing', NULL, NULL, NULL, 'naalp2199@gmail.com', 'Benito', '2023-10-10 19:52:20', 'NULL', '2023-10-10 19:52:41', 1, 0),
(187, 'Britanny Rodriguez torres ', NULL, NULL, NULL, 'britanny_rodriguez2526@hotmail.com', '260293BRT', '2023-10-10 20:01:04', 'NULL', '2023-10-10 20:02:01', 1, 0),
(188, 'Yazmin Lara gonzalez', NULL, NULL, NULL, 'yazytavo@hotmail.com', 'superman15', '2023-10-10 20:07:41', 'NULL', '2023-10-10 21:26:58', 1, 0),
(189, 'Elizabeth Román Zárate ', NULL, NULL, NULL, 'elizaroman1510@gmail.com', '1328', '2023-10-10 20:09:06', 'NULL', '2023-10-10 20:09:33', 1, 0),
(190, 'Lupita  rubio', NULL, NULL, NULL, 'guadaluperubioreyes31@gmail.com', '123456y', '2023-10-10 20:18:52', 'NULL', '2023-10-10 20:19:31', 1, 0),
(191, 'Iris Yoselin Garcia Perez ', NULL, NULL, NULL, 'iris.puqkita@gmail.com', 'Maxi2468', '2023-10-10 20:25:44', 'NULL', '2023-10-10 20:26:27', 1, 0),
(192, 'Jessica ', NULL, NULL, NULL, 'jessi.mun.vaz3264@gmail.com', '326454', '2023-10-10 20:37:09', 'NULL', '2023-10-10 20:39:10', 1, 0),
(193, 'Sarvia Margarita Pérez Ruiz ', NULL, NULL, NULL, 'magui222513@gmail.com', '220204', '2023-10-10 20:39:53', 'NULL', '2023-10-10 20:40:36', 1, 0),
(194, 'Reyes Castillo Diana Michelle ', NULL, NULL, NULL, 'dianucha99@gmail.com', 'asdfgnlkjh', '2023-10-10 20:40:16', 'NULL', '2023-10-10 20:41:03', 1, 0),
(195, 'Emmanuel Hernandez', NULL, NULL, NULL, 'Emmanuelhdez97@outlook.com', 'genios15', '2023-10-10 20:48:25', 'NULL', '2023-10-10 20:53:02', 1, 0),
(196, 'Diego Germán Sandoval Rosas ', NULL, NULL, NULL, 'diegosandoval282@outlook.com', '318343', '2023-10-10 20:51:47', 'NULL', '2023-10-10 20:52:27', 1, 0),
(197, 'Jessica Peñaloza Terrazas ', NULL, NULL, NULL, 'bunibunx3@gmail.com', 'bunibun14', '2023-10-10 20:55:14', 'NULL', '2023-10-10 20:56:22', 1, 0),
(198, 'Paola Bermudez Lazcano ', NULL, NULL, NULL, 'paola_205@msn.com', 'paola22102014', '2023-10-10 21:01:13', 'NULL', '2023-10-10 21:01:53', 1, 0),
(199, 'Jazmib agueros', NULL, NULL, NULL, 'jazminagueros@gmail.com', 'fluff2426', '2023-10-10 21:17:08', 'NULL', '2023-10-10 21:17:46', 1, 0),
(200, 'Karla Vázquez Marcos', NULL, NULL, NULL, 'karla.marks15@gmail.com', '150818', '2023-10-10 21:19:51', 'NULL', '2023-10-10 21:20:11', 1, 0),
(201, 'Itzel Casas B ', NULL, NULL, NULL, 'la_sisi@hotmail.com', 'Minimo13', '2023-10-10 21:25:02', 'NULL', '2023-10-10 21:27:48', 1, 0),
(202, 'Dulce Pineda ', NULL, NULL, NULL, 'djossenely.pineda@gmail.com', 'savp2516', '2023-10-10 21:26:51', 'NULL', '2023-10-10 21:27:37', 1, 0),
(203, 'Monserrat Gea ', NULL, NULL, NULL, 'eclipse_ec17@hotmail.com', '110194', '2023-10-10 21:38:51', 'NULL', '2023-10-10 21:40:17', 1, 0),
(204, 'Brenda San Luis ', NULL, NULL, NULL, 'epo267.brendasanluiscastillo@gmail.com', 'bs020920', '2023-10-10 22:27:16', 'NULL', '2023-10-10 22:29:04', 1, 0),
(205, 'Jonathan Tellez Lagunas', NULL, NULL, NULL, 'nathanzellet@gmail.com', 'Sauris.97', '2023-10-10 22:29:58', 'NULL', '2023-10-10 22:30:41', 1, 0),
(206, 'Diana Evelyn Mendoza Lorenzo ', NULL, NULL, NULL, 'dm13le.bae@gmail.com', 'quesitolindo', '2023-10-10 22:39:11', 'NULL', '2023-10-10 22:39:37', 1, 0),
(207, 'Jimena Romero ', NULL, NULL, NULL, 'jimenacanchola271102@gmail.com', 'Jime2711', '2023-10-10 23:40:12', 'NULL', '2023-10-10 23:40:44', 1, 0),
(208, 'Zaira Moncayo ', NULL, NULL, NULL, 'zaira.gmn@gmail.com', 'Makena123', '2023-10-11 00:32:47', 'NULL', '2023-10-11 00:33:20', 1, 0),
(209, 'Diana Zamora Castro', NULL, NULL, NULL, 'zdiana256@gmail.com', '210780', '2023-10-11 00:35:54', 'NULL', '2023-10-11 00:37:06', 1, 0),
(210, 'Tzintli Nikte Tobón Vazquez ', NULL, NULL, NULL, 'tzinredfield@gmail.com', 'Chris051004', '2023-10-11 01:35:38', 'NULL', '2023-10-11 01:36:32', 1, 0),
(211, 'Luis Alberto Gamez ', NULL, NULL, NULL, 'worldgh@hotmail.com', 'conejosrabito', '2023-10-11 01:56:03', 'NULL', '2023-10-11 02:00:02', 1, 0),
(212, 'Melisa Ávila ', NULL, NULL, NULL, 'melisacelina04@gmail.com', 'meli181201', '2023-10-11 02:13:42', 'NULL', '2023-10-11 02:14:38', 1, 0),
(213, 'Karina monje', NULL, NULL, NULL, 'monmargabi27@gmail.com', 'monje2027', '2023-10-11 02:17:10', 'NULL', '2023-10-11 02:18:02', 1, 0),
(214, 'Sofía Antonia Quezada Maldonado', NULL, NULL, NULL, 'squezadamaldonado@gmail.com', 'SaQM**270419', '2023-10-11 07:19:44', 'NULL', '2023-10-11 07:20:35', 1, 0),
(215, 'Adriana Zúñiga ', NULL, NULL, NULL, 'zunigadriana1106@gmail.com', 'lucreLoreJass', '2023-10-11 08:30:37', 'NULL', '2023-10-11 08:31:05', 1, 0),
(216, 'Karen Daniela Rivera Beltrán ', NULL, NULL, NULL, 'karenrivera52696@gmail.com', 'Ariana74', '2023-10-11 09:10:46', 'NULL', '2023-10-11 09:11:22', 1, 0),
(217, 'Luna', NULL, NULL, NULL, 'vmeeds@gmail.com', 'P7g4J2r9', '2023-10-11 09:37:33', 'NULL', '2023-10-11 09:38:36', 1, 0),
(218, 'Noemi Pineda ', NULL, NULL, NULL, 'nopi_fire@hotmail.com', 'pawino984', '2023-10-11 09:49:41', 'NULL', '2023-10-11 10:19:05', 1, 0),
(219, 'Diana Laura Piña Huerta ', NULL, NULL, NULL, 'pidianitahu009@gmail.com', 'Liliciffe21', '2023-10-11 09:55:20', 'NULL', '2023-10-11 09:55:46', 1, 0),
(220, 'Tatiana Ortega Ramirez', NULL, NULL, NULL, 'montserrat.ortega.r@gmail.com', 'M9ntserrat36', '2023-10-11 10:19:07', 'NULL', '2023-10-11 10:19:45', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `expositores`
--
ALTER TABLE `expositores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
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
-- AUTO_INCREMENT de la tabla `expositores`
--
ALTER TABLE `expositores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
