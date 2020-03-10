-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: youcard
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faction_id` int(11) DEFAULT NULL,
  `creator_id` int(11) NOT NULL,
  `rarety_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `health` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_161498D34448F8DA` (`faction_id`),
  KEY `IDX_161498D361220EA6` (`creator_id`),
  KEY `IDX_161498D384B6B508` (`rarety_id`),
  CONSTRAINT `FK_161498D34448F8DA` FOREIGN KEY (`faction_id`) REFERENCES `faction` (`id`),
  CONSTRAINT `FK_161498D361220EA6` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_161498D384B6B508` FOREIGN KEY (`rarety_id`) REFERENCES `rarety` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card`
--

LOCK TABLES `card` WRITE;
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` VALUES (1,1,1,1,'Iron Man',300,200,100,'card_2020-03-06-17-22-50.jpeg'),(2,1,1,1,'Captain America',100,150,50,'card_2020-03-06-17-27-55.jpeg'),(3,2,1,1,'Thanos',1000,500,250,'card_2020-03-06-17-31-14.jpeg'),(4,3,1,3,'Silvia',50,50,50,''),(5,2,1,2,'Trump',300,1000,300,'card_2020-03-06-17-49-11.png'),(6,1,1,2,'Hawkeye',50,75,50,'card_2020-03-08-21-46-06.jpeg'),(7,1,1,1,'Spider-Man',100,100,50,'card_2020-03-08-23-08-01.jpeg'),(8,3,1,3,'Jonh',20,20,10,'');
/*!40000 ALTER TABLE `card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deck`
--

DROP TABLE IF EXISTS `deck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deck`
--

LOCK TABLES `deck` WRITE;
/*!40000 ALTER TABLE `deck` DISABLE KEYS */;
INSERT INTO `deck` VALUES (5,'Best'),(6,'test');
/*!40000 ALTER TABLE `deck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deck_card`
--

DROP TABLE IF EXISTS `deck_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deck_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) DEFAULT NULL,
  `deck_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2AF3DCED4ACC9A20` (`card_id`),
  KEY `IDX_2AF3DCED111948DC` (`deck_id`),
  CONSTRAINT `FK_2AF3DCED111948DC` FOREIGN KEY (`deck_id`) REFERENCES `deck` (`id`),
  CONSTRAINT `FK_2AF3DCED4ACC9A20` FOREIGN KEY (`card_id`) REFERENCES `card` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deck_card`
--

LOCK TABLES `deck_card` WRITE;
/*!40000 ALTER TABLE `deck_card` DISABLE KEYS */;
INSERT INTO `deck_card` VALUES (8,7,6),(20,1,6),(23,7,6),(24,2,6),(28,1,6),(30,1,5),(31,3,5),(32,2,5),(33,1,5),(34,1,5),(35,1,6),(37,7,6);
/*!40000 ALTER TABLE `deck_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faction`
--

DROP TABLE IF EXISTS `faction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faction`
--

LOCK TABLES `faction` WRITE;
/*!40000 ALTER TABLE `faction` DISABLE KEYS */;
INSERT INTO `faction` VALUES (1,'Hero'),(2,'Vilain'),(3,'Civil'),(4,'Bandit');
/*!40000 ALTER TABLE `faction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rarety`
--

DROP TABLE IF EXISTS `rarety`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rarety` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rarety`
--

LOCK TABLES `rarety` WRITE;
/*!40000 ALTER TABLE `rarety` DISABLE KEYS */;
INSERT INTO `rarety` VALUES (1,'Gold','#FFD700'),(2,'Silver','#C0C0C0'),(3,'Copper','#B87333');
/*!40000 ALTER TABLE `rarety` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'ruffinel','joshua','joshua@gmail.com','[\"ROLE_USER\"]','$argon2id$v=19$m=65536,t=4,p=1$kPR05T4dxIYaT3HwVODkaQ$/6cndfUzWILIPB7FA9av61x8UfJwBn2xmv2gAstoGx4','2020-03-06 17:00:09');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-10 22:14:09
