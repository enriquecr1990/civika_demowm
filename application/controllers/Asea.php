<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asea extends CI_Controller {

    public $usuario;
    public $mensaje;
    public $type_msg;

    function __construct(){
        parent:: __construct();
        $this->load->model('ControlUsuariosModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->mensaje = $this->session->userdata('msg');
        }else{
            $this->usuario = false;
            $this->mensaje = $this->session->userdata('msg');
        }
    }

    public function index() {
        $data['extra_js'] = array(
            base_url().'extras/datepicker/js/bootstrap-datepicker.js',
            base_url().'extras/fileinput/js/fileinput.js',
            base_url().'extras/fileupload/js/vendor/jquery.ui.widget.js',
            base_url().'extras/fileupload/js/jquery.iframe-transport.js',
            base_url().'extras/fileupload/js/jquery.fileupload.js',
            base_url().'extras/asea/es/es_registro.js',
            base_url().'extras/asea/control_usuario/control_usuarios.js'
        );
        $data['usuario'] = $this->usuario;
        if($this->mensaje != ''){
            $data['mensaje'] = $this->mensaje;
        }
        $ruta_index = $this->obtenerRutaIndex();
        $this->load->view($ruta_index,$data);
    }

    public function iniciarSesionAsea(){
        $post = $this->input->post();
        $sesion = $this->ControlUsuariosModel->obtenerUsuarioSesion($post);
        if($sesion['existe']){
            $this->session->set_userdata($sesion);
            $this->usuario = $sesion['usuario'];
        }else{
            $this->session->set_userdata($sesion);
            $this->mensaje = $sesion['msg'];
        }
        $this->type_msg = $sesion['type_msg'];
        redirect(base_url('Asea'));
    }

    public function cerrarSesionAsea(){
        $this->session->sess_destroy();
        $this->usuario = false;
        $this->index();
        redirect(base_url('Asea'));
    }

    public function iniciarRegistroES(){
        $data['nuevo'] = true;
        $this->load->view('asea/estacion_servicio/RegistroES',$data);
    }

    public function enCostruccion(){
        $data['usuario'] = $this->usuario;
        $this->load->view('sistema/en_construccion',$data);
    }

    public function guardarEstacionServicio(){
        $this->load->model('EstacionServicioModel');
        $post = $this->input->post();
        $post['usuario']['verificado'] = 'no';
        $retorno = $this->EstacionServicioModel->guardarEstacionServicio($post);
        if($retorno['exito']){
            $retorno['msg'] = 'Se registró correctamente en el sistema, espere indicaciones del administrador para completar su registro';
        }
        echo json_encode($retorno);
    }

    public function uploadFileLogo(){
        $this->load->model('DocumentosAseaModel');
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = 'extras/imagenes/logos_es/';
                    $data = upload_file_asea($f,$options);
                    //var_dump($data);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumentoAsea = $this->DocumentosAseaModel->guardarDocumentoAsea($datos_doc);
                        $retorno['documento_asea'] = $this->DocumentosAseaModel->obtenerDocumentoAsea($idDocumentoAsea);
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    /**
     * apartado de funciones privadas para el controlador principal
     */
    private function obtenerRutaIndex(){
        $ruta_index = 'sistema/inicio';
        $usuario = $this->usuario;
        if($usuario){
            if(isset($usuario->es_administrador) && $usuario->es_administrador){
                if(isset($usuario->update_password) && $usuario->update_password == 0){
                    $ruta_index = 'asea/control_usuarios/ConfiguracionUsuario';
                }
            }
        }
        //var_dump($usuario,$ruta_index);exit;
        return $ruta_index;
    }

    public function teamo(){
        echo 'te amo mucho Corona';
    }

}
