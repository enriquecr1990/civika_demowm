<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Donativos extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        if(sesionActive()){
            $this->load->model('NotificacionesModel');
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }
    }

    public function index(){
        $data['seccion'] = 'Donativo';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url('extras/js/donativos/vsachk.js'),
            base_url('extras/js/donativos/mp.js'),
            'https://sandbox-assets.secure.checkout.visa.com/checkout-widget/resources/js/integration/v1/sdk.js'
        );
        $this->load->view('donativos/donacion_civika',$data);
    }

}