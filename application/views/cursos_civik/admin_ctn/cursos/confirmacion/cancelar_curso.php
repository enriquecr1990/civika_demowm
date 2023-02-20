<div class="modal fade" role="dialog" id="modal_cancelacion_curso_civika">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Cancelar curso presencial</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="col-sm-12">
                    <div id="form_mensajes_cancelacion_curso" class="mensajes_sistema_civik"></div>
                </div>

                <form id="form_cancelar_curso_presencial">
                    <input type="hidden" name="curso_taller_norma[id_curso_taller_norma]" value="<?=$curso_taller_norma->id_curso_taller_norma?>">
                    <input type="hidden" name="curso_taller_norma[ctn_cancelado]" value="si">
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="descripcion_cancelacion" class="col-form-label">Mótivo</label>
                            <textarea id="descripcion_cancelacion" class="form-control" name="curso_taller_norma[descripcion_cancelacion]"
                                      data-rule-required="true"
                                      placeholder="Describa brevemente el motivo de la cancelación"></textarea>
                        </div>
                    </div>
                    <?php if(isset($curso_taller_norma->publicaciones_activas_finalizadas) && $curso_taller_norma->publicaciones_activas_finalizadas->activas != 0): ?>
                        <div class="row">
                            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-12 text-justify">
                                <label>
                                    Se detectarón públicaciones activas del curso, ¿Le gustaria notificar a los alumnos del cambio?
                                </label>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="notificar_si" name="notificacion_cancelacion" data-rule-required="true" class="custom-control-input" value="no">
                                    <label class="custom-control-label" for="notificar_si">No</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="notificar_no" name="notificacion_cancelacion" class="custom-control-input" value="si">
                                    <label class="custom-control-label" for="notificar_no">Si</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-pill btn-sm cancelar_curso">Aceptar</button>
                <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>