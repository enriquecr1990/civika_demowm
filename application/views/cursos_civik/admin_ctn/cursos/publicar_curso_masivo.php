<div class="modal fade" role="dialog" id="modal_publicacion_curso_masivo_civika">
    <div class="modal-dialog modal-slg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Publicar <?= $curso->tipo ?> masivo para empresa</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php if (isset($instructores) && is_array($instructores) && sizeof($instructores) != 0): ?>

                <form id="form_guardar_publicacion_curso">

                    <input type="hidden" name="id_cotizacion" value="<?= isset($id_cotizacion) ? $id_cotizacion : 0 ?>">

                    <input type="hidden" name="publicacion_ctn[id_publicacion_ctn]" value="<?= isset($publicacion_ctn) ? $publicacion_ctn->id_publicacion_ctn : 0 ?>">
                    <input type="hidden" name="publicacion_ctn[id_curso_taller_norma]" value="<?= $curso->id_curso_taller_norma ?>">
                    <input type="hidden" name="publicacion_ctn[id_catalogo_tipo_publicacion]" value="<?= CURSO_EMPRESA ?>">

                    <div class="modal-body">

                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label for="input_rfc_empresa" class="col-form-label">RFC de la empresa<span class="requerido">*</span></label>
                                <input id="input_rfc_empresa" class="form-control civika_mayus" placeholder="RFC de la empresa destinada"
                                       data-rule-required="true" name="publicacion_ctn_has_empresa_masivo[rfc]"
                                       <?= isset($publicacion_ctn_empresa) ? 'disabled="disabled"' : '' ?>
                                       value="<?= isset($publicacion_ctn_empresa) ? $publicacion_ctn_empresa->rfc : '' ?>">
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label for="input_rfc_empresa" class="col-form-label">Correo de la empresa<span class="requerido">*</span></label>
                                <input id="input_rfc_empresa" class="form-control"
                                       placeholder="Correo de la empresa destinada"
                                       data-rule-required="true" name="publicacion_ctn_has_empresa_masivo[correo]"
                                       <?= isset($publicacion_ctn_empresa) ? 'disabled="disabled"' : '' ?>
                                       value="<?= isset($publicacion_ctn_empresa) ? $publicacion_ctn_empresa->correo : '' ?>">
                                <span class="help-span">Se usará para enviar el link a la empresa y que llene los alumnos para la publicación<br>Puede enviar a más de un correo si lo separa por una coma ","</span>
                            </div>
                        </div>

                        <!-- apartado los campos para publicar el curso -->
                        <div class="row row_form">
                            <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                <label for="input_nombre_comercial" class="col-form-label">Nombre del curso comercial<span class="requerido">*</span></label>
                                <input id="input_nombre_comercial" class="form-control" placeholder="Nombre del curso comercial" data-rule-required="true" name="publicacion_ctn[nombre_curso_comercial]"
                                       value="<?= isset($publicacion_ctn) ? $publicacion_ctn->nombre_curso_comercial : '' ?>">
                                <label class="help-span">Nombre DC-3: <?= $curso->nombre ?></label>
                            </div>

                            <div class="form-group col-lg-5 col-md-12 col-sm-12">
                                <label for="input_eje_tematico" class="col-form-label">Eje temático<span class="requerido">*</span></label>
                                <textarea id="input_eje_tematico" class="form-control" placeholder="Eje temático" data-rule-required="true"
                                          name="publicacion_ctn[eje_tematico]"><?= isset($publicacion_ctn) ? $publicacion_ctn->eje_tematico : $curso->temario ?></textarea>
                            </div>

                            <div class="form-group col-lg-2 col-md-12 col-sm-12">
                                <label class="col-form-label">Tendrá evaluación</label>
                                <select class="custom-select" name="publicacion_ctn[aplica_evaluacion]" data-rule-required="true">
                                    <option value="no" <?= isset($publicacion_ctn) && $publicacion_ctn->aplica_evaluacion == 'no' ? 'selected="selected"' : '' ?>>No</option>
                                    <option value="si" <?= isset($publicacion_ctn) && $publicacion_ctn->aplica_evaluacion == 'si' ? 'selected="selected"' : '' ?>>Si</option>
                                </select>
                            </div>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_descripcion_curso" class="col-form-label">Descripción<span class="requerido">*</span></label>
                                <textarea id="input_descripcion_curso" class="form-control" data-rule-required="true" name="publicacion_ctn[descripcion]"
                                          placeholder="Descripción del curso"><?= isset($publicacion_ctn) ? $publicacion_ctn->descripcion : '' ?></textarea>
                            </div>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                                <label for="input_fecha_inicio" class="col-form-label">Fecha de impartición<span class="requerido">*</span></label>
                                <div class="input-group with-addon-icon-left">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="input_fecha_inicio" class="form-control datepicker_shards"
                                           placeholder="Fecha inicio del curso" data-rule-required="true"
                                           name="publicacion_ctn[fecha_inicio]"
                                           value="<?= isset($publicacion_ctn) ? fechaBDToHtml($publicacion_ctn->fecha_inicio) : '' ?>">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                                <label for="input_fecha_fin" class="col-form-label">Fecha fin<span class="requerido">*</span></label>
                                <div class="input-group with-addon-icon-left">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="input_fecha_fin" class="form-control datepicker_shards"
                                           placeholder="Fecha límite" data-rule-required="true"
                                           name="publicacion_ctn[fecha_fin]"
                                           value="<?= isset($publicacion_ctn) ? fechaBDToHtml($publicacion_ctn->fecha_fin) : '' ?>">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-12">
                                <label for="input_fecha_limite_inscripcion" class="col-form-label">Fecha limite<span class="requerido">*</span></label>
                                <div class="input-group with-addon-icon-left">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="input_fecha_fin" class="form-control datepicker_shards" placeholder="Fecha límite" data-rule-required="true"
                                           name="publicacion_ctn[fecha_limite_inscripcion]" value="<?= isset($publicacion_ctn) ? fechaBDToHtml($publicacion_ctn->fecha_limite_inscripcion) : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_lugar_imparticion" class="col-form-label">Lugar donde se impartirá<span class="requerido">*</span></label>
                                <textarea id="input_lugar_imparticion" class="form-control" data-rule-required="true" placeholder="Lugar donde se impartirá el curso" rows="5"
                                          name="publicacion_ctn[direccion_imparticion]"><?= isset($publicacion_ctn) ? $publicacion_ctn->direccion_imparticion : 'Centro Educativo Campus Cívika. Ferrocarril Mexicano 286. Colonia 20 de noviembre. Apizaco, Tlax. C.P. 90341' ?></textarea>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_mapa" class="col-form-label">Mapa<span class="requerido">*</span></label>
                                <input id="input_mapa" type="text" class="form-control" data-rule-required="true" data-rule-url="true"
                                       placeholder="Link del mapa" name="publicacion_ctn[mapa]" value="<?= isset($publicacion_ctn) ? $publicacion_ctn->mapa : 'https://goo.gl/maps/tbHXvx8UksC2' ?>">
                            </div>
                        </div>

                        <div class="row row_form">

                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_agente_capacitador" class="col-form-label">Agente Capacitador</label>
                                <input id="input_agente_capacitador" class="form-control" data-rule-required="true" name="publicacion_ctn[agente_capacitador]"
                                       placeholder="Nombre del agente Capacitador" value="<?= isset($publicacion_ctn) ? $publicacion_ctn->agente_capacitador : 'Civika Holding Latinoamérica S.A. de C.V. (CHL111213MX1-0013)' ?>">
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_duracion" class="col-form-label">Duración curso<span class="requerido">*</span></label>
                                <input id="input_duracion" class="form-control" name="publicacion_ctn[duracion]" data-rule-required="true" placeholder="Duración (hrs)"
                                       value="<?= isset($publicacion_ctn) ? $publicacion_ctn->duracion : '' ?>">
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_duracion" class="col-form-label">Duración const.<span class="requerido">*</span></label>
                                <input id="input_duracion" class="form-control" name="publicacion_ctn[duracion]" data-rule-required="true" placeholder="Duración (hrs)"
                                       value="<?= isset($publicacion_ctn) ? $publicacion_ctn->duracion_constancia : $curso->duracion ?>">
                            </div>
                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_duracion" class="col-form-label">Horario<span class="requerido">*</span></label>
                                <input id="input_duracion" class="form-control" name="publicacion_ctn[horario]" value="<?= isset($publicacion_ctn) ? $publicacion_ctn->horario : '' ?>"
                                       data-rule-required="true" placeholder="Horario (ej. de 9 a 15 hrs)">
                            </div>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_costo_en_tiempo" class="col-form-label">Costo</label>
                                <div class="input-group with-addon-icon-left">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input id="input_costo_en_tiempo" class="form-control" type="number"
                                           data-rule-required="true" data-rule-number="true"
                                           name="publicacion_ctn[costo_en_tiempo]" placeholder="Costo"
                                           value="<?= isset($publicacion_ctn) ? $publicacion_ctn->costo_en_tiempo : '' ?>">
                                </div>
                            </div>

                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_banner_img" class="col-form-label">Logotipo empresa<span
                                            class="requerido">*</span></label>
                                <input id="input_banner_img" type="file" class="file fileUploadLogotipoEmpresa"
                                       accept="image/*" name="img_banner">
                            </div>
                            <div id="div_conteiner_file_banner"
                                 class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <?php if (isset($publicacion_ctn_banner) && $publicacion_ctn_banner): ?>
                                    <div>
                                        <label for="banner_id_documento" class="col-form-label">Imagen del
                                            logotipo</label> <span class="help-block help-span">Puede reemplazar el logo subiendo otra imagen</span>
                                        <br>
                                        <input id="banner_id_documento" class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[banner][id_documento]"
                                               value="<?= $publicacion_ctn_banner->id_documento ?>">
                                        <input type="hidden" name="publicacion_has_doc_banner[banner][tipo]" value="logo_empresa">
                                        <input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][titulo]"
                                               value="Logotipo de la empresa">
                                        <input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][descripcion]"
                                               value="Es el logotipo de la empresa que se usara en la constancia de la DC-3">
                                        <button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage"
                                                data-nombre_archivo="<?= $publicacion_ctn_banner->documento_banner->nombre ?>"
                                                data-src_image="<?= $publicacion_ctn_banner->documento_banner->ruta_documento ?>">
                                            <i class="fa fa-image"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" id="inputs_checkeds_constancias">
                                <label for="input_check_constancias_emitidas" class="col-form-label">Constancias
                                    ortorgadas<span class="requerido">*</span></label>
                                <?php $index_other = 99999; ?>
                                <?php foreach ($catalogo_constancias as $index => $cc): ?>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox"
                                               class="custom-control-input checkbox_change_show_hide catalogo_constancia"
                                               id="check_cat_constancia_<?= $cc->id_catalogo_constancia ?>"
                                               data-id_val_show="99999" data-div_show="#especifique_constancia"
                                            <?= isset($publicacion_ctn_has_constancia) && array_key_exists($cc->id_catalogo_constancia, $publicacion_ctn_has_constancia) ? 'checked="checked"' : '' ?>
                                               value="<?= $cc->id_catalogo_constancia ?>"
                                               name="publicacion_ctn_has_constancia[<?= $cc->id_catalogo_constancia ?>][id_catalogo_constancia]">
                                        <label class="custom-control-label"
                                               for="check_cat_constancia_<?= $cc->id_catalogo_constancia ?>"><?= $cc->nombre ?></label>
                                        <?php if ($cc->id_catalogo_constancia != $index_other): ?>
                                            <span class="help-span"><?= $curso->nombre ?></span>
                                        <?php else: ?>
                                            <span class="help-span"
                                                  id="nombre_aparece_constancia"><?= isset($publicacion_ctn) ? $publicacion_ctn->nombre_curso_comercial : '' ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                                <div id="especifique_constancia" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                    <?= isset($publicacion_ctn_has_constancia) && array_key_exists($index_other, $publicacion_ctn_has_constancia) ? '' : 'style="display: none"' ?> >
                                    <input class="form-control especifique_constancia"
                                           placeholder="Especifique la constancia"
                                           data-rule-required="true"
                                           name="publicacion_ctn_has_constancia[<?= $index_other ?>][especifique_otra_constancia]"
                                           value="<?= isset($publicacion_ctn_has_constancia) && array_key_exists($index_other, $publicacion_ctn_has_constancia) ? $publicacion_ctn_has_constancia[$index_other]->especifique_otra_constancia : '' ?>">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" id="inputs_radio_coffe">
                                <div class="row row_form">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-0">
                                        <label for="input_check_coffe_break_ofrecer" class="col-form-label">Coffe
                                            Break<span class="requerido">*</span></label>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-0">
                                        <select id="input_check_coffe_break_ofrecer" class="custom-select"
                                                name="publicacion_ctn[id_catalogo_break_curso]"
                                                data-rule-required="true">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($catalogo_coffe_break as $ccb): ?>
                                                <option value="<?= $ccb->id_catalogo_break_curso ?>" <?= isset($publicacion_ctn) && $publicacion_ctn->id_catalogo_break_curso == $ccb->id_catalogo_break_curso ? 'selected="selected"' : '' ?> ><?= $ccb->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                                        <input class="form-control descripcion"
                                               placeholder="Descripción del break del curso"
                                               name="publicacion_ctn[descripcion_break_curso]"
                                               value="<?= isset($publicacion_ctn) ? $publicacion_ctn->descripcion_break_curso : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label class="col-form-label">¿Es constancia externa?</label>
                            <select class="custom-select" name="publicacion_ctn[tiene_constancia_externa]"
                                    data-rule-required="true">
                                <option value="no" <?= isset($publicacion_ctn) && $publicacion_ctn->tiene_constancia_externa == 'no' ? 'selected="selected"' : '' ?>>No</option>
                                <option value="si" <?= isset($publicacion_ctn) && $publicacion_ctn->tiene_constancia_externa == 'si' ? 'selected="selected"' : '' ?>>Si</option>
                            </select>
                        </div>

                        <div class="row row_form">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label for="input_adicionales" class="col-form-label">Adicionales</label>
                                <textarea id="input_adicionales" class="form-control"
                                          name="publicacion_ctn[adicionales]"
                                          placeholder="Descripción de notas/adicionales al curso"><?= isset($publicacion_ctn) ? $publicacion_ctn->adicionales : '' ?></textarea>
                            </div>
                        </div>

                        <!-- apartado de rows ocultos -->
                        <div id="newRowInstructorAula" style="display: none;">
                            <!--
                            <?php
                            $data['pintar_vacio'] = true;
                            $data['rows'] = array(array());
                            $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/instructor_aula', $data);
                            ?>
                        -->
                        </div>

                        <div id="newRowMaterialApoyo" style="display: none;">
                            <!--
                            <?php
                            $data['pintar_vacio'] = true;
                            $data['rows'] = array(array());
                            $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/material_apoyo', $data);
                            ?>
                        -->
                        </div>

                        <!-- apartado de instructores -->
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="input_instructor" class="col-form-label">Instructor(es) <span
                                            class="requerido">*</span> <span class="help-span help-block ">Agregue por lo menos 1 instructor</span></label>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th width="40%" class="text-center">Instructor</th>
                                            <th class="text-center">Aula</th>
                                            <th class="text-center" width="10%">
                                                <button type="button" id="agregar_instructor_aula"
                                                        class="btn btn-primary btn-sm btn-pill agregar_row_instructor_aula"
                                                        data-origen="#newRowInstructorAula"
                                                        data-destino="#tbodyInstructorAula">
                                                    Agregar
                                                </button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyInstructorAula">
                                        <?php if (isset($publicacion_ctn)): ?>
                                            <?php
                                            $data['pintar_vacio'] = false;
                                            $data['rows'] = $instructores_asignados;
                                            $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/instructor_aula', $data);
                                            ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- apartado de material de apoyo -->
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="col-form-label">Material de apoyo <span class="help-block help-span">Opcional</span></label>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Titúlo</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">¿Documento público?</th>
                                            <th class="text-center">Documento(s)</th>
                                            <th class="text-center" width="10%">
                                                <button type="button"
                                                        class="btn btn-primary btn-sm btn-pill agregar_row_material_apoyo"
                                                        data-origen="#newRowMaterialApoyo"
                                                        data-destino="#tbodyMaterialApoyo">
                                                    Agregar
                                                </button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyMaterialApoyo">
                                        <?php if (isset($publicacion_ctn)): ?>
                                            <?php
                                            $data['pintar_vacio'] = false;
                                            $data['rows'] = $publicacion_ctn_material_apoyo;
                                            $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/material_apoyo', $data);
                                            ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <button type="button" class="btn btn-success btn-pill btn-sm guardar_publicacion_ctn_empresa">
                            <?= isset($publicacion_ctn) ? 'Actualizar publicación' : 'Publicar' ?>
                        </button>
                        <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar
                        </button>
                    </div>
                </form>

            <?php else: ?>

                <div class="container">
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-danger">
                                No es posible publicar en este momento el curso no tiene registrados instructores en el
                                sistema, ingrese uno e intentelo más tarde
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cerrar
                        </button>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>