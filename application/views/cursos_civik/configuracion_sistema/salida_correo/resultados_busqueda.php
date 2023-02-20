<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center">Correo</th>
            <th class="text-center">Estatus del correo</th>
            <th class="text-center" width="15%">
                <button class="btn btn-primary btn-sm btn-pill agregar_nueva_config_correo">
                    Nueva configuración
                </button>
            </th>
        </tr>
        </thead>
        <tbody class="tbody_config_salida_correo">
        <?php if(isset($array_salida_correo) && is_array($array_salida_correo) && sizeof($array_salida_correo) != 0): ?>
            <?php foreach ($array_salida_correo as $index => $a): ?>
                <tr>
                    <td><span class="badge badge-light"><?=$a->smtp_user?></span></td>
                    <td>
                        <span class="badge badge-<?=$a->active == 'si' ? 'success':'danger'?>"><?=$a->active == 'si' ? 'Active' : 'Inactiva'?></span>
                    </td>
                    <td class="text-center">
                        <ul>
                            <li class="mb-1">
                                <?php if($a->active == 'no'): ?>
                                    <button class="btn btn-sm btn-warning btn-pill modificar_config_correo"
                                            title="Editar configuración correo"
                                            data-toggle="tooltip" type="button"
                                            data-id_config_correo="<?=$a->id_config_correo?>">
                                        Editar
                                    </button>
                                <?php endif; ?>
                            </li>
                            <li class="mb-1">
                                <?php if($a->active == 'no'): ?>
                                    <button class="btn btn-danger btn-sm btn-pill usar_correo_electronico"
                                            data-toggle="tooltip" type="button"
                                            data-url_operacion="<?=base_url()?>ConfiguracionSistema/set_default_config_correo/<?= $a->id_config_correo?>"
                                            data-msg_operacion="Se activará está configuración para el envio de correos electrónicos, ¿Deseá continuar?"
                                            data-placement="bottom" data-btn_trigger="#btn_buscar_config_correo">
                                        Usar configuracion
                                    </button>
                                <?php else: ?>
                                    <span class="badge badge-success">Configuración actual</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>