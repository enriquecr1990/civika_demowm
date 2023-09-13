<div class="modal fade" id="modal_form_ec" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($estandar_competencia) ? 'Actualizar':'Nuevo'?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_ec">
				<div class="modal-body">
					<div class="form-group row">
						<label for="input_codigo" class="col-sm-3 col-form-label">Código</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input_str_mayus" id="input_codigo" data-rule-required="true"
								   name="codigo" placeholder="Código del estándar de competencia" value="<?=isset($estandar_competencia) ? $estandar_competencia->codigo : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="input_titulo" class="col-sm-3 col-form-label">Título</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="input_titulo" placeholder="Título del estándar de competencia" data-rule-required="true"
									  name="titulo" rows="5"><?=isset($estandar_competencia) ? $estandar_competencia->titulo : ''?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="input_calificacion_juicio" class="col-sm-3 col-form-label">Calificación de juicio:</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="input_calificacion_juicio" data-rule-required="true" data-rule-number="true"
								   name="calificacion_juicio" placeholder="Calificación para juicio" value="<?=isset($estandar_competencia) ? $estandar_competencia->calificacion_juicio : ''?>">
						</div>
					</div>
					<div class="form-group row">
						<label for="img_banner_ec" class="col-sm-3 col-form-label">Imagen Banner:</label>
						<input type="hidden" id="input_id_archivo_banner_ec" name="id_archivo" value="<?=isset($estandar_competencia) ? $estandar_competencia->id_archivo : ''?>">
						<input type="file" id="img_banner_ec" name="img_banner_ec" class="col-sm-3" accept="image/*" >
						<div id="procesando_img_banner_ec" class="col-sm-5">
							<?php if(isset($archivo_banner) && !is_null($archivo_banner)): ?>
								<img src="<?=base_url().$archivo_banner->ruta_directorio.$archivo_banner->nombre?>" alt="Imágen banner EC" style="max-width: 120px" class="img-fluid img-thumbnail">
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ec"
							data-id_estandar_competencia="<?=isset($estandar_competencia) ? $estandar_competencia->id_estandar_competencia : ''?>"
							class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
