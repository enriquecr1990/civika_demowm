<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
	<div class="container">
		<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
			aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fas fa-arrow-down"></span>
		</button>
		<div class="collapse navbar-collapse order-3" id="navbarCollapse">

			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" id="menu_bars" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i> Menu</a>
				</li>
				<li class="nav-item ">
					<a href="<?=base_url()?>" class="nav-link"><i class="fas fa-house-damage"></i> Inicio</a>
				</li>
				<?php if(isset($usuario) && !is_null($usuario)): ?>
					<li class="nav-item ">
						<a href="<?=base_url()?>admin" class="nav-link"><i class="fas fa-inbox"></i> Panel de Control</a>
					</li>
				<?php endif; ?>
				<li class="nav-item ">
					<a href="<?=base_url()?>contacto" class="nav-link"><i class="fas fa-address-book"></i> Contacto</a>
				</li>
				<li class="nav-item ">
					<a href="<?=base_url()?>quienes_somos" class="nav-link"><i class="fas fa-user"></i> Quienes somos</a>
				</li>
			</ul>

		</div>

		<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
			<?php if(isset($usuario_login) && !is_null($usuario_login)): ?>
				<?php $this->load->view('menu/top_login',array('usuario' => $usuario_login));?>
			<?php elseif(isset($usuario) && !is_null($usuario)): ?>
				<?php $this->load->view('menu/top_login',array('usuario' => $usuario));?>
			<?php else: ?>
				<li class="nav-item">
					<a href="<?=base_url()?>login" class="nav-link"><i class="fa fa-door-open"></i> Iniciar Sesión</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</nav>
