ALTER TABLE `alumno_publicacion_ctn_has_material` 
ADD COLUMN `comentario_instructor` TEXT NULL AFTER `id_documento`,
ADD COLUMN `comentario_alumno` TEXT NULL AFTER `comentario_instructor`;
