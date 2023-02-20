CREATE TABLE IF NOT EXISTS `alumno_publicacion_ctn_has_material` (
  `id_alumno_publicacion_ctn_has_material` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(500) NOT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `tipo_evidencia` INT(1) NOT NULL DEFAULT 1 COMMENT 'tipo de evidencia \n1 = material en archivo\n2 = video online o url del video almacenado en drive',
  `url_video` VARCHAR(500) NULL DEFAULT NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_alumno_publicacion_ctn_has_material`),
  INDEX `fk_alumno_publicacion_ctn_has_material_documento1_idx` (`id_documento` ASC),
  INDEX `fk_alumno_publicacion_ctn_has_material_alumno_inscrito_ctn__idx` (`id_alumno_inscrito_ctn_publicado` ASC),
  CONSTRAINT `fk_alumno_publicacion_ctn_has_material_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_publicacion_ctn_has_material_alumno_inscrito_ctn_pu1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;