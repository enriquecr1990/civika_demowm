<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

    public $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('ControlUsuariosModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('NotificacionesModel','NotificacionesModel');
        $this->load->model('ContadorVisitasModel','ContadorVisitasModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
        }
        //$this->ContadorVisitasModel->registro_contador_visitas();
    }

    public function index() {
        $get = $this->input->get();
        $data['seccion'] = 'Inicio';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $id_usuario = isset($this->usuario) && $this->usuario ? $this->usuario->id_usuario : false;
        $data['extra_js'] = array(
            base_url().'extras/js/index.js',
            base_url().'extras/js/adminCtn/inscripciones.js',
        );
        $data['visitas_sitio'] = $this->ContadorVisitasModel->obtener_visitas_sitio();
        $data['leyenda_stps'] = true;
        $data['cursos_proximos'] = $this->CursosModel->obtenerCursosPorPublicar();
        //se cambia el negocio para que muestre la oferta educativa y de la publicacion mostrar la carta descriptiva
        if(isset($get['id_publicacion_ctn']) && !is_null($get['id_publicacion_ctn']) && $get['id_publicacion_ctn'] != ''){
            //para cargar la oferta educativa para un unico curso
            $id_catalogo_tipo_publicacion = isset($get['tipo_pubicacion']) && existe_valor($get['tipo_pubicacion']) ? $get['tipo_pubicacion'] : CURSO_PRESENCIAL;
            $data['curso_disponible'] = $this->CursosModel->obtener_curso_publicacion($get['id_publicacion_ctn'],$id_usuario,$id_catalogo_tipo_publicacion);
            $curso_inscrito = false;
            if(isset($data['curso_disponible']->alumno_inscripcion->id_catalogo_proceso_inscripcion) && $data['curso_disponible']->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO){
                $curso_inscrito = true;
            }
            //redirec de la evaluacion online
            if($id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE && !sesionActive()){
                redirect(base_url().'InscripcionesCTN/registroCursoTallerNorma/'.$get['id_publicacion_ctn']);
            }if($id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE && sesionActive()){
                if($curso_inscrito){
                    redirect(base_url().'Alumnos/mis_evaluaciones_online?id_publicacion_ctn='.$get['id_publicacion_ctn']);
                }else{
                    redirect(base_url().'InscripcionesCTN/registroCursoTallerNorma/'.$get['id_publicacion_ctn']);
                }
            }
            $this->load->view('cursos_civika_publicacion',$data);
        }else{
            //para cargar la oferta educativa predeterminada
            //$data['cursos_disponibles'] = $this->CursosModel->obtenerCursosPublicados($id_usuario,$id_catalogo_tipo_publicacion = CURSO_PRESENCIAL);
            $data['cursos_disponibles_eva_online'] = $this->CursosModel->obtenerCursosPublicados($id_usuario,$id_catalogo_tipo_publicacion = CURSO_EVALUACION_ONLINE);
            //echo '<pre>'.print_r($data);exit;
            $this->load->view('cursos_civika',$data);
        }
        //se regresa el negocio de como estaban las publicaciones
        /*$data['es_publicacion_unica'] = 'no';
        $data['id_publicacion_ctn'] = 0;
        if(isset($get['id_publicacion_ctn']) && !is_null($get['id_publicacion_ctn']) && $get['id_publicacion_ctn'] != ''){
            $data['es_publicacion_unica'] = 'si';
            $data['id_publicacion_ctn'] = $get['id_publicacion_ctn'];
        }
        $data['cursos_disponibles'] = $this->CursosModel->obtenerCursosPublicados($id_usuario);
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civika',$data);
        */
    }

    public function galeria(){
        $data['seccion'] = 'Publicaciones galeria';
        $data['usuario'] = $this->usuario;
    }

    public function iniciarSesionAsea(){
        $post = $this->input->post();
        $sesion = $this->ControlUsuariosModel->obtenerUsuarioSesion($post);
        if($sesion['existe']){
            $this->session->set_userdata($sesion);
            $this->usuario = $sesion['usuario'];
        }
        $this->index();
    }

    public function cerrarSesionAsea(){
        $this->session->sess_destroy();
        $this->usuario = false;
        $this->index();
    }

    /*public function iniciarRegistroES(){
        $this->load->view('asea/estacion_servicio/RegistroES');
    }*/

    public function menus(){
        $this->load->view('sistema/menus_bootstrap');
    }

    public function wizard(){
        $data['extra_js'] = array(
            base_url('extras/proyecto/wizard.js')
        );
        $this->load->view('wizard/principalWizard',$data);
    }

    public function generar_imagen_de_codigo($codigo){
        header ("Content-type: image/png");
        $string = $codigo;
        $font = 13;
        $width = (ImageFontWidth($font) * strlen($string)) + 18;
        $height = ImageFontHeight($font) + 10;

        $im = @imagecreate ($width,$height);
        $background_color = imagecolorallocate ($im, 28, 141, 183); //white background
        $text_color = imagecolorallocate ($im, 255,255,255);//black text
        imagestring ($im, $font, 9, 5, $string, $text_color);
        imagepng ($im);
    }

    public function ahorcado(){
        $data['extra_js'] = array(
            base_url('extras/proyecto/wizard.js')
        );
        $data['teclado'] = $this->obtener_teclado();
        $this->load->view('ahorcado/juego_ahorcado',$data);
    }

    private function obtener_teclado(){
        $teclado = array(
            array('1','2','3','4','5','6','7','8','9','0'),
            array('Q','W','E','R','T','Y','U','I','O','P'),
            array('A','S','D','F','G','H','J','K','L','Ñ'),
            array('Z','X','C','V','B','N','M')
        );
        return $teclado;
    }


}
