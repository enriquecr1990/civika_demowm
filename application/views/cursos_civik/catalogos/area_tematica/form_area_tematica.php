<div class="modal fade" role="dialog" id="modal_registrar_modificar_area_tematica">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($area_tematica) ? 'Modificar':'Agregar'?> área temática</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_catalogo_area_tematica">

                <input type="hidden" name="catalogo_area_tematica[id_catalogo_area_tematica]" value="<?=isset($area_tematica) ? $area_tematica->id_catalogo_area_tematica : ''?>">

                <div class="col-sm-12">
                    <div id="form_mensajes_area_tematica" class="mensajes_sistema_civik"></div>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_clave" class="col-form-label">Clave</label>
                            <input id="input_clave" class="form-control" placeholder="Clave del área temática"
                                   name="catalogo_area_tematica[clave]" data-rule-required="true"
                                   value="<?=isset($area_tematica) ? $area_tematica->clave:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_denominacion" class="col-form-label">Denominación</label>
                            <input id="input_denominacion" class="form-control" placeholder="Denominación del área temática"
                                   name="catalogo_area_tematica[denominacion]" data-rule-required="true"
                                   value="<?=isset($area_tematica) ? $area_tematica->denominacion:''?>">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_catalogo_area_tematica">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>