<input type="hidden" id="tipo_usuario" value="candidato">
<div class="form-group row">
	<label for="input_nombre" class="col-sm-3 col-form-label">Nombre</label>
	<div class="col-sm-9">
		<input type="text" class="form-control" id="input_nombre" data-rule-required="true"
			   name="nombre" placeholder="Nombre del candidato" value="<?=isset($usuario) ? $usuario->nombre : ''?>">
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

<?php if(isset($modificacion_from_perfil) && $modificacion_from_perfil == 'si'): ?>

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
		<label for="input_lugar_nacimiento" class="col-sm-3 col-form-label">Lugar de nacimiento</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="input_lugar_nacimiento" data-rule-required="true" name="lugar_nacimiento" placeholder="Lugar de nacimiento"
				   value="<?=isset($usuario) ? $usuario->lugar_nacimiento : ''?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="input_nacionalidad" class="col-sm-3 col-form-label">Nacionalidad</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="input_nacionalidad" data-rule-required="true" name="nacionalidad" placeholder="Nacionalidad"
				   value="<?=isset($usuario) ? $usuario->nacionalidad : ''?>">
		</div>
	</div>

	<div class="form-group row">
		<label for="input_celular" class="col-sm-3 col-form-label">Celular</label>
		<div class="col-sm-9">
			<input type="text" data-rule-required="true" id="input_celular" name="celular" placeholder="Número de celular" class="form-control"
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

<?php endif; ?>

<div class="form-group row">
	<label for="input_correo" class="col-sm-3 col-form-label">Email</label>
	<div class="col-sm-9">
		<input type="email" class="form-control" id="input_correo" data-rule-required="true" name="correo"
			   placeholder="Correo electrónico" value="<?=isset($usuario) ? $usuario->correo : ''?>">
	</div>
</div>

<div class="form-group row">
	<label for="input_curp" class="col-sm-3 col-form-label">CURP</label>
	<div class="col-sm-9">
		<input type="text" class="form-control input_str_mayus" id="input_curp" data-rule-required="true" data-rule-minlength="18" data-rule-maxlength="18" name="curp"
			   placeholder="Clave Única de Registro de Población CURP" value="<?=isset($usuario) ? $usuario->curp : ''?>">
		<?php if(!isset($usuario)): ?>
			<small class="form-text text-muted">El CURP se registrará como usuario del sistema y como contraseña (únicamente los primeros 10 carácteres)</small>
		<?php endif; ?>
	</div>
</div>

<div class="form-group row">
	<label for="input_sector_productivo" class="col-sm-3 col-form-label">Sector productivo de trabajo</label>
	<div class="col-sm-9">
		<select class="custom-select" id="input_sector_productivo" data-rule-required="true" name="id_cat_sector_productivo">
			<option value="">--Seleccione--</option>
			<?php foreach ($cat_sector_productivo as $csp): ?>
				<option value="<?=$csp->id_cat_sector_productivo?>" <?=isset($usuario->id_cat_sector_productivo) && $usuario->id_cat_sector_productivo == $csp->id_cat_sector_productivo ? 'selected="selected"':'' ?> ><?=$csp->nombre?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
