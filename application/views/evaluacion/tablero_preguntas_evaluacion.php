<hr>
<div class="form-group row">
	<label class="col-form-label">Banco de preguntas</label>
</div>
<?php if(isset($preguntas_evaluacion) && is_array($preguntas_evaluacion) && sizeof($preguntas_evaluacion) != 0): ?>
<div class="col-12">
	<div class="card">
		<div class="card-body table-responsive p-0">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Pregunta</th>
						<th>Tipo</th>
						<th style="width: 300px">
							Opciones
							<small class="form-text text-muted">Las verdes son correctas</small>
						</th>
						<th class="columna_operaciones_preguntas_eva">Operaciones</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($preguntas_evaluacion as $index => $pe): ?>
						<tr>
							<td><?=$index + 1?></td>
							<td><?=$pe->pregunta?></td>
							<td><?=$pe->tipo_pregunta?></td>
							<td class="text-justify">
								<ul class="lista_respuestas_evaluacion">
									<?php if(isset($pe->opciones_pregunta) && is_array($pe->opciones_pregunta)): ?>
										<?php if($pe->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL): ?>
											<li style="list-style: none"><span class="badge badge-info">Preguntas de lado izquierdo</span></li>
											<li style="list-style: none"><span class="badge badge-success">Preguntas de lado derecho y respuestas correctas</span></li>
										<?php endif; ?>
										<?php foreach ($pe->opciones_pregunta as $opcion): ?>
											<?php if($pe->id_cat_tipo_opciones_pregunta == OPCION_SECUENCIAL): ?>
												<li>
													<?=$opcion->descripcion?>: <span class="badge badge-success"><?=$opcion->orden_pregunta?></span>
												</li>
											<?php elseif($pe->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL): ?>
												<li>
													<span class="badge badge-<?=$opcion->pregunta_relacional == 'izquierda' ? 'info':'success'?>"><?=$opcion->orden_pregunta?></span>
													<?=$opcion->descripcion?>
												</li>
											<?php else: ?>
												<li>
													<span class="<?=$opcion->tipo_respuesta == 'correcta' ? 'respuesta_correcta':''?>" ><?=$opcion->descripcion?></span>
													<?php if(isset($opcion->archivo_imagen_respuesta) && is_object($opcion->archivo_imagen_respuesta)): ?>
														<button type="button" class="btn btn-sm btn-dark popoverShowImage mb-1"
																data-nombre_archivo="<?=$opcion->archivo_imagen_respuesta->nombre?>"
																data-src_image="<?=base_url().$opcion->archivo_imagen_respuesta->ruta_directorio.$opcion->archivo_imagen_respuesta->nombre?>">
															<i class="fa fa-image"></i>
														</button>
													<?php endif;?>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</td>
							<td class="columna_operaciones_preguntas_eva">
								<?php if(isset($estandar_competencia_has_evaluacion->liberada) && $estandar_competencia_has_evaluacion->liberada == 'no'): ?>
									<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.modificar')): ?>
										<button class="btn btn-sm btn-outline-primary modificar_pregunta_evaluacion" data-toggle="tooltip" title="Modificar pregunta"
												data-id_evaluacion="<?=$pe->id_evaluacion?>" data-id_banco_pregunta="<?=$pe->id_banco_pregunta?>">
											<i class="fa fa-edit"></i>
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.eliminar')): ?>
										<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar pregunta evaluación"
												data-msg_confirmacion_general="¿Esta seguro de eliminar la pregunta de la evaluación?, esta acción no podrá revertirse"
												data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/eliminar_pregunta/<?=$pe->id_banco_pregunta?>"
												data-btn_trigger="#btn_buscar_ec_evaluacion">
											<i class="fas fa-trash"></i>
										</button>
									<?php endif; ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
