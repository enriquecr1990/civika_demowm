<div id="accordion">
    <?php foreach ($catalogo_ocupaciones_tablero as $index => $cot): ?>
        <div class="card">
            <div class="card-header" id="heading_<?=$index?>">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-link"  data-toggle="collapse" data-target="#collapse_<?=$index?>"
                            aria-expanded="true" aria-controls="collapse_<?=$index?>">
                        <?=$cot->clave_area_subarea.' '.$cot->denominacion?>
                    </button>
                    <button class="btn btn-link btn-sm modificar_ocupacion_especificia_area"
                            data-id_catalogo_ocupacion_especifica="<?=$cot->id_catalogo_ocupacion_especifica?>" data-tipo_ocupacion_especifica="area">
                        <i class="fa fa-pencil"></i>
                    </button>
                </h5>
            </div>

            <div id="collapse_<?=$index?>" class="collapse <?=$index == 0 ? 'show': ''?>" aria-labelledby="heading_<?=$index?>" data-parent="#accordion">
                <div class="card-body">
                    <ul>
                        <?php foreach ($cot->subAreas as $sa): ?>
                            <li>
                                <?=$sa->clave_area_subarea.' '.$sa->denominacion?>
                                <button class="btn btn-link btn-sm modificar_ocupacion_especificia_subarea"
                                        data-id_catalogo_ocupacion_especifica="<?=$sa->id_catalogo_ocupacion_especifica?>" data-tipo_ocupacion_especifica="subarea">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>