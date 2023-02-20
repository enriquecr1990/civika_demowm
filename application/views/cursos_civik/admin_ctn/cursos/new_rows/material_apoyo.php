<?php
if($rows === false){
    $rows = array(array());
}elseif(sizeof($rows) == 0){
    $rows = array();
}
?>

<?php foreach ($rows as $r): ?>
    <tr>
        <td>
            <input type="hidden" name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][tipo]"
                   value="doc">
            <input type="text" class="form-control" name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][titulo]"
                    <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                   value="<?=$pintar_vacio ? '' : $r->titulo?>" data-rule-required="true" placeholder="Título del documento">

        </td>
        <td>
            <input type="text" class="form-control" name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][descripcion]"
                <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                   value="<?=$pintar_vacio ? '' : $r->descripcion?>" placeholder="Descripción del documento">
        </td>
        <td>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="documento_publico_si_<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>" class="custom-control-input" value="si"
                       <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                       <?=!$pintar_vacio && $r->documento_publico == 'si' ? 'checked':''?>
                       name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][documento_publico]">
                <label class="custom-control-label" for="documento_publico_si_<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>">Si</label>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="radio" id="documento_publico_no_<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>" class="custom-control-input" value="no"
                       <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                       <?=!$pintar_vacio && $r->documento_publico == 'no' ? 'checked':''?>
                       name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][documento_publico]" >
                <label class="custom-control-label" for="documento_publico_no_<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>">No</label>
            </div>
        </td>
        <td class="text-center">
            <?php if(!isset($lectura) || $lectura !== true): ?>
                <input id="input_banner_img" type="file" class="file fileUploadDocCurso" data-id_row="<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>"
                        <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                       accept="*/*" name="publicacion_has_doc">
                <br>
            <?php endif; ?>
            <div class="conteiner_file_material_apoyo" id="div_conteiner_file_material_apoyo_<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>">
                <?php if(!$pintar_vacio): ?>
                    <div>
                        <input class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[material][<?=$r->id_publicacion_has_doc_banner?>][id_documento]"
                               value="<?=$r->id_documento?>">
                        <a href="<?=$r->documento_banner->ruta_documento?>" target="_blank" class="btn btn-sm btn-pill btn-success "
                           data-toggle="tooltip" title="Ver material de apoyo" >
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="custom-control custom-radio mb-3">
                <input type="text" class="form-control" name="publicacion_has_doc_banner[material][<?=$pintar_vacio ? '{id}':$r->id_publicacion_has_doc_banner?>][url_video]"
                    <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                       value="<?=$pintar_vacio ? '' : $r->url_video?>" data-rule-url="true" placeholder="URL video (ejemplo: https://www.youtube.com/watch?v=lwBZ-Q0TJF8)">
                <span class="help-span">En caso de que tenga un video el material de apoyo</span>
            </div>
        </td>
        <td>
            <button type="button" <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?> class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>

    </tr>
<?php endforeach; ?>
