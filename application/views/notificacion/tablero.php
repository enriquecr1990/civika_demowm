<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_notificaciones">
		<div class="row">
			<div class="col-md-3">

				<a href="#" id="nueva_notificacion" role="button" class="btn btn-primary btn-block mb-3">Nueva notificación</a>
				<a href="#" class="btn btn-danger btn-block mb-3 regresar_notificaciones" style="display: none;">Volver a recibidos</a>

				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Carpetas</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="card-body p-0">
						<ul class="nav nav-pills flex-column">
							<li class="nav-item active">
								<a href="#" role="button" class="nav-link lnk_notificaciones_recibidas">
									<i class="fas fa-inbox"></i> Recibidas
									<span class="badge bg-primary float-right" id="notificaciones_no_leidas_tablero"></span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link lnk_notificaciones_enviadas">
									<i class="far fa-envelope"></i> Enviadas
								</a>
							</li>
							<!--<li class="nav-item">
								<a href="#" class="nav-link lnk_notificaciones_borrador">
									<i class="far fa-file-alt"></i> Borradores
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link lnk_notificaciones_eliminadas">
									<i class="far fa-trash-alt"></i> Eliminadas
								</a>
							</li>-->
						</ul>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
			<div class="col-md-9" id="contenedor_operaciones_notificaciones">
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
