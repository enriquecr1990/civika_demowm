<div class="modal fade" role="dialog" id="modal_registrar_modificar_usuario">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($usuario) ? 'Modificar usuario' : 'Agregar usuario'?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_guardar_usuario">
                <div class="col-sm-12">
                    <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
                </div>

                <?php if(isset($es_configuracion) && $es_configuracion != ''): ?>
                    <input type="hidden" name="es_configuracion" value="<?=$es_configuracion?>">
                <?php endif; ?>

                <input id="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?=isset($usuario) ? $usuario->id_usuario : ''?>">
                <input type="hidden" name="usuario[update_password]" value="<?=isset($usuario) ? $usuario->update_password : 0?>">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="slt_tipo_usuario" class="col-form-label">Tipo de usuario</label>
                            <?php if($tipo_usuario != 'administrador'): ?>
                                <select id="slt_tipo_usuario" class="custom-select d-block" data-rule-required="true" <?=isset($usuario) ? 'disabled="disabled"':''?>
                                        name="tipo_usuario" >
                                    <option value="">Seleccione</option>
                                    <?php foreach ($catalogo_usuario as $ca): ?>
                                        <option value="<?=$ca['value']?>" <?=isset($tipo_usuario) && $tipo_usuario == $ca['value'] ? 'selected="selected"':''?>><?=$ca['label']?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <span>Administrador</span>
                            <?php endif; ?>
                            <?php if(isset($usuario)): ?>
                                <input class="input_tipo_usuario" type="hidden" name="tipo_usuario" value="<?=$tipo_usuario?>">
                            <?php endif; ?>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Nombre</label>
                            <input id="input_nombre" class="form-control" placeholder="Nombre" data-rule-required="true"
                                   name="usuario[nombre]" value="<?=isset($usuario) ? $usuario->nombre : ''?>">
                        </div>
                    </div>


                    <div class="row">

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_apellido_p" class="col-form-label">Apellido paterno</label>
                            <input id="input_apellido_p" class="form-control" placeholder="Apellido paterno" data-rule-required="true"
                                   name="usuario[apellido_p]" value="<?=isset($usuario) ? $usuario->apellido_p : ''?>">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_apellido_m" class="col-form-label">Apellido materno</label>
                            <input id="input_apellido_m" class="form-control" placeholder="Apellido materno" data-rule-required="true"
                                   name="usuario[apellido_m]" value="<?=isset($usuario) ? $usuario->apellido_m : ''?>">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_telefono" class="col-form-label">Teléfono</label>
                            <input id="input_telefono" class="form-control" placeholder="Teléfono" data-rule-required="true"
                                   name="usuario[telefono]" value="<?=isset($usuario) ? $usuario->telefono : ''?>">
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_correo" class="col-form-label">Correo electrónico</label>
                            <input id="input_correo" class="form-control" placeholder="Correo" data-rule-required="true" data-rule-email="true"
                                   name="usuario[correo]" value="<?=isset($usuario) ? $usuario->correo : ''?>">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_usuario" class="col-form-label">Usuario</label>
                            <input id="input_usuario" class="form-control" placeholder="Usuario" data-rule-required="true"
                                   <?=isset($usuario) ? 'readonly="readonly"':''?>
                                   name="usuario[usuario]" value="<?=isset($usuario) ? $usuario->usuario : ''?>">
                        </div>

                        <?php if(isset($usuario)): ?>
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label class="custom-control custom-toggle d-block my-2">
                                    <input type="checkbox" id="input_cambiar_password_usuario"
                                           class="custom-control-input input_checkbox_change" data-div_show_hidden="#input_form_passwords">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Modificar contraseña</span>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row" id="input_form_passwords" <?=isset($usuario) ? 'style="display: none"':''?>>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_password" class="col-form-label">Contraseña</label>
                            <input id="input_password" type="password" id="password" class="form-control" placeholder="Constraseña" data-rule-required="true"
                                   name="usuario[password]" value="">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_password_repeat" class="col-form-label">Repetir contraseña</label>
                            <input id="input_password_repeat" type="password" class="form-control" placeholder="Constraseña"
                                   data-rule-required="true" value="">
                        </div>
                    </div>

                    <!-- datos propios por el tipo del alumno -->
                    <div id="inputs_extra_form_usuario">
                        <?php $this->load->view('cursos_civik/control_usuarios/inputTipoUsuario'); ?>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_usuario_civik">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>