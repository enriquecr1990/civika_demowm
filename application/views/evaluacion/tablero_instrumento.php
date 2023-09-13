<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_estandar_competencia_evaluacion">

			<input type="hidden" id="input_id_estandar_competencia" value="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>">
			<input type="hidden" id="input_id_estandar_competencia_instrumento" value="<?=isset($id_estandar_competencia_instrumento) ? $id_estandar_competencia_instrumento : ''?>">
			<input type="hidden" id="input_id_ec_instrumento_has_actividad" value="<?=isset($id_ec_instrumento_has_actividad) ? $id_ec_instrumento_has_actividad : ''?>">

			<?php if(isset($existe_evidencia_alumnos) && $existe_evidencia_alumnos): ?>
				<div class="callout callout-warning">
					<h5>Lo siento</h5>
					<p>Sé detecto que hay alumnos cargando evidencia del EC, no es posible modificar</p>
				</div>
			<?php else: ?>
				<div class="form-group row">
					<div class="col-sm-6">
						<button type="button" style="display: none" id="btn_buscar_ec_evaluacion_cuestionario">buscar</button>
					</div>
				</div>

				<div class="card card-solid mt-3">
					<div class="card-body pb-0">
						<div id="contenedor_resultados_ec_evaluacion_cuestionario"></div>
					</div>
				</div>
			<?php endif; ?>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
