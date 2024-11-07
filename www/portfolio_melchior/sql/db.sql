CREATE DATABASE IF NOT EXISTS `portfolio_melchior`;

USE `portfolio_melchior`;

CREATE TABLE IF NOT EXISTS `t_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `main_name` varchar(255) NOT NULL,
  `title_bio` varchar(255) NOT NULL,
  `description_bio` text NOT NULL,
  `image_bio` varchar(255) NOT NULL,
  `video_bio` varchar(255) NOT NULL,
  `title_artwork` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_filter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_filter` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `t_artwork` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `main_image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `image_1` varchar(255) NOT NULL,
  `image_2` varchar(255) NOT NULL,
  `image_3` varchar(255) NOT NULL,
  `audio_artwork` varchar(500) NULL,
  `id_filter` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_filter`) REFERENCES `t_filter`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
