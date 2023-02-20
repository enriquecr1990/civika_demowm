<?php $this->load->view('default/header') ?>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id="cards" class="container-fluid">
                    <div class="row">

                        <?php if(isset($curso_disponible) && is_object($curso_disponible) && !is_null($curso_disponible)): ?>
                            <div class="form-group col-lg-4 col-md-8 col-sm-12 col-12">
                                <img class="img-fluid img-thumbnail" src="<?= base_url() . $curso_disponible->img_banner ?>"
                                     alt="<?= $curso_disponible->nombre ?>">
                            </div>

                            <div class="form-group col-lg-8 col-md-4 col-sm-12 col-12">
                                <h5 class="card-title"><?= strtoupper($curso_disponible->nombre_curso_comercial) ?></h5>
                                <p class="card-text text-justify">
                                    <span class="text-descripcion-curso">
                                        <?=$curso_disponible->descripcion?>
                                    </span><br>

                                    <span class="negrita">Fecha de impartición: </span> <?= fechaBDToHtml( $curso_disponible->fecha_inicio) ?>.
                                    <span class="negrita">Horario de:</span> <?= strMinusculas($curso_disponible->horario) ?> horas

                                    <label>$<?= number_format($curso_disponible->costo, 2) ?></label>
                                </p>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12 text-left">
                                        <button type="button" class="btn btn-sm btn-pill mb-1 btn_cargar_carta_descriptiva_curso"
                                                data-id_publicacion_ctn="<?=$curso_disponible->id_publicacion_ctn?>">
                                            Carta descriptiva
                                        </button>
                                        <br>
                                        <?php $inscripcion = true;
                                        $es_admin = false;
                                        if(isset($usuario) && $usuario){
                                            if($usuario->tipo_usuario != 'alumno'){
                                                $inscripcion = false;
                                            }
                                            if($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin' ){
                                                $es_admin = true;
                                            }
                                        }
                                        ?>
                                        <?php if($inscripcion): ?>
                                            <?php if (isset($curso_disponible->alumno_inscripcion) && $curso_disponible->alumno_inscripcion): ?>
                                                <?php
                                                $leyenda = 'En proceso de inscripcion';
                                                $leyenda_detalle = '';
                                                $class = 'warning';
                                                $class_detalle = 'warning';
                                                $update_datos = true;
                                                if($curso_disponible->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_EN_VALIDACION){
                                                    $leyenda = 'Pago en validación';
                                                    $leyenda_detalle = 'Preinscripción realizada / pago en validación';
                                                    $class = 'light';
                                                    $update_datos = false;
                                                }if($curso_disponible->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_OBSERVADO){
                                                    $leyenda = 'Pago observado';
                                                    $leyenda_detalle = 'Preinscripción realizada / pago observado';
                                                    $class = 'danger';
                                                    $class_detalle = 'danger';
                                                }if($curso_disponible->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO){
                                                    $leyenda = 'Inscrito';
                                                    $leyenda_detalle = 'Inscripción realizada / pago validado';
                                                    $class = 'success';
                                                    $class_detalle = 'success';
                                                    $update_datos = false;
                                                }
                                                ?>
                                                <span class="btn btn-sm btn-pill btn-<?=$class?>" data-toggle="tooltip"
                                                      title="Ver detalle"><?=$leyenda?></span>
                                                <?php if($update_datos): ?>
                                                    <br>
                                                    <a href="<?=base_url().'InscripcionesCTN/actualizarDatosAlumno/'.$curso_disponible->id_publicacion_ctn?>" class="btn btn-sm btn-pill btn-info" data-toggle="tooltip"
                                                       title="Ver detalle">Continuar proceso de inscripcion</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php $leyenda_detalle = ''; ?>
                                                <a href="<?= base_url() . 'InscripcionesCTN/registroCursoTallerNorma/' . $curso_disponible->id_publicacion_ctn ?>"
                                                   class="btn btn-sm btn-pill btn-success">Inscribirme</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($es_admin):?>
                                            <button type="button" class="btn btn-sm btn-pill btn-success btn_enviar_publicidad_correo"
                                                    data-id_publicacion_ctn="<?=$curso_disponible->id_publicacion_ctn?>">
                                                Enviar correos
                                            </button>
                                            <br>
                                            <span class="badge badge-pill badge-info">Visitas Carta Descriptiva: <?=$curso_disponible->visitas_carta_descriptiva?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12 text-right">
                                        <a href="<?=base_url()?>" class="btn btn-sm btn-pill btn-primary">Ver oferta educativa</a>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-group col-lg-12">
                                <div class="alert alert-danger">
                                    El curso al que intenta ingresar o ya fue impartido o no se encuentra disponible
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>



<div id="conteiner_operacion_inscripcion_alumno"></div>

<div id="container_operacion_carta_descriptiva"></div>

<?php $this->load->view('default/footer') ?>