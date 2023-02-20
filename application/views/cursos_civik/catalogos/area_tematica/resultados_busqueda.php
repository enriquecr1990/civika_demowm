<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Clave</th>
            <th class="text-center">Denominación</th>
            <th class="text-center" width="15%">
                <button class="btn btn-info btn-sm btn-pill agregar_nueva_area_tematica">
                    Nueva área temática
                </button>
            </th>
        </tr>
        </thead>
        <tbody class="tbodyAreasTematicas">
        <?php if(isset($catalogo_area_tematica) && is_array($catalogo_area_tematica) && sizeof($catalogo_area_tematica) != 0): ?>
            <?php foreach ($catalogo_area_tematica as $a): ?>
                <tr>
                    <td><?=$a->clave?></td>
                    <td><?=$a->denominacion?></td>
                    <td>
                        <button class="btn btn-primary btn-pill btn-sm modificar_area_tematica" data-toggle="tooltip"
                                title="Modificar área temática" data-placement="bottom"
                                data-id_catalogo_area_tematica="<?=$a->id_catalogo_area_tematica?>">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-pill btn-sm eliminar_aula_civika" data-toggle="tooltip"
                                data-url_operacion="<?=base_url().'AdministrarCatalogos/eliminar_catalogo_area_tematica/'.$a->id_catalogo_area_tematica?>"
                                data-msg_operacion="Se eliminará el área temática del sistema <label>¿deseá continuar?</label>"
                                data-btn_trigger="#btn_buscar_areas_tematicas"
                                title="Eliminar área temática" data-placement="bottom">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Sin registro de áreas temáticas en el sistema</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>