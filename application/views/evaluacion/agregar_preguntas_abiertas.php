<div class="modal fade" role="dialog" id="modal_form_pregunta_abierta">
	<div class="modal-dialog modal-lg'> " id="modal_tamanio_preguntas_abiertas" role="document">
		<div class="modal-content">
			<div class="modal-header card-header">
				<h5 class="modal-title"><?=isset($pregunta_abierta) ? 'Modificar' : 'Agregar'?> Pregunta abierta</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>

			<form id="form_guardar_pregunta_abierta">

				<div class="modal-body">
				<div class="form-group row">
					<label class="col-form-label col-sm-3" for="txt_pregunta_abierta">Pregunta:</label>
					<div class="col-sm-9">
						<textarea id="txt_pregunta_abierta" class="form-control" placeholder="Describa la pregunta abierta" data-rule-required="true"
								name="pregunta_formulario_abierto"><?=isset($pregunta_abierta) ? $pregunta_abierta->pregunta_formulario_abierto : ''?></textarea>
					</div>
				</div>

				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-outline-success btn-sm" id="guardar_preguntas_abiertas"
							data-id_cat_pregunta_formulario_abierto="<?=isset($pregunta_abierta) ? $pregunta_abierta->id_cat_pregunta_formulario_abierto : ''?>"
							data-id_formulario="<?=isset($id_formulario) ? $id_formulario : ''?>" >Aceptar</button>
				</div>
			</form>
		</div>
	</div>
</div>
