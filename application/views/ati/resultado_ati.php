<?php if (isset($estandar_competencia)): ?>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Estándar de competencia: </label><span
				class="col-sm-10 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
	</div>
<?php endif; ?>

<hr>
<div class="form-group row">
	<label class="col-form-label">Instrumentos de la EC</label>
</div>

<?php if(isset($existe_evidencia_alumnos) && $existe_evidencia_alumnos): ?>
	<hr>
	<div class="form-group row">
		<div class="callout callout-warning">
			<h5>Sin edición</h5>
			<p>Se detecto que hay alumnos cargando evidencia de trabajo, no es posible editar este Instrumento</p>
		</div>
	</div>
<?php endif; ?>

<?php if (isset($estandar_competencia_instrumento) && is_array($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0): ?>
	<div class="form-group row">
		<?php foreach ($estandar_competencia_instrumento as $eci): ?>
			<div class="col-lg-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?= $eci->nombre ?></h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body table-responsive p-0">
										<table class="table table-striped">
											<thead>
											<tr>
												<th>ID</th>
												<th>Actividad</th>
												<th>Instrucciones</th>
												<th>Archivos y/o Videos</th>
												<th>Operaciones</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($eci->actividades as $a): ?>
												<tr>
													<td><?=$a->id_ec_instrumento_has_actividad?></td>
													<td><?=$a->actividad?></td>
													<td><?=$a->instrucciones?></td>
													<td>
														<?php if(isset($a->archivos_videos) && is_array($a->archivos_videos) && sizeof($a->archivos_videos) != 0): ?>
															<ul style="list-style: none">
																<?php foreach ($a->archivos_videos as $av): ?>
																	<?php
																		if(!is_null($av->id_archivo) && $av->id_archivo != ''){
																			$href = base_url().$av->archivo;
																			$icon = 'fa fa-file';
																			$nombre = $av->nombre_archivo;
																		}else{
																			$href = $av->url_video;
																			$icon = 'fa fa-video';
																			$nombre = $av->url_video;
																		}
																	?>
																	<li class="mb-1">
																		<a href="<?=$href?>" target="_blank" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="<?=$nombre?>">
																			<i class="<?=$icon?>"></i> <?=substr($nombre,0,10).'...'?>
																		</a>
																	</li>
																<?php endforeach; ?>
															</ul>
														<?php else: ?>
															<span class="badge badge-primary">Sin archivos ni videos</span>
														<?php endif;?>
													</td>
													<td>
														<?php if(isset($existe_evidencia_alumnos) && !$existe_evidencia_alumnos): ?>
															<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.modificar')): ?>
																<button class="btn btn-outline-primary btn-sm modificar_estandar_competencia_ati" data-toggle="tooltip" title="Modificar instrumento"
																		data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
																		data-id_ec_instrumento_has_actividad="<?=$a->id_ec_instrumento_has_actividad?>"
																		type="button" ><i class="fa fa-edit"></i></button>
															<?php endif; ?>
															<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.eliminar')):?>
																<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar instrumento de evaluación"
																		data-msg_confirmacion_general="¿Esta seguro de eliminar el listado de tecnicas/instrumentos y actividades de la EC?, esta acción no podrá revertirse"
																		data-url_confirmacion_general="<?=base_url()?>TecnicasInstrumentos/eliminar_ec_ati/<?=$a->id_ec_instrumento_has_actividad?>"
																		data-btn_trigger="#btn_buscar_estandar_competencia_ati">
																	<i class="fas fa-trash"></i>
																</button>
															<?php endif; ?>
														<?php endif; ?>
														<?php if(perfil_permiso_operacion_menu('evaluacion.agregar') && $eci->id_cat_instrumento == INSTRUMENTO_CUESTIONARIO): ?>
															<a href="<?=base_url()?>cuestionario_ati/<?=$estandar_competencia->id_estandar_competencia.'/'.$a->id_ec_instrumento_has_actividad?>" class="btn btn-sm btn-outline-dark" data-toggle="tooltip" title="Cuestionario de evaluación">
																<i class="fa fa-file-alt"></i> Cuestionario
															</a>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		<?php endforeach; ?>
	</div>

<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
