<div class="modal fade" id="modal_form_instructor_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-<?=isset($tipo) && $tipo == 'instructor' ? 'lg':'xl'?>">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($tipo) && $tipo == 'instructor' ? 'Evaluadores':'Candidatos'?> en el EC</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_ec_ati">
				<input id="estandar_competencia_instructor" type="hidden" value="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>">
				<?php if((isset($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0
							&& isset($estandar_competencia_evaluacion) && is_object($estandar_competencia_evaluacion)
							&& isset($estandar_competencia_has_requerimientos) && sizeof($estandar_competencia_has_requerimientos) != 0
							&& isset($instructores_asignados) && sizeof($instructores_asignados) != 0)
						|| $tipo == 'instructor'): ?>
					<div class="modal-body">
						<?php if(isset($usuarios) && is_array($usuarios) && sizeof($usuarios) > 0): ?>
							<?php if($tipo == 'alumno'): ?>
								<div id="listado_usuarios_evaluadores_asignados" style="display: none">
									<select class="custom-select  form-control-border slt_usuarios_evaluadores_asignados">
										<option value="">--Seleccione--</option>
										<?php foreach ($instructores_asignados as $ia): ?>
											<option value="<?=$ia->id_usuario?>"><?=$ia->codigo_evaluador.' - '.$ia->nombre.' '.$ia->apellido_p.' '.$ia->apellido_m?></option>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>
							<div class="form-group row">
								<label for="instructores_alumnos_disponibles" class="col-sm-3 col-form-label"><?=isset($tipo) && $tipo == 'instructor' ? 'Evaluadores':'Candidatos'?></label>
								<div class="col-sm-9">
									<select id="instructores_alumnos_disponibles" class="custom-select form-control-border slt_instructor_alumno_ec"
											data-tipo="<?=$tipo?>"
											name="instructor_alumno_id_usuario">
										<option value="">-- Seleccione --</option>
										<?php if(isset($usuarios)): ?>
											<?php foreach ($usuarios as $instructor): ?>
												<option id="instructor_alumno<?=$instructor->id_usuario?>" data-foto_perfil="<?=$instructor->foto_perfil?>"
														value="<?=$instructor->id_usuario?>" >
													<?php if($tipo == 'instructor'): ?>
														<?=isset($instructor->codigo_evaluador) ? $instructor->codigo_evaluador : ''?> - <?=$instructor->nombre.' '.$instructor->apellido_p.' '.$instructor->apellido_m?>
													<?php else: ?>
														<?=isset($instructor->curp) ? $instructor->curp : ''?> - <?=$instructor->nombre.' '.$instructor->apellido_p.' '.$instructor->apellido_m?>
													<?php endif ?>
												</option>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
									<?php if(isset($tipo) && $tipo == 'instructor'): ?>
										<small class="form-text text-muted">Seleccione un nombre de la lista, se guardara automaticamente en el sistema al momento de seleccionar algún evaluador </small>
									<?php else: ?>
										<small class="form-text text-muted">Seleccione un nombre de la lista, se agregará al tablero, posteriormente seleccione un evaluador de la EC y de click en el boton verde para guardar la información</small>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group row">
								<div class="card-body table-responsive p-0" id="table_otras_actividades">
									<table class="table table-head-fixed text-nowrap">
										<thead>
										<tr>
											<th></th>
											<?php if($tipo == 'alumno'): ?>
												<th>Candidato</th>
											<?php endif; ?>
											<th>Evaluadores</th>
											<th class="text-center">
											</th>
										</tr>
										</thead>
										<tbody id="tbody_instructores_alumnos_ec">

										</tbody>
									</table>
								</div>
							</div>

						<?php else: ?>
							<div class="form-group row">
								<div class="callout callout-warning col-sm-12">
									<h5>Aviso importante: </h5>
									<p>
										Se detectó que no cuenta con <?=isset($tipo) && $tipo == 'instructor' ? 'Evaluadores' : 'candidatos/alumnos'?> registrados en el sistema, favor de
										registrar por lo menos uno para continuar; pulse <a href="<?=base_url()?>usuario/<?=isset($tipo) && $tipo == 'instructor' ? 'instructores' : 'candidatos'?>">aquí</a> para ir al modulo de correspondiente
									</p>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="modal-footer text-right">
						<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Aceptar</button>
					</div>
				<?php else: ?>
					<div class="modal-body">
						<div class="callout callout-danger">
							<h5>Lo siento</h5>
							<p>Para poder asignar los alumnos es necesario que registre:</p>
							<ol>
								<li>Las actividades, tecnicas e instrumentos de evaluación con sus cuestionarios liberados (si aplica) <span class="badge badge-dark"><?=isset($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0 && $evaluacion_instrumento_liberados ? 'OK':'Falta'?></span></li>
								<li>Los requerimientos de evaluación <span class="badge badge-dark"><?=isset($estandar_competencia_has_requerimientos) && sizeof($estandar_competencia_has_requerimientos) != 0 ? 'OK':'Falta'?></span></li>
								<li>La evaluación diagnostica liberada <span class="badge badge-dark"><?=isset($estandar_competencia_evaluacion) && is_object($estandar_competencia_evaluacion) != 0 ? 'OK':'Falta'?></span></li>
								<li>Asignar por lo menos un evaluador al Estándar de competencia <span class="badge badge-dark"><?=isset($instructores_asignados) && sizeof($instructores_asignados) != 0 ? 'OK':'Falta'?></span></li>
							</ol>
						</div>
					</div>
					<div class="modal-footer text-right">
						<button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Cerrar</button>
					</div>
				<?php endif; ?>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
