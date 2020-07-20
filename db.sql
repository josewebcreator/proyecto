-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `proyecto` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `proyecto`;

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
  `lenguaje` char(2) NOT NULL,
  `email` varchar(50) NOT NULL,
  `solicitud` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `entrada_blog`;
CREATE TABLE `entrada_blog` (
  `id_ent` int(11) NOT NULL AUTO_INCREMENT,
  `lenguaje` char(2) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `imagen_central` varchar(300) NOT NULL,
  `foto_footer` longtext NOT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id_ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(16) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `token` char(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `parrafo_blog`;
CREATE TABLE `parrafo_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `id_entrada_blog` int(11) NOT NULL,
  `sub_titulo` varchar(300) NOT NULL,
  `imagen_parrafo` varchar(300) DEFAULT NULL,
  `texto` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_entrada_blog` (`id_entrada_blog`),
  CONSTRAINT `parrafo_blog_ibfk_1` FOREIGN KEY (`id_entrada_blog`) REFERENCES `entrada_blog` (`id_ent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2020-07-20 00:26:00