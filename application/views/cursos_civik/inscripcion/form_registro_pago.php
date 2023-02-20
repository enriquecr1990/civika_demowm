<?php
$disabled = '';
if (isset($disabled_edicion_datos) && $disabled_edicion_datos) {
    $disabled = 'disabled="disabled"';
}
?>

<div class="card">
    <div class="card-header">
        <!--<h5 class="text-primary">
            Registro de pago
        </h5>-->
    </div>
    <div aria-labelledby="heading_registro_pago"
         data-parent="#accordion">
        <div class="card-body">

            <div class="card mb-1">
                <div class="card-header">
                    <label>Datos de facturación</label>
                </div>
                <div class="card-body">
                    <form id="form_registro_pago_facturacion">
                        <div class="col-sm-12">
                            <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
                        </div>

                        <input class="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
                        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]"
                               value="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">
                        <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno ?>">
                        <input type="hidden" name="datos_fiscales[id_alumno_inscrito_ctn_publicado]"
                               value="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">

                        <div class="row">

                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <label class="col-form-label">¿Requiere factura por el pago del curso?</label>
                            </div>
                            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="customRadio1" name="alumno_inscrito_ctn_publicado[requiere_factura]"
                                           class="custom-control-input checked_required_factura"
                                        <?= $disabled ?>
                                           value="no" <?= $alumno_inscrito_ctn_publicacion->requiere_factura == 'no' ? 'checked="checked"' : '' ?>>
                                    <label class="custom-control-label" for="customRadio1">No</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="customRadio2" name="alumno_inscrito_ctn_publicado[requiere_factura]"
                                           class="custom-control-input checked_required_factura"
                                        <?= $disabled ?>
                                           value="si" <?= $alumno_inscrito_ctn_publicacion->requiere_factura == 'si' ? 'checked="checked"' : '' ?>>
                                    <label class="custom-control-label" for="customRadio2">Si</label>
                                </div>
                            </div>
                        </div>

                        <!-- datos de facturacion -->
                        <div id="form_data_facturacion" <?= $alumno_inscrito_ctn_publicacion->requiere_factura == 'no' ? 'style="display: none;"' : '' ?>>
                            <div class="row row_form">
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_razon_social" class="col-form-label">Razón social<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_razon_social" class="form-control"
                                           placeholder="Razón social" data-rule-required="true" <?= $disabled ?>
                                           name="datos_fiscales[razon_social]"
                                           value="<?= isset($datos_fiscales) ? $datos_fiscales->razon_social : $empresa->nombre ?>">
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_rfc" class="col-form-label">RFC<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_rfc" class="form-control civika_mayus dato_rfc_factura"
                                           placeholder="RFC de la razón social" data-rule-required="true"
                                           name="datos_fiscales[rfc]"
                                           value="<?= isset($datos_fiscales) ? $datos_fiscales->rfc : $empresa->rfc ?>" <?= $disabled ?>>
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_correo" class="col-form-label">Correo</label>
                                    <input id="input_datos_fiscales_correo" class="form-control"
                                           placeholder="Correo al que se le hara llegar la factura"
                                           data-rule-mail="true" <?= $disabled ?>
                                           name="datos_fiscales[correo]"
                                           value="<?= isset($datos_fiscales) ? $datos_fiscales->correo : $empresa->correo ?>">
                                </div>
                            </div>
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_direccion" class="col-form-label">Domicilio fiscal<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_direccion" class="form-control"
                                           placeholder="Domicilio fiscal de la razón social" data-rule-required="true"
                                        <?= $disabled ?> name="datos_fiscales[direccion_fiscal]"
                                           value="<?= isset($datos_fiscales) ? $datos_fiscales->direccion_fiscal : $empresa->domicilio ?>">
                                </div>
                            </div>
                            <div class="row row_form"
                                 id="row_uso_cfdi_persona_fisica" <?= isset($datos_fiscales) && strlen($datos_fiscales->rfc) == 13 ? '' : 'style="display: none;"' ?>>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_uso_cfdi_fisica" class="col-form-label">Uso de CFDI<span
                                                class="requerido">*</span></label>
                                    <select id="input_datos_fiscales_uso_cfdi_fisica" class="custom-select"
                                            data-rule-required="true" <?= $disabled ?> name="uso_cfdi_fisica">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($catalogo_uso_cfdi_persona_fisica as $cpf): ?>
                                            <option value="<?= $cpf->id_catalogo_uso_cfdi ?>" <?= isset($datos_fiscales) && $datos_fiscales->id_catalogo_uso_cfdi == $cpf->id_catalogo_uso_cfdi ? 'selected="selected"' : '' ?>><?= '(' . $cpf->clave . ') ' . $cpf->descripcion ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row row_form"
                                 id="row_uso_cfdi_persona_moral" <?= isset($datos_fiscales) && strlen($datos_fiscales->rfc) == 12 ? '' : 'style="display: none;"' ?>>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_uso_cfdi_moral" class="col-form-label">Uso de CFDI<span
                                                class="requerido">*</span></label>
                                    <select id="input_datos_fiscales_uso_cfdi_moral" <?= $disabled ?> class="custom-select"
                                            data-rule-required="true" name="uso_cfdi_moral">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($catalogo_uso_cfdi_persona_moral as $cpf): ?>
                                            <option value="<?= $cpf->id_catalogo_uso_cfdi ?>" <?= isset($datos_fiscales) && $datos_fiscales->id_catalogo_uso_cfdi == $cpf->id_catalogo_uso_cfdi ? 'selected="selected"' : '' ?>><?= '(' . $cpf->clave . ') ' . $cpf->descripcion ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                <div class="alert alert-warning">
                                    Favor de guardar primero sus datos de facturación y preceder a su pago
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12 text-right">
                                <button type="button"
                                        class="btn btn-success btn-pill civika_guardar_facturacion"
                                        data-id_alumno_inscrito_ctn_publicado="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">
                                    Guardar datos facturación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-2 civika_forma_pago_efectivo" style="display: none">
                <div class="card-header">
                    <label>Realice su pago en efectivo o deposito bancario</label>
                </div>
                <div class="card-body">
                    <form id="form_registro_pago">

                        <input class="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
                        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]"
                               value="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">
                        <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno ?>">
                        <input type="hidden" name="datos_fiscales[id_alumno_inscrito_ctn_publicado]"
                               value="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">

                        <?php if (isset($es_inscripcion_por_pasos) && $es_inscripcion_por_pasos): ?>
                            <!-- subir recibo de pago -->
                            <div class="row row_form">
                                <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <label class="col-form-label">Descargar formato de pago</label>
                                    <a href="<?= base_url() ?>DocumentosPDF/formato_pago/"
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

                        <?php endif; ?>

                        <!-- observacion del recibo de pago -->
                        <?php if ($alumno_inscrito_ctn_publicacion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_OBSERVADO): ?>
                            <div class="row row_form">
                                <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <label>Pago observado:</label>
                                </div>
                                <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <textarea class="form-control"
                                      disabled="disabled"><?= $alumno_inscrito_ctn_publicacion->observacion_comprobante ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                    <?php if (!$disabled_edicion_datos): ?>
                        <?php if (isset($es_inscripcion_por_pasos) && $es_inscripcion_por_pasos): ?>
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button"
                                            class="btn btn-primary btn-pill btn-sm civika_enviar_recibo_pago_inscripcion"
                                            data-id_alumno_inscrito_ctn_publicado="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">
                                        Enviar recibo
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                    <button type="button"
                                            class="btn btn-success btn-pill btn-sm civika_enviar_complemento_inscripcion"
                                            data-id_alumno_inscrito_ctn_publicado="<?= $alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado ?>">
                                        Concluir registro DC-3 y complemento de pago
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div><!-- end card body -->
            </div> <!-- end card -->

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
                                    'url_payment' => 'PagoOnline/mp_inscripcion_ca/'.$curso_incripcion->id_publicacion_ctn.'/'.$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado,
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
