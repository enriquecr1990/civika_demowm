CREATE TABLE `civika_ped`.`estandar_competencia_convocatoria` (
  `id_estandar_competencia_convocatoria` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT UNSIGNED NOT NULL,
  `titulo` VARCHAR(250) NOT NULL,
  `programacion_inicio` DATE NOT NULL,
  `programacion_fin` DATE NOT NULL,
  `alineacion_inicio` DATE NOT NULL,
  `alineacion_fin` DATE NOT NULL,
  `evaluacion_inicio` DATE NOT NULL,
  `evaluacion_fin` DATE NOT NULL,
  `certificado_inicio` DATE NOT NULL,
  `certificado_fin` DATE NOT NULL,
  `proposito` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `id_cat_sector_ec` SMALLINT(3) UNSIGNED NOT NULL,
  `sector_descripcion` TEXT NOT NULL,
  `perfil` TEXT NOT NULL,
  `duracion_descripcion` TEXT NOT NULL,
  `costo_alineacion` DECIMAL(8,2) NOT NULL,
  `costo_evaluacion` DECIMAL(8,2) NOT NULL,
  `costo_certificado` DECIMAL(8,2) NOT NULL,
  `costo` DECIMAL(8,2) NOT NULL,
  `publicada` ENUM('si', 'no') NOT NULL DEFAULT 'no' ,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no' ,
  PRIMARY KEY (`id_estandar_competencia_convocatoria`),
  INDEX `ec_convocatoria_estandar_competencia_idx` (`id_estandar_competencia` ASC) VISIBLE,
  INDEX `ec_convocatoria_cat_sector_idx` (`id_cat_sector_ec` ASC) VISIBLE,
  CONSTRAINT `ec_convocatoria_estandar_competencia`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `civika_ped`.`estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ec_convocatoria_cat_sector`
    FOREIGN KEY (`id_cat_sector_ec`)
    REFERENCES `civika_ped`.`cat_sector_ec` (`id_cat_sector_ec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION) ENGINE=InnoDB;
