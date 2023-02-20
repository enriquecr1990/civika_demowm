<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Administración de Estaciones de servicio</div>
        <div class="panel-body">

            <div class="panel panel-default">
                <div class="panel-heading">Búsqueda de Estaciones de servicio</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_buscar_estacion_servicio">
                        <div class="form-group">
                            <div class="col-sm-3"><input class="form-control" placeholder="Nombre de la estación" name="es_nombre"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="RFC de la estación" name="es_rfc"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Domicilio de la estación" name="es_domicilio"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Telefóno de la estación" name="es_telefono"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3"><input class="form-control" placeholder="Correo de la estación" name="es_correo"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Representante legal de la estación" name="es_representante"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control datepicker" placeholder="Fecha registro de la estación" name="es_fecha_registro">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control datepicker" placeholder="Fecha actualización de la estación" name="es_fecha_actualizacion">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: right">
                                <button type="button" class=" btn btn-success btn-sm buscar_estaciones_servicio"><span class="glyphicon glyphicon-search"></span>Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Estaciones de servicio</div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: right">
                            <button class="btn btn-info btn-sm agregar_estacion_servicio" data-backdrop="static">
                                <span class="glyphicon glyphicon-plus"></span>Nueva Estación Servicio
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-12" id="contenedor_resultados_estacion_servicio">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_es"></div>
<div id="conteiner_registro_empleados_es"></div>
<div id="conteiner_registro_normas_es"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>