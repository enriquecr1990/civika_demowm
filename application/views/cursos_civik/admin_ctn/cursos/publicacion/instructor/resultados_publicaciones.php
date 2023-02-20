<div class="card">
    <div class="card-header">
        <label>Publicaciones</label>
    </div>
    <div class="card-body">

        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'Instructores/buscar_mis_publicaciones_ctn',
            'conteiner_resultados' => '#contenedor_resultados_publicaciones_todas',
            'form_busqueda' => 'form_buscar_publicaciones_todas',
            'id_paginacion' => uniqid(),
            'tipo_registro' => 'publicaciones'
        );
        $this->load->view('default/paginacion_tablero',$data_paginacion);
        ?>

        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                <tr>
                    <th width="30%" class="text-center">Nombre del curso</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Agente capacitador</th>
                    <th width="15%" class="text-center">Dirección</th>
                    <!--<th class="text-center">Precio</th>-->
                    <th width="18%" class="text-center">Operaciones</th>
                </tr>
                </thead>
                <?php if(isset($array_publicacion_ctn) && is_array($array_publicacion_ctn) && sizeof($array_publicacion_ctn) != 0): ?>
                    <?php foreach ($array_publicacion_ctn as $pc): ?>
                        <tr class="<?=isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'si' ? 'table-danger':''?>">
                            <td class="text-justify">
                                <ul>
                                    <li>
                                        <span class="negrita">Nombre DC-3: </span><?=$pc->nombre_dc3?>
                                    </li>
                                    <li>
                                        <span class="negrita">Nombre comercial: </span><?=$pc->nombre_curso_comercial?>
                                    </li>
                                    <?php if(isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'si'): ?>
                                        <li>
                                            <span class="badge badge-danger">Publicación cancelada</span>
                                        </li>
                                        <li>
                                            <label>Cuando:</label>
                                            <span><?=fechaBDToHtml($pc->fecha_eliminada)?></span>
                                        </li>
                                        <li>
                                            <span><?=$pc->detalle_eliminacion?></span>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                        <span class="badge badge-<?=isset($pc->publicacion_finalizada) && $pc->publicacion_finalizada ? 'primary':'success'?>">
                                            Publicación <?=isset($pc->publicacion_finalizada) && $pc->publicacion_finalizada ? 'finalizada':'vigente'?>
                                        </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <td class="text-left">
                                <ul class="list-group">
                                    <li class="list-group-item">Publicación: <?=fechaBDToHtml($pc->fecha_publicacion)?></li>
                                    <li class="list-group-item">Inicio: <?=fechaBDToHtml($pc->fecha_inicio)?></li>
                                    <li class="list-group-item">Fin: <?=fechaBDToHtml($pc->fecha_fin)?></li>
                                    <li class="list-group-item">Límite inscripción: <?=fechaBDToHtml($pc->fecha_limite_inscripcion)?></li>
                                </ul>
                            </td>
                            <td><?=$pc->agente_capacitador?></td>
                            <td><?=$pc->direccion_imparticion?></td>
                            <!--
                            <td>
                                <p>
                                    <span>Precio normal:</span> <span>$<?=number_format($pc->costo_en_tiempo,2)?></span>
                                </p>
                                <p>
                                    <span>Despues del <?=fechaBDToHtml($pc->fecha_limite_inscripcion)?></span> <span>$<?=number_format($pc->costo_extemporaneo,2)?></span>
                                </p>
                            </td>
                            -->
                            <td>
                                <ul class="text-left">
                                    <li class="mb-1">
                                        <button type="button" class="btn btn-secondary btn-sm btn-pill ver_detalle_publicacion_ctn"
                                                data-toggle="tooltip" data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>"
                                                title="Ver detalle publicación curso">
                                            <i class="fa fa-file fa-white"></i> Ver detalle
                                        </button>
                                    </li>
                                    <?php if(isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'no'): ?>
                                        <li class="mb-1">
                                            <button type="button" class="btn btn-info btn-sm btn-pill registro_alumnos_publiacion_ctn_instructor" data-toggle="tooltip"
                                                    title="Ver alumnos" data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>">
                                                <i class="fa fa-users"></i> Ver alumnos
                                            </button>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(isset($pc->aplica_evaluacion) && $pc->aplica_evaluacion == 'si'): ?>
                                        <li class="mb-1">
                                            <a class="btn btn-warning btn-sm btn-pill text-white" data-toggle="tooltip" href="<?=base_url()?>Instructores/evaluacion_diagnostica/<?=$pc->id_publicacion_ctn?>"
                                               title="Ver examen" data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>">
                                                <i class="fa fa-file-text-o "></i> Ver evaluación diagnóstica
                                            </a>
                                        </li>
                                        <li class="mb-1">
                                            <a class="btn btn-warning btn-sm btn-pill text-white" data-toggle="tooltip" href="<?=base_url()?>Instructores/evaluacion_final/<?=$pc->id_publicacion_ctn?>"
                                               title="Ver examen" data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>">
                                                <i class="fa fa-file-text-o "></i> Ver evaluación diagnóstica
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <ul class="text-left">
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Inscritos:</div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-info"><?=$pc->alumnos_inscritos?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Asistierón:</div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-success"><?=$pc->alumnos_asistencia?></span>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Sin publicaciones registradas</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>