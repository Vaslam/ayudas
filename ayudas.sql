-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2015 at 04:44 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ayudas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `permissionid` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phonenumber` varchar(16) DEFAULT NULL,
  `cellphonenumber` varchar(16) DEFAULT NULL,
  `info` varchar(512) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `permissionid`, `name`, `lastname`, `email`, `phonenumber`, `cellphonenumber`, `info`, `active`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Admin', 'App Web', '', '', '', 'Administrador por defecto. No se puede eliminar, cambiar permiso o desactivar.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `content` text,
  `datemodified` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `description` text,
  `theorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `description`, `theorder`) VALUES
(3, 'Galeria de Prueba', 'Pellentesque ligula ligula, cursus consequat cursus ut, cursus a erat. Aenean auctor scelerisque odio, sit amet porttitor tortor porttitor ut. Nullam justo velit, tristique a arcu ut, laoreet luctus enim. In suscipit lacus sapien, et sodales lectus ultricies id. Proin ornare erat id aliquet consequat. Donec egestas aliquet diam.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque facilisis congue', 0),
(4, 'Segunda GalerÃ­a de Prueba', 'Pellentesque ligula ligula, cursus consequat cursus ut, cursus a erat. Aenean auctor scelerisque odio, sit amet porttitor tortor porttitor ut. Nullam justo velit, tristique a arcu ut, laoreet luctus enim. In suscipit lacus sapien, et sodales lectus ultricies id. Proin ornare erat id aliquet consequat. Donec egestas aliquet diam.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque facilisis congue', 0),
(5, 'Tercera GalerÃ­a', 'Pellentesque ligula ligula, cursus consequat cursus ut, cursus a erat. Aenean auctor scelerisque odio, sit amet porttitor tortor porttitor ut. Nullam justo velit, tristique a arcu ut, laoreet luctus enim. In suscipit lacus sapien, et sodales lectus ultricies id. Proin ornare erat id aliquet consequat. Donec egestas aliquet diam.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque facilisis congue', 0),
(6, 'Que bonita galerÃ­a!', 'Pellentesque ligula ligula, cursus consequat cursus ut, cursus a erat. Aenean auctor scelerisque odio, sit amet porttitor tortor porttitor ut. Nullam justo velit, tristique a arcu ut, laoreet luctus enim. In suscipit lacus sapien, et sodales lectus ultricies id. Proin ornare erat id aliquet consequat. Donec egestas aliquet diam.\r\n\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus scelerisque facilisis congue', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `content` text,
  `default` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `default`) VALUES
(1, 'Home - Video', '<iframe width="100%" height="480" src="https://www.youtube.com/embed/EOcVvy1mcYI" frameborder="0" allowfullscreen></iframe>', 1),
(2, 'Pie de Pagina', '<table style="margin: 0 auto;">\r\n	<tbody>\r\n		<tr>\r\n			<td style="vertical-align: middle;"><img src="http://localhost/ayudas/img/White-logo.png" style="width: 200px;" td="" /></td>\r\n			<td style="vertical-align: middle; text-align: left; padding-left: 10px;">\r\n			<p style="font-size: 13pt; margin-top: 13px;">Tel&eacute;fonos: 01 8000 354 54 10<br />\r\n			Correo: info@ayudasparatodos.org</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productcategories`
--

CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `content` text,
  `theorder` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `productcategories`
--

INSERT INTO `productcategories` (`id`, `category`, `title`, `content`, `theorder`, `active`) VALUES
(1, 0, 'Categoria de Prueba', '<p>Nullam eu placerat odio. Cras imperdiet tortor at aliquam placerat. Duis id libero elementum, aliquet ligula ac, facilisis purus. Pellentesque ut est cursus, pulvinar dui quis, facilisis felis. Cras auctor ante et eros tincidunt sollicitudin.</p>\r\n\r\n<p>In et accumsan sem, et dapibus turpis. Aliquam tincidunt et sem rhoncus tincidunt. Nulla facilisi. Donec felis lacus, commodo eu lorem sit amet, tempor volutpat orci.&nbsp;</p>\r\n', 0, 1),
(2, 0, 'Segunda CategorÃ­a de Prueba', '<p>Cras tempus fringilla nunc et suscipit. Suspendisse interdum eget arcu ut fringilla. Morbi posuere tortor vitae pretium ultrices. Fusce porttitor, quam et sollicitudin imperdiet, neque ligula molestie nibh, at fermentum nisi magna sed neque. Nam condimentum turpis ut urna pulvinar, et blandit leo accumsan. Morbi ut vehicula dui. Etiam feugiat libero sit amet nisi iaculis, quis ullamcorper metus hendrerit.</p>\r\n\r\n<p>Integer dictum viverra felis, at sagittis sem efficitur a.</p>\r\n', 0, 1),
(3, 0, 'Tercera CategorÃ­a', '<p>Cras tempus fringilla nunc et suscipit. Suspendisse interdum eget arcu ut fringilla. Morbi posuere tortor vitae pretium ultrices. Fusce porttitor, quam et sollicitudin imperdiet, neque ligula molestie nibh, at fermentum nisi magna sed neque. Nam condimentum turpis ut urna pulvinar, et blandit leo accumsan. Morbi ut vehicula dui. Etiam feugiat libero sit amet nisi iaculis, quis ullamcorper metus hendrerit.</p>\r\n\r\n<p>Integer dictum viverra felis, at sagittis sem efficitur a.</p>\r\n', 0, 1),
(4, 0, 'Cuarta CategorÃ­a de Prueba', '<p>Cras tempus fringilla nunc et suscipit. Suspendisse interdum eget arcu ut fringilla. Morbi posuere tortor vitae pretium ultrices. Fusce porttitor, quam et sollicitudin imperdiet, neque ligula molestie nibh, at fermentum nisi magna sed neque. Nam condimentum turpis ut urna pulvinar, et blandit leo accumsan. Morbi ut vehicula dui. Etiam feugiat libero sit amet nisi iaculis, quis ullamcorper metus hendrerit.</p>\r\n\r\n<p>Integer dictum viverra felis, at sagittis sem efficitur a.</p>\r\n', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(128) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `content` text,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `repositories`
--

CREATE TABLE IF NOT EXISTS `repositories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `content` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
