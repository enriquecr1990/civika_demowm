<div class="modal fade" role="dialog" id="modal_registrar_modificar_aula">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($aula) ? 'Modificar':'Agregar'?> aula</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_catalogo_aula">

                <input type="hidden" name="catalogo_aula[id_catalogo_aula]" value="<?=isset($aula) ? $aula->id_catalogo_aula : ''?>">

                <div class="col-sm-12">
                    <div id="form_mensajes_aula" class="mensajes_sistema_civik"></div>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_campus" class="col-form-label">Campus</label>
                            <input id="input_campus" class="form-control" placeholder="Campus del aula"
                                   name="catalogo_aula[campus]" data-rule-required="true"
                                   value="<?=isset($aula) ? $aula->campus:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_nombre_aula" class="col-form-label">Nombre del aula</label>
                            <input id="input_campus" class="form-control" placeholder="Nombre del aula"
                                   name="catalogo_aula[aula]" data-rule-required="true"
                                   value="<?=isset($aula) ? $aula->aula:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_nombre_aula" class="col-form-label">Capacidad de alumnos</label>
                            <input id="input_campus" class="form-control" placeholder="Capacidad de alumnos del aula"
                                   name="catalogo_aula[cupo]" data-rule-required="true" data-rule-number="true"
                                   value="<?=isset($aula) ? $aula->cupo:''?>">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_catalogo_aula">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>