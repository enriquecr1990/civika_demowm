<div class="modal fade" role="dialog" id="modal_registrar_modificar_ocupacion_especifica">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($ocupacion_especifica) ? 'Modificar':'Agregar'?> ocupación específica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_catalogo_ocupacion_especifica">

                <input type="hidden" name="catalogo_ocupacion_especifica[id_catalogo_ocupacion_especifica]" value="<?=isset($ocupacion_especifica) ? $ocupacion_especifica->id_catalogo_ocupacion_especifica : ''?>">

                <div class="col-sm-12">
                    <div id="form_mensajes_ocupacion_especifica" class="mensajes_sistema_civik"></div>
                </div>

                <div class="modal-body">

                    <?php if(isset($es_sub_area) && $es_sub_area): ?>
                        <div class="row row_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="slt_area_principal" class="col-form-label">Área principal</label>
                                <select class="custom-select d-block" name="catalogo_ocupacion_especifica[id_catalogo_ocupacion_especifica_parent]" data-rule-required="true">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($areas as $a): ?>
                                        <option value="<?=$a->id_catalogo_ocupacion_especifica?>" <?=isset($ocupacion_especifica) && $ocupacion_especifica->id_catalogo_ocupacion_especifica_parent == $a->id_catalogo_ocupacion_especifica ? 'selected="selected"':''?>><?=$a->clave_area_subarea.' '.$a->denominacion?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row row_form">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_clave_area" class="col-form-label">Clave de área</label>
                            <input id="input_clave_area" class="form-control" placeholder="Clave de área"
                                   name="catalogo_ocupacion_especifica[clave_area_subarea]" data-rule-required="true"
                                   value="<?=isset($ocupacion_especifica) ? $ocupacion_especifica->clave_area_subarea:''?>">
                        </div>
                    </div>

                    <div class="row row_form">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="textarea_denominacion" class="col-form-label">Denominación</label>
                            <textarea id="textarea_denominacion" class="form-control" placeholder="Descripcion de la denominacion"
                                      name="catalogo_ocupacion_especifica[denominacion]"
                                      data-rule-required="true" rows="5"><?=isset($ocupacion_especifica) ? $ocupacion_especifica->denominacion : ''?></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_catalogo_ocupacion_especifica">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>