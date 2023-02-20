<?php foreach ($rows_array as $index => $row): ?>
    <tr>
        <td>
            <select class="custom-select" data-rule-required="true"
                    name="instructor_preparacion_academica[<?=$pintar_vacio ? '{id}':$index?>][id_catalogo_titulo_academico]">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_titulo_academico as $cta): ?>
                    <option value="<?=$cta->id_catalogo_titulo_academico?>" <?=!$pintar_vacio && $row->id_catalogo_titulo_academico == $cta->id_catalogo_titulo_academico ? 'selected="selected"':''?>><?=$cta->titulo?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_preparacion_academica[<?=$pintar_vacio ? '{id}':$index?>][profesion_carrera]"
                   class="form-control" placeholder="Profesión/carrera" value="<?=$pintar_vacio ? '':$row->profesion_carrera?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_preparacion_academica[<?=$pintar_vacio ? '{id}':$index?>][institucion_academica]"
                   class="form-control" placeholder="Institución académica" value="<?=$pintar_vacio ? '':$row->institucion_academica?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_preparacion_academica[<?=$pintar_vacio ? '{id}':$index?>][fecha_termino]"
                   class="form-control datepicker_shards" placeholder="Fecha de finalización" value="<?=$pintar_vacio ? '':fechaBDToHtml($row->fecha_termino)?>" >
        </td>
        <td class="text-center">
            <button class="btn btn-sm btn-pill btn-danger eliminar_row_table_civik">
                <i class="fa fa-trash"></i> Eliminar
            </button>
        </td>
    </tr>
<?php endforeach; ?>