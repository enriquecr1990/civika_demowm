<div class="modal fade" role="dialog" id="modal_registrar_modificar_norma">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><?=$titulo_norma?></h5>
            </div>
            <form class="form-horizontal" id="form_guardar_norma_asea">
                <input type="hidden" name="normas_asea[id_normas_asea]" value="<?=isset($normas_asea) ? $normas_asea->id_normas_asea : ''?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div id="guardar_form_busqueda_normas_asea_modal">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Nombre:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Nombre norma" data-rule-required="true"
                                   name="normas_asea[nombre]" value="<?=isset($normas_asea) ? $normas_asea->nombre : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Duración:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Duración norma (horas)" data-rule-required="true"
                                   name="normas_asea[duracion]" value="<?=isset($normas_asea) ? $normas_asea->duracion : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Instructor:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Instructor norma" data-rule-required="true"
                                   name="normas_asea[instructor]" value="<?=isset($normas_asea) ? $normas_asea->instructor : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Fecha inicio:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input class="form-control datepicker" data-rule-required="true"
                                   placeholder="Fecha inicio" name="normas_asea[fecha_inicio]"
                                   value="<?=isset($normas_asea) ? fechaBDToHtml($normas_asea->fecha_inicio): ''?>">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                            </div>
                        </div>
                        <label class="col-sm-2">Fecha fin:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input class="form-control datepicker" data-rule-required="true"
                                       placeholder="Fecha fin" name="normas_asea[fecha_fin]"
                                       value="<?=isset($normas_asea) ? fechaBDToHtml($normas_asea->fecha_fin) : ''?>">
                                <div class="input-group-addon"><span style="width: 80%; height: 80%;" class="glyphicon glyphicon-calendar"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Ocupacion específica:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Ocupacion específica" data-rule-required="true"
                                   name="normas_asea[ocupacion_especifica]" value="<?=isset($normas_asea) ? $normas_asea->ocupacion_especifica : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Agente capacitador:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Agente capacitador" data-rule-required="true"
                                   name="normas_asea[agente_capacitador]" value="<?=isset($normas_asea) ? $normas_asea->agente_capacitador : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Área temática:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Área temática" data-rule-required="true"
                                   name="normas_asea[area_tematica]" value="<?=isset($normas_asea) ? $normas_asea->area_tematica : ''?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Año:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="normas_asea[anio]" data-rule-required="true">
                                <option value="">Seleccione</option>
                                <?php foreach ($catalogo_anios as $anio){ ?>
                                    <option value="<?=$anio?>" <?=(isset($normas_asea) && $normas_asea->anio == $anio) ? 'selected="selected"':''?>><?=$anio?></option>
                                <?php }?>
                            </select>
                        </div>
                        <label class="col-sm-3">Orden norma:</label>
                        <div class="col-sm-3">
                            <select class="form-control"  name="normas_asea[orden_norma]" data-rule-required="true">
                                <option value="">Seleccione</option>
                                <?php foreach ($catalogo_ordenamiento_norma as $ordenamiento){ ?>
                                    <option value="<?=$ordenamiento?>" <?=(isset($normas_asea) && $normas_asea->orden_norma == $ordenamiento) ? 'selected="selected"':''?>><?=$ordenamiento?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Horario:</label>
                        <div class="col-sm-10">
                            <input class="form-control" placeholder="Horario" data-rule-required="true"
                                   name="normas_asea[horario]" value="<?=isset($normas_asea) ? $normas_asea->horario : ''?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-sm guardar_norma_asea">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>