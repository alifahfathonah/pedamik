-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: 10118068_akademik
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_code` (`department_code`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`department_code`) REFERENCES `departments` (`department_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'IF','IF2',2),(3,'IF','IF2',1);
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `course_code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` int(11) NOT NULL,
  `sks` int(11) NOT NULL,
  PRIMARY KEY (`course_code`),
  KEY `department_code` (`department_code`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_code`) REFERENCES `departments` (`department_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES ('IF31101','IF','Agama dan Etika',1,2),('IF31105','IF','Bahasa Inggris I',1,2),('IF31201','IF','Matematika dasar 1 -Kalkulus I',1,2),('IF31204','IF','Algoritma dan Pemrograman',1,4),('IF31206L','IF','Prak. Aplikasi Otomasi Perkantoran',1,2),('IF31207L','IF','Prak. Aplikasi berbasis Web I',1,2),('IF31208','IF','Pengantar Sistem dan Teknologi Informasi',1,2),('IF31209','IF','Sistem Digital',1,2),('IF32104','IF','Bahasa Indonesia',2,2),('IF32106','IF','Bahasa Inggris II',2,2),('IF32209','IF','Matematika Dasar II -Kalkulus II',2,3),('IF32214L','IF','Prak. Aplikasi berbasis Web II',2,2),('IF32216','IF','Logika Matematika',2,3),('IF32222','IF','Struktur Data',2,3),('IF32225','IF','Statistika dan Probabilitas',2,3),('IF33107','IF','Wawasan Kebangsaan (Pancasila dan Kewarganegaraan)',3,3),('IF33218','IF','Aljabar Linear dan Matriks',3,3),('IF33220','IF','Matematika Diskrit',3,3),('IF33227','IF','Organisasi dan Arsitektur Komputer',3,3),('IF33332','IF','Basis Data I (basis data)',3,3),('IF33351','IF','Pemrograman Berbasis OO',3,4);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `department_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`department_code`),
  KEY `faculty_code` (`faculty_code`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`faculty_code`) REFERENCES `faculties` (`faculty_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES ('AK','FEB','Akuntansi'),('DI','FD','Desain Interior'),('DKV','FD','Desain Komunikasi Visual'),('IF','FTIK','Teknik Informatika'),('IK','FISP','Ilmu Komunikasi'),('IP','FISP','Ilmu Pemerintahan'),('MJ','FEB','Manajemen'),('TK','FTIK','Teknik Komputer');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculties` (
  `faculty_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`faculty_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES ('FD','Desain'),('FEB','Ekonomi dan Bisnis'),('FISP','Ilmu Sosial dan Ilmu Politik'),('FTIK','Teknik dan Ilmu Komputer');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nidn` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `nidn` (`nidn`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `lecturers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

LOCK TABLES `lecturers` WRITE;
/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
INSERT INTO `lecturers` VALUES (2,5,'101289832235','085863332124','Hilman Fauzi','L','1995-03-09','Sukabumi, Jawa Barat'),(4,10,'158723764','085766727633','Dharma Saputra','L','1993-04-22','Sukabumi, Jawa Barat');
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` enum('D3','D4','S1','S2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `graduated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`),
  UNIQUE KEY `phone_number` (`phone_number`),
  KEY `user_id` (`user_id`,`department_code`),
  KEY `department_code` (`department_code`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `students_ibfk_4` FOREIGN KEY (`department_code`) REFERENCES `departments` (`department_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (2,7,'IF','10118068','085863331766','Satria Aji Putra','L','1999-07-22','Sukabumi','Sukabumi, Jawa Barat','S1',NULL),(3,8,'IF','10118067','0858633311455','Agus Awaludin','L','2000-03-12','Bandung','Bandung, Jawa Barat','S1',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teaches`
--

DROP TABLE IF EXISTS `teaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `course_code` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`,`class_id`,`course_code`),
  KEY `class_id` (`class_id`),
  KEY `course_code` (`course_code`),
  CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`),
  CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `teaches_ibfk_3` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teaches`
--

LOCK TABLES `teaches` WRITE;
/*!40000 ALTER TABLE `teaches` DISABLE KEYS */;
INSERT INTO `teaches` VALUES (1,2,1,'IF31101','2020','Senin'),(2,2,1,'IF31101','2020','Selasa'),(4,2,3,'IF31207L','2020','Senin');
/*!40000 ALTER TABLE `teaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','student','lecturer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@email.com','$2y$10$hSxSWOvXACIkZg7mnqOEMuMMA.ztnMkMVHcRvsjBoyuge11Fzmi1W','admin','2020-08-15 06:57:02'),(5,'101289832235','donesghor@gmail.com','$2y$10$OSDTJWJ1RXFtf5wVPuQLuugHGtHWMa73cSzxl8BoT1DipRxgfhde.','lecturer','2020-08-18 01:07:53'),(7,'10118068','satria.10118068@email.academy.test','$2y$10$3L/E47qSdpQb.XyH4XzKceDIwlejDjXnmm3JZhoMN0xJU9PLc0J42','student','2020-08-19 02:04:40'),(8,'10118067','agus.10118067@email.academy.test','$2y$10$rzlU9Gdm4pUL4rz3yJSjBupPfdSLLgngyOOmWdjC1TWnyEdSjCFba','student','2020-08-19 05:52:56'),(10,'158723764','dosen.dharma@email.test','$2y$10$rFcaOhpbeVRA.M8J.hsU9e/H7bVnIaacvw5E/Qiz3tsUrz56P9lfi','lecturer','2020-08-19 05:59:54');
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

-- Dump completed on 2020-08-19 13:14:55
