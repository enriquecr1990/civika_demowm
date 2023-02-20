<?php foreach ($rows_array as $index => $row): ?>
    <tr>
        <td>
            <select class="custom-select" data-rule-required="true"
                    name="instructor_certificacion_diplomado_curso[<?=$pintar_vacio ? '{id}':$index?>][id_catalogo_tipo_cdc]">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_tipo_cdc as $cta): ?>
                    <option value="<?=$cta->id_catalogo_tipo_cdc?>" <?=!$pintar_vacio && $row->id_catalogo_tipo_cdc == $cta->id_catalogo_tipo_cdc ? 'selected="selected"':''?>><?=$cta->nombre?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_certificacion_diplomado_curso[<?=$pintar_vacio ? '{id}':$index?>][nombre]"
                   class="form-control" placeholder="Nombre" value="<?=!$pintar_vacio ? $row->nombre:''?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_certificacion_diplomado_curso[<?=$pintar_vacio ? '{id}':$index?>][institucion]"
                   class="form-control" placeholder="Nombre del instituto/organización..." value="<?=!$pintar_vacio ? $row->institucion:''?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_certificacion_diplomado_curso[<?=$pintar_vacio ? '{id}':$index?>][fecha_finalizacion]"
                   class="form-control datepicker_shards" placeholder="Fecha de finalización" value="<?=!$pintar_vacio ? fechaBDToHtml($row->fecha_finalizacion):''?>">
        </td>
        <td class="text-center">
            <button class="btn btn-sm btn-pill btn-danger eliminar_row_table_civik">
                <i class="fa fa-trash"></i> Eliminar
            </button>
        </td>
    </tr>
<?php endforeach;?>