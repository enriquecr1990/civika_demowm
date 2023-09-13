<div class="modal fade" id="modal_expediente_digital_candidato" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Expediente digial del candidato</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-lg-3">Ficha de registro</label>
					<div class="col-lg-9">
						<?php if(isset($ficha_registro_pdf) && is_object($ficha_registro_pdf)): ?>
							<ul>
								<li>Expediente PDF: <?=$ficha_registro_pdf->nombre?></li>
								<li>Fecha de carga: <?=fechaHoraBDToHTML($ficha_registro_pdf->fecha)?></li>

								<li>
									<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
									   href="<?=base_url().$ficha_registro_pdf->ruta_directorio.$ficha_registro_pdf->nombre?>">
										<i class="fa fa-eye"></i> Ver archivo
									</a>
								</li>
							</ul>
						<?php else: ?>
							<label>Sin registro del archivo</label>
						<?php endif; ?>
					</div>
					<label class="col-lg-3">Instrumento de evaluación de competencia</label>
					<div class="col-lg-9" >
						<?php if(isset($instrumento_evaluacion_pdf) && is_object($instrumento_evaluacion_pdf)): ?>
							<ul>
								<li>Expediente PDF: <?=$instrumento_evaluacion_pdf->nombre?></li>
								<li>Fecha de carga: <?=fechaHoraBDToHTML($instrumento_evaluacion_pdf->fecha)?></li>

								<li>
									<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
									   href="<?=base_url().$instrumento_evaluacion_pdf->ruta_directorio.$instrumento_evaluacion_pdf->nombre?>">
										<i class="fa fa-eye"></i> Ver archivo
									</a>
								</li>
							</ul>
						<?php else: ?>
							<label>Sin registro del archivo</label>
						<?php endif; ?>
					</div>
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
					<label class="col-lg-3">Portafolio de evidencias PED</label>
					<div class="col-lg-9" id="contenedor_certificado_laboral">
						<?php if(isset($archivo_ped_generado) && is_object($archivo_ped_generado)): ?>
							<ul>
								<li>Expediente PDF: <?=$archivo_ped_generado->nombre?></li>
								<li>Fecha generado: <?=fechaHoraBDToHTML($archivo_ped_generado->fecha)?></li>
								<li>
									<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"
									   href="<?=base_url().$archivo_ped_generado->ruta_directorio.$archivo_ped_generado->nombre?>">
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
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
