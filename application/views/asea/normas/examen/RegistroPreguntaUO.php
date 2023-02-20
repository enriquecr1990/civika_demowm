<div class="col-xs-12 col-sm-12 col-md-12">
    <?php if(!isset($tiene_evaluacion_norma)):?>
    <div class="form-group">
        <div class="col-sm-12 derecha">
            <button class="btn btn-info btn-xs asea_agregar_row_tabla"
                    id="btnAgregarPreguntaUO"
                    data-row_destino="#tbodyRespuestaPreguntaUO"
                    data-row_origen="#newRowRespuestaPreguntaUO">
                <i class="glyphicon glyphicon-plus"></i>Agregar respuesta
            </button>
        </div>
    </div>
    <?php endif; ?>
    <div id="newRowRespuestaPreguntaUO">
        <!--<tr>
            <td>
                <input class="form-control" name="opcion_pregunta_norma_asea[{id}][descripcion]" data-rule-required="true"
                                   placeholder="Describa la repuesta a la pregunta" value="" >
            </td>
            <td>
                <div class="form-group">
                    <div class="col-sm-2">
                        <input type="radio" name="opcion_pregunta_norma_asea[{id}][tipo_respuesta]" data-rule-required="true" value="correcta">
                    </div>
                    <span class="col-sm-4">Correcta</span>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <input type="radio" name="opcion_pregunta_norma_asea[{id}][tipo_respuesta]" data-rule-required="true" value="incorrecta">
                    </div>
                    <span class="col-sm-4">Incorrecta</span>
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
            <tbody id="tbodyRespuestaPreguntaUO">
            <?php if(isset($opcion_pregunta_norma_asea)): ?>
                <?php foreach($opcion_pregunta_norma_asea as $op): ?>
                    <tr>
                        <td>
                            <input class="form-control" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][descripcion]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                   data-rule-required="true" placeholder="Describa la repuesta a la pregunta" value="<?=$op->descripcion?>" >
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-1">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           data-rule-required="true" value="correcta" <?=$op->tipo_respuesta == 'correcta' ? 'checked="checked"':''?> >
                                </div>
                                <span class="col-sm-4">Correcta</span>
                                <div class="col-sm-1">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           data-rule-required="true" value="incorrecta" <?=$op->tipo_respuesta == 'incorrecta' ? 'checked="checked"':''?>>
                                </div>
                                <span class="col-sm-4">Incorrecta</span>
                            </div>
                        </td>
                        <td>
                            <?php if(!$tiene_evaluacion_norma): ?>
                                <button class="btn btn-danger btn-xs eliminar_reglon_tabla" data-toggle="tooltip"
                                        data-placement="bottom" title="Eliminar respuesta" type="button">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="col-sm-12">
            <div class="error_validaciones_pregunta_uo"></div>
        </div>
    </div>
</div>