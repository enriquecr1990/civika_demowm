<div class="col-sm-12">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" data-toggle="tooltip" data-placement="top"
                           title="Seleccionar todas las normas" class="check_all_normas">
                </th>
                <th>Norma</th>
                <th>Instructor</th>
                <th>Área temática</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($normas_asea as $na): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="estacion_servicio_tiene_normas[][id_normas_asea]"
                               <?=$na->tiene_norma ? 'checked="checked"' : ''?>
                               class="checkbox_norma_estacion_servicio" value="<?=$na->id_normas_asea?>">
                    </td>
                    <td><?=$na->nombre?></td>
                    <td><?=$na->instructor?></td>
                    <td><?=$na->area_tematica?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>