<?php foreach ($rows as $r): ?>
    <tr>
        <td>
            <input type="hidden" name="instrutores_asignados[<?=$pintar_vacio ? '{id}' : $r->id_instructor_asignado_curso_publicado?>][id_instructor_asignado_curso_publicado]"
                   value="<?=$pintar_vacio ? 0 : $r->id_instructor_asignado_curso_publicado?>">
            <select id="input_instructor" class="custom-select" data-rule-required="true" style="width: 100%"
                    <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                    name="instrutores_asignados[<?=$pintar_vacio ? '{id}' : $r->id_instructor_asignado_curso_publicado?>][id_instructor]" >
                <option value="">Seleccione</option>
                <?php foreach ($instructores as $i): ?>
                    <option value="<?=$i->id_instructor?>" <?=!$pintar_vacio && $r->id_instructor == $i->id_instructor ? 'selected="selected"':''?>><?=$i->abreviatura.' '.$i->nombre_completo?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select id="input_instructor" class="custom-select" data-rule-required="true" style="width: 100%"
                    <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?>
                    name="instrutores_asignados[<?=$pintar_vacio ? '{id}' : $r->id_instructor_asignado_curso_publicado?>][id_catalogo_aula]" >
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_aulas as $ca): ?>
                    <option value="<?=$ca->id_catalogo_aula?>" <?=!$pintar_vacio && $r->id_catalogo_aula == $ca->id_catalogo_aula ? 'selected="selected"':''?>><?=$ca->campus.' - '.$ca->aula?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <button type="button" <?=isset($lectura) && $lectura === true ? 'disabled="disabled"' : ''?> class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
<?php endforeach;?>