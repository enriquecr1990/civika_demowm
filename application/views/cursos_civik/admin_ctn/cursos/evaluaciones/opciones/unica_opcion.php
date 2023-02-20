<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <label class="col-form-label" for="txt_pregunta_verdadero_falso">Redacción de la pregunta:</label>
    <textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
              name="pregunta_publicacion_ctn[pregunta]"><?=isset($pregunta_publicacion_ctn) ? $pregunta_publicacion_ctn->pregunta : ''?></textarea>
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12">
    <span class="badge badge-primary">Respuestas:</span>
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 text-right">
    <button type="button" class="btn btn-success btn-pill btn-sm agregar_row_respuesta_pregunta_up"
            data-origen="#new_row_respuesta_pregunta_up"
            data-destino="#tbody_respuesta_pregunta_up">
        <i class="fa fa-plus"></i> Agregar respuesta
    </button>
</div>

<div class="noview" id="new_row_respuesta_pregunta_up">
    <!--
    <tr>
        <td>
            <input type="text" class="form-control" placeholder="Respuesta"
                   name="opcion_pregunta_publicacion_ctn[{id}][descripcion]"
                   data-rule-required="true" value="">
        </td>
        <td class="text-center">
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="value_correcto_si_{id}"
                       name="opcion_pregunta_publicacion_ctn[{id}][tipo_respuesta]"
                       class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                <label class="custom-control-label" for="value_correcto_si_{id}"></label>
            </div>
        </td>
        <td class="text-center">
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="value_correcto_no_{id}"
                       name="opcion_pregunta_publicacion_ctn[{id}][tipo_respuesta]"
                       class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                <label class="custom-control-label" for="value_correcto_no_{id}"></label>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip"
                    title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    -->
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">Opciones respuesta<span class="requerido">*</span></th>
            <th colspan="2" class="text-center">Correcta<span class="requerido">*</span></th>
            <th rowspan="2" width="15px">Operación</th>
        </tr>
        <tr>
            <th class="text-center">Si</th>
            <th class="text-center">No</th>
        </tr>
        </thead>
        <tbody id="tbody_respuesta_pregunta_up">
        <?php if(isset($opciones_pregunta_publicacion_ctn) && is_array($opciones_pregunta_publicacion_ctn)): ?>
            <?php foreach ($opciones_pregunta_publicacion_ctn as $index => $opp): ?>
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Respuesta"
                               name="opcion_pregunta_publicacion_ctn[<?=$index?>][descripcion]"
                               data-rule-required="true" value="<?=$opp->descripcion?>">
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="value_correcto_si_<?=$index?>"
                                   name="opcion_pregunta_publicacion_ctn[<?=$index?>][tipo_respuesta]"
                                   <?=$opp->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
                                   class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                            <label class="custom-control-label" for="value_correcto_si_<?=$index?>"></label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="value_correcto_no_<?=$index?>"
                                   name="opcion_pregunta_publicacion_ctn[<?=$index?>][tipo_respuesta]"
                                   <?=$opp->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
                                   class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                            <label class="custom-control-label" for="value_correcto_no_<?=$index?>"></label>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip"
                                title="Eliminar registro"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <div id="contenedor_mensajes_validacion_footer_modal"></div>
</div>