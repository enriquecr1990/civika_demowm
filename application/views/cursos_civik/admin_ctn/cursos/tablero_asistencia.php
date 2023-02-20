<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">

            <form id="form_buscar_cursos">

                <div class="row">

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">Fecha de </label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="input_fecha_inicio" class="form-control datepicker_shards input_buscar_change"
                                   data-btn_buscar="#btn_buscar_publicaciones_curso"
                                   name="fecha_inicio_de" placeholder="Fecha de inicio">
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">a </label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="input_fecha_inicio" class="form-control datepicker_shards input_buscar_change"
                                   data-btn_buscar="#btn_buscar_publicaciones_curso"
                                   name="fecha_inicio_a" placeholder="Fecha de fin">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                        <button type="button" id="btn_buscar_tabler_asistencia"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_cursos"
                                data-conteiner_resultados="#contenedor_resultados_cursos"
                                data-btn_trigger="#buscar_tablero_asistencia"
                                data-url_peticion="<?=base_url().'AdministrarCTN/buscar_tablero_asistencia'?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_cursos"></div>

</div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>