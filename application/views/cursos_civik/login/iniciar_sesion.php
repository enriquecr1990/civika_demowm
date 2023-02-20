<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="row">
        <div class="form-group col-lg-3 col-md-3"></div>
        <div class="form-group col-lg-6 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <label>Inicia sesión con tu cuenta</label>
                </div>
                <div class="card-body">
                    <form id="form_iniciar_sesion" role="form">

                        <?php if(isset($id_publicacion_ctn)): ?>
                            <input type="hidden" name="id_publicacion_ctn" value="<?=$id_publicacion_ctn?>">
                        <?php endif; ?>

                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-lg 12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                        <input id="input_usuario_sesion" type="text" class="form-control"
                                               placeholder="Usuario" data-rule-required="true" name="usuario">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg 12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>
                                </span>
                                        <input id="input_password_sesion" type="password" class="form-control" data-rule-required="true"
                                               placeholder="Contraseña" name="password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <a href="<?=base_url()?>Login/reset_password"> ¿Has olvidado la contraseña? </a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <!--<button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cancelar</button>-->
                            <a href="<?=base_url()?>" class="btn btn-secondary btn-pill btn-sm" >Cancelar</a>
                            <button type="button" class="btn btn-primary btn-pill btn-sm iniciar_sesion_sistema_civka">Aceptar</button>
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