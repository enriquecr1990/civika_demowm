<aside class="main-sidebar sidebar-dark-primary elevation-4" id="menu_lateral_izquierdo">
	<!-- Brand Logo -->
	<a href="<?=base_url()?>" class="brand-link">
		<img src="<?=base_url()?>assets/imgs/logos/icono.png" alt="Civika PED Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Sistema Integral PED</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<?php if(isset($usuario)): ?>

			<!-- SidebarSearch Form -->
			<!--<div class="form-inline">
				<div class="input-group" data-widget="sidebar-search">
					<input class="form-control form-control-sidebar" type="search" placeholder="Buscar opciones" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-sidebar">
							<i class="fas fa-search fa-fw"></i>
						</button>
					</div>
				</div>
			</div>-->

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<!-- menu admin -->
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- opciones del menu para los usuarios -->
					<?php $this->load->view('menu/catalogo'); ?>
					<?php $this->load->view('menu/configuracion'); ?>
					<?php $this->load->view('menu/usuario'); ?>
					<?php $this->load->view('menu/estandar_competencia'); ?>
				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		<?php else: ?>
		<?php endif; ?>
	</div>
	<!-- /.sidebar -->

</aside>
