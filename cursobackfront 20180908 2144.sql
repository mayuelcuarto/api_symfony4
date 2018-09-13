-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.7.14


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema curso_backfront
--

CREATE DATABASE IF NOT EXISTS curso_backfront;
USE curso_backfront;

--
-- Definition of table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `status` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tasks_users_idx` (`user_id`),
  CONSTRAINT `fk_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`,`user_id`,`title`,`description`,`status`,`created_at`,`updated_at`) VALUES 
 (1,1,'Tarea 1','Descripción de la primera tarea','todo','2018-01-26 02:18:14','2018-01-26 02:18:14'),
 (2,1,'Tarea 2 modificada','Descripción de la segunda tarea','new','2018-01-26 11:24:30','2018-07-07 15:55:51'),
 (3,34,'Nueva tarea','info random','todo','2018-06-25 17:04:39','2018-08-19 23:50:32'),
 (4,34,'Nueva tarea 2','Info random','finished','2018-06-25 17:07:07','2018-08-19 23:50:25'),
 (5,34,'Nueva tarea 3','prueba de info','todo','2018-06-25 17:10:11','2018-06-25 17:10:11'),
 (6,34,'Nueva tarea 4','fsdfsfsd','new','2018-06-25 17:14:26','2018-06-25 17:14:26'),
 (7,34,'Nueva tarea 5','fsjfhskdhfkjs','new','2018-06-25 17:15:59','2018-06-25 17:15:59'),
 (8,34,'Nueva tarea 6','dfsdfsfs','new','2018-06-25 17:16:45','2018-06-25 17:16:45'),
 (9,34,'Nueva tarea 7','prueba de info','todo','2018-06-25 17:18:58','2018-06-25 17:18:58'),
 (10,34,'Nueva tarea 8','adasd','todo','2018-06-26 15:49:30','2018-06-26 15:49:30'),
 (11,34,'Nueva tarea 9','nueva tarea','finished','2018-06-26 15:49:46','2018-06-26 15:49:46'),
 (13,34,'Nueva tarea 11','aasdasdasd','finished','2018-06-26 15:50:16','2018-06-26 15:50:16'),
 (14,34,'Tarea 12','tarea importante','todo','2018-06-26 16:32:43','2018-06-26 16:32:43'),
 (16,34,'Esta tarea está modificada 1','Correcta','todo','2018-07-02 18:17:15','2018-07-06 22:29:30'),
 (17,1,'Tarea 3','Prueba de tarea','finished','2018-08-19 22:54:46','2018-08-19 22:54:52');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(180) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`role`,`name`,`surname`,`email`,`password`,`created_at`) VALUES 
 (1,'user','Admin','Admin','admin@admin.com','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','2018-01-25 03:26:46'),
 (4,'user','Admin 1','Admin 1','admin1@admin.com','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','2018-01-25 03:36:32'),
 (23,'user','Admin 5','Admin 5','admin5@admin.com','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','2018-04-14 03:49:13'),
 (24,'user','Admin 6','Admin 6','admin6@admin.com','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','2018-04-14 05:05:31'),
 (29,'user','David','Lopes','david@david.com','07d046d5fac12b3f82daf5035b9aae86db5adc8275ebfbf05ec83005a4a8ba3e','2018-06-20 19:07:29'),
 (30,'user','Juan','Lopes','juan@juan.com','ed08c290d7e22f7bb324b15cbadce35b0b348564fd2d5f95752388d86d71bcca','2018-06-20 19:10:06'),
 (33,'user','Jesus','Lopez','jesus@jesus.com','a54e71f0e17f5aaf7946e66ab42cf3b1fd4e61d60581736c9f0eb1c3f794eb7c','2018-06-20 19:15:12'),
 (34,'user','Salvador','Lopez','salva@salva.com','6f63d3537f7c1e437226835ff8d398d5889a12e316338c58019a6b0b37006bc5','2018-06-20 19:17:06');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
