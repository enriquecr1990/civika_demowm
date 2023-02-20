<div class="modal fade" role="dialog" id="modal_publicacion_curso_masivo_envio_publicacion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Enviar información a la empresa</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="form_guardar_publicacion_curso_enviar_informacion">

                <input type="hidden" name="id_publicacion_ctn" value="<?= $id_publicacion_ctn ?>">
                <input type="hidden" id="id_cotizacion" name="id_cotizacion" value="<?= $id_cotizacion ?>">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <div id="form_mensajes_curso_publicacion" class="mensajes_sistema_civik"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label for="input_rfc_empresa" class="col-form-label">RFC de la empresa<span
                                        class="requerido">*</span></label>
                            <input id="input_rfc_empresa" class="form-control civika_mayus"
                                   placeholder="RFC de la empresa destinada" readonly="readonly"
                                   data-rule-required="true" name="rfc" value="<?=$rfc?>">
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label for="input_rfc_empresa" class="col-form-label">Correo de la empresa<span
                                        class="requerido">*</span></label>
                            <input id="input_rfc_empresa" class="form-control"
                                   placeholder="Correo de la empresa destinada"
                                   data-rule-required="true" name="correo" value="<?=$correo?>">
                            <span class="help-span">Se usará para enviar el link a la empresa y que llene los alumnos para la publicación<br>Puede enviar a más de un correo si lo separa por una coma ","</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-pill btn-sm enviar_informacion_publicacion_masiva">
                        Enviar información del curso
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>