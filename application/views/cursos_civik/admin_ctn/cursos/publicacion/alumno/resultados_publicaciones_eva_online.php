<div class="card">
    <div class="card-header">
        <label>Evaluaciones Online</label>
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
                    <th width="28%" class="text-center">Denominación</th>
                    <th class="text-center">
                        Contenido
                    </th>
                    <th class="text-center">Evaluaciones</th>
                    <th class="text-center">Carpeta de evidencias</th>
                    <th class="text-center">Constancias</th>
                </tr>
                </thead>
                <?php if (isset($array_publicacion_ctn) && is_array($array_publicacion_ctn) && sizeof($array_publicacion_ctn) != 0): ?>
                    <?php foreach ($array_publicacion_ctn as $pc): ?>
                        <tr class="<?= isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'si' ? 'table-danger' : '' ?>">
                            <td class="text-justify" <?=$pc->id_catalogo_proceso_inscripcion != PROCESO_PAGO_FINALIZADO_INSCRITO || $pc->asistio_alumno != 'si' ? 'colspan="5"':''?>>
                                <ul>
                                    <li><span class="negrita"><?= $pc->nombre_curso_comercial ?></span></li>
                                    <li><span class="negrita">Fecha de inicio:</span> <?= fechaBDToHtml($pc->fecha_inicio) ?></li>
                                    <li><span class="negrita">Fecha de fin:</span> <?= fechaBDToHtml($pc->fecha_fin) ?></li>
                                    <li>
                                        <button type="button"
                                                class="btn btn-secondary btn-sm btn-pill ver_detalle_publicacion_ctn"
                                                data-toggle="tooltip"
                                                data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>"
                                                title="Ver detalle publicación curso">
                                            <i class="fa fa-file fa-white"></i> Ver detalle del curso
                                        </button>
                                    </li>
                                    <?php if($pc->id_catalogo_proceso_inscripcion != PROCESO_PAGO_FINALIZADO_INSCRITO || $pc->asistio_alumno != 'si'): ?>
                                        <li><span class="badge badge-danger">Pago en validación</span></li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                            <?php if($pc->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO && $pc->asistio_alumno == 'si'): ?>
                                <td class="text-center">
                                    <ul>
                                        <li>
                                            <p class="mt-1 mb-0">
                                                <button type="button" class="btn btn-pill btn-info publicacion_ctn_vademecum"
                                                        data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>"
                                                        data-id_alumno_inscrito_ctn_publicado="<?=$pc->id_alumno_inscrito_ctn_publicado?>">
                                                    <i class="fa fa-download"></i> Descargar material
                                                </button>
                                            </p>
                                            <!--<span class="help-span">Para continuar con la evaluación, descargue el Vademecum</span>-->
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <?php if($pc->descargo_vademecum == 'si'): ?>
                                        <?php
                                        $data['pc'] = $pc;
                                        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_evaluaciones',$data);
                                        ?>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Descargue el material de apoyo </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-pill btn-success publicacion_eva_subir_material"
                                            data-lectura="1"
                                            data-id_alumno_inscrito_ctn_publicado="<?=$pc->id_alumno_inscrito_ctn_publicado?>">
                                        <i class="fa fa-upload"></i> Subir evidencias
                                    </button>
                                </td>
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

 
                                            <?php if (isset($pc->prueba_final) && is_object($pc->prueba_final)
                                                && $pc->prueba_final->publicacion_aprobada): ?>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <?php
                                                        $data['publicacion_ctn'] = $pc;
                                                        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_constancias', $data);
                                                        ?>
                                                    </li>
                                                </ul>
                                            <?php else: ?>
                                                <span class="badge badge-danger">No cuenta con evaluación aprobada</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
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