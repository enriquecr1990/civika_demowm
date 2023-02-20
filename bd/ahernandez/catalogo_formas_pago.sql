-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-06-2019 a las 18:17:06
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
-- Estructura de tabla para la tabla `catalogo_formas_pago`
--

DROP TABLE IF EXISTS `catalogo_formas_pago`;
CREATE TABLE IF NOT EXISTS `catalogo_formas_pago` (
  `id_catalogo_formas_pago` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuenta` varchar(100) DEFAULT NULL COMMENT 'almacena el numero de cuenta para realizar los depositos de los pagos',
  `numero_tarjeta` varchar(20) DEFAULT NULL COMMENT 'almacena el numero de tarjeta donde se haran los depositos de las formas de pago',
  `clabe` varchar(45) DEFAULT NULL COMMENT 'numero cuental clabe interbancaria',
  `sucursal` varchar(45) DEFAULT NULL,
  `banco` varchar(250) NOT NULL COMMENT 'nombre del banco',
  `titular` varchar(250) DEFAULT NULL COMMENT 'titular de la cuenta',
  `descripcion_pago_externo` varchar(1500) DEFAULT NULL COMMENT 'una descripción de un pago externo',
  `titulo_pago` varchar(1500) DEFAULT NULL,
  PRIMARY KEY (`id_catalogo_formas_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `catalogo_formas_pago`
--

INSERT INTO `catalogo_formas_pago` (`id_catalogo_formas_pago`, `cuenta`, `numero_tarjeta`, `clabe`, `sucursal`, `banco`, `titular`, `descripcion_pago_externo`, `titulo_pago`) VALUES
(3, '', '4741763000420520', '', '', 'HSBC', '', 'Depósito OXXO', 'Deposito OXXO'),
(7, '4054631999', '', '', '', 'HSBC ', 'CIVIKA HOLDING LATINOAMERICA, S.A. DE C.V. ', NULL, 'Depósito Bancario:'),
(8, '4054631999', '', '021832040546319996', '', 'HSBC', 'CIVIKA HOLDING LATINOAMERICA, S.A. DE C.V. ', NULL, 'Transferencia Bancaria:');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
