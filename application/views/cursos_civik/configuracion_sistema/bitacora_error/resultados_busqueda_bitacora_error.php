<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Controller</th>
            <th class="text-center">Function</th>
            <th class="text-center">Fecha</th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($array_bitacora_error) && is_array($array_bitacora_error) && sizeof($array_bitacora_error) != 0): ?>
            <?php foreach ($array_bitacora_error as $index => $a): ?>
                <tr>
                    <td><?=$a->controller?></td>
                    <td><?=$a->function?></td>
                    <td><?=fechaHoraBDToHTML($a->fecha)?></td>
                    <td>
                        <button type="button" class="btn btn-pill btn-outline-primary btn_view_conteiner"
                                data-id_bitacora_error="<?=$a->id_bitacora_error?>">
                            <i class="fa fa-eye-slash"></i> Ver detalle
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>