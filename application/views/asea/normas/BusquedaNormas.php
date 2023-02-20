<?php if($listaNormasAsea): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead style="text-align: center;">
            <tr>
                <th>Año</th>
                <th>Nombre</th>
                <th>Instructor</th>
                <th>Periodo ejecución</th>
                <th style="max-width: 15px;"></th>
            </tr>
            </thead>
            <tbody class="tbodyResultadosNormasASEA">
            <?php foreach ($listaNormasAsea as $norma): ?>
                <tr>
                    <td><?=$norma->anio?></td>
                    <td><?=$norma->nombre?></td>
                    <td><?=$norma->instructor?></td>
                    <td>
                        De <?=fechaBDToHtml($norma->fecha_inicio)?> a <?=fechaBDToHtml($norma->fecha_fin)?>
                        con horario de <?=$norma->horario?>
                    </td>
                    <td>
                        <div class="centrado">
                            <button type="button" class="btn btn-info btn-xs consultar_norma_asea" data-toggle="tooltip"
                                    data-id_norma="<?=$norma->id_normas_asea?>" data-editar_norma="2"
                                    data-placement="bottom" title="Consultar norma" >
                                <span class="glyphicon glyphicon-book"></span>
                            </button>
                            <?php if(isset($usuario->es_rh_empresa) && $usuario->es_rh_empresa): ?>
                                <button type="button" class="btn btn-success btn-xs consultar_actividades_norma" data-toggle="tooltip"
                                        data-id_norma="<?=$norma->id_normas_asea?>" data-editar_norma="2"
                                        data-placement="bottom" title="Consultar actividades de la norma" >
                                    <span class="glyphicon glyphicon-tasks"></span>
                                </button>
                            <?php endif; ?>
                            <?php if((isset($usuario->es_administrador) && $usuario->es_administrador)
                                    || (isset($usuario->es_admin) && $usuario->es_admin)): ?>
                                <button type="button" class="btn btn-primary btn-xs modificar_norma_asea" data-toggle="tooltip"
                                        data-id_norma="<?=$norma->id_normas_asea?>" data-placement="bottom" title="Modificar norma" >
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs consultar_norma_asea_actividades" data-toggle="tooltip"
                                        data-id_norma="<?=$norma->id_normas_asea?>" data-editar_norma="1"
                                        data-placement="bottom" title="Editar actividades norma" >
                                    <span class="glyphicon glyphicon-tasks"></span>
                                </button>
                                <a href="<?=base_url().'NormasAsea/registrarPreguntasNorma/'.$norma->id_normas_asea?>" role="button"
                                        class="btn btn-success btn-xs" data-toggle="tooltip"
                                        data-placement="bottom" title="Preguntas norma ASEA" >
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                </a>
                                <button type="button" class="btn btn-danger btn-xs eliminar_norma_asea" data-toggle="tooltip"
                                        data-url="NormasAsea/eliminarNormaAsea/<?=$norma->id_normas_asea?>"
                                        data-btn_trigger=".buscar_normas_asea"
                                        data-placement="bottom" title="Eliminar norma" >
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <span class="glyphicon glyphicon-info-sign"></span>No se encontraron registros
    </div>
<?php endif; ?>