<div class="card" style="position: relative !important;">
    <div class="card-header">
        Examen de evaluación - <?=$evaluacion_publicacion_ctn->titulo_evaluacion?>
    </div>
    <div class="card-body">

        <?php if(isset($evaluacion_alumno_publicacion_ctn) && is_object($evaluacion_alumno_publicacion_ctn)
            && isset($pregunta_publicacion_ctn) && is_array($pregunta_publicacion_ctn)): ?>
            <?php foreach ($pregunta_publicacion_ctn as $index => $prt): ?>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 text-justify">
                        <label>
                            <?= $index + 1 ?>.- <?= $prt->pregunta ?>
                            <?php if(isset($respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['es_correcta']) && $respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['es_correcta']): ?>
                                <span class="badge badge-success">Correcta</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Incorrecta</span>
                            <?php endif; ?>
                        </label>
                    </div>
                </div>
                <?php if (in_array($prt->id_opciones_pregunta, array(OPCION_VERDADERO_FALSO, OPCION_UNICA_OPCION, OPCION_IMAGEN_UNICA_OPCION))): ?>
                    <div class="row">
                        <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                            <label class="custom-control-label" >
                                <?php if(isset($respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['op_seleccionada']) && $respuestas_alumno[$prt->id_pregunta_publicacion_ctn]['op_seleccionada'] == $opciones->id_opcion_pregunta_publicacion_ctn): ?>
                                    <span class="badge badge-pill badge-outline-info" style="white-space: normal !important; text-align: justify"><?= $opciones->descripcion ?></span>
                                <?php else: ?>
                                    <?= $opciones->descripcion ?>
                                <?php endif; ?>
                            </label>
                            <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                <div>
                                    <img class="img-thumbnail" style="width: 100px !important;"
                                         src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                         alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (in_array($prt->id_opciones_pregunta, array(OPCION_OPCION_MULTIPLE, OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
                    <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $opciones): ?>
                        <label class="custom-control-label" >
                            <?php if(in_array($opciones->id_opcion_pregunta_publicacion_ctn,$prt->respuestas_alumno)): ?>
                                <span class="badge badge-pill badge-outline-info" style="white-space: normal !important; text-align: justify"><?= $opciones->descripcion ?></span>
                            <?php else: ?>
                                <?= $opciones->descripcion ?>
                            <?php endif; ?>
                        </label>
                        <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                            <div>
                                <img class="img-thumbnail" style="width: 100px !important;"
                                     src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                     alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php elseif ($prt->id_opciones_pregunta == OPCION_SECUENCIAL): ?>
                    <table class="table table-striped data-table">
                        <thead>
                        <tr>
                            <th width="15%">Orden cronológico</th>
                            <th>Opción</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($prt->opciones_pregunta_publicacion_ctn as $index_op => $opciones): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-pill badge-outline-info" ><?=isset($prt->respuestas_alumno[$index_op]) ? $prt->respuestas_alumno[$index_op] : 'Sin respuesta'?></span>
                                    </td>
                                    <td>
                                        <label for="secuencial_<?= $opciones->id_opcion_pregunta_publicacion_ctn ?>"><?= $opciones->descripcion ?></label>
                                        <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                            <div>
                                                <img class="img-thumbnail" style="width: 100px !important;"
                                                     src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                     alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php elseif ($prt->id_opciones_pregunta == OPCION_RELACIONAL): ?>
                    <table class="table table-striped data-table">
                        <?php foreach ($prt->opciones_pregunta_publicacion_ctn_izq as $index => $opciones): ?>
                            <tr>
                                <!-- izq -->
                                <td width="5%">
                                    <button type="button"
                                            class="btn btn-outline-success btn-pill btn-sm draggable_btn"><?= $opciones->consecutivo ?></button>
                                </td>
                                <td>
                                    <span><?= $opciones->descripcion ?></span>
                                    <?php if (isset($opciones->documento_imagen_respuesta) && is_object($opciones->documento_imagen_respuesta)): ?>
                                        <div>
                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                 src="<?= $opciones->documento_imagen_respuesta->ruta_documento ?>"
                                                 alt="<?= $opciones->documento_imagen_respuesta->nombre ?>">
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <!-- der -->
                                <td width="12%">
                                    <span class="badge badge-pill badge-outline-info" ><?=isset($prt->respuestas_alumno[$index]) ? $prt->respuestas_alumno[$index] : 'Sin respuesta'?></span>
                                </td>
                                <td>
                                    <label for="relacional_<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->id_opcion_pregunta_publicacion_ctn ?>"><?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->descripcion ?></label>
                                    <?php if (isset($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta) && is_object($prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta)): ?>
                                        <div>
                                            <img class="img-thumbnail" style="width: 100px !important;"
                                                 src="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->ruta_documento ?>"
                                                 alt="<?= $prt->opciones_pregunta_publicacion_ctn_der[$index]->documento_imagen_respuesta->nombre ?>">
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="card-footer">
        <button id="btn_cerrar_evaluacion_lectura" type="button" class="btn btn-sm btn-pill btn-primary">Cerrar evaluacion</button>
    </div>
</div>