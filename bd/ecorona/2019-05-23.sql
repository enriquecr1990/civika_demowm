CREATE TABLE IF NOT EXISTS `bitacora_error` (
  `id_bitacora_error` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `controller` VARCHAR(150) NOT NULL,
  `function` VARCHAR(250) NOT NULL,
  `post_usr` TEXT NOT NULL,
  `respose_error` TEXT NOT NULL,
  PRIMARY KEY (`id_bitacora_error`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `admin_paginas` (
  `id_admin_paginas` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` VARCHAR(45) NOT NULL,
  `ruta` VARCHAR(1500) NOT NULL,
  `nombre_pagina` VARCHAR(1500) NOT NULL,
  `activa` ENUM('si', 'no') NOT NULL DEFAULT 'si',
  `eliminada` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id_admin_paginas`))
ENGINE = InnoDB;