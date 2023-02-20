<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Tipo pregunta</th>
            <th>Pregunta</th>
            <th>Respuesta(s) correcta(s)</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="tbodyPreguntasNorma">
        <?php if (isset($normas_asea->editar_preguntas) && $normas_asea->editar_preguntas): ?>
            <?php foreach ($preguntas_normas_asea as $pn): ?>
                <tr>
                    <td><?=$pn->opcion_pregunta?></td>
                    <td><?=$pn->pregunta?></td>
                    <td>
                        <ul>
                            <?php foreach($pn->respuestas_correctas as $rc): ?>
                                <li><?=$rc->descripcion?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs modificar_pregunta_repuesta_norma" data-toggle="tooltip"
                                data-id_normas_asea="<?=$normas_asea->id_normas_asea?>"
                                data-id_preguntas_norma_asea="<?=$pn->id_preguntas_normas_asea?>"
                                data-placement="bottom" title="<?=$tiene_evaluacion_norma ? 'Ver pregunta norma':'Editar pregunta de la norma'?>">
                            <span class="glyphicon glyphicon-<?=$tiene_evaluacion_norma ? 'bookmark':'pencil'?>"></span>
                        </button>
                        <?php if(!$tiene_evaluacion_norma): ?>
                            <button type="button" class="btn btn-danger btn-xs elminar_pregunta_norma_asea" data-toggle="tooltip"
                                    data-url="NormasAsea/eliminarPreguntaNormaAsea/<?=$pn->id_preguntas_normas_asea?>"
                                    data-btn_trigger=".buscar_preguntas_respuestas_norma"
                                    data-placement="bottom" title="Eliminar pregunta de la norma" >
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach ($preguntas_norma as $pn): ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
