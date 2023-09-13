<div class="modal fade" id="modal_evidencia_evaluacion_respuestas" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Evaluación realizada</h4>
				<button type="button" class="close btn_cerrar_modal_evidencia_respuestas" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="card card-solid">
					<div class="card-body pb-0">

						<div class="callout callout-success">
							<h5>Información del sistema</h5>
							<p>Esta evaluación es información de sus respuestas realizadas</p>
							<ul>
								<?php if(isset($usuario_has_evaluacion_realizada)){};?>
								<li>Inicio: <?=fechaHoraBDToHTML($usuario_has_evaluacion_realizada->fecha_iniciada)?></li>
								<li>Fin: <?=fechaHoraBDToHTML($usuario_has_evaluacion_realizada->fecha_enviada)?></li>
								<li>Calificación: <span class="span_calificacion_evidencia" data-calificacion="<?=$usuario_has_evaluacion_realizada->calificacion?>"><?=$usuario_has_evaluacion_realizada->calificacion?></span></li>
							</ul>
						</div>

						<?php if(isset($preguntas_evaluacion) && is_array($preguntas_evaluacion)): ?>
							<?php foreach ($preguntas_evaluacion as $index => $prt): ?>
								<!-- redaccion de la pregunta -->
								<div class="form-group row">
									<label><?=$index + 1?>. - <?=$prt->pregunta?></label> &nbsp;
									<?php if(!isset($respuestas_candidato[$prt->id_banco_pregunta]) || !$respuestas_candidato[$prt->id_banco_pregunta]): ?>
										<span class="badge badge-danger">Incorrecta</span>
									<?php endif; ?>
								</div>
								<!-- opciones de la pregunta -->
								<?php if(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_VERDADERO_FALSO,OPCION_UNICA_OPCION,OPCION_IMAGEN_UNICA_OPCION))): ?>
									<div class="row">
										<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
											<div class="form-group col-md-3">
												<div class="custom-control custom-radio">
													<span class="<?=in_array($op->id_opcion_pregunta,$prt->respuesta_candidato) ? 'respuesta_correcta':''?>"><?=$op->descripcion?></span>
													<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
														<img class="img-thumbnail popoverShowImage"
															 data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
															 data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
															 style="width: 50px !important;" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
														<button type="button" data-nombre_archivo="<?=$op->archivo_imagen_respuesta->nombre?>"
																data-src_image="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>"
																class="btn btn-sm btn-outline-success btn_ver_imagen_modal"><i class="fa fa-eye"></i></button>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								<?php elseif(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_OPCION_MULTIPLE,OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
									<div class="row">
										<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
											<div class="form-group col-md-3">
												<div class="custom-control custom-checkbox">
													<span class="<?=in_array($op->id_opcion_pregunta,$prt->respuesta_candidato) ? 'respuesta_correcta':''?>"><?=$op->descripcion?></span>
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
																<span class="respuesta_correcta"><?=isset($prt->respuesta_candidato[$index_op]) ? $prt->respuesta_candidato[$index_op] : 'Sin respuesta'?></span>
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
																<span class="respuesta_correcta"><?=isset($prt->respuesta_candidato[$index_op]) ? $prt->respuesta_candidato[$index_op] : 'Sin respuesta'?></span>
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
					</div>
				</div>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default btn_cerrar_modal_evidencia_respuestas">Cerrar</button>
			</div>
		</div>
	</div>
</div>
