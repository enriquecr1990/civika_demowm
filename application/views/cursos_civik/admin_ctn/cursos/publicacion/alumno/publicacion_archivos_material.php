<div class="modal fade" role="dialog" id="modal_publicacion_subir_archivos_material">
    <div class="modal-dialog modal-mlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Material de evidencias</label>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>-->
                <button type="button" class="close cerrar_modal_civika" data-id_modal="modal_publicacion_subir_archivos_material"
                        aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div id="newRowMaterialEvidencia" style="display: none;">
                <!--
                <?php
                    $data['pintar_vacio'] = true;
                    $data['rows'] = array(array());
                    $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/material_evidencia',$data);
                ?>
                -->
            </div>

            <form id="form_guardar_material_evidencia">

                <input type="hidden" name="id_alumno_inscrito_ctn_publicado" value="<?=$id_alumno_inscrito_ctn_publicado?>">

                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <th>Titulo</th>
                                    <th>Descripcion</th>
                                    <th>Archivo evidencia/URL de vídeo</th>
                                    <th>
                                        Comentarios y observaciones
                                    </th>
                                    <th>
                                        <?php if(!$lectura): ?>
                                            <button type="button" id="agregar_material_evidencia"
                                                    class="btn btn-primary btn-sm btn-pill agregar_row_material_evidencia"
                                                    data-origen="#newRowMaterialEvidencia"
                                                    data-destino="#tbodyMaterialEvidencia">
                                                Agregar evidencia
                                            </button>
                                        <?php endif; ?>
                                    </th>
                                    </thead>
                                    <tbody id="tbodyMaterialEvidencia">
                                    <?php if(isset($array_alumnos_publicacion_ctn_has_evidencia)): ?>
                                        <?php
                                        $data['pintar_vacio'] = false;
                                        $data['rows'] = $array_alumnos_publicacion_ctn_has_evidencia;
                                        $data['lectura'] = $lectura;
                                        $data['usuario'] = $usuario;
                                        $this->load->view('cursos_civik/admin_ctn/cursos/new_rows/material_evidencia',$data);
                                        ?>
                                    <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <?php if($lectura): ?>
                        <!--<button type="button" class="btn btn-success btn-pill btn-sm " data-dismiss="modal">-->
                        <button type="button" class="btn btn-success btn-pill btn-sm cerrar_modal_civika"
                                data-id_modal="modal_publicacion_subir_archivos_material">
                            Cerrar
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-success btn-pill btn-sm publicacion_guardar_material_evidencia">
                            Aceptar
                        </button>
                        <!--<button type="button" class="btn btn-danger btn-pill btn-sm" data-dismiss="modal">-->
                        <button type="button" class="btn btn-danger btn-pill btn-sm cerrar_modal_civika" data-id_modal="modal_publicacion_subir_archivos_material">
                            Cancelar
                        </button>
                    <?php endif; ?>
                </div>
            </form>

        </div>
    </div>
</div>