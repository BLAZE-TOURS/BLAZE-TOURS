-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.39 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table blazetuktuk.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_status1_idx` (`status_id`),
  CONSTRAINT `fk_admin_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.idx_time_slot
CREATE TABLE IF NOT EXISTS `idx_time_slot` (
  `id` varchar(45) NOT NULL,
  `time_slots_id` int NOT NULL,
  `toure_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idx_time_slot_time_slots1_idx` (`time_slots_id`),
  KEY `fk_idx_time_slot_toure1_idx` (`toure_id`),
  CONSTRAINT `fk_idx_time_slot_time_slots1` FOREIGN KEY (`time_slots_id`) REFERENCES `time_slots` (`id`),
  CONSTRAINT `fk_idx_time_slot_toure1` FOREIGN KEY (`toure_id`) REFERENCES `toure` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.locations
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `toure_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_locations_toure1_idx` (`toure_id`),
  CONSTRAINT `fk_locations_toure1` FOREIGN KEY (`toure_id`) REFERENCES `toure` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.makers
CREATE TABLE IF NOT EXISTS `makers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.rating_star
CREATE TABLE IF NOT EXISTS `rating_star` (
  `id` int NOT NULL AUTO_INCREMENT,
  `star` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.time_slots
CREATE TABLE IF NOT EXISTS `time_slots` (
  `id` int NOT NULL AUTO_INCREMENT,
  `time_slot` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.toure
CREATE TABLE IF NOT EXISTS `toure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `subtitle` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `adult_price` double NOT NULL,
  `children_price` double NOT NULL,
  `maximum_count` int NOT NULL,
  `toure_type_id` int NOT NULL,
  `datetime_added` datetime NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_toure_toure_type_idx` (`toure_type_id`),
  KEY `fk_toure_status1_idx` (`status_id`),
  CONSTRAINT `fk_toure_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_toure_toure_type` FOREIGN KEY (`toure_type_id`) REFERENCES `toure_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.toure_images
CREATE TABLE IF NOT EXISTS `toure_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint NOT NULL,
  `toure_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_toure_images_toure1_idx` (`toure_id`),
  CONSTRAINT `fk_toure_images_toure1` FOREIGN KEY (`toure_id`) REFERENCES `toure` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.toure_makers
CREATE TABLE IF NOT EXISTS `toure_makers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `makers_id` int NOT NULL,
  `stop_order` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_toure_makers_makers1_idx` (`makers_id`),
  CONSTRAINT `fk_toure_makers_makers1` FOREIGN KEY (`makers_id`) REFERENCES `makers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.toure_type
CREATE TABLE IF NOT EXISTS `toure_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

-- Dumping structure for table blazetuktuk.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `review` text,
  `date` datetime DEFAULT NULL,
  `rating_star_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_rating_star1_idx` (`rating_star_id`),
  CONSTRAINT `fk_user_rating_star1` FOREIGN KEY (`rating_star_id`) REFERENCES `rating_star` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
