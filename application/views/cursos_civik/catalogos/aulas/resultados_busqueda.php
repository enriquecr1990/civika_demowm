<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Campus</th>
            <th class="text-center">Aula</th>
            <th class="text-center">Capacidad</th>
            <th class="text-center" width="15%">
                <button class="btn btn-info btn-sm btn-pill agregar_nueva_aula">
                    Nueva aula
                </button>
            </th>
        </tr>
        </thead>
        <tbody class="tbodyAulasCivika">
        <?php if(isset($catalogo_aulas) && is_array($catalogo_aulas) && sizeof($catalogo_aulas) != 0): ?>
            <?php foreach ($catalogo_aulas as $a): ?>
                <tr>
                    <td><?=$a->campus?></td>
                    <td><?=$a->aula?></td>
                    <td><?=$a->cupo?></td>
                    <td>
                        <button class="btn btn-primary btn-pill btn-sm modificar_aula" data-toggle="tooltip"
                                title="Modificar aula" data-placement="bottom"
                                data-id_catalogo_aula="<?=$a->id_catalogo_aula?>">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-pill btn-sm eliminar_aula_civika" data-toggle="tooltip"
                                data-url_operacion="<?=base_url().'AdministrarCatalogos/eliminar_aula/'.$a->id_catalogo_aula?>"
                                data-msg_operacion="Se eliminará el aula del sistema <label>¿deseá continuar?</label>"
                                data-btn_trigger="#btn_buscar_aulas"
                                title="Eliminar aula" data-placement="bottom">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Sin registro de aulas en el sistema</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>