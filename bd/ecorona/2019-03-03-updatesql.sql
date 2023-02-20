ALTER TABLE `cursos_civik`.`instructor` 
ADD COLUMN `id_documento_firma` INT(10) UNSIGNED NULL AFTER `experiencia_curricular`,
ADD INDEX `instructo_documento_firma_img_idx` (`id_documento_firma` ASC);
;
ALTER TABLE `cursos_civik`.`instructor` 
ADD CONSTRAINT `instructo_documento_firma_img`
  FOREIGN KEY (`id_documento_firma`)
  REFERENCES `cursos_civik`.`documento` (`id_documento`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
