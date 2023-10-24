<?php if(isset($ec_curso) && is_array($ec_curso) && !empty($ec_curso)): ?>
	<?php foreach($ec_curso as $index => $curso): ?>
		<?php if($curso->eliminado == 'no'): ?>
		<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
			<div class="card" style="width: 18rem;">
				<img src="<?=base_url().$curso->ruta_directorio.$curso->nombre?>" class="card-img-top img-convocatoria-publicada" alt="...">
				<div class="card-body">
					<h5 class="card-title"><b><?=$curso->nombre_curso?> </b></h5>
					<p class="card-text"><?=$curso->descripcion?> </p>
					<p class="card-text"><b>Publicado:</b> <?=$curso->publicado?> </p>
				</div>
				<div class="card-footer text-right">
					<?php if(perfil_permiso_operacion_menu('curso_ec.consultar')): ?>
						<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_curso_ec" data-id_ec_curso="<?=$curso->id_ec_curso?>">
							<i class="fa fa-eye"></i> Ver detalle
						</button>
					<?php endif; ?>
					<?php if(perfil_permiso_operacion_menu('curso_ec.cerrar_liberar')): ?>
						<?php if($curso->fecha_publicado == null): ?>
						<br><button type="button" class="btn btn-sm btn-outline-success mb-1 iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Publicar Curso"
								data-msg_confirmacion_general="¿Esta seguro de publicar el curso?; al hacerlo, no podra modificarla y esta acción no podrá revertirse"
								data-url_confirmacion_general="<?=base_url()?>Curso/publicar/<?=$curso->id_ec_curso?>/<?= $curso->id_estandar_competencia ?>"
								data-btn_trigger="#btn_buscar_ec_curso">
							<i class="fas fa-eye"></i> Publicar
						</button>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(perfil_permiso_operacion_menu('curso_ec.modificar')): ?>
						<button type="button" id="modificar_estandar_competencia_curso" class="btn btn-sm btn-outline-info"
								data-id_estandar_competencia="<?=$curso->id_estandar_competencia ?>"
								data-id_ec_curso="<?=$curso->id_ec_curso?>" >
							<i class="fa fa-edit"></i> Modificar
						</button>
					
						<a class="btn btn-sm btn-outline-primary contenidocursomodulo"
								data-toggle="tooltip" title="Contenido curso módulo"
								href="<?=base_url()?>campania/modulo/<?=$curso->id_ec_curso?>"><i class="fa fa-edit"></i>Contenido módulos </a>
					
					<?php endif; ?>
					<?php if(perfil_permiso_operacion_menu('curso_ec.eliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Eliminar Curso"
								data-msg_confirmacion_general="¿Esta seguro de eliminar el curso?, esta acción no podrá revertirse"
								data-url_confirmacion_general="<?=base_url()?>Curso/eliminar/<?=$curso->id_ec_curso?>"
								data-btn_trigger="#btn_buscar_ec_curso">
							<i class="fas fa-trash"></i> Eliminar
						</button>
						<hr>
					<?php endif; ?>  					
				</div>
			</div>
		</div>
		<?php else: ?>
			<?php if(perfil_permiso_operacion_menu('todos.todos')): ?>
				<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
				<div class="card" style="width: 18rem;">
					<div class="ribbon ribbon-wrapper">
						<div class="ribbon bg-danger">
							Eliminado
						</div>
					</div>
					<img src="<?=base_url().$curso->ruta_directorio.$curso->nombre?>" class="card-img-top img-convocatoria-publicada" alt="...">
					<div class="card-body">
						<h5 class="card-title"><?=$curso->nombre_curso?> </h5>
						<p class="card-text"><?=$curso->descripcion?> </p>
						<p class="card-text">Publicado: <?=$curso->publicado?> </p>
						<p class="card-text">Eliminado: <?=$curso->eliminado?> </p>
					</div>
					<div class="card-footer text-right">
					
						<?php if(perfil_permiso_operacion_menu('curso_ec.deseliminar')): ?>
							<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Curso"
									data-msg_confirmacion_general="¿Esta seguro de desea que el curso que esta eliminado, vuelva a estar funcional?"
									data-url_confirmacion_general="<?=base_url()?>Curso/deseliminar/<?=$curso->id_ec_curso?>"
									data-btn_trigger="#btn_buscar_ec_curso">
								<i class="fas fa-trash-restore"></i>
							</button>
						<?php endif; ?>
						
					</div>
				</div>
			<?php endif ?>
		</div>
		<?php endif ?>

	<?php endforeach; ?>
<?php else: ?>
	<div class="card card-solid" id="card_resultados_convocatoria_ec">
		<div class="card-body pb-0">
			<div class="form-group row">
				<div class="callout callout-warning col-md-12">
					<h5>Aviso IMPORTANTE</h5>
					<p>
						En este momento no contamos con cursos vigentes o se está cargando la información 
						de los cursos
					</p>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
