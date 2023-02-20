<div class="modal fade" role="dialog" id="modal_registrar_modificar_pregunta_evaluacion">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title"><?=isset($pregunta_publicacion_ctn) ? 'Modificar' : 'Agregar'?> pregunta evaluación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_guardar_pregunta_evaluacion_ctn">

                <div id="form_guardar_pregunta_evaluacion_ctn_msg" class="mensajes_sistema_civik"></div>

                <input type="hidden" name="pregunta_publicacion_ctn[id_pregunta_publicacion_ctn]" value="<?=isset($pregunta_publicacion_ctn) ? $pregunta_publicacion_ctn->id_pregunta_publicacion_ctn : ''?>">
                <input type="hidden" name="pregunta_publicacion_ctn[id_evaluacion_publicacion_ctn]" value="<?=$id_evaluacion_publicacion_ctn?>">

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label for="slt_opcion_pregunta_form" class="col-form-label">Tipo de pregunta:</label>
                            <select id="slt_opcion_pregunta_form" class="custom-select" data-rule-required="true"
                                    data-id_pregunta_publicacion_ctn="<?=isset($pregunta_publicacion_ctn) ? $pregunta_publicacion_ctn->id_pregunta_publicacion_ctn:''?>"
                                    name="pregunta_publicacion_ctn[id_opciones_pregunta]">
                                <option value="">Seleccione</option>
                                <?php foreach ($catalogo_tipo_opciones_pregunta as $ctop): ?>
                                    <option value="<?=$ctop->id_opciones_pregunta?>" <?=isset($pregunta_publicacion_ctn) && $pregunta_publicacion_ctn->id_opciones_pregunta == $ctop->id_opciones_pregunta ? 'selected="selected"':''?>><?=$ctop->opcion_pregunta?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="destino_registro_opciones_pregunta_complemento" class="row">
                        <div class="form-group col-lg-12">
                            <?php if(isset($pregunta_publicacion_ctn)): ?>
                                <?php switch ($pregunta_publicacion_ctn->id_opciones_pregunta){
                                    case OPCION_VERDADERO_FALSO:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/verdadero_falso');
                                        break;
                                    case OPCION_UNICA_OPCION:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/unica_opcion');
                                        break;
                                    case OPCION_OPCION_MULTIPLE:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/opcion_multiple');
                                        break;
                                    case OPCION_IMAGEN_UNICA_OPCION:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/img_unica_opcion');
                                        break;
                                    case OPCION_IMAGEN_OPCION_MULTIPLE:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/img_opcion_multiple');
                                        break;
                                    case OPCION_SECUENCIAL:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/secuenciales');
                                        break;
                                    case OPCION_RELACIONAL:
                                        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/relacionales');
                                        break;
                                }
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success btn-pill btn-sm guardar_pregunta_evaluacion_ctn">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>