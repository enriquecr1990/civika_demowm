<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" id="input_buscar_estandar_competencia" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_estandar_competencia" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
				<?php if(perfil_permiso_operacion_menu('estandar_competencia.agregar')): ?>
					<div class="col-md-6 text-right">
						<button type="button" id="agregar_estandar_competencia" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="card card-solid">
			<div class="card-body pb-0">
				<?php if(isset($usuario) && $usuario->perfil == 'alumno'): ?>
					<div class="row" id="contenedor_resultados_estandar_competencia">
						<?php $this->load->view('ec/resultado_tablero_alumno'); ?>
					</div>
				<?php else: ?>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive p-0">
									<table class="table table-striped">
										<thead>
										<tr>
											<th>ID</th>
											<th>Código</th>
											<th>Titulo</th>
											<th>Banner</th>
											<th>Operaciones</th>
										</tr>
										</thead>
										<tbody id="contenedor_resultados_estandar_competencia">
											<?php $this->load->view('ec/resultado_tablero'); ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
