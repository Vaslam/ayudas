-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2014 at 08:34 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adminpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` varchar(4) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`) VALUES
(1, 'COL', 'Amazonas'),
(2, 'COL', 'Antioquia'),
(3, 'COL', 'Arauca'),
(4, 'COL', 'Atlántico'),
(5, 'COL', 'Bolívar'),
(6, 'COL', 'Boyacá'),
(7, 'COL', 'Caldas'),
(8, 'COL', 'Caquetá'),
(9, 'COL', 'Casanare'),
(10, 'COL', 'Cauca'),
(11, 'COL', 'Cesar'),
(12, 'COL', 'Chocó'),
(13, 'COL', 'Córdoba'),
(14, 'COL', 'Cundinamarca'),
(15, 'COL', 'Güainia'),
(16, 'COL', 'Guaviare'),
(17, 'COL', 'Huila'),
(18, 'COL', 'La Guajira'),
(19, 'COL', 'Magdalena'),
(20, 'COL', 'Meta'),
(21, 'COL', 'Nariño'),
(22, 'COL', 'Norte de Santander'),
(23, 'COL', 'Putumayo'),
(24, 'COL', 'Quindío'),
(25, 'COL', 'Risaralda'),
(26, 'COL', 'San Andrés y Providencia'),
(27, 'COL', 'Santander'),
(28, 'COL', 'Sucre'),
(29, 'COL', 'Tolima'),
(30, 'COL', 'Valle del Cauca'),
(31, 'COL', 'Vaupés'),
(32, 'COL', 'Vichada');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
