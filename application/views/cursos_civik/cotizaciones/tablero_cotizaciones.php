<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_cotizaciones_todas">

                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="nombre_curso" class="col-form-label">Curso STPS</label>
                        <input id="nombre_curso" type="text" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_cotizaciones"
                               name="nombre_dc3" placeholder="Nombre de la DC-3">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="folio_cotizacion" class="col-form-label">Folio cotización</label>
                        <input id="folio_cotizacion" type="text" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_cotizaciones" value="<?=$folio_cotizacion?>"
                               name="folio_cotizacion" placeholder="Folio cotización">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">Fecha de cotización</label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="input_fecha_inicio" class="form-control datepicker_shards input_buscar_change"
                                   data-btn_buscar="#btn_buscar_cotizaciones"
                                   name="fecha_cotizacion" placeholder="Fecha de impartición del curso">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <button type="button" id="btn_buscar_cotizaciones"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_cotizaciones_todas"
                                data-conteiner_resultados="#contenedor_resultados_tablero"
                                data-url_peticion="<?=base_url().'Cotizaciones/buscar_cotizaciones'?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_tablero"></div>

</div>

<!-- divs de container -->
<div id="contenedor_agregar_modificar_cotizacion"></div>
<div id="conteiner_publicar_curso_masivo"></div>
<div id="conteiner_enviar_informacion_empresa_curso"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>