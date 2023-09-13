<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<?php $this->load->view('menu/content_header');?>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<?php if(isset($usuario) && in_array($usuario->perfil,array('alumno'))): ?>
				<?php if(isset($cat_msg_bienvenida->nombre) && $cat_msg_bienvenida->nombre != ''): ?>
					<div class="form-group row">
						<div class="col-md-12">
							<div class="callout callout-success">
								<p><?=$cat_msg_bienvenida->nombre?></p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div><!-- /.container-fluid -->
	</section>
	<!-- /. Main content -->
</div>
<!-- /. Content Wrapper. Contains page content  -->

<?php $this->load->view('default/footer'); ?>
