<div class="modal fade" id="modal_form_ec_evaluacion" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($evaluacion) ? 'Actualizar':'Agregar'?> evaluación </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_evaluacion_ec">
				<div class="modal-body">
					<div class="form-group row">
						<label for="cat_evaluacion" class="col-sm-3 col-form-label">Tipo de evaluacion</label>
						<div class="col-sm-9">
							<input type="hidden" name="id_cat_evaluacion" value="<?=isset($tipo) ? $tipo : EVALUACION_DIAGNOSTICA?>">
							<?php switch($tipo){
								case EVALUACION_DIAGNOSTICA:
									echo '<span class="badge badge-success">Diagnóstica</span>';
									break;
								case EVALUACION_CUESTIONARIO_INSTRUMENTO:
									echo '<span class="badge badge-success">Cuestionario del instrumento</span>';
									break;
								case EVALUACION_ENTREGABLE:
									echo '<span class="badge badge-success">Entregable esperado</span>';
									break;
								case EVALUACION_MODULO:
									echo '<span class="badge badge-success">Módulo</span>';
									break;
								default:
									echo '<span class="badge badge-success">Diagnóstica</span>';
								break;
							} ?>
						</div>
					</div>

					<div id="contenedor_msg_ec_evaluacion"></div>

					<div class="form-group row">
						<label for="input_titulo" class="col-sm-3 col-form-label">Titulo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_titulo" data-rule-required="true"
								   name="titulo" placeholder="Titulo de la evaluación" value="<?=isset($evaluacion) ? $evaluacion->titulo : ''?>">
						</div>
					</div>

					<div class="form-group row">
						<label for="input_tiempo" class="col-sm-3 col-form-label">Tiempo (minutos)</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_tiempo" data-rule-number="true"
								   name="tiempo" placeholder="Tiempo de la evaluación" value="<?=isset($evaluacion) ? $evaluacion->tiempo : ''?>">
							<small class="form-text text-muted">Si desea que no haya tiempo en la evaluación, solo deje el campo vacio o un cero</small>
						</div>
					</div>

					<div class="form-group row">
						<label for="input_tiempo" class="col-sm-3 col-form-label">Intentos de evaluación</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_intentos" data-rule-number="true"
								   name="intentos" placeholder="Intentos de la evaluación" value="<?=isset($evaluacion) ? $evaluacion->intentos : ''?>">
						</div>
					</div>

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_evaluacion_ec" data-id_evaluacion="<?=isset($evaluacion) ? $evaluacion->id_evaluacion : ''?>" class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
