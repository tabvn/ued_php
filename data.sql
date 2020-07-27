-- MySQL dump 10.13  Distrib 5.7.29, for macos10.14 (x86_64)
--
-- Host: localhost    Database: ued
-- ------------------------------------------------------
-- Server version	5.7.29

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
-- Table structure for table `dang_ky`
--

DROP TABLE IF EXISTS `dang_ky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dang_ky` (
  `hoc_phan_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `thoi_gian` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hoc_phan_id`,`user_id`),
  UNIQUE KEY `unque_user_hp` (`hoc_phan_id`,`user_id`),
  KEY `fk_hoc_phan_has_users_users1_idx` (`user_id`),
  KEY `fk_hoc_phan_has_users_hoc_phan1_idx` (`hoc_phan_id`),
  CONSTRAINT `fk_hoc_phan_has_users_hoc_phan1` FOREIGN KEY (`hoc_phan_id`) REFERENCES `hoc_phan` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_hoc_phan_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dang_ky`
--

LOCK TABLES `dang_ky` WRITE;
/*!40000 ALTER TABLE `dang_ky` DISABLE KEYS */;
INSERT INTO `dang_ky` VALUES (1,2,'2020-07-27 04:40:42'),(1,3,'2020-07-25 09:10:13');
/*!40000 ALTER TABLE `dang_ky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giang_vien`
--

DROP TABLE IF EXISTS `giang_vien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giang_vien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten` varchar(45) DEFAULT NULL,
  `ho` varchar(45) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `dien_thoai` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giang_vien`
--

LOCK TABLES `giang_vien` WRITE;
/*!40000 ALTER TABLE `giang_vien` DISABLE KEYS */;
INSERT INTO `giang_vien` VALUES (1,'BÃ¬nh','ÄoÃ n Duy','1987-10-25','duybinh@gmail.com','012345'),(2,'Anh PhÆ°Æ¡ng','Pháº¡m','1987-10-25','paphuong@gmail.com','12345678');
/*!40000 ALTER TABLE `giang_vien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hoc_phan`
--

DROP TABLE IF EXISTS `hoc_phan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hoc_phan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_hoc_phan` varchar(255) DEFAULT NULL,
  `ma_hoc_phan` varchar(255) NOT NULL,
  `so_tin_chi` int(11) DEFAULT NULL,
  `giang_vien_id` int(11) NOT NULL,
  `mon_hoc_id` int(11) NOT NULL,
  `so_luong_toi_da` int(11) DEFAULT NULL,
  `thu` varchar(50) NOT NULL,
  `tiet_bat_dau` int(11) NOT NULL,
  `tiet_ket_thuc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ma_hoc_phan_UNIQUE` (`ma_hoc_phan`),
  KEY `fk_mon_hoc_giang_vien1_idx` (`giang_vien_id`),
  KEY `fk_hoc_phan_mon_hoc1_idx` (`mon_hoc_id`),
  CONSTRAINT `fk_hoc_phan_mon_hoc1` FOREIGN KEY (`mon_hoc_id`) REFERENCES `mon_hoc` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_mon_hoc_giang_vien1` FOREIGN KEY (`giang_vien_id`) REFERENCES `giang_vien` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hoc_phan`
--

LOCK TABLES `hoc_phan` WRITE;
/*!40000 ALTER TABLE `hoc_phan` DISABLE KEYS */;
INSERT INTO `hoc_phan` VALUES (1,'MÃ£ nguá»“n má»Ÿ nhÃ³m 001','001',3,1,3,100,'2',1,3),(2,'ToÃ¡n cao cáº¥p nhÃ³m 01','002',3,2,1,50,'2',2,4);
/*!40000 ALTER TABLE `hoc_phan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mon_hoc`
--

DROP TABLE IF EXISTS `mon_hoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mon_hoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_mon_hoc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mon_hoc`
--

LOCK TABLES `mon_hoc` WRITE;
/*!40000 ALTER TABLE `mon_hoc` DISABLE KEYS */;
INSERT INTO `mon_hoc` VALUES (1,'ToÃ¡n cao cáº¥p 1'),(2,'Váº­t lÃ½ Ä‘áº¡i cÆ°Æ¡ng'),(3,'Há»c pháº§n chuyÃªn ngÃ nh');
/*!40000 ALTER TABLE `mon_hoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sinh_vien`
--

DROP TABLE IF EXISTS `sinh_vien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sinh_vien` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ma_sinh_vien` varchar(45) NOT NULL,
  `ten` varchar(45) DEFAULT NULL,
  `ho` varchar(45) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `lop` varchar(45) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ma_sinh_vien_UNIQUE` (`ma_sinh_vien`),
  KEY `fk_sinh_vien_users1_idx` (`user_id`),
  CONSTRAINT `fk_sinh_vien_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sinh_vien`
--

LOCK TABLES `sinh_vien` WRITE;
/*!40000 ALTER TABLE `sinh_vien` DISABLE KEYS */;
INSERT INTO `sinh_vien` VALUES (1,'001','Toáº£n','Nguyá»…n ÄÃ¬nh','1987-10-25','18CNTT04',2),(2,'002','Thuá»· TiÃªn','NgÃ´ LÃª','2000-10-25','18CNTT04',3),(3,'003','Sang','Huá»³nh vÄƒn','2000-10-25','18CNTT04',4),(5,'004','KhuÃª','ÄÃ o Ngá»c','2000-10-25','18CNTT04',6);
/*!40000 ALTER TABLE `sinh_vien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(155) NOT NULL,
  `role` varchar(45) NOT NULL DEFAULT 'sinh_vien',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@gmail.com','21232f297a57a5a743894a0e4a801fc3','admin'),(2,'toan@tabvn.com','21232f297a57a5a743894a0e4a801fc3','student'),(3,'tien@tabvn.com','21232f297a57a5a743894a0e4a801fc3','student'),(4,'sang@gmail.com','21232f297a57a5a743894a0e4a801fc3','student'),(6,'khue@gmail.com','21232f297a57a5a743894a0e4a801fc3','student');
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

-- Dump completed on 2020-07-27 20:51:24
