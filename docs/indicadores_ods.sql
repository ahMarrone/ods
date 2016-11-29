-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-11-2016 a las 10:26:43
-- Versión del servidor: 5.5.53-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `indicadores_ods`
--
CREATE DATABASE IF NOT EXISTS `indicadores_ods` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `indicadores_ods`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agrupamientoRefGeografica`
--

DROP TABLE IF EXISTS `agrupamientoRefGeografica`;
CREATE TABLE IF NOT EXISTS `agrupamientoRefGeografica` (
  `id_1` int(11) unsigned NOT NULL,
  `id_2` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_1`,`id_2`),
  KEY `refGeografica_ibfk_2` (`id_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desgloces`
--

DROP TABLE IF EXISTS `desgloces`;
CREATE TABLE IF NOT EXISTS `desgloces` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desgloce',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglocesIndicadores`
--

DROP TABLE IF EXISTS `desglocesIndicadores`;
CREATE TABLE IF NOT EXISTS `desglocesIndicadores` (
  `idIndicador` int(11) unsigned NOT NULL,
  `idDesgloce` int(11) unsigned NOT NULL,
  KEY `idIndicador` (`idIndicador`),
  KEY `idDesgloce` (`idDesgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

DROP TABLE IF EXISTS `indicadores`;
CREATE TABLE IF NOT EXISTS `indicadores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del indicador',
  `fkIdMeta` int(11) unsigned NOT NULL COMMENT 'clave foranea meta',
  `tipo` enum('porcentual','entero','real') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de indicador',
  `valMin` bigint(20) NOT NULL COMMENT 'valor minimo dentro del dominio',
  `valMax` bigint(20) NOT NULL COMMENT 'valor maximo dentro del dominio',
  `ambito` enum('N','P','D') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito al que pertenece el indicador',
  `visibleNacional` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Nacional',
  `visibleProvincial` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Provincial',
  `visibleMunicipal` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Municipal',
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  `fechasDestacadas` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdMeta` (`fkIdMeta`),
  KEY `ndxUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

DROP TABLE IF EXISTS `metas`;
CREATE TABLE IF NOT EXISTS `metas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL,
  `fkIdObjetivo` int(11) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkIdObjetivo` (`fkIdObjetivo`),
  KEY `ndxUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=163 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

DROP TABLE IF EXISTS `objetivos`;
CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refGeografica`
--

DROP TABLE IF EXISTS `refGeografica`;
CREATE TABLE IF NOT EXISTS `refGeografica` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=552 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

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
  `valor` decimal(10,2) NOT NULL,
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
  `id` int(11) unsigned NOT NULL,
  `idIndicador` int(11) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `cruzado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `desglocesIndicadores_uniq_1` (`idIndicador`,`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agrupamientoRefGeografica`
--
ALTER TABLE `agrupamientoRefGeografica`
  ADD CONSTRAINT `refGeografica_ibfk_1` FOREIGN KEY (`id_1`) REFERENCES `refGeografica` (`id`),
  ADD CONSTRAINT `refGeografica_ibfk_2` FOREIGN KEY (`id_2`) REFERENCES `refGeografica` (`id`);

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
  ADD CONSTRAINT `valoresIndicadores_ibfk_4` FOREIGN KEY (`idValoresIndicadoresConfigFecha`) REFERENCES `valoresIndicadoresConfigFecha` (`id`),
  ADD CONSTRAINT `valoresIndicadores_ibfk_2` FOREIGN KEY (`idRefGeografica`) REFERENCES `refGeografica` (`id`),
  ADD CONSTRAINT `valoresIndicadores_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
