-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.42 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for blaze-tours_db
CREATE DATABASE IF NOT EXISTS `blaze-tours_db` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `blaze-tours_db`;

-- Dumping structure for table blaze-tours_db.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_status1_idx` (`status_id`),
  CONSTRAINT `fk_admin_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `email`, `password`, `status_id`) VALUES
	(1, 'admin@blaze-tours.com', 'Blaze@2025', 1);

-- Dumping structure for table blaze-tours_db.booking
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `numberOfCount` int DEFAULT NULL,
  `status_id` int NOT NULL,
  `tour_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meditation_status1_idx` (`status_id`),
  KEY `fk_booking_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_booking_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`),
  CONSTRAINT `fk_meditation_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.booking: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact1` varchar(45) NOT NULL,
  `contact2` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `copywrite` text NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `insta` varchar(255) NOT NULL,
  `yt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.company: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.gallary
CREATE TABLE IF NOT EXISTS `gallary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tour_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallary_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_gallary_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.gallary: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.highlight
CREATE TABLE IF NOT EXISTS `highlight` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.highlight: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.idx_highlight
CREATE TABLE IF NOT EXISTS `idx_highlight` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `highlight_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idx_highlight_tour1_idx` (`tour_id`),
  KEY `fk_idx_highlight_highlight1_idx` (`highlight_id`),
  CONSTRAINT `fk_idx_highlight_highlight1` FOREIGN KEY (`highlight_id`) REFERENCES `highlight` (`id`),
  CONSTRAINT `fk_idx_highlight_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.idx_highlight: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.idx_time
CREATE TABLE IF NOT EXISTS `idx_time` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tour_id` int NOT NULL,
  `time_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idx_time_tour1_idx` (`tour_id`),
  KEY `fk_idx_time_time1_idx` (`time_id`),
  CONSTRAINT `fk_idx_time_time1` FOREIGN KEY (`time_id`) REFERENCES `time` (`id`),
  CONSTRAINT `fk_idx_time_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.idx_time: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.location
CREATE TABLE IF NOT EXISTS `location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `address` text,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `icon_url` text,
  `description` text,
  `stop-duration_time` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.location: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.logo
CREATE TABLE IF NOT EXISTS `logo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `company_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logo_company1_idx` (`company_id`),
  CONSTRAINT `fk_logo_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.logo: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.massage
CREATE TABLE IF NOT EXISTS `massage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `massage` text NOT NULL,
  `dateTime` datetime NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_massage_status1_idx` (`status_id`),
  CONSTRAINT `fk_massage_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.massage: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.rating_star
CREATE TABLE IF NOT EXISTS `rating_star` (
  `id` int NOT NULL AUTO_INCREMENT,
  `star` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.rating_star: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.shorts
CREATE TABLE IF NOT EXISTS `shorts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table blaze-tours_db.shorts: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.status: ~2 rows (approximately)
INSERT INTO `status` (`id`, `name`) VALUES
	(1, 'Active'),
	(2, 'De-Active');

-- Dumping structure for table blaze-tours_db.story
CREATE TABLE IF NOT EXISTS `story` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date_time` date NOT NULL,
  `img_url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.story: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.time
CREATE TABLE IF NOT EXISTS `time` (
  `id` int NOT NULL AUTO_INCREMENT,
  `timeslot` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.time: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.tour
CREATE TABLE IF NOT EXISTS `tour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `duration` int DEFAULT NULL,
  `kids_price` double DEFAULT NULL,
  `adult_price` double DEFAULT NULL,
  `maximum_people_count` int DEFAULT NULL,
  `location_id` int NOT NULL,
  `tours_type_id` int NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tour_location1_idx` (`location_id`),
  KEY `fk_tour_tours_type1_idx` (`tours_type_id`),
  KEY `fk_tour_status1_idx` (`status_id`),
  CONSTRAINT `fk_tour_location1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `fk_tour_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_tour_tours_type1` FOREIGN KEY (`tours_type_id`) REFERENCES `tours_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tour: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.tours_type
CREATE TABLE IF NOT EXISTS `tours_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tours_type: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.tour_image
CREATE TABLE IF NOT EXISTS `tour_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `main_image` text,
  `second_image` text,
  `tour_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tour_image_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_tour_image_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tour_image: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `date` datetime NOT NULL,
  `rating_star_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_rating_star_idx` (`rating_star_id`),
  CONSTRAINT `fk_user_rating_star` FOREIGN KEY (`rating_star_id`) REFERENCES `rating_star` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.user: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
