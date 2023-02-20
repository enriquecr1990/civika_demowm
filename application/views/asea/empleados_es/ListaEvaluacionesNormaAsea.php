<div class="modal fade" role="dialog" id="modal_empleado_es_evaluaciones_norma">
    <div class="modal-dialog" role="document" style="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Evaluaciones norma Asea - <?= $normas_asea->nombre ?></h5>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <?php if ($evaluaciones_norma_asea): ?>
                        <?php $this->load->view('asea/empleados_es/CalificacionesEvaluacionesNorma'); ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="glyphicon glyphicon-info-sign"></i>&nbsp;No existen evaluaciones registradas en la
                            norma
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12 centrado">
                        <button class="btn btn-info btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>