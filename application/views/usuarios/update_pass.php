<div class="modal fade" id="modal_cambiar_password_usuario" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Actualizar contraseña</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_actualizar_password">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_password_cambiar" class="col-sm-3 col-form-label">Contraseña</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="input_password_cambiar" data-rule-required="true" name="password" placeholder="Contraseña">
						</div>
						<div class="col-sm-1">
							<button type="button" data-toggle="tooltip" data-placement="right" title="Ver contraseña"
									class="btn btn-default btn-sm ver_password no_password" data-id_password="#input_password_cambiar"><i class="fas fa-eye"></i></button>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_pass_usr" class="btn btn-sm btn-outline-primary" data-id_usuario="<?=isset($id_usuario) ? $id_usuario : ''?>">Actualizar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
