-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `img` varchar(300) NOT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `comentario_blog`;
CREATE TABLE `comentario_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `texto` varchar(300) NOT NULL,
  `id_entrada_blog` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_entrada_blog` (`id_entrada_blog`),
  CONSTRAINT `comentario_blog_ibfk_1` FOREIGN KEY (`id_entrada_blog`) REFERENCES `entrada_blog` (`id_ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `contacto`;
CREATE TABLE `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `identificacion` varchar(300) NOT NULL,
  `mensaje` mediumtext NOT NULL,
  `borrado` int(1) NOT NULL DEFAULT 0,
  `visto` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `entrada_blog`;
CREATE TABLE `entrada_blog` (
  `id_ent` int(11) NOT NULL AUTO_INCREMENT,
  `lenguaje` char(2) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `creador` varchar(100) NOT NULL,
  `imagen_central` varchar(300) NOT NULL,
  `foto_footer` longtext NOT NULL,
  `texto` longtext NOT NULL,
  `borrado` char(1) NOT NULL DEFAULT '0',
  `aprob` char(1) NOT NULL DEFAULT '0',
  `id_login` int(11) NOT NULL,
  `token` char(6) NOT NULL,
  PRIMARY KEY (`id_ent`),
  KEY `id_login` (`id_login`),
  CONSTRAINT `entrada_blog_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(16) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `token` char(6) NOT NULL,
  `activo` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `login` (`id`, `usuario`, `hash`, `mail`, `token`, `activo`) VALUES
(1,	'prueba',	'$2y$10$z4KNwbxDcEtOYyTjpyb2iOHw9cxED7HEqOprvY9pfzpqwRIMbwTPm',	'',	'123456',	'1');

DROP TABLE IF EXISTS `parrafo_blog`;
CREATE TABLE `parrafo_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `id_entrada_blog` int(11) NOT NULL,
  `sub_titulo` varchar(300) NOT NULL,
  `imagen_parrafo` varchar(300) DEFAULT NULL,
  `texto` longtext NOT NULL,
  `tiempo` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_entrada_blog` (`id_entrada_blog`),
  CONSTRAINT `parrafo_blog_ibfk_1` FOREIGN KEY (`id_entrada_blog`) REFERENCES `entrada_blog` (`id_ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_login` int(11) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `apellidos` varchar(300) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `id_login` (`id_login`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuario` (`id`, `id_login`, `nombres`, `apellidos`, `tipo`, `activo`) VALUES
(1,	1,	'Jose Manuel',	'Garcia Garcia',	'admin',	1);

-- 2020-11-21 21:25:44