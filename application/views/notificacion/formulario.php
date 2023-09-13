<div class="card card-danger card-outline">
	<div class="card-header">
		<h3 class="card-title">Nueva notificacón</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<form id="form_notificacion">
			<div class="form-group">
				<select name="destinatarios[]" class="select2" multiple="multiple" data-placeholder="Para:" data-rule-required="true" style="width: 100%;">
					<?php foreach ($usuarios as $u): ?>
						<option value="<?=$u->id_usuario?>"><?=$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m .' - ('.$u->perfil.')'?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<input class="form-control" placeholder="Asunto" name="asunto" data-rule-required="true">
			</div>
			<div class="form-group">
				<textarea id="textarea_notificacion" name="mensaje" class="form-control" data-rule-required="true" ></textarea>
			</div>
			<div class="form-group">
				<input type="file" name="file_adjunto_notificacion" class="archivo_adjunto_notificacion">
				<div id="procesando_adjuntos_notificacion"></div>
				<p class="help-block">Max. 5MB</p>
			</div>
			<div class="form-group" id="contenedor_archivos_notificacion"></div>
		</form>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
		<div class="float-right">
			<!--<button type="button" class="btn btn-default guardar_notificacion" data-tipo_notificacion="borrador"><i class="fas fa-pencil-alt"></i> Borrador</button>-->
			<button type="button" class="btn btn-primary guardar_notificacion" data-tipo_notificacion="enviada"><i class="far fa-envelope"></i> Enviar</button>
		</div>
		<button type="button" class="btn btn-default regresar_notificaciones"><i class="fas fa-times"></i> Cancelar</button>
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->
