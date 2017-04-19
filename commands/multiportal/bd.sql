SET foreign_key_checks = 0;

--
-- Table structure for table `m_FORCO_Capitulo`
--

DROP TABLE IF EXISTS `m_FORCO_Capitulo`;

CREATE TABLE `m_FORCO_Capitulo` (
  `idCapitulo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreCapitulo` varchar(45) NOT NULL,
  `descripcionCapitulo` varchar(250) NOT NULL,
  `estadoCapitulo` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idModulo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idCapitulo`),
  KEY `fk_m_FORCO_Capitulo_m_FORCO_Modulo` (`idModulo`),
  CONSTRAINT `fk_m_FORCO_Capitulo_m_FORCO_Modulo` FOREIGN KEY (`idModulo`) REFERENCES `m_FORCO_Modulo` (`idModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_Contenido`
--

DROP TABLE IF EXISTS `m_FORCO_Contenido`;

CREATE TABLE `m_FORCO_Contenido` (
  `idContenido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contenido` longtext,
  `estadoContenido` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `idCapitulo` int(10) unsigned NOT NULL,
  `idContenidoCopia` int(10) unsigned DEFAULT NULL,
  `frecuenciaMes` tinyint(3) unsigned DEFAULT '0',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tituloContenido` varchar(255) NOT NULL,
  `descripcionContenido` varchar(255) NOT NULL,
  `idCurso` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idContenido`),
  KEY `fk_m_FORCO_Contenido_m_FORCO_Capitulo1_idx` (`idCapitulo`),
  KEY `fk_m_FORCO_Contenido_m_FORCO_Contenido1_idx` (`idContenidoCopia`),
  KEY `fk_m_FORCO_Contenido_m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_m_FORCO_Contenido_m_FORCO_Capitulo1` FOREIGN KEY (`idCapitulo`) REFERENCES `m_FORCO_Capitulo` (`idCapitulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_m_FORCO_Contenido_m_FORCO_Contenido1` FOREIGN KEY (`idContenidoCopia`) REFERENCES `m_FORCO_Contenido` (`idContenido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_m_FORCO_Contenido_m_FORCO_Curso` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`)
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_Cuestionario`
--

DROP TABLE IF EXISTS `m_FORCO_Cuestionario`;

CREATE TABLE `m_FORCO_Cuestionario` (
  `idCuestionario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tituloCuestionario` varchar(100) NOT NULL,
  `descripcionCuestionario` varchar(250) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `porcentajeMinimo` int(11) NOT NULL DEFAULT '0',
  `numeroPreguntas` int(11) NOT NULL DEFAULT '0',
  `numeroIntentos` int(11) NOT NULL DEFAULT '0',
  `idCurso` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idCuestionario`),
  KEY `idCurso` (`idCurso`),
  CONSTRAINT `m_FORCO_Cuestionario_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`) ON UPDATE CASCADE
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_Curso`
--

DROP TABLE IF EXISTS `m_FORCO_Curso`;

CREATE TABLE `m_FORCO_Curso` (
  `idCurso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreCurso` varchar(45) DEFAULT NULL,
  `presentacionCurso` varchar(250) DEFAULT NULL,
  `estadoCurso` tinyint(1) NOT NULL DEFAULT '1',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idTipoContenido` int(10) unsigned NOT NULL,
  `fechaInicio` datetime NOT NULL,
  `fechaFin` datetime DEFAULT NULL,
  PRIMARY KEY (`idCurso`),
  KEY `fk_m_FORCO_Curso_m_FORCO_TipoContenido` (`idTipoContenido`),
  CONSTRAINT `fk_m_FORCO_Curso_m_FORCO_TipoContenido` FOREIGN KEY (`idTipoContenido`) REFERENCES `m_FORCO_TipoContenido` (`idTipoContenido`)
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_Modulo`
--

DROP TABLE IF EXISTS `m_FORCO_Modulo`;

CREATE TABLE `m_FORCO_Modulo` (
  `idModulo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreModulo` varchar(45) NOT NULL,
  `descripcionModulo` varchar(250) NOT NULL,
  `estadoModulo` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idCurso` int(10) unsigned NOT NULL,
  `duracionDias` int(3) unsigned NOT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  PRIMARY KEY (`idModulo`),
  KEY `fk_m_FORCO_Modulo_m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_m_FORCO_Modulo_m_FORCO_Curso` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`)
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_OpcionRespuesta`
--

DROP TABLE IF EXISTS `m_FORCO_OpcionRespuesta`;

CREATE TABLE `m_FORCO_OpcionRespuesta` (
  `idOpcionRespuesta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPregunta` int(10) unsigned NOT NULL,
  `respuesta` varchar(250) NOT NULL,
  `esCorrecta` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idOpcionRespuesta`),
  KEY `fk_m_FORCO_OpcionRespuesta_m_FORCO_Pregunta1_idx` (`idPregunta`),
  CONSTRAINT `fk_m_FORCO_OpcionRespuesta_m_FORCO_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `m_FORCO_Pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_ParametrosPuntos`
--

DROP TABLE IF EXISTS `m_FORCO_ParametrosPuntos`;

CREATE TABLE `m_FORCO_ParametrosPuntos` (
  `idParametroPunto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoParametro` int(1) unsigned NOT NULL,
  `valorPuntos` int(11) unsigned NOT NULL,
  `idTipoContenido` int(10) unsigned NOT NULL,
  `condicion` int(2) unsigned DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valorPuntosExtra` int(11) DEFAULT NULL,
  PRIMARY KEY (`idParametroPunto`),
  KEY `fk_m_FORCO_ParametrosPuntos_m_FORCO_TipoContenido` (`idTipoContenido`),
  CONSTRAINT `fk_m_FORCO_ParametrosPuntos_m_FORCO_TipoContenido` FOREIGN KEY (`idTipoContenido`) REFERENCES `m_FORCO_TipoContenido` (`idTipoContenido`)
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_Pregunta`
--

DROP TABLE IF EXISTS `m_FORCO_Pregunta`;

CREATE TABLE `m_FORCO_Pregunta` (
  `idPregunta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tituloPregunta` varchar(45) NOT NULL,
  `pregunta` text,
  `idPreguntaPadre` int(10) unsigned DEFAULT NULL COMMENT 'Para agrupar preguntas (completar)',
  `idTipoPregunta` int(10) unsigned NOT NULL,
  `idCuestionario` int(10) unsigned NOT NULL,
  `estado` tinyint(1) unsigned NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPregunta`),
  KEY `fk_m_FORCO_Pregunta_m_FORCO_Pregunta1_idx` (`idPreguntaPadre`),
  KEY `fk_m_FORCO_Pregunta_m_TipoPregunta1_idx` (`idTipoPregunta`),
  KEY `fk_m_FORCO_Pregunta_m_FORCO_Cuestionario1_idx` (`idCuestionario`),
  CONSTRAINT `fk_m_FORCO_Pregunta_m_FORCO_Cuestionario1` FOREIGN KEY (`idCuestionario`) REFERENCES `m_FORCO_Cuestionario` (`idCuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_m_FORCO_Pregunta_m_FORCO_Pregunta1` FOREIGN KEY (`idPreguntaPadre`) REFERENCES `m_FORCO_Pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_m_FORCO_Pregunta_m_TipoPregunta1` FOREIGN KEY (`idTipoPregunta`) REFERENCES `m_FORCO_TipoPregunta` (`idTipoPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_TipoContenido`
--

DROP TABLE IF EXISTS `m_FORCO_TipoContenido`;

CREATE TABLE `m_FORCO_TipoContenido` (
  `idTipoContenido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreTipoContenido` varchar(45) NOT NULL,
  `estadoTipoContenido` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idTipoContenido`)
) ENGINE=InnoDB;


--
-- Table structure for table `m_FORCO_TipoPregunta`
--

DROP TABLE IF EXISTS `m_FORCO_TipoPregunta`;

CREATE TABLE `m_FORCO_TipoPregunta` (
  `idTipoPregunta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoPregunta` varchar(45) NOT NULL,
  `estado` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`idTipoPregunta`)
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_ContenidoCalificacion`
--

DROP TABLE IF EXISTS `t_FORCO_ContenidoCalificacion`;


CREATE TABLE `t_FORCO_ContenidoCalificacion` (
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `idContenido` int(10) unsigned NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `comentario` varchar(100) NOT NULL,
  `calificacion` int(1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`numeroDocumento`,`idContenido`)
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_ContenidoLeidoUsuario`
--

DROP TABLE IF EXISTS `t_FORCO_ContenidoLeidoUsuario`;


CREATE TABLE `t_FORCO_ContenidoLeidoUsuario` (
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `idContenido` int(10) unsigned NOT NULL DEFAULT '0',
  `fechaCreacion` datetime DEFAULT NULL,
  `idCurso` int(10) unsigned NOT NULL,
  PRIMARY KEY (`numeroDocumento`,`idContenido`),
  KEY `fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Contenido` (`idContenido`),
  KEY `fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Contenido` FOREIGN KEY (`idContenido`) REFERENCES `m_FORCO_Contenido` (`idContenido`),
  CONSTRAINT `fk_t_FORCO_ContenidoLeidoUsuario_m_FORCO_Curso` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_ContenidoLeidoUsuario_m_Usuario` FOREIGN KEY (`numeroDocumento`) REFERENCES `m_Usuario` (`numeroDocumento`)
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_CuestionarioUsuario`
--

DROP TABLE IF EXISTS `t_FORCO_CuestionarioUsuario`;


CREATE TABLE `t_FORCO_CuestionarioUsuario` (
  `idCuestionarioUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idCuestionario` int(10) unsigned NOT NULL,
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `numeroPreguntasTotal` double DEFAULT NULL,
  `numeroPreguntasRespondidas` double DEFAULT NULL,
  `porcentajeObtenido` double DEFAULT NULL,
  `estadoCuestionario` tinyint(1) unsigned NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaActualizacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idCuestionarioUsuario`),
  KEY `fk_t_FORCO_CuestionarioUsuario_m_FORCO_Cuestionario1_idx` (`idCuestionario`),
  KEY `fk_t_FORCO_CuestionarioUsuario_m_Usuario1_idx` (`numeroDocumento`),
  CONSTRAINT `fk_t_FORCO_CuestionarioUsuario_m_FORCO_Cuestionario1` FOREIGN KEY (`idCuestionario`) REFERENCES `m_FORCO_Cuestionario` (`idCuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_FORCO_CuestionarioUsuario_m_Usuario1` FOREIGN KEY (`numeroDocumento`) REFERENCES `m_Usuario` (`numeroDocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_CursoGruposInteres`
--

DROP TABLE IF EXISTS `t_FORCO_CursoGruposInteres`;


CREATE TABLE `t_FORCO_CursoGruposInteres` (
  `idGrupoInteres` int(10) unsigned NOT NULL,
  `idCurso` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idGrupoInteres`,`idCurso`),
  KEY `fk_t_FORCO_CursoGruposInteres_m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_CursoGruposInteres_m_FORCO_Curso` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_CursoGruposInteres_m_GrupoInteres` FOREIGN KEY (`idGrupoInteres`) REFERENCES `m_GrupoInteres` (`idGrupoInteres`)
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_CursosUsuario`
--

DROP TABLE IF EXISTS `t_FORCO_CursosUsuario`;


CREATE TABLE `t_FORCO_CursosUsuario` (
  `idCurso` int(10) unsigned NOT NULL,
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `fechaInicioLectura` datetime DEFAULT NULL,
  PRIMARY KEY (`idCurso`,`numeroDocumento`),
  KEY `fk_t_FORCO_CursosUsuario_m_Usuario` (`numeroDocumento`),
  CONSTRAINT `fk_t_FORCO_CursosUsuario_m_FORCO_Curso` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_CursosUsuario_m_Usuario` FOREIGN KEY (`numeroDocumento`) REFERENCES `m_Usuario` (`numeroDocumento`)
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_Puntos`
--

DROP TABLE IF EXISTS `t_FORCO_Puntos`;


CREATE TABLE `t_FORCO_Puntos` (
  `idPunto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `valorPuntos` int(11) unsigned NOT NULL,
  `descripcionPunto` varchar(100) NOT NULL,
  `idCuestionario` int(10) unsigned DEFAULT NULL,
  `idParametroPunto` int(10) unsigned DEFAULT NULL,
  `tipoParametro` int(10) DEFAULT NULL,
  `idTipoContenido` int(10) unsigned DEFAULT NULL,
  `condicion` int(2) unsigned DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT NULL,
  `idPuntoSincronizado` int(10) unsigned DEFAULT NULL,
  `idCurso` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idPunto`),
  KEY `fk_t_FORCO_Puntos_m_FORCO_Cuestionario` (`idCuestionario`),
  KEY `fk_t_FORCO_Puntos_m_FORCO_ParametrosPuntos` (`idParametroPunto`),
  KEY `fk_t_FORCO_Puntos_m_Usuario` (`numeroDocumento`),
  KEY `idCurso` (`idCurso`),
  CONSTRAINT `fk_t_FORCO_Puntos_m_FORCO_Cuestionario` FOREIGN KEY (`idCuestionario`) REFERENCES `m_FORCO_Cuestionario` (`idCuestionario`),
  CONSTRAINT `fk_t_FORCO_Puntos_m_FORCO_ParametrosPuntos` FOREIGN KEY (`idParametroPunto`) REFERENCES `m_FORCO_ParametrosPuntos` (`idParametroPunto`),
  CONSTRAINT `fk_t_FORCO_Puntos_m_Usuario` FOREIGN KEY (`numeroDocumento`) REFERENCES `m_Usuario` (`numeroDocumento`),
  CONSTRAINT `t_FORCO_Puntos_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `m_FORCO_Curso` (`idCurso`) ON UPDATE CASCADE
) ENGINE=InnoDB;


--
-- Table structure for table `t_FORCO_Respuestas`
--

DROP TABLE IF EXISTS `t_FORCO_Respuestas`;


CREATE TABLE `t_FORCO_Respuestas` (
  `idRespuesta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numeroDocumento` bigint(20) unsigned NOT NULL,
  `idPregunta` int(10) unsigned NOT NULL,
  `idOpcionRespuesta` int(10) unsigned DEFAULT NULL,
  `esCorrecta` int(10) unsigned DEFAULT NULL,
  `idCuestionario` int(10) unsigned DEFAULT NULL,
  `respuestaTextual` varchar(255) NOT NULL,
  `idCuestionarioUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idRespuesta`),
  KEY `fk_t_FORCO_Respuestas_m_Usuario1_idx` (`numeroDocumento`),
  KEY `fk_t_FORCO_Respuestas_m_FORCO_Pregunta1_idx` (`idPregunta`),
  KEY `fk_t_FORCO_Respuestas_m_FORCO_OpcionRespuesta1_idx` (`idOpcionRespuesta`),
  KEY `fk_t_FORCO_Respuestas_m_FORCO_idCuestionario_idx` (`idCuestionario`),
  KEY `idCuestionarioUsuario` (`idCuestionarioUsuario`),
  CONSTRAINT `fk_t_FORCO_Respuestas_m_FORCO_Cuestionario` FOREIGN KEY (`idCuestionario`) REFERENCES `m_FORCO_Cuestionario` (`idCuestionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_FORCO_Respuestas_m_FORCO_OpcionRespuesta1` FOREIGN KEY (`idOpcionRespuesta`) REFERENCES `m_FORCO_OpcionRespuesta` (`idOpcionRespuesta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_FORCO_Respuestas_m_FORCO_Pregunta1` FOREIGN KEY (`idPregunta`) REFERENCES `m_FORCO_Pregunta` (`idPregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_FORCO_Respuestas_m_Usuario1` FOREIGN KEY (`numeroDocumento`) REFERENCES `m_Usuario` (`numeroDocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `t_FORCO_Respuestas_ibfk_1` FOREIGN KEY (`idCuestionarioUsuario`) REFERENCES `t_FORCO_CuestionarioUsuario` (`idCuestionarioUsuario`)
) ENGINE=InnoDB;

SET foreign_key_checks = 1;
