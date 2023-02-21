<div class="modal fade" role="dialog" id="modal_resultados_evaluacion">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Resultados de la evaluación</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <div class="table-responsive">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <table class="table table-striped">
                            <thead>
                            <th>#</th>
                            <th>Titulo evaluación (Tipo)</th>
                            <th>Fecha</th>
                            <th>Calificación</th>
                            </thead>
                            <tbody>
                            <?php if(isset($evaluaciones_alumno) && is_array($evaluaciones_alumno) && sizeof($evaluaciones_alumno) != 0):?>
                                <?php foreach ($evaluaciones_alumno as $index => $ea): ?>
                                <tr>
                                    <td><?=$index + 1?></td>
                                    <td><?=isset($ea->titulo_evaluacion) && existe_valor($ea->titulo_evaluacion) ? $ea->titulo_evaluacion : $ea->tipo?></td>
                                    <td><?=fechaHoraBDToHTML($ea->fecha_envio)?></td>
                                    <td>
                                        <span class="badge badge-<?=$ea->etiqueta_evaluacion?>"><?=$ea->calificacion_evaluacion?></span>
                                        <br class="mb-1">
                                        <a href="<?=base_url()?>DocumentosPDF/evaluacion_lectura/<?=$id_publicacion_ctn.'/'.$ea->tipo.'/'.$ea->id_evaluacion_alumno_publicacion_ctn?>" target="_blank" class="btn btn-sm btn-pill btn-info">Ver evaluacion PDF</a>
                                        <a href="<?=base_url()?>DocumentosPDF/evaluacion_conocimientos/<?=$id_publicacion_ctn.'/'.$ea->id_evaluacion_alumno_publicacion_ctn?>" target="_blank" class="btn btn-sm btn-pill btn-primary">Ver evaluacion conocimientos PDF</a>
                                        <?php if(isset($usuario) && $usuario->tipo_usuario != 'alumno'): ?>
                                            <br class="mb-1">
                                            <button data-id_evaluacion_alumno_publicacion_ctn="<?=$ea->id_evaluacion_alumno_publicacion_ctn?>" class="btn btn-sm btn-pill btn-secondary btn_ver_evaluacion_lectura"><i class="fa fa-eye"></i> Ver examen</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td class="text-center" colspan="4">Sin evaluaciones registradas</td>
                            </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="contenedor_resultado_evaluacion_lectura" style="display: none">

                </div>

            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-dark btn-pill btn-sm" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>