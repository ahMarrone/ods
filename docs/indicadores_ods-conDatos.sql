-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-02-2017 a las 12:46:59
-- Versión del servidor: 5.5.54-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.21

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `indicadores_ods`
--
DROP DATABASE IF EXISTS `indicadores_ods`;
CREATE DATABASE IF NOT EXISTS `indicadores_ods` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `indicadores_ods`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agrupamientoRefGeografica`
--

DROP TABLE IF EXISTS `agrupamientoRefGeografica`;
CREATE TABLE IF NOT EXISTS `agrupamientoRefGeografica` (
  `id1` int(11) unsigned NOT NULL,
  `id2` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id1`,`id2`),
  KEY `refGeografica_ibfk_2` (`id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `agrupamientoRefGeografica`
--

INSERT INTO `agrupamientoRefGeografica` (`id1`, `id2`) VALUES
(31, 1),
(54, 1),
(57, 1),
(62, 1),
(63, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(83, 1),
(88, 1),
(94, 1),
(95, 1),
(96, 1),
(98, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(143, 1),
(144, 1),
(145, 1),
(146, 1),
(147, 1),
(148, 1),
(149, 1),
(150, 1),
(151, 1),
(152, 1),
(153, 1),
(154, 1),
(155, 1),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(165, 1),
(166, 1),
(167, 1),
(168, 1),
(169, 1),
(170, 1),
(171, 1),
(172, 1),
(173, 1),
(174, 1),
(176, 1),
(177, 1),
(178, 1),
(179, 1),
(180, 1),
(181, 1),
(182, 1),
(183, 1),
(184, 1),
(185, 1),
(186, 1),
(187, 1),
(188, 1),
(189, 1),
(190, 1),
(191, 1),
(192, 1),
(193, 1),
(194, 1),
(195, 1),
(196, 1),
(197, 1),
(198, 1),
(199, 1),
(200, 1),
(201, 1),
(202, 1),
(203, 1),
(204, 1),
(205, 1),
(206, 1),
(207, 1),
(208, 1),
(209, 1),
(210, 1),
(211, 1),
(212, 1),
(213, 1),
(214, 1),
(216, 1),
(376, 1),
(386, 1),
(410, 1),
(411, 1),
(412, 1),
(413, 1),
(414, 1),
(421, 1),
(552, 1),
(51, 2),
(319, 2),
(320, 2),
(321, 2),
(322, 2),
(323, 2),
(324, 2),
(325, 2),
(326, 2),
(327, 2),
(329, 2),
(330, 2),
(373, 2),
(374, 2),
(538, 2),
(539, 2),
(41, 3),
(48, 3),
(50, 3),
(67, 3),
(97, 3),
(99, 3),
(105, 3),
(282, 3),
(293, 3),
(295, 3),
(312, 3),
(315, 3),
(335, 3),
(336, 3),
(337, 3),
(343, 3),
(344, 3),
(349, 3),
(352, 3),
(353, 3),
(394, 3),
(395, 3),
(396, 3),
(453, 3),
(471, 3),
(332, 4),
(333, 4),
(341, 4),
(342, 4),
(345, 4),
(346, 4),
(347, 4),
(348, 4),
(380, 4),
(404, 4),
(405, 4),
(406, 4),
(438, 4),
(514, 4),
(516, 4),
(512, 5),
(520, 5),
(522, 5),
(523, 5),
(524, 5),
(525, 5),
(526, 5),
(527, 5),
(528, 5),
(530, 5),
(531, 5),
(532, 5),
(535, 5),
(536, 5),
(537, 5),
(38, 6),
(240, 6),
(242, 6),
(328, 6),
(354, 6),
(355, 6),
(356, 6),
(357, 6),
(358, 6),
(359, 6),
(360, 6),
(361, 6),
(362, 6),
(363, 6),
(364, 6),
(365, 6),
(366, 6),
(367, 6),
(368, 6),
(369, 6),
(370, 6),
(371, 6),
(372, 6),
(375, 6),
(409, 6),
(475, 6),
(30, 7),
(33, 7),
(40, 7),
(47, 7),
(59, 7),
(66, 7),
(69, 7),
(70, 7),
(71, 7),
(72, 7),
(74, 7),
(79, 7),
(80, 7),
(81, 7),
(82, 7),
(84, 7),
(85, 7),
(86, 7),
(87, 7),
(89, 7),
(90, 7),
(91, 7),
(92, 7),
(93, 7),
(454, 7),
(25, 8),
(26, 8),
(27, 8),
(28, 8),
(29, 8),
(32, 8),
(35, 8),
(39, 8),
(42, 8),
(43, 8),
(44, 8),
(45, 8),
(46, 8),
(49, 8),
(52, 8),
(56, 8),
(58, 8),
(316, 9),
(317, 9),
(318, 9),
(391, 9),
(392, 9),
(393, 9),
(397, 9),
(400, 9),
(468, 9),
(299, 10),
(300, 10),
(301, 10),
(302, 10),
(303, 10),
(304, 10),
(305, 10),
(306, 10),
(307, 10),
(308, 10),
(309, 10),
(310, 10),
(311, 10),
(313, 10),
(314, 10),
(452, 10),
(34, 11),
(285, 11),
(286, 11),
(287, 11),
(288, 11),
(289, 11),
(290, 11),
(291, 11),
(292, 11),
(294, 11),
(296, 11),
(297, 11),
(298, 11),
(415, 11),
(416, 11),
(417, 11),
(418, 11),
(419, 11),
(420, 11),
(422, 11),
(518, 11),
(519, 11),
(55, 12),
(263, 12),
(265, 12),
(267, 12),
(272, 12),
(273, 12),
(274, 12),
(275, 12),
(276, 12),
(277, 12),
(278, 12),
(279, 12),
(280, 12),
(281, 12),
(283, 12),
(284, 12),
(350, 12),
(463, 12),
(175, 13),
(250, 13),
(254, 13),
(256, 13),
(257, 13),
(259, 13),
(260, 13),
(261, 13),
(269, 13),
(270, 13),
(271, 13),
(377, 13),
(378, 13),
(379, 13),
(428, 13),
(429, 13),
(430, 13),
(551, 13),
(36, 14),
(37, 14),
(53, 14),
(60, 14),
(61, 14),
(64, 14),
(65, 14),
(68, 14),
(73, 14),
(383, 14),
(384, 14),
(385, 14),
(387, 14),
(388, 14),
(389, 14),
(390, 14),
(423, 14),
(464, 15),
(465, 15),
(481, 15),
(482, 15),
(483, 15),
(484, 15),
(485, 15),
(486, 15),
(487, 15),
(488, 15),
(489, 15),
(490, 15),
(491, 15),
(492, 15),
(493, 15),
(494, 15),
(340, 16),
(398, 16),
(399, 16),
(401, 16),
(402, 16),
(403, 16),
(407, 16),
(408, 16),
(435, 16),
(436, 16),
(439, 16),
(478, 16),
(479, 16),
(243, 17),
(244, 17),
(245, 17),
(246, 17),
(247, 17),
(248, 17),
(249, 17),
(251, 17),
(252, 17),
(253, 17),
(255, 17),
(258, 17),
(262, 17),
(264, 17),
(266, 17),
(268, 17),
(451, 17),
(455, 17),
(462, 17),
(466, 17),
(467, 17),
(470, 17),
(474, 17),
(125, 18),
(142, 18),
(160, 18),
(223, 18),
(230, 18),
(231, 18),
(232, 18),
(233, 18),
(234, 18),
(235, 18),
(236, 18),
(237, 18),
(238, 18),
(239, 18),
(241, 18),
(351, 18),
(427, 18),
(476, 18),
(477, 18),
(226, 19),
(229, 19),
(456, 19),
(457, 19),
(458, 19),
(459, 19),
(460, 19),
(461, 19),
(480, 19),
(334, 20),
(338, 20),
(339, 20),
(381, 20),
(382, 20),
(517, 20),
(540, 20),
(424, 21),
(425, 21),
(426, 21),
(431, 21),
(432, 21),
(433, 21),
(434, 21),
(440, 21),
(441, 21),
(442, 21),
(443, 21),
(444, 21),
(445, 21),
(446, 21),
(447, 21),
(448, 21),
(449, 21),
(450, 21),
(515, 21),
(215, 22),
(217, 22),
(218, 22),
(219, 22),
(220, 22),
(221, 22),
(222, 22),
(224, 22),
(225, 22),
(227, 22),
(228, 22),
(469, 22),
(472, 22),
(473, 22),
(529, 22),
(533, 22),
(534, 22),
(541, 22),
(542, 22),
(543, 22),
(544, 22),
(545, 22),
(546, 22),
(547, 22),
(548, 22),
(549, 22),
(550, 22),
(331, 23),
(437, 23),
(509, 23),
(521, 23),
(553, 23),
(495, 24),
(496, 24),
(497, 24),
(498, 24),
(499, 24),
(500, 24),
(501, 24),
(502, 24),
(503, 24),
(504, 24),
(505, 24),
(506, 24),
(507, 24),
(508, 24),
(510, 24),
(511, 24),
(513, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desgloces`
--

DROP TABLE IF EXISTS `desgloces`;
CREATE TABLE IF NOT EXISTS `desgloces` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desglose',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------
INSERT INTO `desgloces` (`id`, `descripcion`) VALUES
(0, 'Sin desglose');



--
-- Estructura de tabla para la tabla `desglocesIndicadores`
--

DROP TABLE IF EXISTS `desglocesIndicadores`;
CREATE TABLE IF NOT EXISTS `desglocesIndicadores` (
  `idIndicador` int(11) unsigned NOT NULL,
  `idDesgloce` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idIndicador`,`idDesgloce`),
  KEY `idIndicador` (`idIndicador`),
  KEY `idDesgloce` (`idDesgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la etiqueta',
  `fkIdDesgloce` int(11) unsigned NOT NULL COMMENT 'clave foranea desgloce',
  PRIMARY KEY (`id`),
  KEY `fkIdDesgloce` (`fkIdDesgloce`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;

INSERT INTO `etiquetas` (`id`, `descripcion`, `fkIdDesgloce`) VALUES
(0, 'Sin etiqueta', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

DROP TABLE IF EXISTS `indicadores`;
CREATE TABLE IF NOT EXISTS `indicadores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fkIdMeta` int(11) unsigned NOT NULL COMMENT 'clave foranea meta',
  `codigo` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'código del indicador',
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del indicador',
  `tipo` enum('porcentual','entero','real') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de indicador',
  `valMin` bigint(20) NOT NULL COMMENT 'valor minimo dentro del dominio',
  `valMax` bigint(20) NOT NULL COMMENT 'valor maximo dentro del dominio',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito al que pertenece el indicador',
  `visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Nacional',
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  `fechasDestacadas` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documentpath` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaMetaIntermedia` date DEFAULT NULL,
  `valorEsperadoMetaIntermedia` decimal(15,6) DEFAULT NULL,
  `fechaMetaFinal` date DEFAULT NULL,
  `valorEsperadoMetaFinal` decimal(15,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdMeta` (`fkIdMeta`),
  KEY `ndxUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

DROP TABLE IF EXISTS `metas`;
CREATE TABLE IF NOT EXISTS `metas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(8) COLLATE utf8_spanish_ci NOT NULL COMMENT 'código de la meta',
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL,
  `fkIdObjetivo` int(11) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdObjetivo` (`fkIdObjetivo`),
  KEY `ndxUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;


--
-- Estructura de tabla para la tabla `objetivos`
--

DROP TABLE IF EXISTS `objetivos`;
CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'código del objetivo',
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;

--
-- Volcado de datos para la tabla `objetivos`
--

INSERT INTO `objetivos` (`id`, `codigo`, `descripcion`) VALUES
(1, '1', 'Poner fin a la pobreza en todas sus formas en todo el mundo'),
(2, '2', 'Poner fin al hambre, lograr la seguridad alimentaria y la mejora de la nutrición y promover la agricultura sostenible'),
(3, '3', 'Garantizar una vida sana y promover el bienestar para todos en todas las edades'),
(4, '4', 'Garantizar una educación inclusiva, equitativa y de calidad y promover oportunidades de aprendizaje durante toda la vida para todos'),
(5, '5', 'Lograr la igualdad entre los géneros y empoderar a todas las mujeres y las niñas'),
(6, '6', 'Garantizar la disponibilidad de agua y su gestión sostenible y el saneamiento para todos'),
(7, '7', 'Garantizar el acceso a una energía asequible, segura, sostenible y moderna para todos'),
(8, '8', 'Promover el crecimiento económico sostenido, inclusivo y sostenible, el empleo pleno y productivo y el trabajo decente para todos'),
(9, '9', 'Construir infraestructuras resilientes, promover la industrialización inclusiva y sostenible y fomentar la innovación'),
(10, '10', 'Reducir la desigualdad en y entre los países'),
(11, '11', 'Lograr que las ciudades y los asentamientos humanos sean inclusivos, seguros, resilientes y sostenibles'),
(12, '12', 'Garantizar modalidades de consumo y producción sostenibles'),
(13, '13', 'Adoptar medidas urgentes para combatir el cambio climático y sus efectos'),
(14, '14', 'Conservar y utilizar en forma sostenible los océanos, los mares y los recursos marinos para el desarrollo sostenible'),
(15, '15', 'Proteger, restablecer y promover el uso sostenible de los ecosistemas terrestres, gestionar los bosques de forma sostenible de los bosques, luchar contra la desertificación, detener e invertir la degradación de las tierras y poner freno a la pérdida de la diversidad biológica'),
(16, '16', 'Promover sociedades pacíficas e inclusivas para el desarrollo sostenible, facilitar el acceso a la justicia para todos y crear instituciones eficaces, responsables e inclusivas a todos los niveles'),
(17, '17', 'Fortalecer los medios de ejecución y revitalizar la Alianza Mundial para el Desarrollo Sostenible Finanzas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refGeografica`
--

DROP TABLE IF EXISTS `refGeografica`;
CREATE TABLE IF NOT EXISTS `refGeografica` (
  `id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ;

--
-- Volcado de datos para la tabla `refGeografica`
--

INSERT INTO `refGeografica` (`id`, `descripcion`, `ambito`) VALUES
(0, 'PAIS', 'N'),
(1, 'BUENOS AIRES', 'P'),
(2, 'CATAMARCA', 'P'),
(3, 'CHACO', 'P'),
(4, 'CHUBUT', 'P'),
(5, 'CIUDAD AUTONOMA DE BUENOS AIRES', 'P'),
(6, 'CORDOBA', 'P'),
(7, 'CORRIENTES', 'P'),
(8, 'ENTRE RIOS', 'P'),
(9, 'FORMOSA', 'P'),
(10, 'JUJUY', 'P'),
(11, 'LA PAMPA', 'P'),
(12, 'LA RIOJA', 'P'),
(13, 'MENDOZA', 'P'),
(14, 'MISIONES', 'P'),
(15, 'NEUQUEN', 'P'),
(16, 'RIO NEGRO', 'P'),
(17, 'SALTA', 'P'),
(18, 'SAN JUAN', 'P'),
(19, 'SAN LUIS', 'P'),
(20, 'SANTA CRUZ', 'P'),
(21, 'SANTA FE', 'P'),
(22, 'SANTIAGO DEL ESTERO', 'P'),
(23, 'TIERRA DEL FUEGO', 'P'),
(24, 'TUCUMAN', 'P'),
(25, 'CONCORDIA', 'D'),
(26, 'SAN SALVADOR', 'D'),
(27, 'VILLAGUAY', 'D'),
(28, 'COLON', 'D'),
(29, 'FEDERAL', 'D'),
(30, 'CAPITAL', 'D'),
(31, 'ALMIRANTE BROWN', 'D'),
(32, 'NOGOYA', 'D'),
(33, 'ITATI', 'D'),
(34, 'ATREUCO', 'D'),
(35, 'TALA', 'D'),
(36, 'CAINGUAS', 'D'),
(37, 'LEANDRO N. ALEM', 'D'),
(38, 'PRESIDENTE ROQUE SAENZ PENA', 'D'),
(39, 'GUALEGUAYCHU', 'D'),
(40, 'BERON DE ASTRADA', 'D'),
(41, 'QUITILIPI', 'D'),
(42, 'ISLAS DEL IBICUY', 'D'),
(43, 'GUALEGUAY', 'D'),
(44, 'FEDERACION', 'D'),
(45, 'LA PAZ', 'D'),
(46, 'FELICIANO', 'D'),
(47, 'GENERAL PAZ', 'D'),
(48, 'PRESIDENCIA DE LA PLAZA', 'D'),
(49, 'VICTORIA', 'D'),
(50, 'SAN LORENZO', 'D'),
(51, 'CAPAYAN', 'D'),
(52, 'DIAMANTE', 'D'),
(53, 'MONTECARLO', 'D'),
(54, 'LA PLATA', 'D'),
(55, 'CORONEL FELIPE VARELA', 'D'),
(56, 'URUGUAY', 'D'),
(57, 'PRESIDENTE PERON', 'D'),
(58, 'PARANA', 'D'),
(59, 'MERCEDES', 'D'),
(60, 'APOSTOLES', 'D'),
(61, 'CANDELARIA', 'D'),
(62, 'CARLOS CASARES', 'D'),
(63, 'SALADILLO', 'D'),
(64, 'LIBERTADOR GENERAL SAN MARTIN', 'D'),
(65, 'CAPITAL', 'D'),
(66, 'CONCEPCION', 'D'),
(67, 'O''HIGGINS', 'D'),
(68, 'ELDORADO', 'D'),
(69, 'SAN ROQUE', 'D'),
(70, 'SALADAS', 'D'),
(71, 'MBURUCUYA', 'D'),
(72, 'SAN LUIS DEL PALMAR', 'D'),
(73, 'SAN PEDRO', 'D'),
(74, 'SANTO TOME', 'D'),
(75, 'PEHUAJO', 'D'),
(76, 'TRENQUE LAUQUEN', 'D'),
(77, 'GENERAL BELGRANO', 'D'),
(78, 'LAS FLORES', 'D'),
(79, 'GENERAL ALVEAR', 'D'),
(80, 'SAN MARTIN', 'D'),
(81, 'PASO DE LOS LIBRES', 'D'),
(82, 'MONTE CASEROS', 'D'),
(83, 'GENERAL GUIDO', 'D'),
(84, 'CURUZU CUATIA', 'D'),
(85, 'SAUCE', 'D'),
(86, 'ESQUINA', 'D'),
(87, 'ITUZAINGO', 'D'),
(88, 'OLAVARRIA', 'D'),
(89, 'SAN MIGUEL', 'D'),
(90, 'GOYA', 'D'),
(91, 'LAVALLE', 'D'),
(92, 'BELLA VISTA', 'D'),
(93, 'EMPEDRADO', 'D'),
(94, 'ROJAS', 'D'),
(95, 'SAN ANTONIO DE ARECO', 'D'),
(96, 'MAIPU', 'D'),
(97, '9 DE JULIO', 'D'),
(98, 'ARRECIFES', 'D'),
(99, '2 DE ABRIL', 'D'),
(100, 'CAPITAN SARMIENTO', 'D'),
(101, 'CARMEN DE ARECO', 'D'),
(102, 'PINAMAR', 'D'),
(103, 'SALTO', 'D'),
(104, 'EXALTACION DE LA CRUZ', 'D'),
(105, 'TAPENAGA', 'D'),
(106, 'ESCOBAR', 'D'),
(107, 'SAN MIGUEL', 'D'),
(108, 'SAN ANDRES DE GILES', 'D'),
(109, 'JUNIN', 'D'),
(110, 'MERCEDES', 'D'),
(111, 'GENERAL VILLEGAS', 'D'),
(112, 'PILAR', 'D'),
(113, 'LUJAN', 'D'),
(114, 'HURLINGHAM', 'D'),
(115, 'MORON', 'D'),
(116, 'CHACABUCO', 'D'),
(117, 'MALVINAS ARGENTINAS', 'D'),
(118, 'JOSE C PAZ', 'D'),
(119, 'GENERAL SAN MARTIN', 'D'),
(120, 'MORENO', 'D'),
(121, 'LINCOLN', 'D'),
(122, 'ITUZAINGO', 'D'),
(123, 'FLORENTINO AMEGHINO', 'D'),
(124, 'LA MATANZA', 'D'),
(125, 'RIVADAVIA', 'D'),
(126, 'GENERAL RODRIGUEZ', 'D'),
(127, 'SUIPACHA', 'D'),
(128, 'TRES DE FEBRERO', 'D'),
(129, 'MERLO', 'D'),
(130, 'CHIVILCOY', 'D'),
(131, 'BRAGADO', 'D'),
(132, 'LANUS', 'D'),
(133, 'GENERAL LAS HERAS', 'D'),
(134, 'MARCOS PAZ', 'D'),
(135, 'LOMAS DE ZAMORA', 'D'),
(136, 'GENERAL VIAMONTE', 'D'),
(137, 'ESTEBAN ECHEVERRIA', 'D'),
(138, 'EZEIZA', 'D'),
(139, 'ALBERTI', 'D'),
(140, 'FLORENCIO VARELA', 'D'),
(141, 'NAVARRO', 'D'),
(142, 'SANTA LUCIA', 'D'),
(143, 'CAÑUELAS', 'D'),
(144, 'SAN VICENTE', 'D'),
(145, 'LOBOS', 'D'),
(146, 'BRANDSEN', 'D'),
(147, 'CARLOS TEJEDOR', 'D'),
(148, '25 DE MAYO', 'D'),
(149, '9 DE JULIO', 'D'),
(150, 'GENERAL PAZ', 'D'),
(151, 'MONTE', 'D'),
(152, 'ROQUE PEREZ', 'D'),
(153, 'GENERAL ALVEAR', 'D'),
(154, 'QUILMES', 'D'),
(155, 'PILA', 'D'),
(156, 'GENERAL LA MADRID', 'D'),
(157, 'BOLIVAR', 'D'),
(158, 'BALCARCE', 'D'),
(159, 'VICENTE LOPEZ', 'D'),
(160, 'CAPITAL', 'D'),
(161, 'TAPALQUE', 'D'),
(162, 'HIPOLITO YRIGOYEN', 'D'),
(163, 'DOLORES', 'D'),
(164, 'RAUCH', 'D'),
(165, 'AZUL', 'D'),
(166, 'DAIREAUX', 'D'),
(167, 'TRES LOMAS', 'D'),
(168, 'AYACUCHO', 'D'),
(169, 'GUAMINI', 'D'),
(170, 'SALLIQUELO', 'D'),
(171, 'GENERAL JUAN MADARIAGA', 'D'),
(172, 'ENSENADA', 'D'),
(173, 'BERAZATEGUI', 'D'),
(174, 'TANDIL', 'D'),
(175, 'GUAYMALLEN', 'D'),
(176, 'CORONEL SUAREZ', 'D'),
(177, 'LAPRIDA', 'D'),
(178, 'AVELLANEDA', 'D'),
(179, 'SAN ISIDRO', 'D'),
(180, 'BENITO JUAREZ', 'D'),
(181, 'SAAVEDRA', 'D'),
(182, 'ADOLFO GONZALES CHAVES', 'D'),
(183, 'CORONEL PRINGLES', 'D'),
(184, 'TORNQUIST', 'D'),
(185, 'TIGRE', 'D'),
(186, 'GENERAL PINTO', 'D'),
(187, 'SAN CAYETANO', 'D'),
(188, 'TRES ARROYOS', 'D'),
(189, 'CORONEL DE MARINA LEONARDO ROSALES', 'D'),
(190, 'VILLA GESELL', 'D'),
(191, 'BAHIA BLANCA', 'D'),
(192, 'MONTE HERMOSO', 'D'),
(193, 'CORONEL DORREGO', 'D'),
(194, 'NECOCHEA', 'D'),
(195, 'LOBERIA', 'D'),
(196, 'GENERAL ALVARADO', 'D'),
(197, 'CHASCOMUS', 'D'),
(198, 'BERISSO', 'D'),
(199, 'GENERAL PUEYRREDON', 'D'),
(200, 'MAR CHIQUITA', 'D'),
(201, 'LA COSTA', 'D'),
(202, 'GENERAL LAVALLE', 'D'),
(203, 'TORDILLO', 'D'),
(204, 'CASTELLI', 'D'),
(205, 'PUNTA INDIO', 'D'),
(206, 'MAGDALENA', 'D'),
(207, 'SAN FERNANDO', 'D'),
(208, 'CAMPANA', 'D'),
(209, 'BARADERO', 'D'),
(210, 'ZARATE', 'D'),
(211, 'SAN PEDRO', 'D'),
(212, 'RAMALLO', 'D'),
(213, 'SAN NICOLAS', 'D'),
(214, 'PERGAMINO', 'D'),
(215, 'FIGUEROA', 'D'),
(216, 'COLON', 'D'),
(217, 'AVELLANEDA', 'D'),
(218, 'PELLEGRINI', 'D'),
(219, 'SALAVINA', 'D'),
(220, 'GENERAL TABOADA', 'D'),
(221, 'ALBERDI', 'D'),
(222, 'MORENO', 'D'),
(223, 'ZONDA', 'D'),
(224, 'JUAN F IBARRA', 'D'),
(225, 'CHOYA', 'D'),
(226, 'AYACUCHO', 'D'),
(227, 'RIVADAVIA', 'D'),
(228, 'OJO DE AGUA', 'D'),
(229, 'GOBERNADOR DUPUY', 'D'),
(230, 'ULLUM', 'D'),
(231, 'ANGACO', 'D'),
(232, 'ALBARDON', 'D'),
(233, 'CHIMBAS', 'D'),
(234, '9 DE JULIO', 'D'),
(235, 'RAWSON', 'D'),
(236, 'POCITO', 'D'),
(237, 'SAN MARTIN', 'D'),
(238, 'CAUCETE', 'D'),
(239, 'JACHAL', 'D'),
(240, 'TERCERO ARRIBA', 'D'),
(241, '25 DE MAYO', 'D'),
(242, 'JUAREZ CELMAN', 'D'),
(243, 'CAPITAL', 'D'),
(244, 'CACHI', 'D'),
(245, 'CERRILLOS', 'D'),
(246, 'CHICOANA', 'D'),
(247, 'LA VIÑA', 'D'),
(248, 'SANTA VICTORIA', 'D'),
(249, 'GENERAL JOSE DE SAN MARTIN', 'D'),
(250, 'SANTA ROSA', 'D'),
(251, 'RIVADAVIA', 'D'),
(252, 'METAN', 'D'),
(253, 'LA CANDELARIA', 'D'),
(254, 'MAIPU', 'D'),
(255, 'GUACHIPAS', 'D'),
(256, 'CAPITAL', 'D'),
(257, 'GODOY CRUZ', 'D'),
(258, 'CAFAYATE', 'D'),
(259, 'JUNIN', 'D'),
(260, 'RIVADAVIA', 'D'),
(261, 'GENERAL ALVEAR', 'D'),
(262, 'MOLINOS', 'D'),
(263, 'CASTRO BARROS', 'D'),
(264, 'GENERAL GÜEMES', 'D'),
(265, 'SANAGASTA', 'D'),
(266, 'SAN CARLOS', 'D'),
(267, 'GENERAL OCAMPO', 'D'),
(268, 'ROSARIO DE LERMA', 'D'),
(269, 'SAN MARTIN', 'D'),
(270, 'LA PAZ', 'D'),
(271, 'SAN RAFAEL', 'D'),
(272, 'CHILECITO', 'D'),
(273, 'GENERAL ANGEL V. PEÑALOZA', 'D'),
(274, 'GENERAL BELGRANO', 'D'),
(275, 'CHAMICAL', 'D'),
(276, 'INDEPENDENCIA', 'D'),
(277, 'GENERAL JUAN F. QUIROGA', 'D'),
(278, 'ROSARIO VERA PEÑALOZA', 'D'),
(279, 'GENERAL SAN MARTIN', 'D'),
(280, 'VINCHINA', 'D'),
(281, 'FAMATINA', 'D'),
(282, 'LIBERTAD', 'D'),
(283, 'SAN BLAS DE LOS SAUCES', 'D'),
(284, 'ARAUCO', 'D'),
(285, 'REALICO', 'D'),
(286, 'TRENEL', 'D'),
(287, 'CHALILEO', 'D'),
(288, 'LOVENTUE', 'D'),
(289, 'TOAY', 'D'),
(290, 'CAPITAL', 'D'),
(291, 'LIMAY MAHUIDA', 'D'),
(292, 'UTRACAN', 'D'),
(293, 'MAYOR LUIS J. FONTANA', 'D'),
(294, 'CURACO', 'D'),
(295, 'FRAY JUSTO SANTA MARIA DE ORO', 'D'),
(296, 'LIHUEL CALEL', 'D'),
(297, 'RANCUL', 'D'),
(298, 'CONHELO', 'D'),
(299, 'TILCARA', 'D'),
(300, 'PALPALA', 'D'),
(301, 'COCHINOCA', 'D'),
(302, 'TUMBAYA', 'D'),
(303, 'DOCTOR MANUEL BELGRANO', 'D'),
(304, 'SAN ANTONIO', 'D'),
(305, 'EL CARMEN', 'D'),
(306, 'SANTA BARBARA', 'D'),
(307, 'LEDESMA', 'D'),
(308, 'HUMAHUACA', 'D'),
(309, 'YAVI', 'D'),
(310, 'SANTA CATALINA', 'D'),
(311, 'SAN PEDRO', 'D'),
(312, '12 DE OCTUBRE', 'D'),
(313, 'VALLE GRANDE', 'D'),
(314, 'RINCONADA', 'D'),
(315, 'CHACABUCO', 'D'),
(316, 'RAMON LISTA', 'D'),
(317, 'PILCOMAYO', 'D'),
(318, 'FORMOSA', 'D'),
(319, 'CAPITAL', 'D'),
(320, 'ANCASTI', 'D'),
(321, 'BELEN', 'D'),
(322, 'SANTA MARIA', 'D'),
(323, 'ANDALGALA', 'D'),
(324, 'AMBATO', 'D'),
(325, 'PACLIN', 'D'),
(326, 'SANTA ROSA', 'D'),
(327, 'EL ALTO', 'D'),
(328, 'SOBREMONTE', 'D'),
(329, 'LA PAZ', 'D'),
(330, 'POMAN', 'D'),
(331, 'RIO GRANDE', 'D'),
(332, 'MARTIRES', 'D'),
(333, 'PASO DE INDIOS', 'D'),
(334, 'MAGALLANES', 'D'),
(335, 'SARGENTO CABRAL', 'D'),
(336, 'COMANDANTE FERNANDEZ', 'D'),
(337, 'INDEPENDENCIA', 'D'),
(338, 'CORPEN AIKE', 'D'),
(339, 'DESEADO', 'D'),
(340, 'CONESA', 'D'),
(341, 'LANGUIÑEO', 'D'),
(342, 'GAIMAN', 'D'),
(343, 'GENERAL BELGRANO', 'D'),
(344, 'GENERAL DONOVAN', 'D'),
(345, 'RAWSON', 'D'),
(346, 'TEHUELCHES', 'D'),
(347, 'ESCALANTE', 'D'),
(348, 'FLORENTINO AMEGHINO', 'D'),
(349, '25 DE MAYO', 'D'),
(350, 'GENERAL LAMADRID', 'D'),
(351, 'CALINGASTA', 'D'),
(352, 'MAIPU', 'D'),
(353, '1° DE MAYO', 'D'),
(354, 'TULUMBA', 'D'),
(355, 'ISCHILIN', 'D'),
(356, 'TOTORAL', 'D'),
(357, 'CRUZ DEL EJE', 'D'),
(358, 'COLON', 'D'),
(359, 'PUNILLA', 'D'),
(360, 'CAPITAL', 'D'),
(361, 'GENERAL SAN MARTIN', 'D'),
(362, 'SANTA MARIA', 'D'),
(363, 'MINAS', 'D'),
(364, 'POCHO', 'D'),
(365, 'SAN ALBERTO', 'D'),
(366, 'SAN JAVIER', 'D'),
(367, 'RIO SEGUNDO', 'D'),
(368, 'SAN JUSTO', 'D'),
(369, 'UNION', 'D'),
(370, 'RIO PRIMERO', 'D'),
(371, 'MARCOS JUAREZ', 'D'),
(372, 'RIO CUARTO', 'D'),
(373, 'ANTOFAGASTA DE LA SIERRA', 'D'),
(374, 'TINOGASTA', 'D'),
(375, 'GENERAL ROCA', 'D'),
(376, 'LEANDRO N ALEM', 'D'),
(377, 'TUPUNGATO', 'D'),
(378, 'TUNUYAN', 'D'),
(379, 'LUJAN DE CUYO', 'D'),
(380, 'FUTALEUFU', 'D'),
(381, 'RIO CHICO', 'D'),
(382, 'LAGO ARGENTINO', 'D'),
(383, 'SAN JAVIER', 'D'),
(384, 'CONCEPCION', 'D'),
(385, 'GUARANI', 'D'),
(386, 'GENERAL ARENALES', 'D'),
(387, '25 DE MAYO', 'D'),
(388, 'OBERA', 'D'),
(389, 'GENERAL MANUEL BELGRANO', 'D'),
(390, 'SAN IGNACIO', 'D'),
(391, 'PIRANE', 'D'),
(392, 'PATIÑO', 'D'),
(393, 'BERMEJO', 'D'),
(394, 'BERMEJO', 'D'),
(395, 'LIBERTADOR GENERAL SAN MARTIN', 'D'),
(396, 'GENERAL GUEMES', 'D'),
(397, 'PILAGAS', 'D'),
(398, 'VALCHETA', 'D'),
(399, 'SAN ANTONIO', 'D'),
(400, 'LAISHI', 'D'),
(401, '9 DE JULIO', 'D'),
(402, 'ÑORQUINCO', 'D'),
(403, '25 DE MAYO', 'D'),
(404, 'BIEDMA', 'D'),
(405, 'TELSEN', 'D'),
(406, 'GASTRE', 'D'),
(407, 'EL CUY', 'D'),
(408, 'PILCANIYEU', 'D'),
(409, 'CALAMUCHITA', 'D'),
(410, 'ADOLFO ALSINA', 'D'),
(411, 'RIVADAVIA', 'D'),
(412, 'PELLEGRINI', 'D'),
(413, 'PUAN', 'D'),
(414, 'VILLARINO', 'D'),
(415, 'MARACO', 'D'),
(416, 'QUEMU QUEMU', 'D'),
(417, 'CATRILO', 'D'),
(418, 'CALEU CALEU', 'D'),
(419, 'GUATRACHE', 'D'),
(420, 'HUCAL', 'D'),
(421, 'PATAGONES', 'D'),
(422, 'CHAPALEUFU', 'D'),
(423, 'IGUAZU', 'D'),
(424, 'IRIONDO', 'D'),
(425, 'SAN JUSTO', 'D'),
(426, 'LAS COLONIAS', 'D'),
(427, 'SARMIENTO', 'D'),
(428, 'LAS HERAS', 'D'),
(429, 'LAVALLE', 'D'),
(430, 'MALARGÜE', 'D'),
(431, 'SAN JERONIMO', 'D'),
(432, 'GENERAL LOPEZ', 'D'),
(433, 'ROSARIO', 'D'),
(434, 'SAN LORENZO', 'D'),
(435, 'PICHI MAHUIDA', 'D'),
(436, 'ADOLFO ALSINA', 'D'),
(437, 'USHUAIA', 'D'),
(438, 'RIO SENGUER', 'D'),
(439, 'BARILOCHE', 'D'),
(440, 'GARAY', 'D'),
(441, 'SAN JAVIER', 'D'),
(442, 'VERA', 'D'),
(443, 'CASTELLANOS', 'D'),
(444, 'BELGRANO', 'D'),
(445, 'CASEROS', 'D'),
(446, '9 DE JULIO', 'D'),
(447, 'SAN MARTIN', 'D'),
(448, 'GENERAL OBLIGADO', 'D'),
(449, 'LA CAPITAL', 'D'),
(450, 'CONSTITUCION', 'D'),
(451, 'LOS ANDES', 'D'),
(452, 'SUSQUES', 'D'),
(453, 'SAN FERNANDO', 'D'),
(454, 'SAN COSME', 'D'),
(455, 'LA POMA', 'D'),
(456, 'CHACABUCO', 'D'),
(457, 'JUAN MARTIN DE PUEYRREDON', 'D'),
(458, 'GENERAL PEDERNERA', 'D'),
(459, 'LIBERTADOR GENERAL SAN MARTIN', 'D'),
(460, 'CORONEL PRINGLES', 'D'),
(461, 'JUNIN', 'D'),
(462, 'LA CALDERA', 'D'),
(463, 'CAPITAL', 'D'),
(464, 'HUILICHES', 'D'),
(465, 'CATAN LIL', 'D'),
(466, 'IRUYA', 'D'),
(467, 'ORAN', 'D'),
(468, 'MATACOS', 'D'),
(469, 'SILIPICA', 'D'),
(470, 'ANTA', 'D'),
(471, 'ALMIRANTE BROWN', 'D'),
(472, 'COPO', 'D'),
(473, 'RIO HONDO', 'D'),
(474, 'ROSARIO DE LA FRONTERA', 'D'),
(475, 'RIO SECO', 'D'),
(476, 'VALLE FERTIL', 'D'),
(477, 'IGLESIA', 'D'),
(478, 'AVELLANEDA', 'D'),
(479, 'GENERAL ROCA', 'D'),
(480, 'BELGRANO', 'D'),
(481, 'LOS LAGOS', 'D'),
(482, 'LACAR', 'D'),
(483, 'COLLON CURA', 'D'),
(484, 'PICUN LEUFU', 'D'),
(485, 'ALUMINE', 'D'),
(486, 'ZAPALA', 'D'),
(487, 'CONFLUENCIA', 'D'),
(488, 'PICUNCHES', 'D'),
(489, 'AÑELO', 'D'),
(490, 'LONCOPUE', 'D'),
(491, 'ÑORQUIN', 'D'),
(492, 'PEHUENCHES', 'D'),
(493, 'MINAS', 'D'),
(494, 'CHOS MALAL', 'D'),
(495, 'LA COCHA', 'D'),
(496, 'GRANEROS', 'D'),
(497, 'JUAN BAUTISTA ALBERDI', 'D'),
(498, 'RIO CHICO', 'D'),
(499, 'CHICLIGASTA', 'D'),
(500, 'SIMOCA', 'D'),
(501, 'LULES', 'D'),
(502, 'MONTEROS', 'D'),
(503, 'LEALES', 'D'),
(504, 'FAMAILLA', 'D'),
(505, 'YERBA BUENA', 'D'),
(506, 'BURRUYACU', 'D'),
(507, 'TAFI VIEJO', 'D'),
(508, 'TAFI DEL VALLE', 'D'),
(509, 'ISLAS MALVINAS', 'D'),
(510, 'CAPITAL', 'D'),
(511, 'CRUZ ALTA', 'D'),
(512, 'COMUNA 6', 'D'),
(513, 'TRANCAS', 'D'),
(514, 'SARMIENTO', 'D'),
(515, 'SAN CRISTOBAL', 'D'),
(516, 'CUSHAMEN', 'D'),
(517, 'LAGO BUENOS AIRES', 'D'),
(518, 'CHICAL CO', 'D'),
(519, 'PUELEN', 'D'),
(520, 'COMUNA 1', 'D'),
(521, 'ISLAS DEL ATLANTICO SUR', 'D'),
(522, 'COMUNA 2', 'D'),
(523, 'COMUNA 3', 'D'),
(524, 'COMUNA 4', 'D'),
(525, 'COMUNA 5', 'D'),
(526, 'COMUNA 7', 'D'),
(527, 'COMUNA 8', 'D'),
(528, 'COMUNA 9', 'D'),
(529, 'BANDA', 'D'),
(530, 'COMUNA 10', 'D'),
(531, 'COMUNA 11', 'D'),
(532, 'COMUNA 12', 'D'),
(533, 'ROBLES', 'D'),
(534, 'CAPITAL', 'D'),
(535, 'COMUNA 13', 'D'),
(536, 'COMUNA 14', 'D'),
(537, 'COMUNA 15', 'D'),
(538, 'VALLE VIEJO', 'D'),
(539, 'FRAY MAMERTO ESQUIU', 'D'),
(540, 'GÜER AIKE', 'D'),
(541, 'SAN MARTIN', 'D'),
(542, 'MITRE', 'D'),
(543, 'SARMIENTO', 'D'),
(544, 'ATAMISQUI', 'D'),
(545, 'LORETO', 'D'),
(546, 'GUASAYAN', 'D'),
(547, 'JIMENEZ', 'D'),
(548, 'QUEBRACHOS', 'D'),
(549, 'BELGRANO', 'D'),
(550, 'AGUIRRE', 'D'),
(551, 'SAN CARLOS', 'D'),
(552, 'LEZAMA', 'D'),
(553, 'ANTARTIDA ARGENTINA', 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `domicilio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `localidad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dependencia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ambito` enum('N','P','D','L','R') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `apellido`, `nombre`, `domicilio`, `localidad`, `provincia`, `telefono`, `dependencia`, `ambito`, `observaciones`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'root', 'root', 'hgelt@politicassociales.gob.ar ', 'hgelt@politicassociales.gob.ar ', '', '', '', '', '', '', '', 'N', NULL, 1, 'p004rq1adaso08sw08gskkgcw48o84c', '$2y$13$p004rq1adaso08sw08gskeyrspSFcPvBTyHqX5swLtP1Zxr5RgtaO', '2017-02-17 12:41:56', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosRefGeografica`
--

DROP TABLE IF EXISTS `usuariosRefGeografica`;
CREATE TABLE IF NOT EXISTS `usuariosRefGeografica` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_refGeografica` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_refGeografica`),
  KEY `usuariosRefGeografica_ibfk_2` (`id_refGeografica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoresIndicadores`
--

DROP TABLE IF EXISTS `valoresIndicadores`;
CREATE TABLE IF NOT EXISTS `valoresIndicadores` (
  `idValoresIndicadoresConfigFecha` int(11) unsigned NOT NULL,
  `idEtiqueta` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Clave en formato string que representa el cruce de etuqietas del registro',
  `idRefGeografica` int(11) unsigned NOT NULL,
  `valor` decimal(15,6) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  PRIMARY KEY (`idValoresIndicadoresConfigFecha`,`idRefGeografica`,`idEtiqueta`),
  KEY `idDesglocesIndicadoresndicadores` (`idValoresIndicadoresConfigFecha`),
  KEY `idRefGeografica` (`idRefGeografica`),
  KEY `idEtiqueta` (`idEtiqueta`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoresIndicadoresConfigFecha`
--

DROP TABLE IF EXISTS `valoresIndicadoresConfigFecha`;
CREATE TABLE IF NOT EXISTS `valoresIndicadoresConfigFecha` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idIndicador` int(11) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `cruzado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desglocesIndicadores_uniq_1` (`idIndicador`,`fecha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoresIndicadoresConfigFechaDesgloces`
--

DROP TABLE IF EXISTS `valoresIndicadoresConfigFechaDesgloces`;
CREATE TABLE IF NOT EXISTS `valoresIndicadoresConfigFechaDesgloces` (
  `idDesgloce` int(11) unsigned NOT NULL,
  `idValoresIndicadoresConfigFecha` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idDesgloce`,`idValoresIndicadoresConfigFecha`),
  KEY `desglocesSeleccionados_ibfk_2` (`idValoresIndicadoresConfigFecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agrupamientoRefGeografica`
--
ALTER TABLE `agrupamientoRefGeografica`
  ADD CONSTRAINT `refGeografica_ibfk_1` FOREIGN KEY (`id1`) REFERENCES `refGeografica` (`id`),
  ADD CONSTRAINT `refGeografica_ibfk_2` FOREIGN KEY (`id2`) REFERENCES `refGeografica` (`id`);

--
-- Filtros para la tabla `desglocesIndicadores`
--
ALTER TABLE `desglocesIndicadores`
  ADD CONSTRAINT `desglocesIndicadores_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `desglocesIndicadores_ibfk_2` FOREIGN KEY (`idDesgloce`) REFERENCES `desgloces` (`id`);

--
-- Filtros para la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`fkIdDesgloce`) REFERENCES `desgloces` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`fkIdMeta`) REFERENCES `metas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `indicadores_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`fkIdObjetivo`) REFERENCES `objetivos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `metas_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuariosRefGeografica`
--
ALTER TABLE `usuariosRefGeografica`
  ADD CONSTRAINT `usuariosRefGeografica_ibfk_2` FOREIGN KEY (`id_refGeografica`) REFERENCES `refGeografica` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuariosRefGeografica_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `valoresIndicadores`
--
ALTER TABLE `valoresIndicadores`
  ADD CONSTRAINT `valoresIndicadores_ibfk_2` FOREIGN KEY (`idRefGeografica`) REFERENCES `refGeografica` (`id`),
  ADD CONSTRAINT `valoresIndicadores_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `valoresIndicadores_ibfk_4` FOREIGN KEY (`idValoresIndicadoresConfigFecha`) REFERENCES `valoresIndicadoresConfigFecha` (`id`);

--
-- Filtros para la tabla `valoresIndicadoresConfigFecha`
--
ALTER TABLE `valoresIndicadoresConfigFecha`
  ADD CONSTRAINT `valoresIndicadoresConfigFecha_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`);

--
-- Filtros para la tabla `valoresIndicadoresConfigFechaDesgloces`
--
ALTER TABLE `valoresIndicadoresConfigFechaDesgloces`
  ADD CONSTRAINT `valoresIndicadoresConfigFechaDesgloces_ibfk_1` FOREIGN KEY (`idDesgloce`) REFERENCES `desgloces` (`id`),
  ADD CONSTRAINT `valoresIndicadoresConfigFechaDesgloces_ibfk_2` FOREIGN KEY (`idValoresIndicadoresConfigFecha`) REFERENCES `valoresIndicadoresConfigFecha` (`id`);


SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; 

SET SQL_MODE = "";


--
-- `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'admin','admin','juan@juan.com','juan@juan.com','Juan','Perez','Domi 1','Loca 1','Provi 1','Tele 1','Depe 1','N','Obs 1',1,'dtk59ah2hlsgw0kwgco8ksgowswkk0k','$2y$13$dtk59ah2hlsgw0kwgco8ken383BFhPxXsnpHXDOuMl4wUeCuTJe5m','2017-02-07 14:04:41',0,0,NULL,'GVbZJdNJI5_SsDR2F6bP--kYZT_yyO82deevYkCqRdk','2017-02-14 13:35:28','a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(3,'rcodas','rcodas','rcodas@politicassociales.gob.ar','rcodas@politicassociales.gob.ar','Codas','Renata','Julio Roca 782','CABA','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'sslrfftpw68g804co4cwwkkck004oo0','$2y$13$sslrfftpw68g804co4cwweOx5zwTFMmjfqLfOQXmaCCYv7Lvtsm4e','2017-07-25 13:59:59',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(4,'sconde','sconde','solgconde@gmail.com','solgconde@gmail.com','García Conde','Soledad','Julio Roca 782','CABA','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'8qxllzsiafwgkos0wgkok0swcws4cks','$2y$13$8qxllzsiafwgkos0wgkokuxSYS8V3rYfSJq.wxD7gf8IjZ929xu4S','2016-12-29 21:30:36',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(5,'mferro','mferro','mferro@politicassociales.gob.ar','mferro@politicassociales.gob.ar','Ferro','María Lujan','Julio Roca 782','CABA','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'eoxvoh7w7o08ko8c08gkkokwsc4kog4','$2y$13$eoxvoh7w7o08ko8c08gkkeNn4ntwnGUl5xLcT7Gh7dwLaNN7xLaJq','2017-02-23 11:38:34',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(6,'ntodesca','ntodesca','ntodesca@politicassociales.gob.ar','ntodesca@politicassociales.gob.ar','Todesca','Nicolas Alejandro','Julio Roca 782','CABA','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'clnafn7f2n4gs4408ogsgokggc8kgc8','$2y$13$clnafn7f2n4gs4408ogsge9vFz4CHm6s8Oq1IWiRlHmGiVgYsRLOu','2016-12-24 01:31:16',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(7,'jbalasini','jbalasini','jbalasini@politicassociales.gob.ar','jbalasini@politicassociales.gob.ar','Balasini','Juan Ignacio','Julio Roca 782','Capital Federal','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'nwtcxuqu734k4ss00o8o0ggoswswkks','$2y$13$nwtcxuqu734k4ss00o8o0emn7XRQ8gFWJE7Gf9EhUIkT3Jpnmd.2i','2017-02-23 16:29:49',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(8,'lmiguel','lmiguel','lmiguel@politicassociales.gob.ar','lmiguel@politicassociales.gob.ar','Miguel','Luciana','Julio Roca 782','Capital Federal','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'hffk4rzywdkoow4440g4wcw0owgk844','$2y$13$hffk4rzywdkoow4440g4wO4MKEVQUD8aZAqX1RrkrLS3eMekwckgq','2016-10-06 21:44:01',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(9,'ldipietro','ldipietro','ldipietro@politicassociales.gob.ar','ldipietro@politicassociales.gob.ar','Di Pietro','Luis','Julio Roca 782','Capital Federal','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'j1m42s9c3a8gck8s00wk4cc8kccgc8g','$2y$13$j1m42s9c3a8gck8s00wk4O7kOCkFC/Gh2hOz2LX1uDtqpeI2WHTlS','2017-02-23 14:54:48',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(10,'frubinstein','frubinstein','frubinstein@politicassociales.gob.ar','frubinstein@politicassociales.gob.ar','Rubinstein','Fabiana','Julio Roca 782','Capital Federal','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'bw6e6augcsg0occsggc4kcs0g00ck4o','$2y$13$bw6e6augcsg0occsggc4kOIPHstFE./X9wS8E4Dlw1RtlCi7BIqxi','2017-03-31 11:38:46',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL),(11,'mbrisson','mbrisson','mbrisson@politicassociales.gob.ar','mbrisson@politicassociales.gob.ar','Brisson','Maria Eugenia','Julio Roca 782','Capital Federal','Buenos Aires','4342-0939','CNCPS','N',NULL,1,'8v9unld032g4oosw4ock80kkksccwgw','$2y$13$8v9unld032g4oosw4ock8upbcrF66S1UHEFqrNKdEVlaeCJZOJHlW','2017-03-30 15:37:22',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(12,'abednar','abednar','abednar@politicassociales.gob.ar','abednar@politicassociales.gob.ar','Bednar','Ariel','Julio Roca 782','Capital Federal','Buenos Aires','1565370874','CNCPS','N',NULL,1,'deffbps6cuo88so0wgw4o4kg00sgcgo','$2y$13$deffbps6cuo88so0wgw4ou.Rh5Gr.Jq2BGneSFLdF0Fp3RUOPJRli','2017-03-17 14:59:30',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL),(13,'gpandiella','gpandiella','gpandiella@politicassociales.gob.ar','gpandiella@politicassociales.gob.ar','Pandiella','Gustavo','Julio Argentino Roca 782','CABA','Buenos Aires','43420939','CNCPS','N',NULL,1,'8itfbzpenyg40k4084cwss0o84ksws4','$2y$13$8itfbzpenyg40k4084cwser1jWTI7y9SylsZlEc67ex/RVEDoAbLq','2017-04-07 14:58:47',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `metas`
--

LOCK TABLES `metas` WRITE;
/*!40000 ALTER TABLE `metas` DISABLE KEYS */;
INSERT INTO `metas` VALUES (2,'00001','Para 2030, erradicar la pobreza extrema para todas las personas en el mundo, actualmente medida por un ingreso por persona inferior a 1.25 dólares de los Estados Unidos al día','N',1,1,'2017-03-23 14:39:32'),(3,'00002','Para 2030, reducir al menos a la mitad la proporción de hombres, mujeres y niños de todas las edades que viven en la pobreza en todas sus dimensiones con arreglo a las definiciones nacionales','N',1,1,'0000-00-00 00:00:00'),(4,'00003','Poner en práctica a nivel nacional sistemas y medidas apropiadas de protección social para todos, incluidos niveles mínimos, y, para 20 30, lograr una amplia cobertura de los pobres y los vulnerables','N',1,1,'0000-00-00 00:00:00'),(5,'00004','Para 2030, garantizar que todos los hombres y mujeres, en particular los pobres y los vulnerables, tengan los mismos derechos a los recursos económicos, así como acceso a los servicios básicos, la propiedad y el control de las tierras y otros bienes, la herencia, los recursos naturales, las nuevas tecnologías apropiadas y los servicios financieros, incluida la microfinanciación','N',1,1,'0000-00-00 00:00:00'),(6,'00005','Para 2030, fomentar la resiliencia de los pobres y las personas que se encuentran en situaciones vulnerables y reducir su exposición y vulnerabilidad a los fenómenos extremos relacionados con el clima y otras crisis y desastres económicos, sociales y ambientales','N',1,1,'0000-00-00 00:00:00'),(7,'00006','Garantizar una movilización importante de recursos procedentes de diversas fuentes, incluso mediante la mejora de la cooperación para el desarrollo, a fin de proporcionar medios suficientes y previsibles a los países en desarrollo, en particular los países menos adelantados, para poner en práctica prog ramas y políticas encaminados a poner fin a la pobreza en todas sus dimensiones','N',1,1,'0000-00-00 00:00:00'),(8,'00007','Crear marcos normativos sólidos en los planos nacional, regional e internacional, sobre la base de estrategias de desarrollo en favor de los pobres que tengan en cuenta las cuestiones de género, a fin de apoyar la inversión acelerada en medidas para erradicar la pobreza','N',1,1,'0000-00-00 00:00:00'),(9,'00001','Para 2030, poner fin al hambre y asegurar el acceso de todas las personas, en particular los pobres y las personas en situaciones vulnerables, incluidos los lactantes, a una alimentación sana, nutritiva y suficiente durante todo el año','N',2,1,'0000-00-00 00:00:00'),(10,'00002','Para 2030, poner fin a todas las formas de malnutrición, incluso logrando, a más tardar en 2025, las metas convenidas internacionalmente sobre el retraso del crecimiento y la emaciación de los niños menores de 5 años, y abordar las necesidades de nutrición de las adolescentes, las mujeres e mbarazadas y lactantes y las personas de edad','N',2,1,'0000-00-00 00:00:00'),(11,'00003','Para 2030, duplicar la productividad agrícola y los ingresos de los productores de alimentos en pequeña escala, en particular las mujeres, los pueblos indígenas, los agricultores familiares, los pastores y los pescadores, entre otras cosas mediante un acceso seguro y equitativo a las tierras, a otros recursos de producción e insumos, conocimientos, servicios financieros, mercados y oportunidades para la generación de valor añadido y empleos no agrícolas','N',2,1,'0000-00-00 00:00:00'),(12,'00004','Para 2030, asegurar la sostenibilidad de los sistemas de producción de alimentos y aplicar prácticas agrícolas resilientes que aumenten la productividad y la producción, contribuyan al mantenimiento de los ecosistemas, fortalezcan la capacidad de adaptación al cambio climático, los fenómenos meteorológicos extremos, las sequías, las inundaciones y otros desastres, y mejoren progresivamente la calidad del suelo y la tierra','N',2,1,'0000-00-00 00:00:00'),(13,'00005','Para 2020, mantener la diversidad genética de las semillas, las plantas cultivadas y los animales de granja y domesticados y sus especies silvestres conexas, entre otras cosas mediante una buena gestión y diversificación de los bancos de semillas y plantas a nivel nacional, regional e internacional, y promover el acceso a los beneficios que se deriven de la utilización de los recursos genéticos y los conocimientos tradicionales y su distribución justa y equitativa, como se ha convenido internacionalmente','N',2,1,'0000-00-00 00:00:00'),(14,'00006','Aumentar las inversiones, incluso mediante una mayor cooperación internacional, en la infraestructura rural, la investigación agrícola y los servicios de extensión, el desarrollo tecnológico y los bancos de genes de plantas y ganado a fin de mejorar la capacidad de producción agrícola en los países en desarrollo, en particular en los países menos adelantados','N',2,1,'0000-00-00 00:00:00'),(15,'00007','Corregir y prevenir las restricciones y distorsiones comerciales en los mercados agropecuarios mundiales, entre otras cosas mediante la eliminación paralela de todas las formas de subvenciones a las exportaciones agrícolas y todas las medidas de exportación con efectos equivalentes, de conformidad con el mandato de la Ronda de Doha para el Desarrollo','N',2,1,'0000-00-00 00:00:00'),(16,'00008','Adoptar medidas para asegurar el buen funcionamiento de los mercados de productos básicos alimentarios y sus derivados y facilitar el acceso oportuno a información sobre los mercados, en particular sobre las reservas de alimentos, a fin de ayudar a limitar la extrema volatilidad de los precios de los alimentos','N',2,1,'0000-00-00 00:00:00'),(17,'00001','Para 2030, reducir la tasa mundial de mortalidad materna a menos de 70 por cada 100.000 nacidos vivos','N',3,1,'0000-00-00 00:00:00'),(18,'00002','Para 2030, poner fin a las muertes evitables de recién nacidos y de niños menores de 5 años, logrando que todos los países intenten reducir la mortalidad neonatal al menos hasta 12 por cada 1.000 nacidos vivos, y la mortalidad de niños menores de 5 años al menos hasta 25 por cada 1.000 nacidos vivos','N',3,1,'0000-00-00 00:00:00'),(19,'00003','Para 2030, poner fin a las epidemias del SIDA, la tuberculosis, la malaria y las enfermedades tropicales desatendidas y combatir la hepatitis, las enfermedades transmitidas por el agua y otras enfermedades transmisibles','N',3,1,'0000-00-00 00:00:00'),(20,'00004','Para 2030, reducir en un tercio la mortalidad prematura por enfermedades no transmisibles mediante la prevención y el tratamiento y promover la salud mental y el bienestar','N',3,1,'0000-00-00 00:00:00'),(21,'00005','Fortalecer la prevención y el tratamiento del abuso de sustancias adictivas, incluido el uso indebido de estupefacientes y el consumo nocivo de alcohol','N',3,1,'0000-00-00 00:00:00'),(22,'00006','Para 2020, reducir a la mitad el número de muertes y lesiones causadas por accidentes de tráfico en el mundo','N',3,1,'0000-00-00 00:00:00'),(23,'00007','Para 2030, garantizar el acceso universal a los servicios de salud sexual y reproductiva, incluidos los de planificación de la familia, información y educación, y la integración de la salud reproductiva en las estrategias y los programas nacionales','N',3,1,'0000-00-00 00:00:00'),(24,'00008','Lograr la cobertura sanitaria universal, en particular la protección contra los riesgos financieros, el acceso a servicios de salud esenciales de calidad y el acceso a medicamentos y vacunas seguros, eficaces, asequibles y de calidad para todos','N',3,1,'0000-00-00 00:00:00'),(25,'00009','Para 2030, reducir sustancialmente el número de muertes y enfermedades producidas por productos químicos peligrosos y la contaminación del aire, el agua y el suelo','N',3,1,'0000-00-00 00:00:00'),(26,'000010','Fortalecer la aplicación del Convenio Marco de la Organización Mundial de la Salud para el Control del Tabaco en todos los países, según proceda','N',3,1,'0000-00-00 00:00:00'),(27,'000011','Apoyar las actividades de investigación y desarrollo de vacunas y medicamentos para las enfermedades transmisibles y no transmisibles que afectan primordialmente a los países en desarrollo y facilitar el acceso a medicamentos y vacunas esenciales asequibles de conformidad con la Declaración de Doha relativa al Acuerdo sobre los ADPIC y la Salud Pública, en la que se afirma el derecho de los países en desarrollo a utilizar al máximo las disposiciones del Acuerdo sobre los Aspectos de los Derechos de Propiedad Intelectual Relacionados con el Comercio en lo relativo a la flexibilidad para proteger la salud públi ca y, en particular, proporcionar acceso a los medicamentos para todos','N',3,1,'0000-00-00 00:00:00'),(28,'000012','Aumentar sustancialmente la financiación de la salud y la contratación, el desarrollo, la capacitación y la retención del personal sanitario en los países en desarrollo, especialmente en los países menos adelantados y los pequeños Estados insulares en desarrollo','N',3,1,'0000-00-00 00:00:00'),(29,'000013','Reforzar la capacidad de todos los países, en particular los países en desarrollo, en materia de alerta temprana, reducción de riesgos y gestión de los riesgos para la salud nacional y mundial','N',3,1,'0000-00-00 00:00:00'),(30,'00001','Para 2030, velar por que todas las niñas y todos los niños terminen los ciclos de la enseñanza primaria y secundaria, que ha de ser gratuita, equitativa y de calidad y producir resultados escolares pertinentes y eficaces','N',4,1,'0000-00-00 00:00:00'),(31,'00002','Para 2030, velar por que todas las niñas y todos los niños tengan acceso a servicios de atención y desarrollo en la primera infancia y a una enseñanza preescolar de calidad, a fin de que estén preparados para la enseñanza primaria','N',4,1,'0000-00-00 00:00:00'),(32,'00003','Para 2030, asegurar el acceso en condiciones de igualdad para todos los hombres y las mujeres a una formación técnica, profesional y superior de calidad, incluida la enseñanza universitaria','N',4,1,'0000-00-00 00:00:00'),(33,'00004','Para 2030, aumentar sustancialmente el número de jóvenes y adultos que tienen las competencias necesarias, en particular técnicas y profesionales, para acceder al empleo, el trabajo decente y el emprendimiento','N',4,1,'0000-00-00 00:00:00'),(34,'00005','Para 2030, eliminar las disparidades de género en la educación y garantizar el acceso en condiciones de igualdad de las personas vulnerables, incluidas las personas con discapacidad, los pueblos indígenas y los niños en situaciones de vulnerabilidad, a todos los niveles de la enseñanza y la formación profesional','N',4,1,'0000-00-00 00:00:00'),(35,'00006','Para 2030, garantizar que todos los jóvenes y al menos una proporción sustancial de los adultos, tanto hombres como mujeres, tengan competencias de lectura, escritura y aritmética','N',4,1,'0000-00-00 00:00:00'),(36,'00007','Para 2030, garantizar que todos los alumnos adquieran los conocimientos teóricos y prácticos necesarios para promover el desarrollo sostenible, entre otras cosas mediante la educación para el desarrollo sostenible y la adopción de estilos de vida sostenibles, los derechos humanos, la igualdad entre los géneros, la promoción de una cultura de paz y no violencia, la ciudadanía mundial y la valoración de la diversidad cultural y de la contribución de la cultura al desarrollo sostenible, entre otros medios','N',4,1,'0000-00-00 00:00:00'),(37,'00008','Construir y adecuar instalaciones escolares que respondan a las necesidades de los niños y las personas discapacitadas y tengan en cuenta las cuestiones de género, y que ofrezcan entornos de aprendizaje seguros, no violentos, inclusivos y eficaces para todos','N',4,1,'0000-00-00 00:00:00'),(38,'00009','Para 2020, aumentar sustancialmente a nivel mundial el número de becas disponibles para los países en desarrollo, en particular los países menos adelantados, los pequeños Estados insulares en desarrollo y los países de África, para que sus estudiantes puedan matricularse en programas de estudios superiores, incluidos programas de formación profesional y programas técnicos, científicos, de ingeniería y de tecnología de la información y las comunicaciones, en países desarrollados y otros países en desarrollo','N',4,1,'0000-00-00 00:00:00'),(39,'000010','Para 2030, aumentar sustancialmente la oferta de maestros calificados, entre otras cosas mediante la cooperación internacional para la formación de docentes en los países en desarrollo, especialmente los países menos adelantados y los pequeños Estados insulares en desarrollo','N',4,1,'0000-00-00 00:00:00'),(40,'00001','Poner fin a todas las formas de discriminación contra todas las mujeres y las niñas en todo el mundo','N',5,1,'0000-00-00 00:00:00'),(41,'00002','Eliminar todas las formas de violencia contra todas las mujeres y las niñas en los ámbitos público y privado, incluidas la trata y la explotación sexual y otros tipos de explotación','N',5,1,'0000-00-00 00:00:00'),(42,'00003','Eliminar todas las prácticas nocivas, como el matrimonio infantil, precoz y forzado y la mutilación genital femenina','N',5,1,'0000-00-00 00:00:00'),(43,'00004','Reconocer y valorar los cuidados no remunerados y el trabajo doméstico no remunerado mediante la prestación de servicios públicos, la provisión de infraestructuras y la formulación de políticas de protección social, así como mediante la promoción de la responsabilidad compartida en el hogar y la familia, según proceda en cada país','N',5,1,'0000-00-00 00:00:00'),(44,'00005','Velar por la participación plena y efectiva de las mujeres y la igualdad de oportunidades de liderazgo a todos los niveles de la adopción de decisiones en la vida política, económica y pública','N',5,1,'0000-00-00 00:00:00'),(45,'00006','Garantizar el acceso universal a la salud sexual y reproductiva y los derechos reproductivos, de conformidad con el Programa de Acción de la Conferencia Internacional sobre la Población y el Desarrollo, la Plataforma de Acción de Beijing y los documentos finales de sus conferencias de examen','N',5,1,'0000-00-00 00:00:00'),(46,'00007','Emprender reformas que otorguen a las mujeres el derecho a los recursos económicos en condiciones de igualdad , así como el acceso a la propiedad y al control de las tierras y otros bienes, los servicios financieros, la herencia y los recursos naturales, de conformidad con las leyes nacionales','N',5,1,'0000-00-00 00:00:00'),(47,'00008','Mejorar el uso de la tecnología instrumental, en particular la tecnología de la información y las comunicaciones, para promover el empoderamiento de la mujer','N',5,1,'0000-00-00 00:00:00'),(48,'00009','Aprobar y fortalecer políticas acertadas y leyes aplicables para promover la igualdad entre los géneros y el empoderamiento de las mujeres y las niñas a todos los niveles','N',5,1,'0000-00-00 00:00:00'),(49,'00001','Para 2030, lograr el acceso universal y equitativo al agua potable, a un precio asequible para todos','N',6,1,'0000-00-00 00:00:00'),(50,'00002','Para 2030, lograr el acceso equitativo a servicios de saneamiento e higiene adecuados para todos y poner fin a la defecación al aire libre, prestando especial atención a las necesidades de las mujeres y las niñas y las personas en situaciones vulnerables','N',6,1,'0000-00-00 00:00:00'),(51,'00003','Para 2030, mejorar la calidad del agua mediante la reducción de la contaminación, la eliminación del vertimiento y la reducción al mínimo de la descarga de materiales y productos químicos peligrosos, la reducción a la mitad del porcentaje de aguas residuales sin tratar y un aumento sustancial del reciclado y la reutilización en condiciones de seguridad a nivel mundial','N',6,1,'0000-00-00 00:00:00'),(52,'00004','Para 2030, aumentar sustancialmente la utilización eficiente de los recursos hídricos en todos los sectores y asegurar la sostenibilidad de la extracción y el abastecimiento de agua dulce para hacer frente a la escasez de agua y reducir sustancialmente el número de personas que sufren de escasez de agua','N',6,1,'0000-00-00 00:00:00'),(53,'00005','Para 2030, poner en práctica la gestión integrada de los recursos hídricos a todos los niveles, incluso mediante la cooperación transfronteriza, según proceda 6.6 Para 2020, proteger y restablecer los ecosistemas relacionados con el agua, incluidos los bosques, las montañas, los humedales, los ríos, los acuíferos y los lagos','N',6,1,'0000-00-00 00:00:00'),(54,'00006','Para 2030, ampliar la cooperación internacional y el apoyo prestado a los países en desarrollo para la creación de capacidad en actividades y programas relativos al agua y el saneamiento, incluidos el acopio y almacenamiento de agua, la desalinización, el aprovechamiento eficiente de los recursos hídricos, el tratamiento de aguas residuales y las tecnologías de reciclaje y reutilización','N',6,1,'0000-00-00 00:00:00'),(55,'00007','Apoyar y fortalecer la participación de las comunidades locales en la mejora de la gestión del agua y el saneamiento','N',6,1,'0000-00-00 00:00:00'),(56,'00001','Para 2030, garantizar el acceso universal a servicios de energía asequibles, confiables y modernos','N',7,1,'0000-00-00 00:00:00'),(57,'00002','Para 2030, aumentar sustancialmente el porcentaje de la energía renovable en el conjunto de fuentes de energía','N',7,1,'0000-00-00 00:00:00'),(58,'00003','Para 2030, duplicar la tasa mundial de mejora de la eficiencia energética','N',7,1,'0000-00-00 00:00:00'),(59,'00004','Para 2030, aumentar la cooperación internacional a fin de facilitar el acceso a la investigación y las tecnologías energéticas no contaminantes, incluidas las fuentes de energía renovables, la eficiencia energética y las tecnologías avanzadas y menos contaminantes de combustibles fósiles, y promover la inversión en infraestructuras energéticas y tecnologías de energía no contaminante','N',7,1,'0000-00-00 00:00:00'),(60,'00005','Para 2030, ampliar la infraestructura y mejorar la tecnología para prestar servicios de energía modernos y sostenibles para todos en los países en desarrollo, en particular los países menos adelantados, los pequeños Estados insulares en desarrollo y los países en desarrollo sin litoral, en consonancia con sus respectivos programas de apoyo','N',7,1,'0000-00-00 00:00:00'),(61,'00001','Mantener el crecimiento económico per capita de conformidad con las circunstancias nacionales y, en particular, un crecimiento del producto interno bruto de al menos un 7% anual en los países menos adelantados','N',8,1,'0000-00-00 00:00:00'),(62,'00002','Lograr niveles más elevados de productividad económica mediante la diversificación, la modernización tecnológica y la innovación, entre otras cosas centrando la atención en sectores de mayor valor añadido y uso intensivo de mano de obra','N',8,1,'0000-00-00 00:00:00'),(63,'00003','Promover políticas orientadas al desarrollo que apoyen las actividades productivas, la creación de empleo decente, el emprendimiento, la creatividad y la innovación, y alentar la oficialización y el crecimiento de las microempresas y las pequeñas y medianas empresas, entre otras cosas mediante el acceso a servicios financieros','N',8,1,'0000-00-00 00:00:00'),(64,'00004','Mejorar progresivamente, para 2030, la producción y el consumo eficientes de los recursos mundiales y procurar desvincular el crecimiento económico de la degradación del medio ambiente, de conformidad con el marco decenal de programas sobre modalidades sostenibles de consumo y producción, empezando por los países desarrollados','N',8,1,'0000-00-00 00:00:00'),(65,'00005','Para 2030, lograr el empleo pleno y productivo y garantizar un trabajo decente para todos los hombres y mujeres, incluidos los jóvenes y las personas con discapacidad, y la igualdad de remuneración por trabajo de igual valor','N',8,1,'0000-00-00 00:00:00'),(66,'00006','Para 2020, reducir sustancialmente la proporción de jóvenes que no están empleados y no cursan estudios ni reciben capacitación','N',8,1,'0000-00-00 00:00:00'),(67,'00007','Adoptar medidas inmediatas y eficaces para erradicar el trabajo forzoso, poner fin a las formas modernas de esclavitud y la trata de seres humanos y asegurar la prohibición y eliminación de las peores formas de trabajo infantil, incluidos el reclutamiento y la utilización de niños soldados, y, a más tardar en 2025, poner fin al trabajo infantil en todas sus formas,','N',8,1,'0000-00-00 00:00:00'),(68,'00008','Proteger los derechos laborales y promover un entorno de trabajo seguro y protegido para todos los trabajadores, incluidos los trabajadores migrantes, en particular las mujeres migrantes y las personas con empleos precarios','N',8,1,'0000-00-00 00:00:00'),(69,'00009','Para 2030, elaborar y poner en práctica políticas encaminadas a promover un turismo sostenible que cree puestos de trabajo y promueva la cultura y los productos locales','N',8,1,'0000-00-00 00:00:00'),(70,'000010','Fortalecer la capacidad de las instituciones financieras nacionales para alentar y ampliar el acceso a los servicios bancarios, financieros y de seguros para todos','N',8,1,'0000-00-00 00:00:00'),(71,'000011','Aumentar el apoyo a la iniciativa de ayuda para el comercio en los países en desarrollo, en particular los países menos adelantados, incluso en el contexto del Marco Integrado Mejorado de Asistencia Técnica Relacionada con el Comercio para los Países Menos Adelantados','N',8,1,'0000-00-00 00:00:00'),(72,'000012','Para 2020, desarrollar y poner en marcha una estrategia mundial para el empleo de los jóvenes y aplicar el Pacto Mundial para el Empleo de la Organización Internacional del Trabajo','N',8,1,'0000-00-00 00:00:00'),(73,'00001','Desarrollar infraestructuras fiables, sostenibles, resilientes y de calidad, incluidas infraestructuras regionales y transfronterizas, para apoyar el desarrollo económico y el bienestar humano, con especial hincapié en el acceso equitativo y asequible para todos','N',9,1,'0000-00-00 00:00:00'),(74,'00002','Promover una industrialización inclusiva y sostenible y, a más tardar en 2030, aumentar de manera significativa la contribución de la industria al empleo y al producto interno bruto, de acuerdo con las circunstancias nacionales, y duplicar esa contribución en los países menos adelantados','N',9,1,'0000-00-00 00:00:00'),(75,'00003','Aumentar el acceso de las pequeñas empresas industriales y otras empresas, en particular en los países en desarrollo, a los servicios financieros, incluido el acceso a créditos asequibles, y su integración en las cadenas de valor y los mercados','N',9,1,'0000-00-00 00:00:00'),(76,'00004','Para 2030, mejorar la infraestructura y reajustar las industrias para que sean sostenibles, usando los recursos con mayor eficacia y promoviendo la adopción de tecnologías y procesos industriales limpios y ambientalmente racionales, y logrando que todos los países adopten medidas de acuerdo con sus capac idades respectivas','N',9,1,'0000-00-00 00:00:00'),(77,'00005','Aumentar la investigación científica y mejorar la capacidad tecnológica de los sectores industriales de todos los países, en particular los países en desarrollo, entre otras cosas fomentando la innovación y aumentando sustancialmente el número de personas que trabajan en el campo de la investigación y el desarrollo por cada millón de personas, así como aumentando los gastos en investigación y desarrollo de los sectores público y privado para 2013','N',9,1,'0000-00-00 00:00:00'),(78,'00006','Facilitar el desarrollo de infraestructuras sostenibles y resilientes en los países en desarrollo con un mayor apoyo financiero, tecnológico y técnico a los países de África, los países menos adelantados, los países en desarrollo sin litoral y los pequeños Estados insulares en desarrollo','N',9,1,'0000-00-00 00:00:00'),(79,'00007','Apoyar el desarrollo de tecnologías nacionales, la investigación y la innovación en los países en desarrollo, en particular garantizando un entorno normativo propicio a la diversificación industrial y la adición de valor a los productos básicos, entre otras cosas','N',9,1,'0000-00-00 00:00:00'),(80,'00008','Aumentar de forma significativa el acceso a la tecnología de la información y las comunicaciones y esforzarse por facilitar el acceso universal y asequible a Internet en los países menos adelantados a más tardar en 2020','N',9,1,'0000-00-00 00:00:00'),(81,'00001','Para 2030, lograr progresivamente y mantener el crecimiento de los ingresos del 40% más pobre de la población a una tasa superior a la media nacional','N',10,1,'0000-00-00 00:00:00'),(82,'00002','Para 2030, potenciar y promover la inclusión social, económica y política de todas las personas, independientemente de su edad, sexo, discapacidad, raza, etnia, origen, religión o situación económica u otra condición','N',10,1,'0000-00-00 00:00:00'),(83,'00003','Garantizar la igualdad de oportunidades y reducir la desigualdad de los resultados, en particular mediante la eliminación de las leyes, políticas y prácticas discriminatorias y la promoción de leyes, políticas y medidas adecuadas a ese respecto','N',10,1,'0000-00-00 00:00:00'),(84,'00004','Adoptar políticas, en especial fiscales, salariales y de protección social, y lograr progresivamente una mayor igualdad','N',10,1,'0000-00-00 00:00:00'),(85,'00005','Mejorar la reglamentación y vigilancia de las instituciones y los mercados financieros mundiales y fortalecer la aplicación de esa reglamentación','N',10,1,'0000-00-00 00:00:00'),(86,'00006','Velar por una mayor representación y voz de los países en desarrollo en la adopción de decisiones en las instituciones económicas y financieras internacionales para que estas sean más eficaces, fiables, responsables y legítimas','N',10,1,'0000-00-00 00:00:00'),(87,'00007','Facilitar la migración y la movilidad ordenadas, seguras, regulares y responsables de las personas, entre otras cosas mediante la aplicación de políticas migratorias planificadas y bien gestionadas','N',10,1,'0000-00-00 00:00:00'),(88,'00008','Aplicar el principio del trato especial y diferenciado para los países en desarrollo, en particular los países menos adelantados, de confor midad con los acuerdos de la Organización Mundial del Comercio','N',10,1,'0000-00-00 00:00:00'),(89,'00009','Alentar la asistencia oficial para el desarrollo y las corrientes financieras, incluida la inversión extranjera directa, para los Estados con mayores necesidades, en particular los países menos adelantados, los países de África, los pequeños Estados insulares en desarrollo y los países en desarrollo sin litoral, en consonancia con sus planes y programas nacionales','N',10,1,'0000-00-00 00:00:00'),(90,'000010','Para 2030, reducir a menos del 3% los costos de transacción de las remesas de los migrantes y eliminar los canales de envío de remesas con un costo superior al 5%','N',10,1,'0000-00-00 00:00:00'),(91,'00001','Para 2030, asegurar el acceso de todas las personas a viviendas y servicios básicos adecuados, seguros y asequibles y mejorar los barrios marginales','N',11,1,'0000-00-00 00:00:00'),(92,'00002','Para 2030, proporcionar acceso a sistemas de transporte seguros, as equibles, accesibles y sostenibles para todos y mejorar la seguridad vial, en particular mediante la ampliación del transporte público, prestando especial atención a las necesidades de las personas en situación vulnerable, las mujeres, los niños, las personas con discapacidad y las personas de edad','N',11,1,'0000-00-00 00:00:00'),(93,'00003','Para 2030, aumentar la urbanización inclusiva y sostenible y la capacidad para una planificación y gestión participativas, integradas y sostenibles de los asentamientos humanos en todos los países','N',11,1,'0000-00-00 00:00:00'),(94,'00004','Redoblar los esfuerzos para proteger y salvaguardar el patrimonio cultural y natural del mundo','N',11,1,'0000-00-00 00:00:00'),(95,'00005','Para 2030, reducir de forma significativa el número de muertes y de personas afectadas por los desastres, incluidos los relacionados con el agua, y reducir sustancialmente las pérdidas económicas directas vinculadas al producto interno bruto mundial causadas por los desastres, haciendo especial hincapié en la protección de los pobres y las personas en situaciones vulnerables','N',11,1,'0000-00-00 00:00:00'),(96,'00006','Para 2030, reducir el impacto ambiental negativo per capita de las ciudades, incluso prestando especial atención a la calidad del aire y la gestión de los desechos municipales y de otro tipo','N',11,1,'0000-00-00 00:00:00'),(97,'00007','Para 2030, proporcionar acceso universal a zonas verdes y espacios públicos seguros, inclusivos y accesibles, en particular para las mujeres y los niños, las personas de edad y las personas con discapacidad','N',11,1,'0000-00-00 00:00:00'),(98,'00008','Apoyar los vínculos económicos, sociales y ambientales positivos entre las zonas urbanas, periurbanas y rurales mediante el fortalecimiento de la planificación del desarrollo nacional y regional','N',11,1,'0000-00-00 00:00:00'),(99,'00009','Para 2020, aumentar sustancialmente el número de ciudades y asentamientos humanos que adoptan y ponen en marcha políticas y planes integrados para promover la inclusión, el uso eficiente de los recursos, la mitigación del cambio climático y la adaptación a él y la resiliencia ante los desastres, y desarrollar y poner en práctica, en consonancia con el Marco de Sendai para la Reducción del Riesgo de Desastres 2015-2030, la gestión integral de los riesgos de desastre a todos los niveles','N',11,1,'0000-00-00 00:00:00'),(100,'000010','Proporcionar apoyo a los países menos adelantados, incluso mediante la asistencia financiera y técnica, para que puedan construir edificios sostenibles y resilientes utilizando materiales locales','N',11,1,'0000-00-00 00:00:00'),(101,'00001','Aplicar el Marco Decenal de Programas sobre Modalidades de Consumo y Producción Sostenibles, con la participación de todos los países y bajo el liderazgo de los países desarrollados, teniendo en cuenta el grado de desarrollo y las capacidades de los países en desarrollo','N',12,1,'0000-00-00 00:00:00'),(102,'00002','Para 2030, lograr la gestión sostenible y el uso eficiente de los recursos naturales','N',12,1,'0000-00-00 00:00:00'),(103,'00003','Para 2030, reducir a la mitad el desperdicio mundial de alimentos per capita en la venta al por menor y a nivel de los consumidores y reducir las pérdidas de alimentos en las cadenas de producción y distribución, incluidas las pérdidas posteriores a las cosechas','N',12,1,'0000-00-00 00:00:00'),(104,'00004','Para 2020, lograr la gestión ecológicamente racional de los productos químicos y de todos los desechos a lo largo de su ciclo de vida, de conformidad con los marcos internacionales convenidos, y reducir de manera significativa su liberación a la atmósfera, el agua y el suelo a fin de reducir al mínimo sus efect os adversos en la salud humana y el medio ambiente','N',12,1,'0000-00-00 00:00:00'),(105,'00005','Para 2030, disminuir de manera sustancial la generación de desechos mediante políticas de prevención, reducción, reciclaje y reutilización','N',12,1,'0000-00-00 00:00:00'),(106,'00006','Alentar a las empresas, en especial las grandes empresas y las empresas transnacionales, a que adopten prácticas sostenibles e incorporen información sobre la sostenibilidad en su ciclo de presentación de informes','N',12,1,'0000-00-00 00:00:00'),(107,'00007','Promover prácticas de contratación pública que sean sostenibles, de conformidad con las políticas y prioridades nacionales','N',12,1,'0000-00-00 00:00:00'),(108,'00008','Para 2030, velar por que las personas de todo el mundo tengan información y conocimientos pertinentes para el desarrollo sostenible y los estilos de vida en armonía con la naturaleza','N',12,1,'0000-00-00 00:00:00'),(109,'00009','Apoyar a los países en desarrollo en el fortalecimiento de su capacidad científica y tecnológica a fin de avanzar hacia modalidades de consumo y producción más sostenibles','N',12,1,'0000-00-00 00:00:00'),(110,'000010','Elaborar y aplicar instrumentos que permitan seguir de cerca los efectos en el desarrollo sostenible con miras a lograr un turismo sostenible que cree puestos de trabajo y promueva la cultura y los productos locales','N',12,1,'0000-00-00 00:00:00'),(111,'000011','Racionalizar los subsidios ineficientes a los combustibles fósiles que alientan el consumo antieconómico mediante la eliminación de las distorsio nes del mercado, de acuerdo con las circunstancias nacionales, incluso mediante la reestructuración de los sistemas tributarios y la eliminación gradual de los subsidios perjudiciales, cuando existan, para que se ponga de manifiesto su impacto ambiental, t eniendo plenamente en cuenta las necesidades y condiciones particulares de los países en desarrollo y reduciendo al mínimo los posibles efectos adversos en su desarrollo, de manera que se proteja a los pobres y las comunidades afectadas','N',12,1,'0000-00-00 00:00:00'),(112,'00001','Fortalecer la resiliencia y la capacidad de adaptación a los riesgos relacionados con el clima y los desastres naturales en todos los países','N',13,1,'0000-00-00 00:00:00'),(113,'00002','Incorporar medidas relativas al cambio climático en las políticas, estrategias y planes nacionales','N',13,1,'0000-00-00 00:00:00'),(114,'00003','Mejorar la educación, la sensibilización y la capacidad humana e institucional en relación con la mitigación del cambio climático, la adaptación a él, la reducción de sus efectos y la alerta temprana','N',13,1,'0000-00-00 00:00:00'),(115,'00004','Poner en práctica el compromiso contraído por los países desarrollados que son parte en la Convención Marco de las Naciones Unidas sobre el Cambio Climático con el objetivo de movilizar conjuntamente 100.000 millones de dólares anuales para el año 2020, procedentes de todas las fuentes, a fin de atender a las necesidades de los países en desarrollo, en el contexto de una labor significativa de mitigación y de una aplicación transparente, y poner en pleno funcionamiento el Fondo Verde para el Clima capitalizándolo lo antes posible','N',13,1,'0000-00-00 00:00:00'),(116,'00005','Promover mecanismos para aumentar la capacidad de planificación y gestión eficaces en relación con el cambio climático en los países menos adelantados y los pequeños Estados insulares en desarrollo, centrándose en particular en las mujeres, los jóvenes y las comunidades locales y marginadas','N',13,1,'0000-00-00 00:00:00'),(117,'00001','Para 2025, prevenir y reducir de manera significativa la contaminación marina de todo tipo, en particular la contaminación producida por actividades realizadas en tierra firme, incluidos los detritos marinos y la contaminación por nutrientes','N',14,1,'0000-00-00 00:00:00'),(118,'00002','Para 2020, gestionar y proteger de manera sostenible los ecosistemas marinos y costeros con miras a evitar efectos nocivos importantes, incluso mediante el fortalecimiento de su resiliencia, y adoptar medidas para restaurarlos con objeto de restablecer la salud y la productividad de los océanos','N',14,1,'0000-00-00 00:00:00'),(119,'00003','Reducir al mínimo los efectos de la acidificación de los océanos y hacerles frente, incluso mediante la intensificación de la cooperación científica a todos los niveles','N',14,1,'0000-00-00 00:00:00'),(120,'00004','Para 2020, reglamentar eficazmente la explotación pesquera y poner fin a la pesca excesiva, la pesca ilegal, la pesca no declarada y no reglamentada y las prácticas de pesca destructivas, y aplicar planes de gestión con fundamento científico a fin de restablecer las poblaciones de peces en el plazo más breve posible, por lo menos a niveles que puedan producir el máximo rendimiento sostenible de acuerdo con sus características biológicas','N',14,1,'0000-00-00 00:00:00'),(121,'00005','Para 2020, conservar por lo menos el 10% de las zonas costeras y marinas, de conformidad con las leyes nacionales y el derecho internacional y sobre la base de la mejor información científica disponible','N',14,1,'0000-00-00 00:00:00'),(122,'00006','Para 2020, prohibir ciertas formas de subvenciones a la pesca que contribuyen a la capacidad de pesca excesiva y la sobreexplotación pesquera, eliminar las subvenciones que contribuyen a la pesca ilegal, no declarada y no reglamentada y abstenerse de introducir nuevas subvenciones de esa índole, reconociendo que la negociación sobre las subvenciones a la pesca en el marco de la Organización Mundial del Comercio debe incluir un trato especial y diferenciado, apropiado y efectivo para los países en desarrollo y los países menos adelantados','N',14,1,'0000-00-00 00:00:00'),(123,'00007','Para 2030, aumentar los beneficios económicos que los pequeños Estados insulares en desarrollo y los países menos adelantados reciben del uso sostenible de los recursos marinos, en particular mediante la gestión sostenible de la pesca, la acuicultura y el turismo','N',14,1,'0000-00-00 00:00:00'),(124,'00008','Aumentar los conocimientos científicos, desarrollar la capacidad de investigación y transferir la tecnología marina, teniendo en cuenta los criterios y directrices para la transferencia de tecnología marina de la Comisión Oceanográfica Intergubernamental, a fin de mejorar la salud de los océanos y potenciar la contribución de la biodiversidad marina al desarrollo de los países en desarrollo, en particular los pequeños Estados insulares en desarrollo y los países menos adelantados','N',14,1,'0000-00-00 00:00:00'),(125,'00009','Facilitar el acceso de los pescadores artesanales en pequeña escala a los recursos marinos y los mercados','N',14,1,'0000-00-00 00:00:00'),(126,'000010','Mejorar la conservación y el uso sostenible de los océanos y sus recursos aplicando el derecho internacional reflejado en la Convención de las Naciones Unidas sobre el Derecho del Mar, que proporciona el marco jurídico para la conservación y la utilización sostenible de los océanos y sus recursos, como se recuerda en el párrafo 158 del documento “El futuro que queremos”','N',14,1,'0000-00-00 00:00:00'),(127,'00001','Para 2020, velar por la conservación, el restablecimiento y el uso sostenible de los ecosistemas terrestres y los ecosistemas interiores de agua dulce y los servicios que proporcionan, en particular los bosques, los humedales, las montañas y las zonas áridas, en consonancia con las obligaciones contraídas en virtud de acuerdos internacionales','N',15,1,'0000-00-00 00:00:00'),(128,'00002','Para 2020, promover la gestión sostenible de todos los tipos de bosques, poner fin a la deforestación, recuperar los bosques degradados e incrementar la forestación y la reforestación a nivel mundial','N',15,1,'0000-00-00 00:00:00'),(129,'00003','Para 2030, luchar contra la desertificación, rehabilitar las tierras y los suelos degradados, incluidas las tierras afectadas por la desertificación, la sequía y las inundaciones, y procurar lograr un mundo con una degradación neutra del suelo','N',15,1,'0000-00-00 00:00:00'),(130,'00004','Para 2030, velar por la conservación de los ecosistemas montañosos, incluida su diversidad biológica, a fin de mejorar su capacidad de proporciona r beneficios esenciales para el desarrollo sostenible','N',15,1,'0000-00-00 00:00:00'),(131,'00005','Adoptar medidas urgentes y significativas para reducir la degradación de los hábitats naturales, detener la pérdida de la diversidad biológica y, para 2020, proteger las especies amenazadas y evitar su extinción','N',15,1,'0000-00-00 00:00:00'),(132,'00006','Promover la participación justa y equitativa en los beneficios que se deriven de la utilización de los recursos genéticos y promover el acceso adecuado a esos recursos, como se ha convenido internacionalmente','N',15,1,'0000-00-00 00:00:00'),(133,'00007','Adoptar medidas urgentes para poner fin a la caza furtiva y el tráfico de especies protegidas de flora y fauna y abordar la demanda y la oferta ilegales de productos silvestres','N',15,1,'0000-00-00 00:00:00'),(134,'00008','Para 2020, adoptar medidas para prevenir la introducción de especies exóticas invasoras y reducir de forma significativa sus efectos en los ecosistemas terrestres y acuáticos y controlar o erradicar las especies prioritarias','N',15,1,'0000-00-00 00:00:00'),(135,'00009','Para 2020, integrar los valores de los ecosistemas y la diversidad biológica en la planificación nacional y local, los procesos de desarrollo, las estrategias de reducción de la pobreza y la contabilidad','N',15,1,'0000-00-00 00:00:00'),(136,'000010','Movilizar y aumentar de manera significativa los recursos financieros procedentes de todas las fuentes para conservar y utilizar de forma sostenible la diversidad biológica y los ecosistemas','N',15,1,'0000-00-00 00:00:00'),(137,'000011','Movilizar un volumen apreciable de recursos procedentes de todas las fuentes y a todos los niveles para financiar la gestión forestal sostenible y proporcionar incentivos adecuados a los países en desarrollo para que promuevan d icha gestión, en particular con miras a la conservación y la reforestación','N',15,1,'0000-00-00 00:00:00'),(138,'000012','Aumentar el apoyo mundial a la lucha contra la caza furtiva y el tráfico de especies protegidas, en particular aumentando la capacidad de las comunidades locales para promover oportunidades de subsistencia sostenibles','N',15,1,'0000-00-00 00:00:00'),(139,'00001','Reducir considerablemente todas las formas de violencia y las tasas de mortalidad conexas en todo el mundo','N',16,1,'0000-00-00 00:00:00'),(140,'00002','Poner fin al maltrato, la explotación, la trata, la tortura y todas las formas de violencia contra los niños','N',16,1,'0000-00-00 00:00:00'),(141,'00003','Promover el estado de derecho en los planos nacional e internacional y garantizar la igualdad de acceso a la justicia para todos','N',16,1,'0000-00-00 00:00:00'),(142,'00004','Para 2030, reducir de manera significativa las corrientes financieras y de armas ilícitas, fortalecer la recuperación y devolución de bienes rob ados y luchar contra todas las formas de delincuencia organizada','N',16,1,'0000-00-00 00:00:00'),(143,'00005','Reducir sustancialmente la corrupción y el soborno en todas sus formas','N',16,1,'0000-00-00 00:00:00'),(144,'00006','Crear instituciones eficaces, responsables y transparentes a todos los niveles','N',16,1,'0000-00-00 00:00:00'),(145,'00007','Garantizar la adopción de decisiones inclusivas, participativas representativas que respondan a las necesidades a todos los niveles y','N',16,1,'0000-00-00 00:00:00'),(146,'00008','Ampliar y fortalecer la participación de los países en desarrollo en las instituciones de gobernanza mundial','N',16,1,'0000-00-00 00:00:00'),(147,'00009','Para 2030, proporcionar acceso a una identidad jurídica para todos, en particular mediante el registro de nacimientos','N',16,1,'0000-00-00 00:00:00'),(148,'000010','Garantizar el acceso público a la información y proteger las libertades fundamentales, de conformidad con las leyes nacionales y los acuerdos internacionales','N',16,1,'0000-00-00 00:00:00'),(149,'000011','Fortalecer las instituciones nacionales pertinentes, incluso mediante la cooperación internacional, con miras a crear capacidad a todos los niveles, en particular en los países en desarrollo, para prevenir la violencia y combatir el terrorismo y la delincuencia','N',16,1,'0000-00-00 00:00:00'),(150,'000012','Promover y aplicar leyes y políticas no discriminatorias en favor del desarrollo sostenible','N',16,1,'0000-00-00 00:00:00'),(151,'00001','Fortalecer la movilización de recursos internos, incluso mediante la prestación de apoyo internacional a los países en desarrollo, con el fin de mejorar la capacidad nacional para recaudar ingresos fiscales y de otra índole','N',17,1,'0000-00-00 00:00:00'),(152,'00002','Velar por que los países desarrollados cumplan cabalmente sus compromisos en relación con la asistencia oficial para el desarrollo, incluido el compromiso de numerosos países desarrollados de alcanzar el objetivo de destinar el 0,7% del ingreso nacional bruto a la asistencia oficial para el desarrol lo y del 0,15% al 0,20% del ingreso nacional bruto a la asistencia oficial para el desarrollo de los países menos adelantados; y alentar a los proveedores de asistencia oficial para el desarrollo a que consideren fijar una meta para destinar al menos el 0, 20% del ingreso nacional bruto a la asistencia oficial para el desarrollo de los países menos adelantados','N',17,1,'0000-00-00 00:00:00'),(153,'00003','Movilizar recursos financieros adicionales procedentes de múltiples fuentes para los países en desarrollo','N',17,1,'0000-00-00 00:00:00'),(154,'00004','Ayudar a los países en desarrollo a lograr la sostenibilidad de la deuda a largo plazo con políticas coordinadas orientadas a fomentar la financiación, el alivio y la reestructuración de la deuda, según proceda, y hacer frente a la deuda externa de los países pobres muy endeudados a fin de reducir el endeudamiento excesivo','N',17,1,'0000-00-00 00:00:00'),(155,'00005','Adoptar y aplicar sistemas de promoción de las inversiones en favor de los países menos adelantados Tecnología','N',17,1,'0000-00-00 00:00:00'),(156,'00006','Mejorar la cooperación regional e internacional Norte -Sur, Sur-Sur y triangular en materia de ciencia, tecnología e innovación y el acceso a ellas y aumentar el intercambio de conocimientos en condiciones mutuamente convenidas, entre otras cosas mejorando la coordinación entre los mecanismos existentes, en particular en el ámbito de las Naciones Unidas, y mediante un mecanismo mundial de facilitación de la tecnología','N',17,1,'0000-00-00 00:00:00'),(157,'00007','Promover el desarrollo de tecnologías ecológicamente racionales y su transferencia, divulgación y difusión a los países en desarrollo en condiciones favorables, incluso en condiciones concesionarias y preferenciales, por mutuo acuerdo','N',17,1,'0000-00-00 00:00:00'),(158,'00008','Poner en pleno funcionamiento, a más tardar en 2017, el banco de tecnología y el mecanismo de apoyo a la ciencia, la tecnología y la innovación para los países menos adelantados y aumentar la utilización de tecnología instrumental, en particular de la tecnología de la información y las comunicaciones','N',17,1,'0000-00-00 00:00:00'),(159,'00009','Aumentar el apoyo internacional a la ejecución de programas de fomento de la capacidad eficaces y con objetivos concretos en los países en desarrollo a fin de apoyar los planes nacionales orientados a aplicar todos los Objetivos de Desarrollo Sostenible, incluso mediante la cooperación Norte-Sur, Sur-Sur y triangular Comercio','N',17,1,'0000-00-00 00:00:00'),(160,'000010','Promover un sistema de comercio multilateral universal, basado en normas, abierto, no discriminatorio y equitativo en el marco de la Organización Mundial del Comercio, incluso mediante la conclusión de las negociaciones con arreglo a su Programa de Doha para el Desarrollo','N',17,1,'0000-00-00 00:00:00'),(161,'000011','Aumentar de manera significativa las exportaciones de los países en desarrollo, en particular con miras a duplicar la participación de los países menos adelantados en las exportaciones mundiales para 2020','N',17,1,'0000-00-00 00:00:00'),(162,'000012','Lograr la consecución oportuna del acceso a los mercados, libre de derechos y de contingentes, de manera duradera para todos los países menos adelantados, de conformidad con las decisiones de la Organización Mundial del Comercio, entre otras cosas velando por que las normas de origen preferenciales aplicabl es a las importaciones de los países menos adelantados sean transparentes y sencillas y contribuyan a facilitar el acceso a los mercados','N',17,1,'0000-00-00 00:00:00'),(163,'00000','Aumentar los conocimientos científicos, desarrollar la capacidad de investigación y transferir tecnología marina, teniendo en cuenta los Criterios y Directrices para la Transferencia de Tecnología Marina de la Comisión Oceanográfica Intergubernamental, a fin de mejorar la salud de los océanos y potenciar la contribución de la biodiversidad marina al desarrollo de los países en desarrollo, en particular los pequeños Estados insulares en desarrollo y los países menos adelantados','N',14,6,'2016-12-23 20:21:32'),(164,'00008','prueba','N',1,3,'2017-01-04 20:48:13'),(165,'000017','Fomentar y promover la articulación entre las organizaciones de la sociedad civil, las organizaciones empresariales y los organismos públicos nacionales en la gestión de las políticas públicas','N',17,1,'2017-07-25 14:58:04');
/*!40000 ALTER TABLE `metas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `desgloces`
--

LOCK TABLES `desgloces` WRITE;
/*!40000 ALTER TABLE `desgloces` DISABLE KEYS */;
INSERT INTO `desgloces` VALUES (1,'Sexo'),(2,'Área'),(3,'Ocupación'),(4,'Etnia');
/*!40000 ALTER TABLE `desgloces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
INSERT INTO `etiquetas` VALUES (8,'Femenino 1',1),(9,'Masculino 1',1),(10,'Plena',3),(11,'Medio Tiempo',3),(12,'Desocupado',3),(13,'Urbana',2),(14,'Rural',2),(16,'Total 1',1),(17,'Aborigen',4),(18,'Blanca',4),(19,'Negra',4),(20,'total',2);
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `indicadores`
--

LOCK TABLES `indicadores` WRITE;
/*!40000 ALTER TABLE `indicadores` DISABLE KEYS */;
INSERT INTO `indicadores` VALUES (5,2,1,'Proporción de la población que vive por debajo del umbral internacional de la pobreza - test','porcentual',0,100,'P',1,3,'2017-07-25 14:25:42',NULL,'bdd5bea1dc30761e61dbe153cff0691f.pdf','2019-01-01',20.000000,'2030-01-01',8.000000),(6,6,1,'Número de muertos, desaparecidos, heridos, reubicados o evacuados debido a desastres por cada 100.000 personas.','entero',0,100000,'N',1,1,'2017-02-17 13:26:51',NULL,NULL,NULL,NULL,NULL,NULL),(8,49,1,'Porcentaje de la población que dispone de servicios de suministro de agua potable gestionados de manera segura.','porcentual',0,100,'D',1,1,'2017-02-17 13:36:07','2030-01-01;2015-01-01;2017-01-01',NULL,'2019-01-01',70.000000,'2030-01-01',90.000000),(9,9,1,'Este es un indicador de prueba','porcentual',0,100,'P',1,1,'2017-02-21 15:02:35','2015-01-01',NULL,'2019-01-01',23.000000,'2030-01-01',12.000000),(10,2,2,'Indicador de Prueba - ODS 1 - Meta 1.1 - Meta 1.1.2','porcentual',1,100,'N',1,1,'2016-12-29 21:19:43','2015-01-01;2010-01-01;2013-01-01','ea51f9efcb6e25e2fed5a48444c53247.pdf','2018-01-01',65.000000,'2030-01-01',100.000000),(11,3,1,'Esto es una prueba de Ariel de Informática','porcentual',0,100,'P',1,1,'2017-03-23 15:25:57','2010-01-01;2014-01-01;2011-01-01;2015-01-01;2018-01-01',NULL,'2014-01-01',2015.000000,'2020-01-01',102.000000),(12,2,3,'Tasa de ocupación - TEST','porcentual',0,100,'P',1,1,'2016-12-29 21:19:26','1984-01-01;1990-01-01;2001-01-01;2010-01-01;2015-01-01',NULL,'2019-01-01',40.000000,'2030-01-01',100.000000),(13,65,1,'Tasa de Actividad','porcentual',0,100,'P',1,3,'2017-03-28 15:03:09','1984-01-01;1990-01-01;2001-01-01;2010-01-01;2016-01-01',NULL,'2019-01-01',60.000000,'2030-01-01',100.000000),(14,65,2,'Tasa de Actividad-Departamental.','porcentual',0,100,'D',1,3,'2016-10-03 23:21:51','1983-01-01;2017-01-01',NULL,NULL,NULL,NULL,NULL),(15,163,1,'Financiamiento para la promoción de la investigación, desarrollo e innovación del espacio marítimo y pesquero con relación al Presupuesto Nacional en Ciencia y Técnica','porcentual',0,100,'N',1,6,'2016-12-23 20:37:00',NULL,NULL,'2020-01-01',3.000000,'2030-01-01',5.000000),(16,17,1,'Razón de mortalidad materna por 100.000 nacidos vivos','real',0,100,'N',1,6,'2016-12-23 21:33:02',NULL,NULL,'2020-01-01',13.000000,'2030-01-01',8.000000),(18,18,1,'Número de muertes de menores de 5 años cada 1.000 nacidos vivos','real',0,1000,'N',1,6,'2016-12-23 22:56:38',NULL,NULL,'2020-01-01',9.000000,'2030-01-01',8.000000),(19,17,2,'Razón de mortalidad materna por 100.000 nacidos vivos por provincia','real',0,100,'P',1,6,'2016-12-23 23:39:02',NULL,NULL,NULL,NULL,NULL,NULL),(20,2,5,'prueba prueba','porcentual',0,100,'N',1,1,'2017-07-25 14:46:19','2011-01-01;2017-01-01;2020-01-01',NULL,'2017-01-01',55.000000,'2020-01-01',60.000000),(21,2,0,'iiiii','entero',0,100,'N',1,3,'2017-07-25 15:39:58',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `indicadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `desglocesIndicadores`
--

LOCK TABLES `desglocesIndicadores` WRITE;
/*!40000 ALTER TABLE `desglocesIndicadores` DISABLE KEYS */;
INSERT INTO `desglocesIndicadores` VALUES (5,0),(5,1),(5,2),(6,0),(6,1),(8,0),(9,0),(9,1),(9,3),(10,0),(10,1),(10,2),(10,3),(11,0),(12,0),(12,1),(12,2),(12,3),(12,4),(13,0),(13,1),(14,0),(15,0),(16,0),(18,0),(19,0),(20,0),(21,0);
/*!40000 ALTER TABLE `desglocesIndicadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `valoresIndicadoresConfigFecha`
--

LOCK TABLES `valoresIndicadoresConfigFecha` WRITE;
/*!40000 ALTER TABLE `valoresIndicadoresConfigFecha` DISABLE KEYS */;
INSERT INTO `valoresIndicadoresConfigFecha` VALUES (9,5,'2013-01-01',0),(10,5,'2014-01-01',0),(11,8,'2015-01-01',0),(12,6,'2015-01-01',0),(13,6,'2016-01-01',0),(14,6,'2014-01-01',0),(15,5,'2015-01-01',0),(16,9,'2014-01-01',0),(17,12,'1984-01-01',0),(18,12,'2001-01-01',0),(19,12,'1990-01-01',0),(20,13,'1984-01-01',0),(21,5,'1985-01-01',0),(22,13,'1985-01-01',0),(23,5,'1986-01-01',0),(24,13,'1986-01-01',0),(25,13,'1987-01-01',0),(26,13,'1988-01-01',0),(27,13,'1989-01-01',0),(28,13,'1990-01-01',0),(29,13,'1992-01-01',0),(30,13,'1993-01-01',0),(31,13,'1996-01-01',0),(32,13,'1997-01-01',0),(33,13,'1998-01-01',0),(34,13,'2000-01-01',0),(35,13,'2001-01-01',0),(36,13,'2003-01-01',0),(37,13,'2005-01-01',0),(38,13,'2007-01-01',0),(39,13,'2009-01-01',0),(40,13,'2011-01-01',0),(41,13,'2013-01-01',0),(42,13,'2015-01-01',0),(43,10,'2010-01-01',0),(44,10,'2015-01-01',0),(45,10,'2005-01-01',0),(46,13,'2016-01-01',0),(47,14,'2016-01-01',0),(48,15,'2017-01-01',0),(49,16,'2000-01-01',0),(50,16,'2005-01-01',0),(51,16,'2009-01-01',0),(52,16,'2010-01-01',0),(53,16,'2015-01-01',0),(58,18,'1990-01-01',0),(59,18,'2000-01-01',0),(60,18,'2005-01-01',0),(61,18,'2010-01-01',0),(62,18,'2013-01-01',0),(63,19,'2015-01-01',0),(64,5,'2016-01-01',0),(65,12,'2016-01-01',0),(66,20,'2017-01-01',0),(67,5,'2017-01-01',0);
/*!40000 ALTER TABLE `valoresIndicadoresConfigFecha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `valoresIndicadoresConfigFechaDesgloces`
--

LOCK TABLES `valoresIndicadoresConfigFechaDesgloces` WRITE;
/*!40000 ALTER TABLE `valoresIndicadoresConfigFechaDesgloces` DISABLE KEYS */;
INSERT INTO `valoresIndicadoresConfigFechaDesgloces` VALUES (2,9),(0,10),(0,11),(1,12),(1,13),(1,14),(0,15),(1,16),(3,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(2,43),(3,43),(1,44),(2,44),(3,44),(1,45),(2,45),(3,45),(0,46),(0,47),(0,48),(0,49),(0,50),(0,51),(0,52),(0,53),(0,58),(0,59),(0,60),(0,61),(0,62),(0,63),(0,64),(4,65),(0,66),(2,67);
/*!40000 ALTER TABLE `valoresIndicadoresConfigFechaDesgloces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- `valoresIndicadores`
--

LOCK TABLES `valoresIndicadores` WRITE;
/*!40000 ALTER TABLE `valoresIndicadores` DISABLE KEYS */;
INSERT INTO `valoresIndicadores` VALUES (9,'13',1,23.000000,1,3,'2017-07-25 14:51:16'),(9,'14',1,24.000000,1,3,'2017-07-25 14:51:16'),(9,'20',1,50.000000,1,3,'2017-07-25 14:51:16'),(9,'13',2,22.000000,1,1,'2017-02-17 13:45:29'),(9,'14',2,28.000000,1,1,'2017-02-17 13:45:29'),(9,'13',3,33.000000,1,1,'2017-02-17 13:45:29'),(9,'14',3,40.000000,1,1,'2017-02-17 13:45:29'),(9,'13',4,21.000000,1,1,'2017-02-17 13:45:29'),(9,'14',4,21.000000,1,1,'2017-02-17 13:45:29'),(9,'13',5,10.000000,1,1,'2017-02-17 13:45:29'),(9,'14',5,10.000000,1,1,'2017-02-17 13:45:29'),(9,'13',6,18.000000,1,1,'2017-02-17 13:45:29'),(9,'14',6,21.000000,1,1,'2017-02-17 13:45:29'),(9,'13',7,30.000000,1,1,'2017-02-17 13:45:29'),(9,'14',7,35.000000,1,1,'2017-02-17 13:45:29'),(9,'13',8,23.000000,1,1,'2017-02-17 13:45:29'),(9,'14',8,22.000000,1,1,'2017-02-17 13:45:29'),(9,'13',9,45.000000,1,3,'2017-07-25 14:49:50'),(9,'14',9,50.000000,1,3,'2017-07-25 14:49:50'),(9,'20',9,50.000000,1,3,'2017-07-25 14:49:50'),(9,'13',10,40.000000,1,1,'2017-02-17 13:45:29'),(9,'14',10,44.000000,1,1,'2017-02-17 13:45:29'),(9,'13',11,27.000000,1,1,'2017-02-17 13:45:29'),(9,'14',11,29.000000,1,1,'2017-02-17 13:45:29'),(9,'13',12,34.000000,1,1,'2017-02-17 13:45:29'),(9,'14',12,35.000000,1,1,'2017-02-17 13:45:29'),(9,'13',13,16.000000,1,1,'2017-02-17 13:45:29'),(9,'14',13,19.000000,1,1,'2017-02-17 13:45:29'),(9,'13',14,33.000000,1,1,'2017-02-17 13:45:29'),(9,'14',14,45.000000,1,1,'2017-02-17 13:45:29'),(9,'13',15,12.000000,1,1,'2017-02-17 13:45:29'),(9,'14',15,18.000000,1,1,'2017-02-17 13:45:29'),(9,'13',16,22.000000,1,1,'2017-02-17 13:45:29'),(9,'14',16,22.000000,1,1,'2017-02-17 13:45:29'),(9,'13',17,26.000000,1,1,'2017-02-17 13:45:29'),(9,'14',17,31.000000,1,1,'2017-02-17 13:45:29'),(9,'13',18,22.000000,1,1,'2017-02-17 13:45:29'),(9,'14',18,30.000000,1,1,'2017-02-17 13:45:29'),(9,'13',19,21.000000,1,3,'2017-07-25 14:49:37'),(9,'14',19,21.000000,1,3,'2017-07-25 14:49:37'),(9,'20',19,40.000000,1,3,'2017-07-25 14:49:37'),(9,'13',20,23.000000,1,3,'2017-07-25 14:49:39'),(9,'14',20,24.000000,1,3,'2017-07-25 14:49:39'),(9,'20',20,65.000000,1,3,'2017-07-25 14:49:39'),(9,'13',21,19.000000,1,3,'2017-07-25 14:49:40'),(9,'14',21,22.000000,1,3,'2017-07-25 14:49:40'),(9,'20',21,78.000000,1,3,'2017-07-25 14:49:40'),(9,'13',22,33.000000,1,3,'2017-07-25 14:49:34'),(9,'14',22,35.000000,1,3,'2017-07-25 14:49:34'),(9,'20',22,60.000000,1,3,'2017-07-25 14:49:34'),(9,'13',23,29.000000,1,3,'2017-07-25 14:49:32'),(9,'14',23,33.000000,1,3,'2017-07-25 14:49:32'),(9,'20',23,50.000000,1,3,'2017-07-25 14:49:32'),(9,'13',24,28.000000,1,3,'2017-07-25 14:49:30'),(9,'14',24,26.000000,1,3,'2017-07-25 14:49:30'),(9,'20',24,50.000000,1,3,'2017-07-25 14:49:30'),(11,'0',36,54.000000,1,1,'2017-02-17 13:52:19'),(11,'0',37,56.000000,1,1,'2017-02-17 13:52:19'),(11,'0',53,56.000000,1,1,'2017-02-17 13:52:19'),(11,'0',55,25.000000,1,1,'2017-02-17 13:50:47'),(11,'0',60,99.000000,1,1,'2017-02-17 13:52:19'),(11,'0',61,66.000000,1,1,'2017-02-17 13:52:19'),(11,'0',64,56.000000,1,1,'2017-02-17 13:52:19'),(11,'0',65,54.000000,1,1,'2017-02-17 13:52:19'),(11,'0',68,67.000000,1,1,'2017-02-17 13:52:19'),(11,'0',73,32.000000,1,1,'2017-02-17 13:52:19'),(11,'0',263,21.000000,1,1,'2017-02-17 13:50:47'),(11,'0',265,32.000000,1,1,'2017-02-17 13:50:47'),(11,'0',267,43.000000,1,1,'2017-02-17 13:50:47'),(11,'0',272,77.000000,1,1,'2017-02-17 13:50:47'),(11,'0',273,22.000000,1,1,'2017-02-17 13:50:47'),(11,'0',274,43.000000,1,1,'2017-02-17 13:50:47'),(11,'0',275,23.000000,1,1,'2017-02-17 13:50:47'),(11,'0',276,41.000000,1,1,'2017-02-17 13:50:47'),(11,'0',277,78.000000,1,1,'2017-02-17 13:50:47'),(11,'0',278,77.000000,1,1,'2017-02-17 13:50:47'),(11,'0',279,12.000000,1,1,'2017-02-17 13:50:47'),(11,'0',280,42.000000,1,1,'2017-02-17 13:50:47'),(11,'0',281,67.000000,1,1,'2017-02-17 13:50:47'),(11,'0',283,12.000000,1,1,'2017-02-17 13:50:47'),(11,'0',284,21.000000,1,1,'2017-02-17 13:50:47'),(11,'0',350,42.000000,1,1,'2017-02-17 13:50:47'),(11,'0',383,45.000000,1,1,'2017-02-17 13:52:19'),(11,'0',384,34.000000,1,1,'2017-02-17 13:52:19'),(11,'0',385,78.000000,1,1,'2017-02-17 13:52:19'),(11,'0',387,65.000000,1,1,'2017-02-17 13:52:19'),(11,'0',388,55.000000,1,1,'2017-02-17 13:52:19'),(11,'0',389,23.000000,1,1,'2017-02-17 13:52:19'),(11,'0',390,22.000000,1,1,'2017-02-17 13:52:19'),(11,'0',423,22.000000,1,1,'2017-02-17 13:51:25'),(11,'0',463,44.000000,1,1,'2017-02-17 13:50:47'),(12,'8',0,3500.000000,1,1,'2017-02-17 13:53:31'),(12,'9',0,4000.000000,1,1,'2017-02-17 13:53:31'),(13,'8',0,2300.000000,1,1,'2017-02-17 13:54:00'),(13,'9',0,3211.000000,1,1,'2017-02-17 13:54:00'),(14,'8',0,10263.000000,1,1,'2017-02-17 13:54:28'),(14,'9',0,9863.000000,1,1,'2017-02-17 13:54:28'),(15,'0',1,15.000000,1,1,'2017-02-21 13:17:36'),(15,'0',2,12.000000,1,1,'2017-02-21 13:17:36'),(15,'0',3,20.000000,1,1,'2017-02-21 13:17:36'),(16,'10',1,18.000000,1,1,'2017-02-21 15:09:03'),(16,'11',1,19.000000,1,1,'2017-02-21 15:09:03'),(16,'12',1,33.000000,1,1,'2017-02-21 15:09:03'),(16,'8',1,23.000000,1,1,'2017-02-21 15:09:03'),(16,'9',1,33.000000,1,1,'2017-02-21 15:09:03'),(16,'10',11,12.000000,1,1,'2017-02-21 15:09:03'),(16,'11',11,34.000000,1,1,'2017-02-21 15:09:03'),(16,'12',11,12.000000,1,1,'2017-02-21 15:09:03'),(16,'8',11,66.000000,1,1,'2017-02-21 15:09:03'),(16,'9',11,88.000000,1,1,'2017-02-21 15:09:03'),(17,'8',21,25.200000,1,3,'2017-03-28 13:25:06'),(17,'9',21,48.700000,1,3,'2017-03-28 13:25:06'),(18,'16',1,3.000000,1,4,'2016-12-29 21:32:07'),(18,'8',1,1.000000,1,4,'2016-12-29 21:32:07'),(18,'9',1,2.000000,1,4,'2016-12-29 21:32:07'),(19,'8',21,28.900000,1,3,'2017-03-28 13:28:59'),(19,'9',21,48.900000,1,3,'2017-03-28 13:28:59'),(20,'16',21,36.100000,1,3,'2017-04-07 15:24:52'),(20,'8',21,24.200000,1,3,'2017-04-07 15:24:52'),(20,'9',21,48.700000,1,3,'2017-04-07 15:24:52'),(22,'16',21,38.400000,1,3,'2017-04-05 16:50:26'),(22,'8',21,28.500000,1,3,'2017-04-05 16:50:26'),(22,'9',21,49.200000,1,3,'2017-04-05 16:50:26'),(24,'16',21,37.200000,1,3,'2017-04-05 16:46:50'),(24,'8',21,27.400000,1,3,'2017-04-05 16:46:50'),(24,'9',21,47.700000,1,3,'2017-04-05 16:46:50'),(25,'16',21,37.700000,1,3,'2017-04-05 16:45:32'),(25,'8',21,26.300000,1,3,'2017-04-05 16:45:32'),(25,'9',21,50.300000,1,3,'2017-04-05 16:45:32'),(26,'16',21,39.400000,1,3,'2017-04-05 16:43:51'),(26,'8',21,29.200000,1,3,'2017-04-05 16:43:51'),(26,'9',21,50.900000,1,3,'2017-04-05 16:43:51'),(27,'16',21,38.600000,1,3,'2017-04-05 16:49:46'),(27,'8',21,28.800000,1,3,'2017-04-05 16:49:46'),(27,'9',21,49.700000,1,3,'2017-04-05 16:49:46'),(29,'16',21,40.300000,1,3,'2017-04-05 17:00:00'),(29,'8',21,32.100000,1,3,'2017-04-05 17:00:00'),(29,'9',21,48.900000,1,3,'2017-04-05 17:00:00'),(30,'16',21,39.900000,1,3,'2017-04-05 17:00:37'),(30,'8',21,31.000000,1,3,'2017-04-05 17:00:37'),(30,'9',21,49.500000,1,3,'2017-04-05 17:00:37'),(31,'16',21,35.600000,1,3,'2017-04-05 17:01:14'),(31,'8',21,26.000000,1,3,'2017-04-05 17:01:14'),(31,'9',21,45.900000,1,3,'2017-04-05 17:01:14'),(32,'16',21,37.800000,1,3,'2017-04-05 17:01:52'),(32,'8',21,30.300000,1,3,'2017-04-05 17:01:52'),(32,'9',21,46.200000,1,3,'2017-04-05 17:01:52'),(33,'16',21,36.900000,1,3,'2017-04-05 17:02:25'),(33,'8',21,28.800000,1,3,'2017-04-05 17:02:25'),(33,'9',21,46.000000,1,3,'2017-04-05 17:02:25'),(34,'16',21,39.100000,1,3,'2017-04-05 16:51:53'),(34,'8',21,30.800000,1,3,'2017-04-05 16:51:53'),(34,'9',21,48.500000,1,3,'2017-04-05 16:51:53'),(35,'16',21,39.000000,1,3,'2017-04-05 16:52:24'),(35,'8',21,31.100000,1,3,'2017-04-05 16:52:24'),(35,'9',21,47.800000,1,3,'2017-04-05 16:52:24'),(36,'16',21,44.600000,1,3,'2017-04-05 16:53:04'),(36,'8',21,39.600000,1,3,'2017-04-05 16:53:04'),(36,'9',21,50.000000,1,3,'2017-04-05 16:53:04'),(37,'16',21,42.500000,1,3,'2017-04-05 16:53:41'),(37,'8',21,34.800000,1,3,'2017-04-05 16:53:41'),(37,'9',21,50.900000,1,3,'2017-04-05 16:53:41'),(38,'16',21,39.900000,1,3,'2017-04-05 16:54:55'),(38,'8',21,30.500000,1,3,'2017-04-05 16:54:55'),(38,'9',21,50.200000,1,3,'2017-04-05 16:54:55'),(39,'16',21,42.800000,1,3,'2017-04-05 16:55:31'),(39,'8',21,34.700000,1,3,'2017-04-05 16:55:31'),(39,'9',21,51.600000,1,3,'2017-04-05 16:55:31'),(40,'16',21,44.400000,1,3,'2017-04-05 16:56:04'),(40,'8',21,34.800000,1,3,'2017-04-05 16:56:04'),(40,'9',21,54.800000,1,3,'2017-04-05 16:56:04'),(41,'16',21,44.100000,1,3,'2017-04-05 16:56:59'),(41,'8',21,35.300000,1,3,'2017-04-05 16:56:59'),(41,'9',21,53.500000,1,3,'2017-04-05 16:56:59'),(42,'16',21,42.700000,1,3,'2017-04-05 16:57:46'),(42,'8',21,33.300000,1,3,'2017-04-05 16:57:46'),(42,'9',21,52.900000,1,3,'2017-04-05 16:57:46'),(43,'10',0,100.000000,1,3,'2017-04-07 16:49:14'),(43,'11',0,40.000000,1,3,'2017-04-07 16:49:14'),(43,'12',0,45.000000,1,3,'2017-04-07 16:49:14'),(43,'13',0,58.000000,1,3,'2017-04-07 16:49:14'),(43,'14',0,35.000000,1,3,'2017-04-07 16:49:14'),(43,'16',0,100.000000,1,3,'2017-04-07 16:49:14'),(43,'8',0,30.000000,1,3,'2017-04-07 16:49:14'),(43,'9',0,35.000000,1,3,'2017-04-07 16:49:14'),(44,'10',0,100.000000,1,3,'2017-04-07 16:50:01'),(44,'11',0,52.000000,1,3,'2017-04-07 16:50:01'),(44,'12',0,33.000000,1,3,'2017-04-07 16:50:01'),(44,'13',0,58.000000,1,3,'2017-04-07 16:50:01'),(44,'14',0,40.000000,1,3,'2017-04-07 16:50:01'),(44,'16',0,100.000000,1,3,'2017-04-07 16:50:01'),(44,'8',0,45.000000,1,3,'2017-04-07 16:50:01'),(44,'9',0,58.000000,1,3,'2017-04-07 16:50:01'),(45,'10',0,10.000000,1,3,'2017-04-07 16:51:14'),(45,'11',0,2.000000,1,3,'2017-04-07 16:51:14'),(45,'12',0,80.000000,1,3,'2017-04-07 16:51:14'),(45,'13',0,40.000000,1,3,'2017-04-07 16:51:14'),(45,'14',0,25.000000,1,3,'2017-04-07 16:51:14'),(45,'16',0,75.000000,1,3,'2017-04-07 16:51:14'),(45,'8',0,15.000000,1,3,'2017-04-07 16:51:14'),(45,'9',0,25.000000,1,3,'2017-04-07 16:51:14'),(46,'0',2,42.600000,1,3,'2016-09-29 00:01:45'),(46,'0',3,37.000000,1,3,'2016-09-29 00:01:45'),(46,'0',5,54.600000,1,3,'2016-09-28 23:52:58'),(46,'0',7,43.700000,1,3,'2016-09-28 23:53:39'),(46,'0',9,29.900000,1,3,'2016-09-29 00:00:17'),(46,'0',12,41.000000,1,3,'2016-09-29 00:01:45'),(46,'0',17,42.200000,1,3,'2016-09-29 00:01:45'),(46,'0',22,36.400000,1,3,'2016-09-29 00:01:45'),(46,'0',23,47.300000,1,3,'2016-09-29 00:01:45'),(47,'0',25,39.900000,1,3,'2016-10-03 23:38:30'),(47,'0',30,43.700000,1,3,'2016-10-03 23:28:45'),(47,'0',54,45.200000,1,3,'2016-10-03 23:41:38'),(47,'0',58,44.300000,1,3,'2016-10-03 23:47:19'),(47,'0',65,42.000000,1,3,'2016-10-03 23:30:56'),(47,'0',160,33.600000,1,3,'2016-10-03 23:27:36'),(47,'0',191,46.700000,1,3,'2016-10-03 23:41:38'),(47,'0',199,47.100000,1,3,'2016-10-03 23:41:38'),(47,'0',243,42.200000,1,3,'2016-10-03 23:33:15'),(47,'0',256,45.400000,1,3,'2016-10-03 23:26:57'),(47,'0',261,33.600000,0,3,'2016-10-03 23:27:36'),(47,'0',290,41.300000,1,3,'2016-10-03 23:43:08'),(47,'0',319,42.600000,1,3,'2016-10-03 23:31:37'),(47,'0',345,47.800000,1,3,'2016-10-03 23:50:33'),(47,'0',347,40.900000,1,3,'2016-10-03 23:50:33'),(47,'0',360,44.600000,1,3,'2016-10-03 23:39:31'),(47,'0',372,48.000000,1,3,'2016-10-03 23:41:58'),(47,'0',433,48.700000,1,3,'2016-10-03 23:42:42'),(47,'0',449,43.600000,1,3,'2016-10-03 23:42:42'),(47,'0',463,41.000000,1,3,'2016-10-03 23:32:52'),(47,'0',487,42.100000,1,3,'2016-10-03 23:54:38'),(47,'0',540,45.000000,1,3,'2016-10-03 23:52:20'),(48,'0',0,1.000000,0,1,'2017-07-25 13:01:00'),(49,'0',0,35.000000,1,6,'2016-12-23 21:43:05'),(50,'0',0,39.000000,1,6,'2016-12-23 21:46:26'),(51,'0',0,55.000000,1,6,'2016-12-23 21:48:53'),(52,'0',0,44.000000,1,6,'2016-12-23 21:51:35'),(53,'0',0,39.000000,1,6,'2016-12-23 21:54:02'),(58,'0',0,29.600000,1,6,'2016-12-23 22:57:11'),(59,'0',0,19.300000,1,6,'2016-12-23 22:59:35'),(60,'0',0,15.500000,1,6,'2016-12-23 22:59:55'),(61,'0',0,13.800000,1,6,'2016-12-23 23:00:18'),(62,'0',0,12.600000,1,6,'2016-12-23 23:00:51'),(63,'0',1,39.000000,1,6,'2016-12-23 23:43:18'),(63,'0',2,0.000000,1,6,'2016-12-23 23:43:18'),(63,'0',3,73.000000,1,6,'2016-12-23 23:43:18'),(63,'0',4,41.000000,1,6,'2016-12-23 23:43:18'),(63,'0',5,19.000000,1,6,'2016-12-23 23:43:18'),(63,'0',6,29.000000,1,6,'2016-12-23 23:43:18'),(63,'0',7,48.000000,1,6,'2016-12-23 23:43:18'),(63,'0',8,51.000000,1,6,'2016-12-23 23:43:18'),(63,'0',9,57.000000,1,6,'2016-12-23 23:43:18'),(63,'0',10,75.000000,1,6,'2016-12-23 23:43:18'),(63,'0',11,19.000000,1,6,'2016-12-23 23:43:18'),(63,'0',12,32.000000,1,6,'2016-12-23 23:43:18'),(63,'0',13,23.000000,1,6,'2016-12-23 23:43:18'),(63,'0',14,59.000000,1,6,'2016-12-23 23:43:18'),(63,'0',15,34.000000,1,6,'2016-12-23 23:43:18'),(63,'0',16,0.000000,1,6,'2016-12-23 23:43:18'),(63,'0',17,81.000000,1,6,'2016-12-23 23:43:18'),(63,'0',18,59.000000,1,6,'2016-12-23 23:43:18'),(63,'0',19,37.000000,1,6,'2016-12-23 23:43:18'),(63,'0',20,16.000000,1,6,'2016-12-23 23:43:18'),(63,'0',21,19.000000,1,6,'2016-12-23 23:43:18'),(63,'0',22,42.000000,1,6,'2016-12-23 23:43:18'),(63,'0',23,0.000000,1,6,'2016-12-23 23:43:18'),(63,'0',24,36.000000,1,6,'2016-12-23 23:43:18'),(65,'17',1,18.000000,1,1,'2016-12-29 21:20:34'),(65,'18',1,16.000000,1,1,'2016-12-29 21:20:34'),(65,'19',1,20.000000,1,1,'2016-12-29 21:20:34'),(65,'17',2,1.000000,1,1,'2016-12-29 21:24:12'),(65,'18',2,2.000000,1,1,'2016-12-29 21:24:12'),(65,'19',2,1.000000,1,1,'2016-12-29 21:24:12'),(65,'17',3,1.000000,1,1,'2016-12-29 21:24:20'),(65,'18',3,1.000000,1,1,'2016-12-29 21:24:20'),(65,'19',3,1.000000,1,1,'2016-12-29 21:24:20'),(65,'17',4,1.000000,1,1,'2016-12-29 21:24:28'),(65,'18',4,1.000000,1,1,'2016-12-29 21:24:28'),(65,'19',4,1.000000,1,1,'2016-12-29 21:24:28'),(65,'17',5,5.000000,1,1,'2016-12-29 21:20:57'),(65,'18',5,3.000000,1,1,'2016-12-29 21:20:57'),(65,'19',5,2.000000,1,1,'2016-12-29 21:20:57'),(65,'17',12,1.000000,1,1,'2016-12-29 21:20:57'),(65,'18',12,2.000000,1,1,'2016-12-29 21:20:57'),(65,'19',12,3.000000,1,1,'2016-12-29 21:20:57'),(65,'17',23,5.000000,1,1,'2016-12-29 21:23:32'),(65,'18',23,12.000000,1,1,'2016-12-29 21:23:32'),(65,'19',23,3.000000,1,1,'2016-12-29 21:23:32'),(66,'0',0,55.000000,1,3,'2017-07-25 14:03:36'),(67,'13',1,55.000000,1,3,'2017-07-25 14:48:53'),(67,'14',1,40.000000,1,3,'2017-07-25 14:48:53'),(67,'20',1,60.000000,1,3,'2017-07-25 14:48:53');
/*!40000 ALTER TABLE `valoresIndicadores` ENABLE KEYS */;
UNLOCK TABLES;