<div class="modal fade" id="modal_curso_modulo_detalle" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Curso detalles</b></h4>
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

				<!-- <div class="form-group row">
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
						<div class="card" style="width: 18rem;">
							<div class="card-body">
								<h5 class="card-title">Módulo 1 </h5>
								<p class="card-text">Descripción módulo 1</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>
							</div>
							<div class="card-footer text-right">
								<?php if(perfil_permiso_operacion_menu('curso_ec.consultar')): ?>
									<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_curso_ec" data-id_ec_curso="<?=$ec_curso->id_ec_curso?>">
										<i class="fa fa-eye"></i> Ver detalle
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.modificar')): ?>
									<button type="button" id="modificar_estandar_competencia_curso" class="btn btn-sm btn-outline-info"
											data-id_estandar_competencia="<?=$ec_curso->id_estandar_competencia ?>"
											data-id_ec_curso="<?=$ec_curso->id_ec_curso?>" >
										<i class="fa fa-edit"></i> Modificar
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.eliminar')): ?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
											data-toggle="tooltip" title="Eliminar Curso"
											data-msg_confirmacion_general="¿Esta seguro de eliminar el curso?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>Curso/eliminar/<?=$ec_curso->id_ec_curso?>"
											data-btn_trigger="#btn_buscar_ec_curso">
										<i class="fas fa-trash"></i> Eliminar
									</button>
									<hr>
								<?php endif; ?>  					
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
						<div class="card" style="width: 18rem;">
							<div class="card-body">
								<h5 class="card-title">Módulo 2 </h5>
								<p class="card-text">Descripción módulo 2</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>
							</div>
							<div class="card-footer text-right">
								<?php if(perfil_permiso_operacion_menu('curso_ec.consultar')): ?>
									<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_curso_ec" data-id_ec_curso="<?=$ec_curso->id_ec_curso?>">
										<i class="fa fa-eye"></i> Ver detalle
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.modificar')): ?>
									<button type="button" id="modificar_estandar_competencia_curso" class="btn btn-sm btn-outline-info"
											data-id_estandar_competencia="<?=$ec_curso->id_estandar_competencia ?>"
											data-id_ec_curso="<?=$ec_curso->id_ec_curso?>" >
										<i class="fa fa-edit"></i> Modificar
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.eliminar')): ?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
											data-toggle="tooltip" title="Eliminar Curso"
											data-msg_confirmacion_general="¿Esta seguro de eliminar el curso?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>Curso/eliminar/<?=$ec_curso->id_ec_curso?>"
											data-btn_trigger="#btn_buscar_ec_curso">
										<i class="fas fa-trash"></i> Eliminar
									</button>
									<hr>
								<?php endif; ?>  					
							</div>
						</div>
					</div>
					<br>
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
						<div class="card" style="width: 18rem;">
							<div class="card-body">
								<h5 class="card-title">Módulo 3 </h5>
								<p class="card-text">Descripción módulo 3</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>
							</div>
							<div class="card-footer text-right">
								<?php if(perfil_permiso_operacion_menu('curso_ec.consultar')): ?>
									<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_curso_ec" data-id_ec_curso="<?=$ec_curso->id_ec_curso?>">
										<i class="fa fa-eye"></i> Ver detalle
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.modificar')): ?>
									<button type="button" id="modificar_estandar_competencia_curso" class="btn btn-sm btn-outline-info"
											data-id_estandar_competencia="<?=$ec_curso->id_estandar_competencia ?>"
											data-id_ec_curso="<?=$ec_curso->id_ec_curso?>" >
										<i class="fa fa-edit"></i> Modificar
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('curso_ec.eliminar')): ?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
											data-toggle="tooltip" title="Eliminar Curso"
											data-msg_confirmacion_general="¿Esta seguro de eliminar el curso?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>Curso/eliminar/<?=$ec_curso->id_ec_curso?>"
											data-btn_trigger="#btn_buscar_ec_curso">
										<i class="fas fa-trash"></i> Eliminar
									</button>
									<hr>
								<?php endif; ?>  					
							</div>
						</div>
					</div>
				</div> -->

				<div class="form-group row">
				
					<div class="col-lg-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Módulo 1</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<p class="card-text">Descripción módulo 1</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>

								<!-- Temario -->
								<div class="form-group row">
				
								<p class="card-text"><b>Temario</b></p>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 1</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 1</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 2</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 2</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 3</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 3</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>

								</div>


							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<div class="col-lg-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Módulo 2</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<p class="card-text">Descripción módulo 2</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>

								<!-- Temario -->
								<div class="form-group row">
				
								<p class="card-text"><b>Temario</b></p>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 1</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 1</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 2</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 2</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 3</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 3</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>

								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<div class="col-lg-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Módulo 3</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<p class="card-text">Descripción módulo 3</p>
								<p class="card-text"><b>Objetivo General:</b> Objetivo general de pruebas</p>
								<p class="card-text"><b>Objetivos especificos:</b> </p>
								<div class="form-group">
									<p class="card-text">Objetivo especifico 1</p>
									<p class="card-text">Objetivo especifico 2</p>
									<p class="card-text">Objetivo especifico 3</p>
								</div>

								<!-- Temario -->
								<div class="form-group row">
				
								<p class="card-text"><b>Temario</b></p>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 1</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 1</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 2</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 2</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>
									<div class="col-lg-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">Tema 3</h3>
												<div class="card-tools">
													<button type="button" class="btn btn-tool" data-card-widget="collapse">
														<i class="fas fa-minus"></i>
													</button>
												</div>
											</div>
											<!-- /.card-header -->
											<div class="card-body">
												<p class="card-text"><b>Instrucciones:</b> Instrucciones del tema 3</p>
												<p class="card-text"><b>Contenido:</b> </p>
												<div class="form-group">
													<p class="card-text">Contenido 1</p>
													<p class="card-text">Contenido 2</p>
													<p class="card-text">Contenido 3</p>
												</div>
											</div>
											<!-- /.card-body -->
										</div>
										<!-- /.card -->
									</div>

								</div>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>

				</div>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
				<a href="<?=base_url()?>Curso/registro/<?=$ec_curso->id_ec_curso?>"
						class="btn btn-sm btn-outline-primary">Registrarme</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
