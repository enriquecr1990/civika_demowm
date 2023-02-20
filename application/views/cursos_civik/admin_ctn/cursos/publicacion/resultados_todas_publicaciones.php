<div class="card">
    <div class="card-header">
        <label>Publicaciones</label>
    </div>
    <div class="card-body">

        <!-- paginacion -->
        <?php
        $data_paginacion = array(
            'url_paginacion' => 'AdministrarCTN/buscar_todas_publicacion_ctn',
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
                    <th width="30%" class="text-center">Nombre del curso</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Agente capacitador</th>
                    <th width="15%" class="text-center">Dirección</th>
                    <th class="text-center">Precio</th>
                    <th width="18%" class="text-center">Operaciones</th>
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
                                    <?php if (isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'si'): ?>
                                        <li>
                                            <span class="badge badge-danger">Publicación cancelada</span>
                                        </li>
                                        <li>
                                            <label>Cuando:</label>
                                            <span><?= fechaBDToHtml($pc->fecha_eliminada) ?></span>
                                        </li>
                                        <li>
                                            <span><?= $pc->detalle_eliminacion ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <span class="badge badge-<?= isset($pc->publicacion_finalizada) && $pc->publicacion_finalizada ? 'primary' : 'success' ?>">
                                                Publicación <?= isset($pc->publicacion_finalizada) && $pc->publicacion_finalizada ? 'finalizada' : 'vigente' ?>
                                            </span>
                                        </li>
                                        <?php if ($pc->id_catalogo_tipo_publicacion == CURSO_PRESENCIAL && isset($pc->publicacion_finalizada) && !$pc->publicacion_finalizada): ?>
                                            <li>
                                                <p id="url_copiar_<?= $pc->id_publicacion_ctn ?>"
                                                   class="noview"><?= base_url() . '?id_publicacion_ctn=' . $pc->id_publicacion_ctn ?></p>
                                                <button type="button" class="btn btn-sm btn-primary btn_copiar_link"
                                                        data-url_to_copy="#url_copiar_<?= $pc->id_publicacion_ctn ?>"><i
                                                            class="fa fa-copy"></i> Copiar link
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (isset($pc->evaluacion_diagnostica_disponible)): ?>
                                            <li class="mt-1">
                                                <span class="badge badge-<?= $pc->evaluacion_diagnostica_disponible ? 'success' : 'danger' ?>">Evaluación diagnóstica <?= $pc->evaluacion_diagnostica_disponible ? 'disponible' : 'en creación' ?></span>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (isset($pc->evaluacion_final_disponible)): ?>
                                            <li class="mt-1">
                                                <span class="badge badge-<?= $pc->evaluacion_final_disponible ? 'info' : 'danger' ?>">Evaluación final <?= $pc->evaluacion_final_disponible ? 'disponible' : 'en creación' ?></span>
                                                <?php if($pc->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE): ?>
                                                    <p class="mt-1">
                                                        <button type="button"
                                                                class="btn btn-sm btn-pill btn-outline-success publicar_link_evaluacion"
                                                                data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>">
                                                            Publicar link de evaluación
                                                        </button>
                                                    </p>
                                                    <p class="mt-1">
                                                        <a href="<?= base_url() ?>?id_publicacion_ctn=<?= $pc->id_publicacion_ctn ?>&tipo_pubicacion=4"
                                                           target="_blank">
                                                            <?= base_url() ?>?id_publicacion_ctn=<?= $pc->id_publicacion_ctn ?>&tipo_pubicacion=4
                                                        </a>
                                                    </p>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>

                            </td>
                            <td class="text-left">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        Publicación: <?= fechaBDToHtml($pc->fecha_publicacion) ?></li>
                                    <li class="list-group-item">Inicio: <?= fechaBDToHtml($pc->fecha_inicio) ?></li>
                                    <li class="list-group-item">Fin: <?= fechaBDToHtml($pc->fecha_fin) ?></li>
                                    <li class="list-group-item">Límite
                                        inscripción: <?= fechaBDToHtml($pc->fecha_limite_inscripcion) ?></li>
                                </ul>
                            </td>
                            <td><?= $pc->agente_capacitador ?></td>
                            <td><?= $pc->direccion_imparticion ?></td>
                            <td>
                                <p>
                                    <span>Precio normal:</span>
                                    <span>$<?= number_format($pc->costo_en_tiempo, 2) ?></span>
                                </p>
                                <p>
                                    <span>Despues del <?= fechaBDToHtml($pc->fecha_limite_inscripcion) ?></span>
                                    <span>$<?= number_format($pc->costo_extemporaneo, 2) ?></span>
                                </p>
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
                                    <?php if (isset($pc->publicacion_eliminada) && $pc->publicacion_eliminada == 'no'): ?>
                                        <?php if (isset($usuario) && ($usuario->tipo_usuario == 'administrador') || $usuario->tipo_usuario == 'admin'): ?>
                                            <li class="mb-1">
                                                <?php $class_modificar_publicacion = 'modificar_publicacion_curso_civik';
                                                if ($pc->id_catalogo_tipo_publicacion == CURSO_EMPRESA) $class_modificar_publicacion = 'modificar_publicacion_curso_masivo_civik';
                                                if ($pc->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE) $class_modificar_publicacion = 'modificar_publicacion_evaluacion_online';
                                                ?>
                                                <button type="button"
                                                        class="btn btn-warning btn-sm btn-pill <?= $class_modificar_publicacion ?> text-white"
                                                        data-toggle="tooltip"
                                                        data-id_curso_taller_norma="<?= $pc->id_curso_taller_norma ?>"
                                                        data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>"
                                                        title="Modificar publicación curso">
                                                    <i class="fa fa-pencil fa-white"></i> Editar
                                                </button>
                                            </li>
                                            <li class="mb-1">
                                                <button type="button"
                                                        class="btn btn-danger btn-sm btn-pill iniciar_cancelacion_publicacion_curso"
                                                        data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>"
                                                        data-toggle="tooltip" title="Cancelar publicación curso">
                                                    <i class="fa fa-ban"></i> Cancelar
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                        <li class="mb-1">
                                            <!--<button type="button"
                                                    class="btn btn-info btn-sm btn-pill registro_alumnos_publiacion_ctn"
                                                    data-toggle="tooltip"
                                                    title="Ver alumnos"
                                                    data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>">
                                                <i class="fa fa-users"></i> Ver alumnos
                                            </button>-->
                                            <a href="<?= base_url() ?>AdministrarCTN/registro_alumnos_pub_ctn/<?= $pc->id_publicacion_ctn ?>"
                                               class="btn btn-info btn-sm btn-pill">
                                                <i class="fa fa-users"></i> Ver alumnos
                                            </a>
                                        </li>
                                        <?php if (isset($pc->aplica_evaluacion) && $pc->aplica_evaluacion == 'si'): ?>
                                            <li class="mb-1">
                                                <div class="btn-group" role="group">
                                                    <button id="btn_group_evaluaciones" type="button"
                                                            class="btn btn-primary btn-pill btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="fa fa-file-text"></i> Evaluación
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btn_group_evaluaciones">
                                                        <a class="dropdown-item"
                                                           href="<?= base_url() ?>Instructores/evaluacion_diagnostica/<?= $pc->id_publicacion_ctn ?>">
                                                            Diagnóstica
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="<?= base_url() ?>Instructores/evaluacion_final/<?= $pc->id_publicacion_ctn ?>">
                                                            Final
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php endif; ?>

                                        <!-- primera prueba para la antologia -->
                                        <?php if (isset($pc->publicacion_empresa_masiva) && $pc->publicacion_empresa_masiva == 'si' || $pc->id_catalogo_tipo_publicacion == CURSO_EMPRESA): ?>
                                            <li class="mb-1">
                                                <button type="button" class="btn btn-dark btn-sm btn-pill antologia_ctn"
                                                        data-toggle="tooltip"
                                                        title="Ver alumnos"
                                                        data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>">
                                                    <i class="fa fa-book" aria-hidden="true"></i>
                                                    Antologia
                                                </button>
                                            </li>
                                        <?php endif; ?>


                                        <?php if ($pc->publicacion_finalizada && in_array($pc->id_catalogo_tipo_publicacion, array(CURSO_PRESENCIAL, CURSO_EVALUACION_ONLINE))): ?>
                                            <li class="mb-1">
                                                <button type="button"
                                                        class="btn btn-success btn-sm btn-pill iniciar_publicacion_galeria_imagenes"
                                                        data-toggle="tooltip"
                                                        title="Publicar galeria de fotos"
                                                        data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>">
                                                    <i class="fa fa-image"></i> Publicar galeria
                                                </button>
                                            </li>

                                            <!-- considerar dado que seria por el instructor -->
                                            <li class="mb-1">
                                                <div class="btn-group" role="group">
                                                    <button id="btn_group_constancias_instructor" type="button"
                                                            class="btn btn-warning text-white btn-pill btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="fa fa-file-pdf-o"></i> Encuestas satisfacción
                                                    </button>
                                                    <div class="dropdown-menu"
                                                         aria-labelledby="btn_group_constancias_instructor">
                                                        <?php foreach ($pc->instructores_asignados as $ia): ?>
                                                            <button type="button"
                                                                    data-id_instructor_asignado_ctn_publicado="<?= $ia->id_instructor_asignado_curso_publicado ?>"
                                                                    class="dropdown-item iniciar_encuesta_satisfaccion"><?= $ia->nombre . ' ' . $ia->apellido_p ?></button>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif; ?>

                                        <?php if (isset($pc->publicacion_empresa_masiva) && $pc->publicacion_empresa_masiva == 'si' || $pc->id_catalogo_tipo_publicacion == CURSO_EMPRESA): ?>
                                            <li class="mb-1">
                                                <a href="<?= base_url() ?>DocumentosPDF/carta_descriptiva_empresa/<?= $pc->id_publicacion_ctn ?>"
                                                   target="_blank" class="btn btn-success btn-pill btn-sm">
                                                    <i class="fa fa-file-pdf-o"></i> Carta descriptiva
                                                </a>
                                            </li>
                                            <li class="mb-1">
                                                <a href="<?= base_url() ?>DocumentosPDF/informe_final_empresa/<?= $pc->id_publicacion_ctn ?>"
                                                   target="_blank" class="btn btn-success btn-pill btn-sm">
                                                    <i class="fa fa-file-pdf-o"></i> Informe Final
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <!-- Parte para mostrar la antologia-->
                                        <?php if ($pc->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE): ?>
                                            <li class="mb-1">
                                                <button type="button"
                                                        class="btn btn-dark btn-sm btn-pill antologia_ctn"
                                                        data-toggle="tooltip"
                                                        title="Muestra la Antologia"
                                                        data-id_publicacion_ctn="<?= $pc->id_publicacion_ctn ?>">
                                                    <i class="fa fa-book" aria-hidden="true"></i>
                                                    Antologia
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                                <ul class="text-left">
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Registrados:
                                            </div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-secondary"><?= $pc->alumnos_registrados ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Registro datos:
                                            </div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-warning"><?= $pc->alumnos_actualizacion_datos ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Pago enviado:
                                            </div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-primary"><?= $pc->alumnos_recibo_enviado ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Pago observado:
                                            </div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-danger"><?= $pc->alumnos_pago_observado ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Inscritos:</div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-info"><?= $pc->alumnos_inscritos ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="form-group col-lg-7 col-md-6 col-sm-12 col-12">Asistierón:</div>
                                            <div class="form-group col-lg-5 col-sm-6 col-sm-12 col-12 text-left">
                                                <span class="badge badge-success"><?= $pc->alumnos_asistencia ?></span>
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