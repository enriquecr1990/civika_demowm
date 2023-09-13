<div class="modal fade" id="modal_evidencia_evaluacion" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="titulo_modal_evidencia"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">

				<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','admin','root'))): ?>
					<div class="col-lg-12" id="modal_tablero_cedula_evaluacion">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Resultados de la evaluación</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>

							<div class="card-body">

								<form id="form_resultados_evaluacion">
									<div class="form-group row">
										<div class="col-lg-6">
											<label for="txt_mejores_practicas" class="col-form-label">Mejores practicas:</label>
											<textarea class="form-control" id="txt_mejores_practicas" placeholder="Describa las mejores practicas"
													  data-rule-required="true" name="mejores_practicas"><?=$usuario_has_ec->mejores_practicas?></textarea>
										</div>
										<div class="col-lg-6">
											<label for="txt_areas_oportunidad" class="col-form-label">Áreas de oportunidad:</label>
											<textarea class="form-control" id="txt_areas_oportunidad" placeholder="Describa las áreas de oportunidad"
													  data-rule-required="true" name="areas_oportunidad"><?=$usuario_has_ec->areas_oportunidad?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-6">
											<label for="txt_criterios_no_cubiertos" class="col-form-label">Criterios de evaluación no cubiertos:</label>
											<textarea class="form-control" id="txt_criterios_no_cubiertos" placeholder="Describa los criterios de evaluación no cubiertos por el candidato"
													  data-rule-required="true" name="criterio_no_cubiertos"><?=$usuario_has_ec->criterio_no_cubiertos?></textarea>
										</div>
										<div class="col-lg-6">
											<label for="txt_recomendaciones" class="col-form-label">Recomendaciones:</label>
											<textarea class="form-control" id="txt_recomendaciones" placeholder="Describa las recomendaciones de la evaluación"
													  data-rule-required="true" name="recomendaciones"><?=$usuario_has_ec->recomendaciones?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="input_jucio_evaluacion_c" class="col-sm-2 col-form-label">Juicio de evaluación</label>
										<div class="col-sm-4">
											<div class="form-group row">
												<div class="col-lg-6">
													<div class="custom-control custom-radio">
														<input class="custom-control-input" type="radio" data-rule-required="true" id="input_jucio_evaluacion_c"
															   name="jucio_evaluacion" value="competente" <?=isset($usuario_has_ec) && $usuario_has_ec->jucio_evaluacion == 'competente' ? 'checked="checked"':''?>>
														<label for="input_jucio_evaluacion_c" class="custom-control-label">Competente</label>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="custom-control custom-radio">
														<input class="custom-control-input" type="radio" id="input_jucio_evaluacion_nc" name="jucio_evaluacion"
															   value="no_competente"  <?=isset($usuario_has_ec) && $usuario_has_ec->jucio_evaluacion == 'no_competente' ? 'checked="checked"':''?>>
														<label for="input_jucio_evaluacion_nc" class="custom-control-label">No competente</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3">Observaciones del candidato:</label>
										<span class="col-sm-9"><?=$usuario_has_ec->observaciones_candidato?></span>
									</div>
								</form>
								<div class="col-lg-12 text-right">
									<button type="button" id="btn_update_resultados_evaluacion"
											data-id_usuario_has_estandar_competencia="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>"
											class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i> Guardar resultados</button>
								</div>

							</div>
						</div>
					</div>
				<?php endif ?>

				<div class="col-12" id="modal_tablero_evaluacion_diagnostica">
					<div class="card">
						<div class="card-body table-responsive p-0">
							<table class="table table-striped">
								<thead>
								<tr>
									<th>ID</th>
									<th>Titulo</th>
									<th>
										Tiempo
										<small class="form-text text-muted">En minutos</small>
									</th>
									<th>
										Calificación
										<small class="form-text text-muted">Se tomará la más alta</small>
									</th>
									<th>Evaluación</th>
									<th></th>
								</tr>
								</thead>
								<tbody>
								<?php if(isset($ec_has_evaluacion)): ?>
									<?php foreach ($ec_has_evaluacion as $index => $ecc):?>
										<?php $calificaciones[$index] = array(); ?>
										<tr>
											<td><?=$index + 1?></td>
											<td><?=$ecc->titulo?></td>
											<td><?=$ecc->tiempo != 0 && $ecc->tiempo != '' ? $ecc->tiempo : 'N/A'?></td>
											<td>
												<span id="span_calificacion_alta_<?=$index?>"></span>
											</td>
											<td><?=$ecc->tipo_evaluacion?></td>
											<td style="max-width: 150px">
												<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','admin'))): ?>
													<button type="button" class="btn btn-sm btn-success buscar_preguntas_evaluacion"
															data-id_evaluacion="<?=$ecc->id_evaluacion?>">
														<i class="fa fa-clipboard-list"></i> Ver preguntas
													</button>
												<?php endif; ?>
												<?php if(isset($usuario) && $usuario->perfil == 'alumno'): ?>
													<?php if(sizeof($ecc->evaluaciones_realizadas) < $ecc->intentos): ?>
														<a href="<?=base_url()?>evaluacion/<?=$ecc->id_estandar_competencia.'/'.$ecc->id_evaluacion?>" class="btn btn-sm btn-danger" >
															<i class="fa fa-check"></i> Realizar examen
														</a>
													<?php endif; ?>
												<?php endif; ?>
												<button class="btn btn-sm btn-info btn_ver_intentos_evaluacion btn_info_oculta" data-mostrar_instentos=".evaluaciones_candidato_<?=$index?>" type="button">
													<i class="fa fa-eye"></i> Ver evaluaciones
												</button>
												<div class="form-group row">
													<div class="col-lg-12">
														<label>Intentos Adicionales: </label>
														<input type="number" class="form-control input_modificacion_update"
															   data-mostrar_mensaje="si"
															   data-campo_actualizar="intentos_adicionales"
															   data-tabla_actualizar="usuario_has_estandar_competencia"
															   data-id_actualizar="id_usuario_has_estandar_competencia"
															   data-id_actualizar_valor="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>"
															   placeholder="Intentos Adicionales"
															   value="<?=$usuario_has_ec->intentos_adicionales?>">
														<small class="form-text text-muted">Modifique para habilitar más intentos (al salir del texto o presionando ENTER se guardará automáticamente)</small>
													</div>
												</div>
											</td>
											<td></td>
										</tr>
										<?php if(isset($ecc->evaluaciones_realizadas) && is_array($ecc->evaluaciones_realizadas) && sizeof($ecc->evaluaciones_realizadas) != 0): ?>
											<?php foreach ($ecc->evaluaciones_realizadas as $index_er => $er): ?>
												<?php $calificaciones[$index][] = $er->calificacion ?>
												<tr class="evaluaciones_candidato_<?=$index?>" style="display: none;">
													<td ></td>
													<td><?=$index_er+1?></td>
													<td>Inicio: <?=fechaHoraBDToHTML($er->fecha_iniciada)?></td>
													<td>Finalizo: <?=fechaHoraBDToHTML($er->fecha_enviada)?></td>
													<td>Calificacion: <span class="span_calificacion_evidencia" data-calificacion="<?=$er->calificacion?>"><?=$er->calificacion?></span></td>
													<td>Decisión tomada:
														<i>
														<?php switch ($er->decision_candidato){
															case 'tomar_capacitacion':
																echo 'Tomar capacitación previo a la Evaluación';
																break;
															case 'tomar_alineacion':
																echo 'Tomar alineación previo a la Evaluación';
																break;
															case 'tomar_proceso':
																echo 'Iniciar el proceso de Evaluación';
																break;
															default:
																echo 'Otro: '.$er->descripcion_candidato_otro;
																break;
														}?>
														</i>
													</td>
													<td>
														<button data-id_usuario_has_evaluacion_realizada="<?=$er->id_usuario_has_evaluacion_realizada?>" class="btn btn-success btn-sm ver_evaluacion_respuestas_candidato">
															<i class="fa fa-clipboard-list"></i>Ver evaluación
														</button>
													</td>
												</tr>
											<?php endforeach; ?>
											<input type="hidden" class="calificacion_alta" data-id_index="<?=$index?>" id="calificacion_alta_<?=$index?>" value="<?=max($calificaciones[$index])?>">
										<?php else: ?>
											<tr class="evaluaciones_candidato_<?=$index?>" style="display: none;">
												<td colspan="6">Sin evaluaciones realizadas</td>
											</tr>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div id="contenedor_preguntas_preview" class="form-group row" style="display: none">
					<div class="col-md-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Preguntas/Respuestas de la EC</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="form-group row" id="card_body_preguntas_preview">

								</div>
							</div>
						</div>
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
