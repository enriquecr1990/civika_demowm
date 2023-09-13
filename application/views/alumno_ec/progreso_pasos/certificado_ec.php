<div class="col-lg-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Certificado del EC</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>

		<div class="card-body">

			<div class="form-group row">
				<label class="col-sm-3">Juicio de evaluación:</label>
				<span class="col-sm-9"><?=$usuario_has_ec->jucio_evaluacion == 'competente' ? 'Competente':'No competente'?></span>
			</div>

			<?php if($usuario_has_ec->jucio_evaluacion == 'competente' && (isset($certificado_laboral_pdf) && is_object($certificado_laboral_pdf))): ?>
				<div class="form-group row">
					<iframe src="<?=base_url().$certificado_laboral_pdf->ruta_directorio.$certificado_laboral_pdf->nombre?>" style="width: 100%; min-height: 300px; max-height: 600px"></iframe>
				</div>
			<?php else: ?>
				<div class="callout callout-danger">
					<h5>Lo siento</h5>
					<p>No es posible descargar el certificado en esté momento, el juicio emitido se encuentrá como no competente o el administrador/evaluador no ha subido a sistema su certificador laboral en formato PDF.</p>
				</div>
			<?php endif; ?>

		</div>
	</div>

</div>


<div class="form-group row justify-content-between">
	<div class="col-lg-6 text-left">
		<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_jucio_competencia-tab">
			<i class="fa fa-backward"></i> Anterior
		</button>
	</div>
	<div class="col-lg-6 text-right">
		<button type="button" data-siguiente_link="#tab_encuesta_satisfaccion-tab" data-numero_paso="6" <?=$usuario_has_ec->jucio_evaluacion == 'competente' ? '':'disabled="disabled"'?>
				class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div>
