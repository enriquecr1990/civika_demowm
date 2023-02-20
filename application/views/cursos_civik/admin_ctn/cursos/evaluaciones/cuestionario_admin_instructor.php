<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Evaluación <?=$tipo_evaluacion?></label>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label>Nombre DC-3: </label>
                </div>
                <div class="form-group col-lg-9 col-md-6 col-sm-12">
                    <span><?=$curso_taller_norma->nombre?></span>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label>Nombre comercial: </label>
                </div>
                <div class="form-group col-lg-9 col-md-6 col-sm-12">
                    <span><?=$publicacion_ctn->nombre_curso_comercial?></span>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label>Fecha de impartición: </label>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <span><?=fechaBDToHtml($publicacion_ctn->fecha_inicio)?></span>
                </div>

                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label>Fecha de finalización: </label>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <span><?=fechaBDToHtml($publicacion_ctn->fecha_fin)?></span>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="button" id="btn_buscar_preguntas_evaluacion"
                            class="btn btn-success btn-sm btn-pill buscar_comun_civik noview"
                            data-id_form="form_buscar_cursos"
                            data-conteiner_resultados="#contenedor_resultados_preguntas_evaluacion_ctn"
                            data-url_peticion="<?=base_url().'Instructores/buscar_preguntas_evaluacion_publicacion_ctn/'.$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>">
                        Buscar
                    </button>
                    <a href="<?=base_url()?>DocumentosPDF/evaluacion/<?=$evaluacion_publicacion_ctn->id_publicacion_ctn.'/'.$tipo_evaluacion?>"
                       target="_blank" class="btn btn-danger btn-sm btn-pill">
                        <i class="fa fa-file-pdf-o"></i> Ver en PDF
                    </a>
                    <?php if(isset($evaluacion_publicacion_ctn->disponible_alumnos) && $evaluacion_publicacion_ctn->disponible_alumnos == 'no'): ?>
                        <button class="btn btn-success btn-pill btn-sm evaluacion_publicacion_ctn_agregar_pregunta btn_agregar_pregunta_evaluacion_publicacion_evaluacion" id="btn_agregar_pregunta_evaluacion"
                                data-id_evaluacion_publicacion_ctn="<?=$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>">
                            <i class="fa fa-plus-circle"></i> Agregar pregunta
                        </button>
                        <button class="btn btn-info btn-pill btn-sm publicar_evaluacion_publicacion_ctn btn_agregar_pregunta_evaluacion_publicacion_evaluacion" id="btn_publicar_evaluacion"
                                data-url_operacion="<?=base_url().'Instructores/publicar_evaluacion/'.$evaluacion_publicacion_ctn->id_evaluacion_publicacion_ctn?>"
                                data-msg_operacion="Se publicará la evaluación y estará disponible para los alumnos <label>¿deseá continuar?</label>"
                                data-btn_trigger="#btn_buscar_preguntas_evaluacion" data-remove_html=".btn_agregar_pregunta_evaluacion_publicacion_evaluacion">
                            <i class="fa fa-check"></i> Publicar evaluación
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="contenedor_resultados_preguntas_evaluacion_ctn"></div>

    <div class="row row_form">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-left">
            <a href="<?=base_url()?>AdministrarCTN/ver_publicaciones_ctn?tipo_publicacion=<?=CURSO_EVALUACION_ONLINE?>" class="btn btn-success btn-sm">Regresar</a>
        </div>
    </div>

</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="container_agregar_modificar_pregunta"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>