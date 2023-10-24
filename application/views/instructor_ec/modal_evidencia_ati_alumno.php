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
				<input id="id_alumno" hidden value="<?= $usuario_alumno->id_usuario?>">
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

						<div class="col-lg-12" id="div_leyend_fecha_envio_ati_tablero">
							<?php $this->load->view('entregables/evaluador/tablero_evidencias_evaluador'); ?>
						</div>

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
