<div class="modal fade" role="dialog" id="modal_validar_datos_alumno_validar_recibo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title">Enviar recibo de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <div class="row" id="frame_validacion_datos_dc3">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 loader_iframe">
                        <iframe src="<?=base_url().'DocumentosPDF/datos_alumno/'.$id_alumno_inscrito_ctn_publicado?>" style="width: 100%; height: 350px;"></iframe>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input check_validacion_datos" id="check_revisar_datos_sin_dc3">
                                <label class="custom-control-label" for="check_revisar_datos_sin_dc3">
                                    He revisado la información y confirmó que son correctos los datos personales
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success btn-sm btn-pill enviar_recibo_inscripcion_validacion_civik_sin_dc3"
                        disabled="disabled" data-id_alumno_inscrito_ctn_publicado="<?=$id_alumno_inscrito_ctn_publicado?>">
                    Enviar recibo
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>