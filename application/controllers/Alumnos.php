<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('AlumnosModel');
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
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/tablero_publicaciones',$data);
    }

    public function mis_evaluaciones_online(){
        $get = $this->input->get();
        $data['seccion'] = 'Mis evaluaciones';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['evaluacion_online'] = true;
        $data['id_publicacion_ctn'] = isset($get['id_publicacion_ctn']) && existe_valor($get['id_publicacion_ctn']) ? $get['id_publicacion_ctn'] : false;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/tablero_publicaciones',$data);
    }

    public function buscar_mis_publicaciones_ctn($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $post['id_usuario'] = $this->usuario->id_usuario;
        $evaluacion_online = false;
        if(isset($post['evaluacion_online']) && existe_valor($post['evaluacion_online']) && $post['evaluacion_online'] == 1){
            $evaluacion_online = true;
            $post['id_catalogo_tipo_publicacion'] = CURSO_EVALUACION_ONLINE;
        }
        $data = $this->CursosModel->obtener_publicacion_ctn_alumno($post,$pagina,$limit);
        $data['usuario'] = $this->usuario;
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        foreach ($data['array_publicacion_ctn'] as $pctn){
            $pctn->prueba_diagnostica = $this->obtener_datos_evaluacion($pctn->id_publicacion_ctn,$pctn->id_alumno,'diagnostica');
            $pctn->prueba_final = $this->obtener_datos_evaluacion($pctn->id_publicacion_ctn,$pctn->id_alumno,'final');
        }
        if($evaluacion_online){
            $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/resultados_publicaciones_eva_online',$data);
        }else{
            $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/resultados_publicaciones',$data);
        }
    }

    public function evaluacion_diagnostica($id_publicacion_ctn){
        $this->examen($id_publicacion_ctn,'diagnostica');
    }

    public function evaluacion_final($id_publicacion_ctn){
        $this->examen($id_publicacion_ctn,'final');
    }

    public function guardar_examen_alumno(){
        $post = $this->input->post();
        $resultado['exito'] = false;
        $resultado['msg'] = ERROR_SOLICITUD;
        if($this->Evaluacion_model->guardar_examen_alumno($post)){
            $calificacion = $this->Evaluacion_model->calcular_calificacion_evalucion($post['id_evaluacion_alumno_publicacion_ctn'],$post['tipo_evaluacion']);
            $resultado['exito'] = true;
            $resultado['msg'] = 'Se realizó correctamente la evaluación';
            $resultado['msg'] .= '<br>sacaste una calificación de: <span class="negrita">'.$calificacion.'</span>';
            $evaluacion_publicacion_ctn = $this->Evaluacion_model->obtener_evaluacion_publicacion_ctn_by_id($post['id_evaluacion_publicacion_ctn']);
            $publicacion_ctn = $this->CursosModel->obtenerPublicacionCTN($evaluacion_publicacion_ctn->id_publicacion_ctn);
            $resultado['redirec'] = '/mis_cursos';
            if($publicacion_ctn->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE){
                $resultado['redirec'] = '/mis_evaluaciones_online';
            }
        }
        echo json_encode($resultado);exit;
    }

    public function ver_calificacion_evaluacion($id_evaluacion_alumno_publicacion_ctn){
        $calificacion = $this->Evaluacion_model->calcular_calificacion_evalucion($id_evaluacion_alumno_publicacion_ctn,'final');
        var_dump($calificacion);exit;
    }

    public function obtener_archivos_vademecum($id_publicacion_ctn,$id_alumno_inscrito_ctn_publicado){
        $data['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
        $data['archivos_vademecum'] = $this->CursosModel->obtenerMaterialDidactico($id_publicacion_ctn);
        //var_dump($data['archivos_vademecum']);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/publicacion_archivos_vademecum',$data);
    }

    public function aceptar_descarga_vademecum($id_alumno_inscrito_ctn_publicado){
        $respuesta['exito'] = false;
        $respuesta['msg'] = ERROR_SOLICITUD;
        if($this->Evaluacion_model->aceptar_descarga_vademecum($id_alumno_inscrito_ctn_publicado)){
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se acepto la descarga de los archivos del Vademecum, podra realizar la evaluación';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function obtener_modal_subir_material($id_alumno_inscrito_ctn_publicado){
        $post = $this->input->post();
        $data['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
        $data['array_alumnos_publicacion_ctn_has_evidencia'] = $this->AlumnosModel->obtener_publicacion_material_evidencia($id_alumno_inscrito_ctn_publicado);
        $data['lectura'] = isset($post['lectura']) && $post['lectura'] == 2 ? true : false;
        $data['usuario'] = $this->usuario;
        //var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/publicacion_archivos_material',$data);
    }

    public function guardar_publicacion_material_evidencia(){
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = ERROR_SOLICITUD;
        if($this->AlumnosModel->guardar_publicacion_material_evidencia($post)){
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardó la evidencia del material con exito';
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * apartado de funciones privadas
     */
    private function examen($id_publicacion_ctn,$tipo){
        $data['seccion'] = 'Mis cursos';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data = $this->Evaluacion_model->obtener_datos_examen_alumno($id_publicacion_ctn,$this->usuario->id_usuario,$tipo);
        $data['seccion'] = 'Mis cursos';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/plugins/jquery_countdown/jquery.countdown.min.js',
            base_url().'extras/js/alumno/examen_alumno.js',
        );
        $data['extra_css'] = array(
            //base_url().'extras/plugins/jquery_ui/css/jquery-ui.css',
        );
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/examen',$data);
    }

    private function obtener_datos_evaluacion($id_publicacion_ctn,$id_alumno,$tipo){
        $retorno = false;
        if($this->Evaluacion_model->existe_evaluacion_publicacion_ctn_disponible($id_publicacion_ctn,$tipo)){
            $evaluacion_publicacion_ctn = $this->Evaluacion_model->obtener_datos_examen_publicacion_alumno($id_publicacion_ctn,$id_alumno,$tipo);
            $retorno = new stdClass();
            $retorno->evaluacion_disponible = true;
            $retorno->publicacion_aprobada = $this->Evaluacion_model->isPasoEvaluacion();
            $retorno->calificacion_aprobada = $this->Evaluacion_model->getEvaluacionAprobatoria();
            $retorno->puede_realizar_evaluacion = $this->Evaluacion_model->isPuedeRealizarEvaluacion();
            $retorno->etiqueta_evaluacion = $this->Evaluacion_model->getEtiquetaEvaluacion();
            $retorno->titulo_evaluacion = $evaluacion_publicacion_ctn->titulo_evaluacion;
            $retorno->alumno_inscrito_ctn_publicado = $this->InscripcionModel->obtenerAlumnoInscritoCTNPublicacion($id_publicacion_ctn, $id_alumno);
            $retorno->evaluaciones_alumno_id = $this->Evaluacion_model->getIdsEvaluacionAlumno();
        }
        return $retorno;
    }

}