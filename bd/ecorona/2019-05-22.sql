DROP TABLE IF EXISTS `config_correo`;
CREATE TABLE IF NOT EXISTS `config_correo` (
  `id_config_correo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `protocol` VARCHAR(45) NOT NULL,
  `smtp_host` VARCHAR(500) NOT NULL,
  `smtp_user` VARCHAR(500) NOT NULL,
  `smtp_pass` VARCHAR(500) NOT NULL,
  `smtp_port` VARCHAR(25) NOT NULL,
  `charset` VARCHAR(100) NOT NULL,
  `mailtype` VARCHAR(45) NOT NULL,
  `newline` VARCHAR(45) NOT NULL,
  `active` ENUM('si', 'no') NOT NULL,
  PRIMARY KEY (`id_config_correo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `config_correo` (`id_config_correo`, `protocol`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `charset`, `mailtype`,`newline`, `active`) VALUES (1, 'smtp', 'us3.smtp.mailhostbox.com', 'sistemas@civika.edu.mx', 'HCD*fIG9', '587', 'utf-8', 'html','', 'si');
INSERT INTO `config_correo` (`id_config_correo`, `protocol`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `charset`, `mailtype`,`newline`, `active`) VALUES (2, 'smtp', 'ssl://smtp.gmail.com', 'infocivika@gmail.com', 'avg10c127716y', '465', 'utf-8', 'html','\r\n', 'no');
