-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: agro
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

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
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `line` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `message` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `tpl_path` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `src_path` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (28,'meta','','meta','meta'),(29,'header','','header','header'),(30,'menu','','menu','menu'),(31,'content','','content','content'),(32,'footer','','footer','footer'),(33,'slider','','slider','slider'),(34,'gallery',NULL,'gallery','gallery'),(35,'miniHeader',NULL,'miniHeader','miniHeader');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules_set`
--

DROP TABLE IF EXISTS `modules_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `set_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_params` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `lp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules_set`
--

LOCK TABLES `modules_set` WRITE;
/*!40000 ALTER TABLE `modules_set` DISABLE KEYS */;
INSERT INTO `modules_set` VALUES (63,'index',28,NULL,1,1),(64,'index',29,NULL,1,2),(65,'index',33,NULL,0,3),(66,'index',31,NULL,1,4),(67,'index',32,NULL,1,5),(68,'gallery',28,NULL,1,1),(69,'gallery',29,NULL,0,2),(70,'gallery',34,NULL,1,3),(71,'gallery',32,NULL,1,4),(72,'subpage',28,NULL,1,1),(73,'subpage',29,NULL,0,2),(74,'subpage',31,NULL,1,3),(75,'subpage',32,NULL,1,4),(76,'gallery',35,NULL,1,2),(77,'subpage',35,NULL,1,2);
/*!40000 ALTER TABLE `modules_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_content`
--

DROP TABLE IF EXISTS `pages_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `header` text COLLATE utf8_bin,
  `content` longtext COLLATE utf8_bin NOT NULL,
  `lang_code` enum('GB','PL') COLLATE utf8_bin NOT NULL DEFAULT 'GB',
  `class` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `style` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_id_UNIQUE` (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_content`
--

LOCK TABLES `pages_content` WRITE;
/*!40000 ALTER TABLE `pages_content` DISABLE KEYS */;
INSERT INTO `pages_content` VALUES (17,'kontakt','Kontakt','<div class=\"row\"><div class=\"col-xs-6\">Gospodarstwo Pod Bocianem</br></br>Marek Rosiak</br>Łagiewniki 31</br>62-010 Pobiedziska</br>woj. wielkopolskie</div><div class=\"col-xs-6 col_r\"></br></br>Marek Rosiak tel. 507 059 975</br>Renata Rosiak tel. 608 527 174</br></br>adres e-mail: <a href=\"mailto:rosiakmr@wp.pl\" class=\"mailto\">rosiakmr@wp.pl</a></div></div></br><div id=\"map\"><iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d155283.7044433486!2d17.25334363264112!3d52.545955559912144!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470461e8efa4790b%3A0x57af3e2ec0791cf!2s%C5%81agiewniki+31%2C+62-010+%C5%81agiewniki!5e0!3m2!1spl!2spl!4v1420807201781\" width=\"100%\" height=\"450\" frameborder=\"0\" style=\"border:0\"></iframe></div>','PL',NULL,NULL,NULL,1,26),(14,'cennik','Cennik','Oferuję noclegi w formie agroturystyki.</br></br>Dysponuję mieszkaniem na pierwszym piętrze (dla 6 osób), w skład którego wchodzą:</br>- sypialnia z jednym łóżkiem 2-osobowym</br>- dwie sypialnie z dwoma łóżkami 1-osobowymi</br>- jedna wspólna łazienka z wanną</br>- w pełni wyposażona kuchnia (lodówka, płyta elektryczna, naczynia)</br></br>Cena 300zł/doba netto.</br>Przy mniejszej liczbie osób cena do negocjacji.</br>Przy pobycie krótszym niż 5 dni - dodatkowa opłata za sprzątanie końcowe 50zł.</br>Łożeczko niemowlęce na życzenie - 50zł/pobyt.</br>miejsca parkingowe: niestrzeżone przy obiekcie bez opłat.</br></br>Wystawiam faktury VAT (8%).</br></br>Doba hotelowa zaczyna się od 16.00 w dniu przyjazdu do 12.00 w dniu wyjazdu.</br></br>Przy rezerwacji wymagana zaliczka w wysokości 30% wartości pobytu.</br>','PL',NULL,NULL,NULL,1,24),(15,'regulamin','REGULAMIN WYPOCZYNKU W GOSPODARSTWIE AGROTURYSTYCZNYM „GOSPODARSTWO POD BOCIANEM”','1.Turysta zobowiązany jest do przestrzegania porządku obowiązującego w gospodarstwie agroturystycznym i do użytkowania wszystkich pomieszczeń zgodnie z ich przeznaczeniem.<br>2.Po przyjeździe do gospodarstwa należy się zameldować przedstawiając dokument tożsamości. <br>3.Na początku i na końcu pobytu dokonana zostanie inwentaryzacja i sprawdzenie stanu pomieszczeń wraz z ich wyposażeniem.<br>4.Sprzątanie pokoi zajętych przez turystów ustalone jest indywidualnie z gospodarzami w dniu przyjazdu (dotyczy pobytu dłuższego niż 7 dni.)<br>5.Jeżeli liczba turystów jest wyższa niż wcześniej ustalono gospodarz ma prawo:<br>- odmówić przyjęcia dodatkowych osób.<br>- odstąpić od umowy z winy turysty.<br>6.Turysta nie może bez zgody gospodarzy przyjmować na nocleg lub pobyt dzienny w gospodarstwie agroturystycznym dodatkowych osób traktując ich jako swoich gości.<br>7.Osobom pod wpływem alkoholu lub środków odurzających, zachowujących się agresywnie, gospodarze maja prawo wymówić pokój w trybie natychmiastowym bez zwrotu dokonanych wcześniej opłat.<br>8.Gospodarze wskazują turyście miejsce do parkowania samochodu, ale nie ponoszą odpowiedzialności za jego bezpieczeństwo.<br>9.Gospodarze nie ponoszą odpowiedzialności za mienie turysty. <br>10. Turysta odpowiada za wyrządzone przez siebie szkody, za które ma obowiązek zapłacić na miejscu z własnych środków, za szkody spowodowane przez dzieci odpowiadają ich opiekunowie.<br>11.Turysta otrzymuje do swojej dyspozycji klucz do pokoju i zobowiązany jest zwrócić go w dniu wyjazdu. Zgubienie klucza powoduje obowiązek uiszczenia należnej opłaty - 50 ZŁ.<br>12.Trzymanie zwierząt domowych w najmowanych pomieszczeniach jest zabronione. <br>13.Dostęp do zwierząt w gospodarstwie( w tym psów) może odbywać się pod nadzorem gospodarzy lub osoby do tego wyznaczonej. <br>14.Uczestnictwo turysty w pracach w gospodarstwie jest możliwe tylko po uzgodnieniu z gospodarzami. <br>15.Za pobyt turysty poza gospodarstwem gospodarze nie ponoszą żadnej odpowiedzialności.<br>16.W całym domu obowiązuje zakaz palenia tytoniu. <br>17.W godzinach 22:00- 6:00 obowiązuje cisza nocna. <br>18.Gospodarze służą wyjaśnieniami i radą we wszystkich spornych kwestiach dotyczących regulaminu i uprzejmie proszą zacnych gości o jego przestrzeganie.<br>','PL',NULL,NULL,NULL,1,25);
/*!40000 ALTER TABLE `pages_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin_gallery`
--

DROP TABLE IF EXISTS `plugin_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugin_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `alt` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `lp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugin_gallery`
--

LOCK TABLES `plugin_gallery` WRITE;
/*!40000 ALTER TABLE `plugin_gallery` DISABLE KEYS */;
INSERT INTO `plugin_gallery` VALUES (1,'agro04.jpg','pokój 2','pokój 2',NULL,9),(2,'agro12.jpg','łazienka','łazienka',NULL,2),(3,'agro08.jpg','kuchnia','kuchnia',NULL,3),(4,'agro05.jpg','pokój 3','pokój 3',NULL,10),(5,'agro01.jpg','pokój 1','pokój 1',NULL,5),(6,'agro02.jpg','pokój 2','pokój 2',NULL,7),(7,'agro03.jpg','pokój 2','pokój 2',NULL,8),(8,'agro11.jpg','kuchnia','kuchnia',NULL,4),(9,'agro07.jpg','kuchnia','kuchnia',NULL,12),(10,'agro09.jpg','pokój 2','pokój 2',NULL,6),(11,'agro06.jpg','pokój 3','pokój 3',NULL,11),(12,'agro10.jpg','kuchnia','kuchnia',NULL,1),(13,'agro13.jpg','balkon','balkon',NULL,13);
/*!40000 ALTER TABLE `plugin_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setups`
--

DROP TABLE IF EXISTS `setups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT NULL,
  `setup_type` enum('page_template','page') COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `alias` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `href` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `modules_set_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `mode` enum('json','basic','blank') COLLATE utf8_bin NOT NULL DEFAULT 'basic',
  `access` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setups`
--

LOCK TABLES `setups` WRITE;
/*!40000 ALTER TABLE `setups` DISABLE KEYS */;
INSERT INTO `setups` VALUES (22,NULL,'page','index','about','','index','basic',NULL,1),(23,0,'page','galeria','galeria','galeria','gallery','basic',NULL,1),(24,NULL,'page','cennik','cennik','cennik','subpage','basic',NULL,1),(25,NULL,'page','regulamin','regulamin','regulamin','subpage','basic',NULL,1),(26,NULL,'page','kontakt','kontakt','kontakt','subpage','basic',NULL,1);
/*!40000 ALTER TABLE `setups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-02 17:26:00
