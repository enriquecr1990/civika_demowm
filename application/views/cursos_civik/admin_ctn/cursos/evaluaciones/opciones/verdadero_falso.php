<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <label class="col-form-label" for="txt_pregunta_verdadero_falso">Redacción de la pregunta:</label>
    <textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
              name="pregunta_publicacion_ctn[pregunta]"><?=isset($pregunta_publicacion_ctn) ? $pregunta_publicacion_ctn->pregunta : ''?></textarea>
</div>

<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <span class="badge badge-primary">Respuestas:</span>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">Opciones respuesta</th>
            <th colspan="2" class="text-center">Correcta</th>
        </tr>
        <tr>
            <th class="text-center">Si</th>
            <th class="text-center">No</th>
        </tr>
        </thead>
        <tbody>
        <!-- verdadero -->
        <tr>
            <td>
                <label>Verdadero</label>
                <input type="hidden" value="Verdadero" name="opcion_pregunta_publicacion_ctn[1][descripcion]"
                       data-rule-required="true">
            </td>
            <td class="text-center">
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="value_correcto_si"
                           name="opcion_pregunta_publicacion_ctn[1][tipo_respuesta]"
                           <?=isset($opciones_pregunta_publicacion_ctn) && $opciones_pregunta_publicacion_ctn[0]->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
                           class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                    <label class="custom-control-label" for="value_correcto_si"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="value_correcto_no"
                           name="opcion_pregunta_publicacion_ctn[1][tipo_respuesta]"
                        <?=isset($opciones_pregunta_publicacion_ctn) && $opciones_pregunta_publicacion_ctn[0]->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
                           class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                    <label class="custom-control-label" for="value_correcto_no"></label>
                </div>
            </td>
        </tr>
        <!-- falso -->
        <tr>
            <td>
                <label>Falso</label>
                <input type="hidden" value="Falso" name="opcion_pregunta_publicacion_ctn[2][descripcion]"
                       data-rule-required="true">
            </td>
            <td class="text-center">
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="value_incorrecto_si"
                           name="opcion_pregunta_publicacion_ctn[2][tipo_respuesta]"
                        <?=isset($opciones_pregunta_publicacion_ctn) && $opciones_pregunta_publicacion_ctn[1]->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
                           class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                    <label class="custom-control-label" for="value_incorrecto_si"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="value_incorrecto_no"
                           name="opcion_pregunta_publicacion_ctn[2][tipo_respuesta]"
                        <?=isset($opciones_pregunta_publicacion_ctn) && $opciones_pregunta_publicacion_ctn[1]->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
                           class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                    <label class="custom-control-label" for="value_incorrecto_no"></label>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="contenedor_mensajes_validacion_footer_modal"></div>
</div>