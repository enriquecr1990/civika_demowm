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
    <div class="row">
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
                <th rowspan="2" class="vertical-center">#</th>
                <th rowspan="2" class="vertical-center text-center" width="30%">Alumno</th>
                <th rowspan="2" class="vertical-center text-center" width="18%">Constancia(s)</th>
                <th rowspan="2" class="vertical-center text-center">% de Asistencia</th>
                <th colspan="2" class="text-center">Evaluacion</th>
            </tr>
            <tr>
                <th class="text-center">Diagnóstica</th>
                <th class="text-center">Final</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($array_alumnos_publicacion) && is_array($array_alumnos_publicacion) && sizeof($array_alumnos_publicacion) != 0): ?>
                <?php foreach ($array_alumnos_publicacion as $index => $alumno): ?>
                    <tr id="registro_alumno_<?=$alumno->id_alumno?>">
                        <td class="vertical-center"><?=$index + 1?></td>
                        <td class="vertical-center">
                            <ul>
                                <li>
                                    <?=$alumno->apellido_p.' '.$alumno->apellido_m.' '.$alumno->nombre?>
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
                            <?php if($alumno->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO): ?>
                                <ul class="text-center">
                                    <?php if(isset($publicacion_ctn->aplica_dc3) && $publicacion_ctn->aplica_dc3 ): ?>
                                        <li class="mb-3">
                                            <a href="<?=base_url().'DocumentosPDF/constancia_dc3/'.$alumno->id_alumno.'/'.$alumno->id_publicacion_ctn?>"
                                               class="btn btn-info btn-sm btn-pill mr-3"
                                               data-toggle="tooltip"
                                               title="Ver DC-3" target="_blank">
                                                <i class="fa fa-download fa-white"></i> DC-3
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(isset($publicacion_ctn->aplica_habilidades) && $publicacion_ctn->aplica_habilidades ): ?>
                                        <li class="mb-3">
                                            <a href="<?=base_url().'DocumentosPDF/habilidades_const/'.$alumno->id_alumno .'/'.$publicacion_ctn->id_publicacion_ctn?>"
                                               class="btn btn-success btn-sm btn-pill mr-3"
                                               data-toggle="tooltip"
                                               title="Ver Constancia Habilidades" target="_blank">
                                                <i class="fa fa-download fa-white"></i> Habilidades
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php if(isset($publicacion_ctn->aplica_otra) && $publicacion_ctn->aplica_otra ): ?>
                                        <li><span class="help-span"><?=$publicacion_ctn->aplica_otra->especifique_otra_constancia?></span></li>
                                        <li class="mb-3">
                                            <a href="<?=base_url().'DocumentosPDF/constancia_cigede/'.$alumno->id_alumno .'/'.$publicacion_ctn->id_publicacion_ctn?>"
                                               class="btn btn-warning btn-sm btn-pill mr-3 text-white"
                                               data-toggle="tooltip"
                                               title="Ver Constancia Cigede" target="_blank">
                                                <i class="fa fa-download fa-white"></i> Otra
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a href="<?=base_url().'DocumentosPDF/constancia_cigede_blanco/'.$alumno->id_alumno .'/'.$publicacion_ctn->id_publicacion_ctn?>"
                                               class="btn btn-warning btn-sm btn-pill mr-3 text-white"
                                               data-toggle="tooltip"
                                               title="<?=$publicacion_ctn->aplica_otra->especifique_otra_constancia?>" target="_blank">
                                                <i class="fa fa-download fa-white"></i> Otra blanco
                                            </a>
                                        </li>
                                    <?php endif;?>
                                </ul>
                            <?php endif; ?>
                        </td>
                        <td class="vertical-center">
                            <input class="form-control civika_actualizacion_campo"
                                   data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                   data-tabla_update="alumno_inscrito_ctn_publicado"
                                   data-campo_update="perciento_asistencia"
                                   data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                   data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   data-destino_respuesta="#respuesta_auto_guardado_porciento_asistencia_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   placeholder="% de asistencia" value="<?=isset($alumno->perciento_asistencia) ? $alumno->perciento_asistencia : ''?>">
                            <div id="respuesta_auto_guardado_porciento_asistencia_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
                        </td>
                        <td class="vertical-center">
                            <input class="form-control civika_actualizacion_campo"
                                   data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                   data-tabla_update="alumno_inscrito_ctn_publicado"
                                   data-campo_update="calificacion_diagnostica"
                                   data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                   data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   data-destino_respuesta="#respuesta_auto_guardado_cal_diagnostica_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   placeholder="Calificación diagnóstica" value="<?=isset($alumno->calificacion_diagnostica) ? $alumno->calificacion_diagnostica : ''?>">
                            <div id="respuesta_auto_guardado_cal_diagnostica_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
                        </td>
                        <td class="vertical-center">
                            <input class="form-control civika_actualizacion_campo"
                                   data-url_peticion="<?=base_url()?>Instructores/actualizar_asistencia_calificaciones"
                                   data-tabla_update="alumno_inscrito_ctn_publicado"
                                   data-campo_update="calificacion_final"
                                   data-id_campo_update="id_alumno_inscrito_ctn_publicado"
                                   data-id_value_update="<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   data-destino_respuesta="#respuesta_auto_guardado_cal_final_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"
                                   placeholder="Calificación Final" value="<?=isset($alumno->calificacion_final) ? $alumno->calificacion_final : ''?>">
                            <div id="respuesta_auto_guardado_cal_final_<?=$alumno->id_alumno_inscrito_ctn_publicado?>"></div>
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