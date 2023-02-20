<div class="modal fade" role="dialog" id="modal_consultar_evaluaciones_empleado">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Evaluaciones empleado</h4>
            </div>
            <form class="form-horizontal" id="form_registro_es">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="es_nombre">Empleado:</label>
                        <span class="col-sm-4"><?=$empleado_es->nombre.' '.$empleado_es->apellido_p.' '.$empleado_es->apellido_m?></span>
                        <label class="col-sm-2 control-label" for="es_nombre">CURP:</label>
                        <span class="col-sm-4"><?=$empleado_es->curp?></span>
                    </div>

                    <?php if($normas_cursadas_empleados && is_array($normas_cursadas_empleados)): ?>
                        <div class="form-group">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Norma</th>
                                            <th>Ingresos al curso</th>
                                            <th>Primer ingreso</th>
                                            <th>Segundo ingreso</th>
                                            <th>Evaluaciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($normas_cursadas_empleados as $nce): ?>
                                            <tr>
                                                <td><?=$nce->nombre?></td>
                                                <td><?=$nce->ingresos_curso?></td>
                                                <td><?=fechaBDToHtml($nce->fecha_ingreso)?></td>
                                                <td><?=$nce->fecha_ultimo_ingreso != null ? fechaBDToHtml($nce->fecha_ultimo_ingreso) : 'N/A'?></td>
                                                <td>
                                                    <?php if($nce->lista_evaluaciones):?>
                                                        <ul typeof="number">
                                                            <?php foreach ($nce->lista_evaluaciones as $eva): ?>
                                                                <li>
                                                                    <label>Calificación: </label>
                                                                    <span class="label label-<?=$eva->color_calificacion?>"><?=$eva->calificacion_evaluacion?></span>
                                                                    <?php if($eva->aprobado): ?>
                                                                        <button type="button" class="btn btn-info btn-xs ver_descargar_constancia_dc3"
                                                                                data-toggle="tooltip" data-id_normas_asea="<?=$nce->id_normas_asea?>"
                                                                                data-id_empleado_es="<?=$empleado_es->id_empleado_es?>" data-tipo="I"
                                                                                title="Ver constancia">
                                                                            <i class="glyphicon glyphicon-education"></i>
                                                                        </button>
                                                                        <a role="button" class="btn btn-success btn-xs"
                                                                            href="<?=base_url().'EmpleadosES/constanciaDC3/'.$nce->id_normas_asea.'/'.$empleado_es->id_empleado_es.'/D'?>">
                                                                            <i class="glyphicon glyphicon-save-file"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <span class="label label-info">Sin evaluaciones registradas</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign">&nbsp;No se tienen registradas evaluaciones en el sistema</i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: center">
                            <button type="button" class=" btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>