<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" style="margin-left: 5% !important; margin-right: 5% !important">
		<div class="row"> 
			<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
				<div class="card" style="width: 18rem;">
					<img src="https://civika.com.mx/seguridadWM/files_uploads/2023/02/21/08_55_39-poster-supervisiOacuten-de-seguridad-en-obras-nuevas-y-remodelaciones-para-coordinadores-y-gerentes-de-construcciOacutenjpg.jpg" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">SUPERVISIÓN DE SEGURIDAD EN OBRAS NUEVAS Y REMODELACIONES PARA COORDINADORES Y GERENTES DE CONSTRUCCIÓN</h5>
						<p class="card-text">Aqui va la descripcón del curso</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer', ['is_public' => true]); ?>
