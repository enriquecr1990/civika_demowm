<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConfiguracionSistema extends CI_Controller {

    private $usuario;
    private $mensaje;
    private $type_msg;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('NotificacionesModel','NotificacionesModel');
        $this->load->model('ConfiguracionSistemaModel','configuracion_sistema_model');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    /**
     * apartado de funciones para la configuracion del correo
     */
    public function salida_correo(){
        $data['seccion'] = 'Configuración sistema';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/js/config_sistema/salida_correo.js',
        );
        //var_dump($data);exit;
        $this->load->view('cursos_civik/configuracion_sistema/salida_correo/tablero',$data);
    }

    public function salida_correo_resultados(){
        $data['array_salida_correo'] = $this->configuracion_sistema_model->obtener_listado_config_correo();
        $this->load->view('cursos_civik/configuracion_sistema/salida_correo/resultados_busqueda',$data);
    }

    public function agregar_modificar_config_correo($id_config_correo = false){
        $data = array();
        if($id_config_correo){
            $data['config_correo'] = $this->configuracion_sistema_model->obtener_config_correo($id_config_correo);
        }
        $this->load->view('cursos_civik/configuracion_sistema/salida_correo/form_registro',$data);
    }

    public function guardar_config_correo(){
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = ERROR_SOLICITUD;
        if($this->configuracion_sistema_model->guardar_configuracion_correo($post)){
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo la configuración de correo correctamente';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function set_default_config_correo($id_config_correo){
        $respuesta['exito'] = false;
        $respuesta['msg'] = ERROR_SOLICITUD;
        if($this->configuracion_sistema_model->set_default_config_correo($id_config_correo)){
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo la configuración de correo correctamente';
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * apartado de funciones para el listado de la bitacora de errores
     * por el momento solo se implemento para el envio de correos
     */
    public function bitacora_errores(){
        $data['seccion'] = 'Configuración sistema';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/plugins/json_viewer/json_viewer.js',
            base_url().'extras/js/config_sistema/bitacora_error.js',
        );
        $data['extra_css'] = array(
            base_url().'extras/plugins/json_viewer/json_viewer.css',
        );
        //var_dump($data);exit;
        $this->load->view('cursos_civik/configuracion_sistema/bitacora_error/tablero_bitacora_error',$data);
    }

    public function bitacora_errores_resultados(){
        $post = $this->input->post();
        $data['array_bitacora_error'] = $this->configuracion_sistema_model->listado_errores($post);
        $this->load->view('cursos_civik/configuracion_sistema/bitacora_error/resultados_busqueda_bitacora_error',$data);
    }

    public function cargar_modal_bitacora_error($id_bitacora_error){
        $data['bitacora_error'] = $this->configuracion_sistema_model->obtener_bitacora_error($id_bitacora_error);
        $this->load->view('cursos_civik/configuracion_sistema/bitacora_error/modal_bitacora_error',$data);
    }

}