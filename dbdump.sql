-- Adminer 4.8.1 MySQL 8.0.32-0ubuntu0.22.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `Mineral`;
CREATE DATABASE `Mineral` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `Mineral`;

DROP TABLE IF EXISTS `mineral_collection`;
CREATE TABLE `mineral_collection` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mineral_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `color_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `weight_in_grams` decimal(10,2) NOT NULL,
  `mineral_form` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `image_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `mineral_collection` (`id`, `mineral_name`, `color_description`, `weight_in_grams`, `mineral_form`, `comments`, `image_file`) VALUES
(1,	'Zebra Calcite',	'brownish orange, white and black',	1386.70,	'Natural',	'Bernie\'s Rock Shop',	'images/zebra_calcite.jpg'),
(2,	'Tigereye',	' lighter brown with dark brown bands',	92.47,	'Orb',	'Gift from Donald Christmas 2019',	'images/tigereye.jpg'),
(3,	'Super Seven',	'purple with bands of white',	768.27,	'Natural, Point',	'Gift from Donald Birthday 2021',	'images/super_seven.jpg'),
(4,	'Sunstone',	'orange',	44.49,	'Polished, Palm',	'Gift from Nick',	'images/sunstone.jpg'),
(5,	'Sulfer',	'yellow',	122.04,	'Natural',	'Breckenridge Colorado, 2018',	'images/sulfer.jpg'),
(6,	'Spiderweb Jasper',	'grey with black lines',	30.18,	'Tumbled, Polished',	'Renaissance Faire 2015',	'images/spiderweb_jasper.jpg'),
(7,	'Sodalite',	'blue with black and white',	83.56,	'Natural',	'Bernie\'s Rock Shop',	'images/sodalite.jpg'),
(8,	'Snowflake Obsidian',	'black, grey ',	54.64,	'Tumbled, Polished',	'Cosmic Delights',	'images/snowflake.jpg'),
(9,	'Snakeskin Agate',	'white',	69.82,	'Polished, Palm',	'Bernie\'s Rock Shop',	'images/snakeskin_agate.jpg'),
(10,	'Smoky Quartz',	'brown',	100.01,	'Polished, Point',	'Gift from mom',	'images/smoky_quartz.jpg'),
(11,	'Scolecite',	'white',	99.11,	'Polished, Fossil, Palm',	'Gift from Donald',	'images/s.jpg'),
(12,	'Rose Quartz',	'pink',	1210.69,	'Natural',	'Renaissance Faire 2015',	'images/rose_quartz.jpg'),
(13,	'Rainbow Florite',	'purple, green',	277.77,	'Natural',	'Cosmic Delights',	'images/rainbow_florite.jpg'),
(14,	'Rhodonite',	'pink, black',	19.93,	'Polished, Shaped',	'Cosmic Delights',	'images/r.jpg'),
(15,	'Pink Calcite',	'pink',	244.11,	'Shaped, Point',	'Gift from Donald',	'images/pink_calcite.jpg'),
(16,	'Moss Agate',	'green with white swirls',	23.58,	'Shaped',	'Crystal subscription box',	'images/moss_agate.jpg'),
(17,	'Mica in Quartz',	'white, black',	113.35,	'Natural',	'Cosmic Delights',	'images/mica_in_quartz.jpg'),
(18,	'Septarian shield',	'black, brown',	54.64,	'Polished, Fossil',	'Gift from Linda. She has the other half. ',	'images/linda.jpg'),
(19,	'Lepediolite',	'purple',	34.21,	'Natural',	'Cosmic Delights',	'images/lepediolite.jpg'),
(20,	'Lapis Lazuli',	'blue and white with swirls of gold ',	38.97,	'Tumbled, Polished',	'Bernie\'s Rock Shop',	'images/lapis_lazuli.jpg'),
(21,	'Labradorite',	'bue',	46.89,	'Natural, Polished',	'Bernie\'s Rock Shop',	'images/l.jpg'),
(22,	'Kambaba Jasper',	'green, black',	71.36,	'Polished, Palm',	'Bernie\'s Rock Shop',	'images/kambaba_jasper.jpg'),
(23,	'Iron Quartz',	'brown',	60.98,	'Natural, Point',	'Gem Show',	'images/iron_quartz.jpg'),
(24,	'Indigo Gabbro',	'purple, black',	123.42,	'Polished, Palm',	'Cosmic Delights',	'images/indigo_gabbro.jpg'),
(25,	'Hematoid Quartz',	'brown',	400.01,	'Polished, Shaped',	'Gem Show 2022',	'images/h.jpg'),
(26,	'Green Moonstone',	'green with black flecks',	165.22,	'Polished, Palm',	'Cosmic Delights',	'images/green_moonstone.jpg'),
(27,	'Fire Quartz',	'orange',	92.47,	'Natural',	'Breckenridge Colorado, 2018',	'images/fire_quartz.jpg'),
(28,	'Desert Rose Calcite',	'brown',	41.14,	'Natural',	'Bernie\'s Rock Shop',	'images/desert_rose.jpg'),
(29,	'Coral',	'white, orange',	89.76,	'Polished, Fossil, Palm',	'Crystal subscription box',	'images/coral_fossil.jpg'),
(30,	'Cobaltian Calcite',	'pink ',	333.88,	'Natural',	'Gem Show 2022',	'images/cobaltian_calcite.jpg'),
(31,	'Chrysacolla Malachite',	'green, blue',	123.97,	'Natural',	'Breckenridge Colorado, 2018',	'images/chrysacolla_malachite.jpg'),
(32,	'Carnelion',	'orange, white',	89.76,	'Polished, Palm',	'Cosmic Delights',	'images/carnelion.jpg'),
(33,	'Bumblebee Japer',	'yellow',	38.97,	'Polished, Palm',	'Gift from Nick',	'images/bumblebee_jasper.jpg'),
(34,	'Bronzite',	'brown, bronze with flecks of black',	18.72,	'Polished, Shaped',	'Gift from Donald',	'images/bronzite.jpg'),
(35,	'Blue Kyanite ',	'blue, white',	88.88,	'Natural',	'Bernie\'s Rock Shop',	'images/blue_kyanite.jpg'),
(36,	'Blue Calcite',	'bue',	444.49,	'Natural',	'Bernie\'s Rock Shop',	'images/blue_calcite.jpg'),
(37,	'Apatite',	'blue with white and brown patches',	184.88,	'Natural, Polished, Palm',	'Gem Show 2022',	'images/apatite.jpg'),
(38,	'Argonite Star Cluster',	'orange',	29.34,	'Natural',	'Bernie\'s Rock Shop',	'images/agonite_star.jpg'),
(39,	'Amazonite',	'blue, black, white',	78.48,	'Natural/Raw',	'Cosmic Delights',	'images/amazonite.jpg'),
(40,	'Trilobite',	'grey',	107.99,	'Fossil',	'Gem Show 2022',	'images/trilobite.jpg'),
(41,	'Ammonite',	'brown with white stripes in a spiral',	18.98,	'Natural, Fossil',	'Gift from NIck',	'images/ammonite.jpg'),
(42,	'Chevron Amethyst ',	'purple, white with some rust colors',	419.19,	'Natural',	'Bernie\'s Rock Shop',	'images/chevron_amethyst.jpg'),
(43,	'Orthoceras',	'grey, black ',	60.98,	'Polished, Shaped, Fossil',	'Bernie\'s Rock Shop',	'images/orthoceras.jpg'),
(44,	'Amethyst Hematite',	'purple with red speckles ',	119.14,	'Natural',	'Gem Show 2022',	'images/a.jpg'),
(46,	'Test Fossil',	'Test',	8.00,	'Natural/Raw',	'from your mom',	''),
(47,	'Test Mineral',	'blue, black, white',	8.10,	'Natural',	'from your mom, she\'s pretty neat.',	'');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `access_privileges` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id`, `user_name`, `password_hash`, `access_privileges`) VALUES
(1,	'Anna',	'$2y$10$56KwvQ2C/eWDdmhuLHi.hOCUlWfYQp9n/2joCW9WMbHOj9J0Lf4va',	'admin'),
(2,	'Sally McBally',	'$2y$10$iunpp640Sl4l.6VtsMvGTOKZCclM1Py5r1HeudbiCgnpeL0gHsfDa',	'user'),
(3,	'Bob McBob',	'$2y$10$2lfsNfda.diWf7YiKRIfMOU5CGhgSAZab3kYLKsD/kF3sP/JbPfo2',	'user');

-- 2023-05-05 20:51:39