<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Evaluacion norma Asea</div>
        <div class="panel-body">
            <form class="form-horizontal" id="form_enviar_evaluacion_norma_asea">

                <input type="hidden" name="evaluacion_norma_asea[id_normas_asea]" value="<?=$normas_asea->id_normas_asea?>">

                <?php if($existe_aprobado): ?>
                    <?php $this->load->view('asea/empleados_es/CalificacionesEvaluacionesNorma'); ?>
                <?php else: ?>
                    <?php if($puede_evaluar ): ?>
                        <?php if($preguntas_normas): ?>

                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pregunta</th>
                                            <th>Respuesta</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($preguntas_normas as $index => $pn): ?>
                                            <input type="hidden" name="respuesta_empleado_es[<?=$index?>][id_preguntas_normas_asea]" value="<?=$pn->id_preguntas_normas_asea?>">
                                            <tr>
                                                <td><?=$index + 1?></td>
                                                <td><?=$pn->pregunta?></td>
                                                <td style="min-width: 200px; max-width: 450px;">
                                                    <?php foreach($pn->respuestas as $index_r => $r): ?>
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-2">
                                                                <input type="<?=$pn->is_checkbox ? 'checkbox':'radio'?>" data-rule-required="true"
                                                                       name="respuesta_empleado_es[<?=$index?>][respuestas]<?=$pn->is_checkbox ? '[]':''?>[id_opcion_pregunta]"
                                                                       value="<?=$r->id_opcion_pregunta?>">
                                                            </div>
                                                            <span class="col-sm-10"><?=$r->descripcion?></span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    He revisado detalladamente mi evaluación y acepto enviarla para su calificación &nbsp;<input type="checkbox" class="aceptar_envio_evaluacion">Aceptar
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i>
                                    Por el momento no se encuentran registradas las pregunta para la evaluación de la norma
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <i class="glyphicon glyphicon-info-sign"></i>
                                Ya cuenta con las evaluaciones permitidas por el sistema, de click en regresar para verificar su(s) evaluacion(es) y con que calificación cuenta cada una de ellas
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="col-sm-12">
                    <div class="col-sm-6 izquierda">
                        <a role="button" class="btn btn-default btn-sm regresar_evaluaciones_empleado_es" href="<?=base_url().'EmpleadosES/CursosNormasAsea'?>">
                            <i class="glyphicon glyphicon-arrow-left"></i>Regresar
                        </a>
                    </div>
                    <?php if($puede_evaluar && !$existe_aprobado): ?>
                        <div class="col-sm-6 derecha">
                            <button type="button" class="btn btn-success btn-sm mandar_evaluacion_norma_empleado" disabled="disabled"><i class="glyphicon glyphicon-send"></i>Enviar evaluación</button>
                        </div>
                    <?php endif; ?>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="conteiner_empleado_cursar_norma_asea"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>