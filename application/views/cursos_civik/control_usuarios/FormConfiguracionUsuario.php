<form class="form-horizontal" role="form">

    <?php if(isset($es_configuracion) && $es_configuracion): ?>
        <input type="hidden" name="es_configuracion" value="1">
    <?php endif; ?>

    <?php
    $class_modificar = 'modificar_usuario_admin_asea';
    $tipo_usuario = 'administrador';
    if(isset($usuario->es_admin) && $usuario->es_admin){
        $tipo_usuario = 'admin';
    }
    ?>
    <?php if((isset($usuario->es_administrador) && $usuario->es_administrador
        || isset($usuario->es_admin) && $usuario->es_admin)): ?>
        <div class="form-group">
            <label class="col-sm-2">Nombre:</label>
            <span class="col-sm-4"><?= $usuario->nombre ?></span>
            <label class="col-sm-2">Apellidos:</label>
            <span class="col-sm-4"><?= $usuario->apellido_p . ' ' . $usuario->apellido_m ?></span>
        </div>
        <div class="form-group">
            <label class="col-sm-2">Correo:</label>
            <span class="col-sm-4"><?= $usuario->correo ?></span>
            <label class="col-sm-2">Teléfono:</label>
            <span class="col-sm-4"><?= $usuario->telefono ?></span>
        </div>
        <div class="form-group derecha">
            <div class="col-sm-12">
                <button type="button" class="btn btn-info btn-xs modificar_usuario_admin_asea" data-toggle="tooltip"
                        data-id_usuario="<?=$usuario->id_usuario?>" data-tipo_usuario="<?=$tipo_usuario?>"
                        data-es_configuracion="1"
                        data-placement="bottom" title="Modificar sus datos del sistema">
                    <i class="glyphicon glyphicon-pencil"></i>&nbsp;Modificar datos
                </button>
            </div>
        </div>
    <?php elseif(isset($usuario->es_rh_empresa) && $usuario->es_rh_empresa): ?>
        <?php $class_modificar = 'modificar_estacion_servicio';$tipo_usuario = ''?>
        <div class="form-group">
            <label class="col-sm-2">Nombre:</label>
            <span class="col-sm-4"><?= $usuario->nombre ?></span>
            <label class="col-sm-2">RFC</label>
            <span class="col-sm-4"><?=$usuario->rfc?></span>
        </div>
        <div class="form-group">
            <label class="col-sm-2">Domicilio:</label>
            <span class="col-sm-4"><?= $usuario->domicilio?></span>
            <label class="col-sm-2">Teléfono:</label>
            <span class="col-sm-4"><?=$usuario->telefono?></span>
        </div>
        <div class="form-group">
            <label class="col-sm-2">Representante legal:</label>
            <span class="col-sm-4"><?= $usuario->representante_legal ?></span>
            <label class="col-sm-2">Correo:</label>
            <span class="col-sm-4"><?=$usuario->correo?></span>
        </div>
        <div class="form-group">
            <label class="col-sm-2">Logotipo:</label>
            <span class="col-sm-4">
                <img src="<?=$usuario->imagen_usuario?>" class="img-thumbnail" width="120px" height="80px">
            </span>
        </div>
        <div class="form-group derecha">
            <div class="col-sm-12">
                <button type="button" class="btn btn-info btn-xs modificar_estacion_servicio" data-toggle="tooltip"
                        title="Modificar datos de su estación de servicio" data-placement="bottom"
                        data-es_configuracion="1"
                        data-id_estacion_servicio="<?=$estacion->id_estacion_servicio?>">
                    <i class="glyphicon glyphicon-pencil"></i>&nbsp;Modificar datos
                </button>
            </div>
        </div>
    <?php elseif(isset($usuario->es_trabajador) && $usuario->es_trabajador): ?>
        <div class="form-group">
            <label class="col-sm-2">Nombre:</label>
            <span class="col-sm-4"><?= $usuario->nombre ?></span>
            <label class="col-sm-2">Apellidos:</label>
            <span class="col-sm-4"><?=$usuario->apellido_p.' '.$usuario->apellido_m?></span>
        </div>
        <div class="form-group">
            <label class="col-sm-2">CURP:</label>
            <span class="col-sm-4"><?= $usuario->curp ?></span>
            <label class="col-sm-2">Puesto:</label>
            <span class="col-sm-4"><?=$usuario->puesto?></span>
        </div>
        <div class="form-group derecha">
            <div class="col-sm-12">
                <button type="button" class="btn btn-info btn-xs modificar_empleados_sistema" data-toggle="tooltip"
                        data-id_empleado_es="<?=$usuario->id_empleado_es?>"
                        data-placement="bottom" title="Modificar sus datos del sistema">
                    <i class="glyphicon glyphicon-pencil"></i>&nbsp;Modificar datos
                </button>
            </div>
        </div>
    <?php endif; ?>

</form>