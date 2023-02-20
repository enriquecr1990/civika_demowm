<div class="modal fade" role="dialog" id="modal_publicacion_link_evaluacion_online_civika">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Publicar link evaluación online</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_publicacion_link_evaluacion_online">

                <input type="hidden" name="id_publicacion_ctn" value="<?=$id_publicacion_ctn?>">

                <div class="modal-body">

                    <div class="row row_form">
                        <div class="form-group col-lg-12">
                            <label class="col-form-label">¿Es publicación a empresa u a un alumno?<span class="requerido">*</span></label>
                            <select class="custom-select" data-rule-requied="true" name="empresa" id="slt_empresa_publicacion_online">
                                <option value="">--Seleccione--</option>
                                <option value="si" <?=isset($evaluacion_online_ctn->empresa) && $evaluacion_online_ctn->empresa == 'si' ? 'selected="selected"' : ''?>>Si</option>
                                <option value="no" <?=isset($evaluacion_online_ctn->empresa) && $evaluacion_online_ctn->empresa == 'no' ? 'selected="selected"' : ''?>>No</option>
                            </select>
                        </div>
                    </div>

                    <div id="link_evaluacion_online" <?=isset($evaluacion_online_ctn->empresa) && $evaluacion_online_ctn->empresa == 'si' ? '':'style="display: none"'?>>

                        <div class="row row_form" >
                            <div class="form-group col-lg-12">
                                <label class="col-form-label">Destinatario</label>
                                <input class="form-control" name="destinatario" data-rule-required="true" placeholder="Nombre del destinatario"
                                       value="<?=isset($evaluacion_online_ctn->destinatario) ? $evaluacion_online_ctn->destinatario : ''?>">
                            </div>
                        </div>
                        <div class="row row_form">
                            <div class="form-group col-lg-12">
                                <label class="col-form-label">Correo(s)<span class="requerido">*</span></label>
                                <textarea id="correo_link_evaluacion_online" class="form-control" placeholder="Correo(s) para la empresa"
                                          data-rule-required="true" name="correo_link"><?=isset($evaluacion_online_ctn->correo_link) ? $evaluacion_online_ctn->correo_link : ''?></textarea>
                                <span class="help-span">Si es más de un correo, separarlo por una coma ","</span>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-pill btn-sm guardar_publicacion_evaluacion_online_link">
                        Generar link evaluación
                    </button>
                    <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>