DROP TABLE IF EXISTS `documento` ;

CREATE TABLE IF NOT EXISTS `documento` (
  `id_documento` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `ruta_directorio` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id_documento`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `usuario` ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(120) NOT NULL COMMENT 'Es el usuario del sistema para el logeo',
  `password` VARCHAR(250) NOT NULL DEFAULT '' COMMENT 'Es la contraseña del sistema para el logeo',
  `activo` ENUM('si', 'no') NOT NULL DEFAULT 'si' COMMENT 'define si el usuario se encuentra activo en el sistema',
  `codigo_verificacion` VARCHAR(250) NULL,
  `verificado` ENUM('si', 'no') NOT NULL DEFAULT 'si' COMMENT 'es la verificacion del usuario en el sistema; el codigo de activación se pudo mandar por correo',
  `update_password` INT(7) NOT NULL DEFAULT 0 COMMENT 'almacena si tuvo la actualización de su contraseña',
  `nombre` VARCHAR(150) NULL,
  `apellido_p` VARCHAR(150) NULL,
  `apellido_m` VARCHAR(150) NULL,
  `correo` VARCHAR(250) NULL,
  `telefono` VARCHAR(35) NULL,
  `update_datos` INT(5) UNSIGNED NOT NULL DEFAULT 0,
  `id_documento_perfil` INT(10) UNSIGNED NULL COMMENT 'almacena la foto de perfil del usuario del sistema',
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC),
  INDEX `fk_usuario_documento1_idx` (`id_documento_perfil` ASC),
  CONSTRAINT `fk_usuario_documento1`
    FOREIGN KEY (`id_documento_perfil`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_titulo_academico` ;

CREATE TABLE IF NOT EXISTS `catalogo_titulo_academico` (
  `id_catalogo_titulo_academico` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id del grado academico',
  `abreviatura` VARCHAR(50) NOT NULL,
  `titulo` VARCHAR(100) NOT NULL COMMENT 'descripcion del grado academico',
  PRIMARY KEY (`id_catalogo_titulo_academico`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_ocupacion_especifica` ;

CREATE TABLE IF NOT EXISTS `catalogo_ocupacion_especifica` (
  `id_catalogo_ocupacion_especifica` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave_area_subarea` CHAR(5) NOT NULL COMMENT 'clave del area o subarea',
  `denominacion` VARCHAR(250) NOT NULL COMMENT 'descripcion de la ocupación',
  `id_catalogo_ocupacion_especifica_parent` INT(5) UNSIGNED NULL COMMENT 'id del parent de catalago al que pertenece (area general)',
  PRIMARY KEY (`id_catalogo_ocupacion_especifica`),
  INDEX `fk_catalogo_ocupacion_especifica_catalogo_ocupacion_especif_idx` (`id_catalogo_ocupacion_especifica_parent` ASC),
  UNIQUE INDEX `denominacion_UNIQUE` (`denominacion` ASC),
  CONSTRAINT `fk_catalogo_ocupacion_especifica_catalogo_ocupacion_especifica1`
    FOREIGN KEY (`id_catalogo_ocupacion_especifica_parent`)
    REFERENCES `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `alumno` ;

CREATE TABLE IF NOT EXISTS `alumno` (
  `id_alumno` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curp` VARCHAR(18) NULL COMMENT 'Curp del alumo del CTN',
  `domicilio` VARCHAR(2000) NULL,
  `puesto` VARCHAR(100) NULL COMMENT 'Puesto que desempeña en su lugar de trabajo (si aplica)',
  `profesion` VARCHAR(250) NULL COMMENT 'especifica el tipo de profesionista que seria el alumno',
  `id_usuario` INT(10) UNSIGNED NOT NULL COMMENT 'referencia del usuario que tiene en el sistema',
  `id_catalogo_titulo_academico` INT(5) UNSIGNED NULL COMMENT 'Referencia del titulo academico que tiene el estudiante',
  `id_catalogo_ocupacion_especifica` INT(5) UNSIGNED NULL COMMENT 'referencia del catalogo nacional de ocupacion especifica ',
  `update_datos` INT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_alumno`),
  INDEX `fk_empleado_es_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_alumno_catalogo_titulo_academico1_idx` (`id_catalogo_titulo_academico` ASC),
  INDEX `fk_alumno_catalogo_ocupacion_especifica1_idx` (`id_catalogo_ocupacion_especifica` ASC),
  CONSTRAINT `fk_empleado_es_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_catalogo_titulo_academico1`
    FOREIGN KEY (`id_catalogo_titulo_academico`)
    REFERENCES `catalogo_titulo_academico` (`id_catalogo_titulo_academico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_catalogo_ocupacion_especifica1`
    FOREIGN KEY (`id_catalogo_ocupacion_especifica`)
    REFERENCES `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `empresa_alumno` ;

CREATE TABLE IF NOT EXISTS `empresa_alumno` (
  `id_empresa_alumno` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(500) NULL,
  `rfc` VARCHAR(13) NULL,
  `domicilio` VARCHAR(1500) NULL,
  `telefono` VARCHAR(50) NULL,
  `correo` VARCHAR(250) NULL,
  `representante_legal` VARCHAR(500) NULL COMMENT 'es el nombre del representante legal de la empresa en caso de que tenga uno',
  `representante_trabajadores` VARCHAR(500) NULL COMMENT 'es el nombre del representante de trabajadores de la empresa en caso de que tenga uno',
  `update_datos` INT(10) NOT NULL DEFAULT 0,
  `id_alumno` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_empresa_alumno`),
  INDEX `fk_empresa_alumno1_idx` (`id_alumno` ASC),
  CONSTRAINT `fk_empresa_alumno1`
    FOREIGN KEY (`id_alumno`)
    REFERENCES `alumno` (`id_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_area_tematica` ;

CREATE TABLE IF NOT EXISTS `catalogo_area_tematica` (
  `id_catalogo_area_tematica` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` CHAR(5) NOT NULL COMMENT 'clave del área tematica para los cursos',
  `denominacion` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_catalogo_area_tematica`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `curso_taller_norma` ;

CREATE TABLE IF NOT EXISTS `curso_taller_norma` (
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_catalogo_area_tematica` INT(5) UNSIGNED NOT NULL,
  `nombre` VARCHAR(250) NOT NULL,
  `clave_area_tematica_otra` CHAR(5) NULL COMMENT 'describe la clave del area temitica si no esta en el catalogo',
  `area_tematica_otra` VARCHAR(250) NULL COMMENT 'describe otra area tematica si no esta en el catalogo',
  `tipo` ENUM('curso', 'taller', 'norma') NOT NULL DEFAULT 'curso' COMMENT 'determina si es un curso, un taller o una norma',
  `tipo_aplicacion` ENUM('presencial', 'online') NOT NULL DEFAULT 'presencial' COMMENT 'determina si el curso taller o norma es de forma presencial o en linea',
  `descripcion` TEXT NOT NULL COMMENT 'una descripcion corta del contenido del curso',
  `objetivo` TEXT NOT NULL COMMENT 'describe el objetivo general del curso',
  `orden_norma` INT(3) NULL,
  `id_documento` INT(10) UNSIGNED NULL COMMENT 'referencia del documento promocional para el banner de proximos cursos',
  PRIMARY KEY (`id_curso_taller_norma`),
  INDEX `fk_curso_taller_norma_catalogo_area_tematica1_idx` (`id_catalogo_area_tematica` ASC),
  INDEX `fk_curso_taller_norma_documento1_idx` (`id_documento` ASC),
  CONSTRAINT `fk_curso_taller_norma_catalogo_area_tematica1`
    FOREIGN KEY (`id_catalogo_area_tematica`)
    REFERENCES `catalogo_area_tematica` (`id_catalogo_area_tematica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curso_taller_norma_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_tipo_opciones_pregunta` ;

CREATE TABLE IF NOT EXISTS `catalogo_tipo_opciones_pregunta` (
  `id_opciones_pregunta` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `opcion_pregunta` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_opciones_pregunta`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `pregunta_ctn` ;

CREATE TABLE IF NOT EXISTS `pregunta_ctn` (
  `id_pregunta_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` TEXT NOT NULL,
  `id_opciones_pregunta` INT(5) UNSIGNED NOT NULL,
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_pregunta_ctn`),
  INDEX `fk_cuestionario_normas_asea_catalogo_tipo_opciones_pregunta_idx` (`id_opciones_pregunta` ASC),
  INDEX `fk_cuestionario_normas_asea_normas_asea1_idx` (`id_curso_taller_norma` ASC),
  CONSTRAINT `fk_cuestionario_normas_asea_catalogo_tipo_opciones_pregunta1`
    FOREIGN KEY (`id_opciones_pregunta`)
    REFERENCES `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuestionario_normas_asea_normas_asea1`
    FOREIGN KEY (`id_curso_taller_norma`)
    REFERENCES `curso_taller_norma` (`id_curso_taller_norma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_proceso_inscripcion` ;

CREATE TABLE IF NOT EXISTS `catalogo_proceso_inscripcion` (
  `id_catalogo_proceso_inscripcion` INT(5) UNSIGNED NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_catalogo_proceso_inscripcion`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `publicacion_ctn` ;

CREATE TABLE IF NOT EXISTS `publicacion_ctn` (
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_curso_comercial` VARCHAR(1500) NOT NULL COMMENT 'es el nombre del curso que se estaria publicando (para la publicidad)',
  `direccion_imparticion` TEXT NOT NULL,
  `fecha_inicio` DATE NOT NULL COMMENT 'fecha de incio del curso cuando se publique',
  `fecha_fin` DATE NOT NULL COMMENT 'fecha de fin del curso cuando se publique',
  `duracion` DECIMAL(6,2) NOT NULL COMMENT 'contendrá la duración en horas',
  `horario` VARCHAR(250) NOT NULL,
  `fecha_publicacion` DATETIME NOT NULL,
  `fecha_limite_inscripcion` DATETIME NOT NULL,
  `fecha_publicacion_baja` DATETIME NULL,
  `agente_capacitador` VARCHAR(500) NOT NULL,
  `costo_en_tiempo` DECIMAL(8,2) NOT NULL,
  `costo_extemporaneo` DECIMAL(8,2) NOT NULL,
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_publicacion_ctn`),
  INDEX `fk_publicacion_ctn_curso_taller_norma1_idx` (`id_curso_taller_norma` ASC),
  CONSTRAINT `fk_publicacion_ctn_curso_taller_norma1`
    FOREIGN KEY (`id_curso_taller_norma`)
    REFERENCES `curso_taller_norma` (`id_curso_taller_norma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `instructor` ;

CREATE TABLE IF NOT EXISTS `instructor` (
  `id_instructor` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_catalogo_titulo_academico` INT(5) UNSIGNED NULL COMMENT 'Referencia del titulo academico del instructor',
  `curp` VARCHAR(18) NOT NULL,
  `profesion` VARCHAR(500) NULL COMMENT 'Especificar la profesión que ejerce',
  PRIMARY KEY (`id_instructor`),
  INDEX `fk_empleado_es_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_instructor_catalogo_titulo_academico1_idx` (`id_catalogo_titulo_academico` ASC),
  CONSTRAINT `fk_empleado_es_usuario10`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instructor_catalogo_titulo_academico1`
    FOREIGN KEY (`id_catalogo_titulo_academico`)
    REFERENCES `catalogo_titulo_academico` (`id_catalogo_titulo_academico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_aula` ;

CREATE TABLE IF NOT EXISTS `catalogo_aula` (
  `id_catalogo_aula` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `campus` VARCHAR(150) NOT NULL DEFAULT 'Apizaco' COMMENT 'se le da el nombre del campus al que pertenece el aula',
  `aula` VARCHAR(250) NOT NULL COMMENT 'nombre del aula ',
  `cupo` INT(5) NOT NULL COMMENT 'capacidad de alumnos que puede tener un curso',
  PRIMARY KEY (`id_catalogo_aula`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `instructor_asignado_curso_publicado` ;

CREATE TABLE IF NOT EXISTS `instructor_asignado_curso_publicado` (
  `id_instructor_asignado_curso_publicado` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_instructor` INT(10) UNSIGNED NOT NULL,
  `id_catalogo_aula` INT(10) UNSIGNED NOT NULL,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_instructor_asignado_curso_publicado`),
  INDEX `fk_instructor_asignado_curso_instructor1_idx` (`id_instructor` ASC),
  INDEX `fk_instructor_asignado_curso_catalogo_aula1_idx` (`id_catalogo_aula` ASC),
  INDEX `fk_instructor_asignado_curso_publicado_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  CONSTRAINT `fk_instructor_asignado_curso_instructor1`
    FOREIGN KEY (`id_instructor`)
    REFERENCES `instructor` (`id_instructor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instructor_asignado_curso_catalogo_aula1`
    FOREIGN KEY (`id_catalogo_aula`)
    REFERENCES `catalogo_aula` (`id_catalogo_aula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instructor_asignado_curso_publicado_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `alumno_inscrito_ctn_publicado` ;

CREATE TABLE IF NOT EXISTS `alumno_inscrito_ctn_publicado` (
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_actualizacion_datos` DATETIME NULL COMMENT 'fecha de cuando el alumno inicio de actualización de datos',
  `fecha_preinscripcion` DATETIME NULL COMMENT 'fecha de cuando el alumno termino de guardar sus datos del formulario online y antes de registrar el pago',
  `fecha_pago_registrado` DATETIME NULL COMMENT 'fecha en la que el alumno registra su recibo de pago en el sistema',
  `fecha_pago_validado` DATETIME NULL COMMENT 'fecha de cuando el administrador valido el pago del alumno y se culminaria con la inscripcion completa del curso',
  `fecha_pago_observado` DATETIME NULL COMMENT 'fecha de cuando se raliza una observación del comprobate de pago del alumno',
  `fecha_ultimo_ingreso` DATETIME NULL,
  `ingresos_curso` INT(5) NOT NULL DEFAULT 1,
  `id_catalogo_proceso_inscripcion` INT(5) UNSIGNED NOT NULL DEFAULT 1,
  `id_alumno` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NULL COMMENT 'contiene el documento de la ficha de deposito',
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL COMMENT 'se guarda la publicación de un curso por el cual un alumno se estaría apuntando a un curso',
  `requiere_factura` ENUM('si', 'no') NULL DEFAULT 'no' COMMENT 'columna que guarda si el alumno require factura en el curso publicado',
  `cumple_comprobante` ENUM('si', 'no') NULL COMMENT 'almacena si el comprobante es valido',
  `observacion_comprobante` TEXT NULL COMMENT 'en caso de tener una observacion el comprobante se guarda el detalle en este apartado',
  `id_instructor_asignado_curso_publicado` INT(10) UNSIGNED NULL COMMENT 'referencia de cuando se le asigna el instructor y el aula al finalizar su proceso de inscripcion',
  `envio_datos_dc3` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `fecha_envio_datos_dc3` DATETIME NULL,
  `id_documento_dc3` INT(10) UNSIGNED NULL COMMENT 'almancena el id del documento del formulario de inscripcion concluido con los datos de la dc-3',
  PRIMARY KEY (`id_alumno_inscrito_ctn_publicado`),
  INDEX `fk_empleado_cursa_norma_empleado_es1_idx` (`id_alumno` ASC),
  INDEX `fk_alumno_inscrito_ctn_documento1_idx` (`id_documento` ASC),
  INDEX `fk_alumno_inscrito_ctn_catalogo_proceso_pago1_idx` (`id_catalogo_proceso_inscripcion` ASC),
  INDEX `fk_alumno_inscrito_ctn_publicado_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  INDEX `fk_alumno_inscrito_ctn_publicado_instructor_asignado_curso__idx` (`id_instructor_asignado_curso_publicado` ASC),
  INDEX `fk_alumno_inscrito_ctn_publicado_documento1_idx` (`id_documento_dc3` ASC),
  CONSTRAINT `fk_empleado_cursa_norma_empleado_es1`
    FOREIGN KEY (`id_alumno`)
    REFERENCES `alumno` (`id_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_inscrito_ctn_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_inscrito_ctn_catalogo_proceso_pago1`
    FOREIGN KEY (`id_catalogo_proceso_inscripcion`)
    REFERENCES `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_inscrito_ctn_publicado_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_inscrito_ctn_publicado_instructor_asignado_curso_pu1`
    FOREIGN KEY (`id_instructor_asignado_curso_publicado`)
    REFERENCES `instructor_asignado_curso_publicado` (`id_instructor_asignado_curso_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_inscrito_ctn_publicado_documento1`
    FOREIGN KEY (`id_documento_dc3`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `evaluacion_ctn` ;

CREATE TABLE IF NOT EXISTS `evaluacion_ctn` (
  `id_evaluacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL,
  `fecha_evaluacion` DATETIME NOT NULL,
  PRIMARY KEY (`id_evaluacion_ctn`),
  INDEX `fk_evaluacion_ctn_alumno_inscrito_ctn1_idx` (`id_alumno_inscrito_ctn_publicado` ASC),
  CONSTRAINT `fk_evaluacion_ctn_alumno_inscrito_ctn1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `actividad_norma` ;

CREATE TABLE IF NOT EXISTS `actividad_norma` (
  `id_actividad_norma` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NOT NULL,
  `objetivo` TEXT NOT NULL,
  `url_video` TEXT NOT NULL,
  `nombre_video` VARCHAR(500) NOT NULL,
  `tiempo` FLOAT(7,2) UNSIGNED NOT NULL,
  `id_curso_taller_norma` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_actividad_norma`),
  INDEX `fk_actividad_normas_asea_normas_asea1_idx` (`id_curso_taller_norma` ASC),
  CONSTRAINT `fk_actividad_normas_asea_normas_asea1`
    FOREIGN KEY (`id_curso_taller_norma`)
    REFERENCES `curso_taller_norma` (`id_curso_taller_norma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `opcion_pregunta_ctn` ;

CREATE TABLE IF NOT EXISTS `opcion_pregunta_ctn` (
  `id_opcion_pregunta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NOT NULL,
  `tipo_respuesta` ENUM('correcta', 'incorrecta') NOT NULL,
  `id_pregunta_ctn` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_opcion_pregunta`),
  INDEX `fk_opcion_pregunta_preguntas_normas_asea1_idx` (`id_pregunta_ctn` ASC),
  CONSTRAINT `fk_opcion_pregunta_preguntas_normas_asea1`
    FOREIGN KEY (`id_pregunta_ctn`)
    REFERENCES `pregunta_ctn` (`id_pregunta_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `respuesta_evaluacion` ;

CREATE TABLE IF NOT EXISTS `respuesta_evaluacion` (
  `id_respuesta_evaluacion` INT(10) UNSIGNED NOT NULL,
  `id_evaluacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_pregunta_ctn` INT(10) UNSIGNED NOT NULL,
  `id_opcion_pregunta` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_respuesta_evaluacion`),
  INDEX `fk_respuesta_empleado_es_preguntas_normas_asea1_idx` (`id_pregunta_ctn` ASC),
  INDEX `fk_respuesta_empleado_es_opcion_pregunta_norma_asea1_idx` (`id_opcion_pregunta` ASC),
  INDEX `fk_respuesta_empleado_es_evaluacion_norma_asea1_idx` (`id_evaluacion_ctn` ASC),
  CONSTRAINT `fk_respuesta_empleado_es_preguntas_normas_asea1`
    FOREIGN KEY (`id_pregunta_ctn`)
    REFERENCES `pregunta_ctn` (`id_pregunta_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_empleado_es_opcion_pregunta_norma_asea1`
    FOREIGN KEY (`id_opcion_pregunta`)
    REFERENCES `opcion_pregunta_ctn` (`id_opcion_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_empleado_es_evaluacion_norma_asea1`
    FOREIGN KEY (`id_evaluacion_ctn`)
    REFERENCES `evaluacion_ctn` (`id_evaluacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `historico_actividad_usuario` ;

CREATE TABLE IF NOT EXISTS `historico_actividad_usuario` (
  `id_historico_actividad_usuario` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion_operacion` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_historico_actividad_usuario`),
  INDEX `fk_historico_actividad_usuario_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_historico_actividad_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `usuario_admin` ;

CREATE TABLE IF NOT EXISTS `usuario_admin` (
  `id_usuario_admin` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `tipo` ENUM('administrador', 'admin') NOT NULL COMMENT 'define si el usuario es\nadministrador = super administrador\nadmin = administrador normal',
  PRIMARY KEY (`id_usuario_admin`),
  INDEX `fk_civik_asea_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_civik_asea_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `publicacion_has_doc_banner` ;

CREATE TABLE IF NOT EXISTS `publicacion_has_doc_banner` (
  `id_publicacion_has_doc_banner` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('doc', 'img') NOT NULL DEFAULT 'img',
  `titulo` VARCHAR(500) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_publicacion_has_doc_banner`),
  INDEX `fk_publicación_has_doc_banner_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  INDEX `fk_publicación_has_doc_banner_documento1_idx` (`id_documento` ASC),
  CONSTRAINT `fk_publicación_has_doc_banner_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicación_has_doc_banner_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_uso_cfdi` ;

CREATE TABLE IF NOT EXISTS `catalogo_uso_cfdi` (
  `id_catalogo_uso_cfdi` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` CHAR(5) NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `aplica_p_fisica` ENUM('si', 'no') NOT NULL COMMENT 'determina si el uso de cfdi aplica para personas fisicas',
  `aplica_p_moral` ENUM('si', 'no') NOT NULL COMMENT 'determina si el uso de cfdi aplica para personas fisicas',
  PRIMARY KEY (`id_catalogo_uso_cfdi`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `datos_fiscales` ;

CREATE TABLE IF NOT EXISTS `datos_fiscales` (
  `id_datos_fiscales` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `razon_social` VARCHAR(1500) NULL,
  `rfc` VARCHAR(13) NULL,
  `direccion_fiscal` VARCHAR(2500) NULL,
  `correo` VARCHAR(250) NULL,
  `id_catalogo_uso_cfdi` INT(6) UNSIGNED NULL,
  `id_alumno_inscrito_ctn_publicado` INT(10) UNSIGNED NOT NULL COMMENT 'referencia de los datos fiscales que requieren factura',
  PRIMARY KEY (`id_datos_fiscales`),
  INDEX `fk_datos_fiscales_catalogo_uso_cfdi1_idx` (`id_catalogo_uso_cfdi` ASC),
  INDEX `fk_datos_fiscales_alumno_inscrito_ctn_publicado1_idx` (`id_alumno_inscrito_ctn_publicado` ASC),
  CONSTRAINT `fk_datos_fiscales_catalogo_uso_cfdi1`
    FOREIGN KEY (`id_catalogo_uso_cfdi`)
    REFERENCES `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_fiscales_alumno_inscrito_ctn_publicado1`
    FOREIGN KEY (`id_alumno_inscrito_ctn_publicado`)
    REFERENCES `alumno_inscrito_ctn_publicado` (`id_alumno_inscrito_ctn_publicado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_constancia` ;

CREATE TABLE IF NOT EXISTS `catalogo_constancia` (
  `id_catalogo_constancia` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL COMMENT 'Determina el nombre de la constancia',
  PRIMARY KEY (`id_catalogo_constancia`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `publicacion_ctn_has_constancia` ;

CREATE TABLE IF NOT EXISTS `publicacion_ctn_has_constancia` (
  `id_publicacion_ctn_has_constancia` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_publicacion_ctn` INT(10) UNSIGNED NOT NULL,
  `id_catalogo_constancia` INT(5) UNSIGNED NOT NULL,
  `especifique_otra_constancia` VARCHAR(500) NULL COMMENT 'determina el nombre de la \"otra\" constancia que se estaria entregando al acreditar el curso',
  PRIMARY KEY (`id_publicacion_ctn_has_constancia`),
  INDEX `fk_publicacion_ctn_has_constancia_publicacion_ctn1_idx` (`id_publicacion_ctn` ASC),
  INDEX `fk_publicacion_ctn_has_constancia_catalogo_constancia1_idx` (`id_catalogo_constancia` ASC),
  CONSTRAINT `fk_publicacion_ctn_has_constancia_publicacion_ctn1`
    FOREIGN KEY (`id_publicacion_ctn`)
    REFERENCES `publicacion_ctn` (`id_publicacion_ctn`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacion_ctn_has_constancia_catalogo_constancia1`
    FOREIGN KEY (`id_catalogo_constancia`)
    REFERENCES `catalogo_constancia` (`id_catalogo_constancia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `catalogo_formas_pago` ;

CREATE TABLE IF NOT EXISTS `catalogo_formas_pago` (
  `id_catalogo_formas_pago` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cuenta` VARCHAR(100) NULL COMMENT 'almacena el numero de cuenta para realizar los depositos de los pagos',
  `numero_tarjeta` VARCHAR(20) NULL COMMENT 'almacena el numero de tarjeta donde se haran los depositos de las formas de pago',
  `clabe` VARCHAR(45) NULL COMMENT 'numero cuental clabe interbancaria',
  `sucursal` VARCHAR(45) NULL,
  `banco` VARCHAR(250) NOT NULL COMMENT 'nombre del banco',
  `titular` VARCHAR(250) NOT NULL COMMENT 'titular de la cuenta',
  `descripcion_pago_externo` VARCHAR(1500) NULL COMMENT 'una descripción de un pago externo',
  PRIMARY KEY (`id_catalogo_formas_pago`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `bitacora_datos_usuario` ;

CREATE TABLE IF NOT EXISTS `bitacora_datos_usuario` (
  `id_bitacora_datos_personales` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `seccion` VARCHAR(500) NOT NULL COMMENT 'es la seccion que se esta guardando',
  `fecha` DATETIME NOT NULL COMMENT 'fecha en la que se guarda la informacion ',
  `datos` TEXT NOT NULL COMMENT 'datos que se recibieron del post del formulario',
  PRIMARY KEY (`id_bitacora_datos_personales`),
  INDEX `fk_bit_datos_personales_usuario_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_bit_datos_personales_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `cat_formas_pago_logos` ;

CREATE TABLE IF NOT EXISTS `cat_formas_pago_logos` (
  `id_cat_formas_pago_logos` INT NOT NULL,
  `id_catalogo_formas_pago` INT(10) UNSIGNED NOT NULL,
  `id_documento` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_cat_formas_pago_logos`),
  INDEX `fk_cat_formas_pago_logos_catalogo_formas_pago1_idx` (`id_catalogo_formas_pago` ASC),
  INDEX `fk_cat_formas_pago_logos_documento1_idx` (`id_documento` ASC),
  CONSTRAINT `fk_cat_formas_pago_logos_catalogo_formas_pago1`
    FOREIGN KEY (`id_catalogo_formas_pago`)
    REFERENCES `catalogo_formas_pago` (`id_catalogo_formas_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cat_formas_pago_logos_documento1`
    FOREIGN KEY (`id_documento`)
    REFERENCES `documento` (`id_documento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



DROP TABLE IF EXISTS `notificacion` ;

CREATE TABLE IF NOT EXISTS `notificacion` (
  `id_notificacion` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mensaje` TEXT NOT NULL COMMENT 'es el mensaje que le llegara a un usuario',
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id_notificacion`))
ENGINE = InnoDB;



DROP TABLE IF EXISTS `usuario_sistema_has_notificacion` ;

CREATE TABLE IF NOT EXISTS `usuario_sistema_has_notificacion` (
  `id_usuario_sistema_has_notificacion` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_notificacion` BIGINT(20) UNSIGNED NOT NULL,
  `id_usuario_envia` INT(10) UNSIGNED NOT NULL COMMENT 'identificador de quien envia el mensaje',
  `id_usuario_recibe` INT(10) UNSIGNED NOT NULL COMMENT 'identificador del usuario del sistema quien recibe la notificacion',
  `fecha_leido` DATETIME NULL,
  PRIMARY KEY (`id_usuario_sistema_has_notificacion`),
  INDEX `fk_usuario_sistema_has_notificacion_notificacion_usuario_si_idx` (`id_notificacion` ASC),
  INDEX `fk_usuario_sistema_has_notificacion_usuario1_idx` (`id_usuario_envia` ASC),
  INDEX `fk_usuario_sistema_has_notificacion_usuario2_idx` (`id_usuario_recibe` ASC),
  CONSTRAINT `fk_usuario_sistema_has_notificacion_notificacion_usuario_sist1`
    FOREIGN KEY (`id_notificacion`)
    REFERENCES `notificacion` (`id_notificacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_sistema_has_notificacion_usuario1`
    FOREIGN KEY (`id_usuario_envia`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_sistema_has_notificacion_usuario2`
    FOREIGN KEY (`id_usuario_recibe`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



START TRANSACTION;

INSERT INTO `documento` (`id_documento`, `nombre`, `ruta_directorio`, `fecha`) VALUES (1, 'oxxo.png', 'extras/imagenes/logo/', '2018-02-24');
INSERT INTO `documento` (`id_documento`, `nombre`, `ruta_directorio`, `fecha`) VALUES (2, 'citibanamex.png', 'extras/imagenes/logo/', '2018-02-24');
INSERT INTO `documento` (`id_documento`, `nombre`, `ruta_directorio`, `fecha`) VALUES (3, 'telecomm.png', 'extras/imagenes/logo/', '2018-02-24');

COMMIT;


START TRANSACTION;

INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `activo`, `codigo_verificacion`, `verificado`, `update_password`, `nombre`, `apellido_p`, `apellido_m`, `correo`, `telefono`, `update_datos`, `id_documento_perfil`) VALUES (1, 'administrador', '316f00d66c019640cb2d632e1ac28b39da579779', 'si', NULL, 'si', DEFAULT, 'Sistema', 'Administrador', 'Civika', 'enrique_cr1990@hotmail.com', '246 757 50 99', DEFAULT, NULL);
INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `activo`, `codigo_verificacion`, `verificado`, `update_password`, `nombre`, `apellido_p`, `apellido_m`, `correo`, `telefono`, `update_datos`, `id_documento_perfil`) VALUES (2, 'civikholding', '330de41b530d5748e0f60a06ffa74240f5153263', 'si', NULL, 'si', DEFAULT, 'José Luis ', 'Salazar ', 'Hernández', 'jl_salazarh@hotmail.com', '241-115-58-00', DEFAULT, NULL);

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (1, 'Lic.', 'Licenciatura');
INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (2, 'Ing.', 'Ingenieria');
INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (3, 'Mtro.', 'Maestria');
INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (4, 'Doc.', 'Doctorado');
INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (5, '', 'Ama de casa');
INSERT INTO `catalogo_titulo_academico` (`id_catalogo_titulo_academico`, `abreviatura`, `titulo`) VALUES (6, '', 'Estudiante');

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (1, '01', 'Cultivo, crianza y aprovechamiento', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (2, '02', 'Extracción y suministro', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (3, '03', 'Construcción', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (4, '04', 'Tecnología', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (5, '05', 'Procesamiento y fabricación', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (6, '06', 'Transporte', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (7, '07', 'Provisión de bienes y servicios', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (8, '08', 'Gestión y soporte administrativo', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (9, '09', 'Salud y protección social', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (10, '10', 'Comunicación', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (11, '11', 'Desarrollo y extensión del conocimiento', NULL);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (12, '01.1', 'Agricultura y silvicultura', 1);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (13, '01.2', 'Ganadería', 1);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (14, '01.3', 'Pesca y acuacultura', 1);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (15, '02.1', 'Exploración', 2);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (16, '02.2', 'Extracción', 2);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (17, '02.3', 'Refinación y beneficio', 2);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (18, '02.4', 'Provisión de energía', 2);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (19, '02.5', 'Provisión de agua', 2);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (20, '03.1', 'Planeación y dirección de obras', 3);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (21, '03.2', 'Edificación y urbanización', 3);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (22, '03.3', 'Acabado', 3);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (23, '03.4', 'Instalación y mantenimiento', 3);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (24, '04.1', 'Mecánica', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (25, '04.2', 'Electricidad', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (26, '04.3', 'Electrónica', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (27, '04.4', 'Informática', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (28, '04.5', 'Telecomunicaciones', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (29, '04.6', 'Procesos industriales', 4);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (30, '05.1', 'Minerales no metálicos', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (31, '05.2', 'Metales', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (32, '05.3', 'Alimentos y bebidas', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (33, '05.4', 'Textiles y prendas de vestir', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (34, '05.5', 'Materia orgánica', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (35, '05.6', 'Productos químicos', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (36, '05.7', 'Productos metálicos y de hule y plástico', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (37, '05.8', 'Productos eléctricos y electrónicos', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (38, '05.9', 'Productos impresos', 5);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (39, '06.1', 'Ferroviario', 6);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (40, '06.2', 'Autotransporte', 6);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (41, '06.3', 'Aéreo', 6);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (42, '06.4', 'Marítimo y fluvial', 6);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (43, '06.5', 'Servicios de apoyo', 6);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (44, '07.1', 'Comercio', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (45, '07.2', 'Alimentación y hospedaje', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (46, '07.3', 'Turismo', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (47, '07.4', 'Deporte y esparcimiento', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (48, '07.5', 'Servicios personales', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (49, '07.6', 'Reparación de artículos de uso doméstico y personal', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (50, '07.7', 'Limpieza', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (51, '07.8', 'Servicio postal y mensajería', 7);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (52, '08.1', 'Bolsa, banca y seguros', 8);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (53, '08.2', 'Administración', 8);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (54, '08.3', 'Servicios legales', 8);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (55, '09.1', 'Servicios médicos', 9);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (56, '09.2', 'Inspección sanitaria y del medio ambiente', 9);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (57, '09.3', 'Seguridad social', 9);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (58, '09.4', 'Protección de bienes y/o personas', 9);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (59, '10.1', 'Publicación', 10);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (60, '10.2', 'Radio, cine, televisión y teatro', 10);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (61, '10.3', 'Interpretación artística', 10);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (62, '10.4', 'Traducción e interpretación lingüística', 10);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (63, '10.5', 'Publicidad, propaganda y relaciones públicas', 10);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (64, '11.1', 'Investigación', 11);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (65, '11.2', 'Enseñanza', 11);
INSERT INTO `catalogo_ocupacion_especifica` (`id_catalogo_ocupacion_especifica`, `clave_area_subarea`, `denominacion`, `id_catalogo_ocupacion_especifica_parent`) VALUES (66, '11.3', 'Difusión cultural', 11);

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (1, '1000', 'Producción general');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (2, '2000', 'Servicios');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (3, '3000', 'Administración, contabilidad y economía');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (4, '4000', 'Comercialización');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (5, '5000', 'Mantenimiento y reparación');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (6, '6000', 'Seguridad');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (7, '7000', 'Desarrollo personal y familiar');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (8, '8000', 'Uso de tecnologías de la información y comunicación');
INSERT INTO `catalogo_area_tematica` (`id_catalogo_area_tematica`, `clave`, `denominacion`) VALUES (9, '9000', 'Participación social');

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (1, 'Verdadero/Falso');
INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (2, 'Unica opcion');
INSERT INTO `catalogo_tipo_opciones_pregunta` (`id_opciones_pregunta`, `opcion_pregunta`) VALUES (3, 'Opcion multiple');

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`, `descripcion`) VALUES (1, 'Actualización de datos');
INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`, `descripcion`) VALUES (2, 'Sin pago registrado');
INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`, `descripcion`) VALUES (3, 'Pago en validación');
INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`, `descripcion`) VALUES (4, 'Pago observado');
INSERT INTO `catalogo_proceso_inscripcion` (`id_catalogo_proceso_inscripcion`, `descripcion`) VALUES (5, 'Inscrito');

COMMIT;



START TRANSACTION;

INSERT INTO `catalogo_aula` (`id_catalogo_aula`, `campus`, `aula`, `cupo`) VALUES (1, DEFAULT, 'Aula 1', 28);
INSERT INTO `catalogo_aula` (`id_catalogo_aula`, `campus`, `aula`, `cupo`) VALUES (2, DEFAULT, 'Aula 2', 20);
INSERT INTO `catalogo_aula` (`id_catalogo_aula`, `campus`, `aula`, `cupo`) VALUES (3, DEFAULT, 'Aula 3', 15);

COMMIT;


START TRANSACTION;

INSERT INTO `usuario_admin` (`id_usuario_admin`, `id_usuario`, `tipo`) VALUES (1, 1, 'administrador');
INSERT INTO `usuario_admin` (`id_usuario_admin`, `id_usuario`, `tipo`) VALUES (2, 2, 'administrador');

COMMIT;


START TRANSACTION;

INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (1, 'G01', 'Adquisición de mercancias', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (2, 'G02', 'Devoluciones, descuentos o bonificaciones', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (3, 'G03', 'Gastos en general', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (4, 'I01', 'Construcciones', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (5, 'I02', 'Mobilario y equipo de oficina por inversiones', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (6, 'I03', 'Equipo de transporte', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (7, 'I04', 'Equipo de computo y accesorios', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (8, 'I05', 'Dados, troqueles, moldes, matrices y herramental', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (9, 'I06', 'Comunicaciones telefónicas', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (10, 'I07', 'Comunicaciones satelitales', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (11, 'I08', 'Otra maquinaria y equipo', 'si', 'si');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (12, 'D01', 'Honorarios médicos, dentales y gastos hospitalarios.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (13, 'D02', 'Gastos médicos por incapacidad o discapacidad', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (14, 'D03', 'Gastos funerales.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (15, 'D04', 'Donativos.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (16, 'D05', 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (17, 'D06', 'Aportaciones voluntarias al SAR.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (18, 'D07', 'Primas por seguros de gastos médicos.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (19, 'D08', 'Gastos de transportación escolar obligatoria.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (20, 'D09', 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (21, 'D10', 'Pagos por servicios educativos (colegiaturas)', 'si', 'no');
INSERT INTO `catalogo_uso_cfdi` (`id_catalogo_uso_cfdi`, `clave`, `descripcion`, `aplica_p_fisica`, `aplica_p_moral`) VALUES (22, 'P01', 'Por definir', 'si', 'si');

COMMIT;


START TRANSACTION;

INSERT INTO `catalogo_constancia` (`id_catalogo_constancia`, `nombre`) VALUES (1, 'Constancia de habilidades laborales');
INSERT INTO `catalogo_constancia` (`id_catalogo_constancia`, `nombre`) VALUES (2, 'Constancia DC-3 STPS');
INSERT INTO `catalogo_constancia` (`id_catalogo_constancia`, `nombre`) VALUES (99999, 'Otra');

COMMIT;


START TRANSACTION;

INSERT INTO `catalogo_formas_pago` (`id_catalogo_formas_pago`, `cuenta`, `numero_tarjeta`, `clabe`, `sucursal`, `banco`, `titular`, `descripcion_pago_externo`) VALUES (1, '', '5256 7819 0454 0692', NULL, NULL, 'Citi-banamex', 'José Luis Salazar Hernandez', 'Puede pasar a pagar en cualquier tienda OXXO y Telecomm Telegrafos');

COMMIT;


START TRANSACTION;

INSERT INTO `cat_formas_pago_logos` (`id_cat_formas_pago_logos`, `id_catalogo_formas_pago`, `id_documento`) VALUES (1, 1, 1);
INSERT INTO `cat_formas_pago_logos` (`id_cat_formas_pago_logos`, `id_catalogo_formas_pago`, `id_documento`) VALUES (2, 1, 2);
INSERT INTO `cat_formas_pago_logos` (`id_cat_formas_pago_logos`, `id_catalogo_formas_pago`, `id_documento`) VALUES (3, 1, 3);

COMMIT;

