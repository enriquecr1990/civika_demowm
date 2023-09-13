<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header.php');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="error-page">
				<h2 class="headline text-danger"> 403</h2>

				<div class="error-content">
					<h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Permiso denegado.</h3>

					<p>
						No fue posible cargar esta página, no cuentas con los permisos necesarios para su operación
						Mientras tanto puedes ir al <a href="<?=base_url()?>">inicio</a> o navegar por las opciones del menú ubicado en el lateral izquierdo
					</p>
					
				</div>
				<!-- /.error-content -->
			</div>
			<!-- /.error-page -->
		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
