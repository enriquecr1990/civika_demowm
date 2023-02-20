<div class="card">
    <div class="card-header">
        <label>Registro nuevo(s) alumno(s) al curso publicado</label>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-12">
                <label>¿Existe el alumno registrado en el sistema?</label>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-6 col-xs-6">
                <div class="custom-control custom-radio mb-2">
                    <input type="radio" id="alumno_registrado_sistema_no" name="alumno_registrado_sistema"
                           class="custom-control-input input_check_alumno_registro_ctu_publicado" value="no">
                    <label class="custom-control-label" for="alumno_registrado_sistema_no">No</label>
                </div>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-6 col-xs-6">
                <div class="custom-control custom-radio mb-2">
                    <input type="radio" id="alumno_registrado_sistema_si" name="alumno_registrado_sistema"
                           class="custom-control-input input_check_alumno_registro_ctu_publicado" value="si">
                    <label class="custom-control-label" for="alumno_registrado_sistema_si">Si</label>
                </div>
            </div>
        </div>

        <div id="registro_alumno_nuevo" style="display: none;">
            <form id="form_registrar_alumno_nuevo_ctn_publicado">

                <input type="hidden" name="id_publicacion_ctn" value="<?=$publicacion_ctn->id_publicacion_ctn?>">

                <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="nombre_alumno" >Nombre<span class="requerido">*</span></label>
                        <input id="nombre_alumno" class="form-control" placeholder="Nombre del alumno" name="usuario[nombre]" data-rule-required="true">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="apellido_p_alumno">Apellido paterno<span class="requerido">*</span></label>
                        <input id="apellido_p_alumno" class="form-control" placeholder="Apellido paterno" name="usuario[apellido_p]" data-rule-required="true">
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="apellido_m_alumno">Apellido materno<span class="requerido">*</span></label>
                        <input id="apellido_m_alumno" class="form-control" placeholder="Apellido meterno" name="usuario[apellido_m]" data-rule-required="true">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="curp_alumno">CURP<span class="requerido">*</span></label>
                        <input id="curp_alumno" class="form-control civika_mayus" placeholder="CURP" name="alumno[curp]" data-rule-required="true" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="apellido_m_alumno">Correo</label>
                        <input id="apellido_m_alumno" class="form-control" placeholder="Correo" name="usuario[correo]" data-rule-email="true" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="apellido_m_alumno">Teléfono</label>
                        <input id="apellido_m_alumno" class="form-control" placeholder="Teléfono" name="usuario[telefono]" >
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="curp_alumno">Puesto</label>
                        <input id="curp_alumno" class="form-control" placeholder="Puesto" name="alumno[puesto]" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="ocupacion_especifica_alumno">Ocupación espécifica</label>
                        <select id="ocupacion_especifica_alumno" class="custom-select" name="alumno[id_catalogo_ocupacion_especifica]">
                            <option value="">Seleccione</option>
                            <?php foreach ($catalogo_ocupacion_especifica as $coe): ?>
                                <optgroup label="<?=$coe->clave_area_subarea.' '.$coe->denominacion?>">
                                    <?php foreach ($coe->subAreas as $sa): ?>
                                        <option value="<?=$sa->id_catalogo_ocupacion_especifica?>"><?=$sa->clave_area_subarea.' '.$sa->denominacion?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="nombre_empresa">Nombre de la empresa</label>
                        <input id="nombre_empresa" class="form-control" placeholder="Nombre de la empresa" name="empresa[nombre]" >
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="rfc_empresa">RFC empresa</label>
                        <input id="rfc_empresa" class="form-control civika_mayus" placeholder="RFC de la empresa" name="empresa[rfc]" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="rep_legal_empresa">Representante legal</label>
                        <input id="rep_legal_empresa" class="form-control" placeholder="Representante legal" name="empresa[representante_legal]" >
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                        <label for="rep_legal_empresa">Representante trabajores</label>
                        <input id="rep_legal_empresa" class="form-control" placeholder="Representante de trabajadores" name="empresa[representante_trabajadores]" >
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <button type="button" class="btn btn-success btn-sm btn-pill guardar_nuevo_alumno_ctn_publicado">Aceptar</button>
                        <button type="button" class="btn btn-danger btn-sm btn-pill cancelar_registro_alumno_ctn_publicacion">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="registro_alumno_existente" style="display: none">
            <form id="form_buscar_usuarios">
                <div class="row">

                    <input type="hidden" name="tipo_usuario" value="alumno">
                    <input type="hidden" name="id_publicacion_ctn" value="<?=$publicacion_ctn->id_publicacion_ctn?>">

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_nombre" class="col-form-label">Nombre</label>
                        <input id="input_buscar_nombre" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_alumnos_registrados_sistema"
                               placeholder="Nombre" name="nombre">
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-xs-6 col-sm-12">
                        <label for="input_buscar_apellido_p" class="col-form-label">Apellido paterno</label>
                        <input id="input_buscar_apellido_p" class="form-control input_buscar_change"
                               data-btn_buscar="#btn_buscar_alumnos_registrados_sistema"
                               placeholder="Apellido paterno" name="apellido_p">
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-xs-12 col-sm-12 text-right">
                        <button type="button" id="btn_buscar_alumnos_registrados_sistema"
                                class="btn btn-success btn-sm btn-pill buscar_comun_civik noview"
                                data-id_form="form_buscar_usuarios"
                                data-conteiner_resultados="#container_resultados_registro_alumnos_para_ctn_publicado"
                                data-url_peticion="<?=base_url().'AdministrarCTN/buscar_alumnos_sistema'?>">
                            Buscar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-pill cancelar_registro_alumno_ctn_publicacion">Cancelar registro</button>
                    </div>
                </div>
            </form>

            <div id="container_resultados_registro_alumnos_para_ctn_publicado"></div>

        </div>

    </div>
</div>