<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Configuración de salida del correo</label>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="button" id="btn_buscar_config_correo"
                            class="noview buscar_comun_civik" data-id_form=""
                            data-conteiner_resultados="#conteiner_resultados_config_correo"
                            data-url_peticion="<?=base_url().'ConfiguracionSistema/salida_correo_resultados'?>">
                        Buscar
                    </button>
                </div>
            </div>
            </form>
            <div id="conteiner_resultados_config_correo"></div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_config_correo"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>