CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT NULL,
  `content` text,
  `theorder` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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