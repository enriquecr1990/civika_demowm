<div class="card mb-3">
    <div class="card-header">
        <span class="negrita">Preguntas evaluación</span> <span class="badge badge-info">Evaluación <?=isset($evaluacion_publicacion_ctn->disponible_alumnos) && $evaluacion_publicacion_ctn->disponible_alumnos == 'si' ? 'públicada':' en edición' ?></span>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                <label class="col-form-label" for="tiempo_evaluacion">Título de la evaluación</label>
                <input type="text" placeholder="Título de la evaluación" id="titulo_evaluacion"
                       data-url_peticion="<?=base_url()?>Instructores/actualizar_evaluacion_publicacion_ctn"
                       data-tabla_update="evaluacion_publicacion_ctn"
                       data-campo_update="titulo_evaluacion"
                       <?=isset($evaluacion_publicacion_ctn->disponible_alumnos) && $evaluacion_publicacion_ctn->disponible_alumnos == 'si' ? 'disabled="disabled"':'' ?>
                       data-id_campo_update="id_evaluacion_publicacion_ctn"
                       data-id_value_update="<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       data-destino_respuesta="#respuesta_auto_guardado_tiempo_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       class="form-control civika_actualizacion_campo" value="<?=$evaluacion_publicacion_ctn->titulo_evaluacion?>">
                <span class="help-span">En caso de ser requerido ingrese un valor</span>
                <div id="respuesta_auto_guardado_tiempo_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"></div>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                <label class="col-form-label" for="tiempo_evaluacion">Tiempo de evaluación</label>
                <span class="help-span">(en minutos)</span>
                <input type="number" placeholder="Tiempo de evaluacion (en minutos)" id="tiempo_evaluacion"
                       data-url_peticion="<?=base_url()?>Instructores/actualizar_evaluacion_publicacion_ctn"
                       data-tabla_update="evaluacion_publicacion_ctn"
                       data-campo_update="tiempo_evaluacion"
                    <?=isset($evaluacion_publicacion_ctn->disponible_alumnos) && $evaluacion_publicacion_ctn->disponible_alumnos == 'si' ? 'disabled="disabled"':'' ?>
                       data-id_campo_update="id_evaluacion_publicacion_ctn"
                       data-id_value_update="<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       data-destino_respuesta="#respuesta_auto_guardado_tiempo_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       class="form-control civika_actualizacion_campo" value="<?=$evaluacion_publicacion_ctn->tiempo_evaluacion?>">
                <span class="help-span">En caso de ser requerido ingrese un valor</span>
                <div id="respuesta_auto_guardado_tiempo_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"></div>
            </div>
            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                <label class="col-form-label" for="intentos_evaluacion">Número de intentos de evaluación</label>
                <input type="number" placeholder="Numero de intentos para realizar la evaluación" id="intentos_evaluacion"
                       data-url_peticion="<?=base_url()?>Instructores/actualizar_evaluacion_publicacion_ctn"
                       data-tabla_update="evaluacion_publicacion_ctn"
                       data-campo_update="intentos_evaluacion"
                       data-id_campo_update="id_evaluacion_publicacion_ctn"
                       data-id_value_update="<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       data-destino_respuesta="#respuesta_auto_guardado_intentos_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                       class="form-control civika_actualizacion_campo" value="<?=$evaluacion_publicacion_ctn->intentos_evaluacion?>">
                <span class="help-span">En caso de ser requerido ingrese un valor</span>
                <div id="respuesta_auto_guardado_intentos_evaluacion_<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"></div>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Pregunta</th>
                    <th>Tipo</th>
                    <th width="30%">
                        Repuestas
                        <br><span class="help-span">Las verdes son correctas</span>
                    </th>
                    <th>Operaciones</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($preguntas_publicacion_ctn) && is_array($preguntas_publicacion_ctn) && sizeof($preguntas_publicacion_ctn) != 0): ?>
                    <?php foreach ($preguntas_publicacion_ctn as $index => $ppc): ?>
                        <tr>
                            <td><?=$index + 1?></td>
                            <td><?=$ppc->pregunta?></td>
                            <td><?=$ppc->opcion_pregunta?></td>
                            <td class="text-justify">
                                <ul class="lista_respuestas_evaluacion">
                                    <?php if(isset($ppc->opciones_pregunta_publicacion_ctn) && is_array($ppc->opciones_pregunta_publicacion_ctn)): ?>
                                        <?php if($ppc->id_opciones_pregunta == OPCION_RELACIONAL): ?>
                                            <li style="list-style: none"><span class="badge badge-info">Preguntas de lado izquierdo</span></li>
                                            <li style="list-style: none"><span class="badge badge-success">Preguntas de lado derecho y respuestas correctas</span></li>
                                        <?php endif; ?>
                                        <?php foreach ($ppc->opciones_pregunta_publicacion_ctn as $opcion): ?>
                                            <?php if($ppc->id_opciones_pregunta == OPCION_SECUENCIAL): ?>
                                                <li>
                                                    <?=$opcion->descripcion?>: <span class="badge badge-success"><?=$opcion->orden_pregunta?></span>
                                                </li>
                                            <?php elseif($ppc->id_opciones_pregunta == OPCION_RELACIONAL): ?>
                                                <li>
                                                    <span class="badge badge-<?=$opcion->pregunta_relacional == 'izquierda' ? 'info':'success'?>"><?=$opcion->orden_pregunta?></span>
                                                    <?=$opcion->descripcion?>
                                                </li>
                                            <?php else: ?>
                                                <li class="<?=$opcion->tipo_respuesta == 'correcta' ? 'correcta':'incorrecta'?>">
                                                    <span ><?=$opcion->descripcion?></span>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(isset($opcion->documento_imagen_respuesta) && is_object($opcion->documento_imagen_respuesta)): ?>
                                                <div>
                                                    <img class="img-thumbnail <?=$opcion->tipo_respuesta == 'correcta' ? 'img_correcta':''?>" style="width: 75px !important;" src="<?=$opcion->documento_imagen_respuesta->ruta_documento?>" alt="<?=$opcion->documento_imagen_respuesta->nombre?>">
                                                </div>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <td>
                                <?php if(isset($evaluacion_publicacion_ctn->disponible_alumnos) && $evaluacion_publicacion_ctn->disponible_alumnos == 'no'): ?>
                                    <ul class="text-center">
                                        <li class="mb-1">
                                            <button class="btn btn-sm btn-pill btn-primary evaluacion_publicacion_ctn_modificar_pregunta"
                                                    data-id_evaluacion_publicacion_ctn="<?=$ppc->id_evaluacion_publicacion_ctn?>"
                                                    data-id_pregunta_publicacion_ctn="<?=$ppc->id_pregunta_publicacion_ctn?>">
                                                <i class="fa fa-pencil"></i> Modificar
                                            </button>
                                        </li>
                                        <li class="mb-1">
                                            <button class="btn btn-sm btn-pill btn-danger eliminar_registro_table_comun"
                                                    data-url_operacion="<?=base_url().'Instructores/eliminar_pregunta_pregunta_evaluacion_ctn/'.$ppc->id_pregunta_publicacion_ctn?>"
                                                    data-msg_operacion="Se eliminará la pregunta del sistema <label>¿deseá continuar?</label>"
                                                    data-btn_trigger="#btn_buscar_preguntas_evaluacion">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </button>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>