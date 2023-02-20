<div class="modal fade" role="dialog" id="modal_registro_normas_estacion_servicio">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Normas correspondientes a la estación de servicio</h4>
            </div>
            <form class="form-horizontal" id="form_registro_normas_estacion_servicio">
                <input type="hidden" name="id_estacion_servicio" value="<?=$estacion_servicio->id_estacion_servicio?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2">Nombre:</label>
                        <span class="col-sm-4"><?=$estacion_servicio->nombre?></span>
                        <label class="col-sm-2">RFC:</label>
                        <span class="col-sm-4"><?=$estacion_servicio->rfc?></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Año norma:</label>
                        <div class="col-sm-4">
                            <select class="form-control buscar_normas_estacion_servicio" data-id_estacion_servicio="<?=$estacion_servicio->id_estacion_servicio?>">
                                <?php foreach ($catalogo_anios as $anio){ ?>
                                    <option value="<?=$anio?>" <?=$anio == $anio_selected ? 'selected="selected"':''?>><?=$anio?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="conteiner_resultados_estacion_servicio">
                        <?php $this->load->view('asea/estacion_servicio/ResultadosNormaEstacionServicio'); ?>
                    </div>
                    <div class="form-group" id="conteiner_error_validacion_norma_estacion_servicio">

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: center">
                            <button type="button" class=" btn btn-success btn-sm guardar_normas_estacion_servicio">Aceptar</button>
                            <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>