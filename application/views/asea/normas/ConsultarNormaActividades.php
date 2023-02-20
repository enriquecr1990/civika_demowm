<div class="modal fade" role="dialog" id="modal_consultar_norma_asea_actividad">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=$tituloConsultarNorma?></h4>
            </div>
            <form class="form-horizontal" id="form_actividades_norma">
                <input type="hidden" name="id_normas_asea" value="<?=$normasAsea->id_normas_asea?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div id="guardar_form_busqueda_normas_asea_modal">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Nombre:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->nombre?></span></div>
                        <label class="col-sm-2">Duración:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->duracion?></span></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Instructor:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->instructor?></span></div>
                        <label class="col-sm-2">Fecha inicio:</label>
                        <div class="col-sm-4"><span><?=fechaBDToHtml($normasAsea->fecha_inicio)?></span></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Fecha fin:</label>
                        <div class="col-sm-4"><span><?=fechaBDToHtml($normasAsea->fecha_fin)?></span></div>
                        <label class="col-sm-2">Ocupación específica:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->ocupacion_especifica?></span></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Agente capacitador:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->agente_capacitador?></span></div>
                        <label class="col-sm-2">Área temática:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->area_tematica?></span></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Año:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->anio?></span></div>
                        <label class="col-sm-2">Horario:</label>
                        <div class="col-sm-4"><span><?=$normasAsea->horario?></span></div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Actividades normas ASEA</div>
                        <div class="panel-body">
                            <?php if($editarNormaActividad): ?>
                                <div class="col-sm-12" style="text-align: right;">
                                    <button type="button" class="btn btn-info btn-sm agregar_actividad_norma" data-backdrop="static">
                                        <span class="glyphicon glyphicon-plus"></span>Agregar actividad
                                    </button>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="col-sm-12 col-md-12">
                                    <div class="table-responsive">
                                        <?php $this->load->view('asea/normas/RegistroActividadNorma'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <?php if($editarNormaActividad):?>
                        <button type="button" class="btn btn-success btn-sm guardar_activiades_norma">Aceptar</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-<?=$editarNormaActividad ? 'danger' : 'success'?> btn-sm" data-dismiss="modal">
                        <?=$editarNormaActividad ? 'Cancelar' : 'Cerrar'?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>