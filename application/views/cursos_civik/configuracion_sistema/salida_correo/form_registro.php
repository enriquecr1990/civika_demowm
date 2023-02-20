<div class="modal fade" role="dialog" id="modal_registrar_modificar_config_correo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($sede_presencial) ? 'Modificar':'Agregar'?> configuración de correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_config_correo">

                <input type="hidden" name="id_config_correo" value="<?=isset($config_correo) ? $config_correo->id_config_correo : ''?>">
                <input type="hidden" name="active" value="<?=isset($config_correo) ? $config_correo->active : 'no'?>">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_protocol" class="col-form-label">Protocol<span class="requerido">*</span></label>
                            <input id="input_protocol" class="form-control" placeholder="Protocol"
                                   name="protocol" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->protocol : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_host" class="col-form-label">SMTP Host<span class="requerido">*</span></label>
                            <input id="input_smtp_host" class="form-control" placeholder="SMTP Host"
                                   name="smtp_host" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->smtp_host : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_user" class="col-form-label">SMTP user<span class="requerido">*</span></label>
                            <input id="input_smtp_user" class="form-control" placeholder="SMTP User"
                                   name="smtp_user" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->smtp_user : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_pass" class="col-form-label">SMTP password<span class="requerido">*</span></label>
                            <input id="input_smtp_pass" class="form-control" placeholder="SMTP Password"
                                   name="smtp_pass" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->smtp_pass : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_port" class="col-form-label">SMTP port<span class="requerido">*</span></label>
                            <input id="input_smtp_port" class="form-control" placeholder="SMTP Port"
                                   name="smtp_port" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->smtp_port : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_charset" class="col-form-label">Charset<span class="requerido">*</span></label>
                            <input id="input_smtp_charset" class="form-control" placeholder="Charset"
                                   name="charset" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->charset : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_mailtype" class="col-form-label">Mailtype<span class="requerido">*</span></label>
                            <input id="input_smtp_mailtype" class="form-control" placeholder="Mailtype"
                                   name="mailtype" data-rule-required="true"
                                   value="<?=isset($config_correo) ? $config_correo->mailtype : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_smtp_newline" class="col-form-label">Newline</label>
                            <input id="input_smtp_newline" class="form-control" placeholder="New Line"
                                   name="newline"
                                   value="<?=isset($config_correo) ? $config_correo->newline : ''?>">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_config_correo">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>