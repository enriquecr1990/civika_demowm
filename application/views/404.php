<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header.php');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="error-page">
				<h2 class="headline text-warning"> 404</h2>

				<div class="error-content">
					<h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Está pagina no fue encontrada.</h3>

					<p>
						No fue posible encontrar la pagina que estabas buscando
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
