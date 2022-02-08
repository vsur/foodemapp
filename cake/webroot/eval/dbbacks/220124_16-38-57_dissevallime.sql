-- MySQL dump 10.13  Distrib 5.7.32, for osx10.12 (x86_64)
--
-- Host: localhost    Database: dissevallime
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Table structure for table `limo_answer_l10ns`
--

DROP TABLE IF EXISTS `limo_answer_l10ns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_answer_l10ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `answer` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_answer_l10ns_idx` (`aid`,`language`)
) ENGINE=MyISAM AUTO_INCREMENT=547 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_answer_l10ns`
--

LOCK TABLES `limo_answer_l10ns` WRITE;
/*!40000 ALTER TABLE `limo_answer_l10ns` DISABLE KEYS */;
INSERT INTO `limo_answer_l10ns` VALUES (414,413,'Hochschulreife','de'),(546,545,'Walksches Haus','de'),(415,414,'Studium','de'),(527,526,'Ja, ich stimme zu','de'),(413,412,'Mittlere Reife','de'),(412,411,'Quali','de'),(417,416,'Schlecht','de'),(418,417,'Nicht gut','de'),(419,418,'Neutral','de'),(316,315,'1–2 Mal','de'),(317,316,'3–4 Mal','de'),(318,317,'5–6 Mal','de'),(56,55,'Nicht','de'),(57,56,'Wenig','de'),(58,57,'Mittelmäßig','de'),(59,58,'Ziemlich','de'),(60,59,'Sehr','de'),(61,60,'Keine','de'),(62,61,'Vegetarisch','de'),(63,62,'Vegan','de'),(64,63,'Halal','de'),(65,64,'Koscher','de'),(315,314,'< 1Mal','de'),(320,319,'Nein','de'),(334,333,'Nüsse','de'),(333,332,'Gluten','de'),(332,331,'Laktose','de'),(441,440,'Sehr schwer','de'),(442,441,'Schwer','de'),(534,533,'Oishii','de'),(533,532,'Vapiano','de'),(131,130,'Sehr schwer','de'),(132,131,'Schwer','de'),(133,132,'Neutral','de'),(134,133,'Leicht','de'),(135,134,'Sehr leicht','de'),(221,220,'Sehr zufrieden','de'),(220,219,'Zufrieden','de'),(218,217,'Unzufrieden','de'),(219,218,'Neutral','de'),(217,216,'Sehr unzufrieden','de'),(154,153,'Arbeit','de'),(153,152,'Privat','de'),(155,154,'Weniger als 1 Stunde','de'),(156,155,'Etwa 1 Stunde','de'),(157,156,'1–3 Stunden','de'),(158,157,'4–5 Stunden','de'),(159,158,'Mehr als 5 Stunden','de'),(439,438,'Erfahrene Nutzerin, Erfahrener Nutzer','de'),(163,162,'Etwa 1 Stunde','de'),(164,163,'1–3 Stunden','de'),(165,164,'Mehr als 5 Stunden','de'),(166,165,'Weniger als 1 Stunde','de'),(167,166,'4–5 Stunden','de'),(539,538,'DOM - Grill Kitchen Bar','de'),(538,537,'Allvitalis Cocktailbar','de'),(211,210,'Sehr leicht','de'),(210,209,'Leicht','de'),(209,208,'Neutral','de'),(208,207,'Schwer','de'),(207,206,'Sehr schwer','de'),(222,221,'Sehr unzufrieden','de'),(223,222,'Unzufrieden','de'),(224,223,'Neutral','de'),(225,224,'Zufrieden','de'),(226,225,'Sehr zufrieden','de'),(542,541,'s\' Häusle','de'),(543,542,'Kesselhaus','de'),(238,237,'Sehr schwer','de'),(239,238,'Schwer','de'),(240,239,'Neutral','de'),(241,240,'Leicht','de'),(242,241,'Sehr leicht','de'),(243,242,'Sehr unzufrieden','de'),(244,243,'Unzufrieden','de'),(245,244,'Neutral','de'),(246,245,'Zufrieden','de'),(247,246,'Sehr zufrieden','de'),(502,501,'3','de'),(495,494,'2','de'),(423,422,'Nicht gut','de'),(424,423,'Neutral','de'),(496,495,'3','de'),(503,502,'4','de'),(422,421,'Schlecht','de'),(319,318,'Täglich','de'),(335,334,'Histamin','de'),(331,330,'Keine','de'),(443,442,'Es geht','de'),(521,520,'Umfrage erneut starten','de'),(501,500,'2','de'),(494,493,'Stimme überhaupt nicht zu – 1','de'),(535,534,'American Diner Durlach','de'),(537,536,'Scruffy\'s Irish Pub','de'),(536,535,'Oval','de'),(541,540,'Restaurant Kaiserhof','de'),(416,415,'Promotion','de'),(420,419,'Gut','de'),(421,420,'Sehr gut','de'),(425,424,'Gut','de'),(426,425,'Sehr gut','de'),(526,525,'Nein, ich stimme nicht zu','de'),(532,531,'Die Zwiebel','de'),(438,437,'Anfänger','de'),(440,439,'Internet-Profi','de'),(444,443,'Leicht','de'),(445,444,'Sehr leicht','de'),(540,539,'Zur Alten Hackerei','de'),(545,544,'Restaurant Beim Schupi','de'),(544,543,'Exil Cölner','de'),(504,503,'Stimme voll zu – 5','de'),(500,499,'Stimme überhaupt nicht zu – 1','de'),(497,496,'4','de'),(498,497,'Stimme voll zu – 5','de'),(505,504,'Nein, danke, aber es war mir eine Freude mitzumachen','de');
/*!40000 ALTER TABLE `limo_answer_l10ns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_answers`
--

DROP TABLE IF EXISTS `limo_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_answers` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortorder` int(11) NOT NULL,
  `assessment_value` int(11) NOT NULL DEFAULT '0',
  `scale_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `limo_answers_idx` (`qid`,`code`,`scale_id`),
  KEY `limo_answers_idx2` (`sortorder`)
) ENGINE=MyISAM AUTO_INCREMENT=546 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_answers`
--

LOCK TABLES `limo_answers` WRITE;
/*!40000 ALTER TABLE `limo_answers` DISABLE KEYS */;
INSERT INTO `limo_answers` VALUES (415,7,'AO05',4,0,0),(520,4,'AO01',0,0,0),(526,2,'AO01',1,0,0),(414,7,'AO04',3,0,0),(413,7,'AO03',2,0,0),(412,7,'AO02',1,0,0),(411,7,'AO01',0,0,0),(416,8,'AO01',0,0,0),(417,8,'AO02',1,0,0),(418,8,'AO03',2,0,0),(317,9,'AO04',3,0,0),(316,9,'AO03',2,0,0),(315,9,'AO02',1,0,0),(55,10,'AO01',0,0,0),(56,10,'AO02',1,0,0),(57,10,'AO03',2,0,0),(58,10,'AO04',3,0,0),(59,10,'AO05',4,0,0),(60,11,'AO01',0,0,0),(61,11,'AO02',1,0,0),(62,11,'AO03',2,0,0),(63,11,'AO04',3,0,0),(64,11,'AO05',4,0,0),(314,9,'AO01',0,0,0),(319,12,'AO01',0,0,0),(333,13,'AO04',3,0,0),(332,13,'AO03',2,0,0),(331,13,'AO02',1,0,0),(441,14,'AO02',1,0,0),(442,14,'AO03',2,0,0),(534,16,'AO04',3,0,0),(131,17,'AO02',1,0,0),(132,17,'AO03',2,0,0),(133,17,'AO04',3,0,0),(130,17,'AO01',0,0,0),(134,17,'AO05',4,0,0),(219,18,'AO04',3,0,0),(218,18,'AO03',2,0,0),(217,18,'AO02',1,0,0),(216,18,'AO01',0,0,0),(153,19,'AO02',1,0,0),(152,19,'AO01',0,0,0),(154,20,'AO04',0,0,0),(155,20,'AO01',1,0,0),(156,20,'AO02',2,0,0),(157,20,'AO05',3,0,0),(158,20,'AO03',4,0,0),(438,21,'AO02',1,0,0),(439,21,'AO03',2,0,0),(162,22,'AO01',1,0,0),(163,22,'AO02',2,0,0),(164,22,'AO03',4,0,0),(165,22,'AO04',0,0,0),(166,22,'AO05',3,0,0),(538,23,'AO04',3,0,0),(210,24,'AO05',4,0,0),(209,24,'AO04',3,0,0),(208,24,'AO03',2,0,0),(207,24,'AO02',1,0,0),(206,24,'AO01',0,0,0),(537,23,'AO03',2,0,0),(220,18,'AO05',4,0,0),(221,25,'AO01',0,0,0),(222,25,'AO02',1,0,0),(223,25,'AO03',2,0,0),(224,25,'AO04',3,0,0),(225,25,'AO05',4,0,0),(542,26,'AO03',2,0,0),(237,27,'AO01',0,0,0),(238,27,'AO02',1,0,0),(239,27,'AO03',2,0,0),(240,27,'AO04',3,0,0),(241,27,'AO05',4,0,0),(242,28,'AO01',0,0,0),(243,28,'AO02',1,0,0),(244,28,'AO03',2,0,0),(245,28,'AO04',3,0,0),(246,28,'AO05',4,0,0),(503,30,'AO05',4,0,0),(502,30,'AO04',3,0,0),(501,30,'AO03',2,0,0),(500,30,'AO02',1,0,0),(499,30,'AO01',0,0,0),(496,41,'AO04',3,0,0),(495,41,'AO03',2,0,0),(421,55,'AO01',0,0,0),(422,55,'AO02',1,0,0),(423,55,'AO03',2,0,0),(494,41,'AO02',1,0,0),(504,72,'AO01',0,0,0),(543,26,'AO04',3,0,0),(318,9,'AO05',4,0,0),(334,13,'AO05',4,0,0),(330,13,'AO01',0,0,0),(443,14,'AO04',3,0,0),(440,14,'AO01',0,0,0),(497,41,'AO05',4,0,0),(533,16,'AO03',2,0,0),(493,41,'AO01',0,0,0),(536,23,'AO02',1,0,0),(540,26,'AO01',0,0,0),(541,26,'AO02',1,0,0),(419,8,'AO04',3,0,0),(420,8,'AO05',4,0,0),(424,55,'AO04',3,0,0),(425,55,'AO05',4,0,0),(525,2,'AO02',0,0,0),(531,16,'AO01',0,0,0),(532,16,'AO02',1,0,0),(437,21,'AO01',0,0,0),(444,14,'AO05',4,0,0),(539,23,'AO05',4,0,0),(544,26,'AO05',4,0,0),(545,26,'AO06',5,0,0),(535,23,'AO01',0,0,0);
/*!40000 ALTER TABLE `limo_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_archived_table_settings`
--

DROP TABLE IF EXISTS `limo_archived_table_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_archived_table_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tbl_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `properties` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_archived_table_settings`
--

LOCK TABLES `limo_archived_table_settings` WRITE;
/*!40000 ALTER TABLE `limo_archived_table_settings` DISABLE KEYS */;
INSERT INTO `limo_archived_table_settings` VALUES (1,182594,1,'old_survey_182594_20220117140633','response','2022-01-17 15:06:33','[]',NULL),(2,182594,1,'old_survey_182594_timings_20220117140633','timings','2022-01-17 15:06:33','',NULL),(3,182594,1,'old_survey_182594_20220117142706','response','2022-01-17 15:27:06','[]',NULL),(4,182594,1,'old_survey_182594_timings_20220117142706','timings','2022-01-17 15:27:06','',NULL),(5,182594,1,'old_survey_182594_20220117153137','response','2022-01-17 16:31:38','[]',NULL),(6,182594,1,'old_survey_182594_timings_20220117153137','timings','2022-01-17 16:31:38','',NULL),(7,612158,1,'old_survey_612158_20220117153230','response','2022-01-17 16:32:30','[\"612158X9X72\",\"612158X9X72other\"]',NULL),(8,612158,1,'old_survey_612158_timings_20220117153230','timings','2022-01-17 16:32:30','',NULL),(9,612158,1,'old_survey_612158_20220122102852','response','2022-01-22 11:28:52','[\"612158X9X72\",\"612158X9X72other\"]',NULL),(10,612158,1,'old_survey_612158_timings_20220122102852','timings','2022-01-22 11:28:52','',NULL),(11,612158,1,'old_survey_612158_20220122112154','response','2022-01-22 12:21:54','[\"612158X9X72\",\"612158X9X72other\"]',NULL),(12,612158,1,'old_survey_612158_timings_20220122112154','timings','2022-01-22 12:21:55','',NULL);
/*!40000 ALTER TABLE `limo_archived_table_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_assessments`
--

DROP TABLE IF EXISTS `limo_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_assessments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL DEFAULT '0',
  `scope` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gid` int(11) NOT NULL DEFAULT '0',
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximum` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`,`language`),
  KEY `limo_assessments_idx2` (`sid`),
  KEY `limo_assessments_idx3` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_assessments`
--

LOCK TABLES `limo_assessments` WRITE;
/*!40000 ALTER TABLE `limo_assessments` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_asset_version`
--

DROP TABLE IF EXISTS `limo_asset_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_asset_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_asset_version`
--

LOCK TABLES `limo_asset_version` WRITE;
/*!40000 ALTER TABLE `limo_asset_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_asset_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_boxes`
--

DROP TABLE IF EXISTS `limo_boxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `usergroup` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_boxes`
--

LOCK TABLES `limo_boxes` WRITE;
/*!40000 ALTER TABLE `limo_boxes` DISABLE KEYS */;
INSERT INTO `limo_boxes` VALUES (1,1,'surveyAdministration/newSurvey','Create survey','icon-add','Create a new survey','welcome',-2),(2,2,'surveyAdministration/listsurveys','List surveys','icon-list','List available surveys','welcome',-1),(3,3,'admin/globalsettings','Global settings','icon-settings','Edit global settings','welcome',-2),(4,4,'admin/update','ComfortUpdate','icon-shield','Stay safe and up to date','welcome',-2),(5,5,'https://account.limesurvey.org/limestore','LimeStore','fa fa-cart-plus','LimeSurvey extension marketplace','welcome',-2),(6,6,'themeOptions','Themes','icon-templates','Themes','welcome',-2);
/*!40000 ALTER TABLE `limo_boxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_conditions`
--

DROP TABLE IF EXISTS `limo_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_conditions` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL DEFAULT '0',
  `cqid` int(11) NOT NULL DEFAULT '0',
  `cfieldname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `method` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `scenario` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`),
  KEY `limo_conditions_idx` (`qid`),
  KEY `limo_conditions_idx3` (`cqid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_conditions`
--

LOCK TABLES `limo_conditions` WRITE;
/*!40000 ALTER TABLE `limo_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_defaultvalue_l10ns`
--

DROP TABLE IF EXISTS `limo_defaultvalue_l10ns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_defaultvalue_l10ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvid` int(11) NOT NULL DEFAULT '0',
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defaultvalue` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `limo_idx1_defaultvalue_ls` (`dvid`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_defaultvalue_l10ns`
--

LOCK TABLES `limo_defaultvalue_l10ns` WRITE;
/*!40000 ALTER TABLE `limo_defaultvalue_l10ns` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_defaultvalue_l10ns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_defaultvalues`
--

DROP TABLE IF EXISTS `limo_defaultvalues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_defaultvalues` (
  `dvid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL DEFAULT '0',
  `scale_id` int(11) NOT NULL DEFAULT '0',
  `sqid` int(11) NOT NULL DEFAULT '0',
  `specialtype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`dvid`),
  KEY `limo_idx1_defaultvalue` (`qid`,`scale_id`,`sqid`,`specialtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_defaultvalues`
--

LOCK TABLES `limo_defaultvalues` WRITE;
/*!40000 ALTER TABLE `limo_defaultvalues` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_defaultvalues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_expression_errors`
--

DROP TABLE IF EXISTS `limo_expression_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_expression_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `errortime` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `qid` int(11) DEFAULT NULL,
  `gseq` int(11) DEFAULT NULL,
  `qseq` int(11) DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eqn` text COLLATE utf8mb4_unicode_ci,
  `prettyprint` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_expression_errors`
--

LOCK TABLES `limo_expression_errors` WRITE;
/*!40000 ALTER TABLE `limo_expression_errors` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_expression_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_failed_login_attempts`
--

DROP TABLE IF EXISTS `limo_failed_login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_failed_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_attempt` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_attempts` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_failed_login_attempts`
--

LOCK TABLES `limo_failed_login_attempts` WRITE;
/*!40000 ALTER TABLE `limo_failed_login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_failed_login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_group_l10ns`
--

DROP TABLE IF EXISTS `limo_group_l10ns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_group_l10ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `group_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_idx1_group_ls` (`gid`,`language`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_group_l10ns`
--

LOCK TABLES `limo_group_l10ns` WRITE;
/*!40000 ALTER TABLE `limo_group_l10ns` DISABLE KEYS */;
INSERT INTO `limo_group_l10ns` VALUES (3,2,'Umfrage canceln','','de'),(2,1,'Datenschutz und Einverständnis','','de'),(4,3,'Soziodemographische Daten','','de'),(5,4,'Ernährungsbezogene Daten','Dieser Block dient der Erfassung von Daten, die in einem Ernährungsbezug stehen. Hintergrund ist, die Ergebnisse vor einem  „Ernährungskontext“ besser bewerten zu können.','de'),(6,5,'Listen-Ansicht','','de'),(7,6,'Online-Nutzung','Dieser Block dient der Erfassung von Daten zu Ihrem Internet-Level. Hintergrund ist, die Ergebnisse vor einem  „Nutzungskontext“ besser bewerten zu können.','de'),(8,7,'Standardisierter Fragebogen für die Ansichten','<meta charset=\"UTF-8\" />\r\n<p>Vielen Dank, dass Sie diesen Test mitgemacht haben! Es ist wichtig, dass auch neue und alternative Formen von Benutzeroberflächen untersucht werden.</p>\r\n\r\n<p>Am Ende möchte ich gerne noch von Ihnen einen speziellen Fragebogen ausgefüllt haben. Bitte beantworten Sie unten folgende Fragen, um zu bewerten, wie Sie mit den neuen Darstellungen der Ergebnisse bei der Chord-Diagramm-Ansicht und bei der Map-Ansicht zurecht gekommen sind. Bitte versuchen Sie die Fragen vor allem vor dem Hintergrund zu beantworten, dass es bei den alternativen Darstellungsformen darum ging, möglichst gut die selbst gewählten Kategorien zusammen mit den weiteren Kategorien darzustellen, um ein möglichst genaues Bild des jeweiligen Orts zu kommunizieren.</p>\r\n','de'),(9,8,'Letzte Fragen','<p>Am Ende möchte ich Ihnen noch mal die Gelegenheit geben, mir Feedback zu geben, wenn Sie das möchten. </p>\r\n\r\n<p>Es folgt nur mehr die Danksagung und das Speichern der Daten, dieser Schritt ist dann der Abschluss, für die erfolgreiche Abgabe ist er aber wichtig. </p>\r\n','de'),(10,9,'Danksagung','','de'),(11,10,'Weitere spezielle Fragen','Nach dem Test und mit dem Wissen aus dem Test möchte ich jetzt noch einige weitere Fragen stellen.','de'),(17,16,'Chord-Ansicht','','de'),(18,17,'Map-Ansicht','','de'),(19,18,'Tasks','','de');
/*!40000 ALTER TABLE `limo_group_l10ns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_groups`
--

DROP TABLE IF EXISTS `limo_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_groups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL DEFAULT '0',
  `group_order` int(11) NOT NULL DEFAULT '0',
  `randomization_group` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `grelevance` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`gid`),
  KEY `limo_idx1_groups` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_groups`
--

LOCK TABLES `limo_groups` WRITE;
/*!40000 ALTER TABLE `limo_groups` DISABLE KEYS */;
INSERT INTO `limo_groups` VALUES (1,612158,1,'','1'),(2,612158,2,'',''),(3,612158,3,'',''),(4,612158,5,'',''),(5,612158,7,'Diss-Rand-1',''),(6,612158,4,'',''),(7,612158,10,'',''),(8,612158,12,'',''),(9,612158,13,'',''),(10,612158,11,'',''),(16,612158,8,'Diss-Rand-1',''),(17,612158,9,'Diss-Rand-1',''),(18,612158,6,'','');
/*!40000 ALTER TABLE `limo_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_label_l10ns`
--

DROP TABLE IF EXISTS `limo_label_l10ns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_label_l10ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_label_l10ns`
--

LOCK TABLES `limo_label_l10ns` WRITE;
/*!40000 ALTER TABLE `limo_label_l10ns` DISABLE KEYS */;
INSERT INTO `limo_label_l10ns` VALUES (1,1,'Stimme überhaupt nicht zu – 1','de'),(2,2,'2','de'),(3,3,'3','de'),(4,4,'4','de'),(5,5,'Stimme voll zu – 5','de');
/*!40000 ALTER TABLE `limo_label_l10ns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_labels`
--

DROP TABLE IF EXISTS `limo_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL DEFAULT '0',
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortorder` int(11) NOT NULL,
  `assessment_value` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_idx5_labels` (`lid`,`code`),
  KEY `limo_idx1_labels` (`code`),
  KEY `limo_idx2_labels` (`sortorder`),
  KEY `limo_idx4_labels` (`lid`,`sortorder`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_labels`
--

LOCK TABLES `limo_labels` WRITE;
/*!40000 ALTER TABLE `limo_labels` DISABLE KEYS */;
INSERT INTO `limo_labels` VALUES (1,1,'AO01',0,0),(2,1,'AO02',1,0),(3,1,'AO03',2,0),(4,1,'AO04',3,0),(5,1,'AO05',4,0);
/*!40000 ALTER TABLE `limo_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_labelsets`
--

DROP TABLE IF EXISTS `limo_labelsets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_labelsets` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `label_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `languages` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_labelsets`
--

LOCK TABLES `limo_labelsets` WRITE;
/*!40000 ALTER TABLE `limo_labelsets` DISABLE KEYS */;
INSERT INTO `limo_labelsets` VALUES (1,'Zustimmung 5er Likert','de');
/*!40000 ALTER TABLE `limo_labelsets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_map_tutorial_users`
--

DROP TABLE IF EXISTS `limo_map_tutorial_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_map_tutorial_users` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `taken` int(11) DEFAULT '1',
  PRIMARY KEY (`uid`,`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_map_tutorial_users`
--

LOCK TABLES `limo_map_tutorial_users` WRITE;
/*!40000 ALTER TABLE `limo_map_tutorial_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_map_tutorial_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_notifications`
--

DROP TABLE IF EXISTS `limo_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `importance` int(11) NOT NULL DEFAULT '1',
  `display_class` varchar(31) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `first_read` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `limo_notifications_pk` (`entity`,`entity_id`,`status`),
  KEY `limo_idx1_notifications` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_notifications`
--

LOCK TABLES `limo_notifications` WRITE;
/*!40000 ALTER TABLE `limo_notifications` DISABLE KEYS */;
INSERT INTO `limo_notifications` VALUES (1,'user',1,'SSL nicht erzwungen','<span class=\"fa fa-exclamation-circle text-warning\"></span>&nbsp;Warnung: Erzwingen Sie die SSL-Verschlüsselung in den globalen Einstellungen / Sicherheit, nachdem SSL für Ihren Webserver ordnungsgemäß konfiguriert wurde.','new',1,'default','197e2f4b07ecc4d79b9ab282b0f5d62d499a6ae6623e54a466d68ef1fbf53f8d','2022-01-10 09:59:32','2022-01-12 15:22:40'),(2,'user',1,'Password warning','<span class=\"fa fa-exclamation-circle text-warning\"></span>&nbsp;Achtung: Sie benutzen immer noch das Standard-Passwort (&#039;password&#039;). Bitte ändern Sie Ihr Passwort und melden Sie sich erneut an.','read',1,'default','ad50a108d1eabe340f30f4cba82b1d4ce3260fde42d40530bde7d8d46fbdf97f','2022-01-11 11:15:07','2022-01-12 15:22:43');
/*!40000 ALTER TABLE `limo_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participant_attribute`
--

DROP TABLE IF EXISTS `limo_participant_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participant_attribute` (
  `participant_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`participant_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participant_attribute`
--

LOCK TABLES `limo_participant_attribute` WRITE;
/*!40000 ALTER TABLE `limo_participant_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_participant_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participant_attribute_names`
--

DROP TABLE IF EXISTS `limo_participant_attribute_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participant_attribute_names` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_type` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defaultname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encrypted` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_attribute` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attribute_id`,`attribute_type`),
  KEY `limo_idx_participant_attribute_names` (`attribute_id`,`attribute_type`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participant_attribute_names`
--

LOCK TABLES `limo_participant_attribute_names` WRITE;
/*!40000 ALTER TABLE `limo_participant_attribute_names` DISABLE KEYS */;
INSERT INTO `limo_participant_attribute_names` VALUES (1,'TB','firstname','TRUE','Y','Y'),(2,'TB','lastname','TRUE','Y','Y'),(3,'TB','email','TRUE','Y','Y');
/*!40000 ALTER TABLE `limo_participant_attribute_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participant_attribute_names_lang`
--

DROP TABLE IF EXISTS `limo_participant_attribute_names_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participant_attribute_names_lang` (
  `attribute_id` int(11) NOT NULL,
  `attribute_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`attribute_id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participant_attribute_names_lang`
--

LOCK TABLES `limo_participant_attribute_names_lang` WRITE;
/*!40000 ALTER TABLE `limo_participant_attribute_names_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_participant_attribute_names_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participant_attribute_values`
--

DROP TABLE IF EXISTS `limo_participant_attribute_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participant_attribute_values` (
  `value_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participant_attribute_values`
--

LOCK TABLES `limo_participant_attribute_values` WRITE;
/*!40000 ALTER TABLE `limo_participant_attribute_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_participant_attribute_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participant_shares`
--

DROP TABLE IF EXISTS `limo_participant_shares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participant_shares` (
  `participant_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `share_uid` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `can_edit` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`participant_id`,`share_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participant_shares`
--

LOCK TABLES `limo_participant_shares` WRITE;
/*!40000 ALTER TABLE `limo_participant_shares` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_participant_shares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_participants`
--

DROP TABLE IF EXISTS `limo_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_participants` (
  `participant_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` text COLLATE utf8mb4_unicode_ci,
  `lastname` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blacklisted` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_uid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`participant_id`),
  KEY `limo_idx3_participants` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_participants`
--

LOCK TABLES `limo_participants` WRITE;
/*!40000 ALTER TABLE `limo_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_permissions`
--

DROP TABLE IF EXISTS `limo_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `permission` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_p` int(11) NOT NULL DEFAULT '0',
  `read_p` int(11) NOT NULL DEFAULT '0',
  `update_p` int(11) NOT NULL DEFAULT '0',
  `delete_p` int(11) NOT NULL DEFAULT '0',
  `import_p` int(11) NOT NULL DEFAULT '0',
  `export_p` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_idx1_permissions` (`entity_id`,`entity`,`permission`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_permissions`
--

LOCK TABLES `limo_permissions` WRITE;
/*!40000 ALTER TABLE `limo_permissions` DISABLE KEYS */;
INSERT INTO `limo_permissions` VALUES (1,'global',0,1,'superadmin',0,1,0,0,0,0),(2,'survey',612158,1,'assessments',1,1,1,1,0,0),(3,'survey',612158,1,'quotas',1,1,1,1,0,0),(4,'survey',612158,1,'responses',1,1,1,1,1,1),(5,'survey',612158,1,'statistics',0,1,0,0,0,0),(6,'survey',612158,1,'survey',0,1,0,1,0,0),(7,'survey',612158,1,'surveyactivation',0,0,1,0,0,0),(8,'survey',612158,1,'surveycontent',1,1,1,1,1,1),(9,'survey',612158,1,'surveylocale',0,1,1,0,0,0),(10,'survey',612158,1,'surveysecurity',1,1,1,1,0,0),(11,'survey',612158,1,'surveysettings',0,1,1,0,0,0),(12,'survey',612158,1,'tokens',1,1,1,1,1,1),(13,'survey',612158,1,'translations',0,1,1,0,0,0);
/*!40000 ALTER TABLE `limo_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_permissiontemplates`
--

DROP TABLE IF EXISTS `limo_permissiontemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_permissiontemplates` (
  `ptid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `renewed_last` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`ptid`),
  UNIQUE KEY `limo_idx1_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_permissiontemplates`
--

LOCK TABLES `limo_permissiontemplates` WRITE;
/*!40000 ALTER TABLE `limo_permissiontemplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_permissiontemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_plugin_settings`
--

DROP TABLE IF EXISTS `limo_plugin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_plugin_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_id` int(11) NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_plugin_settings`
--

LOCK TABLES `limo_plugin_settings` WRITE;
/*!40000 ALTER TABLE `limo_plugin_settings` DISABLE KEYS */;
INSERT INTO `limo_plugin_settings` VALUES (1,1,NULL,NULL,'next_extension_update_check','\"2022-01-25 09:45:37\"');
/*!40000 ALTER TABLE `limo_plugin_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_plugins`
--

DROP TABLE IF EXISTS `limo_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin_type` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `active` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '0',
  `version` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `load_error` int(11) DEFAULT '0',
  `load_error_message` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_plugins`
--

LOCK TABLES `limo_plugins` WRITE;
/*!40000 ALTER TABLE `limo_plugins` DISABLE KEYS */;
INSERT INTO `limo_plugins` VALUES (1,'UpdateCheck','core',1,0,'1.0.0',0,NULL),(2,'PasswordRequirement','core',1,0,'1.0.0',0,NULL),(3,'ComfortUpdateChecker','core',1,0,'1.0.0',0,NULL),(4,'Authdb','core',1,0,'1.0.0',0,NULL),(5,'AuthLDAP','core',0,0,'1.0.0',0,NULL),(6,'AuditLog','core',0,0,'1.0.0',0,NULL),(7,'Authwebserver','core',0,0,'1.0.0',0,NULL),(8,'ExportR','core',1,0,'1.0.0',0,NULL),(9,'ExportSTATAxml','core',1,0,'1.0.0',0,NULL),(10,'ExportSPSSsav','core',1,0,'1.0.4',0,NULL),(11,'oldUrlCompat','core',0,0,'1.0.1',0,NULL),(12,'expressionQuestionHelp','core',0,0,'1.0.1',0,NULL),(13,'expressionQuestionForAll','core',0,0,'1.0.1',0,NULL),(14,'expressionFixedDbVar','core',0,0,'1.0.2',0,NULL),(15,'customToken','core',0,0,'1.0.1',0,NULL),(16,'mailSenderToFrom','core',0,0,'1.0.0',0,NULL),(17,'TwoFactorAdminLogin','core',0,0,'1.2.5',0,NULL);
/*!40000 ALTER TABLE `limo_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_question_attributes`
--

DROP TABLE IF EXISTS `limo_question_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_question_attributes` (
  `qaid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL DEFAULT '0',
  `attribute` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`qaid`),
  KEY `limo_idx1_question_attributes` (`qid`),
  KEY `limo_idx2_question_attributes` (`attribute`)
) ENGINE=MyISAM AUTO_INCREMENT=1781 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_question_attributes`
--

LOCK TABLES `limo_question_attributes` WRITE;
/*!40000 ALTER TABLE `limo_question_attributes` DISABLE KEYS */;
INSERT INTO `limo_question_attributes` VALUES (1,2,'array_filter_exclude','',''),(2,2,'other_comment_mandatory','0',''),(3,2,'other_numbers_only','0',''),(4,2,'array_filter','',''),(5,2,'array_filter_style','0',''),(6,2,'random_group','',''),(7,2,'em_validation_q','',''),(8,2,'em_validation_q_tip','','en'),(9,2,'fix_height','200',''),(10,2,'fix_width','',''),(11,2,'crop_or_resize','0',''),(12,2,'keep_aspect','0',''),(13,2,'horizontal_scroll','0',''),(14,2,'other_replace_text','','en'),(15,2,'alphasort','0',''),(16,2,'hide_tip','1',''),(17,2,'random_order','0',''),(18,2,'hidden','0',''),(19,2,'cssclass','',''),(20,2,'printable_help','','en'),(21,2,'page_break','0',''),(22,2,'scale_export','0',''),(23,2,'time_limit','',''),(24,2,'time_limit_action','1',''),(25,2,'time_limit_disable_next','0',''),(26,2,'time_limit_disable_prev','0',''),(27,2,'time_limit_countdown_message','','en'),(28,2,'time_limit_timer_style','',''),(29,2,'time_limit_message_delay','',''),(30,2,'time_limit_message','','en'),(31,2,'time_limit_message_style','',''),(32,2,'time_limit_warning','',''),(33,2,'time_limit_warning_display_time','',''),(34,2,'time_limit_warning_message','','en'),(35,2,'time_limit_warning_style','',''),(36,2,'time_limit_warning_2','',''),(37,2,'time_limit_warning_2_display_time','',''),(38,2,'time_limit_warning_2_message','','en'),(39,2,'time_limit_warning_2_style','',''),(40,2,'public_statistics','0',''),(41,2,'statistics_showgraph','1',''),(42,2,'statistics_graphtype','0',''),(43,2,'button_size','lg',''),(44,2,'save_as_default','N',''),(45,2,'clear_default','N',''),(46,2,'em_validation_q_tip','','de'),(47,2,'other_replace_text','','de'),(48,2,'printable_help','','de'),(49,2,'time_limit_countdown_message','','de'),(50,2,'time_limit_message','','de'),(51,2,'time_limit_warning_message','','de'),(52,2,'time_limit_warning_2_message','','de'),(53,2,'max_buttons_row','col-sm-12',''),(184,6,'time_limit_action','1',''),(183,6,'time_limit','',''),(182,6,'numbers_only','0',''),(181,6,'page_break','0',''),(180,6,'maximum_chars','',''),(179,6,'cssclass','',''),(178,6,'hidden','0',''),(177,6,'display_rows','',''),(176,6,'input_size','',''),(175,6,'text_input_width','',''),(174,6,'hide_tip','0',''),(173,6,'suffix','','de'),(172,6,'prefix','','de'),(171,6,'em_validation_q_tip','','de'),(170,6,'em_validation_q','',''),(169,6,'random_group','',''),(168,5,'save_as_default','N',''),(167,5,'statistics_graphtype','0',''),(166,5,'statistics_showgraph','1',''),(165,5,'public_statistics','0',''),(164,5,'page_break','0',''),(163,5,'max_num_value_n','',''),(162,5,'num_value_int_only','0',''),(161,5,'min_num_value_n','',''),(160,5,'maximum_chars','',''),(159,5,'printable_help','','de'),(158,5,'cssclass','',''),(157,5,'hidden','0',''),(156,5,'hide_tip','1',''),(155,5,'input_size','',''),(154,5,'text_input_width','3',''),(153,5,'placeholder','','de'),(152,5,'suffix','','de'),(151,5,'prefix','','de'),(150,5,'em_validation_sq_tip','','de'),(149,5,'em_validation_sq','',''),(148,5,'em_validation_q_tip','','de'),(147,5,'em_validation_q','',''),(146,5,'random_group','',''),(99,4,'array_filter_exclude','',''),(100,4,'other_comment_mandatory','0',''),(101,4,'other_numbers_only','0',''),(102,4,'array_filter','',''),(103,4,'array_filter_style','0',''),(104,4,'random_group','',''),(105,4,'em_validation_q','',''),(106,4,'em_validation_q_tip','','de'),(107,4,'fix_height','200',''),(108,4,'fix_width','',''),(109,4,'crop_or_resize','0',''),(110,4,'keep_aspect','0',''),(111,4,'horizontal_scroll','0',''),(112,4,'other_replace_text','','de'),(113,4,'alphasort','0',''),(114,4,'hide_tip','1',''),(115,4,'random_order','0',''),(116,4,'hidden','0',''),(117,4,'cssclass','',''),(118,4,'printable_help','','de'),(119,4,'page_break','0',''),(120,4,'scale_export','0',''),(121,4,'time_limit','',''),(122,4,'time_limit_action','1',''),(123,4,'time_limit_disable_next','0',''),(124,4,'time_limit_disable_prev','0',''),(125,4,'time_limit_countdown_message','','de'),(126,4,'time_limit_timer_style','',''),(127,4,'time_limit_message_delay','',''),(128,4,'time_limit_message','','de'),(129,4,'time_limit_message_style','',''),(130,4,'time_limit_warning','',''),(131,4,'time_limit_warning_display_time','',''),(132,4,'time_limit_warning_message','','de'),(133,4,'time_limit_warning_style','',''),(134,4,'time_limit_warning_2','',''),(135,4,'time_limit_warning_2_display_time','',''),(136,4,'time_limit_warning_2_message','','de'),(137,4,'time_limit_warning_2_style','',''),(138,4,'public_statistics','0',''),(139,4,'statistics_showgraph','1',''),(140,4,'statistics_graphtype','0',''),(141,4,'button_size','default',''),(142,4,'save_as_default','N',''),(143,4,'clear_default','N',''),(144,4,'max_buttons_row','col-sm-12',''),(145,2,'display_columns','',''),(185,6,'time_limit_disable_next','0',''),(186,6,'time_limit_disable_prev','0',''),(187,6,'time_limit_countdown_message','','de'),(188,6,'time_limit_timer_style','',''),(189,6,'time_limit_message_delay','',''),(190,6,'time_limit_message','','de'),(191,6,'time_limit_message_style','',''),(192,6,'time_limit_warning','',''),(193,6,'time_limit_warning_display_time','',''),(194,6,'time_limit_warning_message','','de'),(195,6,'time_limit_warning_style','',''),(196,6,'time_limit_warning_2','',''),(197,6,'time_limit_warning_2_display_time','',''),(198,6,'time_limit_warning_2_message','','de'),(199,6,'time_limit_warning_2_style','',''),(200,6,'statistics_showmap','1',''),(201,6,'statistics_showgraph','1',''),(202,6,'statistics_graphtype','0',''),(203,6,'location_mapservice','0',''),(204,6,'location_nodefaultfromip','0',''),(205,6,'location_postal','0',''),(206,6,'location_city','0',''),(207,6,'location_state','0',''),(208,6,'location_country','0',''),(209,6,'location_mapzoom','11',''),(210,6,'location_defaultcoordinates','',''),(211,6,'location_mapwidth','500',''),(212,6,'location_mapheight','300',''),(213,6,'save_as_default','N',''),(214,6,'clear_default','N',''),(215,7,'other_comment_mandatory','0',''),(216,7,'other_numbers_only','0',''),(217,7,'array_filter_exclude','',''),(218,7,'array_filter_style','0',''),(219,7,'array_filter','',''),(220,7,'random_group','',''),(221,7,'em_validation_q','',''),(222,7,'em_validation_q_tip','','de'),(223,7,'keep_aspect','0',''),(224,7,'horizontal_scroll','0',''),(225,7,'crop_or_resize','0',''),(226,7,'fix_width','',''),(227,7,'fix_height','200',''),(228,7,'other_replace_text','','de'),(229,7,'display_columns','',''),(230,7,'hide_tip','1',''),(231,7,'random_order','0',''),(232,7,'alphasort','0',''),(233,7,'hidden','0',''),(234,7,'cssclass','',''),(235,7,'printable_help','','de'),(236,7,'page_break','0',''),(237,7,'scale_export','0',''),(238,7,'time_limit','',''),(239,7,'time_limit_action','1',''),(240,7,'time_limit_disable_next','0',''),(241,7,'time_limit_disable_prev','0',''),(242,7,'time_limit_countdown_message','','de'),(243,7,'time_limit_timer_style','',''),(244,7,'time_limit_message_delay','',''),(245,7,'time_limit_message','','de'),(246,7,'time_limit_message_style','',''),(247,7,'time_limit_warning','',''),(248,7,'time_limit_warning_display_time','',''),(249,7,'time_limit_warning_message','','de'),(250,7,'time_limit_warning_style','',''),(251,7,'time_limit_warning_2','',''),(252,7,'time_limit_warning_2_display_time','',''),(253,7,'time_limit_warning_2_message','','de'),(254,7,'time_limit_warning_2_style','',''),(255,7,'public_statistics','0',''),(256,7,'statistics_showgraph','1',''),(257,7,'statistics_graphtype','0',''),(258,7,'save_as_default','Y',''),(259,7,'clear_default','N',''),(260,5,'clear_default','N',''),(261,8,'other_comment_mandatory','0',''),(262,8,'other_numbers_only','0',''),(263,8,'array_filter_exclude','',''),(264,8,'array_filter_style','0',''),(265,8,'array_filter','',''),(266,8,'random_group','',''),(267,8,'em_validation_q','',''),(268,8,'em_validation_q_tip','','de'),(269,8,'keep_aspect','0',''),(270,8,'horizontal_scroll','0',''),(271,8,'crop_or_resize','0',''),(272,8,'fix_width','',''),(273,8,'fix_height','200',''),(274,8,'other_replace_text','','de'),(275,8,'display_columns','',''),(276,8,'hide_tip','1',''),(277,8,'random_order','0',''),(278,8,'alphasort','0',''),(279,8,'hidden','0',''),(280,8,'cssclass','',''),(281,8,'printable_help','','de'),(282,8,'page_break','0',''),(283,8,'scale_export','0',''),(284,8,'time_limit','',''),(285,8,'time_limit_action','1',''),(286,8,'time_limit_disable_next','0',''),(287,8,'time_limit_disable_prev','0',''),(288,8,'time_limit_countdown_message','','de'),(289,8,'time_limit_timer_style','',''),(290,8,'time_limit_message_delay','',''),(291,8,'time_limit_message','','de'),(292,8,'time_limit_message_style','',''),(293,8,'time_limit_warning','',''),(294,8,'time_limit_warning_display_time','',''),(295,8,'time_limit_warning_message','','de'),(296,8,'time_limit_warning_style','',''),(297,8,'time_limit_warning_2','',''),(298,8,'time_limit_warning_2_display_time','',''),(299,8,'time_limit_warning_2_message','','de'),(300,8,'time_limit_warning_2_style','',''),(301,8,'public_statistics','0',''),(302,8,'statistics_showgraph','1',''),(303,8,'statistics_graphtype','0',''),(304,8,'save_as_default','N',''),(305,8,'clear_default','N',''),(306,9,'other_comment_mandatory','0',''),(307,9,'other_numbers_only','0',''),(308,9,'array_filter_exclude','',''),(309,9,'array_filter_style','0',''),(310,9,'array_filter','',''),(311,9,'random_group','',''),(312,9,'em_validation_q','',''),(313,9,'em_validation_q_tip','','de'),(314,9,'keep_aspect','0',''),(315,9,'horizontal_scroll','0',''),(316,9,'crop_or_resize','0',''),(317,9,'fix_width','',''),(318,9,'fix_height','200',''),(319,9,'other_replace_text','','de'),(320,9,'display_columns','',''),(321,9,'hide_tip','1',''),(322,9,'random_order','0',''),(323,9,'alphasort','0',''),(324,9,'hidden','0',''),(325,9,'cssclass','',''),(326,9,'printable_help','','de'),(327,9,'page_break','0',''),(328,9,'scale_export','0',''),(329,9,'time_limit','',''),(330,9,'time_limit_action','1',''),(331,9,'time_limit_disable_next','0',''),(332,9,'time_limit_disable_prev','0',''),(333,9,'time_limit_countdown_message','','de'),(334,9,'time_limit_timer_style','',''),(335,9,'time_limit_message_delay','',''),(336,9,'time_limit_message','','de'),(337,9,'time_limit_message_style','',''),(338,9,'time_limit_warning','',''),(339,9,'time_limit_warning_display_time','',''),(340,9,'time_limit_warning_message','','de'),(341,9,'time_limit_warning_style','',''),(342,9,'time_limit_warning_2','',''),(343,9,'time_limit_warning_2_display_time','',''),(344,9,'time_limit_warning_2_message','','de'),(345,9,'time_limit_warning_2_style','',''),(346,9,'public_statistics','0',''),(347,9,'statistics_showgraph','1',''),(348,9,'statistics_graphtype','0',''),(349,9,'save_as_default','N',''),(350,9,'clear_default','N',''),(351,10,'other_comment_mandatory','0',''),(352,10,'other_numbers_only','0',''),(353,10,'array_filter_exclude','',''),(354,10,'array_filter_style','0',''),(355,10,'array_filter','',''),(356,10,'random_group','',''),(357,10,'em_validation_q','',''),(358,10,'em_validation_q_tip','','de'),(359,10,'keep_aspect','0',''),(360,10,'horizontal_scroll','0',''),(361,10,'crop_or_resize','0',''),(362,10,'fix_width','',''),(363,10,'fix_height','200',''),(364,10,'other_replace_text','','de'),(365,10,'display_columns','',''),(366,10,'hide_tip','1',''),(367,10,'random_order','0',''),(368,10,'alphasort','0',''),(369,10,'hidden','0',''),(370,10,'cssclass','',''),(371,10,'printable_help','','de'),(372,10,'page_break','0',''),(373,10,'scale_export','0',''),(374,10,'time_limit','',''),(375,10,'time_limit_action','1',''),(376,10,'time_limit_disable_next','0',''),(377,10,'time_limit_disable_prev','0',''),(378,10,'time_limit_countdown_message','','de'),(379,10,'time_limit_timer_style','',''),(380,10,'time_limit_message_delay','',''),(381,10,'time_limit_message','','de'),(382,10,'time_limit_message_style','',''),(383,10,'time_limit_warning','',''),(384,10,'time_limit_warning_display_time','',''),(385,10,'time_limit_warning_message','','de'),(386,10,'time_limit_warning_style','',''),(387,10,'time_limit_warning_2','',''),(388,10,'time_limit_warning_2_display_time','',''),(389,10,'time_limit_warning_2_message','','de'),(390,10,'time_limit_warning_2_style','',''),(391,10,'public_statistics','0',''),(392,10,'statistics_showgraph','1',''),(393,10,'statistics_graphtype','0',''),(394,10,'save_as_default','Y',''),(395,10,'clear_default','N',''),(396,11,'other_comment_mandatory','0',''),(397,11,'other_numbers_only','0',''),(398,11,'array_filter_exclude','',''),(399,11,'array_filter_style','0',''),(400,11,'array_filter','',''),(401,11,'random_group','',''),(402,11,'em_validation_q','',''),(403,11,'em_validation_q_tip','','de'),(404,11,'keep_aspect','0',''),(405,11,'horizontal_scroll','0',''),(406,11,'crop_or_resize','0',''),(407,11,'fix_width','',''),(408,11,'fix_height','200',''),(409,11,'other_replace_text','','de'),(410,11,'display_columns','',''),(411,11,'hide_tip','1',''),(412,11,'random_order','0',''),(413,11,'alphasort','0',''),(414,11,'hidden','0',''),(415,11,'cssclass','',''),(416,11,'printable_help','','de'),(417,11,'page_break','0',''),(418,11,'scale_export','0',''),(419,11,'time_limit','',''),(420,11,'time_limit_action','1',''),(421,11,'time_limit_disable_next','0',''),(422,11,'time_limit_disable_prev','0',''),(423,11,'time_limit_countdown_message','','de'),(424,11,'time_limit_timer_style','',''),(425,11,'time_limit_message_delay','',''),(426,11,'time_limit_message','','de'),(427,11,'time_limit_message_style','',''),(428,11,'time_limit_warning','',''),(429,11,'time_limit_warning_display_time','',''),(430,11,'time_limit_warning_message','','de'),(431,11,'time_limit_warning_style','',''),(432,11,'time_limit_warning_2','',''),(433,11,'time_limit_warning_2_display_time','',''),(434,11,'time_limit_warning_2_message','','de'),(435,11,'time_limit_warning_2_style','',''),(436,11,'public_statistics','0',''),(437,11,'statistics_showgraph','1',''),(438,11,'statistics_graphtype','0',''),(439,11,'save_as_default','Y',''),(440,11,'clear_default','N',''),(441,12,'other_comment_mandatory','0',''),(442,12,'other_numbers_only','0',''),(443,12,'array_filter_exclude','',''),(444,12,'array_filter_style','0',''),(445,12,'array_filter','',''),(446,12,'random_group','',''),(447,12,'em_validation_q','',''),(448,12,'em_validation_q_tip','','de'),(449,12,'keep_aspect','0',''),(450,12,'horizontal_scroll','0',''),(451,12,'crop_or_resize','0',''),(452,12,'fix_width','',''),(453,12,'fix_height','200',''),(454,12,'other_replace_text','Ja (bitte angeben)','de'),(455,12,'display_columns','',''),(456,12,'hide_tip','1',''),(457,12,'random_order','0',''),(458,12,'alphasort','0',''),(459,12,'hidden','0',''),(460,12,'cssclass','',''),(461,12,'printable_help','','de'),(462,12,'page_break','0',''),(463,12,'scale_export','0',''),(464,12,'time_limit','',''),(465,12,'time_limit_action','1',''),(466,12,'time_limit_disable_next','0',''),(467,12,'time_limit_disable_prev','0',''),(468,12,'time_limit_countdown_message','','de'),(469,12,'time_limit_timer_style','',''),(470,12,'time_limit_message_delay','',''),(471,12,'time_limit_message','','de'),(472,12,'time_limit_message_style','',''),(473,12,'time_limit_warning','',''),(474,12,'time_limit_warning_display_time','',''),(475,12,'time_limit_warning_message','','de'),(476,12,'time_limit_warning_style','',''),(477,12,'time_limit_warning_2','',''),(478,12,'time_limit_warning_2_display_time','',''),(479,12,'time_limit_warning_2_message','','de'),(480,12,'time_limit_warning_2_style','',''),(481,12,'public_statistics','0',''),(482,12,'statistics_showgraph','1',''),(483,12,'statistics_graphtype','0',''),(484,12,'save_as_default','N',''),(485,12,'clear_default','N',''),(486,13,'other_comment_mandatory','0',''),(487,13,'other_numbers_only','0',''),(488,13,'array_filter_exclude','',''),(489,13,'array_filter_style','0',''),(490,13,'array_filter','',''),(491,13,'random_group','',''),(492,13,'em_validation_q','',''),(493,13,'em_validation_q_tip','','de'),(494,13,'keep_aspect','0',''),(495,13,'horizontal_scroll','0',''),(496,13,'crop_or_resize','0',''),(497,13,'fix_width','',''),(498,13,'fix_height','200',''),(499,13,'other_replace_text','','de'),(500,13,'display_columns','',''),(501,13,'hide_tip','1',''),(502,13,'random_order','0',''),(503,13,'alphasort','0',''),(504,13,'hidden','0',''),(505,13,'cssclass','',''),(506,13,'printable_help','','de'),(507,13,'page_break','0',''),(508,13,'scale_export','0',''),(509,13,'time_limit','',''),(510,13,'time_limit_action','1',''),(511,13,'time_limit_disable_next','0',''),(512,13,'time_limit_disable_prev','0',''),(513,13,'time_limit_countdown_message','','de'),(514,13,'time_limit_timer_style','',''),(515,13,'time_limit_message_delay','',''),(516,13,'time_limit_message','','de'),(517,13,'time_limit_message_style','',''),(518,13,'time_limit_warning','',''),(519,13,'time_limit_warning_display_time','',''),(520,13,'time_limit_warning_message','','de'),(521,13,'time_limit_warning_style','',''),(522,13,'time_limit_warning_2','',''),(523,13,'time_limit_warning_2_display_time','',''),(524,13,'time_limit_warning_2_message','','de'),(525,13,'time_limit_warning_2_style','',''),(526,13,'public_statistics','0',''),(527,13,'statistics_showgraph','1',''),(528,13,'statistics_graphtype','0',''),(529,13,'save_as_default','N',''),(530,13,'clear_default','N',''),(531,14,'other_comment_mandatory','0',''),(532,14,'other_numbers_only','0',''),(533,14,'array_filter_exclude','',''),(534,14,'array_filter_style','0',''),(535,14,'array_filter','',''),(536,14,'random_group','',''),(537,14,'em_validation_q','',''),(538,14,'em_validation_q_tip','','de'),(539,14,'keep_aspect','0',''),(540,14,'horizontal_scroll','0',''),(541,14,'crop_or_resize','0',''),(542,14,'fix_width','',''),(543,14,'fix_height','200',''),(544,14,'other_replace_text','','de'),(545,14,'display_columns','',''),(546,14,'hide_tip','1',''),(547,14,'random_order','0',''),(548,14,'alphasort','0',''),(549,14,'hidden','0',''),(550,14,'cssclass','',''),(551,14,'printable_help','','de'),(552,14,'page_break','0',''),(553,14,'scale_export','0',''),(554,14,'time_limit','',''),(555,14,'time_limit_action','1',''),(556,14,'time_limit_disable_next','0',''),(557,14,'time_limit_disable_prev','0',''),(558,14,'time_limit_countdown_message','','de'),(559,14,'time_limit_timer_style','',''),(560,14,'time_limit_message_delay','',''),(561,14,'time_limit_message','','de'),(562,14,'time_limit_message_style','',''),(563,14,'time_limit_warning','',''),(564,14,'time_limit_warning_display_time','',''),(565,14,'time_limit_warning_message','','de'),(566,14,'time_limit_warning_style','',''),(567,14,'time_limit_warning_2','',''),(568,14,'time_limit_warning_2_display_time','',''),(569,14,'time_limit_warning_2_message','','de'),(570,14,'time_limit_warning_2_style','',''),(571,14,'public_statistics','0',''),(572,14,'statistics_showgraph','1',''),(573,14,'statistics_graphtype','0',''),(574,14,'save_as_default','N',''),(575,14,'clear_default','N',''),(576,15,'random_group','',''),(577,15,'hide_tip','0',''),(578,15,'hidden','0',''),(579,15,'cssclass','',''),(580,15,'page_break','0',''),(581,15,'time_limit','',''),(582,15,'time_limit_action','1',''),(583,15,'time_limit_disable_next','0',''),(584,15,'time_limit_disable_prev','0',''),(585,15,'time_limit_countdown_message','','de'),(586,15,'time_limit_timer_style','',''),(587,15,'time_limit_message_delay','',''),(588,15,'time_limit_message','','de'),(589,15,'time_limit_message_style','',''),(590,15,'time_limit_warning','',''),(591,15,'time_limit_warning_display_time','',''),(592,15,'time_limit_warning_message','','de'),(593,15,'time_limit_warning_style','',''),(594,15,'time_limit_warning_2','',''),(595,15,'time_limit_warning_2_display_time','',''),(596,15,'time_limit_warning_2_message','','de'),(597,15,'time_limit_warning_2_style','',''),(598,15,'statistics_showgraph','1',''),(599,15,'statistics_graphtype','0',''),(600,15,'save_as_default','N',''),(601,15,'clear_default','N',''),(602,16,'other_comment_mandatory','0',''),(603,16,'random_group','',''),(604,16,'em_validation_q','',''),(605,16,'em_validation_q_tip','','de'),(606,16,'alphasort','0',''),(607,16,'category_separator','',''),(608,16,'hide_tip','1',''),(609,16,'random_order','1',''),(610,16,'other_replace_text','','de'),(611,16,'hidden','0',''),(612,16,'cssclass','',''),(613,16,'dropdown_size','',''),(614,16,'printable_help','','de'),(615,16,'dropdown_prefix','0',''),(616,16,'page_break','0',''),(617,16,'scale_export','0',''),(618,16,'time_limit','',''),(619,16,'time_limit_action','1',''),(620,16,'time_limit_disable_next','0',''),(621,16,'time_limit_disable_prev','0',''),(622,16,'time_limit_countdown_message','','de'),(623,16,'time_limit_timer_style','',''),(624,16,'time_limit_message_delay','',''),(625,16,'time_limit_message','','de'),(626,16,'time_limit_message_style','',''),(627,16,'time_limit_warning','',''),(628,16,'time_limit_warning_display_time','',''),(629,16,'time_limit_warning_message','','de'),(630,16,'time_limit_warning_style','',''),(631,16,'time_limit_warning_2','',''),(632,16,'time_limit_warning_2_display_time','',''),(633,16,'time_limit_warning_2_message','','de'),(634,16,'time_limit_warning_2_style','',''),(635,16,'public_statistics','0',''),(636,16,'statistics_showgraph','1',''),(637,16,'statistics_graphtype','0',''),(638,16,'save_as_default','N',''),(639,16,'clear_default','N',''),(640,17,'other_comment_mandatory','0',''),(641,17,'other_numbers_only','0',''),(642,17,'array_filter_exclude','',''),(643,17,'array_filter_style','0',''),(644,17,'array_filter','',''),(645,17,'random_group','',''),(646,17,'em_validation_q','',''),(647,17,'em_validation_q_tip','','de'),(648,17,'keep_aspect','0',''),(649,17,'horizontal_scroll','0',''),(650,17,'crop_or_resize','0',''),(651,17,'fix_width','',''),(652,17,'fix_height','200',''),(653,17,'other_replace_text','','de'),(654,17,'display_columns','',''),(655,17,'hide_tip','1',''),(656,17,'random_order','0',''),(657,17,'alphasort','0',''),(658,17,'hidden','0',''),(659,17,'cssclass','',''),(660,17,'printable_help','','de'),(661,17,'page_break','0',''),(662,17,'scale_export','0',''),(663,17,'time_limit','',''),(664,17,'time_limit_action','1',''),(665,17,'time_limit_disable_next','0',''),(666,17,'time_limit_disable_prev','0',''),(667,17,'time_limit_countdown_message','','de'),(668,17,'time_limit_timer_style','',''),(669,17,'time_limit_message_delay','',''),(670,17,'time_limit_message','','de'),(671,17,'time_limit_message_style','',''),(672,17,'time_limit_warning','',''),(673,17,'time_limit_warning_display_time','',''),(674,17,'time_limit_warning_message','','de'),(675,17,'time_limit_warning_style','',''),(676,17,'time_limit_warning_2','',''),(677,17,'time_limit_warning_2_display_time','',''),(678,17,'time_limit_warning_2_message','','de'),(679,17,'time_limit_warning_2_style','',''),(680,17,'public_statistics','0',''),(681,17,'statistics_showgraph','1',''),(682,17,'statistics_graphtype','0',''),(683,17,'save_as_default','N',''),(684,17,'clear_default','N',''),(685,18,'other_comment_mandatory','0',''),(686,18,'other_numbers_only','0',''),(687,18,'array_filter_exclude','',''),(688,18,'array_filter_style','0',''),(689,18,'array_filter','',''),(690,18,'random_group','',''),(691,18,'em_validation_q','',''),(692,18,'em_validation_q_tip','','de'),(693,18,'keep_aspect','0',''),(694,18,'horizontal_scroll','0',''),(695,18,'crop_or_resize','0',''),(696,18,'fix_width','',''),(697,18,'fix_height','200',''),(698,18,'other_replace_text','','de'),(699,18,'display_columns','',''),(700,18,'hide_tip','1',''),(701,18,'random_order','0',''),(702,18,'alphasort','0',''),(703,18,'hidden','0',''),(704,18,'cssclass','',''),(705,18,'printable_help','','de'),(706,18,'page_break','0',''),(707,18,'scale_export','0',''),(708,18,'time_limit','',''),(709,18,'time_limit_action','1',''),(710,18,'time_limit_disable_next','0',''),(711,18,'time_limit_disable_prev','0',''),(712,18,'time_limit_countdown_message','','de'),(713,18,'time_limit_timer_style','',''),(714,18,'time_limit_message_delay','',''),(715,18,'time_limit_message','','de'),(716,18,'time_limit_message_style','',''),(717,18,'time_limit_warning','',''),(718,18,'time_limit_warning_display_time','',''),(719,18,'time_limit_warning_message','','de'),(720,18,'time_limit_warning_style','',''),(721,18,'time_limit_warning_2','',''),(722,18,'time_limit_warning_2_display_time','',''),(723,18,'time_limit_warning_2_message','','de'),(724,18,'time_limit_warning_2_style','',''),(725,18,'public_statistics','0',''),(726,18,'statistics_showgraph','1',''),(727,18,'statistics_graphtype','0',''),(728,18,'save_as_default','N',''),(729,18,'clear_default','N',''),(730,19,'other_comment_mandatory','0',''),(731,19,'other_numbers_only','0',''),(732,19,'array_filter_exclude','',''),(733,19,'array_filter_style','0',''),(734,19,'array_filter','',''),(735,19,'random_group','',''),(736,19,'em_validation_q','',''),(737,19,'em_validation_q_tip','','de'),(738,19,'keep_aspect','0',''),(739,19,'horizontal_scroll','0',''),(740,19,'crop_or_resize','0',''),(741,19,'fix_width','',''),(742,19,'fix_height','200',''),(743,19,'other_replace_text','','de'),(744,19,'display_columns','',''),(745,19,'hide_tip','1',''),(746,19,'random_order','0',''),(747,19,'alphasort','0',''),(748,19,'hidden','0',''),(749,19,'cssclass','',''),(750,19,'printable_help','','de'),(751,19,'page_break','0',''),(752,19,'scale_export','0',''),(753,19,'time_limit','',''),(754,19,'time_limit_action','1',''),(755,19,'time_limit_disable_next','0',''),(756,19,'time_limit_disable_prev','0',''),(757,19,'time_limit_countdown_message','','de'),(758,19,'time_limit_timer_style','',''),(759,19,'time_limit_message_delay','',''),(760,19,'time_limit_message','','de'),(761,19,'time_limit_message_style','',''),(762,19,'time_limit_warning','',''),(763,19,'time_limit_warning_display_time','',''),(764,19,'time_limit_warning_message','','de'),(765,19,'time_limit_warning_style','',''),(766,19,'time_limit_warning_2','',''),(767,19,'time_limit_warning_2_display_time','',''),(768,19,'time_limit_warning_2_message','','de'),(769,19,'time_limit_warning_2_style','',''),(770,19,'public_statistics','0',''),(771,19,'statistics_showgraph','1',''),(772,19,'statistics_graphtype','0',''),(773,19,'save_as_default','N',''),(774,19,'clear_default','N',''),(775,20,'other_comment_mandatory','0',''),(776,20,'other_numbers_only','0',''),(777,20,'array_filter_exclude','',''),(778,20,'array_filter_style','0',''),(779,20,'array_filter','',''),(780,20,'random_group','',''),(781,20,'em_validation_q','',''),(782,20,'em_validation_q_tip','','de'),(783,20,'keep_aspect','0',''),(784,20,'horizontal_scroll','0',''),(785,20,'crop_or_resize','0',''),(786,20,'fix_width','',''),(787,20,'fix_height','200',''),(788,20,'other_replace_text','','de'),(789,20,'display_columns','',''),(790,20,'hide_tip','1',''),(791,20,'random_order','0',''),(792,20,'alphasort','0',''),(793,20,'hidden','0',''),(794,20,'cssclass','',''),(795,20,'printable_help','','de'),(796,20,'page_break','0',''),(797,20,'scale_export','0',''),(798,20,'time_limit','',''),(799,20,'time_limit_action','1',''),(800,20,'time_limit_disable_next','0',''),(801,20,'time_limit_disable_prev','0',''),(802,20,'time_limit_countdown_message','','de'),(803,20,'time_limit_timer_style','',''),(804,20,'time_limit_message_delay','',''),(805,20,'time_limit_message','','de'),(806,20,'time_limit_message_style','',''),(807,20,'time_limit_warning','',''),(808,20,'time_limit_warning_display_time','',''),(809,20,'time_limit_warning_message','','de'),(810,20,'time_limit_warning_style','',''),(811,20,'time_limit_warning_2','',''),(812,20,'time_limit_warning_2_display_time','',''),(813,20,'time_limit_warning_2_message','','de'),(814,20,'time_limit_warning_2_style','',''),(815,20,'public_statistics','0',''),(816,20,'statistics_showgraph','1',''),(817,20,'statistics_graphtype','0',''),(818,20,'save_as_default','Y',''),(819,20,'clear_default','N',''),(820,21,'other_comment_mandatory','0',''),(821,21,'other_numbers_only','0',''),(822,21,'array_filter_exclude','',''),(823,21,'array_filter_style','0',''),(824,21,'array_filter','',''),(825,21,'random_group','',''),(826,21,'em_validation_q','',''),(827,21,'em_validation_q_tip','','de'),(828,21,'keep_aspect','0',''),(829,21,'horizontal_scroll','0',''),(830,21,'crop_or_resize','0',''),(831,21,'fix_width','',''),(832,21,'fix_height','200',''),(833,21,'other_replace_text','','de'),(834,21,'display_columns','',''),(835,21,'hide_tip','1',''),(836,21,'random_order','0',''),(837,21,'alphasort','0',''),(838,21,'hidden','0',''),(839,21,'cssclass','',''),(840,21,'printable_help','','de'),(841,21,'page_break','0',''),(842,21,'scale_export','0',''),(843,21,'time_limit','',''),(844,21,'time_limit_action','1',''),(845,21,'time_limit_disable_next','0',''),(846,21,'time_limit_disable_prev','0',''),(847,21,'time_limit_countdown_message','','de'),(848,21,'time_limit_timer_style','',''),(849,21,'time_limit_message_delay','',''),(850,21,'time_limit_message','','de'),(851,21,'time_limit_message_style','',''),(852,21,'time_limit_warning','',''),(853,21,'time_limit_warning_display_time','',''),(854,21,'time_limit_warning_message','','de'),(855,21,'time_limit_warning_style','',''),(856,21,'time_limit_warning_2','',''),(857,21,'time_limit_warning_2_display_time','',''),(858,21,'time_limit_warning_2_message','','de'),(859,21,'time_limit_warning_2_style','',''),(860,21,'public_statistics','0',''),(861,21,'statistics_showgraph','1',''),(862,21,'statistics_graphtype','0',''),(863,21,'save_as_default','Y',''),(864,21,'clear_default','N',''),(865,22,'other_comment_mandatory','0',''),(866,22,'other_numbers_only','0',''),(867,22,'array_filter_exclude','',''),(868,22,'array_filter_style','0',''),(869,22,'array_filter','',''),(870,22,'random_group','',''),(871,22,'em_validation_q','',''),(872,22,'em_validation_q_tip','','de'),(873,22,'keep_aspect','0',''),(874,22,'horizontal_scroll','0',''),(875,22,'crop_or_resize','0',''),(876,22,'fix_width','',''),(877,22,'fix_height','200',''),(878,22,'other_replace_text','','de'),(879,22,'display_columns','',''),(880,22,'hide_tip','1',''),(881,22,'random_order','0',''),(882,22,'alphasort','0',''),(883,22,'hidden','0',''),(884,22,'cssclass','',''),(885,22,'printable_help','','de'),(886,22,'page_break','0',''),(887,22,'scale_export','0',''),(888,22,'time_limit','',''),(889,22,'time_limit_action','1',''),(890,22,'time_limit_disable_next','0',''),(891,22,'time_limit_disable_prev','0',''),(892,22,'time_limit_countdown_message','','de'),(893,22,'time_limit_timer_style','',''),(894,22,'time_limit_message_delay','',''),(895,22,'time_limit_message','','de'),(896,22,'time_limit_message_style','',''),(897,22,'time_limit_warning','',''),(898,22,'time_limit_warning_display_time','',''),(899,22,'time_limit_warning_message','','de'),(900,22,'time_limit_warning_style','',''),(901,22,'time_limit_warning_2','',''),(902,22,'time_limit_warning_2_display_time','',''),(903,22,'time_limit_warning_2_message','','de'),(904,22,'time_limit_warning_2_style','',''),(905,22,'public_statistics','0',''),(906,22,'statistics_showgraph','1',''),(907,22,'statistics_graphtype','0',''),(908,22,'save_as_default','Y',''),(909,22,'clear_default','N',''),(910,23,'other_comment_mandatory','0',''),(911,23,'random_group','',''),(912,23,'em_validation_q','',''),(913,23,'em_validation_q_tip','','de'),(914,23,'alphasort','0',''),(915,23,'category_separator','',''),(916,23,'hide_tip','1',''),(917,23,'random_order','1',''),(918,23,'other_replace_text','','de'),(919,23,'hidden','0',''),(920,23,'cssclass','',''),(921,23,'dropdown_size','',''),(922,23,'printable_help','','de'),(923,23,'dropdown_prefix','0',''),(924,23,'page_break','0',''),(925,23,'scale_export','0',''),(926,23,'time_limit','',''),(927,23,'time_limit_action','1',''),(928,23,'time_limit_disable_next','0',''),(929,23,'time_limit_disable_prev','0',''),(930,23,'time_limit_countdown_message','','de'),(931,23,'time_limit_timer_style','',''),(932,23,'time_limit_message_delay','',''),(933,23,'time_limit_message','','de'),(934,23,'time_limit_message_style','',''),(935,23,'time_limit_warning','',''),(936,23,'time_limit_warning_display_time','',''),(937,23,'time_limit_warning_message','','de'),(938,23,'time_limit_warning_style','',''),(939,23,'time_limit_warning_2','',''),(940,23,'time_limit_warning_2_display_time','',''),(941,23,'time_limit_warning_2_message','','de'),(942,23,'time_limit_warning_2_style','',''),(943,23,'public_statistics','0',''),(944,23,'statistics_showgraph','1',''),(945,23,'statistics_graphtype','0',''),(946,23,'save_as_default','N',''),(947,23,'clear_default','N',''),(948,24,'other_comment_mandatory','0',''),(949,24,'other_numbers_only','0',''),(950,24,'array_filter_exclude','',''),(951,24,'array_filter_style','0',''),(952,24,'array_filter','',''),(953,24,'random_group','',''),(954,24,'em_validation_q','',''),(955,24,'em_validation_q_tip','','de'),(956,24,'keep_aspect','0',''),(957,24,'horizontal_scroll','0',''),(958,24,'crop_or_resize','0',''),(959,24,'fix_width','',''),(960,24,'fix_height','200',''),(961,24,'other_replace_text','','de'),(962,24,'display_columns','',''),(963,24,'hide_tip','1',''),(964,24,'random_order','0',''),(965,24,'alphasort','0',''),(966,24,'hidden','0',''),(967,24,'cssclass','',''),(968,24,'printable_help','','de'),(969,24,'page_break','0',''),(970,24,'scale_export','0',''),(971,24,'time_limit','',''),(972,24,'time_limit_action','1',''),(973,24,'time_limit_disable_next','0',''),(974,24,'time_limit_disable_prev','0',''),(975,24,'time_limit_countdown_message','','de'),(976,24,'time_limit_timer_style','',''),(977,24,'time_limit_message_delay','',''),(978,24,'time_limit_message','','de'),(979,24,'time_limit_message_style','',''),(980,24,'time_limit_warning','',''),(981,24,'time_limit_warning_display_time','',''),(982,24,'time_limit_warning_message','','de'),(983,24,'time_limit_warning_style','',''),(984,24,'time_limit_warning_2','',''),(985,24,'time_limit_warning_2_display_time','',''),(986,24,'time_limit_warning_2_message','','de'),(987,24,'time_limit_warning_2_style','',''),(988,24,'public_statistics','0',''),(989,24,'statistics_showgraph','1',''),(990,24,'statistics_graphtype','0',''),(991,24,'save_as_default','N',''),(992,24,'clear_default','N',''),(993,25,'other_comment_mandatory','0',''),(994,25,'other_numbers_only','0',''),(995,25,'array_filter_exclude','',''),(996,25,'array_filter_style','0',''),(997,25,'array_filter','',''),(998,25,'random_group','',''),(999,25,'em_validation_q','',''),(1000,25,'em_validation_q_tip','','de'),(1001,25,'keep_aspect','0',''),(1002,25,'horizontal_scroll','0',''),(1003,25,'crop_or_resize','0',''),(1004,25,'fix_width','',''),(1005,25,'fix_height','200',''),(1006,25,'other_replace_text','','de'),(1007,25,'display_columns','',''),(1008,25,'hide_tip','1',''),(1009,25,'random_order','0',''),(1010,25,'alphasort','0',''),(1011,25,'hidden','0',''),(1012,25,'cssclass','',''),(1013,25,'printable_help','','de'),(1014,25,'page_break','0',''),(1015,25,'scale_export','0',''),(1016,25,'time_limit','',''),(1017,25,'time_limit_action','1',''),(1018,25,'time_limit_disable_next','0',''),(1019,25,'time_limit_disable_prev','0',''),(1020,25,'time_limit_countdown_message','','de'),(1021,25,'time_limit_timer_style','',''),(1022,25,'time_limit_message_delay','',''),(1023,25,'time_limit_message','','de'),(1024,25,'time_limit_message_style','',''),(1025,25,'time_limit_warning','',''),(1026,25,'time_limit_warning_display_time','',''),(1027,25,'time_limit_warning_message','','de'),(1028,25,'time_limit_warning_style','',''),(1029,25,'time_limit_warning_2','',''),(1030,25,'time_limit_warning_2_display_time','',''),(1031,25,'time_limit_warning_2_message','','de'),(1032,25,'time_limit_warning_2_style','',''),(1033,25,'public_statistics','0',''),(1034,25,'statistics_showgraph','1',''),(1035,25,'statistics_graphtype','0',''),(1036,25,'save_as_default','N',''),(1037,25,'clear_default','N',''),(1038,26,'other_comment_mandatory','0',''),(1039,26,'random_group','',''),(1040,26,'em_validation_q','',''),(1041,26,'em_validation_q_tip','','de'),(1042,26,'alphasort','0',''),(1043,26,'category_separator','',''),(1044,26,'hide_tip','1',''),(1045,26,'random_order','1',''),(1046,26,'other_replace_text','','de'),(1047,26,'hidden','0',''),(1048,26,'cssclass','',''),(1049,26,'dropdown_size','',''),(1050,26,'printable_help','','de'),(1051,26,'dropdown_prefix','0',''),(1052,26,'page_break','0',''),(1053,26,'scale_export','0',''),(1054,26,'time_limit','',''),(1055,26,'time_limit_action','1',''),(1056,26,'time_limit_disable_next','0',''),(1057,26,'time_limit_disable_prev','0',''),(1058,26,'time_limit_countdown_message','','de'),(1059,26,'time_limit_timer_style','',''),(1060,26,'time_limit_message_delay','',''),(1061,26,'time_limit_message','','de'),(1062,26,'time_limit_message_style','',''),(1063,26,'time_limit_warning','',''),(1064,26,'time_limit_warning_display_time','',''),(1065,26,'time_limit_warning_message','','de'),(1066,26,'time_limit_warning_style','',''),(1067,26,'time_limit_warning_2','',''),(1068,26,'time_limit_warning_2_display_time','',''),(1069,26,'time_limit_warning_2_message','','de'),(1070,26,'time_limit_warning_2_style','',''),(1071,26,'public_statistics','0',''),(1072,26,'statistics_showgraph','1',''),(1073,26,'statistics_graphtype','0',''),(1074,26,'save_as_default','N',''),(1075,26,'clear_default','N',''),(1076,27,'other_comment_mandatory','0',''),(1077,27,'other_numbers_only','0',''),(1078,27,'array_filter_exclude','',''),(1079,27,'array_filter_style','0',''),(1080,27,'array_filter','',''),(1081,27,'random_group','',''),(1082,27,'em_validation_q','',''),(1083,27,'em_validation_q_tip','','de'),(1084,27,'keep_aspect','0',''),(1085,27,'horizontal_scroll','0',''),(1086,27,'crop_or_resize','0',''),(1087,27,'fix_width','',''),(1088,27,'fix_height','200',''),(1089,27,'other_replace_text','','de'),(1090,27,'display_columns','',''),(1091,27,'hide_tip','1',''),(1092,27,'random_order','0',''),(1093,27,'alphasort','0',''),(1094,27,'hidden','0',''),(1095,27,'cssclass','',''),(1096,27,'printable_help','','de'),(1097,27,'page_break','0',''),(1098,27,'scale_export','0',''),(1099,27,'time_limit','',''),(1100,27,'time_limit_action','1',''),(1101,27,'time_limit_disable_next','0',''),(1102,27,'time_limit_disable_prev','0',''),(1103,27,'time_limit_countdown_message','','de'),(1104,27,'time_limit_timer_style','',''),(1105,27,'time_limit_message_delay','',''),(1106,27,'time_limit_message','','de'),(1107,27,'time_limit_message_style','',''),(1108,27,'time_limit_warning','',''),(1109,27,'time_limit_warning_display_time','',''),(1110,27,'time_limit_warning_message','','de'),(1111,27,'time_limit_warning_style','',''),(1112,27,'time_limit_warning_2','',''),(1113,27,'time_limit_warning_2_display_time','',''),(1114,27,'time_limit_warning_2_message','','de'),(1115,27,'time_limit_warning_2_style','',''),(1116,27,'public_statistics','0',''),(1117,27,'statistics_showgraph','1',''),(1118,27,'statistics_graphtype','0',''),(1119,27,'save_as_default','N',''),(1120,27,'clear_default','N',''),(1121,28,'other_comment_mandatory','0',''),(1122,28,'other_numbers_only','0',''),(1123,28,'array_filter_exclude','',''),(1124,28,'array_filter_style','0',''),(1125,28,'array_filter','',''),(1126,28,'random_group','',''),(1127,28,'em_validation_q','',''),(1128,28,'em_validation_q_tip','','de'),(1129,28,'keep_aspect','0',''),(1130,28,'horizontal_scroll','0',''),(1131,28,'crop_or_resize','0',''),(1132,28,'fix_width','',''),(1133,28,'fix_height','200',''),(1134,28,'other_replace_text','','de'),(1135,28,'display_columns','',''),(1136,28,'hide_tip','1',''),(1137,28,'random_order','0',''),(1138,28,'alphasort','0',''),(1139,28,'hidden','0',''),(1140,28,'cssclass','',''),(1141,28,'printable_help','','de'),(1142,28,'page_break','0',''),(1143,28,'scale_export','0',''),(1144,28,'time_limit','',''),(1145,28,'time_limit_action','1',''),(1146,28,'time_limit_disable_next','0',''),(1147,28,'time_limit_disable_prev','0',''),(1148,28,'time_limit_countdown_message','','de'),(1149,28,'time_limit_timer_style','',''),(1150,28,'time_limit_message_delay','',''),(1151,28,'time_limit_message','','de'),(1152,28,'time_limit_message_style','',''),(1153,28,'time_limit_warning','',''),(1154,28,'time_limit_warning_display_time','',''),(1155,28,'time_limit_warning_message','','de'),(1156,28,'time_limit_warning_style','',''),(1157,28,'time_limit_warning_2','',''),(1158,28,'time_limit_warning_2_display_time','',''),(1159,28,'time_limit_warning_2_message','','de'),(1160,28,'time_limit_warning_2_style','',''),(1161,28,'public_statistics','0',''),(1162,28,'statistics_showgraph','1',''),(1163,28,'statistics_graphtype','0',''),(1164,28,'save_as_default','N',''),(1165,28,'clear_default','N',''),(1237,41,'save_as_default','N',''),(1236,41,'statistics_graphtype','0',''),(1235,41,'statistics_showgraph','1',''),(1234,41,'public_statistics','0',''),(1233,41,'scale_export','0',''),(1232,41,'page_break','0',''),(1231,41,'printable_help','','de'),(1230,41,'use_dropdown','0',''),(1229,41,'cssclass','',''),(1228,41,'hidden','0',''),(1227,41,'random_order','0',''),(1226,41,'hide_tip','1',''),(1225,41,'repeat_headings','',''),(1224,41,'answer_width','',''),(1223,41,'em_validation_q_tip','','de'),(1222,41,'em_validation_q','',''),(1221,41,'random_group','',''),(1220,41,'exclude_all_others','',''),(1219,41,'array_filter_exclude','',''),(1218,41,'array_filter','',''),(1217,41,'array_filter_style','0',''),(1216,41,'max_answers','',''),(1215,41,'min_answers','',''),(1192,30,'min_answers','',''),(1193,30,'max_answers','',''),(1194,30,'array_filter_style','0',''),(1195,30,'array_filter','',''),(1196,30,'array_filter_exclude','',''),(1197,30,'exclude_all_others','',''),(1198,30,'random_group','',''),(1199,30,'em_validation_q','',''),(1200,30,'em_validation_q_tip','','de'),(1201,30,'answer_width','',''),(1202,30,'repeat_headings','',''),(1203,30,'hide_tip','1',''),(1204,30,'random_order','0',''),(1205,30,'hidden','0',''),(1206,30,'cssclass','',''),(1207,30,'use_dropdown','0',''),(1208,30,'printable_help','','de'),(1209,30,'page_break','0',''),(1210,30,'scale_export','0',''),(1211,30,'public_statistics','0',''),(1212,30,'statistics_showgraph','1',''),(1213,30,'statistics_graphtype','0',''),(1214,30,'save_as_default','N',''),(1238,41,'clear_default','N',''),(1239,50,'random_group','',''),(1240,50,'em_validation_q','',''),(1241,50,'em_validation_q_tip','','de'),(1242,50,'hide_tip','1',''),(1243,50,'text_input_width','',''),(1244,50,'input_size','',''),(1245,50,'display_rows','3',''),(1246,50,'hidden','0',''),(1247,50,'cssclass','',''),(1248,50,'maximum_chars','',''),(1249,50,'page_break','0',''),(1250,50,'time_limit','',''),(1251,50,'time_limit_action','1',''),(1252,50,'time_limit_disable_next','0',''),(1253,50,'time_limit_disable_prev','0',''),(1254,50,'time_limit_countdown_message','','de'),(1255,50,'time_limit_timer_style','',''),(1256,50,'time_limit_message_delay','',''),(1257,50,'time_limit_message','','de'),(1258,50,'time_limit_message_style','',''),(1259,50,'time_limit_warning','',''),(1260,50,'time_limit_warning_display_time','',''),(1261,50,'time_limit_warning_message','','de'),(1262,50,'time_limit_warning_style','',''),(1263,50,'time_limit_warning_2','',''),(1264,50,'time_limit_warning_2_display_time','',''),(1265,50,'time_limit_warning_2_message','','de'),(1266,50,'time_limit_warning_2_style','',''),(1267,50,'statistics_showgraph','1',''),(1268,50,'statistics_graphtype','0',''),(1269,50,'save_as_default','N',''),(1466,70,'time_limit_warning_message','','de'),(1465,70,'time_limit_warning_display_time','',''),(1464,70,'time_limit_warning','',''),(1463,70,'time_limit_message_style','',''),(1462,70,'time_limit_message','','de'),(1461,70,'time_limit_message_delay','',''),(1460,70,'time_limit_timer_style','',''),(1459,70,'time_limit_countdown_message','','de'),(1458,70,'time_limit_disable_prev','0',''),(1457,70,'time_limit_disable_next','0',''),(1456,70,'time_limit_action','1',''),(1455,70,'time_limit','',''),(1454,70,'page_break','0',''),(1453,70,'maximum_chars','',''),(1452,70,'cssclass','',''),(1451,70,'hidden','0',''),(1450,70,'display_rows','3',''),(1449,70,'input_size','',''),(1448,70,'text_input_width','',''),(1447,70,'hide_tip','1',''),(1446,70,'em_validation_q_tip','','de'),(1445,70,'em_validation_q','',''),(1444,70,'random_group','',''),(1301,52,'random_group','',''),(1302,52,'em_validation_q','',''),(1303,52,'em_validation_q_tip','','de'),(1304,52,'hide_tip','1',''),(1305,52,'text_input_width','',''),(1306,52,'input_size','',''),(1307,52,'display_rows','3',''),(1308,52,'hidden','0',''),(1309,52,'cssclass','',''),(1310,52,'maximum_chars','',''),(1311,52,'page_break','0',''),(1312,52,'time_limit','',''),(1313,52,'time_limit_action','1',''),(1314,52,'time_limit_disable_next','0',''),(1315,52,'time_limit_disable_prev','0',''),(1316,52,'time_limit_countdown_message','','de'),(1317,52,'time_limit_timer_style','',''),(1318,52,'time_limit_message_delay','',''),(1319,52,'time_limit_message','','de'),(1320,52,'time_limit_message_style','',''),(1321,52,'time_limit_warning','',''),(1322,52,'time_limit_warning_display_time','',''),(1323,52,'time_limit_warning_message','','de'),(1324,52,'time_limit_warning_style','',''),(1325,52,'time_limit_warning_2','',''),(1326,52,'time_limit_warning_2_display_time','',''),(1327,52,'time_limit_warning_2_message','','de'),(1328,52,'time_limit_warning_2_style','',''),(1329,52,'statistics_showgraph','1',''),(1330,52,'statistics_graphtype','0',''),(1331,52,'save_as_default','N',''),(1332,52,'clear_default','N',''),(1333,53,'random_group','',''),(1334,53,'em_validation_q','',''),(1335,53,'em_validation_q_tip','','de'),(1336,53,'hide_tip','1',''),(1337,53,'text_input_width','',''),(1338,53,'input_size','',''),(1339,53,'display_rows','3',''),(1340,53,'hidden','0',''),(1341,53,'cssclass','',''),(1342,53,'maximum_chars','',''),(1343,53,'page_break','0',''),(1344,53,'time_limit','',''),(1345,53,'time_limit_action','1',''),(1346,53,'time_limit_disable_next','0',''),(1347,53,'time_limit_disable_prev','0',''),(1348,53,'time_limit_countdown_message','','de'),(1349,53,'time_limit_timer_style','',''),(1350,53,'time_limit_message_delay','',''),(1351,53,'time_limit_message','','de'),(1352,53,'time_limit_message_style','',''),(1353,53,'time_limit_warning','',''),(1354,53,'time_limit_warning_display_time','',''),(1355,53,'time_limit_warning_message','','de'),(1356,53,'time_limit_warning_style','',''),(1357,53,'time_limit_warning_2','',''),(1358,53,'time_limit_warning_2_display_time','',''),(1359,53,'time_limit_warning_2_message','','de'),(1360,53,'time_limit_warning_2_style','',''),(1361,53,'statistics_showgraph','1',''),(1362,53,'statistics_graphtype','0',''),(1363,53,'save_as_default','N',''),(1364,53,'clear_default','N',''),(1365,54,'random_group','',''),(1366,54,'em_validation_q','',''),(1367,54,'em_validation_q_tip','','de'),(1368,54,'hide_tip','1',''),(1369,54,'text_input_width','',''),(1370,54,'input_size','',''),(1371,54,'display_rows','3',''),(1372,54,'hidden','0',''),(1373,54,'cssclass','',''),(1374,54,'maximum_chars','',''),(1375,54,'page_break','0',''),(1376,54,'time_limit','',''),(1377,54,'time_limit_action','1',''),(1378,54,'time_limit_disable_next','0',''),(1379,54,'time_limit_disable_prev','0',''),(1380,54,'time_limit_countdown_message','','de'),(1381,54,'time_limit_timer_style','',''),(1382,54,'time_limit_message_delay','',''),(1383,54,'time_limit_message','','de'),(1384,54,'time_limit_message_style','',''),(1385,54,'time_limit_warning','',''),(1386,54,'time_limit_warning_display_time','',''),(1387,54,'time_limit_warning_message','','de'),(1388,54,'time_limit_warning_style','',''),(1389,54,'time_limit_warning_2','',''),(1390,54,'time_limit_warning_2_display_time','',''),(1391,54,'time_limit_warning_2_message','','de'),(1392,54,'time_limit_warning_2_style','',''),(1393,54,'statistics_showgraph','1',''),(1394,54,'statistics_graphtype','0',''),(1395,54,'save_as_default','N',''),(1396,54,'clear_default','N',''),(1397,55,'other_comment_mandatory','0',''),(1398,55,'other_numbers_only','0',''),(1399,55,'array_filter_exclude','',''),(1400,55,'array_filter_style','0',''),(1401,55,'array_filter','',''),(1402,55,'random_group','',''),(1403,55,'em_validation_q','',''),(1404,55,'em_validation_q_tip','','de'),(1405,55,'keep_aspect','0',''),(1406,55,'horizontal_scroll','0',''),(1407,55,'crop_or_resize','0',''),(1408,55,'fix_width','',''),(1409,55,'fix_height','200',''),(1410,55,'other_replace_text','','de'),(1411,55,'display_columns','',''),(1412,55,'hide_tip','1',''),(1413,55,'random_order','0',''),(1414,55,'alphasort','0',''),(1415,55,'hidden','0',''),(1416,55,'cssclass','',''),(1417,55,'printable_help','','de'),(1418,55,'page_break','0',''),(1419,55,'scale_export','0',''),(1420,55,'time_limit','',''),(1421,55,'time_limit_action','1',''),(1422,55,'time_limit_disable_next','0',''),(1423,55,'time_limit_disable_prev','0',''),(1424,55,'time_limit_countdown_message','','de'),(1425,55,'time_limit_timer_style','',''),(1426,55,'time_limit_message_delay','',''),(1427,55,'time_limit_message','','de'),(1428,55,'time_limit_message_style','',''),(1429,55,'time_limit_warning','',''),(1430,55,'time_limit_warning_display_time','',''),(1431,55,'time_limit_warning_message','','de'),(1432,55,'time_limit_warning_style','',''),(1433,55,'time_limit_warning_2','',''),(1434,55,'time_limit_warning_2_display_time','',''),(1435,55,'time_limit_warning_2_message','','de'),(1436,55,'time_limit_warning_2_style','',''),(1437,55,'public_statistics','0',''),(1438,55,'statistics_showgraph','1',''),(1439,55,'statistics_graphtype','0',''),(1440,55,'save_as_default','N',''),(1441,55,'clear_default','N',''),(1442,50,'clear_default','N',''),(1443,30,'clear_default','N',''),(1467,70,'time_limit_warning_style','',''),(1468,70,'time_limit_warning_2','',''),(1469,70,'time_limit_warning_2_display_time','',''),(1470,70,'time_limit_warning_2_message','','de'),(1471,70,'time_limit_warning_2_style','',''),(1472,70,'statistics_showgraph','1',''),(1473,70,'statistics_graphtype','0',''),(1474,70,'save_as_default','N',''),(1475,70,'clear_default','N',''),(1476,70,'display_type','0',''),(1477,70,'printable_help','','de'),(1478,70,'scale_export','0',''),(1479,70,'public_statistics','0',''),(1480,71,'random_group','',''),(1481,71,'em_validation_q','',''),(1482,71,'em_validation_q_tip','','de'),(1483,71,'hide_tip','1',''),(1484,71,'text_input_width','',''),(1485,71,'input_size','',''),(1486,71,'display_rows','3',''),(1487,71,'hidden','0',''),(1488,71,'cssclass','',''),(1489,71,'maximum_chars','',''),(1490,71,'page_break','0',''),(1491,71,'time_limit','',''),(1492,71,'time_limit_action','1',''),(1493,71,'time_limit_disable_next','0',''),(1494,71,'time_limit_disable_prev','0',''),(1495,71,'time_limit_countdown_message','','de'),(1496,71,'time_limit_timer_style','',''),(1497,71,'time_limit_message_delay','',''),(1498,71,'time_limit_message','','de'),(1499,71,'time_limit_message_style','',''),(1500,71,'time_limit_warning','',''),(1501,71,'time_limit_warning_display_time','',''),(1502,71,'time_limit_warning_message','','de'),(1503,71,'time_limit_warning_style','',''),(1504,71,'time_limit_warning_2','',''),(1505,71,'time_limit_warning_2_display_time','',''),(1506,71,'time_limit_warning_2_message','','de'),(1507,71,'time_limit_warning_2_style','',''),(1508,71,'statistics_showgraph','1',''),(1509,71,'statistics_graphtype','0',''),(1510,71,'save_as_default','N',''),(1511,71,'clear_default','N',''),(1512,72,'other_comment_mandatory','0',''),(1513,72,'other_numbers_only','0',''),(1514,72,'array_filter_exclude','',''),(1515,72,'array_filter_style','0',''),(1516,72,'array_filter','',''),(1517,72,'random_group','',''),(1518,72,'em_validation_q','',''),(1519,72,'em_validation_q_tip','','de'),(1520,72,'keep_aspect','0',''),(1521,72,'horizontal_scroll','0',''),(1522,72,'crop_or_resize','0',''),(1523,72,'fix_width','',''),(1524,72,'fix_height','200',''),(1525,72,'other_replace_text','Ja, ich möchte am Gewinnspiel teilnehmen (bitte geben Sie Ihre E-Mail-Adresse an)','de'),(1526,72,'display_columns','',''),(1527,72,'hide_tip','1',''),(1528,72,'random_order','0',''),(1529,72,'alphasort','0',''),(1530,72,'hidden','0',''),(1531,72,'cssclass','',''),(1532,72,'printable_help','','de'),(1533,72,'page_break','0',''),(1534,72,'scale_export','0',''),(1535,72,'time_limit','',''),(1536,72,'time_limit_action','1',''),(1537,72,'time_limit_disable_next','0',''),(1538,72,'time_limit_disable_prev','0',''),(1539,72,'time_limit_countdown_message','','de'),(1540,72,'time_limit_timer_style','',''),(1541,72,'time_limit_message_delay','',''),(1542,72,'time_limit_message','','de'),(1543,72,'time_limit_message_style','',''),(1544,72,'time_limit_warning','',''),(1545,72,'time_limit_warning_display_time','',''),(1546,72,'time_limit_warning_message','','de'),(1547,72,'time_limit_warning_style','',''),(1548,72,'time_limit_warning_2','',''),(1549,72,'time_limit_warning_2_display_time','',''),(1550,72,'time_limit_warning_2_message','','de'),(1551,72,'time_limit_warning_2_style','',''),(1552,72,'public_statistics','0',''),(1553,72,'statistics_showgraph','1',''),(1554,72,'statistics_graphtype','0',''),(1555,72,'save_as_default','Y',''),(1556,72,'clear_default','N',''),(1557,73,'random_group','',''),(1558,73,'em_validation_q','',''),(1559,73,'em_validation_q_tip','','de'),(1560,73,'prefix','','de'),(1561,73,'suffix','','de'),(1562,73,'hide_tip','1',''),(1563,73,'text_input_width','',''),(1564,73,'input_size','',''),(1565,73,'display_rows','',''),(1566,73,'hidden','0',''),(1567,73,'cssclass','',''),(1568,73,'maximum_chars','',''),(1569,73,'page_break','0',''),(1570,73,'numbers_only','0',''),(1571,73,'time_limit','',''),(1572,73,'time_limit_action','1',''),(1573,73,'time_limit_disable_next','0',''),(1574,73,'time_limit_disable_prev','0',''),(1575,73,'time_limit_countdown_message','','de'),(1576,73,'time_limit_timer_style','',''),(1577,73,'time_limit_message_delay','',''),(1578,73,'time_limit_message','','de'),(1579,73,'time_limit_message_style','',''),(1580,73,'time_limit_warning','',''),(1581,73,'time_limit_warning_display_time','',''),(1582,73,'time_limit_warning_message','','de'),(1583,73,'time_limit_warning_style','',''),(1584,73,'time_limit_warning_2','',''),(1585,73,'time_limit_warning_2_display_time','',''),(1586,73,'time_limit_warning_2_message','','de'),(1587,73,'time_limit_warning_2_style','',''),(1588,73,'statistics_showmap','1',''),(1589,73,'statistics_showgraph','1',''),(1590,73,'statistics_graphtype','0',''),(1591,73,'location_mapservice','0',''),(1592,73,'location_nodefaultfromip','0',''),(1593,73,'location_postal','0',''),(1594,73,'location_city','0',''),(1595,73,'location_state','0',''),(1596,73,'location_country','0',''),(1597,73,'location_mapzoom','11',''),(1598,73,'location_defaultcoordinates','',''),(1599,73,'location_mapwidth','500',''),(1600,73,'location_mapheight','300',''),(1601,73,'save_as_default','Y',''),(1602,73,'clear_default','N',''),(1603,74,'random_group','',''),(1604,74,'hide_tip','0',''),(1605,74,'hidden','0',''),(1606,74,'cssclass','',''),(1607,74,'page_break','0',''),(1608,74,'time_limit','',''),(1609,74,'time_limit_action','1',''),(1610,74,'time_limit_disable_next','0',''),(1611,74,'time_limit_disable_prev','0',''),(1612,74,'time_limit_countdown_message','','de'),(1613,74,'time_limit_timer_style','',''),(1614,74,'time_limit_message_delay','',''),(1615,74,'time_limit_message','','de'),(1616,74,'time_limit_message_style','',''),(1617,74,'time_limit_warning','',''),(1618,74,'time_limit_warning_display_time','',''),(1619,74,'time_limit_warning_message','','de'),(1620,74,'time_limit_warning_style','',''),(1621,74,'time_limit_warning_2','',''),(1622,74,'time_limit_warning_2_display_time','',''),(1623,74,'time_limit_warning_2_message','','de'),(1624,74,'time_limit_warning_2_style','',''),(1625,74,'statistics_showgraph','1',''),(1626,74,'statistics_graphtype','0',''),(1627,74,'save_as_default','N',''),(1628,74,'clear_default','N',''),(1629,5,'other_comment_mandatory','0',''),(1630,5,'other_numbers_only','0',''),(1631,5,'array_filter_exclude','',''),(1632,5,'array_filter_style','0',''),(1633,5,'array_filter','',''),(1634,5,'keep_aspect','0',''),(1635,5,'horizontal_scroll','0',''),(1636,5,'crop_or_resize','0',''),(1637,5,'fix_width','',''),(1638,5,'fix_height','200',''),(1639,5,'other_replace_text','Alter in Jahren','de'),(1640,5,'display_columns','',''),(1641,5,'random_order','0',''),(1642,5,'alphasort','0',''),(1643,5,'scale_export','0',''),(1644,5,'time_limit','',''),(1645,5,'time_limit_action','1',''),(1646,5,'time_limit_disable_next','0',''),(1647,5,'time_limit_disable_prev','0',''),(1648,5,'time_limit_countdown_message','','de'),(1649,5,'time_limit_timer_style','',''),(1650,5,'time_limit_message_delay','',''),(1651,5,'time_limit_message','','de'),(1652,5,'time_limit_message_style','',''),(1653,5,'time_limit_warning','',''),(1654,5,'time_limit_warning_display_time','',''),(1655,5,'time_limit_warning_message','','de'),(1656,5,'time_limit_warning_style','',''),(1657,5,'time_limit_warning_2','',''),(1658,5,'time_limit_warning_2_display_time','',''),(1659,5,'time_limit_warning_2_message','','de'),(1660,5,'time_limit_warning_2_style','',''),(1661,75,'random_group','',''),(1662,75,'display_type','0',''),(1663,75,'hide_tip','1',''),(1664,75,'hidden','0',''),(1665,75,'cssclass','',''),(1666,75,'printable_help','','de'),(1667,75,'page_break','0',''),(1668,75,'scale_export','0',''),(1669,75,'public_statistics','0',''),(1670,75,'statistics_showgraph','1',''),(1671,75,'statistics_graphtype','0',''),(1672,75,'save_as_default','Y','');
/*!40000 ALTER TABLE `limo_question_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_question_l10ns`
--

DROP TABLE IF EXISTS `limo_question_l10ns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_question_l10ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL,
  `question` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `help` mediumtext COLLATE utf8mb4_unicode_ci,
  `script` text COLLATE utf8mb4_unicode_ci,
  `language` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_idx1_question_ls` (`qid`,`language`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_question_l10ns`
--

LOCK TABLES `limo_question_l10ns` WRITE;
/*!40000 ALTER TABLE `limo_question_l10ns` DISABLE KEYS */;
INSERT INTO `limo_question_l10ns` VALUES (6,5,'<p>Geben Sie Ihr Alter in Jahren an</p>\r\n','','','de'),(7,6,'Geben Sie Ihren Beruf an','','','de'),(5,4,'<script>\r\n$( document ).ready(function() {\r\n    $(\"#ls-button-submit\").hide();\r\n});\r\n</script>\r\n<p>Schade, dass Sie nicht bei meiner Umfrage mitmachen wollen. Ich wäre wirklich auf Ihre Hilfe angewiesen.</p>\r\n\r\n<p>Sie können sich hier noch einmal entscheiden, ob Sie nun die Umfrage erneut starten wollen oder ob Sie das Fenster einfach schließen.</p>\r\n\r\n<p>Vielen herzlichen Dank und alles Gute.</p>\r\n<script src=\"http://localhost:8888/foodemapp/cake/js/eval-helper.js\">\r\n\r\n</script>','','','de'),(8,7,'Angaben zu Ihrer Ausbildung','','','de'),(76,75,'Geben Sie Ihr Geschlecht an','','','de'),(9,8,'Wie fühlen Sie sich gerade?','','','de'),(10,9,'<p>Wie oft pro Woche bereiten Sie eine Mahlzeit zu?</p>\r\n','','','de'),(11,10,'<p>Wie interessiert sind Sie am Thema Ernährung?</p>\r\n','','','de'),(12,11,'Haben Sie eine bestimmte Ernährungspräferenz?','','','de'),(13,12,'<p>Machen Sie eine bestimmte Diät?</p>\r\n','','','de'),(14,13,'<p>Haben Sie eine bestimmte Unverträglichkeit?</p>\r\n','','','de'),(15,14,'<p>Wie leicht fällt es Ihnen, sich so zu ernähren wie Sie es möchten?</p>\r\n','','','de'),(16,15,'<p>Nun beginnt der eigentliche Test. Im Anschluss bekommen Sie drei verschiedene Arten zu sehen, wie Restaurants miteinander verglichen werden können. Jede Art hat ihre Vor- und Nachteile. Um besser mit den Visualisierungen zurecht zu kommen, habe ich ein kleines Video zur Einführung vorbereitet, das Ihnen zeigen soll, wie diese Ansichten funktionieren. </p>\r\n\r\n<p>Klicken Sie bitte auf den Link für das Video, es öffnet sich dann ein neuer Tab und Sie können das Video dort groß ansehen. Wenn das Video beendet ist, kommen Sie bitte wieder zur Umfrage zurück. </p>\r\n\r\n<p>LINK Video</p>\r\n\r\n<p>Als nächstes bekommen Sie in zufälliger Reihenfolge eine bestimmte Ansicht, dazu gibt es eine Aufgabe. Es wird ein Szenario beschrieben und Sie sollen sich in dieses Szenario hineinversetzen und für diesen Fall mit der jeweiligen Ansicht das vermeintliche passenste Restaurant finden. </p>\r\n\r\n<p>Dazu verschaffen Sie sich einfach mit der Ansicht einen Überblick und wählen dann unten in dem Auswahl-Feld das jeweilige Restaurant aus. Dann werden noch einige Fragen zu Ihrer Entscheidung gestellt. </p>\r\n\r\n<p>Schließlich bekommen Sie noch eine zweite und dritte Aufgabe mit den anderen Ansichten. </p>\r\n','','','de'),(17,16,'<h2>Listen-Ansicht: Suchen Sie einen passenden Ort für ein Abendessen mit der Familie</h2>\r\n<script src=\"http://localhost:8888/foodemapp/cake/js/eval-helper.js\">\r\n\r\n</script>\r\n\r\n<p>Stellen Sie sich vor, Ihre Partnerin, Ihr Partner hat Geburtstag und zur Feier des Tages möchten Sie die ganze Familie zum Essen in ein Restaurant einladen, es ist Sommer, Sie wollen gerne draußen sitzen und Sie sind eine relativ große Gruppe. Die Eltern, Ihre beiden Kinder 8 und 11 Jahre alt und die Großeltern sind auch mit dabei. <br />Ihr Bruder mit seiner Frau kommt auch mit dazu, Sie sind also eine relativ große Gruppe von 8 Leuten.<br />Sie wollen ein lockeres, schönes Lokal, nicht zu fein, wo nicht geraucht wird und was nicht so teuer ist – Sie wollen gerne alle einladen.</p>\r\n\r\n<p>In diesem System nehmen wir jetzt mal folgende Einstellungen an: </p>\r\n\r\n<ul>\r\n	<li>Außenbereich, Wichtigkeitssterne 5</li>\r\n	<li>Gruppenfreundlich, Wichtigkeitssterne 5</li>\r\n	<li>Raucher: Nein , Wichtigkeitssterne 5</li>\r\n	<li>Geräuschpegel: Durchschnitt, Wichtigkeitssterne 5</li>\r\n	<li>Restaurants, Wichtigkeitssterne 4</li>\r\n	<li>Preisklasse: 2, Wichtigkeitssterne 4</li>\r\n	<li>Gut für: Abendessen, Wichtigkeitssterne 3</li>\r\n</ul>\r\n\r\n<p>Sie bekommen gleich eine Ergebnis-Ansicht zu sehen, bitte suchen Sie das passende Restaurant aus und überlegen sich, warum Sie sich so entschieden haben. Sie müssen Ihre Auswahl unten noch in einem gesonderten Feld festlegen!</p>\r\n\r\n<p>Bitte lassen Sie folgendes noch in Ihre Auswahl mit einfließen: </p>\r\n\r\n<ul>\r\n	<li>Oma hat aber große Probleme mit Treppen wegen ihrer Arthrose. </li>\r\n	<li>Da Ihre Kids mitkommen, wäre WLAN sicherlich ganz gut, damit die Kinder sich auch selbst beschäftigen können, Ihre Familienessen dauern gerne mal etwas länger.</li>\r\n</ul>\r\n\r\n<p>Viel Spass!</p>\r\n\r\n<h3>Listen-Ansicht</h3>\r\n\r\n<p><iframe align=\"middle\" frameborder=\"1\" height=\"558px\" id=\"fmAppFrame\" scrolling=\"yes\" src=\"http://192.168.178.77:8888/foodemapp/cake/ypois/preset-geo/list?BC_C-ID_81_BC-STATE_1=4&amp;BC_C-ID_77_BC-STATE_1=5&amp;BC_C-ID_50_BC-STATE_1=5&amp;NC_C-ID_3_NCATTR-ID_7=5&amp;NC_C-ID_7_NCATTR-ID_26=4&amp;OC_C-ID_1_OCATTR-ID_2=3&amp;OC_C-ID_3_OCATTR-ID_11=5\" tabindex=\"-1\" width=\"992px\"></iframe></p>\r\n\r\n<p> </p>\r\n','','','de'),(18,17,'Wie leicht ist Ihnen die Entscheidung mit der Listen-Ansicht gefallen?','','','de'),(19,18,'<p>Wie zufrieden sind Sie mit der Entscheidung in der Listen-Ansicht, im Hinblick auf die beschriebene Situation?</p>\r\n','','','de'),(20,19,'Wo surfen Sie meistens im Internet?','','','de'),(21,20,'Wie viel Zeit verbringen Sie pro Tag im Internet?','','','de'),(22,21,'Beschreiben Sie Ihr Internet-Level','','','de'),(23,22,'<p>Wie häufig nutzen Sie Ihr Smartphone mit Online-Diensten pro Tag?</p>\r\n','','','de'),(24,23,'<h2>Chord-Ansicht: Suchen Sie einen passenden Ort für sich und Ihren Kumpel, der Live-Musik liebt.</h2>\r\n\r\n<p>Stellen Sie sich vor, Sie möchten zusammen mit Ihrer besten Freundin, Ihrem besten Freund einen schönen Abend verbringen und gemeinsam ausgehen. Ihre Freundin, Ihr Freund liebt es in Bars oder Kneipen mit Live-Musik zu Abend zu essen. Da Sie im Anschluss noch ein bisschen feiern wollen, ist ein bisschen Night-Club-Flair auch nicht schlecht. Da Ihre beste Freundin, Ihr bester Freund aber seit einer Sportverletzung im Rollstuhl sitzt, ist es wichtig einen barrierefreien Ort zu wählen, der für Rollstuhlfahrerinnen bzw. Rollstuhlfahrer geeignet ist. Außerdem meidet Ihre Begleitung seit der Verletzung Sportbars. Das alles ist zu berücksichtigen und wir nehmen folgende Einstellungen an:</p>\r\n\r\n<ul>\r\n	<li>Rollstuhlfahrer, Wichtigkeitssterne 5 </li>\r\n	<li>KEINE Sportbar, Wichtigkeitssterne 5</li>\r\n	<li>Musik: Live, Wichtigkeitssterne 4</li>\r\n	<li>Nachtleben, Wichtigkeitssterne 3</li>\r\n</ul>\r\n\r\n<p>Sie bekommen gleich eine Ergebnis-Ansicht zu sehen, bitte suchen Sie das passende Restaurant aus und überlegen sich, warum Sie sich so entschieden haben. Sie müssen Ihre Auswahl unten noch in einem gesonderten Feld festlegen!</p>\r\n\r\n<p>Bitte lassen Sie folgendes noch in Ihre Auswahl mit einfließen: </p>\r\n\r\n<ul>\r\n	<li>Da Sie selbst vor 2 Monaten aufgehört haben zu rauchen, bevorzugen Sie Lokale, in denen nicht geraucht wird. </li>\r\n	<li>Auch wenn Sie gerne mal einen kleinen Cocktail schlürfen, achten Sie bei Ihrer Auswahl darauf, dass Lokale mit einer Cocktailbar meistens recht hohe Tresen mit Barhockern haben. Das ist für Ihre Begleitung im Rollstuhl eher nichts, versuchen Sie darauf Rücksicht zu nehmen.</li>\r\n	<li>Da Sie zusammen essen und dort noch den restlichen Abend verbringen wollen, schadet es nicht, wenn Sie sich nicht das teuerste Lokal aussuchen.</li>\r\n</ul>\r\n\r\n<p>Viel Spass!</p>\r\n\r\n<h3>Chord-Ansicht</h3>\r\n\r\n<p><iframe align=\"middle\" frameborder=\"1\" height=\"558px\" id=\"fmAppFrame\" scrolling=\"yes\" src=\"http://192.168.178.77:8888/foodemapp/cake/ypois/preset-geo/chord?BC_C-ID_103_BC-STATE_1=5&amp;NC_C-ID_6_NCATTR-ID_21=4&amp;BC_C-ID_75_BC-STATE_1=3&amp;BC_C-ID_89_BC-STATE_0=5\" tabindex=\"-1\" width=\"992px\"></iframe></p>\r\n\r\n<p> </p>\r\n','','','de'),(3,2,'<h2>Datenschutz</h2>\r\n\r\n<p>Es besteht das Recht auf Auskunft durch den Verantwortlichen an dieser Studie über die erhobenen personenbezogenen Daten sowie das Recht auf Berichtigung, Löschung, Einschränkung der Verarbeitung der Daten sowie ein Widerspruchsrecht gegen die Verarbeitung sowie des Rechts auf Datenübertragbarkeit. <br />Bevor der Fragebogen startet, stehen hier detaillierte Informationen zu Ihren Rechten im Zuge dieser Befragung und unten werden Sie nochmals um Ihre Zustimmung gebeten. Ihre Daten werden ausschließlich auf Grundlage der gesetzlichen Bestimmungen (§ 3 BDSG, Art. 13 DSGVO) erhoben und verarbeitet. Sie verfügen über folgende persönliche Rechte im Rahmen dieser Befragung:</p>\r\n\r\n<ul>\r\n	<li>Die Teilnahme an der Studie ist freiwillig. Sie können den Fragebogen jederzeit abbrechen.</li>\r\n	<li>Ihre Teilnahme ist anonym, Ihre Antworten können nicht auf Sie zurückgeführt werden. Das bedeutet ebenfalls, dass Ihr persönlicher Datensatz nach Abschluss der Befragung für mich nicht identifizierbar ist.</li>\r\n	<li>Falls Sie nach der Studie Auskunft über Ihre Daten haben wollen oder Ihre Teilnahme zurückziehen, bitte ich Sie, dies im abschließenden Kommentarfeld (gemeinsam mit einer Kontaktadresse) zu vermerken.</li>\r\n	<li>Ihre Daten werden ausschließlich für wissenschaftliche Zwecke verwendet.</li>\r\n	<li>Die Forschung folgt keinem kommerziellen Interesse. Ich behandle all Ihre Daten streng vertraulich.</li>\r\n</ul>\r\n\r\n<p>Wenn Sie Fragen zu dieser Erhebung haben, wenden Sie sich bitte gerne an mich, den Verantwortlichen dieser Untersuchung: Veit Stephan, <a href=\"mailto:v.stephan@oth-aw.de?subject=Anfrage%20aus%20der%20Diss-Evaluation\">v.stephan@oth-aw.de</a>, Wissenschaftlicher Mitarbeiter der Fakultät Elektrotechnik, Medien und Informatik an der Ostbayerischen Technischen Hochschule Amberg-Weiden (Postadresse: Ostbayerische Technische Hochschule (OTH) Amberg-Weiden, z.H. Veit Stephan, Kaiser-Wilhelm-Ring 23, 92224 Amberg). </p>\r\n\r\n<p>Für grundsätzliche juristische Fragen im Zusammenhang mit der DSGVO und Forschung wenden Sie sich bitte an die Datenschutzbeauftragte der Universität Regensburg oder den Datenschutzbeauftragten der Ostbayerische Technischen Hochschule (OTH) Amberg-Weiden.</p>\r\n\r\n<p>Behördliche Datenschutzbeauftragte der Universität Regensburg(kommissarisch):<br /><strong>Susanne Stingl</strong><br />Dienstgebäude „Altes Finanzamt“, Raum 135, 1. OG.<br />Landshuter Straße 4, 93047 Regensburg<br />Telefon 0941 943-5376, Fax 0941 943-5369<br />Internet <a href=\"https://www.ur.de\">www.ur.de</a> </p>\r\n\r\n<p>Behördlicher Datenschutzbeauftragter der OTH Amberg-Weiden:<br /><strong>Dipl. Ing. (FH) Martin Hofmann</strong><br />Hetzenrichter Weg 15, 92637 Weiden<br />Telefon 0961 382-1709, Fax 0961 382-2709<br />Internet <a href=\"https://www.oth-aw.de\">www.oth-aw.de</a>, E-Mail: <a href=\"mailto:datenschutzbeauftragter@oth-aw.de?subject=Anfrage%20von%20der%20Evaluation%20von%20Herrn%20Veit%20Stephan%20\">datenschutzbeauftragter@oth-aw.de</a></p>\r\n\r\n<p>Zudem besteht das Recht der Beschwerde bei der Datenschutzbehörde: </p>\r\n\r\n<p>Bayerischer Landesbeauftragter für Datenschutz<br />Prof. Dr. Thomas Petri<br />Postfach 22 12 19<br />80502 München <br />Telefon: 089 212672-0, Fax 089 212672-50<br />Internet <a href=\"https://www.datenschutz-bayern.de\">www.datenschutz-bayern.de</a>, E-Mail <a href=\"mailto:poststelle@datenschutz-bayern.de\">poststelle@datenschutz-bayern.de</a></p>\r\n\r\n<hr />\r\n<h2>Einverständniserklärung</h2>\r\n\r\n<p>Damit Sie an dieser Studie teilnehmen können, benötige ich Ihr Einverständnis.</p>\r\n','','','de'),(25,24,'Wie leicht ist Ihnen die Entscheidung mit der Chord-Ansicht gefallen?','','','de'),(26,25,'<p>Wie zufrieden sind Sie mit der Entscheidung in der Chord-Ansicht, im Hinblick auf die beschriebene Situation?</p>\r\n','','','de'),(27,26,'<h2>Map-Ansicht: Suchen Sie für sich und eine Freundin, einen Freund einen Ort für einen gemeinsamen Lunch, während Sie einen Businesstermin in der Stadt haben.</h2>\r\n\r\n<p>Sie sind heute geschäftlich in Karlsruhe unterwegs, dort wohnt auch eine sehr gute Freundin, ein sehr guter Freund von Ihnen. Sie wollen sich gerne zum Mittagessen treffen. Ihr Businesstermin ist am Nachmittag, das heißt Sie können schon am Vormittag anreisen. Weil Sie es gewohnt sind auch außerhalb des Büros zu arbeiten, brauchen Sie ein Restaurant, das kostenfreies WLAN hat, damit Sie vor dem Lunch dort noch etwas arbeiten können. Als Hundeliebhaberin bzw. Hundeliebhaber kommt Ihr Begleiter, Ihr Hund, natürlich mit. Es ist Sommer und das Wetter ist gut, deswegen sind Sie auch mit Ihrem nagelneuen Cabrio angereist. Sie wollen gerne draußen sitzen. Das alles ist zu berücksichtigen und wir nehmen folgende Einstellungen an:</p>\r\n\r\n<ul>\r\n	<li>Hunde erlaubt, Wichtigkeitssterne 5 </li>\r\n	<li>Nimmt Reservierungen an, Wichtigkeitssterne 5</li>\r\n	<li>Außenbereich, Wichtigkeitssterne 4</li>\r\n	<li>WLAN Kostenlos, Wichtigkeitssterne 3</li>\r\n</ul>\r\n\r\n<p>Sie bekommen gleich eine Ergebnis-Ansicht zu sehen, bitte suchen Sie das passende Restaurant aus und überlegen sich, warum Sie sich so entschieden haben. Sie müssen Ihre Auswahl unten noch in einem gesonderten Feld festlegen!</p>\r\n\r\n<p>Bitte lassen Sie folgendes noch in Ihre Auswahl mit einfließen: </p>\r\n\r\n<ul>\r\n	<li>Da Sie Ihren Gast einladen und es auf Firmenkosten abrechnen können, muss es nicht das günstigste Restaurant sein.</li>\r\n	<li>Ihr nagelneues Cabrio ist im Moment noch Ihr heiß begehrtes Edelstück, daher wäre es Ihnen sehr recht, wenn Sie es nicht irgendwo auf der Straße abstellen müssen, sondern vielleicht eine Garage vorhanden wäre.</li>\r\n</ul>\r\n\r\n<p>Viel Spass!</p>\r\n\r\n<h3>Map-Ansicht</h3>\r\n\r\n<p><iframe align=\"middle\" frameborder=\"1\" height=\"558px\" id=\"fmAppFrame\" scrolling=\"yes\" src=\"http://192.168.178.77:8888/foodemapp/cake/ypois/preset-geo/map?NC_C-ID_2_NCATTR-ID_4=5&amp;BC_C-ID_40_BC-STATE_1=5&amp;BC_C-ID_94_BC-STATE_1=4&amp;BC_C-ID_77_BC-STATE_1=3\" tabindex=\"-1\" width=\"992px\"></iframe></p>\r\n\r\n<p> </p>\r\n','','','de'),(28,27,'Wie leicht ist Ihnen die Entscheidung mit der Map-Ansicht gefallen?','','','de'),(29,28,'<p>Wie zufrieden sind Sie mit der Entscheidung in der Map-Ansicht, im Hinblick auf die beschriebene Situation?</p>\r\n','','','de'),(42,41,'<h2>Weitere quantitative Fragen</h2>\r\n','','','de'),(88,87,'Glauben Sie, es ist besser, wenn ein Algorithmus Ihnen die besten Ergebnisse einfach nur darstellt anstatt möglichst genau zu kommunizieren, warum die Auswahl so ausfällt?',NULL,NULL,'de'),(87,86,'Glauben Sie es ist eine gute Sache, Anwendungen mehr in die Richtung zu entwickeln, den Nutzerinnen und Nutzern die Informationen möglichst umfassend zu zeigen und somit mehr Verantwortung bei der Entscheidung bei den Nutzerinnen und Nutzern einzufordern?',NULL,NULL,'de'),(31,30,'<h2>Fragebogen zur System-Gebrauchstauglichkeit</h2>\r\n','','','de'),(69,68,'9.	Ich fühlte mich bei der Benutzung der alternativen Darstellungen der Food-Map-App sehr sicher.',NULL,NULL,'de'),(68,67,'8.	Ich fand die alternativen Darstellungen der Food-Map-App sehr umständlich zu benutzen.',NULL,NULL,'de'),(67,66,'7.	Ich glaube, dass den meisten Menschen die Bedienung der alternativen Darstellungen der Food-Map-App leicht fällt.',NULL,NULL,'de'),(66,65,'6.	Ich denke, die alternativen Darstellungen der Food-Map-App enthalten zu viele Ungereimtheiten.',NULL,NULL,'de'),(65,64,'5.	Ich fand, dass die verschiedenen Funktionen gut in die Anwendung eingebaut waren.',NULL,NULL,'de'),(64,63,'4.	Ich glaube, ich könnte Hilfe benötigen, um die alternativen Darstellungen der Food-Map-App besser nutzen zu können.',NULL,NULL,'de'),(63,62,'3.	Ich fand die alternativen Darstellungen der Food-Map-App einfach zu benutzen.',NULL,NULL,'de'),(62,61,'2.	Ich fand die alternativen Darstellungen der Food-Map-App unnötig komplex. ',NULL,NULL,'de'),(61,60,'1.	Ich denke, dass ich die alternativen Darstellungen der Food-Map-App gerne nochmals benutzen würde.',NULL,NULL,'de'),(85,84,'Glauben Sie, dass es hilfreich ist bei Vergleichsanwendungen auch die Kriterien mit zu kommunizieren, die nicht direkt bei der Filterung ausgewählt wurden?',NULL,NULL,'de'),(86,85,'Glauben Sie, Sie könnten sich mit einer solchen Anwendung wirklich einen besseren Eindruck von dem jeweiligen Ort verschaffen?',NULL,NULL,'de'),(51,50,'<strong>Woran glauben Sie liegt das? Begründen Sie bitte Ihre Antwort auf die vorherige Frage.</strong>','','','de'),(71,70,'<h2>Weitere qualitative Fragen</h2>\r\n\r\n<p>Jetzt möchte ich jetzt noch ein paar weitere Fragen stellen, bei denen Sie auch gerne Ihr Feedback geben können, wenn Sie das möchten.</p>\r\n\r\n<p><strong>Hat Ihnen die Chord-Diagramm- oder Karten-Ansicht besser gefallen als die einfache Listen-Ansicht?</strong></p>\r\n','','','de'),(53,52,'<strong>Was hat Ihnen an der Chord-Diagramm-Variante am besonders gut gefallen?</strong>','','','de'),(54,53,'<strong>Was hat Ihnen an der Listen-Ansicht besonders gut gefallen?</strong>','','','de'),(55,54,'<h2>Abschlussfragen</h2>\r\n\r\n<p><strong>Weitere Anregungen, Fragen oder Ideen? </strong></p>\r\n','','','de'),(56,55,'Wie fühlen Sie sich gerade?','','','de'),(70,69,'10.	Ich musste viel ausprobieren, bevor ich anfangen konnte, die alternativen Darstellungen der Food-Map-App richtig zu verwenden.',NULL,NULL,'de'),(72,71,'<strong>Was hat Ihnen an der Map-Ansicht am besonders gut gefallen?</strong>','','','de'),(73,72,'<h2>Danksagung</h2>\r\n\r\n<p>Vielen, vielen Dank, dass Sie an der Umfrage teilgenommen haben! Das hilft mir mit meiner Forschung immens. Ich hoffe, Sie haben auch etwas Spass gehabt oder etwas gelernt. Auf alle Fälle bin ich Ihnen sehr dankbar für Ihre Hilfe!</p>\r\n\r\n<p>Als kleines Dankeschön können Sie an einem Gewinnspiel mitmachen. Ich verlose jede Woche unter den Teilnehmerinnen und Teilnehmern einen Amazongutschein über 20 €. </p>\r\n\r\n<p>Wenn Sie am Gewinnspiel teilnehmen möchten, tragen Sie bitte hier Ihre E-Mail-Adresse ein und aktivieren die Auswahl „Ja ich möchte am Gewinnspiel teilnehmen“.</p>\r\n\r\n<p> </p>\r\n','','','de'),(74,73,'<p>Falls Sie noch Fragen zu Inhalt, Zweck oder Forschungsethik dieser Erhebung oder Sie Interesse an den Ergebnissen der Untersuchung haben, wenden Sie sich bitte an <a href=\"mailto:v.stephan@oth-aw.de?subject=Anfrage%20aus%20Evaluation%2C%20Danksagung\">v.stephan@oth-aw.de</a>. </p>\r\n\r\n<p>Falls Sie von Ihrem Lösch- oder Auskunftsrecht Gebrauch machen wollen, hinterlassen Sie bitte eine Kontaktadresse im Kommentarfeld.</p>\r\n','','','de'),(75,74,'<h2>Abschluss</h2>\r\n\r\n<p>Bitte klicken Sie unten auf <strong>Absenden</strong> – erst dann ist der Fragebogen abgeschlossen und Ihre Daten sind gespeichert.</p>\r\n','','','de');
/*!40000 ALTER TABLE `limo_question_l10ns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_question_themes`
--

DROP TABLE IF EXISTS `limo_question_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_question_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xml_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `author` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` text COLLATE utf8mb4_unicode_ci,
  `license` text COLLATE utf8mb4_unicode_ci,
  `version` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_version` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `last_update` datetime DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `theme_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_theme` tinyint(1) DEFAULT NULL,
  `extends` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `limo_idx1_question_themes` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_question_themes`
--

LOCK TABLES `limo_question_themes` WRITE;
/*!40000 ALTER TABLE `limo_question_themes` DISABLE KEYS */;
INSERT INTO `limo_question_themes` VALUES (1,'5pointchoice','Y','application/views/survey/questions/answer/5pointchoice','/assets/images/screenshots/5.png','5 point choice','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','5 point choice question type configuration','2019-09-23 15:05:59',1,'question_theme','5',1,'','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"choice-5-pt-radio\"}'),(2,'arrays/10point','Y','application/views/survey/questions/answer/arrays/10point','/assets/images/screenshots/B.png','Array (10 point choice)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (10 point choice) question type configuration','2019-09-23 15:05:59',1,'question_theme','B',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-10-pt\"}'),(3,'arrays/5point','Y','application/views/survey/questions/answer/arrays/5point','/assets/images/screenshots/A.png','Array (5 point choice)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (5 point choice) question type configuration','2019-09-23 15:05:59',1,'question_theme','A',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-5-pt\"}'),(4,'arrays/array','Y','application/views/survey/questions/answer/arrays/array','/assets/images/screenshots/F.png','Array','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array question type configuration','2019-09-23 15:05:59',1,'question_theme','F',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-flexible-row\"}'),(5,'arrays/column','Y','application/views/survey/questions/answer/arrays/column','/assets/images/screenshots/H.png','Array by column','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array by column question type configuration','2019-09-23 15:05:59',1,'question_theme','H',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-flexible-column\"}'),(6,'arrays/dualscale','Y','application/views/survey/questions/answer/arrays/dualscale','/assets/images/screenshots/1.png','Array dual scale','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array dual scale question type configuration','2019-09-23 15:05:59',1,'question_theme','1',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"2\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-flexible-dual-scale\"}'),(7,'arrays/increasesamedecrease','Y','application/views/survey/questions/answer/arrays/increasesamedecrease','/assets/images/screenshots/E.png','Array (Increase/Same/Decrease)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (Increase/Same/Decrease) question type configuration','2019-09-23 15:05:59',1,'question_theme','E',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-increase-same-decrease\"}'),(8,'arrays/multiflexi','Y','application/views/survey/questions/answer/arrays/multiflexi','/assets/images/screenshots/COLON.png','Array (Numbers)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (Numbers) question type configuration','2019-09-23 15:05:59',1,'question_theme',':',1,'','Arrays','{\"subquestions\":\"2\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-multi-flexi\"}'),(9,'arrays/texts','Y','application/views/survey/questions/answer/arrays/texts','/assets/images/screenshots/;.png','Array (Texts)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (Texts) question type configuration','2019-09-23 15:05:59',1,'question_theme',';',1,'','Arrays','{\"subquestions\":\"2\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"array-multi-flexi-text\"}'),(10,'arrays/yesnouncertain','Y','application/views/survey/questions/answer/arrays/yesnouncertain','/assets/images/screenshots/C.png','Array (Yes/No/Uncertain)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Array (Yes/No/Uncertain) question type configuration','2019-09-23 15:05:59',1,'question_theme','C',1,'','Arrays','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"array-yes-uncertain-no\"}'),(11,'boilerplate','Y','application/views/survey/questions/answer/boilerplate','/assets/images/screenshots/X.png','Text display','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Text display question type configuration','2019-09-23 15:05:59',1,'question_theme','X',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"boilerplate\"}'),(12,'date','Y','application/views/survey/questions/answer/date','/assets/images/screenshots/D.png','Date/Time','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Date/Time question type configuration','2019-09-23 15:05:59',1,'question_theme','D',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"date\"}'),(13,'equation','Y','application/views/survey/questions/answer/equation','/assets/images/screenshots/EQUATION.png','Equation','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Equation question type configuration','2019-09-23 15:05:59',1,'question_theme','*',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"equation\"}'),(14,'file_upload','Y','application/views/survey/questions/answer/file_upload','/assets/images/screenshots/PIPE.png','File upload','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','File upload question type configuration','2019-09-23 15:05:59',1,'question_theme','|',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"upload-files\"}'),(15,'gender','Y','application/views/survey/questions/answer/gender','/assets/images/screenshots/G.png','Gender','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Gender question type configuration','2019-09-23 15:05:59',1,'question_theme','G',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"gender\"}'),(16,'hugefreetext','Y','application/views/survey/questions/answer/hugefreetext','/assets/images/screenshots/U.png','Huge free text','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Huge free text question type configuration','2019-09-23 15:05:59',1,'question_theme','U',1,'','Text questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"text-huge\"}'),(17,'language','Y','application/views/survey/questions/answer/language','/assets/images/screenshots/I.png','Language switch','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Language switch question type configuration','2019-09-23 15:05:59',1,'question_theme','I',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"0\",\"assessable\":\"0\",\"class\":\"language\"}'),(18,'listradio','Y','application/views/survey/questions/answer/listradio','/assets/images/screenshots/L.png','List (Radio)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','List (radio) question type configuration','2019-09-23 15:05:59',1,'question_theme','L',1,'','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"list-radio\"}'),(19,'list_dropdown','Y','application/views/survey/questions/answer/list_dropdown','/assets/images/screenshots/!.png','List (Dropdown)','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','List (dropdown) question type configuration','2019-09-23 15:05:59',1,'question_theme','!',1,'','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"list-dropdown\"}'),(20,'list_with_comment','Y','application/views/survey/questions/answer/list_with_comment','/assets/images/screenshots/O.png','List with comment','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','List with comment question type configuration','2019-09-23 15:05:59',1,'question_theme','O',1,'','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"list-with-comment\"}'),(21,'longfreetext','Y','application/views/survey/questions/answer/longfreetext','/assets/images/screenshots/T.png','Long free text','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Long free text question type configuration','2019-09-23 15:05:59',1,'question_theme','T',1,'','Text questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"text-long\"}'),(22,'multiplechoice','Y','application/views/survey/questions/answer/multiplechoice','/assets/images/screenshots/M.png','Multiple choice','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Multiple choice question type configuration','2019-09-23 15:05:59',1,'question_theme','M',1,'','Multiple choice questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"multiple-opt\"}'),(23,'multiplechoice_with_comments','Y','application/views/survey/questions/answer/multiplechoice_with_comments','/assets/images/screenshots/P.png','Multiple choice with comments','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Multiple choice with comments question type configuration','2019-09-23 15:05:59',1,'question_theme','P',1,'','Multiple choice questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"multiple-opt-comments\"}'),(24,'multiplenumeric','Y','application/views/survey/questions/answer/multiplenumeric','/assets/images/screenshots/K.png','Multiple numerical input','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Multiple numerical input question type configuration','2019-09-23 15:05:59',1,'question_theme','K',1,'','Mask questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"numeric-multi\"}'),(25,'multipleshorttext','Y','application/views/survey/questions/answer/multipleshorttext','/assets/images/screenshots/Q.png','Multiple short text','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Multiple short text question type configuration','2019-09-23 15:05:59',1,'question_theme','Q',1,'','Text questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"multiple-short-txt\"}'),(26,'numerical','Y','application/views/survey/questions/answer/numerical','/assets/images/screenshots/N.png','Numerical input','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Numerical input question type configuration','2019-09-23 15:05:59',1,'question_theme','N',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"numeric\"}'),(27,'ranking','Y','application/views/survey/questions/answer/ranking','/assets/images/screenshots/R.png','Ranking','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Ranking question type configuration','2019-09-23 15:05:59',1,'question_theme','R',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"ranking\"}'),(28,'shortfreetext','Y','application/views/survey/questions/answer/shortfreetext','/assets/images/screenshots/S.png','Short free text','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Short free text question type configuration','2019-09-23 15:05:59',1,'question_theme','S',1,'','Text questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"text-short\"}'),(29,'yesno','Y','application/views/survey/questions/answer/yesno','/assets/images/screenshots/Y.png','Yes/No','2018-09-08 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Yes/No question type configuration','2019-09-23 15:05:59',1,'question_theme','Y',1,'','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"yes-no\"}'),(30,'bootstrap_buttons','Y','themes/question/bootstrap_buttons/survey/questions/answer/listradio','/themes/question/bootstrap_buttons/survey/questions/answer/listradio/assets/bootstrap_buttons_listradio.png','Bootstrap buttons','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','New implementation of the Bootstrap buttons question theme','2019-09-23 15:05:59',1,'question_theme','L',1,'L','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"list-radio\"}'),(31,'bootstrap_buttons_multi','Y','themes/question/bootstrap_buttons/survey/questions/answer/multiplechoice','/themes/question/bootstrap_buttons/survey/questions/answer/multiplechoice/assets/bootstrap_buttons_multiplechoice.png','Bootstrap buttons','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2018 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','New implementation of the Bootstrap buttons question theme','2019-09-23 15:05:59',1,'question_theme','M',1,'M','Multiple choice questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"multiple-opt\"}'),(32,'browserdetect','Y','themes/question/browserdetect/survey/questions/answer/shortfreetext','/assets/images/screenshots/S.png','Browser detection','2017-07-09 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2017 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Browser, Platform and Proxy detection','2019-09-23 15:05:59',1,'question_theme','S',1,'S','Text questions','{\"subquestions\":\"0\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"text-short\"}'),(33,'image_select-listradio','Y','themes/question/image_select/survey/questions/answer/listradio','/assets/images/screenshots/L.png','Image select list (Radio)','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2016 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','List Radio with images.','2019-09-23 15:05:59',1,'question_theme','L',1,'L','Single choice questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"list-radio\"}'),(34,'image_select-multiplechoice','Y','themes/question/image_select/survey/questions/answer/multiplechoice','/assets/images/screenshots/M.png','Image select multiple choice','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2016 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Multiplechoice with images.','2019-09-23 15:05:59',1,'question_theme','M',1,'M','Multiple choice questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"1\",\"class\":\"multiple-opt\"}'),(35,'inputondemand','Y','themes/question/inputondemand/survey/questions/answer/multipleshorttext','/assets/images/screenshots/Q.png','Input on demand','2019-10-04 00:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2019 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','Hide not needed input fields in multiple shorttext','2019-09-23 15:05:59',1,'question_theme','Q',1,'Q','Text questions','{\"subquestions\":\"1\",\"answerscales\":\"0\",\"hasdefaultvalues\":\"1\",\"assessable\":\"0\",\"class\":\"multiple-short-txt\"}'),(36,'ranking_advanced','Y','themes/question/ranking_advanced/survey/questions/answer/ranking','/assets/images/screenshots/R.png','Ranking advanced','1970-01-01 01:00:00','LimeSurvey GmbH','info@limesurvey.org','http://www.limesurvey.org','Copyright (C) 2005 - 2017 LimeSurvey Gmbh, Inc. All rights reserved.','GNU General Public License version 2 or later','1.0','1','New implementation of the ranking question','2019-09-23 15:05:59',1,'question_theme','R',1,'R','Mask questions','{\"subquestions\":\"0\",\"answerscales\":\"1\",\"hasdefaultvalues\":\"0\",\"assessable\":\"1\",\"class\":\"ranking\"}');
/*!40000 ALTER TABLE `limo_question_themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_questions`
--

DROP TABLE IF EXISTS `limo_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_questions` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `parent_qid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T',
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `preg` text COLLATE utf8mb4_unicode_ci,
  `other` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `mandatory` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encrypted` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `question_order` int(11) NOT NULL,
  `scale_id` int(11) NOT NULL DEFAULT '0',
  `same_default` int(11) NOT NULL DEFAULT '0',
  `relevance` text COLLATE utf8mb4_unicode_ci,
  `question_theme_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modulename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`qid`),
  KEY `limo_idx1_questions` (`sid`),
  KEY `limo_idx2_questions` (`gid`),
  KEY `limo_idx3_questions` (`type`),
  KEY `limo_idx4_questions` (`title`),
  KEY `limo_idx5_questions` (`parent_qid`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_questions`
--

LOCK TABLES `limo_questions` WRITE;
/*!40000 ALTER TABLE `limo_questions` DISABLE KEYS */;
INSERT INTO `limo_questions` VALUES (2,0,612158,1,'L','G01Q01',NULL,'N','Y','N',1,0,0,'1','listradio',''),(6,0,612158,3,'S','G01Q04','','N','S','N',4,0,0,'1','shortfreetext',''),(5,0,612158,3,'N','G03Q03','','Y','N','N',1,0,0,'1','numerical',''),(4,0,612158,2,'L','DROPOUT01',NULL,'N','Y','N',1,0,0,'((G01Q01.NAOK == \'AO02\'))','bootstrap_buttons',''),(7,0,612158,3,'L','G03Q05',NULL,'N','S','N',3,0,0,'1','listradio',''),(8,0,612158,3,'L','G03Q06',NULL,'N','N','N',5,0,0,'1','listradio',''),(9,0,612158,4,'L','G04Q07',NULL,'N','S','N',1,0,0,'1','listradio',''),(10,0,612158,4,'L','G04Q08',NULL,'N','S','N',2,0,0,'1','listradio',''),(11,0,612158,4,'L','G04Q09',NULL,'Y','S','N',3,0,0,'1','listradio',''),(12,0,612158,4,'L','G04Q10',NULL,'Y','S','N',4,0,0,'1','listradio',''),(13,0,612158,4,'L','G04Q11',NULL,'Y','S','N',5,0,0,'1','listradio',''),(14,0,612158,4,'L','G04Q12',NULL,'N','S','N',6,0,0,'1','listradio',''),(15,0,612158,18,'X','G05Q13',NULL,'N','N','N',1,0,0,'1','boilerplate',''),(16,0,612158,5,'!','G05Q14',NULL,'N','Y','N',1,0,0,'1','list_dropdown',''),(17,0,612158,5,'L','G05Q15',NULL,'N','Y','N',2,0,0,'1','listradio',''),(18,0,612158,5,'L','G05Q16',NULL,'N','Y','N',3,0,0,'1','listradio',''),(19,0,612158,6,'L','G04Q17',NULL,'N','S','N',1,0,0,'1','listradio',''),(20,0,612158,6,'L','G04Q18',NULL,'N','S','N',2,0,0,'1','listradio',''),(21,0,612158,6,'L','G04Q19',NULL,'N','S','N',3,0,0,'1','listradio',''),(22,0,612158,6,'L','G04Q18Copy',NULL,'N','S','N',4,0,0,'1','listradio',''),(23,0,612158,16,'!','G05Q17',NULL,'N','Y','N',1,0,0,'1','list_dropdown',''),(24,0,612158,16,'L','G05Q18',NULL,'N','Y','N',2,0,0,'1','listradio',''),(25,0,612158,16,'L','G05Q19',NULL,'N','Y','N',3,0,0,'1','listradio',''),(26,0,612158,17,'!','G05Q20',NULL,'N','Y','N',1,0,0,'1','list_dropdown',''),(27,0,612158,17,'L','G05Q21',NULL,'N','Y','N',2,0,0,'1','listradio',''),(28,0,612158,17,'L','G05Q22',NULL,'N','Y','N',3,0,0,'1','listradio',''),(41,0,612158,10,'F','G07Q29',NULL,'N','Y','N',1,0,0,'1','arrays/array',''),(30,0,612158,7,'F','G07Q28',NULL,'N','Y','N',1,0,0,'1','arrays/array',''),(69,30,612158,7,'T','SQ010',NULL,'N',NULL,'N',9,0,0,'1',NULL,NULL),(68,30,612158,7,'T','SQ009',NULL,'N',NULL,'N',8,0,0,'1',NULL,NULL),(67,30,612158,7,'T','SQ008',NULL,'N',NULL,'N',7,0,0,'1',NULL,NULL),(66,30,612158,7,'T','SQ007',NULL,'N',NULL,'N',6,0,0,'1',NULL,NULL),(65,30,612158,7,'T','SQ006',NULL,'N',NULL,'N',5,0,0,'1',NULL,NULL),(64,30,612158,7,'T','SQ005',NULL,'N',NULL,'N',4,0,0,'1',NULL,NULL),(63,30,612158,7,'T','SQ004',NULL,'N',NULL,'N',3,0,0,'1',NULL,NULL),(62,30,612158,7,'T','SQ003',NULL,'N',NULL,'N',2,0,0,'1',NULL,NULL),(61,30,612158,7,'T','SQ002',NULL,'N',NULL,'N',1,0,0,'1',NULL,NULL),(60,30,612158,7,'T','SQ001',NULL,'N',NULL,'N',0,0,0,'1',NULL,NULL),(87,41,612158,10,'T','SQ004',NULL,'N',NULL,'N',3,0,0,'1',NULL,NULL),(86,41,612158,10,'T','SQ003',NULL,'N',NULL,'N',2,0,0,'1',NULL,NULL),(85,41,612158,10,'T','SQ002',NULL,'N',NULL,'N',1,0,0,'1',NULL,NULL),(50,0,612158,10,'T','G07Q30','','N','N','N',3,0,0,'1','longfreetext',''),(70,0,612158,10,'Y','G07Q35','','N','N','N',2,0,0,'1','yesno',''),(52,0,612158,10,'T','G07Q32','','N','N','N',4,0,0,'1','longfreetext',''),(53,0,612158,10,'T','G07Q33','','N','N','N',6,0,0,'1','longfreetext',''),(54,0,612158,8,'T','G08Q33','','N','N','N',1,0,0,'1','longfreetext',''),(55,0,612158,8,'L','G03Q36',NULL,'N','N','N',2,0,0,'1','listradio',''),(84,41,612158,10,'T','SQ001',NULL,'N',NULL,'N',0,0,0,'1',NULL,NULL),(71,0,612158,10,'T','G07Q37','','N','N','N',5,0,0,'1','longfreetext',''),(72,0,612158,9,'L','G10Q36',NULL,'Y','Y','Y',1,0,0,'1','listradio',''),(73,0,612158,9,'S','G10Q37','','N','N','N',2,0,0,'1','shortfreetext',''),(74,0,612158,9,'X','G10Q38',NULL,'N','N','N',3,0,0,'1','boilerplate',''),(75,0,612158,3,'G','G03Q39',NULL,'N','N','N',2,0,0,'1','gender','');
/*!40000 ALTER TABLE `limo_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_quota`
--

DROP TABLE IF EXISTS `limo_quota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qlimit` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `autoload_url` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `limo_idx1_quota` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_quota`
--

LOCK TABLES `limo_quota` WRITE;
/*!40000 ALTER TABLE `limo_quota` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_quota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_quota_languagesettings`
--

DROP TABLE IF EXISTS `limo_quota_languagesettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_quota_languagesettings` (
  `quotals_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotals_quota_id` int(11) NOT NULL DEFAULT '0',
  `quotals_language` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `quotals_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quotals_message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `quotals_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quotals_urldescrip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`quotals_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_quota_languagesettings`
--

LOCK TABLES `limo_quota_languagesettings` WRITE;
/*!40000 ALTER TABLE `limo_quota_languagesettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_quota_languagesettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_quota_members`
--

DROP TABLE IF EXISTS `limo_quota_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_quota_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `qid` int(11) DEFAULT NULL,
  `quota_id` int(11) DEFAULT NULL,
  `code` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_idx1_quota_members` (`sid`,`qid`,`quota_id`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_quota_members`
--

LOCK TABLES `limo_quota_members` WRITE;
/*!40000 ALTER TABLE `limo_quota_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_quota_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_saved_control`
--

DROP TABLE IF EXISTS `limo_saved_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_saved_control` (
  `scid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL DEFAULT '0',
  `srid` int(11) NOT NULL DEFAULT '0',
  `identifier` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saved_thisstep` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `saved_date` datetime NOT NULL,
  `refurl` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`scid`),
  KEY `limo_idx1_saved_control` (`sid`),
  KEY `limo_idx2_saved_control` (`srid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_saved_control`
--

LOCK TABLES `limo_saved_control` WRITE;
/*!40000 ALTER TABLE `limo_saved_control` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_saved_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_sessions`
--

DROP TABLE IF EXISTS `limo_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_sessions` (
  `id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`),
  KEY `sess_expire` (`expire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_sessions`
--

LOCK TABLES `limo_sessions` WRITE;
/*!40000 ALTER TABLE `limo_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_settings_global`
--

DROP TABLE IF EXISTS `limo_settings_global`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_settings_global` (
  `stg_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `stg_value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`stg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_settings_global`
--

LOCK TABLES `limo_settings_global` WRITE;
/*!40000 ALTER TABLE `limo_settings_global` DISABLE KEYS */;
INSERT INTO `limo_settings_global` VALUES ('sendadmincreationemail','1'),('admincreationemailsubject','Benutzerregistrierung bei \'{SITENAME}\''),('admincreationemailtemplate','<p>Hallo {FULLNAME},</p>\r\n\r\n<p>Dies ist eine automatische E-Mail-Benachrichtigung, dass auf der Website <strong>\'{SITENAME}\'</strong> ein Benutzer für Sie erstellt wurde.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Sie können jetzt die folgenden Anmeldeinformationen verwenden, um sich anzumelden</p>\r\n\r\n<p><strong>Benutzername</strong>: {USERNAME}</p>\r\n\r\n<p><a href=\"{LOGINURL}\">Klicken Sie hier, um Ihr Passwort festzulegen</a></p>\r\n\r\n<p>Falls Sie Fragen bezüglich dieser E-Mail haben, kontaktieren Sie bitte den Administrator über {SITEADMINEMAIL}.</p>\r\n\r\n<p> </p>\r\n\r\n<p>Dankeschön!</p>\r\n'),('DBVersion','479'),('SessionName','CSANWVUIZSECLRMEBJSVBGASOLTQQYKZUIYFKHIEQKJJKEFBOKBVRLRUOQBJMAOA'),('sitename','Evaluation Doktorarbeit Veit Stephan'),('siteadminname','Veit'),('siteadminemail','v.stephan@oth-aw.de'),('siteadminbounce','v.stephan@oth-aw.de'),('defaultlang','de'),('AssetsVersion','30255'),('last_survey_1','612158'),('restrictToLanguages',''),('defaulthtmleditormode','inline'),('defaultquestionselectormode','default'),('defaultthemeteeditormode','default'),('javascriptdebugbcknd','0'),('javascriptdebugfrntnd','0'),('maintenancemode','off'),('allow_unstable_extension_update','0'),('createsample','1'),('defaulttheme','fruity'),('x_frame_options','sameorigin'),('force_ssl','off'),('loginIpWhitelist',''),('tokenIpWhitelist',''),('admintheme','Purple_Tentacle'),('emailmethod','mail'),('emailsmtphost',''),('emailsmtppassword',''),('bounceaccounthost',''),('bounceaccounttype','off'),('bounceencryption','off'),('bounceaccountuser',''),('bounceaccountpass',''),('emailsmtpssl',''),('emailsmtpdebug','0'),('emailsmtpuser',''),('filterxsshtml','1'),('disablescriptwithxss','1'),('repeatheadings','25'),('maxemails','50'),('sendingrate','60'),('iSessionExpirationTime','7200'),('ipInfoDbAPIKey',''),('pdffontsize','9'),('pdfshowsurveytitle','Y'),('pdfshowheader','N'),('pdflogowidth','50'),('pdfheadertitle',''),('pdfheaderstring',''),('bPdfQuestionFill','1'),('bPdfQuestionBold','0'),('bPdfQuestionBorder','1'),('bPdfResponseBorder','1'),('googleMapsAPIKey',''),('googleanalyticsapikey',''),('googletranslateapikey',''),('surveyPreview_require_Auth','1'),('RPCInterface','off'),('rpc_publish_api',''),('add_access_control_header','1'),('characterset','auto'),('sideMenuBehaviour','adaptive'),('overwritefiles','N'),('timeadjust','+0 minutes'),('usercontrolSameGroupPolicy','1'),('customassetversionnumber','2');
/*!40000 ALTER TABLE `limo_settings_global` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_settings_user`
--

DROP TABLE IF EXISTS `limo_settings_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_settings_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `entity` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` varchar(31) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stg_name` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stg_value` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `limo_idx1_settings_user` (`uid`),
  KEY `limo_idx2_settings_user` (`entity`),
  KEY `limo_idx3_settings_user` (`entity_id`),
  KEY `limo_idx4_settings_user` (`stg_name`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_settings_user`
--

LOCK TABLES `limo_settings_user` WRITE;
/*!40000 ALTER TABLE `limo_settings_user` DISABLE KEYS */;
INSERT INTO `limo_settings_user` VALUES (1,1,NULL,NULL,'question_default_values_L','{ \"logic\":{ \"other_comment_mandatory\":\"0\",\"other_numbers_only\":\"0\",\"array_filter_exclude\":\"\",\"array_filter_style\":\"0\",\"array_filter\":\"\",\"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" } },\"display\":{ \"keep_aspect\":\"0\",\"horizontal_scroll\":\"0\",\"crop_or_resize\":\"0\",\"fix_width\":\"\",\"fix_height\":\"200\",\"other_replace_text\":{ \"de\":\"Ja ich m\\u00f6chte am Gewinnspiel teilnehmen (bitte geben Sie Ihre E-Mail Adressen an)\" },\"display_columns\":\"\",\"hide_tip\":\"1\",\"random_order\":\"0\",\"alphasort\":\"0\",\"hidden\":\"0\",\"cssclass\":\"\",\"printable_help\":{ \"de\":\"\" } },\"other\":{ \"page_break\":\"0\",\"scale_export\":\"0\" },\"timer\":{ \"time_limit\":\"\",\"time_limit_action\":\"1\",\"time_limit_disable_next\":\"0\",\"time_limit_disable_prev\":\"0\",\"time_limit_countdown_message\":{ \"de\":\"\" },\"time_limit_timer_style\":\"\",\"time_limit_message_delay\":\"\",\"time_limit_message\":{ \"de\":\"\" },\"time_limit_message_style\":\"\",\"time_limit_warning\":\"\",\"time_limit_warning_display_time\":\"\",\"time_limit_warning_message\":{ \"de\":\"\" },\"time_limit_warning_style\":\"\",\"time_limit_warning_2\":\"\",\"time_limit_warning_2_display_time\":\"\",\"time_limit_warning_2_message\":{ \"de\":\"\" },\"time_limit_warning_2_style\":\"\" },\"statistics\":{ \"public_statistics\":\"0\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(2,1,NULL,NULL,'quickaction_state','1'),(5,1,NULL,NULL,'question_default_values_X','{ \"logic\":{ \"random_group\":\"\" },\"display\":{ \"hide_tip\":\"0\",\"hidden\":\"0\",\"cssclass\":\"\" },\"other\":{ \"page_break\":\"0\" },\"timer\":{ \"time_limit\":\"\",\"time_limit_action\":\"1\",\"time_limit_disable_next\":\"0\",\"time_limit_disable_prev\":\"0\",\"time_limit_countdown_message\":{ \"de\":\"\" },\"time_limit_timer_style\":\"\",\"time_limit_message_delay\":\"\",\"time_limit_message\":{ \"de\":\"\" },\"time_limit_message_style\":\"\",\"time_limit_warning\":\"\",\"time_limit_warning_display_time\":\"\",\"time_limit_warning_message\":{ \"de\":\"\" },\"time_limit_warning_style\":\"\",\"time_limit_warning_2\":\"\",\"time_limit_warning_2_display_time\":\"\",\"time_limit_warning_2_message\":{ \"de\":\"\" },\"time_limit_warning_2_style\":\"\" },\"statistics\":{ \"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(3,1,NULL,NULL,'question_default_values_N','{ \"logic\":{ \"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" },\"em_validation_sq\":\"\",\"em_validation_sq_tip\":{ \"de\":\"\" } },\"display\":{ \"prefix\":{ \"de\":\"\" },\"suffix\":{ \"de\":\"\" },\"placeholder\":{ \"de\":\"\" },\"text_input_width\":\"\",\"input_size\":\"\",\"hide_tip\":\"0\",\"hidden\":\"0\",\"cssclass\":\"\",\"printable_help\":{ \"de\":\"\" } },\"input\":{ \"maximum_chars\":\"\",\"min_num_value_n\":\"\",\"num_value_int_only\":\"0\",\"max_num_value_n\":\"\" },\"other\":{ \"page_break\":\"0\" },\"statistics\":{ \"public_statistics\":\"0\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(4,1,NULL,NULL,'question_default_values_S','{ \"logic\":{ \"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" } },\"display\":{ \"prefix\":{ \"de\":\"\" },\"suffix\":{ \"de\":\"\" },\"hide_tip\":\"0\",\"text_input_width\":\"\",\"input_size\":\"\",\"display_rows\":\"\",\"hidden\":\"0\",\"cssclass\":\"\" },\"input\":{ \"maximum_chars\":\"\" },\"other\":{ \"page_break\":\"0\",\"numbers_only\":\"0\" },\"timer\":{ \"time_limit\":\"\",\"time_limit_action\":\"1\",\"time_limit_disable_next\":\"0\",\"time_limit_disable_prev\":\"0\",\"time_limit_countdown_message\":{ \"de\":\"\" },\"time_limit_timer_style\":\"\",\"time_limit_message_delay\":\"\",\"time_limit_message\":{ \"de\":\"\" },\"time_limit_message_style\":\"\",\"time_limit_warning\":\"\",\"time_limit_warning_display_time\":\"\",\"time_limit_warning_message\":{ \"de\":\"\" },\"time_limit_warning_style\":\"\",\"time_limit_warning_2\":\"\",\"time_limit_warning_2_display_time\":\"\",\"time_limit_warning_2_message\":{ \"de\":\"\" },\"time_limit_warning_2_style\":\"\" },\"statistics\":{ \"statistics_showmap\":\"1\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" },\"location\":{ \"location_mapservice\":\"0\",\"location_nodefaultfromip\":\"0\",\"location_postal\":\"0\",\"location_city\":\"0\",\"location_state\":\"0\",\"location_country\":\"0\",\"location_mapzoom\":\"11\",\"location_defaultcoordinates\":\"\",\"location_mapwidth\":\"500\",\"location_mapheight\":\"300\" } }'),(6,1,NULL,NULL,'question_default_values_!','{ \"logic\":{ \"other_comment_mandatory\":\"0\",\"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" } },\"display\":{ \"alphasort\":\"0\",\"category_separator\":\"\",\"hide_tip\":\"1\",\"random_order\":\"1\",\"other_replace_text\":{ \"de\":\"\" },\"hidden\":\"0\",\"cssclass\":\"\",\"dropdown_size\":\"\",\"printable_help\":{ \"de\":\"\" },\"dropdown_prefix\":\"0\" },\"other\":{ \"page_break\":\"0\",\"scale_export\":\"0\" },\"timer\":{ \"time_limit\":\"\",\"time_limit_action\":\"1\",\"time_limit_disable_next\":\"0\",\"time_limit_disable_prev\":\"0\",\"time_limit_countdown_message\":{ \"de\":\"\" },\"time_limit_timer_style\":\"\",\"time_limit_message_delay\":\"\",\"time_limit_message\":{ \"de\":\"\" },\"time_limit_message_style\":\"\",\"time_limit_warning\":\"\",\"time_limit_warning_display_time\":\"\",\"time_limit_warning_message\":{ \"de\":\"\" },\"time_limit_warning_style\":\"\",\"time_limit_warning_2\":\"\",\"time_limit_warning_2_display_time\":\"\",\"time_limit_warning_2_message\":{ \"de\":\"\" },\"time_limit_warning_2_style\":\"\" },\"statistics\":{ \"public_statistics\":\"0\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(7,1,NULL,NULL,'question_default_values_F','{ \"logic\":{ \"min_answers\":\"\",\"max_answers\":\"\",\"array_filter_style\":\"0\",\"array_filter\":\"\",\"array_filter_exclude\":\"\",\"exclude_all_others\":\"\",\"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" } },\"display\":{ \"answer_width\":\"\",\"repeat_headings\":\"\",\"hide_tip\":\"1\",\"random_order\":\"0\",\"hidden\":\"0\",\"cssclass\":\"\",\"use_dropdown\":\"0\",\"printable_help\":{ \"de\":\"\" } },\"other\":{ \"page_break\":\"0\",\"scale_export\":\"0\" },\"statistics\":{ \"public_statistics\":\"0\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(8,1,NULL,NULL,'question_default_values_T','{ \"logic\":{ \"random_group\":\"\",\"em_validation_q\":\"\",\"em_validation_q_tip\":{ \"de\":\"\" } },\"display\":{ \"hide_tip\":\"1\",\"text_input_width\":\"\",\"input_size\":\"\",\"display_rows\":\"3\",\"hidden\":\"0\",\"cssclass\":\"\" },\"input\":{ \"maximum_chars\":\"\" },\"other\":{ \"page_break\":\"0\" },\"timer\":{ \"time_limit\":\"\",\"time_limit_action\":\"1\",\"time_limit_disable_next\":\"0\",\"time_limit_disable_prev\":\"0\",\"time_limit_countdown_message\":{ \"de\":\"\" },\"time_limit_timer_style\":\"\",\"time_limit_message_delay\":\"\",\"time_limit_message\":{ \"de\":\"\" },\"time_limit_message_style\":\"\",\"time_limit_warning\":\"\",\"time_limit_warning_display_time\":\"\",\"time_limit_warning_message\":{ \"de\":\"\" },\"time_limit_warning_style\":\"\",\"time_limit_warning_2\":\"\",\"time_limit_warning_2_display_time\":\"\",\"time_limit_warning_2_message\":{ \"de\":\"\" },\"time_limit_warning_2_style\":\"\" },\"statistics\":{ \"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }'),(9,1,NULL,NULL,'preselectquestiontype','T'),(10,1,NULL,NULL,'preselectquestiontheme','longfreetext'),(11,1,NULL,NULL,'showScriptEdit','0'),(12,1,NULL,NULL,'noViewMode','0'),(13,1,NULL,NULL,'answeroptionprefix','AO'),(14,1,NULL,NULL,'subquestionprefix','SQ'),(15,1,NULL,NULL,'lock_organizer','0'),(16,1,NULL,NULL,'createsample','default'),(17,1,NULL,NULL,'question_default_values_G','{ \"logic\":{ \"random_group\":\"\" },\"display\":{ \"display_type\":\"0\",\"hide_tip\":\"1\",\"hidden\":\"0\",\"cssclass\":\"\",\"printable_help\":{ \"de\":\"\" } },\"other\":{ \"page_break\":\"0\",\"scale_export\":\"0\" },\"statistics\":{ \"public_statistics\":\"0\",\"statistics_showgraph\":\"1\",\"statistics_graphtype\":\"0\" } }');
/*!40000 ALTER TABLE `limo_settings_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_survey_612158`
--

DROP TABLE IF EXISTS `limo_survey_612158`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_survey_612158` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `submitdate` datetime DEFAULT NULL,
  `lastpage` int(11) DEFAULT NULL,
  `startlanguage` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seed` varchar(31) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startdate` datetime NOT NULL,
  `datestamp` datetime NOT NULL,
  `612158X1X2` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X2X4` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X3X5` decimal(30,10) DEFAULT NULL,
  `612158X3X75` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X3X7` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X3X6` text COLLATE utf8mb4_unicode_ci,
  `612158X3X8` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X6X19` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X6X20` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X6X21` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X6X22` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X9` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X10` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X11` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X11other` text COLLATE utf8mb4_unicode_ci,
  `612158X4X12` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X12other` text COLLATE utf8mb4_unicode_ci,
  `612158X4X13` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X4X13other` text COLLATE utf8mb4_unicode_ci,
  `612158X4X14` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X18X15` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X5X16` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X5X17` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X5X18` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X16X23` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X16X24` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X16X25` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X17X26` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X17X27` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X17X28` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ001` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ002` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ003` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ004` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ005` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ006` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ007` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ008` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ009` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X7X30SQ010` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X41SQ001` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X41SQ002` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X41SQ003` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X41SQ004` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X70` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X10X50` text COLLATE utf8mb4_unicode_ci,
  `612158X10X52` text COLLATE utf8mb4_unicode_ci,
  `612158X10X71` text COLLATE utf8mb4_unicode_ci,
  `612158X10X53` text COLLATE utf8mb4_unicode_ci,
  `612158X8X54` text COLLATE utf8mb4_unicode_ci,
  `612158X8X55` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `612158X9X72` text COLLATE utf8mb4_unicode_ci,
  `612158X9X72other` text COLLATE utf8mb4_unicode_ci,
  `612158X9X73` text COLLATE utf8mb4_unicode_ci,
  `612158X9X74` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_survey_token_612158_37715` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_survey_612158`
--

LOCK TABLES `limo_survey_612158` WRITE;
/*!40000 ALTER TABLE `limo_survey_612158` DISABLE KEYS */;
INSERT INTO `limo_survey_612158` VALUES (13,NULL,NULL,2,'de','1468066618','2022-01-24 09:48:43','2022-01-24 09:52:12','AO02','AO02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(14,NULL,NULL,1,'de','2032425001','2022-01-24 10:09:48','2022-01-24 10:09:54','AO02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(15,NULL,NULL,1,'de','844524125','2022-01-24 10:12:50','2022-01-24 10:12:53','AO02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(16,NULL,NULL,1,'de','996209288','2022-01-24 10:24:13','2022-01-24 10:24:17','AO02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(17,NULL,NULL,8,'de','1267991641','2022-01-24 10:45:15','2022-01-24 10:48:11','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,'AO05','AO01','AO01','AO03','AO03','AO03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(18,NULL,NULL,6,'de','2069259460','2022-01-24 10:52:14','2022-01-24 10:53:29','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(19,NULL,NULL,6,'de','1654631001','2022-01-24 12:55:34','2022-01-24 12:56:05','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(20,NULL,NULL,7,'de','1611648759','2022-01-24 12:59:14','2022-01-24 13:00:09','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,'AO03','AO01','AO01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(21,NULL,NULL,6,'de','914112055','2022-01-24 15:33:44','2022-01-24 15:34:21','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL),(22,NULL,NULL,6,'de','161346656','2022-01-24 15:35:28','2022-01-24 15:36:02','AO01',NULL,NULL,'','','','','','','','','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL);
/*!40000 ALTER TABLE `limo_survey_612158` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_survey_612158_timings`
--

DROP TABLE IF EXISTS `limo_survey_612158_timings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_survey_612158_timings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interviewtime` float DEFAULT NULL,
  `612158X1time` float DEFAULT NULL,
  `612158X1X2time` float DEFAULT NULL,
  `612158X2time` float DEFAULT NULL,
  `612158X2X4time` float DEFAULT NULL,
  `612158X3time` float DEFAULT NULL,
  `612158X3X5time` float DEFAULT NULL,
  `612158X3X75time` float DEFAULT NULL,
  `612158X3X7time` float DEFAULT NULL,
  `612158X3X6time` float DEFAULT NULL,
  `612158X3X8time` float DEFAULT NULL,
  `612158X6time` float DEFAULT NULL,
  `612158X6X19time` float DEFAULT NULL,
  `612158X6X20time` float DEFAULT NULL,
  `612158X6X21time` float DEFAULT NULL,
  `612158X6X22time` float DEFAULT NULL,
  `612158X4time` float DEFAULT NULL,
  `612158X4X9time` float DEFAULT NULL,
  `612158X4X10time` float DEFAULT NULL,
  `612158X4X11time` float DEFAULT NULL,
  `612158X4X12time` float DEFAULT NULL,
  `612158X4X13time` float DEFAULT NULL,
  `612158X4X14time` float DEFAULT NULL,
  `612158X18time` float DEFAULT NULL,
  `612158X18X15time` float DEFAULT NULL,
  `612158X5time` float DEFAULT NULL,
  `612158X5X16time` float DEFAULT NULL,
  `612158X5X17time` float DEFAULT NULL,
  `612158X5X18time` float DEFAULT NULL,
  `612158X16time` float DEFAULT NULL,
  `612158X16X23time` float DEFAULT NULL,
  `612158X16X24time` float DEFAULT NULL,
  `612158X16X25time` float DEFAULT NULL,
  `612158X17time` float DEFAULT NULL,
  `612158X17X26time` float DEFAULT NULL,
  `612158X17X27time` float DEFAULT NULL,
  `612158X17X28time` float DEFAULT NULL,
  `612158X7time` float DEFAULT NULL,
  `612158X7X30time` float DEFAULT NULL,
  `612158X10time` float DEFAULT NULL,
  `612158X10X41time` float DEFAULT NULL,
  `612158X10X70time` float DEFAULT NULL,
  `612158X10X50time` float DEFAULT NULL,
  `612158X10X52time` float DEFAULT NULL,
  `612158X10X71time` float DEFAULT NULL,
  `612158X10X53time` float DEFAULT NULL,
  `612158X8time` float DEFAULT NULL,
  `612158X8X54time` float DEFAULT NULL,
  `612158X8X55time` float DEFAULT NULL,
  `612158X9time` float DEFAULT NULL,
  `612158X9X72time` float DEFAULT NULL,
  `612158X9X73time` float DEFAULT NULL,
  `612158X9X74time` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_survey_612158_timings`
--

LOCK TABLES `limo_survey_612158_timings` WRITE;
/*!40000 ALTER TABLE `limo_survey_612158_timings` DISABLE KEYS */;
INSERT INTO `limo_survey_612158_timings` VALUES (13,17.86,4.39,NULL,13.47,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,5.27,5.27,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,3.48,3.48,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,4.25,4.25,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,171.75,8.22,NULL,NULL,NULL,6.46,NULL,NULL,NULL,NULL,NULL,12.64,NULL,NULL,NULL,NULL,5.02,NULL,NULL,NULL,NULL,NULL,NULL,2.73,NULL,NULL,NULL,NULL,NULL,10.4,NULL,NULL,NULL,126.28,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,72.58,4.33,NULL,NULL,NULL,53.77,NULL,NULL,NULL,NULL,NULL,6.32,NULL,NULL,NULL,NULL,5.97,NULL,NULL,NULL,NULL,NULL,NULL,2.19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,27.23,6.38,NULL,NULL,NULL,6.25,NULL,NULL,NULL,NULL,NULL,6.65,NULL,NULL,NULL,NULL,5.72,NULL,NULL,NULL,NULL,NULL,NULL,2.23,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,52.59,3.63,NULL,NULL,NULL,8.93,NULL,NULL,NULL,NULL,NULL,7,NULL,NULL,NULL,NULL,6.14,NULL,NULL,NULL,NULL,NULL,NULL,2.7,NULL,NULL,NULL,NULL,NULL,24.19,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,34.94,10.81,NULL,NULL,NULL,10.46,NULL,NULL,NULL,NULL,NULL,6.24,NULL,NULL,NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,2.43,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,32.97,4.58,NULL,NULL,NULL,5.44,NULL,NULL,NULL,NULL,NULL,14.51,NULL,NULL,NULL,NULL,5.89,NULL,NULL,NULL,NULL,NULL,NULL,2.55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `limo_survey_612158_timings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_survey_links`
--

DROP TABLE IF EXISTS `limo_survey_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_survey_links` (
  `participant_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_invited` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  PRIMARY KEY (`participant_id`,`token_id`,`survey_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_survey_links`
--

LOCK TABLES `limo_survey_links` WRITE;
/*!40000 ALTER TABLE `limo_survey_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_survey_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_survey_url_parameters`
--

DROP TABLE IF EXISTS `limo_survey_url_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_survey_url_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `parameter` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `targetqid` int(11) DEFAULT NULL,
  `targetsqid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_survey_url_parameters`
--

LOCK TABLES `limo_survey_url_parameters` WRITE;
/*!40000 ALTER TABLE `limo_survey_url_parameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_survey_url_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveymenu`
--

DROP TABLE IF EXISTS `limo_surveymenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveymenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `level` int(11) DEFAULT '0',
  `title` varchar(168) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `position` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'side',
  `description` text COLLATE utf8mb4_unicode_ci,
  `showincollapse` int(11) DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `changed_at` datetime DEFAULT NULL,
  `changed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_surveymenu_name` (`name`),
  KEY `limo_idx2_surveymenu` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveymenu`
--

LOCK TABLES `limo_surveymenu` WRITE;
/*!40000 ALTER TABLE `limo_surveymenu` DISABLE KEYS */;
INSERT INTO `limo_surveymenu` VALUES (1,NULL,NULL,NULL,'settings',1,0,'Survey settings','side','Survey settings',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(2,NULL,NULL,NULL,'mainmenu',2,0,'Survey menu','side','Main survey menu',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(3,NULL,NULL,NULL,'quickmenu',3,0,'Quick menu','collapsed','Quick menu',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0);
/*!40000 ALTER TABLE `limo_surveymenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveymenu_entries`
--

DROP TABLE IF EXISTS `limo_surveymenu_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveymenu_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `name` varchar(168) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `title` varchar(168) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_title` varchar(168) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_description` text COLLATE utf8mb4_unicode_ci,
  `menu_icon` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_icon_type` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_class` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_link` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `action` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `template` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `partial` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `classes` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `permission` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `permission_grade` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `getdatamethod` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en-GB',
  `showincollapse` int(11) DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `changed_at` datetime DEFAULT NULL,
  `changed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `limo_surveymenu_entries_name` (`name`),
  KEY `limo_idx1_surveymenu_entries` (`menu_id`),
  KEY `limo_idx5_surveymenu_entries` (`menu_title`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveymenu_entries`
--

LOCK TABLES `limo_surveymenu_entries` WRITE;
/*!40000 ALTER TABLE `limo_surveymenu_entries` DISABLE KEYS */;
INSERT INTO `limo_surveymenu_entries` VALUES (1,1,NULL,1,'overview','Survey overview','Overview','Open the general survey overview','list','fontawesome','','surveyAdministration/view','','','','','','','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(2,1,NULL,2,'generalsettings','General survey settings','General settings','Open general survey settings','gears','fontawesome','','','updatesurveylocalesettings_generalsettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_generaloptions_panel','','surveysettings','read',NULL,'generalTabEditSurvey','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(3,1,NULL,3,'surveytexts','Survey text elements','Text elements','Survey text elements','file-text-o','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/tab_edit_view','','surveylocale','read',NULL,'getTextEditData','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(4,1,NULL,4,'datasecurity','Data policy settings','Data policy settings','Edit data policy settings','shield','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/tab_edit_view_datasecurity','','surveylocale','read',NULL,'getDataSecurityEditData','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(5,1,NULL,5,'theme_options','Theme options','Theme options','Edit theme options for this survey','paint-brush','fontawesome','','themeOptions/updateSurvey','','','','','surveysettings','update','{\"render\": {\"link\": { \"pjaxed\": true, \"data\": {\"surveyid\": [\"survey\",\"sid\"], \"gsid\":[\"survey\",\"gsid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(6,1,NULL,6,'presentation','Presentation & navigation settings','Presentation','Edit presentation and navigation settings','eye-slash','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_presentation_panel','','surveylocale','read',NULL,'tabPresentationNavigation','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(7,1,NULL,7,'tokens','Survey participant settings','Participant settings','Set additional options for survey participants','users','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_tokens_panel','','surveylocale','read',NULL,'tabTokens','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(8,1,NULL,8,'notification','Notification and data management settings','Notifications & data','Edit settings for notification and data management','feed','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_notification_panel','','surveylocale','read',NULL,'tabNotificationDataManagement','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(9,1,NULL,9,'publication','Publication & access control settings','Publication & access','Edit settings for publication and access control','key','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_publication_panel','','surveylocale','read',NULL,'tabPublicationAccess','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(10,1,NULL,10,'surveypermissions','Edit survey permissions','Survey permissions','Edit permissions for this survey','lock','fontawesome','','admin/surveypermission/sa/view/','','','','','surveysecurity','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(11,2,NULL,1,'listQuestions','Question list','Question list','List questions','list','fontawesome','','questionAdministration/listQuestions','','','','','surveycontent','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(12,2,NULL,2,'listQuestionGroups','Group list','Group list','List question groups','th-list','fontawesome','','questionGroupsAdministration/listquestiongroups','','','','','surveycontent','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(13,2,NULL,3,'reorder','Reorder questions & groups','Reorder questions & groups','Reorder questions & groups','icon-organize','iconclass','','surveyAdministration/organize/','','','','','surveycontent','update','{\"render\": {\"isActive\": false, \"link\": {\"data\": {\"surveyid\": [\"survey\", \"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(14,2,NULL,4,'participants','Survey participants','Survey participants','Go to survey participant and token settings','user','fontawesome','','admin/tokens/sa/index/','','','','','surveysettings','update','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(15,2,NULL,5,'emailtemplates','Email templates','Email templates','Edit the templates for invitation, reminder and registration emails','envelope-square','fontawesome','','admin/emailtemplates/sa/index/','','','','','surveylocale','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(16,2,NULL,6,'quotas','Edit quotas','Quotas','Edit quotas for this survey.','tasks','fontawesome','','admin/quotas/sa/index/','','','','','quotas','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(17,2,NULL,7,'assessments','Edit assessments','Assessments','Edit and look at the assessements for this survey.','comment-o','fontawesome','','assessment/index','','','','','assessments','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(18,2,NULL,8,'panelintegration','Edit survey panel integration','Panel integration','Define panel integrations for your survey','link','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_integration_panel','','surveylocale','read','{\"render\": {\"link\": { \"pjaxed\": false}}}','tabPanelIntegration','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(19,2,NULL,9,'responses','Responses','Responses','Responses','icon-browse','iconclass','','responses/browse/','','','','','responses','read','{\"render\": {\"isActive\": true, \"link\": {\"data\": {\"surveyId\": [\"survey\", \"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(20,2,NULL,10,'statistics','Statistics','Statistics','Statistics','bar-chart','fontawesome','','admin/statistics/sa/index/','','','','','statistics','read','{\"render\": {\"isActive\": true, \"link\": {\"data\": {\"surveyid\": [\"survey\", \"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(21,2,NULL,11,'resources','Add/edit resources (files/images) for this survey','Resources','Add/edit resources (files/images) for this survey','file','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_resources_panel','','surveylocale','read','{\"render\": { \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','tabResourceManagement','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(22,2,NULL,12,'plugins','Simple plugin settings','Simple plugins','Edit simple plugin settings','plug','fontawesome','','','updatesurveylocalesettings','editLocalSettings_main_view','/admin/survey/subview/accordion/_plugins_panel','','surveysettings','read','{\"render\": {\"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','pluginTabSurvey','en-GB',0,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(23,3,NULL,1,'activateSurvey','Activate survey','Activate survey','Activate survey','play','fontawesome','','surveyAdministration/activate','','','','','surveyactivation','update','{\"render\": {\"isActive\": false, \"link\": {\"data\": {\"iSurveyID\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(24,3,NULL,2,'deactivateSurvey','Stop this survey','Stop this survey','Stop this survey','stop','fontawesome','','surveyAdministration/deactivate','','','','','surveyactivation','update','{\"render\": {\"isActive\": true, \"link\": {\"data\": {\"surveyid\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(25,3,NULL,3,'testSurvey','Go to survey','Go to survey','Go to survey','cog','fontawesome','','survey/index/','','','','','','','{\"render\": {\"link\": {\"external\": true, \"data\": {\"sid\": [\"survey\",\"sid\"], \"newtest\": \"Y\", \"lang\": [\"survey\",\"language\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(26,3,NULL,4,'surveyLogicFile','Survey logic file','Survey logic file','Survey logic file','sitemap','fontawesome','','admin/expressions/sa/survey_logic_file/','','','','','surveycontent','read','{\"render\": { \"link\": {\"data\": {\"sid\": [\"survey\",\"sid\"]}}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0),(27,3,NULL,5,'cpdb','Central participant database','Central participant database','Central participant database','users','fontawesome','','admin/participants/sa/displayParticipants','','','','','tokens','read','{\"render\": {\"link\": {}}}','','en-GB',1,1,'2022-01-10 08:57:09',0,'2022-01-10 08:57:09',0);
/*!40000 ALTER TABLE `limo_surveymenu_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveys`
--

DROP TABLE IF EXISTS `limo_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveys` (
  `sid` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `gsid` int(11) DEFAULT '1',
  `admin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `expires` datetime DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `adminemail` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anonymized` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `faxto` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `savetimings` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `language` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_languages` text COLLATE utf8mb4_unicode_ci,
  `datestamp` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `usecookie` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowregister` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowsave` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `autonumber_start` int(11) NOT NULL DEFAULT '0',
  `autoredirect` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowprev` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `printanswers` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ipaddr` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ipanonymize` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `refurl` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `datecreated` datetime DEFAULT NULL,
  `showsurveypolicynotice` int(11) DEFAULT '0',
  `publicstatistics` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `publicgraphs` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `listpublic` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `htmlemail` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `sendconfirmation` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `tokenanswerspersistence` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `assessments` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `usecaptcha` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `usetokens` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `bounce_email` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributedescriptions` mediumtext COLLATE utf8mb4_unicode_ci,
  `emailresponseto` text COLLATE utf8mb4_unicode_ci,
  `emailnotificationto` text COLLATE utf8mb4_unicode_ci,
  `tokenlength` int(11) NOT NULL DEFAULT '15',
  `showxquestions` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showgroupinfo` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'B',
  `shownoanswer` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showqnumcode` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'X',
  `bouncetime` int(11) DEFAULT NULL,
  `bounceprocessing` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `bounceaccounttype` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bounceaccounthost` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bounceaccountpass` text COLLATE utf8mb4_unicode_ci,
  `bounceaccountencryption` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bounceaccountuser` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showwelcome` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showprogress` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `questionindex` int(11) NOT NULL DEFAULT '0',
  `navigationdelay` int(11) NOT NULL DEFAULT '0',
  `nokeyboard` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `alloweditaftercompletion` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `googleanalyticsstyle` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googleanalyticsapikey` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tokenencryptionoptions` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`sid`),
  KEY `limo_idx1_surveys` (`owner_id`),
  KEY `limo_idx2_surveys` (`gsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveys`
--

LOCK TABLES `limo_surveys` WRITE;
/*!40000 ALTER TABLE `limo_surveys` DISABLE KEYS */;
INSERT INTO `limo_surveys` VALUES (612158,1,1,'inherit','Y',NULL,NULL,'inherit','N','','I','Y','inherit','de','','Y','I','I','I',13,'I','I','I','N','Y','N','2022-01-10 09:01:42',0,'I','I','Y','I','I','I','I','J','N','inherit',NULL,'inherit','inherit',-1,'I','I','I','I',NULL,'N',NULL,NULL,NULL,NULL,NULL,'I','I',-1,-1,'I','I','','','{ \"enabled\":\"Y\",\"columns\":{ \"firstname\":\"N\",\"lastname\":\"N\",\"email\":\"N\" } }');
/*!40000 ALTER TABLE `limo_surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveys_groups`
--

DROP TABLE IF EXISTS `limo_surveys_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveys_groups` (
  `gsid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `description` text COLLATE utf8mb4_unicode_ci,
  `sortorder` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `alwaysavailable` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`gsid`),
  KEY `limo_idx1_surveys_groups` (`name`),
  KEY `limo_idx2_surveys_groups` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveys_groups`
--

LOCK TABLES `limo_surveys_groups` WRITE;
/*!40000 ALTER TABLE `limo_surveys_groups` DISABLE KEYS */;
INSERT INTO `limo_surveys_groups` VALUES (1,'default','Default',NULL,'Default survey group',0,1,NULL,NULL,'2022-01-10 08:57:10','2022-01-10 08:57:10',1);
/*!40000 ALTER TABLE `limo_surveys_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveys_groupsettings`
--

DROP TABLE IF EXISTS `limo_surveys_groupsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveys_groupsettings` (
  `gsid` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `admin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adminemail` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anonymized` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `format` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `savetimings` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `datestamp` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `usecookie` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowregister` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowsave` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `autonumber_start` int(11) DEFAULT '0',
  `autoredirect` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `allowprev` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `printanswers` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ipaddr` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `ipanonymize` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `refurl` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `showsurveypolicynotice` int(11) DEFAULT '0',
  `publicstatistics` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `publicgraphs` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `listpublic` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `htmlemail` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `sendconfirmation` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `tokenanswerspersistence` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `assessments` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `usecaptcha` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `bounce_email` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributedescriptions` text COLLATE utf8mb4_unicode_ci,
  `emailresponseto` text COLLATE utf8mb4_unicode_ci,
  `emailnotificationto` text COLLATE utf8mb4_unicode_ci,
  `tokenlength` int(11) DEFAULT '15',
  `showxquestions` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showgroupinfo` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'B',
  `shownoanswer` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showqnumcode` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'X',
  `showwelcome` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `showprogress` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `questionindex` int(11) DEFAULT '0',
  `navigationdelay` int(11) DEFAULT '0',
  `nokeyboard` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `alloweditaftercompletion` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  PRIMARY KEY (`gsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveys_groupsettings`
--

LOCK TABLES `limo_surveys_groupsettings` WRITE;
/*!40000 ALTER TABLE `limo_surveys_groupsettings` DISABLE KEYS */;
INSERT INTO `limo_surveys_groupsettings` VALUES (0,1,'Veit','v.stephan@evidentmedia.de','N','G','N','fruity','N','N','N','Y',0,'N','N','N','N','N','N',0,'N','N','N','Y','Y','N','N','N',NULL,NULL,NULL,NULL,15,'Y','B','Y','X','Y','Y',0,0,'N','N'),(1,-1,'inherit','inherit','I','I','I','inherit','I','I','I','I',0,'I','I','I','I','I','I',0,'I','I','I','I','I','I','I','E','inherit',NULL,'inherit','inherit',-1,'I','I','I','I','I','I',-1,-1,'I','I');
/*!40000 ALTER TABLE `limo_surveys_groupsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_surveys_languagesettings`
--

DROP TABLE IF EXISTS `limo_surveys_languagesettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_surveys_languagesettings` (
  `surveyls_survey_id` int(11) NOT NULL,
  `surveyls_language` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `surveyls_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surveyls_description` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_welcometext` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_endtext` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_policy_notice` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_policy_error` text COLLATE utf8mb4_unicode_ci,
  `surveyls_policy_notice_label` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_url` text COLLATE utf8mb4_unicode_ci,
  `surveyls_urldescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_email_invite_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_email_invite` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_email_remind_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_email_remind` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_email_register_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_email_register` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_email_confirm_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surveyls_email_confirm` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_dateformat` int(11) NOT NULL DEFAULT '1',
  `surveyls_attributecaptions` text COLLATE utf8mb4_unicode_ci,
  `email_admin_notification_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_admin_notification` mediumtext COLLATE utf8mb4_unicode_ci,
  `email_admin_responses_subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_admin_responses` mediumtext COLLATE utf8mb4_unicode_ci,
  `surveyls_numberformat` int(11) NOT NULL DEFAULT '0',
  `attachments` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`surveyls_survey_id`,`surveyls_language`),
  KEY `limo_idx1_surveys_languagesettings` (`surveyls_title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_surveys_languagesettings`
--

LOCK TABLES `limo_surveys_languagesettings` WRITE;
/*!40000 ALTER TABLE `limo_surveys_languagesettings` DISABLE KEYS */;
INSERT INTO `limo_surveys_languagesettings` VALUES (612158,'de','Neuartige Ansichten zum Vergleich verschiedener Eigenschaften','<h2>Einleitung</h2>\r\n\r\n<div style=\"text-align: left;\">\r\n<p><span style=\"color:#000000;\">Liebe Teilnehmerin, lieber Teilnehmer,</span></p>\r\n\r\n<p><span style=\"color:#000000;\">ich, Veit Stephan, freue mich über Ihr Interesse, an dieser wissenschaftlichen Studie zu meiner Doktorarbeit teilzunehmen! Dieser Fragebogen befasst sich mit der Frage der Visualisierung von komplexen Daten bei Food Environment Maps. Um die komplexen, mehrdimensionalen Daten der ernährungsbezogenen Points Of Interest (POI) schnell vermitteln zu können, muss evaluiert werden, wie sich die Indikatoren für die eigenen Prämissen auf der Karte am besten visualisieren lassen.</span></p>\r\n\r\n<p><span style=\"color:#000000;\">Es geht darum die eigenen Wünsche einer Vorstellung besser ausdrücken zu können und vor allem die dadurch entstandenen Ergebnisse bzw. Möglichkeiten besser reflektieren, vergleichen und bewerten zu können. Mit neuartigen Darstellungen soll geprüft werden, ob sich einzelne Ergebnisse schneller und besser in ihren vielen, vielen Ausprägungen darstellen lassen.</span></p>\r\n\r\n<p><span style=\"color:#000000;\">Diese Befragung wird im Rahmen meiner Doktorarbeit an der Universität Regensburg in Kooperation mit der Ostbayerischen Technischen Hochschule Amberg-Weiden erstellt. Die Daten können von mir, dem Doktoranden, bzw. den Gutachtern der wissenschaftlichen Arbeit zum Zwecke der Leistungsbeurteilung eingesehen werden. Die erhobenen Daten dürfen gemäß Art. 89 Abs. 1 DSGVO grundsätzlich unbeschränkt gespeichert werden.</span></p>\r\n</div>\r\n','<h2>Vielen Dank für Ihr Interesse!</h2>\r\n\r\n<p><span style=\"font-size:14px;\"><span style=\"color:#000000;\">Mit dem Button <strong>Weiter</strong> können Sie direkt loslegen. Wenn Sie Umfrage pausieren wollen, können Sie ab der ersten Frage rechts oben auf <strong>Später fortfahren</strong> klicken und sich dann Ihren aktuellen Stand speichern. Falls Sie dann später fortsetzen wollen, können Sie dann hier auf der Einstiegsseite Ihren Namen und das Passwort eingeben und dann an der gespeicherten Stelle fortfahren.  </span></span></p>\r\n\r\n<h3>Los gehts, starten Sie mit dem Klick auf <strong>Weiter</strong></h3>\r\n','<h2>Vielen Dank</h2>\r\n\r\n<p>Ihr Fragebogen ist abgeschlossen und Ihre Daten sind gespeichert.</p>\r\n\r\n<p>Ich danke Ihnen nochmals herzlich für Ihre Zeit und Mühe!</p>\r\n\r\n<p>Sie können dieses Fenster jetzt schließen. </p>\r\n\r\n<p>Falls Sie wollen, können Sie auch gerne noch weiter mit der ganzen Anwendung spielen. Im Moment liegen allerdings nur Daten für Karlsruhe vor:</p>\r\n\r\n<p><a href=\"https://forschung.veitstephan.digital/diss/fmapp/beta/ypois/set-scenario\" target=\"_self\">https://forschung.veitstephan.digital/diss/fmapp/beta/ypois/set-scenario</a></p>\r\n',NULL,NULL,NULL,'','','Einladung zu einer Umfrage','Hallo {FIRSTNAME},<br />\n<br />\nHiermit möchten wir dich zu einer Umfrage einladen.<br />\n<br />\nDer Titel der Umfrage ist <br />\n\"{SURVEYNAME}\"<br />\n<br />\n\"{SURVEYDESCRIPTION}\"<br />\n<br />\nUm an dieser Umfrage teilzunehmen, klicke bitte auf den unten stehenden Link.<br />\n<br />\nMit freundlichen Grüßen,<br />\n<br />\n{ADMINNAME} ({ADMINEMAIL})<br />\n<br />\n----------------------------------------------<br />\nKlicke hier um die Umfrage zu starten:<br />\n{SURVEYURL}<br />\n<br />\nWenn Sie an diese Umfrage nicht teilnehmen und keine weiteren Erinnerungen erhalten möchten, klicken Sie bitte auf den folgenden Link:<br />\n{OPTOUTURL}<br />\n<br />\nWenn Sie geblockt sind, jedoch wieder teilnehmen und weitere Einladungen erhalten möchten, klicken Sie bitte auf den folgenden Link:<br />\n{OPTINURL}','Erinnerung an die Teilnahme an einer Umfrage','Hallo {FIRSTNAME},<br />\n<br />\nVor kurzem haben wir dich zu einer Umfrage eingeladen.<br />\n<br />\nZu unserem Bedauern haben wir bemerkt, dass du die Umfrage noch nicht ausgefüllt hast. Wir möchten dir mitteilen, dass die Umfrage noch aktiv ist, und würden uns freuen, wenn du teilnehmen könntest.<br />\n<br />\nDer Titel der Umfrage ist <br />\n\'{SURVEYNAME}\'<br />\n<br />\n\'{SURVEYDESCRIPTION}\'<br />\n<br />\nUm an dieser Umfrage teilzunehmen, klicke bitte auf den unten stehenden Link.<br />\n<br />\n Mit freundlichen Grüßen,<br />\n<br />\n{ADMINNAME} ({ADMINEMAIL})<br />\n<br />\n----------------------------------------------<br />\nKlicke hier, um die Umfrage zu starten:<br />\n{SURVEYURL}<br />\n<br />\nWenn Sie an diese Umfrage nicht teilnehmen und keine weiteren Erinnerungen erhalten möchten, klicken Sie bitte auf den folgenden Link:<br />\n{OPTOUTURL}','Registrierungsbestätigung für Teilnahmeumfrage','Hallo {FIRSTNAME},<br />\n<br />\ndu (oder jemand, der deine E-Mail-Adresse angegeben hat) hast dich für eine Umfrage mit dem Titel {SURVEYNAME} angemeldet.<br />\n<br />\nUm an dieser Umfrage teilzunehmen, klicke bitte auf folgenden Link:<br />\n<br />\n{SURVEYURL}<br />\n<br />\nWenn du irgendwelche Fragen zu dieser Umfrage hast oder wenn du dich nicht für diese Umfrage angemeldet hast und glaubst, dass dir diese E-Mail irrtümlicherweise zugeschickt worden ist, kontaktiere bitte {ADMINNAME} unter {ADMINEMAIL}.','Bestätigung für die Teilnahme an unserer Umfrage','Hallo {FIRSTNAME},<br />\n<br />\nVielen Dank für die Teilnahme an der Umfrage mit dem Titel {SURVEYNAME}. Deine Antworten wurden bei uns gespeichert.<br />\n<br />\nWenn du irgendwelche Fragen zu dieser E-Mail hast, kontaktiere bitte {ADMINNAME} unter {ADMINEMAIL}.<br />\n<br />\nMit freundlichen Grüßen,<br />\n<br />\n{ADMINNAME}',1,NULL,'Antwortabsendung für Umfrage {SURVEYNAME}','Hallo,<br />\n<br />\nEine neue Antwort wurde für die Umfrage \'{SURVEYNAME}\' abgegeben.<br />\n<br />\nKlicke auf den folgenden Link um den Antwortdatensatz anzusehen:<br />\n{VIEWRESPONSEURL}<br />\n<br />\nKlicke auf den folgenden Link um den Antwortdatensatz zu bearbeiten:<br />\n{EDITRESPONSEURL}<br />\n<br />\nUm die Statistik zu sehen, klicke hier:<br />\n{STATISTICSURL}','Antwortabsendung für Umfrage {SURVEYNAME} mit Ergebnissen','Hallo,<br />\n<br />\nEine neue Antwort wurde für die Umfrage \'{SURVEYNAME}\' abgegeben.<br />\n<br />\nKlicken Sie auf den folgenden Link um den Antwortdatensatz anzusehen:<br />\n{VIEWRESPONSEURL}<br />\n<br />\nKlicken Sie auf den folgenden Link um den Antwortdatensatz zu bearbeiten:<br />\n{EDITRESPONSEURL}<br />\n<br />\nUm die Statistik zu sehen, klicken Sie hier:<br />\n{STATISTICSURL}<br />\n<br />\n<br />\nDie folgenden Antworten wurden vom Teilnehmer gegeben:<br />\n{ANSWERTABLE}',0,NULL);
/*!40000 ALTER TABLE `limo_surveys_languagesettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_template_configuration`
--

DROP TABLE IF EXISTS `limo_template_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_template_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sid` int(11) DEFAULT NULL,
  `gsid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `files_css` text COLLATE utf8mb4_unicode_ci,
  `files_js` text COLLATE utf8mb4_unicode_ci,
  `files_print_css` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  `cssframework_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cssframework_css` mediumtext COLLATE utf8mb4_unicode_ci,
  `cssframework_js` mediumtext COLLATE utf8mb4_unicode_ci,
  `packages_to_load` text COLLATE utf8mb4_unicode_ci,
  `packages_ltr` text COLLATE utf8mb4_unicode_ci,
  `packages_rtl` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `limo_idx1_template_configuration` (`template_name`),
  KEY `limo_idx2_template_configuration` (`sid`),
  KEY `limo_idx3_template_configuration` (`gsid`),
  KEY `limo_idx4_template_configuration` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_template_configuration`
--

LOCK TABLES `limo_template_configuration` WRITE;
/*!40000 ALTER TABLE `limo_template_configuration` DISABLE KEYS */;
INSERT INTO `limo_template_configuration` VALUES (1,'vanilla',NULL,NULL,NULL,'{\"add\":[\"css/ajaxify.css\",\"css/theme.css\",\"css/custom.css\"]}','{\"add\":[\"scripts/theme.js\",\"scripts/ajaxify.js\",\"scripts/custom.js\"]}','{\"add\":[\"css/print_theme.css\"]}','{\"ajaxmode\":\"off\",\"brandlogo\":\"on\",\"container\":\"on\", \"hideprivacyinfo\": \"off\", \"brandlogofile\":\"themes/survey/vanilla/files/logo.png\",\"font\":\"noto\", \"showpopups\":\"1\", \"showclearall\":\"off\", \"questionhelptextposition\":\"top\"}','bootstrap','{}','','{\"add\":[\"pjax\",\"font-noto\",\"moment\"]}',NULL,NULL),(2,'fruity',NULL,NULL,NULL,'{\"add\":[\"css/ajaxify.css\",\"css/animate.css\",\"css/theme.css\",\"css/custom.css\",\"css/variations/purple_tentacle.css\"]}','{\"add\":[\"scripts/theme.js\",\"scripts/ajaxify.js\",\"scripts/custom.js\"]}','{\"add\":[\"css/print_theme.css\"]}','{\"ajaxmode\":\"off\",\"brandlogo\":\"on\",\"brandlogofile\":\"image::generalfiles::wordcloud.png\",\"container\":\"on\",\"backgroundimage\":\"off\",\"backgroundimagefile\":null,\"animatebody\":\"off\",\"bodyanimation\":\"fadeInRight\",\"bodyanimationduration\":\"500\",\"animatequestion\":\"off\",\"questionanimation\":\"flipInX\",\"questionanimationduration\":\"500\",\"animatealert\":\"off\",\"alertanimation\":\"shake\",\"alertanimationduration\":\"500\",\"font\":\"noto\",\"bodybackgroundcolor\":\"#ffffff\",\"fontcolor\":\"#444444\",\"questionbackgroundcolor\":\"#ffffff\",\"questionborder\":\"on\",\"questioncontainershadow\":\"on\",\"checkicon\":\"f00c\",\"animatecheckbox\":\"on\",\"checkboxanimation\":\"rubberBand\",\"checkboxanimationduration\":\"500\",\"animateradio\":\"on\",\"radioanimation\":\"zoomIn\",\"radioanimationduration\":\"500\",\"zebrastriping\":\"off\",\"stickymatrixheaders\":\"off\",\"greyoutselected\":\"off\",\"hideprivacyinfo\":\"off\",\"crosshover\":\"off\",\"showpopups\":\"1\",\"showclearall\":\"off\",\"questionhelptextposition\":\"top\",\"notables\":\"1\",\"cssframework\":null,\"off\":\"false\",\"fixnumauto\":\"off\"}','bootstrap','{}','','{\"add\":[\"pjax\",\"font-noto\",\"moment\"]}',NULL,NULL),(3,'bootswatch',NULL,NULL,NULL,'{\"add\":[\"css/ajaxify.css\",\"css/theme.css\",\"css/custom.css\"]}','{\"add\":[\"scripts/theme.js\",\"scripts/ajaxify.js\",\"scripts/custom.js\"]}','{\"add\":[\"css/print_theme.css\"]}','{\"ajaxmode\":\"off\",\"brandlogo\":\"on\",\"container\":\"on\",\"brandlogofile\":\"themes/survey/bootswatch/files/logo.png\", \"showpopups\":\"1\", \"showclearall\":\"off\", \"questionhelptextposition\":\"top\"}','bootstrap','{\"replace\":[[\"css/bootstrap.css\",\"css/variations/flatly.min.css\"]]}','','{\"add\":[\"pjax\",\"font-noto\",\"moment\"]}',NULL,NULL),(4,'fruity',612158,NULL,NULL,'{\"add\":[\"css/variations/purple_tentacle.css\"]}','inherit','inherit','{\"general_inherit\":null,\"font\":\"inherit\",\"cssframework\":\"image::theme::css\\/variations\\/purple_tentacle.css\",\"bodybackgroundcolor\":\"inherit\",\"fontcolor\":\"inherit\",\"questionbackgroundcolor\":\"inherit\",\"checkicon\":\"inherit\",\"backgroundimagefile\":\"inherit\",\"brandlogofile\":\"inherit\",\"bodyanimation\":\"inherit\",\"inherit\":\"inherit\",\"questionanimation\":\"inherit\",\"alertanimation\":\"inherit\",\"checkboxanimation\":\"inherit\",\"radioanimation\":\"inherit\",\"container\":\"inherit\",\"zebrastriping\":\"inherit\",\"stickymatrixheaders\":\"inherit\",\"greyoutselected\":\"inherit\",\"hideprivacyinfo\":\"inherit\",\"crosshover\":\"inherit\",\"showpopups\":\"inherit\",\"notables\":\"inherit\",\"showclearall\":\"inherit\",\"questionhelptextposition\":\"inherit\",\"fixnumauto\":\"inherit\",\"questionborder\":\"inherit\",\"questioncontainershadow\":\"inherit\",\"backgroundimage\":\"inherit\",\"brandlogo\":\"inherit\",\"animatebody\":\"inherit\",\"animatequestion\":\"inherit\",\"animatealert\":\"inherit\",\"animatecheckbox\":\"inherit\",\"animateradio\":\"inherit\",\"generalInherit\":null}','inherit','inherit','inherit','inherit',NULL,NULL),(5,'fruity',NULL,1,NULL,'inherit','inherit','inherit','inherit','inherit','inherit','inherit','inherit',NULL,NULL),(6,'bootswatch',612158,NULL,NULL,'inherit','inherit','inherit','inherit','inherit','inherit','inherit','inherit',NULL,NULL),(7,'bootswatch',NULL,1,NULL,'inherit','inherit','inherit','inherit','inherit','inherit','inherit','inherit',NULL,NULL),(8,'fruity',182594,NULL,NULL,'inherit','inherit','inherit','inherit','inherit','inherit','inherit','inherit',NULL,NULL);
/*!40000 ALTER TABLE `limo_template_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_templates`
--

DROP TABLE IF EXISTS `limo_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `author` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` text COLLATE utf8mb4_unicode_ci,
  `license` mediumtext COLLATE utf8mb4_unicode_ci,
  `version` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_version` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_folder` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `files_folder` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `last_update` datetime DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `extends` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `limo_idx1_templates` (`name`),
  KEY `limo_idx2_templates` (`title`),
  KEY `limo_idx3_templates` (`owner_id`),
  KEY `limo_idx4_templates` (`extends`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_templates`
--

LOCK TABLES `limo_templates` WRITE;
/*!40000 ALTER TABLE `limo_templates` DISABLE KEYS */;
INSERT INTO `limo_templates` VALUES (1,'vanilla','vanilla','Vanilla Theme','2022-01-10 08:57:10','LimeSurvey GmbH','info@limesurvey.org','https://www.limesurvey.org/','Copyright (C) 2007-2019 The LimeSurvey Project Team\\r\\nAll rights reserved.','License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.','3.0','3.0','views','files','<strong>LimeSurvey Bootstrap Vanilla Survey Theme</strong><br>A clean and simple base that can be used by developers to create their own Bootstrap based theme.',NULL,1,''),(2,'fruity','fruity','Fruity Theme','2022-01-10 08:57:10','LimeSurvey GmbH','info@limesurvey.org','https://www.limesurvey.org/','Copyright (C) 2007-2019 The LimeSurvey Project Team\\r\\nAll rights reserved.','License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.','3.0','3.0','views','files','<strong>LimeSurvey Fruity Theme</strong><br>A fruity theme for a flexible use. This theme offers monochromes variations and many options for easy customizations.',NULL,1,'vanilla'),(3,'bootswatch','bootswatch','Bootswatch Theme','2022-01-10 08:57:10','LimeSurvey GmbH','info@limesurvey.org','https://www.limesurvey.org/','Copyright (C) 2007-2019 The LimeSurvey Project Team\\r\\nAll rights reserved.','License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.','3.0','3.0','views','files','<strong>LimeSurvey Bootwatch Theme</strong><br>Based on BootsWatch Themes: <a href=\"https://bootswatch.com/3/\"\">Visit BootsWatch page</a> ',NULL,1,'vanilla');
/*!40000 ALTER TABLE `limo_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_tutorial_entries`
--

DROP TABLE IF EXISTS `limo_tutorial_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_tutorial_entries` (
  `teid` int(11) NOT NULL AUTO_INCREMENT,
  `ordering` int(11) DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  `settings` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`teid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_tutorial_entries`
--

LOCK TABLES `limo_tutorial_entries` WRITE;
/*!40000 ALTER TABLE `limo_tutorial_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_tutorial_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_tutorial_entry_relation`
--

DROP TABLE IF EXISTS `limo_tutorial_entry_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_tutorial_entry_relation` (
  `teid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  PRIMARY KEY (`teid`,`tid`),
  KEY `limo_idx1_tutorial_entry_relation` (`uid`),
  KEY `limo_idx2_tutorial_entry_relation` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_tutorial_entry_relation`
--

LOCK TABLES `limo_tutorial_entry_relation` WRITE;
/*!40000 ALTER TABLE `limo_tutorial_entry_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_tutorial_entry_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_tutorials`
--

DROP TABLE IF EXISTS `limo_tutorials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_tutorials` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `active` int(11) DEFAULT '0',
  `settings` mediumtext COLLATE utf8mb4_unicode_ci,
  `permission` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_grade` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `limo_idx1_tutorials` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_tutorials`
--

LOCK TABLES `limo_tutorials` WRITE;
/*!40000 ALTER TABLE `limo_tutorials` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_tutorials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_user_groups`
--

DROP TABLE IF EXISTS `limo_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_user_groups` (
  `ugid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`ugid`),
  UNIQUE KEY `limo_idx1_user_groups` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_user_groups`
--

LOCK TABLES `limo_user_groups` WRITE;
/*!40000 ALTER TABLE `limo_user_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_user_in_groups`
--

DROP TABLE IF EXISTS `limo_user_in_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_user_in_groups` (
  `ugid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`ugid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_user_in_groups`
--

LOCK TABLES `limo_user_in_groups` WRITE;
/*!40000 ALTER TABLE `limo_user_in_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_user_in_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_user_in_permissionrole`
--

DROP TABLE IF EXISTS `limo_user_in_permissionrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_user_in_permissionrole` (
  `ptid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`ptid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_user_in_permissionrole`
--

LOCK TABLES `limo_user_in_permissionrole` WRITE;
/*!40000 ALTER TABLE `limo_user_in_permissionrole` DISABLE KEYS */;
/*!40000 ALTER TABLE `limo_user_in_permissionrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `limo_users`
--

DROP TABLE IF EXISTS `limo_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limo_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `users_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `lang` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `htmleditormode` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `templateeditormode` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `questionselectormode` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `one_time_pw` text COLLATE utf8mb4_unicode_ci,
  `dateformat` int(11) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validation_key` varchar(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation_key_expiration` datetime DEFAULT NULL,
  `last_forgot_email_password` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `limo_idx1_users` (`users_name`),
  KEY `limo_idx2_users` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `limo_users`
--

LOCK TABLES `limo_users` WRITE;
/*!40000 ALTER TABLE `limo_users` DISABLE KEYS */;
INSERT INTO `limo_users` VALUES (1,'v.stephan','$2y$10$Gk65OQbK5agvAPYhSBpuoeEax1UCKTO4Sb2jbE44qwi1bf1e81pMK','Veit',0,'de','v.stephan@evidentmedia.de','default','default','default',NULL,1,'2022-01-24 15:29:08','2022-01-10 09:59:09','2022-01-24 16:29:08','b59g5rkyuumvvw9mc7qw6b6q42dwgt47pd4ecx','2022-01-13 08:38:05','2022-01-11 08:38:05');
/*!40000 ALTER TABLE `limo_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-24 16:38:58
