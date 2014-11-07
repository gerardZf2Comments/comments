-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: moduleswdoctrine
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.12.04.1

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
-- Table structure for table `mesa`
--

DROP TABLE IF EXISTS `mesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesa`
--

LOCK TABLES `mesa` WRITE;
/*!40000 ALTER TABLE `mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `mesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `watched` int(11) NOT NULL,
  `repo_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(500) NOT NULL,
  `meta_data` blob,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `photo_url` varchar(255) DEFAULT NULL,
  `owner` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,34,'4545','module','mod des','http://add.com',NULL,'2013-10-09 12:03:12','0000-00-00 00:00:00',NULL,'bla'),(2,34,'45345','modules','mod des','http://add2.com',NULL,'2013-10-09 12:03:12','0000-00-00 00:00:00',NULL,'blaa');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_admin`
--

DROP TABLE IF EXISTS `module_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_admin` (
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`module_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `module_admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `module_admin_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_admin`
--

LOCK TABLES `module_admin` WRITE;
/*!40000 ALTER TABLE `module_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_comment`
--

DROP TABLE IF EXISTS `module_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `has_parent` int(1) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_comment`
--

LOCK TABLES `module_comment` WRITE;
/*!40000 ALTER TABLE `module_comment` DISABLE KEYS */;
INSERT INTO `module_comment` VALUES (1,1,'ahgergerh',0,NULL,1,'shdhgsh','2013-10-10 00:00:00'),(2,1,'REPLY',1,1,1,NULL,NULL),(3,1,'REPLY',1,1,1,NULL,NULL),(4,1,'REPLY',1,1,1,NULL,NULL),(5,1,'REPLY',1,1,1,NULL,NULL),(6,1,'REPLY',1,1,1,NULL,NULL),(7,1,'reply',1,1,1,NULL,NULL),(8,1,'reply',1,1,1,NULL,NULL),(9,1,'vb',0,NULL,1,'b',NULL),(10,1,'vb',0,NULL,1,'b',NULL),(11,1,'by',1,1,1,NULL,NULL),(12,1,'comment',0,NULL,1,'next',NULL),(13,1,'a reply',1,12,1,NULL,NULL),(14,1,'a reply',1,12,1,NULL,NULL),(15,1,'a reply',1,12,1,NULL,NULL),(16,1,'yy',0,NULL,1,'yy',NULL),(17,1,'com',1,16,1,NULL,NULL),(18,1,'yy',0,NULL,1,'yy',NULL),(19,1,'v',1,18,1,NULL,NULL),(20,1,'ff',0,NULL,1,'gg',NULL),(21,1,'r',1,20,1,NULL,NULL),(22,1,'r',1,20,1,NULL,NULL),(23,1,'f',0,NULL,1,'g',NULL),(24,1,'as',1,23,1,NULL,NULL),(25,1,'ju',0,NULL,1,'h',NULL),(26,1,'reply',1,25,1,NULL,NULL),(27,1,'a reply',1,12,1,NULL,NULL),(28,1,'reply',1,1,1,NULL,NULL),(29,1,'reply',1,16,1,NULL,NULL),(30,1,'rr',1,25,1,NULL,NULL),(31,1,'a comment ex',0,NULL,1,'a comment title',NULL),(32,1,'hjkkk',1,25,1,NULL,NULL),(33,1,'reply',1,23,1,NULL,NULL),(34,1,'reply',1,12,1,NULL,NULL),(35,1,'reply',1,12,1,NULL,NULL),(36,1,'reply',1,12,1,NULL,NULL),(37,1,'try',1,20,1,NULL,NULL),(38,1,'a reply',1,31,1,NULL,NULL),(39,1,'poner',1,1,1,NULL,NULL),(40,1,'u',1,18,1,NULL,NULL),(41,1,'reply',1,18,1,NULL,NULL),(42,1,'t',1,16,1,NULL,NULL),(43,1,'comment',1,31,1,NULL,NULL),(44,1,'r',1,18,1,NULL,NULL),(45,1,'reply',1,31,1,NULL,NULL),(46,1,'comment',1,12,1,NULL,NULL),(47,1,'to',1,12,1,NULL,NULL),(48,1,'com',1,12,1,NULL,NULL),(49,1,'com',1,12,1,NULL,NULL),(50,1,'r',1,9,1,NULL,NULL),(51,1,'r',1,9,1,NULL,NULL),(52,1,'i',1,16,1,NULL,NULL),(53,1,'r',1,9,1,NULL,NULL),(54,1,'yyy',1,16,1,NULL,NULL),(55,1,'ggg',1,12,1,NULL,NULL),(56,1,'thanks',1,18,1,NULL,NULL),(57,1,'details',1,20,1,NULL,NULL),(58,1,'it works',1,1,1,NULL,NULL);
/*!40000 ALTER TABLE `module_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_comment_reply`
--

DROP TABLE IF EXISTS `module_comment_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_comment_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_comment_reply`
--

LOCK TABLES `module_comment_reply` WRITE;
/*!40000 ALTER TABLE `module_comment_reply` DISABLE KEYS */;
INSERT INTO `module_comment_reply` VALUES (1,1,'bla'),(2,0,'two'),(3,1,'bla'),(4,1,'two');
/*!40000 ALTER TABLE `module_comment_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_tag`
--

DROP TABLE IF EXISTS `module_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_tag` (
  `module_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_tag`
--

LOCK TABLES `module_tag` WRITE;
/*!40000 ALTER TABLE `module_tag` DISABLE KEYS */;
INSERT INTO `module_tag` VALUES (1,1),(1,1),(1,1),(1,1),(1,4),(1,5),(1,6);
/*!40000 ALTER TABLE `module_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'module'),(2,'real'),(3,'coke'),(4,'bla'),(5,'new'),(6,'breakin');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'bla','gera@yuu.com','blas','bfhkab',NULL,'2013-10-09 12:14:54');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_provider`
--

DROP TABLE IF EXISTS `user_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_provider` (
  `user_id` int(11) NOT NULL,
  `provider_id` varchar(50) NOT NULL,
  `provider` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`provider_id`),
  UNIQUE KEY `provider_id` (`provider_id`,`provider`),
  CONSTRAINT `user_provider_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_provider`
--

LOCK TABLES `user_provider` WRITE;
/*!40000 ALTER TABLE `user_provider` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `state` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('bla','gera@yuu.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',1),('bla2','gera@yuu2.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',2),('bla3','gera3@yuu.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',3),('bla4','gera@yuu4.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',4),('bla5','gera@yuu5.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',5),('bla6','gera@yuu6.com','blas','bfhkab',NULL,'','2013-10-09 10:14:54',6);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-07 12:57:04
