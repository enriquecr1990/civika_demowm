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
            <input type="text" class="form-control" name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][titulo]"
                   <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                   value="<?=$pintar_vacio ? '' : $r->titulo?>" data-rule-required="true" placeholder="Título del documento/vídeo">

        </td>
        <td>
            <input type="text" class="form-control" name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][descripcion]"
                   <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                   value="<?=$pintar_vacio ? '' : $r->descripcion?>" placeholder="Descripción del documento/vídeo">
        </td>
        <td class="text-center">
            <?php if(isset($lectura) && !$lectura): ?>
                <select class="custom-select slt_material_tipo_evidencia" data-rule-required="true"
                        name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][tipo_evidencia]">
                    <option value="">Seleccione</option>
                    <option value="1" <?=!$pintar_vacio && $r->tipo_evidencia == 1 ? 'selected="selected"':''?>>Archivo de evidencia</option>
                    <option value="2" <?=!$pintar_vacio && $r->tipo_evidencia == 2 ? 'selected="selected"':''?>>Link de video de YouTube/OneDrive/Facebook/...</option>
                </select>
                <br>
                <div class="contenedor_archivo_documento mb-1" <?=!$pintar_vacio && $r->tipo_evidencia == 1 ? '': 'style="display:none"'?>>
                    <input id="input_banner_img" type="file" class="file fileUploadDocsEvidencia"
                           data-id_row="<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>"
                        <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                           accept="*/*" name="publicacion_has_doc_evidencia">
                    <br>
                    <div class="conteiner_file_material_apoyo" id="div_conteiner_file_material_apoyo_<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>">
                        <?php if(!$pintar_vacio && isset($r->documento_evidencia) && $r->documento_evidencia != false): ?>
                            <div>
                                <input class="publicacion_material_evidencia" type="hidden" name="alumno_publicacion_ctn_has_material[<?=$r->id_alumno_publicacion_ctn_has_material?>][id_documento]"
                                       value="<?=$r->id_documento?>">
                                <a href="<?=$r->documento_evidencia->ruta_documento?>" target="_blank" class="btn btn-sm btn-pill btn-success "
                                   data-toggle="tooltip" title="Ver material de apoyo" >
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <?php if(isset($r->documento_evidencia) && !is_null($r->documento_evidencia) && $r->documento_evidencia !== false): ?>
                    <a href="<?=$r->documento_evidencia->ruta_documento?>" target="_blank" class="btn btn-sm btn-pill btn-success "
                       data-toggle="tooltip" title="Ver material de apoyo" >
                        <i class="fa fa-file-pdf-o"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>


            <?php if(isset($lectura) && !$lectura): ?>
                <div class="contenedor_video mb-1" <?=!$pintar_vacio && $r->tipo_evidencia == 2 ? '': 'style="display:none"'?>>
                    <input type="text" data-rule-required="true" data-rule-url="true" class="form-control" name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][url_video]"
                        <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                           value="<?=$pintar_vacio ? '' : $r->url_video?>" placeholder="URL video (ejemplo: https://www.youtube.com/watch?v=lwBZ-Q0TJF8)">
                </div>
            <?php else: ?>
                <a href="<?=$r->url_video?>" target="_blank" class="link"><?=$r->url_video?></a>
            <?php endif; ?>

        </td>
        <td class="text-center">
            <?php if(!$pintar_vacio): ?>
                <span class="badge badge-info">Por civika</span>
                <?php if(isset($usuario) && ($usuario->tipo_usuario == 'instructor' || $usuario->tipo_usuario == 'admin' || $usuario->tipo_usuario == 'administrador')): ?>
                    <textarea class="form-control civika_actualizacion_campo" rows="5" placeholder="Comentarios y observaciones de la evidencia"
                              data-url_peticion="<?=base_url()?>Instructores/actualizar_comentario_observacion"
                              data-tabla_update="alumno_publicacion_ctn_has_material"
                              data-campo_update="comentario_instructor"
                              data-id_campo_update="id_alumno_publicacion_ctn_has_material"
                              data-id_value_update="<?=$r->id_alumno_publicacion_ctn_has_material?>"><?=isset($r->comentario_instructor) ? $r->comentario_instructor : ''?></textarea>
                <?php else: ?>
                    <input type="hidden" name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][comentario_instructor]"
                           value="<?=$r->comentario_instructor?>">
                    <p><?=isset($r->comentario_instructor) ? $r->comentario_instructor : 'Sin comentario'?></p>
                <?php endif; ?>

                <span class="badge badge-info">Del alumno</span>
                <?php if(isset($usuario) && $usuario->tipo_usuario == 'alumno'): ?>
                    <textarea class="form-control" rows="5" name="alumno_publicacion_ctn_has_material[<?=$pintar_vacio ? '{id}':$r->id_alumno_publicacion_ctn_has_material?>][comentario_alumno]"
                              placeholder="Comentarios y observaciones de la evidencia"><?=isset($r->comentario_alumno) ? $r->comentario_alumno : ''?></textarea>
                <?php else: ?>
                    <p><?=isset($r->comentario_alumno) ? $r->comentario_alumno : 'Sin comentario'?></p>
                <?php endif; ?>
            <?php endif; ?>
        </td>
        <td>
            <?php if(isset($lectura) && !$lectura): ?>
                <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
            <?php endif; ?>
        </td>

    </tr>
<?php endforeach; ?>
