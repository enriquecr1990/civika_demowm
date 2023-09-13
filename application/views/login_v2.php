<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">

		 <?php $this->load->view('default/content_header.php');?>

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Main row -->
				<div class="row">
					<!-- Left col -->
					<div class="col-lg-3"></div>
					<section class="col-lg-6">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Iniciar sesion</h3>
							</div>
							<!-- /.card-header -->
							<!-- form start -->
							<form class="form-horizontal" id="form_login">
								<div class="card-body">
									<div class="form-group row">
										<label for="input_usuario" class="col-sm-2 col-form-label">Usuario</label>
										<div class="col-sm-10">
											<input type="text" name="usuario" class="form-control" id="input_usuario" placeholder="Nombre de usuario" data-rule-required="true">
										</div>
									</div>
									<div class="form-group row">
										<label for="input_contrasena_login" class="col-sm-2 col-form-label">Contraseña</label>
										<div class="col-sm-9">
											<input id="input_contrasena_login" name="password" type="password" placeholder="Contraseña" data-rule-required="true" class="form-control">
										</div>
										<div class="col-sm-1">
											<button type="button" class="input-group-text ver_password no_password" data-id_password="#input_contrasena_login"><i class="fas fa-eye"></i></button>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<a href="#" class="form-check-label">Olvide mi contraseña</a>
										</div>
									</div>
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
									<button id="iniciar_sesion" type="button" class="btn btn-success">Aceptar</button>
									<a href="<?=base_url()?>" class="btn btn-danger float-right">Cancelar</a>
								</div>
								<!-- /.card-footer -->
							</form>
						</div>
					</section>
					<!-- /.Left col -->
					<!-- right col (We are only adding the ID to make the widgets sortable)-->
					<div class="col-lg-3"></div>
					<!-- right col -->
				</div>
				<!-- /.row (main row) -->
			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
