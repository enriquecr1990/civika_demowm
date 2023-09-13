<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TecnicasInstrumentos extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
		$this->load->model('ActividadIEModel');
		$this->load->model('CatalogoModel');
		$this->load->model('ECInstrumentoModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('ECInstrumentoActividadHasArchivo');
		$this->load->model('ECInstrumentoHasActividadModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

	public function index($id_estandar_competencia){
    	//tecnicas_instrumentos
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$data['titulo_pagina'] = 'Actividades, técnicas e instrumentos';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Actividades, técnicas e instrumentos','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'tecnicas_instrumentos';
			$data['usuario'] = $this->usuario;
			$data['id_estandar_competencia'] = $id_estandar_competencia;
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
				base_url() . 'assets/js/ec/actividades_ie.js'
			);
			$ec_instrumento_alumno = $this->ActividadIEModel->obtener_ec_instrumento_alumno($id_estandar_competencia);
			$data['existe_evidencia_alumnos'] = is_array($ec_instrumento_alumno) && sizeof($ec_instrumento_alumno) > 0;
			$this->load->view('ati/actividades_instrumento',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultado_ati($id_estandar_competencia){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
    	try{
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$ec_instrumento_alumno = $this->ActividadIEModel->obtener_ec_instrumento_alumno($id_estandar_competencia);
			$data['existe_evidencia_alumnos'] = is_array($ec_instrumento_alumno) && sizeof($ec_instrumento_alumno) > 0;
			//echo json_encode($data['estandar_competencia_instrumento']);exit;
    		$this->load->view('ati/resultado_ati',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultado_actividades_de_instrumento($id_estandar_competencia,$id_cat_instrumento){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
    	try{
    		$response['success'] = true;
    		$response['msg'][] = 'Se obtuvo la información correctamente';
			$response['ec_instrumento_has_actividad'] = $this->ActividadIEModel->obtener_actividades_instrumento($id_estandar_competencia,$id_cat_instrumento);
		}catch (Exception $ex){
    		$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function agregar_modificar_ati($id_estandar_competencia, $id_ec_instrumento_has_actividad = false){
		perfil_permiso_operacion('tecnicas_instrumentos.agregar');
		try{
			$data['cat_instrumento'] = $this->CatalogoModel->get_catalogo('cat_instrumento');
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			if($id_ec_instrumento_has_actividad){
				$data['id_ec_instrumento_has_actividad'] = $id_ec_instrumento_has_actividad;
				$data['ec_instrumento_has_actividad'] = $this->ECInstrumentoHasActividadModel->obtener_row($id_ec_instrumento_has_actividad);
				$data['estandar_competencia_instrumento'] = $this->ECInstrumentoModel->obtener_row($data['ec_instrumento_has_actividad']->id_estandar_competencia_instrumento);
				$data['ec_instrumento_actividad_has_archivo'] = $this->ActividadIEModel->obtener_archivos_videos($id_ec_instrumento_has_actividad);
			}
			//var_dump($data);exit;
			$this->load->view('ati/form_ati',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_ati($id_estandar_competencia){
		perfil_permiso_operacion('tecnicas_instrumentos.agregar');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formECActividadesIE($post);
			if($validacion['success']){
				$guardar = $this->ActividadIEModel->guardar_ati($post,$id_estandar_competencia);
				if($guardar['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar['msg'];
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validacion['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function eliminar_ec_ati($id_ec_instrumento_has_actividad){
    	try{
    		$response['success'] = false;
    		$response['msg'][] = 'No fue posible eliminar tecnicas/instrumentos y actividades de la evaluación de la EC';
    		if($this->ActividadIEModel->eliminar_ec_ati($id_ec_instrumento_has_actividad)){
				$response['success'] = true;
				$response['msg'] = array('Se eliminó el instrumento de evaluación de la EC');
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

}
