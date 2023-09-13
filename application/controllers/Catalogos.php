<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();

	}

	public function estados(){
		try{
			$cat_estado = $this->CatalogoModel->cat_estado();
			$response['success'] = true;
			$response['msg'] = array('');
			$response['data']['cat_estado'] = $cat_estado;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();

		}
		echo json_encode($response);exit;
	}

	public function municipio($id_cat_estado){
		try{
			$cat_municipio = $this->CatalogoModel->cat_municipio($id_cat_estado);
			$response['success'] = true;
			$response['msg'] = array('');
			$response['data']['cat_municipio'] = $cat_municipio;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();

		}
		echo json_encode($response);exit;
	}

	public function localidad($id_municipio){
		try{
			$cat_localidad =  $this->CatalogoModel->cat_localidad($id_municipio);
			$response['success'] = true;
			$response['msg'] = array('');
			$response['data']['cat_localidad'] = $cat_localidad;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();

		}
		echo json_encode($response);exit;
	}

	public function bienvenida(){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Catalogo - Mensaje de bienvenida';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Catalogos','activo' => false,'url' => '#'),
				array('nombre' => 'Mensaje de bienvenida','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'cat_bienvenida';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
				base_url().'assets/js/catalogos/bienvenida.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2/css/select2.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
			);
			$data['cat_msg_bienvenida'] = $this->CatalogoModel->cat_msg_bienvenida();
			//var_dump($data);exit;
			$this->load->view('catalogo/bienvenida',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_msg_bienvenida($id){
		try{
			$this->load->model('CatMsgModel');
			$post = $this->input->post();
			$guardar = $this->CatMsgModel->guardar_row($post,$id);
			if($guardar['success']){
				$response['success'] = true;
				$response['msg'] = array('Se guardo el mensaje de bienvenida correctamente');
			}else{
				$response['success'] = false;
				$response['msg'] = array('No fue posible guardar el mensaje, favor de intentar más tarde');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

}
