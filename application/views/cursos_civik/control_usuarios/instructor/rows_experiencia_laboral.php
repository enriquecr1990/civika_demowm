<?php foreach ($rows_array as $index => $row): ?>
    <tr>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_experiencia_laboral[<?=$pintar_vacio ? '{id}':$index?>][puesto_trabajo]"
                   class="form-control" placeholder="Puesto de trabajo" value="<?=!$pintar_vacio ? $row->puesto_trabajo:''?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_experiencia_laboral[<?=$pintar_vacio ? '{id}':$index?>][empresa]"
                   class="form-control" placeholder="Empresa" value="<?=!$pintar_vacio ? $row->empresa:''?>">
        </td>
        <td>
            <input type="text" data-rule-required="true"
                   name="instructor_experiencia_laboral[<?=$pintar_vacio ? '{id}':$index?>][fecha_ingreso]"
                   class="form-control datepicker_shards" placeholder="Fecha de ingreso" value="<?=!$pintar_vacio ? fechaBDToHtml($row->fecha_ingreso):''?>">
        </td>
        <td>
            <input type="text" name="instructor_experiencia_laboral[<?=$pintar_vacio ? '{id}':$index?>][fecha_termino]"
                   class="form-control datepicker_shards" placeholder="Fecha de finalización" value="<?=!$pintar_vacio && !is_null($row->fecha_termino) ? fechaBDToHtml($row->fecha_termino):''?>">
        </td>
        <td class="text-center">
            <button class="btn btn-sm btn-pill btn-danger eliminar_row_table_civik">
                <i class="fa fa-trash"></i> Eliminar
            </button>
        </td>
    </tr>
<?php endforeach;?>