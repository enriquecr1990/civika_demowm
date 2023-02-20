<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <?php $this->load->view('cursos_civik/admin_ctn/cursos/detalle_curso'); ?>

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_publicaciones">

                <input type="hidden" name="id_curso_taller_norma" value="<?=$curso_taller_norma->id_curso_taller_norma?>">

                <input type="hidden" name="id_catalogo_tipo_publicacion" value="<?=CURSO_EMPRESA?>">

                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="nombre_curso_comercial" class="col-form-label">Nombre comercial</label>
                        <input id="nombre_curso_comercial" type="text" class="form-control"
                               name="nombre_curso_comercial" placeholder="Nombre comercial del curso">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="agente_capacitador" class="col-form-label">Agente capacitador</label>
                        <input id="agente_capacitador" type="text" class="form-control"
                               name="agente_capacitador" placeholder="Nombre del agente capacitador">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">Fecha de impartición</label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="input_fecha_inicio" class="form-control datepicker_shards"
                                   name="fecha_inicio" placeholder="Fecha de impartición del curso">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <button type="button" id="btn_buscar_publicaciones_curso"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_publicaciones"
                                data-conteiner_resultados="#contenedor_resultados_publicaciones"
                                data-url_peticion="<?=base_url().'AdministrarCTN/buscar_publicaciones_curso/'.$curso_taller_norma->id_curso_taller_norma?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_publicaciones"></div>

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
<div id="container_antologia_ctn"></div>


<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>