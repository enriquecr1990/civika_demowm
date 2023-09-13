<div class="modal fade" id="modal_form_domicilio" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($datos_domicilio) ? 'Actualizar':'Nuevo'?> domicilio</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_domicilio">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_calle" class="col-sm-3 col-form-label">Calle</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_calle" data-rule-required="true"
								   name="calle" placeholder="Nombre de la calle" value="<?=isset($datos_domicilio) ? $datos_domicilio->calle : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_numero_ext" class="col-sm-3 col-form-label">Número</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_numero_ext" data-rule-required="true" data-rule-number="true" name="numero_ext" placeholder="Número exterior" value="<?=isset($datos_domicilio) ? $datos_domicilio->numero_ext : ''?>">
							<small class="form-text text-muted">Número exterior</small>
						</div>
						<label for="input_numero_ext" class="col-sm-3 col-form-label">Número interior</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_numero_int" name="numero_int" placeholder="interior" value="<?=isset($datos_domicilio) ? $datos_domicilio->numero_int : ''?>">
							<small class="form-text text-muted">Número interior</small>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_cp" class="col-sm-3 col-form-label">C.P.:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="input_cp" data-rule-required="true" data-rule-number="true"
								   name="codigo_postal" placeholder="Código postal" value="<?=isset($datos_domicilio) ? $datos_domicilio->codigo_postal : ''?>">
						</div>
						<label for="input_cp" class="col-sm-3 col-form-label">¿Domicilio principal?</label>
						<div class="col-sm-3">
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" data-rule-required="true" id="input_predeterminado_si" name="predeterminado"
									   value="si" <?=isset($datos_domicilio) && $datos_domicilio->predeterminado == 'si' ? 'checked="checked"':''?>>
								<label for="input_predeterminado_si" class="custom-control-label">Si</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" id="input_predeterminado_no" name="predeterminado" value="no" <?=isset($datos_domicilio) && $datos_domicilio->predeterminado == 'no' ? 'checked="checked"':''?>>
								<label for="input_predeterminado_no" class="custom-control-label">No</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="select_cat_estado" class="col-sm-3 col-form-label" >Estado:</label>
						<div class="col-sm-9">
							<select id="select_cat_estado" class="custom-select form-control-border slt_cat_estado"
									name="id_cat_estado" data-id_slt_municipios="#select_cat_municipio" required>
								<option value="">--Seleccione--</option>
								<?php foreach ($cat_estado as $e): ?>
									<option value="<?=$e->id_cat_estado?>" <?=isset($datos_domicilio) && $datos_domicilio->id_cat_estado == $e->id_cat_estado ? 'selected="selected"':''?>><?=$e->nombre?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="select_cat_municipio" class="col-sm-3 col-form-label" >Municipio:</label>
						<div class="col-sm-9">
							<select id="select_cat_municipio" data-id_slt_localidades="#select_cat_localidades" class="custom-select form-control-border slt_cat_municipio"
									name="id_cat_municipio" required <?=isset($datos_domicilio) ? '':'disabled="disabled"'?> >
								<?php if(isset($cat_municipio) && is_array($cat_municipio) && sizeof($cat_municipio) != 0):?>
									<?php foreach ($cat_municipio as $cm): ?>
										<option value="<?=$cm->id_cat_municipio?>" <?=isset($datos_domicilio) && $datos_domicilio->id_cat_municipio == $cm->id_cat_municipio ? 'selected="selected"': ''?>><?=$cm->nombre?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<option value="">--Seleccione estado--</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="select_cat_localidades" class="col-sm-3 col-form-label">Localidad:</label>
						<div class="col-sm-9">
							<select id="select_cat_localidades" class="custom-select form-control-border"
									name="id_cat_localidad" required <?=isset($datos_domicilio) ? '':'disabled="disabled"'?>>
								<?php if(isset($cat_localidad) && is_array($cat_localidad) && sizeof($cat_localidad) != 0):?>
									<?php foreach ($cat_localidad as $cl): ?>
										<option value="<?=$cl->id_cat_localidad?>" <?=isset($datos_domicilio) && $datos_domicilio->id_cat_localidad == $cl->id_cat_localidad ? 'selected="selected"': ''?>><?=$cl->nombre?></option>
									<?php endforeach; ?>
								<?php else: ?>
									<option value="">--Seleccione municipio--</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_domicilio" data-id_usuario="<?=$id_usuario?>"
							data-id_datos_domicilio="<?=isset($datos_domicilio) ? $datos_domicilio->id_datos_domicilio : ''?>" class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
