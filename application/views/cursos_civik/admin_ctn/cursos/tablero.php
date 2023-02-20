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

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_nombre" class="col-form-label">Nombre del curso</label>
                        <input id="input_buscar_nombre" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_cursos"
                               placeholder="Nombre" name="nombre">
                        <span class="help-span">El que aparece en la DC-3</span>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="nombre_dc3" class="col-form-label">Descripción del curso</label>
                        <input id="nombre_dc3" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_cursos"
                               placeholder="Nombre" name="descripcion">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                        <label for="select_curso_cancelado" class="col-form-label">Curso cancelado</label>
                        <select id="select_curso_cancelado" class="custom-select input_buscar_change"
                                data-btn_buscar="#btn_buscar_cursos" name="ctn_cancelado">
                            <option value="no" selected="selected">No</option>
                            <option value="si">Si</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                        <button type="button" id="btn_buscar_cursos"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik"
                                data-id_form="form_buscar_cursos"
                                data-conteiner_resultados="#contenedor_resultados_cursos"
                                data-url_peticion="<?=base_url().'AdministrarCTN/buscarCursos'?>">
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div id="contenedor_resultados_cursos"></div>

</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_curso"></div>
<div id="conteiner_publicar_curso"></div>
<div id="conteiner_publicar_curso_masivo"></div>
<div id="conteiner_confirmacion_modal_cursos"></div>
<div id="conteiner_enviar_informacion_empresa_curso"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>