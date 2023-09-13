<input type="hidden" id="tipo_usuario" value="admin">
<div class="form-group row">
	<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
	<div class="col-sm-9">
		<input type="text" class="form-control" id="input_nombre" data-rule-required="true"
			   name="nombre" placeholder="Nombre del usuario" value="<?=isset($usuario) ? $usuario->nombre : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_paterno" class="col-sm-3 col-form-label">Paterno</label>
	<div class="col-sm-9">
		<input type="text" class="form-control" id="input_paterno" data-rule-required="true" name="apellido_p" placeholder="Apellido paterno"
			   value="<?=isset($usuario) ? $usuario->apellido_p : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_materno" class="col-sm-3 col-form-label">Materno</label>
	<div class="col-sm-9">
		<input type="text" class="form-control" id="input_materno" data-rule-required="true" name="apellido_m"
			   placeholder="Apellido materno" value="<?=isset($usuario) ? $usuario->apellido_m : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_genero" class="col-sm-3 col-form-label">Genero</label>
	<div class="col-sm-9">
		<div class="custom-control custom-radio">
			<input class="custom-control-input" type="radio" data-rule-required="true" id="input_genero" name="genero"
				   value="m" <?=isset($usuario) && $usuario->genero == 'm' ? 'checked="checked"':''?>>
			<label for="input_genero" class="custom-control-label">Masculino</label>
		</div>
		<div class="custom-control custom-radio">
			<input class="custom-control-input" type="radio" id="input_genero_f" name="genero" value="f" <?=isset($usuario) && $usuario->genero == 'f' ? 'checked="checked"':''?>>
			<label for="input_genero_f" class="custom-control-label">Femenino</label>
		</div>
	</div>
</div>

<div class="form-group row">
	<label for="input_fecha_nacimiento" class="col-sm-3 col-form-label">Fecha de nacimiento</label>
	<div class="col-sm-9">
		<input type="date" class="form-control" id="input_fecha_nacimiento" data-rule-required="true" name="fecha_nacimiento" placeholder="dd/mm/yyyy"
			   value="<?=isset($usuario) ? $usuario->fecha_nacimiento : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_correo" class="col-sm-3 col-form-label">Email</label>
	<div class="col-sm-9">
		<input type="email" class="form-control" id="input_correo" data-rule-required="true" name="correo"
			   placeholder="Correo electrónico" value="<?=isset($usuario) ? $usuario->correo : ''?>">
		<?php if(!isset($usuario)): ?>
			<small class="form-text text-muted">El correo se registrará como usuario del sistema</small>
		<?php endif; ?>
	</div>
</div>

<div class="form-group row">
	<label for="input_celular" class="col-sm-3 col-form-label">Celular</label>
	<div class="col-sm-9">
		<input type="text" data-rule-required="true" id="input_celular" name="celular" placeholder="Número de telefono" class="form-control"
			   data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" value="<?=isset($usuario) ? $usuario->celular : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_telefono" class="col-sm-3 col-form-label">Telefono</label>
	<div class="col-sm-9">
		<input type="text" id="input_telefono" name="telefono" placeholder="Número de telefono" class="form-control"
			   data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" value="<?=isset($usuario) ? $usuario->telefono : ''?>">
	</div>
</div>

<?php if(!isset($usuario)): ?>
	<div class="form-group row">
		<label for="input_password" class="col-sm-3 col-form-label">Contraseña</label>
		<div class="col-sm-8">
			<input type="password" class="form-control" id="input_password" data-rule-required="true" name="password" placeholder="Contraseña">
		</div>
		<div class="col-sm-1">
			<button type="button" data-toggle="tooltip" data-placement="right" title="Ver contraseña" class="btn btn-default btn-sm ver_password no_password" data-id_password="#input_password"><i class="fas fa-eye"></i></button>
		</div>
	</div>
<?php endif; ?>
