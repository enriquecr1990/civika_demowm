<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EncuestaSatisfaccion extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
		$this->load->model('CatalogoModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioHasEncuestaModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
            http_response_code(401);
			redirect(base_url().'login');
        }
    }

	public function candidato($id_estandar_competencia,$id_usuario){
		try{
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' =>$id_estandar_competencia,'id_usuario' => $id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_ec'] = $usuario_has_ec;
			$data['usuario_has_encuesta_satisfacion'] = $this->UsuarioHasEncuestaModel->encuesta_satisfacion_usuario_ec($usuario_has_ec->id_usuario_has_estandar_competencia);
			$data['cat_preguntas_encuesta'] = $this->CatalogoModel->cat_preguntas_encuesta();
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['titulo_pagina'] = 'Encuesta de satisfacción';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Encuesta de satisfacción','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/js/ec/encuesta_safisfaccion.js'
			);
			$this->load->view('encuesta_satisfacion/candidato',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function candidato_lectura($id_estandar_competencia,$id_usuario){
		try{
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' =>$id_estandar_competencia,'id_usuario' => $id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_ec'] = $usuario_has_ec;
			$data['usuario_has_encuesta_satisfacion'] = $this->UsuarioHasEncuestaModel->encuesta_satisfacion_usuario_ec($usuario_has_ec->id_usuario_has_estandar_competencia);
			$data['cat_preguntas_encuesta'] = $this->CatalogoModel->cat_preguntas_encuesta();
			foreach ($data['cat_preguntas_encuesta'] as $cpe){
				$respuesta_candidato = $this->UsuarioHasEncuestaModel->respuesta_candidato_pregunta($cpe->id_cat_preguntas_encuesta,$data['usuario_has_encuesta_satisfacion']->id_usuario_has_encuesta_satisfaccion);
				$cpe->respuesta = $respuesta_candidato;
			}
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['titulo_pagina'] = 'Encuesta de satisfacción';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Encuesta de satisfacción','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$this->load->view('encuesta_satisfacion/candidato_lectura',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_encuesta_satisfacion($id_usuario_has_ec){
		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formEncuestaSatisfacion($post);
			if($validaciones['success']){
				$guardar = $this->UsuarioHasEncuestaModel->guardar_respuestas_candidato($id_usuario_has_ec,$post);
				if($guardar['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar la encuesta, favor de intentar más tarde';
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Ocurrio un error al intentar guardar';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function guardar_encuesta_satisfacion_derechos_obligaciones($id_usuario_has_ec){
		try{
			$post = $this->input->post();
			$validaciones = Validaciones_Helper::formEncuestaSatisfacionDerechosObligaciones($post);
			if($validaciones['success']){
				$guardar = $this->UsuarioHasEncuestaModel->guardar_respuestas_candidato_derechos_obligaciones($id_usuario_has_ec,$post);
				if($guardar['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar la encuesta, favor de intentar más tarde';
				}
			}else{
				$response['success'] = false;
				$response['msg'] = $validaciones['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Ocurrio un error al intentar guardar';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

}
