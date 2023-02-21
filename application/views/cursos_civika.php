<?php $this->load->view('default/header') ?>

<?php if (isset($cursos_disponibles) && is_array($cursos_disponibles) && sizeof($cursos_disponibles) != 0): ?>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
        <h3 class="card-title">Oferta educativa</h3>
    </div>
    <div id="cards" class="container mb-2">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
            <h4 class="card-title">Cursos Presenciales</h4>
        </div>
        <div class="example col-md-12 ml-auto mr-auto">
            <div class="row">
                <?php foreach ($cursos_disponibles as $index => $cd): ?>
                    <div class="col-xlg-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card card_cursos_disponibles">
                            <img class="card-img-top" src="<?= base_url() . $cd->img_banner ?>"
                                 alt="<?= $cd->nombre ?>" width="100%" height="180px">
                            <div class="card-body">
                                <h5 class="card-title"><?= strtoupper($cd->nombre_curso_comercial) ?></h5>
                                <p class="card-text text-justify">
                                        <span class="text-descripcion-curso">
                                            <?php if (strlen($cd->descripcion) > 250): ?>
                                                <?= substr($cd->descripcion, 0, 250) . '...' ?>
                                            <?php else: ?>
                                                <?= $cd->descripcion ?>
                                            <?php endif; ?>
                                        </span><br>

                                    <span class="negrita">Fecha de impartición: </span> <?= fechaBDToHtml($cd->fecha_inicio) ?>
                                    .
                                    <span class="negrita">Horario de:</span> <?= strMinusculas($cd->horario) ?> horas

                                    <label>$<?= number_format($cd->costo, 2) ?></label>
                                </p>
                                <div class="text-right">
                                    <button type="button" id="btn_carta_descriptiva_<?= $cd->id_publicacion_ctn ?>"
                                            class="btn btn-sm btn-pill btn_cargar_carta_descriptiva_curso"
                                            data-id_publicacion_ctn="<?= $cd->id_publicacion_ctn ?>">
                                        Carta descriptiva
                                    </button>
                                    <?php $inscripcion = true;
                                    $es_admin = false;
                                    if (isset($usuario) && $usuario) {
                                        if ($usuario->tipo_usuario != 'alumno') {
                                            $inscripcion = false;
                                        }
                                        if ($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin') {
                                            $es_admin = true;
                                        }
                                    }
                                    ?>
                                    <?php if ($inscripcion): ?>
                                        <?php if (isset($cd->alumno_inscripcion) && $cd->alumno_inscripcion): ?>
                                            <?php
                                            $leyenda = 'En proceso de inscripcion';
                                            $leyenda_detalle = '';
                                            $class = 'warning';
                                            $class_detalle = 'warning';
                                            $update_datos = true;
                                            if ($cd->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_EN_VALIDACION) {
                                                $leyenda = 'Pago en validación';
                                                $leyenda_detalle = 'Preinscripción realizada / pago en validación';
                                                $class = 'light';
                                                $update_datos = false;
                                            }
                                            if ($cd->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_OBSERVADO) {
                                                $leyenda = 'Pago observado';
                                                $leyenda_detalle = 'Preinscripción realizada / pago observado';
                                                $class = 'danger';
                                                $class_detalle = 'danger';
                                            }
                                            if ($cd->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO) {
                                                $leyenda = 'Inscrito';
                                                $leyenda_detalle = 'Inscripción realizada / pago validado';
                                                $class = 'success';
                                                $class_detalle = 'success';
                                                $update_datos = false;
                                            }
                                            ?>
                                            <span class="btn btn-sm btn-pill btn-<?= $class ?>" data-toggle="tooltip"
                                                  title="Ver detalle"><?= $leyenda ?></span>
                                            <?php if ($update_datos): ?>
                                                <br>
                                                <a href="<?= base_url() . 'InscripcionesCTN/actualizarDatosAlumno/' . $cd->id_publicacion_ctn ?>"
                                                   class="btn btn-sm btn-pill btn-info" data-toggle="tooltip"
                                                   title="Ver detalle">Continuar proceso de inscripcion</a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php $leyenda_detalle = ''; ?>
                                            <a href="<?= base_url() . 'InscripcionesCTN/registroCursoTallerNorma/' . $cd->id_publicacion_ctn ?>"
                                               class="btn btn-sm btn-pill btn-success">Inscribirme</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($es_admin): ?>
                                        <button type="button"
                                                class="btn btn-sm btn-pill btn-success btn_enviar_publicidad_correo"
                                                data-id_publicacion_ctn="<?= $cd->id_publicacion_ctn ?>">
                                            Enviar correos
                                        </button>
                                        <br>
                                        <span class="badge badge-pill badge-info">Visitas Carta Descriptiva: <?= $cd->visitas_carta_descriptiva ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div id="contenido_curso_<?= $index ?>" style="display: none">
                            <ul>
                                <li><i class="fa fa-calendar"></i> Fecha límite de
                                    inscripción: <?= fechaBDToHtml($cd->fecha_limite_inscripcion) ?></li>
                                <li><i class="fa fa-calendar"></i> Fecha de
                                    aplicación: <?= fechaBDToHtml($cd->fecha_inicio) ?></li>
                                <li><i class="fa fa-clock-o"></i> Horario: <?= $cd->horario ?></li>
                                <li><i class="fa fa-clock-o"></i> Duración: <?= $cd->duracion ?></li>
                                <li><i class="fa fa-map-marker"></i> Lugar: <?= $cd->direccion_imparticion ?></li>
                                <li><i class="fa fa-file"></i> Descripcion: <?= $cd->descripcion ?></li>
                                <li><i class="fa fa-commenting"></i> Objetivo: <?= $cd->objetivo ?></li>
                                <?php if (isset($leyenda_detalle) && $leyenda_detalle != ''): ?>
                                    <li>
                                        <div class="alert alert-<?= $class_detalle ?>">
                                            <i class="fa fa-check-circle fa-2x"></i> <?= $leyenda_detalle ?>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

    <!-- codigo para vista de cursos de evaluacion online-->
<?php if(!es_produccion()): ?>
    <?php if (isset($cursos_disponibles_eva_online) && is_array($cursos_disponibles_eva_online) && sizeof($cursos_disponibles_eva_online) != 0): ?>
        <div id="cards" class="container mb-2">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                <h4 class="card-title">Evaluaciones Online</h4>
            </div>
            <div class="example col-md-12 ml-auto mr-auto">
                <div class="row">
                    <?php foreach ($cursos_disponibles_eva_online as $index => $cdeo): ?>
                        <div class="col-xlg-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card card_cursos_disponibles">
                                <img class="card-img-top" src="<?= base_url() . $cdeo->img_banner ?>"
                                     alt="<?= $cdeo->nombre ?>" width="100%" height="180px">
                                <div class="card-body">
                                    <h5 class="card-title"><?= strtoupper($cdeo->nombre_curso_comercial) ?></h5>
                                    <p class="card-text text-justify">
                                        <span class="text-descripcion-curso">
                                            <?php if (strlen($cdeo->descripcion) > 250): ?>
                                                <?= substr($cdeo->descripcion, 0, 250) . '...' ?>
                                            <?php else: ?>
                                                <?= $cdeo->descripcion ?>
                                            <?php endif; ?>
                                        </span><br>

                                        <span class="negrita">Fecha de impartición: </span> <?= fechaBDToHtml($cdeo->fecha_inicio) ?>
                                        .
                                        <span class="negrita">Horario de:</span> <?= strMinusculas($cdeo->horario) ?>
                                        horas

                                        <label>$<?= number_format($cdeo->costo, 2) ?></label>
                                    </p>
                                    <div class="text-right">
                                        <button type="button"
                                                id="btn_carta_descriptiva_<?= $cdeo->id_publicacion_ctn ?>"
                                                class="btn btn-sm btn-pill btn_cargar_carta_descriptiva_curso"
                                                data-id_publicacion_ctn="<?= $cdeo->id_publicacion_ctn ?>">
                                            Carta descriptiva
                                        </button>
                                        <?php $inscripcion = true;
                                        $es_admin = false;
                                        if (isset($usuario) && $usuario) {
                                            if ($usuario->tipo_usuario != 'alumno') {
                                                $inscripcion = false;
                                            }
                                            if ($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin') {
                                                $es_admin = true;
                                            }
                                        }
                                        ?>
                                        <?php if ($inscripcion): ?>
                                            <?php if (isset($cdeo->alumno_inscripcion) && $cdeo->alumno_inscripcion): ?>
                                                <?php
                                                $leyenda = 'En proceso de inscripcion';
                                                $leyenda_detalle = '';
                                                $class = 'warning';
                                                $class_detalle = 'warning';
                                                $update_datos = true;
                                                if ($cdeo->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_EN_VALIDACION) {
                                                    $leyenda = 'Pago en validación';
                                                    $leyenda_detalle = 'Preinscripción realizada / pago en validación';
                                                    $class = 'light';
                                                    $update_datos = false;
                                                }
                                                if ($cdeo->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_OBSERVADO) {
                                                    $leyenda = 'Pago observado';
                                                    $leyenda_detalle = 'Preinscripción realizada / pago observado';
                                                    $class = 'danger';
                                                    $class_detalle = 'danger';
                                                }
                                                if ($cdeo->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO) {
                                                    $leyenda = 'Inscrito';
                                                    $leyenda_detalle = 'Inscripción realizada / pago validado';
                                                    $class = 'success';
                                                    $class_detalle = 'success';
                                                    $update_datos = false;
                                                }
                                                ?>
                                                <span class="btn btn-sm btn-pill btn-<?= $class ?>"
                                                      data-toggle="tooltip"
                                                      title="Ver detalle"><?= $leyenda ?></span>
                                                <?php if ($update_datos): ?>
                                                    <br>
                                                    <a href="<?= base_url() . 'InscripcionesCTN/actualizarDatosAlumno/' . $cdeo->id_publicacion_ctn ?>"
                                                       class="btn btn-sm btn-pill btn-info" data-toggle="tooltip"
                                                       title="Ver detalle">Continuar proceso de inscripcion</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php $leyenda_detalle = ''; ?>
                                                <a href="<?= base_url() . 'InscripcionesCTN/registroCursoTallerNorma/' . $cdeo->id_publicacion_ctn ?>"
                                                   class="btn btn-sm btn-pill btn-success">Inscribirme</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($es_admin): ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-pill btn-success btn_enviar_publicidad_correo"
                                                    data-id_publicacion_ctn="<?= $cdeo->id_publicacion_ctn ?>">
                                                Enviar correos
                                            </button>
                                            <br>
                                            <span class="badge badge-pill badge-info">Visitas Carta Descriptiva: <?= $cdeo->visitas_carta_descriptiva ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div id="contenido_curso_<?= $index ?>" style="display: none">
                                <ul>
                                    <li><i class="fa fa-calendar"></i> Fecha límite de
                                        inscripción: <?= fechaBDToHtml($cdeo->fecha_limite_inscripcion) ?></li>
                                    <li><i class="fa fa-calendar"></i> Fecha de
                                        aplicación: <?= fechaBDToHtml($cdeo->fecha_inicio) ?></li>
                                    <li><i class="fa fa-clock-o"></i> Horario: <?= $cdeo->horario ?></li>
                                    <li><i class="fa fa-clock-o"></i> Duración: <?= $cdeo->duracion ?></li>
                                    <li><i class="fa fa-map-marker"></i> Lugar: <?= $cdeo->direccion_imparticion ?></li>
                                    <li><i class="fa fa-file"></i> Descripcion: <?= $cdeo->descripcion ?></li>
                                    <li><i class="fa fa-commenting"></i> Objetivo: <?= $cdeo->objetivo ?></li>
                                    <?php if (isset($leyenda_detalle) && $leyenda_detalle != ''): ?>
                                        <li>
                                            <div class="alert alert-<?= $class_detalle ?>">
                                                <i class="fa fa-check-circle fa-2x"></i> <?= $leyenda_detalle ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif?>

    <div id="conteiner_operacion_inscripcion_alumno"></div>

    <div id="container_operacion_carta_descriptiva"></div>

<?php $this->load->view('default/footer') ?>