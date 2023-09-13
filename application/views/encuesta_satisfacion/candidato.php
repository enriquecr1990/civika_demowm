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
			<label class="col-lg-3">Estándar de competencia: </label>
			<span class="col-lg-9"><?=$estandar_competencia->codigo.' - '.$estandar_competencia->titulo?></span>
		</div>

		<div class="card card-solid mt-3">
			<div class="card-body pb-0">
				<div class="form-group row">
					<?php if(is_object($usuario_has_encuesta_satisfacion) || !is_null($usuario_has_encuesta_satisfacion)): ?>
						<div class="col-lg-12">
							<div class="callout callout-success">
								<h5>Muchas gracias</h5>
								<p>Detectamos que ya realizó la encuesta de satisfación para él Estándar de Competencia</p>
							</div>
						</div>
					<?php else: ?>
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
								<div class="col-lg-4">
									<label for="txt_observaciones_candidato" >Observaciones:</label>
									<small class="form-text text-muted">Mencione brevemente algunas sugerencias para mejorar el servicio</small>
								</div>
								<textarea data-rule-required="true" class="form-control col-lg-8"
										  placeholder="Mencione brevemente algunas sugerencias para mejorar el servicio" name="observaciones"></textarea>
							</div>
							<div class="form-group row">
								<div class="col-lg-12 text-right">
									<button type="button" id="btn_guardar_encuesta_satisfaccion" class="btn btn-success btn-sm"
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

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
