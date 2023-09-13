<div class="form-group row">
    <label class="col-form-label col-sm-3" for="txt_pregunta_verdadero_falso">Pregunta:</label>
	<div class="col-sm-9">
		<textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
				  name="banco_pregunta[pregunta]"><?=isset($banco_pregunta) ? $banco_pregunta->pregunta : ''?></textarea>
	</div>
</div>


<div class="col-12">
	<div class="card">
		<div class="card-body table-responsive p-0">
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
				<tbody id="tbody_opciones_pregunta">
					<!-- verdadero -->
					<tr>
						<td>
							<label>Verdadero</label>
							<input type="hidden" value="Verdadero" name="opcion_pregunta[1][descripcion]"
								   data-rule-required="true">
						</td>
						<td class="text-center">
							<div class="custom-control custom-radio mb-3">
								<input type="radio" id="value_correcto_si"
									   name="opcion_pregunta[1][tipo_respuesta]"
									   <?=isset($opcion_pregunta) && $opcion_pregunta[0]->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
									   class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
								<label class="custom-control-label" for="value_correcto_si"></label>
							</div>
						</td>
						<td class="text-center">
							<div class="custom-control custom-radio mb-3">
								<input type="radio" id="value_correcto_no"
									   name="opcion_pregunta[1][tipo_respuesta]"
									<?=isset($opcion_pregunta) && $opcion_pregunta[0]->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
									   class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
								<label class="custom-control-label" for="value_correcto_no"></label>
							</div>
						</td>
					</tr>
					<!-- falso -->
					<tr>
						<td>
							<label>Falso</label>
							<input type="hidden" value="Falso" name="opcion_pregunta[2][descripcion]"
								   data-rule-required="true">
						</td>
						<td class="text-center">
							<div class="custom-control custom-radio mb-3">
								<input type="radio" id="value_incorrecto_si"
									   name="opcion_pregunta[2][tipo_respuesta]"
									<?=isset($opcion_pregunta) && $opcion_pregunta[1]->tipo_respuesta == 'correcta' ? 'checked="checked"':'' ?>
									   class="custom-control-input radio_verdadero_correcta" data-rule-required="true" value="correcta">
								<label class="custom-control-label" for="value_incorrecto_si"></label>
							</div>
						</td>
						<td class="text-center">
							<div class="custom-control custom-radio mb-3">
								<input type="radio" id="value_incorrecto_no"
									   name="opcion_pregunta[2][tipo_respuesta]"
									<?=isset($opcion_pregunta) && $opcion_pregunta[1]->tipo_respuesta == 'incorrecta' ? 'checked="checked"':'' ?>
									   class="custom-control-input radio_verdadero_incorrecta" value="incorrecta">
								<label class="custom-control-label" for="value_incorrecto_no"></label>
							</div>
						</td>
					</tr>
				</tbody>
    		</table>
		</div>
	</div>
</div>
