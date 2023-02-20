<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Seguimiento a empleados</div>
        <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <?php if(is_array($listaEmpleadosES) && sizeof($listaEmpleadosES) != 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Empleado</th>
                                    <th>CURP</th>
                                    <th>Puesto</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($listaEmpleadosES)): ?>
                                    <?php foreach ($listaEmpleadosES as $emp): ?>
                                        <tr>
                                            <td><?=$emp->nombre.' '.$emp->apellido_p.' '.$emp->apellido_m?></td>
                                            <td><?=$emp->curp?></td>
                                            <td><?=$emp->puesto?></td>
                                            <td>
                                                <button class="btn btn-info btn-xs consultar_evaluaciones_empleado" data-toggle="tooltip"
                                                        title="Consultar evaluaciones empleado" data-placement="bottom"
                                                        data-id_empleado_es="<?=$emp->id_empleado_es?>">
                                                    <i class="glyphicon glyphicon-briefcase"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="glyphicon glyphicon-info-sign"></i>&nbsp;No cuenta con empleados registrados en el sistema
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="conteiner_evaluaciones_empleado"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>