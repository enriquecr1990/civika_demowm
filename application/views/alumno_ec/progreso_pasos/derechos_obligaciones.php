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
		
	</div>
</div>

<div class="card card-primary">
	<div class="card-header">
		<label class="modal-title">Encuesta de satisfacción</label>
	</div>
	<div clss="card-body">
		<div class="form-group row">
			<div class="col-lg-12 ml-1 mr-1">
				<p>
					Con la finalidad de elevar la calidad del servicio relacionado con el proceso de
					evaluación y la atención del servicio, solicito su opinión en cuanto al
					cumplimiento.
				</p>
				<p>
					Señale su respuesta para cada factor en las columnas de la derecha el grado de evaluación que otorgue de acuerdo a la siguiente codificación:
					<strong>
						1. Muy de Acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/01_icon_muy_feliz.png" class="img_encuesta_satisfaccion" alt="Muy feliz">),
						2. De acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/02_icon_feliz.png" class="img_encuesta_satisfaccion" alt="Feliz">),
						3. Parcialmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/03_icon_triste.png" class="img_encuesta_satisfaccion" alt="Triste">),
						4. Totalmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/04_icon_muy_triste.png" class="img_encuesta_satisfaccion" alt="Muy triste">).
					</strong>
				</p>
			</div>
		</div>
		<div>
			<?php if(is_object($usuario_has_encuesta_satisfacion) || !is_null($usuario_has_encuesta_satisfacion)): ?>
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

			<?php else: ?>
				<form id="form_encuesta_satisfaccion">
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
												<div class="custom-control custom-radio">
													<input class="custom-control-input" id="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_1" type="radio" data-rule-required="true" name="respuesta[<?=$cpe->id_cat_preguntas_encuesta?>]" value="1">
													<label for="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_1" class="custom-control-label col-sm-1"></label>
												</div>
											</td>
											<td class="text-center">
												<div class="custom-control custom-radio">
													<input class="custom-control-input" id="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_2" type="radio" name="respuesta[<?=$cpe->id_cat_preguntas_encuesta?>]" value="2">
													<label for="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_2" class="custom-control-label"></label>
												</div>
											</td>
											<td class="text-center">
												<div class="custom-control custom-radio">
													<input class="custom-control-input" id="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_3" type="radio" name="respuesta[<?=$cpe->id_cat_preguntas_encuesta?>]" value="3">
													<label for="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_3" class="custom-control-label"></label>
												</div>
											</td>
											<td class="text-center">
												<div class="custom-control custom-radio">
													<input class="custom-control-input" id="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_4" type="radio" name="respuesta[<?=$cpe->id_cat_preguntas_encuesta?>]" value="4">
													<label for="respuesta_<?=$cpe->id_cat_preguntas_encuesta?>_4" class="custom-control-label"></label>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-12 text-right">
							<button type="button" id="btn_guardar_encuesta_satisfaccion_derechos_obligaciones" class="btn btn-outline-success btn-sm"
									data-id_usuario_has_ec="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>">
								<i class="fa fa-save"></i> Guardar
							</button>
						</div>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>

<div class="form-group row justify-content-between">
	<div class="col-lg-8 text-left">
		<?php if(!isset($usuario_has_encuesta_satisfacion) || is_null($usuario_has_encuesta_satisfacion)): ?>
			<div class="callout callout-warning">
				<h5>Información importante</h5>
				<p>Para poder ir a la evaluación diagnóstica, es necesario que responda primero la pregunta de la encuesta de satisfacción</p>
			</div>
		<?php endif ?>
	</div>
	<div class="col-lg-4 text-right">
		<button type="button" data-siguiente_link="#tab_evaluacion_diagnostica-tab" id="btn_siguiente_tab_derechos_obligaciones"
				<?=isset($usuario_has_encuesta_satisfacion) && !is_null($usuario_has_encuesta_satisfacion) ? '':'disabled="disabled"'?> data-numero_paso="1"
				class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div>

