<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('UsuarioModel');
		if(sesionActive()){
			//$this->usuario = usuarioSession();
			$this->usuario = usuarioSession();
			if(!isset($this->usuario->foto_perfil) || $this->usuario->foto_perfil == ''){
				$this->load->model('PerfilModel');
				$foto_perfil = $this->PerfilModel->foto_perfil();
				$this->usuario->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
			}
		}else{
			$this->usuario = null;
			redirect(base_url().'login');
		}
	}

	public function index()
	{
		$data['titulo_pagina'] = 'BIENVENIDO al Sistema Integral PED';
		$data['usuario'] = $this->usuario;
		switch ($this->usuario->perfil){
			case 'alumno':
				$data['cat_msg_bienvenida'] = $this->CatalogoModel->cat_msg_bienvenida();
				$data['extra_js'] = array(
					base_url().'assets/js/validacion_datos.js'
				);
				break;
			case 'instructor':
				$data['extra_js'] = array(
					base_url().'assets/js/validacion_datos.js'
				);
				break;
		}
		$this->load->view('index',$data);
	}

	public function no_encontrado(){
		if(is_ajax()){
			$this->output->set_status_header(404);
		}else{
			$data['titulo_pagina'] = '404 página no encontrada';
			$data['usuario'] = $this->usuario;
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => '404 página no encontrada','activo' => true,'url' => '#'),
			);
			$this->load->view('404',$data);
		}
	}

	public function sin_permisos(){
		if(is_ajax()){
			$this->output->set_status_header(403);
		}else{
			$data['titulo_pagina'] = '403 Sin permisos';
			$data['usuario'] = $this->usuario;
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => '403 sin permisos','activo' => true,'url' => '#'),
			);
			$this->load->view('403',$data);
		}
	}

	public function need_login(){
		if(is_ajax()){
			$this->output->set_status_header(401);
		}else{
			$data['titulo_pagina'] = '403 Sin permisos';
			$data['usuario'] = $this->usuario;
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => '403 sin permisos','activo' => true,'url' => '#'),
			);
			$this->load->view('403',$data);
		}
	}

	public function actualizar_comun(){
		try{
			$this->load->model('ComunModel');
			$resultado['success'] = false;
			$resultado['msg'] = array('Ocurrio un error al actualizar, favor de intentar más tarde');
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::actualizarComun($post);
			if($validaciones['success']){
				$actualizar = $this->ComunModel->actualizar_comun($post);
				if($actualizar['success']){
					$resultado['success'] = true;
				}
				$resultado['msg'] = array($actualizar['msg']);
			}else{
				$resultado['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = array('Ocurrio un error al actualizar, favor de intentar más tarde');
		}
		echo json_encode($resultado);exit;
	}

	public function eliminar_comun(){
		try{
			$this->load->model('ComunModel');
			$resultado['success'] = false;
			$resultado['msg'] = array('Ocurrio un error al eliminar el registro, favor de intentar más tarde');
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::eliminarComun($post);
			if($validaciones['success']){
				$actualizar = $this->ComunModel->eliminar_comun($post);
				if($actualizar['success']){
					$resultado['success'] = true;
				}
				$resultado['msg'] = array($actualizar['msg']);
			}else{
				$resultado['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = array('Ocurrio un error al actualizar, favor de intentar más tarde');
		}
		echo json_encode($resultado);exit;
	}

}
