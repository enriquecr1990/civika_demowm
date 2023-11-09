<div class="form-group">
	<div class="col-12">
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
					<?php if(isset($ec_has_evaluacion) && is_array($ec_has_evaluacion) && !empty($ec_has_evaluacion)): ?>
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
								<td>
									<?php if(isset($usuario) && in_array($usuario->perfil,array('instructor','admin'))): ?>
										<button type="button" class="btn btn-sm btn-outline-success buscar_preguntas_evaluacion"
												data-id_evaluacion="<?=$ecc->id_evaluacion?>">
											<i class="fa fa-clipboard-list"></i> Ver preguntas
										</button>
									<?php endif; ?>
									<?php if(isset($usuario) && $usuario->perfil == 'alumno'): ?>
										<?php if(sizeof($ecc->evaluaciones_realizadas) < $ecc->intentos): ?>
											<a href="<?=base_url()?>evaluacion_diagnostica/<?=$ecc->id_estandar_competencia.'/'.$ecc->id_evaluacion?>" class="btn btn-sm btn-outline-danger" >
												<i class="fa fa-check"></i> Realizar examen
											</a>
										<?php endif; ?>
									<?php endif; ?>
									<button class="btn btn-sm btn-outline-info btn_ver_intentos_evaluacion btn_info_oculta" data-mostrar_instentos=".evaluaciones_candidato_<?=$index?>" type="button">
										<i class="fa fa-eye"></i> Ver evaluaciones
									</button>
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
					<?php else: ?>
						<div class="callout callout-warning">
							<h5>Lo siento</h5>
							<p>En este momento no se encuentra dado de alta la evaluación diagnóstica en el sistema, espere a que el administrador o el evaluador la suba y liberé para que pueda continuar en el proceso de certificación</p>
						</div>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="form-group row">
	<div class="col-lg-6 text-left">
		<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_derechos_obligaciones-tab">
			<i class="fa fa-backward"></i> Anterior
		</button>
	</div>
	<div class="col-6 text-right">
		<button type="button" <?=isset($ecc->evaluaciones_realizadas) && sizeof($ecc->evaluaciones_realizadas) != 0 ? '':'disabled="disabled"'?>
				data-siguiente_link="#tab_evaluacion_requerimientos-tab" data-numero_paso="2"
				class="btn btn-outline-success guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div>
