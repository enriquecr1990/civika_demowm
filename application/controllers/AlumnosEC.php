<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AlumnosEC extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
		$this->load->model('ArchivoModel');
		$this->load->model('ActividadIEModel');
        $this->load->model('EcInstrumentoAlumnoModel');
        $this->load->model('EcInstrumentoAlumnoComentarioModel');
        $this->load->model('EcInstrumentoAlumnoEvidenciasModel');
        $this->load->model('EntregableAlumnoArchivoModel');
        $this->load->model('ECUsuarioHasExpedientePEDModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('ECHasEvaluacionModel');
		$this->load->model('EvaluacionHasPreguntasModel');
		$this->load->model('EvaluacionModel');
		$this->load->model('EvaluacionRespuestasUsuarioModel');
		$this->load->model('DocsPDFModel');
		$this->load->model('PlanRequerimientoModel');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioHasECProgresoModel');
		$this->load->model('UsuarioModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
            http_response_code(401);
			redirect(base_url().'login');
        }
    }

	/**
	 * funciones para ver el progreso del candidado del EC
	 */
	public function ver_progreso($id_estandar_competencia,$id_usuario_evaluador){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$data['titulo_pagina'] = 'Estándar de competencia';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Progreso','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
				base_url().'assets/js/validacion_datos.js',
				base_url().'assets/js/ec/candidato.js',
				base_url().'assets/js/ec/encuesta_safisfaccion.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css'
			);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['evaluador'] = $this->EstandarCompetenciaModel->obtener_instructor_ec($id_estandar_competencia,$id_usuario_evaluador);
			$foto_perfil = $this->PerfilModel->foto_perfil($id_usuario_evaluador);
			$data['evaluador']->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $this->usuario->id_usuario),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$progreso_pasos = $this->UsuarioHasECProgresoModel->tablero(array('id_usuario_has_estandar_competencia' => $data['usuario_has_ec']->id_usuario_has_estandar_competencia),0);
			//iteramos el progreso de pasos para determinar si habilitamos o no los pasos del candidato y calcular su progreso
			$data['progreso_pasos'] = $progreso_pasos['total_registros'];
			//var_dump($progreso_pasos);exit;
			$this->load->view('alumno_ec/progreso_ec',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ficha_carta_compromiso($id_estandar_competencia){
		try{
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $this->usuario->id_usuario),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario'] = $this->usuario;
			$data['datos_usuario'] = $this->UsuarioModel->obtener_usuario_modificar_id($this->usuario->id_usuario);
			$data['datos_domicilio'] = $this->PerfilModel->obtener_datos_direcciones($this->usuario->id_usuario,true);
			$data['firma_candidato'] = $this->PerfilModel->obtener_datos_expediente($this->usuario->id_usuario,8);
			$data['foto_certificado_candidato'] = $this->PerfilModel->obtener_datos_expediente($this->usuario->id_usuario,2);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$vista_carta_compromiso = $this->load->view('alumno_ec/progreso_pasos/carta_compromiso',$data,true);
			$response['success'] = true;
			$response['msg'][] = 'Se obtuvo la carta compromiso con exito';
			$response['data']['html_ficha_carta_compromiso'] = $vista_carta_compromiso;
			$response['data']['mostrar_modal'] = true;
			if($data['usuario_has_ec']->carta_compromiso == 'si'){
				$response['data']['mostrar_modal'] = false;
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function ver_progreso_evaluacion_diagnostica($id_estandar_competencia,$id_usuario){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			//apartado de evaluacion diagnostica
			$data['usuario'] = $this->usuario;
			$data['ec_has_evaluacion'] = $this->ECHasEvaluacionModel->obtener_evaluaciones_ec($id_estandar_competencia);
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $id_usuario),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			foreach ($data['ec_has_evaluacion'] as $eche){
				$buscar_evaluacion_realizada = array(
					'id_usuario' => $id_usuario,
					'id_estandar_competencia_has_evaluacion' => $eche->id_estandar_competencia_has_evaluacion,
					'enviada' => 'si'
				);
				$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_evaluacion_realizada,0);
				$eche->evaluaciones_realizadas = $usuario_has_evaluacion_realizada['usuario_has_evaluacion_realizada'];
			}
			//var_dump($data['ec_has_evaluacion']);exit;
			//fin apartado de evaluacion diagnostica
			$this->load->view('alumno_ec/progreso_pasos/evaluacion_diagnostica',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_derechos_obligaciones(){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$this->load->view('alumno_ec/progreso_pasos/derechos_obligaciones');
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_evaluacion_requerimientos($id_estandar_competencia,$id_usuario_alumno,$id_usuario_evaluador){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			//validar evaluacion_realizada
			$buscar_usuario_has_evaluacion_enviada =  array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno, 'enviada' => 'si');
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$usuario_has_evaluacion_enviada['total_registros'] != 0 ? $data['evaluacion_diagnostica_realizada'] = true : $data['evaluacion_diagnostica_realizada'] = false;
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$estandar_competencia_has_requerimientos = $this->PlanRequerimientoModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia),0);
			$data['estandar_competencia_requerimientos'] = $estandar_competencia_has_requerimientos['estandar_competencia_has_requerimientos'];
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['id_usuario_alumno'] = $id_usuario_alumno;
			$data['id_usuario_evaluador'] = $id_usuario_evaluador;
			$this->load->view('alumno_ec/progreso_pasos/evaluacion_requerimientos',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_certificado_ec($id_estandar_competencia,$id_usuario_alumno,$id_usuario_evaluador){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			//validar evaluacion_realizada
			$data['certificado_laboral_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_CERTIFICADO_EC);
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['id_usuario_alumno'] = $id_usuario_alumno;
			$data['id_usuario_evaluador'] = $id_usuario_evaluador;
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $this->usuario->id_usuario),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			//var_dump($data);exit;
			$this->load->view('alumno_ec/progreso_pasos/certificado_ec',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_evidencias_old($id_estandar_competencia,$id_usuario){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$data['usuario'] = $this->usuario;
			//apartado para la evidencia de trabajo del candidato
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$buscar_usuario_has_evaluacion_enviada =  array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_usuario' => $id_usuario,
				'enviada' => 'si'
			);
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$data['puede_cargar_evidencia_ati'] = true;
			//formatoArrayData($data);exit;
			if($usuario_has_evaluacion_enviada['total_registros'] == 0){
				$data['puede_cargar_evidencia_ati'] = false;
			}else{
				foreach ($data['estandar_competencia_instrumento'] as $index => $eci){
					//ciclamos las actividades correspondientes de la ec
					foreach ($eci->actividades as $idx => $act){
						$busqueda_instrumento_alumno = array(
							'id_ec_instrumento_has_actividad' => $act->id_ec_instrumento_has_actividad,
							'id_usuario' => $this->usuario->id_usuario
						);
						$instrumento_alumno = $this->EcInstrumentoAlumnoModel->tablero($busqueda_instrumento_alumno);
						//lo dejamos en cero dado que deberia devolver un registro en este campo
						$instrumento_alumno = isset($instrumento_alumno['ec_instrumento_alumno'][0]) ? $instrumento_alumno['ec_instrumento_alumno'][0] : false;
						if($instrumento_alumno){
							//obtenemos los registros de los comentarios del entregable ATI
							$busqueda_archivos_comentarios = array('id_ec_instrumento_alumno' => $instrumento_alumno->id_ec_instrumento_alumno);
							$instrumento_comentario = $this->EcInstrumentoAlumnoComentarioModel->tablero($busqueda_archivos_comentarios);
							$instrumento_comentario = $instrumento_comentario['ec_instrumento_alumno_has_comentario'];
							$instrumento_alumno->comentarios = $instrumento_comentario;
							//consultamos los registros de los archivos que ha cargado el candidato
							$instrumento_evidencia_candidato = $this->EcInstrumentoAlumnoEvidenciasModel->tablero($busqueda_archivos_comentarios);
							$instrumento_alumno->evidencias = $instrumento_evidencia_candidato['ec_instrumento_alumno_evidencias'];
						}else{
							//insertamos el instrumento que debera llenar el alumno
							$busqueda_instrumento_alumno['id_cat_proceso'] = ESTATUS_EN_CAPTURA;
							$instrumento_alumno_nuevo = $this->EcInstrumentoAlumnoModel->guardar_row($busqueda_instrumento_alumno);
							$instrumento_alumno = $this->EcInstrumentoAlumnoModel->obtener_row($instrumento_alumno_nuevo['id']);
							$instrumento_alumno->comentarios = array();
							$instrumento_alumno->evidencias = array();
							$instrumento_alumno->evaluacion = false;
						}
						$act->ec_instrumento_alumno = $instrumento_alumno;
						$act->evaluacion_instrumento = false;
						//para obtener la evaluacion del instrumento
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
			}
			//Fin del apartado para la evidencia de trabajo del candidato
			formatoArrayData($data['estandar_competencia_instrumento']);exit;
			$this->load->view('alumno_ec/progreso_pasos/evidencias',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_evidencias($id_estandar_competencia,$id_usuario){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$data['usuario'] = $this->usuario;
			//apartado para la evidencia de trabajo del candidato
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$buscar_usuario_has_evaluacion_enviada =  array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_usuario' => $id_usuario,
				'enviada' => 'si'
			);
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$data['puede_cargar_evidencia_ati'] = true;
			//formatoArrayData($data);exit;
			if($usuario_has_evaluacion_enviada['total_registros'] == 0){
				$data['puede_cargar_evidencia_ati'] = false;
			}else{
				foreach ($data['estandar_competencia_instrumento'] as $index => $eci){
					//ciclamos las actividades correspondientes de la ec
					foreach ($eci->actividades as $idx => $act){
						$busqueda_instrumento_alumno = array(
							'id_ec_instrumento_has_actividad' => $act->id_ec_instrumento_has_actividad,
							'id_usuario' => $this->usuario->id_usuario
						);
						$instrumento_alumno = $this->EcInstrumentoAlumnoModel->tablero($busqueda_instrumento_alumno);
						//lo dejamos en cero dado que deberia devolver un registro en este campo
						$instrumento_alumno = isset($instrumento_alumno['ec_instrumento_alumno'][0]) ? $instrumento_alumno['ec_instrumento_alumno'][0] : false;
						if($instrumento_alumno){
							//obtenemos los registros de los comentarios del entregable ATI
							$busqueda_archivos_comentarios = array('id_ec_instrumento_alumno' => $instrumento_alumno->id_ec_instrumento_alumno);
							$instrumento_comentario = $this->EcInstrumentoAlumnoComentarioModel->tablero($busqueda_archivos_comentarios);
							$instrumento_comentario = $instrumento_comentario['ec_instrumento_alumno_has_comentario'];
							$instrumento_alumno->comentarios = $instrumento_comentario;
							//consultamos los registros de los archivos que ha cargado el candidato
							$instrumento_evidencia_candidato = $this->EcInstrumentoAlumnoEvidenciasModel->tablero($busqueda_archivos_comentarios);
							$instrumento_alumno->evidencias = $instrumento_evidencia_candidato['ec_instrumento_alumno_evidencias'];
						}else{
							//insertamos el instrumento que debera llenar el alumno
							$busqueda_instrumento_alumno['id_cat_proceso'] = ESTATUS_EN_CAPTURA;
							$instrumento_alumno_nuevo = $this->EcInstrumentoAlumnoModel->guardar_row($busqueda_instrumento_alumno);
							$instrumento_alumno = $this->EcInstrumentoAlumnoModel->obtener_row($instrumento_alumno_nuevo['id']);
							$instrumento_alumno->comentarios = array();
							$instrumento_alumno->evidencias = array();
							$instrumento_alumno->evaluacion = false;
						}
						$act->ec_instrumento_alumno = $instrumento_alumno;
						$act->evaluacion_instrumento = false;
						//para obtener la evaluacion del instrumento
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
			}
			//Fin del apartado para la evidencia de trabajo del candidato
			$this->load->view('alumno_ec/progreso_pasos/evidencias_old',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_juicio_evaluacion($id_estandar_competencia,$id_usuario_alumno,$id_usuario_evaluador){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			//apartado de evaluacion diagnostica
			$data['usuario'] = $this->usuario;
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $id_usuario_alumno),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['id_usuario_alumno'] = $id_usuario_alumno;
			$data['id_usuario_evaluador'] = $id_usuario_evaluador;
			//fin apartado de evaluacion diagnostica
			$this->load->view('alumno_ec/progreso_pasos/juicio_competencia',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_encuesta_satisfaccion($id_estandar_competencia,$id_usuario){
		try{
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' =>$id_estandar_competencia,'id_usuario' => $id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_ec'] = $usuario_has_ec;
			$data['usuario_has_encuesta_satisfacion'] = $this->UsuarioHasEncuestaModel->encuesta_satisfacion_usuario_ec($usuario_has_ec->id_usuario_has_estandar_competencia);
			$data['cat_preguntas_encuesta'] = $this->CatalogoModel->cat_preguntas_encuesta();
			if(!is_null($data['usuario_has_encuesta_satisfacion'])){
				foreach ($data['cat_preguntas_encuesta'] as $cpe){
					$respuesta_candidato = $this->UsuarioHasEncuestaModel->respuesta_candidato_pregunta($cpe->id_cat_preguntas_encuesta,$data['usuario_has_encuesta_satisfacion']->id_usuario_has_encuesta_satisfaccion);
					$cpe->respuesta = $respuesta_candidato;
				}
			}
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['titulo_pagina'] = 'Encuesta de satisfacción';
			$data['usuario'] = $this->usuario;
			$this->load->view('alumno_ec/progreso_pasos/encuesta_satisfacion',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function ver_progreso_expediente_digital($id_estandar_competencia,$id_usuario){
		try{
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' =>$id_estandar_competencia,'id_usuario' => $id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_ec'] = $usuario_has_ec;$data['ficha_registro_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario,EXPEDIENTE_FICHA_REGISTRO);
			$data['instrumento_evaluacion_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario,EXPEDIENTE_INSTRUMENTO_EVA);
			$data['certificado_laboral_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario,EXPEDIENTE_CERTIFICADO_EC);
			$usuario_has_ec = $this->DocsPDFModel->obtener_usuario_has_ec($id_usuario,$id_estandar_competencia);
			$data['archivo_ped_generado'] = false;
			if(is_object($usuario_has_ec) && isset($usuario_has_ec->id_archivo_ped) && !is_null($usuario_has_ec->id_archivo_ped) && $usuario_has_ec->id_archivo_ped != ''){
				$data['archivo_ped_generado'] = $this->ArchivoModel->obtener_archivo($usuario_has_ec->id_archivo_ped);
			}
			//var_dump($data);exit;
			$this->load->view('alumno_ec/progreso_pasos/expediente_digital',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function guardar_progreso_pasos($id_usuario_has_estandar_competencia,$paso = 1){
		try{
			$response['success'] = true;
			$response['msg'] = array();
			$busqueda_pasos = array(
				'id_usuario_has_estandar_competencia' => $id_usuario_has_estandar_competencia,
				'numero_paso' => $paso
			);
			$progreso_pasos = $this->UsuarioHasECProgresoModel->tablero($busqueda_pasos);
			if($progreso_pasos['total_registros'] == 0){
				$busqueda_pasos['fecha'] = date('Y-m-d H:i:s');
				$response = $this->UsuarioHasECProgresoModel->guardar_row($busqueda_pasos);
				if(!$response['success']){
					$response['msg'] = array('No fue posible guardar su progreso en este paso, favor de intentar más tarde');
				}
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function evidencia_ati($id_estandar_competencia,$id_usuario = false){
		perfil_permiso_operacion('tecnicas_instrumentos.consultar');
		try{
			$id_usuario = $id_usuario ? $id_usuario : $this->usuario->id_usuario;
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);
			$buscar_usuario_has_evaluacion_enviada =  array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_usuario' => $id_usuario,
				'enviada' => 'si'
			);
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$data['puede_cargar_evidencia_ati'] = true;
			if($usuario_has_evaluacion_enviada['total_registros'] == 0){
				$data['puede_cargar_evidencia_ati'] = false;
			}else{
				foreach ($data['estandar_competencia_instrumento'] as $index => $eci){
					//ciclamos las actividades correspondientes de la ec
					foreach ($eci->actividades as $idx => $act){
						$busqueda_instrumento_alumno = array(
							'id_ec_instrumento_has_actividad' => $act->id_ec_instrumento_has_actividad,
							'id_usuario' => $this->usuario->id_usuario
						);
						$instrumento_alumno = $this->EcInstrumentoAlumnoModel->tablero($busqueda_instrumento_alumno);
						//lo dejamos en cero dado que deberia devolver un registro en este campo
						$instrumento_alumno = isset($instrumento_alumno['ec_instrumento_alumno'][0]) ? $instrumento_alumno['ec_instrumento_alumno'][0] : false;
						if($instrumento_alumno){
							//obtenemos los registros de los comentarios del entregable ATI
							$instrumento_comentario = $this->EcInstrumentoAlumnoComentarioModel->tablero(
								array('id_ec_instrumento_alumno' => $instrumento_alumno->id_ec_instrumento_alumno)
							);
							$instrumento_comentario = $instrumento_comentario['ec_instrumento_alumno_has_comentario'];
							$instrumento_alumno->comentarios = $instrumento_comentario;
						}else{
							//insertamos el instrumento que debera llenar el alumno
							$busqueda_instrumento_alumno['id_cat_proceso'] = ESTATUS_EN_CAPTURA;
							$instrumento_alumno_nuevo = $this->EcInstrumentoAlumnoModel->guardar_row($busqueda_instrumento_alumno);
							$instrumento_alumno = $this->EcInstrumentoAlumnoModel->obtener_row($instrumento_alumno_nuevo['id']);
							$instrumento_alumno->comentarios = array();
						}
						$act->ec_instrumento_alumno = $instrumento_alumno;
					}
				}
			}
			//print_r($data['estandar_competencia_instrumento']);exit;
			$this->load->view('alumno_ec/modal_evidencia_ati',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
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
				$guardar_comentario = $this->EcInstrumentoAlumnoComentarioModel->guardar_row($post);
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

	public function actualizar_ati($id_entregable,$id_alumno){
		perfil_permiso_operacion('tecnicas_instrumentos.comentario');
		try{
			$post_update = $this->input->post();
			$update = $this->EntregableAlumnoArchivoModel->guardar_archivo($post_update, $id_entregable, $id_alumno);
			$response['success'] = $update['success'];
			$response['msg'][] = $update['msg'];
			$response['data']['id_insert'] = $update['id'];
			$response['data']['id_entregable'] = $update['id_entregable'];
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function evaluacion($id_estandar_competencia,$id_evaluacion){
		perfil_permiso_operacion('evaluacion.respuesta');
		try{
			$data['titulo_pagina'] = 'Mi examen de la EC';
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/frm/jquery_countdown/jquery.countdown.min.js',
				base_url().'assets/js/ec/examen.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/css/reloj.css'
			);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['evaluacion'] = $this->EvaluacionModel->obtener_row($id_evaluacion);
			$ec_has_evaluacion = $this->ECHasEvaluacionModel->tablero(array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_evaluacion' => $id_evaluacion,
				'liberada' => 'si'
			));
			//var_dump($ec_has_evaluacion);exit;
			$data['existe_evaluacion_liberada'] = true;
			//validamos que exista una evaluacion liberada
			//apartado para calificaciones
			$data['tiene_evaluacion_aprobatoria'] = false;
			$data['puede_realizar_evaluacion'] = true;
			$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$data['ec_has_evaluacion'] = $ec_has_evaluacion['estandar_competencia_has_evaluacion'][0];
			$data['preguntas_evaluacion'] = $evaluacion_preguntas['preguntas_evaluacion'];
			//validamos una evaluacion realizada y aprobada
			$buscar_usuario_has_evaluacion_enviada =  array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_estandar_competencia_has_evaluacion' => $data['ec_has_evaluacion']->id_estandar_competencia_has_evaluacion,
				'id_usuario' => $this->usuario->id_usuario,
				'enviada' => 'si'
			);
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $this->usuario->id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_estandar_competencia'] = $usuario_has_ec;
			$total_intentos = $data['evaluacion']->intentos;
			if(is_object($usuario_has_ec) && $usuario_has_ec->intentos_adicionales != 0){
				$total_intentos += $usuario_has_ec->intentos_adicionales;
			}
			if($total_intentos != 0){
				if($usuario_has_evaluacion_enviada['total_registros'] >= $total_intentos){
					$data['puede_realizar_evaluacion'] = false;
				}
			}

			if($data['puede_realizar_evaluacion']){
				$buscar_usuario_has_evaluacion = $buscar_usuario_has_evaluacion_enviada;
				$buscar_usuario_has_evaluacion['enviada'] = 'no';
				$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion,0);
				if($usuario_has_evaluacion_realizada['total_registros'] == 0){
					$buscar_usuario_has_evaluacion['fecha_iniciada'] = date('Y-m-d H:i:s');
					$this->UsuarioHasEvaluacionRealizadaModel->insertar($buscar_usuario_has_evaluacion);
					unset($buscar_usuario_has_evaluacion['fecha_iniciada']);
					$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion);
				}
				$data['usuario_has_evaluacion_realizada'] = $usuario_has_evaluacion_realizada['usuario_has_evaluacion_realizada'][0];
				//respuestas_candidato
				foreach ($data['preguntas_evaluacion'] as $index => $pe){
					$opciones = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $pe->id_banco_pregunta));
					$opciones_izquierda = array();
					$opciones_derecha = array();
					foreach ($opciones['opcion_pregunta'] as $op){
						$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
						if($pe->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL){
							$op->pregunta_relacional == 'izquierda' ? $opciones_izquierda[] = $op : $opciones_derecha[] = $op;
						}
					}
					$pe->opciones_pregunta = $opciones['opcion_pregunta'];
					$pe->opciones_pregunta_izq = $opciones_izquierda;
					$pe->opciones_pregunta_der = $opciones_derecha;
				}
			}
			//var_dump($data);exit;
			$this->load->view('alumno_ec/examen',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

	public function ver_evaluacion($id_usuario_has_evaluacion_realizada){
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			$evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->obtener_row($id_usuario_has_evaluacion_realizada);
			//determinar hacia donde iran los datos para la evaluacion
			//puede ser una evaluacion del estandar de competencia, como puede ser de un instrumento y los demas que lleguen a salir
			//estandar_competencia_evaluacion
			if(!is_null($evaluacion_realizada->id_estandar_competencia_has_evaluacion) && $evaluacion_realizada->id_estandar_competencia_has_evaluacion != ''){
				$ec_has_evaluacion = $this->ECHasEvaluacionModel->obtener_row($evaluacion_realizada->id_estandar_competencia_has_evaluacion);
				$id_evaluacion = $ec_has_evaluacion->id_evaluacion;
				$data['ec_has_evaluacion'] = $ec_has_evaluacion;
			}
			//cuestionario del instrumento de evaluación
			if(!is_null($evaluacion_realizada->id_ec_instrumento_actividad_evaluacion) && $evaluacion_realizada->id_ec_instrumento_actividad_evaluacion != ''){
				$this->load->model('ECInstrumentoActividadEvaluacionModel');
				$ec_instrumento_actividad_evaluacion = $this->ECInstrumentoActividadEvaluacionModel->obtener_row($evaluacion_realizada->id_ec_instrumento_actividad_evaluacion);
				$id_evaluacion = $ec_instrumento_actividad_evaluacion->id_evaluacion;
			}
			$data['evaluacion'] = $this->EvaluacionModel->obtener_row($id_evaluacion);
			$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$data['preguntas_evaluacion'] = $evaluacion_preguntas['preguntas_evaluacion'];
			$data['usuario_has_evaluacion_realizada'] = $evaluacion_realizada;
			//respuestas_candidato
			foreach ($data['preguntas_evaluacion'] as $index => $pe){
				$opciones = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $pe->id_banco_pregunta));
				$opciones_izquierda = array();
				$opciones_derecha = array();
				foreach ($opciones['opcion_pregunta'] as $op){
					$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
					if($pe->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL){
						$op->pregunta_relacional == 'izquierda' ? $opciones_izquierda[] = $op : $opciones_derecha[] = $op;
					}
				}
				$pe->opciones_pregunta = $opciones['opcion_pregunta'];
				$pe->opciones_pregunta_izq = $opciones_izquierda;
				$pe->opciones_pregunta_der = $opciones_derecha;
				$pe->respuesta_candidato = $this->EvaluacionRespuestasUsuarioModel->obtener_respuesta_usuario($pe->id_banco_pregunta,$data['usuario_has_evaluacion_realizada']->id_usuario_has_evaluacion_realizada);
			}
			$respuestas_candidato = $this->EvaluacionRespuestasUsuarioModel->obtener_respuestas_candidato($data['usuario_has_evaluacion_realizada']->id_usuario_has_evaluacion_realizada);
			$data['respuestas_candidato'] = array();
			foreach ($respuestas_candidato as $rc){
				$data['respuestas_candidato'][$rc->id_banco_pregunta] = $rc->incorrectas_alumno == 0 && $rc->correctas_alumno == $rc->numero_opciones_correctas;
			}
			//echo '<pre>';print_r($data);exit;
			$this->load->view('alumno_ec/examen_lectura',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

	public function guardar_respuestas(){
		perfil_permiso_operacion('evaluacion.respuesta');
		try{
			$post = $this->input->post();
			$response['success'] = false;
			$response['msg'][] = 'No fue posible guardar las respuestas de su evaluación, favor de intentar más tarde';
			$guardar = $this->EvaluacionRespuestasUsuarioModel->guardar_respuestas_evaluacion_diagnostica($post);
			if($guardar){
				$response['success'] = true;
				$calificacion = $this->EvaluacionRespuestasUsuarioModel->obtener_calificacion_evaluacion($post['id_usuario_has_evaluacion_realizada']);
				$response['data'] = $this->data_calificacion($calificacion);
				$response['data']['evaluacion_sistema'] = 'Tomar capacitación previo a la Evaluación';
				if($calificacion > 33 && $calificacion <= 66){
					$response['data']['evaluacion_sistema'] = 'Tomar alineación previo a la Evaluación';
				}if($calificacion > 66){
					$response['data']['evaluacion_sistema'] = 'Iniciar el proceso de Evaluación';
				}
				//almacenamos la calificación obtenida
				$this->UsuarioHasEvaluacionRealizadaModel->guardar_row(array('calificacion' => $response['data']['calificacion']),$post['id_usuario_has_evaluacion_realizada']);
				$response['data']['id_usuario_has_evaluacion_realizada'] = $post['id_usuario_has_evaluacion_realizada'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function guardar_decision(){
		perfil_permiso_operacion('evaluacion.respuesta');
		try{
			$post = $this->input->post();
			$response['success'] = false;
			$response['msg'][] = 'No fue posible guardar su decisión, favor de intentar más tarde';
			$guardar = $this->UsuarioHasEvaluacionRealizadaModel->guardar_row($post,$post['id_usuario_has_evaluacion_realizada']);
			if($guardar['success']){
				$response['success'] = true;
				$response['msg'] = array('Se guardó su decisión en el sistema');
			}else{
				$response['msg'] = $guardar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function calificacion_evaluacion($id_usuario_has_evaluacion_realizada){
    	try{
    		$calificacion = $this->EvaluacionRespuestasUsuarioModel->obtener_calificacion_evaluacion($id_usuario_has_evaluacion_realizada);
    		$response['success'] = true;
    		$response['msg'][] = 'Se obtuvo la calificación de la evaluacion realizada';
    		$response['data'] = $this->data_calificacion($calificacion);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function data_calificacion($calificacion){
    	$data['calificacion'] = $calificacion;
		$data['tag'] = 'badge badge-danger';
		if($data['calificacion'] >= 70 && $data['calificacion'] < 80){
			$data['tag'] = 'badge badge-warning';
		}if($data['calificacion'] >= 80 && $data['calificacion'] < 90){
			$data['tag'] = 'badge badge-info';
		}if($data['calificacion'] >= 90){
			$data['tag'] = 'badge badge-success';
		}
    	return $data;
	}

	public function expediente_digital($id_estandar_competencia,$id_usuario_alumno){
		try{
			$data['ficha_registro_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_FICHA_REGISTRO);
			$data['instrumento_evaluacion_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_INSTRUMENTO_EVA);
			$data['certificado_laboral_pdf'] = $this->ECUsuarioHasExpedientePEDModel->obtener_registro_existente($id_estandar_competencia,$id_usuario_alumno,EXPEDIENTE_CERTIFICADO_EC);
			$usuario_has_ec = $this->DocsPDFModel->obtener_usuario_has_ec($id_usuario_alumno,$id_estandar_competencia);
			$data['archivo_ped_generado'] = false;
			if(is_object($usuario_has_ec) && isset($usuario_has_ec->id_archivo_ped) && !is_null($usuario_has_ec->id_archivo_ped) && $usuario_has_ec->id_archivo_ped != ''){
				$data['archivo_ped_generado'] = $this->ArchivoModel->obtener_archivo($usuario_has_ec->id_archivo_ped);
			}
			$this->load->view('alumno_ec/expediente_digital',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	//para la evaluacion del instrumento cuestionario
	public function evaluacion_instrumento($id_ec_instrumento_has_actividad,$id_evaluacion){
		perfil_permiso_operacion('evaluacion.respuesta');
		try{
			$this->load->model('ECInstrumentoModel');
			$this->load->model('ECInstrumentoHasActividadModel');
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$data['titulo_pagina'] = 'Mi evaluación del instrumento';
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['extra_js'] = array(
				base_url().'assets/frm/jquery_countdown/jquery.countdown.min.js',
				base_url().'assets/js/ec/instrumento/examen.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/css/reloj.css'
			);
			$data['instrumento_has_actividad'] = $this->ECInstrumentoHasActividadModel->obtener_row($id_ec_instrumento_has_actividad);
			$data['estandar_competencia_instrumento'] = $this->ECInstrumentoModel->obtener_row($data['instrumento_has_actividad']->id_estandar_competencia_instrumento);
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $data['estandar_competencia_instrumento']->id_estandar_competencia,'id_usuario' => $this->usuario->id_usuario),0);
			$usuario_has_ec = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$data['usuario_has_estandar_competencia'] = $usuario_has_ec;
			$data['evaluacion'] = $this->EvaluacionModel->obtener_row($id_evaluacion);
			$data['existe_evaluacion_liberada'] = false;
			$buscar_evaluacion_instrumento = array(
				'id_ec_instrumento_has_actividad' => $id_ec_instrumento_has_actividad,
				'liberada' => 'si'
			);
			$evaluacion_instrumento = $this->ECInstrumentoActividadEvaluacionModel->tablero($buscar_evaluacion_instrumento);
			//var_dump($data,$evaluacion_instrumento);exit;
			if($evaluacion_instrumento['total_registros'] != 0){
				$data['existe_evaluacion_liberada'] = true;
				//validamos que exista una evaluacion liberada
				//apartado para calificaciones
				$data['tiene_evaluacion_aprobatoria'] = false;
				$data['puede_realizar_evaluacion'] = true;
				$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
				$data['preguntas_evaluacion'] = $evaluacion_preguntas['preguntas_evaluacion'];
				$data['ec_instrumento_actividad_evaluacion'] = $evaluacion_instrumento['ec_instrumento_actividad_evaluacion'][0];
				//validamos una evaluacion realizada y aprobada
				$buscar_usuario_has_evaluacion_enviada =  array(
					'id_ec_instrumento_actividad_evaluacion' => $data['ec_instrumento_actividad_evaluacion']->id,
					'id_usuario' => $this->usuario->id_usuario,
					'enviada' => 'si'
				);
				$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
				//para determinar los intentos adicionales que se le otorgaran a cada candidato conforme al instrumento
				//no se solicitó pero considero que se pedira por parte de CIVIKA
				$ec_instrumento_alumno = $this->EcInstrumentoAlumnoModel->tablero(
					array('id_usuario' => $this->usuario->id_usuario,'id_ec_instrumento_has_actividad' => $id_ec_instrumento_has_actividad)
				);
				$data['ec_instrumento_alumno'] = $ec_instrumento_alumno['total_registros'] != 0 ? $ec_instrumento_alumno['ec_instrumento_alumno'][0] : false;
				$total_intentos = $data['evaluacion']->intentos;
				if(is_object($data['ec_instrumento_alumno']) && $data['ec_instrumento_alumno']->intentos_adicionales != 0){
					$total_intentos += $data['ec_instrumento_alumno']->intentos_adicionales;
				}if($usuario_has_evaluacion_realizada['total_registros'] >= $total_intentos){
					$data['puede_realizar_evaluacion'] = false;
				}

				if($data['puede_realizar_evaluacion']){
					$buscar_usuario_has_evaluacion = $buscar_usuario_has_evaluacion_enviada;
					$buscar_usuario_has_evaluacion['enviada'] = 'no';
					if($usuario_has_evaluacion_realizada['total_registros'] == 0){
						$buscar_usuario_has_evaluacion['fecha_iniciada'] = date('Y-m-d H:i:s');
						$this->UsuarioHasEvaluacionRealizadaModel->insertar($buscar_usuario_has_evaluacion);
						unset($buscar_usuario_has_evaluacion['fecha_iniciada']);
						$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion);
					}
					$data['usuario_has_evaluacion_realizada'] = $usuario_has_evaluacion_realizada['usuario_has_evaluacion_realizada'][0];
					//respuestas_candidato
					foreach ($data['preguntas_evaluacion'] as $index => $pe){
						$opciones = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $pe->id_banco_pregunta));
						$opciones_izquierda = array();
						$opciones_derecha = array();
						foreach ($opciones['opcion_pregunta'] as $op){
							$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
							if($pe->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL){
								$op->pregunta_relacional == 'izquierda' ? $opciones_izquierda[] = $op : $opciones_derecha[] = $op;
							}
						}
						$pe->opciones_pregunta = $opciones['opcion_pregunta'];
						$pe->opciones_pregunta_izq = $opciones_izquierda;
						$pe->opciones_pregunta_der = $opciones_derecha;
					}
				}
				//var_dump($data);exit;
			}
			$this->load->view('alumno_ec/examen_instrumento',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

	public function guardar_respuestas_instrumento(){
		perfil_permiso_operacion('evaluacion.respuesta');
		try{
			$post = $this->input->post();
			$response['success'] = false;
			$response['msg'][] = 'No fue posible guardar las respuestas de su evaluación, favor de intentar más tarde';
			$guardar = $this->EvaluacionRespuestasUsuarioModel->guardar_respuestas_evaluacion_instrumento($post);
			if($guardar){
				$response['success'] = true;
				$calificacion = $this->EvaluacionRespuestasUsuarioModel->obtener_calificacion_evaluacion_instrumento($post['id_usuario_has_evaluacion_realizada']);
				$response['data'] = $this->data_calificacion($calificacion);
				$response['data']['evaluacion_sistema'] = 'Tomar capacitación previo a la Evaluación';
				if($calificacion > 33 && $calificacion <= 66){
					$response['data']['evaluacion_sistema'] = 'Tomar alineación previo a la Evaluación';
				}if($calificacion > 66){
					$response['data']['evaluacion_sistema'] = 'Iniciar el proceso de Evaluación';
				}
				//almacenamos la calificación obtenida
				$this->UsuarioHasEvaluacionRealizadaModel->guardar_row(array('calificacion' => $response['data']['calificacion']),$post['id_usuario_has_evaluacion_realizada']);
				$response['data']['id_usuario_has_evaluacion_realizada'] = $post['id_usuario_has_evaluacion_realizada'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

}
