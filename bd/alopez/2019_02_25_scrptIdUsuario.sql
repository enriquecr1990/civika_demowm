ALTER TABLE `cursos_civik`.`crm` 
ADD COLUMN `id_usuario` INT(10) UNSIGNED NOT NULL AFTER `descripcion`,
ADD INDEX `id_usuario_idx` (`id_usuario` ASC);
;
ALTER TABLE `cursos_civik`.`crm` 
ADD CONSTRAINT `id_usuario`
  FOREIGN KEY (`id_usuario`)
  REFERENCES `cursos_civik`.`usuario` (`id_usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;