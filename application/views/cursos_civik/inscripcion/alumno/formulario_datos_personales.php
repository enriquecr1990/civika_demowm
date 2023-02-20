<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container-fluid" id="accordion">

    <div class="card">
        <div class="card-header">
            <label>Proceso de inscripcion, registro de datos personales</label>
        </div>
        <div class="card-body">

            <div class="card mb-2">
                <div class="card-header">
                    <label>Registro de datos personales</label>
                </div>
                <div class="card-body">
                    <form id="form_guardar_usuario_alumno_datos_generales">

                        <div class="col-sm-12">
                            <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="alert alert-info" style="font-size: 18px; font-weight: bold">
                                    Es necesario que guarde sus datos personales, posteriormente cargar su recibo de pago y enviarlo con el botón azul "Enviar recibo" que aparece al final de esté formulario.
                                    (En caso de que su pago sea antes de tomar su curso, adjunte una imagen de su INE/IFE o alguna identificación oficial)
                                </div>
                            </div>
                        </div>

                        <p>
                            <span>Los datos con <span class="requerido">*</span> son obligatorios</span>
                        </p>

                        <input id="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
                        <input type="hidden" name="usuario[update_password]" value="<?= $usuario->update_password ?>">
                        <input id="usuario_update_datos" type="hidden" name="usuario[update_datos]" value="<?= $usuario->update_datos ?>">
                        <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno?>">
                        <input id="usuario_alumno_update_datos" type="hidden" name="usuario_alumno[update_datos]" value="<?= $usuario_alumno->update_datos ?>">
                        <input type="hidden" name="usuario_alumno[id_publicacion_ctn]" value="<?= $curso_incripcion->id_publicacion_ctn?>">
                        <input id="input_tipo_usuario" type="hidden" name="tipo_usuario" value="alumno">

                        <div class="row">

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_nombre" class="col-form-label">Nombre(s)<span
                                            class="requerido">*</span></label>
                                <input id="input_nombre" class="form-control" placeholder="Nombre(s)" data-rule-required="true"
                                    <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       name="usuario[nombre]" value="<?= $usuario->nombre ?>">
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_apellido_p" class="col-form-label">Apellido paterno<span
                                            class="requerido">*</span></label>
                                <input id="input_apellido_p" class="form-control" placeholder="Apellido paterno"
                                       data-rule-required="true" name="usuario[apellido_p]"
                                    <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       value="<?= $usuario->apellido_p ?>">
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_apellido_m" class="col-form-label">Apellido materno<span
                                            class="requerido">*</span></label>
                                <input id="input_apellido_m" class="form-control" placeholder="Apellido materno"
                                       data-rule-required="true" name="usuario[apellido_m]" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       value="<?= $usuario->apellido_m ?>">
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_telefono" class="col-form-label">Teléfono<span class="requerido">*</span></label>
                                <input id="input_telefono" class="form-control" placeholder="Teléfono"
                                       data-rule-required="true" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       name="usuario[telefono]" value="<?= $usuario->telefono ?>">
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_correo" class="col-form-label">Correo electrónico<span
                                            class="requerido">*</span></label>
                                <input id="input_correo" class="form-control" placeholder="Correo" data-rule-required="true"
                                    <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       data-rule-email="true" name="usuario[correo]" value="<?= $usuario->correo ?>">
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_usuario" class="col-form-label">Usuario</label>
                                <input id="input_usuario" class="form-control" placeholder="Usuario"
                                       data-rule-required="true" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       name="usuario[usuario]" value="<?= $usuario->usuario ?>" readonly="readonly">
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label class="custom-control custom-toggle d-block my-2">
                                    <input type="checkbox" id="input_cambiar_password_usuario"
                                           class="custom-control-input input_checkbox_change" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                           data-div_show_hidden=".input_form_passwords">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Modificar contraseña</span>
                                </label>
                            </div>

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 input_form_passwords" <?= isset($usuario) ? 'style="display: none"' : '' ?>>
                                <label for="input_password" class="col-form-label">Contraseña<span
                                            class="requerido">*</span></label>
                                <input id="input_password" type="password" id="password" class="form-control"
                                       placeholder="Constraseña" data-rule-required="true" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       name="usuario[password]" value="">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 input_form_passwords" <?= isset($usuario) ? 'style="display: none"' : '' ?>>
                                <label for="input_password_repeat" class="col-form-label">Repetir contraseña<span
                                            class="requerido">*</span></label>
                                <input id="input_password_repeat" type="password" class="form-control"
                                       placeholder="Constraseña" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       data-rule-required="true" value="">
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_profesion_alumno" class="col-form-label">Profesión</label>
                                <input id="input_profesion_alumno" class="form-control" placeholder="Profesión/Carrera"
                                       name="usuario_alumno[profesion]" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       value="<?= isset($usuario_alumno) ? $usuario_alumno->profesion : '' ?>">
                            </div>

                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_domicilio_alumno" class="col-form-label">Domicilio</label>
                                <input id="input_domicilio_alumno" class="form-control" placeholder="Nombre"
                                       name="usuario_alumno[domicilio]" <?=$disabled_edicion_datos ? 'disabled="disabled"' : ''?>
                                       value="<?= isset($usuario_alumno) ? $usuario_alumno->domicilio : '' ?>">
                            </div>
                        </div>

                        <p>
                            <span>Los datos con <span class="requerido">*</span> son obligatorios</span>
                        </p>

                        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
                        <?php if(!$disabled_edicion_datos): ?>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <button type="button" class="btn btn-success btn-pill guardar_usuario_alumno_datos_personales">
                                    Guardar datos personales
                                </button>
                            </div>
                        <?php endif; ?>

                    </form>
                </div>
            </div>

            <div class="card mb-2 civika_forma_pago_efectivo" style="display: none">
                <div class="card-header">
                    <label>Realice su pago en efectivo o deposito bancario</label>
                </div>
                <div class="card-body">
                    <div id="seccion_recibo_pago" <?=isset($usuario) && $usuario->update_datos == 0 || $disabled_edicion_datos ? 'style="display: none"':'' ?>>
                        <form id="form_registro_pago">
                            <input class="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
                            <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
                            <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno?>">
                            <input type="hidden" name="datos_fiscales[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">

                            <div class="row">
                                <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label">Descargar formato de pago</label>
                                    <a href="<?= base_url() ?>DocumentosPDF/formato_pago"
                                       class="btn btn-success btn-pill btn-sm" target="_blank">
                                        <i class="fa fa-download"></i> Descargar
                                    </a>
                                </div>
                                <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12" id="upload_recibo_pago_civik">
                                    <label for="input_recibo_pago_img" class="col-form-label">Recibo de pago<span
                                                class="requerido">*</span></label>
                                    <div class="file_upload_civik btn btn-sm btn-info btn-pill" id="upload_recibo_pago_civik">
                                        <label for="input_recibo_pago_img" class="col-form-label">Subir recibo</label>
                                        <input id="input_recibo_pago_img" type="file" class="upload_civika fileUploadReciboPago"
                                               accept="image/*" name="img_recibo_pago">
                                    </div>
                                </div>
                                <div id="div_conteiner_file_recibo_pago" class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <?php if(isset($alumno_inscrito_ctn_publicacion->documento_recibo_pago)): ?>
                                        <label for="recibo_pago_id_documento" class="col-form-label">Imagen del recibo de pago</label> <span class="help-block help-span">Puede reemplazar el recibo subiendo otra imagen</span> <br>
                                        <input id="recibo_pago_id_documento" class="recibo_pago_inscripcion" type="hidden" name="alumno_inscrito_ctn_publicado[id_documento]"
                                               value="<?=$alumno_inscrito_ctn_publicacion->documento_recibo_pago->id_documento?>">
                                        <button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage"
                                                data-nombre_archivo="<?=$alumno_inscrito_ctn_publicacion->documento_recibo_pago->nombre?>"
                                                data-src_image="<?=$alumno_inscrito_ctn_publicacion->documento_recibo_pago->ruta_documento?>"
                                                data-width_img="100%" data-height_img="100%">
                                            <i class="fa fa-image"></i>
                                        </button>
                                        <a href="<?=$alumno_inscrito_ctn_publicacion->documento_recibo_pago->ruta_documento?>" class="btn btn-light btn-pill btn-sm" target="_blank">
                                            <i class="fa fa-file-o"></i>Ver imagen
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if(!is_null($alumno_inscrito_ctn_publicacion->cumple_comprobante) && $alumno_inscrito_ctn_publicacion->cumple_comprobante == 'no'): ?>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-form-label">Observación</label>
                                        <span><?=$alumno_inscrito_ctn_publicacion->observacion_comprobante?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button" class="btn btn-primary btn-pill civika_enviar_recibo_validacion_alumno"
                                            data-id_alumno_inscrito_ctn_publicado="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
                                        Enviar recibo
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php if (!es_produccion()): ?>
                <div class="card mt-2 civika_forma_pago_online" style="display: none">
                    <div class="card-header">
                        <label>Realice su pago en línea (online):</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <div class="alert alert-warning">
                                            Favor de validar su información ingresada en el sistema, para garantizar que la emición de sus constancias sea con los datos correctos.
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="frame_validacion_dc3_pago_online">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 loader_iframe">
                                        <iframe src="<?=base_url().'DocumentosPDF/datos_alumno/'.$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>" style="width: 100%; height: 550px;"></iframe>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="alert">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input check_validacion_datos" id="check_revisar_datos_to_pago_online">
                                                <label class="custom-control-label" for="check_revisar_datos_to_pago_online">
                                                    He revisado la información y confirmó que son correctos los datos personales
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="formas_pago_inscripcion_alumno" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                                <?php
                                $data_payment = array(
                                    'transaction_amount' => $curso_incripcion->costo,
                                    'url_payment' => base_url().'PagoOnline/mp_inscripcion_ca/'.$curso_incripcion->id_publicacion_ctn.'/'.$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado,
                                    'details_payment' => $curso_incripcion->nombre_curso_comercial,
                                    'reintentar' => isset($tried_payment) ? $tried_payment : false
                                );
                                $this->load->view('payments/pagos_online', $data_payment);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- conteiners para las peticiones de las operaciones -->
<div id="container_modal_validar_datos_alumno_envio_recibo"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>