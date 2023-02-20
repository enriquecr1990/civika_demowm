<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Bitacora de errores</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_bitacora_error">
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="input_fecha_inicio" class="col-form-label">Fecha </label>
                        <div class="input-group with-addon-icon-left">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input id="fecha" class="form-control datepicker_shards input_buscar_change"
                                   data-btn_buscar="#btn_buscar_bitacora_errores"
                                   name="fecha" placeholder="Fecha del error">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                        <button type="button" id="btn_buscar_bitacora_errores"
                                class="noview buscar_comun_civik" data-id_form="form_buscar_bitacora_error"
                                data-conteiner_resultados="#conteiner_resultados_bitacora_errores"
                                data-url_peticion="<?= base_url() . 'ConfiguracionSistema/bitacora_errores_resultados' ?>">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
            <div id="conteiner_resultados_bitacora_errores"></div>
        </div>
    </div>
</div>

<!-- modal del contenedor del contenido -->v
<div id="contenedor_modal_vista_bitacora_error"></div>


<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>