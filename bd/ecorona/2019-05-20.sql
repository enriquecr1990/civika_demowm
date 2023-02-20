ALTER TABLE `evaluacion_publicacion_ctn` 
ADD COLUMN `titulo_evaluacion` VARCHAR(550) NULL DEFAULT NULL COMMENT 'almacenara el titulo de la evaluación online' AFTER `tipo`;
