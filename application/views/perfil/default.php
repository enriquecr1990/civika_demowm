<div class="col-md-3">

	<!-- Profile Image -->
	<div class="card card-primary card-outline">
		<div class="card-body box-profile">
			<div class="text-center">
				<img class="profile-user-img img-fluid img-circle img_foto_perfil"
					 src="<?=isset($usuario->foto_perfil) ? $usuario->foto_perfil : base_url('/assets/imgs/iconos/admin.png')?>"
					 alt="Foto de perfil">
			</div>

			<h3 class="profile-username text-center">
				<?php if(isset($usuario->datos_usuario) && is_object($usuario->datos_usuario)): ?>
					<?=$usuario->datos_usuario->nombre.' '.$usuario->datos_usuario->apellido_p.' '.$usuario->datos_usuario->apellido_m ?>
				<?php else: ?>
					<?=$usuario->usuario?>
				<?php endif; ?>
			</h3>

			<p class="text-muted text-center">
				<?php switch ($usuario->perfil){
					case 'root':case 'admin': echo 'Administrador del sistema';break;
					case 'instructor': echo 'Evaluador';break;
					case 'alumno': echo 'Alumno/Candidato';break;
				}?>
			</p>

			<?php if(isset($usuario->datos_usuario) && is_object($usuario->datos_usuario)): ?>
				<ul class="list-group list-group-unbordered mb-3">
					<li class="list-group-item">
						<b><?=$usuario->datos_usuario->genero == 'm' ? 'Masculino':'Femenino'?></b>
					</li>
					<li class="list-group-item">
						<b><?=$usuario->datos_usuario->correo?></b>
					</li>
					<li class="list-group-item">
						<b>
							<?=$usuario->datos_usuario->celular?>
							<?=$usuario->datos_usuario->celular != '' && $usuario->datos_usuario->telefono != '' ? '/':''?>
							<?=$usuario->datos_usuario->telefono?>
						</b>
					</li>
				</ul>
			<?php endif; ?>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->

	<!-- About Me Box -->
	<?php if(isset($datos_usuario) && is_object($datos_usuario)): ?>
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Acerca de mí</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">

				<strong><i class="fas fa-user-tie mr-1"></i> Nivel Acádemico</strong>

				<p class="text-muted">
					<span class="span_nivel_academico"><?=$datos_usuario->nivel_academico != '' ? $datos_usuario->nivel_academico : 'Sin datos'?></span>
				</p>

				<hr>

				<strong><i class="fas fa-user-tie mr-1"></i> Profesión</strong>

				<p class="text-muted">
					<span class="span_profesion"><?=$datos_usuario->profesion != '' ? $datos_usuario->profesion : 'Sin datos'?></span>
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
