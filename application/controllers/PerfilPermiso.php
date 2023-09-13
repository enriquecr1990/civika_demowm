<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PerfilPermiso extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('PerfilPermisoModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

	public function index(){
		try{
			perfil_permiso_operacion('todos.todos');
			$data['titulo_pagina'] = 'Perfiles, múdulos y permisos del sistema';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Usuarios','activo' => false,'url' => base_url().'usuario'),
				array('nombre' => 'Perfiles y permisos','activo' => true,'url' => '#'),
			);
			$data['usuario'] = $this->usuario;
			$data['sidebar'] = 'perfil_permisos';
			$data['cat_perfil'] = $this->CatalogoModel->cat_perfil();//catalogo especial
			$data['cat_modulo'] = $this->CatalogoModel->cat_modulo();
			$data['cat_permiso'] = $this->CatalogoModel->cat_permiso();
			$data['extra_js'][] = base_url().'assets/js/admin/perfil_permiso.js';
			$this->load->view('perfil_permisos/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function modulo_permiso($id_cat_perfil){
    	try{
			perfil_permiso_operacion('todos.todos');
			$modulo_permiso = $this->PerfilPermisoModel->modulo_permisos($id_cat_perfil);
			$response['success'] = true;
			$response['msg'] = array();
			$response['modulo_permiso'] = $modulo_permiso;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function agregar_modulo_permiso(){
    	try{
			perfil_permiso_operacion('todos.todos');
    		$post = $this->input->post();
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$validacion_campos = Validaciones_Helper::agregarModuloPermiso($post);
			if($validacion_campos['success']){
				$agregar = $this->PerfilPermisoModel->agregar_modulo_permiso($post);
				if($agregar){
					$response['success'] = true;
					$response['msg'] = array('Se agregó el permiso correctamente del sistema');
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function quitar_modulo_permiso(){
    	try{
			perfil_permiso_operacion('todos.todos');
    		$post = $this->input->post();
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$validacion_campos = Validaciones_Helper::agregarModuloPermiso($post);
			if($validacion_campos['success']){
				$agregar = $this->PerfilPermisoModel->quitar_modulo_permiso($post);
				if($agregar){
					$response['success'] = true;
					$response['msg'] = array('Se quitó el permiso correctamente del sistema');
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}
}
