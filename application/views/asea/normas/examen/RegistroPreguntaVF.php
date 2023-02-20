<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="min-width: 65%">Opción</th>
                <th>Respuesta</th>
            </tr>
            </thead>
            <tbody id="tbodyRespuestaPreguntaVF">
            <?php if(isset($opcion_pregunta_norma_asea)): ?>
                <?php foreach($opcion_pregunta_norma_asea as $op): ?>
                    <tr>
                        <td>
                            <input class="form-control" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][descripcion]" data-rule-required="true"
                                   placeholder="Describa la repuesta a la pregunta" readonly="readonly" value="<?=$op->descripcion?>" >
                        </td>
                        <td>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" data-rule-required="true"
                                            <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           value="correcta" <?=$op->tipo_respuesta == 'correcta' ? 'checked="checked"':''?> >
                                </div>
                                <span class="col-sm-4">Correcta</span>
                                <div class="col-sm-2">
                                    <input type="radio" name="opcion_pregunta_norma_asea[<?=$op->id_opcion_pregunta?>][tipo_respuesta]" data-rule-required="true"
                                            <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                           value="incorrecta" <?=$op->tipo_respuesta == 'incorrecta' ? 'checked="checked"':''?>>
                                </div>
                                <span class="col-sm-4">Incorrecta</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>
                        <input class="form-control" readonly="readonly" name="opcion_pregunta_norma_asea[1][descripcion]"
                               data-rule-required="true" placeholder="Describa la repuesta a la pregunta" value="Verdadero">
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <input type="radio" name="opcion_pregunta_norma_asea[1][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?> data-rule-required="true" value="correcta">
                            </div>
                            <span class="col-sm-4">Correcta</span>
                            <div class="col-sm-2">
                                <input type="radio" name="opcion_pregunta_norma_asea[1][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?> data-rule-required="true" value="incorrecta">
                            </div>
                            <span class="col-sm-4">Incorrecta</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="form-control" readonly="readonly" name="opcion_pregunta_norma_asea[2][descripcion]"
                               data-rule-required="true" placeholder="Describa la repuesta a la pregunta" value="Falso">
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <input type="radio" name="opcion_pregunta_norma_asea[2][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?> data-rule-required="true" value="correcta">
                            </div>
                            <span class="col-sm-4">Correcta</span>
                            <div class="col-sm-2">
                                <input type="radio" name="opcion_pregunta_norma_asea[2][tipo_respuesta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?> data-rule-required="true" value="incorrecta">
                            </div>
                            <span class="col-sm-4">Incorrecta</span>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="col-sm-12">
            <div class="error_validaciones_pregunta_vf"></div>
        </div>
    </div>
</div>