<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?> 
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" style="margin-left: 5% !important; margin-right: 5% !important">
		<div class="row" id="contenedor_resultados_convocatoria_ec"></div>
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer', ['is_public' => true]); ?>
