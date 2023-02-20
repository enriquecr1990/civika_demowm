<form id="form_guardar_usuario_alumno_datos_generales">

    <div class="col-sm-12">
        <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
    </div>

    <p>
        <span>Los datos con <span class="requerido">*</span> son obligatorios</span>
    </p>

    <input id="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
    <input type="hidden" name="usuario[update_password]" value="<?= $usuario->update_password ?>">
    <input id="usuario_update_datos" type="hidden" name="usuario[update_datos]" value="<?= $usuario->update_datos ?>">
    <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno?>">
    <input id="usuario_alumno_update_datos" type="hidden" name="usuario_alumno[update_datos]" value="<?= $usuario_alumno->update_datos ?>">
    <?php if(isset($curso_incripcion)): ?>
        <input type="hidden" name="usuario_alumno[id_publicacion_ctn]" value="<?= $curso_incripcion->id_publicacion_ctn?>">
    <?php endif; ?>
    <input id="input_tipo_usuario" type="hidden" name="tipo_usuario" value="alumno">

    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_nombre" class="col-form-label">Nombre(s)<span
                    class="requerido">*</span></label>
            <input id="input_nombre" class="form-control" placeholder="Nombre(s)" data-rule-required="true"
                   name="usuario[nombre]" value="<?= $usuario->nombre ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_apellido_p" class="col-form-label">Apellido paterno<span
                    class="requerido">*</span></label>
            <input id="input_apellido_p" class="form-control" placeholder="Apellido paterno"
                   data-rule-required="true" name="usuario[apellido_p]"
                   value="<?= $usuario->apellido_p ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_apellido_m" class="col-form-label">Apellido materno<span
                    class="requerido">*</span></label>
            <input id="input_apellido_m" class="form-control" placeholder="Apellido materno"
                   data-rule-required="true" name="usuario[apellido_m]"
                   value="<?= $usuario->apellido_m ?>">
        </div>

    </div>

    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_telefono" class="col-form-label">Teléfono<span class="requerido">*</span></label>
            <input id="input_telefono" class="form-control" placeholder="Teléfono"
                   data-rule-required="true"
                   name="usuario[telefono]" value="<?= $usuario->telefono ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_correo" class="col-form-label">Correo electrónico<span
                    class="requerido">*</span></label>
            <input id="input_correo" class="form-control" placeholder="Correo" data-rule-required="true"
                   data-rule-email="true" name="usuario[correo]" value="<?= $usuario->correo ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_usuario" class="col-form-label">Usuario</label>
            <input id="input_usuario" class="form-control" placeholder="Usuario"
                   data-rule-required="true"
                   name="usuario[usuario]" value="<?= $usuario->usuario ?>" readonly="readonly">
        </div>

    </div>

    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="custom-control custom-toggle d-block my-2">
                <input type="checkbox" id="input_cambiar_password_usuario"
                       class="custom-control-input input_checkbox_change"
                       data-div_show_hidden=".input_form_passwords">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Modificar contraseña</span>
            </label>
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 input_form_passwords" <?= isset($usuario) ? 'style="display: none"' : '' ?>>
            <label for="input_password" class="col-form-label">Contraseña<span
                    class="requerido">*</span></label>
            <input id="input_password" type="password" id="password" class="form-control"
                   placeholder="Constraseña" data-rule-required="true"
                   name="usuario[password]" value="">
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 input_form_passwords" <?= isset($usuario) ? 'style="display: none"' : '' ?>>
            <label for="input_password_repeat" class="col-form-label">Repetir contraseña<span
                    class="requerido">*</span></label>
            <input id="input_password_repeat" type="password" class="form-control"
                   placeholder="Constraseña"
                   data-rule-required="true" value="">
        </div>

    </div>

    <!-- datos de la dc3 -->
    <!--
    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_curp_alumno" class="col-form-label">CURP<span
                    class="requerido">*</span></label>
            <input id="input_curp_alumno" class="form-control civika_mayus" placeholder="CURP"
                   data-rule-required="true"
                   name="usuario_alumno[curp]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->curp : '' ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_puesto_alumno" class="col-form-label">Puesto<span
                    class="requerido">*</span></label>
            <input id="input_puesto_alumno" class="form-control" placeholder="Puesto que desempeña"
                   data-rule-required="true"
                   name="usuario_alumno[puesto]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->puesto : '' ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_puesto_alumno" class="col-form-label">Ocupación específica<span
                    class="requerido">*</span></label>
            <select class="custom-select" name="usuario_alumno[id_catalogo_ocupacion_especifica]"
                    data-rule-required="true">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_ocupacion_especifica as $coe): ?>
                    <optgroup label="<?=$coe->clave_area_subarea.' '.$coe->denominacion?>">
                        <?php foreach ($coe->subAreas as $sa): ?>
                            <option value="<?=$sa->id_catalogo_ocupacion_especifica?>" <?=$usuario_alumno->id_catalogo_ocupacion_especifica == $sa->id_catalogo_ocupacion_especifica ? 'selected="selected"':''?>><?=$sa->clave_area_subarea.' '.$sa->denominacion?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>

    </div>
    -->

    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_profesion_alumno" class="col-form-label">Profesión</label>
            <input id="input_profesion_alumno" class="form-control" placeholder="Profesión/Carrera"
                   name="usuario_alumno[profesion]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->profesion : '' ?>">
        </div>

        <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <label for="input_domicilio_alumno" class="col-form-label">Domicilio</label>
            <input id="input_domicilio_alumno" class="form-control" placeholder="Nombre"
                   name="usuario_alumno[domicilio]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->domicilio : '' ?>">
        </div>
    </div>

    <p>
        <span>Los datos con <span class="requerido">*</span> son obligatorios</span>
    </p>

    <?php if(isset($es_inscripcion) && $es_inscripcion): ?>
        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <button type="button" class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_personales">
                Guardar datos personales
            </button>
        </div>
    <?php endif; ?>

    <?php if(isset($es_inscripcion_por_pasos) && $es_inscripcion_por_pasos): ?>
        <input type="hidden" name="alumno_inscrito_ctn_publicado[id_alumno_inscrito_ctn_publicado]" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <button type="button" class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_personales_paso_1">
                Guardar datos personales
            </button>
        </div>
    <?php endif; ?>

</form>