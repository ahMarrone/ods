-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-10-2016 a las 04:43:39
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

drop database IF EXISTS `indicadores_ods`;
create database `indicadores_ods`;
use indicadores_ods;
--
-- BD indicadores. Cruce etiquetas
--
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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

DROP TABLE IF EXISTS `desgloces`;
CREATE TABLE IF NOT EXISTS `desgloces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desgloce',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `desgloces`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desgloces_indicadores`
--

DROP TABLE IF EXISTS `desgloces_indicadores`;
CREATE TABLE IF NOT EXISTS `desgloces_indicadores` (
  `idIndicador` int(10) unsigned NOT NULL,
  `idDesgloce` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idIndicador`,`idDesgloce`),
  KEY `desgloces_indicadores_ibfk_2` (`idDesgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcar la base de datos para la tabla `desgloces_indicadores`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la etiqueta',
  `fkIdDesgloce` int(10) unsigned NOT NULL COMMENT 'clave foranea desgloce',
  PRIMARY KEY (`id`),
  KEY `fkIdDesgloce` (`fkIdDesgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `etiquetas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

DROP TABLE IF EXISTS `indicadores`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `indicadores`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas`
--

DROP TABLE IF EXISTS `metas`;
CREATE TABLE IF NOT EXISTS `metas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `fkIdObjetivo` int(10) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  PRIMARY KEY (`id`),
  KEY `fkIdObjetivo` (`fkIdObjetivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `metas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

DROP TABLE IF EXISTS `objetivos`;
CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `objetivos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `refgeografica`
--

DROP TABLE IF EXISTS `refgeografica`;
CREATE TABLE IF NOT EXISTS `refgeografica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  `agrupa` int(10) unsigned NOT NULL COMMENT 'id de la ref. geogr. por la cual es agrupada',
  PRIMARY KEY (`id`),
  KEY `agrupa` (`agrupa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `refgeografica`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoresindicadores`
--

DROP TABLE IF EXISTS `valoresindicadores`;
CREATE TABLE IF NOT EXISTS `valoresindicadores` (
  `idIndicador` int(10) unsigned NOT NULL,
  `idEtiqueta` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Clave en formato string que representa el cruce de etuqietas del registro',
  `idRefGeografica` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `valor` decimal(10,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idIndicador`,`idEtiqueta`,`idRefGeografica`,`fecha`),
  KEY `idRefGeografica` (`idRefGeografica`),
  KEY `idEtiqueta` (`idEtiqueta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcar la base de datos para la tabla `valoresindicadores`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `desgloces_indicadores`
--
ALTER TABLE `desgloces_indicadores`
  ADD CONSTRAINT `desgloces_indicadores_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `desgloces_indicadores_ibfk_2` FOREIGN KEY (`idDesgloce`) REFERENCES `desgloces` (`id`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `valoresindicadores`
--
ALTER TABLE `valoresindicadores`
  ADD CONSTRAINT `valoresindicadores_ibfk_2` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`),
  ADD CONSTRAINT `valoresindicadores_ibfk_1` FOREIGN KEY (`idRefGeografica`) REFERENCES `refgeografica` (`id`);
