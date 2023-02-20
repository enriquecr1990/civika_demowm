<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_publicaciones_todas">

                <input type="hidden" name="evaluacion_online" value="<?=isset($evaluacion_online) && $evaluacion_online === true ? '1':'2'?>">
                <?php if(isset($id_publicacion_ctn) && $id_publicacion_ctn !== false): ?>
                    <input type="hidden" name="id_publicacion_ctn" value="<?=$id_publicacion_ctn?>">
                <?php endif; ?>

                <div class="row">
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

                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <button type="button" id="btn_buscar_publicaciones_curso"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_publicaciones_todas"
                                data-conteiner_resultados="#contenedor_resultados_publicaciones_todas"
                                data-url_peticion="<?=base_url().'Alumnos/buscar_mis_publicaciones_ctn'?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_publicaciones_todas"></div>

</div>

<!-- divs de container -->
<div id="conteiner_publicar_curso"></div>
<div id="contenedor_resultados_evaluacion"></div>
<div id="contenedor_archivos_vademecum"></div>
<div id="contenedor_subir_archivos_material"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>