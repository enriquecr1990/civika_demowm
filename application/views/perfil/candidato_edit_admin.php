<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">

				<?php $this->load->view('perfil/edicion_admin'); ?>

				<div class="col-md-9">
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<li class="nav-item"><a class="nav-link active mi_perfil_mi_informacion" href="#mi_informacion" data-toggle="tab">Mi información</a></li>
								<li class="nav-item"><a class="nav-link" id="tab_direcciones" data-id_usuario="<?=$datos_usuario_modificar->id_usuario?>" href="#content_tab_mi_direccion" data-toggle="tab">Direcciones</a></li>
								<li class="nav-item"><a class="nav-link" data-id_usuario="<?=$datos_usuario_modificar->id_usuario?>" id="tab_datos_empresa" href="#content_tab_datos_empresa" data-toggle="tab">Datos de empresa</a></li>
								<!--<li class="nav-item"><a class="nav-link" href="#seguridad" data-toggle="tab">Seguridad</a></li>-->
								<li class="nav-item"><a class="nav-link" id="tab_curriculum" data-id_usuario="<?=$datos_usuario_modificar->id_usuario?>" href="#curriculum" data-toggle="tab">Experiencia curricular</a></li>
								<li class="nav-item"><a class="nav-link" id="tab_expediente_digital" data-id_usuario="<?=$datos_usuario_modificar->id_usuario?>" href="#content_tab_expediente_digital" data-toggle="tab">Expediente digital</a></li>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">

								<div class="active tab-pane" id="mi_informacion">
									<div class="form-group row">
										<label class="col-sm-3">Usuario del sistema</label>
										<span class="col-sm-9"><?=isset($usuario_modificar) ? $usuario_modificar->usuario : $usuario->usuario?></span>
									</div>
									<?php if(isset($datos_usuario_modificar)):?>
										<div class="form-group row">
											<label class="col-sm-3">Nombre</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->nombre ?> <?=$datos_usuario_modificar->apellido_p?> <?=$datos_usuario_modificar->apellido_m?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">CURP</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->curp ?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Genero</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->genero == 'm' ? 'Masculino' : 'Femenino'?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Cumpleaños</label>
											<span class="col-sm-9"><?=isset($datos_usuario_modificar->fecha_nacimiento) && ($datos_usuario_modificar->fecha_nacimiento != '' || $datos_usuario_modificar->fecha_nacimiento != '0000-00-00') ? fecha_castellano_sin_anio($datos_usuario_modificar->fecha_nacimiento) : 'Sin dato'?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Lugar de nacimiento</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->lugar_nacimiento?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Nacionalidad:</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->nacionalidad?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Número de celular:</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->celular?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Número de casa:</label>
											<span class="col-sm-9"><?=$datos_usuario_modificar->telefono?></span>
										</div>

										<div class="form-group row">
											<label class="col-sm-3">Sector productivo de trabajo:</label>
											<span class="col-sm-9"><?=isset($datos_usuario_modificar->sector_productivo) ? $datos_usuario_modificar->sector_productivo : 'Sin datos'?></span>
										</div>

										<div class="form-group row">
											<div class="col-sm-12 text-right">
												<button type="button" id="modificar_usuario_candidato"
														data-is_admin="si"
														data-id_usuario="<?=isset($datos_usuario_modificar) ? $datos_usuario_modificar->id_usuario : $usuario->id_usuario ?>"
														class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i> Modificar</button>
											</div>
										</div>
									<?php endif; ?>


								</div>

								<div class="tab-pane" id="content_tab_mi_direccion"></div>

								<div class="tab-pane" id="content_tab_datos_empresa"></div>

								<div class="tab-pane" id="seguridad">
									<form id="actualizar_password_perfil">
										<div class="form-group row">
											<label for="input_password_anterior" class="col-sm-2 col-form-label">Contraseña anterior</label>
											<div class="col-sm-4">
												<input type="password" class="form-control" id="input_password_anterior" data-rule-required="true"
													   name="password_anterior" placeholder="Contraseña anterior">
											</div>
											<div class="col-sm-1">
												<button type="button" data-toggle="tooltip" data-placement="right" title="Ver contraseña"
														class="btn btn-default btn-sm ver_password no_password"
														data-id_password="#input_password_anterior"><i class="fas fa-eye"></i></button>
											</div>
										</div>

										<div class="form-group row">
											<label for="input_password_nueva" class="col-sm-2 col-form-label">Contraseña nueva</label>
											<div class="col-sm-4">
												<input type="password" class="form-control" id="input_password_nueva" data-rule-required="true"
													   name="password_nueva" placeholder="Contraseña anterior">
											</div>
											<div class="col-sm-1">
												<button type="button" data-toggle="tooltip" data-placement="right" title="Ver contraseña"
														class="btn btn-default btn-sm ver_password no_password"
														data-id_password="#input_password_nueva"><i class="fas fa-eye"></i></button>
											</div>
										</div>

										<div class="form-group row">
											<label for="input_password_repetir" class="col-sm-2 col-form-label">Repetir Contraseña</label>
											<div class="col-sm-4">
												<input type="password" class="form-control" id="input_password_repetir" data-rule-required="true"
													   name="password_repetir" placeholder="Contraseña anterior">
											</div>
											<div class="col-sm-1">
												<button type="button" data-toggle="tooltip" data-placement="right" title="Ver contraseña"
														class="btn btn-default btn-sm ver_password no_password"
														data-id_password="#input_password_repetir"><i class="fas fa-eye"></i></button>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-7 text-right">
												<button type="button" id="btn_actualizar_password_perfil" data-id_usuario="<?=$datos_usuario_modificar->id_usuario?>"
														class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i> Actualizar</button>
											</div>
										</div>
									</form>
								</div>

								<div class="tab-pane" id="curriculum"></div>

								<div class="tab-pane" id="content_tab_expediente_digital"></div>

							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
