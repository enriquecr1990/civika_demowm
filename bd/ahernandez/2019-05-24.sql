ALTER TABLE `catalogo_formas_pago`
	ADD COLUMN `titulo_pago` VARCHAR(1500) NULL AFTER `descripcion_pago_externo`;

ALTER TABLE `catalogo_formas_pago`
	CHANGE COLUMN `titular` `titular` VARCHAR(250) NULL COMMENT 'titular de la cuenta' AFTER `banco`;