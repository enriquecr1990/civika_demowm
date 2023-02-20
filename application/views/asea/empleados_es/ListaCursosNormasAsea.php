<?php if($normas_asea): ?>
<div class="col-sm-12">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Duración</th>
                <th>Periodo</th>
                <th>Horario</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($normas_asea as $na): ?>
                <tr>
                    <td><?= $na->orden_norma ?></td>
                    <td><?= $na->nombre ?></td>
                    <td><?= $na->duracion ?></td>
                    <td>Del <?= fechaBDToHtml($na->fecha_inicio) ?> al <?= fechaBDToHtml($na->fecha_fin) ?></td>
                    <td><?= $na->horario ?></td>
                    <td>
                        <?php if ($na->aplica_cursar): ?>
                            <button type="button" class="btn btn-info btn-xs empleado_cursar_norma_asea"
                                    data-toggle="tooltip"
                                    data-id_normas_asea="<?= $na->id_normas_asea ?>" title="Cursar norma">
                                <i class="glyphicon glyphicon-book"></i>
                            </button>
                        <?php else: ?>
                            <span class="label label-danger" data-toggle="tooltip" data-placement="bottom"
                                  title="Para tomar la norma es necesario que haya cursado la norma anterior y tener al menos una evaluación">No disponible</span>
                        <?php endif; ?>
                        <?php if ($na->aplica_curso): ?>
                            <button class="btn btn-primary btn-xs empleado_consultar_evaluaciones_norma" data-toggle="tooltip"
                                    data-id_normas_asea="<?= $na->id_normas_asea ?>"
                                    title="Consultar evaluaciones de la norma">
                                <i class="glyphicon glyphicon-tags"></i>
                            </button>
                        <?php endif; ?>
                        <?php if ($na->aplica_curso && $na->aplica_evaluacion): ?>
                            <a role="button" class="btn btn-warning btn-xs" data-toggle="tooltip"
                                    title="Realizar evaluación de la norma"
                                href="<?=base_url().'EmpleadosES/iniciarEvaluacionNorma/'.$na->id_normas_asea?>">
                                <i class="glyphicon glyphicon-file"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($na->aplica_constancia): ?>
                            <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip"
                                    title="Descargar constancia">
                                <i class="glyphicon glyphicon-certificate"></i>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <div class="form-group">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <i class="glyphicon glyphicon-info-sign"></i>&nbsp;Por el momento no se encuentran registras normas en el sistema para su estación de servicio
            </div>
        </div>
    </div>
<?php endif; ?>
