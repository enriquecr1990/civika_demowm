<div class="form-group row">
    <label class="col-form-label col-sm-3" for="txt_pregunta_verdadero_falso">Pregunta:</label>
	<div class="col-sm-9">
		<textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación" data-rule-required="true"
				  name="banco_pregunta[pregunta]"><?=isset($banco_pregunta) ? $banco_pregunta->pregunta : 'Relacione correctamente las siguientes opciones'?></textarea>
	</div>
</div>


<div class="form-group row">
	<label class="col-form-label col-sm-12">Respuestas:</label>
	<small class="form-text text-muted">La secuencia de las respuestas para el lateral izquierdo se guardaran conforme al orden de la tabla</small>
</div>

<div class="form-group row ">
	<div class="col-sm-12 text-right">
		<button id="agregar_opcion_pregunta_img_uo" type="button" class="btn btn-success btn-pill btn-sm agregar_row_comun actualizar_rows_respuestas_preguntas_relacionales"
				data-origen="#new_row_respuesta_pregunta_relacionales"
				data-destino="#tbody_opciones_pregunta">
			<i class="fa fa-plus"></i> Agregar opción
		</button>
	</div>
</div>

<div class="noview" id="new_row_respuesta_pregunta_relacionales">
    <!--
    <tr>
        <td>
            <input type="hidden" class="form-control consecutivo_derecho" placeholder="Orden de la pregunta" data-rule-required="true"
                   min="1" data-rule-number="true"
                   name="opcion_pregunta[izquierda][{id}][orden_pregunta]"
                   value="">
            <span class="consecutivo_derecho"></span>
        </td>
        <td>
            <textarea type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                      name="opcion_pregunta[izquierda][{id}][descripcion]"></textarea>
        </td>
        <td class="text-center">
            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<input id="input_banner_img{id}" type="file" class="file img_foto_opcion_pregunta_uo"
					   data-destino_input_imagen="#imagen_opcion_pregunta_izquierda_{id}" data-rule_required="true"
					   data-destino_src_imagen="#imagen_opcion_pregunta_src_izquierda_{id}"
					   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_izquierda_{id}"
					   accept="image/*" name="img_banner">
			</div>
			<div id="div_container_img_pregunta_evaluacion_{id}">
				<div>
					<input type="hidden" id="imagen_opcion_pregunta_izquierda_{id}" class="image_opcion_pregunta" name="opcion_pregunta[izquierda][{id}][id_archivo]"
						value="">
					<img id="imagen_opcion_pregunta_src_izquierda_{id}" class="img-thumbnail" style="width: 75px !important;"
						 src="<?=base_url().'assets/imgs/logos/no_disponible.png'?>"
						 alt="Imagen opciones">
				</div>
				<div id="procesando_imagen_opcion_pregunta_izquierda_{id}"></div>
			</div>
        </td>
        <td>
            <input type="number" class="form-control consecutivo" placeholder="Opción relacionada" data-rule-required="true"
                   min="1" data-rule-number="true"
                   name="opcion_pregunta[derecha][{id}][orden_pregunta]"
                   value="">
        </td>
        <td>
            <textarea type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                      name="opcion_pregunta[derecha][{id}][descripcion]"></textarea>
        </td>
        <td class="text-center">
            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
				<input id="input_banner_img{id}" type="file" class="file img_foto_opcion_pregunta_uo"
					   data-destino_input_imagen="#imagen_opcion_pregunta_derecha_{id}" data-rule_required="true"
					   data-destino_src_imagen="#imagen_opcion_pregunta_src_derecha_{id}"
					   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_derecha_{id}"
					   accept="image/*" name="img_banner">
			</div>
			<div id="div_container_img_pregunta_evaluacion_derecha_{id}">
				<div>
					<input type="hidden" id="imagen_opcion_pregunta_derecha_{id}" class="image_opcion_pregunta" name="opcion_pregunta[derecha][{id}][id_archivo]"
						value="">
					<img id="imagen_opcion_pregunta_src_derecha_{id}" class="img-thumbnail" style="width: 75px !important;"
						 src="<?=base_url().'assets/imgs/logos/no_disponible.png'?>"
						 alt="Imagen opciones">
				</div>
				<div id="procesando_imagen_opcion_pregunta_derecha_{id}"></div>
			</div>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm eliminar_registro_comun" data-toggle="tooltip"
                    title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    -->
</div>

<!-- izquierda -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Número opción</th>
            <th>
                Opciones izquierda
            </th>
            <th>
                Imágen <small class="form-text text-muted">Opcional</small>
            </th>
            <th>
                Opción relacionada
            </th>
            <th>
                Opciones derecha
            </th>
            <th>
                Imágen <small class="form-text text-muted">Opcional</small>
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody id="tbody_opciones_pregunta">
        <?php if(isset($opcion_pregunta_izquierda) && is_array($opcion_pregunta_izquierda) && isset($opcion_pregunta_derecha) && is_array($opcion_pregunta_derecha)): ?>
            <!-- para las opciones de izquierda tomar el valor de la iteración -->
            <!-- para las opciones de derecha tomar el valor del array con el indice $index -->
            <?php foreach ($opcion_pregunta_izquierda as $index => $opp): ?>
                <tr>
					<!-- preguntas de izquierda -->
                    <td>
                        <input type="hidden" class="form-control consecutivo_derecho" placeholder="Orden de la pregunta" data-rule-required="true"
                               min="1" data-rule-number="true"
                               name="opcion_pregunta[izquierda][<?=$index?>][orden_pregunta]"
                               value="<?=$index + 1?>">
                        <span class="consecutivo_derecho"><?=$index + 1?></span>
                    </td>
                    <td>
                        <textarea type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                                  name="opcion_pregunta[izquierda][<?=$index?>][descripcion]"><?=$opp->descripcion?></textarea>
                    </td>
                    <td class="text-center">
						<div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<input id="input_banner_img<?=$index?>" type="file" class="file img_foto_opcion_pregunta_uo"
								   data-destino_input_imagen="#imagen_opcion_pregunta_izquierda_<?=$index?>" data-rule_required="true"
								   data-destino_src_imagen="#imagen_opcion_pregunta_src_izquierda_<?=$index?>"
								   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_izquierda_<?=$index?>"
								   accept="image/*" name="img_banner">
						</div>
						<div id="div_container_img_pregunta_evaluacion_<?=$index?>">
							<div>
								<input type="hidden" id="imagen_opcion_pregunta_izquierda_<?=$index?>" class="image_opcion_pregunta" name="opcion_pregunta[izquierda][<?=$index?>][id_archivo]" value="<?=isset($opp->id_archivo) ? $opp->id_archivo : ''?>">
								<img id="imagen_opcion_pregunta_src_izquierda_<?=$index?>" class="img-thumbnail" style="width: 75px !important;"
									 src="<?=isset($opp->archivo_imagen_respuesta->ruta_directorio) ? base_url().$opp->archivo_imagen_respuesta->ruta_directorio.$opp->archivo_imagen_respuesta->nombre : base_url().'assets/imgs/logos/no_disponible.png'?>"
									 alt="<?=isset($opp->archivo_imagen_respuesta->nombre) ? $opp->archivo_imagen_respuesta->nombre : 'Imagen opciones'?>">
							</div>
							<div id="procesando_imagen_opcion_pregunta_izquierda_<?=$index?>"></div>
						</div>
                    </td>
					<!-- preguntas de derecha -->
                    <td>
                        <input type="number" class="form-control consecutivo" placeholder="Orden de la pregunta" data-rule-required="true"
                               min="1" data-rule-number="true"
                               name="opcion_pregunta[derecha][<?=$index?>][orden_pregunta]"
                               value="<?=$opcion_pregunta_derecha[$index]->orden_pregunta?>">
                    </td>
                    <td>
                        <textarea type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                                  name="opcion_pregunta[derecha][<?=$index?>][descripcion]"><?=$opcion_pregunta_derecha[$index]->descripcion?></textarea>
                    </td>
                    <td class="text-center">
						<div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
							<input id="input_banner_img<?=$index?>" type="file" class="file img_foto_opcion_pregunta_uo"
								   data-destino_input_imagen="#imagen_opcion_pregunta_derecha_<?=$index?>" data-rule_required="true"
								   data-destino_src_imagen="#imagen_opcion_pregunta_src_derecha_<?=$index?>"
								   data-destino_procesando_imagen="#procesando_imagen_opcion_pregunta_derecha_<?=$index?>"
								   accept="image/*" name="img_banner">
						</div>
						<div id="div_container_img_pregunta_evaluacion_derecha_<?=$index?>">
							<div>
								<input type="hidden" id="imagen_opcion_pregunta_derecha_<?=$index?>" class="image_opcion_pregunta" name="opcion_pregunta[derecha][<?=$index?>][id_archivo]" value="<?=isset($opp->id_archivo) ? $opp->id_archivo : ''?>">
								<img id="imagen_opcion_pregunta_src_derecha_<?=$index?>" class="img-thumbnail" style="width: 75px !important;"
									 src="<?=isset($opcion_pregunta_derecha[$index]->archivo_imagen_respuesta->ruta_directorio) ? base_url().$opcion_pregunta_derecha[$index]->archivo_imagen_respuesta->ruta_directorio.$opcion_pregunta_derecha[$index]->archivo_imagen_respuesta->nombre : base_url().'assets/imgs/logos/no_disponible.png'?>"
									 alt="<?=isset($opcion_pregunta_derecha[$index]->archivo_imagen_respuesta->nombre) ? $opcion_pregunta_derecha[$index]->archivo_imagen_respuesta->nombre : 'Imagen opciones'?>">
							</div>
							<div id="procesando_imagen_opcion_pregunta_derecha_<?=$index?>"></div>
						</div>
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
