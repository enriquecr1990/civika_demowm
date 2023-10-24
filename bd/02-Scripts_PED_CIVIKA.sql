CREATE TABLE `cat_pregunta_formulario_abierto` (
  `id_cat_pregunta_formulario_abierto` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta_formulario_abierto` varchar(750) NOT NULL,
  `id_entregable_evidencia` int(10) NOT NULL,
  `eliminado` enum('no','si') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id_cat_pregunta_formulario_abierto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar las preguntas abiertas de formulario dinamico';


CREATE TABLE `respuesta_pregunta_formulario_abierto` (
  `id_respuesta_pregunta_formulario_abierto` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta_pregunta_formulario_abierto` varchar(750) COLLATE utf8_bin NOT NULL,
  `respuesta_has_pregunta_formulario_abierto` int(11) NOT NULL,
  `usuario` int(10) NOT NULL,
  `eliminado` enum('no','si') COLLATE utf8_bin DEFAULT 'no',
  PRIMARY KEY (`id_respuesta_pregunta_formulario_abierto`),
  KEY `respuesta_has_pregunta_formulario_abierto_idx` (`respuesta_has_pregunta_formulario_abierto`),
  CONSTRAINT `fk_respuesta_has_pregunta_formulario_abierto` FOREIGN KEY (`respuesta_has_pregunta_formulario_abierto`) REFERENCES `cat_pregunta_formulario_abierto` (`id_cat_pregunta_formulario_abierto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla para almacenar las preguntas abiertas del formulario dinamico';



CREATE TABLE `ec_curso` (
  `id_ec_curso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `que_aprenderas` text COLLATE utf8_spanish_ci,
  `id_archivo` bigint(20) unsigned DEFAULT NULL,
  `publicado` enum('no','si') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `fecha_publicado` datetime DEFAULT NULL,
  `eliminado` enum('no','si') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `id_estandar_competencia` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_ec_curso`),
  KEY `fk_ec_ec_curso_idx` (`id_estandar_competencia`),
  KEY `fk_archivo_eccursobanner_idx` (`id_archivo`),
  CONSTRAINT `fk_archivo_eccursobanner` FOREIGN KEY (`id_archivo`) REFERENCES `archivo` (`id_archivo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_ec_curso` FOREIGN KEY (`id_estandar_competencia`) REFERENCES `estandar_competencia` (`id_estandar_competencia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla para agregar cursos';


CREATE TABLE `ec_curso_modulo` (
  `id_ec_curso_modulo` int(19) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `objetivo_general` text COLLATE utf8_bin NOT NULL,
  `objetivos_especificos` text COLLATE utf8_bin NOT NULL,
  `eliminado` enum('no','si') COLLATE utf8_bin NOT NULL DEFAULT 'no',
  `id_evaluacion` int(10) unsigned DEFAULT NULL,
  `id_ec_curso` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_ec_curso_modulo`),
  KEY `fk_eccursomodulo_evaluacion_idx` (`id_evaluacion`),
  KEY `fk_eccursomodulo_ec_curso_idx` (`id_ec_curso`),
  CONSTRAINT `fk_eccursomodulo_ec_curso` FOREIGN KEY (`id_ec_curso`) REFERENCES `ec_curso` (`id_ec_curso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_eccursomodulo_evaluacion` FOREIGN KEY (`id_evaluacion`) REFERENCES `evaluacion` (`id_evaluacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla para almacenar los datos de cada modulo del curso';


CREATE TABLE `ec_curso_modulo_temario` (
  `id_ec_curso_modulo_temario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tema` varchar(250) COLLATE utf8_bin NOT NULL,
  `instrucciones` text COLLATE utf8_bin,
  `contenido_curso` text COLLATE utf8_bin,
  `eliminado` enum('si','no') COLLATE utf8_bin GENERATED ALWAYS AS ('no') VIRTUAL,
  `id_archivo` bigint(20) unsigned DEFAULT NULL,
  `id_ec_curso_modulo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_ec_curso_modulo_temario`),
  KEY `fk_eccursomodulo_eccursomodulotemario_idx` (`id_ec_curso_modulo`),
  KEY `fk_eccmtemario_archivo_idx` (`id_archivo`),
  CONSTRAINT `fk_eccmtemario_archivo` FOREIGN KEY (`id_archivo`) REFERENCES `archivo` (`id_archivo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_eccursomodulo_eccursomodulotemario` FOREIGN KEY (`id_ec_curso_modulo`) REFERENCES `ec_curso_modulo` (`id_ec_curso_modulo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla para almacenar los datos de los temarios de modulo del curso';



