<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH.'application/controllers/Notificaciones.php';

class EC extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('ActividadIEModel');
        $this->load->model('ArchivoModel');
        $this->load->model('CatalogoModel');
        $this->load->model('EstandarCompetenciaModel');
		$this->load->model('ECHasEvaluacionModel');
        $this->load->model('UsuarioHasECModel');
        $this->load->model('UsuarioModel');
        $this->load->model('UsuarioHasECProgresoModel');
        $this->load->model('PerfilModel');
        $this->load->model('PlanRequerimientoModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

    public function index(){
		perfil_permiso_operacion('estandar_competencia.consultar');
    	try{
			$array_busqueda = array();
			if(in_array($this->usuario->perfil,array('instructor','alumno'))){
				$array_busqueda['id_usuario'] = $this->usuario->id_usuario;
			}
			$data = $this->EstandarCompetenciaModel->tablero($array_busqueda,1,5);
			$data['titulo_pagina'] = 'Estándar de competencias';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion(1,5,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/estandar_competencia.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			if($this->usuario->perfil == 'alumno'){
				//sacar el instructor asignado al EC
				foreach ($data['estandar_competencia'] as $index => $ec){
					$ec->instructor = $this->EstandarCompetenciaModel->obtener_instructor_ec($ec->id_estandar_competencia,$ec->id_usuario_evaluador);
					$foto_perfil = $this->PerfilModel->foto_perfil($ec->instructor->id_usuario);
					$ec->instructor->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
					$progreso_pasos = $this->UsuarioHasECProgresoModel->tablero(array('id_usuario_has_estandar_competencia' => $ec->id_usuario_has_estandar_competencia),0);
					//iteramos el progreso de pasos para determinar si habilitamos o no los pasos del candidato y calcular su progreso
					$ec->progreso_pasos = $progreso_pasos['total_registros'];
				}
				//$data['extra_css'][] = base_url().'assets/frm/fileinput/css/fileinput.css';
				//$data['extra_css'][] = base_url().'assets/frm/fileupload/css/jquery.fileupload.css';
			 
				$data['extra_js'][] = base_url().'assets/js/ec/candidato.js';
				$data['extra_js'][] = base_url().'assets/frm/fileinput/js/fileinput.js';
				$data['extra_js'][] = base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js';
				$data['extra_js'][] = base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js';
				$data['extra_js'][] = base_url().'assets/frm/fileupload/js/jquery.fileupload.js';
			}
			//var_dump($data);exit;
			$this->load->view('ec/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero($pagina = 1, $registros = 5){
		perfil_permiso_operacion('estandar_competencia.consultar');
    		try{
    			$post = $this->input->post();
			if(in_array($this->usuario->perfil,array('instructor','alumno'))){
				$post['id_usuario'] = $this->usuario->id_usuario;
			}
			$data = $this->EstandarCompetenciaModel->tablero($post,$pagina,$registros);
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			if($this->usuario->perfil == 'alumno'){
				//sacar el instructor asignado al EC
				foreach ($data['estandar_competencia'] as $index => $ec){
					$ec->instructor = $this->EstandarCompetenciaModel->obtener_instructor_ec($ec->id_estandar_competencia,$ec->id_usuario_evaluador);
					$foto_perfil = $this->PerfilModel->foto_perfil($ec->instructor->id_usuario);
					$ec->instructor->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
					$progreso_pasos = $this->UsuarioHasECProgresoModel->tablero(array('id_usuario_has_estandar_competencia' => $ec->id_usuario_has_estandar_competencia),0);
					//iteramos el progreso de pasos para determinar si habilitamos o no los pasos del candidato y calcular su progreso
					$ec->progreso_pasos = $progreso_pasos['total_registros'];
				}
				$this->load->view('ec/resultado_tablero_alumno',$data);
			}else{
				$this->load->view('ec/resultado_tablero',$data);
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modifcar($id_estandar_competencia = false){
		perfil_permiso_operacion('estandar_competencia.agregar');
    	$data = array();
    	if($id_estandar_competencia){
    		$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['archivo_banner'] = null;
			if(isset($data['estandar_competencia']->id_archivo) && !is_null($data['estandar_competencia']->id_archivo) && $data['estandar_competencia']->id_archivo != ''){
				$data['archivo_banner'] = $this->ArchivoModel->obtener_archivo($data['estandar_competencia']->id_archivo);
			}
		}
    	$this->load->view('ec/agregar_modificar_ec',$data);
	}

	public function guardar_form($id_estandar_competencia = false){
		perfil_permiso_operacion('estandar_competencia.agregar');
    		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formEstandarCompetencia($post);
			if($validaciones['success']){
				$guardar_ec = $this->EstandarCompetenciaModel->guardar_row($post,$id_estandar_competencia);
				if($guardar_ec['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_ec['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_ec['msg'];
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

	public function eliminar($id_estandar_compentencia){
		perfil_permiso_operacion('estandar_competencia.eliminar');
		try{
			$eliminar = $this->EstandarCompetenciaModel->eliminar_row($id_estandar_compentencia);
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

	public function deseliminar($id_estandar_compentencia){
		perfil_permiso_operacion('estandar_competencia.deseliminar');
		try{
			$deseliminar = $this->EstandarCompetenciaModel->deseliminar_row($id_estandar_compentencia);
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

	public function agregar_instructor_alumno_ec($id_estandar_competencia,$tipo='instructor'){
		perfil_permiso_operacion('estandar_competencia.instructor');
		try{
			$instructores_candidatos = $this->UsuarioModel->obtener_usuarios_tablero(array(),$tipo,0);
			$data['usuarios'] = $instructores_candidatos['usuarios'];
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['tipo'] = $tipo;
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$estandar_competencia_has_requerimientos = $this->PlanRequerimientoModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia),0,10);
			$data['estandar_competencia_has_requerimientos'] = $estandar_competencia_has_requerimientos['estandar_competencia_has_requerimientos'];
			//para la evaluacion diagnostica
			$data['estandar_competencia_evaluacion'] = $this->ECHasEvaluacionModel->obtener_evaluacion_diagnostica_liberada($id_estandar_competencia);
			$data['evaluacion_instrumento_liberados'] = $this->ActividadIEModel->getEvaluacionInstrumento();
			//cargamos la lista de instructores cuando se muestre la modal para los candidatos
			if($tipo == 'alumno'){
				$instructores = $this->UsuarioModel->obtener_usuarios_tablero(array(),'instructor',0);
				$data['usuarios_instructores'] = $instructores['usuarios'];
				$instructores = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'perfil' => 'instructor'),0);
				$data['instructores_asignados'] = $instructores['usuario_has_estandar_competencia'];
			}
			//var_dump($data['evaluacion_instrumento_liberados']);exit;
			$this->load->view('ec/form_instructores',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function instructores_alumnos_asignados($id_estandar_competencia,$tipo='instructor'){
		perfil_permiso_operacion('estandar_competencia.instructor');
		try{
			$buscar = array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'perfil' => $tipo,
			);
			$instructores_alumnos_asignados = $this->UsuarioHasECModel->tablero($buscar,0);
			$response['success'] = true;
			$response['msg'][] = '';
			$response['usuario_has_estandar_competencia'] = $instructores_alumnos_asignados['usuario_has_estandar_competencia'];
			//sacamos la lista de instructores que se asignaron al EC
			if($tipo == 'alumno'){
				$buscar['perfil'] = 'instructor';
				$instructores = $this->UsuarioHasECModel->tablero($buscar,0);
				$response['instructores_asignados'] = $instructores['usuario_has_estandar_competencia'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function guardar_instructor_alumno_ec($id_estandar_competencia,$id_usuario,$id_usuario_evaluador = false){
		perfil_permiso_operacion('estandar_competencia.instructor');
		try{
			$insert = array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_usuario' => $id_usuario,
				'fecha_registro' => date('Y-m-d')
			);
			$id_usuario_evaluador ? $insert['id_usuario_evaluador'] = $id_usuario_evaluador : false;
			$guardar = $this->UsuarioHasECModel->guardar_row($insert);
			if($guardar['success']){
				$response['success'] = true;
				$response['msg'][] = 'Se guardo el registro con éxito';
			}else{
				$response['success'] = false;
				$response['msg'][] = $guardar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar_instructor_alumno_ec($id_estandar_competencia,$id_usuario){
		perfil_permiso_operacion('estandar_competencia.instructor');
		try{
			$eliminar = array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_usuario' => $id_usuario
			);
			$guardar = $this->UsuarioHasECModel->eliminar_row_criterios($eliminar);
			if($guardar['success']){
				$response['success'] = true;
				$response['msg'][] = 'Se eliminó el registro con éxito';
			}else{
				$response['success'] = false;
				$response['msg'][] = $guardar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function agregar_modificar_plan_requerimientos($id_estandar_competencia){
		perfil_permiso_operacion('tecnicas_instrumentos.agregar');
    	try{
    		$data['id_estandar_competencia'] = $id_estandar_competencia;
    		//falta el data una vez implementado la BD
			$estandar_competencia_has_requerimientos = $this->PlanRequerimientoModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia),0,10);
			$data['estandar_competencia_has_requerimientos'] = $estandar_competencia_has_requerimientos['estandar_competencia_has_requerimientos'];
			//var_dump($data);exit;
    		$this->load->view('ec/agregar_modificar_plan_requerimientos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_form_plan_requerimientos($id_estandar_competencia){
		perfil_permiso_operacion('tecnicas_instrumentos.agregar');
    	try{
    		$post = $this->input->post();
			$validaciones = Validaciones_Helper::formPlanRequerimiento($post);
			if($validaciones['success']){
				$guardar = $this->PlanRequerimientoModel->guardar_registros($post,$id_estandar_competencia);
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

}
