ALTER TABLE `usuario` 
ADD COLUMN `suscripcion_correo` ENUM('si','no') NOT NULL DEFAULT 'si' AFTER `tipo_usuario`;
