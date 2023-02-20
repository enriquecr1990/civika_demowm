<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControlUsuarios extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('CatalogosModel');
        $this->load->model('ControlUsuariosModel');
        $this->load->model('NotificacionesModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('administrarCTN/InscripcionModel','InscripcionModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    public function index(){
        $data['seccion'] = 'Usuarios';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url('extras/js/usuario/control_usuarios.js'),
            base_url('extras/js/usuario/perfil.js'),
            base_url().'extras/plugins/datepicker/locales/bootstrap-datepicker.es.min.js',
        );
        $data['tipo_usuario'] = $this->CatalogosModel->obtenerUsuarioSistema();
        $this->load->view('cursos_civik/control_usuarios/Usuario',$data);
    }

    public function buscarUsuarios($pagina = 1,$limit = 10){
        $post = $this->input->post();
        $data = $this->ControlUsuariosModel->obtenerUsuariosSistema($post,$pagina,$limit);
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        $this->load->view('cursos_civik/control_usuarios/ResultadosBusquedaUsuarios',$data);
    }

    public function agregarModificarUsuario($idUsuario=false){
        $data['catalogo_usuario'] = $this->CatalogosModel->obtenerUsuarioSistema();
        $data['catalogo_titulo_academico'] = $this->CatalogosModel->obtenerCatalogoTituloAcademico();
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $data['usuario_login'] = $this->usuario;
        $post = $this->input->post();
        $data_usuario = array();
        $data['tipo_usuario'] = '';
        if($idUsuario){
            $data['tipo_usuario'] = isset($post['tipo_usuario']) ? $post['tipo_usuario'] : 'alumno';
            $data_usuario = $this->ControlUsuariosModel->obtenerUsuarioDetalle($idUsuario,$data['tipo_usuario']);
            $data['es_configuracion'] = isset($post['es_configuracion']) ? true : false;
        }
        $data = array_merge($data,$data_usuario,$post);
        //echo '<pre>'.print_r($data);exit;
        $this->load->view('cursos_civik/control_usuarios/RegistrarModificarUsuario',$data);
    }

    public function agregar_modificar_experiencia_curricular($id_usuario){
        $data = $this->ControlUsuariosModel->obtenerUsuarioDetalle($id_usuario,'instructor');
        $data['catalogo_titulo_academico'] = $this->CatalogosModel->obtenerCatalogoTituloAcademico();
        $data['catalogo_tipo_cdc'] = $this->CatalogosModel->obtener_catalogo_tipo_cdc();
        $data['array_instructor_preparacion_academica'] = $this->ControlUsuariosModel->obtener_array_instructor_preparacion_academica($data['usuario_instructor']->id_instructor);
        $data['array_instructor_certificacion_diplomado_curso'] = $this->ControlUsuariosModel->obtener_array_instructor_certificacion_diplomado_curso($data['usuario_instructor']->id_instructor);
        $data['array_instructor_experiencia_laboral'] = $this->ControlUsuariosModel->obtener_array_instructor_experiencia_laboral($data['usuario_instructor']->id_instructor);
        $this->load->view('cursos_civik/control_usuarios/instructor/registro_experiencia_curricular',$data);
    }

    public function guardarUsuario(){
        $form_post = $this->input->post();
        $retorno = $this->ControlUsuariosModel->guardarUsuario($form_post);
        if(isset($form_post['es_configuracion']) && $form_post['es_configuracion'] == 1){
            if($retorno['exito']){
                $usuario = $this->usuario;
                $usuario->nombre = $form_post['usuario']['nombre'];
                $usuario->apellido_p = $form_post['usuario']['apellido_p'];
                $usuario->apellido_m = $form_post['usuario']['apellido_m'];
                $usuario->correo = $form_post['usuario']['correo'];
                $usuario->telefono = $form_post['usuario']['telefono'];
                $usuario->update_password = $form_post['usuario']['update_password'];
                $sesion['existe'] = true;
                $sesion['msg'] = '';
                $sesion['usuario'] = $usuario;
                $this->session->set_userdata($sesion);
                $this->usuario = $usuario;
                $retorno['recargar'] = true;
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function guardar_usuario_instructor_datos_to_cv(){
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        if($this->ControlUsuariosModel->guardar_usuario_instructor_datos_to_cv($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó la información del instructor con los datos para la C.V.';
        }
        echo json_encode($result);
        exit;
    }

    public function activarDesactivarUsuario($idUsuarioAdmin){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible cambiar el estatus del usuario administrador, favor de intentar más tarde';
        if($this->ControlUsuariosModel->activarDesactivarUsuario($idUsuarioAdmin)){
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó el estatus del usuario administrador con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function eliminarUsuarioAdmin($idUsuarioAdmin){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible eliminar el usuario administrador, favor de intentar mas tarde';
        if($this->ControlUsuariosModel->eliminarUsuarioAdmin($idUsuarioAdmin)){
            $result['exito'] = true;
            $result['msg'] = 'Se elimino el usuario administrador con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function perfil(){
        $data['seccion'] = 'Usuario';
        $data_usuario = $this->ControlUsuariosModel->obtenerUsuarioDetalle($this->usuario->id_usuario,$this->usuario->tipo_usuario);
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/usuario/control_usuarios.js',
            base_url().'extras/js/usuario/perfil.js',
        );
        $data = array_merge($data,$data_usuario);
        $this->load->view('cursos_civik/control_usuarios/perfil/perfil_usuario',$data);
    }

    public function guardarUsuarioAlumnoDatosPersonales(){
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar sus datos generales, favor de intentar mas tarde';
        if($this->ControlUsuariosModel->guardarUsuarioAlumnoDatosPersonales($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó sus datos personales con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function guardarUsuarioAlumnoDatosEmpresa(){
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar sus datos de la empresa, favor de intentar mas tarde';
        if($this->ControlUsuariosModel->guardarUsuarioAlumnoDatosEmpresa($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó sus datos de la empresa con éxito';
        }
        echo json_encode($result);
        exit;
    }
    public function actualizar_suscripcion_correo($suscripcion){
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo actualizar la suscripción';
        if($this->ControlUsuariosModel->actualizar_recibir_correo($this->usuario->id_usuario,$suscripcion)){
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se actualizo la suscripcion';
        }
        echo json_encode($respuesta);
        exit; 
        
    } 


}