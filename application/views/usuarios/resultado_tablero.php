<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>" data-proceso_paginacion="<?=$sidebar?>">
<?php endif;?>
<?php if(isset($usuarios) && is_array($usuarios) && sizeof($usuarios) > 0):?>
	<?php foreach ($usuarios as $index => $u): ?>
		<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
			<div class="card bg-light d-flex flex-fill">
				<div class="card-header text-muted border-bottom-0">
					<?php
						switch ($u->perfil){
							case 'admin':
								echo 'Administrador del sistema';
								break;
							case 'instructor':
								echo 'Evaluador';
								break;
							case 'alumno':
								echo 'Alumno/Candidato';
								break;
							default:
								echo 'Usuario del sistema';
								break;
						}
					?>
				</div>
				<div class="card-body pt-0">
					<?php if($u->activo == 'no'): ?>
						<div class="ribbon ribbon-wrapper ribbon-lg">
							<div class="ribbon bg-warning">
								Desactivado
							</div>
						</div>
					<?php endif; ?>
					<?php if($u->eliminado == 'si'): ?>
						<div class="ribbon ribbon-wrapper ribbon-lg">
							<div class="ribbon bg-danger">
								Eliminado
							</div>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="col-7">
							<h2 class="lead"><b><?=$u->nombre.' '.$u->apellido_p.' '.$u->apellido_m?></b></h2>
							<?php if(isset($u->habilidades)): ?>
								<p class="text-muted text-sm"><b>Habilidades: </b> <?=$u->habilidades?> </p>
							<?php endif;?>
							<ul class="ml-4 mb-0 fa-ul text-muted">
								<li class="small"><span class="fa-li"><i class="fas fa-lg fa-user"></i></span>Usuario: <?=$u->usuario?></li>
								<?php if(isset($u->profesion)): ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-user-graduate"></i></span> Profesión: <?=$u->profesion?></li>
								<?php endif; ?>
								<?php if(isset($u->puesto)): ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-globe-americas"></i></span> Puesto: <?=$u->puesto?></li>
								<?php endif; ?>
								<?php if(isset($u->domicilio)): ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?=$u->domicilio?></li>
								<?php endif; ?>
								<li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span><?=$u->correo?></li>
								<?php if(isset($u->celular) && $u->celular != ''): ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-mobile"></i></span><?=$u->celular?></li>
								<?php endif; ?>
								<?php if(isset($u->telefono) && $u->telefono != ''): ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><?=$u->telefono?></li>
								<?php endif; ?>
							</ul>
						</div>
						<div class="col-5 text-center">
							<img src="<?=isset($u->foto_perfil) ? $u->foto_perfil : base_url().'assets/imgs/iconos/admin.png' ?>" alt="<?=$u->nombre.' '.$u->apellido_p?>" class="img-circle img-fluid">
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="text-right">
						<?php if($u->eliminado == 'no'): ?>
							<?php if($u->activo == 'si'): ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.eliminar')):?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar Usuario"
											data-msg_confirmacion_general="¿Esta seguro de eliminar el usuario?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>Usuario/eliminar_usuario/<?=$u->id_usuario?>"
											data-btn_trigger="#btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>">
										<i class="fas fa-trash"></i>
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.update_pass')):?>
									<button type="button" class="btn btn-sm btn-outline-dark modificar_password_usuario"
											data-id_usuario="<?=$u->id_usuario?>"
											data-toggle="tooltip" title="Cambiar contraseña">
										<i class="fas fa-key"></i>
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.desactivar')):?>
									<button type="button" class="btn btn-sm btn-outline-warning iniciar_confirmacion_operacion" data-toggle="tooltip" title="Desactivar usuario"
											data-msg_confirmacion_general="¿Esta seguro de desactivar el usuario?"
											data-url_confirmacion_general="<?=base_url()?>Usuario/desactivar_usuario/<?=$u->id_usuario?>"
											data-btn_trigger="#btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>">
										<i class="fas fa-window-close"></i>
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.modificar')):?>
									<button type="button" class="btn btn-sm btn-outline-primary modificar_usuario" data-toggle="tooltip" title="Editar usuario"
											data-id_usuario="<?=$u->id_usuario?>" data-tipo_usuario="<?=$u->perfil == 'alumno' ? 'candidato' : $u->perfil?>">
										<i class="fas fa-edit"></i>
									</button>
									<?php if($u->perfil == 'alumno'): ?>
										<a href="<?=base_url()?>Perfil/editar/<?=$u->id_usuario?>" class="btn btn-sm btn-outline-dark"><i class="fas fa-edit"></i> Perfil</a>
									<?php endif; ?>
								<?php endif; ?>
							<?php else: ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.eliminar')):?>
									<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar Usuario"
											data-msg_confirmacion_general="¿Esta seguro de eliminar el usuario?, esta acción no podrá revertirse"
											data-url_confirmacion_general="<?=base_url()?>Usuario/eliminar_usuario/<?=$u->id_usuario?>"
											data-btn_trigger="#btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>">
										<i class="fas fa-trash"></i>
									</button>
								<?php endif; ?>
								<?php if(perfil_permiso_operacion_menu('usuarios.activar')):?>
									<button type="button" class="btn btn-sm btn-outline-success iniciar_confirmacion_operacion" data-toggle="tooltip" title="Activar usuario"
											data-msg_confirmacion_general="¿Esta seguro de activar el usuario?"
											data-url_confirmacion_general="<?=base_url()?>Usuario/activar_usuario/<?=$u->id_usuario?>"
											data-btn_trigger="#btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>">
										<i class="fas fa-check"></i>
									</button>
								<?php endif; ?>
							<?php endif; ?>
						<?php else: ?>
							<?php if(perfil_permiso_operacion_menu('usuarios.deseliminar')):?>
								<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Usuario"
										data-msg_confirmacion_general="¿Esta seguro de desea que el usuario que esta eliminado, vuelva a estar funcional?"
										data-url_confirmacion_general="<?=base_url()?>Usuario/deseliminar_usuario/<?=$u->id_usuario?>"
										data-btn_trigger="#btn_buscar_<?=isset($sidebar) ? $sidebar : ''?>">
									<i class="fas fa-trash-restore"></i>
								</button>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif;?>
