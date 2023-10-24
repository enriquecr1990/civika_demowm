<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('ArchivoModel');
		$this->load->model('CatalogoModel');
		$this->load->model('DatosDomicilioModel');
		$this->load->model('DatosEmpresaModel');
		$this->load->model('UsuarioModel');
		$this->load->model('PerfilModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();

		}else{
			$this->usuario = null;
			redirect(base_url().'login');
		}
	}

	public function index()
	{
		$data = array();
		$data['extra_css'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
			base_url().'assets/frm/fileinput/css/fileinput.css',
			base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
		);
		$data['extra_js'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
			base_url().'assets/frm/fileinput/js/fileinput.js',
			base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
			base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
			base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
		);

		$data['titulo_pagina'] = 'Mi perfil';
		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Mi perfil','activo' => true,'url' => '#'),
		);
		$data['usuario'] = $this->usuario;
		$data['datos_usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($this->usuario->id_usuario);
		//dd($data);exit;
		$switch_perfil = $this->usuario->perfil;
		switch ($switch_perfil){
			case 'root':case 'admin':
				$data['extra_js'][] = base_url().'assets/js/perfil/admin.js';
				$this->load->view('perfil/admin',$data);
			break;
			case 'instructor':
				$data['extra_js'][] = base_url().'assets/js/perfil/instructor.js';
				$this->load->view('perfil/instructor',$data);
				break;
			case 'alumno':
				$data['extra_js'][] = base_url().'assets/js/perfil/candidato.js';
				$this->load->view('perfil/candidato',$data);
				break;
		}
	}

	//esta funcion es exclusiva para la edición del perfil de candidato/alumno por parte de los administradores
	public function editar($id_usuario){
		perfil_permiso_operacion('usuarios.alumno');
		$data = array();
		$data['titulo_pagina'] = 'Editar perfil';
		$data['sidebar'] = 'candidatos';
		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Usuarios','activo' => false,'url' => base_url().'usuario'),
			array('nombre' => 'Candidatos','activo' => false,'url' => base_url().'Usuario/candidatos'),
			array('nombre' => 'Editando perfil','activo' => true,'url' => '#'),
		);
		$data['extra_css'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
			base_url().'assets/frm/fileinput/css/fileinput.css',
			base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
		);
		$data['extra_js'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
			base_url().'assets/frm/fileinput/js/fileinput.js',
			base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
			base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
			base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
		);
		$usuario = $this->UsuarioModel->obtener_row($id_usuario);
		$data['usuario'] = $this->usuario;
		$data['usuario_modificar'] = $this->UsuarioModel->obtener_usuario_by_usr($usuario->usuario);
		$data['datos_usuario_modificar'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$data['usuario_modificar']->datos_usuario = $data['datos_usuario_modificar'];
		$switch_perfil = $data['usuario_modificar']->perfil;
		switch ($switch_perfil){
			case 'root':case 'admin':case 'instructor':
				redirect(base_url().'404');
				break;
			case 'alumno':
				$data['edicion_admin'] = true;
				$data['extra_js'][] = base_url().'assets/js/perfil/candidato.js';
				$this->load->view('perfil/candidato_edit_admin',$data);
				break;
		}
	}

	public function update_password($id_usuario){
		$response['succes'] = false;
		$response['msg'] = array('Ocurrio un error en el sistema, favor de intentar más tarde');
		try{
			$post = $this->input->post();
			$validacion_campos = Validaciones_Helper::formActualizarPassword($post);
			if($validacion_campos['success']){
				$actualizar = $this->UsuarioModel->actualizar_password_perfil($id_usuario,$post);
				if($actualizar['success']){
					$response['success'] = true;
					$response['msg'] = array($actualizar['msg']);
				}else{
					$response['success'] = false;
					$response['msg'] = array($actualizar['msg']);
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
		echo json_encode($response);
	}

	public function validacion_campos_perfil(){
		try{
			$id_usuario = $this->usuario->id_usuario;
			$response['usuario_update_datos'] = false;
			$data['datos_usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($this->usuario->id_usuario);
			if($data['datos_usuario']->update_datos == 0){
				$response['usuario_update_datos'] = true;
				$response['msg'][] = 'No ha actualizado sus datos personales del perfil';
			}else{
				if(!is_null($data['datos_usuario']->fecha_update)){
					$hoy = new DateTime(date('Y-m-d'));
					$fecha_update = new DateTime(date('Y-m-d',strtotime($data['datos_usuario']->fecha_update)));
					$dias_transcurridos = $hoy->diff($fecha_update);
					$response['data']['dias_transcurridos'] = $dias_transcurridos->days;
					if($dias_transcurridos->days > 183){
						$response['usuario_update_datos'] = true;
						$response['msg'][] = 'Detectamos en el sistema que han transcurrido 6 meses de cuando actualizo la ultima vez sus datos; si han habido algun cambio puede actualizarlos desde su perfil';
					}
				}
			}
			switch ($this->usuario->perfil){
				case 'alumno':
					//validar expediente del candidato
					$foto_certificado_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario,2);
					$foto_firma_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario,8);
					$curp_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario,7);
					$ine_anverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario,3);
					$ine_reverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario,4);
					if(!is_object($foto_certificado_candidato) || is_null($foto_certificado_candidato)){
						$response['usuario_update_datos'] = true;
						$response['msg'][] = 'No se encuentra en el sistema la foto del candidato';
					}if(!is_object($foto_firma_candidato) || is_null($foto_firma_candidato)){
					$response['usuario_update_datos'] = true;
					$response['msg'][] = 'No se encuentra en el sistema la firma del candidato';
				}if(!is_object($curp_candidato) || is_null($curp_candidato)){
					$response['usuario_update_datos'] = true;
					$response['msg'][] = 'No se encuentra en el sistema el CURP del candidato';
				}if(!is_object($ine_anverso_candidato) || !is_object($ine_reverso_candidato)){
					$response['usuario_update_datos'] = true;
					$response['msg'][] = 'No se encuentra en el sistema el INE del Candidato (falta el anverso o reverso o ambos)';
				}
					break;
				case 'instructor':
					$foto_firma_evaluador = $this->PerfilModel->obtener_datos_expediente($id_usuario,8);
					if(!is_object($foto_firma_evaluador) || is_null($foto_firma_evaluador)){
						$response['usuario_update_datos'] = true;
						$response['msg'][] = 'No se encuentra en el sistema la firma del evaluador';
					}
					break;
			}
			$response['success'] = true;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function agregar_modificar_usuario($tipo = 'admin',$id_usuario = false,$is_admin = 'no'){
		$data['tipo_usuario'] = $tipo != 'instructor' ? $tipo : 'evaluador';
		//$data['cat_sector_productivo'] = $this->CatalogoModel->cat_sector_productivo();
		$data['cat_sector_ec'] = $this->CatalogoModel->get_catalogo('cat_sector_ec');
		if($id_usuario){
			$data['usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
			$data['usuario']->id_usuario = $id_usuario;
			$data['modificacion_from_perfil'] = $is_admin;
			$data['id_usuario_sesion'] = $this->usuario->id_usuario;
		}
		//dd($data);exit;
		$this->load->view('usuarios/agregar_modifiar_usr',$data);
	}

	public function guardar_form_usuario($tipo = 'admin',$id_usuario = false){
		try{
			$post = $this->input->post();
			$post['fecha_update'] = date('Y-m-d');
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
					if($validacion_campos['success']){
						$guardar_candidato = $this->UsuarioModel->guardar_usuario_candidato($post,$id_usuario);
						if($guardar_candidato['success']){
							$response['success'] = true;
							$response['msg'][] = $guardar_candidato['msg'];
							$response['perfil_usuario_modificacion'] = $this->usuario->perfil;
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

	public function agregar_modificar_direccion($id_usuario,$id = false){
		try{
			$data['id_usuario'] = $id_usuario;
			$data['cat_estado'] = $this->CatalogoModel->cat_estado();
			if($id){
				$data['datos_domicilio'] = $this->DatosDomicilioModel->obtener_row($id);
				$data['cat_municipio'] = $this->CatalogoModel->cat_municipio($data['datos_domicilio']->id_cat_estado);
				$data['cat_localidad'] = $this->CatalogoModel->cat_localidad($data['datos_domicilio']->id_cat_municipio);
			}
			$this->load->view('usuarios/agregar_modifiar_domicilio',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

	public function agregar_modificar_empresa($id_usuario,$id = false){
		try{
			$data['id_usuario'] = $id_usuario;
			if($id){
				$data['datos_empresa'] = $this->DatosEmpresaModel->obtener_row($id);
				$data['archivo_logotipo'] = $this->ArchivoModel->obtener_row($data['datos_empresa']->id_archivo_logotipo);
			}
			$this->load->view('usuarios/agregar_modificar_empresa',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

	public function guardar_domicilio($id_usuario,$id = false){
		try{
			$post = $this->input->post();
			$validacion_campos = Validaciones_Helper::formDomicilio($post);
			if($validacion_campos['success']){
				$post['id_usuario'] = $id_usuario;
				isset($post['predeterminado']) && $post['predeterminado'] == 'si' ? $this->DatosDomicilioModel->actualizar_predeterminado($this->usuario->id_usuario) : false;
				$guardar_domicilio = $this->DatosDomicilioModel->guardar_row($post,$id);
				if($guardar_domicilio){
					$response['success'] = true;
					$response['msg'][] = 'Se guardaron los datos de domicilio correctamente';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar el domicilio, favor de intentar más tarde';
				}
			}else {
				$response['success'] = false;
				$response['msg'][] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function guardar_empresa($id_usuario,$id = false){
		try{
			$post = $this->input->post();
			$validacion_campos = Validaciones_Helper::formEmpresa($post);
			if($validacion_campos['success']){
				$post['id_usuario'] = $id_usuario;
				isset($post['vigente']) && $post['vigente'] == 'si' ? $this->DatosEmpresaModel->actualizar_vigente($this->usuario->id_usuario) : false;
				$guardar_empresa = $this->DatosEmpresaModel->guardar_row($post,$id);
				if($guardar_empresa){
					$response['success'] = true;
					$response['msg'][] = 'Se guardaron los datos de empresa correctamente';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar los datos de la empresa, favor de intentar más tarde';
				}
			}else {
				$response['success'] = false;
				$response['msg'][] = $validacion_campos['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function obtener_tab_curriculum($id_usuario = false){
		$id_usuario ? $id_usuario : $this->usuario->id_usuario;
		$data['datos_usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$data['cat_nivel_academico'] = $this->CatalogoModel->get_catalogo('cat_nivel_academico');
		$this->load->view('perfil/tab_curriculum',$data);
	}

	public function obtener_tab_expediente_digital($id_usuario = false){
		$id_usuario ? $id_usuario : $this->usuario->id_usuario;
		$usuario = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$usuario = $this->UsuarioModel->obtener_usuario_by_usr($usuario->usuario);
		$data['usuario'] = $usuario;
		$data['datos_usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$data['foto_perfil'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,1);
		$data['foto_certificados'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,2);
		$data['foto_firma'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,8);
		$data['doc_curp'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,7);
		$data['foto_ine_anverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,3);
		$data['foto_ine_reverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,4);
		$data['foto_cedula_anverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,5);
		$data['foto_cedula_reverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario,6);
		//var_dump($data);exit;
		$this->load->view('perfil/tab_expediente_digital',$data);
	}

	public function obtener_tab_direcciones($id_usuario = false){
		$id_usuario ? $id_usuario : $this->usuario->id_usuario;
		$usuario = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$usuario = $this->UsuarioModel->obtener_usuario_by_usr($usuario->usuario);
		$data['usuario'] = $usuario;
		$data['datos_domicilio'] = $this->PerfilModel->obtener_datos_direcciones($id_usuario);
		$this->load->view('perfil/tab_direcciones',$data);
	}

	public function obtener_tab_empresa($id_usuario = false){
		$id_usuario ? $id_usuario : $this->usuario->id_usuario;
		$usuario = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario);
		$usuario = $this->UsuarioModel->obtener_usuario_by_usr($usuario->usuario);
		$data['usuario'] = $usuario;
		$data['datos_empresa'] = $this->PerfilModel->obtener_datos_empresa($id_usuario);
		$this->load->view('perfil/tab_datos_empresa',$data);
	}

	public function actualizar_foto_perfil($id_archivo,$id_usuario = false){
		try{
			$id_usuario ? $id_usuario : $this->usuario->id_usuario;
			$resultado['success'] = false;
			$resultado['msg'] = array('No es posible actualizar la foto de perfil, intentar más tarde');
			$foto_perfil = $this->PerfilModel->actualizar_foto_perfil($id_archivo,$id_usuario);
			if($foto_perfil){
				$resultado['success'] = true;
				$resultado['msg'] = array('Se cargo la foto de perfil con exito');
				$foto_perfil = $this->PerfilModel->foto_perfil();
				$this->usuario->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
				$this->session->set_userdata('usuario',$this->usuario);
			}else{
				$resultado['success'] = false;
				$resultado['msg'] = array('No es posible cargar la foto de perfil');
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = array('No es posible actualizar la foto de perfil, intentar más tarde');
		}
		echo json_encode($resultado);exit;
	}

	public function actualizar_expediente_digital($id_archivo,$id_usuario = false,$id_cat_expediente = 2){
		try{
			$id_usuario ? $id_usuario : $this->usuario->id_usuario;
			$resultado['success'] = false;
			$resultado['msg'] = array('No es posible actualizar el archivo, intentar más tarde');
			$expediente = $this->PerfilModel->actualizar_expediente_usuario($id_archivo,$id_usuario,$id_cat_expediente);
			if($expediente){
				$resultado['success'] = true;
				$resultado['msg'] = array('Se cargo el archivo del expediente con éxito');
			}else{
				$resultado['success'] = false;
				$resultado['msg'] = array('No es posible cargar el archivo del expediente con éxito');
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = array('No es posible actualizar el archivo del expediente, favor de intentar más tarde');
		}
		echo json_encode($resultado);exit;
	}

	public function eliminar_domicilio($id){
		try{
			$eliminar = $this->DatosDomicilioModel->eliminar_row($id);
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

	public function eliminar_empresa($id){
		try{
			$eliminar = $this->DatosEmpresaModel->eliminar_row($id);
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

}
