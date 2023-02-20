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
                        <div class="alert alert-danger">
                            Considere que con los datos proporcionados se generaran sus constancias, si existiera un error posterior al envio se le generará un cargo adicional para reimpresión
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input check_validacion_datos" id="check_revisar_datos">
                                <label class="custom-control-label" for="check_revisar_datos">
                                    He revisado la información y confirmó que son correctos los datos para la DC-3
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success btn-sm btn-pill enviar_recibo_inscripcion_validacion_civik"
                        disabled="disabled" data-id_alumno_inscrito_ctn_publicado="<?=$id_alumno_inscrito_ctn_publicado?>">
                    Enviar recibo
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>