<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('ConfigCorreoModel');

	}

	public function salida_correo(){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Configuración de salida de correo';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Configuración','activo' => false,'url' => '#'),
				array('nombre' => 'Salida Correo','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'salida_correo';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/js/configuracion/salida_correo.js',
			);
			$data['config_correo'] = $this->CatalogoModel->cat_msg_bienvenida();
			//var_dump($data);exit;
			$this->load->view('configuracion/correo/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function buscar_config_correo(){
		try{
			$resultados = $this->ConfigCorreoModel->tablero(array());
			$data['config_correo'] = $resultados['config_correo'];
			$this->load->view('configuracion/correo/resultado_tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar_salida_correo($id_config_correo = false){
		perfil_permiso_operacion('todos.todos');
		$data = array();
		if($id_config_correo){
			$data['config_correo'] = $this->ConfigCorreoModel->obtener_row($id_config_correo);
		}
		$this->load->view('configuracion/correo/agregar_modificar',$data);
	}

	public function guardar_salida_correo($id_config_correo = false){
		perfil_permiso_operacion('todos.todos');
		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formConfigCorreo($post);
			if(!$id_config_correo){
				$post['activo'] = 'no';
			}
			if($validaciones['success']){
				$guardar = $this->ConfigCorreoModel->guardar_row($post,$id_config_correo);
				if($guardar['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar['msg'];
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function activar_config_correo($id_config_correo){
		try{
			$response['success'] = false;
			$response['msg'] = array('No fue posible activar la configuración del correo');
			if($this->ConfigCorreoModel->activar_config_correo($id_config_correo)){
				$response['success'] = true;
				$response['msg'] = array('Se activo está configuración de correo para la salida de correos');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

}
