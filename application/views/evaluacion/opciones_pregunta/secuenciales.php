<div class="form-group row">
    <label class="col-form-label col-sm-3" for="txt_pregunta_verdadero_falso">Pregunta:</label>
	<div class="col-sm-9">
		<textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
				  name="banco_pregunta[pregunta]"><?=isset($banco_pregunta) ? $banco_pregunta->pregunta : 'Ordene cronológicamente las siguientes opciones'?></textarea>
	</div>
</div>

<div class="form-group row">
	<div class="col-sm-12 text-right">
		<button id="agregar_opcion_pregunta_img_uo" type="button" class="btn btn-success btn-pill btn-sm agregar_row_comun"
				data-origen="#new_row_respuesta_pregunta_up"
				data-destino="#tbody_opciones_pregunta">
			<i class="fa fa-plus"></i> Agregar opción
		</button>
	</div>
</div>

<div class="noview" id="new_row_respuesta_pregunta_up">
    <!--
    <tr>
    	<td>
            <input type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                   name="opcion_pregunta[{id}][descripcion]"
                   value="">
        </td>
        <td class="text-center">
        	<div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<input id="input_banner_img{id}" type="file" class="file img_foto_opcion_pregunta_uo"
					   data-destino_input_imagen="#imagen_opcion_pregunta_{id}" data-rule_required="true"
					   data-destino_src_imagen="#imagen_opcion_pregunta_src_{id}"
					   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_{id}"
					   accept="image/*" name="img_banner">
			</div>
            <div id="div_container_img_pregunta_evaluacion_{id}">
				<div>
					<input type="hidden" id="imagen_opcion_pregunta_{id}" class="" name="opcion_pregunta[{id}][id_archivo]" value="">
					<img id="imagen_opcion_pregunta_src_{id}" class="img-thumbnail" style="width: 75px !important;"
						 src="<?=base_url().'assets/imgs/logos/no_disponible.png'?>"
						 alt="Imagen opciones">
				</div>
				<div id="procesando_imagen_opcion_pregunta_{id}"></div>
			</div>
        </td>
        <td>
            <input type="number" class="form-control consecutivo" placeholder="Orden de la pregunta" data-rule-required="true"
                   min="1" data-rule-number="true"
                   name="opcion_pregunta[{id}][orden_pregunta]"
                   value="">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm eliminar_registro_comun" data-toggle="tooltip"
                    title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    -->
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Opciones
				<small class="form-text text-muted">La secuencia se guardaran conforme al orden de la tabla</small>
            </th>
            <th>
                Imágen
				<small class="form-text text-muted">Opcional</small>
            </th>
            <th>
                Secuencia correcta
                <small class="form-text text-muted">De como se evaluará la respuesta</small>
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tbody_opciones_pregunta">
        <?php if(isset($opcion_pregunta) && is_array($opcion_pregunta)): ?>
            <?php foreach ($opcion_pregunta as $index => $opp): ?>
                <tr>
					<input type="hidden" name="opcion_pregunta[<?=$index?>][tipo_respuesta]" value="correcta">
                    <td>
                        <input type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                               name="opcion_pregunta[<?=$index?>][descripcion]"
                               value="<?=$opp->descripcion?>">
                    </td>
                    <td class="text-center">
                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<input id="input_banner_img<?=$index?>" type="file" class="file img_foto_opcion_pregunta_uo"
								   data-destino_input_imagen="#imagen_opcion_pregunta_<?=$index?>" data-rule_required="true"
								   data-destino_src_imagen="#imagen_opcion_pregunta_src_<?=$index?>"
								   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_<?=$index?>"
								   accept="image/*" name="img_banner">
                        </div>
                        <div id="div_container_img_pregunta_evaluacion_<?=$index?>">
							<div>
								<input type="hidden" id="imagen_opcion_pregunta_<?=$index?>" class="image_opcion_pregunta" name="opcion_pregunta[<?=$index?>][id_archivo]" value="<?=isset($opp->id_archivo) ? $opp->id_archivo : ''?>">
								<img id="imagen_opcion_pregunta_src_<?=$index?>" class="img-thumbnail" style="width: 75px !important;"
									 src="<?=isset($opp->archivo_imagen_respuesta->ruta_directorio) ? base_url().$opp->archivo_imagen_respuesta->ruta_directorio.$opp->archivo_imagen_respuesta->nombre : base_url().'assets/imgs/logos/no_disponible.png'?>"
									 alt="<?=isset($opp->archivo_imagen_respuesta->nombre) ? $opp->archivo_imagen_respuesta->nombre : 'Imagen opciones'?>">
							</div>
							<div id="procesando_imagen_opcion_pregunta_<?=$index?>"></div>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control consecutivo" placeholder="Orden de la pregunta" data-rule-required="true"
                               min="1" data-rule-number="true"
                               name="opcion_pregunta[<?=$index?>][orden_pregunta]"
                               value="<?=$opp->orden_pregunta?>">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm eliminar_registro_comun" data-toggle="tooltip"
                                title="Eliminar registro"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
