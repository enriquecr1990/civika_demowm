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
												<th>Operaciones</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($eci->actividades as $index => $a): ?>
												<tr>
													<td><?=$index + 1?></td>
													<td><?=$a->actividad?></td>
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
