<?php
$numero_actividades = 0;
$numero_actividades_finalizadas = 0;
?>
<?php if(isset($puede_cargar_evidencia_ati) && $puede_cargar_evidencia_ati): ?>
	<?php if(isset($estandar_competencia_instrumento) && is_array($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0): ?>
		<label class="col-form-label">Instrumentos de evaluación</label>
		<div class="callout callout-success">
			<h5>Información importante</h5>
			<p>
				A continuación carga tus evidencias conforme a las instrucciones correspondientes, para poder pasar al paso de "Juicio de Competencia", es necesario entragar todas las evidencias y esten en estatus de "FINALIZADA"
			</p>
		</div>
		<?php foreach ($estandar_competencia_instrumento as $index_eci => $eci): ?>
			<?php if(in_array($eci->id_cat_instrumento,array(INSTRUMENTO_GUIA_OBSERVACION,INSTRUMENTO_LISTA_COTEJO))): ?>
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
							<div class="form-group row">
								<?php if(isset($eci->actividades) && is_array($eci->actividades)):?>
									<?php foreach ($eci->actividades as $index_act => $act): ?>
										<?php $numero_actividades++; ?>
										<div class="card card-warning card-outline col-12 contenedor_evidencia_alumno">
											<div class="card-body">
												<div class="form-group row">
													<!-- actividad -->
													<div class="col-md-4"><strong>Evidencia</strong></div>
													<div class="col-md-4"><span><?=$act->actividad?></span></div>
													<?php if(isset($act->ec_instrumento_alumno) && is_object($act->ec_instrumento_alumno) && !is_null($act->ec_instrumento_alumno)):?>
														<div class="col-md-4">
															<?php if($act->ec_instrumento_alumno->id_cat_proceso ==ESTATUS_OBSERVACIONES): ?>
																<span class="badge badge-danger evidencia_alumno_ati_span">Evidencia con observaciones</span>
															<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_ENVIADA): ?>
																<span class="badge badge-primary evidencia_alumno_ati_span">Evidencia enviada</span>
															<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_EN_CAPTURA): ?>
																<span class="badge badge-info evidencia_alumno_ati_span">En captura de evidencia</span>
															<?php else: ?>
																<?php $numero_actividades_finalizadas++; ?>
																<span class="badge badge-success evidencia_alumno_ati_span">Finalizada</span>
															<?php endif; ?>
														</div>
													<?php endif; ?>
													<?php if(isset($act->instrucciones) && $act->instrucciones != ''): ?>
														<div class="col-md-12">
															<strong>Instrucciones: </strong>
														</div>
														<div class="col-md-12">
															<span><?=$act->instrucciones?></span>
														</div>
													<?php endif; ?>
													<?php if(isset($act->archivos_videos) && is_array($act->archivos_videos) && sizeof($act->archivos_videos)): ?>
														<div class="col-md-4"><strong>Material de apoyo <i class="fa fa-paperclip"></i></strong></div>
														<div class="col-md-8">
															<?php foreach ($act->archivos_videos as $index_videos => $av): ?>
																<li>
																	<?php if(!is_null($av->url_video) && $av->url_video != ''): ?>
																		<?php $idVideo = "";
																		preg_match(
																				'/[\\?\\&]v=([^\\?\\&]+)/',
																				$av->url_video,
																				$matches
																		);
																		$idVideo=$matches[1];
																		?>
																		<!--<iframe src="https://www.youtube.com/embed/<?=$idVideo?>?controls=0" width="450" height="380"></iframe>-->
																		<a target="_blank" href="<?=$av->url_video?>"><?=$av->url_video?></a>
																	<?php endif; ?>
																	<?php if(!is_null($av->id_archivo) && $av->id_archivo != ''): ?>
																		<a href="<?=base_url().$av->archivo?>" target="_blank"><?=$av->nombre_archivo?></a>
																	<?php endif; ?>
																</li>
															<?php endforeach; ?>
														</div>
													<?php endif; ?>
													<div class="col-md-4">
														<strong>Subir evidencia</strong>
													</div>
													<div class="col-md-4">
														<?php if(isset($act->ec_instrumento_alumno) && is_object($act->ec_instrumento_alumno) && !is_null($act->ec_instrumento_alumno)):?>
															<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
																<div class="form-group row">
																	<input type="file" id="doc_evidencia_ati_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" name="doc_evidencia_ati"
																		   data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																		   data-div_procesando="#procesando_doc_evidencia_ati<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" accept="*/*"
																		   class="doc_evidencia_ati_alumno">
																	<div id="procesando_doc_evidencia_ati<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"></div>
																</div>
															<?php endif; ?>
														<?php endif; ?>
													</div>
													<div class="col-md-4">
														<?php if(isset($act->ec_instrumento_alumno) && is_object($act->ec_instrumento_alumno) && !is_null($act->ec_instrumento_alumno)):?>
															<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
																<div class="form-group row">
																	<input type="url" placeholder="URL de video - YouTube" id="url_evidencia_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" class="form-control col-md-10">
																	<button type="button" class="btn btn-sm btn-outline-success add_url_evidencia"
																			data-input_url="#url_evidencia_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																			data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																			data-contenedor_destino="#contenedor_doc_evidencia_ati_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" ><i class="fa fa-plus"></i></button>
																</div>
															<?php endif; ?>
														<?php endif; ?>
													</div>
													<!-- evidencia del alumno -->
													<div class="col-md-12 ">
														<?php if(isset($act->ec_instrumento_alumno) && is_object($act->ec_instrumento_alumno) && !is_null($act->ec_instrumento_alumno)):?>
															<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
																<div class="form-group row" id="contenedor_doc_evidencia_ati_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																	<?php if(isset($act->ec_instrumento_alumno->evidencias) && is_array($act->ec_instrumento_alumno->evidencias) && sizeof($act->ec_instrumento_alumno->evidencias) != 0): ?>
																		<?php foreach ($act->ec_instrumento_alumno->evidencias as $index_evidencia => $evidencia): ?>
																			<div class="col-md-4">
																				<?php if(isset($evidencia->id_archivo_instrumento) && !is_null($evidencia->id_archivo_instrumento)): ?>
																					<a target="_blank" class="archivo_doc_evidencia_ati" href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>">
																						<?=$evidencia->nombre?>
																					</a>
																				<?php else: ?>
																					<a target="_blank" class="archivo_doc_evidencia_ati" href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>">
																						<?=$evidencia->url_video?>
																					</a>
																				<?php endif; ?>
																				<button type="button" data-tag_parent="div" data-tabla_eliminar="ec_instrumento_alumno_evidencias" data-id_eliminar="id_ec_instrumento_alumno_evidencias"
																						data-id_eliminar_valor="<?=$evidencia->id_ec_instrumento_alumno_evidencias?>" class="btn btn-sm btn-outline-danger btn_eliminar_comun_sistema"><i class="fa fa-trash"></i></button>
																			</div>
																		<?php endforeach; ?>
																	<?php endif; ?>
																</div>
																<!-- comentarios de los entregables -->
																<div class="form-group row">
																	<div class="col-md-11">
																	<textarea class="form-control" id="txt_comentarios_candidato_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																			  placeholder="Detalle algun comentario para que el evaluador pueda visualizarlo"></textarea>
																	</div>
																	<div class="col-md-1">
																		<button type="button" class="btn btn-sm btn-success txt_guardar_comentario_candidato_progreso"
																				data-id_body_comentarios="#tbody_comentario_candidato<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
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
																					<tbody id="tbody_comentario_candidato<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
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
																	<div class="col-md-12 text-right">
																		<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
																			<?php if($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_OBSERVACIONES): ?>
																				<button type="button" class="btn btn-sm btn-outline-danger btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																						data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="enviar"
																						title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Replica evidencia al evaluador</button>
																			<?php else: ?>
																				<button type="button" class="btn btn-sm btn-outline-success btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																						data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="enviar"
																						title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Enviar evidencia al evaluador</button>
																			<?php endif; ?>
																		<?php endif; ?>
																	</div>
																</div>
															<?php endif;?>
															<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_ENVIADA,ESTATUS_FINALIZADA))): ?>
																<div class="col-md-9">
																	<div class="form-group row" id="contenedor_doc_evidencia_ati_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																		<?php if(isset($act->ec_instrumento_alumno->evidencias) && is_array($act->ec_instrumento_alumno->evidencias) && sizeof($act->ec_instrumento_alumno->evidencias) != 0): ?>
																			<?php foreach ($act->ec_instrumento_alumno->evidencias as $index_evidencia => $evidencia): ?>
																				<div class="col-md-4">
																					<a target="_blank" href="<?=base_url().$evidencia->ruta_directorio.$evidencia->nombre?>">
																						<?=$evidencia->nombre?>
																					</a>
																				</div>
																			<?php endforeach; ?>
																		<?php endif; ?>
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
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if(in_array($eci->id_cat_instrumento,array(INSTRUMENTO_CUESTIONARIO))): ?>
				<div class="col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title"><?= $eci->nombre ?></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<?php if(isset($eci->actividades) && is_array($eci->actividades)):?>
									<?php foreach ($eci->actividades as $index_act => $act): ?>
										<?php $numero_actividades++; ?>
										<div class="card card-warning card-outline col-12 contenedor_evidencia_alumno">
											<div class="card-body">
												<div class="form-group row">
													<!-- actividad -->
													<div class="col-md-4"><strong>Nombre del cuestionario</strong></div>
													<div class="col-md-4"><span><?=$act->actividad?></span></div>
													<div class="col-md-4">
														<?php if($act->ec_instrumento_alumno->id_cat_proceso ==ESTATUS_OBSERVACIONES): ?>
															<span class="badge badge-danger evidencia_alumno_ati_span">Evidencia con observaciones</span>
														<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_ENVIADA): ?>
															<span class="badge badge-primary evidencia_alumno_ati_span">Evidencia enviada</span>
														<?php elseif($act->ec_instrumento_alumno->id_cat_proceso == ESTATUS_EN_CAPTURA): ?>
															<span class="badge badge-info evidencia_alumno_ati_span">En captura de evidencia</span>
														<?php else: ?>
															<?php $numero_actividades_finalizadas++; ?>
															<span class="badge badge-success evidencia_alumno_ati_span">Finalizada</span>
														<?php endif; ?>
													</div>
													<?php if(isset($act->instrucciones) && $act->instrucciones != ''): ?>
														<div class="col-md-12">
															<strong>Lea atentamente las siguientes instrucciones: </strong>
														</div>
														<div class="col-md-12">
															<span><?=$act->instrucciones?></span>
														</div>
													<?php endif; ?>
													<?php if(isset($act->evaluacion_instrumento) && is_object($act->evaluacion_instrumento) && $act->evaluacion_instrumento->liberada == 'si'): ?>
														<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
															<div class="col-md-6">
																<strong>Intentos permitidos: </strong><span class="badge badge-danger"><?=$act->intentos_permitidos?></span>
															</div>
															<?php if(sizeof($act->instrumento_actividad_evaluacion) < $act->intentos_permitidos): ?>
																<div class="col-md-6 text-right">
																	<a href="<?=base_url()?>evaluacion_instrumento/<?=$act->id_ec_instrumento_has_actividad?>/<?=$act->evaluacion_instrumento->id_evaluacion?>"
																	   class="btn btn-sm btn-outline-danger" id="evaluacion_cuestionario_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" >
																		<i class="fa fa-check-circle"></i>Realizar cuestionario
																	</a>
																</div>
															<?php endif; ?>
														<?php endif; ?>
													<?php else: ?>
														<span class="badge badge-danger">No hay evaluación cargada en sistema</span>
													<?php endif; ?>
												</div>
												<?php if(isset($act->evaluacion_instrumento) && is_object($act->evaluacion_instrumento) && $act->evaluacion_instrumento->liberada == 'si'): ?>
													<div class="form-group row" id="evaluaciones_realizadas_instrumento_<?=$act->id_ec_instrumento_has_actividad?>">
														<?php $this->load->view('alumno_ec/progreso_pasos/evaluacion_instrumento',array('evaluaciones_realizadas' => $act->instrumento_actividad_evaluacion)); ?>
													</div>
												<?php endif; ?>

												<!-- comentarios de los entregables -->
												<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
													<div class="form-group row">
														<div class="col-md-11">
																	<textarea class="form-control" id="txt_comentarios_candidato_<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																			  placeholder="Detalle algun comentario para que el evaluador pueda visualizarlo"></textarea>
														</div>
														<div class="col-md-1">
															<button type="button" class="btn btn-sm btn-success txt_guardar_comentario_candidato_progreso"
																	data-id_body_comentarios="#tbody_comentario_candidato<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>"
																	data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
																<i class="fa fa-save"></i>
															</button>
														</div>
													</div>
												<?php endif; ?>
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
																	<tbody id="tbody_comentario_candidato<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>">
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
													<div class="col-md-12 text-right">
														<?php if(in_array($act->ec_instrumento_alumno->id_cat_proceso,array(ESTATUS_EN_CAPTURA,ESTATUS_OBSERVACIONES))): ?>
															<?php if($act->ec_instrumento_alumno->id_cat_proceso ==ESTATUS_OBSERVACIONES): ?>
																<button type="button" class="btn btn-sm btn-outline-danger btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																		data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="enviar" data-is_cuestionario="si"
																		title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Replica evidencia al evaluador</button>
															<?php else: ?>
																<button type="button" class="btn btn-sm btn-outline-success btn_actualizar_ec_instrumento_alumno_proceso" data-toggle="tooltip"
																		data-id_ec_instrumento_alumno="<?=$act->ec_instrumento_alumno->id_ec_instrumento_alumno?>" data-proceso_ati="enviar" data-is_cuestionario="si"
																		title="Cerrar esté instrumento como válidado, el alumno no podrá modificarlo"><i class="fa fa-check"></i> Enviar evidencia al evaluador</button>
															<?php endif; ?>
														<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
<?php else: ?>
	<div class="callout callout-danger">
		<h5>Información importante</h5>
		<p>No es posible cargar la evidencia de las técnicas, instrumentos y actividades del estándar de competencia hasta que realize la evaluación diagnóstica</p>
	</div>
<?php endif;?>
<input type="hidden" id="numero_actividades" value="<?=$numero_actividades?>">
<input type="hidden" id="numero_actividades_finalizadas" value="<?=$numero_actividades_finalizadas?>">

<div class="form-group row justify-content-between">
	<div class="col-lg-6 text-left">
		<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_evaluacion_requerimientos-tab">
			<i class="fa fa-backward"></i> Anterior
		</button>
	</div>
	<div class="col-lg-6 text-right">
		<button type="button" data-siguiente_link="#tab_jucio_competencia-tab" data-numero_paso="4" disabled="disabled"
				class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div>
