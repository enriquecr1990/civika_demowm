<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($estandar_competencia) && sizeof($estandar_competencia) != 0): ?>
	<?php foreach ($estandar_competencia as $index => $ec): ?>
		<tr class="<?=$ec->eliminado =='si' ? 'text-danger':''?>">
			<td><?=$ec->id_estandar_competencia?></td>
			<td><?=$ec->codigo?></td>
			<td><?=$ec->titulo?></td>
			<td>
				<?php if(isset($ec->id_archivo) && !is_null($ec->id_archivo) && $ec->id_archivo != ''): ?>
					<img src="<?=base_url().$ec->ruta_directorio.$ec->nombre?>" style="max-width: 120px" alt="Imágen Banner EC" class="img-fluid img-thumbnail">
				<?php else: ?>
					<span class="badge badge-info">Sin banner registrado</span>
				<?php endif; ?>
			</td>
			<td>
				<?php if($ec->eliminado =='no'): ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.modificar')): ?>
						<button type="button" data-id_estandar_competencia="<?=$ec->id_estandar_competencia?>"
								data-toggle="tooltip" title="Modificar estandar"
								class="btn btn-sm btn-outline-primary modificar_estandar_competencia"><i class="fa fa-edit"></i> Editar</button>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.eliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Eliminar Estándar"
								data-msg_confirmacion_general="¿Esta seguro de eliminar el estándar de competencia?, esta acción no podrá revertirse"
								data-url_confirmacion_general="<?=base_url()?>EC/eliminar/<?=$ec->id_estandar_competencia?>"
								data-btn_trigger="#btn_buscar_estandar_competencia">
							<i class="fas fa-trash"></i> Eliminar
						</button>
						<hr>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.modificar')): ?>
						<a class="btn btn-sm btn-outline-primary contenidocurso"
								data-toggle="tooltip" title="Contenido curso"
								href="<?=base_url()?>campania/<?=$ec->id_estandar_competencia?>"><i class="fa fa-edit"></i>Contenido curso </a>
					<?php endif; ?>


					<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.consultar')): ?>
						<div class="btn-group">
							<button type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-clipboard-list"></i> Planes del EC</button>
							<button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu" role="menu" style="">
								<a class="dropdown-item" data-toggle="tooltip"
								   title="Plan de evaluación"
								   href="<?=base_url()?>tecnicas_instrumentos/<?=$ec->id_estandar_competencia?>">Plan de evaluación</a>
								<a class="dropdown-item" data-toggle="tooltip"
								   title="Evidencias esperadas"
								   href="<?=base_url()?>evidencias_esperadas/<?=$ec->id_estandar_competencia?>">Evidencias esperadas</a>
								<a class="dropdown-item lnk_agregar_modificacion_plan_requerimientos" data-id_estandar_competencia="<?=$ec->id_estandar_competencia?>"
								   data-toggle="tooltip" title="Plan de requerimientos" role="button">
									Plan de requerimientos
								</a>
							</div>
						</div>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('evaluacion.consultar')): ?>
						<a class="btn btn-sm btn-outline-dark" data-toggle="tooltip"
						   title="Evaluación al Estándar de competencia"
						   href="<?=base_url()?>evaluacion_cerrada/<?=EVALUACION_DIAGNOSTICA.'/'.$ec->id_estandar_competencia?>"><i class="fa fa-file-alt"></i> Evaluación diagnóstica</a>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')): ?>
						<a class="btn btn-sm btn-outline-secondary" data-toggle="tooltip"
						   title="Evaluación al Estándar de competencia"
						   href="<?=base_url()?>estandar_competencia/convocatoria/<?=$ec->id_estandar_competencia?>"><i class="fa fa-file-alt"></i> Convocatoria</a>
						<hr>
					<?php endif; ?>

					<?php if(perfil_permiso_operacion_menu('estandar_competencia.instructor')): ?>
						<hr>
						<button class="btn btn-sm btn-outline-warning btn_instructor_evaluador" data-toggle="tooltip"
								data-id_estandar_competencia="<?=$ec->id_estandar_competencia?>"
								title="Ver y/o asignar evaluador"><i class="fa fa-user-tie"></i> Evaluadores</button>
					<?php endif; ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.alumno')): ?>
						<?php if(isset($usuario) && $usuario->perfil == 'instructor'): ?>
							<a href="<?=base_url()?>EvaluadoresEC/alumnos/<?=$ec->id_estandar_competencia?>"
							   class="btn btn-sm btn-outline-success" data-toggle="tooltip"
							   title="Ver alumnos asignados"><i class="fa fa-user-graduate"></i> Candidatos</a>
						<?php else: ?>
							<div class="btn-group"> 
								<button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-user-graduate"></i> Candidatos</button>
								<button type="button" class="btn btn-outline-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu" style="">
									<a class="dropdown-item btn_alumnos_ec" role="button" data-id_estandar_competencia="<?=$ec->id_estandar_competencia?>">
										Asignación
									</a>
									<a class="dropdown-item" href="<?=base_url()?>EvaluadoresEC/alumnos/<?=$ec->id_estandar_competencia?>">Tablero</a>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php else: ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.deseliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Estándar"
								data-msg_confirmacion_general="¿Esta seguro de desea que el estándar de competencia que esta eliminado, vuelva a estar funcional?"
								data-url_confirmacion_general="<?=base_url()?>EC/deseliminar/<?=$ec->id_estandar_competencia?>"
								data-btn_trigger="#btn_buscar_estandar_competencia">
							<i class="fas fa-trash-restore"></i>
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="5" class="text-center">
			Sin registros encontrados
		</td>
	</tr>
<?php endif; ?>
