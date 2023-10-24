<?php if($pagina_select == 1): ?>
	<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
<?php endif; ?>
<?php if(isset($estandar_competencia_convocatoria) && sizeof($estandar_competencia_convocatoria) != 0): ?>
	<?php foreach ($estandar_competencia_convocatoria as $index => $echc): ?>
		<tr>
			<td><?=$index + 1?></td>
			<td>
				<?=$echc->titulo?>
				<?php if(isset($echc->id_usuario) && !is_null($echc->id_usuario)): ?>
					<br><span class="badge badge-info">Registro por instructor</span>
					<br><span class="badge badge-info"><?=$echc->usuario_registra_convocatoria?></span>
				<?php endif; ?>
			</td>
			<td>
				<label>Programa: </label><?=fechaBDToHtml($echc->programacion_inicio)?> al <?=fechaBDToHtml($echc->programacion_fin)?><br>
				<label>Alineación: </label><?=fechaBDToHtml($echc->alineacion_inicio)?> al <?=fechaBDToHtml($echc->alineacion_fin)?><br>
				<label>Evaluación: </label><?=fechaBDToHtml($echc->evaluacion_inicio)?> al <?=fechaBDToHtml($echc->evaluacion_fin)?><br>
				<label>Certificado: </label><?=fechaBDToHtml($echc->certificado_inicio)?> al <?=fechaBDToHtml($echc->certificado_fin)?><br>
				<br>
				<label>Costo alineación: </label>$<?=$echc->costo_alineacion?><br>
				<label>Costo evaluación: </label>$<?=$echc->costo_evaluacion?><br>
				<label>Costo certificado: </label>$<?=$echc->costo_certificado?><br>
				<label>Costo certificado: </label>$<?=$echc->costo?>
			</td>
			<td>
				<label>Proposito: </label> <?=$echc->proposito != '' ? $echc->proposito :'Sin información'?><br>
				<label>Descripción: </label> <?=$echc->descripcion != '' ? $echc->descripcion : 'Sin información'?>
				<label>Sector descripción: </label> <?=$echc->sector_descripcion != '' ? $echc->sector_descripcion : 'Sin información'?>
				<!--<label>Perfil: </label><?=$echc->perfil?>
				<label>Duración: </label><?=$echc->duracion_descripcion?> -->
			</td>
			<td>
				<?php if($echc->convocatoria_vigente): ?>
					<span class="badge badge-success">Vigente</span>
				<?php else: ?>
					<span class="badge badge-danger">Vencida</span>
				<?php endif; ?>
			</td>
			<td>
				<?php if($echc->eliminado =='no'): ?>
					<?php if($echc->convocatoria_vigente && $echc->publicada == 'no'): ?>
						<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')): ?>
							<button type="button" data-id_estandar_competencia="<?=$echc->id_estandar_competencia?>"
									data-id_estandar_competencia_convocatoria="<?=$echc->id_estandar_competencia_convocatoria?>"
									data-toggle="tooltip" title="Modificar Convocatoria"
									class="btn btn-sm btn-outline-primary mb-1 modificar_convocatoria_ec"><i class="fa fa-edit"></i> Editar</button>
						<?php endif; ?>

						<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')): ?>
							<br><button type="button" class="btn btn-sm btn-outline-danger mb-1 iniciar_confirmacion_operacion"
									data-toggle="tooltip" title="Eliminar Convocatoria"
									data-msg_confirmacion_general="¿Esta seguro de eliminar la convocatoria del estándar de competencia?, esta acción no podrá revertirse"
									data-url_confirmacion_general="<?=base_url()?>ConvocatoriasEC/eliminar/<?=$echc->id_estandar_competencia_convocatoria?>"
									data-btn_trigger="#btn_buscar_convocatoria_ec">
								<i class="fas fa-trash"></i> Eliminar
							</button>
						<?php endif; ?>

						<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')): ?>
							<br><button type="button" class="btn btn-sm btn-outline-success mb-1 iniciar_confirmacion_operacion"
									data-toggle="tooltip" title="Publicar Convocatoria"
									data-msg_confirmacion_general="¿Esta seguro de publicar la convocatoria del estándar de competencia?; al hacerlo, no podra modificarla y esta acción no podrá revertirse"
									data-url_confirmacion_general="<?=base_url()?>ConvocatoriasEC/publicar/<?=$echc->id_estandar_competencia_convocatoria?>"
									data-btn_trigger="#btn_buscar_convocatoria_ec">
								<i class="fas fa-eye"></i> Publicar
							</button>
						<?php endif; ?>
					<?php else: ?>
						<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')): ?>
							<button type="button" data-id_estandar_competencia_convocatoria="<?=$echc->id_estandar_competencia_convocatoria?>"
									data-toggle="tooltip" title="Modificar estandar"
									class="btn btn-sm btn-outline-dark clonar_convocatoria_ec"><i class="fa fa-edit"></i> Clonar convocatoria</button>
						<?php endif; ?>
					<?php endif; ?>
					
				<?php else: ?>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.deseliminar')): ?>
						<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Deseliminar Convocatoria del estandar"
								data-msg_confirmacion_general="¿Esta seguro de desea que la convocaatoria del estándar de competencia que esta eliminado, vuelva a estar funcional?"
								data-url_confirmacion_general="<?=base_url()?>ConvocatoriasEC/deseliminar/<?=$echc->id_estandar_competencia_convocatoria?>"
								data-btn_trigger="#btn_buscar_convocatoria_ec">
							<i class="fas fa-trash-restore"></i>
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="6" class="text-center">
			Sin registros encontrados
		</td>
	</tr>
<?php endif; ?>
