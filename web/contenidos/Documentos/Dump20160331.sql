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
-- Table structure for table `t_ofertaslaborales`
--

DROP TABLE IF EXISTS `t_ofertaslaborales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_ofertaslaborales` (
  `idOfertaLaboral` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cargo` varchar(45) NOT NULL,
  `idContenidoDestino` int(10) unsigned NOT NULL,
  `idCiudad` int(10) unsigned NOT NULL,
  `fechaPublicacion` datetime NOT NULL,
  `fechaCierre` datetime NOT NULL,
  `idUsuarioPublicacion` int(10) unsigned NOT NULL,
  `fechaInicioPublicacion` datetime NOT NULL,
  `fechaFinPublicacion` datetime NOT NULL,
  `tituloOferta` varchar(45) NOT NULL,
  `urlElEmpleo` varchar(45) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idArea` int(11) NOT NULL,
  `descripcionContactoOferta` text NOT NULL,
  `idInformacionContacto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idOfertaLaboral`),
  KEY `ofertasLaborales_idUsuarioPublicacion_fk_idx` (`idUsuarioPublicacion`),
  KEY `fk_tOfertasLaborales_tInformacionContactoOferta_idx` (`idInformacionContacto`),
  CONSTRAINT `fk_tOfertasLaborales_tInformacionContactoOferta` FOREIGN KEY (`idInformacionContacto`) REFERENCES `t_informacioncontactooferta` (`idInformacionContacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ofertasLaborales_idUsuarioPublicacion_fk` FOREIGN KEY (`idUsuarioPublicacion`) REFERENCES `m_usuario` (`numeroDocumento`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_ofertaslaborales`
--

LOCK TABLES `t_ofertaslaborales` WRITE;
/*!40000 ALTER TABLE `t_ofertaslaborales` DISABLE KEYS */;
INSERT INTO `t_ofertaslaborales` VALUES (1,'cominicador',1,76001,'2016-03-30 00:00:00','2016-03-31 00:00:00',1,'2016-03-30 00:00:00','2016-03-31 00:00:00','se necesita',' ',1,1,'se busca alguien q hable ',1),(2,'prueba',1,76001,'2016-03-30 00:00:00','2016-03-31 00:00:00',1,'2016-03-30 00:00:00','2016-03-31 00:00:00','se necesita tester',' ',1,1,'alguien que pruebe',1);
/*!40000 ALTER TABLE `t_ofertaslaborales` ENABLE KEYS */;
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

-- Dump completed on 2016-03-31 16:41:44
