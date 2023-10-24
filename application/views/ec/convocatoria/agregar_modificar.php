<div class="modal fade" id="modal_form_convocatoria_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($estandar_competencia_convocatoria) && (isset($es_clonacion) && !$es_clonacion) ? 'Actualizar':'Nueva'?> Convocatoria del Estándar de Competencia</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_convocatoria">
				<input type="hidden" name="id_estandar_competencia_convocatoria" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->id_estandar_competencia_convocatoria : ''?>">
				<input type="hidden" name="id_estandar_competencia" value="<?=$id_estandar_competencia?>">
				<input type="hidden" name="publicada" value="no">
				<?php if(isset($id_usuario) && $id_usuario != ''): ?>
					<input type="hidden" name="id_usuario" value="<?=$id_usuario?>">
				<?php endif; ?>
				<div class="modal-body">
					<div class="form-group row"> 
						<div class="callout callout-warning col-md-12">
							La fecha de "Alineación Fin" se usará para limitar las convocatorias mostradas en el "inicio" o portal público de convocatorias del sistema
						</div>
					</div>
					<?php if(isset($es_clonacion) && $es_clonacion): ?>
						<div class="form-group row"> 
							<div class="callout callout-danger col-md-12">
								Se detectó que es una convocatoria que esta obteniendo información de una existente; para registrar completamente la nueva convocatoria, es necesario que revise los datos del siguiente formulario y de en el botón de guardar
							</div>
						</div>
					<?php endif; ?>
					<div class="form-group row">
						<div class="col-sm-12">
							<label for="input_titulo" class="col-form-label">Titulo</label>
							<input type="text" class="form-control" id="input_titulo" data-rule-required="true"
									name="titulo" placeholder="Titulo de la convocatoria EC" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->titulo : $estandar_competencia->codigo.' - '.$estandar_competencia->titulo?>">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3">
							<label for="input_programa_inicio" class="col-form-label">Programa inicio</label>
							<input type="date" class="form-control" id="input_programa_inicio" data-rule-required="true"
									name="programacion_inicio" placeholder="Fecha para programa inicio" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->programacion_inicio : ''?>">
						</div>
						<div class="col-sm-3">
							<label for="input_programa_fin" class="col-form-label">Programa fin</label>
							<input type="date" class="form-control" id="input_programa_fin" data-rule-required="true"
								   name="programacion_fin" placeholder="Fecha para programa fin" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->programacion_fin : ''?>">
						
						</div>
						<div class="col-sm-3">
							<label for="input_alineacion_inicio" class="col-form-label">Alineación inicio</label>
							<input type="date" class="form-control" id="input_alineacion_inicio" data-rule-required="true"
									name="alineacion_inicio" placeholder="Fecha para alineación inicio" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->alineacion_inicio : ''?>">
						</div>
						<div class="col-sm-3">
							<label for="input_alineacion_fin" class="col-form-label">Alineación fin</label>
							<input type="date" class="form-control" id="input_alineacion_fin" data-rule-required="true"
									name="alineacion_fin" placeholder="Fecha para alineación fin" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->alineacion_fin : ''?>">	
						</div>
					</div>
					
					<div class="form-group row">
						
						<div class="col-sm-3">
							<label for="input_evaluacion_inicio" class="col-form-label">Evaluación inicio</label>
							<input type="date" class="form-control" id="input_evaluacion_inicio" data-rule-required="true"
									name="evaluacion_inicio" placeholder="Fecha para Evaluación inicio" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->evaluacion_inicio : ''?>">
						</div>
						<div class="col-sm-3">
							<label for="input_evaluacion_fin" class="col-form-label">Evaluación fin</label>
							<input type="date" class="form-control" id="input_evaluacion_fin" data-rule-required="true"
									name="evaluacion_fin" placeholder="Fecha para Evaluación fin" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->evaluacion_fin : ''?>">
						</div>
						<div class="col-sm-3">
							<label for="input_certificado_inicio" class="col-form-label">Certificado inicio</label>
							<input type="date" class="form-control" id="input_certificado_inicio" data-rule-required="true"
									name="certificado_inicio" placeholder="Fecha para Certificado inicio" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->certificado_inicio : ''?>">
						</div>
						<div class="col-sm-3">
							<label for="input_certificado_fin" class="col-form-label">Certificado fin</label>
							<input type="date" class="form-control" id="input_certificado_fin" data-rule-required="true"
									name="certificado_fin" placeholder="Fecha para Certificado fin" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->certificado_fin : ''?>">							
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-6">
							<label for="input_textarea_proposito" class="col-form-label">Propósito</label>
							<textarea id="input_textarea_proposito" name="proposito" class="form-control" data-rule-required="true" ><?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->proposito : ''?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="input_textarea_descripcion" class="col-form-label">Descripción</label>
							<textarea id="input_textarea_descripcion" name="descripcion" class="form-control" data-rule-required="true" ><?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->descripcion : ''?></textarea>
						</div>
					</div>

					<div class="form-group row">						
						<div class="col-sm-6">
							<label for="input_cat_sector" class="col-form-label">Sector</label>
							<select id="input_cat_sector" name="id_cat_sector_ec" data-rule-required="true" class="custom-select form-control-border" >
								<option value="">-- Seleccione --</option>
								<?php if(isset($cat_sector_ec)): ?>
									<?php foreach ($cat_sector_ec as $cs): ?>
										<option value="<?=$cs->id_cat_sector_ec?>" <?=isset($estandar_competencia_convocatoria) && $estandar_competencia_convocatoria->id_cat_sector_ec == $cs->id_cat_sector_ec ? 'selected="selected"':''?> ><?=$cs->nombre?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						<div class="col-sm-6">
							<label for="input_textarea_sector_descripcion" class="col-form-label">Sector Descripción</label>
							<textarea id="input_textarea_sector_descripcion" name="sector_descripcion" class="form-control" data-rule-required="true" ><?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->sector_descripcion : ''?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-6">
							<label for="input_textarea_perfil" class="col-form-label">Perfil</label>
							<textarea id="input_textarea_perfil" name="perfil" class="form-control" data-rule-required="true" ><?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->perfil : ''?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="input_textarea_duracion_descripcion" class="col-form-label">Descripción duración de la convocatoria</label>
							<textarea id="input_textarea_duracion_descripcion" name="duracion_descripcion" class="form-control" data-rule-required="true" ><?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->duracion_descripcion : ''?></textarea>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-3">
							<label for="input_costo_alineacion" class="col-form-label">Costo Alineación</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<input id="input_costo_alineacion" type="number" data-rule-required="true" name="costo_alineacion" placeholder="Costo de la alienación del EC" class="form-control costo_convocatoria" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->costo_alineacion : ''?>">
							</div>
						</div>
						<div class="col-sm-3">
							<label for="input_costo_evaluacion" class="col-form-label">Costo Evaluación</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<input id="input_costo_evaluacion" data-rule-required="true" type="number" name="costo_evaluacion" placeholder="Costo de la Evaluación del EC" class="form-control costo_convocatoria" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->costo_alineacion : ''?>">
							</div>
						</div>
						<div class="col-sm-3">
							<label for="input_costo_certificado" class="col-form-label">Costo Certificado</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<input id="input_costo_certificado" data-rule-required="true" type="number" name="costo_certificado" placeholder="Costo de la Certificación del EC" class="form-control costo_convocatoria" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->costo_certificado : ''?>">
							</div>
						</div>
						<div class="col-sm-3">
							<label for="input_costo" class="col-form-label">Costo total</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">$</span>
								</div>
								<input id="input_costo" data-rule-required="true" type="number" name="costo" placeholder="Costo de la Certificación del EC" class="form-control" value="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->costo : ''?>">
							</div>
						</div>
					</div>

				</div><!-- end modal body -->
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ec_convocatoria"
							data-id_estandar_competencia_convocatoria="<?=isset($estandar_competencia_convocatoria) ? $estandar_competencia_convocatoria->id_estandar_competencia_convocatoria : ''?>"
							class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
