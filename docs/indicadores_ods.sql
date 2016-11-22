-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2016 at 03:18 PM
-- Server version: 5.5.52-0+deb8u1
-- PHP Version: 5.6.27-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `indicadores_ods`
--
drop database IF EXISTS `indicadores_ods`;
create database `indicadores_ods`;
use indicadores_ods;

-- --------------------------------------------------------

--
-- Table structure for table `agrupamientoRefGeografica`
--

CREATE TABLE IF NOT EXISTS `agrupamientoRefGeografica` (
  `id_1` int(11) unsigned NOT NULL,
  `id_2` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `desgloces`
--

CREATE TABLE IF NOT EXISTS `desgloces` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del desgloce'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `desglocesIndicadores`
--

CREATE TABLE IF NOT EXISTS `desglocesIndicadores` (
  `id` int(11) unsigned NOT NULL,
  `idIndicador` int(11) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `desgloces` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cruzado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `desglocesSeleccionados`
--

CREATE TABLE IF NOT EXISTS `desglocesSeleccionados` (
  `idDesgloce` int(10) unsigned NOT NULL,
  `idDesglocesIndicadores` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `etiquetas`
--

CREATE TABLE IF NOT EXISTS `etiquetas` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la etiqueta',
  `fkIdDesgloce` int(11) unsigned NOT NULL COMMENT 'clave foranea desgloce'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `indicadores`
--

CREATE TABLE IF NOT EXISTS `indicadores` (
`id` int(11) unsigned NOT NULL,
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
  `fechasDestacadas` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE IF NOT EXISTS `metas` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la meta',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL,
  `fkIdObjetivo` int(11) unsigned NOT NULL COMMENT 'clave foranea tabla objetivos',
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion del objtivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refGeografica`
--

CREATE TABLE IF NOT EXISTS `refGeografica` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(5000) COLLATE utf8_spanish_ci NOT NULL COMMENT 'descripcion de la referencia geografica',
  `ambito` enum('N','P','D','L','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'ambito de la ref. geografica'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) unsigned NOT NULL,
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
  `credentials_expire_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuariosRefGeografica`
--

CREATE TABLE IF NOT EXISTS `usuariosRefGeografica` (
  `id_usuario` int(11) unsigned NOT NULL,
  `id_refGeografica` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `valoresIndicadores`
--

CREATE TABLE IF NOT EXISTS `valoresIndicadores` (
  `idDesglocesIndicadores` int(11) unsigned NOT NULL,
  `idEtiqueta` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Clave en formato string que representa el cruce de etuqietas del registro',
  `idRefGeografica` int(11) unsigned NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `aprobado` tinyint(1) NOT NULL,
  `idUsuario` int(11) unsigned NOT NULL,
  `fechaModificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agrupamientoRefGeografica`
--
ALTER TABLE `agrupamientoRefGeografica`
 ADD PRIMARY KEY (`id_1`,`id_2`), ADD KEY `refGeografica_ibfk_2` (`id_2`);

--
-- Indexes for table `desgloces`
--
ALTER TABLE `desgloces`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desglocesIndicadores`
--
ALTER TABLE `desglocesIndicadores`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `desglocesIndicadores_uniq_1` (`idIndicador`,`fecha`);

--
-- Indexes for table `desglocesSeleccionados`
--
ALTER TABLE `desglocesSeleccionados`
 ADD PRIMARY KEY (`idDesgloce`,`idDesglocesIndicadores`), ADD KEY `desglocesSeleccionados_ibfk_2` (`idDesglocesIndicadores`);

--
-- Indexes for table `etiquetas`
--
ALTER TABLE `etiquetas`
 ADD PRIMARY KEY (`id`), ADD KEY `fkIdDesgloce` (`fkIdDesgloce`);

--
-- Indexes for table `indicadores`
--
ALTER TABLE `indicadores`
 ADD PRIMARY KEY (`id`), ADD KEY `fkIdMeta` (`fkIdMeta`), ADD KEY `ndxUsuario` (`idUsuario`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
 ADD PRIMARY KEY (`id`), ADD KEY `fkIdObjetivo` (`fkIdObjetivo`), ADD KEY `ndxUsuario` (`idUsuario`);

--
-- Indexes for table `objetivos`
--
ALTER TABLE `objetivos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refGeografica`
--
ALTER TABLE `refGeografica`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`), ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`), ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Indexes for table `usuariosRefGeografica`
--
ALTER TABLE `usuariosRefGeografica`
 ADD PRIMARY KEY (`id_usuario`,`id_refGeografica`), ADD KEY `usuariosRefGeografica_ibfk_2` (`id_refGeografica`);

--
-- Indexes for table `valoresIndicadores`
--
ALTER TABLE `valoresIndicadores`
 ADD PRIMARY KEY (`idDesglocesIndicadores`,`idRefGeografica`,`idEtiqueta`), ADD KEY `idDesglocesIndicadoresndicadores` (`idDesglocesIndicadores`), ADD KEY `idRefGeografica` (`idRefGeografica`), ADD KEY `idEtiqueta` (`idEtiqueta`), ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `desgloces`
--
ALTER TABLE `desgloces`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `etiquetas`
--
ALTER TABLE `etiquetas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `indicadores`
--
ALTER TABLE `indicadores`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `objetivos`
--
ALTER TABLE `objetivos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `refGeografica`
--
ALTER TABLE `refGeografica`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `agrupamientoRefGeografica`
--
ALTER TABLE `agrupamientoRefGeografica`
ADD CONSTRAINT `refGeografica_ibfk_1` FOREIGN KEY (`id_1`) REFERENCES `refGeografica` (`id`),
ADD CONSTRAINT `refGeografica_ibfk_2` FOREIGN KEY (`id_2`) REFERENCES `refGeografica` (`id`);

--
-- Constraints for table `desglocesIndicadores`
--
ALTER TABLE `desglocesIndicadores`
ADD CONSTRAINT `desglocesIndicadores_ibfk_1` FOREIGN KEY (`idIndicador`) REFERENCES `indicadores` (`id`);

--
-- Constraints for table `desglocesSeleccionados`
--
ALTER TABLE `desglocesSeleccionados`
ADD CONSTRAINT `desglocesSeleccionados_ibfk_2` FOREIGN KEY (`idDesglocesIndicadores`) REFERENCES `desgloces` (`id`),
ADD CONSTRAINT `desglocesSeleccionados_ibfk_1` FOREIGN KEY (`idDesgloce`) REFERENCES `desglocesIndicadores` (`id`);

--
-- Constraints for table `etiquetas`
--
ALTER TABLE `etiquetas`
ADD CONSTRAINT `etiquetas_ibfk_1` FOREIGN KEY (`fkIdDesgloce`) REFERENCES `desgloces` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `indicadores`
--
ALTER TABLE `indicadores`
ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`fkIdMeta`) REFERENCES `metas` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `indicadores_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `metas`
--
ALTER TABLE `metas`
ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`fkIdObjetivo`) REFERENCES `objetivos` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `metas_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `usuariosRefGeografica`
--
ALTER TABLE `usuariosRefGeografica`
ADD CONSTRAINT `usuariosRefGeografica_ibfk_2` FOREIGN KEY (`id_refGeografica`) REFERENCES `refGeografica` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `usuariosRefGeografica_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `valoresIndicadores`
--
ALTER TABLE `valoresIndicadores`
ADD CONSTRAINT `valoresIndicadores_ibfk_1` FOREIGN KEY (`idDesglocesIndicadores`) REFERENCES `desglocesIndicadores` (`id`),
ADD CONSTRAINT `valoresIndicadores_ibfk_2` FOREIGN KEY (`idRefGeografica`) REFERENCES `refGeografica` (`id`),
ADD CONSTRAINT `valoresIndicadores_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
