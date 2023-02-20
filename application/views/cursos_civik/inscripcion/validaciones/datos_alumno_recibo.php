<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-warning">
        Favor de verificar sus datos antes de enviar el recibo de pago para su validación
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label>Nombre(s)</label>
        <span><?= $usuario->nombre ?></span>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label>Apellido paterno</label>
        <span><?= $usuario->apellido_p ?></span>
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label>Apellido materno</label>
        <span><?= $usuario->apellido_m ?></span>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label>Teléfono</label>
        <span><?= $usuario->telefono ?></span>
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label>Correo</label>
        <span><?= $usuario->correo ?></span>
    </div>
</div>