<div class="card">
    <div class="card-header">
        <label>Cursos STPS</label>
    </div>
    <div class="card-body">

        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'Alumnos/buscar_mis_publicaciones_ctn',
            'conteiner_resultados' => '#contenedor_resultados_publicaciones_todas',
            'form_busqueda' => 'form_buscar_publicaciones_todas',
            'id_paginacion' => uniqid(),
            'tipo_registro' => 'publicaciones'
        );
        $this->load->view('default/paginacion_tablero', $data_paginacion);
        ?>

        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                <tr>
                    <th width="28%" class="text-center">Nombre del curso</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Agente capacitador</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">
                        Evaluación y constancias
                    </th>
                    <th class="text-center">Operaciones</th>
                </tr>
                </thead>
                <?php if (isset($array_publicacion_ctn) && is_array($array_publicacion_ctn) && sizeof($array_publicacion_ctn) != 0): ?>
                    <?php foreach ($array_publicacion_ctn as $pc): ?>
                        <tr class="<?= isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'si' ? 'table-danger' : '' ?>">
                            <td class="text-justify">
                                <ul>
                                    <li>
                                        <span class="negrita">Nombre DC-3: </span><?= $pc->nombre_dc3 ?>
                                    </li>
                                    <li>
                                        <span class="negrita">Nombre comercial: </span><?= $pc->nombre_curso_comercial ?>
                                    </li>
                                    <li>
                                        <span class="badge badge-success"><?=$pc->tipo_publicacion?></span>
                                    </li>
                                </ul>
                            </td>
                            <td class="text-left">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Publicación: <?= fechaBDToHtml($pc->fecha_publicacion) ?></li>
                                    <li class="list-group-item">Inicio: <?= fechaBDToHtml($pc->fecha_inicio) ?></li>
                                    <li class="list-group-item">Fin: <?= fechaBDToHtml($pc->fecha_fin) ?></li>
                                </ul>
                            </td>
                            <td><?= $pc->agente_capacitador ?></td>
                            <td><?= $pc->direccion_imparticion ?></td>
                            <td class="text-center">
                                <?php if (isset($pc->aplica_evaluacion) && $pc->aplica_evaluacion == 'no'): ?>
                                    <li class="list_none mb-1"><span
                                                class="badge badge-light">Sin evaluación requerida</span></li>
                                    <?php
                                    $data['publicacion_ctn'] = $pc;
                                    $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_constancias', $data);
                                    ?>
                                <?php else: ?>
                                    <?php if($pc->id_catalogo_tipo_publicacion == CURSO_PRESENCIAL || $pc->id_catalogo_tipo_publicacion == CURSO_EMPRESA): ?>
                                        <?php
                                        $data['pc'] = $pc;
                                        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_evaluaciones',$data);
                                        ?>
                                    <?php elseif($pc->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE): ?>
                                        <ul class="list-group">
                                            <li class="list-group-item text-center">
                                                <p class="mt-1 mb-0">
                                                    <button type="button" class="btn btn-pill btn-sm btn-warning publicacion_ctn_vademecum"
                                                            data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>"
                                                            data-id_alumno_inscrito_ctn_publicado="<?=$pc->id_alumno_inscrito_ctn_publicado?>">
                                                        Vademecúm
                                                    </button>
                                                </p>
                                                <span class="help-span">Para continuar con la evaluación, descargue el Vademecum</span>
                                            </li>
                                        </ul>
                                        <?php if($pc->descargo_vademecum == 'si'): ?>
                                            <?php
                                                $data['pc'] = $pc;
                                                $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_evaluaciones',$data);
                                            ?>
                                        <?php endif; ?>
                                        <?php if (isset($pc->prueba_final) && is_object($pc->prueba_final)
                                                && $pc->prueba_final->publicacion_aprobada): ?>
                                            <ul class="list-group">
                                                <li class="list-group-item">

                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <ul class="text-left">
                                    <li class="mb-1">
                                        <button type="button"
                                                class="btn btn-secondary btn-sm btn-pill ver_detalle_publicacion_ctn"
                                                data-toggle="tooltip"
                                                data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>"
                                                title="Ver detalle publicación curso">
                                            <i class="fa fa-file fa-white"></i> Ver detalle
                                        </button>
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