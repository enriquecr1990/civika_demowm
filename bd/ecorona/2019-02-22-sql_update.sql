/* 
ejecutado en pruebas 2019-02-24
ejecutado en produccion 2019-02-24
 */
ALTER TABLE `evaluacion_publicacion_ctn` 
ADD COLUMN `tipo` ENUM('diagnostica', 'final') NOT NULL DEFAULT 'diagnostica' AFTER `id_publicacion_ctn`;

ALTER TABLE `evaluacion_alumno_publicacion_ctn` 
ADD COLUMN `id_evaluacion_publicacion_ctn` INT(10) UNSIGNED NOT NULL AFTER `id_alumno_inscrito_ctn_publicado`,
ADD INDEX `evaluacion_alumno_eva_publicacion_ctn_idx` (`id_evaluacion_publicacion_ctn` ASC);

ALTER TABLE `evaluacion_alumno_publicacion_ctn` 
ADD CONSTRAINT `evaluacion_alumno_eva_publicacion_ctn`
  FOREIGN KEY (`id_evaluacion_publicacion_ctn`)
  REFERENCES `evaluacion_publicacion_ctn` (`id_evaluacion_publicacion_ctn`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  
ALTER TABLE `publicacion_ctn` 
CHANGE COLUMN `horario` `horario` VARCHAR(250) NULL ,
CHANGE COLUMN `fecha_limite_inscripcion` `fecha_limite_inscripcion` DATETIME NULL ;

CREATE TABLE `evaluacion_online_ctn` (
  `id_evaluacion_online_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `empresa` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `destinatario` varchar(500) NULL,
  `correo_link` TEXT NULL,
  PRIMARY KEY (`id_evaluacion_online_ctn`),
  INDEX `evaluacion_online_publicacion_ctn_idx` (`id_publicacion_ctn` ASC),
  CONSTRAINT `evaluacion_online_publicacion_ctn`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
	
ALTER TABLE `alumno_inscrito_ctn_publicado` 
ADD COLUMN `descargo_vademecum` ENUM('no', 'si') NOT NULL DEFAULT 'no' AFTER `calificacion_final`;
