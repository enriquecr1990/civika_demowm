<div class="form-group row">
	<label class="col-sm-2">Nivel académico:</label>
	<span class="col-sm-9 span_nivel_academico"><?=isset($datos_usuario->nivel_academico) ? $datos_usuario->nivel_academico : 'Sin datos'?></span>
	<select class="custom-select col-sm-9" id="slt_nivel_academico" style="display: none;">
		<option value="">--Seleccione--</option>
		<?php foreach ($cat_nivel_academico as $cna): ?>
			<option value="<?=$cna->id_cat_nivel_academico?>" <?=isset($datos_usuario->id_cat_nivel_academico) && $datos_usuario->id_cat_nivel_academico == $cna->id_cat_nivel_academico ? 'selected="selected"' : '' ?> ><?=$cna->nombre?></option>
		<?php endforeach;?>
	</select>
	<div class="col-sm-1">
		<button id="btn_modificar_nivel_academico" data-toggle="tooltip" title="Editar nivel académico"
				data-id_btn_iniciar_mod="#btn_modificar_nivel_academico"
				data-span_leyenda=".span_nivel_academico"
				data-id_input_editar="#slt_nivel_academico"
				data-id_btn_guardar_mod="#btn_guardar_nivel_academico"
				data-id_btn_cancelar_mod="#btn_cancelar_nivel_academico"
				type="button" class="btn btn-sm btn-outline-primary btn_iniciar_modificacion">
			<i class="fa fa-edit"></i>
		</button>
		<button id="btn_guardar_nivel_academico" style="display: none" data-toggle="tooltip" title="Guardar nivel académico"
				data-id_btn_iniciar_mod="#btn_modificar_nivel_academico"
				data-span_leyenda=".span_nivel_academico"
				data-id_input_editar="#slt_nivel_academico"
				data-id_btn_guardar_mod="#btn_guardar_nivel_academico"
				data-id_btn_cancelar_mod="#btn_cancelar_nivel_academico"
				data-campo_actualizar="id_cat_nivel_academico"
				data-tabla_actualizar="datos_usuario"
				data-id_actualizar="id_datos_usuario"
				data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
				data-type_input="select"
				class="btn btn-outline-success btn-sm btn_guardar_modificacion">
			<i class="fa fa-save"></i>
		</button>
		<button id="btn_cancelar_nivel_academico" style="display: none" data-toggle="tooltip" title="Cancelar"
				data-id_btn_iniciar_mod="#btn_modificar_nivel_academico"
				data-span_leyenda=".span_nivel_academico"
				data-id_input_editar="#slt_nivel_academico"
				data-id_btn_guardar_mod="#btn_guardar_nivel_academico"
				data-id_btn_cancelar_mod="#btn_cancelar_nivel_academico"
				class="btn btn-outline-danger btn-sm btn_cancelar_modificacion">
			<i class="fa fa-window-close"></i>
		</button>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-2">Profesión</label>
	<span class="col-sm-9 span_profesion"><?=isset($datos_usuario->profesion) ? $datos_usuario->profesion : 'Sin datos'?></span>
	<input type="text" placeholder="Escriba su profesión" class="form-control col-sm-9" id="input_editar_profesion" style="display: none;"
		   value="<?=isset($datos_usuario->profesion) ? $datos_usuario->profesion : ''?>">
	<div class="col-sm-1">
		<button id="btn_modificar_profesion" data-toggle="tooltip" title="Editar profesión"
				data-id_btn_iniciar_mod="#btn_modificar_profesion"
				data-span_leyenda=".span_profesion"
				data-id_input_editar="#input_editar_profesion"
				data-id_btn_guardar_mod="#btn_guardar_profesion"
				data-id_btn_cancelar_mod="#btn_cancelar_profesion"
				type="button" class="btn btn-sm btn-outline-primary btn_iniciar_modificacion">
			<i class="fa fa-edit"></i>
		</button>
		<button id="btn_guardar_profesion" style="display: none" data-toggle="tooltip" title="Guardar profesión"
				data-id_btn_iniciar_mod="#btn_modificar_profesion"
				data-span_leyenda=".span_profesion"
				data-id_input_editar="#input_editar_profesion"
				data-id_btn_guardar_mod="#btn_guardar_profesion"
				data-id_btn_cancelar_mod="#btn_cancelar_profesion"
				data-campo_actualizar="profesion"
				data-tabla_actualizar="datos_usuario"
				data-id_actualizar="id_datos_usuario"
				data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
				class="btn btn-outline-success btn-sm btn_guardar_modificacion">
			<i class="fa fa-save"></i>
		</button>
		<button id="btn_cancelar_profesion" style="display: none" data-toggle="tooltip" title="Cancelar"
				data-id_btn_iniciar_mod="#btn_modificar_profesion"
				data-span_leyenda=".span_profesion"
				data-id_input_editar="#input_editar_profesion"
				data-id_btn_guardar_mod="#btn_guardar_profesion"
				data-id_btn_cancelar_mod="#btn_cancelar_profesion"
				class="btn btn-outline-danger btn-sm btn_cancelar_modificacion">
			<i class="fa fa-window-close"></i>
		</button>
	</div>
</div>
<!--<hr>
<div class="form-group row">
	<label class="col-sm-2">Puesto laboral</label>
	<span class="col-sm-9 span_puesto_laboral"><?=isset($datos_usuario->puesto) ? $datos_usuario->puesto : 'Sin datos'?></span>
	<input type="text" placeholder="Escriba su puesto laboral" class="form-control col-sm-9" id="input_editar_puesto" style="display: none;"
		   value="<?=isset($datos_usuario->puesto) ? $datos_usuario->puesto : ''?>">
	<div class="col-sm-1">
		<button id="btn_modificar_puesto" data-toggle="tooltip" title="Editar puesto"
				data-id_btn_iniciar_mod="#btn_modificar_puesto"
				data-span_leyenda=".span_puesto_laboral"
				data-id_input_editar="#input_editar_puesto"
				data-id_btn_guardar_mod="#btn_guardar_puesto"
				data-id_btn_cancelar_mod="#btn_cancelar_puesto"
				type="button" class="btn btn-sm btn-outline-primary btn_iniciar_modificacion">
			<i class="fa fa-edit"></i>
		</button>
		<button id="btn_guardar_puesto" style="display: none" data-toggle="tooltip" title="Guardar puesto"
				data-id_btn_iniciar_mod="#btn_modificar_puesto" data-span_leyenda=".span_puesto_laboral"
				data-id_input_editar="#input_editar_puesto" data-id_btn_guardar_mod="#btn_guardar_puesto"
				data-id_btn_cancelar_mod="#btn_cancelar_puesto"
				data-campo_actualizar="puesto" data-tabla_actualizar="datos_usuario"
				data-id_actualizar="id_datos_usuario" data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
				class="btn btn-outline-success btn-sm btn_guardar_modificacion">
			<i class="fa fa-save"></i>
		</button>
		<button id="btn_cancelar_puesto" style="display: none" data-toggle="tooltip" title="Cancelar"
				data-id_btn_iniciar_mod="#btn_modificar_puesto"
				data-span_leyenda=".span_puesto_laboral"
				data-id_input_editar="#input_editar_puesto"
				data-id_btn_guardar_mod="#btn_guardar_puesto"
				data-id_btn_cancelar_mod="#btn_cancelar_puesto"
				class="btn btn-outline-danger btn-sm btn_cancelar_modificacion">
			<i class="fa fa-window-close"></i>
		</button>
	</div>
</div>
<hr>
<div class="form-group row">
	<label class="col-sm-2">Habilidades</label>
	<span class="col-sm-9 span_habilidades"><?=isset($datos_usuario->habilidades) ? $datos_usuario->habilidades : 'Sin datos'?></span>
	<input type="text" placeholder="Escriba sus habilidades" class="form-control col-sm-9" id="input_editar_habilidades" style="display: none;"
		   value="<?=isset($datos_usuario->habilidades) ? $datos_usuario->habilidades : ''?>">
	<div class="col-sm-1">
		<button id="btn_modificar_habilidades" data-toggle="tooltip" title="Editar habilidades"
				data-id_btn_iniciar_mod="#btn_modificar_habilidades"
				data-span_leyenda=".span_habilidades"
				data-id_input_editar="#input_editar_habilidades"
				data-id_btn_guardar_mod="#btn_guardar_habilidades"
				data-id_btn_cancelar_mod="#btn_cancelar_habilidades"
				type="button" class="btn btn-sm btn-outline-primary btn_iniciar_modificacion">
			<i class="fa fa-edit"></i>
		</button>
		<button id="btn_guardar_habilidades" style="display: none" data-toggle="tooltip" title="Guardar habilidades"
				data-id_btn_iniciar_mod="#btn_modificar_habilidades"
				data-span_leyenda=".span_habilidades"
				data-id_input_editar="#input_editar_habilidades"
				data-id_btn_guardar_mod="#btn_guardar_habilidades"
				data-id_btn_cancelar_mod="#btn_cancelar_habilidades"
				data-campo_actualizar="habilidades" data-tabla_actualizar="datos_usuario"
				data-id_actualizar="id_datos_usuario" data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
				class="btn btn-outline-success btn-sm btn_guardar_modificacion">
			<i class="fa fa-save"></i>
		</button>
		<button id="btn_cancelar_habilidades" style="display: none" data-toggle="tooltip" title="Cancelar"
				data-id_btn_iniciar_mod="#btn_modificar_habilidades"
				data-span_leyenda=".span_habilidades"
				data-id_input_editar="#input_editar_habilidades"
				data-id_btn_guardar_mod="#btn_guardar_habilidades"
				data-id_btn_cancelar_mod="#btn_cancelar_habilidades"
				class="btn btn-outline-danger btn-sm btn_cancelar_modificacion">
			<i class="fa fa-window-close"></i>
		</button>
	</div>
</div>
<hr>
<div class="form-group row">
	<label class="col-sm-2">Educación</label>
	<div id="div_educacion" class="col-sm-9"><?=isset($datos_usuario->educacion) ? $datos_usuario->educacion : 'Sin datos'?></div>
	<div class="col-sm-9" id="input_editor_curriculum" style="display: none">
		<textarea id="editor_curriculum"><?=isset($datos_usuario->educacion) ? $datos_usuario->educacion : ''?></textarea>
	</div>
	<div class="col-sm-1">
		<button id="btn_modificar_educacion" data-toggle="tooltip" title="Editar educacion"
				data-id_btn_iniciar_mod="#btn_modificar_educacion"
				data-span_leyenda="#div_educacion"
				data-id_input_editar="#input_editor_curriculum"
				data-id_btn_guardar_mod="#btn_guardar_educacion"
				data-id_btn_cancelar_mod="#btn_cancelar_educacion"
				type="button" class="btn btn-sm btn-outline-primary btn_iniciar_modificacion">
			<i class="fa fa-edit"></i>
		</button>
		<button id="btn_guardar_educacion" style="display: none" data-toggle="tooltip" title="Guardar educacion"
				data-id_btn_iniciar_mod="#btn_modificar_educacion"
				data-span_leyenda="#div_educacion"
				data-id_div_editor="#input_editor_curriculum"
				data-id_input_editar="#editor_curriculum"
				data-id_btn_guardar_mod="#btn_guardar_educacion"
				data-id_btn_cancelar_mod="#btn_cancelar_educacion"
				data-campo_actualizar="educacion" data-tabla_actualizar="datos_usuario"
				data-id_actualizar="id_datos_usuario" data-id_actualizar_valor="<?=$datos_usuario->id_datos_usuario?>"
				class="btn btn-outline-success btn-sm btn_guardar_modificacion btn_guardar_editor_summernote">
			<i class="fa fa-save"></i>
		</button>
		<button id="btn_cancelar_educacion" style="display: none" data-toggle="tooltip" title="Cancelar"
				data-id_btn_iniciar_mod="#btn_modificar_educacion"
				data-span_leyenda="#div_educacion"
				data-id_input_editar="#input_editor_curriculum"
				data-id_btn_guardar_mod="#btn_guardar_educacion"
				data-id_btn_cancelar_mod="#btn_cancelar_educacion"
				class="btn btn-outline-danger btn-sm btn_cancelar_modificacion">
			<i class="fa fa-window-close"></i>
		</button>
	</div>
</div>
-->
