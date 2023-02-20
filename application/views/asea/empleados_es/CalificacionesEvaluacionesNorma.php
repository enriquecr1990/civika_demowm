
    <div class="form-group">
        <label class="col-sm-2">Norma:</label>
        <span class="col-sm-4"><?= $normas_asea->nombre ?></span>
        <label class="col-sm-2">Instrucctor:</label>
        <span class="col-sm-4"><?= $normas_asea->instructor ?></span>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Fecha evaluación</th>
                        <th>Calificación</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($evaluaciones_norma_asea as $ena): ?>
                        <tr>
                            <td><?= fechaBDToHtml($ena->fecha_evaluacion) ?></td>
                            <td>
                                <span class="label label-<?= $ena->color_calificacion ?>"><?= $ena->calificacion_evaluacion ?></span>
                            </td>
                            <td>
                            <span class="label label-<?= $ena->aprobado ? 'success' : 'danger' ?>"><?= $ena->aprobado ? 'Aprobado' : 'Reprobado' ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if ($existe_aprobado): ?>
        <div class="form-group">
            <div class="col-sm-12 derecha">
                <button type="button" class="btn btn-info btn-xs ver_descargar_constancia_dc3"
                        data-toggle="tooltip" data-id_normas_asea="<?=$normas_asea->id_normas_asea?>"
                        data-id_empleado_es="<?=$empleado_es->id_empleado_es?>" data-tipo="I"
                        title="Ver constancia en línea">
                    <i class="glyphicon glyphicon-education"></i> &nbsp;Ver constancia
                </button>
                <a role="button" class="btn btn-success btn-xs"
                   href="<?=base_url().'EmpleadosES/constanciaDC3/'.$normas_asea->id_normas_asea.'/'.$empleado_es->id_empleado_es.'/D'?>">
                    <i class="glyphicon glyphicon-save-file"></i> &nbsp;Descargar constancia PDF
                </a>
            </div>
        </div>
    <?php endif; ?>