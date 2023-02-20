<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Catalogo de áreas temáticas</label>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="button" id="btn_buscar_areas_tematicas"
                            class="noview buscar_comun_civik" data-id_form=""
                            data-conteiner_resultados="#conteiner_resultados_area_tematica"
                            data-url_peticion="<?=base_url().'AdministrarCatalogos/area_tematica_resultados'?>">
                        Buscar
                    </button>
                </div>
            </div>
            </form>
            <div id="conteiner_resultados_area_tematica">
                <?php $this->load->view('cursos_civik/catalogos/area_tematica/resultados_busqueda'); ?>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_area_tematica"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>