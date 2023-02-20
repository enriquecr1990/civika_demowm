<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {

    private $usuario;
    private $mensaje;
    private $type_msg;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('NotificacionesModel','NotificacionesModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    public function index(){
        $data['seccion'] = 'Notificaciones';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $this->session->set_userdata($data);
        $data['total_registros'] = $this->NotificacionesModel->obtenerNotificacionesUsuario($data['usuario']->id_usuario,0);
        $data['array_notificaciones'] = $this->NotificacionesModel->obtenerNotificacionesUsuario($data['usuario']->id_usuario,1);
        $data['paginas'] = intval(ceil($data['total_registros'] / 20));
        $this->NotificacionesModel->actualizar_notificaciones_leida($data['usuario']->id_usuario);
        $data['notificaciones'] = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        $this->load->view('cursos_civik/notificaciones/tablero',$data);
    }

    public function notificaciones_no_leidas($pagina = 1){
        $data['usuario'] = $this->usuario;
        $data['total_registros'] = $this->NotificacionesModel->obtenerNotificacionesUsuario($data['usuario']->id_usuario,0);
        $data['notificaciones'] = $this->NotificacionesModel->obtenerNotificacionesUsuario($data['usuario']->id_usuario,$pagina);
        $data['paginas'] = intval(ceil($data['total_registros'] / 20));
        $this->load->view('cursos_civik/notificaciones/');
    }

}