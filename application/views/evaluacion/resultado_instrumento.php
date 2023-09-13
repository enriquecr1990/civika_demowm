<?php if (isset($ec_instrumento_has_actividad)): ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Instrumento de evaluación: </label>
		<span id="descripcion_actividad" class="col-sm-10 col-form-label"><?= $ec_instrumento_has_actividad->actividad?></span>
	</div>
<?php endif; ?>

<hr>
<div class="form-group row">
	<label class="col-form-label">Evaluación del instrumento</label>
</div>

<?php if (isset($evaluacion) && is_array($evaluacion) && sizeof($evaluacion) != 0): ?>
	<div class="form-group row">
		<?php foreach ($evaluacion as $e): ?>
			<?php if(is_null($e->tiempo)): ?>
				<input type="hidden" id="btn_sin_modificar_evaluacion" value="<?=$e->id_evaluacion?>">
			<?php endif; ?>
			<div class="col-md-12">
				<div class="card card-<?=$e->eliminado == 'si' ? 'light' : 'info'?>">
					<div class="card-header">
						<h3 class="card-title <?=$e->eliminado == 'si' ? 'text-danger' : ''?>">
							<?=isset($e->tiempo) && $e->tiempo != 0 ? 'Tiempo: '.$e->tiempo.' minutos': ''?>
							<?=isset($e->intentos) && $e->intentos != 0 && $e->intentos != '' ? ' - Intentos: '.$e->intentos: ''?>
							<?=isset($e->cat_evaluacion) ? ' - Evaluación: '.$e->cat_evaluacion : ''?>
						</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-12 text-right">
								<button id="btn_buscar_pregunta_<?=$e->id_evaluacion?>" class="btn btn-info btn-sm buscar_preguntas_evaluacion" data-toggle="tooltip"
										title="Cargar pregunta de la evaluación" style="display: none"
										data-id_evaluacion="<?=$e->id_evaluacion?>"
										type="button" ><i class="fa fa-search"></i> Buscar preguntas
								</button>
								<?php if($e->liberada_instrumento == 'no'): ?>
									<?php if(perfil_permiso_operacion_menu('evaluacion.modificar')): ?>
										<button id="btn_editar_evaluacion_<?=$e->id_evaluacion?>" class="btn btn-outline-primary btn-sm modificar_evaluacion_ec" data-toggle="tooltip"
												title="Editar la evaluación de la EC"
												data-id_evaluacion="<?=$e->id_evaluacion?>"
												type="button" ><i class="fa fa-edit"></i> Editar
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('evaluacion.cerrar_liberar')):?>
										<button type="button" class="btn btn-sm btn-outline-dark iniciar_confirmacion_operacion" data-toggle="tooltip" title="Liberar evaluación para los candidatos"
												data-msg_confirmacion_general="¿Esta seguro que desea liberar la evaluación? con esta operación ya no podrá editar la evaluación ni las preguntas del mismo y dejara disponible la evaluación para los candidatos"
												data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/liberar_evaluacion_instrumento/<?=$e->id_evaluacion.'/'.$e->id_ec_instrumento_actividad_evaluacion?>"
												data-btn_trigger="#btn_buscar_ec_evaluacion_cuestionario">
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
								<?php endif; ?>
							</div>
						</div>
						<div id="contenedor_preguntas_evaluacion_<?=$e->id_evaluacion?>"></div>
					</div>
					<!-- /.card-body -->
					<?php if($e->eliminado == 'no'): ?>
						<div class="card-footer text-right">
							<?php if($e->liberada_instrumento == 'no'): ?>
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
											data-url_confirmacion_general="<?=base_url()?>EvaluacionEC/liberar_evaluacion_instrumento/<?=$e->id_evaluacion.'/'.$e->id_ec_instrumento_actividad_evaluacion?>"
											data-btn_trigger="#btn_buscar_ec_evaluacion_cuestionario">
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
