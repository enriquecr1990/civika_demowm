<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" >

		<?php if (isset($evaluacion)): ?>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Nombre del instrumento: </label><span
						class="col-sm-10 col-form-label"><?= $instrumento_has_actividad->actividad ?></span>
			</div>

			<?php if(isset($instrumento_has_actividad->instrucciones) && $instrumento_has_actividad->instrucciones != ''): ?>
				<!--<div class="form-group row">
					<div class="col-md-12">
						<div class="callout callout-success">
							<h5>Instrucciones</h5>
							<div><?=$instrumento_has_actividad->instrucciones?></div>
						</div>
					</div>
				</div>-->
			<?php endif; ?>

			<div class="card card-solid">
				<div class="card-body pb-0">
					<?php if(isset($ec_instrumento_actividad_evaluacion) && is_object($ec_instrumento_actividad_evaluacion) && $ec_instrumento_actividad_evaluacion->liberada == 'si'): ?>
						<?php if(isset($tiene_evaluacion_aprobatoria) && $tiene_evaluacion_aprobatoria): ?>
							<div class="callout callout-success">
								<h5>Información importante</h5>
								<p>Se ha detectado que ya cuenta con una evaluación aprobatoria MUCHAS FELICIDADES</p>
							</div>
						<?php else: ?>
							<?php if(isset($puede_realizar_evaluacion) && $puede_realizar_evaluacion): ?>

								<form id="form_evaluacion_examen">

									<input type="hidden" id="id_estandar_competencia" value="<?=$estandar_competencia_instrumento->id_estandar_competencia?>">
									<input type="hidden" id="id_ec_instrumento_actividad_evaluacion" value="<?=$ec_instrumento_actividad_evaluacion->id?>">
									<input type="hidden" id="id_usuario_has_evaluacion_realizada" name="id_usuario_has_evaluacion_realizada" value="<?=isset($usuario_has_evaluacion_realizada) ? $usuario_has_evaluacion_realizada->id_usuario_has_evaluacion_realizada : ''?>">
									<input type="hidden" id="id_usuario_evaluador" name="id_usuario_evaluador" value="<?=isset($usuario_has_estandar_competencia) ? $usuario_has_estandar_competencia->id_usuario_evaluador : ''?>">

									<!-- para el contador del tiempo -->
									<?php if(isset($evaluacion->tiempo) && $evaluacion->tiempo != 0 && $evaluacion->tiempo != ''): ?>
										<input type="hidden" id="tiempo_minutos" value="<?= $evaluacion->tiempo ?>">
										<div id="reloj_contador"></div>
									<?php endif; ?>

									<?php if(isset($preguntas_evaluacion) && is_array($preguntas_evaluacion)): ?>
										<div class="form-group row">
											<div class="col-md-12">
												<div class="callout callout-success">
													<h5><?=$evaluacion->titulo?></h5>
													<p>Lea cuidadosamente las preguntas y responda conforme usted considere sea la respuesta correcta. MUCHO EXITO</p>
												</div>
											</div>
										</div>
										<?php foreach ($preguntas_evaluacion as $index => $prt): ?>
											<!-- redaccion de la pregunta -->
											<div class="form-group row">
												<label><?=$index + 1?>. - <?=$prt->pregunta?></label> &nbsp;
												<!-- opciones de la pregunta -->
												<?php if(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_VERDADERO_FALSO,OPCION_UNICA_OPCION,OPCION_IMAGEN_UNICA_OPCION))): ?>
													<small class="form-text text-muted">Seleccione solo una respuesta</small>
												<?php elseif(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_OPCION_MULTIPLE,OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
													<small class="form-text text-muted">Seleccione por lo menos dos respuestas</small>
												<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_SECUENCIAL): ?>
													<small class="form-text text-muted">Ordene cronologicamente como considere sea correcto</small>
												<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL): ?>
													<small class="form-text text-muted">Relacione las las opciones del lado izquierdo en los recuadros del lado derecho</small>
												<?php endif; ?>
											</div>
											<!-- opciones de la pregunta -->
											<?php if(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_VERDADERO_FALSO,OPCION_UNICA_OPCION,OPCION_IMAGEN_UNICA_OPCION))): ?>
												<div class="row">
													<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
														<div class="form-group col-md-6">
															<div class="custom-control custom-radio">
																<input class="custom-control-input" id="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>" data-rule-required="true"
																	   type="radio" name="pregunta[<?= $prt->id_banco_pregunta ?>][<?=$prt->id_cat_tipo_opciones_pregunta?>]" value="<?=$op->id_opcion_pregunta?>">
																<label for="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>" class="custom-control-label"><?=$op->descripcion?></label>
																<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
																	<img class="img-thumbnail popoverShowImage"
																		 data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																		 data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																		 style="width: 50px !important;" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
																	<button type="button" data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																			data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																			class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
																<?php endif; ?>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											<?php elseif(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_OPCION_MULTIPLE,OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
												<div class="row">
													<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
														<div class="form-group col-md-6">
															<div class="custom-control custom-checkbox">
																<input class="custom-control-input" id="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>" data-rule-required="true"
																	   type="checkbox" name="pregunta[<?= $prt->id_banco_pregunta ?>][<?=$prt->id_cat_tipo_opciones_pregunta?>][]" value="<?=$op->id_opcion_pregunta?>">
																<label for="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>" class="custom-control-label"><?=$op->descripcion?></label>
																<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
																	<img class="img-thumbnail popoverShowImage"
																		 data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																		 data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																		 style="width: 50px !important;" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
																	<button type="button" data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																			data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																			class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
																<?php endif; ?>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_SECUENCIAL): ?>
												<div class="col-12">
													<div class="card">
														<div class="card-body table-responsive p-0">
															<table class="table table-striped">
																<thead>
																<tr>
																	<th>Orden cronológico</th>
																	<th>Opción</th>
																</tr>
																</thead>
																<tbody>
																<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
																	<tr>
																		<td width="15%">
																			<input type="text" id="pregunta_opcion_respuesta_<?=$op->id_opcion_pregunta?>"
																				   class="form-control" data-rule-number="true"
																				   name="pregunta[<?= $prt->id_banco_pregunta ?>][<?=$prt->id_cat_tipo_opciones_pregunta?>][<?= $op->id_opcion_pregunta ?>]"
																				   data-rule-required="true" placeholder="Orden Cronologico">
																		</td>
																		<td>
																			<label for="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>"><?=$op->descripcion?></label>
																			<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
																				<img class="img-thumbnail popoverShowImage"
																					 data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																					 data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																					 style="width: 50px !important;" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
																				<button type="button" data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																						data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																						class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
																			<?php endif; ?>
																		</td>
																	</tr>
																<?php endforeach; ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL): ?>
												<div class="col-12">
													<div class="card">
														<div class="card-body table-responsive p-0">
															<table class="table table-striped">
																<tbody>
																<?php foreach ($prt->opciones_pregunta_izq as $index_op => $op): ?>
																	<tr>
																		<!-- izq -->
																		<td width="10%">
																			<?=$op->consecutivo?>
																		</td>
																		<td>
																			<label for="pregunta_opcion_respuesta_<?= $op->id_opcion_pregunta?>"><?=$op->descripcion?></label>
																			<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
																				<img class="img-thumbnail popoverShowImage"
																					 data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																					 data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																					 style="width: 50px !important;" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
																				<button type="button" data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																						data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																						class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
																			<?php endif; ?>
																		</td>
																		<!-- der -->
																		<td width="15%">
																			<input type="text" id="pregunta_opcion_respuesta_<?=$prt->opciones_pregunta_der[$index_op]->id_opcion_pregunta?>"
																				   class="form-control" data-rule-number="true"
																				   name="pregunta[<?= $prt->opciones_pregunta_der[$index_op]->id_banco_pregunta ?>][<?=$prt->id_cat_tipo_opciones_pregunta?>][<?= $prt->opciones_pregunta_der[$index_op]->id_opcion_pregunta ?>]"
																				   data-rule-required="true" placeholder="Opción relacionada">
																		</td>
																		<td>
																			<label for="pregunta_opcion_respuesta_<?= $prt->opciones_pregunta_der[$index_op]->id_opcion_pregunta?>"><?=$prt->opciones_pregunta_der[$index_op]->descripcion?></label>
																			<?php if(isset($prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta) && is_object($prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta)): ?>
																				<img class="img-thumbnail popoverShowImage"
																					 data-nombre_archivo="<?=$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->nombre?>"
																					 data-src_image="<?=base_url().$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->ruta_directorio.$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->nombre?>"
																					 style="width: 50px !important;" src="<?=base_url().$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->ruta_directorio.$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
																				<button type="button" data-nombre_archivo="<?=$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->nombre?>"
																						data-src_image="<?=base_url().$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->ruta_directorio.$prt->opciones_pregunta_der[$index_op]->archivo_imagen_respuesta->nombre?>"
																						class="btn btn-sm btn-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
																			<?php endif; ?>
																		</td>
																	</tr>
																<?php endforeach; ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											<?php endif; ?>

										<?php endforeach; ?>
									<?php endif; ?>

									<!-- botones de envio del examen -->
									<div class="form-group row">
										<div class="col-md-12 text-right">
											<button type="button" id="btn_enviar_examen" class="btn btn-sm btn-outline-primary">Enviar respuestas</button>
											<button type="button" id="btn_enviar_examen_tiempo" style="display: none" class="btn btn-sm btn-info">Enviar examen tiempo</button>
										</div>
									</div>

								</form>

							<?php else :?>
								<div class="callout callout-warning">
									<h5>Información importante</h5>
									<p>LO SENTIMOS, Hemos detectado que ha agotado todos los intentos disponibles en la evaluación</p>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php else: ?>
						<div class="callout callout-danger">
							<h5>Información importante</h5>
							<p>LO SENTIMOS, La evaluación no se encuentra disponible para contestar, espere que algún administrador/instructor del sistema lo libere</p>
						</div>
					<?php endif; ?>
				</div>
			</div>

		<?php else: ?>

			<div class="form-group row">
				<div class="callout callout-danger">
					<h5>Información importante</h5>
					<p>Se detectado en el sistema que la evaluación se encuentra actualmente en captura de datos, favor de intentar más tarde</p>
				</div>
			</div>

		<?php endif; ?>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
