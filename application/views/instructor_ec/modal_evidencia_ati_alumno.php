<div class="modal fade" id="modal_evidencia_ati_alumno" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Evidencia de trabajo del candidato</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-lg-2">Alumno:</label>
					<span class="col-lg-4"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></span>
					<label class="col-lg-1">CURP:</label>
					<span class="col-lg-5"><?=$usuario_alumno->curp?></span>
				</div>
				<div class="form-group row">
					<?php if(isset($estandar_competencia_instrumento) && is_array($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0): ?>
						<!-- para agregar la fecha de liberación de los ATI por el evaluador -->

						<div class="col-lg-12" id="div_input_fecha_envio_ati" <?=isset($ati_revisados_liberados) && $ati_revisados_liberados ? '':'style="display:none"'?>>
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Acuerdos de la evaluación</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
									</div>
								</div>

								<div class="card-body">
									<form id="form_acuerdos_evaluacion">
										<label>Acuerdo para el desarrollo de la evaluación</label>
										<div class="form-group row">
											<label for="input_date_fecha_envio_ati" class="col-lg-3">Fecha envio: </label>
											<div class="col-lg-3">
												<input type="date" id="input_fecha_evidencia_ati" class="form-control" data-rule-required="true"
														name="fecha_evidencia_ati"
														placeholder="Fecha del plan de evidencia" value="<?=$usuario_has_ec->fecha_evidencia_ati?>">
												<small class="form-text text-muted text-red" id="error_fecha_evidencia" style="display: none" >Sabados y Domingos no estan disponibles</small>
											</div>
											<label for="input_date_fecha_envio_ati" class="col-lg-3">Hora envio: </label>
											<div class="col-lg-3">
												<input type="time" id="input_hora_evidencia_ati" placeholder="Hora del plan" data-rule-required="true"
														name="hora_evidencia_ati"
														class="form-control" value="<?=$usuario_has_ec->hora_evidencia_ati?>">
												<small class="form-text text-muted smal_hora_envio" ></small>
											</div>
										</div>
										<label>Acuerdo para la presentación de los resultados de la evaluación</label>
										<div class="form-group row">
											<label for="slt_lugar_revision" class="col-lg-3">Lugar de revisión</label>
											<div class="col-lg-3">
												<select class="custom-select slt_mostrar_ocultar" id="slt_lugar_revision"
														data-contenedor_detalle="#descripcion_otro_lugar_revision" data-input_detalle="#input_descripcion_lugar" data-id_show="otro"
														name="lugar_revision" data-rule-required="true">
													<option value="">--Seleccione--</option>
													<option value="civika" <?=isset($usuario_has_ec->lugar_presentacion_resultados) && $usuario_has_ec->lugar_presentacion_resultados == 'civika' ? 'selected="selected"' : ''?>>Fundación Civika</option>
													<option value="otro" <?=isset($usuario_has_ec->lugar_presentacion_resultados) && $usuario_has_ec->lugar_presentacion_resultados == 'otro' ? 'selected="selected"' : ''?>>Otro</option>
												</select>
											</div>
											<div id="descripcion_otro_lugar_revision" class="col-lg-6" <?=isset($usuario_has_ec->lugar_presentacion_resultados) && $usuario_has_ec->lugar_presentacion_resultados == 'otro' ? '' : 'style="display: none"'?>>
												<div class="form-group row">
													<label for="input_descripcion_lugar" class="col-lg-6">Descripción del lugar</label>
													<input type="text" placeholder="Descripción del lugar de la revisión" data-rule-required="true" id="input_descripcion_lugar"
															class="form-control col-lg-6" value="<?=$usuario_has_ec->descripcion_presentacion_resultados?>">
												</div>
											</div>
											<label for="input_fecha_revision_ati" class="col-lg-3">Fecha de revisión: </label>
											<div class="col-lg-3">
												<input type="date" id="input_fecha_revision_ati" class="form-control" data-rule-required="true" name="fecha_revision_ati" min="<?=$usuario_has_ec->fecha_evidencia_ati?>"
														placeholder="Fecha del plan de evidencia" value="<?=$usuario_has_ec->fecha_presentacion_resultados?>">
												<small class="form-text text-muted text-red" id="error_fecha_revision" style="display: none" >Sabados y Domingos no estan disponibles</small>
											</div>
											<label for="input_hora_revision_ati" class="col-lg-3">Hora de revisión: </label>
											<div class="col-lg-3">
												<input type="time" id="input_hora_revision_ati" placeholder="Hora de reivisión" data-rule-required="true" name="hora_revision_ati"
														class="form-control" value="<?=$usuario_has_ec->hora_presentacion_resultados?>">
												<small class="form-text text-muted smal_hora_envio" ></small>
											</div>
										</div>
									</form>
									<div class="col-lg-12 text-right">
										<button type="button" id="btn_date_fecha_envio_ati" data-id_estandar_competencia="<?=$id_estandar_compentencia?>"
												data-id_usuario_alumno="<?=$id_usuario_alumno?>" class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i> Guardar acuerdos</button>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-12" id="div_leyend_fecha_envio_ati" <?=isset($ati_revisados_liberados) && $ati_revisados_liberados ? 'style="display:none"':''?>>
							<div class="alert alert-light">
								Entregables en proceso de carga por el candidato o en revisión o sin liberar, no se puede actualizar la fecha de entrega
							</div>
						</div>
						<input type="hidden" id="numero_instrumentos_ati" value="<?=sizeof($estandar_competencia_instrumento)?>">
						<?php foreach ($estandar_competencia_instrumento as $index_eci => $eci): ?>
							<div class="col-md-12">
								<div class="card card-primary">
									<div class="card-header">
										<h3 class="card-title"><?=$eci->nombre?></h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-card-widget="collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>

									<div class="card-body">
										<div class="contenedor_evidencia_alumno">
											<?php if(isset($eci->actividades) && is_array($eci->actividades)):?>
												<?php foreach ($eci->actividades as $index_act => $act): ?>
													<!-- actividad -->
													<div class="form-group row" id="contenedor_instrumento_evaluacion_<?=$act->id_ec_instrumento_has_actividad?>">
														<div class="col-md-4">
															<strong>Nombre del instrumento</strong>
														</div>
														<div class="col-md-4">
															<span><?=$act->actividad?></span>
														</div>
														<div class="col-md-4">
															<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_EN_CAPTURA): ?>
																<span class="badge badge-dark evidencia_alumno_ati_span evidencia_alumno_ati_span_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">En captura por el candidato</span>
															<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_ENVIADA): ?>
																<span class="badge badge-info evidencia_alumno_ati_span evidencia_alumno_ati_span_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">Enviada por el candidato</span>
															<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_OBSERVACIONES): ?>
																<span class="badge badge-danger evidencia_alumno_ati_span evidencia_alumno_ati_span_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">Evidencia con observaciones</span>
															<?php else: ?>
																<span class="badge badge-success evidencia_alumno_ati_span">Finalizada</span>
															<?php endif;?>
														</div>
													</div>
													<?php if(isset($act->instrucciones) && $act->instrucciones != ''): ?>
														<div class="form-group row">
															<div class="col-md-4">
																<strong>Instrucciones del instrumento</strong>
															</div>
															<div class="col-md-8">
																<?=$act->instrucciones?>
															</div>
														</div>
													<?php endif; ?>

													<?php if(isset($act->archivos_videos) && is_array($act->archivos_videos) && sizeof($act->archivos_videos) != 0): ?>
														<div class="form-group row">
															<div class="col-md-4">
																<strong>Material de apoyo</strong>
															</div>
															<div class="col-md-8">
																<?php foreach ($act->archivos_videos as $index_av => $av): ?>
																	<?php if(is_null($av->id_archivo)): ?>
																		<a href="<?=$av->url_video?>" target="_blank" ><?=$av->url_video?></a>
																	<?php else: ?>
																		<a href="<?=base_url().$av->archivo?>" target="_blank" ><?=$av->nombre_archivo?></a>
																	<?php endif; ?>
																<?php endforeach; ?>
															</div>
														</div>
													<?php endif; ?>

													<!-- evidencia del alumno -->
													<?php if(in_array($eci->id_cat_instrumento,array(INSTRUMENTO_GUIA_OBSERVACION,INSTRUMENTO_LISTA_COTEJO))): ?>
														<div class="form-group row">
															<div class="col-md-12">
																<?php if(isset($act->ec_instrumento_alumno) && is_object($act->ec_instrumento_alumno) && !is_null($act->ec_instrumento_alumno)):?>
																	<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_ENVIADA): ?>
																		<div class="form-group row">
																			<div class="col-md-4">
																				<strong>Evidencias del candidato</strong>
																			</div>
																			<div class="col-md-8">
																				<ul>
																					<?php foreach($act->alumno_evidencias as $index_ae => $evidencia): ?>
																						<?php if(is_null($evidencia->id_archivo_instrumento)): ?>
																							<li><a href="<?=$evidencia->url_video?>" target="_blank" ><?=$evidencia->url_video?></a></li>
																						<?php else: ?>
																							<li><a href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>" target="_blank" ><?=$evidencia->nombre?></a></li>
																						<?php endif; ?>
																					<?php endforeach; ?>
																				</ul>
																			</div>
																		</div>
																		<!-- comentarios de los entregables -->
																		<div class="form-group row">
																			<div class="col-md-11">
																				<textarea class="form-control text_area_comentarios_instructor_<?=$act->id_ec_instrumento_has_actividad?>" id="txt_comentarios_candidato_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																						  placeholder="Detalle su comentario para el candidato"></textarea>
																			</div>
																			<div class="col-md-1">
																				<button type="button" class="btn btn-sm btn-success txt_guardar_comentario_instructor"
																						data-id_body_comentarios="#tbody_comentario_instructor<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																						data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																					<i class="fa fa-save"></i>
																				</button>
																			</div>
																		</div>
																		<div class="form-group row">
																			<div class="col-md-12">
																				<div class="card">
																					<div class="card-body table-responsive p-0">
																						<table class="table table-striped">
																							<thead>
																							<tr>
																								<th colspan="3">Comentario</th>
																							</tr>
																							</thead>
																							<tbody id="tbody_comentario_instructor<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																							<?php if(isset($act->ec_instrumento_alumno->comentarios) && is_array($act->ec_instrumento_alumno->comentarios) && sizeof($act->ec_instrumento_alumno->comentarios) != 0): ?>
																								<?php foreach ($act->ec_instrumento_alumno->comentarios as $index_comentario => $com): ?>
																									<tr>
																										<td><?=$com->quien == 'alumno' ? 'Candidato':'Evaluador' ?></td>
																										<td><?=$com->comentario?></td>
																										<td><?=fechaHoraBDToHTML($com->fecha)?></td>
																									</tr>
																								<?php endforeach; ?>
																							<?php endif; ?>
																							</tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="form-group row">
																			<div class="col-md-6 text-left">
																				<button type="button" class="btn btn-sm btn-outline-danger btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																						data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="observar"
																						title="Observar este instrumento y enviarselo al alumno para su revisión"><i class="fa fa-backward"></i> Observar evidencia</button>
																			</div>
																			<div class="col-md-6 text-right">
																				<button type="button" class="btn btn-sm btn-outline-success btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																						data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="liberar"
																						title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Liberar evidencia</button>
																			</div>
																		</div>
																	<?php endif;?>
																	<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_OBSERVACIONES || $act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_FINALIZADA): ?>
																		<div class="form-group row">
																			<div class="col-md-4">
																				<strong>Evidencias del candidato</strong>
																			</div>
																			<div class="col-md-8">
																				<ul>
																					<?php foreach($act->alumno_evidencias as $index_ae => $evidencia): ?>
																						<?php if(is_null($evidencia->id_archivo_instrumento)): ?>
																							<li><a href="<?=$evidencia->url_video?>" target="_blank" ><?=$evidencia->url_video?></a></li>
																						<?php else: ?>
																							<li><a href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>" target="_blank" ><?=$evidencia->nombre?></a></li>
																						<?php endif; ?>
																					<?php endforeach; ?>
																				</ul>
																			</div>
																		</div>
																		<div class="form-group row">
																			<div class="col-md-12">
																				<div class="card">
																					<div class="card-body table-responsive p-0">
																						<table class="table table-striped">
																							<thead>
																							<tr>
																								<th colspan="3">Comentario</th>
																							</tr>
																							</thead>
																							<tbody id="tbody_comentario_instructor">
																							<?php if(isset($act->ec_instrumento_alumno->comentarios) && is_array($act->ec_instrumento_alumno->comentarios) && sizeof($act->ec_instrumento_alumno->comentarios) != 0): ?>
																								<?php foreach ($act->ec_instrumento_alumno->comentarios as $index_comentario => $com): ?>
																									<tr>
																										<td><?=$com->quien == 'alumno' ? 'Candidato':'Evaluador' ?></td>
																										<td><?=$com->comentario?></td>
																										<td><?=fechaHoraBDToHTML($com->fecha)?></td>
																									</tr>
																								<?php endforeach; ?>
																							<?php endif; ?>
																							</tbody>
																						</table>
																					</div>
																				</div>
																			</div>
																		</div>
																	<?php endif; ?>
																<?php else:?>
																	<span class="badge badge-danger">Sin información por parte del alumno</span>
																<?php endif;?>
															</div>
														</div>
													<?php endif; ?>
													<?php if(in_array($eci->id_cat_instrumento,array(INSTRUMENTO_CUESTIONARIO))): ?>
														<?php if(isset($act->instrumento_actividad_evaluacion)): ?>
															<div class="form-group row" id="evaluaciones_realizadas_instrumento_<?=$act->id_ec_instrumento_has_actividad?>">
																<?php $this->load->view('alumno_ec/progreso_pasos/evaluacion_instrumento',array('evaluaciones_realizadas' => $act->instrumento_actividad_evaluacion)); ?>
															</div>
														<?php endif; ?>
														<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_ENVIADA): ?>
															<!-- comentarios de los entregables -->
															<div class="form-group row">
																<div class="col-md-11">
																		<textarea class="form-control" id="txt_comentarios_candidato_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																				  placeholder="Detalle su comentario para el candidato"></textarea>
																</div>
																<div class="col-md-1">
																	<button type="button" class="btn btn-sm btn-success txt_guardar_comentario_instructor"
																			data-id_body_comentarios="#tbody_comentario_instructor<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																			data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																		<i class="fa fa-save"></i>
																	</button>
																</div>
															</div>
															<div class="form-group row">
																<div class="col-md-12">
																	<div class="card">
																		<div class="card-body table-responsive p-0">
																			<table class="table table-striped">
																				<thead>
																				<tr>
																					<th colspan="3">Comentario</th>
																				</tr>
																				</thead>
																				<tbody id="tbody_comentario_instructor<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																				<?php if(isset($act->ec_instrumento_alumno->comentarios) && is_array($act->ec_instrumento_alumno->comentarios) && sizeof($act->ec_instrumento_alumno->comentarios) != 0): ?>
																					<?php foreach ($act->ec_instrumento_alumno->comentarios as $index_comentario => $com): ?>
																						<tr>
																							<td><?=$com->quien == 'alumno' ? 'Candidato':'Evaluador' ?></td>
																							<td><?=$com->comentario?></td>
																							<td><?=fechaHoraBDToHTML($com->fecha)?></td>
																						</tr>
																					<?php endforeach; ?>
																				<?php endif; ?>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<div class="col-md-6 text-left">
																	<button type="button" class="btn btn-sm btn-outline-danger btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																			data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="observar"
																			title="Observar este instrumento y enviarselo al alumno para su revisión"><i class="fa fa-backward"></i> Observar evidencia</button>
																</div>
																<div class="col-md-6 text-right">
																	<button type="button" class="btn btn-sm btn-outline-success btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																			data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="liberar"
																			title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Liberar evidencia</button>
																</div>
															</div>
														<?php endif;?>
														<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_OBSERVACIONES || $act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_FINALIZADA): ?>
															<div class="form-group row">
																<div class="col-md-12">
																	<div class="card">
																		<div class="card-body table-responsive p-0">
																			<table class="table table-striped">
																				<thead>
																				<tr>
																					<th colspan="3">Comentario</th>
																				</tr>
																				</thead>
																				<tbody id="tbody_comentario_instructor">
																				<?php if(isset($act->ec_instrumento_alumno->comentarios) && is_array($act->ec_instrumento_alumno->comentarios) && sizeof($act->ec_instrumento_alumno->comentarios) != 0): ?>
																					<?php foreach ($act->ec_instrumento_alumno->comentarios as $index_comentario => $com): ?>
																						<tr>
																							<td><?=$com->quien == 'alumno' ? 'Candidato':'Evaluador' ?></td>
																							<td><?=$com->comentario?></td>
																							<td><?=fechaHoraBDToHTML($com->fecha)?></td>
																						</tr>
																					<?php endforeach; ?>
																				<?php endif; ?>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														<?php endif; ?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
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
