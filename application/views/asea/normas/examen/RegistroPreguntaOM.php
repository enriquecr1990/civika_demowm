<div class="col-xs-12 col-sm-12 col-md-12">
    <?php if(!isset($tiene_evaluacion_norma)):?>
    <div class="form-group">
        <div class="col-sm-12 derecha">
            <button class="btn btn-info btn-xs asea_agregar_row_tabla"
                    id="btnAgregarPreguntaOM"
                    data-row_destino="#tbodyRespuestaPreguntaOM"
                    data-row_origen="#newRowRespuestaPreguntaOM">
                <i class="glyphicon glyphicon-plus"></i>Agregar respuesta
            </button>
        </div>
    </div>
    <?php endif; ?>
    <div id="newRowRespuestaPreguntaOM">
        <!--<tr>
            <td>
                <input class="form-control" name="opcion_pregunta_norma_asea[{id}][descripcion]"
                                   data-rule-required="true" placeholder="Describa la repuesta a la pregunta" value="" >
            </td>
            <td>
                <div class="col-sm-12">
                    <div class="col-sm-2"><input type="radio" data-rule-required="true" name="opcion_pregunta_norma_asea[{id}][tipo_respuesta]" value="correcta"></div>
                    <label class="col-sm-4">Correcta</label>
                    <div class="col-sm-2"><input type="radio" data-rule-required="true" name="opcion_pregunta_norma_asea[{id}][tipo_respuesta]" value="incorrecta"></div>
                    <label class="col-sm-4">Incorrecta</label>
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-xs eliminar_row_tabla" data-toggle="tooltip"
                        data-placement="bottom" title="Eliminar respuesta" >
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </td>
        </tr>-->
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="min-width: 60%">Opción</th>
                <th>Respuesta</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="tbodyRespuestaPreguntaOM">
            <?php if(isset($opcion_pregunta_norma_asea)): ?>
                <?php foreach($opcion_pregunta_norma_asea as $op): ?>
                    <tr>
                        <td>
                            <input class="form-control" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][descripcion]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                   data-rule-required="true" placeholder="Describa la repuesta a la pregunta" value="<?=$op->descripcion?>" >
                        </td>
                        <td>
                            <div class="col-sm-12">
                                <div class="col-sm-2">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           data-rule-required="true" value="correcta" <?=$op->tipo_respuesta == 'correcta' ? 'checked="checked"':''?> >
                                </div>
                                <label class="col-sm-4">Correcta</label>
                                <div class="col-sm-2">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           data-rule-required="true" value="incorrecta" <?=$op->tipo_respuesta == 'incorrecta' ? 'checked="checked"':''?>>
                                </div>
                                <label class="col-sm-4">Incorrecta</label>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="col-sm-12">
            <div class="error_validaciones_pregunta_om"></div>
        </div>
    </div>
</div>