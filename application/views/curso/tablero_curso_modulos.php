<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_curso_modulos">

			<input type="hidden" id="id_ec_curso" value="<?=isset($id_ec_curso) ? $id_ec_curso : ''?>">

			<div class="form-group row">
				<div class="col-sm-6">
					<button type="button" style="display: none" id="btn_buscar_ec_curso_modulos">buscar</button>
				</div>
				<div class="col-sm-6 text-right">
				<?php if($ec_curso->publicado == 'no'): ?>
					<?php if(perfil_permiso_operacion_menu('ec_curso.agregar')) : ?>
						<button type="button" id="agregar_ec_curso_modulo" class="btn btn-sm btn-outline-success"
						data-id_ec_curso="<?=isset($id_ec_curso) ? $id_ec_curso : ''?>"><i class="fa fa-plus-square"></i> Nuevo modulo</button>
					<?php endif; ?>
				<?php endif;?>
				</div>
			</div>

			<div class="card card-solid mt-3">
				<div class="card-body pb-0">
					<div id="contenedor_resultados_ec_curso_modulos"></div>
				</div>
			</div>

		</section>
		<!-- /.content -->

		
		<div id="contenedor_modal_curso"></div>
		<div id="contenedor_modal_curso_modulo"></div>
		<div id="contenedor_modal_curso_modulo_temario"></div>
	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
