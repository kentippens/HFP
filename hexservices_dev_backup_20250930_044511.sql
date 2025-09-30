-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: hexservices_dev
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
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
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `changes` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `batch_uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  KEY `activity_logs_causer_type_causer_id_index` (`causer_type`,`causer_id`),
  KEY `activity_logs_created_at_index` (`created_at`),
  KEY `activity_logs_subject_type_subject_id_log_name_index` (`subject_type`,`subject_id`,`log_name`),
  KEY `activity_logs_causer_type_causer_id_log_name_index` (`causer_type`,`causer_id`,`log_name`),
  KEY `activity_logs_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,'bulk','Test bulk operation',NULL,NULL,'bulk_test',NULL,NULL,'[]',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:04:06','2025-09-29 23:04:06'),(2,'export',':causer exported 10 test_resource',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"test_resource\", \"count\": 10, \"filters\": null}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:04:06','2025-09-29 23:04:06'),(3,'model',':causer updated Service Pool Resurfacing','App\\Models\\Service',1,'updated',NULL,NULL,'[]','{\"old\": {\"meta_robots\": \"index, follow\"}, \"attributes\": {\"id\": 1, \"icon\": null, \"name\": \"Pool Resurfacing\", \"slug\": \"pool-resurfacing\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Resurfacing Experts | 25-Year Warranty | Save $22,500\", \"description\": \"<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>\", \"meta_robots\": \"noindex, nofollow\", \"order_index\": 1, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.\", \"short_description\": \"Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(4,'model',':causer updated Service Pool Resurfacing','App\\Models\\Service',1,'updated',NULL,NULL,'[]','{\"old\": {\"meta_robots\": \"noindex, nofollow\"}, \"attributes\": {\"id\": 1, \"icon\": null, \"name\": \"Pool Resurfacing\", \"slug\": \"pool-resurfacing\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Resurfacing Experts | 25-Year Warranty | Save $22,500\", \"description\": \"<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>\", \"meta_robots\": \"index, follow\", \"order_index\": 1, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.\", \"short_description\": \"Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(5,'model',':causer updated Service Pool Resurfacing','App\\Models\\Service',1,'updated',NULL,NULL,'[]','{\"old\": {\"order_index\": 1}, \"attributes\": {\"id\": 1, \"icon\": null, \"name\": \"Pool Resurfacing\", \"slug\": \"pool-resurfacing\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Resurfacing Experts | 25-Year Warranty | Save $22,500\", \"description\": \"<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>\", \"meta_robots\": \"index, follow\", \"order_index\": 10, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.\", \"short_description\": \"Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(6,'model',':causer updated Service Pool Conversions','App\\Models\\Service',2,'updated',NULL,NULL,'[]','{\"old\": {\"order_index\": 2}, \"attributes\": {\"id\": 2, \"icon\": null, \"name\": \"Pool Conversions\", \"slug\": \"pool-conversions\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Conversions | Upgrade to Fiberglass | Dallas-Fort Worth\", \"description\": \"<p>Complete pool conversion services to transform your outdated pool into a modern, efficient fiberglass pool that saves money and maintenance time.</p>\", \"meta_robots\": \"index, follow\", \"order_index\": 11, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Convert your gunite or vinyl pool to fiberglass. Reduce maintenance costs by 70% with our professional pool conversion services.\", \"short_description\": \"Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(7,'model',':causer updated Service Pool Remodeling','App\\Models\\Service',3,'updated',NULL,NULL,'[]','{\"old\": {\"order_index\": 3}, \"attributes\": {\"id\": 3, \"icon\": null, \"name\": \"Pool Remodeling\", \"slug\": \"pool-remodeling\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Remodeling | Complete Pool Renovation | DFW\", \"description\": \"<p>Comprehensive pool remodeling to update every aspect of your pool area. From waterline tiles to deck resurfacing, we handle it all.</p>\", \"meta_robots\": \"index, follow\", \"order_index\": 12, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Full-service pool remodeling in Dallas-Fort Worth. Update tiles, coping, equipment, and more with our expert renovation team.\", \"short_description\": \"Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(8,'bulk','Test bulk operation',NULL,NULL,'bulk_test',NULL,NULL,'[]',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(9,'export',':causer exported 10 test_resource',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"test_resource\", \"count\": 10, \"filters\": null}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:04:52','2025-09-29 23:04:52'),(11,'model',':causer updated Service Pool Resurfacing','App\\Models\\Service',1,'updated',NULL,NULL,'[]','{\"old\": {\"meta_robots\": \"index, follow\"}, \"attributes\": {\"id\": 1, \"icon\": null, \"name\": \"Pool Resurfacing\", \"slug\": \"pool-resurfacing\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Resurfacing Experts | 25-Year Warranty | Save $22,500\", \"description\": \"<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>\", \"meta_robots\": \"noindex, nofollow\", \"order_index\": 10, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.\", \"short_description\": \"Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:10:24','2025-09-29 23:10:24'),(12,'model',':causer updated Service Pool Resurfacing','App\\Models\\Service',1,'updated',NULL,NULL,'[]','{\"old\": {\"meta_robots\": \"noindex, nofollow\"}, \"attributes\": {\"id\": 1, \"icon\": null, \"name\": \"Pool Resurfacing\", \"slug\": \"pool-resurfacing\", \"image\": null, \"json_ld\": null, \"benefits\": null, \"features\": null, \"overview\": null, \"is_active\": 1, \"parent_id\": null, \"meta_title\": \"Pool Resurfacing Experts | 25-Year Warranty | Save $22,500\", \"description\": \"<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>\", \"meta_robots\": \"index, follow\", \"order_index\": 10, \"canonical_url\": null, \"homepage_image\": null, \"breadcrumb_image\": null, \"meta_description\": \"Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.\", \"short_description\": \"Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.\", \"include_in_sitemap\": 1}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:10:24','2025-09-29 23:10:24'),(13,'bulk','Test bulk operation',NULL,NULL,'bulk_test',NULL,NULL,'[]',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:10:25','2025-09-29 23:10:25'),(14,'export',':causer exported 10 test_resource',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"test_resource\", \"count\": 10, \"filters\": null}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:10:25','2025-09-29 23:10:25'),(16,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(17,'model',':causer created Service Test Activity Service','App\\Models\\Service',5,'created',NULL,NULL,'{\"attributes\": {\"id\": 5, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169707\", \"is_active\": true, \"created_at\": \"2025-09-29 18:15:07\", \"updated_at\": \"2025-09-29 18:15:07\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(18,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',5,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"id\": 5, \"name\": \"Updated Test Activity Service\", \"slug\": \"test-activity-service-1759169707\", \"is_active\": true, \"description\": \"Testing activity logging\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(19,'model',':causer deleted Service Updated Test Activity Service','App\\Models\\Service',5,'deleted',NULL,NULL,'{\"attributes\": {\"id\": 5, \"name\": \"Updated Test Activity Service\", \"slug\": \"test-activity-service-1759169707\", \"is_active\": true, \"created_at\": \"2025-09-29 18:15:07\", \"updated_at\": \"2025-09-29 18:15:07\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(20,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(21,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(22,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(23,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:15:07','2025-09-29 23:15:07'),(24,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(25,'model',':causer created Service Test Activity Service','App\\Models\\Service',6,'created',NULL,NULL,'{\"attributes\": {\"id\": 6, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169860\", \"is_active\": true, \"created_at\": \"2025-09-29 18:17:40\", \"updated_at\": \"2025-09-29 18:17:40\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(26,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',6,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"id\": 6, \"name\": \"Updated Test Activity Service\", \"slug\": \"test-activity-service-1759169860\", \"is_active\": true, \"description\": \"Testing activity logging\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(27,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(28,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(29,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(30,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:17:40','2025-09-29 23:17:40'),(31,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(32,'model',':causer created Service Test Activity Service','App\\Models\\Service',7,'created',NULL,NULL,'{\"attributes\": {\"id\": 7, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169900\", \"is_active\": true, \"created_at\": \"2025-09-29 18:18:20\", \"updated_at\": \"2025-09-29 18:18:20\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(33,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',7,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(34,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(35,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(36,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(37,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:20','2025-09-29 23:18:20'),(38,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(39,'model',':causer created Service Test Activity Service','App\\Models\\Service',8,'created',NULL,NULL,'{\"attributes\": {\"id\": 8, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169938\", \"is_active\": true, \"created_at\": \"2025-09-29 18:18:58\", \"updated_at\": \"2025-09-29 18:18:58\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(40,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',8,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(41,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(42,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(43,'model',':causer created Service Test Change Service','App\\Models\\Service',9,'created',NULL,NULL,'{\"attributes\": {\"id\": 9, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759169938\", \"is_active\": false, \"created_at\": \"2025-09-29 18:18:58\", \"updated_at\": \"2025-09-29 18:18:58\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(44,'model',':causer updated Service Updated Test Service','App\\Models\\Service',9,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(45,'model',':causer updated Service Updated Test Service','App\\Models\\Service',9,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(46,'model',':causer updated Service Updated Test Service','App\\Models\\Service',9,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(47,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(48,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:18:58','2025-09-29 23:18:58'),(49,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(50,'model',':causer created Service Test Activity Service','App\\Models\\Service',10,'created',NULL,NULL,'{\"attributes\": {\"id\": 10, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169956\", \"is_active\": true, \"created_at\": \"2025-09-29 18:19:16\", \"updated_at\": \"2025-09-29 18:19:16\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(51,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',10,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(52,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(53,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(54,'model',':causer created Service Test Change Service','App\\Models\\Service',11,'created',NULL,NULL,'{\"attributes\": {\"id\": 11, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759169956\", \"is_active\": false, \"created_at\": \"2025-09-29 18:19:16\", \"updated_at\": \"2025-09-29 18:19:16\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(55,'model',':causer updated Service Updated Test Service','App\\Models\\Service',11,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(56,'model',':causer updated Service Updated Test Service','App\\Models\\Service',11,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(57,'model',':causer updated Service Updated Test Service','App\\Models\\Service',11,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(58,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(59,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:16','2025-09-29 23:19:16'),(60,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(61,'model',':causer created Service Test Activity Service','App\\Models\\Service',12,'created',NULL,NULL,'{\"attributes\": {\"id\": 12, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169970\", \"is_active\": true, \"created_at\": \"2025-09-29 18:19:30\", \"updated_at\": \"2025-09-29 18:19:30\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(62,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',12,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(63,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(64,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(65,'model',':causer created Service Test Change Service','App\\Models\\Service',13,'created',NULL,NULL,'{\"attributes\": {\"id\": 13, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759169970\", \"is_active\": false, \"created_at\": \"2025-09-29 18:19:30\", \"updated_at\": \"2025-09-29 18:19:30\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(66,'model',':causer updated Service Updated Test Service','App\\Models\\Service',13,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(67,'model',':causer updated Service Updated Test Service','App\\Models\\Service',13,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(68,'model',':causer updated Service Updated Test Service','App\\Models\\Service',13,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(69,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(70,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:30','2025-09-29 23:19:30'),(71,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(72,'model',':causer created Service Test Activity Service','App\\Models\\Service',14,'created',NULL,NULL,'{\"attributes\": {\"id\": 14, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759169984\", \"is_active\": true, \"created_at\": \"2025-09-29 18:19:44\", \"updated_at\": \"2025-09-29 18:19:44\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(73,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',14,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(74,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(75,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(76,'model',':causer created Service Test Change Service','App\\Models\\Service',15,'created',NULL,NULL,'{\"attributes\": {\"id\": 15, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759169984\", \"is_active\": false, \"created_at\": \"2025-09-29 18:19:44\", \"updated_at\": \"2025-09-29 18:19:44\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(77,'model',':causer updated Service Updated Test Service','App\\Models\\Service',15,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(78,'model',':causer updated Service Updated Test Service','App\\Models\\Service',15,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(79,'model',':causer updated Service Updated Test Service','App\\Models\\Service',15,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(80,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(81,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:19:44','2025-09-29 23:19:44'),(82,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(83,'model',':causer created Service Test Activity Service','App\\Models\\Service',16,'created',NULL,NULL,'{\"attributes\": {\"id\": 16, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759170033\", \"is_active\": true, \"created_at\": \"2025-09-29 18:20:33\", \"updated_at\": \"2025-09-29 18:20:33\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(84,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',16,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(85,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(86,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(87,'model',':causer created Service Test Change Service','App\\Models\\Service',17,'created',NULL,NULL,'{\"attributes\": {\"id\": 17, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759170033\", \"is_active\": false, \"created_at\": \"2025-09-29 18:20:33\", \"updated_at\": \"2025-09-29 18:20:33\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(88,'model',':causer updated Service Updated Test Service','App\\Models\\Service',17,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(89,'model',':causer updated Service Updated Test Service','App\\Models\\Service',17,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(90,'model',':causer updated Service Updated Test Service','App\\Models\\Service',17,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(91,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(92,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:33','2025-09-29 23:20:33'),(93,'test','Testing activity logging',NULL,NULL,'test_action',NULL,NULL,'{\"test\": true, \"value\": 123}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:46','2025-09-29 23:20:46'),(94,'model',':causer created Service Test Activity Service','App\\Models\\Service',18,'created',NULL,NULL,'{\"attributes\": {\"id\": 18, \"name\": \"Test Activity Service\", \"slug\": \"test-activity-service-1759170047\", \"is_active\": true, \"created_at\": \"2025-09-29 18:20:47\", \"updated_at\": \"2025-09-29 18:20:47\", \"description\": \"Testing activity logging\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(95,'model',':causer updated Service Updated Test Activity Service','App\\Models\\Service',18,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Activity Service\"}, \"attributes\": {\"name\": \"Updated Test Activity Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(96,'auth','Failed login attempt for test@example.com',NULL,NULL,'failed_login',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"email\": \"test@example.com\", \"reason\": \"Invalid credentials\", \"user_agent\": \"Symfony\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(97,'custom',':causer admin_panel_access on resource',NULL,NULL,'admin_panel_access',NULL,NULL,'{\"section\": \"services\", \"action_type\": \"view_list\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(98,'model',':causer created Service Test Change Service','App\\Models\\Service',19,'created',NULL,NULL,'{\"attributes\": {\"id\": 19, \"name\": \"Test Change Service\", \"slug\": \"test-change-service-1759170047\", \"is_active\": false, \"created_at\": \"2025-09-29 18:20:47\", \"updated_at\": \"2025-09-29 18:20:47\", \"description\": \"Original description\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(99,'model',':causer updated Service Updated Test Service','App\\Models\\Service',19,'updated',NULL,NULL,'[]','{\"old\": {\"name\": \"Test Change Service\"}, \"attributes\": {\"name\": \"Updated Test Service\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(100,'model',':causer updated Service Updated Test Service','App\\Models\\Service',19,'updated',NULL,NULL,'[]','{\"old\": {\"description\": \"Original description\"}, \"attributes\": {\"description\": \"Updated description\"}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(101,'model',':causer updated Service Updated Test Service','App\\Models\\Service',19,'updated',NULL,NULL,'[]','{\"old\": {\"is_active\": false}, \"attributes\": {\"is_active\": true}}','127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(102,'export',':causer exported 25 services',NULL,NULL,'exported',NULL,NULL,'{\"type\": \"services\", \"count\": 25, \"filters\": {\"is_active\": true}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(103,'file',':causer downloaded file sample-data.csv',NULL,NULL,'downloaded',NULL,NULL,'{\"filename\": \"sample-data.csv\"}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:20:47','2025-09-29 23:20:47'),(104,'custom',':causer scheduled_export on resource',NULL,NULL,'scheduled_export',NULL,NULL,'{\"model\": \"contacts\", \"format\": \"csv\", \"period\": \"all\", \"total_records\": 7, \"files_generated\": 1}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:52:21','2025-09-29 23:52:21'),(105,'custom',':causer scheduled_export on resource',NULL,NULL,'scheduled_export',NULL,NULL,'{\"model\": \"services\", \"format\": \"csv\", \"period\": \"all\", \"total_records\": 4, \"files_generated\": 1}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-29 23:52:39','2025-09-29 23:52:39'),(106,'auth','Login attempt from 127.0.0.1 at unusual hour',NULL,NULL,'suspicious_attempt',NULL,NULL,'{\"ip\": \"127.0.0.1\", \"hour\": 23, \"email\": \"admin@hexagonservicesolutions.com\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0\"}',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',NULL,'2025-09-30 04:20:35','2025-09-30 04:20:35'),(107,'auth',':causer logged in',NULL,NULL,'login','App\\Models\\User',2,'{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0\"}',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',NULL,'2025-09-30 04:20:35','2025-09-30 04:20:35'),(108,'model',':causer updated User Admin User','App\\Models\\User',2,'updated','App\\Models\\User',2,'[]','{\"old\": {\"is_admin\": true, \"last_login_at\": null, \"last_login_ip\": null, \"two_factor_enabled\": false, \"force_password_change\": false}, \"attributes\": {\"is_admin\": 1, \"last_login_at\": \"2025-09-29 23:20:35\", \"last_login_ip\": \"127.0.0.1\", \"two_factor_enabled\": 0, \"force_password_change\": 0}}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',NULL,'2025-09-30 04:20:35','2025-09-30 04:20:35'),(109,'auth',':causer logged in',NULL,NULL,'login','App\\Models\\User',2,'{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0\"}',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',NULL,'2025-09-30 04:20:35','2025-09-30 04:20:35'),(110,'auth',':causer logged in',NULL,NULL,'login','App\\Models\\User',2,'{\"ip\": \"127.0.0.1\", \"user_agent\": \"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0\"}',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',NULL,'2025-09-30 04:20:35','2025-09-30 04:20:35'),(111,'custom',':causer scheduled_export on resource',NULL,NULL,'scheduled_export',NULL,NULL,'{\"model\": \"contacts\", \"format\": \"csv\", \"period\": \"all\", \"total_records\": 7, \"files_generated\": 1}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:27:16','2025-09-30 04:27:16'),(112,'custom',':causer data_import on resource',NULL,NULL,'data_import',NULL,NULL,'{\"model\": \"BlogPost\", \"file_name\": \"sample-blog-posts-bulk.csv\", \"total_rows\": 10, \"failed_rows\": 10, \"successful_rows\": 0}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(113,'custom',':causer data_import on resource',NULL,NULL,'data_import',NULL,NULL,'{\"model\": \"BlogPost\", \"file_name\": \"sample-blog-posts-bulk.csv\", \"total_rows\": 10, \"failed_rows\": 10, \"successful_rows\": 0}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:36:09','2025-09-30 04:36:09'),(114,'custom',':causer data_import on resource',NULL,NULL,'data_import',NULL,NULL,'{\"model\": \"BlogPost\", \"file_name\": \"sample-blog-posts-bulk.csv\", \"total_rows\": 10, \"failed_rows\": 10, \"successful_rows\": 0}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:36:43','2025-09-30 04:36:43'),(115,'custom',':causer data_import on resource',NULL,NULL,'data_import',NULL,NULL,'{\"model\": \"BlogPost\", \"file_name\": \"sample-blog-posts-bulk.csv\", \"total_rows\": 10, \"failed_rows\": 20, \"successful_rows\": 0}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:36:59','2025-09-30 04:36:59'),(116,'model',':causer created BlogPost Essential Pool Maintenance Guide','App\\Models\\BlogPost',1,'created',NULL,NULL,'{\"attributes\": {\"id\": 1, \"name\": \"Essential Pool Maintenance Guide\", \"slug\": \"essential-pool-maintenance-guide\", \"content\": \"<p>Maintaining your pool properly is crucial for ensuring crystal clear water and extending the life of your pool equipment. This comprehensive guide covers everything you need to know about pool maintenance.</p><p>Regular maintenance includes checking water chemistry, cleaning filters, and removing debris. By following a consistent maintenance schedule, you can prevent costly repairs and enjoy your pool year-round.</p>\", \"excerpt\": \"Complete guide to maintaining your swimming pool year-round\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Essential Pool Maintenance Guide | Expert Tips\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 11, \"is_published\": true, \"published_at\": \"2024-01-15 09:00:00\", \"featured_image\": \"images/blog/pool-maintenance-guide.jpg\", \"meta_description\": \"Learn professional pool maintenance techniques to keep your pool pristine\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(117,'model',':causer created BlogPost Pool Resurfacing: When and Why','App\\Models\\BlogPost',2,'created',NULL,NULL,'{\"attributes\": {\"id\": 2, \"name\": \"Pool Resurfacing: When and Why\", \"slug\": \"pool-resurfacing-when-and-why\", \"content\": \"<p>Is your pool showing signs of wear? Cracks, rough surfaces, or persistent staining may indicate it\'s time for resurfacing. This article explains when to resurface your pool and the benefits it provides.</p><p>Pool resurfacing not only improves aesthetics but also extends your pool\'s lifespan and can reduce maintenance costs. Learn about different resurfacing options and their costs.</p>\", \"excerpt\": \"Discover when your pool needs resurfacing and the benefits\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"When to Resurface Your Pool | Expert Advice\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 12, \"is_published\": true, \"published_at\": \"2024-02-01 10:30:00\", \"featured_image\": \"images/blog/pool-resurfacing-when.jpg\", \"meta_description\": \"Know the signs that indicate your pool needs resurfacing\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(118,'model',':causer created BlogPost Top 5 Pool Safety Tips for Families','App\\Models\\BlogPost',3,'created',NULL,NULL,'{\"attributes\": {\"id\": 3, \"name\": \"Top 5 Pool Safety Tips for Families\", \"slug\": \"top-5-pool-safety-tips-for-families\", \"content\": \"<p>Pool safety is paramount when you have children or pets. These five essential safety tips will help you create a secure swimming environment for your family.</p><p>From proper fencing to chemical storage, we cover all aspects of pool safety. Implementing these measures can prevent accidents and give you peace of mind.</p>\", \"excerpt\": \"Essential pool safety measures every family should implement\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Safety Tips for Families | Keep Kids Safe\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 13, \"is_published\": true, \"published_at\": \"2024-03-10 14:00:00\", \"featured_image\": \"images/blog/pool-safety-tips.jpg\", \"meta_description\": \"Important pool safety guidelines for families with children\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(119,'model',':causer created BlogPost Energy-Efficient Pool Equipment','App\\Models\\BlogPost',4,'created',NULL,NULL,'{\"attributes\": {\"id\": 4, \"name\": \"Energy-Efficient Pool Equipment\", \"slug\": \"energy-efficient-pool-equipment\", \"content\": \"<p>Reduce your pool\'s operating costs with energy-efficient equipment. Modern pool pumps, heaters, and LED lighting can significantly lower your energy bills.</p><p>This guide reviews the latest energy-saving pool technologies and calculates potential savings. Make your pool more eco-friendly while saving money.</p>\", \"excerpt\": \"Save money with energy-efficient pool equipment and technology\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Energy-Efficient Pool Equipment Guide\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 14, \"is_published\": true, \"published_at\": \"2024-03-25 11:00:00\", \"featured_image\": \"images/blog/energy-efficient-equipment.jpg\", \"meta_description\": \"Discover how to reduce pool operating costs with efficient equipment\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(120,'model',':causer created BlogPost Preparing Your Pool for Summer','App\\Models\\BlogPost',5,'created',NULL,NULL,'{\"attributes\": {\"id\": 5, \"name\": \"Preparing Your Pool for Summer\", \"slug\": \"preparing-your-pool-for-summer\", \"content\": \"<p>Get your pool ready for the summer swimming season with our comprehensive preparation checklist. From water chemistry to equipment inspection, we cover everything you need.</p><p>Proper spring preparation ensures your pool is safe, clean, and ready for months of enjoyment. Follow our step-by-step guide for the best results.</p>\", \"excerpt\": \"Complete checklist for summer pool preparation\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Summer Pool Preparation Guide | Get Ready to Swim\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 15, \"is_published\": true, \"published_at\": \"2024-04-15 08:30:00\", \"featured_image\": \"images/blog/summer-pool-prep.jpg\", \"meta_description\": \"Essential steps to prepare your pool for summer season\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(121,'model',':causer created BlogPost Understanding Pool Water Chemistry','App\\Models\\BlogPost',6,'created',NULL,NULL,'{\"attributes\": {\"id\": 6, \"name\": \"Understanding Pool Water Chemistry\", \"slug\": \"understanding-pool-water-chemistry\", \"content\": \"<p>Balanced water chemistry is the foundation of a healthy pool. This guide explains pH, alkalinity, chlorine levels, and other crucial chemical parameters.</p><p>Learn how to test your water, interpret results, and make proper adjustments. Proper water chemistry prevents algae, protects equipment, and ensures swimmer comfort.</p>\", \"excerpt\": \"Master the basics of pool water chemistry and testing\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Water Chemistry Explained | Complete Guide\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 11, \"is_published\": true, \"published_at\": \"2024-04-28 13:00:00\", \"featured_image\": \"images/blog/water-chemistry.jpg\", \"meta_description\": \"Understand and maintain perfect pool water chemistry\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(122,'model',':causer created BlogPost Pool Tile Cleaning and Maintenance','App\\Models\\BlogPost',7,'created',NULL,NULL,'{\"attributes\": {\"id\": 7, \"name\": \"Pool Tile Cleaning and Maintenance\", \"slug\": \"pool-tile-cleaning-and-maintenance\", \"content\": \"<p>Keep your pool tiles sparkling with proper cleaning and maintenance techniques. This guide covers everything from calcium removal to grout repair.</p><p>Regular tile maintenance prevents buildup and extends the life of your pool\'s finish. Learn professional cleaning methods and preventive measures.</p>\", \"excerpt\": \"Professional techniques for cleaning and maintaining pool tiles\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Tile Cleaning Guide | Remove Calcium Buildup\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 11, \"is_published\": true, \"published_at\": \"2024-05-05 10:00:00\", \"featured_image\": \"images/blog/tile-cleaning.jpg\", \"meta_description\": \"Expert tips for maintaining clean and beautiful pool tiles\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(123,'model',':causer created BlogPost Choosing the Right Pool Filter','App\\Models\\BlogPost',8,'created',NULL,NULL,'{\"attributes\": {\"id\": 8, \"name\": \"Choosing the Right Pool Filter\", \"slug\": \"choosing-the-right-pool-filter\", \"content\": \"<p>Your pool filter is crucial for maintaining clean, clear water. This comparison guide helps you choose between sand, cartridge, and DE filters.</p><p>We examine the pros and cons of each filter type, including maintenance requirements and costs. Make an informed decision for your pool\'s filtration needs.</p>\", \"excerpt\": \"Compare pool filter types and choose the best for your needs\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Filter Comparison Guide | Sand vs Cartridge vs DE\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 14, \"is_published\": true, \"published_at\": \"2024-05-20 09:30:00\", \"featured_image\": \"images/blog/pool-filters.jpg\", \"meta_description\": \"Choose the perfect pool filter system for your needs\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(124,'model',':causer created BlogPost Winterizing Your Pool: Complete Guide','App\\Models\\BlogPost',9,'created',NULL,NULL,'{\"attributes\": {\"id\": 9, \"name\": \"Winterizing Your Pool: Complete Guide\", \"slug\": \"winterizing-your-pool-complete-guide\", \"content\": \"<p>Properly winterizing your pool protects it from freeze damage and makes spring opening easier. This comprehensive guide covers all winterization steps.</p><p>From balancing water chemistry to installing a winter cover, we detail everything needed for successful pool winterization. Protect your investment during the off-season.</p>\", \"excerpt\": \"Step-by-step pool winterization guide for cold climates\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Winterization Guide | Protect Your Pool\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 15, \"is_published\": true, \"published_at\": \"2024-06-01 11:30:00\", \"featured_image\": \"images/blog/pool-winterizing.jpg\", \"meta_description\": \"Complete instructions for properly winterizing your swimming pool\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(125,'model',':causer created BlogPost Pool Landscaping Ideas','App\\Models\\BlogPost',10,'created',NULL,NULL,'{\"attributes\": {\"id\": 10, \"name\": \"Pool Landscaping Ideas\", \"slug\": \"pool-landscaping-ideas\", \"content\": \"<p>Transform your pool area into a backyard oasis with creative landscaping ideas. From tropical themes to modern minimalist designs, find inspiration for your pool landscape.</p><p>We cover plant selection, hardscaping options, lighting, and safety considerations. Create a beautiful and functional poolside environment.</p>\", \"excerpt\": \"Creative landscaping ideas to enhance your pool area\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:37:11\", \"meta_title\": \"Pool Landscaping Ideas | Transform Your Backyard\", \"updated_at\": \"2025-09-29 23:37:11\", \"category_id\": 16, \"is_published\": true, \"published_at\": \"2024-06-15 14:00:00\", \"featured_image\": \"images/blog/pool-landscaping.jpg\", \"meta_description\": \"Beautiful landscaping designs for around your swimming pool\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(126,'custom',':causer data_import on resource',NULL,NULL,'data_import',NULL,NULL,'{\"model\": \"BlogPost\", \"file_name\": \"sample-blog-posts-bulk.csv\", \"total_rows\": 10, \"failed_rows\": 0, \"successful_rows\": 10}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:37:11','2025-09-30 04:37:11'),(127,'model',':causer created BlogPost DIY Pool Maintenance Schedule - Daily, Weekly, and Monthly Tasks','App\\Models\\BlogPost',11,'created',NULL,NULL,'{\"attributes\": {\"id\": 11, \"name\": \"DIY Pool Maintenance Schedule - Daily, Weekly, and Monthly Tasks\", \"slug\": \"diy-pool-maintenance-schedule\", \"content\": \"<h1>DIY Pool Maintenance Schedule</h1>\\n<p>Maintaining your pool doesn\'t have to be overwhelming. With a structured schedule and consistent effort, you can keep your pool sparkling clean and equipment running smoothly. This comprehensive guide breaks down maintenance tasks by frequency, making pool care manageable for any pool owner.</p>\\n<h2>Daily Tasks (5-10 minutes)</h2>\\n<h3>1. Skim the Surface</h3>\\n<p>Remove leaves, insects, and debris before they sink and decompose.</p>\\n<h3>2. Check Water Level</h3>\\n<p>Ensure water is at mid-skimmer level. Add water if needed.</p>\\n<h3>3. Empty Skimmer Baskets</h3>\\n<p>Clear baskets to maintain proper water flow.</p>\\n<h3>4. Quick Visual Inspection</h3>\\n<p>Look for:</p>\\n<ul>\\n<li>Visible algae growth</li>\\n<li>Cloudy water</li>\\n<li>Equipment leaks</li>\\n<li>Unusual sounds</li>\\n</ul>\\n<h2>Weekly Tasks (1-2 hours)</h2>\\n<h3>Monday - Water Testing</h3>\\n<p>Test and adjust:</p>\\n<ul>\\n<li><strong>Chlorine</strong>: 1-3 ppm</li>\\n<li><strong>pH</strong>: 7.2-7.6</li>\\n<li><strong>Alkalinity</strong>: 80-120 ppm</li>\\n</ul>\\n<h3>Wednesday - Cleaning</h3>\\n<ul>\\n<li>Brush walls and floor</li>\\n<li>Vacuum pool thoroughly</li>\\n<li>Clean tile line with pool brush</li>\\n<li>Backwash filter (if pressure is 8-10 PSI above normal)</li>\\n</ul>\\n<h3>Friday - Shock Treatment</h3>\\n<ul>\\n<li>Add shock treatment after sunset</li>\\n<li>Run pump overnight</li>\\n<li>Test chlorine before swimming</li>\\n</ul>\\n<h3>Saturday - Equipment Check</h3>\\n<ul>\\n<li>Inspect pump and filter</li>\\n<li>Check automatic cleaner</li>\\n<li>Test pool lights</li>\\n<li>Verify timer settings</li>\\n</ul>\\n<h2>Bi-Weekly Tasks</h2>\\n<h3>Weeks 1 &amp; 3</h3>\\n<ul>\\n<li><strong>Deep clean filter</strong>: Rinse cartridge filters or backwash DE/sand filters thoroughly</li>\\n<li><strong>Water chemistry deep test</strong>: Include calcium hardness and cyanuric acid</li>\\n<li><strong>Inspect pool cover</strong>: Clean and check for damage</li>\\n</ul>\\n<h3>Weeks 2 &amp; 4</h3>\\n<ul>\\n<li><strong>Clean pool deck</strong>: Power wash if needed</li>\\n<li><strong>Trim vegetation</strong>: Keep plants away from pool edge</li>\\n<li><strong>Check safety equipment</strong>: Test GFCI outlets, inspect rails and ladders</li>\\n</ul>\\n<h2>Monthly Tasks</h2>\\n<h3>First Monday</h3>\\n<p><strong>Complete Water Analysis</strong>\\nTest all parameters:</p>\\n<ul>\\n<li>Free and total chlorine</li>\\n<li>pH and alkalinity</li>\\n<li>Calcium hardness (200-400 ppm)</li>\\n<li>Cyanuric acid (30-50 ppm)</li>\\n<li>Total dissolved solids</li>\\n<li>Metals (iron, copper)</li>\\n</ul>\\n<h3>Mid-Month</h3>\\n<p><strong>Equipment Maintenance</strong></p>\\n<ul>\\n<li>Lubricate o-rings</li>\\n<li>Check pump seals</li>\\n<li>Inspect heater (if applicable)</li>\\n<li>Clean salt cell (saltwater pools)</li>\\n<li>Test automatic controls</li>\\n</ul>\\n<h3>Month-End</h3>\\n<p><strong>Preventive Measures</strong></p>\\n<ul>\\n<li>Add algaecide</li>\\n<li>Apply metal sequestrant</li>\\n<li>Enzyme treatment for oil/organics</li>\\n<li>Check and adjust water level</li>\\n</ul>\\n<h2>Seasonal Maintenance</h2>\\n<h3>Spring Opening</h3>\\n<ul>\\n<li>Remove and clean cover</li>\\n<li>Reinstall equipment</li>\\n<li>Fill to proper level</li>\\n<li>Balance chemistry gradually</li>\\n<li>Super-chlorinate</li>\\n<li>Run filter continuously for 24-48 hours</li>\\n</ul>\\n<h3>Summer Intensive</h3>\\n<ul>\\n<li><strong>June</strong>: Deep clean filter media</li>\\n<li><strong>July</strong>: Professional equipment inspection</li>\\n<li><strong>August</strong>: Check for sun damage, replace worn parts</li>\\n</ul>\\n<h3>Fall Preparation</h3>\\n<ul>\\n<li>Reduce pump runtime gradually</li>\\n<li>Deep clean before covering</li>\\n<li>Balance chemistry for winter</li>\\n<li>Lower water level (if winterizing)</li>\\n<li>Add winterizing chemicals</li>\\n</ul>\\n<h3>Winter (Closed Pools)</h3>\\n<ul>\\n<li>Monthly cover inspection</li>\\n<li>Remove water/snow accumulation</li>\\n<li>Check for animal damage</li>\\n<li>Monitor chemistry monthly (if not fully winterized)</li>\\n</ul>\\n<h2>Creating Your Custom Schedule</h2>\\n<h3>Step 1: Assess Your Pool</h3>\\n<p>Consider:</p>\\n<ul>\\n<li>Pool size and type</li>\\n<li>Bather load</li>\\n<li>Surrounding environment</li>\\n<li>Climate conditions</li>\\n</ul>\\n<h3>Step 2: Set Reminders</h3>\\n<p>Use:</p>\\n<ul>\\n<li>Phone calendar alerts</li>\\n<li>Pool maintenance apps</li>\\n<li>Physical calendar by equipment</li>\\n</ul>\\n<h3>Step 3: Keep Records</h3>\\n<p>Track:</p>\\n<ul>\\n<li>Chemical additions</li>\\n<li>Test results</li>\\n<li>Equipment repairs</li>\\n<li>Unusual observations</li>\\n</ul>\\n<h2>Time-Saving Tips</h2>\\n<ol>\\n<li><strong>Invest in automation</strong>: Timers, automatic cleaners, and chemical feeders</li>\\n<li><strong>Maintain consistent schedule</strong>: Prevents bigger problems</li>\\n<li><strong>Stock supplies</strong>: Buy chemicals in bulk</li>\\n<li><strong>Learn your pool</strong>: Understanding patterns reduces troubleshooting time</li>\\n<li><strong>Preventive maintenance</strong>: Address small issues immediately</li>\\n</ol>\\n<h2>Common Scheduling Mistakes</h2>\\n<h3>Avoid These Pitfalls:</h3>\\n<ul>\\n<li>❌ Skipping tasks when pool \\\"looks fine\\\"</li>\\n<li>❌ Over-chlorinating to compensate for missed treatments</li>\\n<li>❌ Ignoring filter pressure</li>\\n<li>❌ Postponing equipment maintenance</li>\\n<li>❌ Inconsistent testing</li>\\n</ul>\\n<h2>Professional Service Integration</h2>\\n<h3>When to Call Experts:</h3>\\n<ul>\\n<li>Annual equipment inspection</li>\\n<li>Opening/closing service</li>\\n<li>Major repairs</li>\\n<li>Persistent water problems</li>\\n<li>Equipment upgrades</li>\\n</ul>\\n<h3>DIY vs Professional Balance:</h3>\\n<ul>\\n<li><strong>You handle</strong>: Regular cleaning, basic chemistry, simple maintenance</li>\\n<li><strong>Pros handle</strong>: Complex repairs, electrical work, plumbing issues</li>\\n</ul>\\n<h2>Maintenance Log Template</h2>\\n<p>Keep track with this simple format:</p>\\n<pre><code>Date: _______\\nTask Completed: _______\\nChemical Added: _______ Amount: _______\\nTest Results: Cl:___ pH:___ Alk:___\\nNotes: _______\\nNext Action: _______\\n</code></pre>\\n<h2>Conclusion</h2>\\n<p>A well-maintained pool is a joy to own and use. By following this schedule and adapting it to your specific needs, you\'ll spend less time fixing problems and more time enjoying your pool. Remember, consistency is key – a little effort regularly prevents major issues down the road.</p>\\n<p>Start implementing this schedule today, and watch your pool maintenance become second nature!</p>\\n\", \"excerpt\": \"DIY Pool Maintenance Schedule\\nMaintaining your pool doesn\'t have to be overwhelming. With a structured schedule and consistent effort, you can keep your pool sparkling clean and equipment running smoothly. This comprehensive guide breaks down maintenance tasks by frequency, making pool care manageab...\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:48:03\", \"meta_title\": \"DIY Pool Maintenance Schedule | Complete Guide\", \"updated_at\": \"2025-09-29 23:48:03\", \"category_id\": 11, \"is_published\": true, \"published_at\": \"2024-08-20 10:00:00\", \"featured_image\": \"images/blog/maintenance-schedule.jpg\", \"meta_description\": \"Follow our comprehensive DIY pool maintenance schedule with daily, weekly, monthly, and seasonal tasks to keep your pool pristine.\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:48:03','2025-09-30 04:48:03'),(128,'model',':causer created BlogPost The Complete Guide to Pool Automation Systems','App\\Models\\BlogPost',12,'created',NULL,NULL,'{\"attributes\": {\"id\": 12, \"name\": \"The Complete Guide to Pool Automation Systems\", \"slug\": \"pool-automation-systems-guide\", \"content\": \"<h1>The Complete Guide to Pool Automation Systems</h1>\\n<p>Pool automation has revolutionized how pool owners manage and maintain their swimming pools. With smart technology becoming more accessible, automating your pool can save time, money, and ensure optimal water conditions year-round.</p>\\n<h2>What is Pool Automation?</h2>\\n<p>Pool automation refers to systems that allow you to control various pool functions remotely or automatically. These systems can manage:</p>\\n<ul>\\n<li><strong>Filtration cycles</strong></li>\\n<li><strong>Heating and cooling</strong></li>\\n<li><strong>Lighting</strong></li>\\n<li><strong>Water features</strong></li>\\n<li><strong>Chemical dosing</strong></li>\\n<li><strong>Cleaning schedules</strong></li>\\n</ul>\\n<h2>Benefits of Pool Automation</h2>\\n<h3>1. Energy Efficiency</h3>\\n<p>Modern automation systems optimize equipment runtime, reducing energy consumption by up to 70%. Smart scheduling ensures pumps and heaters run only when necessary.</p>\\n<h3>2. Water Conservation</h3>\\n<p>Automated water level management prevents overflow and maintains optimal levels, saving thousands of gallons annually.</p>\\n<h3>3. Chemical Balance</h3>\\n<p>Automated chemical feeders maintain perfect water chemistry, reducing manual testing and chemical waste.</p>\\n<h3>4. Convenience</h3>\\n<p>Control your entire pool system from your smartphone, whether you\'re home or away.</p>\\n<h2>Popular Automation Systems</h2>\\n<h3>Pentair IntelliCenter</h3>\\n<p>The IntelliCenter offers comprehensive control with:</p>\\n<ul>\\n<li>Mobile app control</li>\\n<li>Voice assistant integration</li>\\n<li>Energy consumption tracking</li>\\n<li>Customizable schedules</li>\\n</ul>\\n<h3>Hayward OmniLogic</h3>\\n<p>Features include:</p>\\n<ul>\\n<li>ColorLogic lighting control</li>\\n<li>Multiple body of water control</li>\\n<li>Chemical automation compatibility</li>\\n<li>Weather-based adjustments</li>\\n</ul>\\n<h3>Jandy iAquaLink</h3>\\n<p>Highlights:</p>\\n<ul>\\n<li>Simple setup process</li>\\n<li>PDA remote control option</li>\\n<li>Integration with home automation</li>\\n<li>Real-time notifications</li>\\n</ul>\\n<h2>Installation Considerations</h2>\\n<h3>Professional vs. DIY</h3>\\n<p>While some basic automation can be DIY-installed, complex systems require professional installation to ensure:</p>\\n<ul>\\n<li>Proper electrical connections</li>\\n<li>Equipment compatibility</li>\\n<li>Warranty compliance</li>\\n<li>Safety standards</li>\\n</ul>\\n<h3>Cost Factors</h3>\\n<p>Budget for:</p>\\n<ul>\\n<li><strong>Basic systems</strong>: $1,500 - $3,000</li>\\n<li><strong>Advanced systems</strong>: $3,000 - $7,000</li>\\n<li><strong>Installation</strong>: $500 - $2,000</li>\\n</ul>\\n<h2>Smart Features to Consider</h2>\\n<h3>Variable Speed Pumps</h3>\\n<p>These pumps adjust speed based on demand, offering:</p>\\n<ul>\\n<li>90% energy savings</li>\\n<li>Quieter operation</li>\\n<li>Extended equipment life</li>\\n</ul>\\n<h3>LED Lighting</h3>\\n<p>Programmable LED lights provide:</p>\\n<ul>\\n<li>Color-changing effects</li>\\n<li>Energy efficiency</li>\\n<li>Long lifespan (50,000+ hours)</li>\\n</ul>\\n<h3>Automated Covers</h3>\\n<p>Safety covers that open and close automatically:</p>\\n<ul>\\n<li>Reduce evaporation</li>\\n<li>Maintain temperature</li>\\n<li>Enhance safety</li>\\n</ul>\\n<h2>Maintenance Tips</h2>\\n<ol>\\n<li><strong>Regular Updates</strong>: Keep system firmware updated</li>\\n<li><strong>Sensor Cleaning</strong>: Clean sensors monthly for accurate readings</li>\\n<li><strong>Battery Replacement</strong>: Replace backup batteries annually</li>\\n<li><strong>Professional Inspection</strong>: Annual system check by professionals</li>\\n</ol>\\n<h2>Future Trends</h2>\\n<p>The future of pool automation includes:</p>\\n<ul>\\n<li><strong>AI-powered predictive maintenance</strong></li>\\n<li><strong>Integration with smart home ecosystems</strong></li>\\n<li><strong>Solar-powered automation systems</strong></li>\\n<li><strong>Advanced water quality monitoring</strong></li>\\n</ul>\\n<h2>Conclusion</h2>\\n<p>Pool automation represents a significant upgrade that pays for itself through energy savings and reduced maintenance costs. Whether you choose a basic timer system or a comprehensive smart solution, automation will transform your pool ownership experience.</p>\\n<p>Ready to automate your pool? Contact our experts for a personalized consultation and discover the perfect automation solution for your needs.</p>\\n\", \"excerpt\": \"Discover how pool automation can transform your swimming pool maintenance experience with smart controls, energy savings, and remote management capabilities.\", \"author_id\": 2, \"created_at\": \"2025-09-29 23:48:03\", \"meta_title\": \"Pool Automation Systems: Complete Setup Guide\", \"updated_at\": \"2025-09-29 23:48:03\", \"category_id\": 14, \"is_published\": true, \"published_at\": \"2024-07-15 00:00:00\", \"featured_image\": \"images/blog/pool-automation.jpg\", \"meta_description\": \"Learn about modern pool automation systems, their benefits, and how to choose the right setup for your swimming pool.\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:48:03','2025-09-30 04:48:03'),(129,'model',':causer created BlogPost Saltwater vs Chlorine Pools: Which Is Right for You?','App\\Models\\BlogPost',13,'created',NULL,NULL,'{\"attributes\": {\"id\": 13, \"name\": \"Saltwater vs Chlorine Pools: Which Is Right for You?\", \"slug\": \"saltwater-vs-chlorine-pools-which-is-right-for-you\", \"content\": \"<h1>Saltwater vs Chlorine Pools: Which Is Right for You?</h1>\\n<p>One of the most common questions pool owners face is whether to choose a saltwater or traditional chlorine system. Both have their advantages and disadvantages, and the right choice depends on your specific needs, budget, and preferences.</p>\\n<h2>Understanding the Basics</h2>\\n<h3>Traditional Chlorine Pools</h3>\\n<p>Traditional pools use chlorine tablets, granules, or liquid chlorine added directly to the water. The chlorine acts as a sanitizer, killing bacteria and algae.</p>\\n<h3>Saltwater Pools</h3>\\n<p>Contrary to popular belief, saltwater pools still use chlorine. The difference is that they generate chlorine through a salt chlorine generator (also called a salt cell) that converts salt into chlorine through electrolysis.</p>\\n<h2>Cost Comparison</h2>\\n<h3>Initial Investment</h3>\\n<p>| System Type | Initial Cost | Equipment |\\n|------------|--------------|-----------|\\n| Chlorine | $300-500 | Basic equipment |\\n| Saltwater | $1,500-2,500 | Salt generator system |</p>\\n<h3>Ongoing Costs</h3>\\n<p><strong>Chlorine Pools:</strong></p>\\n<ul>\\n<li>Monthly chemical costs: $50-100</li>\\n<li>Annual total: $600-1,200</li>\\n</ul>\\n<p><strong>Saltwater Pools:</strong></p>\\n<ul>\\n<li>Salt replacement: $50-100/year</li>\\n<li>Cell replacement: $500-800 every 3-7 years</li>\\n<li>Annual average: $200-300</li>\\n</ul>\\n<h2>Maintenance Requirements</h2>\\n<h3>Chlorine Pool Maintenance</h3>\\n<p>Daily/Weekly tasks:</p>\\n<ul>\\n<li>Test and adjust chlorine levels</li>\\n<li>Add chlorine as needed</li>\\n<li>Balance pH and alkalinity</li>\\n<li>Shock treatment weekly</li>\\n</ul>\\n<h3>Saltwater Pool Maintenance</h3>\\n<p>Weekly/Monthly tasks:</p>\\n<ul>\\n<li>Check salt levels (monthly)</li>\\n<li>Clean salt cell (every 3 months)</li>\\n<li>Balance pH and alkalinity</li>\\n<li>Less frequent shocking needed</li>\\n</ul>\\n<h2>Pros and Cons</h2>\\n<h3>Chlorine Pools</h3>\\n<p><strong>Advantages:</strong></p>\\n<ul>\\n<li>✅ Lower initial cost</li>\\n<li>✅ Familiar technology</li>\\n<li>✅ Quick problem resolution</li>\\n<li>✅ Works in all climates</li>\\n</ul>\\n<p><strong>Disadvantages:</strong></p>\\n<ul>\\n<li>❌ Strong chemical smell</li>\\n<li>❌ Skin and eye irritation</li>\\n<li>❌ Frequent chemical handling</li>\\n<li>❌ Higher ongoing costs</li>\\n</ul>\\n<h3>Saltwater Pools</h3>\\n<p><strong>Advantages:</strong></p>\\n<ul>\\n<li>✅ Gentler on skin and eyes</li>\\n<li>✅ Lower chemical costs</li>\\n<li>✅ More stable chlorine levels</li>\\n<li>✅ Silky water feel</li>\\n</ul>\\n<p><strong>Disadvantages:</strong></p>\\n<ul>\\n<li>❌ High upfront investment</li>\\n<li>❌ Salt corrosion risk</li>\\n<li>❌ Complex troubleshooting</li>\\n<li>❌ Cell replacement costs</li>\\n</ul>\\n<h2>Health and Comfort Considerations</h2>\\n<h3>Skin and Hair</h3>\\n<p>Saltwater pools are generally gentler on skin and hair. The lower chlorine concentration and absence of chloramines reduce:</p>\\n<ul>\\n<li>Dry, itchy skin</li>\\n<li>Red, irritated eyes</li>\\n<li>Damaged, discolored hair</li>\\n<li>Faded swimwear</li>\\n</ul>\\n<h3>Swimming Experience</h3>\\n<p>Many swimmers prefer saltwater pools for:</p>\\n<ul>\\n<li>Softer water feel</li>\\n<li>No strong chlorine odor</li>\\n<li>More natural swimming experience</li>\\n<li>Less post-swim shower urgency</li>\\n</ul>\\n<h2>Environmental Impact</h2>\\n<h3>Chlorine Pools</h3>\\n<ul>\\n<li>Chemical production and transportation footprint</li>\\n<li>Potential for chemical spills</li>\\n<li>Chloramine off-gassing</li>\\n</ul>\\n<h3>Saltwater Pools</h3>\\n<ul>\\n<li>Lower chemical transportation needs</li>\\n<li>Salt is a natural product</li>\\n<li>Energy use for chlorine generation</li>\\n<li>Potential salt runoff concerns</li>\\n</ul>\\n<h2>Making Your Decision</h2>\\n<p>Consider these factors:</p>\\n<ol>\\n<li><strong>Budget</strong>: Can you afford the higher initial investment for saltwater?</li>\\n<li><strong>Usage</strong>: High-use pools benefit from saltwater stability</li>\\n<li><strong>Sensitivity</strong>: Family members with sensitive skin prefer saltwater</li>\\n<li><strong>Location</strong>: Coastal areas may already have salt corrosion concerns</li>\\n<li><strong>Maintenance preference</strong>: Do you prefer frequent simple tasks or occasional complex ones?</li>\\n</ol>\\n<h2>Common Myths Debunked</h2>\\n<p><strong>Myth 1</strong>: Saltwater pools are chlorine-free\\n<strong>Truth</strong>: They generate chlorine from salt</p>\\n<p><strong>Myth 2</strong>: Saltwater pools taste like the ocean\\n<strong>Truth</strong>: Salt levels are 10x lower than seawater</p>\\n<p><strong>Myth 3</strong>: Saltwater pools require no maintenance\\n<strong>Truth</strong>: They need different, not less, maintenance</p>\\n<h2>Conclusion</h2>\\n<p>Both systems can provide a clean, safe swimming environment. Chlorine pools offer simplicity and lower initial costs, while saltwater pools provide a more comfortable swimming experience with lower long-term chemical costs.</p>\\n<p>The best choice depends on your priorities: If you want lower upfront costs and don\'t mind regular chemical maintenance, choose chlorine. If you prefer a gentler swimming experience and can invest more initially, saltwater might be your best option.</p>\\n<p>Whichever system you choose, proper maintenance is key to a healthy, enjoyable pool.</p>\\n\", \"excerpt\": \"Saltwater vs Chlorine Pools: Which Is Right for You?\\nOne of the most common questions pool owners face is whether to choose a saltwater or traditional chlorine system. Both have their advantages and disadvantages, and the right choice depends on your specific needs, budget, and preferences.\\nUndersta...\", \"author_id\": 3, \"created_at\": \"2025-09-29 23:48:03\", \"meta_title\": \"Saltwater vs Chlorine Pools: Complete Comparison Guide\", \"updated_at\": \"2025-09-29 23:48:03\", \"category_id\": 5, \"is_published\": true, \"published_at\": \"2024-08-02 00:00:00\", \"featured_image\": \"images/blog/saltwater-vs-chlorine.jpg\", \"meta_description\": \"Compare saltwater and chlorine pools to make the right choice. Learn about costs, maintenance, pros and cons of each system.\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 04:48:03','2025-09-30 04:48:03'),(130,'model',':causer created BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'created',NULL,NULL,'{\"attributes\": {\"id\": 15, \"name\": \"Test Workflow Post 1759205983\", \"slug\": \"test-workflow-1759205983\", \"status\": \"draft\", \"content\": \"Test content for workflow validation\", \"excerpt\": \"Test excerpt\", \"version\": 1, \"author_id\": 1, \"created_at\": \"2025-09-30 04:19:43\", \"updated_at\": \"2025-09-30 04:19:43\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(131,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"draft\", \"submitted_for_review_at\": null}, \"attributes\": {\"status\": \"review\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(132,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"review\", \"reviewed_at\": null, \"reviewer_id\": null, \"is_published\": null, \"published_at\": null, \"review_notes\": null, \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"published\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"reviewer_id\": 1, \"is_published\": true, \"published_at\": \"2025-09-30 04:19:43\", \"review_notes\": \"Approved for testing\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(133,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"published\", \"archived_at\": null, \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"is_published\": true, \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"archived\", \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"is_published\": false, \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(134,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"archived\", \"version\": 1, \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"draft\", \"version\": 2, \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(135,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"draft\", \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"published\", \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(136,'model',':causer created BlogPost Draft Post Test','App\\Models\\BlogPost',16,'created',NULL,NULL,'{\"attributes\": {\"id\": 16, \"name\": \"Draft Post Test\", \"slug\": \"draft-test-1759205983\", \"status\": \"draft\", \"content\": \"Draft content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:19:43\", \"updated_at\": \"2025-09-30 04:19:43\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(137,'model',':causer created BlogPost Review Post Test','App\\Models\\BlogPost',17,'created',NULL,NULL,'{\"attributes\": {\"id\": 17, \"name\": \"Review Post Test\", \"slug\": \"review-test-1759205983\", \"status\": \"review\", \"content\": \"Review content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:19:43\", \"updated_at\": \"2025-09-30 04:19:43\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(138,'model',':causer created BlogPost Published Post Test','App\\Models\\BlogPost',18,'created',NULL,NULL,'{\"attributes\": {\"id\": 18, \"name\": \"Published Post Test\", \"slug\": \"published-test-1759205983\", \"status\": \"published\", \"content\": \"Published content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:19:43\", \"updated_at\": \"2025-09-30 04:19:43\", \"category_id\": 1, \"published_at\": \"2025-09-30 04:19:43\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(139,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"published\", \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"review\", \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(140,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"review\", \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewer_id\": 1, \"is_published\": false, \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"review_notes\": \"Approved for testing\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"published\", \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"reviewer_id\": null, \"is_published\": true, \"published_at\": \"2025-09-30 04:19:43\", \"review_notes\": \"Test without reviewer\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(141,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"published\", \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"review\", \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(142,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewer_id\": null, \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"review_notes\": \"Test without reviewer\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"reviewer_id\": 1, \"published_at\": \"2025-09-30 04:19:43\", \"review_notes\": \"Rejected for testing\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(143,'model',':causer updated BlogPost Test Workflow Post 1759205983','App\\Models\\BlogPost',15,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"review\", \"version\": 2, \"archived_at\": \"2025-09-30T04:19:43.000000Z\", \"reviewed_at\": \"2025-09-30T04:19:43.000000Z\", \"published_at\": \"2025-09-30T04:19:43.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:19:43.000000Z\"}, \"attributes\": {\"status\": \"draft\", \"version\": 3, \"archived_at\": \"2025-09-30 04:19:43\", \"reviewed_at\": \"2025-09-30 04:19:43\", \"published_at\": \"2025-09-30 04:19:43\", \"submitted_for_review_at\": \"2025-09-30 04:19:43\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:19:43','2025-09-30 09:19:43'),(144,'model',':causer created BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'created',NULL,NULL,'{\"attributes\": {\"id\": 19, \"name\": \"Test Workflow Post 1759206227\", \"slug\": \"test-workflow-1759206227\", \"status\": \"draft\", \"content\": \"Test content for workflow validation\", \"excerpt\": \"Test excerpt\", \"version\": 1, \"author_id\": 1, \"created_at\": \"2025-09-30 04:23:47\", \"updated_at\": \"2025-09-30 04:23:47\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(145,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"draft\", \"submitted_for_review_at\": null}, \"attributes\": {\"status\": \"review\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(146,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"review\", \"reviewed_at\": null, \"reviewer_id\": null, \"is_published\": null, \"published_at\": null, \"review_notes\": null, \"submitted_for_review_at\": \"2025-09-30T04:23:47.000000Z\"}, \"attributes\": {\"status\": \"published\", \"reviewed_at\": \"2025-09-30 04:23:47\", \"reviewer_id\": 1, \"is_published\": true, \"published_at\": \"2025-09-30 04:23:47\", \"review_notes\": \"Approved for testing\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(147,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"published\", \"archived_at\": null, \"reviewed_at\": \"2025-09-30T04:23:47.000000Z\", \"is_published\": true, \"published_at\": \"2025-09-30T04:23:47.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:23:47.000000Z\"}, \"attributes\": {\"status\": \"archived\", \"archived_at\": \"2025-09-30 04:23:47\", \"reviewed_at\": \"2025-09-30 04:23:47\", \"is_published\": false, \"published_at\": \"2025-09-30 04:23:47\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(148,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"archived\", \"version\": 1, \"archived_at\": \"2025-09-30T04:23:47.000000Z\", \"reviewed_at\": \"2025-09-30T04:23:47.000000Z\", \"published_at\": \"2025-09-30T04:23:47.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:23:47.000000Z\"}, \"attributes\": {\"status\": \"draft\", \"version\": 2, \"archived_at\": \"2025-09-30 04:23:47\", \"reviewed_at\": \"2025-09-30 04:23:47\", \"published_at\": \"2025-09-30 04:23:47\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(149,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"draft\", \"archived_at\": \"2025-09-30T04:23:47.000000Z\", \"reviewed_at\": \"2025-09-30T04:23:47.000000Z\", \"published_at\": \"2025-09-30T04:23:47.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:23:47.000000Z\"}, \"attributes\": {\"status\": \"published\", \"archived_at\": \"2025-09-30 04:23:47\", \"reviewed_at\": \"2025-09-30 04:23:47\", \"published_at\": \"2025-09-30 04:23:47\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(150,'model',':causer created BlogPost Draft Post Test','App\\Models\\BlogPost',20,'created',NULL,NULL,'{\"attributes\": {\"id\": 20, \"name\": \"Draft Post Test\", \"slug\": \"draft-test-1759206227\", \"status\": \"draft\", \"content\": \"Draft content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:23:47\", \"updated_at\": \"2025-09-30 04:23:47\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(151,'model',':causer created BlogPost Review Post Test','App\\Models\\BlogPost',21,'created',NULL,NULL,'{\"attributes\": {\"id\": 21, \"name\": \"Review Post Test\", \"slug\": \"review-test-1759206227\", \"status\": \"review\", \"content\": \"Review content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:23:47\", \"updated_at\": \"2025-09-30 04:23:47\", \"category_id\": 1}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(152,'model',':causer created BlogPost Published Post Test','App\\Models\\BlogPost',22,'created',NULL,NULL,'{\"attributes\": {\"id\": 22, \"name\": \"Published Post Test\", \"slug\": \"published-test-1759206227\", \"status\": \"published\", \"content\": \"Published content\", \"author_id\": 1, \"created_at\": \"2025-09-30 04:23:47\", \"updated_at\": \"2025-09-30 04:23:47\", \"category_id\": 1, \"published_at\": \"2025-09-30 04:23:47\"}}',NULL,'127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47'),(153,'model',':causer updated BlogPost Test Workflow Post 1759206227','App\\Models\\BlogPost',19,'updated',NULL,NULL,'[]','{\"old\": {\"status\": \"published\", \"archived_at\": \"2025-09-30T04:23:47.000000Z\", \"reviewed_at\": \"2025-09-30T04:23:47.000000Z\", \"published_at\": \"2025-09-30T04:23:47.000000Z\", \"submitted_for_review_at\": \"2025-09-30T04:23:47.000000Z\"}, \"attributes\": {\"status\": \"review\", \"archived_at\": \"2025-09-30 04:23:47\", \"reviewed_at\": \"2025-09-30 04:23:47\", \"published_at\": \"2025-09-30 04:23:47\", \"submitted_for_review_at\": \"2025-09-30 04:23:47\"}}','127.0.0.1','Symfony',NULL,'2025-09-30 09:23:47','2025-09-30 09:23:47');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`),
  KEY `blog_categories_slug_index` (`slug`),
  KEY `blog_categories_is_active_index` (`is_active`),
  KEY `blog_categories_order_index_index` (`order_index`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (1,'Pool Resurfacing','pool-resurfacing','Expert guides on fiberglass, plaster, and pebble pool resurfacing techniques','Pool Resurfacing Tips & Guides | Premier Pool Resurfacing','Learn about pool resurfacing options, costs, and professional techniques from industry experts.',1,1,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(2,'Pool Conversions','pool-conversions','Converting vinyl liner and concrete pools to modern fiberglass','Pool Conversion Guides | Fiberglass Pool Conversions','Everything about converting traditional pools to durable fiberglass pool systems.',1,2,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(3,'Pool Remodeling','pool-remodeling','Pool renovation ideas, design trends, and remodeling projects','Pool Remodeling Ideas & Inspiration | Pool Renovation','Discover pool remodeling ideas, latest design trends, and renovation tips.',1,3,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(4,'Pool Repair','pool-repair','Pool repair solutions for cracks, leaks, and structural issues','Pool Repair Solutions & Tips | Expert Pool Repair','Professional pool repair advice for cracks, leaks, equipment, and structural problems.',1,4,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(5,'Pool Maintenance','pool-maintenance','Pool care tips, maintenance schedules, and water chemistry','Pool Maintenance Guide | Pool Care Tips','Essential pool maintenance tips, cleaning schedules, and water chemistry guides.',1,5,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(6,'Fiberglass Pools','fiberglass-pools','Benefits, installation, and care of fiberglass pool systems','Fiberglass Pool Guide | Benefits & Installation','Learn about fiberglass pool advantages, installation process, and long-term benefits.',1,6,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(9,'Industry News','industry-news','Latest news and updates from the pool industry','Pool Industry News & Updates | Pool Trends','Stay updated with the latest pool industry news, innovations, and market trends.',1,9,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(10,'General','general','General updates and company announcements','Company Updates | Premier Pool Resurfacing News','General news, updates, and announcements from Premier Pool Resurfacing.',1,10,'2025-09-28 10:40:15','2025-09-28 10:40:15'),(11,'Pool Care','pool-care',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(12,'Pool Renovation','pool-renovation',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(13,'Pool Safety','pool-safety',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(14,'Pool Equipment','pool-equipment',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(15,'Seasonal Care','seasonal-care',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52'),(16,'Design & Aesthetics','design-aesthetics',NULL,NULL,NULL,1,0,'2025-09-30 04:35:52','2025-09-30 04:35:52');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `author_id` bigint unsigned NOT NULL,
  `reviewer_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_legacy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hexagon Team',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robots` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
  `json_ld` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `include_in_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('draft','review','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `order_index` int NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `submitted_for_review_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `review_notes` text COLLATE utf8mb4_unicode_ci,
  `version` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_is_published_published_at_index` (`is_published`,`published_at`),
  KEY `blog_posts_slug_index` (`slug`),
  KEY `blog_posts_category_index` (`category`),
  KEY `blog_posts_meta_robots_index` (`meta_robots`),
  KEY `blog_posts_category_id_index` (`category_id`),
  KEY `blog_posts_is_published_index` (`is_published`),
  KEY `blog_posts_published_at_index` (`published_at`),
  KEY `blog_posts_published_date_idx` (`is_published`,`published_at`),
  KEY `blog_posts_cat_published_idx` (`category_id`,`is_published`,`published_at`),
  KEY `blog_posts_author_id_index` (`author_id`),
  KEY `blog_posts_reviewer_id_foreign` (`reviewer_id`),
  KEY `blog_posts_status_published_at_index` (`status`,`published_at`),
  KEY `blog_posts_status_index` (`status`),
  CONSTRAINT `blog_posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `blog_posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `blog_posts_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,11,2,NULL,'Essential Pool Maintenance Guide','essential-pool-maintenance-guide','<p>Maintaining your pool properly is crucial for ensuring crystal clear water and extending the life of your pool equipment. This comprehensive guide covers everything you need to know about pool maintenance.</p><p>Regular maintenance includes checking water chemistry, cleaning filters, and removing debris. By following a consistent maintenance schedule, you can prevent costly repairs and enjoy your pool year-round.</p>','Complete guide to maintaining your swimming pool year-round',NULL,'Hexagon Team','images/blog/pool-maintenance-guide.jpg',NULL,'Essential Pool Maintenance Guide | Expert Tips','Learn professional pool maintenance techniques to keep your pool pristine','index, follow',NULL,NULL,1,1,'published',0,'2024-01-15 15:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(2,12,2,NULL,'Pool Resurfacing: When and Why','pool-resurfacing-when-and-why','<p>Is your pool showing signs of wear? Cracks, rough surfaces, or persistent staining may indicate it\'s time for resurfacing. This article explains when to resurface your pool and the benefits it provides.</p><p>Pool resurfacing not only improves aesthetics but also extends your pool\'s lifespan and can reduce maintenance costs. Learn about different resurfacing options and their costs.</p>','Discover when your pool needs resurfacing and the benefits',NULL,'Hexagon Team','images/blog/pool-resurfacing-when.jpg',NULL,'When to Resurface Your Pool | Expert Advice','Know the signs that indicate your pool needs resurfacing','index, follow',NULL,NULL,1,1,'published',0,'2024-02-01 16:30:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(3,13,2,NULL,'Top 5 Pool Safety Tips for Families','top-5-pool-safety-tips-for-families','<p>Pool safety is paramount when you have children or pets. These five essential safety tips will help you create a secure swimming environment for your family.</p><p>From proper fencing to chemical storage, we cover all aspects of pool safety. Implementing these measures can prevent accidents and give you peace of mind.</p>','Essential pool safety measures every family should implement',NULL,'Hexagon Team','images/blog/pool-safety-tips.jpg',NULL,'Pool Safety Tips for Families | Keep Kids Safe','Important pool safety guidelines for families with children','index, follow',NULL,NULL,1,1,'published',0,'2024-03-10 19:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(4,14,2,NULL,'Energy-Efficient Pool Equipment','energy-efficient-pool-equipment','<p>Reduce your pool\'s operating costs with energy-efficient equipment. Modern pool pumps, heaters, and LED lighting can significantly lower your energy bills.</p><p>This guide reviews the latest energy-saving pool technologies and calculates potential savings. Make your pool more eco-friendly while saving money.</p>','Save money with energy-efficient pool equipment and technology',NULL,'Hexagon Team','images/blog/energy-efficient-equipment.jpg',NULL,'Energy-Efficient Pool Equipment Guide','Discover how to reduce pool operating costs with efficient equipment','index, follow',NULL,NULL,1,1,'published',0,'2024-03-25 16:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(5,15,2,NULL,'Preparing Your Pool for Summer','preparing-your-pool-for-summer','<p>Get your pool ready for the summer swimming season with our comprehensive preparation checklist. From water chemistry to equipment inspection, we cover everything you need.</p><p>Proper spring preparation ensures your pool is safe, clean, and ready for months of enjoyment. Follow our step-by-step guide for the best results.</p>','Complete checklist for summer pool preparation',NULL,'Hexagon Team','images/blog/summer-pool-prep.jpg',NULL,'Summer Pool Preparation Guide | Get Ready to Swim','Essential steps to prepare your pool for summer season','index, follow',NULL,NULL,1,1,'published',0,'2024-04-15 13:30:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(6,11,2,NULL,'Understanding Pool Water Chemistry','understanding-pool-water-chemistry','<p>Balanced water chemistry is the foundation of a healthy pool. This guide explains pH, alkalinity, chlorine levels, and other crucial chemical parameters.</p><p>Learn how to test your water, interpret results, and make proper adjustments. Proper water chemistry prevents algae, protects equipment, and ensures swimmer comfort.</p>','Master the basics of pool water chemistry and testing',NULL,'Hexagon Team','images/blog/water-chemistry.jpg',NULL,'Pool Water Chemistry Explained | Complete Guide','Understand and maintain perfect pool water chemistry','index, follow',NULL,NULL,1,1,'published',0,'2024-04-28 18:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(7,11,2,NULL,'Pool Tile Cleaning and Maintenance','pool-tile-cleaning-and-maintenance','<p>Keep your pool tiles sparkling with proper cleaning and maintenance techniques. This guide covers everything from calcium removal to grout repair.</p><p>Regular tile maintenance prevents buildup and extends the life of your pool\'s finish. Learn professional cleaning methods and preventive measures.</p>','Professional techniques for cleaning and maintaining pool tiles',NULL,'Hexagon Team','images/blog/tile-cleaning.jpg',NULL,'Pool Tile Cleaning Guide | Remove Calcium Buildup','Expert tips for maintaining clean and beautiful pool tiles','index, follow',NULL,NULL,1,1,'published',0,'2024-05-05 15:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(8,14,2,NULL,'Choosing the Right Pool Filter','choosing-the-right-pool-filter','<p>Your pool filter is crucial for maintaining clean, clear water. This comparison guide helps you choose between sand, cartridge, and DE filters.</p><p>We examine the pros and cons of each filter type, including maintenance requirements and costs. Make an informed decision for your pool\'s filtration needs.</p>','Compare pool filter types and choose the best for your needs',NULL,'Hexagon Team','images/blog/pool-filters.jpg',NULL,'Pool Filter Comparison Guide | Sand vs Cartridge vs DE','Choose the perfect pool filter system for your needs','index, follow',NULL,NULL,1,1,'published',0,'2024-05-20 14:30:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(9,15,2,NULL,'Winterizing Your Pool: Complete Guide','winterizing-your-pool-complete-guide','<p>Properly winterizing your pool protects it from freeze damage and makes spring opening easier. This comprehensive guide covers all winterization steps.</p><p>From balancing water chemistry to installing a winter cover, we detail everything needed for successful pool winterization. Protect your investment during the off-season.</p>','Step-by-step pool winterization guide for cold climates',NULL,'Hexagon Team','images/blog/pool-winterizing.jpg',NULL,'Pool Winterization Guide | Protect Your Pool','Complete instructions for properly winterizing your swimming pool','index, follow',NULL,NULL,1,1,'published',0,'2024-06-01 16:30:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(10,16,2,NULL,'Pool Landscaping Ideas','pool-landscaping-ideas','<p>Transform your pool area into a backyard oasis with creative landscaping ideas. From tropical themes to modern minimalist designs, find inspiration for your pool landscape.</p><p>We cover plant selection, hardscaping options, lighting, and safety considerations. Create a beautiful and functional poolside environment.</p>','Creative landscaping ideas to enhance your pool area',NULL,'Hexagon Team','images/blog/pool-landscaping.jpg',NULL,'Pool Landscaping Ideas | Transform Your Backyard','Beautiful landscaping designs for around your swimming pool','index, follow',NULL,NULL,1,1,'published',0,'2024-06-15 19:00:00',0,'2025-09-30 04:37:11','2025-09-30 04:37:11',NULL,NULL,NULL,NULL,1),(11,11,2,NULL,'DIY Pool Maintenance Schedule - Daily, Weekly, and Monthly Tasks','diy-pool-maintenance-schedule','<h1>DIY Pool Maintenance Schedule</h1>\n<p>Maintaining your pool doesn\'t have to be overwhelming. With a structured schedule and consistent effort, you can keep your pool sparkling clean and equipment running smoothly. This comprehensive guide breaks down maintenance tasks by frequency, making pool care manageable for any pool owner.</p>\n<h2>Daily Tasks (5-10 minutes)</h2>\n<h3>1. Skim the Surface</h3>\n<p>Remove leaves, insects, and debris before they sink and decompose.</p>\n<h3>2. Check Water Level</h3>\n<p>Ensure water is at mid-skimmer level. Add water if needed.</p>\n<h3>3. Empty Skimmer Baskets</h3>\n<p>Clear baskets to maintain proper water flow.</p>\n<h3>4. Quick Visual Inspection</h3>\n<p>Look for:</p>\n<ul>\n<li>Visible algae growth</li>\n<li>Cloudy water</li>\n<li>Equipment leaks</li>\n<li>Unusual sounds</li>\n</ul>\n<h2>Weekly Tasks (1-2 hours)</h2>\n<h3>Monday - Water Testing</h3>\n<p>Test and adjust:</p>\n<ul>\n<li><strong>Chlorine</strong>: 1-3 ppm</li>\n<li><strong>pH</strong>: 7.2-7.6</li>\n<li><strong>Alkalinity</strong>: 80-120 ppm</li>\n</ul>\n<h3>Wednesday - Cleaning</h3>\n<ul>\n<li>Brush walls and floor</li>\n<li>Vacuum pool thoroughly</li>\n<li>Clean tile line with pool brush</li>\n<li>Backwash filter (if pressure is 8-10 PSI above normal)</li>\n</ul>\n<h3>Friday - Shock Treatment</h3>\n<ul>\n<li>Add shock treatment after sunset</li>\n<li>Run pump overnight</li>\n<li>Test chlorine before swimming</li>\n</ul>\n<h3>Saturday - Equipment Check</h3>\n<ul>\n<li>Inspect pump and filter</li>\n<li>Check automatic cleaner</li>\n<li>Test pool lights</li>\n<li>Verify timer settings</li>\n</ul>\n<h2>Bi-Weekly Tasks</h2>\n<h3>Weeks 1 &amp; 3</h3>\n<ul>\n<li><strong>Deep clean filter</strong>: Rinse cartridge filters or backwash DE/sand filters thoroughly</li>\n<li><strong>Water chemistry deep test</strong>: Include calcium hardness and cyanuric acid</li>\n<li><strong>Inspect pool cover</strong>: Clean and check for damage</li>\n</ul>\n<h3>Weeks 2 &amp; 4</h3>\n<ul>\n<li><strong>Clean pool deck</strong>: Power wash if needed</li>\n<li><strong>Trim vegetation</strong>: Keep plants away from pool edge</li>\n<li><strong>Check safety equipment</strong>: Test GFCI outlets, inspect rails and ladders</li>\n</ul>\n<h2>Monthly Tasks</h2>\n<h3>First Monday</h3>\n<p><strong>Complete Water Analysis</strong>\nTest all parameters:</p>\n<ul>\n<li>Free and total chlorine</li>\n<li>pH and alkalinity</li>\n<li>Calcium hardness (200-400 ppm)</li>\n<li>Cyanuric acid (30-50 ppm)</li>\n<li>Total dissolved solids</li>\n<li>Metals (iron, copper)</li>\n</ul>\n<h3>Mid-Month</h3>\n<p><strong>Equipment Maintenance</strong></p>\n<ul>\n<li>Lubricate o-rings</li>\n<li>Check pump seals</li>\n<li>Inspect heater (if applicable)</li>\n<li>Clean salt cell (saltwater pools)</li>\n<li>Test automatic controls</li>\n</ul>\n<h3>Month-End</h3>\n<p><strong>Preventive Measures</strong></p>\n<ul>\n<li>Add algaecide</li>\n<li>Apply metal sequestrant</li>\n<li>Enzyme treatment for oil/organics</li>\n<li>Check and adjust water level</li>\n</ul>\n<h2>Seasonal Maintenance</h2>\n<h3>Spring Opening</h3>\n<ul>\n<li>Remove and clean cover</li>\n<li>Reinstall equipment</li>\n<li>Fill to proper level</li>\n<li>Balance chemistry gradually</li>\n<li>Super-chlorinate</li>\n<li>Run filter continuously for 24-48 hours</li>\n</ul>\n<h3>Summer Intensive</h3>\n<ul>\n<li><strong>June</strong>: Deep clean filter media</li>\n<li><strong>July</strong>: Professional equipment inspection</li>\n<li><strong>August</strong>: Check for sun damage, replace worn parts</li>\n</ul>\n<h3>Fall Preparation</h3>\n<ul>\n<li>Reduce pump runtime gradually</li>\n<li>Deep clean before covering</li>\n<li>Balance chemistry for winter</li>\n<li>Lower water level (if winterizing)</li>\n<li>Add winterizing chemicals</li>\n</ul>\n<h3>Winter (Closed Pools)</h3>\n<ul>\n<li>Monthly cover inspection</li>\n<li>Remove water/snow accumulation</li>\n<li>Check for animal damage</li>\n<li>Monitor chemistry monthly (if not fully winterized)</li>\n</ul>\n<h2>Creating Your Custom Schedule</h2>\n<h3>Step 1: Assess Your Pool</h3>\n<p>Consider:</p>\n<ul>\n<li>Pool size and type</li>\n<li>Bather load</li>\n<li>Surrounding environment</li>\n<li>Climate conditions</li>\n</ul>\n<h3>Step 2: Set Reminders</h3>\n<p>Use:</p>\n<ul>\n<li>Phone calendar alerts</li>\n<li>Pool maintenance apps</li>\n<li>Physical calendar by equipment</li>\n</ul>\n<h3>Step 3: Keep Records</h3>\n<p>Track:</p>\n<ul>\n<li>Chemical additions</li>\n<li>Test results</li>\n<li>Equipment repairs</li>\n<li>Unusual observations</li>\n</ul>\n<h2>Time-Saving Tips</h2>\n<ol>\n<li><strong>Invest in automation</strong>: Timers, automatic cleaners, and chemical feeders</li>\n<li><strong>Maintain consistent schedule</strong>: Prevents bigger problems</li>\n<li><strong>Stock supplies</strong>: Buy chemicals in bulk</li>\n<li><strong>Learn your pool</strong>: Understanding patterns reduces troubleshooting time</li>\n<li><strong>Preventive maintenance</strong>: Address small issues immediately</li>\n</ol>\n<h2>Common Scheduling Mistakes</h2>\n<h3>Avoid These Pitfalls:</h3>\n<ul>\n<li>❌ Skipping tasks when pool \"looks fine\"</li>\n<li>❌ Over-chlorinating to compensate for missed treatments</li>\n<li>❌ Ignoring filter pressure</li>\n<li>❌ Postponing equipment maintenance</li>\n<li>❌ Inconsistent testing</li>\n</ul>\n<h2>Professional Service Integration</h2>\n<h3>When to Call Experts:</h3>\n<ul>\n<li>Annual equipment inspection</li>\n<li>Opening/closing service</li>\n<li>Major repairs</li>\n<li>Persistent water problems</li>\n<li>Equipment upgrades</li>\n</ul>\n<h3>DIY vs Professional Balance:</h3>\n<ul>\n<li><strong>You handle</strong>: Regular cleaning, basic chemistry, simple maintenance</li>\n<li><strong>Pros handle</strong>: Complex repairs, electrical work, plumbing issues</li>\n</ul>\n<h2>Maintenance Log Template</h2>\n<p>Keep track with this simple format:</p>\n<pre><code>Date: _______\nTask Completed: _______\nChemical Added: _______ Amount: _______\nTest Results: Cl:___ pH:___ Alk:___\nNotes: _______\nNext Action: _______\n</code></pre>\n<h2>Conclusion</h2>\n<p>A well-maintained pool is a joy to own and use. By following this schedule and adapting it to your specific needs, you\'ll spend less time fixing problems and more time enjoying your pool. Remember, consistency is key – a little effort regularly prevents major issues down the road.</p>\n<p>Start implementing this schedule today, and watch your pool maintenance become second nature!</p>\n','DIY Pool Maintenance Schedule\nMaintaining your pool doesn\'t have to be overwhelming. With a structured schedule and consistent effort, you can keep your pool sparkling clean and equipment running smoothly. This comprehensive guide breaks down maintenance tasks by frequency, making pool care manageab...',NULL,'Hexagon Team','images/blog/maintenance-schedule.jpg',NULL,'DIY Pool Maintenance Schedule | Complete Guide','Follow our comprehensive DIY pool maintenance schedule with daily, weekly, monthly, and seasonal tasks to keep your pool pristine.','index, follow',NULL,NULL,1,1,'published',0,'2024-08-20 15:00:00',0,'2025-09-30 04:48:03','2025-09-30 04:48:03',NULL,NULL,NULL,NULL,1),(12,14,2,NULL,'The Complete Guide to Pool Automation Systems','pool-automation-systems-guide','<h1>The Complete Guide to Pool Automation Systems</h1>\n<p>Pool automation has revolutionized how pool owners manage and maintain their swimming pools. With smart technology becoming more accessible, automating your pool can save time, money, and ensure optimal water conditions year-round.</p>\n<h2>What is Pool Automation?</h2>\n<p>Pool automation refers to systems that allow you to control various pool functions remotely or automatically. These systems can manage:</p>\n<ul>\n<li><strong>Filtration cycles</strong></li>\n<li><strong>Heating and cooling</strong></li>\n<li><strong>Lighting</strong></li>\n<li><strong>Water features</strong></li>\n<li><strong>Chemical dosing</strong></li>\n<li><strong>Cleaning schedules</strong></li>\n</ul>\n<h2>Benefits of Pool Automation</h2>\n<h3>1. Energy Efficiency</h3>\n<p>Modern automation systems optimize equipment runtime, reducing energy consumption by up to 70%. Smart scheduling ensures pumps and heaters run only when necessary.</p>\n<h3>2. Water Conservation</h3>\n<p>Automated water level management prevents overflow and maintains optimal levels, saving thousands of gallons annually.</p>\n<h3>3. Chemical Balance</h3>\n<p>Automated chemical feeders maintain perfect water chemistry, reducing manual testing and chemical waste.</p>\n<h3>4. Convenience</h3>\n<p>Control your entire pool system from your smartphone, whether you\'re home or away.</p>\n<h2>Popular Automation Systems</h2>\n<h3>Pentair IntelliCenter</h3>\n<p>The IntelliCenter offers comprehensive control with:</p>\n<ul>\n<li>Mobile app control</li>\n<li>Voice assistant integration</li>\n<li>Energy consumption tracking</li>\n<li>Customizable schedules</li>\n</ul>\n<h3>Hayward OmniLogic</h3>\n<p>Features include:</p>\n<ul>\n<li>ColorLogic lighting control</li>\n<li>Multiple body of water control</li>\n<li>Chemical automation compatibility</li>\n<li>Weather-based adjustments</li>\n</ul>\n<h3>Jandy iAquaLink</h3>\n<p>Highlights:</p>\n<ul>\n<li>Simple setup process</li>\n<li>PDA remote control option</li>\n<li>Integration with home automation</li>\n<li>Real-time notifications</li>\n</ul>\n<h2>Installation Considerations</h2>\n<h3>Professional vs. DIY</h3>\n<p>While some basic automation can be DIY-installed, complex systems require professional installation to ensure:</p>\n<ul>\n<li>Proper electrical connections</li>\n<li>Equipment compatibility</li>\n<li>Warranty compliance</li>\n<li>Safety standards</li>\n</ul>\n<h3>Cost Factors</h3>\n<p>Budget for:</p>\n<ul>\n<li><strong>Basic systems</strong>: $1,500 - $3,000</li>\n<li><strong>Advanced systems</strong>: $3,000 - $7,000</li>\n<li><strong>Installation</strong>: $500 - $2,000</li>\n</ul>\n<h2>Smart Features to Consider</h2>\n<h3>Variable Speed Pumps</h3>\n<p>These pumps adjust speed based on demand, offering:</p>\n<ul>\n<li>90% energy savings</li>\n<li>Quieter operation</li>\n<li>Extended equipment life</li>\n</ul>\n<h3>LED Lighting</h3>\n<p>Programmable LED lights provide:</p>\n<ul>\n<li>Color-changing effects</li>\n<li>Energy efficiency</li>\n<li>Long lifespan (50,000+ hours)</li>\n</ul>\n<h3>Automated Covers</h3>\n<p>Safety covers that open and close automatically:</p>\n<ul>\n<li>Reduce evaporation</li>\n<li>Maintain temperature</li>\n<li>Enhance safety</li>\n</ul>\n<h2>Maintenance Tips</h2>\n<ol>\n<li><strong>Regular Updates</strong>: Keep system firmware updated</li>\n<li><strong>Sensor Cleaning</strong>: Clean sensors monthly for accurate readings</li>\n<li><strong>Battery Replacement</strong>: Replace backup batteries annually</li>\n<li><strong>Professional Inspection</strong>: Annual system check by professionals</li>\n</ol>\n<h2>Future Trends</h2>\n<p>The future of pool automation includes:</p>\n<ul>\n<li><strong>AI-powered predictive maintenance</strong></li>\n<li><strong>Integration with smart home ecosystems</strong></li>\n<li><strong>Solar-powered automation systems</strong></li>\n<li><strong>Advanced water quality monitoring</strong></li>\n</ul>\n<h2>Conclusion</h2>\n<p>Pool automation represents a significant upgrade that pays for itself through energy savings and reduced maintenance costs. Whether you choose a basic timer system or a comprehensive smart solution, automation will transform your pool ownership experience.</p>\n<p>Ready to automate your pool? Contact our experts for a personalized consultation and discover the perfect automation solution for your needs.</p>\n','Discover how pool automation can transform your swimming pool maintenance experience with smart controls, energy savings, and remote management capabilities.',NULL,'Hexagon Team','images/blog/pool-automation.jpg',NULL,'Pool Automation Systems: Complete Setup Guide','Learn about modern pool automation systems, their benefits, and how to choose the right setup for your swimming pool.','index, follow',NULL,NULL,1,1,'published',0,'2024-07-15 05:00:00',0,'2025-09-30 04:48:03','2025-09-30 04:48:03',NULL,NULL,NULL,NULL,1),(13,5,3,NULL,'Saltwater vs Chlorine Pools: Which Is Right for You?','saltwater-vs-chlorine-pools-which-is-right-for-you','<h1>Saltwater vs Chlorine Pools: Which Is Right for You?</h1>\n<p>One of the most common questions pool owners face is whether to choose a saltwater or traditional chlorine system. Both have their advantages and disadvantages, and the right choice depends on your specific needs, budget, and preferences.</p>\n<h2>Understanding the Basics</h2>\n<h3>Traditional Chlorine Pools</h3>\n<p>Traditional pools use chlorine tablets, granules, or liquid chlorine added directly to the water. The chlorine acts as a sanitizer, killing bacteria and algae.</p>\n<h3>Saltwater Pools</h3>\n<p>Contrary to popular belief, saltwater pools still use chlorine. The difference is that they generate chlorine through a salt chlorine generator (also called a salt cell) that converts salt into chlorine through electrolysis.</p>\n<h2>Cost Comparison</h2>\n<h3>Initial Investment</h3>\n<p>| System Type | Initial Cost | Equipment |\n|------------|--------------|-----------|\n| Chlorine | $300-500 | Basic equipment |\n| Saltwater | $1,500-2,500 | Salt generator system |</p>\n<h3>Ongoing Costs</h3>\n<p><strong>Chlorine Pools:</strong></p>\n<ul>\n<li>Monthly chemical costs: $50-100</li>\n<li>Annual total: $600-1,200</li>\n</ul>\n<p><strong>Saltwater Pools:</strong></p>\n<ul>\n<li>Salt replacement: $50-100/year</li>\n<li>Cell replacement: $500-800 every 3-7 years</li>\n<li>Annual average: $200-300</li>\n</ul>\n<h2>Maintenance Requirements</h2>\n<h3>Chlorine Pool Maintenance</h3>\n<p>Daily/Weekly tasks:</p>\n<ul>\n<li>Test and adjust chlorine levels</li>\n<li>Add chlorine as needed</li>\n<li>Balance pH and alkalinity</li>\n<li>Shock treatment weekly</li>\n</ul>\n<h3>Saltwater Pool Maintenance</h3>\n<p>Weekly/Monthly tasks:</p>\n<ul>\n<li>Check salt levels (monthly)</li>\n<li>Clean salt cell (every 3 months)</li>\n<li>Balance pH and alkalinity</li>\n<li>Less frequent shocking needed</li>\n</ul>\n<h2>Pros and Cons</h2>\n<h3>Chlorine Pools</h3>\n<p><strong>Advantages:</strong></p>\n<ul>\n<li>✅ Lower initial cost</li>\n<li>✅ Familiar technology</li>\n<li>✅ Quick problem resolution</li>\n<li>✅ Works in all climates</li>\n</ul>\n<p><strong>Disadvantages:</strong></p>\n<ul>\n<li>❌ Strong chemical smell</li>\n<li>❌ Skin and eye irritation</li>\n<li>❌ Frequent chemical handling</li>\n<li>❌ Higher ongoing costs</li>\n</ul>\n<h3>Saltwater Pools</h3>\n<p><strong>Advantages:</strong></p>\n<ul>\n<li>✅ Gentler on skin and eyes</li>\n<li>✅ Lower chemical costs</li>\n<li>✅ More stable chlorine levels</li>\n<li>✅ Silky water feel</li>\n</ul>\n<p><strong>Disadvantages:</strong></p>\n<ul>\n<li>❌ High upfront investment</li>\n<li>❌ Salt corrosion risk</li>\n<li>❌ Complex troubleshooting</li>\n<li>❌ Cell replacement costs</li>\n</ul>\n<h2>Health and Comfort Considerations</h2>\n<h3>Skin and Hair</h3>\n<p>Saltwater pools are generally gentler on skin and hair. The lower chlorine concentration and absence of chloramines reduce:</p>\n<ul>\n<li>Dry, itchy skin</li>\n<li>Red, irritated eyes</li>\n<li>Damaged, discolored hair</li>\n<li>Faded swimwear</li>\n</ul>\n<h3>Swimming Experience</h3>\n<p>Many swimmers prefer saltwater pools for:</p>\n<ul>\n<li>Softer water feel</li>\n<li>No strong chlorine odor</li>\n<li>More natural swimming experience</li>\n<li>Less post-swim shower urgency</li>\n</ul>\n<h2>Environmental Impact</h2>\n<h3>Chlorine Pools</h3>\n<ul>\n<li>Chemical production and transportation footprint</li>\n<li>Potential for chemical spills</li>\n<li>Chloramine off-gassing</li>\n</ul>\n<h3>Saltwater Pools</h3>\n<ul>\n<li>Lower chemical transportation needs</li>\n<li>Salt is a natural product</li>\n<li>Energy use for chlorine generation</li>\n<li>Potential salt runoff concerns</li>\n</ul>\n<h2>Making Your Decision</h2>\n<p>Consider these factors:</p>\n<ol>\n<li><strong>Budget</strong>: Can you afford the higher initial investment for saltwater?</li>\n<li><strong>Usage</strong>: High-use pools benefit from saltwater stability</li>\n<li><strong>Sensitivity</strong>: Family members with sensitive skin prefer saltwater</li>\n<li><strong>Location</strong>: Coastal areas may already have salt corrosion concerns</li>\n<li><strong>Maintenance preference</strong>: Do you prefer frequent simple tasks or occasional complex ones?</li>\n</ol>\n<h2>Common Myths Debunked</h2>\n<p><strong>Myth 1</strong>: Saltwater pools are chlorine-free\n<strong>Truth</strong>: They generate chlorine from salt</p>\n<p><strong>Myth 2</strong>: Saltwater pools taste like the ocean\n<strong>Truth</strong>: Salt levels are 10x lower than seawater</p>\n<p><strong>Myth 3</strong>: Saltwater pools require no maintenance\n<strong>Truth</strong>: They need different, not less, maintenance</p>\n<h2>Conclusion</h2>\n<p>Both systems can provide a clean, safe swimming environment. Chlorine pools offer simplicity and lower initial costs, while saltwater pools provide a more comfortable swimming experience with lower long-term chemical costs.</p>\n<p>The best choice depends on your priorities: If you want lower upfront costs and don\'t mind regular chemical maintenance, choose chlorine. If you prefer a gentler swimming experience and can invest more initially, saltwater might be your best option.</p>\n<p>Whichever system you choose, proper maintenance is key to a healthy, enjoyable pool.</p>\n','Saltwater vs Chlorine Pools: Which Is Right for You?\nOne of the most common questions pool owners face is whether to choose a saltwater or traditional chlorine system. Both have their advantages and disadvantages, and the right choice depends on your specific needs, budget, and preferences.\nUndersta...',NULL,'Hexagon Team',NULL,NULL,'Saltwater vs Chlorine Pools: Complete Comparison Guide','Compare saltwater and chlorine pools to make the right choice. Learn about costs, maintenance, pros and cons of each system.','index, follow',NULL,NULL,1,1,'published',0,'2024-08-02 05:00:00',0,'2025-09-30 04:48:03','2025-09-30 04:48:03',NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'contact_page',
  `source_uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_submissions_source_index` (`source`),
  KEY `contact_submissions_is_read_index` (`is_read`),
  KEY `contact_submissions_created_at_index` (`created_at`),
  KEY `contact_submissions_email_index` (`email`),
  KEY `contact_submissions_phone_index` (`phone`),
  KEY `contact_submissions_service_index` (`service`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
INSERT INTO `contact_submissions` VALUES (1,NULL,NULL,'test@example.com','555-1234',NULL,'Testing unified contact form','pool-resurfacing-conversion','contact_page',NULL,'127.0.0.1','Test',NULL,0,'2025-09-22 21:55:44','2025-09-22 21:55:44'),(2,NULL,NULL,'request_callback@test.com','555-2508',NULL,'Testing request-callback option','request-callback','contact_page',NULL,'127.0.0.1','Test',NULL,0,'2025-09-22 21:56:20','2025-09-22 21:56:20'),(3,NULL,NULL,'pool_resurfacing_conversion@test.com','555-9554',NULL,'Testing pool-resurfacing-conversion option','pool-resurfacing-conversion','contact_page',NULL,'127.0.0.1','Test',NULL,0,'2025-09-22 21:56:20','2025-09-22 21:56:20'),(4,NULL,NULL,'pool_repair@test.com','555-4442',NULL,'Testing pool-repair option','pool-repair','contact_page',NULL,'127.0.0.1','Test',NULL,0,'2025-09-22 21:56:20','2025-09-22 21:56:20'),(5,NULL,NULL,'pool_remodeling@test.com','555-5262',NULL,'Testing pool-remodeling option','pool-remodeling','contact_page',NULL,'127.0.0.1','Test',NULL,0,'2025-09-22 21:56:20','2025-09-22 21:56:20'),(6,'Jake','','Takpper@gmail.com','469-555-9563',NULL,NULL,'Investor Inquiry: Strategic Partnership','investor_relations_page','http://localhost:8002/investor-relations','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','2025-09-28 11:03:57',0,'2025-09-28 11:03:57','2025-09-28 11:03:57'),(8,'Peter','','no-email@localhost','972-156-3636',NULL,NULL,'request-callback','contact_page','http://localhost:8002/pool-repair-quote','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0','2025-09-29 22:04:40',0,'2025-09-29 22:04:40','2025-09-29 22:04:40');
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_pages`
--

DROP TABLE IF EXISTS `core_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `core_pages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robots` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
  `json_ld` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `include_in_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `core_pages_slug_unique` (`slug`),
  KEY `core_pages_slug_is_active_index` (`slug`),
  KEY `core_pages_is_active_index` (`is_active`),
  KEY `core_pages_slug_index` (`slug`),
  KEY `core_pages_active_slug_idx` (`is_active`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_pages`
--

LOCK TABLES `core_pages` WRITE;
/*!40000 ALTER TABLE `core_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exports`
--

DROP TABLE IF EXISTS `exports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exporter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exports_user_id_foreign` (`user_id`),
  CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exports`
--

LOCK TABLES `exports` WRITE;
/*!40000 ALTER TABLE `exports` DISABLE KEYS */;
/*!40000 ALTER TABLE `exports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_import_rows`
--

DROP TABLE IF EXISTS `failed_import_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_import_rows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `data` json NOT NULL,
  `import_id` bigint unsigned NOT NULL,
  `validation_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_import_rows_import_id_foreign` (`import_id`),
  CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_import_rows`
--

LOCK TABLES `failed_import_rows` WRITE;
/*!40000 ALTER TABLE `failed_import_rows` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_import_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_login_attempts`
--

DROP TABLE IF EXISTS `failed_login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_login_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempted_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_login_attempts_email_ip_address_index` (`email`,`ip_address`),
  KEY `failed_login_attempts_email_index` (`email`),
  KEY `failed_login_attempts_ip_index` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_login_attempts`
--

LOCK TABLES `failed_login_attempts` WRITE;
/*!40000 ALTER TABLE `failed_login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processed_rows` int unsigned NOT NULL DEFAULT '0',
  `total_rows` int unsigned NOT NULL,
  `successful_rows` int unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imports_user_id_foreign` (`user_id`),
  CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitation_tokens`
--

DROP TABLE IF EXISTS `invitation_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invitation_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitation_tokens_token_unique` (`token`),
  KEY `invitation_tokens_token_index` (`token`),
  KEY `invitation_tokens_email_index` (`email`),
  KEY `invitation_tokens_used_expires_at_index` (`expires_at`),
  KEY `invitation_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitation_tokens`
--

LOCK TABLES `invitation_tokens` WRITE;
/*!40000 ALTER TABLE `invitation_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitation_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landing_pages`
--

DROP TABLE IF EXISTS `landing_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `landing_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subheadline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cta_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` json DEFAULT NULL,
  `testimonials` json DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robots` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
  `json_ld` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `include_in_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `custom_css` text COLLATE utf8mb4_unicode_ci,
  `custom_js` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `landing_pages_slug_unique` (`slug`),
  KEY `landing_pages_is_active_slug_index` (`is_active`,`slug`),
  KEY `landing_pages_meta_robots_index` (`meta_robots`),
  KEY `landing_pages_slug_index` (`slug`),
  KEY `landing_pages_is_active_index` (`is_active`),
  KEY `landing_pages_active_slug_idx` (`is_active`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landing_pages`
--

LOCK TABLES `landing_pages` WRITE;
/*!40000 ALTER TABLE `landing_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `landing_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_04_162307_create_services_table',1),(5,'2025_07_04_162315_create_blog_posts_table',1),(6,'2025_07_04_162315_create_contact_submissions_table',1),(7,'2025_07_04_162315_create_landing_pages_table',1),(8,'2025_07_06_184030_add_category_to_blog_posts_table',1),(9,'2025_07_07_010039_add_thumbnail_to_blog_posts_table',1),(10,'2025_07_07_025852_create_core_pages_table',1),(11,'2025_07_07_033141_add_canonical_url_to_core_pages_table',1),(12,'2025_07_07_035643_add_include_in_sitemap_to_core_pages_table',1),(13,'2025_07_07_040426_add_meta_robots_to_core_pages_table',1),(14,'2025_07_07_042145_add_json_ld_to_core_pages_table',1),(15,'2025_07_08_032227_add_seo_fields_to_services_table',1),(16,'2025_07_08_032420_add_seo_fields_to_blog_posts_table',1),(17,'2025_07_08_032543_add_seo_fields_to_landing_pages_table',1),(18,'2025_07_08_070239_add_first_name_last_name_to_contact_submissions_table',1),(19,'2025_07_08_072450_make_message_nullable_in_contact_submissions_table',1),(20,'2025_07_08_074015_add_service_and_source_uri_to_contact_submissions_table',1),(21,'2025_07_08_090601_add_blog_page_to_core_pages_table',1),(22,'2025_07_08_165211_create_tracking_scripts_table',1),(23,'2025_07_09_170153_create_failed_login_attempts_table',1),(24,'2025_07_09_171043_create_invitation_tokens_table',1),(25,'2025_07_22_220535_add_breadcrumb_image_to_services_table',1),(26,'2025_07_27_034847_add_parent_id_to_services_table',1),(27,'2025_07_27_040406_update_services_unique_constraint',1),(28,'2025_08_04_033118_standardize_database_columns',1),(29,'2025_08_04_033255_fix_invitation_tokens_final',1),(30,'2025_08_04_035411_add_is_active_to_core_pages_table',1),(31,'2025_08_04_035817_add_short_description_to_services_table',1),(32,'2025_08_04_041358_fix_blog_posts_columns',1),(33,'2025_08_04_062312_add_missing_columns_to_contact_submissions_table',1),(34,'2025_08_05_133808_add_password_security_fields_to_users_table',1),(35,'2025_08_05_133828_create_password_histories_table',1),(36,'2025_08_05_134833_create_notifications_table',1),(37,'2025_08_05_140759_create_blog_categories_table',1),(38,'2025_08_05_140816_add_category_id_to_blog_posts_table',1),(39,'2025_08_05_141500_migrate_blog_posts_categories',1),(40,'2025_08_05_213239_add_is_admin_to_users_table',1),(41,'2025_08_05_215821_standardize_service_image_paths',1),(42,'2025_08_05_220517_standardize_all_metadata',1),(43,'2025_08_05_221321_revert_metadata_to_hss',1),(44,'2025_08_05_221715_remove_meta_keywords_from_all_tables',1),(45,'2025_08_26_042405_add_featured_image_and_thumbnail_to_blog_posts_table',1),(46,'2025_08_27_061501_add_homepage_image_to_services_table',1),(47,'2025_09_08_180702_add_features_benefits_overview_to_services_table',1),(48,'2025_09_09_170916_create_roles_table',1),(49,'2025_09_09_170920_create_permissions_table',1),(50,'2025_09_09_170938_create_role_user_table',1),(51,'2025_09_09_170942_create_permission_role_table',1),(52,'2025_09_09_170946_create_permission_user_table',1),(53,'2025_09_09_172413_add_performance_indexes_to_database',1),(54,'2025_09_09_173127_convert_blog_posts_author_to_foreign_key',1),(55,'2025_09_12_194909_create_silos_table',1),(59,'2025_09_29_154811_create_imports_table',2),(60,'2025_09_29_154812_create_exports_table',2),(61,'2025_09_29_154813_create_failed_import_rows_table',2),(62,'2025_09_29_create_activity_logs_table',3),(63,'2025_09_30_041003_add_publishing_workflow_to_blog_posts_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_histories`
--

DROP TABLE IF EXISTS `password_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `password_histories_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `password_histories_user_id_index` (`user_id`),
  KEY `password_histories_user_created_idx` (`user_id`,`created_at`),
  CONSTRAINT `password_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_histories`
--

LOCK TABLES `password_histories` WRITE;
/*!40000 ALTER TABLE `password_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_role_permission_id_role_id_unique` (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_user_permission_id_user_id_unique` (`permission_id`,`user_id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  KEY `permission_user_expires_at_index` (`expires_at`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`),
  UNIQUE KEY `permissions_slug_unique` (`slug`),
  KEY `permissions_slug_index` (`slug`),
  KEY `permissions_group_index` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_expires_at_index` (`expires_at`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_slug_unique` (`slug`),
  KEY `roles_slug_index` (`slug`),
  KEY `roles_level_index` (`level`),
  KEY `roles_is_default_index` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `overview` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `features` json DEFAULT NULL,
  `benefits` json DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homepage_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_robots` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
  `json_ld` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `include_in_sitemap` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order_index` int NOT NULL DEFAULT '0',
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_parent_unique` (`slug`,`parent_id`),
  KEY `services_is_active_sort_order_index` (`is_active`,`order_index`),
  KEY `services_slug_index` (`slug`),
  KEY `services_meta_robots_index` (`meta_robots`),
  KEY `services_parent_id_index` (`parent_id`),
  KEY `services_hierarchy_idx` (`parent_id`,`is_active`,`order_index`),
  KEY `services_sitemap_idx` (`include_in_sitemap`,`is_active`),
  CONSTRAINT `services_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Pool Resurfacing','pool-resurfacing','Transform your pool with our premium resurfacing solutions. Long-lasting, beautiful finishes backed by a 25-year warranty.',NULL,'<p>Professional pool resurfacing services that restore and enhance your pool\'s beauty and functionality. We specialize in fiberglass, plaster, and pebble finishes.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'Pool Resurfacing Experts | 25-Year Warranty | Save $22,500','Expert pool resurfacing services in Dallas-Fort Worth. Transform your pool with premium fiberglass coating. 25-year warranty included.','index, follow',NULL,NULL,1,1,10,NULL,'2025-09-24 00:48:44','2025-09-29 23:10:24'),(2,'Pool Conversions','pool-conversions','Convert your traditional pool to modern fiberglass. Upgrade to a low-maintenance, energy-efficient swimming experience.',NULL,'<p>Complete pool conversion services to transform your outdated pool into a modern, efficient fiberglass pool that saves money and maintenance time.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'Pool Conversions | Upgrade to Fiberglass | Dallas-Fort Worth','Convert your gunite or vinyl pool to fiberglass. Reduce maintenance costs by 70% with our professional pool conversion services.','index, follow',NULL,NULL,1,1,11,NULL,'2025-09-24 00:48:44','2025-09-29 23:04:52'),(3,'Pool Remodeling','pool-remodeling','Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.',NULL,'<p>Comprehensive pool remodeling to update every aspect of your pool area. From waterline tiles to deck resurfacing, we handle it all.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'Pool Remodeling | Complete Pool Renovation | DFW','Full-service pool remodeling in Dallas-Fort Worth. Update tiles, coping, equipment, and more with our expert renovation team.','index, follow',NULL,NULL,1,1,12,NULL,'2025-09-24 00:48:44','2025-09-29 23:04:52'),(4,'Pool Repair','pool-repair','Expert pool repair services for cracks, leaks, and structural issues. Permanent solutions with warranty protection.',NULL,'<p>Professional pool repair services addressing all types of damage including cracks, leaks, and equipment failures. Fast, reliable solutions that last.</p>',NULL,NULL,NULL,NULL,NULL,NULL,'Pool Repair | Fix Cracks & Stop Leaks | Permanent Solutions','Expert Pool Repair in Texas. Fix Structural Cracks, Gunite Damage & Concrete Cancer. 25-Year Warranty. Free Estimates. Call (972) 789-2983.','index, follow',NULL,NULL,1,1,4,NULL,'2025-09-24 00:48:44','2025-09-24 00:48:44');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `silos`
--

DROP TABLE IF EXISTS `silos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `silos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_robots` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'index, follow',
  `json_ld` json DEFAULT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homepage_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` json DEFAULT NULL,
  `benefits` json DEFAULT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `silos_slug_unique` (`slug`),
  KEY `silos_slug_index` (`slug`),
  KEY `silos_parent_id_index` (`parent_id`),
  KEY `silos_is_active_index` (`is_active`),
  KEY `silos_sort_order_index` (`sort_order`),
  CONSTRAINT `silos_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `silos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `silos`
--

LOCK TABLES `silos` WRITE;
/*!40000 ALTER TABLE `silos` DISABLE KEYS */;
INSERT INTO `silos` VALUES (1,'Pool Resurfacing','pool-resurfacing',NULL,'Professional pool resurfacing services to restore and enhance your pool\'s appearance and functionality.','<p>Transform your pool with our professional resurfacing services. We offer a variety of materials and finishes to suit your style and budget.</p>','pool-resurfacing','Pool Resurfacing Services | Professional Pool Renovation','Expert pool resurfacing services in DFW. Transform your pool with fiberglass, plaster, or pebble finishes. Get a free quote today!',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2025-09-13 01:00:44','2025-09-22 08:15:17'),(2,'Pool Conversions','pool-conversions',NULL,'Convert your pool to a more efficient system with our professional pool conversion services.',NULL,'pool-conversions','Pool Conversions | Transform to Fiberglass | 25-Year Warranty','Convert your traditional pool to fiberglass. No excavation. 5-7 day installation. North & Central Texas exclusive Fibre Tech dealer. Free quote.','http://localhost/localhost/pool-conversions','index, follow','\"{\\\"@context\\\":\\\"https:\\\\/\\\\/schema.org\\\",\\\"@type\\\":\\\"Service\\\",\\\"name\\\":\\\"Pool Conversions to Fiberglass\\\",\\\"description\\\":\\\"Professional pool conversion services to transform traditional pools to fiberglass with 25-year warranty\\\",\\\"provider\\\":{\\\"@type\\\":\\\"LocalBusiness\\\",\\\"name\\\":\\\"Hexagon Fiberglass Pools\\\",\\\"telephone\\\":\\\"972-789-2983\\\",\\\"address\\\":{\\\"@type\\\":\\\"PostalAddress\\\",\\\"addressLocality\\\":\\\"Dallas\\\",\\\"addressRegion\\\":\\\"TX\\\",\\\"addressCountry\\\":\\\"US\\\"}},\\\"areaServed\\\":{\\\"@type\\\":\\\"State\\\",\\\"name\\\":\\\"Texas\\\"},\\\"serviceType\\\":\\\"Pool Conversion\\\",\\\"url\\\":\\\"http:\\\\/\\\\/localhost\\\\/localhost\\\\/pool-conversions\\\"}\"',NULL,NULL,NULL,NULL,NULL,1,2,'2025-09-13 01:00:44','2025-09-26 18:52:21'),(3,'Pool Remodeling','pool-remodeling',NULL,'Complete pool remodeling services including tile, coping, and equipment upgrades for a total pool transformation.','<p>Transform your entire pool with our comprehensive remodeling services. We handle every aspect of your pool renovation from tiles and coping to equipment and surfaces.</p>','pool-remodeling','Pool Remodeling | Complete Pool Renovation | Dallas-Fort Worth','Complete pool remodeling services in Dallas-Fort Worth. Update tiles, coping, equipment, and surfaces. Transform your pool with expert renovation. Free quote.',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,3,'2025-09-13 01:00:44','2025-09-25 20:14:48'),(4,'Pool Repair','pool-repair-service',NULL,'Fast and reliable pool repair services for all types of pool problems.','<p>Keep your pool in perfect condition with our expert repair services. We handle everything from minor fixes to major repairs.</p>','pool-repair-service','Pool Repair Services | Emergency & Routine Pool Repairs','Professional pool repair services in DFW. Crack repair, leak detection, equipment repair, and more. Fast, reliable service.',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,4,'2025-09-13 01:00:44','2025-09-23 12:49:57'),(5,'Fiberglass Pool Resurfacing','fiberglass-pool-resurfacing',1,'Durable and long-lasting fiberglass pool resurfacing solutions.','<p>Fiberglass resurfacing provides a smooth, durable finish that resists stains and requires minimal maintenance.</p>','fiberglass-pool-resurfacing','Fiberglass Pool Resurfacing | Durable Pool Finishes','Professional fiberglass pool resurfacing services. Long-lasting, low-maintenance finishes for your pool. Get a free quote.',NULL,'index, follow',NULL,NULL,NULL,'[{\"title\": \"Long-lasting Durability\", \"description\": \"Fiberglass surfaces can last 15-30 years with proper care\"}, {\"title\": \"Smooth Finish\", \"description\": \"Non-porous surface that resists algae and stains\"}, {\"title\": \"Low Maintenance\", \"description\": \"Requires less chemicals and cleaning\"}, {\"title\": \"Quick Installation\", \"description\": \"Faster installation compared to other materials\"}]','[{\"title\": \"Cost-Effective\", \"description\": \"Lower long-term maintenance costs\"}, {\"title\": \"Energy Efficient\", \"description\": \"Better heat retention saves on heating costs\"}, {\"title\": \"Comfortable\", \"description\": \"Smooth surface is gentle on feet\"}, {\"title\": \"Versatile Design\", \"description\": \"Available in various colors and patterns\"}]',NULL,1,1,'2025-09-13 01:00:44','2025-09-13 01:00:44'),(6,'Plaster & Marcite Resurfacing','plaster-marcite-resurfacing',1,'Traditional plaster and marcite pool resurfacing for a classic look.','<p>Classic plaster and marcite finishes provide a timeless appearance and reliable performance for your pool.</p>','plaster-marcite-resurfacing','Plaster & Marcite Pool Resurfacing | Classic Pool Finishes','Expert plaster and marcite pool resurfacing services. Traditional finishes with modern application techniques. Free estimates.',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,2,'2025-09-13 01:00:44','2025-09-13 01:00:44'),(7,'Pool Crack Repair','pool-crack-repair',4,'Professional pool crack repair services to prevent water loss and structural damage.','<p>Expert crack repair services to restore your pool\'s integrity and prevent further damage.</p>','pool-crack-repair','Pool Crack Repair Services | Fix Pool Cracks Fast','Professional pool crack repair services in DFW. Fix structural cracks, surface cracks, and prevent water loss. Emergency service available.',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2025-09-13 01:00:44','2025-09-13 01:00:44'),(8,'Pool Tile Remodeling','pool-tile-remodeling',3,'Update your pool with beautiful new tile designs and patterns.','<p>Transform your pool\'s appearance with our professional tile remodeling services.</p>','pool-tile-remodeling','Pool Tile Remodeling | Custom Pool Tile Installation','Professional pool tile remodeling services. Custom designs, waterline tiles, and complete tile renovations. Free design consultation.',NULL,'index, follow',NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2025-09-13 01:00:44','2025-09-13 01:00:44'),(9,'Saltwater Pool Conversion','saltwater-pool-conversion',2,'Convert your chlorine pool to a saltwater system for easier maintenance.','<p>Enjoy the benefits of a saltwater pool with our professional conversion services.</p>','default','Saltwater Pool Conversion | Chlorine to Salt System','Professional saltwater pool conversion services. Convert from chlorine to salt for easier maintenance and better swimming experience.',NULL,'index, follow',NULL,NULL,NULL,'[{\"title\": \"Softer Water\", \"description\": \"Gentler on skin, eyes, and hair\"}, {\"title\": \"Lower Maintenance\", \"description\": \"Self-regulating chlorine production\"}, {\"title\": \"Cost Savings\", \"description\": \"Reduced chemical costs over time\"}, {\"title\": \"Eco-Friendly\", \"description\": \"Fewer harsh chemicals needed\"}]',NULL,NULL,1,1,'2025-09-13 01:00:44','2025-09-13 01:00:44');
/*!40000 ALTER TABLE `silos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tracking_scripts`
--

DROP TABLE IF EXISTS `tracking_scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tracking_scripts` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` enum('head','body_start','body_end') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'head',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracking_scripts`
--

LOCK TABLES `tracking_scripts` WRITE;
/*!40000 ALTER TABLE `tracking_scripts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tracking_scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_changed_at` timestamp NULL DEFAULT NULL,
  `force_password_change` tinyint(1) NOT NULL DEFAULT '0',
  `failed_login_attempts` int NOT NULL DEFAULT '0',
  `locked_until` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_password_changed_at_index` (`password_changed_at`),
  KEY `users_locked_until_index` (`locked_until`),
  KEY `users_last_login_at_index` (`last_login_at`),
  KEY `users_is_admin_index` (`is_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Hexagon Team','author@hexagonservicesolutions.com',0,NULL,'$2y$12$.ej8GvUgL0VC4lIe6J/p3O3xArpTCmS2mou8Leyqe/XgO22kzAqii',NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-09-13 01:00:42','2025-09-13 01:00:42'),(2,'Admin User','admin@hexagonservicesolutions.com',1,NULL,'$2y$12$HOqqryztKu8.SHhK6nA0AOYiN9r1edWOTqjerpqKa7DdyzASlXrjG',NULL,0,0,NULL,0,NULL,NULL,'2025-09-30 04:20:35','127.0.0.1',NULL,'2025-09-22 06:43:04','2025-09-30 04:20:35'),(3,'Ken Tippens','ken.tippens@outlook.com',1,NULL,'$2y$12$KX3bDivZJ8vic1KSVZe9uOOvyJnnM3lA5zTjjfYH3u4Ig27wbMfu2',NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,'2025-09-22 06:43:05','2025-09-22 06:43:05');
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

-- Dump completed on 2025-09-30  4:45:12
