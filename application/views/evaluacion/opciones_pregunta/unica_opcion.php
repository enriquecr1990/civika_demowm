<div class="form-group row">
    <label class="col-form-label col-sm-3" for="txt_pregunta_unica_opcion">Pregunta:</label>
	<div class="col-sm-9">
		<textarea id="txt_pregunta_unica_opcion" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
				  name="banco_pregunta[pregunta]"><?=isset($banco_pregunta) ? $banco_pregunta->pregunta : ''?></textarea>
	</div>
</div>

<div class="form-group row">
    <label class="col-form-label col-sm-12">Respuestas:</label>
</div>

<div class="form-group row">
	<div class="col-sm-12 text-right">
		<button type="button" class="btn btn-outline-success btn-sm agregar_row_comun"
				data-origen="#new_row_respuesta_pregunta_up"
				data-destino="#tbody_opciones_pregunta">
			<i class="fa fa-plus"></i> Agregar respuesta
		</button>
	</div>
</div>

<div class="noview" id="new_row_respuesta_pregunta_up">
    <!--
    <tr>
        <td>
            <input type="text" class="form-control" placeholder="Respuesta"
                   name="opcion_pregunta[{id}][descripcion]"
                   data-rule-required="true" value="">
        </td>
        <td class="text-center">
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="value_correcto_si_{id}"
                       name="opcion_pregunta[{id}][tipo_respuesta]"
                       class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                <label class="custom-control-label" for="value_correcto_si_{id}"></label>
            </div>
        </td>
        <td class="text-center">
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="value_correcto_no_{id}"
                       name="opcion_pregunta[{id}][tipo_respuesta]"
                       class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                <label class="custom-control-label" for="value_correcto_no_{id}"></label>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-outline-danger btn-sm eliminar_registro_comun" data-toggle="tooltip"
                    title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    -->
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th rowspan="2">Opciones respuesta</th>
            <th colspan="2" class="text-center">Correcta</th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th class="text-center">Si</th>
            <th class="text-center">No</th>
        </tr>
        </thead>
        <tbody id="tbody_opciones_pregunta">
        <?php if(isset($opcion_pregunta) && is_array($opcion_pregunta)): ?>
            <?php foreach ($opcion_pregunta as $index => $opp): ?>
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Respuesta"
                               name="opcion_pregunta[<?=$index?>][descripcion]"
                               data-rule-required="true" value="<?=$opp->descripcion?>">
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="value_correcto_si_<?=$index?>"
                                   name="opcion_pregunta[<?=$index?>][tipo_respuesta]"
                                   <?=$opp->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
                                   class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
                            <label class="custom-control-label" for="value_correcto_si_<?=$index?>"></label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="value_correcto_no_<?=$index?>"
                                   name="opcion_pregunta[<?=$index?>][tipo_respuesta]"
                                   <?=$opp->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
                                   class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
                            <label class="custom-control-label" for="value_correcto_no_<?=$index?>"></label>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm eliminar_registro_comun" data-toggle="tooltip"
                                title="Eliminar registro"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <div id="contenedor_mensajes_validacion_footer_modal"></div>
</div>
