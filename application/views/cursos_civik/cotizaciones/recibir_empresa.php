<!-- cargar header del proyecto -->
<?php $this->load->view('default/header');
$disable='disabled="dssabled"';
if($cotizacion->id_catalogo_proceso_cotizacion == COTIZACION_RECIBIDA){
    $disable = '';
}
?>



<div class="container">

    <div class="card mb-3">
        <div class="card-header">
            <label>Cotizacion <?=$cotizacion->nombre?></label>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-7 col-md-12 col-sm-12 col-12 loader_iframe">
                    <iframe  src="<?=base_url()?>DocumentosPDF/cotizacion/<?=$cotizacion->id_cotizacion?>" width="100%" height="700px"></iframe>
                </div>
                <div class="form-group col-lg-5 col-md-12 col-sm-12 col-12">
                    <form id="form_cotizacion_empresa">

                        <input type="hidden" name="cotizacion[id_cotizacion]" value="<?=$cotizacion->id_cotizacion?>">

                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                <label for="slt_acepta_cotizacion" class="col-form-label">¿Acepta la cotizacion?</label>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio1" name="acepta_cotizacion"
                                           <?=existe_valor($cotizacion->folio_orden_compra) ? 'checked="checked"':''?> <?=$disable?>
                                           class="custom-control-input checked_acepta_cotizacion" data-rule-required="true" value="si">
                                    <label class="custom-control-label" for="customRadio1">Si</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="customRadio2" name="acepta_cotizacion" <?=$disable?>
                                        <?=existe_valor($cotizacion->folio_orden_compra) ? '':'checked="checked"'?>
                                           class="custom-control-input checked_acepta_cotizacion" value="no">
                                    <label class="custom-control-label" for="customRadio2">No</label>
                                </div>
                            </div>
                        </div>

                        <div id="complemento_form_orden_compra" <?=existe_valor($cotizacion->folio_orden_compra) ? '':'style="display:none"'?>>
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                    <label class="col-form-label">Orden de compra</label>
                                    <input type="text" placeholder="Orden de compra" class="form-control"
                                           name="cotizacion[folio_orden_compra]" <?=$disable?> data-rule-required="true"
                                           value="<?=existe_valor($cotizacion->folio_orden_compra) ? $cotizacion->folio_orden_compra:''?>">
                                </div>
                            </div>
                            <!-- datos de facturacion -->
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_razon_social" class="col-form-label">Razón social<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_razon_social" class="form-control" placeholder="Razón social"
                                           data-rule-required="true" <?=$disable?>
                                           name="datos_fiscales[razon_social]" value="<?= isset($datos_fiscales) ? $datos_fiscales->razon_social : $cotizacion->empresa?>">
                                </div>
                            </div>
                            <div class="row row_form">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_rfc" class="col-form-label">RFC<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_rfc" class="form-control civika_mayus rfc_empresa_cotizacion"
                                           placeholder="RFC de la razón social" data-rule-required="true" <?=$disable?>
                                           name="datos_fiscales[rfc]" value="<?= isset($datos_fiscales) ? $datos_fiscales->rfc : ''?>">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_correo" class="col-form-label">Correo</label>
                                    <input id="input_datos_fiscales_correo" class="form-control"
                                           placeholder="Correo al que se le hara llegar la factura" <?=$disable?>
                                           data-rule-mail="true" name="datos_fiscales[correo]" value="<?= isset($datos_fiscales) ? $datos_fiscales->correo : ''?>">
                                </div>
                            </div>
                            <div class="row row_form">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_direccion" class="col-form-label">Domicilio fiscal<span
                                                class="requerido">*</span></label>
                                    <input id="input_datos_fiscales_direccion" class="form-control" <?=$disable?>
                                           placeholder="Domicilio fiscal de la razón social" data-rule-required="true"
                                           name="datos_fiscales[direccion_fiscal]" value="<?= isset($datos_fiscales) ? $datos_fiscales->direccion_fiscal : ''?>">
                                </div>
                            </div>
                            <div class="row row_form" id="row_uso_cfdi_persona_fisica" <?=isset($datos_fiscales) && strlen($datos_fiscales->rfc) == 13 ? '':'style="display: none;"'?>>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_uso_cfdi_fisica" class="col-form-label">Uso de CFDI 13<span
                                                class="requerido">*</span></label>
                                    <select id="input_datos_fiscales_uso_cfdi_fisica" class="custom-select" data-rule-required="true"
                                            name="uso_cfdi_fisica" <?=$disable?>>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($catalogo_uso_cfdi_persona_fisica as $cpf): ?>
                                            <option value="<?=$cpf->id_catalogo_uso_cfdi?>" <?=isset($datos_fiscales) && $datos_fiscales->id_catalogo_uso_cfdi == $cpf->id_catalogo_uso_cfdi ? 'selected="selected"':''?>><?='('.$cpf->clave.') '.$cpf->descripcion?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="row row_form" id="row_uso_cfdi_persona_moral" <?=isset($datos_fiscales) && strlen($datos_fiscales->rfc) == 12 ? '':'style="display: none;"'?>>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="input_datos_fiscales_uso_cfdi_moral" class="col-form-label">Uso de CFDI 12<span
                                                class="requerido">*</span></label>
                                    <select id="input_datos_fiscales_uso_cfdi_moral" class="custom-select" data-rule-required="true"
                                            name="uso_cfdi_moral" <?=$disable?>>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($catalogo_uso_cfdi_persona_moral as $cpf): ?>
                                            <option value="<?=$cpf->id_catalogo_uso_cfdi?>" <?=isset($datos_fiscales) && $datos_fiscales->id_catalogo_uso_cfdi == $cpf->id_catalogo_uso_cfdi ? 'selected="selected"':''?>><?='('.$cpf->clave.') '.$cpf->descripcion?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if(isset($comprobante_xml) && is_object($comprobante_xml)): ?>
                            <label class="col-form-label">Comprobante fiscal </label>
                        <?php endif; ?>

                        <div class="row">
                            <?php if(isset($comprobante_xml) && is_object($comprobante_xml)): ?>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="<?=$comprobante_xml->ruta_documento?>" class="btn btn-sm btn-info btn-pill" target="_blank"> Ver XML</a>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($comprobante_pdf) && is_object($comprobante_pdf)): ?>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                    <a href="<?=$comprobante_pdf->ruta_documento?>" class="btn btn-sm btn-danger btn-pill" target="_blank"> Ver PDF</a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                <?php if($cotizacion->id_catalogo_proceso_cotizacion == COTIZACION_RECIBIDA): ?>
                                    <button type="button" class="btn btn-sm btn-primary btn-success aceptar_cotizacion_empresa"> Enviar cotización</button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- divs de container -->
<div id="contenedor_agregar_modificar_cotizacion"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>