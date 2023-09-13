<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_configuracion_correo">

		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-md-6"></div>
				<?php if(perfil_permiso_operacion_menu('estandar_competencia.agregar')): ?>
					<button type="button" style="display: none" id="btn_buscar_configuracion_correo" >Buscar</button>
					<div class="col-md-6 text-right">
						<button type="button" id="agregar_configuracion_correo" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body table-responsive p-0">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>ID</th>
										<th>SMTP / Host / Port</th>
										<th>Usr/Pass</th>
										<th>Name</th>
										<th>¿Salida de correo?</th>
										<th></th>
									</tr>
									</thead>
									<tbody id="contenedor_resultados_configuracion_correo">

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
