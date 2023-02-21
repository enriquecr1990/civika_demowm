<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Instructores extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('AutoguardadoModel');
        $this->load->model('ControlUsuariosModel','ControlUsuariosModel');
        $this->load->model('CatalogosModel');
        $this->load->model('Evaluacion_model');
        $this->load->model('NotificacionesModel','NotificacionesModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    public function mis_cursos(){
        $data['seccion'] = 'Mis cursos';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['catalogo_tipo_publicacion'] = $this->CatalogosModel->obtener_catalogo_tipo_publicacion();
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/instructor/tablero_publicaciones',$data);
    }

    public function buscar_mis_publicaciones_ctn($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $post['id_usuario'] = $this->usuario->id_usuario;
        $data = $this->CursosModel->obtener_publicaciones_ctn_instructor($post,$pagina,$limit);
        $data['usuario'] = $this->usuario;
        $data['instructor'] = $this->ControlUsuariosModel->getDatosInstructorByIdUsuario($this->usuario->id_usuario);
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/instructor/resultados_publicaciones',$data);
    }

    public function registro_alumnos_publicacion_ctn($idPublicacionCTN){
        $data['usuario'] = $this->usuario;
        $data['instructor'] = $this->ControlUsuariosModel->getDatosInstructorByIdUsuario($this->usuario->id_usuario);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($idPublicacionCTN);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        //var_dump($data);Exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/instructor/registro_alumnos',$data);
    }

    public function buscar_registro_alumnos_publicacion_ctn(){
        $post = $this->input->post();
        $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN($post);
        $data['alumnos_asistieron'] = $this->CursosModel->obtener_numero_alumnos_asistieron_curso_publicado($post['id_publicacion_ctn']);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($post['id_publicacion_ctn']);
        $publicacion_ctn_has_empresa = $this->CursosModel->obtener_empresa_publicacion_ctn_masivo($post['id_publicacion_ctn']);
        $data['es_publicacion_empresa'] = false;
        if($publicacion_ctn_has_empresa !== false){
            $data['es_publicacion_empresa'] = true;
            $data['realizo_envio_empresa_masivo'] = isset($publicacion_ctn_has_empresa->fecha_envio_informacion) && !is_null($publicacion_ctn_has_empresa->fecha_envio_informacion);
        }
        //echo '<pre>';var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/instructor/registro_alumnos_resultados',$data);
    }

    public function actualizar_asistencia_calificaciones(){
        $post = $this->input->post();
        $data['exito'] = false;
        $data['msg'] = ERROR_SOLICITUD;
        if($this->AutoguardadoModel->actualizar_campo_tabla($post)){
            $data['exito'] = true;
            switch ($post['campo_update']){
                case 'perciento_asistencia':
                    $data['msg'] = 'Se actualizó correctamente el porcentaje de asistencia del alumno';
                    break;
                case 'calificacion_diagnostica':
                    $data['msg'] = 'Se actualizó correctamente la calificación diagnóstica de asistenc del alumno';
                    break;
                case 'calificacion_final':
                    $data['msg'] = 'Se actualizó correctamente la calificación final del alumno';
                    break;
            }
        }
        echo json_encode($data);
        exit;
    }

    public function evaluacion_diagnostica($id_publicacion_ctn){
        $this->evaluacion($id_publicacion_ctn,'diagnostica');
    }

    public function evaluacion_final($id_publicacion_ctn){
        $this->evaluacion($id_publicacion_ctn,'final');
    }

    public function buscar_preguntas_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn){
        $data['evaluacion_publicacion_ctn'] = $this->Evaluacion_model->obtener_evaluacion_publicacion_ctn_by_id($id_evaluacion_publicacion_ctn);
        $data['preguntas_publicacion_ctn'] = $this->Evaluacion_model->buscar_preguntas_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn);
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/tablero_preguntas_evaluacion',$data);
    }

    public function agregar_modificar_pregunta_evaluacion($id_evaluacion_publicacion_ctn,$id_pregunta_publicacion_ctn = false){
        $data['catalogo_tipo_opciones_pregunta'] = $this->CatalogosModel->obtenerCatalogoOpcionesPregunta();
        $data['id_evaluacion_publicacion_ctn'] = $id_evaluacion_publicacion_ctn;
        if($id_pregunta_publicacion_ctn){
            $data['pregunta_publicacion_ctn'] = $this->Evaluacion_model->obtener_pregunta_evaluacion_publicacion_ctn($id_pregunta_publicacion_ctn);
            if($data['pregunta_publicacion_ctn']->id_opciones_pregunta == OPCION_RELACIONAL){
                $data['opciones_pregunta_publicacion_ctn_izquierda'] = $this->Evaluacion_model->obtener_opciones_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn,false,'izquierda');
                $data['opciones_pregunta_publicacion_ctn_derecha'] = $this->Evaluacion_model->obtener_opciones_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn,false,'derecha');
            }else{
                $data['opciones_pregunta_publicacion_ctn'] = $this->Evaluacion_model->obtener_opciones_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn);
            }
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/modal_form_pregunta',$data);
    }

    public function obtener_complemento_registro_opciones_pregunta($id_opciones_pregunta,$id_pregunta_publicacion_ctn = false){
        $data = array();
        switch ($id_opciones_pregunta){
            case OPCION_VERDADERO_FALSO:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/verdadero_falso',$data);
                break;
            case OPCION_UNICA_OPCION:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/unica_opcion',$data);
                break;
            case OPCION_OPCION_MULTIPLE:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/opcion_multiple',$data);
                break;
            case OPCION_IMAGEN_UNICA_OPCION:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/img_unica_opcion',$data);
                break;
            case OPCION_IMAGEN_OPCION_MULTIPLE:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/img_opcion_multiple',$data);
                break;
            case OPCION_SECUENCIAL:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/secuenciales',$data);
                break;
            case OPCION_RELACIONAL:
                $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/opciones/relacionales',$data);
                break;
        }
    }

    public function guardar_pregunta_opciones_evaluacion_ctn(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar las preguntas';
        $post = $this->input->post();
        if($this->Evaluacion_model->guardar_pregunta_opciones_evaluacion_ctn($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se guardo la pregunta con las opciones correctamente';
        }
        echo json_encode($result);
        exit;
    }

    public function eliminar_pregunta_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn){
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        if($this->Evaluacion_model->eliminar_pregunta_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn)){
            $result['exito'] = true;
            $result['msg'] = 'Se eliminó la pregunta del sistema correctamente';
        }
        echo json_encode($result);
        exit;
    }

    public function actualizar_evaluacion_publicacion_ctn(){
        $post = $this->input->post();
        $data['exito'] = false;
        $data['msg'] = ERROR_SOLICITUD;
        if($this->AutoguardadoModel->actualizar_campo_tabla($post)){
            $data['exito'] = true;
            switch ($post['campo_update']){
                case 'perciento_asistencia':
                    $data['msg'] = 'Se actualizó correctamente el porcentaje de asistencia del alumno';
                    break;
                case 'calificacion_diagnostica':
                    $data['msg'] = 'Se actualizó correctamente la calificación diagnóstica de asistenc del alumno';
                    break;
                case 'calificacion_final':
                    $data['msg'] = 'Se actualizó correctamente la calificación final del alumno';
                    break;
            }
        }
        echo json_encode($data);
        exit;
    }

    public function publicar_evaluacion($id_evaluacion_publicacion_ctn){
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        if($this->Evaluacion_model->publicar_evaluacion($id_evaluacion_publicacion_ctn)){
            $result['exito'] = true;
            $result['msg'] = 'Se publicó la evaluación para los alumnos con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function actualizar_comentario_observacion(){
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        $post = $this->input->post();
        if($this->AutoguardadoModel->actualizar_campo_tabla($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se publicó la evaluación para los alumnos con éxito';
        }
        echo json_encode($result);
        exit;
    }

    private function evaluacion($id_publicacion_ctn,$tipo){
        $data['seccion'] = 'Mis cursos';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['evaluacion_publicacion_ctn'] = $this->Evaluacion_model->obtener_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo);
        $data['tipo_evaluacion'] = $tipo;
        $this->load->view('cursos_civik/admin_ctn/cursos/evaluaciones/cuestionario_admin_instructor',$data);
    }

    public function resultados_evaluacion($id_publicacion_ctn,$id_alumno){
        $data['evaluaciones_alumno'] = $this->Evaluacion_model->obtener_evaluaciones_publicacion_alumno($id_publicacion_ctn,$id_alumno);
        $data['usuario'] = $this->usuario;
        $data['id_publicacion_ctn'] = $id_publicacion_ctn;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/resultados_examen',$data);
    }

    public function examen_lectura($id_evaluacion_alumno_publicacion_ctn){
        $data = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/examen_lectura',$data);
    }

}