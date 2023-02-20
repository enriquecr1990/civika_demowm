<!-- paginacion -->
<?php
    $data_paginacion = array(
        'url_paginacion' => 'AdministrarCTN/buscar_alumnos_sistema',
        'conteiner_resultados' => '#container_resultados_registro_alumnos_para_ctn_publicado',
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
            <th class="text-center" width="15%">

            </th>
        </tr>
        </thead>
        <tbody class="tbody_alumnos_sistema">
        <?php if (isset($listaUsuario) && is_array($listaUsuario) && sizeof($listaUsuario) != 0): ?>
            <?php foreach ($listaUsuario as $index => $usuario): ?>
                <tr>
                    <td><?=$pagina_select == 1 ? $index + 1 : (($pagina_select * $limit_select) - ($limit_select - ($index + 1)))?></td>
                    <td><?= $usuario->nombre . ' ' . $usuario->apellido_p . ' ' . $usuario->apellido_m ?></td>
                    <td><?= $usuario->correo ?></td>
                    <td class="text-center">
                        <?php if($usuario->alumno_inscrito): ?>
                            <span class="badge badge-pill badge-success">Alumno inscrito</span>
                        <?php else: ?>
                            <button type="button" class="btn btn-pill btn-sm btn-primary registrar_alumno_existente_ctn_publicado"
                                    data-toggle="tooltip" data-id_publicacion_ctn="<?=$id_publicacion_ctn?>" data-id_usuario="<?=$usuario->id_usuario?>"
                                    title="Inscribir alumno" data-placement="bottom">
                                Inscribir alumno
                            </button>
                        <?php endif; ?>
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
