<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Examen de evaluación</label>
        </div>
        <div class="card-body">

            <?php if(isset($evaluacion_publicacion_ctn) && $evaluacion_publicacion_ctn->disponible_alumnos == 'si'): ?>
                <?php if ($tiene_evaluacion_aprobatoria): ?>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <span class="badge badge-success">! F E L I C I D A D E S !</span>
                            <p>
                                Ya cuenta con una calificación aprobatoria
                                <span class="badge badge-<?= $etiqueta_evaluacion ?> negrita"><?= $evaluacion_aprobatoria ?></span>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($puede_realizar_evaluacion): ?>
                        <form id="form_evaluacion_examen">

                            <input type="hidden" name="id_evaluacion_alumno_publicacion_ctn"
                                   value="<?= $evaluacion_alumno_publicacion_ctn->id_evaluacion_alumno_publicacion_ctn ?>">
                            <input type="hidden" name="id_evaluacion_publicacion_ctn"
                                   value="<?= $evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn ?>">
                            <input type="hidden" name="tipo_evaluacion" value="<?=$evaluacion_publicacion_ctn->tipo?>">

                            <!-- el tiempo que existira si tuviera tiempo limite el examen -->
                            <?php if (isset($evaluacion_publicacion_ctn->tiempo_evaluacion) && !is_null($evaluacion_publicacion_ctn->tiempo_evaluacion)): ?>
                                <input type="hidden" id="tiempo_minutos"
                                       value="<?= $evaluacion_publicacion_ctn->tiempo_evaluacion ?>">
                                <div id="reloj_contador"></div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="alert alert-light">
                                        Lea cuidadosamente las preguntas y responda conforme usted considere sea la
                                        respuesta
                                        correcta
                                    </div>
                                </div>
                            </div>

                            <?php foreach ($pregunta_publicacion_ctn as $index => $prt): ?>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 text-justify">
                                        <label><?= $index + 1 ?>.- <?= $prt->pregunta ?></label>
                                    </div>
                                </div>
                                <?php if (in_array($prt->id_opciones_pregunta, array(OPCION_VERDADERO_FALSO, OPCION_UNICA_OPCION, OPCION_IMAGEN_UNICA_OPCION))): ?>
                                    <div class="row">
                                        <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio"
                                                           id="radio_vf_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"
                                                           data-rule-required="true"
                                                           name="pregunta[<?= $prt->id_pregunta_publicacion_ctn ?>][respuesta][]"
                                                           class="custom-control-input"
                                                           value="<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>">
                                                    <label class="custom-control-label"
                                                           for="radio_vf_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"><?= $opciones->descripcion ?></label>
                                                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                                        <div>
                                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                                 src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                                 alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif (in_array($prt->id_opciones_pregunta, array(OPCION_OPCION_MULTIPLE, OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
                                    <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                                        <div class="form-group col-lg-12">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input id="checkbox_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"
                                                       type="checkbox"
                                                       name="pregunta[<?= $prt->id_pregunta_publicacion_ctn ?>][respuesta][]"
                                                       data-rule-required="true" class="custom-control-input"
                                                       value="<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>">
                                                <label class="custom-control-label"
                                                       for="checkbox_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"><?= $opciones->descripcion ?></label>
                                                <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                                    <div>
                                                        <img class="img-thumbnail" style="width: 100px !important;"
                                                             src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                             alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php elseif ($prt->id_opciones_pregunta == OPCION_SECUENCIAL): ?>
                                    <table class="table table-striped data-table">
                                        <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                                            <tr>
                                                <td width="12%">
                                                    <input type="number"
                                                           id="secuencial_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"
                                                           data-rule-required="true"
                                                           placeholder="Orden cronológico"
                                                           name="pregunta[<?= $prt->id_pregunta_publicacion_ctn ?>][respuesta_secuencial][<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>]"
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <label for="secuencial_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"><?= $opciones->descripcion ?></label>
                                                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                                        <div>
                                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                                 src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                                 alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php elseif ($prt->id_opciones_pregunta == OPCION_RELACIONAL): ?>
                                    <table class="table table-striped data-table">
                                        <?php foreach ($prt->opciones_pregunta_publicacion_ctn_izq as $index => $opciones): ?>
                                            <tr>
                                                <!-- izq -->
                                                <td width="5%">
                                                    <button type="button"
                                                            class="btn btn-success btn-pill btn-sm draggable_btn"><?= $opciones->consecutivo ?></button>
                                                </td>
                                                <td>
                                                    <span><?= $opciones->descripcion ?></span>
                                                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                                        <div>
                                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                                 src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                                 alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- der -->
                                                <td width="12%">
                                                    <input type="number"
                                                           data-rule-required="true"
                                                           id="relacional_<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->id_opcion_pregunta_publicacion_ctn ?>"
                                                           placeholder="Opción relación"
                                                           name="pregunta[<?= $prt->id_pregunta_publicacion_ctn ?>][respuesta_relacional][<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->id_opcion_pregunta_publicacion_ctn ?>]"
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <label for="relacional_<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->id_opcion_pregunta_publicacion_ctn ?>"><?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->descripcion ?></label>
                                                    <?php if (isset($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta) && is_object($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta)): ?>
                                                        <div>
                                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                                 src="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->ruta_documento ?>"
                                                                 alt="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->nombre ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                                    <button type="button" class="btn btn-pill btn-primary btn_enviar_examen">Enviar examen
                                    </button>
                                    <button type="button" class="btn btn-pill btn-info btn_enviar_examen_tiempo noview">Enviar
                                        examen tiempo
                                    </button>
                                </div>
                            </div>

                        </form>
                    <?php else: ?>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <div class="alert alert-danger">
                                    <label>! LO SENTIMOS !</label> Ah reliazado el todos los intentos de evaluación
                                    disponibles
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
            <div class="row">
                <div class="form-group col-lg-12">
                    <div class="alert alert-warning">
                        <label>! LO SENTIMOS !</label> Por el momento no se encuentra disponible la evaluación, el instructor la está creando; espere a su liberación
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="form-group col-lg-12 text-left">
                    <a href="<?=base_url()?>Alumnos/mis_cursos" class="btn btn-sm btn-secondary btn-pill" >Regresar</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- divs de container -->
<div id="conteiner_publicar_curso"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>