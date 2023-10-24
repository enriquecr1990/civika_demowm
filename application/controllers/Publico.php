<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publico extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		$this->load->model('EstandarCompetenciaConvocatoriaModel');
		$this->load->model('UsuarioHasECModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = null;
		}
	}

	public function index()
	{
		$data['titulo_pagina'] = 'Walmart Certificaciones Civika';
		$data['usuario'] = $this->usuario;
		$data['extra_js'] = array(
			base_url() . 'assets/js/convocatorias_publicas.js',
		);
		$this->load->view('publico',$data);
	}

	public function tablero($pagina = 1, $registros = 5){
    		try{
			//integramos la fecha del sistema y poder filtrar las convocatorias vigentes. Se toma hasta antes del final de la alineación
    			$post = [
				'fecha' => date('Y-m-d'),
				'publicada' => 'si'
			];
			if(!is_null($this->usuario) && in_array($this->usuario->perfil,array('instructor','alumno'))){
				$post['id_usuario'] = $this->usuario->id_usuario;
			}
			$data = $this->EstandarCompetenciaConvocatoriaModel->tablero($post,$pagina,$registros);
			$data['usuario'] = $this->usuario;
			$data_paginacion = data_paginacion($pagina,$registros,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			$this->load->view('convocatorias_publicadas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}


	public function detalle($idEstandarCompetenciaConvocatoria){
		try{
			$tablero = $this->EstandarCompetenciaConvocatoriaModel->tablero(['id_estandar_competencia_convocatoria' => $idEstandarCompetenciaConvocatoria]);
			$data['estandar_competencia_convocatoria'] = $tablero['estandar_competencia_convocatoria'][0];
			$data['usuario'] = $this->usuario;
			$data['existe_usuario_ec'] = false;
			$buscar = [
				'id_estandar_competencia' => $data['estandar_competencia_convocatoria']->id_estandar_competencia,
				'id_usuario' => $this->usuario->id_usuario
			];
			$usuario_has_ec_model = $this->UsuarioHasECModel->tablero($buscar);
			if($usuario_has_ec_model['total_registro'] != 0){
				$data['existe_usuario_ec'] = true;
			}
			$this->load->view('convocatoria_publicada_detalle',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function registrarCandidatoSesion($id_estandar_compentencia_convocatoria){
		try{
			if(sesionActive()){
				$this->usuario = usuarioSession();
			}else{
				// lo mandamos a la sesion en caso de que haya caducado
				redirect(base_url().'login');
			}
			$guardar = $this->guardarCandidatoConvocatoria($id_estandar_compentencia_convocatoria,$this->usuario->id_usuario);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	/**
	 * apartado de funciones para registrar un candidato al EC proporcionando su CURP
	 */
	public function registarCandidato(){
		try{
			$this->load->model('UsuarioModel');
			$this->load->model('UsuarioHasECModel');
			$this->load->model('UsuarioHasECModel');
			//validamos el campo de curp para verificar que si llegue el dato y la curp
			$post = $this->input->post();
			$validacion_campos = Validaciones_Helper::formUsuarioCandidatoConvocatoria($post);
			if($validacion_campos['success']){
				$guardar_candidato = $this->UsuarioModel->guardar_usuario_candidato_convocatoria($post);
				if($guardar_candidato['success']){
					//guardaremos sus datos de usuario conforme al diseño del sistema
					$datos_usuario = [
						'nombre' => '',
						'apellido_p' => '',
						'correo' => '',
						'celular' => '',
						'id_usuario' => $guardar_candidato['data']['id_usuario']
					];
					if(isset($post['es_extranjero']) && $post['es_extranjero'] == 1){
						$datos_usuario['codigo_extranjero'] = $post['codigo_extranjero'];
					}else{
						$datos_usuario['curp'] = $post['curp'];
					}
					//en caso de que sea extranjero se almacenara un codigo nacional conforme a su codigo de identificación oficial
					$this->UsuarioModel->guardar_datos_usuario($datos_usuario);
					$guardar = $this->guardarCandidatoConvocatoria($post['id_estandar_compentencia_convocatoria'],$guardar_candidato['data']['id_usuario']);
					if($guardar['success']){
						$response['success'] = true;
						if(isset($post['es_extranjero']) && $post['es_extranjero'] == 1){
							$response['msg'][] = 'Se registro el candidato con exito, recuerde que usuario y contraseña es la clave de identificación de su registro, le recomendamos cambiar la contraseña';
							$response['data']['usuario'] = $post['codigo_extranjero'];
							$response['data']['password'] = $post['codigo_extranjero'];
						}else{
							$response['msg'][] = 'Se registro el candidato con exito, recuerde que su usuario y constraseña son los primeros diez carácteres de su CURP, le recomendamos cambiar la contraseña';
							$response['data']['usuario'] = substr($post['curp'],0,10);
							$response['data']['password'] = substr($post['curp'],0,10);
						}
					}else{
						$response['success'] = false;
						$response['msg'][] = $guardar['msg'];
					}
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_candidato['msg'];
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
		echo json_encode($response);exit;
	}

	private function guardarCandidatoConvocatoria($id_estandar_compentencia_convocatoria,$id_usuario){
		//para poder devolver el mensaje, hay que obtener el estandar de competencia de la convocatoria
		//asignar un evaluador correspondiente (hacer un ramdom de evaluadores y tomar uno)
		//asignamos el candidato al estandar de competencia conforme a la convocatoria
		$estandar_competencia_convocatoria = $this->EstandarCompetenciaConvocatoriaModel->obtener_row($id_estandar_compentencia_convocatoria);
		$insert = array(
			'id_estandar_competencia' => $estandar_competencia_convocatoria->id_estandar_competencia,
			'id_usuario' => $id_usuario,
			//'id_usuario_evaluador' => $instructor->id_usuario,
			'fecha_registro' => date('Y-m-d')
		);
		$insert['id_usuario_evaluador'] = $estandar_competencia_convocatoria->id_usuario;
		//validamos si existe un instructor que haya registrado la convocatoria
		if(is_null($estandar_competencia_convocatoria->id_usuario)){
			$parametros_busqueda = [
				'id_estandar_competencia' => $estandar_competencia_convocatoria->id_estandar_competencia,
				'perfil' => 'instructor'
			];
			$instructor = $this->UsuarioHasECModel->obtener_instructor_para_registro_candidato($parametros_busqueda);
			$insert['id_usuario_evaluador'] = $instructor->id_usuario;
		}
		return $this->UsuarioHasECModel->guardar_row($insert);
	}

}
