<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Registro de preguntas y respuestas norma ASEA</div>
        <div class="panel-body">

            <div class="panel panel-default">
                <div class="panel-heading">Norma ASEA</div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2">Nombre:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->nombre?></span></div>
                            <label class="col-sm-2">Duración:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->duracion?></span></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Instructor:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->instructor?></span></div>
                            <label class="col-sm-2">Fecha inicio:</label>
                            <div class="col-sm-4"><span><?=fechaBDToHtml($normas_asea->fecha_inicio)?></span></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Fecha fin:</label>
                            <div class="col-sm-4"><span><?=fechaBDToHtml($normas_asea->fecha_fin)?></span></div>
                            <label class="col-sm-2">Ocupación específica:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->ocupacion_especifica?></span></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Agente capacitador:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->agente_capacitador?></span></div>
                            <label class="col-sm-2">Área temática:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->area_tematica?></span></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Año:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->anio?></span></div>
                            <label class="col-sm-2">Horario:</label>
                            <div class="col-sm-4"><span><?=$normas_asea->horario?></span></div>
                        </div>

                        <div class="form-group derecha" style="display: none">
                            <div class="col-sm-12">
                                <button class="btn btn-success btn-sm buscar_preguntas_respuestas_norma"
                                        data-id_norma="<?=$normas_asea->id_normas_asea?>">
                                    <i class="glyphicon glyphicon-search"></i>Buscar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Preguntas respuestas Norma</div>
                <div class="panel-body">
                    <?php if(!$tiene_evaluacion_norma): ?>
                        <div class="form-group">
                            <div class="col-sm-12" style="text-align: right">
                                <button class="btn btn-info btn-sm agregar_pregunta_repuesta_norma"
                                        data-id_normas_asea="<?=$normas_asea->id_normas_asea?>">
                                    <span class="glyphicon glyphicon-plus"></span>Nueva pregunta
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="col-sm-12" id="conteiner_preguntas_respuestas_norma">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <a href="<?=base_url().'NormasAsea/ControlNormasAsea'?>" class="btn btn-default"><i class="glyphicon glyphicon-arrow-left"></i>&nbsp;Regresar</a>
            </div>

        </div>
    </div>
</div>

<div id="conteiner_registro_preguntas_respuestas_norma_asea"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>