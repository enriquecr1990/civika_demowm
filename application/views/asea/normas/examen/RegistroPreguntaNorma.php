<div class="modal fade" role="dialog" id="modal_registro_pregunta_norma_asea">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=isset($pregunta_norma_asea) ? 'Modifique' : 'Registre'?> su pregunta con sus respuestas</h4>
            </div>
            <form class="form-horizontal" id="form_registro_pregunta_norma">
                <input type="hidden" name="preguntas_normas_asea[id_preguntas_normas_asea]" value="<?=isset($pregunta_norma_asea) ? $pregunta_norma_asea->id_preguntas_normas_asea : ''?>">
                <input type="hidden" name="preguntas_normas_asea[id_normas_asea]" value="<?=$normas_asea->id_normas_asea?>">
                <div id="conteiner_mensaje_registro_pregunta_norma"></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="es_nombre">Pregunta:</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" data-rule-required="true" placeholder="Describa la pregunta de la norma" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?>
                                      name="preguntas_normas_asea[pregunta]"><?=isset($pregunta_norma_asea) ? $pregunta_norma_asea->pregunta : ''?></textarea>
                        </div>
                        <label class="col-sm-3 control-label" for="es_nombre">Tipo de pregunta:</label>
                        <div class="col-sm-4">
                            <select class="form-control select_tipo_pregunta" data-rule-required="true" name="preguntas_normas_asea[id_opciones_pregunta]" <?=isset($tiene_evaluacion_norma) && $tiene_evaluacion_norma  ? 'disabled="disabled"' : '' ?> >
                                <option value="">Seleccione</option>
                                <?php foreach($catalogo_opciones_pregunta as $op): ?>
                                    <option value="<?=$op->id_opciones_pregunta?>" <?=(isset($pregunta_norma_asea) && $pregunta_norma_asea->id_opciones_pregunta == $op->id_opciones_pregunta) ? 'selected="selected"':''?>><?=$op->opcion_pregunta?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="conteiner_tipo_pregunta_para_respuestas">
                            <?php if(isset($pregunta_norma_asea)): ?>
                                <?php $this->load->view('asea/normas/examen/'.$vista_preguntas,array('opcion_pregunta_norma_asea' => $pregunta_norma_asea->respuestas)); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <div class="col-sm-13" style="text-align: center">
                            <?php if(!$tiene_evaluacion_norma): ?>
                                <button type="button" class=" btn btn-success btn-sm guardar_preguntas_respuestas_norma">Aceptar</button>
                                <button type="button" class=" btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                            <?php else: ?>
                                <button type="button" class=" btn btn-success btn-sm" data-dismiss="modal">Cerrar</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>