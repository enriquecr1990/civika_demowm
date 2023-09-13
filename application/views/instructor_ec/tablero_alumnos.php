<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<?php if (isset($estandar_competencia)): ?>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Estándar de competencia: </label><span
						class="col-sm-10 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
			</div>
			<input type="hidden" id="val_id_estandar_competencia" value="<?=$estandar_competencia->id_estandar_competencia?>">
		<?php endif; ?>

		<div class="card card-solid">
			<div class="card-body pb-0">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body table-responsive p-0">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>ID usuario</th>
										<th>Nombre del alumno</th>
										<th>CURP</th>
										<th>Datos de contacto</th>
										<th>Operaciones</th>
									</tr>
									</thead>
									<tbody id="contenedor_resultado_tablero_alumnos_ec">
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

<!-- modal para generar el portafolio de evidencias del alumno -->
<div class="modal fade" id="modal_generar_portafolio_evidencia" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Portafolio de Evidencias - PED</h4>
				<button type="button" class="close btn_close_modal_generar_evidencia" disabled="disabled" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" id="contenedor_generador_evidencias">

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default btn_close_modal_generar_evidencia" disabled="disabled" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>


<?php $this->load->view('default/footer'); ?>
