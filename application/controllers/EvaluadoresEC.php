<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EvaluadoresEC extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
		$this->load->model('ActividadIEModel');
		$this->load->model('EcInstrumentoAlumnoComentarioModel');
		$this->load->model('EntregableAlumnoComentariosModel');
        $this->load->model('EcInstrumentoAlumnoModel');
        $this->load->model('ECUsuarioHasExpedientePEDModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioModel');
		$this->load->model('EntregableECModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

    public function alumnos($id_estandar_competencia){
		perfil_permiso_operacion('estandar_competencia.alumno');
		try{
			$data['titulo_pagina'] = 'Alumnos del Estándar de Competencias';
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['usuario'] = $this->usuario;
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Alumnos','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['extra_js'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.js',
				base_url().'assets/frm/adm_lte/plugins/summernote/lang/summernote-es-ES.js',
				base_url().'assets/frm/adm_lte/plugins/daterangepicker/daterangepicker.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
				'https://cdnjs.cloudflare.com/ajax/libs/bowser/1.9.4/bowser.min.js', //para determinar que navegador se usa
				base_url().'assets/js/ec/instructor.js',
				base_url().'assets/js/pdf/portafolio_evidencia.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/adm_lte//plugins/daterangepicker/daterangepicker.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			//var_dump($data);exit;
			$this->load->view('instructor_ec/tablero_alumnos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero_alumnos($id_estandar_competencia,$pagina = 1,$limit = 5){
		perfil_permiso_operacion('estandar_competencia.alumno');
		try{
			$instructores_asignados = $this->UsuarioHasECModel->alumnos_inscritos_ec($id_estandar_competencia,PERFIL_ALUMNO,$pagina,$limit);
			$data['alumnos_ec'] = $instructores_asignados;
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['total_registros'] = $this->UsuarioHasECModel->total_registros_alumnos_inscritos_ec($id_estandar_competencia,PERFIL_ALUMNO);
			$data_paginacion = data_paginacion($pagina,$limit,$data['total_registros']);
			$data = array_merge($data,$data_paginacion);
			//var_dump($data);exit;
			$this->load->view('instructor_ec/resultado_tablero_alumnos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function evidencia_ati_alumno($id_estandar_competencia, $id_usuario_alumno){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$this->load->model('EvaluacionModel');
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$this->load->model('UsuarioHasEvaluacionRealizadaModel');
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $id_usuario_alumno),0,10);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec_alumno($id_estandar_competencia,$id_usuario_alumno);
			//echo print_r($data['estandar_competencia_instrumento']);exit;
			$data['ati_revisados_liberados'] = true;
			$data['id_estandar_compentencia'] = $id_estandar_competencia;
			$data['id_usuario_alumno'] = $id_usuario_alumno;
			$data['usuario_alumno'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario_alumno);
			foreach ($data['estandar_competencia_instrumento'] as $index => $eci){
				//ciclamos las actividades correspondientes de la ec
				if(sizeof($eci->actividades) == 0){
					$data['ati_revisados_liberados'] = false;
				}
				foreach ($eci->actividades as $idx => $act){
					$busqueda_instrumento_alumno = array(
						'id_ec_instrumento_has_actividad' => $act->id_ec_instrumento_has_actividad,
						'id_usuario' => $id_usuario_alumno
					);
					$instrumento_alumno = $this->EcInstrumentoAlumnoModel->tablero($busqueda_instrumento_alumno);
					//lo dejamos en cero dado que siempre devolvera un registro en este campo
					$instrumento_alumno = isset($instrumento_alumno['ec_instrumento_alumno'][0]) ? $instrumento_alumno['ec_instrumento_alumno'][0] : false;
					if($instrumento_alumno){
						//obtenemos los registros de los comentarios del entregable ATI
						$instrumento_comentario = $this->EcInstrumentoAlumnoComentarioModel->tablero(
							array('id_ec_instrumento_alumno' => $instrumento_alumno->id_ec_instrumento_alumno)
						);
						$instrumento_comentario = $instrumento_comentario['ec_instrumento_alumno_has_comentario'];
						$instrumento_alumno->comentarios = $instrumento_comentario;
						if($instrumento_alumno->id_cat_proceso != ESTATUS_FINALIZADA ){
							$data['ati_revisados_liberados'] = false;
						}
					}else{
						$data['ati_revisados_liberados'] = false;
					}
					$act->ec_instrumento_alumno = $instrumento_alumno;
					//para obtener la evaluacion del instrumento
					$act->evaluacion_instrumento = false;
					if($eci->id_cat_instrumento == INSTRUMENTO_CUESTIONARIO){
						$buscar_evaluacion_instrumento = array(
							'id_ec_instrumento_has_actividad' => $act->id_ec_instrumento_has_actividad,
							'liberada' => 'si'
						);
						$evaluacion_instrumento = $this->ECInstrumentoActividadEvaluacionModel->tablero($buscar_evaluacion_instrumento);
						if($evaluacion_instrumento['total_registros'] != 0){
							$act->evaluacion_instrumento = $evaluacion_instrumento['ec_instrumento_actividad_evaluacion'][0];
							$act->evaluacion = $this->EvaluacionModel->obtener_row($act->evaluacion_instrumento->id_evaluacion);
							//para determinar que evaluacion ya realizó
							$usuario_has_evaluacion_instrumento = $this->UsuarioHasEvaluacionRealizadaModel->tablero(
								array('id_ec_instrumento_actividad_evaluacion' => $act->evaluacion_instrumento->id,'enviada' => 'si'),
								0);
							$act->instrumento_actividad_evaluacion = array();
							if($usuario_has_evaluacion_instrumento['total_registros'] != 0){
								$act->instrumento_actividad_evaluacion = $usuario_has_evaluacion_instrumento['usuario_has_evaluacion_realizada'];
							}
						}
						//numeros de intentos
						$act->intentos_permitidos = isset($act->evaluacion->intentos) ? $act->evaluacion->intentos : 1;
						if(isset($act->ec_instrumento_alumno->intentos_adicionales) && $act->ec_instrumento_alumno->intentos_adicionales != ''){
							$act->intentos_permitidos += $act->ec_instrumento_alumno->intentos_adicionales;
						}
					}
				}
			}
			//print_r($data);exit;

			$datos = $this->EntregableECModel->obtener_entregables_candidato($id_estandar_competencia,$id_usuario_alumno);

			$data['entregables'] = $datos;

			$this->load->view('instructor_ec/modal_evidencia_ati_alumno',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function tablero_evaluador($id_estandar_competencia,$id_usuario_alumno){
		$datos = $this->EntregableECModel->obtener_entregables_candidato($id_estandar_competencia,$id_usuario_alumno);

		$data['entregables'] = $datos;

		$this->load->view('entregables/evaluador/tablero_evidencias_evaluador',$data);
	}

	public function expediente_candidato($id_estandar_competencia, $id_usuario_alumno){
		perfil_permiso_operacion('estandar_competencia.alumno');
		try{
			$data['id_estandar_compentencia'] = $id_estandar_competencia;
			$data['id_usuario_alumno'] = $id_usuario_alumno;
			$data['usuario_alumno'] = $this->UsuarioModel->obtener_usuario_modificar_id($id_usuario_alumno);
			$data['ficha_registro_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_FICHA_REGISTRO);
			$data['instrumento_evaluacion_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_INSTRUMENTO_EVA);
			$data['certificado_laboral_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_CERTIFICADO_EC);
			$this->load->view('instructor_ec/modal_expediente_candidato',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_archivo_expediente_digital(){
		perfil_permiso_operacion('estandar_competencia.alumno');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formExpedienteDigital($post);
			if($validacion['success']){
				if($this->ECUsuarioHasExpedientePEDModel->guardar_archivo_expediente($post)){
					$response['success'] = true;
					$response['msg'][] = 'Se cargo y actualizo el expediente del candidato correctamente';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible cargar el expediente, favor de intentar más tarde';
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

	public function evaluaciones_alumno($id_estandar_competencia, $id_usuario_alumno){
    	perfil_permiso_operacion('evaluacion.consultar');
    	try{
			$data = array();
			$this->load->view('instructor_ec/modal_evaluaciones_alumno',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_comentario(){
		perfil_permiso_operacion('tecnicas_instrumentos.comentario');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formComentarioATI($post);
			if($validacion['success']){
				$post['fecha'] = date('Y-m-d H:i:s');
				$guardar_comentario = $this->EntregableAlumnoComentariosModel->guardar_comentario($post);
				$response['success'] = $guardar_comentario['success'];
				$response['msg'][] = $guardar_comentario['msg'];
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

	public function guardar_fecha_evidencia_ati(){
		perfil_permiso_operacion('tecnicas_instrumentos.modificar');
    	try{
			$post = $this->input->post();
			$criterios = $post;
			unset($criterios['fecha_evidencia_ati']);
			unset($criterios['lugar_presentacion_resultados']);
			unset($criterios['descripcion_presentacion_resultados']);
			unset($criterios['fecha_presentacion_resultados']);
			$valores = $post;
			unset($valores['id_estandar_competencia']);
			unset($valores['id_usuario']);
			$actualizar = $this->UsuarioHasECModel->actualizar_row_criterios($criterios,$valores);
			if($actualizar['success']){
				$response['success'] = true;
				$response['msg'][] = 'Se actualizó la fecha de la evidencia con éxito';
			}else{
				$response['success'] = false;
				$response['msg'][] = 'No fue posible actualizar la fecha de la evidencia, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function actualizar_ati($id_ec_instrumento_alumno){
		perfil_permiso_operacion('tecnicas_instrumentos.comentario');
		try{
			$post_update = $this->input->post();
			$update = $this->EcInstrumentoAlumnoModel->guardar_row($post_update,$id_ec_instrumento_alumno);
			$response['success'] = $update['success'];
			$response['msg'][] = $update['msg'];
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function guardar_form_resultados_evaluacion($id_usuario_has_ec){
		perfil_permiso_operacion('tecnicas_instrumentos.comentario');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formResultadosEvaluacion($post);
			if($validacion['success']){
				$guardar = $this->UsuarioHasECModel->guardar_row($post,$id_usuario_has_ec);
				if($guardar['success']){
					$response['success'] = true;
					$response['msg'][] = 'Se guardo los resultados de la evaluación con exito';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible guardar los resultados de la evaluación, favor de intentar más tarde';
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

}
