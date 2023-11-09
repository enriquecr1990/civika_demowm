<!-- perfil -->
<li class="nav-item dropdown user-menu">
	<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
		<img src="<?=isset($usuario->foto_perfil) ? $usuario->foto_perfil : base_url('/assets/imgs/iconos/admin.png')?>" class="user-image img-circle elevation-2 img_foto_perfil" alt="Imagen de perfil">
		<span class="d-none d-md-inline">
			<?php if(isset($datos_usuario->nombre) && !is_null($datos_usuario->nombre)): ?>
				<?=$datos_usuario->nombre .' '. $datos_usuario->apellido_p ?>
			<?php else: ?>
				<?=$usuario->usuario?>
			<?php endif; ?>
		</span>
	</a>
	<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<!-- User image -->
		<li class="user-header bg-primary">
			<img src="<?=isset($usuario->foto_perfil) ? $usuario->foto_perfil : base_url('/assets/imgs/iconos/admin.png')?>" class="img-circle elevation-2" alt="User Image">
			<p>
				<?php if(isset($datos_usuario) && is_object($datos_usuario)): ?>
					<?=$datos_usuario->nombre.' '.$datos_usuario->apellido_p.' '.$datos_usuario->apellido_m ?>
				<?php else: ?>
					<?=$usuario->usuario?>
				<?php endif; ?>
				<small>
					<?php switch ($usuario->perfil){
						case 'root':case 'admin': echo 'Administrador del sistema';break;
						case 'instructor': echo 'Evaluador';break;
						case 'alumno': echo 'Alumno/Candidato';break;
					}?>
				</small>
			</p>
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			<a href="<?=base_url()?>perfil" class="btn btn-default btn-flat">Perfil</a>
			<a href="#" id="cerrar_sesion" role="button" class="btn btn-default btn-flat float-right">Cerrar sesión</a>
		</li>
	</ul>
</li>
<!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
	<a class="nav-link" data-toggle="dropdown" href="#">
		<i class="far fa-bell"></i>
		<span class="badge badge-warning navbar-badge numero_notificaciones"></span>
	</a>
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
		<label class="dropdown-item dropdown-header"><span class="numero_notificaciones"></span> Notificationes</label>
		<div class="dropdown-divider"></div>
		<div id="contenedor_notificaciones_no_leidas_menu"></div>
		<div class="dropdown-divider"></div>
		<a href="<?=base_url()?>notificaciones" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
	</div>
</li>
