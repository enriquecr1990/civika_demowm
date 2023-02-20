<?php if($listaEstaciones): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead style="text-align: center;">
            <tr>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Datos de contacto</th>
                <th>Representante legal</th>
                <th>Activa</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="tbodyEstacionesServicio">
            <?php foreach ($listaEstaciones as $estacion): ?>
                <tr>
                    <td><?=$estacion->nombre?></td>
                    <td><?=$estacion->rfc?></td>
                    <td>
                        <label>Domicilio:</label><span><?=$estacion->domicilio?></span><br>
                        <label>Teléfono:</label><span><?=$estacion->telefono?></span><br>
                        <label>Correo:</label><span><?=$estacion->correo?></span>
                    </td>
                    <td><?=$estacion->representante_legal?></td>
                    <td><span class="label label-<?=$estacion->es_activo ? 'success': 'danger'?>"><?=$estacion->activo?></span></td>
                    <td>
                        <button class="btn btn-info btn-xs modificar_estacion_servicio" data-toggle="tooltip"
                                title="Modificar estación de servicio" data-placement="bottom"
                                data-id_estacion_servicio="<?=$estacion->id_estacion_servicio?>">
                            <i class="glyphicon glyphicon-edit"></i>
                        </button>
                        <button class="btn btn-success btn-xs registrar_normas_estacion_servicio" data-toggle="tooltip"
                                title="Asignar normas Asea a la estación" data-placement="bottom"
                                data-id_estacion_servicio="<?=$estacion->id_estacion_servicio?>">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </button>
                        <button class="btn btn-warning btn-xs agregar_empleado_es" data-toggle="tooltip"
                                title="Agregar empleados de la estación" data-placement="bottom"
                                data-id_estacion_servicio="<?=$estacion->id_estacion_servicio?>">
                            <i class="glyphicon glyphicon-user"></i>
                        </button>
                        <button class="btn btn-primary btn-xs consultar_empleados_es" data-toggle="tooltip"
                                title="Consultar empleados de la estación" data-placement="bottom"
                                data-id_estacion_servicio="<?=$estacion->id_estacion_servicio?>">
                            <i class="glyphicon glyphicon-user"></i>
                        </button>
                        <button class="btn btn-<?=$estacion->es_activo ? 'danger' : 'success'?> btn-xs activar_desactivar_estacion_es" data-toggle="tooltip"
                                data-url="EstacionServicio/activarDesactivarES/<?=$estacion->id_estacion_servicio?>/<?=$estacion->es_activo ? '2':'1'?>"
                                data-msg="Se <?=$estacion->es_activo ? 'desactivará' : 'activará'?> la estación de servicio incluyendo sus empleados, ¿Deseá continuar?"
                                title="<?=$estacion->es_activo ? 'Desactivar' : 'Activar'?> estación de servicio" data-placement="bottom"
                                data-btn_trigger=".buscar_estaciones_servicio"
                                data-id_usuario="<?=$estacion->id_usuario?>">
                            <i class="glyphicon glyphicon-<?=$estacion->es_activo ? 'remove':'ok'?>"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <span class="glyphicon glyphicon-info-sign"></span>No se encontraron registros
    </div>
<?php endif; ?>