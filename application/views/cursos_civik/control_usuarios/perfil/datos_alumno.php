
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>CURP</label>
        <span><?=$usuario_alumno->curp == '' ? 'Sin CURP registrada' : $usuario_alumno->curp?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Domicilio</label>
        <span><?=$usuario_alumno->domicilio == '' ? 'Sin Domicilio registrado': $usuario_alumno->domicilio?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Grado académico</label>
        <span><?=is_null($usuario_alumno->id_catalogo_titulo_academico) ? 'Sin Titulo registrado' : $usuario_alumno->titulo?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Profesión</label>
        <span><?=$usuario_alumno->profesion == '' ? 'Sin Profesion registrada' : $usuario_alumno->profesion?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Ocupación específica</label>
        <span><?=is_null($usuario_alumno->id_catalogo_ocupacion_especifica) ? 'Sin Ocupacion especifica registrada' : $usuario_alumno->denominacion?></span>
    </div>

    <?php if(isset($empresa) && is_object($empresa)): ?>
        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Nombre de la empresa</label>
            <span><?=$empresa->nombre?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>RFC</label>
            <span><?=$empresa->rfc?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Domicilio</label>
            <span><?=$empresa->domicilio?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Teléfono</label>
            <span><?=$empresa->telefono?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Correo</label>
            <span><?=$empresa->correo?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Representante legal</label>
            <span><?=$empresa->representante_legal?></span>
        </div>

        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Representante de trabajadores</label>
            <span><?=$empresa->representante_trabajadores?></span>
        </div>
    <?php endif; ?>
