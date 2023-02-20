CREATE TABLE IF NOT EXISTS `cat_metodo_pago` (
  `id_cat_metodo_pago` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_payment` VARCHAR(250) NOT NULL,
  `activo_produccion` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `descripcion` TEXT NULL,
  `id_documento_logo` INT(10) UNSIGNED NULL,
  `cat_metodo_pagocol` VARCHAR(45) NULL,
  PRIMARY KEY (`id_cat_metodo_pago`),
  INDEX `cat_metodo_pago_has_document_logo_idx` (`id_documento_logo` ASC),
  CONSTRAINT `cat_metodo_pago_has_document_logo`
    FOREIGN KEY (`id_documento_logo`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ms_pago_online` (
  `id_ms_pago_online` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_payment` INT(10) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `status_detail` TEXT NOT NULL,
  `date_approved` DATETIME NULL,
  `payment_method_id` VARCHAR(45) NOT NULL,
  `payment_type_id` VARCHAR(250) NOT NULL,
  `transaction_amount` DECIMAL(10,2) NOT NULL,
  `installments` INT(2) NOT NULL,
  PRIMARY KEY (`id_ms_pago_online`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `cat_estatus_metodo_pago_detalle` (
  `id_cat_estatus_metodo_pago_detalle` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(1000) NOT NULL,
  `key_payment` VARCHAR(60) NOT NULL,
  `key_status_detail` VARCHAR(100) NOT NULL,
  `id_cat_metodo_pago` INT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_cat_estatus_metodo_pago_detalle`),
  INDEX `fk_cat_estatus_metodo_pago_detalle_cat_metodo_pago1_idx` (`id_cat_metodo_pago` ASC),
  CONSTRAINT `fk_cat_estatus_metodo_pago_detalle_cat_metodo_pago1`
    FOREIGN KEY (`id_cat_metodo_pago`)
    REFERENCES `cat_metodo_pago` (`id_cat_metodo_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `det_alumno_pago_curso` (
  `id_ms_pago_online` INT(10) UNSIGNED NOT NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL,
  INDEX `fk_det_alumno_pago_curso_ms_pago_online1_idx` (`id_ms_pago_online` ASC),
  INDEX `fk_det_alumno_pago_curso_alumno_inscrito_ctn_publicado1_idx` (`id_alumno_inscrito_ctn_publicado` ASC),
  CONSTRAINT `fk_det_alumno_pago_curso_ms_pago_online1`
    FOREIGN KEY (`id_ms_pago_online`)
    REFERENCES `ms_pago_online` (`id_ms_pago_online`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_det_alumno_pago_curso_alumno_inscrito_ctn_publicado1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


INSERT INTO `cat_metodo_pago` (`id_cat_metodo_pago`, `nombre_payment`, `activo_produccion`, `descripcion`, `id_documento_logo`, `cat_metodo_pagocol`) VALUES (1, 'Mercado Pago', 'no', 'Pago con tarjeta de crédito y débito con Mercado Pago', NULL, NULL);

INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (1, 'Perfecto!, Se acredito tu pago satisfactoriamente', 'MERCADO_PAGO', 'accredited', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (2, 'Estamos procesando el pago, En menos de 2 días habilies te enviaremos por e-mail el resultado', 'MERCADO_PAGO', 'pending_contingency', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (3, 'Estamos procesando el pago, En menos de 2 días habilies te enviaremos por e-mail el resultado', 'MERCADO_PAGO', 'pending_review_manual', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (4, 'Revisa el numero de la tarjeta', 'MERCADO_PAGO', 'cc_rejected_bad_filled_card_number', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (5, 'Revisa la fecha de vencimiento de la tarjeta', 'MERCADO_PAGO', 'cc_rejected_bad_filled_date', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (6, 'Revisa los datos completos de la tarjeta', 'MERCADO_PAGO', 'cc_rejected_bad_filled_other', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (7, 'Revisa el codigo de seguridad de la tarjeta', 'MERCADO_PAGO', 'cc_rejected_bad_filled_security_code', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (8, 'No pudimos procesar el pago con tu tarjeta, verifica e intentalo nuevamente', 'MERCADO_PAGO', 'cc_rejected_blacklist', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (9, 'No pudimos procesar el pago, se necesita verificación para el monto y no pudimos procesarlo', 'MERCADO_PAGO', 'cc_rejected_call_for_authorize', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (10, 'Tarjeta inactiva. Llama a tu banco para activarla y sigue el procedimiento de activación', 'MERCADO_PAGO', 'cc_rejected_card_disabled', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (11, 'No pudimos procesar tu pago, verifica los datos de la tarjeta e intenta nuevamente', 'MERCADO_PAGO', 'cc_rejected_card_error', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (12, 'Ya hiciste un pago por esta compra. Si necesitas comprar nuevamente, ingresa otra tarjeta', 'MERCADO_PAGO', 'cc_rejected_duplicated_payment', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (13, 'Tu pago fue rechazado, intenta con otra tarjeta e intenta nuevamente', 'MERCADO_PAGO', 'cc_rejected_high_risk', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (14, 'Tu tarjeta no tiene fondos suficientes para la operación', 'MERCADO_PAGO', 'cc_rejected_insufficient_amount', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (15, 'La tarjeta ingresada no procesa pagos a meses o cuotas de pago', 'MERCADO_PAGO', 'cc_rejected_invalid_installments', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (16, 'Llegaste al límite de intentos permitidos. Elige otra tarjeta u otro medio de pago', 'MERCADO_PAGO', 'cc_rejected_max_attempts', 1);
INSERT INTO `cat_estatus_metodo_pago_detalle` (`id_cat_estatus_metodo_pago_detalle`, `descripcion`, `key_payment`, `key_status_detail`, `id_cat_metodo_pago`) VALUES (17, 'La tarjeta no pudo procesar el pago', 'MERCADO_PAGO', 'cc_rejected_other_reason', 1);


INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`,`descripcion`) VALUES (6,'Inscrito cupo lleno');