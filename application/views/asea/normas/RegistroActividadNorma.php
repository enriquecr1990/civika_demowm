<table class="table table-striped">
    <thead>
    <tr>
        <th>Descripción</th>
        <th>Objetivo</th>
        <th>Tiempo</th>
        <th>Video</th>
        <?php if($editarNormaActividad): ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody class="tbodyActividadesNorma">
    <?php if($editarNormaActividad): ?>
        <?php if($listaActividadesNorma): ?>
            <?php foreach ($listaActividadesNorma as $actividad): ?>
                <tr id="actividad_norma_<?=$actividad->id_actividad_normas_asea?>">
                    <td>
                        <input class="form-control" placeholder="Describa la actividad de la norma" data-rule-required="true"
                                  name="actividad_normas_asea[<?=$actividad->id_actividad_normas_asea?>][descripcion]" value="<?=$actividad->descripcion?>">
                    </td>
                    <td>
                        <input class="form-control" placeholder="Describa el objetivo de la norma" data-rule-required="true"
                                  name="actividad_normas_asea[<?=$actividad->id_actividad_normas_asea?>][objetivo]" value="<?=$actividad->objetivo?>">
                    </td>
                    <td>
                        <input class="form-control" placeholder="Tiempo (Minutos)" data-rule-required="true" data-rule-number="true"
                               name="actividad_normas_asea[<?=$actividad->id_actividad_normas_asea?>][tiempo]" value="<?=$actividad->tiempo?>">
                    </td>
                    <td>
                        <input type="hidden" id="url_video" name="actividad_normas_asea[<?=$actividad->id_actividad_normas_asea?>][url_video]" value="<?=$actividad->url_video?>">
                        <input type="hidden" id="nombre_video" value="<?=$actividad->nombre_video?>" name="actividad_normas_asea[<?=$actividad->id_actividad_normas_asea?>][nombre_video]">
                        <button type="button" class="btn btn-primary btn-xs buscar_video_actividad_norma" data-toggle="tooltip"
                                data-placement="bottom" title="Seleccionar video" data-destino_video="#actividad_norma_<?=$actividad->id_actividad_normas_asea?>">
                            <i class="glyphicon glyphicon-film"></i>
                        </button>
                        <span class="label label-info" id="nombre_video"><?=$actividad->nombre_video?></span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs eliminar_row_tabla" data-toggle="tooltip"
                                data-placement="bottom" title="Eliminar actividad norma" >
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
    <?php else: ?>
        <?php if($listaActividadesNorma): ?>
            <?php foreach ($listaActividadesNorma as $actividad): ?>
            <tr>
                <td><?=$actividad->descripcion?></td>
                <td><?=$actividad->objetivo?></td>
                <td><?=$actividad->tiempo?> minuto(s)</td>
                <td><span class="label label-info" id="nombre_video"><?=$actividad->nombre_video?></span></td>
            </tr>
            <?php endforeach; ?>
        <?php endif;?>
    <?php endif; ?>
    </tbody>
</table>