<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH.'application/controllers/Notificaciones.php';

class ConvocatoriasEC extends CI_Controller {

    	private $usuario;

    function __construct(){
        parent:: __construct();
	   $this->load->model('ActividadIEModel');
	   $this->load->model('ECHasEvaluacionModel');
	   $this->load->model('EstandarCompetenciaModel');
	   $this->load->model('CatalogoModel');
	   $this->load->model('EstandarCompetenciaConvocatoriaModel');
	   $this->load->model('PlanRequerimientoModel');
	   $this->load->model('UsuarioHasECModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

    	public function index($idEstandarCompetencia){
		perfil_permiso_operacion('estandar_competencia.consultar');
    		try{

			$array_busqueda = array();
			if(in_array($this->usuario->perfil,array('instructor','alumno'))){
				$array_busqueda['id_usuario'] = $this->usuario->id_usuario;
			}
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/convocatoria.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2/css/select2.min.css',
				base_url().'assets/frm/adm_lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
			);
			$data['titulo_pagina'] = 'Convocatoria del Estándar de competencia';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Convocatorias','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($idEstandarCompetencia);
			//cargar los datos que funcionaran para validaciones y poder liberar una convocatoria
			//$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($idEstandarCompetencia);
			//$estandar_competencia_has_requerimientos = $this->PlanRequerimientoModel->tablero(array('id_estandar_competencia' => $idEstandarCompetencia),0,10);
			//$data['estandar_competencia_has_requerimientos'] = $estandar_competencia_has_requerimientos['estandar_competencia_has_requerimientos'];
			//para la evaluacion diagnostica
			$data['estandar_competencia_evaluacion'] = $this->ECHasEvaluacionModel->obtener_evaluacion_diagnostica_liberada($idEstandarCompetencia);
			$data['evaluacion_instrumento_liberados'] = $this->ActividadIEModel->getEvaluacionInstrumento();
			$instructores = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $idEstandarCompetencia,'perfil' => 'instructor'),0);
			$data['instructores_asignados'] = $instructores['usuario_has_estandar_competencia'];
			$this->load->view('ec/convocatoria/tablero',$data);
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
			$data = $this->EstandarCompetenciaConvocatoriaModel->tablero($post,$pagina,$registros);
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$data['fecha_hoy'] = date('Ymd');
			//var_dump($data);exit;
			$this->load->view('ec/convocatoria/resultado_tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar_convocatoria($idEstandarCompetencia,$idEstandarCompetenciaConvocatoria = ''){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$data['id_estandar_competencia'] = $idEstandarCompetencia;
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($idEstandarCompetencia);
			$data['cat_sector_ec'] = $this->CatalogoModel->cat_sector_ec();
			if($this->usuario->perfil == 'instructor'){
				$data['id_usuario'] = $this->usuario->id_usuario;
			}
			if($idEstandarCompetenciaConvocatoria != ''){
				$data['estandar_competencia_convocatoria'] = $this->EstandarCompetenciaConvocatoriaModel->obtener_row($idEstandarCompetenciaConvocatoria);
			}
			$this->load->view('ec/convocatoria/agregar_modificar',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function clonar_convocatoria($idEstandarCompetenciaConvocatoria){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$data['es_clonacion'] = true;
			$data['cat_sector_ec'] = $this->CatalogoModel->cat_sector_ec();
			$estandar_competencia_convocatoria_clon = $this->EstandarCompetenciaConvocatoriaModel->obtener_row($idEstandarCompetenciaConvocatoria);
			$data['id_estandar_competencia'] = $estandar_competencia_convocatoria_clon->id_estandar_competencia;
			$estandar_competencia_convocatoria_clon->id_estandar_competencia_convocatoria = '';
			$data['estandar_competencia_convocatoria'] = $estandar_competencia_convocatoria_clon;
			if($this->usuario->perfil == 'instructor'){
				$data['id_usuario'] = $this->usuario->id_usuario;
			}
			$this->load->view('ec/convocatoria/agregar_modificar',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_convocatoria($id_estandar_competencia_convocatoria = false){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formConvocatoriaEC($post);
			if($validaciones['success']){
				$guardar = $this->EstandarCompetenciaConvocatoriaModel->guardar_row($post,$id_estandar_competencia_convocatoria);
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

	public function eliminar($id_eliminar){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$eliminar = $this->EstandarCompetenciaConvocatoriaModel->eliminar_row($id_eliminar);
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

	public function deseliminar($id_eliminar){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$deseliminar = $this->EstandarCompetenciaConvocatoriaModel->deseliminar_row($id_eliminar);
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

	public function publicar($id_estandar_competencia_convocatoria){
		perfil_permiso_operacion('estandar_competencia.consultar');
		try{
			$publicar = $this->EstandarCompetenciaConvocatoriaModel->actualizar(['publicada' => 'si'],$id_estandar_competencia_convocatoria);
			if($publicar){
				$response['success'] = true;
				$response['msg'][] = 'Se publicó la convocatoria con éxito';
			}else{
				$response['success'] = false;
				$response['msg'][] = 'No fue posible publicar la convocatoria, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

}
