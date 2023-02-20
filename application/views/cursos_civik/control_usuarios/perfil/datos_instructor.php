
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>CURP</label>
        <span><?=$usuario_instructor->curp == '' ? 'Sin CURP registrada' : $usuario_instructor->curp?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Grado académico</label>
        <span><?=is_null($usuario_instructor->id_catalogo_titulo_academico) == '' ? 'Sin grado académico registrado': $usuario_instructor->titulo?></span>
    </div>
    <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <label>Profesion</label>
        <span><?=$usuario_instructor->profesion == '' ? 'Sin Profesión registrada' : $usuario_instructor->profesion?></span>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label>Experiencia</label>
        <span><?=$usuario_instructor->experiencia_curricular?></span>
    </div>
