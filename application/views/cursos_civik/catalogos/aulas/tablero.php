<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Catalogo de aulas</label>
        </div>
        <div class="card-body">
            <form>
            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                    <button type="button" id="btn_buscar_aulas"
                            class="noview buscar_comun_civik" data-id_form=""
                            data-conteiner_resultados="#conteiner_resultados_aulas"
                            data-url_peticion="<?=base_url().'AdministrarCatalogos/aulas_resultados'?>">
                        Buscar
                    </button>
                </div>
            </div>
            </form>
            <div id="conteiner_resultados_aulas">
                <?php $this->load->view('cursos_civik/catalogos/aulas/resultados_busqueda'); ?>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_aula"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>