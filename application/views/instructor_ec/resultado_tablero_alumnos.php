<?php if(isset($pagina_select) && $pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($alumnos_ec) && sizeof($alumnos_ec) != 0): ?>
	<?php foreach ($alumnos_ec as $index => $aec): ?>
		<tr>
			<td><?=$aec->id_usuario?></td>
			<td><?=$aec->nombre.' '.$aec->apellido_p.' '.$aec->apellido_m?></td>
			<td><?=$aec->curp?></td>
			<td>
				<ul>
					<li><label>Correo: </label><?=$aec->correo?></li>
					<li><label>Celular: </label><?=$aec->celular?></li>
					<li><label>Telefono: </label><?=$aec->telefono?></li>
				</ul>
			</td>
			<td>
				<?php if(perfil_permiso_operacion_menu('evaluacion.consultar')): ?>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-dark btn-sm"><i class="fa fa-question"></i> Cuestionarios</button>
						<button type="button" class="btn btn-outline-dark dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu" role="menu" style="">
							<a role="button" class="dropdown-item btn_evaluaciones_alumno" href="#"
							   data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							   data-id_usuario="<?=$aec->id_usuario?>"
							   data-es_evaluacion="si"
							   data-toggle="tooltip" title="Evaluacion(es) diagnoósticas del candidato">
								Evaluación diagnóstica
							</a>
							<a role="button" class="dropdown-item btn_encuesta_satisfaccion_lectura" data-toggle="tooltip" title="Ver encuesta de satisfacción"
							   data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							   data-id_usuario="<?=$aec->id_usuario?>" href="#">
								Encuesta de satisfacción
							</a>
						</div>
					</div>
					<button class="btn btn-sm btn-outline-warning btn_evaluaciones_alumno" data-toggle="tooltip"
							data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							data-id_usuario="<?=$aec->id_usuario?>" data-es_evaluacion="no"
							title="Cédula de evaluación"><i class="fa fa-check-circle"></i> Cédula de evaluación</button>
				<?php endif; ?>
				<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.consultar')): ?>
					<button class="btn btn-sm btn-outline-info btn_evidencia_ati_alumno" data-toggle="tooltip"
							data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							data-id_usuario="<?=$aec->id_usuario?>"
							title="Evidencia de trabajo por parte del candidato"><i class="fa fa-clipboard-list"></i> Evidencia de trabajo</button>
					<button class="btn btn-sm btn-outline-danger btn_cargar_expediente_alumno" data-toggle="tooltip"
							data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							data-id_usuario="<?=$aec->id_usuario?>"
							data-id_usuario_instructor="<?=$aec->id_usuario_evaluador?>"
							title="Carga del expediente del candidato"><i class="fa fa-upload"></i> Expediente digital</button>
					<button class="btn btn-sm btn-outline-success generar_portafolio_evidencia" data-toggle="tooltip"
							data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
							data-id_usuario_alumno="<?=$aec->id_usuario?>"
							data-id_usuario_instructor="<?=$aec->id_usuario_evaluador?>"
							title="Generación del Portafolio de evidencias"><i class="fa fa-file-alt"></i> Generar PED</button>
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
