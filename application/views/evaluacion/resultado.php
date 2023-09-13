<?php if (isset($estandar_competencia)): ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Estándar de competencia: </label><span
				class="col-sm-10 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
	</div>
<?php endif; ?>

<hr>
<div class="form-group row">
	<label class="col-form-label">Evaluación diagnóstica de la EC</label>
</div>

<?php if (isset($evaluacion) && is_array($evaluacion) && sizeof($evaluacion) != 0): ?>
	<div class="form-group row">
		<?php foreach ($evaluacion as $e): ?>
			<div class="col-md-12">
				<div class="card card-<?=$e->eliminado == 'si' ? 'light' : 'info'?>">
					<div class="card-header">
						<h3 class="card-title <?=$e->eliminado == 'si' ? 'text-danger' : ''?>">
							<?=isset($e->titulo) ? $e->titulo : 'Evaluacion de la EC - '.$estandar_competencia->codigo?> -
							<?=isset($e->tiempo) && $e->tiempo != 0 ? 'Tiempo: '.$e->tiempo.' minutos - ': ''?>
							<?=isset($e->intentos) && $e->tiempo != 0 && $e->intentos != '' ? 'Intentos: '.$e->intentos. ' - ': ''?>
							<?=isset($e->cat_evaluacion) ? 'Evaluación: '.$e->cat_evaluacion : ''?>
						</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body" style="display: block;">
						<div class="form-group row">
							<div class="col-sm-12 text-right">
								<button id="btn_buscar_pregunta_<?=$e->id_evaluacion?>" class="btn btn-info btn-sm buscar_preguntas_evaluacion" data-toggle="tooltip"
										title="Cargar pregunta de la evaluación" style="display: none"
										data-id_evaluacion="<?=$e->id_evaluacion?>"
										type="button" ><i class="fa fa-search"></i> Buscar preguntas
								</button>
								<?php if($e->eliminado == 'si'): ?>
									<?php if(perfil_permiso_operacion_menu('evaluacion.deseliminar')):?>
										<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar evaluacion de la EC"
												data-msg_confirmacion_general="¿Esta seguro de deseliminar la evaluación de la EC?, esto volverá a estar activa la evaluación"
												data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/deseliminar/<?=$e->id_evaluacion?>"
												data-btn_trigger="#btn_buscar_ec_evaluacion">
											<i class="fas fa-trash-restore"></i> Deseliminar
										</button>
									<?php endif; ?>
								<?php else: ?>
									<?php if($e->liberada_ec == 'no'): ?>
										<?php if(perfil_permiso_operacion_menu('evaluacion.modificar')): ?>
											<button class="btn btn-outline-primary btn-sm modificar_evaluacion_ec" data-toggle="tooltip"
													title="Editar la evaluación de la EC"
													data-id_evaluacion="<?=$e->id_evaluacion?>"
													type="button" ><i class="fa fa-edit"></i> Editar
											</button>
										<?php endif; ?>
										<?php if(perfil_permiso_operacion_menu('evaluacion.cerrar_liberar')):?>
											<button type="button" class="btn btn-sm btn-outline-dark iniciar_confirmacion_operacion" data-toggle="tooltip" title="Liberar evaluación para los candidatos"
													data-msg_confirmacion_general="¿Esta seguro que desea liberar la evaluación? con esta operación ya no podrá editar la evaluación ni las preguntas del mismo y dejara disponible la evaluación para los candidatos"
													data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/liberar/<?=$e->id_evaluacion.'/'.$e->id_estandar_competencia_has_evaluacion?>"
													data-btn_trigger="#btn_buscar_ec_evaluacion">
												<i class="fas fa-sign-out-alt"></i> Liberar
											</button>
										<?php endif; ?>
										<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
											<button class="btn btn-outline-info btn-sm agregar_pregunta_evaluacion" data-toggle="tooltip"
													title="Agregar pregunta al cuestionario de evaluación"
													data-id_evaluacion="<?=$e->id_evaluacion?>"
													type="button" ><i class="fa fa-list-alt"></i> Agregar pregunta
											</button>
										<?php endif; ?>
										<?php if(perfil_permiso_operacion_menu('evaluacion.eliminar')):?>
											<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar evaluacion de la EC"
													data-msg_confirmacion_general="¿Esta seguro de eliminar la evaluación de la EC?, esta acción no podrá revertirse"
													data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/eliminar/<?=$e->id_evaluacion?>"
													data-btn_trigger="#btn_buscar_ec_evaluacion">
												<i class="fas fa-trash"></i> Eliminar
											</button>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
						<div id="contenedor_preguntas_evaluacion_<?=$e->id_evaluacion?>"></div>
					</div>
					<!-- /.card-body -->
					<?php if($e->eliminado == 'no'): ?>
						<div class="card-footer text-right">
							<?php if($e->liberada_ec == 'no'): ?>
								<?php if(perfil_permiso_operacion_menu('evaluacion.modificar')): ?>
									<button class="btn btn-outline-primary btn-sm modificar_evaluacion_ec" data-toggle="tooltip"
											title="Editar la evaluación de la EC"
											data-id_evaluacion="<?=$e->id_evaluacion?>"
											type="button" ><i class="fa fa-edit"></i> Editar
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('evaluacion.cerrar_liberar')):?>
									<button type="button" class="btn btn-sm btn-outline-dark iniciar_confirmacion_operacion" data-toggle="tooltip" title="Liberar evaluación para los candidatos"
											data-msg_confirmacion_general="¿Esta seguro que desea liberar la evaluación? con esta operación ya no podrá editar la evaluación ni las preguntas del mismo y dejara disponible la evaluación para los candidatos"
											data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/liberar/<?=$e->id_estandar_competencia_has_evaluacion?>"
											data-btn_trigger="#btn_buscar_ec_evaluacion">
										<i class="fas fa-sign-out-alt"></i> Liberar
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
									<button class="btn btn-outline-info btn-sm agregar_pregunta_evaluacion" data-toggle="tooltip"
											title="Agregar pregunta al cuestionario de evaluación"
											data-id_evaluacion="<?=$e->id_evaluacion?>"
											type="button" ><i class="fa fa-list-alt"></i> Agregar pregunta
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('evaluacion.eliminar')):?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar evaluacion de la EC"
											data-msg_confirmacion_general="¿Esta seguro de eliminar la evaluación de la EC?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/eliminar/<?=$e->id_evaluacion?>"
											data-btn_trigger="#btn_buscar_ec_evaluacion">
										<i class="fas fa-trash"></i> Eliminar
									</button>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<!-- /.card -->
			</div>
		<?php endforeach; ?>
	</div>

<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
