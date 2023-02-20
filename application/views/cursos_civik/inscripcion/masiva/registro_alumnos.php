<form id="form_registro_alumnos_empleados_inscripcion_masiva">

    <div class="row">
        <div class="form-group col-lg-12">
            <div class="alert alert-info">
                <ul>
                    <li>Puede llenar su información gradualmente dando click en el boton de "Guardado parcial empleados"</li>
                    <li>Considere registrar todos los empleados que tomaran el curso, las actualizaciones posteriores solo sera posibles hasta el día del evento y se le generará un cargo extra por actualización de constancias</li>
                </ul>
            </div>
        </div>
    </div>

    <input type="hidden" name="actualizacion_informacion" value="<?=isset($empresa_alumno) ? 1 : 2?>">

    <input type="hidden" name="id_publicacion_ctn" value="<?=$publicacion_ctn->id_publicacion_ctn?>">

    <div class="row row_form">
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="nombre_empresa" class="col-form-label">Nombre o denominación social</label>
            <input id="nombre_empresa" class="form-control" name="empresa_alumno[nombre]"
                   data-rule-required="true"
                   placeholder="Nombre o denominación social" value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->nombre : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="rfc_empresa" class="col-form-label">RFC</label>
            <input id="rfc_empresa" class="form-control" name="empresa_alumno[rfc]"
                   data-rule-required="true"
                   placeholder="RFC" readonly="readonly" value="<?=$rfc?>">
        </div>

        <div class="form-group col-lg-6 col-md-12 col-sm-12">
            <label for="domicilio_empresa" class="col-form-label">Domicilio</label>
            <input id="domicilio_empresa" class="form-control" name="empresa_alumno[domicilio]"
                   data-rule-required="true"
                   placeholder="Domicilio de la empresa" value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->domicilio : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="telefono_empresa" class="col-form-label">Teléfono</label>
            <input id="telefono_empresa" class="form-control" name="empresa_alumno[telefono]"
                   data-rule-required="true"
                   placeholder="Teléfono" value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->telefono : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="correo_empresa" class="col-form-label">Correo electrónico</label>
            <input id="correo_empresa" class="form-control" name="empresa_alumno[correo]"
                   data-rule-required="true" data-rule-email="true"
                   placeholder="Correo eletrónico" value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->correo : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="representante_legal_empresa" class="col-form-label">Representante legal</label>
            <input id="representante_legal_empresa" class="form-control" name="empresa_alumno[representante_legal]"
                   data-rule-required="true"
                   placeholder="Representante legal" value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->representante_legal : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            <label for="representante_trabajadores_empresa" class="col-form-label">Representante de trabajadores</label>
            <input id="representante_trabajadores_empresa" class="form-control"
                   data-rule-required="true"
                   name="empresa_alumno[representante_trabajadores]" placeholder="Representante de trabajadores"
                   value="<?=isset($empresa_alumno) && $empresa_alumno !== false ? $empresa_alumno->representante_trabajadores : ''?>">
        </div>

        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <label for="input_banner_img" class="col-form-label">Logotipo empresa<span class="requerido">*</span></label>
            <input id="input_banner_img" type="file" class="file fileUploadLogotipoEmpresa"
                   accept="image/*" name="img_banner">
        </div>
        <div id="div_conteiner_file_banner" class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <?php if(isset($publicacion_ctn_logo_empresa) && $publicacion_ctn_logo_empresa): ?>
                <div>
                    <label for="banner_id_documento" class="col-form-label">Imagen del logotipo</label> <span class="help-block help-span">Puede reemplazar el logo subiendo otra imagen</span> <br>
                    <input id="banner_id_documento" class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[banner][id_documento]" value="<?=$publicacion_ctn_logo_empresa->id_documento?>">
                    <input type="hidden" name="publicacion_has_doc_banner[banner][tipo]" value="logo_empresa">
                    <input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][titulo]" value="Logotipo de la empresa">
                    <input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][descripcion]" value="Es el logotipo de la empresa que se usara en la constancia de la DC-3">
                    <button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage"
                            data-nombre_archivo="<?=$publicacion_ctn_logo_empresa->nombre?>" data-src_image="<?=base_url().$publicacion_ctn_logo_empresa->img_banner?>">
                        <i class="fa fa-image"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div id="new_row_empleado_empresa">
        <!--
         <tr>
            <input type="hidden" name="empleados[{id}][id_usuario]" value="0">
            <input type="hidden" name="empleados[{id}][id_alumno]" value="0">
            <td><input class="form-control" name="empleados[{id}][nombre]" placeholder="Nombre" data-rule-required="true"></td>
            <td><input class="form-control" name="empleados[{id}][apellido_p]" placeholder="Apellido paterno" data-rule-required="true"></td>
            <td><input class="form-control" name="empleados[{id}][apellido_m]" placeholder="Apellido materno"></td>
            <td><input class="form-control civika_mayus curp_empleado" name="empleados[{id}][curp]" placeholder="CURP" ></td>
            <td>
                <select class="custom-select" name="empleados[{id}][id_catalogo_ocupacion_especifica]" data-rule-required="true">
                    <option value="">Seleccione</option>
                    <?php foreach ($catalogo_ocupacion_especifica as $coe): ?>
                        <optgroup label="<?=$coe->clave_area_subarea.' '.$coe->denominacion?>">
                            <option value="<?=$coe->id_catalogo_ocupacion_especifica?>" ><?=$coe->clave_area_subarea.' '.$coe->denominacion?></option>
                            <?php foreach ($coe->subAreas as $sa): ?>
                                <option value="<?=$sa->id_catalogo_ocupacion_especifica?>"><?=$sa->clave_area_subarea.' '.$sa->denominacion?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><input class="form-control" name="empleados[{id}][puesto]" placeholder="Puesto"></td>
            <td>
                <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        -->
    </div>

    <label for="table_empleados_empresa" class="col-form-label">Datos de los trabajadores/colaboradores</label>

    <div class="row">
        <div class="table-responsive">
            <table id="table_empleados_empresa" class="table table-striped">
                <thead>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>CURP</th>
                <th>Ocupación específica</th>
                <th>Puesto</th>
                <th>
                    <button type="button" class="btn btn-primary btn-sm btn-pill agregar_row_empleado_empresa_masivo"
                            data-origen="#new_row_empleado_empresa"
                            data-destino="#tbody_empleado_empresa_masivo">
                        Agregar
                    </button>
                </th>
                </thead>
                <tbody id="tbody_empleado_empresa_masivo">
                <?php if(isset($array_alumnos_publicacion) && is_array($array_alumnos_publicacion) && sizeof($array_alumnos_publicacion) != 0): ?>
                    <?php foreach ($array_alumnos_publicacion as $index => $ap): ?>
                        <tr>
                            <input type="hidden" name="empleados[<?=$index?>][id_usuario]" value="<?=$ap->id_usuario?>">
                            <input type="hidden" name="empleados[<?=$index?>][id_alumno]" value="<?=$ap->id_alumno?>">
                            <td><input class="form-control" name="empleados[<?=$index?>][nombre]" placeholder="Nombre" data-rule-required="true" value="<?=$ap->nombre?>"></td>
                            <td><input class="form-control" name="empleados[<?=$index?>][apellido_p]" placeholder="Apellido paterno" data-rule-required="true" value="<?=$ap->apellido_p?>"></td>
                            <td><input class="form-control" name="empleados[<?=$index?>][apellido_m]" placeholder="Apellido materno" value="<?=$ap->apellido_m?>"></td>
                            <td><input class="form-control civika_mayus curp_empleado" name="empleados[<?=$index?>][curp]" placeholder="CURP" value="<?=$ap->curp?>"></td>
                            <td>
                                <select class="custom-select" name="empleados[<?=$index?>][id_catalogo_ocupacion_especifica]" data-rule-required="true">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($catalogo_ocupacion_especifica as $coe): ?>
                                        <optgroup label="<?=$coe->clave_area_subarea.' '.$coe->denominacion?>">
                                            <option value="<?=$coe->id_catalogo_ocupacion_especifica?>" <?=$ap->id_catalogo_ocupacion_especifica == $coe->id_catalogo_ocupacion_especifica ? 'selected="selected"':''?>><?=$coe->clave_area_subarea.' '.$coe->denominacion?></option>
                                            <?php foreach ($coe->subAreas as $sa): ?>
                                                <option value="<?=$sa->id_catalogo_ocupacion_especifica?>" <?=$ap->id_catalogo_ocupacion_especifica == $sa->id_catalogo_ocupacion_especifica ? 'selected="selected"':''?>><?=$sa->clave_area_subarea.' '.$sa->denominacion?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input class="form-control" name="empleados[<?=$index?>][puesto]" placeholder="Puesto" value="<?=$ap->puesto?>"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-pill btn-sm eliminar_alumno_registrado_ctn_masivo"
                                        data-id_usuario="<?=$ap->id_usuario?>"
                                        data-id_publicacion_ctn="<?=$publicacion_ctn->id_publicacion_ctn?>"
                                        data-rfc_empresa="<?=$rfc?>"
                                        data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
                <button type="button" class="btn btn-pill btn-primary btn-sm guardar_registro_parcial_empleados_empresa_masivo"
                        data-id_publicacion_ctn="<?=$publicacion_ctn->id_publicacion_ctn?>"
                        data-rfc="<?=$rfc?>">Guardado parcial empleados</button>
            </div>
        </div>
    </div>

    <!--<div class="row row_form">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input check_validacion_datos_carga_masiva_empresa" id="check_revisar_datos_empresa_empleados_masivo">
                    <label class="custom-control-label" for="check_revisar_datos_empresa_empleados_masivo">
                        He revisado la información y confirmó que son correctos los datos de la empresa y de los empleados que asistiran al curso
                    </label>
                </div>
            </div>
        </div>
    </div>-->

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-right">
            <button type="button" class="btn btn-pill btn-success guardar_registro_empleados_empresa_masivo">Finalizar registro empleados</button>
        </div>
    </div>

</form>