<div class="modal fade" id="modal_curso_modulo_detalle" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Módulo capacitación detalles</b></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<img src="<?=base_url().$ec_curso->ruta_directorio.$ec_curso->nombre?>" class="img-thumbnail" alt="Curso de Estandar de Competencia">
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label">Curso: </label> <span><?=$ec_curso->nombre_curso?></span>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12"><i class="fa fa-square"></i><b> Descrición:</b></div>
					<div class="col-sm-12">
						<span><?=$ec_curso->descripcion?></span>
					</div>				
				</div>

				<div class="form-group row">
					
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-book"></i> ¿Que aprenderas?:</label>
							<div><?=$ec_curso->que_aprenderas?></div>
						</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label">Módulos</label>
				</div>

				<?php if (isset($ec_curso_modulo['ec_curso_modulo']) && is_array($ec_curso_modulo['ec_curso_modulo']) && sizeof($ec_curso_modulo['ec_curso_modulo']) != 0): ?>				
					<div class="form-group row">
						<?php foreach ($ec_curso_modulo['ec_curso_modulo'] as $index=>$eccm): ?>
							<?php if($eccm->eliminado == 'no'): ?>
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
											
											<div id="contenedor_ec_curso_modulo_temas_<?=$eccm->id_ec_curso_modulo?>">
											
											<?php if (isset($eccm->ec_curso_modulo_temario) && is_array($eccm->ec_curso_modulo_temario) && sizeof($eccm->ec_curso_modulo_temario) != 0): ?>
												<div class="form-group row">
													<?php foreach ($eccm->ec_curso_modulo_temario as $eccmt): ?>
														<?php if($eccmt->eliminado == 'no'): ?>
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
																			<label> Archivo del tema:</label>
																		</div>
																		<div class="form-group row">						
																		<p><a href="<?= base_url().$eccmt->ruta_directorio.$eccmt->nombre?>" target="_blank"><?= $eccmt->nombre ?> </a></p>						
																		</div>
																	</div>
																</div>
																<!-- /.card -->
															</div>
														<?php endif; ?>
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
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

				<?php else: ?>
					<?php $this->load->view('default/sin_datos'); ?>
				<?php endif; ?>
				

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
