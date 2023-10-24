<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model('CatalogoModel');
		$this->load->model('UsuarioModel');
		$this->load->model('PerfilModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
	}

	public function index($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.admin');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,false,$pagina,$limit);
			$data['titulo_pagina'] = 'Usuarios del sistema';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Usuarios','activo' => true,'url' => base_url().'usuario'),
			);
			$data['usuario'] = $this->usuario;
			$data['sidebar'] = 'usuarios';
			$data['extra_js'][] = base_url().'assets/js/admin/usuario.js';
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('usuarios/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero_root($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.admin');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,false,$pagina,$limit);
			$data['sidebar'] = 'usuarios';
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('usuarios/resultado_tablero',$data);
		}catch(Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function administradores($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.admin');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'admin',$pagina,$limit);
			$data['titulo_pagina'] = 'Administradores';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Usuarios','activo' => false,'url' => $this->usuario->perfil=='root' ? base_url().'usuario' : '#'),
				array('nombre' => 'Administradores','activo' => true,'url' => '#'),
			);
			$data['usuario'] = $this->usuario;
			$data['sidebar'] = 'administradores';
			$data['extra_js'][] = base_url().'assets/js/admin/usuario.js';
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data);exit;
			$this->load->view('usuarios/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero_administradores($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.admin');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'admin',$pagina,$limit);
			$data['sidebar'] = 'administradores';
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('usuarios/resultado_tablero',$data);
		}catch(Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function evaluadores($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.instructor');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'instructor',$pagina,$limit);
			$data['titulo_pagina'] = 'Evaluadores';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Usuarios','activo' => false,'url' => $this->usuario->perfil=='root' ? base_url().'usuario' : '#'),
				array('nombre' => 'Evaluadores','activo' => true,'url' => '#'),
			);
			$data['usuario'] = $this->usuario;
			$data['sidebar'] = 'instructores';
			$data['extra_js'][] = base_url().'assets/js/admin/usuario.js';
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('usuarios/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
	}

	public function tablero_evaluadores($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.instructor');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'instructor',$pagina,$limit);
			$data['sidebar'] = 'instructores';
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('usuarios/resultado_tablero',$data);
		}catch(Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function candidatos($pagina = 1, $limit = 10){
		perfil_permiso_operacion('usuarios.alumno');
		try{
			$post = $this->input->post();
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'alumno',$pagina,$limit);
			$data['titulo_pagina'] = 'Candidatos';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Usuarios','activo' => false,'url' => $this->usuario->perfil=='root' ? base_url().'usuario' : '#'),
				array('nombre' => 'Candidatos','activo' => true,'url' => '#'),
			);
			$data['usuario'] = $this->usuario;
			$data['sidebar'] = 'candidatos';
			$data['extra_js'][] = base_url().'assets/js/admin/usuario.js';
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data);exit;
			$this->load->view('usuarios/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
	}

	public function tablero_candidatos($pagina = 1, $limit = 10){
		try{
			$post = $this->input->post();
			//var_dump($post);
			$data = $this->UsuarioModel->obtener_usuarios_tablero($post,'alumno',$pagina,$limit);
			$data['sidebar'] = 'candidatos';
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data);exit;
			$this->load->view('usuarios/resultado_tablero',$data);
		}catch(Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar_usuario($tipo = 'admin',$id_usuario = false){
		$data['tipo_usuario'] = $tipo == 'instructor' ? 'evaluador' : $tipo;
		$data['cat_sector_ec'] = $this->CatalogoModel->get_catalogo('cat_sector_ec');
		//dd($data);exit;
		if($id_usuario){
			$data['usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
			$data['usuario']->id_usuario = $id_usuario;
		}
		$this->load->view('usuarios/agregar_modifiar_usr',$data);
	}

	public function guardar_form_usuario($tipo = 'admin',$id_usuario = false){
		try{
			$post = $this->input->post();
			switch ($tipo){
				case 'admin':
					$validacion_campos = Validaciones_Helper::formUsuarioAdmin($post,$id_usuario);
					if($validacion_campos['success']){
						$guardar_admin = $this->UsuarioModel->guardar_usuario_admin($post,$id_usuario);
						if($guardar_admin['success']){
							$response['success'] = true;
							$response['msg'][] = $guardar_admin['msg'];
						}else{
							$response['success'] = false;
							$response['msg'][] = $guardar_admin['msg'];
						}
					}else {
						$response['success'] = false;
						$response['msg'][] = $validacion_campos['msg'];
					}
					break;
				case 'instructor':
					$validacion_campos = Validaciones_Helper::formUsuarioInstructor($post,$id_usuario);
					if($validacion_campos['success']){
						$guardar_instructor = $this->UsuarioModel->guardar_usuario_instructor($post,$id_usuario);
						if($guardar_instructor['success']){
							$response['success'] = true;
							$response['msg'][] = $guardar_instructor['msg'];
						}else{
							$response['success'] = false;
							$response['msg'][] = $guardar_instructor['msg'];
						}
					}else {
						$response['success'] = false;
						$response['msg'][] = $validacion_campos['msg'];
					}
					break;
				case 'candidato':
					$validacion_campos = Validaciones_Helper::formUsuarioCandidato($post,$id_usuario);
					//var_dump($post);exit;
					if($validacion_campos['success']){
						$guardar_candidato = $this->UsuarioModel->guardar_usuario_candidato($post,$id_usuario);
						if($guardar_candidato['success']){
							$response['success'] = true;
							$response['msg'][] = $guardar_candidato['msg'];
						}else{
							$response['success'] = false;
							$response['msg'][] = $guardar_candidato['msg'];
						}
					}else {
						$response['success'] = false;
						$response['msg'][] = $validacion_campos['msg'];
					}
					break;
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function activar_usuario($id_usario){
		try{
			$activar = $this->UsuarioModel->activar_usuario($id_usario);
			if($activar['success']){
				$response['success'] = true;
				$response['msg'][] = $activar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $activar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function desactivar_usuario($id_usario){
		try{
			$desactivar = $this->UsuarioModel->desactivar_usuario($id_usario);
			if($desactivar['success']){
				$response['success'] = true;
				$response['msg'][] = $desactivar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $desactivar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function eliminar_usuario($id_usario){
		try{
			$eliminar = $this->UsuarioModel->eliminar_usuario($id_usario);
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

	public function deseliminar_usuario($id_usario){
		try{
			$eliminar = $this->UsuarioModel->deseliminar_usuario($id_usario);
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

	public function actualizar_contrasena_usuario($id_usuario){
		$data['id_usuario'] = $id_usuario;
		$this->load->view('usuarios/update_pass',$data);
	}

	public function guardar_nueva_contrasena_usuario($id_usuario){
		try{
			$post = $this->input->post();
			if(!isset($post['password']) || Validaciones_Helper::isCampoVacio($post['password'])){
				$response['success'] = false;
				$response['msg'][] = 'El campo contraseña es requerido';
			}else{
				$actualizar_pass = $this->UsuarioModel->actualizar_password_usuario($id_usuario,$post['password']);
				if($actualizar_pass['success']){
					$response['success'] = true;
				}else{
					$response['success'] = true;
				}$response['msg'][] = $actualizar_pass['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

}
