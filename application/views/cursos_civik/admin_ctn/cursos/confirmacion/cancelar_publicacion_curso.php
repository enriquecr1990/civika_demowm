<div class="modal fade" role="dialog" id="modal_cancelacion_publicacion_curso_civika">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Cancelar publicación de curso presencial</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="col-sm-12">
                    <div id="form_mensajes_cancelacion_curso_presencial" class="mensajes_sistema_civik"></div>
                </div>

                <form id="form_cancelar_publicacion_curso_presencial">
                    <input type="hidden" name="publicacion_ctn[id_publicacion_ctn]" value="<?=$publicacion_ctn->id_publicacion_ctn?>">
                    <input type="hidden" name="publicacion_ctn[publicacion_eliminada]" value="si">
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="descripcion_cancelacion" class="col-form-label">Mótivo</label>
                            <textarea id="descripcion_cancelacion" class="form-control" name="publicacion_ctn[detalle_eliminacion]"
                                      data-rule-required="true"
                                      placeholder="Describa brevemente el motivo de la cancelación"></textarea>
                        </div>
                    </div>
                    <?php if(isset($array_alumnos_publicacion) && is_array($array_alumnos_publicacion) && sizeof($array_alumnos_publicacion) != 0): ?>
                        <div class="row">
                            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-12 text-justify">
                                <label>
                                    Se detectarón alumnos en la publicación del curso, ¿Le gustaria notificarles de la cancelación?
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
                <button type="button" class="btn btn-success btn-pill btn-sm cancelar_publicacion_curso">Aceptar</button>
                <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>