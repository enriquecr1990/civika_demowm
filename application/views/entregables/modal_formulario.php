<div class="modal fade" id="modal_form_entregable" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($entregable) ? 'Modificar Entregable' : 'Agregar Entregable' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form id="form_agregar_modificar_entregable">
				<input hidden name="id_entregable" value="<?= isset($entregable) ? $entregable->id_entregable : '' ?>">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="nombre" data-rule-required="true"
								   name="nombre" placeholder="Nombre del entregable"
								   value="<?= old($entregable, 'nombre') ?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Descripción</label>
						<div class="col-sm-9">
							<textarea type="text" class="form-control" id="descripcion" data-rule-required="true"
									  name="descripcion"
									  placeholder="Descripción del entregable"><?= old($entregable, 'descripcion') ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Instrucciones</label>
						<div class="col-sm-9">
							<textarea type="text" class="form-control" id="instrucciones" data-rule-required="true"
									  name="instrucciones" placeholder="Instrucciones del entregable"
							><?= old($entregable, 'instrucciones') ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Tipo de entregable</label>
						<div class="col-sm-9">
							<select type="text" class="form-control" id="tipo_entregable" data-rule-required="true"
									name="tipo_entregable">
								<option value="">Seleccione una opción</option>
								<option
									value="prod" <?= old($entregable, 'tipo_entregable') == 'prod' ? 'selected' : '' ?> >
									Producto (archivo)
								</option>
								<option
									value="form" <?= old($entregable, 'tipo_entregable') == 'form' ? 'selected' : '' ?>>
									Formulario
								</option>
								<option
									value="cuest" <?= old($entregable, 'tipo_entregable') == 'cuest' ? 'selected' : '' ?>>
									Cuestionario
								</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Material de de apoyo </label>
						<div class="col-sm-9">
							<input type="hidden" id="input_material_apoyo" name="id_archivo"
								   value="<?= isset($entregable->id_archivo) ? $entregable->id_archivo : '' ?>">
							<input type="file" id="material_apoyo" name="material_apoyo" class="col-sm-3" accept="/*">
							<div id="procesando_material_apoyo" class="col-sm-5">
								<?php if (isset($entregable->archivo)): ?>
									<p> <?= old($entregable, 'archivo') ?><em
											class="fa fa-times-circle eliminar_archivo" style="color: red"></em></p>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="input_nombre" class="col-sm-3 col-form-label">Intrumentos</label>
						<div class="col-sm-9">
							<label for="instrumentos"></label>
							<select multiple="multiple" class="form-control" id="instrumentos" name="instrumentos[]">

								<?php if (isset($instrumentos)): ?>
								<?php foreach ($instrumentos as $instrumento): ?>
								<optgroup label="<?= $instrumento->nombre ?>">
									<?php foreach ($instrumento->actividades as $item): ?>
										<option value="<?= $item->id_ec_instrumento_has_actividad ?>"
											<?php if (isset($entregable)): ?>
												<?= in_array($item->id_ec_instrumento_has_actividad, old($entregable, 'instrumentos')) ? 'selected' : '' ?>
											<?php endif; ?>
										> <?= $item->actividad ?>

										</option>
									<?php endforeach; ?>
									<?php endforeach; ?>
									<?php endif; ?>

							</select>
							<small id="emailHelp" class="form-text text-muted">Precione la tecla CTRL para seleccionar
								más de una opción</small>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_entregable"
							data-modificacion_from_perfil="<?= isset($modificacion_from_perfil) ? $modificacion_from_perfil : 'no' ?>"
							class="btn btn-sm btn-outline-primary">Guardar
					</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
