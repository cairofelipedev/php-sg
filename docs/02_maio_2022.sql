/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - sg
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `logs` */

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `data_log` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `logs` */

insert  into `logs`(`id`,`name`,`data_log`,`type`) values 
(1,'admin','2022-04-03 15:48:16','login'),
(2,'admin','2022-04-03 17:32:53','login'),
(3,'admin','2022-04-03 18:28:43','login'),
(4,'admin','2022-04-03 18:36:46','login'),
(5,'admin','2022-04-03 18:39:49','login'),
(6,'admin','2022-04-03 18:40:42','login'),
(7,'admin','2022-04-03 22:46:19','login'),
(8,'admin','2022-04-14 22:26:48','login'),
(9,'admin','2022-04-14 22:50:23','login'),
(10,'admin','2022-04-14 22:59:58','login'),
(11,'admin','2022-04-17 23:13:35','login'),
(12,'admin','2022-04-26 21:59:26','login'),
(13,'admin','2022-04-26 22:21:40','login'),
(14,'admin','2022-04-27 19:35:27','login'),
(15,'admin','2022-05-01 22:16:56','login'),
(16,'admin','2022-05-01 22:27:48','login'),
(17,'admin','2022-05-01 23:20:05','login'),
(18,'admin','2022-05-02 11:28:19','login'),
(19,'admin','2022-05-02 12:30:55','login'),
(20,'admin','2022-05-02 14:27:16','login'),
(21,'admin','2022-05-02 15:05:52','login'),
(22,'admin','2022-05-02 15:06:50','login'),
(23,'admin','2022-05-02 15:13:28','login');

/*Table structure for table `material` */

DROP TABLE IF EXISTS `material`;

CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `data_create` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `material` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL,
  `category_2` varchar(200) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `link_2` varchar(500) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `text_1` text DEFAULT NULL,
  `text_2` varchar(2000) DEFAULT NULL,
  `text_3` varchar(1000) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `img2` varchar(200) DEFAULT NULL,
  `user_create` varchar(200) DEFAULT NULL,
  `data_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(10) DEFAULT NULL,
  `network` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `posts` */

insert  into `posts`(`id`,`title`,`description`,`category`,`category_2`,`link`,`link_2`,`status`,`text_1`,`text_2`,`text_3`,`img`,`img2`,`user_create`,`data_create`,`type`,`network`) values 
(1,'Titulo do post','Descrição do post, text, text, text, text, text, text, text, text',NULL,NULL,'https://instagram.com/cairofelipdev',NULL,'1','Texto principal da postagem',NULL,NULL,NULL,NULL,'Felipe Cairo','2022-05-02 12:29:19','feed','insta'),
(10,'Titulo do post','Descrição do post, text, text, text, text, text, text, text, text',NULL,NULL,'https://instagram.com/cairofelipdev',NULL,'2','Texto principal da postagem',NULL,NULL,NULL,NULL,'Cairo Felipe','2022-05-02 12:29:55','story','face'),
(11,'Titulo do post','Descrição do post, text, text, text, text, text, text, text, text',NULL,NULL,'https://instagram.com/cairofelipdev',NULL,'3','Texto principal da postagem',NULL,NULL,NULL,NULL,'Cairo Felipe','2022-05-02 12:30:28','status','whats');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `whats` varchar(50) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `data_create` timestamp NULL DEFAULT current_timestamp(),
  `address` varchar(200) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `points` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`login`,`email`,`password`,`type`,`whats`,`img`,`data_create`,`address`,`district`,`city`,`state`,`status`,`points`) values 
(1,'admin','sgadmin','admin@admin','12345',1,NULL,NULL,'2022-04-03 15:06:21',NULL,NULL,NULL,NULL,NULL,NULL),
(2,'Cairo Felipe',NULL,NULL,NULL,2,NULL,NULL,'2022-04-26 23:49:23',NULL,NULL,NULL,NULL,'1',100),
(3,'Felipe Cairo',NULL,NULL,NULL,2,NULL,NULL,'2022-04-26 23:49:30',NULL,NULL,NULL,NULL,NULL,50),
(4,'Theo Felipe',NULL,NULL,NULL,2,NULL,NULL,'2022-04-27 22:32:51',NULL,NULL,NULL,NULL,NULL,150);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
