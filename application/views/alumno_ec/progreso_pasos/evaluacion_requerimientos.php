<?php if(isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada): ?>
	<div class="card card-primary">
		<div class="card-header">
			<label class="modal-title">Plan de evaluación</label>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body table-responsive p-0">
						<table class="table table-striped">
							<thead>
							<th>No</th>
							<th>Actividades y forma a desarrollar</th>
							<th>Técnicas e instrumentos de evaluación</th>
							</thead>
							<tbody>
							<?php foreach ($estandar_competencia_instrumento as $eci): ?>
								<?php foreach ($eci->actividades as $index => $a): ?>
									<tr>
										<td class="contenido_tabla_plan_evaluacion centrado">
											<?=$index + 1?>
										</td>
										<td class="contenido_tabla_plan_evaluacion">
											<?=$a->actividad?>
										</td>
										<?php if($index == 0):?>
											<td class="centrado contenido_tabla_plan_evaluacion" rowspan="<?=sizeof($eci->actividades)?>">
												<?=$eci->nombre?>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach;?>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<label class="modal-title">Plan de requerimientos</label>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body table-responsive p-0">
						<table class="table table-striped">
							<thead>
							<tr>
								<th colspan="2">Requerimientos para el desarrollo de la evaluacion</th>
							</tr>
							<tr>
								<th>Cantidad</th>
								<th>Requerimiento</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($estandar_competencia_requerimientos as $ecr):?>
								<tr>
									<td class="contenido_tabla_plan_evaluacion centrado">
										<?=$ecr->cantidad?>
									</td>
									<td class="contenido_tabla_plan_evaluacion">
										<?=$ecr->descripcion?>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<label class="modal-title">Plan de evaluación y requerimientos PDF</label>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<iframe src="<?=base_url()?>DocsPDF/generar_pdf_plan_evaluacion_requerimientos/<?=$id_usuario_alumno?>/<?=$id_usuario_evaluador?>/<?=$id_estandar_competencia?>" style="width: 100%; height: 500px"></iframe>
		</div>
	</div>

	<div class="form-group row justify-content-between">
		<div class="col-lg-6 text-left">
			<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_derechos_obligaciones-tab">
				<i class="fa fa-backward"></i> Anterior
			</button>
		</div>
		<div class="col-lg-6 text-right">
			<button type="button" data-siguiente_link="#tab_evidencias-tab" data-numero_paso="3"
					class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
		</div>
	</div>

<?php else: ?>
	<div class="callout callout-danger">
		<h5>Información importante</h5>
		<p>No es posible cargar la evidencia de las tecnicas, instrumentos y actividades del estándar de competencia hasta que realize la evaluación diagnóstica</p>
	</div>
<?php endif; ?>

