<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('UsuarioModel');
		$this->load->model('NotificacionModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = null;
		}
	}

	public function index()
	{
		if(is_null($this->usuario)){
			$get = $this->input->get();
			//dd($get);exit;
			$data = array();
			if(isset($get['usr']) && $get['usr'] != ''){
				$data['usuario_login'] = $get['usr'];
			}if(isset($get['convocatoria']) && existe_valor($get['convocatoria'])){
				$data['id_convocatoria'] = $get['convocatoria'];
			}
			$this->load->view('login',$data);
		}else{
			redirect(base_url('/admin'));
		}
	}

	public function recuperar_password(){
		$this->load->view('recuperar_password');
	}

	public function mail_recovery_pass(){
		try{
			$post = $this->input->post();
			$validacion_campos = Validaciones_Helper::formRecuperarPass($post);
			if($validacion_campos['success']){
				$regenerar_pass = $this->UsuarioModel->regenerar_password($post);
				if($regenerar_pass['success']){
					$mensaje = 'Estimado usuario(a) "'.$regenerar_pass['usuario']->usuario.'", con base a su solicitud de nueva contraseña por situación de olvido, se le manda una constraseña nueva, ingrese al portal del';
					$mensaje .= ' <a href="'.base_url().'login">Sistema Integral PED</a> e ingrese la siguiente contraseña: <strong>'.$regenerar_pass['nuevo_pass'].'</strong>';
					$mensaje .= '<br> Favor de ingresar al sistema y cambie está contraseña generada vía sistema por una que recuerde';
					$post = array(
						'id_notificacion' => 0,
						'estado' => 'enviada',
						'destinatarios' => array($regenerar_pass['usuario']->id_usuario),
						'asunto' => 'Solicitud de cambio de contraseña',
						'mensaje' => $mensaje
					);
					//se almacena la notificacion y se envia el correo correspondiente
					$id_notificacion_save = $this->NotificacionModel->guardar_notificacion($post);
					$notif_busqueda = $this->NotificacionModel->tablero(array('id_notificacion' => $id_notificacion_save),0);
					$data['notificacion'] = $notif_busqueda['notificacion'][0];
					$destinatarios = $this->NotificacionModel->obtener_destinatarios_correo($id_notificacion_save);
					$html_msg = $this->load->view('notificacion/correo',$data,true);
					$txt_plano = strip_tags($data['notificacion']->mensaje);
					$this->NotificacionModel->enviar_correo($destinatarios,$data['notificacion']->asunto,$html_msg,$txt_plano);

					$response['success'] = true;
					$response['msg'][] = 'Se le asignó una contraseña nueva en el Sistema, revise de favor su correo electrónico donde encontrara el código de su nueva contraseña';
				}else{
					$response['success'] = false;
					$response['msg'][] = $regenerar_pass['msg'];
				}
			}else {
				$response['success'] = false;
				$response['msg'] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function iniciar_sesion(){
		$response['success'] = true;
		$response['msg'] = array();
		try{
			$post = $this->input->post();
			$id_convocatoria = false;
			if(isset($post['id_convocatoria']) && $post['id_convocatoria'] != ''){
				$id_convocatoria = $post['id_convocatoria'];
				unset($post['id_convocatoria']);
			}
			$validacion_campos = Validaciones_Helper::formLogin($post);
			if($validacion_campos['success']){
				$usuario_login['ped'] = $this->UsuarioModel->login_usuario($post);
				if($usuario_login['ped']['success']){
					//procederemos a registrar este usuario login que trato de iniciar sesion desde una convocatoria
					
					$this->session->set_userdata($usuario_login);
				}else{
					$response['success'] = false;
					$response['msg'][] = $usuario_login['ped']['msg'];
				}
			}else {
				$response['success'] = false;
				$response['msg'] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function cerrar_sesion(){
		try{
			$this->session->sess_destroy();
			$response['success'] = true;
			$response['msg'] = array();
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function darse_baja(){
		redirect(base_url());
	}

	public function registro($idEstandarCompetenciaConvocatoria){
		$data['id_estandar_competencia_convocatoria'] = $idEstandarCompetenciaConvocatoria;
		$this->load->view('registro_convocatoria',$data);
	}
}
