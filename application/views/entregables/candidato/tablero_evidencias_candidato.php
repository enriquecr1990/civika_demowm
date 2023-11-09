<?php if (isset($entregables) && sizeof($entregables) != 0): ?>

	<div id="accordion_evidencias">
		<?php foreach ($entregables as $entregable): ?>
			<div class="card w-100">
				<div class="card-header sidebar-dark-primary white" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" style="color: white" data-toggle="collapse"
								data-target="#collapse-evidencia<?= old($entregable, 'id_entregable') ?>"
								aria-expanded="true"
								aria-controls="collapseOne">
							<?php if ($entregable->tipo_entregable == "prod") : ?>
								<em class="fa fa-file mr-1"></em>
							<?php endif; ?>

							<?php if ($entregable->tipo_entregable == "form") : ?>
								<em style="color: var(--dark)" class="fa fa-list mr-1"></em>
							<?php endif; ?>

							<?php if ($entregable->tipo_entregable == "cuest") : ?>
								<em style="color: var(--green)" class="fa fa-question mr-1"></em>
							<?php endif; ?>
							<?= old($entregable, 'nombre_entregable') ?>
						</button>

						<?php if ($entregable->id_estatus == 1) : ?>
							<span class="float-right badge badge-pill badge-info">En proceso</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 2) : ?>
							<span class="float-right badge badge-pill badge-light">Enviada</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 3) : ?>
							<span class="float-right badge badge-pill badge-warning">Con Observaciones</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == 4) : ?>
							<span class="float-right badge badge-pill badge-success">Liberada</span>
						<?php endif; ?>
						<?php if ($entregable->id_estatus == null) : ?>
							<span class="float-right badge badge-pill badge-dark">Pendiente</span>
						<?php endif; ?>
					</h5>
				</div>
				<div id="collapse-evidencia<?= old($entregable, 'id_entregable') ?>" class="collapse p-3"
					 aria-labelledby="headingOne"
					 data-parent="#accordion_evidencias">
					<div class="row">
						<div class="col">
							<p style="color: darkgray">
								<?= old($entregable, 'descripcion') ?>
							</p>
						</div>
					</div>

					<div class="row">
						<div class="col ">
							<label>Instrucciones</label>
							<p class=" small" style="color: darkgray">
								<?= old($entregable, 'instrucciones') ?>
							</p>
						</div>
					</div>
					<?php if (isset($entregable->instrumentos) && sizeof($entregable->instrumentos) != 0): ?>
						<div class="row">
							<div class="col ">
								<label>Instrumentos </label><span class=" small" style="color: darkgray">(a los que aplica este entregable)</span>
								<ul>
									<?php foreach ($entregable->instrumentos as $instrumento): ?>
										<li><?= old($instrumento, 'actividad') ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($entregable->tipo_entregable == "prod") : ?>


						<?php if ($entregable->id_estatus == 4) : ?>
							<div class="row">
								<div class="col-12">
									<label>Evidecias del candidato</label>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<?php if (!empty($entregable->archivos)): ?>
										<ul>
											<?php foreach ($entregable->archivos as $index_ae => $archivo): ?>
												<?php if (is_null($archivo->id_archivo_instrumento)): ?>
													<li><a href="<?= $archivo->url_video ?>"
														   target="_blank"><?= $archivo->url_video ?></a></li>
												<?php else: ?>
													<li>
														<a href="<?= base_url() . $archivo->ruta_directorio . $archivo->nombre ?>"
														   target="_blank"><?= $archivo->nombre ?></a></li>
												<?php endif; ?>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</div>
							</div>
						<?php else: ?>
							<div class="row">
								<div class="col-12">
									<input type="file" id="doc_evidencia_ati_<?= $entregable->id_entregable ?>"
										   name="doc_evidencia_ati"
										   data-id_entregable="<?= $entregable->id_entregable ?>"
										   data-div_procesando="#procesando_doc_evidencia_ati<?= $entregable->id_entregable ?>"
										   accept="*/*"
										   class="doc_evidencia_ati_alumno">
									<div id="procesando_doc_evidencia_ati<?= $entregable->id_entregable ?>"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">

									<table class="table table-striped">
										<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Archivo</th>
											<th scope="col"></th>
										</tr>
										</thead>
										<tbody id="tabla_evidencias_<?= $entregable->id_entregable ?>">
										<?php if (!empty($entregable->archivos)): ?>
											<?php foreach ($entregable->archivos as $archivo): ?>
												<tr>
													<td><?= old($archivo, 'id_archivo_instrumento') ?></td>
													<td><?= old($archivo, 'nombre') ?></td>
													<td>
														<button class="btn btn-sm btn-danger eliminar-archivo-alumno"
																data-id_archivo_instrumento="<?= old($archivo, 'id_archivo_instrumento') ?>"
																data-id_entregable="<?= $entregable->id_entregable ?>"
																data-id_entregable_alumno_archivo="<?= old($archivo, 'id_entregable_alumno_archivo') ?>"
														><em class="fa fa-trash"></em>
														</button>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php endif; ?>



					<?php endif; ?>


					<?php if ($entregable->id_estatus != 4) : ?>
						<div class="row">
							<div class="col-12">
								<div class="input-group mb-3">
							<textarea class="form-control"
									  id="txt_comentarios_candidato_<?= $entregable->id_entregable ?>"
									  placeholder="Agrega un comentario" aria-label="Comentario"
									  aria-describedby="button-addon2"></textarea>
									<div class="input-group-append">
										<button
											class="btn btn-outline-success txt_guardar_comentario_candidato_progreso"
											type="button"
											data-id_body_comentarios="#tbody_comentario_candidato<?= $entregable->id_entregable ?>"
											data-id_entregable="<?= $entregable->id_entregable ?>"
											id="guardar_comentario"><em class="fa fa-save"></em></button>
									</div>
								</div>

							</div>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="col-12">
							<table class="table table-striped">
								<thead>
								<tr>
									<th colspan="3">Comentario</th>
								</tr>
								</thead>
								<tbody id="tbody_comentario_candidato<?= $entregable->id_entregable ?>">
								<?php if (!empty($entregable->comentarios)): ?>
									<?php foreach ($entregable->comentarios as $comentario): ?>
										<td><?= old($comentario, 'quien') == 'instructor' ? 'Evaluador' : 'Candidato' ?></td>
										<td><?= old($comentario, 'comentario') ?></td>
										<td><?= old($comentario, 'fecha') ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>



					<div class="row">
						<div class="col text-right">
							<?php if ($entregable->tipo_entregable == "form") : ?>
								<?php if ($entregable->id_estatus == null || $entregable->id_estatus == 3) : ?>
									<a class="btn btn-sm btn-primary"
									   href="<?= base_url() . 'respuestas_preguntas_abiertas/' . $entregable->id_entregable ?>">Responder</a>
								<?php endif; ?>

								<?php if ($entregable->id_estatus == 1 || $entregable->id_estatus == 3) : ?>
									<button class="btn btn-sm btn-success boton-enviar-entregable"
											data-id_entregable="<?= $entregable->id_entregable ?>"
											data-id_entregable_formulario="<?= $entregable->id_entregable_formulario ?>"
									>Enviar a evaluador
									</button>
								<?php endif; ?>

							<?php endif; ?>



							<?php if ($entregable->tipo_entregable == "prod" && ($entregable->id_estatus != 4 && $entregable->id_estatus != 2)) : ?>

								<button class="btn btn-sm btn-success boton-enviar-entregable"
										data-id_entregable="<?= $entregable->id_entregable ?>">Enviar a evaluador
								</button>
							<?php endif; ?>

							<?php if ($entregable->tipo_entregable == "cuest") : ?>
								<button class="btn btn-sm btn-success boton-enviar-entregable"
										data-id_entregable="<?= $entregable->id_entregable ?>">Enviar a evaluador
								</button>
								<a href="<?=base_url().'evaluacion_entregable/'.$entregable->id_entregable.'/'.$entregable->evaluacion->id_evaluacion ?>" class="btn btn-sm btn-primary">Responder</a>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
