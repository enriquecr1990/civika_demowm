<div class="modal fade" role="dialog" id="modal_detalle_publicacion_curso_civika">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Detalle de la publicación</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <!-- apartado los campos para publicar el curso -->
                <div class="row">

                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label for="input_nombre_dc3" class="col-form-label">Nombre del curso DC-3</label>
                        <span id="input_nombre_dc3"><?=$curso->nombre?></span>
                    </div>

                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="col-form-label">Nombre del curso comercial</label>
                        <span><?=$publicacion_ctn->nombre_curso_comercial?></span>
                    </div>

                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="col-form-label">Eje temático</label>
                        <span><?=$publicacion_ctn->eje_tematico?></span>
                    </div>

                    <div class="form-group col-lg-3 col-md-4 col-sm-12 col-12">
                        <label class="col-form-label">Fecha de impartición</label>
                        <span><?=fechaBDToHtml($publicacion_ctn->fecha_inicio)?></span>
                    </div>
                    <div class="form-group col-lg-3 col-md-4 col-sm-12 col-12">
                        <label class="col-form-label">Fecha fin</label>
                        <span><?=fechaBDToHtml($publicacion_ctn->fecha_fin)?></span>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label class="col-form-label">Lugar donde se impartirá </label>
                        <span><?=$publicacion_ctn->direccion_imparticion?></span>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <label for="input_mapa" class="col-form-label">Ubicación</label>
                        <a href="<?=$publicacion_ctn->mapa?>" target="_blank" class="btn btn-outline-primary btn-sm btn-pill">Ver mapa</a>
                    </div>
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <label class="col-form-label">Duración</label>
                        <span><?=$publicacion_ctn->duracion?> (en horas)</span>
                    </div>

                    <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <label class="col-form-label">Agente Capacitador</label>
                        <span><?=$publicacion_ctn->agente_capacitador?></span>
                    </div>

                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                        <label class="col-form-label">Horario</label>
                        <span><?=$publicacion_ctn->horario?></span>
                    </div>
                    <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <label class="col-form-label">Costo</label>
                        <span>$<?=number_format($publicacion_ctn->costo_en_tiempo,2)?></span>
                    </div>

                    <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                        <?php if(isset($publicacion_ctn_banner->documento_banner) && is_object($publicacion_ctn_banner->documento_banner)): ?>
                            <label class="col-form-label">Banner del curso</label>
                            <button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage"
                                    data-nombre_archivo="<?=$publicacion_ctn_banner->documento_banner->nombre?>" data-src_image="<?=$publicacion_ctn_banner->documento_banner->ruta_documento?>">
                                <i class="fa fa-image"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12" id="inputs_checkeds_constancias">
                        <label for="input_check_constancias_emitidas" class="col-form-label">Constancias ortorgadas</label>
                        <?php $index_other = 99999; ?>
                        <?php foreach ($catalogo_constancias as $index => $cc): ?>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input checkbox_change_show_hide catalogo_constancia" id="check_cat_constancia_<?=$cc->id_catalogo_constancia?>"
                                       data-id_val_show="99999" data-div_show="#especifique_constancia"
                                       <?=isset($publicacion_ctn_has_constancia) && array_key_exists($cc->id_catalogo_constancia,$publicacion_ctn_has_constancia) ? 'checked="checked"':''?>
                                       value="<?=$cc->id_catalogo_constancia?>" name="publicacion_ctn_has_constancia[<?=$cc->id_catalogo_constancia?>][id_catalogo_constancia]">
                                <label class="custom-control-label" for="check_cat_constancia_<?=$cc->id_catalogo_constancia?>"><?=$cc->nombre?></label>
                            </div>
                        <?php endforeach; ?>
                        <div id="especifique_constancia" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"
                             <?=isset($publicacion_ctn_has_constancia) && array_key_exists($index_other,$publicacion_ctn_has_constancia) ? '':'style="display: none"'?> >
                            <span class="help-span"><?=$publicacion_ctn_has_constancia[$index_other]->especifique_otra_constancia?></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-3 col-sm-12 col-xs-12" id="inputs_radio_coffe">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-0">
                                <label for="input_check_coffe_break_ofrecer" class="col-form-label">Coffe Break</label>
                                <?php foreach ($catalogo_coffe_break as $ccb): ?>
                                    <?=isset($publicacion_ctn) && $publicacion_ctn->id_catalogo_break_curso == $ccb->id_catalogo_break_curso ? $ccb->nombre:''?>
                                <?php endforeach; ?>
                                <br><span class="help-span"><?=$publicacion_ctn->descripcion_break_curso?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- apartado de instructores -->
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="input_instructor" class="col-form-label">Instructor(es)  <span class="help-span help-block ">Agregue por lo menos 1 instructor</span></label>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="40%" class="text-center">Instructor</th>
                                    <th class="text-center">Aula</th>
                                    <th class="text-center" width="10%"></th>
                                </tr>
                                </thead>
                                <tbody id="tbodyInstructorAula">
                                <?php if(isset($publicacion_ctn)): ?>
                                    <?php
                                    $data['pintar_vacio'] = false;
                                    $data['lectura'] = true;
                                    $data['rows'] = $instructores_asignados;
                                    $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/instructor_aula',$data);
                                    ?>
                                <?php endif;?>
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
                                    <th class="text-center">Documento PDF</th>
                                    <th class="text-center" width="10%"></th>
                                </tr>
                                </thead>
                                <tbody id="tbodyMaterialApoyo">
                                <?php if(isset($publicacion_ctn)): ?>
                                    <?php
                                    $data['pintar_vacio'] = false;
                                    $data['rows'] = $publicacion_ctn_material_apoyo;
                                    $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/material_apoyo',$data);
                                    ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-success btn-pill btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>