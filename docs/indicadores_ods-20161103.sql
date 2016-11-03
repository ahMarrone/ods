-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-11-2016 a las 13:04:46
-- Versión del servidor: 5.5.52-0ubuntu0.14.04.1
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desgloces`
--

CREATE TABLE IF NOT EXISTS `desgloces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desgloce',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglocesIndicadores`
--

CREATE TABLE IF NOT EXISTS `desglocesIndicadores` (
  `idIndicador` int(11) NOT NULL,
  `idDesgloce` int(11) NOT NULL,
  PRIMARY KEY (`idIndicador`,`idDesgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE IF NOT EXISTS `etiquetas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la etiqueta',
  `fkIdDesgloce` int(10) unsigned NOT NULL COMMENT 'clave foranea desgloce',
  PRIMARY KEY (`id`),
  KEY `fkIdDesgloce` (`fkIdDesgloce`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE IF NOT EXISTS `indicadores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del indicador',
  `fkIdMeta` int(10) unsigned NOT NULL COMMENT 'clave foranea meta',
  `tipo` enum('porcentual','entero','real') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de indicador',
  `valMin` bigint(20) NOT NULL COMMENT 'valor minimo dentro del dominio',
  `valMax` bigint(20) NOT NULL COMMENT 'valor maximo dentro del dominio',
  `ambito` enum('N','P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito al que pertenece el indicador',
  `visibleNacional` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Nacional',
  `visibleProvincial` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Provincial',
  `visibleMunicipal` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Visibilidad del indicador a nivel Municipal',
  PRIMARY KEY (`id`),
  KEY `fkIdMeta` (`fkIdMeta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

CREATE TABLE IF NOT EXISTS `metas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `fkIdObjetivo` int(10) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  PRIMARY KEY (`id`),
  KEY `fkIdObjetivo` (`fkIdObjetivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=169 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refGeografica`
--

CREATE TABLE IF NOT EXISTS `refGeografica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  `agrupa` int(10) unsigned NOT NULL COMMENT 'id de la ref. geogr. por la cual es agrupada',
  PRIMARY KEY (`id`),
  KEY `agrupa` (`agrupa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `domicilio` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `localidad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `dependencia` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `rol` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoresIndicadores`
--

CREATE TABLE IF NOT EXISTS `valoresIndicadores` (
  `idIndicador` int(10) unsigned NOT NULL,
  `idEtiqueta` int(10) unsigned NOT NULL,
  `idRefGeografica` int(10) unsigned NOT NULL,
  `fecha` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idIndicador`,`idEtiqueta`,`idRefGeografica`),
  KEY `idEtiqueta` (`idEtiqueta`),
  KEY `idRefGeografica` (`idRefGeografica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`fkIdDesgloce`) REFERENCES `desgloces` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`fkIdMeta`) REFERENCES `metas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`fkIdObjetivo`) REFERENCES `objetivos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoresIndicadores`
--
ALTER TABLE `valoresIndicadores`
  ADD CONSTRAINT `valoresIndicadores_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `valoresIndicadores_ibfk_2` FOREIGN KEY (`idEtiqueta`) REFERENCES `etiquetas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `valoresIndicadores_ibfk_3` FOREIGN KEY (`idRefGeografica`) REFERENCES `refGeografica` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
