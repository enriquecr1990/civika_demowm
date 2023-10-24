<hr>
<div class="form-group row">
	<label class="col-form-label">Preguntas</label>
</div>
<?php if(isset($preguntas_abiertas) && is_array($preguntas_abiertas) && sizeof($preguntas_abiertas) != 0): ?>
<div class="col-12">
	<div class="card">
		<div class="card-body table-responsive p-0">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Pregunta</th>
						<th class="columna_operaciones_preguntas_eva">Operaciones</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach ($preguntas_abiertas as $index => $pa): ?>
						<?php if($pa->eliminado == 'no'): ?>
						<tr>
							<td><?=$index + 1?></td>
							<td><?=$pa->pregunta_formulario_abierto?></td>
							<td class="columna_operaciones_preguntas_eva">
								
									<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.modificar')): ?>
										<button class="btn btn-sm btn-outline-primary modificar_pregunta_abierta" data-toggle="tooltip" title="Modificar pregunta"
												data-id_formulario="<?=$pa->id_formulario_abierto?>" data-id_cat_pregunta_formulario_abierto="<?=$pa->id_cat_pregunta_formulario_abierto?>">
											<i class="fa fa-edit"></i>
										</button>
									<?php endif; ?>
									<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.eliminar')): ?>
										<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar pregunta evaluación"
												data-msg_confirmacion_general="¿Esta seguro de eliminar la pregunta abierta?, esta acción no podrá revertirse"
												data-url_confirmacion_general="<?=base_url()?>PreguntasAbiertas/eliminar_pregunta_abierta/<?=$pa->id_cat_pregunta_formulario_abierto?>"
												data-btn_trigger="#btn_buscar_preguntas_abiertas">
											<i class="fas fa-trash"></i>
										</button>
									<?php endif; ?>
							</td>
						</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
