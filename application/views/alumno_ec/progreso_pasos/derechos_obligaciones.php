<div class="card card-primary">
	<div class="card-header">
		<label class="modal-title">Derechos y obligaciones</label>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div class="form-group row">
			<div class="col-lg-12">
				<iframe src="<?=base_url()?>assets/docs/derechos_obligaciones.pdf" style="width: 100%; height: 500px"></iframe>
			</div>
		</div>
		<div class="form-group row justify-content-between">
			<div class="col-lg-6 text-left">
				<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_evaluacion_diagnostica-tab">
					<i class="fa fa-backward"></i> Anterior
				</button>
			</div>
			<div class="col-lg-6 text-right">
				<button type="button" data-siguiente_link="#tab_evaluacion_requerimientos-tab" data-numero_paso="2"
						class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
			</div>
		</div>
	</div>
</div>
