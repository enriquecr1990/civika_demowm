<div class="col-lg-12 col-md-12">
	<div class="card">
		<div class="card-body table-responsive p-0">
			<table class="table table-striped">
				<thead>
				<tr>
					<th>ID</th>
					<th>Inicio</th>
					<th>Fin</th>
					<th>Calificación</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					<?php if(isset($evaluaciones_realizadas) && is_array($evaluaciones_realizadas) && sizeof($evaluaciones_realizadas) != 0): ?>
						<?php foreach ($evaluaciones_realizadas as $index_er => $er): ?>
							<tr class="evaluaciones_candidato">
								<td><?=$index_er+1?></td>
								<td><?=fechaHoraBDToHTML($er->fecha_iniciada)?></td>
								<td><?=fechaHoraBDToHTML($er->fecha_enviada)?></td>
								<td>Calificacion: <span class="span_calificacion_evidencia" data-calificacion="<?=$er->calificacion?>"><?=$er->calificacion?></span></td>
								<td>
									<button data-id_usuario_has_evaluacion_realizada="<?=$er->id_usuario_has_evaluacion_realizada?>"
											class="btn btn-success btn-sm ver_evaluacion_respuestas_candidato">
										<i class="fa fa-clipboard-list"></i>Ver evaluación
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr class="evaluaciones_candidato" >
							<td colspan="6">Sin evaluaciones realizadas</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
