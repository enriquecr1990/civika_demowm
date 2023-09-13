<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_administradores">

		<div class="container-fluid mb-3">
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<input type="text" id="input_buscar_usuarios" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
						<div class="input-group-append">
							<button type="button" id="btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>" class="btn btn-lg btn-default">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
				</div>
				<div class="col-md-6 text-right">
					<?php if($sidebar == 'usuarios'): ?>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-outline-success btn-sm">Nuevo</button>
							<button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu" style="">
								<a id="agregar_administrador"  class="dropdown-item" href="#">Administrador</a>
								<a id="agregar_instructor" class="dropdown-item" href="#">Evaluador</a>
								<a id="agregar_candidato" class="dropdown-item" href="#">Candidato</a>
							</div>
						</div>
					<?php endif; ?>
					<?php if($sidebar == 'administradores'): ?>
						<button type="button" id="agregar_administrador" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
					<?php endif; ?>
					<?php if($sidebar == 'instructores'): ?>
						<button type="button" id="agregar_instructor" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
					<?php endif; ?>
					<?php if($sidebar == 'candidatos'): ?>
						<?php if(perfil_permiso_operacion_menu('usuarios.alumno')):?>
							<button type="button" id="agregar_candidato" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row" id="contenedor_resultados_usuario">
					<?php $this->load->view('usuarios/resultado_tablero'); ?>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
