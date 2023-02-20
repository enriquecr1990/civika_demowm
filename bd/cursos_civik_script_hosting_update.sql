ALTER TABLE `usuario` 
ADD COLUMN `tipo_usuario` ENUM('admin', 'instructor', 'alumno', 'contador') NOT NULL DEFAULT 'alumno' COMMENT 'almacena el tipo de usuario que esta registrado en el sistema' AFTER `fecha_update_pass_olvidado`;

update usuario u
  left join usuario_admin ua on ua.id_usuario = u.id_usuario
  left join alumno a on a.id_usuario = u.id_usuario
  left join instructor i on i.id_usuario = u.id_usuario
set u.tipo_usuario = if(ua.id_usuario_admin is not null and ua.tipo = 'administrador','admin',
    if(ua.id_usuario_admin is not null and ua.tipo = 'admin','admin',
      if(a.id_alumno is not null, 'alumno',
        if(i.id_instructor is not null, 'instructor','alumno')
      )
    )
);

ALTER TABLE `curso_taller_norma` 
ADD COLUMN `ctn_cancelado` ENUM('no', 'si') NOT NULL DEFAULT 'no' AFTER `id_documento`;

ALTER TABLE `curso_taller_norma` 
CHANGE COLUMN `ctn_cancelado` `ctn_cancelado` ENUM('no', 'si') NOT NULL DEFAULT 'no' COMMENT 'almacena si un curso del sistema se encuentra cancelado' ,
ADD COLUMN `descripcion_cancelacion` TEXT NULL DEFAULT NULL COMMENT 'almacenara la descripcion de la cancelacion del curso taller norma' AFTER `ctn_cancelado`;

ALTER TABLE `curso_taller_norma` 
ADD COLUMN `fecha_cancelado` DATETIME NULL DEFAULT NULL AFTER `ctn_cancelado`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `publicacion_eliminada` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `descripcion_break_curso`,
ADD COLUMN `fecha_eliminada` DATETIME NULL DEFAULT NULL AFTER `publicacion_eliminada`,
ADD COLUMN `detalle_eliminacion` TEXT NULL DEFAULT NULL AFTER `fecha_eliminada`,
ADD COLUMN `publicacion_modificada` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `detalle_eliminacion`,
ADD COLUMN `fecha_modificada` DATETIME NULL DEFAULT NULL AFTER `publicacion_modificada`,
ADD COLUMN `detalle_modificacion` VARCHAR(45) NULL DEFAULT NULL AFTER `fecha_modificada`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `orden_publicacion` INT(5) NOT NULL DEFAULT 99999 AFTER `detalle_modificacion`;

CREATE TABLE IF NOT EXISTS `visita_sitio` (
  `id_visita_sitio` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(20) NOT NULL COMMENT 'almacena la ip del usuario visitante',
  `num_visita` INT(10) NOT NULL COMMENT 'almacena el numero de visitas al sitio del usuario cuando ya exista',
  `fecha_primer_visita` DATETIME NOT NULL COMMENT 'almacena la fecha de cuando el visitante nos visito por primera vez',
  `fecha_ultima_visita` DATETIME NULL DEFAULT NULL,
  `dispositivo` VARCHAR(45) NOT NULL COMMENT 'almacena la informacion del dispositivo que nos esta visitando',
  `id_usuario` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'almacena el id del usuario que nos vista si es que existe sesion en el dispositivo',
  PRIMARY KEY (`id_visita_sitio`),
  INDEX `fk_visita_sitio_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_visita_sitio_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `publicacion_ctn_has_galeria` (
  `id_publicacion_ctn_has_galeria` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_publicacion_ctn_has_galeria`),
  INDEX `fk_publicacion_ctn_has_galeria_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  INDEX `fk_publicacion_ctn_has_galeria_documento1_idx` (`id_documento` ASC),
  CONSTRAINT `fk_publicacion_ctn_has_galeria_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacion_ctn_has_galeria_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
CHANGE COLUMN `folio_habilidades` `folio_habilidades` CHAR(12) NULL DEFAULT NULL COMMENT 'almacena el consecutivo del folio para la constancia de habilidades' ;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
ADD COLUMN `fecha_folio_generado` DATE NULL DEFAULT NULL AFTER `id_documento_dc3`;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
CHANGE COLUMN `fecha_folio_generado` `fecha_folio_generado` DATE NULL DEFAULT NULL COMMENT 'fecha de cuando se genero el folio' ,
ADD COLUMN `asistio` ENUM('si', 'no') NOT NULL DEFAULT 'no' COMMENT 'almacena la variable de los alumnos que asistieron al cursos para imprimir las constancias de forma masiva' AFTER `folio_habilidades`;

ALTER TABLE `publicacion_has_doc_banner` 
ADD COLUMN `documento_publico` ENUM('si', 'no') NULL DEFAULT NULL COMMENT 'almacena si un documento se encuentra como publico para la carta descriptiva' AFTER `id_documento`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `visitas_carta_descriptiva` INT(10) NOT NULL DEFAULT 0 AFTER `orden_publicacion`;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
ADD COLUMN `semaforo_asistencia` ENUM('no_asiste', 'no_seguro', 'asiste') NULL DEFAULT NULL AFTER `asistio`;

ALTER TABLE `publicacion_ctn` 
CHANGE COLUMN `visitas_carta_descriptiva` `visitas_carta_descriptiva` INT(10) NOT NULL DEFAULT 0 COMMENT 'almacena el valor de los click que se le dan a las cartas descriptivas de la publicacion' ;

ALTER TABLE `alumno` 
ADD COLUMN `trabaja_empresa` ENUM('si', 'no') NULL DEFAULT NULL AFTER `update_datos`;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
CHANGE COLUMN `semaforo_asistencia` `semaforo_asistencia` ENUM('no_asiste', 'no_seguro', 'asiste') NULL DEFAULT NULL COMMENT 'para almacenar el semaforo de la asistencia de los alumno por confirmacion telefonica' ;


ALTER TABLE `publicacion_ctn` 
ADD COLUMN `publicacion_empresa_masiva` ENUM('si', 'no') NOT NULL DEFAULT 'no' COMMENT 'almancena si la publicacion es orientado para una carga masiva para una empresa que registrara sus alumnos' AFTER `visitas_carta_descriptiva`;

CREATE TABLE IF NOT EXISTS `publicacion_ctn_has_empresa_masivo` (
  `id_publicacion_ctn_has_empresa_masivo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rfc` VARCHAR(13) NOT NULL COMMENT 'rfc de la empresa que realizara la incripcion masiva de alumnos',
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_publicacion_ctn_has_empresa_masivo`),
  INDEX `fk_publicacion_ctn_has_empresa_masivo_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  CONSTRAINT `fk_publicacion_ctn_has_empresa_masivo_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `publicacion_ctn_has_empresa_masivo` 
ADD COLUMN `correo` VARCHAR(250) NOT NULL COMMENT 'almancena el correo de la empresa para que se le envie el link para el registro de alumnos al curso publicado' AFTER `rfc`;

ALTER TABLE `publicacion_ctn_has_empresa_masivo` 
ADD COLUMN `fecha_envio_informacion` DATETIME NULL DEFAULT NULL COMMENT 'almacenara la informacion de cuando la empresa acepta haber revisado los datos y verificar que son correctos' AFTER `id_publicacion_ctn`;

ALTER TABLE `publicacion_has_doc_banner` 
CHANGE COLUMN `tipo` `tipo` ENUM('doc', 'img', 'logo_empresa') NOT NULL DEFAULT 'img' ;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
ADD COLUMN `perciento_asistencia` INT(5) NULL DEFAULT NULL AFTER `semaforo_asistencia`,
ADD COLUMN `calificacion_diagnostica` INT(5) NULL DEFAULT NULL AFTER `perciento_asistencia`,
ADD COLUMN `calificacion_final` INT(5) NULL DEFAULT NULL AFTER `calificacion_diagnostica`;

ALTER TABLE `alumno_inscrito_ctn_publicado` 
CHANGE COLUMN `calificacion_diagnostica` `calificacion_diagnostica` DECIMAL(5,2) NULL DEFAULT NULL ,
CHANGE COLUMN `calificacion_final` `calificacion_final` DECIMAL(5,2) NULL DEFAULT NULL ;

/* por ejecutar en pruebas */

CREATE TABLE IF NOT EXISTS `pregunta_encuesta_satisfaccion` (
  `id_pregunta_encuesta_satisfaccion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id_pregunta_encuesta_satisfaccion`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `opcion_encuesta_satisfaccion` (
  `id_opcion_encuesta_satisfaccion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `opcion` VARCHAR(1500) NOT NULL,
  `id_pregunta_encuesta_satisfaccion` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_opcion_encuesta_satisfaccion`),
  INDEX `fk_opcion_encuesta_satisfaccion_pregunta_encuesta_satisfacc_idx` (`id_pregunta_encuesta_satisfaccion` ASC) , 
  CONSTRAINT `fk_opcion_encuesta_satisfaccion_pregunta_encuesta_satisfaccion1`
    FOREIGN KEY (`id_pregunta_encuesta_satisfaccion`)
    REFERENCES `pregunta_encuesta_satisfaccion` (`id_pregunta_encuesta_satisfaccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `encuesta_satisfaccion` (
  `id_encuesta_satisfaccion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `respuesta` VARCHAR(1500) NULL DEFAULT 0,
  `id_opcion_encuesta_satisfaccion` INT(10) UNSIGNED NOT NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_instructor_asignado_curso_publicado` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_encuesta_satisfaccion`),
  INDEX `fk_encuesta_satisfaccion_opcion_encuesta_satisfaccion1_idx` (`id_opcion_encuesta_satisfaccion` ASC) ,
  INDEX `fk_encuesta_satisfaccion_alumno_inscrito_ctn_publicado1_idx` (`id_alumno_inscrito_ctn_publicado` ASC) ,
  INDEX `fk_encuesta_satisfaccion_instructor_asignado_curso_publicad_idx` (`id_instructor_asignado_curso_publicado` ASC) ,
  CONSTRAINT `fk_encuesta_satisfaccion_opcion_encuesta_satisfaccion1`
    FOREIGN KEY (`id_opcion_encuesta_satisfaccion`)
    REFERENCES `opcion_encuesta_satisfaccion` (`id_opcion_encuesta_satisfaccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_encuesta_satisfaccion_alumno_inscrito_ctn_publicado1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_encuesta_satisfaccion_instructor_asignado_curso_publicado1`
    FOREIGN KEY (`id_instructor_asignado_curso_publicado`)
    REFERENCES `instructor_asignado_curso_publicado` (`id_instructor_asignado_curso_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


INSERT INTO `pregunta_encuesta_satisfaccion` (`id_pregunta_encuesta_satisfaccion`, `pregunta`) VALUES 
(1, 'El curso sirve para mejorar mi desempeño laboral'),
(2, 'El curso es de utilidad para mi vida personal'),
(3, 'El curso me ayudará a ser más productivo'),
(4, 'El curso me ayudará a realizar mi trabajo con mayor seguridad'),
(5, 'El curso cumplió con los objetivos de la empresa'),
(6, 'El curso cumplió con mis expectativas personales'),
(7, 'La duración de los temas es'),
(8, 'Su aula le pareció'),
(9, 'El dominio del instructor en el tema impartido es'),
(10, 'La comunicación y actitud del instructor es'),
(11, 'Considero que el siguiente curso debe ser sobre:');

INSERT INTO `opcion_encuesta_satisfaccion` (`id_opcion_encuesta_satisfaccion`,`opcion`,`id_pregunta_encuesta_satisfaccion`) VALUES
(1,'Muy bien',1),(2,'Bien',1),(3,'Regular',1),(4,'Mal',1),(5,'Deficiente',1),
(6,'Muy bien',2),(7,'Bien',2),(8,'Regular',2),(9,'Mal',2),(10,'Deficiente',2),
(11,'Muy bien',3),(12,'Bien',3),(13,'Regular',3),(14,'Mal',3),(15,'Deficiente',3),
(16,'Muy bien',4),(17,'Bien',4),(18,'Regular',4),(19,'Mal',4),(20,'Deficiente',4),
(21,'Muy bien',5),(22,'Bien',5),(23,'Regular',5),(24,'Mal',5),(25,'Deficiente',5),
(26,'Muy bien',6),(27,'Bien',6),(28,'Regular',6),(29,'Mal',6),(30,'Deficiente',6),
(31,'Muy bien',7),(32,'Bien',7),(33,'Regular',7),(34,'Mal',7),(35,'Deficiente',7),
(36,'Muy bien',8),(37,'Bien',8),(38,'Regular',8),(39,'Mal',8),(40,'Deficiente',8),
(41,'Muy bien',9),(42,'Bien',9),(43,'Regular',9),(44,'Mal',9),(45,'Deficiente',9),
(46,'Muy bien',10),(47,'Bien',10),(48,'Regular',10),(49,'Mal',10),(50,'Deficiente',10),
(51,'Mejorar la Producción, la Calidad y las Buenas Prácticas',11),
(52,'Mejora del ambiente Laboral',11),
(53,'Mantenimiento y Reparación',11),
(54,'Seguridad e Higiene',11),
(55,'Comunicación, Liderazgo y Trabajo en Equipo',11),
(56,'Uso de las Tecnologías de la Información, Comunicación y Computación',11),
(57,'Participación Social',11),
(58,'Bienestar Emocional y Desarrollo Humano',11);

/* por ejecutar en pruebas */
INSERT INTO `catalogo_constancia` (`id_catalogo_constancia`, `nombre`, `descripcion`) VALUES ('3', 'Constancia FDH', 'Constancia de Civika FDH');

DROP TABLE IF EXISTS `respuesta_evaluacion` ;

DROP TABLE IF EXISTS `pregunta_ctn` ;

DROP TABLE IF EXISTS `opcion_pregunta_ctn` ;

DROP TABLE IF EXISTS `evaluacion_ctn` ;

CREATE TABLE IF NOT EXISTS `evaluacion_publicacion_ctn` (
  `id_evaluacion_publicacion_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `disponible_alumnos` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `fecha_creacion` DATETIME NOT NULL,
  `fecha_publicacion_alumno` DATETIME NULL DEFAULT NULL,
  `tiempo_evaluacion` INT(5) NULL DEFAULT NULL COMMENT 'si presenta un valor se almacenara el tiempo en minutos para poder realizar la evaluacion por parte del alumno',
  `intentos_evaluacion` INT(3) NULL DEFAULT NULL COMMENT 'almacenara si hay intentos por parte del alumno para realizar la evaluacion \nsi no tiene dato se considera que tiene intentos sin limite',
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_evaluacion_publicacion_ctn`),
  INDEX `fk_evaluacion_publicacion_ctn_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC) ,
  CONSTRAINT `fk_evaluacion_publicacion_ctn_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `pregunta_publicacion_ctn` (
  `id_pregunta_publicacion_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` TEXT NOT NULL,
  `id_opciones_pregunta` INT(5) UNSIGNED NOT NULL,
  `id_evaluacion_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_pregunta_publicacion_ctn`),
  INDEX `fk_pregunta_publicacion_ctn_catalogo_tipo_opciones_pregunta_idx` (`id_opciones_pregunta` ASC) ,
  INDEX `fk_pregunta_publicacion_ctn_evaluacion_publicacion_ctn1_idx` (`id_evaluacion_publicacion_ctn` ASC) ,
  CONSTRAINT `fk_pregunta_publicacion_ctn_catalogo_tipo_opciones_pregunta1`
    FOREIGN KEY (`id_opciones_pregunta`)
    REFERENCES `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pregunta_publicacion_ctn_evaluacion_publicacion_ctn1`
    FOREIGN KEY (`id_evaluacion_publicacion_ctn`)
    REFERENCES `evaluacion_publicacion_ctn` (`id_evaluacion_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `opcion_pregunta_publicacion_ctn` (
  `id_opcion_pregunta_publicacion_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NULL,
  `tipo_respuesta` ENUM('correcta', 'incorrecta') NULL DEFAULT NULL,
  `id_pregunta_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_opcion_pregunta_publicacion_ctn`),
  INDEX `fk_opcion_pregunta_publicacion_ctn_documento1_idx` (`id_documento` ASC) ,
  INDEX `fk_opcion_pregunta_publicacion_ctn_pregunta_publicacion_ctn_idx` (`id_pregunta_publicacion_ctn` ASC) ,
  CONSTRAINT `fk_opcion_pregunta_publicacion_ctn_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opcion_pregunta_publicacion_ctn_pregunta_publicacion_ctn1`
    FOREIGN KEY (`id_pregunta_publicacion_ctn`)
    REFERENCES `pregunta_publicacion_ctn` (`id_pregunta_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `evaluacion_alumno_publicacion_ctn` (
  `id_evaluacion_alumno_publicacion_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATETIME NOT NULL,
  `fecha_envio` DATETIME NULL DEFAULT NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_evaluacion_alumno_publicacion_ctn`),
  INDEX `fk_evaluacion_alumno_publicacion_ctn_alumno_inscrito_ctn_pu_idx` (`id_alumno_inscrito_ctn_publicado` ASC) ,
  CONSTRAINT `fk_evaluacion_alumno_publicacion_ctn_alumno_inscrito_ctn_publ1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `respuesta_alumno_evaluacion` (
  `id_respuesta_alumno_evaluacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_evaluacion_alumno_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_pregunta_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_opcion_pregunta_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_respuesta_alumno_evaluacion`),
  INDEX `fk_respuesta_alumno_evaluacion_evaluacion_alumno_publicacio_idx` (`id_evaluacion_alumno_publicacion_ctn` ASC) ,
  INDEX `fk_respuesta_alumno_evaluacion_pregunta_publicacion_ctn1_idx` (`id_pregunta_publicacion_ctn` ASC) ,
  INDEX `fk_respuesta_alumno_evaluacion_opcion_pregunta_publicacion__idx` (`id_opcion_pregunta_publicacion_ctn` ASC) ,
  CONSTRAINT `fk_respuesta_alumno_evaluacion_evaluacion_alumno_publicacion_1`
    FOREIGN KEY (`id_evaluacion_alumno_publicacion_ctn`)
    REFERENCES `evaluacion_alumno_publicacion_ctn` (`id_evaluacion_alumno_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_alumno_evaluacion_pregunta_publicacion_ctn1`
    FOREIGN KEY (`id_pregunta_publicacion_ctn`)
    REFERENCES `pregunta_publicacion_ctn` (`id_pregunta_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_alumno_evaluacion_opcion_pregunta_publicacion_ctn1`
    FOREIGN KEY (`id_opcion_pregunta_publicacion_ctn`)
    REFERENCES `opcion_pregunta_publicacion_ctn` (`id_opcion_pregunta_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (4, 'Imágenes (única opción)');
INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (5, 'Imágenes (opción multiple)');

ALTER TABLE `curso_taller_norma`
ADD COLUMN `mostrar_banner` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `descripcion_cancelacion`;

CREATE TABLE IF NOT EXISTS `catalogo_tipo_cdc` (
  `id_catalogo_tipo_cdc` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id_catalogo_tipo_cdc`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `instructor_preparacion_academica` (
  `id_instructor_preparacion_academica` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `profesion_carrera` VARCHAR(500) NOT NULL,
  `institucion_academica` VARCHAR(500) NOT NULL,
  `fecha_termino` DATE NOT NULL,
  `id_instructor` INT(10) UNSIGNED NOT NULL,
  `id_catalogo_titulo_academico` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_instructor_preparacion_academica`),
  INDEX `fk_instructor_preparacion_academica_instructor1_idx` (`id_instructor` ASC) ,
  INDEX `fk_instructor_preparacion_academica_catalogo_titulo_academi_idx` (`id_catalogo_titulo_academico` ASC) ,
  CONSTRAINT `fk_instructor_preparacion_academica_instructor1`
    FOREIGN KEY (`id_instructor`)
    REFERENCES `instructor` (`id_instructor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instructor_preparacion_academica_catalogo_titulo_academico1`
    FOREIGN KEY (`id_catalogo_titulo_academico`)
    REFERENCES `catalogo_titulo_academico` (`id_catalogo_titulo_academico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `instructor_certificacion_diplomado_curso` (
  `id_instructor_certificacion_diplomado_curso` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(1500) NOT NULL,
  `institucion` VARCHAR(1500) NOT NULL,
  `fecha_finalizacion` DATE NOT NULL,
  `id_instructor` INT(10) UNSIGNED NOT NULL,
  `id_catalogo_tipo_cdc` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_instructor_certificacion_diplomado_curso`),
  INDEX `fk_instructor_certificacion_diplomado_curso_instructor1_idx` (`id_instructor` ASC) ,
  INDEX `fk_instructor_certificacion_diplomado_curso_catalogo_tipo_c_idx` (`id_catalogo_tipo_cdc` ASC) ,
  CONSTRAINT `fk_instructor_certificacion_diplomado_curso_instructor1`
    FOREIGN KEY (`id_instructor`)
    REFERENCES `instructor` (`id_instructor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instructor_certificacion_diplomado_curso_catalogo_tipo_cdc1`
    FOREIGN KEY (`id_catalogo_tipo_cdc`)
    REFERENCES `catalogo_tipo_cdc` (`id_catalogo_tipo_cdc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `instructor_experiencia_laboral` (
  `id_instructor_experiencia_laboral` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `puesto_trabajo` VARCHAR(500) NOT NULL,
  `empresa` VARCHAR(1500) NOT NULL,
  `fecha_ingreso` DATE NOT NULL,
  `fecha_termino` DATE NULL DEFAULT NULL,
  `id_instructor` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_instructor_experiencia_laboral`),
  INDEX `fk_instructor_experiencia_laboral_instructor1_idx` (`id_instructor` ASC) ,
  CONSTRAINT `fk_instructor_experiencia_laboral_instructor1`
    FOREIGN KEY (`id_instructor`)
    REFERENCES `instructor` (`id_instructor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `catalogo_titulo_academico` (`abreviatura`, `titulo`) VALUES ('TSU', 'Técnico Superior Universitario');
INSERT INTO `catalogo_titulo_academico` (`abreviatura`, `titulo`) VALUES (' ', 'Carrera Técnica');

ALTER TABLE `catalogo_titulo_academico` 
ADD COLUMN `orden_catalogo` INT(5) NOT NULL AFTER `titulo`;

UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='2' WHERE  `id_catalogo_titulo_academico`=8;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='3' WHERE  `id_catalogo_titulo_academico`=7;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='1' WHERE  `id_catalogo_titulo_academico`=6;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='4' WHERE  `id_catalogo_titulo_academico`=1;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='5' WHERE  `id_catalogo_titulo_academico`=2;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='6' WHERE  `id_catalogo_titulo_academico`=3;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='7' WHERE  `id_catalogo_titulo_academico`=4;
UPDATE `catalogo_titulo_academico` SET `orden_catalogo`='8' WHERE  `id_catalogo_titulo_academico`=5;

ALTER TABLE `curso_taller_norma`
ADD COLUMN `temario` TEXT NULL DEFAULT NULL AFTER `mostrar_banner`;

INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (6, 'Secuenciales');
INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (7, 'Relacionales');

ALTER TABLE `opcion_pregunta_publicacion_ctn` 
ADD COLUMN `consecutivo` INT(10) NULL DEFAULT NULL COMMENT 'almacenara el consecutivo de las preguntas para la opcion 6 del catalgo de tipo de pregunta' AFTER `tipo_respuesta`,
ADD COLUMN `orden_pregunta` INT(10) NULL DEFAULT NULL AFTER `id_documento`,
CHANGE COLUMN `descripcion` `descripcion` TEXT NOT NULL ;

ALTER TABLE `opcion_pregunta_publicacion_ctn` 
ADD COLUMN `pregunta_relacional` ENUM('izquierda', 'derecha') NULL DEFAULT NULL COMMENT 'almacenara si la pregunta es izquierda o derecha' AFTER `orden_pregunta`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `aplica_evaluacion` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `publicacion_empresa_masiva`;

CREATE TABLE IF NOT EXISTS `catalogo_proceso_cotizacion` (
  `id_catalogo_proceso_cotizacion` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_catalogo_proceso_cotizacion`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (1, 'Realizada');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (2, 'Enviada');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (3, 'Recibida');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (4, 'Aceptada y publicación del curso');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (5, 'Registro de alumnos por la empresa');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (6, 'En espera de impartición del curso');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (7, 'Finalizada');
INSERT INTO `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`, `nombre`) VALUES (8, 'Cerrada (No aceptada)');


CREATE TABLE IF NOT EXISTS `cotizacion` (
  `id_cotizacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `folio_cotizacion` VARCHAR(25) NOT NULL,
  `fecha_cotizacion` DATETIME NOT NULL,
  `fecha_envio` DATETIME NULL DEFAULT NULL,
  `fecha_recepcion` DATETIME NULL DEFAULT NULL,
  `fecha_orden_compra` VARCHAR(45) NULL DEFAULT NULL,
  `persona_recibe` VARCHAR(250) NOT NULL,
  `empresa` VARCHAR(500) NOT NULL,
  `correo` VARCHAR(250) NOT NULL,
  `temario` TEXT NOT NULL,
  `participantes` INT(5) NOT NULL,
  `duracion` INT(5) NOT NULL,
  `costo_hora` DECIMAL(10,2) NOT NULL,
  `fecha_fin_vigencia` DATE NOT NULL,
  `notas_comerciales` TEXT NOT NULL,
  `iva` INT(3) NULL DEFAULT NULL,
  `folio_orden_compra` VARCHAR(150) NULL DEFAULT NULL,
  `id_catalogo_proceso_cotizacion` INT(5) UNSIGNED NOT NULL,
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL,
  `id_publicacion_ctn` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_documento_factura_xml` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_documento_factura_pdf` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_cotizacion`),
  INDEX `fk_cotizacion_catalogo_proceso_cotizacion1_idx` (`id_catalogo_proceso_cotizacion` ASC) ,
  INDEX `fk_cotizacion_curso_taller_norma1_idx` (`id_curso_taller_norma` ASC) ,
  INDEX `fk_cotizacion_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC) ,
  INDEX `fk_cotizacion_documento1_idx` (`id_documento_factura_xml` ASC) ,
  INDEX `fk_cotizacion_documento2_idx` (`id_documento_factura_pdf` ASC) ,
  CONSTRAINT `fk_cotizacion_catalogo_proceso_cotizacion1`
    FOREIGN KEY (`id_catalogo_proceso_cotizacion`)
    REFERENCES `catalogo_proceso_cotizacion` (`id_catalogo_proceso_cotizacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_curso_taller_norma1`
    FOREIGN KEY (`id_curso_taller_norma`)
    REFERENCES `curso_taller_norma` (`id_curso_taller_norma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_documento1`
    FOREIGN KEY (`id_documento_factura_xml`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cotizacion_documento2`
    FOREIGN KEY (`id_documento_factura_pdf`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
  
  
ALTER TABLE `datos_fiscales` 
CHANGE COLUMN `id_alumno_inscrito_ctn_publicado` `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'referencia de los datos fiscales que requieren factura',
ADD COLUMN `id_cotizacion` INT(10) UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `datos_fiscales` 
ADD CONSTRAINT `fk_datos_fiscales_cotizacion1`
  FOREIGN KEY (`id_cotizacion`)
  REFERENCES `cotizacion` (`id_cotizacion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `curso_taller_norma` 
ADD COLUMN `duracion` INT(5) NULL DEFAULT NULL COMMENT 'la duracion posible del curso' AFTER `temario`,
ADD COLUMN `instructor` VARCHAR(45) NULL DEFAULT NULL COMMENT 'el(los) instructor(es)' AFTER `duracion`,
CHANGE COLUMN `objetivo` `objetivo` TEXT NULL DEFAULT NULL COMMENT 'describe el objetivo general del curso';

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `objetivo` TEXT NULL DEFAULT NULL COMMENT 'es el objetivo del curso' AFTER `aplica_evaluacion`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `descripcion` TEXT NULL DEFAULT NULL COMMENT 'es la descripcion de la publicacion (estaba anteriormente en la tabla de curso taller norma)' AFTER `objetivo`;


ALTER TABLE `publicacion_ctn` 
ADD COLUMN `id_sede_presencial` INT(10) UNSIGNED NULL AFTER `descripcion`,
ADD INDEX `fk_publicacion_ctn_sede_presencial1_idx` (`id_sede_presencial` ASC) ;


CREATE TABLE IF NOT EXISTS `sede_presencial` (
  `id_sede_presencial` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  `direccion` TEXT NOT NULL,
  `link_mapa` VARCHAR(1500) NOT NULL,
  `telefono_principal` VARCHAR(80) NOT NULL,
  `entrada_libre` TEXT NOT NULL,
  `descuento_descripcion` TEXT NOT NULL,
  PRIMARY KEY (`id_sede_presencial`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE `informe_sede` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_sede_presencial` int(10) unsigned NOT NULL,
  KEY `fk_informe_sede_usuario1_idx` (`id_usuario`),
  KEY `fk_informe_sede_sede_presencial1_idx` (`id_sede_presencial`),
  CONSTRAINT `fk_informe_sede_sede_presencial1` FOREIGN KEY (`id_sede_presencial`) REFERENCES `sede_presencial` (`id_sede_presencial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_informe_sede_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `publicacion_ctn` 
ADD CONSTRAINT `fk_publicacion_ctn_sede_presencial1`
  FOREIGN KEY (`id_sede_presencial`)
  REFERENCES `sede_presencial` (`id_sede_presencial`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  
INSERT INTO `sede_presencial` (`id_sede_presencial`, `nombre`, `link_mapa`, `telefono_principal`, `entrada_libre`, `descuento_descripcion`) VALUES (1, 'Apizaco - TLX', 'https://goo.gl/maps/85uSKcEWWcE2', '2414177565', '•	Personas con Discapacidad (Presentar documento oficial que acredite su tipo y/o nivel de discapacidad)', '20% :');
INSERT INTO `sede_presencial` (`id_sede_presencial`, `nombre`, `link_mapa`, `telefono_principal`, `entrada_libre`, `descuento_descripcion`) VALUES (2, 'Cholula - PUE', 'https://goo.gl/maps/yKSvvEd3eqn', '2222279388', '•	Personas con Discapacidad (Presentar documento oficial que acredite su tipo y/o nivel de discapacidad)', '20% :');


CREATE TABLE `curso_taller_norma_has_instructores` (
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL,
  `id_instructor` INT(10) UNSIGNED NOT NULL,
  INDEX `ctn_has_inst_to_ctn_idx` (`id_curso_taller_norma` ASC),
  INDEX `ctn_has_inst_to_instructor_idx` (`id_instructor` ASC),
  CONSTRAINT `ctn_has_inst_to_ctn`
    FOREIGN KEY (`id_curso_taller_norma`)
    REFERENCES `curso_taller_norma` (`id_curso_taller_norma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ctn_has_inst_to_instructor`
    FOREIGN KEY (`id_instructor`)
    REFERENCES `instructor` (`id_instructor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


ALTER TABLE `publicacion_ctn` 
ADD COLUMN `adicionales` TEXT NULL AFTER `id_sede_presencial`;

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `duracion_constancia` DECIMAL(6,2) NULL AFTER `adicionales`;


ALTER TABLE `respuesta_alumno_evaluacion` 
ADD COLUMN `orden_relacion_respuesta` INT(10) NULL DEFAULT NULL AFTER `id_evaluacion_alumno_publicacion_ctn`;

CREATE TABLE IF NOT EXISTS `catalogo_tipo_publicacion` (
  `id_catalogo_tipo_publicacion` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id_catalogo_tipo_publicacion`))
ENGINE = InnoDB;

INSERT INTO `catalogo_tipo_publicacion` (`id_catalogo_tipo_publicacion`, `nombre`) VALUES (1, 'Curso presencial');
INSERT INTO `catalogo_tipo_publicacion` (`id_catalogo_tipo_publicacion`, `nombre`) VALUES (2, 'Curso a empresa');
INSERT INTO `catalogo_tipo_publicacion` (`id_catalogo_tipo_publicacion`, `nombre`) VALUES (3, 'Curso online');
INSERT INTO `catalogo_tipo_publicacion` (`id_catalogo_tipo_publicacion`, `nombre`) VALUES (4, 'Evaluación online');

ALTER TABLE `publicacion_ctn` 
ADD COLUMN `id_catalogo_tipo_publicacion` INT(3) UNSIGNED NULL AFTER `duracion_constancia`,
ADD INDEX `publi_ctn_cat_tipo_publi_idx` (`id_catalogo_tipo_publicacion` ASC);

ALTER TABLE `publicacion_ctn` 
ADD CONSTRAINT `publi_ctn_cat_tipo_publi`
  FOREIGN KEY (`id_catalogo_tipo_publicacion`)
  REFERENCES `catalogo_tipo_publicacion` (`id_catalogo_tipo_publicacion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

