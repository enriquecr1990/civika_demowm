<nav class="main-header navbar navbar-expand navbar-white navbar-light" id="menu_superior">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" id="menu_bars" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=base_url()?>" class="nav-link">Inicio</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=base_url()?>contacto" class="nav-link">Contacto</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?=base_url()?>quienes_somos" class="nav-link">Quienes somos</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<?php if(isset($usuario_login) && !is_null($usuario_login)): ?>
			<?php $this->load->view('menu/top_login',array('usuario' => $usuario_login));?>
		<?php elseif(isset($usuario) && !is_null($usuario)): ?>
			<?php $this->load->view('menu/top_login',array('usuario' => $usuario));?>
		<?php else: ?>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?=base_url()?>login" class="nav-link"><i class="fa fa-door-open"></i> Iniciar Sesión</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>
