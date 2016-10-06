-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-10-2016 a las 19:38:17
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

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
  `id_desgloce` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desgloce',
  PRIMARY KEY (`id_desgloce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `desgloces`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
  `id_etiqueta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la etiqueta',
  `fk_id_desgloce` int(10) unsigned NOT NULL COMMENT 'clave foranea desgloce',
  PRIMARY KEY (`id_etiqueta`),
  KEY `fk_id_desgloce` (`fk_id_desgloce`)
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
  `id_indicador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del indicador',
  `fk_id_meta` int(10) unsigned NOT NULL COMMENT 'clave foranea meta',
  `tipo` enum('porcentual','entero','real') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de indicador',
  `val_min` bigint(20) NOT NULL COMMENT 'valor minimo dentro del dominio',
  `val_max` bigint(20) NOT NULL COMMENT 'valor maximo dentro del dominio',
  `ambito` enum('N','P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito al que pertenece el indicador',
  `visibilidad` bit(3) NOT NULL COMMENT 'mascara de visibilidad del indicador',
  PRIMARY KEY (`id_indicador`),
  KEY `id_meta` (`fk_id_meta`)
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
  `id_meta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `fk_id_objetivo` int(10) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  PRIMARY KEY (`id_meta`),
  KEY `fk_id_objetivo` (`fk_id_objetivo`),
  KEY `fk_id_objetivo_2` (`fk_id_objetivo`)
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
  `id_objetivo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo',
  PRIMARY KEY (`id_objetivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `objetivos`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ref_geografica`
--

DROP TABLE IF EXISTS `ref_geografica`;
CREATE TABLE IF NOT EXISTS `ref_geografica` (
  `id_refgeografica` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('P','M') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica',
  `agrupa` int(10) unsigned NOT NULL COMMENT 'id de la ref. geogr. por la cual es agrupada',
  PRIMARY KEY (`id_refgeografica`),
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

DROP TABLE IF EXISTS `valores_indicadores`;
CREATE TABLE IF NOT EXISTS `valores_indicadores` (
  `id_indicador` int(10) unsigned NOT NULL,
  `id_etiqueta` int(10) unsigned NOT NULL,
  `id_refgeografica` int(10) unsigned NOT NULL,
  `anio` year(4) NOT NULL,
  `mes` tinyint(3) unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_indicador`,`id_etiqueta`,`id_refgeografica`),
  KEY `id_etiqueta` (`id_etiqueta`),
  KEY `id_refgeografica` (`id_refgeografica`)
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
  ADD CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`fk_id_desgloce`) REFERENCES `desgloces` (`id_desgloce`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`fk_id_meta`) REFERENCES `metas` (`id_meta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`fk_id_objetivo`) REFERENCES `objetivos` (`id_objetivo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valores_indicadores`
--
ALTER TABLE `valores_indicadores`
  ADD CONSTRAINT `valores_indicadores_ibfk_3` FOREIGN KEY (`id_refgeografica`) REFERENCES `ref_geografica` (`id_refgeografica`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valores_indicadores_ibfk_1` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id_indicador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valores_indicadores_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id_etiqueta`) ON DELETE CASCADE ON UPDATE CASCADE;
