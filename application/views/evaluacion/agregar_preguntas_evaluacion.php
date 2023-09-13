<div class="modal fade" role="dialog" id="modal_form_evaluacion_pregunta">
	<div class="modal-dialog <?=isset($banco_pregunta->id_cat_tipo_opciones_pregunta) && $banco_pregunta->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL ? 'modal-xl':'modal-lg'?> " id="modal_tamanio_preguntas_evaluacion" role="document">
		<div class="modal-content">
			<div class="modal-header card-header">
				<h5 class="modal-title"><?=isset($banco_pregunta) ? 'Modificar' : 'Agregar'?> pregunta evaluación</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<form id="form_guardar_pregunta_evaluacion">

				<div class="modal-body">
					<div class="form-group row">
						<label for="slt_opcion_pregunta_form" class="col-sm-3 col-form-label">Tipo de pregunta:</label>
						<div class="col-sm-9">
							<select id="slt_opcion_pregunta_form" class="custom-select form-control-border"
									data-rule-required="true" name="banco_pregunta[id_cat_tipo_opciones_pregunta]">
								<option value="">--Seleccione--</option>
								<?php if(isset($cat_tipo_opciones_pregunta)): ?>
									<?php foreach ($cat_tipo_opciones_pregunta as $ctop): ?>
										<option value="<?=$ctop->id_cat_tipo_opciones_pregunta?>" <?=isset($banco_pregunta) && $banco_pregunta->id_cat_tipo_opciones_pregunta == $ctop->id_cat_tipo_opciones_pregunta ? 'selected="selected"':''?>><?=$ctop->nombre?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>

					<div id="destino_registro_opciones_pregunta_complemento">
						<?php if(isset($banco_pregunta)): ?>
							<?php switch ($banco_pregunta->id_cat_tipo_opciones_pregunta){
								case OPCION_VERDADERO_FALSO:
									$this->load->view('evaluacion/opciones_pregunta/verdadero_falso');
									break;
								case OPCION_UNICA_OPCION:
									$this->load->view('evaluacion/opciones_pregunta/unica_opcion');
									break;
								case OPCION_OPCION_MULTIPLE:
									$this->load->view('evaluacion/opciones_pregunta/opcion_multiple');
									break;
								case OPCION_IMAGEN_UNICA_OPCION:
									$this->load->view('evaluacion/opciones_pregunta/img_unica_opcion');
									break;
								case OPCION_IMAGEN_OPCION_MULTIPLE:
									$this->load->view('evaluacion/opciones_pregunta/img_opcion_multiple');
									break;
								case OPCION_SECUENCIAL:
									$this->load->view('evaluacion/opciones_pregunta/secuenciales');
									break;
								case OPCION_RELACIONAL:
									$this->load->view('evaluacion/opciones_pregunta/relacionales');
									break;
							}
							?>
						<?php endif; ?>
					</div>

				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-outline-success btn-sm" id="guardar_preguntas_evaluacion_ec"
							data-id_banco_pregunta="<?=isset($banco_pregunta) ? $banco_pregunta->id_banco_pregunta : ''?>"
							data-id_evaluacion="<?=isset($id_evaluacion) ? $id_evaluacion : ''?>" >Aceptar</button>
				</div>
			</form>
		</div>
	</div>
</div>
