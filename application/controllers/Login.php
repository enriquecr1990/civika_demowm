<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public $usuario;
    public $mensaje;
    public $type_msg;

    function __construct(){
        parent:: __construct();
        $this->load->model('ControlUsuariosModel','ControlUsuariosModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->mensaje = $this->session->userdata('msg');
        }else{
            $this->usuario = false;
            $this->mensaje = $this->session->userdata('msg');
        }
    }

    public function index(){
        $get = $this->input->get();
        if(isset($get['id_publicacion_ctn']) && $get['id_publicacion_ctn']){
            $data['id_publicacion_ctn'] = $get['id_publicacion_ctn'];
        }
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/js/login.js'
        );
        $this->load->view('cursos_civik/login/iniciar_sesion',$data);
    }

    public function iniciarSesion(){
        $respuesta['exito'] = true;
        $respuesta['msg'] = '';
        $post = $this->input->post();
        $sesion = $this->ControlUsuariosModel->obtenerUsuarioSesion($post);
        if($sesion['existe']){
            if ($sesion['usuario']->activo == 'si') {
                $this->session->set_userdata($sesion);
                $this->usuario = $sesion['usuario'];
            } else{
                $respuesta['exito'] = false;
                $respuesta['msg'] = $sesion['msg'];
            }   
        }else{
            $this->session->set_userdata($sesion);
            $this->mensaje = $sesion['msg'];
            $respuesta['exito'] = false;
            $respuesta['msg'] = $sesion['msg'];
        }if(isset($post['id_publicacion_ctn']) && $post['id_publicacion_ctn'] != ''){
            $respuesta['id_publicacion_ctn'] = $post['id_publicacion_ctn'];
        }
        //redirect(base_url());
        echo json_encode($respuesta);
        exit;
    }

    public function cerrarSesion(){
        $this->session->sess_destroy();
        $this->usuario = false;
        $this->index();
        redirect(base_url());
    }

    public function reset_password(){
        $data['extra_js'] = array(
            base_url().'extras/js/login.js'
        );
        $this->load->view('cursos_civik/login/solicitud_reset_password',$data);
    }

    public function obtener_usuario_correo(){
        $post = $this->input->post();
        $data = $this->ControlUsuariosModel->obtenerUsuarioCorreo($post);
        echo json_encode($data);
        exit;
    }

    public function solicitud_reset_password(){
        $post = $this->input->post();
        $response['exito'] = false;
        $response['msg'] = ERROR_SOLICITUD;
        if($this->ControlUsuariosModel->solicitud_reset_password($post)){
            $response['exito'] = true;
            $response['msg'] = 'Se envio a su correo electronico una contraseña temporal para ingresar al sistema';
        }
        echo json_encode($response);
        exit;
    }

    public function reestablecer_password(){
        $get = $this->input->get();
        $existe_reestablecer = $this->ControlUsuariosModel->reestablecer_password($get);
        if($existe_reestablecer){
            $data['extra_js'] = array(
                base_url().'extras/js/login.js'
            );
            $data['id_usuario'] = $get['id_usr'];
            $this->load->view('cursos_civik/login/reset_password',$data);
        }else{
            $this->load->view('default/error_404');
        }
    }

    public function cambiar_password_usuario_by_reestablecimiento(){
        $post = $this->input->post();
        $response['exito'] = false;
        $response['msg'] = ERROR_SOLICITUD;
        $change_pass =$this->ControlUsuariosModel->cambiar_password_usuario_by_reestablecimiento($post);
        if($change_pass['exito']){
            $response['exito'] = true;
            $response['msg'] = 'Se actualizó su contraseña corectamente, intente iniciar sesión en el sistema';
        }else{
            $response['msg'] = $change_pass['msg'];
        }
        echo json_encode($response);exit;
    }

    public function cancelar_reset_password(){
        $get = $this->input->get();
        $response['exito'] = false;
        $response['msg'] = ERROR_SOLICITUD;
        $cancelacion = $this->ControlUsuariosModel->cancelar_reset_password($get);
        if($cancelacion){
            $response['exito'] = true;
            $response['msg'] = 'Se realizó la cancelación de reestablecimiento de contraseña correctamente';
        }
        redirect(base_url());
    }

    public function validar_session(){
        $respose = array(
            'status' => true,
            'msg' => array()
        );
        if(!sesionActive()){
            $respose['status'] = false;
            $respose['msg'] = array('Sessión cadudo');
        }
        echo json_encode($respose);
    }
}