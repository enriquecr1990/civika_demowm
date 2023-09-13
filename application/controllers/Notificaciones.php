<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('NotificacionHasArchivoModel');
        $this->load->model('NotificacionModel');
		$this->load->model('UsuarioModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

    public function index(){
    	try{
			$data['titulo_pagina'] = 'Notificaciones';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Notificaciones','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'notificaciones';
			$data['usuario'] = $this->usuario;
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2/css/select2.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			$data['extra_js'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
				base_url().'assets/frm/adm_lte/plugins/select2/js/select2.full.min.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
				base_url().'assets/js/notificacion.js'
			);
			$this->load->view('notificacion/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultados(){
    	try{
    		//var_dump('aqui todo bien');exit;
    		$post = $this->input->post();
    		$buscar = array();
    		if(isset($post['tipo'])){
    			switch ($post['tipo']){
					case 'recibidas':
						$buscar['id_usuario_recibe'] = $this->usuario->id_usuario;
						$buscar['estado'] = 'enviada';
						break;
					case 'enviadas':
						$buscar['id_usuario_envia'] = $this->usuario->id_usuario;
						$buscar['estado'] = 'enviada';
						break;
					case 'borrador':
						$buscar['id_usuario_envia'] = $this->usuario->id_usuario;
						$buscar['estado'] = 'borrador';
						break;
					case 'eliminadas':
						$buscar['id_usuario_recibe'] = $this->usuario->id_usuario;
						$buscar['id_usuario_envia'] = $this->usuario->id_usuario;
						$buscar['estado'] = 'eliminada_usr';
						break;
				}
			}
    		$data = $this->NotificacionModel->tablero($buscar,0);
    		$data['num_leidas'] = 0;
    		$data['num_no_leidas'] = 0;
    		foreach ($data['notificacion'] as $n){
    			$archivos = $this->NotificacionHasArchivoModel->tablero(array('id_notificacion' => $n->id_notificacion),0);
    			$n->archivos =  $archivos['notificacion_has_archivos'];
    			$n->notificacion_leida ? $data['num_leidas']++ : $data['num_no_leidas']++;
			}
    		$data['tipo'] = $post['tipo'];
    		//echo '<pre>';print_r($data);exit;
    		$this->load->view('notificacion/resultados',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function formulario(){
		try {
			$data_usuarios = $this->UsuarioModel->obtener_usuarios_tablero(array(),false,0);
			$data['usuarios'] = $data_usuarios['usuarios'];
			$this->load->view('notificacion/formulario',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function lectura($id_notificacion){
    	try{
			$notif_busqueda = $this->NotificacionModel->tablero(array('id_notificacion' => $id_notificacion),0);
			$data['notificacion'] = $notif_busqueda['notificacion'][0];
    		$archivos = $this->NotificacionHasArchivoModel->tablero(array('id_notificacion' => $data['notificacion']->id_notificacion),0);
    		$data['archivos'] = $archivos['notificacion_has_archivos'];
    		//var_dump($data);exit;
			//se marca la lectura de la notificacion
			$this->load->model('UsuarioHasNotificacionModel');
			$buscar_notificacion_usuario = array(
				'id_usuario_recibe' => $this->usuario->id_usuario,
				'id_notificacion' => $id_notificacion
			);
			$uhn = $this->UsuarioHasNotificacionModel->tablero($buscar_notificacion_usuario,0);
			if($uhn['total_registros'] > 0){
				$this->UsuarioHasNotificacionModel->guardar_row(array('fecha_leida' => date('Y-m-d H:i:s')),$uhn['usuario_has_notificacion'][0]->id_usuario_has_notificacion);
			}
    		$this->load->view('notificacion/lectura',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_notificacion($id_notificacion = 0, $tipo = 'borrador',$post = false){
		try{
			$post = $post != false ? $post : $this->input->post();
			$validacion_campos = Validaciones_Helper::formNotificaciones($post);
			$post['id_notificacion'] = $id_notificacion == 0 ? false : $id_notificacion;
			$post['estado'] = $tipo;
			//var_dump($post);exit;
			if($validacion_campos['success']){
				$id_notificacion_save = $this->NotificacionModel->guardar_notificacion($post);
				if($id_notificacion_save){
					$response['success'] = true;
					$response['msg'][] = 'Se guardo la notificación con éxito';
					$response['data']['id_notificacion'] = $id_notificacion_save;
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar la notificación con éxito';
				}
			}else{
				$response['success'] = false;
				$response['msg'][] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function enviar_notificacion(){

	}

	public function eliminar_notificacion(){

	}

	public function notificaciones_no_leidas(){
		try{
			$buscar['id_usuario_recibe'] = $this->usuario->id_usuario;
			$buscar['estado'] = 'enviada';
			$buscar['bells'] = true;
			$data = $this->NotificacionModel->tablero($buscar,0);
			echo json_encode($data);exit;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function enviar_correo($id_notificacion){
    	try{
			$notif_busqueda = $this->NotificacionModel->tablero(array('id_notificacion' => $id_notificacion),0);
			$data['notificacion'] = $notif_busqueda['notificacion'][0];
			$archivos = $this->NotificacionHasArchivoModel->tablero(array('id_notificacion' => $data['notificacion']->id_notificacion),0);
			$data['archivos'] = $archivos['notificacion_has_archivos'];
			$destinatarios = $this->NotificacionModel->obtener_destinatarios_correo($id_notificacion);
			$html_msg = $this->load->view('notificacion/correo',$data,true);
			//echo $html_msg;exit;
			$txt_plano = strip_tags($data['notificacion']->mensaje);
			$this->NotificacionModel->enviar_correo($destinatarios,$data['notificacion']->asunto,$html_msg,$txt_plano);
			$response['success'] = true;
			$response['msg'][] = 'Se envió la notificación al correo registrado en el sistema del destinatario';
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

}
