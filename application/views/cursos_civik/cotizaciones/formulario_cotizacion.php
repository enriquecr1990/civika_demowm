<div class="modal fade" role="dialog" id="modal_cotizacion_curso">
    <div class="modal-dialog modal-slg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label><?=isset($cotizacion) ? 'Modificar':'Agregar'?> cotización</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_guardar_cotizacion_curso">

                <div class="modal-body">

                    <input type="hidden" name="cotizacion[id_cotizacion]" value="<?=isset($cotizacion) ? $cotizacion->id_cotizacion:''?>">

                    <div class="row">
                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_representante" class="col-form-label">Destinatario (representante)<span class="requerido">*</span></label>
                            <input id="input_representante" type="text" class="form-control" data-rule-required="true" <?=isset($cotizacion) && $cotizacion->id_catalogo_proceso_cotizacion > COTIZACION_REALIZADA ? 'readonly="readonly"':''?>
                                   placeholder="Persona quien recibe" name="cotizacion[persona_recibe]" value="<?=isset($cotizacion) ? $cotizacion->persona_recibe : ''?>">
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_empresa" class="col-form-label">Empresa<span class="requerido">*</span></label>
                            <input id="input_empresa" type="text" class="form-control" data-rule-required="true" <?=isset($cotizacion) && $cotizacion->id_catalogo_proceso_cotizacion > COTIZACION_REALIZADA ? 'readonly="readonly"':''?>
                                   placeholder="Nombre de la empresa" name="cotizacion[empresa]" value="<?=isset($cotizacion) ? $cotizacion->empresa : ''?>">
                        </div>

                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_empresa" class="col-form-label">Correo<span class="requerido">*</span></label>
                            <input id="input_empresa" type="text" class="form-control" data-rule-required="true" <?=isset($cotizacion) && $cotizacion->id_catalogo_proceso_cotizacion > COTIZACION_ORDEN_COMPRA ? 'readonly="readonly"':''?>
                                   placeholder="Correo para enviar la cotización" name="cotizacion[correo]" value="<?=isset($cotizacion) ? $cotizacion->correo : ''?>">
                            <span class="help-span">Es el correo al cual se mandará la cotización, puede mandar a mas de un correo si lo separa por una coma ","</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label for="curso_taller_norma" class="col-form-label">Curso STPS<span class="requerido">*</span></label>
                            <select id="curso_taller_norma" class="custom-select" name="cotizacion[id_curso_taller_norma]"
                                    <?=isset($cotizacion) && $cotizacion->id_catalogo_proceso_cotizacion > COTIZACION_REALIZADA ? 'disabled="disabled"':''?> data-rule-required="true">
                                <option value="">Seleccione</option>
                                <?php foreach ($cursos_stps as $c): ?>
                                    <option value="<?=$c->id_curso_taller_norma?>" <?=isset($cotizacion) && $cotizacion->id_curso_taller_norma == $c->id_curso_taller_norma ? 'selected="selected"':''?>><?=$c->clave.' '.$c->denominacion.' - '.$c->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-9 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_temario" class="col-form-label">Temario<span class="requerido">*</span></label>
                            <textarea id="input_temario" type="text" class="form-control" data-rule-required="true"
                                      placeholder="Temario del curso" name="cotizacion[temario]"><?=isset($cotizacion) ? $cotizacion->temario : ''?></textarea>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_num_repressentantes" class="col-form-label">Número de participantes<span class="requerido">*</span></label>
                            <input id="input_num_repressentantes" type="number" class="form-control" data-rule-required="true"
                                   placeholder="Número de participantes" name="cotizacion[participantes]" value="<?=isset($cotizacion) ? $cotizacion->participantes : ''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_duracion" class="col-form-label">Duración (horas)<span class="requerido">*</span></label>
                            <input id="input_duracion" type="text" class="form-control" data-rule-required="true"
                                   placeholder="Duración en horas" name="cotizacion[duracion]" value="<?=isset($cotizacion) ? $cotizacion->duracion : ''?>">
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_costo_hora" class="col-form-label">Costo por hora<span class="requerido">*</span></label>
                            <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <input id="input_costo_hora" class="form-control" type="number" data-rule-required="true" data-rule-number="true"
                                       name="cotizacion[costo_hora]" placeholder="Costo" value="<?=isset($cotizacion) ? $cotizacion->costo_hora : ''?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-4 col-sm-12 col-12">
                            <label for="input_fecha_vigencia" class="col-form-label">Fecha de vencimiento<span class="requerido">*</span></label>
                            <div class="input-group with-addon-icon-left">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input id="input_fecha_vigencia" class="form-control datepicker_shards"
                                       placeholder="Fecha de vencimiento" data-rule-required="true"
                                       name="cotizacion[fecha_fin_vigencia]" value="<?=isset($cotizacion) ? fechaBDToHtml($cotizacion->fecha_fin_vigencia) : ''?>">
                            </div>
                        </div>

                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_iva" class="col-form-label">IVA (porciento)</label>
                            <input id="input_iva" class="form-control" type="number" data-rule-number="true" min="0"
                                   name="cotizacion[iva]" placeholder="IVA" value="<?=isset($cotizacion) ? $cotizacion->iva : ''?>">
                            <span class="help-span">En caso de aplicar, poner valor</span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_temario" class="col-form-label">Notas comerciales<span class="requerido">*</span></label>
                            <textarea id="input_temario" type="text" class="form-control" data-rule-required="true"
                                      placeholder="Notas comerciales de la cotiazción" name="cotizacion[notas_comerciales]"><?=isset($cotizacion) ? $cotizacion->notas_comerciales : ''?></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-pill btn-sm guardar_cotizacion">
                        Guardar cotización
                    </button>
                    <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>