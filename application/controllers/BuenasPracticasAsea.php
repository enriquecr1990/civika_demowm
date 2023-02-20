<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BuenasPracticasAsea extends CI_Controller {

    public $usuario;

    function __construct(){
        parent:: __construct();
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
        }else{
            $this->usuario = false;
            redirect(base_url('Asea'));
        }
    }

    /*
     * apartado de funciones para la administracion de buenas practicas asea
     */
    public function index(){
        enConstrucion();
    }
}