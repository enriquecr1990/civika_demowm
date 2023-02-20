<div class="modal fade" role="dialog" id="modal_registrar_modificar_sede_presencial">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($sede_presencial) ? 'Modificar':'Agregar'?> Sede Presencial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_sede_presencial">

                <input type="hidden" name="sede_presencial[id_sede_presencial]" value="<?=isset($sede_presencial) ? $sede_presencial->id_sede_presencial : ''?>">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Sede<span class="requerido">*</span></label>
                            <input id="input_nombre" class="form-control" placeholder="Nombre de la Sede"
                                   name="sede_presencial[nombre]" data-rule-required="true"
                                   value="<?=isset($sede_presencial) ? $sede_presencial->nombre : ''?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_link_mapa" class="col-form-label">Mapa<span class="requerido">*</span></label>
                            <input id="input_link_mapa" class="form-control" placeholder="Link del mapa"
                                   name="sede_presencial[link_mapa]" data-rule-required="true" data-rule-url="true"
                                   value="<?=isset($sede_presencial) ? $sede_presencial->link_mapa:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_telefono" class="col-form-label">Telefóno<span class="requerido">*</span></label>
                            <input id="input_telefono" class="form-control" placeholder="Telefóno principal"
                                   name="sede_presencial[telefono_principal]" data-rule-required="true"
                                   value="<?=isset($sede_presencial) ? $sede_presencial->telefono_principal : ''?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_telefono" class="col-form-label">Dirección<span class="requerido">*</span></label>
                            <textarea id="input_telefono" class="form-control" placeholder="Dirección"
                                      name="sede_presencial[direccion]" data-rule-required="true"><?=isset($sede_presencial) ? $sede_presencial->direccion : ''?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_entrada_libre" class="col-form-label">Entrada libre<span class="requerido">*</span></label>
                            <textarea id="input_entrada_libre" class="form-control" placeholder="Detalle la entrada libre de la Sede"
                                      data-rule-required="true" name="sede_presencial[entrada_libre]"><?=isset($sede_presencial) ? $sede_presencial->entrada_libre : ''?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_entrada_libre" class="col-form-label">Descuentos<span class="requerido">*</span></label>
                            <textarea id="input_entrada_libre" class="form-control" placeholder="Detalle los descuentos de la Sede"
                                      data-rule-required="true" name="sede_presencial[descuento_descripcion]"><?=isset($sede_presencial) ? $sede_presencial->descuento_descripcion : ''?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_entrada_libre" class="col-form-label">Informes e inscripciones<span class="requerido">*</span></label>
                            <select class="custom-select" name="informe_sede[]" data-rule-required="true" multiple>
                                <?php foreach ($usuarios_admin as $ua): ?>
                                    <option value="<?=$ua->id_usuario?>"><?=$ua->nombre.' '.$ua->apellido_p?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_sede_presencial">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>