ALTER TABLE `publicacion_ctn` 
ADD COLUMN `tiene_constancia_externa` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `id_catalogo_tipo_publicacion`;