<div class="modal fade" role="dialog" id="modal_registrar_modificar_experiencia_curricular">
    <div class="modal-dialog modal-mlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title">Experiencia curricular instructor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form id="form_guardar_datos_usuario_to_cv">

                <div class="mensajes_sistema_civik" id="form_mensajes_instructor_cv">

                </div>

                <input id="id_usuario" type="hidden" name="id_instructor" value="<?=$usuario_instructor->id_instructor?>">

                <div class="modal-body">

                    <!-- row vacios -->
                    <div id="new_row_preparacion_academica" class="noview">
                        <!--
                        <?php
                        $data['pintar_vacio'] = true;
                        $data['rows_array'] = array(array());
                        $this->load->view('cursos_civik/control_usuarios/instructor/rows_preparacion_academica',$data);
                        ?>
                        -->
                    </div>

                    <div id="new_row_certificacion_diplomado_curso" class="noview">
                        <!--
                        <?php
                        $data['pintar_vacio'] = true;
                        $data['rows_array'] = array(array());
                        $this->load->view('cursos_civik/control_usuarios/instructor/rows_certificaciones_diplomados_cursos',$data);
                        ?>
                        -->
                    </div>

                    <div id="new_row_experiencia_laboral" class="noview">
                        <!--
                        <?php
                        $data['pintar_vacio'] = true;
                        $data['rows_array'] = array(array());
                        $this->load->view('cursos_civik/control_usuarios/instructor/rows_experiencia_laboral',$data);
                        ?>
                        -->
                    </div>

                    <!-- tablas -->
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="badge badge-info">Preparación académica</span><span class="requerido">*</span>
                        </div>
                    </div>

                    <div class="row" id="title_preparacion_academica">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Profesión carrera</th>
                                        <th>Institución</th>
                                        <th>Fecha de finalización</th>
                                        <th class="text-right">
                                            <button class="btn btn-success btn-pill btn-sm agregar_row_preparacion_academica"
                                                    data-destino="#tbodyPreparacionAcademida"
                                                    data-origen="#new_row_preparacion_academica">
                                                <i class="fa fa-bookmark"></i> Agregar nuevo
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPreparacionAcademida">
                                    <?php
                                    $data['pintar_vacio'] = false;
                                    $data['rows_array'] = isset($array_instructor_preparacion_academica) ? $array_instructor_preparacion_academica : array();
                                    $this->load->view('cursos_civik/control_usuarios/instructor/rows_preparacion_academica',$data);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="title_certificacion_diplo_curso">
                            <span class="badge badge-info">Certificaciones, Diplomados y Cursos</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Instituto que avala</th>
                                        <th>Fecha de conclusión</th>
                                        <th class="text-right">
                                            <button class="btn btn-success btn-pill btn-sm agregar_row_cert_diplo_crs"
                                                    data-destino="#tbody_crt_diplo_crs"
                                                    data-origen="#new_row_certificacion_diplomado_curso">
                                                <i class="fa fa-bookmark"></i> Agregar nuevo
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_crt_diplo_crs">
                                    <?php
                                    $data['pintar_vacio'] = false;
                                    $data['rows_array'] = isset($array_instructor_certificacion_diplomado_curso) ? $array_instructor_certificacion_diplomado_curso : array();
                                    $this->load->view('cursos_civik/control_usuarios/instructor/rows_certificaciones_diplomados_cursos',$data);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="title_experiencia_laboral">
                            <span class="badge badge-info">Experiencia laboral</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Puesto/cargo</th>
                                        <th>Empresa</th>
                                        <th>Fecha de inicio</th>
                                        <th>
                                            Fecha de finalización<br>
                                            <span class="help-span">Deje vacio en caso de seguir laborando</span>
                                        </th>
                                        <th class="text-right">
                                            <button class="btn btn-success btn-pill btn-sm agregar_row_experiencia_laboral"
                                                    data-destino="#tbodyExperienciaLaboral"
                                                    data-origen="#new_row_experiencia_laboral">
                                                <i class="fa fa-bookmark"></i> Agregar nuevo
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyExperienciaLaboral">
                                    <?php
                                    $data['pintar_vacio'] = false;
                                    $data['rows_array'] = isset($array_instructor_experiencia_laboral) ? $array_instructor_experiencia_laboral : array();
                                    $this->load->view('cursos_civik/control_usuarios/instructor/rows_experiencia_laboral',$data);
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center; !important;">
                    <button type="button" class="btn btn-success btn-sm btn-pill guardar_datos_instructor_para_cv">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-sm btn-pill" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>