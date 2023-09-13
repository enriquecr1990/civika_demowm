<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_estandar_competencia_evaluacion">

			<input type="hidden" id="input_id_estandar_competencia" value="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>">

			<div class="form-group row">
				<div class="col-sm-6">
					<button type="button" style="display: none" id="btn_buscar_ec_evaluacion">buscar</button>
				</div>
				<div class="col-sm-6 text-right">
					<?php if(perfil_permiso_operacion_menu('evaluacion.agregar')): ?>
						<button type="button" id="agregar_evaluacion_ec" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nueva evaluación</button>
					<?php endif; ?>
				</div>
			</div>

			<div class="card card-solid mt-3">
				<div class="card-body pb-0">
					<div id="contenedor_resultados_ec_evaluacion"></div>
				</div>
			</div>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
