-- MySQL dump 10.13  Distrib 5.5.27, for osx10.6 (i386)
--
-- Host: localhost    Database: sandy_school
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(8) NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(255) NOT NULL,
  `entity_nces_id` varchar(255) NOT NULL,
  `contact_point_name` text,
  `contact_point_phone` text,
  `contact_point_email` text,
  `website` text,
  `status` varchar(255) DEFAULT NULL,
  `open_date_student` datetime DEFAULT NULL,
  `open_date_teachers` datetime DEFAULT NULL,
  `relocation_information` text,
  `q_fema_resources` tinyint(1) DEFAULT NULL,
  `q_student_transport` text,
  `q_student_percentage` text,
  `q_teacher_transport` text,
  `q_teacher_percentage` text,
  `q_electricity` tinyint(1) DEFAULT NULL,
  `q_electricity_notes` text,
  `q_electricity_status_required` tinyint(1) DEFAULT NULL,
  `q_student_resources` tinyint(1) DEFAULT NULL,
  `q_student_resources_notes` text,
  `q_student_resources_required` tinyint(1) DEFAULT NULL,
  `q_building_water` tinyint(1) DEFAULT NULL,
  `q_building_water_notes` text,
  `q_building_water_required` tinyint(1) DEFAULT NULL,
  `q_building_mold` tinyint(1) DEFAULT NULL,
  `q_building_mold_notes` text,
  `q_building_mold_required` tinyint(1) DEFAULT NULL,
  `q_building_structural` varchar(255) DEFAULT NULL,
  `q_building_structural_notes` text,
  `q_building_structural_required` tinyint(1) DEFAULT NULL,
  `q_building_cafeteria` varchar(255) DEFAULT NULL,
  `q_building_cafeteria_notes` text,
  `q_building_cafeteria_required` tinyint(1) DEFAULT NULL,
  `q_building_contents` varchar(255) DEFAULT NULL,
  `q_building_contents_notes` text,
  `q_building_contents_required` tinyint(1) DEFAULT NULL,
  `q_building_ada` varchar(255) DEFAULT NULL,
  `q_building_ada_notes` text,
  `q_building_ada_required` tinyint(1) DEFAULT NULL,
  `q_building_access` varchar(255) DEFAULT NULL,
  `q_building_access_notes` text,
  `q_building_access_required` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-08  0:03:11
