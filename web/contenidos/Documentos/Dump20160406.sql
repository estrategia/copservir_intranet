-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: intranet
-- ------------------------------------------------------
-- Server version	5.5.25a

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
-- Table structure for table `m_tipocampana`
--

DROP TABLE IF EXISTS `m_tipocampana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_tipocampana` (
  `idTipoCampana` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreTipoCampana` varchar(45) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idTipoCampana`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_tipocampana`
--

LOCK TABLES `m_tipocampana` WRITE;
/*!40000 ALTER TABLE `m_tipocampana` DISABLE KEYS */;
INSERT INTO `m_tipocampana` VALUES (1,'prueba',1);
/*!40000 ALTER TABLE `m_tipocampana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_campanasdestino`
--

DROP TABLE IF EXISTS `t_campanasdestino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_campanasdestino` (
  `idImagenCampana` int(10) unsigned NOT NULL,
  `codigoCiudad` int(11) NOT NULL,
  `idGrupoInteres` int(10) NOT NULL,
  KEY `imagenesCampanasCiudades_idImagenCampana_fk_idx` (`idImagenCampana`),
  KEY `fk_mciudad_tcampanasdestino_idx` (`codigoCiudad`),
  CONSTRAINT `fk_mciudad_tcampanasdestino` FOREIGN KEY (`codigoCiudad`) REFERENCES `m_ciudad` (`codigoCiudad`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_campanasdestino`
--

LOCK TABLES `t_campanasdestino` WRITE;
/*!40000 ALTER TABLE `t_campanasdestino` DISABLE KEYS */;
INSERT INTO `t_campanasdestino` VALUES (1,76001,1),(2,76001,1),(3,76001,1),(4,76001,1),(5,76001,1);
/*!40000 ALTER TABLE `t_campanasdestino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_ofertaslaborales`
--

DROP TABLE IF EXISTS `t_ofertaslaborales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ofertaslaborales` (
  `idOfertaLaboral` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cargo` varchar(45) NOT NULL,
  `idCiudad` int(10) unsigned NOT NULL,
  `fechaPublicacion` datetime NOT NULL,
  `fechaCierre` datetime NOT NULL,
  `numeroDocumento` int(10) unsigned NOT NULL,
  `fechaInicioPublicacion` datetime NOT NULL,
  `fechaFinPublicacion` datetime NOT NULL,
  `tituloOferta` varchar(45) NOT NULL,
  `urlElEmpleo` varchar(45) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `descripcionContactoOferta` text NOT NULL,
  `idInformacionContacto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idOfertaLaboral`),
  KEY `ofertasLaborales_idUsuarioPublicacion_fk_idx` (`numeroDocumento`),
  KEY `fk_tOfertasLaborales_tInformacionContactoOferta_idx` (`idInformacionContacto`),
  CONSTRAINT `fk_tOfertasLaborales_tInformacionContactoOferta` FOREIGN KEY (`idInformacionContacto`) REFERENCES `t_informacioncontactooferta` (`idInformacionContacto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_ofertaslaborales`
--

LOCK TABLES `t_ofertaslaborales` WRITE;
/*!40000 ALTER TABLE `t_ofertaslaborales` DISABLE KEYS */;
INSERT INTO `t_ofertaslaborales` VALUES (1,'cominicador',76001,'2016-04-01 00:00:00','2016-04-02 00:00:00',1,'2016-04-01 00:00:00','2016-04-02 00:00:00','se necesita',' ',1,1,'se busca alguien q hable ',1),(2,'prueba',76001,'2016-04-01 00:00:00','2016-04-02 00:00:00',1,'2016-04-01 00:00:00','2016-04-02 00:00:00','se necesita tester',' ',1,1,'alguien que pruebe',1);
/*!40000 ALTER TABLE `t_ofertaslaborales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_ofertaslaboralesdestino`
--

DROP TABLE IF EXISTS `t_ofertaslaboralesdestino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ofertaslaboralesdestino` (
  `idOfertaLaboral` int(11) NOT NULL,
  `idGrupoInteres` int(10) NOT NULL,
  `codigoCiudad` int(11) NOT NULL,
  KEY `fk_ofertasDestino_ciudad_idx` (`codigoCiudad`),
  CONSTRAINT `fk_ofertasDestino_ciudad` FOREIGN KEY (`codigoCiudad`) REFERENCES `m_ciudad` (`codigoCiudad`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_ofertaslaboralesdestino`
--

LOCK TABLES `t_ofertaslaboralesdestino` WRITE;
/*!40000 ALTER TABLE `t_ofertaslaboralesdestino` DISABLE KEYS */;
INSERT INTO `t_ofertaslaboralesdestino` VALUES (1,1,76001),(2,1,76001);
/*!40000 ALTER TABLE `t_ofertaslaboralesdestino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_publicacionescampanas`
--

DROP TABLE IF EXISTS `t_publicacionescampanas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_publicacionescampanas` (
  `idImagenCampana` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreImagen` varchar(60) NOT NULL,
  `rutaImagen` varchar(60) NOT NULL,
  `idTipoCampana` int(10) unsigned NOT NULL,
  `numeroDocumento` int(10) unsigned NOT NULL,
  `urlEnlaceNoticia` varchar(45) DEFAULT NULL,
  `fechaRegistro` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `posicion` int(1) NOT NULL,
  PRIMARY KEY (`idImagenCampana`),
  KEY `publicacionesCampanasidTipoCampana_fk_idx` (`idTipoCampana`),
  CONSTRAINT `publicacionesCampanasidTipoCampana_fk` FOREIGN KEY (`idTipoCampana`) REFERENCES `m_tipocampana` (`idTipoCampana`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_publicacionescampanas`
--

LOCK TABLES `t_publicacionescampanas` WRITE;
/*!40000 ALTER TABLE `t_publicacionescampanas` DISABLE KEYS */;
INSERT INTO `t_publicacionescampanas` VALUES (1,'hola','banner2.jpg',1,1,'','2016-03-16',1,0),(2,'adios','banner5.jpg',1,1,' ','2016-03-16',1,1),(3,'publicidad','banner.png',1,1,' ','2016-03-16',1,2),(4,'publicidad','banner3.png',1,1,' ','2016-03-16',1,0),(5,'publicidad','banner4.jpg',1,1,' ','2016-03-16',1,2);
/*!40000 ALTER TABLE `t_publicacionescampanas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'intranet'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-06  9:29:41
