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
	public function sectores(){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Catalogo Sectores';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Catalogos','activo' => false,'url' => '#'),
				array('nombre' => 'Sectores','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'cat_sectores';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/js/catalogos/sectores.js',
			);
			$data['extra_css'] = array();
			$this->load->model('CatSectorEc');
			$data['tabla'] = $this->CatSectorEc->obtener_sectores();
			$data['total_registros'] = $this->CatSectorEc->total_data();
			$data_paginacion = data_paginacion(1,15,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//dd($data);exit;
			$this->load->view('catalogo/sector',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_sector(){
		try {
			$this->load->model('CatSectorEc');
			$post = $this->input->post();

			$id= false;
			if (isset($post['id_cat_sector_ec'])){
				$id = $post['id_cat_sector_ec'];
			}
			$data = $this->CatSectorEc->guardar_row($post,$id);

			if($data['success']){
				$response['success'] = true;
				$response['msg'] = array('Se guardo el sector correctamente');
			}else{
				$response['success'] = false;
				$response['msg'] = array('No fue posible guardar el sector, favor de intentar más tarde');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function obtener_sectores($pagina = 1, $limit = 15){
		$this->load->model('CatSectorEc');
		$data['tabla'] = $this->CatSectorEc->obtener_sectores($pagina,$limit);
		$this->load->view('catalogo/tablas/tabla_sectores',$data);
	}

	public function obtener_sector($id){
		$this->load->model('CatSectorEc');
		$data['sector'] = $this->CatSectorEc->obtener_sector($id);
		$this->load->view('catalogo/formulario/form_sector',$data);
	}

	public function eliminar_sector($id){
		try{
			$this->load->model('CatSectorEc');
			$eliminar = $this->CatSectorEc->eliminar($id);
			if($eliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $eliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $eliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
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
