<div class="modal fade" id="modal_form_curso" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?= isset($ec_curso) ? 'Modificar  curso' : 'Agregar  curso' ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_ec_curso">
				
				<input type="hidden" name="id_ec_curso"
					value="<?= isset($ec_curso->id_ec_curso) ? $ec_curso->id_ec_curso : '' ?>">
				<input type="hidden" name="id_estandar_competencia"
					value="<?= isset($id_estandar_competencia) ? $id_estandar_competencia : '' ?>">
				
				<div class="modal-body">
					
					<div class="form-group row" id="div_nombre_curso">
						<label for="nombre_curso" class="col-sm-3 col-form-label" >Nombre curso</label>
						<div class="col-sm-9">
							<input id="nombre_curso" type="text" placeholder="Escriba el nombre del curso"
								class="form-control" name="nombre_curso" data-rule-required="true" 
								value="<?= isset($ec_curso->nombre_curso) ? $ec_curso->nombre_curso : '' ?>">
						</div>
					</div>
					<div class="form-group row" id="div_descripcion_curso">
						<label for="txt_descripcion_curso" class="col-sm-3 col-form-label">Descripción</label>
						<div class="col-sm-9">
							<textarea id="txt_descripcion_curso" class="form-control" placeholder="Describa el curso" data-rule-required="true"
								name="descripcion"><?= isset($ec_curso->descripcion) ? $ec_curso->descripcion : '' ?></textarea>
						</div>
					</div>
					<div class="form-group row" id="div_que_aprenderas_curso">
						<label for="txt_que_aprenderas_curso" class="col-sm-3 col-form-label" >¿Que aprenderas?</label>
						<div class="col-sm-9">
							<textarea id="txt_que_aprenderas_curso" class="form-control" placeholder="Describa el curso" data-rule-required="true"
								name="que_aprenderas"><?= isset($ec_curso->que_aprenderas) ? $ec_curso->que_aprenderas : '' ?></textarea>
						</div>
					</div>
				
					<div class="form-group row">
						<label for="img_banner_ec" class="col-sm-3 col-form-label">Imagen Banner:</label>
						<input type="hidden" id="input_id_archivo_banner_ec_curso" name="id_archivo" value="<?=isset($ec_curso) ? $ec_curso->id_archivo : ''?>">
						<input type="file" id="img_banner_ec_curso" name="img_banner_ec" class="col-sm-3" accept="image/*" >
						<div id="procesando_img_banner_ec_curso" class="col-sm-5">
							<?php if(isset($archivo_banner) && !is_null($archivo_banner)): ?>
								<img src="<?=base_url().$archivo_banner->ruta_directorio.$archivo_banner->nombre?>" alt="Imágen banner EC Curso" style="max-width: 120px" class="img-fluid img-thumbnail">
							<?php endif; ?>
						</div>
					</div>

				</div>


				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_ec_curso"
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
