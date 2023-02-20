<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card mb-3">
        <div class="card-header">
            <label>Curso</label>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <?= $publicacion_ctn->nombre_curso_comercial ?>
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label>Fecha de impartición:</label>
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?= fechaBDToHtml($publicacion_ctn->fecha_inicio) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="seccion_resutados_alumnos_registrados">
        <div class="card-header">
            <label>Registro de alumnos</label>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-8 col-md-8 col-sm-12 col-12 text-left">
                    <form id="form_buscar_registro_alumnos">
                        <div class="row">

                            <input type="hidden" name="id_publicacion_ctn"
                                   value="<?= $publicacion_ctn->id_publicacion_ctn ?>">

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                                <input id="nombre" type="text" class="form-control input_buscar_change"
                                       data-btn_buscar="#btn_buscar_registro_alumno_publicacion"
                                       name="nombre" placeholder="Nombre del alumno">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                                <input id="apellido_paterno" type="text" class="form-control input_buscar_change"
                                       data-btn_buscar="#btn_buscar_registro_alumno_publicacion"
                                       name="apellido_paterno" placeholder="Apellido paterno">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                <button type="button" id="btn_buscar_registro_alumno_publicacion"
                                        class="btn btn-success btn-sm btn-pill buscar_comun_civik noview"
                                        data-id_form="form_buscar_registro_alumnos"
                                        data-conteiner_resultados="#container_resultados_registro_alumnos"
                                        data-url_peticion="<?= base_url() . 'AdministrarCTN/buscar_registro_alumnos_publicacion_ctn' ?>">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12 text-right">
                    <ul>
                        <li class="mb-1">
                            <button type="button"
                                    class="btn btn-secondary btn-sm btn-pill registrar_nuevo_alumno_curso_publicado_presencial"
                                    data-id_publicacion_ctn="<?= $publicacion_ctn->id_publicacion_ctn ?>">
                                <i class="fa fa-user"></i> Registrar nuevo alumno
                            </button>
                        </li>
                        <li class="mb-1">
                            <div class="btn-group" role="group">
                                <button id="btn_group_lista_asistencia" type="button"
                                        class="btn btn-primary btn-pill btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-excel-o"></i> Lista de asistencia
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btn_group_lista_asistencia">
                                    <?php foreach ($instructores_asignados as $ia): ?>
                                        <a href="<?= base_url() . 'DocumentosEXCEL/Lista_Asistencia/' . $publicacion_ctn->id_publicacion_ctn . '/' . $ia->id_instructor_asignado_curso_publicado ?>"
                                           class="dropdown-item">Instructor: <?= $ia->nombre ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>

                        <li class="mb-1">
                            <div class="btn-group" role="group">
                                <button id="btn_group_constancias_instructor" type="button"
                                        class="btn btn-warning text-white btn-pill btn-sm dropdown-toggle"
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

                        <li class="">
                            <div class="btn-group" role="group">
                                <button id="btn_group_constancias" type="button"
                                        class="btn btn-success btn-pill btn-sm dropdown-toggle"
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
                                    <?php if (isset($publicacion_ctn->aplica_dc3) && $publicacion_ctn->aplica_dc3): ?>
                                        <a href="<?= base_url() . 'DocumentosPDF/cons_dc3_sin_firma/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                           class="dropdown-item" target="_blank">
                                            Constancias DC-3 Sin Firma
                                        </a>
                                    <?php endif; ?>
                                    <?php if (isset($publicacion_ctn->aplica_fdh) && $publicacion_ctn->aplica_fdh): ?>
                                        <a href="<?= base_url() . 'DocumentosPDF/constancia_fdh_alumno/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                           class="dropdown-item" target="_blank">
                                            Constancias FDH
                                        </a>
                                    <?php endif; ?>
                                    <?php if (isset($publicacion_ctn->aplica_fdh) && $publicacion_ctn->aplica_fdh): ?>
                                        <a href="<?= base_url() . 'DocumentosPDF/constancia_fdh_alumno_sin_sello/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                           class="dropdown-item" target="_blank">
                                            Constancias FDH Sin Sello
                                        </a>
                                    <?php endif; ?>
                                    <?php if (isset($publicacion_ctn->aplica_habilidades) && $publicacion_ctn->aplica_habilidades): ?>
                                        <a href="<?= base_url() . 'DocumentosPDF/cons_habilidades/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                           class="dropdown-item" target="_blank">
                                            Constancias Habilidades
                                        </a>
                                    <?php endif; ?>
                                     <?php if (isset($publicacion_ctn->aplica_habilidades) && $publicacion_ctn->aplica_habilidades): ?>
                                        <a href="<?= base_url() . 'DocumentosPDF/cons_habilidades_sin_sello/' . $publicacion_ctn->id_publicacion_ctn ?>"
                                           class="dropdown-item" target="_blank">
                                            Constancias Habilidades Sin Sello
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
                    </ul>
                </div>

            </div>

            <div id="container_resultados_registro_alumnos"></div>

        </div>
    </div>

    <div id="container_registro_alumno_nuevo_ctn_publicado" style="display: none">
        <?php $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/registro_nuevo_alumno_ctn_publicado'); ?>
    </div>
</div>


<!-- conteiners para las peticiones de las operaciones -->
<div id="container_registro_alumnos_publicacion"></div>
<div id="container_confirmacion_modal_publicacion_curso"></div>
<div id="conteiner_publicar_curso"></div>
<div id="conteiner_publicar_curso_masivo"></div>
<div id="container_publicacion_galeria_ctn"></div>
<div id="conteiner_encuesta_satisfacion"></div>
<div id="container_antologia_ctn"></div>
<div id="contenedor_subir_archivos_material"></div>
<div id="contenedor_resultados_evaluacion"></div>
<div id="contenedor_evaluacion_cursos"></div>


<?php $this->load->view('default/footer') ?>