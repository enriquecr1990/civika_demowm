<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('EcCursoModel');
		$this->load->model('EcCursoModuloModel');
		$this->load->model('ArchivoModel');

		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = null;
		}
	}

	public function index($id_estandar_competencia)
	{
		$data['titulo_pagina'] = 'Módulos de capacitación';
		$data['usuario'] = $this->usuario;
		$data['id_estandar_competencia'] = $id_estandar_competencia;
		$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
			array('nombre' => 'Módulos de capacitación','activo' =>  true,'url' => '#')
		);


		$data['extra_js'] = array(
			base_url() . 'assets/js/curso.js',
			base_url().'assets/frm/fileinput/js/fileinput.js',
			base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
			base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
			base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
		);
		$data['extra_css'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
		);
				
		
		$this->load->view('curso/tablero_curso',$data);
	}

	public function tablero($pagina = 1, $registros = 5){
    		try{
			//integramos la fecha del sistema y poder filtrar las convocatorias vigentes. Se toma hasta antes del final de la alineación
    			/* $post = [
				'fecha' => date('Y-m-d'),
				'publicado' => 'si'
			]; */
			$post['id_estandar_competencia'] = $this->input->post("id_estandar_competencia");
			if(!is_null($this->usuario) && in_array($this->usuario->perfil,array('instructor','alumno'))){
				$post['id_usuario'] = $this->usuario->id_usuario;
			}
			$data = $this->EcCursoModel->tablero($post,$pagina,$registros);
			//var_dump($data); exit();
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data['ec_curso']); exit();
			$this->load->view('curso/cursos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}


	public function agregar_modificar_curso($id_estandar_competencia, $id_ec_curso = false){
		perfil_permiso_operacion('curso_ec.agregar');
    	$data = array("id_estandar_competencia" => $id_estandar_competencia);
		
    	if($id_ec_curso !== false){
    		$data['ec_curso'] = $this->EcCursoModel->obtener_row($id_ec_curso);
			//$data['ec_curso_modulos'] = (array)$this->EcCursoModuloModel->obtener_ec_curso_modulos($id_ec_curso);
			//var_dump($data['ec_curso_modulos'],$id_ec_curso); exit();
			$data['archivo_banner'] = null;
			if(isset($data['ec_curso']->id_archivo) && !is_null($data['ec_curso']->id_archivo) && $data['ec_curso']->id_archivo != ''){
				$data['archivo_banner'] = $this->ArchivoModel->obtener_archivo($data['ec_curso']->id_archivo);
			}
		}
		//var_dump($data, $id_ec_curso); exit();
    	$this->load->view('curso/agregar_modificar_curso',$data);
	}

	public function guardar_form($id_estandar_competencia = false){
		perfil_permiso_operacion('curso_ec.agregar');
    		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formCurso($post);
			if($validaciones['success']){
				$id_ec_curso = $this->input->post("id_ec_curso") != "" ? $this->input->post("id_ec_curso") : false;
				$guardar_ec_curso = $this->EcCursoModel->guardar_row($post, $id_ec_curso);
				if($guardar_ec_curso['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_ec_curso['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_ec_curso['msg'];
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

	public function detalle($id_ec_curso){
		try{
			/* $tablero = $this->EcCursoModuloModel->tablero(['id_ec_curso' => $id_ec_curso]);
			$data['ec_curso_modulo_model'] = $tablero['ec_curso_modulo_model'][0]; */
			$data['ec_curso'] = $this->EcCursoModel->obtener_ec_curso($id_ec_curso);
			

			$busquedaCursoModel = array(
				'id_ec_curso' => $id_ec_curso
			);
			$data['ec_curso_modulo'] = $this->EcCursoModuloModel->tablero($busquedaCursoModel);
			//dd($data); exit();
			$this->load->view('curso/curso_modulo_detalle',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function publicar($id_ec_curso, $id_estandar_competencia){
		perfil_permiso_operacion('curso_ec.consultar');
		try{

			$dataCursoModuloTemario = $this->EcCursoModel->getCursoModuloTemario($id_ec_curso);

			$result = Validaciones_Helper::validatePublicateModuloCapacitacion($dataCursoModuloTemario);

			if(!$result['success']){
				echo json_encode($result); exit();
			}
			
			$cambiarCursosPublicadoNO = $this->EcCursoModel->actualizar_row_criterios(array("id_estandar_competencia" => $id_estandar_competencia), array("publicado" => "no"));

			$publicar = $this->EcCursoModel->actualizar(['publicado' => 'si', 'fecha_publicado' => date('Y-m-d H:i:s')],$id_ec_curso);
			if($publicar){

				$response['success'] = true;
				$response['msg'][] = 'Se publicó el curso con éxito';
			}else{
				$response['success'] = false;
				$response['msg'][] = 'No fue posible publicar el curso, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function eliminar($id_ec_curso){
		perfil_permiso_operacion('curso_ec.eliminar');
		try{
			$eliminar = $this->EcCursoModel->eliminar_row($id_ec_curso);
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

	public function deseliminar($id_ec_curso){
		perfil_permiso_operacion('curso_ec.deseliminar');
		try{
			$deseliminar = $this->EcCursoModel->deseliminar_row($id_ec_curso);
			if($deseliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $deseliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $deseliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}


	public function index_curso_modulos($id_ec_curso)
	{
		$data['titulo_pagina'] = 'Módulos de capacitación Walmart - Administración de Modulos';
		$data['usuario'] = $this->usuario;
		$data['id_ec_curso'] = $id_ec_curso;
		$data['ec_curso'] = $this->EcCursoModel->obtener_row($id_ec_curso);

		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
			array('nombre' => 'Módulos de capacitación','activo' => false,'url' => base_url().'modulo_capacitacion/'.$data['ec_curso']->id_estandar_competencia),
			array('nombre' => 'Modulos','activo' => true,'url' => '#'),
		);

		$data['extra_js'] = array(
			base_url() . 'assets/js/curso_modulos.js',
			base_url().'assets/frm/fileinput/js/fileinput.js',
			base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
			base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
			base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
			base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
		);
		$data['extra_css'] = array(
			base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
		);
				
		
		$this->load->view('curso/tablero_curso_modulos',$data);
	}

	public function tablero_curso_modulos($id_ec_curso){
		perfil_permiso_operacion('ec_curso.consultar');
		try{
			$busqueda = array(
				'id_ec_curso' => $id_ec_curso
			);
			$data = $this->EcCursoModuloModel->tablero($busqueda);

			$data['ec_curso'] = $this->EcCursoModel->obtener_row($id_ec_curso);
			//dd($data);exit;
			$this->load->view('curso/resultado_curso_modulos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar_curso_modulo($id_ec_curso, $id_ec_curso_modulo = false){
		perfil_permiso_operacion('curso_ec.agregar');
    	$data = array("id_ec_curso" => $id_ec_curso);
		
    	if($id_ec_curso_modulo !== false){
    		$data['ec_curso_modulo'] = $this->EcCursoModuloModel->obtener_row($id_ec_curso_modulo);
			
			//var_dump($data['ec_curso_modulos'],$id_ec_curso); exit();
		}
		//var_dump($data); exit();
    	$this->load->view('curso/agregar_modificar_curso_modulo',$data);
	}

	public function guardar_form_curso_modulo($id_ec_curso = false){
		perfil_permiso_operacion('curso_ec.agregar');
    		try{
			$post = $this->input->post();
			$rules = ["descripcion" => ['required'],
					'objetivo_general' => ["required"],
					'objetivos_especificos' => ["required"],
				];
			$validaciones = Validaciones_Helper::validateFormAll($post, $rules);
			
			if($validaciones['success']){
				$id_ec_curso_modulo = $this->input->post("id_ec_curso_modulo") != "" ? $this->input->post("id_ec_curso_modulo") : false;
				$guardar_ec_curso_modulo = $this->EcCursoModuloModel->guardar_row($post, $id_ec_curso_modulo);
				if($guardar_ec_curso_modulo['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_ec_curso_modulo['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_ec_curso_modulo['msg'];
				}
			}else{
				$response['success'] = false;
				$response['code'] = 400;
				$response['msg'] = $validaciones['messages'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['code'] = 500;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar_ec_curso_modulo($id_ec_curso_modulo){
		perfil_permiso_operacion('curso_ec.eliminar');
		try{
			$eliminar = $this->EcCursoModuloModel->eliminar_row($id_ec_curso_modulo);
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

	public function deseliminar_ec_curso_modulo($id_ec_curso_modulo){
		perfil_permiso_operacion('curso_ec.deseliminar');
		try{
			$deseliminar = $this->EcCursoModuloModel->deseliminar_row($id_ec_curso_modulo);
			if($deseliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $deseliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $deseliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function agregar_modificar_curso_modulo_temario($id_ec_curso_modulo, $id_ec_curso_modulo_temario = false){
		perfil_permiso_operacion('curso_ec.agregar');
    	$data = array("id_ec_curso_modulo" => $id_ec_curso_modulo);
		
    	if($id_ec_curso_modulo_temario !== false){
    		$data['ec_curso_modulo_temario'] = $this->EcCursoModuloTemarioModel->obtener_row($id_ec_curso_modulo_temario);
			//$data['ec_curso_modulos'] = (array)$this->EcCursoModuloModel->obtener_ec_curso_modulos($id_ec_curso);
			//var_dump($data['ec_curso_modulos'],$id_ec_curso); exit();
			$data['archivo'] = null;
			if(isset($data['ec_curso_modulo_temario']->id_archivo) && !is_null($data['ec_curso_modulo_temario']->id_archivo) && $data['ec_curso_modulo_temario']->id_archivo != ''){
				$data['archivo'] = $this->ArchivoModel->obtener_archivo($data['ec_curso_modulo_temario']->id_archivo);
			}
		}
		//var_dump($data, $id_ec_curso_modulo_temario); exit();
    	$this->load->view('curso/agregar_modificar_curso_modulo_temario',$data);
	}

	public function guardar_form_curso_modulo_temario($id_ec_curso_modulo = false){
		perfil_permiso_operacion('curso_ec.agregar');
    		try{
			$post = $this->input->post();
			$rules = ["tema" => ['required'],
					'instrucciones' => ["required"],
					'contenido_curso' => ["required"],
					'id_archivo' => ['required']
				];
			$validaciones = Validaciones_Helper::validateFormAll($post, $rules);
			
			if($validaciones['success']){
				$id_ec_curso_modulo_temario = $this->input->post("id_ec_curso_modulo_temario") != "" ? $this->input->post("id_ec_curso_modulo_temario") : false;
				$guardar_ec_curso_modulo_temario = $this->EcCursoModuloTemarioModel->guardar_row($post, $id_ec_curso_modulo_temario);
				if($guardar_ec_curso_modulo_temario['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_ec_curso_modulo_temario['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_ec_curso_modulo_temario['msg'];
				}
			}else{
				$response['success'] = false;
				$response['code'] = 400;
				$response['msg'] = $validaciones['messages'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['code'] = 500;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar_ec_curso_modulo_temario($id_ec_curso_modulo_temario){
		perfil_permiso_operacion('curso_ec.eliminar');
		try{
			$eliminar = $this->EcCursoModuloTemarioModel->eliminar_row($id_ec_curso_modulo_temario);
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

	public function deseliminar_ec_curso_modulo_temario($id_ec_curso_modulo_temario){
		perfil_permiso_operacion('curso_ec.deseliminar');
		try{
			$deseliminar = $this->EcCursoModuloTemarioModel->deseliminar_row($id_ec_curso_modulo_temario);
			if($deseliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $deseliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $deseliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	
}
