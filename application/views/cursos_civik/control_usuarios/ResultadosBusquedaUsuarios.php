<div class="card">
    <div class="card-header">
        <label>Usuarios</label>
    </div>

    <div class="card-body">
        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'ControlUsuarios/buscarUsuarios',
            'conteiner_resultados' => '#contenedor_resultados_usuarios_sistema',
            'form_busqueda' => 'form_buscar_usuarios',
            'id_paginacion' => uniqid(),
            'tipo_registro' => 'usuarios'
        );
        $this->load->view('default/paginacion_tablero',$data_paginacion);
        ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">#</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center">Tipo de usuario</th>
                        <th class="text-center">Activo</th>
                        <th class="text-center" width="15%">
                            <button class="btn btn-success btn-sm btn-pill agregar_nuevo_usuario">
                                Nuevo usuario
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="tbodyEstacionesServicio">
                    <?php if (isset($listaUsuario) && is_array($listaUsuario) && sizeof($listaUsuario) != 0): ?>
                    <?php foreach ($listaUsuario as $index => $usuario): ?>
                        <tr>
                            <td><?=$pagina_select == 1 ? $index + 1 : (($pagina_select * $limit_select) - ($limit_select - ($index + 1)))?></td>
                            <td><?= $usuario->nombre . ' ' . $usuario->apellido_p . ' ' . $usuario->apellido_m ?></td>
                            <td><?= $usuario->correo ?></td>
                            <td><?= $usuario->telefono ?></td>
                            <td><?= $usuario->tipo_usuario == 'admin' ? 'administrador' : $usuario->tipo_usuario ?></td>
                            <td>
                                <span class="label label-<?= $usuario->es_activo ? 'success' : 'danger' ?>"><?= $usuario->activo ?></span>
                            </td>
                            <td class="text-left">
                                <ul>
                                    <li class="mb-1">
                                        <button class="btn btn-primary btn-pill btn-sm modificar_usuario" data-toggle="tooltip"
                                        title="Modificar usuario" data-placement="bottom"
                                        data-tipo_usuario="<?= $usuario->tipo_usuario ?>"
                                        data-id_usuario="<?= $usuario->id_usuario ?>">
                                        <i class="fa fa-pencil"></i> Modificar
                                    </button>
                                </li>
                                <?php if($usuario->tipo_usuario == 'instructor'): ?>
                                    <li class="mb-1">
                                        <button class="btn btn-warning btn-pill btn-sm fa-white experiencia_curricular_instructor"
                                        data-id_usuario="<?=$usuario->id_usuario?>"
                                        data-toggle="tooltip" title="Experiencia curricular">
                                        <i class="fa fa-bookmark-o"></i> Experiencia curricurlar
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <!-- Botones para activar y eliminar un usuario en construccion aun -->

                        <button class="btn btn-<?= $usuario->es_activo ? 'danger fa-white' : 'success' ?> btn-sm btn-pill activar_desactivar_usario_sistema " data-toggle="tooltip"

                            data-url_operacion="ControlUsuarios/activarDesactivarUsuario/<?= $usuario->id_usuario ?>"

                            data-msg_operacion="Se <?= $usuario->es_activo ? 'desactivará' : 'activará' ?> el usuario <?=$usuario->tipo_usuario?>, ¿Deseá continuar?"
                            title="<?= $usuario->es_activo ? 'Desactivar' : 'Activar' ?> usuario sistema" data-placement="bottom"
                            data-btn_trigger=".buscar_usuarios_sistema"
                            data-id_usuario="<?= $usuario->id_usuario ?>">
                            <i class="fa fa-<?= $usuario->es_activo ? 'remove' : 'ok' ?>"></i><?=$usuario->es_activo ? 'Desactivar' : 'Activar'?>
                        </button>


                            <!--
                            <button class="btn btn-danger btn-pill btn-sm eliminar_usuario_admin" data-toggle="tooltip"
                                    data-url="ControlUsuarios/eliminarUsuarioAdmin/<?= $usuario->id_usuario ?>"
                                    data-btn_trigger=".buscar_usuarios_sistema"
                                    title="Eliminar usuario administrador" data-placement="bottom"
                                    data-id_usuario="<?= $usuario->id_usuario ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        -->
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <td colspan="7" class="text-center">
                    <span>Sin registro de usuarios en el sistema</span>
                </td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

</div>