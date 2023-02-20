-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-06-2019 a las 18:10:14
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursos_civik`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo_forma_pago_detalle`
--

DROP TABLE IF EXISTS `catalogo_forma_pago_detalle`;
CREATE TABLE IF NOT EXISTS `catalogo_forma_pago_detalle` (
  `id_catalogo_forma_pago_detalle` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id_catalogo_forma_pago_detalle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `catalogo_forma_pago_detalle`
--

INSERT INTO `catalogo_forma_pago_detalle` (`id_catalogo_forma_pago_detalle`, `descripcion`) VALUES
(3, 'EL BOUCHER ORIGINAL DEBERÁ SER ENTREGADO EN RECEPCIÓN AL MOMENTO DE FIRMAR SU INGRESO Y ANTES DE INICIAR SU TALLER.\n\n3, 6 , 9 y 12 meses sin interés en todas las tarjetas de crédito VISA, MASTERCARD, AMERICAN EXPRESS, \nCARNET, UP, SÍ VALE, SODEXO Y EDENRED Puede realizar su pago a meses sin intereses con su tarjeta \nde crédito el día del evento en nuestras instalaciones. No aplican tarjetas de débito ni departamentales.\n\nPago en efectivo el día del evento en nuestras instalaciones: Para realizar su pago antes de tomar su \ncurso, requerimos una vez que haya “realizado el registro de sus datos personales” dé clic en el botón\n“subir su recibo de pago” y suba una foto o imagen escaneada de su INE/IFE o alguna otra identificación  oficial. De esta manera su lugar será apartado y podrá pagar en nuestra recepción antes de iniciar su curso.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
