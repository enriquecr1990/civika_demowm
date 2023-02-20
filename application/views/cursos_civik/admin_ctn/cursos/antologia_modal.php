<div class="modal fade show" role="dialog" id="modal_antologia_civika">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Antologia</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="col-form-label">Antes</label>
                        <ul>
                            <li class="mb-1">
                                <div class="btn">
                                    <a href="<?= base_url() ?>DocumentosPDF/carta_descriptiva_empresa/<?= $publicacion_ctn->id_publicacion_ctn ?>"
                                       target="_blank" class="btn btn-info btn-sm btn-pill mr-3">
                                        <i class="fa fa-file-pdf-o"></i> Carta descriptiva
                                    </a>
                                </div>
                            </li>
                            <li class="mb-1">
                                <div class="btn">
                                    <button id="btn_group_evaluaciones" type="button"
                                            class="btn btn-info btn-sm btn-pill mr-3 dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        <i class="fa fa-file-text"></i> Vademecum
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btn_group_evaluaciones">
                                        <?php foreach ($archivos_vademecum as $index => $av): ?>
                                            <a href="<?= $av->ruta_documento ?>" type="button" class="dropdown-item"
                                               data-toggle="tooltip" title="<?= $av->descripcion ?>"
                                               target="_blank"><?= $av->titulo ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                            <?php if (isset($publicacion_ctn->aplica_evaluacion) && $publicacion_ctn->aplica_evaluacion == 'si'): ?>
                                <li>
                                    <div class="btn">
                                        <button id="btn_group_evaluaciones" type="button"
                                                class="btn btn-info btn-sm btn-pill mr-3 dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fa fa-file-text"></i> Evaluación
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btn_group_evaluaciones">
                                            <a type="button" class="dropdown-item"
                                               target="_blank"
                                               href="<?= base_url() ?>DocumentosPDF/evaluacion/<?= $publicacion_ctn->id_publicacion_ctn ?>/diagnostica"
                                               data-toggle="tooltip">
                                                Diagnóstica
                                            </a>
                                            <a type="button" class="dropdown-item"
                                               target="_blank"
                                               href="<?= base_url() ?>DocumentosPDF/evaluacion/<?= $publicacion_ctn->id_publicacion_ctn ?>/final"
                                               data-toggle="tooltip">
                                                Final
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li>
                                <div class="btn">
                                    <button id="btn_group_constancias_instructor" type="button"
                                            class="btn btn-info text-white btn-pill btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-file-pdf-o"></i> Constancias instructor
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btn_group_constancias_instructor">
                                        <?php foreach ($instructores_asignados as $ia): ?>
                                            <a href="<?= base_url() . 'DocumentosPDF/constancia_instructor_publicacion_ctn/' . $publicacion_ctn->id_publicacion_ctn . '/' . $ia->id_instructor ?>"
                                               class="dropdown-item"
                                               target="_blank"><?= $ia->nombre . ' ' . $ia->apellido_p ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="btn">
                                    <button id="btn_group_constancias" type="button"
                                            class="btn btn-info btn-sm btn-pill mr-3 dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-file-pdf-o"></i> Constancias alumnos
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btn_group_constancias">
                                        <?php if (isset($publicacion_ctn->aplica_dc3) && $publicacion_ctn->aplica_dc3): ?>
                                            <a href="<?= base_url() . 'DocumentosPDF/cons_dc3/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                               class="dropdown-item" target="_blank">
                                                Constancias DC-3
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($publicacion_ctn->aplica_fdh) && $publicacion_ctn->aplica_fdh): ?>
                                            <a href="<?= base_url() . 'DocumentosPDF/constancia_fdh_alumno/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                               class="dropdown-item" target="_blank">
                                                Constancias FDH
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($publicacion_ctn->aplica_habilidades) && $publicacion_ctn->aplica_habilidades): ?>
                                            <a href="<?= base_url() . 'DocumentosPDF/cons_habilidades/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                               class="dropdown-item" target="_blank">
                                                Constancias Habilidades
                                            </a>
                                        <?php endif; ?>
                                        <?php if (isset($publicacion_ctn->aplica_otra) && $publicacion_ctn->aplica_otra): ?>
                                            <a href="<?= base_url() . 'DocumentosPDF/cons_cigede/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                               class="dropdown-item" data-toggle="tooltip"
                                               data-placement="left"
                                               title="<?= $publicacion_ctn->aplica_otra->especifique_otra_constancia ?>"
                                               target="_blank">
                                                Constancias Otra
                                            </a>
                                            <a href="<?= base_url() . 'DocumentosPDF/constancia_otra_blanco_todos/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                               class="dropdown-item" data-toggle="tooltip" data-placement="left"
                                               title="<?= $publicacion_ctn->aplica_otra->especifique_otra_constancia ?>"
                                               target="_blank">
                                                Constancias Otra blanco
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>


                            </li>
                            <li>
                                <div class="btn">
                                    <button id="btn_group_lista_asistencia" type="button"
                                            class="btn btn-info btn-sm btn-pill mr-3 dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-file-pdf-o"></i> Lista de asistencia
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btn_group_lista_asistencia">
                                        <?php foreach ($instructores_asignados as $ia): ?>
                                            <a href="<?= base_url() . 'DocumentosEXCEL/Lista_Asistencia/' . $publicacion_ctn->id_publicacion_ctn . '/' . $ia->id_instructor_asignado_curso_publicado ?>"
                                               class="dropdown-item">Instructor: <?= $ia->nombre ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-form-label">Despues</label>
                        <ul>
                            <li class="mb-1">
                                <div class="btn">
                                    <a href="<?= base_url() ?>DocumentosPDF/informe_final_empresa/<?= $publicacion_ctn->id_publicacion_ctn ?>"
                                       target="_blank" class="btn btn-success btn-pill btn-sm">
                                        <i class="fa fa-file-pdf-o"></i> Informe Final
                                    </a>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>