<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="row">
        <div class="form-group col-lg-3 col-md-3"></div>
        <div class="form-group col-lg-6 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <label>Reestablecer contraseña</label>
                </div>
                <div class="card-body">
                    <form id="form_reestabler_password" role="form">
                        <div class="modal-body">

                            <div class="form-group">
                                <div class="col-lg 12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                        <input id="input_correo_reset_pass" type="text" class="form-control"
                                               placeholder="Correo electrónico registrado" data-rule-required="true"
                                               data-rule-email="true" name="correo">
                                    </div>
                                </div>
                            </div>

                            <div id="input_select_usuario_encontrado" class="form-group"
                                 style="display: none">
                            </div>

                        </div>
                        <div class="text-center">
                            <a href="<?=base_url()?>/Login" class="btn btn-secondary btn-pill btn-sm" >Cancelar</a>
                            <button id="btn_solicitud_reset_pass" type="button" style="display: none"
                                    class="btn btn-danger btn-pill btn-sm reestablecer_password_civik">Reestablecer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="form-group col-lg-3 col-md-3"></div>
    </div>
</div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>