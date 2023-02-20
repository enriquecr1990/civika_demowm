<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="row">
        <div class="form-group col-lg-3 col-md-3"></div>
        <div class="form-group col-lg-6 col-md-12 col-sm-12 ">
            <div class="card">
                <div class="card-header">
                    <label>Registrate para acceder a este curso</label>
                </div>
                <div class="card-body">
                    <form id="form_iniciar_sesion_inscripcion" role="form">

                        <div class="col-sm-12">
                            <div id="form_mensajes_curso_registro_inscripcion" class="mensajes_sistema_civik"></div>
                        </div>

                        <input type="hidden" name="curso_inscripcion[id_publicacion_ctn]" value="<?=$id_publicacion_ctn?>">

                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-lg 12 col-sm-12 col-xs-12 col-sm-12">
                                    <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                        <input type="text" class="form-control" placeholder="Correo electrónico o teléfono"
                                               data-rule-required="true" name="usuario">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg 12 col-md-12 col-xs-12 col-sm-12">
                                    <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>
                                </span>
                                        <input id="input_password_registro" type="password" class="form-control" placeholder="Contraseña"
                                               data-rule-required="true" name="password">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="check_show_password">
                                        <label class="custom-control-label" for="check_show_password">Mostrar contraseña</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                                    <label>¿Ya tienes cuenta?</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12 text-left">
                                    <a class="btn btn-pill btn-primary" href="<?=base_url().'Login?id_publicacion_ctn='.$id_publicacion_ctn?>">Inicia Sesión</a>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer text-center">
                            <a href="<?=base_url()?>" class="btn btn-secondary btn-pill btn-sm">Cancelar</a>
                            <button type="button" class="btn btn-danger btn-pill btn-sm registro_curso_incripcion">Regístrate</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="form-group col-lg-3 col-md-3"></div>
    </div>
</div>
<!--
        </div>
    </div>
</div>
-->

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>