<div class="modal fade" role="dialog" id="modal_registrar_modificar_forma_pago">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($formas_pago) ? 'Modificar':'Agregar'?> forma de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_catalogo_formas_pago">

                <input type="hidden" name="catalogo_formas_pago[id_catalogo_formas_pago]" value="<?=isset($formas_pago) ? $formas_pago->id_catalogo_formas_pago : ''?>">

                <div class="col-sm-12">
                    <div id="form_mensajes_formas_pago" class="mensajes_sistema_civik"></div>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_banco" class="col-form-label">Banco<span class="requerido">*</span></label>
                            <input type="text" id="input_banco" class="form-control" placeholder="Nombre del banco"
                            name="catalogo_formas_pago[banco]" data-rule-required="true"
                            value="<?=isset($formas_pago) ? $formas_pago->banco:''?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_sucursal" class="col-form-label">Sucursal</label>
                            <input type="text" id="input_sucursal" class="form-control" placeholder="Sucursal bancaria (opcional)"
                            name="catalogo_formas_pago[sucursal]"
                            value="<?=isset($formas_pago) ? $formas_pago->sucursal:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label  for="input_numero_tarjeta" class="col-form-label">Número de tarjeta</label>
                            <input type="number"  id="input_numero_tarjeta" class="form-control" placeholder="Número de tarjeta"
                            name="catalogo_formas_pago[numero_tarjeta]"
                            data-rule-maxlength="16" data-rule-minlength="16"
                            value="<?=isset($formas_pago) ? $formas_pago->numero_tarjeta:''?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_clabe" class="col-form-label">Clabe</label>
                            <input type="number"   id="input_clabe" class="form-control" placeholder="Clabe interbancaria"
                            name="catalogo_formas_pago[clabe]" 
                            data-rule-maxlength="18" data-rule-minlength="18"
                            value="<?=isset($formas_pago) ? $formas_pago->clabe:''?>">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_cuenta" class="col-form-label">Cuenta</label>
                            <input  type="number" id="input_cuenta" class="form-control" placeholder="Número de cuenta"
                            name="catalogo_formas_pago[cuenta]" 

                            value="<?=isset($formas_pago) ? $formas_pago->cuenta:''?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_titular" class="col-form-label">Titular</label>
                            <input type="text" id="input_titular" class="form-control" placeholder="Titular de la cuenta"
                            name="catalogo_formas_pago[titular]" 
                            value="<?=isset($formas_pago) ? $formas_pago->titular:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <label for="input_titulo" class="col-form-label">Titulo de Pago<span class="requerido">*</span> <span class="help-span">Para PDF</span></label>
                            <input type="text" id="input_titulo" class="form-control" placeholder="Titulo de Pago"
                            name="catalogo_formas_pago[titulo_pago]"
                            data-rule-required="true"
                            value="<?=isset($formas_pago) ? $formas_pago->titulo_pago:''?>">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm btn-pill guardar_catalogo_formas_pago">Aceptar</button>
                        <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>