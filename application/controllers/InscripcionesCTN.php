<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InscripcionesCTN extends CI_Controller
{

    private $usuario;
    private $notificaciones;

    function __construct()
    {
        parent:: __construct();
        $this->load->model('AlumnosModel', 'AlumnosModel');
        $this->load->model('CatalogosModel', 'CatalogosModel');
        $this->load->model('ControlUsuariosModel', 'ControlUsuariosModel');
        $this->load->model('NotificacionesModel', 'NotificacionesModel');
        $this->load->model('administrarCTN/CursosModel', 'CursosModel');
        $this->load->model('administrarCTN/InscripcionModel', 'InscripcionModel');
        $this->load->model('Cotizaciones_model');
        if (sesionActive()) {
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }
    }

    public function iniciarSesion()
    {
        $retorno['exito'] = true;
        $retorno['msg'] = '';
        $post = $this->input->post();
        $retorno['id_publicacion_ctn'] = $post['curso_inscripcion']['id_publicacion_ctn'];
        $registro = $this->ControlUsuariosModel->registroAlumnoCTN($post);
        if ($registro['exito']) {
            $sesion = array(
                'usuario' => $registro['usuario'],
                'curso_inscripcion' => $post['curso_inscripcion']
            );
            $this->session->set_userdata($sesion);
        } else {
            $retorno = $registro;
        }
        echo json_encode($retorno);
        exit;
    }

    public function actualizarDatosAlumno($id_publicacion_ctn,$tried_payment = false)
    {
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url('extras/js/usuario/control_usuarios.js'),
            base_url('extras/js/adminCtn/inscripciones.js'),
        );
        $data['curso_incripcion'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data_usuario = $this->ControlUsuariosModel->obtenerUsuarioDetalle($this->usuario->id_usuario, 'alumno');
        $data['alumno_inscrito_ctn_publicacion'] = $this->InscripcionModel->alumnoProcesoInscripcion($id_publicacion_ctn, $data_usuario['usuario_alumno']->id_alumno);
        $data['datos_fiscales'] = $this->AlumnosModel->obtener_datos_facturacion($data['alumno_inscrito_ctn_publicacion']->id_alumno_inscrito_ctn_publicado);
        $data['catalogo_titulo_academico'] = $this->CatalogosModel->obtenerCatalogoTituloAcademico();
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $data['catalogo_uso_cfdi_persona_fisica'] = $this->CatalogosModel->obtenerUsoCFDI('fisica');
        $data['catalogo_uso_cfdi_persona_moral'] = $this->CatalogosModel->obtenerUsoCFDI('moral');
        $data = array_merge($data, $data_usuario);
        $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
        $data['empresa'] = $this->ControlUsuariosModel->obtenerEmpresaByAlumno($data['usuario_alumno']->id_alumno);
        if(is_null($data['empresa'])){
            $insert_empresa_alumno = array(
                'id_alumno' => $data['usuario_alumno']->id_alumno
            );
            $this->ControlUsuariosModel->guardarEmpresaAlumno($insert_empresa_alumno);
            $data['empresa'] = $this->ControlUsuariosModel->obtenerEmpresaByAlumno($data['usuario_alumno']->id_alumno);
        }
        $data['guardo_datos_generales'] = $data['usuario_alumno']->update_datos == 0 ? false : true;
        $data['guardo_datos_empresa'] = $data['empresa']->update_datos == 0 ? false : true;
        $data['disabled_edicion_datos'] = false;
        $data['es_inscripcion_por_pasos'] = true;
        //echo '<pre>'.print_r($data);exit;
        if($tried_payment !== false){
            $data['tried_payment'] = true;
        }
        if ($data['alumno_inscrito_ctn_publicacion']->id_catalogo_proceso_inscripcion != PROCESO_PAGO_ACTUALIZACION_DATOS
            && $data['alumno_inscrito_ctn_publicacion']->id_catalogo_proceso_inscripcion != PROCESO_PAGO_OBSERVADO) {
            $data['disabled_edicion_datos'] = true;
        }
        //var_dump($data);exit;
        //decision para saber que formulario cargar
        if ($data['curso_incripcion']->aplica_dc3 !== false || $data['curso_incripcion']->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE) {
            //se carga el formulario para la inscripcion por pasos
            $this->load->view('cursos_civik/inscripcion/alumno/formulario_datos', $data);
        }
        if ($data['curso_incripcion']->aplica_dc3 === false && $data['curso_incripcion']->id_catalogo_tipo_publicacion != CURSO_EVALUACION_ONLINE) {
            //se carga el formulario para la inscripcion por unico formulario
            $this->load->view('cursos_civik/inscripcion/alumno/formulario_datos_personales', $data);
        }
        //$this->load->view('cursos_civik/inscripcion/alumno/formulario_datos_personales',$data);
    }

    public function actualizarDatosInscripcion($id_publicacion_ctn)
    {
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url('extras/js/usuario/control_usuarios.js'),
            base_url('extras/js/adminCtn/inscripciones.js'),
            base_url() . 'extras/plugins/fileinput/js/fileinput.js',
            base_url() . 'extras/plugins/fileupload/js/vendor/jquery.ui.widget.js',
            base_url() . 'extras/plugins/fileupload/js/jquery.iframe-transport.js',
            base_url() . 'extras/plugins/fileupload/js/jquery.fileupload.js',
        );
        $data['extra_css'] = array(
            base_url() . 'extras/plugins/fileinput/css/fileinput.css',
            base_url() . 'extras/plugins/fileupload/css/jquery.fileupload.css',
        );
        $data['curso_incripcion'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data_usuario = $this->ControlUsuariosModel->obtenerUsuarioDetalle($this->usuario->id_usuario, 'alumno');
        $data['alumno_inscrito_ctn_publicacion'] = $this->InscripcionModel->alumnoProcesoInscripcion($id_publicacion_ctn, $data_usuario['usuario_alumno']->id_alumno);
        $data['datos_fiscales'] = $this->AlumnosModel->obtener_datos_facturacion($data['alumno_inscrito_ctn_publicacion']->id_alumno_inscrito_ctn_publicado);
        $data['catalogo_titulo_academico'] = $this->CatalogosModel->obtenerCatalogoTituloAcademico();
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $data['catalogo_uso_cfdi_persona_fisica'] = $this->CatalogosModel->obtenerUsoCFDI('fisica');
        $data['catalogo_uso_cfdi_persona_moral'] = $this->CatalogosModel->obtenerUsoCFDI('moral');
        $data = array_merge($data, $data_usuario);
        $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
        $data['empresa'] = $this->ControlUsuariosModel->obtenerEmpresaByAlumno($data['usuario_alumno']->id_alumno);
        $data['guardo_datos_generales'] = $data['usuario_alumno']->update_datos == 0 ? false : true;
        $data['guardo_datos_empresa'] = $data['empresa']->update_datos == 0 ? false : true;
        $data['disabled_edicion_datos'] = false;
        if ($data['alumno_inscrito_ctn_publicacion']->envio_datos_dc3 == 'si') {
            $data['disabled_edicion_datos'] = true;
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/inscripcion/alumno/formulario_datos_complemetarios', $data);
    }

    public function carta_descriptiva_curso($id_publicacion_ctn)
    {
        $data['usuario'] = $this->usuario;
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['formas_pago'] = $this->CatalogosModel->obtenerCatalogoFormasPago($id_publicacion_ctn);
        $data['formas_pago_detalle'] = $this->CatalogosModel->obtener_forma_pago_detalle($id_publicacion_ctn);
        $data['instructor_asignado'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
        $data['valor_curricular'] = $this->CursosModel->obtenerConstanciaDescripcion($id_publicacion_ctn);
        $data['material_didactico'] = $this->CursosModel->obtenerMaterialDidactico($id_publicacion_ctn);
        $data['coffe_break'] = $this->CursosModel->obtenerCoffeBreak($id_publicacion_ctn);
        /// aqui esta mi funcion
        //iterar el registro de los instructores que estan asignados al curso
        foreach ($data['instructor_asignado'] as $instructor) {
            //por cada instructor obtener la preparacion academica
            $instructor->preparacion_academica = $this->CursosModel->obtener_formacion_academica_instructor($instructor->id_instructor);
        }
        foreach ($data['instructor_asignado'] as $experiencia) {
            //por cada instructor obtener la experiencia laboral
            $experiencia->experiencia_laboral = $this->CursosModel->obtener_certtificacion_instructor($experiencia->id_instructor);
        }
        foreach ($data['instructor_asignado'] as $certificaciones) {
            //por cada instructor obtener certificaciones cursos,diplomados
            $certificaciones->certificacion_curso_instructor = $this->CursosModel->obtener_diplomados_cursos_instructor($certificaciones->id_instructor);
        }
        $data['sede_presencial'] = false;
        if (isset($data['publicacion_ctn']->id_sede_presencial) && existe_valor($data['publicacion_ctn']->id_sede_presencial)) {
            $data['sede_presencial'] = $this->CatalogosModel->obtener_sede_civika($data['publicacion_ctn']->id_sede_presencial);
        }
        if (!isset($this->usuario)
            || (isset($this->usuario) && $this->usuario->tipo_usuario == 'alumno')) {
            $this->CursosModel->actualizar_visitas_publicacion_cd($id_publicacion_ctn);
        }
        $this->load->view('cursos_civik/inscripcion/carta_descriptiva', $data);
        //var_dump($data['instructor_asignado']);exit;
        //echo '<pre>';print_r($data['formas_pago_detalle']);exit;
    }

    public function guardarUsuarioAlumnoDatosPersonales()
    {
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar sus datos generales, favor de intentar mas tarde';
        if ($this->InscripcionModel->guardarUsuarioAlumnoDatosPersonales($post)) {
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó sus datos personales con éxito';
            $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
            $result['usuario'] = $data['usuario'];
            $this->session->set_userdata($data);
        }
        echo json_encode($result);
        exit;
    }

    public function guardarUsuarioAlumnoDatosEmpresa()
    {
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar sus datos de la empresa, favor de intentar mas tarde';
        if ($this->InscripcionModel->guardarUsuarioAlumnoDatosEmpresa($post)) {
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó sus datos de la DC-3 con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function registroCursoTallerNorma($idPublicacionCTN)
    {
        $data['notificaciones'] = $this->notificaciones;
        $data['id_publicacion_ctn'] = $idPublicacionCTN;
        $data['extra_js'] = array(
            base_url() . 'extras/js/adminCtn/inscripciones.js'
        );
        if (sesionActive()) {
            $this->usuario = $this->session->userdata('usuario');
            $data['usuario'] = $this->usuario;
            //cargar la vista necesaria para el registro al curso
            $this->actualizarDatosAlumno($idPublicacionCTN);
        } else {
            $this->usuario = false;
            $this->load->view('cursos_civik/inscripcion/formulario', $data);
        }
    }

    public function guardar_registro_pago()
    {
        $retorno['exito'] = false;
        $retorno['msg'] = 'No fue posible guardar su registro de pago, favor de intentar más tarde';
        $post = $this->input->post();
        if ($this->InscripcionModel->guardar_registro_pago($post)) {
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se guardo el registro de pago con exito';
        }
        echo json_encode($retorno);
        exit;
    }

    public function guardar_registro_pago_facturacion()
    {
        $retorno['exito'] = false;
        $retorno['msg'] = 'No fue posible guardar su registro de pago, favor de intentar más tarde';
        $post = $this->input->post();
        if ($this->InscripcionModel->guardar_registro_pago($post)) {
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se guardo el registro de los datos de facturación con exito';
        }
        echo json_encode($retorno);
        exit;
    }

    public function iniciar_envio_recibo_alumno_validacion($id_alumno_inscrito_ctn_publicado)
    {
        $data['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
        $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
        $this->load->view('cursos_civik/inscripcion/validacion_datos_alumno_recibo', $data);
    }

    public function iniciar_envio_complemento_inscripcion($id_alumno_inscrito_ctn_publicado)
    {
        $data['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
        $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
        $this->load->view('cursos_civik/inscripcion/validacion_datos_inscripcion_complemento', $data);
    }

    public function iniciar_envio_recibo_pago($id_alumno_inscrito_ctn_publicado)
    {
        $data['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
        $data['usuario'] = $this->ControlUsuariosModel->obtenerDatosUsuario($this->usuario->id_usuario);
        $this->load->view('cursos_civik/inscripcion/validacion_datos_inscripcion_recibo', $data);
    }

    public function enviar_recibo_validacion_civik_alumno($id_alumno_inscrito_ctn_publicado)
    {
        $retorno['exito'] = false;
        $retorno['msg'] = 'No fue posible enviar su recibo de pago para su validación, favor de intentar más tarde';
        if ($this->InscripcionModel->enviar_recibo_validacion_civik_alumno($id_alumno_inscrito_ctn_publicado)) {
            $this->NotificacionesModel->enviar_notificacion_recibo_pago_a_validar($id_alumno_inscrito_ctn_publicado);
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se envió el recibo de pago con éxito';
        }
        echo json_encode($retorno);
        exit;
    }

    public function enviar_recibo_validacion_civik_alumno_sin_dc3($id_alumno_inscrito_ctn_publicado)
    {
        $retorno['exito'] = false;
        $retorno['msg'] = 'No fue posible enviar su recibo de pago para su validación, favor de intentar más tarde';
        if ($this->InscripcionModel->enviar_recibo_validacion_civik_alumno_sin_dc3($id_alumno_inscrito_ctn_publicado)) {
            $this->NotificacionesModel->enviar_notificacion_recibo_pago_a_validar($id_alumno_inscrito_ctn_publicado);
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se envió el recibo de pago con éxito';
        }
        echo json_encode($retorno);
        exit;
    }

    public function concluir_registro_dc3($id_alumno_inscrito_ctn_publicado)
    {
        $retorno['exito'] = false;
        $retorno['msg'] = 'No fue posible concluir su registro de inscripcion para el formato DC-3, favor de intentar más tarde';
        $documento_dc3 = $this->InscripcionModel->concluir_registro_dc3($id_alumno_inscrito_ctn_publicado);
        if (is_object($documento_dc3)) {
            $this->NotificacionesModel->enviar_notificacion_conclusion_registro_dc3($id_alumno_inscrito_ctn_publicado, $documento_dc3);
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se concluyó el registro de inscripcion al curso';
        }
        echo json_encode($retorno);
        exit;
    }

    public function validarObservarComprobantePagoAlumno()
    {
        $result['exito'] = false;
        $result['inscripcion_realizada'] = false;
        $result['msg'] = 'No fue posible registrar la operación del comprobante del alumno, favor de intentar más tarde';
        $post = $this->input->post();
        $inscripcion_validacion = $this->InscripcionModel->validarObservarComprobantePagoAlumno($post);
        if ($inscripcion_validacion['exito']) {
            if ($post['cumple_comprobante'] == 'si') {
                $this->NotificacionesModel->enviar_notificacion_validacion_pago($this->usuario->id_usuario, $post['id_alumno_inscrito_ctn_publicado']);
                $result['exito'] = true;
                $result['msg'] = 'Se realizó la operación del comprobante del alumno con exito';
                $result['inscripcion_realizada'] = true;
                $result['instructor_asignado'] = $inscripcion_validacion['instructur_asignado'];
                $result['fecha_pago_validado'] = date('d/m/Y');
            } else {
                $this->NotificacionesModel->enviar_notificacion_observacion_pago($this->usuario->id_usuario, $post['id_alumno_inscrito_ctn_publicado']);
                $result['exito'] = true;
                $result['msg'] = 'Se realizó la operación del comprobante del alumno con exito';
            }
        } else {
            $result['exito'] = false;
            $result['msg'] = $inscripcion_validacion['msg'];
        }
        echo json_encode($result);
        exit;
    }

    public function concluirRegistroAlumnoCTN()
    {
        $post = $this->input->post();
        $respuesta['exito'] = true;
        $respuesta['msg'] = $post['msg_success'];
        $inscripcion = $this->CursosModel->guardarInscripcionAlumno($post);
        if (!$inscripcion['exito']) {
            $respuesta['exito'] = false;
            $respuesta['msg'] = $inscripcion['msg'];
        }
        echo json_encode($respuesta);
        exit;
    }

    public function registrar_nuevo_alumno_ctn_publicado()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'Ocurrio un error al tratar de insertar el nuevo alumno';
        if ($this->InscripcionModel->registrar_nuevo_alumno_ctn_publicado($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se registró el nuevo alumno al curso';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function registrar_alumno_existente_ctn_publicado()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'Ocurrio un error al tratar de insertar el nuevo alumno';
        if ($this->InscripcionModel->registrar_alumno_existente_ctn_publicado($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se registró el nuevo alumno al curso';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function semaforo_alumno_confirmacion()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'Ocurrio un error al tratar de actualizar el semaforo del alumno';
        if ($this->InscripcionModel->semaforo_alumno_confirmacion($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se registró el semaforo del alumno';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function registro_empresa_ctn($id_publicacion_ctn)
    {
        $data['extra_js'] = array(
            base_url('extras/js/adminCtn/inscripciones.js'),
            base_url('extras/js/adminCtn/cursos.js'),
        );
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        if($data['publicacion_ctn']->id_catalogo_tipo_publicacion == CURSO_EMPRESA){
            $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
            $data['publicacion_ctn_has_empresa_masivo'] = $this->CursosModel->obtener_empresa_publicacion_ctn_masivo($id_publicacion_ctn);
            $this->load->view('cursos_civik/inscripcion/masiva/principal_registro', $data);
        }else{
            $this->load->view('default/error_404');
        }
    }

    public function validar_rfc_empresa_publicacion_ctn()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No fue posible validar el RFC registrado, verifique la información y vuelva a intentarlo más tarde';
        $empresa_publicacion_ctn = $this->InscripcionModel->validar_rfc_empresa_publicacion_ctn($post);
        if ($empresa_publicacion_ctn) {
            if (is_null($empresa_publicacion_ctn->fecha_envio_informacion) && $empresa_publicacion_ctn->fecha_envio_informacion == '') {
                $respuesta['exito'] = true;
                $respuesta['msg'] = 'Se valido correctamente el RFC, puede realizar la inscripción de los empleados que tomaran el curso';
            } else {
                $respuesta['exito'] = false;
                $respuesta['msg'] = 'Se valido correctamente el RFC, pero se detecto que ya fueron almacenados los empleados que van a tomar el curso';
            }
        }
        echo json_encode($respuesta);
        exit;
    }

    public function capturar_empleados_publicacion_ctn_masivo()
    {
        $post = $this->input->post();
        $data['rfc'] = $post['rfc'];
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($post['id_publicacion_ctn']);
        $data['publicacion_ctn_logo_empresa'] = $this->CursosModel->obtner_publicacion_ctn_banner_logo_empresa($post['id_publicacion_ctn'],'logo_empresa');
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN($post);
        $data['empresa_alumno'] = false;
        if (sizeof($data['array_alumnos_publicacion']) != 0) {
            $data['empresa_alumno'] = $data['array_alumnos_publicacion'][0]->empresa_alumno;
        }
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civik/inscripcion/masiva/registro_alumnos', $data);
    }

    public function guardar_parcial_empleados_publicacion_ctn_masivo()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No fue posible registrar los empleados y los datos de la empresa, favor de intentarlo más tarde';
        if ($this->InscripcionModel->guardar_empleados_publiacion_ctn_masivo($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardó la información de la empresa y de los empleados para el curso';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function guardar_empleados_publiacion_ctn_masivo()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No fue posible registrar los empleados y los datos de la empresa, favor de intentarlo más tarde';
        if ($this->InscripcionModel->guardar_empleados_publiacion_ctn_masivo($post, true)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardó la información de la empresa y de los empleados para el curso';
            $this->NotificacionesModel->notificar_administradores_envio_empleados_publicacion_masiva($post['id_publicacion_ctn'], $post['empresa_alumno']['rfc']);
            $cotizacion['id_catalogo_proceso_cotizacion'] = COTIZACION_EN_ESPERA_CURSO;
            $this->Cotizaciones_model->actualizar_cotizacion_publicacion($post['id_publicacion_ctn'], $cotizacion);
        }
        echo json_encode($respuesta);
        exit;
    }

    public function baja_suscripcion_mail()
    {
        $get = $this->input->get();
        if (isset($get['email']) && existe_valor($get['email'])) {
            $this->InscripcionModel->baja_suscripcion_mail($get['email']);
            $this->session->set_flashdata('type_message', 'success');
            $this->session->set_flashdata('message', 'Se cancelo la suscripción de correo electrónico');
            redirect(base_url());
        } else {
            $this->load->view('cursos_civik/baja_suscripcion_email');
        }
    }

    /**
     * apartado d efunciones para eliminar informacion
     */
    public function eliminar_alumno_inscrito_ctn_publicado($id_usuario)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No fue posible eliminar el empleado que tomara el curso, favor de intentar más tardes';
        if ($this->InscripcionModel->eliminar_alumno_inscrito_ctn_publicado($id_usuario)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se eliminó el empleado que se habia registrado en el sistema para el curso presencial';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function evaluacion_online($id_publicacion_ctn)
    {
        $this->registroCursoTallerNorma($id_publicacion_ctn);
    }

    public function evaluacion_online_empresa()
    {

    }
}
