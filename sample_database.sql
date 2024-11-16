CREATE DATABASE  IF NOT EXISTS `shop_db` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `shop_db`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: shop_db
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `email` varchar(150) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `joined_date` datetime NOT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_admin_gender1_idx` (`gender_id`),
  CONSTRAINT `fk_admin_gender1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('rvsoftwaresolutions1@gmail.com','Ravidu','Vithana','0763738202','Admin@23','2022-11-12 08:51:14','63f25255426ae',1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Gibson'),(2,'Harman Professional'),(3,'Shure'),(4,'Yamaha'),(5,'Fender'),(6,'Steinway'),(7,'Sennheiser'),(8,'Roland'),(9,'Kawai'),(10,'C.F. Martin & Co'),(11,'Trumix'),(12,'Taylor'),(13,'Ferndale'),(14,'Pearl'),(15,'Korg'),(16,'Gretsch'),(17,'Baldwin Piano Company'),(18,'Rickenbacker'),(19,'JBL'),(20,'Kennedy Violins'),(21,'Knilling'),(22,'Atlas');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand_has_category`
--

DROP TABLE IF EXISTS `brand_has_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brand_has_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_id` int NOT NULL,
  `category_id` int NOT NULL,
  `sub_categories_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_brand_has_category_category1_idx` (`category_id`),
  KEY `fk_brand_has_category_brand1_idx` (`brand_id`),
  KEY `fk_brand_has_category_sub_categories1_idx` (`sub_categories_id`),
  CONSTRAINT `fk_brand_has_category_brand1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `fk_brand_has_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_brand_has_category_sub_categories1` FOREIGN KEY (`sub_categories_id`) REFERENCES `sub_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_has_category`
--

LOCK TABLES `brand_has_category` WRITE;
/*!40000 ALTER TABLE `brand_has_category` DISABLE KEYS */;
INSERT INTO `brand_has_category` VALUES (1,1,1,1),(2,4,1,2),(3,5,1,1),(4,10,1,3),(5,6,5,20),(6,7,6,0),(7,8,5,17),(8,4,1,1),(9,20,2,19),(10,21,2,19),(11,22,3,6);
/*!40000 ALTER TABLE `brand_has_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `cart_qty` int NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `variant_id` int NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `fk_cart_user1_idx` (`user_email`),
  KEY `fk_cart_variant1_idx` (`variant_id`),
  CONSTRAINT `fk_cart_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_cart_variant1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (27,3,'raviduyashith123@gmail.com',1),(28,2,'raviduyashith123@gmail.com',12);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Guitars'),(2,'Violins,Ukules, Mandarines & Banjos'),(3,'Drums & Percussion Instruments'),(4,'Wind & Woodwind Instruments'),(5,'Keyboards, Pianoes & MIDI'),(6,'Microphones, Sound Systems & Accessories'),(7,'Amplifiers & Mixers');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `city_id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(45) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'Kuliyapitiya'),(2,'Pannala');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city_has_district`
--

DROP TABLE IF EXISTS `city_has_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city_has_district` (
  `city_has_district_id` int NOT NULL AUTO_INCREMENT,
  `city_city_id` int NOT NULL,
  `district_district_id` int NOT NULL,
  PRIMARY KEY (`city_has_district_id`),
  KEY `fk_city_has_district_district1_idx` (`district_district_id`),
  KEY `fk_city_has_district_city1_idx` (`city_city_id`),
  CONSTRAINT `fk_city_has_district_city1` FOREIGN KEY (`city_city_id`) REFERENCES `city` (`city_id`),
  CONSTRAINT `fk_city_has_district_district1` FOREIGN KEY (`district_district_id`) REFERENCES `district` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city_has_district`
--

LOCK TABLES `city_has_district` WRITE;
/*!40000 ALTER TABLE `city_has_district` DISABLE KEYS */;
INSERT INTO `city_has_district` VALUES (1,2,8),(2,2,17);
/*!40000 ALTER TABLE `city_has_district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condition`
--

DROP TABLE IF EXISTS `condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition_name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condition`
--

LOCK TABLES `condition` WRITE;
/*!40000 ALTER TABLE `condition` DISABLE KEYS */;
INSERT INTO `condition` VALUES (1,'Brand New'),(2,'Used'),(3,'Refurbished');
/*!40000 ALTER TABLE `condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cover_images`
--

DROP TABLE IF EXISTS `cover_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cover_images` (
  `cover_images_id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(150) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`cover_images_id`),
  KEY `fk_images_product1_idx` (`product_id`),
  CONSTRAINT `fk_images_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cover_images`
--

LOCK TABLES `cover_images` WRITE;
/*!40000 ALTER TABLE `cover_images` DISABLE KEYS */;
INSERT INTO `cover_images` VALUES (1,'resources//cover_images//Gibson_EDS_1275_test.jpg',1),(4,'resources//cover_images//product_id_4_1_63de831c84fda.jpeg',4),(5,'resources//cover_images//Gibson EDS-1275_red.jpg',1),(6,'resources//cover_images//Gibson EDS-1275_redandblack.jpg',1),(9,'resources//cover_images//product_id_1_63f72e422aecc.jpeg',1),(12,'resources//cover_images//product_id_7_658dbf31b4600.jpeg',7),(13,'resources//cover_images//product_id_7_658dbf31b54d8.jpeg',7),(14,'resources//cover_images//product_id_8_658dd9088ebaf.jpeg',8),(15,'resources//cover_images//product_id_8_658dd9088f706.jpeg',8),(16,'resources//cover_images//product_id_8_658dd90890097.jpeg',8),(17,'resources//cover_images//product_id_9_667d82b4b7aab.jpeg',9),(18,'resources//cover_images//product_id_10_667d83d733703.jpeg',10);
/*!40000 ALTER TABLE `cover_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `district` (
  `district_id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `province_province_id` int NOT NULL,
  PRIMARY KEY (`district_id`),
  KEY `fk_district_province1_idx` (`province_province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_province_id`) REFERENCES `province` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (1,'Jafna',1),(2,'Kilinochchi',1),(3,'Mulathivu',1),(4,'Mannar',1),(5,'Vavuniya',1),(6,'Anuradhapura',2),(7,'Polonnaruwa',2),(8,'Kurunegala',3),(9,'Puttalam',3),(10,'Trincomalee',5),(11,'Batticaloa',5),(12,'Ampara',5),(13,'Matale',6),(14,'Kandy',6),(15,'Nuwara Eliya',6),(16,'Gampaha',4),(17,'Colombo',4),(18,'Kaluthara',4),(19,'Kegalla',7),(20,'Rathnpura',7),(21,'Badulla',8),(22,'Moneragla',8),(23,'Galle',9),(24,'Matara',9),(25,'Hambanthota',9);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gender` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (1,'Male'),(2,'Female');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `inv_id` varchar(20) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `order_date` datetime NOT NULL,
  PRIMARY KEY (`inv_id`),
  KEY `fk_user_has_variant_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_variant_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` VALUES ('667c92dc850c8','raviduyashith123@gmail.com','2023-12-27 03:44:52'),('667ccb08dcd41','raviduyashith123@gmail.com','2024-02-27 07:44:32'),('667cceadd8e0d','raviduyashith123@gmail.com','2024-06-25 08:00:05'),('667cd479dc98c','raviduyashith123@gmail.com','2024-06-25 08:24:49'),('667cd5787ea5f','raviduyashith123@gmail.com','2024-06-27 08:29:04'),('667db158efad0','raviduyashith123@gmail.com','2024-06-28 00:07:12');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(20) NOT NULL,
  `variant_id` int NOT NULL,
  `inv_qty` int NOT NULL,
  `buying_price` double NOT NULL,
  `discount_given` double NOT NULL,
  `buying_del_fee` double NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_invoice_has_variant_variant1_idx` (`variant_id`),
  KEY `fk_items_invoice1_idx` (`invoice_id`),
  CONSTRAINT `fk_invoice_has_variant_variant1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`),
  CONSTRAINT `fk_items_invoice1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'667c92dc850c8',1,2,2000,8,3000),(2,'667c92dc850c8',8,1,1000,0,2000),(3,'667ccb08dcd41',1,1,2000,8,3000),(14,'667cceadd8e0d',1,3,2000,8,3000),(15,'667cd479dc98c',1,3,2000,8,3000),(18,'667cd479dc98c',8,1,1000,0,2000),(19,'667cd5787ea5f',8,3,1000,0,2000);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model_name` varchar(45) NOT NULL,
  `brand_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_model_brand1_idx` (`brand_id`),
  CONSTRAINT `fk_model_brand1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (1,'ES-175',1),(2,'Stratocaster',5),(3,'Telecaster',5),(4,'EDS-1275',1),(5,'LXIE',10),(6,'D-45',10),(7,'ES-335 Dot GM',1),(8,'Nikola Zubak Violin Outfit 4/4',20),(9,'110VN Sebastian Series',21),(10,'Roland VR09B Live Performance Keyboard',8),(11,'Atlas Tuneable 12inch Tambourine',22);
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_passwords`
--

DROP TABLE IF EXISTS `old_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `old_passwords` (
  `id` int NOT NULL AUTO_INCREMENT,
  `old_password` varchar(20) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_old_passwords_user1_idx` (`user_email`),
  CONSTRAINT `fk_old_passwords_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_passwords`
--

LOCK TABLES `old_passwords` WRITE;
/*!40000 ALTER TABLE `old_passwords` DISABLE KEYS */;
INSERT INTO `old_passwords` VALUES (1,'123456','raviduyashith123@gmail.com'),(3,'1234567','raviduyashith123@gmail.com'),(4,'Ry@12345','raviduyashith123@gmail.com');
/*!40000 ALTER TABLE `old_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_passwords_admin`
--

DROP TABLE IF EXISTS `old_passwords_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `old_passwords_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `old_password` varchar(20) NOT NULL,
  `admin_email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_old_password_admin_admin1_idx` (`admin_email`),
  CONSTRAINT `fk_old_password_admin_admin1` FOREIGN KEY (`admin_email`) REFERENCES `admin` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_passwords_admin`
--

LOCK TABLES `old_passwords_admin` WRITE;
/*!40000 ALTER TABLE `old_passwords_admin` DISABLE KEYS */;
INSERT INTO `old_passwords_admin` VALUES (1,'Admin@123','rvsoftwaresolutions1@gmail.com');
/*!40000 ALTER TABLE `old_passwords_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `brand_has_category_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_product_model1_idx` (`model_id`),
  KEY `fk_product_brand_has_category1_idx` (`brand_has_category_id`),
  CONSTRAINT `fk_product_brand_has_category1` FOREIGN KEY (`brand_has_category_id`) REFERENCES `brand_has_category` (`id`),
  CONSTRAINT `fk_product_model1` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,4,'Gibson EDS-1275',1,1),(4,8,'Nikola Zubak Violin Outfit 4/4',9,1),(7,9,'Knilling 110VN Sebastian Series',10,1),(8,2,'Fender Stratocaster',3,0),(9,10,'Roland VR09B Live Performance Keyboard',7,1),(10,11,'Atlas Tuneable 12inch Tambourine | Hobgo',11,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_deactivation_history`
--

DROP TABLE IF EXISTS `product_deactivation_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_deactivation_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `date_time` datetime NOT NULL,
  `product_id` int NOT NULL,
  `admin_email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_deactivation_history_product1_idx` (`product_id`),
  KEY `fk_product_deactivation_history_admin1_idx` (`admin_email`),
  CONSTRAINT `fk_product_deactivation_history_admin1` FOREIGN KEY (`admin_email`) REFERENCES `admin` (`email`),
  CONSTRAINT `fk_product_deactivation_history_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_deactivation_history`
--

LOCK TABLES `product_deactivation_history` WRITE;
/*!40000 ALTER TABLE `product_deactivation_history` DISABLE KEYS */;
INSERT INTO `product_deactivation_history` VALUES (1,'Damaged goods were found.','2023-02-22 11:15:52',1,'rvsoftwaresolutions1@gmail.com'),(2,'Damaged goods were found','2023-03-24 18:54:50',4,'rvsoftwaresolutions1@gmail.com'),(3,'Damaged goods were found','2023-03-24 19:00:11',4,'rvsoftwaresolutions1@gmail.com'),(4,'test','2024-06-21 08:37:19',8,'rvsoftwaresolutions1@gmail.com'),(5,'testing buynow when deactive','2024-06-21 21:48:25',4,'rvsoftwaresolutions1@gmail.com'),(6,'testing','2024-06-21 21:52:55',4,'rvsoftwaresolutions1@gmail.com'),(7,'test 2 buynow when deactive','2024-06-21 21:53:36',4,'rvsoftwaresolutions1@gmail.com'),(8,'test 3 buynow when deactive','2024-06-21 22:01:38',4,'rvsoftwaresolutions1@gmail.com');
/*!40000 ALTER TABLE `product_deactivation_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `date_time` datetime NOT NULL,
  `product_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `star_count` tinyint NOT NULL,
  `item_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_reviews_product1_idx` (`product_id`),
  KEY `fk_product_reviews_user1_idx` (`user_email`),
  KEY `fk_product_reviews_variant1_idx` (`variant_id`),
  KEY `fk_product_reviews_items1_idx` (`item_id`),
  CONSTRAINT `fk_product_reviews_items1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  CONSTRAINT `fk_product_reviews_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_product_reviews_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_product_reviews_variant1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
INSERT INTO `product_reviews` VALUES (1,'Product is good. Sounds good!','2023-02-25 10:40:33',1,1,'raviduyashith123@gmail.com',5,1),(4,'Product is awesome','2023-01-25 10:40:33',4,8,'raviduyashith123@gmail.com',4,18),(5,'Product is damaged. Packaging is not good','2023-01-25 10:40:33',4,8,'aakil@gmail.com',1,19),(6,'Product is super.','2024-06-27 19:51:10',1,1,'raviduyashith123@gmail.com',5,3);
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_images`
--

DROP TABLE IF EXISTS `profile_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profile_images_user1_idx` (`user_email`),
  CONSTRAINT `fk_profile_images_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_images`
--

LOCK TABLES `profile_images` WRITE;
/*!40000 ALTER TABLE `profile_images` DISABLE KEYS */;
INSERT INTO `profile_images` VALUES (1,'resources//profile_images//Ravidu_63e4b3482ad68.jpeg','raviduyashith123@gmail.com');
/*!40000 ALTER TABLE `profile_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `province` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(45) NOT NULL,
  PRIMARY KEY (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `province`
--

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` VALUES (1,'North Province'),(2,'North Central Province'),(3,'North Western Province'),(4,'Western Province'),(5,'Eastern Province'),(6,'Central Province'),(7,'Sabaragamuwa Province'),(8,'Uva Province'),(9,'Southern Province');
/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recent`
--

DROP TABLE IF EXISTS `recent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recent` (
  `recent_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(150) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`recent_id`),
  KEY `fk_recent_user1_idx` (`user_email`),
  KEY `fk_recent_product1_idx` (`product_id`),
  CONSTRAINT `fk_recent_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_recent_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recent`
--

LOCK TABLES `recent` WRITE;
/*!40000 ALTER TABLE `recent` DISABLE KEYS */;
/*!40000 ALTER TABLE `recent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(45) DEFAULT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sub_categories_category1_idx` (`category_id`),
  CONSTRAINT `fk_sub_categories_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (1,'Acoustic Guitars',1),(2,'Classical Guitars',1),(3,'Electric Guitars',1),(4,'Bass Guitars',1),(5,'Bongo',3),(6,'Tambourine',3),(7,'Drums',3),(8,'Ukules',2),(9,'Mandarines',2),(10,'Banjos',2),(11,'Wooden Flutes',4),(12,'Metal Flutes',4),(13,'Trumpets',4),(14,'Clarinet',4),(15,'Saxophone',4),(16,'French Horn',4),(17,'Keyboards',5),(18,'MIDI',5),(19,'Violins',2),(20,'Pianos',5);
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `email` varchar(150) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `password` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `joined_date` datetime NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `verification_code` varchar(20) DEFAULT NULL,
  `gender_id` int NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_user_gender_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('aakil@gmail.com','Aakil','Mohomed','+94761234567','Ak@1234','2001-12-09','2022-11-16 08:51:14',1,NULL,1),('ravidu@gmail.com','Ravidu','Vithana','+94763738203','1234Ryvk@','2003-04-13','2024-06-07 12:37:14',1,NULL,1),('raviduyashith123@gmail.com','Ravidu','Vithana','+94763738202','Ry@2345','2002-07-08','2022-11-05 21:16:54',1,'667db0402a9ba',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_address` (
  `user_address_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(150) NOT NULL,
  `line1` text,
  `line2` text,
  `postal_code` mediumint DEFAULT NULL,
  `city_has_district_id_id` int NOT NULL,
  PRIMARY KEY (`user_address_id`),
  KEY `fk_city_has_user_user1_idx` (`user_email`),
  KEY `fk_user_address_city_has_district1_idx` (`city_has_district_id_id`),
  CONSTRAINT `fk_city_has_user_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_user_address_city_has_district1` FOREIGN KEY (`city_has_district_id_id`) REFERENCES `city_has_district` (`city_has_district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_address`
--

LOCK TABLES `user_address` WRITE;
/*!40000 ALTER TABLE `user_address` DISABLE KEYS */;
INSERT INTO `user_address` VALUES (1,'raviduyashith123@gmail.com','283/1, Bammanna Road','Kudalupoththa, Narangoda.',60152,1);
/*!40000 ALTER TABLE `user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_blocking_history`
--

DROP TABLE IF EXISTS `user_blocking_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_blocking_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `admin_email` varchar(150) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_blocking_history_user1_idx` (`user_email`),
  KEY `fk_user_blocking_history_admin1_idx` (`admin_email`),
  CONSTRAINT `fk_user_blocking_history_admin1` FOREIGN KEY (`admin_email`) REFERENCES `admin` (`email`),
  CONSTRAINT `fk_user_blocking_history_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_blocking_history`
--

LOCK TABLES `user_blocking_history` WRITE;
/*!40000 ALTER TABLE `user_blocking_history` DISABLE KEYS */;
INSERT INTO `user_blocking_history` VALUES (4,'trying to enter incorrect payment details repeatedly','raviduyashith123@gmail.com','rvsoftwaresolutions1@gmail.com','2023-03-24 19:05:17'),(5,'Giving false feedbacks','raviduyashith123@gmail.com','rvsoftwaresolutions1@gmail.com','2023-03-24 19:16:14');
/*!40000 ALTER TABLE `user_blocking_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variant`
--

DROP TABLE IF EXISTS `variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variant_title` varchar(45) DEFAULT NULL,
  `price` double NOT NULL,
  `qty` int NOT NULL,
  `description` text NOT NULL,
  `datetime_added` datetime NOT NULL,
  `delivery_fee_within_colombo` double NOT NULL,
  `delivery_fee_outside_colombo` double NOT NULL,
  `product_id` int NOT NULL,
  `condition_id` int NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `image_path` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_variant_product1_idx` (`product_id`),
  KEY `fk_variant_condition1_idx` (`condition_id`),
  CONSTRAINT `fk_variant_condition1` FOREIGN KEY (`condition_id`) REFERENCES `condition` (`id`),
  CONSTRAINT `fk_variant_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variant`
--

LOCK TABLES `variant` WRITE;
/*!40000 ALTER TABLE `variant` DISABLE KEYS */;
INSERT INTO `variant` VALUES (1,'Gibson EDS-1275 Red and Orange',2000,9,'test description','2023-01-25 10:40:33',2500,3000,1,1,8,'resources//variant_images//product_id_1_63f82a185b6c9.jpeg'),(2,'Gibson EDS-1275 Red',243000,0,'test description','2023-01-25 10:40:33',2500,3000,1,1,0,'resources//variant_images//product_id_1_63e5c259a5342.jpg'),(4,'Gibson EDS-1275 Red and Yellow',245000,13,'Test description','2023-01-31 18:37:47',2500,3000,1,1,7,'resources//variant_images//product_id_1_641fb46560f2f.jpeg'),(8,'Nikola Zubak Violin Outfit 4/4',1000,0,'Test Description','2023-02-04 21:39:00',2500,3000,4,1,0,'resources//variant_images//product_id_4_63de831c85ad6.jpeg'),(9,'Gibson EDS-1275 Red and Black',250000,4,'Test','2023-03-23 11:12:12',2000,2800,1,1,10,'resources//variant_images//product_id_1_641be6b4e482e.jpeg'),(12,'Knilling 110VN Sebastian Series Model 01',167000,10,'Sample description','2023-12-29 00:02:17',1000,2000,7,1,5,'resources//variant_images//product_id_7_658dbf31b639c.jpeg'),(13,'Fender Stratocaster Red and white',210000,4,'Something','2023-12-29 01:52:32',1000,2000,8,1,4,'resources//variant_images//product_id_8_658dd90890b23.jpeg'),(14,'Fender Stratocaster Black, Brown and White',215000,3,'Something','2023-12-29 01:52:32',1000,2000,8,1,5,'resources//variant_images//product_id_8_658dd90891ef6.jpeg'),(15,'Fender Stratocaster Grey and white',220000,4,'Something','2023-12-29 01:52:32',1000,2000,8,1,3,'resources//variant_images//product_id_8_658dd90892fd0.jpeg'),(16,'Roland VR09B Live Performance Keyboard',250000,10,'Roland test description','2024-06-27 20:48:12',2500,3000,9,1,0,'resources//variant_images//product_id_9_667d82b4b8504.jpeg'),(17,'Atlas Tuneable 12inch Tambourine | Hobgo',25000,10,'Test product','2024-06-27 20:53:03',1000,1500,10,2,0,'resources//variant_images//product_id_10_667d83d734282.jpeg');
/*!40000 ALTER TABLE `variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variant_history`
--

DROP TABLE IF EXISTS `variant_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variant_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `new_price` double NOT NULL DEFAULT '0',
  `del_fee_colombo` double NOT NULL DEFAULT '0',
  `del_fee_outside` double NOT NULL DEFAULT '0',
  `datetime_updated` datetime NOT NULL,
  `variant_id` int NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `fk_variant_history_variant1_idx` (`variant_id`),
  CONSTRAINT `fk_variant_history_variant1` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variant_history`
--

LOCK TABLES `variant_history` WRITE;
/*!40000 ALTER TABLE `variant_history` DISABLE KEYS */;
INSERT INTO `variant_history` VALUES (1,2000,0,0,'2024-06-22 20:28:47',1),(2,2500,0,0,'2024-06-22 20:32:43',1),(3,2450,0,0,'2024-06-22 20:33:12',4),(4,2800,0,0,'2024-06-22 20:33:12',9),(5,245000,0,0,'2024-06-22 20:34:22',4),(6,250000,2000,2800,'2024-06-22 20:34:22',9);
/*!40000 ALTER TABLE `variant_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `wishlist_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(150) NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`wishlist_id`),
  KEY `fk_wishlist_user1_idx` (`user_email`),
  KEY `fk_wishlist_product1_idx` (`product_id`),
  CONSTRAINT `fk_wishlist_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_wishlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (20,'raviduyashith123@gmail.com',4),(21,'raviduyashith123@gmail.com',1);
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-16 20:50:05
