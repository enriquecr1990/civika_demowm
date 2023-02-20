<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>CURP</th>
                <th>Puesto</th>
                <th>Es representante</th>
                <th>Usuario</th>
                <?php if($editarRegistroEmpleados): ?>
                    <th>Constraseña</th>
                    <th></th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody class="tbodyEmpleadosES">
            <?php if($editarRegistroEmpleados): ?>
                <?php if($listaEmpleadosES): ?>
                    <?php foreach ($listaEmpleadosES as $empleado): ?>
                        <tr id="row_table_eliminar_<?=$empleado->id_empleado_es?>">
                            <input type="hidden" class="form-control" name="usuario[<?=$empleado->id_empleado_es?>][id_usuario]" value="<?=$empleado->usuario->id_usuario?>">
                            <input type="hidden" class="form-control" name="empleado_es[<?=$empleado->id_empleado_es?>][id_empleado_es]" value="<?=$empleado->id_empleado_es?>">
                            <td>
                                <input class="form-control input_datos_es" data-rule-required="true" placeholder="Nombre"
                                       name="empleado_es[<?=$empleado->id_empleado_es?>][nombre]" value="<?=$empleado->nombre?>">
                            </td>
                            <td>
                                <input class="form-control input_datos_es" data-rule-required="true" placeholder="Apellido paterno"
                                       name="empleado_es[<?=$empleado->id_empleado_es?>][apellido_p]" value="<?=$empleado->apellido_p?>"></td>
                            <td>
                                <input class="form-control input_datos_es" data-rule-required="true" placeholder="Apellido materno"
                                       name="empleado_es[<?=$empleado->id_empleado_es?>][apellido_m]" value="<?=$empleado->apellido_m?>"></td>
                            <td>
                                <input class="form-control input_curp" data-rule-required="true" data-rule-minlength="18"
                                       data-rule-maxlength="18" maxlength="18" placeholder="CURP"
                                       name="empleado_es[<?=$empleado->id_empleado_es?>][curp]" value="<?=$empleado->curp?>"></td>
                            <td>
                                <input class="form-control input_datos_es" data-rule-required="true" placeholder="Puesto"
                                       name="empleado_es[<?=$empleado->id_empleado_es?>][puesto]" value="<?=$empleado->puesto?>"></td>
                            <td>
                                <input id="empleado_es_representante" type="checkbox" name="empleado_es[<?=$empleado->id_empleado_es?>][es_representante]"
                                       value="si" <?=$empleado->es_representante == 'si' ? 'checked="checked"':''?> ></td>
                            <td class="centrado">
                                <input class="form-control input_datos_es" data-rule-required="true" placeholder="Usuario"
                                       name="usuario[<?=$empleado->id_empleado_es?>][usuario]" value="<?=$empleado->usuario->usuario?>" disabled="disabled"></td>
                            <td>
                                <input type="password" class="form-control input_datos_es" data-rule-required="true"
                                       placeholder="Contraseña" name="usuario[<?=$empleado->id_empleado_es?>][password]"
                                       value="<?=$empleado->usuario->password?>"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-xs eliminar_empleado_es" data-id_empleado_es="<?=$empleado->id_empleado_es?>"
                                        data-eliminar_html="#row_table_eliminar_<?=$empleado->id_empleado_es?>"
                                        data-toggle="tooltip" data-url="EstacionServicio/eliminarEmpleadosES/<?=$empleado->id_empleado_es?>"
                                        title="Eliminar empleado" data-placement="bottom"><i class="glyphicon glyphicon-trash"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif;?>
            <?php else: ?>
                <?php if($listaEmpleadosES): ?>
                    <?php foreach ($listaEmpleadosES as $empleado): ?>
                        <tr>
                            <td><?=$empleado->nombre?></td>
                            <td><?=$empleado->apellido_p?></td>
                            <td><?=$empleado->apellido_m?></td>
                            <td><?=$empleado->curp?></td>
                            <td><?=$empleado->puesto?></td>
                            <td><?=$empleado->es_representante?></td>
                            <td><?=$empleado->usuario->usuario?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif;?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="col-sm-12 mensajes_empleados_guardar">

        </div>
    </div>
</div>
