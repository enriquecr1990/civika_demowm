<div class="modal fade" role="dialog" id="modal_modificar_registrar_empleados_es">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Control de empleados de la Estación de Servicio</h5>
            </div>
            <form class="form-horizontal" id="form_empleados_es">
                <input type="hidden" name="id_estacion_servicio" value="<?=$estacion_servicio->id_estacion_servicio?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div id="guardar_form_empleados_es">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Nombre:</label>
                        <div class="col-sm-4"><span><?=$estacion_servicio->nombre?></span></div>
                        <label class="col-sm-2">RFC:</label>
                        <div class="col-sm-4"><span><?=$estacion_servicio->rfc?></span></div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Empleados ES</div>
                        <div class="panel-body">
                            <?php if($editarRegistroEmpleados): ?>
                                <div class="col-sm-12" style="text-align: right;">
                                    <button type="button" class="btn btn-info btn-sm agregar_nuevo_empleado_es" data-backdrop="static">
                                        <span class="glyphicon glyphicon-plus"></span>Agregar empleado
                                    </button>
                                </div>
                            <?php endif; ?>
                            <?php $this->load->view('asea/estacion_servicio/EmpleadosES'); ?>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <?php if($editarRegistroEmpleados): ?>
                        <button type="button" class="btn btn-success btn-sm guardar_empleados_es">Aceptar</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-<?=$editarRegistroEmpleados ? 'danger':'success'?> btn-sm" data-dismiss="modal"><?=$editarRegistroEmpleados ? 'Cancelar':'Cerrar'?></button>
                </div>
            </form>
        </div>
    </div>
</div>