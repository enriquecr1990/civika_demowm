<div class="modal fade" id="modal_form_instrumento" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($ec_instrumento_has_actividad) ? 'Modificar  intrumento de evaluación' : 'Agregar  intrumento de evaluación' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
					<form id="form_agregar_modificar_ec_ati">

						<input type="hidden" name="id_ec_instrumento_has_actividad"
							   value="<?= isset($id_ec_instrumento_has_actividad) ? $id_ec_instrumento_has_actividad : '' ?>">
						<div class="modal-body">
							<div class="form-group row">
								<label for="cat_instrumento" class="col-sm-3 col-form-label">Instrumento</label>
								<div class="col-sm-9">
									<select id="cat_instrumento"
											class="custom-select form-control-border slt_mostrar_ocultar"
										<?= isset($estandar_competencia_instrumento) ? 'disabled="disabled"' : '' ?>
											data-id_estandar_competencia="<?= isset($id_estandar_competencia) ? $id_estandar_competencia : '' ?>"
											data-contenedor_detalle="#descripcion_otro_instrumento"
											data-input_detalle="#det_cat_instrumento" data-id_show="99999"
											name="id_cat_instrumento" required>
										<option value="">-- Seleccione --</option>
										<?php if (isset($cat_instrumento)): ?>
											<?php foreach ($cat_instrumento as $ct): ?>
												<option
													value="<?= $ct->id_cat_instrumento ?>" <?= isset($estandar_competencia_instrumento) && $estandar_competencia_instrumento->id_cat_instrumento == $ct->id_cat_instrumento ? 'selected="selected"' : '' ?> ><?= $ct->nombre ?></option>
											<?php endforeach; ?>
										<?php endif; ?>
										<!--<option value="99999">Otro</option>-->
									</select>
									<?php if (isset($estandar_competencia_instrumento)): ?>
										<input type="hidden" name="id_cat_instrumento"
											   value="<?= $estandar_competencia_instrumento->id_cat_instrumento ?>">
									<?php endif; ?>
								</div>
							</div>
							<!--<div class="form-group row" id="descripcion_otro_instrumento" style="display: none">
								<label for="det_cat_instrumento" class="col-sm-3 col-form-label" >Descripción</label>
								<div class="col-sm-9">
									<input id="det_cat_instrumento" type="text" placeholder="Describa el instrumento de evaluación"
										   class="form-control" name="instrumento_actividad[actividad]" data-rule-required="true">
								</div>
							</div>-->
							<div id="msg_form_ec_ati"></div>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Actividad:</label>
								<input type="text" data-rule-required="true" class="form-control col-sm-9"
									   placeholder="Describa la actividad"
									   name="instrumento_actividad[actividad]"
									   value="<?= isset($ec_instrumento_has_actividad) ? $ec_instrumento_has_actividad->actividad : '' ?>">
							</div>
							<!--				<div class="form-group row">-->
							<!--					<label class="col-sm-3 col-form-label">Instrucciones:</label>-->
							<!--					<div class="col-sm-9">-->
							<!--						<textarea id="txt_instrucciones" type="text" data-rule-required="true" class="form-control "-->
							<!--								  name="instrumento_actividad[instrucciones]"-->
							<!--								  placeholder="Describa la actividad">-->
							<?php //=isset($ec_instrumento_has_actividad) ? $ec_instrumento_has_actividad->instrucciones : '' ?><!--</textarea>-->
							<!--					</div>-->
							<!--				</div>-->
							<!--				<div class="form-group row">-->
							<!--					<label class="col-sm-3 col-form-label">-->
							<!--						Archivos (PDF/Imágenes/URL de video)-->
							<!--						<small class="form-text text-muted">Suba un archivo por vez</small>-->
							<!--					</label>-->
							<!--					<div class="col-sm-5">-->
							<!--						<div class="form-group row">-->
							<!--							<div class="col-sm-12">-->
							<!--								<input type="file" id="files_ati" data-div_procesando="#procesando_files_ati" accept="*/*"-->
							<!--									   data-file_destino="#destino_files_ati" name="files_ati" class="files_ati">-->
							<!--								<div id="procesando_files_ati"></div>-->
							<!--							</div>-->
							<!--						</div>-->
							<!--						<div class="form-group row">-->
							<!--							<div class="col-sm-12">-->
							<!--								<div class="form-group row">-->
							<!--									<input id="input_url_video" type="url" data-rule-url="true" class="form-control col-sm-9" placeholder="URL del video"-->
							<!--										   value="-->
							<?php //=isset($ec_instrumento_actividad) ? $ec_instrumento_actividad->actividad : '' ?><!--">-->
							<!--									<div class="col-sm-3">-->
							<!--										<button id="btn_agregar_video_ati" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus"></i> Agregar video</button>-->
							<!--									</div>-->
							<!--								</div>-->
							<!--							</div>-->
							<!--						</div>-->
							<!--					</div>-->
							<!--					<div class="col-sm-4" id="destino_files_ati">-->
							<!--						--><?php //if(isset($ec_instrumento_actividad_has_archivo)): ?>
							<!--							--><?php //foreach ($ec_instrumento_actividad_has_archivo as $av): ?>
							<!--								--><?php
							//								if(!is_null($av->id_archivo) && $av->id_archivo != ''){
							//									$href = base_url().$av->archivo;
							//									$icon = 'fa fa-file';
							//									$nombre = $av->nombre_archivo;
							//									$input = '<input type="hidden" name="archivo_video[][id_archivo]" value="'.$av->id_archivo.'">';
							//								}else{
							//									$href = $av->url_video;
							//									$icon = 'fa fa-video';
							//									$nombre = $av->url_video;
							//									$input = '<input type="hidden" name="archivo_video[][url_video]" value="'.$av->url_video.'">';
							//								}
							//								?>
							<!--								<li class="mb-1" style="list-style: none">-->
							<!--									--><?php //=$input?>
							<!--									<a href="-->
							<?php //=$href?><!--" target="_blank" class="btn btn-sm btn-outline-success" data-toggle="tooltip" title="-->
							<?php //=$nombre?><!--">-->
							<!--										<i class="-->
							<?php //=$icon?><!--"></i> --><?php //=substr($nombre,0,20).'...'?>
							<!--									</a>-->
							<!--									<button type="button" class="ml-1 btn btn-sm btn-outline-danger eliminar_archivo_video_instrumento" data-toggle="tooltip" title="Eliminar archivo/video"><i class="fa fa-trash"></i></button>-->
							<!--								</li>-->
							<!--							--><?php //endforeach; ?>
							<!--						--><?php //endif; ?>
							<!--					</div>-->
							<!--				</div>-->
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" id="btn_guardar_form_ec_ati"
									data-id_estandar_competencia="<?= isset($id_estandar_competencia) ? $id_estandar_competencia : '' ?>"
									class="btn btn-outline-primary btn-sm">Guardar
							</button>
						</div>
					</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
