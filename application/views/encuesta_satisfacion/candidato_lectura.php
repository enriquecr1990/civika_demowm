<div class="modal fade" id="modal_encuesta_satisfaccion_respuestas" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Encuesta de satisfación del candidato</h4>
				<button type="button" class="close btn_cerrar_modal_evidencia_respuestas" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group row">
					<label class="col-lg-3">Estándar de competencia: </label>
					<span class="col-lg-9"><?=$estandar_competencia->codigo.' - '.$estandar_competencia->titulo?></span>
				</div>

				<div class="card card-solid mt-3">
					<div class="card-body pb-0">
						<div class="form-group row">
							<div class="form-group row">
								<div class="col-lg-12 alert alert-light">
									<p>
										Con la finalidad de elevar la calidad del servicio relacionado con el proceso de
										evaluación y la atención del servicio, solicito su opinión en cuanto al
										cumplimiento.
									</p>
									<p>
										Señale su respuesta para cada factor en las columnas de la derecha el grado de evaluación que otorgue de acuerdo a la sieguiente codigicación:
										<strong>
											1. Muy de Acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/01_icon_muy_feliz.png" class="img_encuesta_satisfaccion" alt="Muy feliz">),
											2. De acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/02_icon_feliz.png" class="img_encuesta_satisfaccion" alt="Feliz">),
											3. Parcialmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/03_icon_triste.png" class="img_encuesta_satisfaccion" alt="Triste">),
											4. Totalmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/04_icon_muy_triste.png" class="img_encuesta_satisfaccion" alt="Muy triste">).
										</strong>
									</p>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body table-responsive p-0">
										<table class="table table-striped">
											<thead>
											<tr>
												<th>Pregunta</th>
												<th class="text-center">
													<img src="<?=base_url()?>assets/imgs/iconos/01_icon_muy_feliz.png" class="img_encuesta_satisfaccion" alt="Muy feliz">
													<small class="form-text text-muted">Muy de acuerdo</small>
												</th>
												<th class="text-center">
													<img src="<?=base_url()?>assets/imgs/iconos/02_icon_feliz.png" class="img_encuesta_satisfaccion" alt="Feliz">
													<small class="form-text text-muted">De acuerdo</small>
												</th>
												<th class="text-center">
													<img src="<?=base_url()?>assets/imgs/iconos/03_icon_triste.png" class="img_encuesta_satisfaccion" alt="Triste">
													<small class="form-text text-muted">Parcialmente en desacuerdo</small>
												</th>
												<th class="text-center">
													<img src="<?=base_url()?>assets/imgs/iconos/04_icon_muy_triste.png" class="img_encuesta_satisfaccion" alt="Muy triste">
													<small class="form-text text-muted">Totalmente en desacuerdo</small>
												</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($cat_preguntas_encuesta as $index => $cpe): ?>
												<tr>
													<td><strong ><?=$index + 1?>.-<?=$cpe->pregunta?></strong></td>
													<td class="text-center">
														<strong><?=$cpe->respuesta == 1 ? 'X':''?></strong>
													</td>
													<td class="text-center">
														<strong><?=$cpe->respuesta == 2 ? 'X':''?></strong>
													</td>
													<td class="text-center">
														<strong><?=$cpe->respuesta == 3 ? 'X':''?></strong>
													</td>
													<td class="text-center">
														<strong><?=$cpe->respuesta == 4 ? 'X':''?></strong>
													</td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-4">
									<label for="txt_observaciones_candidato" >Observaciones:</label>
									<small class="form-text text-muted">Mencione brevemente algunas sugerencias para mejorar el servicio</small>
								</div>
								<span><?=isset($usuario_has_encuesta_satisfacion->observaciones) ? $usuario_has_encuesta_satisfacion->observaciones : ''?></span>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default">Cerrar</button>
			</div>
		</div>
	</div>
</div>
