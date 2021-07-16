CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `viewed` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urls_url_uindex` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
