<div class="form-group col-lg-12 col-md-12 col-sm-12">
    <label class="col-form-label" for="txt_pregunta_verdadero_falso">Redacción de la pregunta:</label>
    <textarea id="txt_pregunta_verdadero_falso" class="form-control" placeholder="Describa la pregunta para la evaluación"
              data-rule-required="true"
              name="pregunta_publicacion_ctn[pregunta]"><?=isset($pregunta_publicacion_ctn) ? $pregunta_publicacion_ctn->pregunta : 'Ordene cronólogicamente las siguientes opciones'?></textarea>
</div>

<div class="form-group col-lg-6 col-md-6 col-sm-12">
    <span class="badge badge-primary">Opciones:</span>
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 text-right">
    <button type="button" class="btn btn-success btn-pill btn-sm agregar_row_respuesta_pregunta_up"
            data-origen="#new_row_respuesta_pregunta_up"
            data-destino="#tbody_respuesta_pregunta_secuenciales">
        <i class="fa fa-plus"></i> Agregar opcion
    </button>
</div>

<div class="noview" id="new_row_respuesta_pregunta_up">
    <!--
    <tr>
        <td>
            <input type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                   name="opcion_pregunta_publicacion_ctn[{id}][descripcion]"
                   value="">
        </td>
        <td class="text-center">
            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <input id="input_banner_img" type="file" class="file fileUploadImgPreguntaEvaluacion"
                       data-destino_img="#div_container_img_pregunta_evaluacion_{id}" data-rule_required="true"
                       data-identificador_row="{id}"
                       accept="image/*" name="img_banner">
            </div>
            <div id="div_container_img_pregunta_evaluacion_{id}">

            </div>
        </td>
        <td>
            <input type="number" class="form-control consecutivo" placeholder="Orden de la pregunta" data-rule-required="true"
                   min="1" data-rule-number="true"
                   name="opcion_pregunta_publicacion_ctn[{id}][orden_pregunta]"
                   value="">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip"
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
                Opciones <span class="requerido">*</span>
                <br><span class="help-span">La secuencia de las respuestas se guardaran conforme al orden de la tabla</span>
            </th>
            <th>
                Imágen
            </th>
            <th>
                Secuencia correcta
                <br><span class="help-span">De como se evaluará la respuesta</span>
            </th>
            <th width="15%">Operación</th>
        </tr>
        </thead>
        <tbody id="tbody_respuesta_pregunta_secuenciales">
        <?php if(isset($opciones_pregunta_publicacion_ctn) && is_array($opciones_pregunta_publicacion_ctn)): ?>
            <?php foreach ($opciones_pregunta_publicacion_ctn as $index => $opp): ?>
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="Respuesta" data-rule-required="true"
                               name="opcion_pregunta_publicacion_ctn[<?=$index?>][descripcion]"
                               value="<?=$opp->descripcion?>">
                    </td>
                    <td class="text-center">
                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <input id="input_banner_img" type="file" class="file fileUploadImgPreguntaEvaluacion"
                                   data-destino_img="#div_container_img_pregunta_evaluacion_<?=$index?>" data-rule_required="true"
                                   data-identificador_row="<?=$index?>"
                                   accept="image/*" name="img_banner">
                        </div>
                        <div id="div_container_img_pregunta_evaluacion_<?=$index?>">
                            <?php if(isset($opp->documento_imagen_respuesta) && is_object($opp->documento_imagen_respuesta)): ?>
                                <div>
                                    <input type="hidden" class="img_pregunta_evaluacion_ctn" name="opcion_pregunta_publicacion_ctn[<?=$index?>][id_documento]" value="<?=$opp->id_documento?>">
                                    <img class="img-thumbnail" style="width: 75px !important;" src="<?=$opp->documento_imagen_respuesta->ruta_documento?>" alt="<?=$opp->documento_imagen_respuesta->nombre?>">
                                </div>
                            <?php endif;?>
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control consecutivo" placeholder="Orden de la pregunta" data-rule-required="true"
                               min="1" data-rule-number="true"
                               name="opcion_pregunta_publicacion_ctn[<?=$index?>][orden_pregunta]"
                               value="<?=$opp->orden_pregunta?>">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip"
                                title="Eliminar registro"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <div id="contenedor_mensajes_validacion_footer_modal"></div>
</div>