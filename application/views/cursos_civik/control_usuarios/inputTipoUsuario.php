<div id="inputs_to_alumno" <?= isset($usuario) && isset($tipo_usuario) && $tipo_usuario == 'alumno' ? '' : 'style="display: none;"' ?> >

    <?php if(isset($usuario_alumno)): ?>
        <input type="hidden" name="usuario_alumno[id_alumno]" value="<?=$usuario_alumno->id_alumno?>">
    <?php endif; ?>
    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_curp_alumno" class="col-form-label">CURP</label>
            <input id="input_curp_alumno" class="form-control civika_mayus" placeholder="CURP" data-rule-required="true"
                   name="usuario_alumno[curp]" data-rule-minlength="18" data-rule-maxlength="18" maxlength="18"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->curp : '' ?>">
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_titulo_academico_alumno" class="col-form-label">Titúlo Académico</label>
            <select id="input_titulo_academico_alumno" class="custom-select d-block"
                    name="usuario_alumno[id_catalogo_titulo_academico]">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_titulo_academico as $ca): ?>
                    <option value="<?= $ca->id_catalogo_titulo_academico ?>" <?= isset($usuario_alumno) && $usuario_alumno->id_catalogo_titulo_academico == $ca->id_catalogo_titulo_academico ? 'selected="selected"' : '' ?>><?= $ca->titulo ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_profesion_alumno" class="col-form-label">Profesión</label>
            <input id="input_profesion_alumno" class="form-control" placeholder="Profesión/Carrera"
                   name="usuario_alumno[profesion]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->profesion : '' ?>">
        </div>

    </div>

    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_puesto_alumno" class="col-form-label">Puesto</label>
            <input id="input_puesto_alumno" class="form-control" placeholder="Puesto que desempeña"
                   name="usuario_alumno[puesto]" value="<?= isset($usuario_alumno) ? $usuario_alumno->puesto : '' ?>">
        </div>

        <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <label for="input_domicilio_alumno" class="col-form-label">Domicilio</label>
            <input id="input_domicilio_alumno" class="form-control" placeholder="Domicilio "
                   name="usuario_alumno[domicilio]"
                   value="<?= isset($usuario_alumno) ? $usuario_alumno->domicilio : '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="input_ocupacion_especifica" class="col-form-label">Ocupación específica</label>
            <select class="custom-select" name="usuario_alumno[id_catalogo_ocupacion_especifica]">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_ocupacion_especifica as $coe): ?>
                    <optgroup label="<?=$coe->clave_area_subarea.' '.$coe->denominacion?>">
                        <?php foreach ($coe->subAreas as $sa): ?>
                            <option value="<?=$sa->id_catalogo_ocupacion_especifica?>" <?=isset($usuario_alumno) && $usuario_alumno->id_catalogo_ocupacion_especifica == $sa->id_catalogo_ocupacion_especifica ? 'selected="selected"':''?>><?=$sa->clave_area_subarea.' '.$sa->denominacion?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row">

        <input type="hidden" name="empresa[update_datos]" value="<?=isset($empresa->update_datos) ? $empresa->update_datos : 0?>">

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_nombre_empresa" class="col-form-label">Nombre de la empresa <span class="requerido">*</span></label>
            <input id="input_nombre_empresa" class="form-control" placeholder="Nombre de la empresa"
                   name="empresa[nombre]" data-rule-required="true"
                   value="<?= isset($empresa->nombre) ? $empresa->nombre : ''?>">
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_rfc_empresa" class="col-form-label">RFC <span class="requerido">*</span></label>
            <input id="input_rfc_empresa" class="form-control civika_mayus" placeholder="RFC de la empresa"
                   name="empresa[rfc]" data-rule-required="true"
                   value="<?= isset($empresa->rfc) ? $empresa->rfc : '' ?>">
        </div>

    </div>

    <div class="row">

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_rep_legal" class="col-form-label">Representante legal<span class="requerido">*</span></label>
            <input id="input_rep_legal" class="form-control" placeholder="Representante legal"
                   name="empresa[representante_legal]" data-rule-required="true"
                   value="<?= isset($empresa->representante_legal) ? $empresa->representante_legal : ''?>" >
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_rep_trabajadores" class="col-form-label">Representante de los trabajadores</label>
            <input id="input_rep_trabajadores" class="form-control" placeholder="Representante de los trabajadores"
                   name="empresa[representante_trabajadores]"
                   value="<?= isset($empresa->representante_trabajadores) ? $empresa->representante_trabajadores : '' ?>">
        </div>

    </div>

    <div class="row ">
        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_correo_empresa" class="col-form-label">Correo electrónico<span class="requerido">*</span></label>
            <input id="input_correo_empresa" class="form-control" placeholder="Correo"
                   data-rule-email="true" name="empresa[correo]" data-rule-required="true"
                   value="<?= isset($empresa->correo) ? $empresa->correo : '' ?>">
        </div>

        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label for="input_telefono_empresa" class="col-form-label">Teléfono<span class="requerido">*</span></label>
            <input id="input_telefono_empresa" class="form-control" placeholder="Teléfono"
                   name="empresa[telefono]" data-rule-required="true"
                   value="<?= isset($empresa->telefono) ? $empresa->telefono : '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="input_domicilio_empresa" class="col-form-label">Domicilio fiscal<span class="requerido">*</span></label>
            <input id="input_domicilio_empresa" class="form-control" placeholder="Domicilio"
                   name="empresa[domicilio]" data-rule-required="true"
                   value="<?= isset($empresa->domicilio) ? $empresa->domicilio : '' ?>">
        </div>
    </div>
</div>

<div id="inputs_to_instructor" <?= isset($usuario) && isset($tipo_usuario) && $tipo_usuario == 'instructor' ? '' : 'style="display: none;"' ?> >
    <div class="row">

        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_curp_instructor" class="col-form-label">CURP</label>
            <input id="input_curp_instructor" class="form-control civika_mayus" placeholder="CURP"
                   name="usuario_instructor[curp]" data-rule-minlength="18" data-rule-maxlength="18" maxlength="18"
                   value="<?= isset($usuario_instructor) ? $usuario_instructor->curp : '' ?>">
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_titulo_academico_instructor" class="col-form-label">Titúlo Académico</label>
            <select id="input_titulo_academico_instructor" class="custom-select d-block"
                    name="usuario_instructor[id_catalogo_titulo_academico]">
                <option value="">Seleccione</option>
                <?php foreach ($catalogo_titulo_academico as $ca): ?>
                    <option value="<?= $ca->id_catalogo_titulo_academico ?>" <?= isset($usuario_instructor) && $usuario_instructor->id_catalogo_titulo_academico == $ca->id_catalogo_titulo_academico ? 'selected="selected"' : '' ?>><?= $ca->titulo ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="input_profesion_instructor" class="col-form-label">Profesión/Carrera</label>
            <input id="input_profesion_instructor" class="form-control" placeholder="Profesión o nombre carrera"
                   name="usuario_instructor[profesion]"
                   value="<?= isset($usuario_instructor) ? $usuario_instructor->profesion : '' ?>">
        </div>

    </div>

    <div class="row">
        <div class="form-group col-lg-4">
            <div class="file_upload_civik btn btn-sm btn-info btn-pill" id="upload_firma_instructor">
                <label for="input_foto_firma_instructor" class="col-form-label">Subir firma</label>
                <input id="input_foto_firma_instructor" type="file" class="upload_civika fileUploadFirmaInstructor"
                       accept="image/*" name="img_foto_firma">
            </div>
        </div>
        <div id="contenedor_firma_instructor">
            <?php if(isset($usuario_instructor) && existe_valor($usuario_instructor->id_documento_firma)): ?>
            <input type="hidden" name="usuario_instructor[id_documento_firma]" value="<?=$usuario_instructor->id_documento_firma?>">
            <img class="" width="50px" height="50px" src="<?=base_url().$usuario_instructor->ruta_documento_firma?>">
            <?php endif; ?>
        </div>
    </div>

    
    <!--<div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="input_experiencia_instructor" class="col-form-label">Experiencia curricular</label>
            <textarea id="input_experiencia_instructor" class="form-control"
                      placeholder="Experiencia curricular del instructor"
                      name="usuario_instructor[experiencia_curricular]"><?= isset($usuario_instructor) ? $usuario_instructor->experiencia_curricular : '' ?></textarea>
        </div>
    </div>-->
    
</div>

