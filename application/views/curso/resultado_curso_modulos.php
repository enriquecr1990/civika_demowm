<?php if (isset($ec_curso)): ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Módulo de capacitación: </label><span
				class="col-sm-10 col-form-label"><?= $ec_curso->nombre_curso ?></span>
		<label class="col-sm-2 col-form-label">Descripción: </label><span
			class="col-sm-10 col-form-label"><?= $ec_curso->descripcion ?></span>
	</div>
<?php endif; ?>

<hr>
<div class="form-group row">
	<label class="col-form-label">Módulos</label>
</div>

<?php if (isset($ec_curso_modulo) && is_array($ec_curso_modulo) && sizeof($ec_curso_modulo) != 0): ?>
	<div class="form-group row">
		<?php foreach ($ec_curso_modulo as $index=>$eccm): ?>
			<div class="col-md-12">
				<div class="card card-<?=$eccm->eliminado == 'si' ? 'light' : 'primary'?> <?= $index == 0 ? "" : "collapsed-card"?>">
					<div class="card-header">
						<h3 class="card-title <?=$eccm->eliminado == 'si' ? 'text-danger' : ''?>">
							<label> Descripción: <?=isset($eccm->descripcion) ? $eccm->descripcion : "" ?></label>
						</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-<?= $index == 0 ? 'minus' : 'plus'?>"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body" style="display: <?= $index == 0 ? 'block' : 'none'?>;">
						<div class="form-group row">
							<label> Objetvo general:</label>					
						</div>
						<div class="form-group row">
							<?=isset($eccm->objetivo_general) ? $eccm->objetivo_general : ''?>						
						</div>
						<div class="form-group row">						
							<label> Objetivos especificos:</label>
						</div>
						<div class="form-group row">						
							<?=isset($eccm->objetivos_especificos) ? $eccm->objetivos_especificos : ''?></span>							
						</div>
						<div class="form-group row">
							<div class="col-sm-12 text-right">	
							
						<?php if($ec_curso->fecha_publicado == null): ?>
							<?php if($eccm->eliminado == 'si'): ?>
								<?php if(perfil_permiso_operacion_menu('ec_curso.deseliminar')):?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar módulo"
											data-msg_confirmacion_general="¿Esta seguro de deseliminar el módulo?, esto volverá a activar el módulo"
											data-url_confirmacion_general="<?=base_url()?>Curso/deseliminar_ec_curso_modulo/<?=$eccm->id_ec_curso_modulo?>"
											data-btn_trigger="#btn_buscar_ec_curso_modulos">
										<i class="fas fa-trash-restore"></i> Deseliminar
									</button>
								<?php endif; ?>
							<?php else: ?>
									<?php if(perfil_permiso_operacion_menu('ec_curso.modificar')): ?>
										<button class="btn btn-outline-primary btn-sm modificar_ec_curso_modulo" data-toggle="tooltip"
												title="Editar módulo"
												data-id_ec_curso="<?=$eccm->id_ec_curso?>"
												data-id_ec_curso_modulo="<?=$eccm->id_ec_curso_modulo?>"
												type="button" ><i class="fa fa-edit"></i> Editar
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('ec_curso.agregar')):?>
										<button class="btn btn-outline-info btn-sm agregar_ec_curso_modulo_temario" data-toggle="tooltip"
												title="Agregar temario al módulo"
												data-id_ec_curso_modulo="<?=$eccm->id_ec_curso_modulo?>"
												type="button" ><i class="fa fa-list-alt"></i> Agregar tema
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('ec_curso.consultar')): ?>
										<a class="btn btn-sm btn-outline-dark" data-toggle="tooltip"
										title="Evaluación al Módulo del Estándar de competencia"
										href="<?=base_url()?>evaluacion_cerrada/<?=EVALUACION_MODULO.'/'.$eccm->id_ec_curso_modulo?>"><i class="fa fa-file-alt"></i> Cuestionario de evaluación</a>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('ec_curso.eliminar')):?>
										<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar módulo"
												data-msg_confirmacion_general="¿Esta seguro de eliminar el módulo?, esta acción no podrá revertirse"
												data-url_confirmacion_general="<?=base_url()?>Curso/eliminar_ec_curso_modulo/<?=$eccm->id_ec_curso_modulo?>"
												data-btn_trigger="#btn_buscar_ec_curso_modulos">
											<i class="fas fa-trash"></i> Eliminar
										</button>
									<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
							</div>
						</div>
						<div id="contenedor_ec_curso_modulo_temas_<?=$eccm->id_ec_curso_modulo?>">
						
						<?php if (isset($eccm->ec_curso_modulo_temario) && is_array($eccm->ec_curso_modulo_temario) && sizeof($eccm->ec_curso_modulo_temario) != 0): ?>
							<div class="form-group row">
								<?php foreach ($eccm->ec_curso_modulo_temario as $eccmt): ?>
									<div class="col-md-12">
										<div class="card card-<?=$eccmt->eliminado == 'si' ? 'light' : 'info'?> collapsed-card">
											<div class="card-header">
												<h3 class="card-title <?=$eccmt->eliminado == 'si' ? 'text-danger' : ''?>">
													<label> Tema: <?=isset($eccmt->tema) ? $eccmt->tema : "" ?><?=$eccmt->eliminado == 'si' ? '- ELIMINADO' : ''?></label>
												</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-plus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body" style="display: none;">
											<div class="form-group row">
													<div class="col-sm-12 text-right">
												<?php if($ec_curso->publicado == 'no'): ?>
													<?php if($eccmt->eliminado == 'si'): ?>
														<?php if(perfil_permiso_operacion_menu('ec_curso.deseliminar')):?>
															<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar temario"
																	data-msg_confirmacion_general="¿Esta seguro de deseliminar el temario del módulo?, esto volverá a activar el temario"
																	data-url_confirmacion_general="<?=base_url()?>Curso/deseliminar_ec_curso_modulo_temario/<?=$eccmt->id_ec_curso_modulo_temario?>"
																	data-btn_trigger="#btn_buscar_ec_curso_modulos">
																<i class="fas fa-trash-restore"></i> Deseliminar
															</button>
														<?php endif; ?>
													<?php else: ?>
															<?php if(perfil_permiso_operacion_menu('ec_curso.modificar')): ?>
																<button class="btn btn-outline-primary btn-sm modificar_ec_curso_modulo_temario" data-toggle="tooltip"
																		title="Editar temario del módulo"
																		data-id_ec_curso_modulo="<?=$eccmt->id_ec_curso_modulo?>"
																		data-id_ec_curso_modulo_temario="<?=$eccmt->id_ec_curso_modulo_temario?>"
																		type="button" ><i class="fa fa-edit"></i> Editar
																</button>
															<?php endif; ?>
															<?php if(perfil_permiso_operacion_menu('ec_curso.eliminar')):?>
																<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar temario"
																		data-msg_confirmacion_general="¿Esta seguro de eliminar el temario del módulo?, esta acción no podrá revertirse"
																		data-url_confirmacion_general="<?=base_url()?>Curso/eliminar_ec_curso_modulo_temario/<?=$eccmt->id_ec_curso_modulo_temario?>"
																		data-btn_trigger="#btn_buscar_ec_curso_modulos">
																	<i class="fas fa-trash"></i> Eliminar
																</button>
															<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>
													</div>
												</div>

												<div class="form-group row">
													<label> Innstrucciones:</label>
												</div>
												<div class="form-group row">
													<?=isset($eccmt->instrucciones) ? $eccmt->instrucciones : ''?>						
												</div>
												<div class="form-group row">						
													<label> Contenido curso:</label>
												</div>
												<div class="form-group row">						
													<?=isset($eccmt->contenido_curso) ? $eccmt->contenido_curso : ''?></span>							
												</div>

												<div class="form-group row">						
													<label> Archivo:</label>
												</div>
												<div class="form-group row">						
												<p><a href="<?= base_url().$eccmt->ruta_directorio.$eccmt->nombre?>" target="_blank"><?= $eccmt->nombre ?> </a></p>						
												</div>

												
												<div class="form-group row">
													<div class="col-sm-12 text-right">	
												<?php if($ec_curso->fecha_publicado == null): ?>
													<?php if($eccmt->eliminado == 'si'): ?>
														<?php if(perfil_permiso_operacion_menu('ec_curso.deseliminar')):?>
															<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar temario"
																	data-msg_confirmacion_general="¿Esta seguro de deseliminar el temario del módulo?, esto volverá a activar el temario"
																	data-url_confirmacion_general="<?=base_url()?>Curso/deseliminar_ec_curso_modulo_temario/<?=$eccmt->id_ec_curso_modulo_temario?>"
																	data-btn_trigger="#btn_buscar_ec_curso_modulos">
																<i class="fas fa-trash-restore"></i> Deseliminar
															</button>
														<?php endif; ?>
													<?php else: ?>
															<?php if(perfil_permiso_operacion_menu('ec_curso.modificar')): ?>
																<button class="btn btn-outline-primary btn-sm modificar_ec_curso_modulo_temario" data-toggle="tooltip"
																		title="Editar temario del módulo"
																		data-id_ec_curso_modulo="<?=$eccmt->id_ec_curso_modulo?>"
																		data-id_ec_curso_modulo_temario="<?=$eccmt->id_ec_curso_modulo_temario?>"
																		type="button" ><i class="fa fa-edit"></i> Editar
																</button>
															<?php endif; ?>
															<?php if(perfil_permiso_operacion_menu('ec_curso.eliminar')):?>
																<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar temario"
																		data-msg_confirmacion_general="¿Esta seguro de eliminar el temario del módulo?, esta acción no podrá revertirse"
																		data-url_confirmacion_general="<?=base_url()?>Curso/eliminar_ec_curso_modulo_temario/<?=$eccmt->id_ec_curso_modulo_temario?>"
																		data-btn_trigger="#btn_buscar_ec_curso_modulos">
																	<i class="fas fa-trash"></i> Eliminar
																</button>
															<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>
													</div>
												</div>
											</div>
										</div>
										<!-- /.card -->
									</div>
								<?php endforeach; ?>
							</div>

						<?php else: ?>
							<?php $this->load->view('default/sin_datos'); ?>
						<?php endif; ?>
						</div>
					</div>
				</div>
				<!-- /.card -->
			</div>
		<?php endforeach; ?>
	</div>

<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
