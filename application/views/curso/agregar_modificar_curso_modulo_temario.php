<div class="modal fade" id="modal_form_curso_modulo_temario" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($ec_curso_modulo_temario) ? 'Modificar  temario' : 'Agregar  temario' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_ec_curso_modulo_temario">
				
				<input type="hidden" name="id_ec_curso_modulo_temario"
					value="<?= isset($ec_curso_modulo_temario->id_ec_curso_modulo_temario) ? $ec_curso_modulo_temario->id_ec_curso_modulo_temario : '' ?>">
				<input type="hidden" name="id_ec_curso_modulo"
					value="<?= isset($id_ec_curso_modulo) ? $id_ec_curso_modulo : '' ?>">
				
				<div class="modal-body">
					
					<div class="form-group row" id="div_tema">
						<label for="tema" class="col-sm-3 col-form-label" >Tema</label>
						<div class="col-sm-9">
							<input id="tema" type="text" placeholder="Escriba el nombre del tema"
								class="form-control" name="tema" data-rule-required="true" 
								value="<?= isset($ec_curso_modulo_temario->tema) ? $ec_curso_modulo_temario->tema : '' ?>">
						</div>
					</div>
					<div class="form-group row" id="div_instrucciones">
						<label for="instrucciones" class="col-sm-3 col-form-label">Instrucciones</label>
						<div class="col-sm-9">
							<textarea id="instrucciones" class="form-control" placeholder="Describa las instrucciones" data-rule-required="true"
								name="instrucciones"><?= isset($ec_curso_modulo_temario->instrucciones) ? $ec_curso_modulo_temario->instrucciones : '' ?></textarea>
						</div>
					</div>
					<div class="form-group row" id="div_contenido_curso">
						<label for="contenido_curso" class="col-sm-3 col-form-label" >Contenido</label>
						<div class="col-sm-9">
							<textarea id="contenido_curso" class="form-control" placeholder="Describa el contenido" data-rule-required="true"
								name="contenido_curso"><?= isset($ec_curso_modulo_temario->contenido_curso) ? $ec_curso_modulo_temario->contenido_curso : '' ?></textarea>
						</div>
					</div>
				
					<div class="form-group row">
						<label for="archivo_eccmt" class="col-sm-3 col-form-label">Archivo:</label>
						<input type="hidden" id="input_id_archivo_ec_curso_modulo_temario" name="id_archivo" value="<?=isset($ec_curso_modulo_temario) ? $ec_curso_modulo_temario->id_archivo : ''?>">
						<input type="file" id="archivo_eccmt" name="archivo_eccmt" class="col-sm-3" accept="*/*" >
						<div id="procesando_archivo_eccmt" class="col-sm-5">
							<?php if (isset($ec_curso_modulo_temario)): ?>
								<p> <?= old($ec_curso_modulo_temario,'archivo') ?><em class="fa fa-times-circle eliminar_archivo" style="color: red"></em></p>
							<?php endif; ?>
						</div>
					</div>

				</div>


				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ec_curso_modulo_temario"
							data-id_ec_curso_modulo="<?= isset($id_ec_curso_modulo) ? $id_ec_curso_modulo : '' ?>"
							class="btn btn-outline-primary btn-sm">Guardar
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
