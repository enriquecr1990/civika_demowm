<div class="col-md-3">

	<!-- Profile Image -->
	<div class="card card-primary card-outline">
		<div class="card-body box-profile">
			<div class="text-center">
				<img class="profile-user-img img-fluid img-circle img_foto_perfil"
					 src="<?=isset($usuario_modificar->foto_perfil) ? $usuario_modificar->foto_perfil : base_url('/assets/imgs/iconos/admin.png')?>"
					 alt="Foto de perfil">
			</div>

			<h3 class="profile-username text-center">
				<?php if(isset($usuario_modificar->datos_usuario) && is_object($usuario_modificar->datos_usuario)): ?>
					<?=$usuario_modificar->datos_usuario->nombre.' '.$usuario_modificar->datos_usuario->apellido_p.' '.$usuario_modificar->datos_usuario->apellido_m ?>
				<?php else: ?>
					<?=$usuario_modificar->usuario?>
				<?php endif; ?>
			</h3>

			<p class="text-muted text-center">
				<?php switch ($usuario_modificar->perfil){
					case 'root':case 'admin': echo 'Administrador del sistema';break;
					case 'instructor': echo 'Evaluador';break;
					case 'alumno': echo 'Alumno/Candidato';break;
				}?>
			</p>

			<?php if(isset($usuario_modificar->datos_usuario) && is_object($usuario_modificar->datos_usuario)): ?>
				<ul class="list-group list-group-unbordered mb-3">
					<li class="list-group-item">
						<b><?=$usuario_modificar->datos_usuario->genero == 'm' ? 'Masculino':'Femenino'?></b>
					</li>
					<li class="list-group-item">
						<b><?=$usuario_modificar->datos_usuario->correo?></b>
					</li>
					<li class="list-group-item">
						<b>
							<?=isset($usuario_modificar->datos_usuario->celular) ? $usuario_modificar->datos_usuario->celular : ''?>
							<?=isset($usuario_modificar->datos_usuario->telefono) != '' && $usuario_modificar->datos_usuario->telefono != '' ? '/':''?>
							<?=isset($usuario_modificar->datos_usuario->telefono) ? $usuario_modificar->datos_usuario->telefono : ''?>
						</b>
					</li>
				</ul>
			<?php endif; ?>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->

	<!-- About Me Box -->
	<?php if(isset($datos_usuario_modificar) && is_object($datos_usuario_modificar)): ?>
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Acerca de mí</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">

				<strong><i class="fas fa-user-tie mr-1"></i> Profesión / Cargo</strong>

				<p class="text-muted">
					<span class="span_profesion"><?=$datos_usuario_modificar->profesion != '' ? $datos_usuario_modificar->profesion : 'Sin datos'?></span> / <span class="span_puesto_laboral"><?=$datos_usuario_modificar->puesto != '' ? $datos_usuario_modificar->puesto : 'Sin datos'?></span>
				</p>

				<hr>

				<strong><i class="fas fa-pencil-alt mr-1"></i> Habilidades</strong>

				<p class="text-muted">
					<span class="span_habilidades"><?=$datos_usuario_modificar->habilidades != '' ? $datos_usuario_modificar->habilidades : 'Sin datos'?></span>
				</p>

				<hr>

				<?php if(isset($datos_domicilio) && is_object($datos_domicilio)): ?>
					<strong><i class="fas fa-map-marker-alt mr-1"></i> Domicilio</strong>

					<p class="text-muted">
						<?=isset($datos_domicilio->direccion) && $datos_domicilio->direccion != '' ? $datos_domicilio->domicilio : 'Sin datos'?>
					</p>
				<?php endif; ?>

			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	<?php endif; ?>
</div>
<!-- /.col -->
