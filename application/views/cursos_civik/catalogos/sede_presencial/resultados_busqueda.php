<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Dirección</th>
            <th class="text-center">Mapa</th>
            <th class="text-center">Teléfono</th>
            <th class="text-center">Detalle entrada libre</th>
            <th class="text-center">Detalle descuentos</th>
            <th class="text-center" width="15%">
                <button class="btn btn-info btn-sm btn-pill agregar_nueva_sede_presencial">
                    Nueva Sede
                </button>
            </th>
        </tr>
        </thead>
        <tbody class="tbody_sede_presencial">
        <?php if(isset($array_sede_presencial) && is_array($array_sede_presencial) && sizeof($array_sede_presencial) != 0): ?>
            <?php foreach ($array_sede_presencial as $index => $a): ?>
                <tr>
                    <td><?=$a->nombre?></td>
                    <td><?=$a->direccion?></td>
                    <td>
                        <a href="<?=$a->link_mapa?>" target="_blank"><?=$a->link_mapa?></a>
                    </td>
                    <td><?=$a->telefono_principal?></td>
                    <td><?=nl2br($a->entrada_libre)?></td>
                    <td><?=nl2br($a->descuento_descripcion)?></td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-pill btn-sm modificar_sede_presencial" data-toggle="tooltip"
                                title="Modificar Sede de Civika" data-placement="bottom"
                                data-id_sede_presencial="<?=$a->id_sede_presencial?>">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-pill btn-sm eliminar_sede_presencial" data-toggle="tooltip"
                                data-url_operacion="<?=base_url().'AdministrarCatalogos/eliminar_sede_civika/'.$a->id_sede_presencial?>"
                                data-msg_operacion="Se eliminará la sede del sistema <label>¿deseá continuar?</label>"
                                data-btn_trigger="#btn_buscar_formas_pago"
                                title="Eliminar Sede de Civika" data-placement="bottom">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>