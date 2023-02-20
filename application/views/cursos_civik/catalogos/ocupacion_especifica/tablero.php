<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Catalogo de ocupaciones específicas</label>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="button" id="btn_buscar_ocupaciones_especificas"
                            class="noview buscar_comun_civik" data-id_form=""
                            data-conteiner_resultados="#conteiner_resultados_ocupaciones_especificas"
                            data-url_peticion="<?=base_url().'AdministrarCatalogos/ocupaciones_especificas_resultados'?>">
                        Buscar
                    </button>

                    <button type="button" class="btn btn-pill btn-sm btn-primary agregar_ocupacion_especificia_area"
                            data-tipo_ocupacion_especifica="area">
                        Agregar área
                    </button>
                    <button type="button" class="btn btn-pill btn-sm btn-info agregar_ocupacion_especificia_subarea"
                            data-tipo_ocupacion_especifica="subarea">
                        Agregar subárea
                    </button>
                </div>
            </div>
            </form>
            <div id="conteiner_resultados_ocupaciones_especificas">
                <?php $this->load->view('cursos_civik/catalogos/ocupacion_especifica/resultados_busqueda'); ?>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_ocupacion_especifica"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>