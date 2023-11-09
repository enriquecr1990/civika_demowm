

<div class="modal fade" id="modal_form_curso_modulo" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($ec_curso_modulo) ? 'Modificar  módulo' : 'Agregar  módulo' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_ec_curso_modulo">
				
				<input type="hidden" name="id_ec_curso_modulo"
					value="<?= isset($ec_curso_modulo->id_ec_curso_modulo) ? $ec_curso_modulo->id_ec_curso_modulo : '' ?>">
				<input type="hidden" name="id_ec_curso"
					value="<?= isset($id_ec_curso) ? $id_ec_curso : '' ?>">
				
				<div class="modal-body">
					
					<div class="form-group row" id="div_instrucciones">
						<label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
						<div class="col-sm-9">
							<textarea id="descripcion" class="form-control" placeholder="Descripción del módulo" data-rule-required="true"
								name="descripcion"><?= isset($ec_curso_modulo->descripcion) ? $ec_curso_modulo->descripcion : '' ?></textarea>
						</div>
					</div>
					<div class="form-group row" id="div_objetivo_general">
						<label for="objetivo_general" class="col-sm-3 col-form-label" >Objetivo general</label>
						<div class="col-sm-9">
							<textarea id="objetivo_general" class="form-control" placeholder="Describa el objetivo general" data-rule-required="true"
								name="objetivo_general"><?= isset($ec_curso_modulo->objetivo_general) ? $ec_curso_modulo->objetivo_general : '' ?></textarea>
						</div>
					</div>
				
					<div class="form-group row" id="div_objetivos_especificos">
						<label for="objetivos_especificos" class="col-sm-3 col-form-label" >Objetivos especificos</label>
						<div class="col-sm-9">
							<textarea id="objetivos_especificos" class="form-control" placeholder="Describa el objetivo general" data-rule-required="true"
								name="objetivos_especificos"><?= isset($ec_curso_modulo->objetivos_especificos) ? $ec_curso_modulo->objetivos_especificos : '' ?></textarea>
						</div>
					</div>

				</div>


				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ec_curso_modulo"
							data-id_ec_curso_modulo="<?= isset($id_ec_curso) ? $id_ec_curso : '' ?>"
							class="btn btn-outline-primary btn-sm">Guardar
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
