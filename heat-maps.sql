-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: heat-maps
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` text NOT NULL,
  `date` date DEFAULT NULL,
  `posX` int(11) NOT NULL,
  `posY` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'1fcbd791bba0ff9784acba0e898f6af5',NULL,30,30),(2,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',30,30),(3,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',30,30),(4,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',1200,30),(5,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',80,30),(6,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',30,30),(7,'1fcbd791bba0ff9784acba0e898f6af5',NULL,30,30),(8,'1fcbd791bba0ff9784acba0e898f6af5',NULL,30,30),(9,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-14',30,30),(10,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',141,290),(11,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',583,209),(12,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',1034,238),(13,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',220,376),(14,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',445,795),(15,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',445,795),(16,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',445,795),(17,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(18,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(19,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(20,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(21,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(22,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(23,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(24,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(25,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(26,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(27,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(28,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(29,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',446,793),(30,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',857,540),(31,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',760,511),(32,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',869,841),(33,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',1221,848),(34,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',1235,378),(35,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',388,118),(36,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',222,230),(37,'1fcbd791bba0ff9784acba0e898f6af5','2020-04-15',454,790);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` text NOT NULL,
  `expire_date` date NOT NULL,
  `email` varchar(145) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `name` varchar(145) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,'1fcbd791bba0ff9784acba0e898f6af5','2050-02-02','kevin@gmail.com',NULL,'kevin');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-15 21:54:01
