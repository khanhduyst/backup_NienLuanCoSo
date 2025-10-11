-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: lkd_smart
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `record_id` int DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (27,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu IPHONE','2025-09-23 14:39:07'),(28,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu SAMSUNG','2025-09-23 14:39:16'),(29,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu XIAOMI','2025-09-23 14:39:20'),(30,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu IOS','2025-09-23 15:12:56'),(31,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu Android','2025-09-23 15:16:36'),(32,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-24 11:33:32'),(33,2,'UPDATE','os',1,'Người dùng admin đã cập nhật hệ điều hành IOS 15','2025-09-24 12:26:20'),(34,2,'UPDATE','os',1,'Người dùng admin đã cập nhật hệ điều hành IOS 15','2025-09-24 12:26:28'),(35,2,'DELETE','os',1,'Người dùng admin đã xoá hệ điều hành ','2025-09-24 12:29:07'),(36,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu IOS','2025-09-24 12:29:12'),(37,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-26 13:28:25'),(38,2,'INSERT','rams',NULL,'Người dùng admin đã thêm Ram: 4G','2025-09-26 14:28:37'),(39,2,'INSERT','rams',NULL,'Người dùng admin đã thêm Ram: 6GB','2025-09-26 14:29:27'),(40,2,'DELETE','rams',2,'Người dùng admin đã xoá Rams: ','2025-09-26 14:37:46'),(41,2,'INSERT','rams',NULL,'Người dùng admin đã thêm Ram: 6GB','2025-09-26 14:37:50'),(42,2,'UPDATE','rams',3,'Người dùng admin đã cập nhật Ram ','2025-09-26 14:37:53'),(43,2,'UPDATE','brands',8,'Người dùng admin đã cập nhật thương hiệu IPHONE','2025-09-26 14:38:56'),(44,2,'UPDATE','os',3,'Người dùng admin đã cập nhật hệ điều hành IOS','2025-09-26 14:39:59'),(45,2,'LOGOUT','users',NULL,'Người dùng \'admin\' đã đăng xuất hệ thống','2025-09-26 14:48:18'),(46,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-26 14:48:24'),(47,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu OPPO','2025-09-26 15:00:02'),(48,2,'INSERT','storages',NULL,'Người dùng admin đã thêm bộ nhớ: 64GB','2025-09-26 15:09:13'),(49,2,'INSERT','storages',NULL,'Người dùng admin đã thêm bộ nhớ: 32GB','2025-09-26 15:09:21'),(50,2,'INSERT','storages',NULL,'Người dùng admin đã thêm bộ nhớ: 128GB','2025-09-26 15:09:28'),(51,2,'UPDATE','storages',2,'Người dùng admin đã cập nhật bộ nhớ ','2025-09-26 15:14:52'),(52,2,'UPDATE','storages',2,'Người dùng admin đã cập nhật bộ nhớ ','2025-09-26 15:17:35'),(53,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-26 15:20:33'),(54,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-28 13:40:38'),(55,2,'INSERT','colors',NULL,'Người dùng admin đã thêm màu: Xanh Biển','2025-09-28 13:56:46'),(56,2,'INSERT','colors',NULL,'Người dùng admin đã thêm màu: Xanh Biển','2025-09-28 13:57:50'),(57,2,'INSERT','colors',NULL,'Người dùng admin đã thêm màu: vàng','2025-09-28 14:01:33'),(58,2,'UPDATE','colors',2,'Người dùng admin đã cập nhật màu Xanh Biển','2025-09-28 14:05:29'),(59,2,'DELETE','colors',2,'Người dùng admin đã xoá màu ','2025-09-28 14:05:35'),(60,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu MediaTek Helio','2025-09-28 14:32:18'),(61,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu Snapdragon','2025-09-28 14:32:54'),(62,2,'DELETE','brands',13,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:17'),(63,2,'DELETE','brands',12,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:19'),(64,2,'DELETE','brands',11,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:21'),(65,2,'DELETE','brands',10,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:23'),(66,2,'DELETE','brands',9,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:24'),(67,2,'DELETE','brands',8,'Người dùng admin đã xoá thương hiệu ','2025-09-28 14:37:26'),(68,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu Snapdragon','2025-09-28 14:43:56'),(69,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu SamSung','2025-09-28 14:49:53'),(70,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu IOS','2025-09-28 14:57:25'),(71,2,'INSERT','brands',NULL,'Người dùng admin đã thêm thương hiệu IPHONE','2025-09-28 14:57:34'),(72,2,'UPDATE','brands',16,'Người dùng admin đã cập nhật thương hiệu IOS','2025-09-28 14:57:45'),(73,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-29 14:04:09'),(74,2,'LOGOUT','users',NULL,'Người dùng \'admin\' đã đăng xuất hệ thống','2025-09-29 15:22:55'),(75,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-09-30 13:24:15'),(76,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 14:05:28'),(77,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 14:12:41'),(78,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 14:25:05'),(79,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 14:29:28'),(80,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 14:38:25'),(81,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 15:01:50'),(82,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 15:10:44'),(83,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-09-30 15:14:28'),(84,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 17 Pro','2025-09-30 15:16:42'),(85,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 8 Pro','2025-09-30 15:19:26'),(86,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Pro','2025-09-30 15:21:21'),(87,2,'LOGIN','users',NULL,'Người dùng admin đã đăng nhập hệ thống','2025-10-01 13:51:13'),(88,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosa','2025-10-01 13:51:35'),(89,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasd','2025-10-01 13:55:17'),(90,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasdsss','2025-10-01 13:55:41'),(91,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasdssssss','2025-10-01 13:56:10'),(92,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasdssssssss','2025-10-01 13:58:03'),(93,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasdsssssssssa','2025-10-01 13:58:18'),(94,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: Điện thoại iPhone 1 a8 Prosaasdsssssssssaa','2025-10-01 13:59:05'),(95,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: sa','2025-10-01 14:01:58'),(96,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: sasa','2025-10-01 14:02:41'),(97,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: sa','2025-10-01 14:31:54'),(98,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: ss','2025-10-01 14:48:42'),(99,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: c','2025-10-01 14:51:11'),(100,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: x','2025-10-01 14:51:14'),(101,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: a','2025-10-01 14:53:53'),(102,2,'INSERT','product',NULL,'Người dùng admin đã thêm sản phẩm: iPhone 16 Pro 128GB','2025-10-01 15:13:27');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (14,'Snapdragon',1,0,'2025-09-28 14:43:56'),(15,'SamSung',1,1,'2025-09-28 14:49:53'),(16,'IOS',1,1,'2025-09-28 14:57:25'),(17,'IPHONE',1,1,'2025-09-28 14:57:34');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chips`
--

DROP TABLE IF EXISTS `chips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chip_brand` (`brand_id`),
  CONSTRAINT `fk_chip_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chips`
--

LOCK TABLES `chips` WRITE;
/*!40000 ALTER TABLE `chips` DISABLE KEYS */;
/*!40000 ALTER TABLE `chips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'Xanh Biển','#004cff',1,'2025-09-28 13:56:46'),(3,'vàng','#ffdd00',0,'2025-09-28 14:01:33');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `variant_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `variant_id` (`variant_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_district` varchar(100) DEFAULT NULL,
  `shipping_province` varchar(100) DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `os`
--

DROP TABLE IF EXISTS `os`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `os` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `os`
--

LOCK TABLES `os` WRITE;
/*!40000 ALTER TABLE `os` DISABLE KEYS */;
INSERT INTO `os` VALUES (2,'Android',1,'2025-09-23 15:16:36'),(3,'IOS',1,'2025-09-24 12:29:12');
/*!40000 ALTER TABLE `os` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_main` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (23,26,'1759331607_0_iphone-16-pro-max-titan-sa-mac-9-638638962388943852-180x125.jpg',0,'2025-10-01 15:13:27'),(24,26,'1759331607_1_iphone-16-pro-max-titan-sa-mac-5-638638962363556047-180x125.jpg',0,'2025-10-01 15:13:27'),(25,26,'1759331607_2_iphone-16-pro-max-titan-sa-mac-3-638638962351331027-180x125.jpg',0,'2025-10-01 15:13:27'),(26,26,'1759331607_3_iphone-16-pro-max-titan-sa-mac-2-638638962343879149-180x125.jpg',0,'2025-10-01 15:13:27'),(27,26,'1759331607_4_iphone-16-pro-max-titan-sa-mac-1-638638962337813406-180x125.jpg',0,'2025-10-01 15:13:27');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `ram_id` int NOT NULL,
  `storage_id` int NOT NULL,
  `color_id` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `ram_id` (`ram_id`),
  KEY `storage_id` (`storage_id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`ram_id`) REFERENCES `rams` (`id`),
  CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`storage_id`) REFERENCES `storages` (`id`),
  CONSTRAINT `product_variants_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `screen_technology` varchar(100) DEFAULT NULL,
  `screen_size` varchar(100) DEFAULT NULL,
  `front_camera` varchar(255) DEFAULT NULL,
  `rear_camera` varchar(255) DEFAULT NULL,
  `battery_capacity` varchar(100) DEFAULT NULL,
  `categories` varchar(50) DEFAULT NULL,
  `img_main` varchar(255) DEFAULT NULL,
  `sim_card` varchar(50) DEFAULT NULL,
  `description` text,
  `brand_id` int DEFAULT NULL,
  `os_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `chip_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_chip` (`chip_id`),
  KEY `products_ibfk_1` (`brand_id`),
  KEY `products_ibfk_2` (`os_id`),
  CONSTRAINT `fk_chip` FOREIGN KEY (`chip_id`) REFERENCES `chips` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`os_id`) REFERENCES `os` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (26,'iPhone 16 Pro 128GB','Super Retina XDR OLED','	 6.3 inches','12MP, ƒ/1.9, Tự động lấy nét theo pha Focus Pixels','	\r\nCamera chính: 48MP, f/1.78, 24mm, chống rung quang học dịch chuyển cảm biến thế hệ thứ hai, Focus Pixels 100%, hỗ trợ ảnh có độ phân giải siêu cao\r\nHỗ trợ Telephoto 2x 12MP: 52 mm, ƒ/1.6\r\nCamera góc siêu rộng: 48MP, 13 mm, ƒ/2.2 và trường ảnh 120°, H','5000 mAh','phone','1759331607_iphone-16-pro-max-sa-mac-thumb-1-600x600.jpg','Sim kép (nano-Sim và e-Sim) - Hỗ trợ 2 e-Sim','<h2><strong>Đ&aacute;nh gi&aacute; iPhone 16 Pro: sức mạnh khủng, thiết kế đẳng cấp</strong></h2>\r\n\r\n<p><strong>Điện thoại iPhone 16 Pro (128GB, 256GB, 512GB, 1TB)</strong>&nbsp;l&agrave; một trong những si&ecirc;u phẩm đ&aacute;ng gờm của&nbsp;<strong>series iPhone 16</strong>&nbsp;được nh&agrave; T&aacute;o mang đến người d&ugrave;ng. H&atilde;y c&ugrave;ng CellphoneS đ&aacute;nh gi&aacute; iP 16 Pro c&oacute; g&igrave; mới qua c&aacute;c nội dung ch&iacute;nh sau:</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>N&uacute;t Điều Khiển Camera mới, tối ưu trải nghiệm quay chụp</p>\r\n	</li>\r\n	<li>\r\n	<p>T&iacute;ch hợp Apple Intelligence</p>\r\n	</li>\r\n	<li>\r\n	<p>Camera 48MP n&acirc;ng cấp, quay video 4K&nbsp;l&ecirc;n đến 120fps</p>\r\n	</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Camera Ultra Wide 48MP, chụp ảnh cận cảnh sắc n&eacute;t</p>\r\n	</li>\r\n	<li>\r\n	<p>Quay video với &Acirc;m thanh Kh&ocirc;ng gian v&agrave; hậu kỳ với Ho&agrave; &Acirc;m</p>\r\n	</li>\r\n	<li>\r\n	<p>Chipset A18 Pro mạnh mẽ bậc nhất</p>\r\n	</li>\r\n	<li>\r\n	<p>Tăng thời lượng pin, sử dụng li&ecirc;n tục đến 27 giờ</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>Chi tiết như sau:</p>\r\n\r\n<h3>N&uacute;t Điều Khiển Camera mới, tối ưu trải nghiệm quay chụp</h3>\r\n\r\n<p><strong>N&uacute;t Điều Khiển Camera</strong>&nbsp;(Camera Control) l&agrave; một&nbsp;<strong>thiết kế mới</strong>&nbsp;tr&ecirc;n thế hệ&nbsp;<strong>smartphone iPhone 16 Pro</strong>. N&uacute;t điều khiển mới n&agrave;y được đặt ở&nbsp;<strong>cạnh viền b&ecirc;n phải</strong>&nbsp;với viền th&eacute;p bao quanh, bề mặt kết cấu mịn từ tinh thể sapphire. B&ecirc;n dưới n&uacute;t l&agrave; cảm biến lực với độ ch&iacute;nh x&aacute;c cao gi&uacute;p mang lại khả năng phản hồi thao t&aacute;c người d&ugrave;ng ch&iacute;nh x&aacute;c từ bấm tới vuốt.</p>\r\n\r\n<p><img alt=\"Nút Điều Khiển Camera là một thiết kế mới trên thế hệ iPhone 16 Pro\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/dien-thoai-iphone-16-pro-7.jpg\" /></p>\r\n\r\n<p><em>N&uacute;t Điều Khiển Camera l&agrave; một thiết kế mới tr&ecirc;n thế hệ iPhone 16 Pro (Nguồn ảnh: Apple)</em></p>\r\n\r\n<p>Với n&uacute;t Điều Khiển Camera n&agrave;y, người d&ugrave;ng c&oacute; thể điều khiển khả năng quay chụp tiện lợi như bấm để khởi động camera, bấm để chụp v&agrave; ghi h&igrave;nh. Kh&ocirc;ng chỉ đơn giản l&agrave; chụp, người d&ugrave;ng c&oacute; thể ấn nhẹ để mở c&ocirc;ng cụ điều khiển v&agrave; trượt để thay đổi độ thu ph&oacute;ng, phơi s&aacute;ng, thậm ch&iacute; l&agrave; độ s&acirc;u trường ảnh.</p>\r\n\r\n<h3><strong>T&iacute;ch hợp&nbsp;Apple Intelligence tr&ecirc;n iPhone 16 Pro mới</strong></h3>\r\n\r\n<p><strong>Điện thoại iPhone 16 Pro</strong>&nbsp;được t&iacute;ch hợp&nbsp;<strong>Apple Intelligence</strong>&nbsp;- Hệ thống tr&iacute; tuệ nh&acirc;n tạo do Apple ph&aacute;t triển ri&ecirc;ng cho iPhone, iPad, Macbook. Nhờ đ&oacute; hiệu suất l&agrave;m việc v&agrave; trải nghiệm sử dụng được cải thiện vượt trội. Cụ thể Apple Intelligence mang lại nhiều lợi &iacute;ch cho người d&ugrave;ng như:</p>\r\n\r\n<p>- Hỗ trợ&nbsp;<strong>t&oacute;m tắt b&agrave;i giảng hay cuộc tr&ograve; chuyện</strong>&nbsp;nhanh ch&oacute;ng chỉ trong v&agrave;i gi&acirc;y. Th&ocirc;ng qua c&ocirc;ng cụ viết c&ugrave;ng ng&ocirc;n ngữ n&acirc;ng cao hỗ trợ mang lại những đoạn văn từ ngữ ph&ugrave; hợp. Đặc biệt sẽ c&oacute; nhiều phi&ecirc;n bản kh&aacute;c nhau cho người d&ugrave;ng lựa chọn nội dung với c&acirc;u c&uacute;, giọng văn ph&ugrave; hợp nhất. Điểm ấn tượng l&agrave; người d&ugrave;ng thậm ch&iacute; c&oacute; thể sử dụng c&ocirc;ng vụ n&agrave;y ở cả những những ứng dụng do b&ecirc;n thứ 3 ph&aacute;t triển.</p>\r\n\r\n<p>-&nbsp;<strong>Sắp xếp ưu ti&ecirc;n</strong>&nbsp;những thư quan trọng, sắp hết hạn ở đầu hộp thư. C&aacute;c th&ocirc;ng b&aacute;o quan trọng cũng được xếp ở đầu ngăn xếp nhờ đ&oacute; người d&ugrave;ng người c&oacute; thể ch&uacute; &yacute; dễ d&agrave;ng, kh&ocirc;ng bỏ lỡ những tin quan trọng.</p>\r\n\r\n<p>-&nbsp;<strong>Chế độ tập trung</strong>&nbsp;mới: Thay v&igrave; loại bỏ to&agrave;n ho&agrave;n c&aacute;c tin tức, chế độ tập trung mới vẫn cho ph&eacute;p hiển thị những th&ocirc;ng tin cần người d&ugrave;ng ch&uacute; &yacute; ngay lập tức, v&iacute; dụ như đ&oacute;n con tan học.</p>\r\n\r\n<p><img alt=\"Những tính năng thông minh của Apple Intelligence trên iPhone 16 Pro\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/dien-thoai-iphone-16-pro-8.jpg\" /></p>\r\n\r\n<p><em>Những t&iacute;nh năng th&ocirc;ng minh của Apple Intelligence tr&ecirc;n iPhone 16 Pro (Nguồn ảnh: Apple)</em></p>\r\n\r\n<p>Đặc biệt Apple Intelligence hỗ trợ đảm bảo th&ocirc;ng tin cũng như&nbsp;<strong>sự ri&ecirc;ng tư</strong>&nbsp;của người d&ugrave;ng. C&ocirc;ng nghệ n&agrave;y được t&iacute;ch hợp v&agrave;o&nbsp;<a href=\"https://cellphones.com.vn/mobile/apple.html\" target=\"_blank\"><strong>iPhone</strong></a>&nbsp;c&oacute; thể nhận thức nhưng sẽ kh&ocirc;ng thu thập th&ocirc;ng tin của người d&ugrave;ng. Ch&uacute;ng sẽ chỉ chỉ sử dụng để thực hiện theo y&ecirc;u cầu người d&ugrave;ng v&agrave; sẽ kh&ocirc;ng được lưu trữ.</p>\r\n\r\n<h3>Camera 48MP n&acirc;ng cấp, quay video 4K</h3>\r\n\r\n<p><strong>iPhone 16 Pro</strong>&nbsp;sở hữu hệ thống camera chất lượng v&agrave; hiện đại bao gồm: camera&nbsp;<strong>Fusion 48MP</strong>, camera&nbsp;<strong>Ultra Wide 48MP</strong>&nbsp;v&agrave; camera&nbsp;<strong>Telephoto 5x</strong>&nbsp;độ ph&acirc;n giải 12MP. B&ecirc;n cạnh đ&oacute;, phần camera TrueDepth 12MP với khả năng chụp ch&acirc;n dung c&oacute; chức năng tự động lấy n&eacute;t Focus Pixels c&ugrave;ng nhiều t&iacute;nh năng độc đ&aacute;o. Ngo&agrave;i ra, người d&ugrave;ng c&oacute; thể quay video 4K Dolby Vision 120 fps ở chế độ video hoặc slo-mo.</p>\r\n\r\n<p><img alt=\"iPhone 16 Pro sở hữu hệ thống camera chất lượng và hiện đại bao gồm\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-3_1.jpg\" /></p>\r\n\r\n<p><em>iPhone 16 Pro sở hữu hệ thống camera chất lượng v&agrave; hiện đại bao gồm (Nguồn ảnh: Apple)</em></p>\r\n\r\n<h3>Chipset A18 Pro mạnh mẽ bậc nhất xuất hiện tr&ecirc;n iP 16 Pro</h3>\r\n\r\n<p>Chip&nbsp;<strong>A18 Pro</strong>&nbsp;tr&ecirc;n&nbsp;<strong>điện thoại</strong>&nbsp;<strong>iP 16 Pro</strong>&nbsp;đ&aacute;nh dấu bước tiến vượt bậc về sức mạnh v&agrave; hiệu quả năng lượng. Với&nbsp;<strong>CPU 6 l&otilde;i</strong>&nbsp;mới, chip xử l&yacute; c&aacute;c t&aacute;c vụ phức tạp với tốc độ nhanh hơn v&agrave; ti&ecirc;u thụ &iacute;t điện năng hơn, đảm bảo trải nghiệm mượt m&agrave; trong mọi ứng dụng.</p>\r\n\r\n<p><img alt=\"iP 16 Pro sở hữu chip A18 Pro mạnh mẽ với CPU 6 lõi mới\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/iphone-16-pro-2_1.jpg\" /></p>\r\n\r\n<p><em>iP 16 Pro sở hữu chip A18 Pro mạnh mẽ với CPU 6 l&otilde;i mới (Nguồn ảnh: Apple)</em></p>\r\n\r\n<p>B&ecirc;n cạnh đ&oacute;,&nbsp;<strong>GPU 6 l&otilde;i</strong>&nbsp;mang lại hiệu năng đồ họa ấn tượng, đặc biệt ph&ugrave; hợp cho c&aacute;c game AAA. Hệ thống băng th&ocirc;ng bộ nhớ được&nbsp;<strong>tăng gần 20%</strong>, gi&uacute;p tối ưu h&oacute;a hiệu suất to&agrave;n diện. Đặc biệt,&nbsp;<strong>Neural Engine 16 l&otilde;i</strong>&nbsp;cải tiến cho ph&eacute;p xử l&yacute; tr&iacute; tuệ nh&acirc;n tạo nhanh v&agrave; hiệu quả hơn, n&acirc;ng cao khả năng quay chụp v&agrave; l&agrave;m việc.</p>\r\n\r\n<p>Mặc d&ugrave; iPhone 16 Pro c&oacute; hiệu năng ấn tượng nhưng hiện nay c&aacute;c mẫu điện thoại được Apple ra mắt mới năm nay như&nbsp;<a href=\"https://cellphones.com.vn/mobile/apple/iphone-17.html\" target=\"_blank\"><strong>iPhone 17 series</strong></a>&nbsp;cũng l&agrave; một lựa chọn đ&aacute;ng c&acirc;n nhắc, c&ugrave;ng xem ngay. Với tốc độ xử l&yacute; vượt trội v&agrave; khả năng đa nhiệm mượt m&agrave;, thiết bị mang đến hiệu năng mạnh mẽ trong mọi t&aacute;c vụ.</p>\r\n\r\n<h3>Tăng thời lượng pin, sử dụng li&ecirc;n tục đến 27 giờ</h3>\r\n\r\n<p>Smartphone&nbsp;<strong>iPhone 16 Pro mới 2024</strong>&nbsp;mang đến thời lượng pin ấn tượng,&nbsp;<strong>tăng th&ecirc;m đến 4 giờ</strong>&nbsp;so với thế hệ trước. Nhờ thiết kế tối ưu h&oacute;a b&ecirc;n trong, pin lớn hơn v&agrave; chip A18 Pro cải tiến, iPhone 16 Pro c&oacute; thể duy tr&igrave; hiệu năng trong thời gian d&agrave;i d&ugrave; sử dụng nhiều t&iacute;nh năng mới.&nbsp;</p>\r\n\r\n<p><img alt=\"Dung lượng pin trên iPhone 16 Pro tăng thêm đến 4 giờ so với thế hệ trước\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/dien-thoai-iphone-16-pro-4.jpg\" /></p>\r\n\r\n<p><em>Dung lượng pin tr&ecirc;n iPhone 16 Pro tăng th&ecirc;m đến 4 giờ so với thế hệ trước (Nguồn ảnh: Apple)</em></p>\r\n\r\n<p>Với khả năng&nbsp;<strong>xem video c&oacute; thể l&ecirc;n đến 27 giờ</strong>, người d&ugrave;ng sẽ thoải m&aacute;i trải nghiệm m&agrave; kh&ocirc;ng lo ngại về pin. Tuy nhi&ecirc;n, tuỳ v&agrave;o t&aacute;c vụ sử dụng kh&aacute;c nhau, độ s&aacute;ng m&agrave;n h&igrave;nh, &acirc;m lượng m&agrave; thời gian sử dụng c&oacute; thể thay đổi. Sạc MagSafe cũng được cải thiện, cho ph&eacute;p sạc nhanh kh&ocirc;ng d&acirc;y l&ecirc;n đến 50% chỉ trong khoảng 30 ph&uacute;t với c&ocirc;ng suất tối đa 25W khi d&ugrave;ng bộ sạc 30W trở l&ecirc;n.</p>\r\n\r\n<h2><strong>iPhone 16 Pro c&oacute; mấy m&agrave;u? M&agrave;u n&agrave;o đẹp nhất?</strong></h2>\r\n\r\n<p>Thế hệ điện thoại&nbsp;<strong>iPhone 16 Pro mới</strong>&nbsp;c&oacute; tất cả&nbsp;<strong>4 phi&ecirc;n bản m&agrave;u</strong>&nbsp;l&agrave;: Titan Sa Mạc, Titan Tự Nhi&ecirc;n, Titan Trắng v&agrave; Titan Đen. Trong đ&oacute; c&oacute; ba m&agrave;u t&ecirc;n gọi cũ l&agrave;&nbsp;Titan Tự Nhi&ecirc;n, Titan Trắng v&agrave; Titan Đen nhưng sắc độ c&oacute; một ch&uacute;t thay đổi so với thế hệ 15 Pro.&nbsp;</p>\r\n\r\n<blockquote>\r\n<p><a href=\"https://cellphones.com.vn/iphone-17-pro.html\" target=\"_blank\">iPhone 16 Pro c&oacute; thời lượng pin ổn định, nhưng&nbsp;<strong>iPhone 17 Pro</strong>&nbsp;sẽ n&acirc;ng tầm trải nghiệm với pin lớn v&agrave; chip mới tối ưu hiệu năng. Thiết bị hoạt động bền bỉ, xử l&yacute; mượt m&agrave; từ đa nhiệm đến game nặng, trở th&agrave;nh lựa chọn đ&aacute;ng gi&aacute; cho người muốn n&acirc;ng cấp.</a></p>\r\n</blockquote>\r\n\r\n<p><img alt=\"iPhone 16 Pro có 4 màu, trong đó Titan Sa Mạc lần đầu tiên xuất hiện\" src=\"https://cdn2.cellphones.com.vn/insecure/rs:fill:0:0/q:90/plain/https://cellphones.com.vn/media/wysiwyg/Phone/Apple/iPhone-16/dien-thoai-iphone-16-pro-5.jpg\" /></p>\r\n\r\n<p><em>iPhone 16 Pro c&oacute; 4 m&agrave;u, trong đ&oacute; Titan Sa Mạc lần đầu ti&ecirc;n xuất hiện (Nguồn ảnh: Apple)</em></p>\r\n\r\n<p><strong>Titan Sa Mạc l&agrave; m&agrave;u sắc mới</strong>&nbsp;thay thế cho Titan Xanh. Đ&acirc;y cũng l&agrave; m&agrave;u sắc&nbsp;<strong>dự kiến hot nhất</strong>&nbsp;trong 4 phi&ecirc;n bản m&agrave;u năm nay.</p>\r\n',17,3,1,'2025-10-01 15:13:27',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rams`
--

DROP TABLE IF EXISTS `rams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `size` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rams`
--

LOCK TABLES `rams` WRITE;
/*!40000 ALTER TABLE `rams` DISABLE KEYS */;
INSERT INTO `rams` VALUES (1,'4G',1,'2025-09-26 14:28:37'),(3,'6GB',0,'2025-09-26 14:37:50');
/*!40000 ALTER TABLE `rams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variant_id` int NOT NULL,
  `change_type` enum('import','export') NOT NULL,
  `quantity` int NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `variant_id` (`variant_id`),
  CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storages`
--

DROP TABLE IF EXISTS `storages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `storages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `size` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storages`
--

LOCK TABLES `storages` WRITE;
/*!40000 ALTER TABLE `storages` DISABLE KEYS */;
INSERT INTO `storages` VALUES (1,'64GB',1,'2025-09-26 15:09:13'),(2,'32GB',0,'2025-09-26 15:09:21'),(3,'128GB',1,'2025-09-26 15:09:28');
/*!40000 ALTER TABLE `storages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin','Quản trị viên','admin@example.com','0123456789','12345','admin',1,'2025-09-22 16:06:28'),(5,'duy123','Người dùng Duy','duy@example.com','0987654321','1234','customer',1,'2025-09-22 16:27:28');
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

-- Dump completed on 2025-10-01 22:15:57
