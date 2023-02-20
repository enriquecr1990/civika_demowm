<form id="form_guardar_usuario_alumno_datos_empresa">

    <?php
    $disabled = '';
    if(isset($disabled_edicion_datos) && $disabled_edicion_datos){
        $disabled = 'disabled="disabled"';
    }
    ?>

    <div class="card">
        <div class="card-header">
            <!--<h5 class="text-primary">
                Datos de la empresa
            </h5>-->
        </div>
        <div aria-labelledby="heading_datos_empresa"
             data-parent="#accordion">
            <div class="card-body">

                <div class="col-sm-12">
                    <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <div class="alert alert-light">
                            <!--<li>Los datos de la empresa son opcionales, puede capturarlos o ir directamente al "complemento registro de pago"</li>-->
                            <li>Considere que los datos de la empresa se mostrarán en el Formato DC-3 de la STPS</li>
                        </div>
                    </div>
                </div>

                <input class="id_usuario" type="hidden" name="usuario[id_usuario]" value="<?= $usuario->id_usuario ?>">
                <input type="hidden" name="usuario_alumno[id_alumno]" value="<?= $usuario_alumno->id_alumno?>">
                <input id="empresa_update_datos" type="hidden" name="empresa[update_datos]" value="<?= $empresa->update_datos?>">
                <input type="hidden" name="id_alumno_inscrito_ctn_publicado" value="<?=$alumno_inscrito_ctn_publicacion->id_alumno_inscrito_ctn_publicado?>">

                <div class="card mb-3">
                    <div class="card-header">
                        Datos personales
                    </div>
                    <div class="card-body">
                        <div class="row row_form">

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_curp_alumno" class="col-form-label">CURP<span
                                            class="requerido">*</span></label>
                                <input id="input_curp_alumno" class="form-control civika_mayus" placeholder="CURP"
                                       data-rule-required="true" <?=$disabled?>
                                       name="usuario_alumno[curp]"
                                       value="<?= isset($usuario_alumno) ? $usuario_alumno->curp : '' ?>">
                            </div>

                            <div class="form-group col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                <label for="input_puesto_alumno" class="col-form-label">Puesto<span
                                            class="requerido">*</span></label>
                                <input id="input_puesto_alumno" class="form-control" placeholder="Puesto que desempeña"
                                       data-rule-required="true" <?=$disabled?>
                                       name="usuario_alumno[puesto]"
                                       value="<?= isset($usuario_alumno) ? $usuario_alumno->puesto : '' ?>">
                            </div>
                        </div>
                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_puesto_alumno" class="col-form-label">Ocupación específica<span
                                            class="requerido">*</span></label>
                                <select class="custom-select" name="usuario_alumno[id_catalogo_ocupacion_especifica]"
                                        data-rule-required="true" <?=$disabled?>>
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

                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <label class="col-form-label">¿Trabaja para alguna empresa ?</label>
                            </div>
                            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="alumno_trabaja_empresa_no" name="usuario_alumno[trabaja_empresa]" class="custom-control-input cheked_inscripcion_trabaja_empresa"
                                           data-rule-required="true" <?=$disabled?> value="no" <?=isset($usuario_alumno->trabaja_empresa) && $usuario_alumno->trabaja_empresa == 'no' ? 'checked="checked"':''?>>
                                    <label class="custom-control-label" for="alumno_trabaja_empresa_no">No</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="alumno_trabaja_empresa_si" name="usuario_alumno[trabaja_empresa]" class="custom-control-input cheked_inscripcion_trabaja_empresa"
                                        <?=$disabled?> value="si" <?=isset($usuario_alumno->trabaja_empresa) && $usuario_alumno->trabaja_empresa == 'si' ? 'checked="checked"':''?>>
                                    <label class="custom-control-label" for="alumno_trabaja_empresa_si">Si</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" id="datos_empresa_alumno" <?=isset($usuario_alumno->trabaja_empresa) && $usuario_alumno->trabaja_empresa == 'si' ? '':'style="display:none;"'?>>
                    <div class="card-header">
                        Datos empresa
                    </div>
                    <div class="card-body">
                        <div class="row row_form">


                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_nombre_empresa" class="col-form-label">Nombre de la empresa <span class="requerido">*</span></label>
                                <input id="input_nombre_empresa" class="form-control" placeholder="Nombre de la empresa"
                                       name="empresa[nombre]" data-rule-required="true"
                                       value="<?= $empresa->nombre?>" <?=$disabled?>>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_rfc_empresa" class="col-form-label">RFC <span class="requerido">*</span></label>
                                <input id="input_rfc_empresa" class="form-control civika_mayus" placeholder="RFC de la empresa"
                                       name="empresa[rfc]" data-rule-required="true"
                                       value="<?= $empresa->rfc ?>" <?=$disabled?>>
                            </div>

                        </div>

                        <div class="row row_form">

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_rep_legal" class="col-form-label">Representante legal<span class="requerido">*</span></label>
                                <input id="input_rep_legal" class="form-control" placeholder="Representante legal"
                                       name="empresa[representante_legal]" data-rule-required="true"
                                       value="<?= $empresa->representante_legal ?>" <?=$disabled?>>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_rep_trabajadores" class="col-form-label">Representante de los trabajadores</label>
                                <input id="input_rep_trabajadores" class="form-control" placeholder="Representante de los trabajadores"
                                       name="empresa[representante_trabajadores]"
                                       value="<?= $empresa->representante_trabajadores ?>" <?=$disabled?>>
                            </div>

                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_correo_empresa" class="col-form-label">Correo electrónico<span class="requerido">*</span></label>
                                <input id="input_correo_empresa" class="form-control" placeholder="Correo"
                                       data-rule-email="true" name="empresa[correo]" data-rule-required="true"
                                       value="<?= $empresa->correo ?>" <?=$disabled?>>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_telefono_empresa" class="col-form-label">Teléfono<span class="requerido">*</span></label>
                                <input id="input_telefono_empresa" class="form-control" placeholder="Teléfono"
                                       name="empresa[telefono]" data-rule-required="true"
                                       value="<?= $empresa->telefono ?>" <?=$disabled?>>
                            </div>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_domicilio_empresa" class="col-form-label">Domicilio fiscal<span class="requerido">*</span></label>
                                <input id="input_domicilio_empresa" class="form-control" placeholder="Domicilio"
                                       name="empresa[domicilio]" data-rule-required="true"
                                       value="<?= isset($empresa->domicilio) ? $empresa->domicilio : '' ?>" <?=$disabled?>>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(!$disabled_edicion_datos): ?>
                    <?php if(isset($es_inscripcion) && $es_inscripcion): ?>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <button type="button" class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_empresa">
                                    Guardar DC-3
                                </button>
                                <button type="button" class="btn btn-info btn-pill btn-sm guardar_usuario_alumno_datos_sin_empresa">
                                    Guardar DC-3 (Sin empresa)
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($es_inscripcion_por_pasos) && $es_inscripcion_por_pasos): ?>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <button type="button" id="btn_guardar_dc3_pasos_con_empresa"
                                    <?=isset($usuario_alumno->trabaja_empresa) && $usuario_alumno->trabaja_empresa == 'si'  ? '':'style="display:none;"'?>
                                        class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_empresa_paso_2">
                                    Guardar datos DC-3
                                </button>
                                <button type="button" id="btn_guardar_dc3_pasos_sin_empresa"
                                    <?=isset($usuario_alumno->trabaja_empresa) && $usuario_alumno->trabaja_empresa == 'no' || $usuario_alumno->trabaja_empresa == '' ? '':'style="display:none;"'?>
                                        class="btn btn-success btn-pill btn-sm guardar_usuario_alumno_datos_sin_empresa_paso_2">
                                    Guardar datos DC-3
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

</form>