<div class="modal fade" role="dialog" id="modal_encuesta_satisfaccion_admin">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Encuesta de satisfacción</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_encuesta_satisfaccion_admin">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12 col-sm-12 col-xs-12 col-12">
                            <div class="alert alert-info">
                                Registre unicamente la cantidad en porcentaje de las encuestas aplicadas a los alumnos.
                                <br>No es necesario que guarde el sistema lo almacenará de forma automática
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <th width="40%" colspan="3">Pregunta</th>
                            <?php foreach ($encabezados_preguntas as $ep): ?>
                                <th width="12%"><?= $ep->opcion ?></th>
                            <?php endforeach; ?>
                            </thead>
                            <tbody>
                            <?php foreach ($pregunta_encuesta_satisfaccion as $index => $pes): ?>
                                <?php if ($index != 10): ?>
                                    <tr>
                                        <td colspan="3">
                                            <?= $index + 1 ?>.- <?= $pes->pregunta ?>
                                        </td>
                                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $ores): ?>
                                            <td>
                                                <div class="input-group with-addon-icon-right">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                    <input class="form-control civika_actualizacion_campo"
                                                           min="0" max="100" required
                                                           data-url_peticion="<?=base_url()?>AdministrarCTN/actualizar_dato_encuesta_admin"
                                                           data-tabla_update="encuesta_satisfaccion"
                                                           data-campo_update="respuesta"
                                                           data-id_campo_update="id_encuesta_satisfaccion"
                                                           data-id_value_update="<?=$ores->id_encuesta_satisfaccion?>"
                                                           placeholder="<?= $ores->opcion ?>"
                                                           value="<?= $ores->respuesta ?>">
                                                </div>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8">
                                            <?= $index + 1 ?>.- <?= $pes->pregunta ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $ores): ?>
                                            <td><?= $ores->opcion ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($pes->opcion_respuesta_encuesta_satisfaccion as $ores): ?>
                                            <td>
                                                <div class="input-group with-addon-icon-right">
                                                    <span class="input-group-addon">
                                                        %
                                                    </span>
                                                    <input class="form-control civika_actualizacion_campo" placeholder="<?= $ores->opcion ?>"
                                                           min="0" max="100" required
                                                           data-url_peticion="<?=base_url()?>AdministrarCTN/actualizar_dato_encuesta_admin"
                                                           data-tabla_update="encuesta_satisfaccion"
                                                           data-campo_update="respuesta"
                                                           data-id_campo_update="id_encuesta_satisfaccion"
                                                           data-id_value_update="<?=$ores->id_encuesta_satisfaccion?>"
                                                           value="<?= $ores->respuesta ?>">
                                                </div>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </form>

        </div>

    </div>
</div>
</div>