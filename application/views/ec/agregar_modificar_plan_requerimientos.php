<div class="modal fade" id="modal_form_ec_plan_requerimientos" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Plan de requerimientos del Estándar de competencia.</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_plan_requerimientos">
				<div class="modal-body">

					<div class="card-body table-responsive p-0" id="table_otras_actividades">
						<table class="table table-head-fixed text-nowrap">
							<thead>
							<tr>
								<th style="max-width: 20%">Cantidad</th>
								<th>Descripción del requerimiento</th>
								<th class="text-center">
									<button type="button" class="btn btn-sm btn-outline-success agregar_row_comun"
											data-origen="#new_row_requerimiento" data-destino="#tbody_destino_plan_requerimientos"
											title="Nueva plan de requerimientos"><i class="fa fa-plus-square"></i> Nuevo </button>
								</th>
							</tr>
							</thead>
							<tbody id="tbody_destino_plan_requerimientos" class="tbody_scroll">
								<?php if(isset($estandar_competencia_has_requerimientos) && is_array($estandar_competencia_has_requerimientos)): ?>
									<?php foreach ($estandar_competencia_has_requerimientos as $index => $echr): ?>
										<tr>
											<td style="max-width: 20%">
												<input id="cantidad_<?=$index?>" placeholder="Cantidad" data-rule-required="true" data-rule-number="true"
													   type="text" class="form-control" name="requerimientos[<?=$index?>][cantidad]" value="<?=$echr->cantidad?>">
											</td>
											<td>
													<textarea id="descripcion_<?=$index?>" placeholder="Descripción del requerimiento" data-rule-required="true"
															  type="text" class="form-control" name="requerimientos[<?=$index?>][descripcion]"><?=$echr->descripcion?></textarea>
											</td>
											<td class="text-center">
												<button type="button" class="btn btn-sm btn-outline-danger eliminar_registro_comun" data-toggle="tooltip" title="Eliminar requerimiento"><i class="fa fa-trash"></i></button>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
							<tfoot>
							<tr>
								<th>Cantidad</th>
								<th>Descripción del requerimiento</th>
								<th class="text-center">
									<button type="button" class="btn btn-sm btn-outline-success agregar_row_comun"
											data-origen="#new_row_requerimiento" data-destino="#tbody_destino_plan_requerimientos"
											title="Nueva plan de requerimientos"><i class="fa fa-plus-square"></i> Nuevo </button>
								</th>
							</tr>
							</tfoot>
						</table>
					</div>

					<div id="new_row_requerimiento" style="display: none">
						<!--
						<tr>
							<td style="max-width: 20%">
								<input id="cantidad_{id}" placeholder="Cantidad" data-rule-required="true" data-rule-number="true"
									   type="text" class="form-control" name="requerimientos[{id}][cantidad]" required>
							</td>
							<td>
								<textarea id="descripcion_{id}" placeholder="Descripción del requerimiento" data-rule-required="true"
										  type="text" class="form-control" name="requerimientos[{id}][descripcion]"></textarea>
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-sm btn-outline-danger eliminar_registro_comun" data-toggle="tooltip" title="Eliminar requerimiento"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
						-->
					</div>

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_plan_requerimientos" data-id_estandar_competencia="<?=$id_estandar_competencia?>" class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
