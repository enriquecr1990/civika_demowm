<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <label>Perfil del usuario</label>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="foto_perfil_usr">
                    <div id="container_foto_perfil">
                        <?php if(isset($usuario->foto_perfil) && is_object($usuario->foto_perfil)): ?>
                        <img class="img-thumbnail img_perfil" src="<?=$usuario->foto_perfil->ruta_documento?>">
                        <?php else: ?>
                            <img class="img-thumbnail" src="<?=base_url()?>extras/imagenes/logo/person.png">
                        <?php endif; ?>
                    </div>
                    <label for="input_foto_perfil_img" class="col-form-label">Foto de perfil</label>
                    <span class="help-span">A color, de frente, fondo blanco, sin lentes, frente descubierta. (En caso de usar aretes, que estos sean pequeños)</span>
                    <div class="file_upload_civik btn btn-sm btn-info btn-pill" id="upload_recibo_pago_civik_xml">
                        <label for="input_foto_perfil_img" class="col-form-label">Actualizar foto de perfil</label>
                        <input id="input_foto_perfil_img" type="file" class="upload_civika fileUploadFotoPerfil"
                        accept="image/*" name="img_foto_perfil" data-id_usuario="<?=$usuario->id_usuario?>">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <?php $this->load->view('cursos_civik/control_usuarios/perfil/datos_personales');?>
                        <?php if($usuario->tipo_usuario == 'alumno'): ?>
                            <?php $this->load->view('cursos_civik/control_usuarios/perfil/datos_alumno');?>
                        <?php endif; ?>
                        <?php if($usuario->tipo_usuario == 'instructor'): ?>
                            <?php $this->load->view('cursos_civik/control_usuarios/perfil/datos_instructor');?>
                        <?php endif; ?>

                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" id="recibir_correo">
                            <label class="custom-control custom-toggle d-block my-2">
                                <input type="checkbox" id="input_recibir_correo"
                                class="custom-control-input  input_recibir_correo"<?= isset($usuario->suscripcion_correo) && $usuario->suscripcion_correo == 'si' ? 'checked':'' ?>>
                                <span class="custom-control-indicator"  ></span>
                                <span class="custom-control-description">Recibir Correo</span>
                            </label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                            <button type="button" class="btn btn-pill btn-sm btn-success modificar_usuario"
                            data-id_usuario="<?=$usuario->id_usuario?>"
                            data-tipo_usuario="<?=$usuario->tipo_usuario?>"
                            data-es_configuracion="1">
                            Modificar perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="conteiner_agregar_modificar_usuario_admin"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>