-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-12-2016 a las 11:30:41
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

--
-- Volcado de datos para la tabla `desgloces`
--

INSERT INTO `desgloces` (`id`, `descripcion`) VALUES
(0, 'Sin desgloce'),
(1, 'Sexo'),
(2, 'Rango edad 1'),
(3, 'Ubicacion');

--
-- Volcado de datos para la tabla `desglocesIndicadores`
--

INSERT INTO `desglocesIndicadores` (`idIndicador`, `idDesgloce`) VALUES
(1, 0),
(1, 1),
(1, 2),
(1, 3);

--
-- Volcado de datos para la tabla `etiquetas`
--

INSERT INTO `etiquetas` (`id`, `descripcion`, `fkIdDesgloce`) VALUES
(0, 'Sin etiqueta', 0),
(1, 'Femenino', 1),
(2, 'Masculino', 1),
(3, '0-18', 2),
(4, '19-30', 2),
(5, '>30', 2),
(6, 'Urbano', 3),
(7, 'Rural', 3);

--
-- Volcado de datos para la tabla `valoresIndicadores`
--

INSERT INTO `valoresIndicadores` (`idValoresIndicadoresConfigFecha`, `idEtiqueta`, `idRefGeografica`, `valor`, `aprobado`, `idUsuario`, `fechaModificacion`) VALUES
(1, '0', 1, 27.30, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 2, 41.50, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 3, 19.70, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 4, 18.40, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 5, 32.60, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 6, 40.60, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 7, 44.70, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 8, 25.20, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 9, 44.20, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 10, 24.50, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 11, 48.20, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 12, 27.00, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 13, 49.20, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 14, 28.80, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 15, 42.90, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 16, 35.50, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 17, 10.90, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 18, 32.90, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 19, 33.90, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 20, 40.70, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 21, 36.80, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 22, 24.40, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 23, 16.40, 1, 1, '0000-00-00 00:00:00'),
(1, '0', 24, 26.90, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 1, 37.10, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 1, 10.80, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 1, 18.50, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 1, 22.90, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 2, 39.30, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 2, 45.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 2, 39.40, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 2, 31.50, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 3, 48.00, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 3, 11.80, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 3, 42.90, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 3, 27.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 4, 25.40, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 4, 43.50, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 4, 49.20, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 4, 31.10, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 5, 28.80, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 5, 49.60, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 5, 29.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 5, 30.10, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 6, 26.20, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 6, 14.80, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 6, 29.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 6, 42.90, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 7, 22.10, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 7, 30.30, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 7, 41.80, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 7, 22.50, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 8, 28.60, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 8, 33.90, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 8, 43.80, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 8, 17.30, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 9, 45.90, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 9, 25.60, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 9, 45.90, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 9, 14.70, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 10, 37.50, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 10, 45.70, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 10, 24.40, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 10, 36.10, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 11, 47.20, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 11, 15.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 11, 35.80, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 11, 13.50, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 12, 14.10, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 12, 48.20, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 12, 14.90, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 12, 18.10, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 13, 37.70, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 13, 41.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 13, 16.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 13, 33.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 14, 44.50, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 14, 35.70, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 14, 36.10, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 14, 14.00, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 15, 34.70, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 15, 46.50, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 15, 11.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 15, 47.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 16, 28.30, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 16, 33.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 16, 10.80, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 16, 15.60, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 17, 13.80, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 17, 35.50, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 17, 25.00, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 17, 37.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 18, 15.60, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 18, 33.10, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 18, 23.20, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 18, 44.50, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 19, 40.40, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 19, 34.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 19, 25.40, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 19, 49.70, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 20, 23.40, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 20, 38.40, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 20, 33.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 20, 34.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 21, 11.10, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 21, 35.90, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 21, 47.00, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 21, 21.90, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 22, 25.20, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 22, 15.20, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 22, 19.50, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 22, 26.40, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 23, 30.60, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 23, 20.00, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 23, 18.80, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 23, 20.80, 1, 1, '0000-00-00 00:00:00'),
(2, '1', 24, 27.20, 1, 1, '0000-00-00 00:00:00'),
(2, '2', 24, 43.90, 1, 1, '0000-00-00 00:00:00'),
(2, '6', 24, 34.70, 1, 1, '0000-00-00 00:00:00'),
(2, '7', 24, 44.10, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 1, 41.80, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 1, 33.70, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 1, 37.00, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 1, 24.80, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 1, 42.90, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 2, 16.00, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 2, 21.70, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 2, 42.10, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 2, 23.40, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 2, 43.40, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 3, 18.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 3, 49.60, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 3, 40.60, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 3, 41.60, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 3, 12.00, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 4, 43.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 4, 17.70, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 4, 20.60, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 4, 39.00, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 4, 44.20, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 5, 18.20, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 5, 41.80, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 5, 33.60, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 5, 25.30, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 5, 46.80, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 6, 13.90, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 6, 21.30, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 6, 24.30, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 6, 24.00, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 6, 20.20, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 7, 11.70, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 7, 34.00, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 7, 39.30, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 7, 42.30, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 7, 17.20, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 8, 31.20, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 8, 18.60, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 8, 15.10, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 8, 46.80, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 8, 19.20, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 9, 37.80, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 9, 17.30, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 9, 39.70, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 9, 44.70, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 9, 33.30, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 10, 46.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 10, 26.20, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 10, 10.40, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 10, 20.90, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 10, 48.90, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 11, 40.60, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 11, 45.70, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 11, 47.40, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 11, 47.90, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 11, 17.40, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 12, 42.90, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 12, 31.30, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 12, 24.90, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 12, 49.90, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 12, 41.60, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 13, 18.60, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 13, 45.00, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 13, 17.40, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 13, 45.90, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 13, 39.60, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 14, 23.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 14, 34.50, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 14, 12.60, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 14, 45.20, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 14, 39.70, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 15, 14.70, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 15, 48.90, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 15, 15.20, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 15, 38.20, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 15, 29.70, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 16, 49.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 16, 45.90, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 16, 35.30, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 16, 16.80, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 16, 42.30, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 17, 24.70, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 17, 21.50, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 17, 40.50, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 17, 22.00, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 17, 21.00, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 18, 13.60, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 18, 15.10, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 18, 31.60, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 18, 49.60, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 18, 15.00, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 19, 37.80, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 19, 41.10, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 19, 32.90, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 19, 16.40, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 19, 27.20, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 20, 11.90, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 20, 13.60, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 20, 42.90, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 20, 44.40, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 20, 50.00, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 21, 46.60, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 21, 40.10, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 21, 43.40, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 21, 23.20, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 21, 49.60, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 22, 47.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 22, 17.50, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 22, 13.50, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 22, 17.30, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 22, 28.50, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 23, 13.30, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 23, 14.30, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 23, 24.10, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 23, 37.60, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 23, 38.90, 1, 1, '0000-00-00 00:00:00'),
(3, '3', 24, 42.20, 1, 1, '0000-00-00 00:00:00'),
(3, '4', 24, 29.80, 1, 1, '0000-00-00 00:00:00'),
(3, '5', 24, 45.40, 1, 1, '0000-00-00 00:00:00'),
(3, '6', 24, 29.20, 1, 1, '0000-00-00 00:00:00'),
(3, '7', 24, 30.50, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 1, 18.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 1, 46.70, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 1, 20.30, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 1, 41.10, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 2, 48.40, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 2, 43.30, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 2, 38.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 2, 43.20, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 3, 21.20, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 3, 32.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 3, 30.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 3, 47.10, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 4, 44.30, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 4, 49.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 4, 29.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 4, 41.40, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 5, 24.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 5, 45.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 5, 43.40, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 5, 43.20, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 6, 38.50, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 6, 42.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 6, 31.10, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 6, 49.90, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 7, 13.70, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 7, 34.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 7, 35.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 7, 27.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 8, 35.10, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 8, 42.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 8, 22.40, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 8, 25.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 9, 48.90, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 9, 13.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 9, 10.90, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 9, 28.00, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 10, 41.40, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 10, 40.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 10, 12.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 10, 14.80, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 11, 39.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 11, 26.10, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 11, 15.70, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 11, 23.50, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 12, 22.40, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 12, 12.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 12, 19.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 12, 15.50, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 13, 29.30, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 13, 30.60, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 13, 36.30, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 13, 13.30, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 14, 46.60, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 14, 38.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 14, 21.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 14, 22.70, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 15, 29.40, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 15, 32.10, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 15, 26.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 15, 35.00, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 16, 22.00, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 16, 20.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 16, 46.70, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 16, 40.90, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 17, 28.00, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 17, 41.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 17, 22.10, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 17, 19.00, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 18, 38.80, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 18, 37.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 18, 35.70, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 18, 22.80, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 19, 47.70, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 19, 14.00, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 19, 42.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 19, 41.90, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 20, 10.20, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 20, 19.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 20, 46.60, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 20, 45.70, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 21, 20.80, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 21, 13.10, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 21, 47.90, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 21, 31.10, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 22, 49.10, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 22, 44.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 22, 16.70, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 22, 28.50, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 23, 44.20, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 23, 45.50, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 23, 36.80, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 23, 38.30, 1, 1, '0000-00-00 00:00:00'),
(4, '1:6', 24, 40.30, 1, 1, '0000-00-00 00:00:00'),
(4, '1:7', 24, 36.20, 1, 1, '0000-00-00 00:00:00'),
(4, '2:6', 24, 11.90, 1, 1, '0000-00-00 00:00:00'),
(4, '2:7', 24, 39.20, 1, 1, '0000-00-00 00:00:00');

--
-- Volcado de datos para la tabla `valoresIndicadoresConfigFecha`
--

INSERT INTO `valoresIndicadoresConfigFecha` (`id`, `idIndicador`, `fecha`, `cruzado`) VALUES
(1, 1, '2013-07-03', 0),
(2, 1, '2014-11-04', 0),
(3, 1, '2015-11-02', 0),
(4, 1, '2016-12-05', 1);

--
-- Volcado de datos para la tabla `valoresIndicadoresConfigFechaDesgloces`
--

INSERT INTO `valoresIndicadoresConfigFechaDesgloces` (`idDesgloce`, `idValoresIndicadoresConfigFecha`) VALUES
(0, 1),
(1, 2),
(3, 2),
(2, 3),
(3, 3),
(1, 4),
(3, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
