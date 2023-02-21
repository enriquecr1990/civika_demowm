<?php if(isset($es_publicacion_empresa) && $es_publicacion_empresa
    && isset($realizo_envio_empresa_masivo) && !$realizo_envio_empresa_masivo): ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="alert alert-warning">
                Por el momento la empresa esta realizando la carga de informacion de los empleados que tomará el curso
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row row_form">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="check_box_asistencia_masiva"
                       data-id_publicacion_ctn="<?=$publicacion_ctn->id_publicacion_ctn?>"
                    <?=isset($array_alumnos_publicacion) && is_array($array_alumnos_publicacion) && sizeof($array_alumnos_publicacion) != 0 && sizeof($array_alumnos_publicacion) == $alumnos_asistieron ? 'checked="checked"':'' ?>>
                <label class="custom-control-label" for="check_box_asistencia_masiva">Todos asistieron</label>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped data-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th width="10%">Estatus</th>
                <th width="15%">Fechas</th>
                <th>¿Factura?</th>
                <th>Instructor</th>
                <th width="18%">Constancia</th>
                <th width="20%">Operaciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($array_alumnos_publicacion) && is_array($array_alumnos_publicacion) && sizeof($array_alumnos_publicacion) != 0): ?>
                <?php foreach ($array_alumnos_publicacion as $index => $alumno): ?>
                    <tr id="registro_alumno_<?=$alumno->id_alumno?>">
                        <td><?=$index + 1?></td>
                        <td>
                            <ul>
                                <li>
                                    <?=$alumno->apellido_p.' '.$alumno->apellido_m.' '.$alumno->nombre?>
                                </li>
                                <li>
                                    <i class="fa fa-phone"></i> <?=$alumno->telefono_alumno?>
                                </li>
                                <li>
                                    Semaforó de asistencia
                                    <ul>
                                        <li class="mb-1">
                                            <input type="radio" name="asistencia_semaforo_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="custom-radio asistencia_semaforo"
                                                   data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                                   value="no_asiste" <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'no_asiste' ? 'checked':''?>>
                                            <span id="no_asiste_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="badge <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'no_asiste' ? 'badge-danger':'badge-outline-danger'?>">No asiste</span>
                                        </li>
                                        <li class="mb-1">
                                            <input type="radio" name="asistencia_semaforo_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="custom-radio asistencia_semaforo" data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                                   value="no_seguro" <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'no_seguro' ? 'checked':''?>>
                                            <span id="no_seguro_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="badge <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'no_seguro' ? 'badge-warning':'badge-outline-warning'?>">No es seguro</span>
                                        </li>
                                        <li class="mb-1">
                                            <input type="radio" name="asistencia_semaforo_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="custom-radio asistencia_semaforo" data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                                   value="asiste" <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'asiste' ? 'checked':''?>>
                                            <span id="asiste_<?=$alumno->id_alumno_inscrito_ctn_publicado?>" class="badge <?=isset($alumno->semaforo_asistencia) && $alumno->semaforo_asistencia == 'asiste' ? 'badge-success':'badge-outline-success'?>">Confirma asistencia</span>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <label class="custom-control custom-toggle d-block my-2">
                                        <input type="checkbox" class="custom-control-input input_asistencia_alumno" <?=$alumno->asistio == 'si' ? 'checked="checked"':''?>
                                               data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>" >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">¿Asistencia?</span>
                                    </label>
                                </li>
                            </ul>
                        </td>
                        <td>
                            <span class="badge badge-<?=$alumno->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO ? 'success':'warning'?> estatus_inscripcion"><?=$alumno->estatus_inscripcion?></span><hr>
                            <span>¿Datos DC-3?: <?=strtoupper($alumno->envio_datos_dc3)?></span>
                            <?php if($alumno->envio_datos_dc3 == 'si'): ?>
                                <br>
                                <a href="<?=$alumno->documento_dc3->ruta_documento?>" target="_blank">Formulario DC-3</a>
                            <?php endif;?>
                        </td>
                        <td>
                            Pre-inscripción: <?=isset($alumno->fecha_preinscripcion) ? fechaBDToHtml($alumno->fecha_preinscripcion):'Sin registro'?><br>
                            Recibo enviado: <?=isset($alumno->fecha_pago_registrado) ? fechaBDToHtml($alumno->fecha_pago_registrado):'Sin registro'?><br>
                            Recibo Validado: <span class="fecha_pago_validado"><?=isset($alumno->fecha_pago_validado) ? fechaBDToHtml($alumno->fecha_pago_validado):'Sin registro'?></span><br>
                        </td>
                        <td><span class="badge badge-<?=$alumno->requiere_factura == 'si' ? 'success':'danger'?>"><?=$alumno->requiere_factura?></span></td>
                        <td>
                            <span class="instructor_asignado"><?=isset($alumno->instructor) && !is_null($alumno->instructor) ? $alumno->instructor->nombre.' '.$alumno->instructor->apellido_p.' '.$alumno->instructor->apellido_m : 'Sin instructor'?></span>
                        </td>
                        <td>
                            <?php if($alumno->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO): ?>
                                <ul class="text-center">
                                    <li class="mb-3">
                                        <a href="<?=base_url().'DocumentosPDF/constancia_wm/'.$alumno->id_publicacion_ctn.'/'.$alumno->id_alumno_inscrito_ctn_publicado?>"
                                           class="btn btn-success btn-sm btn-pill mr-3"
                                           data-toggle="tooltip"
                                           title="Ver Constancia Walmart" target="_blank">
                                            <i class="fa fa-download fa-white"></i> Constancia WM
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($alumno->id_catalogo_proceso_inscripcion == PROCESO_PAGO_ACTUALIZACION_DATOS): ?>
                                <span class="badge badge-warning">En actualización de datos</span>
                            <?php else: ?>
                                <?php $disabled_op_comprobante = '';
                                if($alumno->id_catalogo_proceso_inscripcion != PROCESO_PAGO_EN_VALIDACION){
                                    $disabled_op_comprobante = 'disabled="disabled"';
                                }
                                ?>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <?php if(isset($alumno->comprobante_pago)
                                            && is_object($alumno->comprobante_pago)): ?>
                                            <a href="<?=$alumno->comprobante_pago->ruta_documento?>" class="btn btn-primary btn-pill btn-sm"
                                               data-toogle="tooltip" title="Ver comprobante de pago"
                                               target="_blank">Ver comprobante</a>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Sin comprobante adjunto</span><br>
                                        <?php endif;?>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="form-group text-center">
                                            <label class="col-form-label">¿Cumple comprobante?</label>
                                            <select id="slt_cumple_comprobante_<?=$alumno->id_alumno?>"
                                                    class="custom-select slt_change_system_civik slt_validar_comprobante_alumno"
                                                    data-btn_validacion="#btn_validacion_comprobante_<?=$alumno->id_alumno?>"
                                                    data-value_show="no" data-destino_show="#observacion_comprobante_<?=$alumno->id_alumno?>"
                                                    data-type_input_destino="textarea" <?=$disabled_op_comprobante?>>
                                                <option value="">Seleccione</option>
                                                <option value="si" <?=$alumno->cumple_comprobante == 'si' ? 'selected="selected"':''?>>Si</option>
                                                <option value="no" <?=$alumno->cumple_comprobante == 'no' ? 'selected="selected"':''?>>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="observacion_comprobante_<?=$alumno->id_alumno?>"
                                            <?=$alumno->cumple_comprobante == 'no' ? '':'style="display: none;"'?>>
                                            <label class="col-form-label">Observación:</label>
                                            <textarea id="txt_observacion_comprobante_<?=$alumno->id_alumno?>" class="form-control" <?=$disabled_op_comprobante?>
                                                      placeholder="Detalle la observación del comprobante"><?=$alumno->observacion_comprobante?></textarea>
                                        </div>
                                        <div class="form-group text-center">
                                            <?php if($alumno->id_catalogo_proceso_inscripcion != PROCESO_PAGO_FINALIZADO_INSCRITO):?>
                                                <button id="btn_validacion_comprobante_<?=$alumno->id_alumno?>" type="button"
                                                        class="btn btn-<?=$alumno->cumple_comprobante == 'si' ? 'success':'danger'?> btn-pill btn-sm btn_validacion_observacion_comprobante_civika"
                                                        data-id_alumno="<?=$alumno->id_alumno?>"
                                                        data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                                    <?=$alumno->cumple_comprobante != '' ? '':'style="display: none;"'?>
                                                    <?=$disabled_op_comprobante?>>
                                                    <?=$alumno->cumple_comprobante == 'si' ? 'Validar e inscribir':'Observar comprobante'?>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>% de asistencia</span>
                                        <input class="form-control civika_actualizacion_campo"
                                               data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                               data-tabla_update="alumno_inscrito_ctn_publicado"
                                               data-campo_update="perciento_asistencia"
                                               data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                               data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               data-destino_respuesta="#respuesta_auto_guardado_porciento_asistencia_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               placeholder="% de asistencia" value="<?=isset($alumno->perciento_asistencia) ? $alumno->perciento_asistencia : ''?>">
                                        <div id="respuesta_auto_guardado_porciento_asistencia_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>Calificación diagnóstica</span>
                                        <input class="form-control civika_actualizacion_campo"
                                               data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                               data-tabla_update="alumno_inscrito_ctn_publicado"
                                               data-campo_update="calificacion_diagnostica"
                                               data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                               data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               data-destino_respuesta="#respuesta_auto_guardado_cal_diagnostica_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               placeholder="Calificación diagnóstica" value="<?=isset($alumno->calificacion_diagnostica) ? $alumno->calificacion_diagnostica : ''?>">
                                        <div id="respuesta_auto_guardado_cal_diagnostica_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>Calificación final</span>
                                        <input class="form-control civika_actualizacion_campo"
                                               data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                               data-tabla_update="alumno_inscrito_ctn_publicado"
                                               data-campo_update="calificacion_final"
                                               data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                               data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               data-destino_respuesta="#respuesta_auto_guardado_cal_final_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                               placeholder="Calificación Final" value="<?=isset($alumno->calificacion_final) ? $alumno->calificacion_final : ''?>">
                                        <div id="respuesta_auto_guardado_cal_final_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
                                    </li>
                                    <?php if($publicacion_ctn->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE): ?>
                                        <li class="list-group-item">
                                            <button type="button" class="btn btn-pill btn-success btn-sm publicacion_eva_subir_material"
                                                    data-lectura="2"
                                                    data-id_alumno_inscrito_ctn_publicado="<?=$alumno->id_alumno_inscrito_ctn_publicado?>">
                                                <i class="fa fa-eye"></i> Ver evidencias
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($publicacion_ctn->aplica_evaluacion == 'si'): ?>
                                        <li class="list-group-item text-center">
                                            <button type="button" class="btn btn-sm btn-pill btn-primary ver_resultados_evaluacion"
                                                    data-id_publicacion_ctn="<?=$publicacion_ctn->id_publicacion_ctn?>"
                                                    data-id_alumno="<?=$alumno->id_alumno?>"><i class="fa-file-text"></i> Ver examenes</button>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Sin registro de alumnos</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
<?php endif; ?>