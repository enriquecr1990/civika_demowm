<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Criterios de búsqueda</label>
        </div>
        <div class="card-body">
            <form id="form_buscar_usuarios">
                <div class="row">

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_nombre" class="col-form-label">Nombre</label>
                        <input id="input_buscar_nombre" class="form-control input_buscar"
                               data-btn-buscar=".buscar_usuarios_sistema"
                               placeholder="Nombre" name="nombre">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_apellido_p" class="col-form-label">Apellido paterno</label>
                        <input id="input_buscar_apellido_p" class="form-control input_buscar"
                               data-btn-buscar=".buscar_usuarios_sistema"
                               placeholder="Apellido paterno" name="apellido_p">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_apellido_m" class="col-form-label">Correo</label>
                        <input id="input_buscar_apellido_m" class="form-control input_buscar"
                               data-btn-buscar=".buscar_usuarios_sistema"
                               placeholder="Correo electrónico" name="correo">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="select_buscar_tipo_usuario" class="col-form-label">Tipo de usuario</label>
                        <select id="select_buscar_tipo_usuario" class="custom-select d-block input_buscar"
                                data-btn-buscar=".buscar_usuarios_sistema" name="tipo_usuario">
                            <option value="">Todos</option>
                            <?php foreach ($tipo_usuario as $tu): ?>
                                <option value="<?=$tu['value']?>"><?=$tu['label']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row noview">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                        <button type="button" class=" btn btn-success btn-pill btn-sm buscar_usuarios_sistema">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="contenedor_resultados_usuarios_sistema"></div>

</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_usuario_admin"></div>
<div id="conteiner_agregar_modificar_experiencia_curricular"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>