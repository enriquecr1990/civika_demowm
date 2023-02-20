<div class="modal fade" role="dialog" id="modal_registrar_modificar_curso">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($curso) ? 'Modificar curso' : 'Agregar curso'?> STPS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_guardar_curso_civika">

                <input type="hidden" name="curso_taller_norma[id_curso_taller_norma]" value="<?=isset($curso) ? $curso->id_curso_taller_norma : ''?>">
                <input type="hidden" name="curso_taller_norma[tipo]" value="curso">

                <div class="col-sm-12">
                    <div id="form_mensajes_curso_registro" class="mensajes_sistema_civik"></div>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Nombre DC3 <span class="requerido">*</span></label>
                            <input id="input_nombre" class="form-control" placeholder="Nombre del curso (STPS)" data-rule-required="true"
                                   name="curso_taller_norma[nombre]" value="<?=isset($curso) ? $curso->nombre : ''?>">
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Duración <span class="requerido">*</span></label>
                            <input id="input_nombre" class="form-control" type="number" placeholder="Duración del curso" data-rule-required="true"
                                   name="curso_taller_norma[duracion]" value="<?=isset($curso) ? $curso->duracion : ''?>">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_area_tematica" class="col-form-label">Área temática <span class="requerido">*</span></label>
                            <select id="input_area_tematica" class="custom-select" data-rule-required="true"
                                    name="curso_taller_norma[id_catalogo_area_tematica]">
                                <option value="">Seleccione</option>
                                <?php foreach ($catalogo_area_tematica as $cat): ?>
                                    <option value="<?=$cat->id_catalogo_area_tematica?>" <?=isset($curso) && $curso->id_catalogo_area_tematica == $cat->id_catalogo_area_tematica ? 'selected="selected"':''?>><?=$cat->clave.' '.$cat->denominacion?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!--<div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="textarea_descripcion" class="col-form-label">Descripción <span class="requerido">*</span></label>
                            <textarea id="textarea_descripcion" class="form-control" data-rule-required="true"
                                      placeholder="Describa brevemente el curso" rows="4"
                                      name="curso_taller_norma[descripcion]"><?=isset($curso) ? $curso->descripcion : ''?></textarea>
                        </div>-->
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="textarea_descripcion" class="col-form-label">Objetivo <span class="requerido">*</span></label>
                            <textarea id="textarea_descripcion" class="form-control" data-rule-required="true"
                                      placeholder="Describa brevemente el objetivo general del curso" rows="4"
                                      name="curso_taller_norma[objetivo]"><?=isset($curso) ? $curso->objetivo : ''?></textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="textarea_temario" class="col-form-label">Temario <span class="requerido">*</span></label>
                            <textarea id="textarea_temario" class="form-control" data-rule-required="true"
                                      placeholder="Describa brevemente el temario del curso" rows="4"
                                      name="curso_taller_norma[temario]"><?=isset($curso) ? $curso->temario : ''?></textarea>
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Instructor(es) <span class="requerido">*</span></label>
                            <input id="input_nombre" class="form-control" type="text" placeholder="Instructor o instructores del curso" data-rule-required="true"
                                   name="curso_taller_norma[instructor]" value="<?=isset($curso) ? $curso->instructor : ''?>">
                        </div>
                    </div>
                    -->
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="input_nombre" class="col-form-label">Instructor(es) <span class="requerido">*</span></label>
                            <select class="custom-select" data-rule-required="true" multiple name="instructores[]">
                                <?php foreach ($instructores as $i): ?>
                                    <option value="<?=$i->id_instructor?>" <?=isset($instructores_ctn) && in_array($i->id_instructor,$instructores_ctn) ? 'selected="selected"':''?>><?=$i->abreviatura.' '.$i->nombre_completo?></option>
                                <?php endforeach; ?>
                            </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="curso_taller_norma[mostrar_banner]"
                                    <?=isset($curso) && $curso->mostrar_banner == 'si' ? 'checked':''?>
                                       class="custom-control-input" id="chk_mostrar_banner" value="1" >
                                <label class="custom-control-label" for="chk_mostrar_banner">¿Mostrar imagen banner principal?</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <label for="input_banner_img" class="col-form-label">Banner proximo curso</label>
                            <input id="input_banner_img" type="file" class="file fileUploadBannerProximoCurso"
                                   accept="image/*" name="img_banner">
                        </div>
                        <div id="div_conteiner_file_banner_proxico_curso" class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <?php if(isset($curso->documento_banner) && $curso->documento_banner): ?>
                                <label for="banner_proximo_curso_id_documento" class="col-form-label">Imagen del banner</label>
                                <span class="help-block help-span">Puede reemplazar el banner subiendo otra imagen</span> <br>
                                <input id="banner_proximo_curso_id_documento" class="documento_banner_proximo_curso" type="hidden" name="curso_taller_norma[id_documento]" value="<?=$curso->id_documento?>">
                                <button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage"
                                        data-nombre_archivo="<?=$curso->documento_banner->nombre?>"
                                        data-src_image="<?=$curso->documento_banner->ruta_documento?>">
                                    <i class="fa fa-image"></i>
                                </button>&nbsp;
                                <a class="btn btn-secondary btn-pill btn-sm" href="<?=$curso->documento_banner->ruta_documento?>" target="_blank">Ver imagen</a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-pill btn-sm guardar_curso_civik">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>