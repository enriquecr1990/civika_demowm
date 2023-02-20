/* 
se ejecuto en pruebas 2019-02-24
se ejecuto en produccion 2019-02-24
 */
CREATE TABLE `crm` (
  `id_crm` INT(10) NOT NULL AUTO_INCREMENT,
  `id_alumno` INT(10) UNSIGNED NOT NULL,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `flag` ENUM('Si', 'No') NULL,
  `descripcion` VARCHAR(200) NULL,
  PRIMARY KEY (`id_crm`),
  INDEX `id_alumno_idx` (`id_alumno` ASC),
  INDEX `id_publicacion_ctn_idx` (`id_publicacion_ctn` ASC),
  CONSTRAINT `id_alumno`
    FOREIGN KEY (`id_alumno`)
    REFERENCES `alumno` (`id_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `id_publicacion_ctn`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_spanish_ci;

