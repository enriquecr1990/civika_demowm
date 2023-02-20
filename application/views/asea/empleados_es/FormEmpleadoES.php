<div class="modal fade" role="dialog" id="modal_form_empleado_es_sistema">
    <div class="modal-dialog" role="document" style="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Modificar datos sistema</h5>
            </div>
            <form class="form-horizontal" id="form_modificar_empleado_es">
                <div class="modal-body">
                    <div id="conteiner_mensajes_modificar_empleado"></div>
                    
                    <input type="hidden" class="form-control" name="usuario[1][id_usuario]" value="<?=$usuario->id_usuario?>">
                    <input type="hidden" class="form-control" name="empleado_es[1][id_empleado_es]" value="<?=$empleado->id_empleado_es?>">
                    <input type="hidden" class="form-control" name="id_estacion_servicio" value="<?=$empleado->id_estacion_servicio?>">

                    <div class="form-group">
                        <label class="col-sm-4">Nombre:</label>
                        <div class="col-sm-8">
                            <input class="form-control" data-rule-required="true" placeholder="Nombre"
                                   name="empleado_es[1][nombre]" value="<?=$empleado->nombre?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Apellido paterno:</label>
                        <div class="col-sm-8">
                            <input class="form-control " data-rule-required="true" placeholder="Apellido paterno"
                                   name="empleado_es[1][apellido_p]" value="<?=$empleado->apellido_p?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Apellido materno:</label>
                        <div class="col-sm-8">
                            <input class="form-control " data-rule-required="true" placeholder="Apellido materno"
                                   name="empleado_es[1][apellido_m]" value="<?=$empleado->apellido_m?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">CURP:</label>
                        <div class="col-sm-8">
                            <input class="form-control" data-rule-required="true" data-rule-minlength="18"
                                   data-rule-maxlength="18" maxlength="18" placeholder="CURP"
                                   name="empleado_es[1][curp]" value="<?=$empleado->curp?>">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-4">Puesto:</label>
                        <div class="col-sm-8">
                            <input class="form-control " data-rule-required="true" placeholder="Puesto"
                                   name="empleado_es[1][puesto]" value="<?=$empleado->puesto?>">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-4">Usuario:</label>
                        <div class="col-sm-8">
                            <input class="form-control" data-rule-required="true" placeholder="Usuario"
                                   name="usuario[1][usuario]" value="<?=$usuario->usuario?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Constraseña:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control " data-rule-required="true"
                                   placeholder="Contraseña" name="usuario[1][password]"
                                   value="<?=$usuario->password?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12 centrado">
                        <button type="button" class="btn btn-info btn-sm actualizar_empleados_es">Aceptar</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>