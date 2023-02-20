<div class="card">
    <div class="card-header">
        <label>Cursos STPS</label>
    </div>
    <div class="card-body">

        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'AdministrarCTN/buscarCursos',
            'conteiner_resultados' => '#contenedor_resultados_cursos',
            'form_busqueda' => 'form_buscar_cursos',
            'id_paginacion' => uniqid(),
            'tipo_registro' => 'cursos'
        );
        $this->load->view('default/paginacion_tablero',$data_paginacion);
        ?>

        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre DC-3</th>
                    <th width="10%" class="text-center">Área temática</th>
                    <!--<th class="text-center">Descripción</th>
                    <th class="text-center">Objetivo</th>
                    -->
                    <th class="text-center" width="55%">Detalle</th>
                    <th class="text-center">Publicaciones</th>
                    <th  class="text-center" width="10%">
                        <button class="btn btn-primary btn-sm btn-pill agregar_nuevo_curso_civik">
                            Nuevo Curso
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody class="tbodyEstacionesServicio">
                <?php if(isset($array_cursos) && is_array($array_cursos) && sizeof($array_cursos) !=0): ?>
                    <?php foreach ($array_cursos as $index => $curso): ?>
                        <tr class="<?=isset($curso->ctn_cancelado) && $curso->ctn_cancelado == 'si' ? 'table-danger':''?>">
                            <td>
                                <?=$pagina_select == 1 ? $index + 1 : (($pagina_select * $limit_select) - ($limit_select - ($index + 1)))?>
                            </td>
                            <td>
                                <?=$curso->nombre?>
                            </td>
                            <td>
                                <?=$curso->area_tematica?>
                                <?php if(isset($curso->clave_area_tematica_otra) && $curso->clave_area_tematica_otra != ''): ?>
                                    <br>
                                    <?=$curso->clave_area_tematica_otra.' '.$curso->area_tematica_otra?>
                                <?php endif; ?>
                            </td>
                            <!--
                            <td class="text-justify">
                                <?=$curso->descripcion?>
                            </td>
                            <td class="text-justify"><?=$curso->objetivo?></td>
                            -->
                            <td class="text-justify">
                                <ul>
                                    <li class="mb-1">
                                        <span class="badge badge-primary">Objetivo:</span><br>
                                        <?=nl2br($curso->objetivo)?>
                                    </li>
                                    <li class="mb-1">
                                        <span class="badge badge-primary">Temario:</span><br>
                                        <?=nl2br($curso->temario)?>
                                    </li>
                                    <?php if(isset($curso->instructores_ctn) && is_array($curso->instructores_ctn) && sizeof($curso->instructores_ctn) != 0): ?>
                                        <li class="mb-1">
                                            <span class="badge badge-primary">Instructor(es)</span><br>
                                            <!--<?=nl2br($curso->instructor)?>-->
                                            <ol>
                                                <?php foreach ($curso->instructores_ctn as $i): ?>
                                                    <li><?=$i->abreviatura.' '.$i->nombre_completo?></li>
                                                <?php endforeach; ?>
                                            </ol>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <td class="text-left">
                                <ul>
                                    <li class="mb-1">
                                        <span class="badge badge-info badge-pill">Activas: <?=isset($curso->publicaciones_activas_finalizadas->activas) ? $curso->publicaciones_activas_finalizadas->activas : '0'?></span>
                                    </li>
                                    <li class="mb-1">
                                        <span class="badge badge-success badge-pill">Finalizadas: <?=isset($curso->publicaciones_activas_finalizadas->finalizadas) ? $curso->publicaciones_activas_finalizadas->finalizadas : '0'?></span>
                                    </li>
                                    <li class="mb-1">
                                        <span class="badge badge-danger badge-pill">Canceladas: <?=isset($curso->publicaciones_activas_finalizadas->canceladas) ? $curso->publicaciones_activas_finalizadas->canceladas : '0'?></span>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul class="text-left">
                                    <?php if(isset($curso->ctn_cancelado) && $curso->ctn_cancelado == 'no'): ?>
                                        <?php if(isset($usuario) && ($usuario->tipo_usuario == 'administrador') || $usuario->tipo_usuario == 'admin'): ?>
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-warning btn-sm btn-pill modificar_curso_civik text-white"
                                                        data-toggle="tooltip" data-id_curso_taller_norma="<?=$curso->id_curso_taller_norma?>"
                                                        title="Modificar Curso">
                                                    <i class="fa fa-pencil fa-white"></i> Editar
                                                </button>
                                            </li>
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-danger btn-sm btn-pill iniciar_cancelacion_curso"
                                                        data-id_curso_taller_norma="<?=$curso->id_curso_taller_norma?>"
                                                        data-toggle="tooltip" title="Cancelar curso">
                                                    <i class="fa fa-ban"></i> Cancelar
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <li class="mb-1">
                                            <div class="btn-group" role="group">
                                                <button id="btn_group_publicaciones" type="button" class="btn btn-info btn-pill btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-send"></i> Publicar
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btn_group_publicaciones">
                                                    <button type="button" class="dropdown-item publicar_curso_civik"
                                                            data-toggle="tooltip" data-id_curso_taller_norma="<?=$curso->id_curso_taller_norma?>"
                                                            title="Publicar curso">
                                                        Curso abierto
                                                    </button>
                                                    <button type="button" class="dropdown-item publicar_curso_masivo_civik"
                                                            data-toggle="tooltip" data-id_curso_taller_norma="<?=$curso->id_curso_taller_norma?>"
                                                            title="Publicar curso masivo para empresas">
                                                        Curso cerrado a empresa
                                                    </button>
                                                    <button type="button" class="dropdown-item publicar_evaluacion_online"
                                                            data-toggle="tooltip" data-id_curso_taller_norma="<?=$curso->id_curso_taller_norma?>"
                                                            title="Publicar evaluación">
                                                        Evaluación en línea
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    <?php else: ?>
                                        <li class="mb-1">
                                            <span class="badge badge-pill badge-danger">Curso cancelado</span>
                                        </li>
                                        <li class="mb-1">
                                            <label>Cuando: </label><span><?=fechaHoraBDToHTML($curso->fecha_cancelado)?></span>
                                        </li>
                                        <li class="mb-1">
                                            <span><?=$curso->descripcion_cancelacion?></span>
                                        </li>
                                    <?php endif; ?>
                                    <li class="mb-1">
                                        <div class="btn-group" role="group">
                                            <button id="btn_group_ver_publicaciones" type="button" class="btn btn-primary btn-pill btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-send"></i> Ver publicaciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btn_group_ver_publicaciones">
                                                <a href="<?=base_url().'AdministrarCTN/verPublicacionCtn/'.$curso->id_curso_taller_norma?>"
                                                   class="dropdown-item" data-toggle="tooltip" title="Ver publicaciones">
                                                    Curso abierto
                                                </a>
                                                <a href="<?=base_url().'AdministrarCTN/ver_publicacion_ctn_empresas/'.$curso->id_curso_taller_norma?>"
                                                   class="dropdown-item" data-toggle="tooltip" title="Ver publicaciones para empresas">
                                                    Curso a empresa
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Sin registro de cursos en el sistema</td>
                    </tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>