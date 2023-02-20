<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">

    <div class="panel panel-success">
        <div class="panel-heading">Administración de normas ASEA</div>
        <div class="panel-body">

            <div id="guardar_form_busqueda_normas_asea">

            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Búsqueda de normas</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_busqueda_normas_asea">
                        <div class="form-group">
                            <div class="col-sm-3"><input class="form-control" placeholder="Nombre" name="nombre"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Duración" name="duracion"></div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Instrucctor" name="instructor"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control datepicker" placeholder="Fecha inicio" name="fecha_inicio">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input class="form-control datepicker" placeholder="Fecha fin" name="fecha_fin">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                            <div class="col-sm-3"><input class="form-control" placeholder="Ocupación específica" name="ocupacion_especifica"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: left">
                                <a class="btn btn-info btn-xs" role="button" data-toggle="collapse" href="#form_busqueda_avanzada">Búsqueda avanzada</a>
                            </div>
                        </div>
                        <div class="collapse" id="form_busqueda_avanzada">
                            <div class="form-group">
                                <div class="col-sm-3"><input class="form-control" placeholder="Agente capacitador" name="agente_capacitador"></div>
                                <div class="col-sm-3"><input class="form-control" placeholder="Área temática" name="area_tematica"></div>
                                <div class="col-sm-3">
                                    <select class="form-control" name="anio">
                                        <option value="">Todos los años</option>
                                        <?php foreach ($catalogo_anios as $anio){ ?>
                                            <option value="<?=$anio?>"><?=$anio?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-sm-3"><input class="form-control" placeholder="Horario" name="horario"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: right">
                                <button type="button" class=" btn btn-success btn-sm buscar_normas_asea"><span class="glyphicon glyphicon-search"></span>Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Normas ASEA</div>
                <div class="panel-body">
                    <?php if((isset($usuario->es_administrador) && $usuario->es_administrador)
                        || (isset($usuario->es_admin) && $usuario->es_admin)): ?>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: right">
                                <button class="btn btn-info btn-sm agregar_norma_asea" data-backdrop="static">
                                    <span class="glyphicon glyphicon-plus"></span>Nueva norma
                                </button>
                            </div>
                        </div>
                        <br>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="col-sm-12" id="contenedor_resultados_normas_aseas">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_registrar_modificar_norma"></div>
<div id="conteiner_consultar_norma_actividad"></div>
<div id="conteiner_registrar_preguntas_norma"></div>
<div id="conteiner_busqueda_video_actividad"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>