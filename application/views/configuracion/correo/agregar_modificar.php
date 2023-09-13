<div class="modal fade" id="modal_form_config_correo" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($config_correo) ? 'Actualizar':'Nuevo'?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_config_correo">
				<input type="hidden" name="id_config_correo" value="<?=isset($config_correo) ? $config_correo->id_config_correo : ''?>">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_smtp_secure" class="col-sm-3 col-form-label">SMTP secure</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_smtp_secure" data-rule-required="true"
								   name="smtp_secure" placeholder="SMTP Secure" value="<?=isset($config_correo) ? $config_correo->smtp_secure : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_host" class="col-sm-3 col-form-label">Host</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_host" data-rule-required="true"
								   name="host" placeholder="Nombre del Host" value="<?=isset($config_correo) ? $config_correo->host : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_port" class="col-sm-3 col-form-label">Port</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_port" data-rule-required="true"
								   name="port" placeholder="Número de Puerto" value="<?=isset($config_correo) ? $config_correo->port : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_usuario" class="col-sm-3 col-form-label">Usuario (correo)</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_usuario" data-rule-required="true"
								   name="usuario" placeholder="Usuario o correo de salida" value="<?=isset($config_correo) ? $config_correo->usuario : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_password" class="col-sm-3 col-form-label">Contraseña</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_password" data-rule-required="true"
								   name="password" placeholder="Contraseña del correo" value="<?=isset($config_correo) ? $config_correo->password : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_name" class="col-sm-3 col-form-label">A nombre de</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_name"
								   name="name" placeholder="A nombre de (quien)" value="<?=isset($config_correo) ? $config_correo->name : ''?>">
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_config_correo"
							data-id_config_correo="<?=isset($config_correo) ? $config_correo->id_config_correo : ''?>"
							class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
