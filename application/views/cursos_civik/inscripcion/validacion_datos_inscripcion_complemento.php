<div class="modal fade" role="dialog" id="modal_validar_datos_alumno_validar_recibo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title">Completar registro de datos DC-3</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-warning">
                        Favor de verificar sus datos antes de concluir el registro de inscripción con los datos DC-3
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <iframe src="<?=base_url().'DocumentosPDF/datos_alumno/'.$id_alumno_inscrito_ctn_publicado?>" style="width: 100%; height: 380px"></iframe>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input check_validacion_datos" id="check_revisar_datos_formato_dc3">
                                <label class="custom-control-label" for="check_revisar_datos_formato_dc3">
                                    He revisado la información y confirmó que son correctos los datos para la DC-3
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success btn-sm btn-pill concluir_registro_dc3"
                        disabled="disabled" data-id_alumno_inscrito_ctn_publicado="<?=$id_alumno_inscrito_ctn_publicado?>">
                    Concluir registro DC-3
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>