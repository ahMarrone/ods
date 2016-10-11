-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-10-2016 a las 19:38:17
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5
drop database IF EXISTS `indicadores_ods`;
create database `indicadores_ods`;
use indicadores_ods;
--
-- base de datos ods
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=0;

--
-- Volcar la base de datos para la tabla `desgloces`
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
-- RELACIONES PARA LA TABLA `etiquetas`:
--   `fk_id_desgloce`
--       `desgloces` -> `id_desgloce`
--

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
  `visibleNacional` varchar(1) NOT NULL COMMENT 'Visibilidad del indicador a nivel Nacional',
  `visibleProvincial` varchar(1) NOT NULL COMMENT 'Visibilidad del indicador a nivel Provincial',
  `visibleMunicipio` varchar(1) NOT NULL COMMENT 'Visibilidad del indicador a nivel Municipal',
  PRIMARY KEY (`id`),
  KEY `fkIdMeta` (`fkIdMeta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- RELACIONES PARA LA TABLA `indicadores`:
--   `fk_id_meta`
--       `metas` -> `id_meta`
--

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
-- RELACIONES PARA LA TABLA `metas`:
--   `fk_id_objetivo`
--       `objetivos` -> `id_objetivo`
--

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
-- Estructura de tabla para la tabla `ref_geografica`
--

DROP TABLE IF EXISTS `refGeografica`;
CREATE TABLE IF NOT EXISTS `refGeografica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  `agrupa` int(10) unsigned NOT NULL COMMENT 'id de la ref. geogr. por la cual es agrupada',
  PRIMARY KEY (`id`),
  KEY `agrupa` (`agrupa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- RELACIONES PARA LA TABLA `ref_geografica`:
--   `agrupa`
--       `ref_geografica` -> `id_refgeografica`
--

--
-- Volcar la base de datos para la tabla `ref_geografica`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_indicadores`
--

DROP TABLE IF EXISTS `valoresIndicadores`;
CREATE TABLE IF NOT EXISTS `valoresIndicadores` (
  `idIndicador` int(10) unsigned NOT NULL,
  `idEtiqueta` int(10) unsigned NOT NULL,
  `idRefGeografica` int(10) unsigned NOT NULL,
  `anio` year(4) NOT NULL,
  `mes` tinyint(3) unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idIndicador`,`idEtiqueta`,`idRefGeografica`),
  KEY `idEtiqueta` (`idEtiqueta`),
  KEY `idRefGeografica` (`idRefGeografica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELACIONES PARA LA TABLA `valores_indicadores`:
--   `id_refgeografica`
--       `ref_geografica` -> `id_refgeografica`
--   `id_indicador`
--       `indicadores` -> `id_indicador`
--   `id_etiqueta`
--       `etiquetas` -> `id_etiqueta`
--

--
-- Volcar la base de datos para la tabla `valores_indicadores`
--


--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`fkIdDesgloce`) REFERENCES `desgloces` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`fkIdMeta`) REFERENCES `metas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`fkIdObjetivo`) REFERENCES `objetivos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `valores_indicadores`
--
ALTER TABLE `valoresIndicadores`
  ADD CONSTRAINT `valoresIndicadores_ibfk_3` FOREIGN KEY (`idRefGeografica`) REFERENCES `refGeografica` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `valoresIndicadores_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `valoresIndicadores_ibfk_2` FOREIGN KEY (`idEtiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
