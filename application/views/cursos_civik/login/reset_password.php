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
                    <form id="form_cambiar_password_by_reestablecer" role="form">

                        <input type="hidden" name="id_usuario" value="<?=$id_usuario?>">

                        <div class="modal-body">

                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Contraseña temporal</label>
                                    <input class="form-control" type="password" name="temp_password"
                                           placeholder="Contraseña temporal" data-rule-required="true">
                                </div>
                            </div>
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Contraseña nueva</label>
                                    <input class="form-control" type="password" name="new_password" id="new_password"
                                           placeholder="Contraseña nueva" data-rule-required="true">
                                </div>
                            </div>

                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Repetir contraseña nueva</label>
                                    <input class="form-control" type="password" id="repeat_new_password"
                                           placeholder="Repetir contraseña nueva" data-rule-required="true">
                                </div>
                            </div>

                        </div>
                        <div class="text-center">
                            <a href="<?=base_url()?>" class="btn btn-secondary btn-pill btn-sm" >Cancelar</a>
                            <button id="btn_solicitud_reset_pass" type="button"
                                    class="btn btn-success btn-pill btn-sm reset_password_civik">Cambiar contraseña</button>
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