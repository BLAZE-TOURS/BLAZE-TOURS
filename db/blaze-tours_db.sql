-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.42 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7087
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

-- Dumping data for table blaze-tours_db.admin: ~0 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

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
  `tour_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallary_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_gallary_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.gallary: ~1 rows (approximately)
INSERT INTO `gallary` (`id`, `title`, `url`, `tour_id`) VALUES
	(7, 'ggjv', '../admin/images/gallry/ggjv.jpeg', NULL);

-- Dumping structure for table blaze-tours_db.highlight
CREATE TABLE IF NOT EXISTS `highlight` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.highlight: ~15 rows (approximately)
INSERT INTO `highlight` (`id`, `name`) VALUES
	(10, 'Pickup included'),
	(11, 'Reserve Now & Pay Later Eligible'),
	(12, 'Free Cancellation'),
	(13, 'Reserve now & pay later'),
	(14, 'Lowest price guarantee'),
	(15, 'Private transportation'),
	(16, 'Bottled water'),
	(17, 'Fuel surcharge'),
	(18, 'coconut water'),
	(19, 'WiFI'),
	(20, 'Entry/Admission - Jami Ul-Alfar Mosque'),
	(21, 'Entry/Admission - Viharamahadevi Park'),
	(22, 'Entry/Admission - Colombo Lighthouse'),
	(23, 'entrance fees or ticket not included'),
	(24, 'Lunch or Dinner not included'),
	(25, 'hrthrth');

-- Dumping structure for table blaze-tours_db.idx_highlight
CREATE TABLE IF NOT EXISTS `idx_highlight` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tour_id` int NOT NULL,
  `highlight_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idx_highlight_tour1_idx` (`tour_id`),
  KEY `fk_idx_highlight_highlight1_idx` (`highlight_id`),
  CONSTRAINT `fk_idx_highlight_highlight1` FOREIGN KEY (`highlight_id`) REFERENCES `highlight` (`id`),
  CONSTRAINT `fk_idx_highlight_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.idx_highlight: ~16 rows (approximately)
INSERT INTO `idx_highlight` (`id`, `tour_id`, `highlight_id`) VALUES
	(19, 10, 10),
	(20, 10, 11),
	(21, 10, 12),
	(25, 11, 12),
	(26, 11, 13),
	(27, 11, 14),
	(28, 12, 15),
	(29, 12, 16),
	(30, 12, 17),
	(31, 12, 18),
	(32, 12, 19),
	(33, 12, 20),
	(34, 12, 21),
	(35, 12, 22),
	(36, 12, 23),
	(37, 12, 24),
	(38, 14, 25);

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.idx_time: ~23 rows (approximately)
INSERT INTO `idx_time` (`id`, `tour_id`, `time_id`) VALUES
	(29, 10, 11),
	(30, 10, 12),
	(31, 10, 13),
	(32, 10, 14),
	(33, 10, 15),
	(34, 10, 16),
	(35, 10, 17),
	(36, 10, 18),
	(37, 10, 19),
	(38, 10, 20),
	(41, 11, 13),
	(42, 11, 20),
	(43, 12, 11),
	(44, 12, 12),
	(45, 12, 13),
	(46, 12, 14),
	(47, 12, 15),
	(48, 12, 16),
	(49, 12, 18),
	(50, 12, 19),
	(51, 12, 20),
	(52, 12, 21),
	(53, 12, 22),
	(54, 14, 23);

-- Dumping structure for table blaze-tours_db.location
CREATE TABLE IF NOT EXISTS `location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `address` text,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `icon_url` text,
  `description` text,
  `stop_duration_time` int DEFAULT NULL,
  `tour_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_location_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_location_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.location: ~31 rows (approximately)
INSERT INTO `location` (`id`, `name`, `address`, `lat`, `lng`, `icon_url`, `description`, `stop_duration_time`, `tour_id`) VALUES
	(26, 'Independence Square', '7 Independence Ave, Colombo 00700, Sri Lanka', 6.90476, 79.8672, 'images/marker/icon_686817e11c36c.ico', 'abc', 20, 10),
	(27, 'Gangaramaya Temple', '61 Sri Jinarathana Rd, Colombo 00200, Sri Lanka', 6.91671, 79.8566, 'images/marker/icon_686817e11d7d3.ico', 'abc', 20, 10),
	(28, 'Sri Ponnambalam Middle School', 'kannimaramman, X856+955, Atthanoor Amman Kovil St, Ganapathy Gardens, Ganapathypudur, Coimbatore, Tenkasi, Tamil Nadu 641006, India', 8.95838, 77.3105, 'images/marker/icon_686817e11ed76.ico', 'abc', 20, 10),
	(29, 'Dutch Hospital - Shopping Precinct', 'Hospital St, Colombo 00100, Sri Lanka', 6.93352, 79.8435, 'images/marker/icon_68be6aa0521b6.png', 'The Old Colombo Dutch Hospital is considered to be the oldest building in the Colombo Fort area dating back to the Dutch colonial era in Sri Lanka.', 15, 11),
	(30, 'Jami Ul-Alfar Mosque', '228 2nd Cross Street, Colombo 01100, Sri Lanka', 6.93843, 79.8518, 'images/marker/icon_68be6aa0534b8.png', 'Jami-Ul-Alfar Mosque ( Red Mosque) is a historic mosque in Colombo, Sri Lanka. It is located on Second Cross Street in Pettah. The mosque is one of the oldest mosques in Colombo and a popular tourist site in the city.', 15, 11),
	(31, 'Colombo Fort Old Lighthouse & Clock Tower', 'Janadhipathi Mawatha, Colombo 00100, Sri Lanka', 6.93475, 79.8428, 'images/marker/icon_68be6aa054c50.png', 'Colombo Fort Clock Tower is a clock tower and was a lighthouse in Colombo. The lighthouse is no longer operational, but the tower remains and functions as a clock tower. It is located at the junction of Chatham Street and Janadhipathi Mawatha (formerly Queens Road) in Colombo fort', 10, 11),
	(32, 'Zylen Tea', '33, 3 Perahera Mawatha, Colombo 00300, Sri Lanka', 6.91628, 79.8533, 'images/marker/icon_68be6aa055ff9.png', 'Specialized in retail and wholesale tea, spices and coffee"', 20, 11),
	(33, 'Pettah', 'Pettah, Colombo, Sri Lanka', 6.93679, 79.8525, 'images/marker/icon_68be6aa05740e.png', 'In the heart of Colombo, Sri Lanka, is the madness of Pettah Market. It’s possibly the best place in Colombo to get initiated into the local Sri Lankan hustle and bustle, to ingest the sounds and smells, and to get a flavor of life in Colombo.', 15, 11),
	(34, 'Galle Face Beach', 'Galle Face Beach, Colombo, Sri Lanka', 6.92578, 79.8437, 'images/marker/icon_68be6aa0586e5.png', 'Galle Face is a 5 ha (12 acres) ocean-side urban park, which stretches for 500 m (1,600 ft) along the coast, in the heart of Colombo, the financial and business capital of Sri Lanka. The promenade was initially laid out in 1859 by Governor Sir Henry George Ward, although the original Galle Face Green extended over a much larger area than is seen today. The Galle Face Green was initially used for horse racing and as a golf course, but was also used for cricket, polo, football, tennis and rugby.', 35, 11),
	(35, 'Hotel De Pilawoos', 'Hotel De Pilawoos, No. 21 Galle Rd, Colombo 00400, Sri Lanka', 6.89434, 79.8555, 'images/marker/icon_68be6aa0599d9.png', 'Especially the authentic Sri Lankan kothu', 30, 11),
	(36, 'Port City Colombo', 'Port City Colombo, Sri Lanka', 6.9378, 79.8368, 'images/marker/icon_68be6aa05ab14.png', 'Port City Colombo, (Sinhala: කොළඹ වරාය නගරය, romanised: Koḷam̆ba Warāya Nagaraya) is a multi-services special economic zone located in Colombo, Sri Lanka, which is currently under construction on reclaimed land adjacent to the Galle Face Green. The land reclamation work had been completed as of January 2019. In 2017, the cost was slated to be US$ 15 billion. Port City Colombo is a multi-billion-dollar FDI-funded Public Private Partnership (PPP).', 30, 11),
	(37, 'Sri Kailawasanatan Swami Temple', 'WVV3+2QM, Colombo 01300, Sri Lanka', 6.94258, 79.8544, 'images/marker/icon_68be6aa05be8b.png', 'Located in the heart of Colombo in Maradana, Sri Kaileswaram Kovil in the Captain’s Garden is considered the oldest Sivan Kovil in Colombo. Though the kovil is situated in the centre of Maradana, this is also isolated from all sides with a network of railway tracks and not as easily accessible as you would think. The entrance to Kovil Street is near a popular landmark, the second-hand bookshops of D.R. Wijewardene Mawatha and the road goes over the Fort railway lines and ends at the Kovil grounds.', 10, 11),
	(38, 'Independence Square', '7 Independence Ave, Colombo 00700, Sri Lanka', 6.90416, 79.8676, 'images/marker/icon_68be6aa05d12b.png', 'Independence Memorial Hall (also known as Independence Commemoration Hall) is a national monument in Sri Lanka built for commemoration of the independence of Sri Lanka from the British rule with the restoration of full governing responsibility to a Ceylonese-elected legislature on February 4, 1948. It is located in Independence Square (formerly Torrington Square) in the Cinnamon Gardens, Colombo. It also houses the Independence Memorial Museum. The monument was built at the location where the formal ceremony marking the start of self-rule, with the opening of the first parliament by Prince Henry, Duke of Gloucester occurred at a special podium February 4, 1948.', 15, 11),
	(39, 'Colombo Lighthouse', 'WRPR+G86, Chaithya Rd, Colombo 00100, Sri Lanka', 6.93628, 79.8408, 'images/marker/icon_68be6aa05e70e.png', 'Colombo Lighthouse is a Lighthouse in Colombo in Sri Lanka and it is operated and maintained by the Sri Lanka Ports Authority. It is located at Galbokka Point south of the Port of Colombo on the waterfront along the marine drive, in Colombo fort.', 10, 11),
	(40, 'Colombo Lotus Tower', '320 McCallum Rd, Colombo 01000, Sri Lanka', 6.92704, 79.8583, 'images/marker/icon_68be6aa05fafe.png', 'Lotus Tower (Sinhala: නෙළුම් කුළුණ; Tamil: தாமரைக் கோபுரம்), also referred to as Colombo Lotus Tower, is a 351.5 m (1,153 ft) tall tower, located in Colombo, Sri Lanka.[1][2] It has been called a symbolic landmark of Sri Lanka.[3] As of 2019, the tower is the tallest self-supported structure in South Asia; the second tallest structure in South Asia after the guy-wire-supported INS Kattabomman in India; the 11th tallest tower in Asia and the 19th tallest tower in the world.[3][4] It was first proposed to be built in the suburb of Peliyagoda but later the Government of Sri Lanka decided to change the location.[5] The lotus-shaped tower is used for communication, observation and other leisure facilities. Construction is estimated to have cost US$113 million.[6]', 15, 11),
	(41, 'Pilawoos - Kollupitiya', '417 Galle - Colombo Rd, Colombo, Sri Lanka', 6.90196, 79.8529, 'images/marker/icon_68be6aa060cc3.png', 'Rotti and Sambol', 15, 11),
	(42, 'Gangaramaya Temple', '61 Sri Jinarathana Rd, Colombo 00200, Sri Lanka', 6.91671, 79.8566, 'images/marker/icon_68be71dcce880.png', 'Gangaramaya Temple, located in the heart of Colombo, Sri Lanka, is a captivating fusion of cultural, historical, and spiritual heritage. This remarkable temple offers visitors a unique glimpse into the country\'s Buddhist traditions, blending modernity with ancient architecture. Established in the 19th century, Gangaramaya is renowned for its eclectic design, featuring elements from Sri Lankan, Thai, Indian, and Chinese cultures.One of the most distinctive features of the temple is its ornate interiors, filled with intricate carvings, vibrant murals, and a collection of priceless antiques, including statues of Buddha, gold ornaments, and sacred relics. The temple also houses an educational center, providing insight into the teachings of Buddhism and offering a serene space for meditation and reflection. Visitors can stroll through the temple’s peaceful surroundings, including a tranquil pond, a tower with breathtaking views of the city, and an awe-inspiring library.', 20, 12),
	(43, 'Sri Kailawasanatan Swami Temple', 'WVV3+2QM, Colombo 01300, Sri Lanka', 6.94258, 79.8544, 'images/marker/icon_68be71dccfbfe.png', 'Sri Kailawasanathan Swami Devasthanam Kovil, situated on Sea Street in Colombo, Sri Lanka, is one of the country’s most important Hindu temples, dedicated to Lord Shiva. This magnificent temple boasts stunning Dravidian architecture, with intricate carvings and vibrant sculptures that depict various deities and mythological stories. The towering gopuram at the entrance is a remarkable feature, drawing visitors’ attention with its colorful and detailed artwork. The temple serves as a spiritual center, offering a peaceful environment for worshippers and visitors to pray, meditate, and seek blessings. It is particularly lively during religious festivals, when grand processions and elaborate rituals take place, attracting large crowds of devotees. Beyond its religious significance, the temple plays a vital role in preserving Tamil culture and traditions in Sri Lanka', 15, 12),
	(44, 'Independence Square', '7 Independence Ave, Colombo 00700, Sri Lanka', 6.90416, 79.8676, 'images/marker/icon_68be71dcd0f58.png', 'The Independence Memorial Hall, located in Independence Square, Colombo, Sri Lanka, is a significant landmark that commemorates the country\'s independence from British colonial rule on February 4, 1948. This iconic structure, built in traditional Sri Lankan architecture, serves as a symbol of the nation’s freedom and unity. The hall is surrounded by lush greenery, adding to the serene atmosphere, making it a peaceful space for reflection and respect.The monument features intricately designed stone carvings and a large statue of the first Prime Minister, Don Stephen Senanayake, who played a crucial role in Sri Lanka’s independence movement. The surrounding park is often a gathering place for locals and tourists, offering an area for leisurely walks or cultural events. Visitors can also explore the historical plaques and exhibits detailing Sri Lanka\'s path to independence. must-visit destination for those seeking to understand Sri Lanka\'s proud history and national identity.', 10, 12),
	(45, 'Jami Ul-Alfar Mosque', '228 2nd Cross Street, Colombo 01100, Sri Lanka', 6.93843, 79.8518, 'images/marker/icon_68be71dcd2507.png', 'Jami Ul-Alfar Mosque, located in the heart of Colombo, Sri Lanka, is one of the city\'s most iconic and beautiful landmarks. Known for its striking red and white striped façade, this mosque is a prominent example of Indo-Saracenic architecture. Built in 1909, the mosque stands out with its grand design, which incorporates elements of both Islamic and Sri Lankan styles. Its unique appearance, especially the towering minaret, makes it a beloved feature of Colombo\'s skyline. The mosque is not just a place of worship but also an architectural masterpiece, with intricately designed arches, domes, and decorative features that reflect the cultural blend of Sri Lanka’s Muslim community. Visitors are welcome to admire its beauty and learn about its rich history, although entry is restricted during prayer times. Jami Ul-Alfar Mosque holds a special place in the hearts of Colombo\'s residents, symbolizing unity, peace, and Sri Lanka\'s diverse religious heritage.', 10, 12),
	(46, 'Sambodhi Pagoda Temple', 'WRQR+9R2, Chaithya Rd, Colombo 00100, Sri Lanka', 6.93839, 79.842, 'images/marker/icon_68be71dcd398a.png', 'Sambodhi Chaithya, located in Colombo, Sri Lanka, is a significant Buddhist stupa that stands as a symbol of spirituality and devotion. Situated near the heart of the city, it offers a peaceful retreat for both locals and visitors seeking a moment of reflection. The stupa, which dates back to the early 20th century, is designed in traditional Sri Lankan architecture and is an iconic feature of Colombo’s skyline. One of the distinctive aspects of Sambodhi Chaithya is its elevated position, built on a raised platform that provides stunning panoramic views of the surrounding city. Visitors can ascend the stairway leading up to the stupa, offering a serene experience along the way. The structure is meticulously adorned with intricate carvings, statues, and relics, reflecting the rich Buddhist heritage of Sri Lanka. Sambodhi Chaithya is a must-visit for those seeking a peaceful and culturally enriching experience, offering insight into Sri Lanka’s deep spiritual roots.', 15, 12),
	(47, 'Colombo Fort Old Lighthouse & Clock Tower', 'Janadhipathi Mawatha, Colombo 00100, Sri Lanka', 6.93475, 79.8428, 'images/marker/icon_68be71dcd50c1.png', 'The Colombo Fort Clock Tower, located in the heart of Colombo, Sri Lanka, is a historical landmark that stands as a testament to the city’s colonial past. Built in the mid-19th century, this clock tower was originally part of the Colombo Fort Railway Station, serving as a key point of reference for travelers and locals alike. Its striking architecture combines elements of colonial and Victorian design, making it an attractive feature in the bustling area. The clock tower, with its tall, cylindrical structure and large clock faces,Over time, it has become a focal point for tourists and residents, offering a glimpse into Sri Lanka’s colonial history. The surrounding area of Colombo Fort is also home to various other historical buildings, making it an ideal spot for those interested in the island’s cultural heritage.Visiting the Colombo Fort Clock Tower provides a unique opportunity to experience the fusion of old-world charm with the dynamic energy of modern-day Colombo.', 5, 12),
	(48, 'Colombo Lotus Tower', '320 McCallum Rd, Colombo 01000, Sri Lanka', 6.92704, 79.8583, 'images/marker/icon_68be71dcd6445.png', 'Lotus Tower Road, located in Colombo, Sri Lanka, is home to the iconic **Lotus Tower**, the tallest structure in Sri Lanka and one of the tallest in South Asia. This remarkable tower, standing at 350 meters, is a symbol of modernity and innovation in the heart of Colombo. Its design is inspired by the lotus flower, a symbol of purity and beauty in Sri Lankan culture, and its vibrant, multi-colored lighting adds to its stunning visual appeal, especially during the night. The Lotus Tower serves as a telecommunications hub and offers breathtaking panoramic views of Colombo and the Indian Ocean from its observation deck. Visitors can experience a unique combination of technology, culture, and urban landscape from the tower’s various facilities, including a restaurant and conference spaces. Lotus Tower Road has become a key area in Colombo, attracting tourists,. It’s a must-visit for those wanting to experience the city’s impressive blend of tradition and modern development.', 10, 12),
	(49, 'Old Parliament Building', 'Kwame Nkrumah, Box CY 298 Causeway, & Third St, Harare, Zimbabwe', -17.8282, 31.052, 'images/marker/icon_68be71dcd786b.png', 'The Old Parliament Building, located in Fort, Colombo, Sri Lanka, is a grand historical landmark that reflects the country\'s colonial and political heritage. Completed in 1930, this neoclassical structure originally served as the seat of the Legislative Council during British rule and later became the home of Sri Lanka’s Parliament until 1983. Its stunning architecture features elegant columns, arches, and intricate details, making it one of Colombo\'s most significant architectural landmarks. The building is located near the scenic Galle Face Green and the waterfront, offering a picturesque view of the Indian Ocean. Today, the Old Parliament Building houses the Presidential Secretariat and is not open for public tours, but visitors can admire its grandeur from the outside. The building\'s historical significance, combined with its beautiful architecture, makes it an important symbol of Sri Lanka\'s journey toward independence and democracy. A visit to this landmark', 5, 12),
	(50, 'Ceylon Tea Supermarket', 'Fountain House Complex, 326 Deans Road, Colombo 01000, Sri Lanka', 6.92137, 79.8642, 'images/marker/icon_68be71dcd959e.png', 'Ceylon Tea Supermarket, located on Deans Road in Colombo, Sri Lanka, is a must-visit destination for tea lovers and anyone looking to explore the rich flavors of Sri Lanka’s world-renowned tea. This specialty store offers a wide selection of premium Ceylon tea, known for its high quality and distinct taste. Whether you prefer the boldness of black tea, the soothing notes of green tea, or the refreshing aroma of white tea, the supermarket caters to all preferences. In addition to tea, Ceylon Tea Supermarket also sells a variety of tea-related accessories, such as teapots, infusers, and cups, making it an ideal place to pick up a souvenir or gift. The friendly and knowledgeable staff are eager to guide the different varieties and provide expert advice on brewing the perfect cup. Located in the bustling heart of Colombo, Ceylon Tea Supermarket offers an authentic Sri Lankan tea experience and is a must-see for tourists looking to bring a piece of Sri Lanka\'s tea culture home.', 30, 12),
	(51, 'Old Town Hall Market', '25, old Town Hall, Sri Bodhiraja Mawatha, Colombo 00100, Sri Lanka', 6.93831, 79.8542, 'images/marker/icon_68be71dcda8bc.png', 'The Old Town Hall, located in Fort, Colombo, Sri Lanka, is a remarkable historical building that dates back to the 19th century. Originally constructed in 1865, it served as the administrative center for the city of Colombo. Designed in the neoclassical style, the building features elegant columns, grand arches, and a distinctive clock tower, which has become one of its most recognizable features. Over the years, the Old Town Hall has witnessed many important events in Sri Lanka’s political and social history. Today, it stands as a prominent heritage site, showcasing the colonial architecture of the period and reflecting the evolution of the city\'s governance. While the building is no longer used for official purposes,Visitors can admire the structure from the outside and appreciate its historical significance, making it an essential stop for those interested in Sri Lanka’s colonial heritage and architectural beauty.', 15, 12),
	(52, 'Galle Face Green', 'Colombo, Sri Lanka', 6.92379, 79.8449, 'images/marker/icon_68be71dcdbbd3.png', 'Galle Face Green, located along the Galle Main Road in Colombo, Sri Lanka, is one of the city’s most popular outdoor destinations, offering a refreshing escape by the ocean. This expansive promenade stretches along the coastline, providing panoramic views of the Indian Ocean and the city skyline. Originally created in 1859 as a recreational space for the British elite, Galle Face Green has become a beloved spot for both locals and tourists. The lush green lawn is perfect for leisurely walks, picnics, or kite flying, with the cooling sea breeze providing a serene atmosphere. It is especially popular at sunset, when the sky is painted with vibrant colors, creating a picturesque backdrop. The area also features food stalls serving local snacks like isso wade (prawn fritters) and kottu, adding to the authentic Sri Lankan experience.Galle Face Green is a hub of social activity, offering a peaceful making it a must-visit destination for anyone exploring Colombo’s cultural and natural beauty.', 10, 12),
	(53, 'Viharamahadevi Park', 'Kurunduwatta, Colombo 00700, Sri Lanka', 6.91339, 79.8617, 'images/marker/icon_68be71dcdd6ba.png', 'Viharamahadevi Park, located in the heart of Colombo, Sri Lanka, is a tranquil green space offering a peaceful escape from the bustle of city life. Named after Queen Viharamahadevi, the park is one of Colombo\'s oldest and largest public parks, spanning over 20 acres. Its beautifully landscaped gardens, wide pathways, and large trees make it an ideal location for leisurely walks, picnics, and outdoor activities. The park is home to a variety of flora, including colorful flowers and towering trees, providing a serene atmosphere for relaxation and nature lovers. A prominent feature of the park is the large statue of Buddha, which adds a spiritual touch to the surroundings. Visitors can also enjoy the children\'s play area, making it a family-friendly destination. Viharamahadevi Park is situated near key attractions like the Colombo National Museum, making it a perfect stop for tourists. It’s a peaceful retreat where one can experience Colombo’s natural beauty and cultural heritage.', 20, 12),
	(54, 'Christian Reformed Church of Sri Lanka', 'WVR5+RJP, Wolfendhal Ln, Colombo 01300, Sri Lanka', 6.94208, 79.8591, 'images/marker/icon_68be71dcdea71.png', 'Wolvendaal Church, located on Wolfendhal Street in Colombo, Sri Lanka, is one of the oldest and most significant Dutch Reformed churches in the country. Built in 1749, the church stands as a testament to Sri Lanka’s colonial history and the influence of the Dutch East India Company. The church\'s stunning architecture features a blend of European and local designs, with a large, imposing structure that includes a high roof, intricate wooden pews, and a beautifully decorated altar. The church is known for its historical importance, as it has been a place of worship for over two centuries. Inside, visitors can admire the old tombstones, some of which belong to Dutch settlers and their families, giving the church a deep sense of history. The peaceful surroundings and the church’s serene atmosphere make it a perfect spot for quiet reflection and exploration. Wolvendaal Church is an important heritage .offering a fascinating glimpse into the city’s colonial past and religious traditions.', 15, 12),
	(55, 'Colombo Lighthouse', 'WRPR+G86, Chaithya Rd, Colombo 00100, Sri Lanka', 6.93628, 79.8408, 'images/marker/icon_68be71dcdff90.png', 'The Colombo Lighthouse, located in Colombo Fort, Sri Lanka, is a historic and iconic landmark that stands tall at the entrance to the Colombo harbor. Originally built in 1867, it was later replaced in 1913 with the current structure, which is still in operation today, guiding ships safely into the bustling port. The lighthouse stands at a height of 29 meters and is a symbol of Colombo’s maritime heritage. The design of the Colombo Lighthouse is simple yet striking, with a white and red striped tower that contrasts beautifully against the blue sky and surrounding landscape. The lighthouse is not only an essential part of Sri Lanka’s navigation system but also a popular spot for visitors seeking panoramic views of the harbor and the Indian Ocean. Although the lighthouse itself is not open to the public, it remains a significant piece of Colombo’s history, reflecting the city’s important . It is a must-see for anyone exploring Colombo’s coastal beauty and colonial past.', 10, 12),
	(56, 'Laksala', '215 Bauddhaloka Mawatha, Colombo 00700, Sri Lanka', 6.89795, 79.8606, 'images/marker/icon_68be71dce1320.png', 'Laksala, located at 215 Bauddhaloka Mawatha in Colombo, Sri Lanka, is the country’s premier state-run handicrafts showroom, offering a wide array of authentic Sri Lankan crafts and souvenirs. Established to promote traditional Sri Lankan artistry, Laksala showcases a stunning collection of handmade goods, ranging from intricate wood carvings and vibrant batiks to stunning pottery, jewelry, and handwoven textiles. Each item reflects the island’s rich cultural heritage and craftsmanship, making it the perfect place to find unique, locally made treasures. The showroom is beautifully organized, with products from various regions of Sri Lanka, ensuring visitors experience a diverse range of artistic styles. It is a popular destination for both tourists and locals looking for highquality souvenirs and gifts that represent the island\'s heritage. A visit to Laksala offers a glimpse into Sri Lankas cultural history while providing an excellent opportunity to purchase timeless, authentic crafts', 30, 12),
	(57, 'Ella', 'Ella, Sri Lanka', 6.87313, 81.0491, 'images/marker/icon_68dd19adaa57a.png', 'hrtht', 12, 14);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.massage: ~0 rows (approximately)

-- Dumping structure for table blaze-tours_db.rating_star
CREATE TABLE IF NOT EXISTS `rating_star` (
  `id` int NOT NULL AUTO_INCREMENT,
  `star` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.rating_star: ~5 rows (approximately)
INSERT INTO `rating_star` (`id`, `star`) VALUES
	(1, '1'),
	(2, '2'),
	(3, '3'),
	(4, '4'),
	(5, '5');

-- Dumping structure for table blaze-tours_db.review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `tour_id` int NOT NULL,
  `rating_star_id` int NOT NULL,
  `submit_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_review_tour1_idx` (`tour_id`),
  KEY `fk_review_rating_star1_idx` (`rating_star_id`),
  CONSTRAINT `fk_review_rating_star1` FOREIGN KEY (`rating_star_id`) REFERENCES `rating_star` (`id`),
  CONSTRAINT `fk_review_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.review: ~0 rows (approximately)
INSERT INTO `review` (`id`, `name`, `email`, `comment`, `tour_id`, `rating_star_id`, `submit_at`) VALUES
	(1, 'Lakshitha madumal', 'mandujayaweera2003@gmail.com', 'wowwwwwwwwwwwwwwwwwwwwwwwwww', 10, 4, '2025-08-24 18:13:46');

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
	(2, 'De-Active'),
	(3, 'Processing');

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.time: ~10 rows (approximately)
INSERT INTO `time` (`id`, `timeslot`) VALUES
	(11, '07:00:00'),
	(12, '08:00:00'),
	(13, '09:00:00'),
	(14, '10:00:00'),
	(15, '11:00:00'),
	(16, '12:00:00'),
	(17, '13:00:00'),
	(18, '14:00:00'),
	(19, '15:00:00'),
	(20, '16:00:00'),
	(21, '17:00:00'),
	(22, '18:00:00'),
	(23, '06:38:00');

-- Dumping structure for table blaze-tours_db.tour
CREATE TABLE IF NOT EXISTS `tour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `duration` int DEFAULT NULL,
  `kids_price` double DEFAULT NULL,
  `adult_price` double DEFAULT NULL,
  `maximum_adult_count` int DEFAULT NULL,
  `maximum_kids_count` int DEFAULT NULL,
  `tours_type_id` int NOT NULL,
  `status_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tour_tours_type1_idx` (`tours_type_id`),
  KEY `fk_tour_status1_idx` (`status_id`),
  CONSTRAINT `fk_tour_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_tour_tours_type1` FOREIGN KEY (`tours_type_id`) REFERENCES `tours_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tour: ~3 rows (approximately)
INSERT INTO `tour` (`id`, `name`, `description`, `duration`, `kids_price`, `adult_price`, `maximum_adult_count`, `maximum_kids_count`, `tours_type_id`, `status_id`) VALUES
	(10, 'Private Safari Tour Exploring Sri Lanka\'s', 'voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur\r\n\r\n‍Whether you work from home or commute to a nearby office, the energy-efficient features of your home contribute to a productive and eco-conscious workday. Smart home systems allow you to monitor and control energy usage, ensuring that your environmental impact remains minimal.', 4, 30.5, 45.6, 6, 4, 1, 1),
	(11, '3 Hour Private Colombo Street Food Tour', 'This private tour delivers: pairing you with a driver-guide who knows great local food stops and fun transport in Convertible tuk-tuk. Sampling Colombo’s street foods can be tricky without a local foodie host to point out favorite local eats and what they consist of. On this private tour, you gain the insider knowledge you need. Let a guide introduce you to food spots such as Pettah Market, together with treats such as cassava chips and samosas, so you end up truly eating like a local. Colombo’s streets to sample specialities like crab curry, sambol, and ice-cream, and as you taste and talk, learn secrets and snippets about Sri Lanka’s roadside dishes that most tourists never hear.', 3, 35, 39, 2, 4, 1, 1),
	(12, 'Explore Colombo in Style Exclusive Tuk Tuk Sightseeing Adventure', 'Embark on an exhilarating journey with Vinoth Blaze to uncover the rich tapestry of Sri Lanka\'s cultural heritage, nestled within the captivating Colombo suburbs. Experience the fusion of history and modernity in Colombo, where every corner tells a story. With over a decade of expertise, Blaze promises an immersive exploration beyond the tourist trail. Glide through the bustling streets aboard our comfortable Cabrio Tuk Tuk, soaking in the vibrant colors and tantalizing aromas of Pettah market, a centuries-old trading hub. Delve into the spiritual realm with visits to ancient temples, immersing yourself in the sacred traditions of Buddhism and Hinduism. Let Blaze be your trusted guide, offering insider tips and assistance for an unforgettable adventure in the heart of Sri Lanka. Join us and unlock the secrets of this enchanting island!', 4, 22, 34, 3, 2, 3, 1),
	(13, 'Lakshitha madumal', 'vfdbfdb', 23, 43, 43, 54, 3, 1, 3),
	(14, 'Mount Lavinia', 'aaaaaaaaaa', 15, 2000, 5000, 3, 2, 3, 1);

-- Dumping structure for table blaze-tours_db.tours_type
CREATE TABLE IF NOT EXISTS `tours_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tours_type: ~2 rows (approximately)
INSERT INTO `tours_type` (`id`, `name`) VALUES
	(1, 'City'),
	(3, 'Adventure'),
	(4, 'Street'),
	(5, 'Private ');

-- Dumping structure for table blaze-tours_db.tour_image
CREATE TABLE IF NOT EXISTS `tour_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `main_image` text,
  `second_image` text,
  `tour_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tour_image_tour1_idx` (`tour_id`),
  CONSTRAINT `fk_tour_image_tour1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.tour_image: ~3 rows (approximately)
INSERT INTO `tour_image` (`id`, `main_image`, `second_image`, `tour_id`) VALUES
	(16, '../../assets/uploads/tour_images/main_686817e0e7bf1_private-tour.png', '../../assets/uploads/tour_images/second_686817e0e82dd_private-tour1.png', 10),
	(18, '../../assets/uploads/tour_images/main_68be6aa046eec_97.jpg', '../../assets/uploads/tour_images/second_68be6aa04743b_10.jpg', 11),
	(19, '../../assets/uploads/tour_images/main_68be71dca9502_8e.jpg', '../../assets/uploads/tour_images/second_68be71dca9a18_94.jpg', 12),
	(20, '../../assets/uploads/tour_images/main_68dd19ad9e8f5_Whisk_b2f31e012c9bc729fe742b747e3e2d59dr.jpeg', '../../assets/uploads/tour_images/second_68dd19ad9ef7c_Whisk_b2f31e012c9bc729fe742b747e3e2d59dr.jpeg', 14);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table blaze-tours_db.user: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
