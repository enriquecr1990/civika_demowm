<div class="col-lg-12">
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Archivos digitales</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>

		<div class="card-body">

			<div class="form-group row">
				<label class="col-lg-3">Cedula de evaluación</label>
				<?php if(isset($archivo_ped_generado) && is_object($archivo_ped_generado)): ?>
					<?php $url_cedula = $usuario_has_ec->id_usuario.'/'.$usuario_has_ec->id_usuario_evaluador.'/'.$usuario_has_ec->id_estandar_competencia.'/0/I'; ?>
					<div class="col-lg-9" id="contenedor_certificado_laboral">
						<ul>
							<li>Expediente PDF: Cédula de evaluación - <?=fechaBDToHtml($archivo_ped_generado->fecha)?></li>
							<li>Fecha creación: <?=fechaHoraBDToHTML($archivo_ped_generado->fecha)?></li>

							<li>
								<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
								   href="<?=base_url()?>DocsPDF/generar_pdf_cedula_evaluacion/<?=$url_cedula?>">
									<i class="fa fa-eye"></i> Ver archivo
								</a>
							</li>
						</ul>
					</div>
				<?php else: ?>
					<label>Sin registro del archivo</label>
				<?php endif; ?>
				<label class="col-lg-3">Certificado de competencia laboral en la EC</label>
				<div class="col-lg-9" id="contenedor_certificado_laboral">
					<?php if(isset($certificado_laboral_pdf) && is_object($certificado_laboral_pdf)): ?>
						<ul>
							<li>Expediente PDF: <?=$certificado_laboral_pdf->nombre?></li>
							<li>Fecha de carga: <?=fechaHoraBDToHTML($certificado_laboral_pdf->fecha)?></li>

							<li>
								<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
								   href="<?=base_url().$certificado_laboral_pdf->ruta_directorio.$certificado_laboral_pdf->nombre?>">
									<i class="fa fa-eye"></i> Ver archivo
								</a>
							</li>
						</ul>
					<?php else: ?>
						<label>Sin registro del archivo</label>
					<?php endif; ?>
				</div>
			</div>


		</div>
	</div>
</div>
