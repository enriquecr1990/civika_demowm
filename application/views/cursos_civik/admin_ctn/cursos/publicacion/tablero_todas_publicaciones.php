<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_publicaciones_todas">

                <div class="row row_form">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="nombre_dc3" class="col-form-label">Nombre de la DC-3</label>
                        <input id="nombre_dc3" type="text" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_publicaciones_curso"
                               name="nombre_dc3" placeholder="Nombre de la DC-3">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="nombre_curso_comercial" class="col-form-label">Nombre comercial</label>
                        <input id="nombre_curso_comercial" type="text" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_publicaciones_curso"
                               name="nombre_curso_comercial" placeholder="Nombre comercial del curso">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="agente_capacitador" class="col-form-label">Agente capacitador</label>
                        <input id="agente_capacitador" type="text" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_publicaciones_curso"
                               name="agente_capacitador" placeholder="Nombre del agente capacitador">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">Fecha de impartición</label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="input_fecha_inicio" class="form-control datepicker_shards input_buscar_change"
                                   data-btn_buscar="#btn_buscar_publicaciones_curso"
                                   name="fecha_inicio" placeholder="Fecha de impartición del curso">
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="agente_capacitador" class="col-form-label">Tipo de publicación</label>
                        <select class="custom-select input_buscar_change" name="id_catalogo_tipo_publicacion"
                                data-btn_buscar="#btn_buscar_publicaciones_curso">
                            <?php foreach ($catalogo_tipo_publicacion as $ctp): ?>
                                <option value="<?=$ctp->id_catalogo_tipo_publicacion?>" <?=isset($get['tipo_publicacion']) && $get['tipo_publicacion'] == $ctp->id_catalogo_tipo_publicacion ? 'selected="selected"':''?>> <?=$ctp->nombre?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <button type="button" id="btn_buscar_publicaciones_curso"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_publicaciones_todas"
                                data-conteiner_resultados="#contenedor_resultados_publicaciones_todas"
                                data-url_peticion="<?=base_url().'AdministrarCTN/buscar_todas_publicacion_ctn'?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_publicaciones_todas"></div>

    <br>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-left">
            <a class="btn btn-sm btn-pill btn-success" href="<?=base_url()?>AdministrarCTN/cursos">Regresar</a>
        </div>
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



<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>