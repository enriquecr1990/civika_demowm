<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EvaluacionEC extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('ActividadIEModel');
        $this->load->model('ArchivoModel');
        $this->load->model('BancoPreguntaModel');
        $this->load->model('CatalogoModel');
        $this->load->model('EstandarCompetenciaModel');
        $this->load->model('EvaluacionHasPreguntasModel');
        $this->load->model('ECHasEvaluacionModel');
        $this->load->model('EvaluacionModel');
        $this->load->model('OpcionPreguntaModel');
        $this->load->model('UsuarioHasEvaluacionRealizadaModel');
        $this->load->model('UsuarioHasECModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

	public function index($id_estandar_competencia){
    	//tecnicas_instrumentos
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			$data['titulo_pagina'] = 'Evaluación diagnóstica del Estándar de Competencia';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Evaluaciones de la EC','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/evaluacion.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			$this->load->view('evaluacion/tablero',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultado($id_estandar_competencia){
		perfil_permiso_operacion('evaluacion.consultar');
    	try{
    		$busqueda = array(
    			'id_estandar_competencia' => $id_estandar_competencia
			);
			$data = $this->EvaluacionModel->tablero($busqueda);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$this->load->view('evaluacion/resultado',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function preguntas_evaluacion($id_evaluacion){
		perfil_permiso_operacion('preguntas_evaluacion.consultar');
		try{
			$data = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$evaluacion = $this->ECHasEvaluacionModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$data['estandar_competencia_has_evaluacion'] = $evaluacion['estandar_competencia_has_evaluacion'][0];
			foreach ($data['preguntas_evaluacion'] as $pe){
				$opciones_pregunta = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $pe->id_banco_pregunta));
				foreach ($opciones_pregunta['opcion_pregunta'] as $op){
					$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
				}
				$pe->opciones_pregunta = $opciones_pregunta['opcion_pregunta'];
			}
			$this->load->view('evaluacion/tablero_preguntas_evaluacion',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function cuestionario_ati($id_estandar_competencia,$id_ec_instrumento_has_actividad){
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			//cargamos el(los) modelos especificos para el cuestionario
			$this->load->model('EcATIEvaluacionModel');
			$data['titulo_pagina'] = 'Cuestionario';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Actividades, técnicas e instrumentos','activo' => false,'url' => base_url().'tecnicas_instrumentos/'.$id_estandar_competencia),
				array('nombre' => 'Cuestionario del instrumento','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = 'estandar_competencias';
			$data['usuario'] = $this->usuario;
			$data['id_estandar_competencia'] = $id_estandar_competencia;
			$data['id_ec_instrumento_has_actividad'] = $id_ec_instrumento_has_actividad;
			$data['ec_instrumento_actividad_evaluacion'] = $this->EcATIEvaluacionModel->obtener_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad);
			$data['evaluacion'] = $this->EvaluacionModel->obtener_row($data['ec_instrumento_actividad_evaluacion']->id_evaluacion);
			$ec_instrumento_alumno = $this->ActividadIEModel->obtener_ec_instrumento_alumno($id_estandar_competencia);
			$data['existe_evidencia_alumnos'] = is_array($ec_instrumento_alumno) && sizeof($ec_instrumento_alumno) > 0;
			$data['extra_js'] = array(
				base_url() . 'assets/js/ec/evaluacion_cuestionario.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/frm/adm_lte/plugins/summernote/summernote-bs4.min.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',
			);
			//var_dump($data);exit;
			$this->load->view('evaluacion/tablero_instrumento',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function resultado_cuestionario_ati($id_ec_instrumento_has_actividad){
		perfil_permiso_operacion('evaluacion.consultar');
		try{
			$this->load->model('ECInstrumentoHasActividadModel');
			$busqueda = array(
				'id_ec_instrumento_has_actividad' => $id_ec_instrumento_has_actividad
			);
			$data = $this->EvaluacionModel->tablero($busqueda);
			$data['ec_instrumento_has_actividad'] = $this->ECInstrumentoHasActividadModel->obtener_row($id_ec_instrumento_has_actividad);
			$this->load->view('evaluacion/resultado_instrumento',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function preguntas_evaluacion_cuestionario($id_evaluacion){
		perfil_permiso_operacion('preguntas_evaluacion.consultar');
		try{
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$data = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$evaluacion = $this->ECInstrumentoActividadEvaluacionModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$data['ec_instrumento_actividad_evaluacion'] = $evaluacion['ec_instrumento_actividad_evaluacion'][0];
			foreach ($data['preguntas_evaluacion'] as $pe){
				$opciones_pregunta = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $pe->id_banco_pregunta));
				foreach ($opciones_pregunta['opcion_pregunta'] as $op){
					$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
				}
				$pe->opciones_pregunta = $opciones_pregunta['opcion_pregunta'];
			}
			$this->load->view('evaluacion/tablero_preguntas_eva_instrumento',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function agregar_modificar_ec($tipo = 'diagnostica',$id_evaluacion = false){
    	perfil_permiso_operacion('evaluacion.agregar');
    	try{
			switch ($tipo){
				case 'diagnostica':
					$data['tipo'] = EVALUACION_DIAGNOSTICA;
					break;
				case 'cuestionario':
					$data['tipo'] = EVALUACION_CUESTIONARIO_INSTRUMENTO;
					break;
			}
    		$data['cat_evaluacion'] = $this->CatalogoModel->get_catalogo('cat_evaluacion');
			if($id_evaluacion){
				$data['evaluacion'] = $this->EvaluacionModel->obtener_row($id_evaluacion);
			}
			$this->load->view('evaluacion/agregar_modificar_form',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function obtener_ec_evaluacion($id_estandar_competencia,$id_cat_evaluacion){
		perfil_permiso_operacion('evaluacion.agregar');
		try{
			$busqueda = array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_cat_evaluacion' => $id_cat_evaluacion,
				'eliminado' => 'no'
			);
			$data = $this->EvaluacionModel->tablero($busqueda);
			$response['success'] = true;
			$response['msg'] = array();
			$response['data'] = false;
			if($data['total_registros'] != 0){
				$response['data'] = $data['evaluacion'][0];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function guardar_evaluacion_ec($id_estandar_competencia,$id_evaluacion = false){
		perfil_permiso_operacion('evaluacion.agregar');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formEvaluacionEC($post);
			if($validacion['success']){
				$id_evaluacion ? $post['fecha_actualizacion'] = date('Y-m-d H:i:s') : $post['fecha_creacion'] = date('Y-m-d H:i:s');
				$post['eliminado'] = 'no';
				$guardar = $this->EvaluacionModel->guardar_row($post,$id_evaluacion);
				$response['success'] = $guardar['success'];
				$response['msg'] = array($guardar['msg']);
				if($guardar['success']){
					$guardar_ec_eval = $id_evaluacion ? true : $this->EvaluacionModel->guardar_estandar_competencia_evaluacion($id_estandar_competencia,$guardar['id']);
					if(!$guardar_ec_eval){
						$response['success'] = false;
						$response['msg'] = array('No fue posible guardar la evaluación con la EC seleccionada, favor de intentar más tarde');
					}
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

	public function eliminar($id_evaluacion){
		perfil_permiso_operacion('evaluacion.eliminar');
		try{
			$eliminar = $this->EvaluacionModel->eliminar_row($id_evaluacion);
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

	public function deseliminar($id_evaluacion){
		perfil_permiso_operacion('evaluacion.eliminar');
		try{
			$deseliminar = $this->EvaluacionModel->deseliminar_row($id_evaluacion);
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

	public function liberar($id_evaluacion,$id_estandar_competencia_has_evaluacion){
		perfil_permiso_operacion('evaluacion.cerrar_liberar');
		try{
			$data = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			if(isset($data['preguntas_evaluacion']) && sizeof($data['preguntas_evaluacion']) > 0){
				$actualizar = array(
					'liberada' => 'si',
					'fecha_liberacion' => date('Y-m-d H:i:s')
				);
				$liberar = $this->ECHasEvaluacionModel->actualizar($actualizar,$id_estandar_competencia_has_evaluacion);
				if($liberar){
					$response['success'] = true;
					$response['msg'][] = 'Se libero la evaluación correctamente, los candidatos podran responderla';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible liberar la evaluación, favor de intentar más tarde';
				}
			}else{
				$response['success'] = false;
				$response['msg'][] = 'No fue posible liberar la evaluación, debe registrar por lo menos una pregunta para poder continuar';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function liberar_evaluacion_instrumento($id_evaluacion,$id_ec_instrumento_actividad_evaluacion){
		perfil_permiso_operacion('evaluacion.cerrar_liberar');
		try{
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$data = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			if(isset($data['preguntas_evaluacion']) && sizeof($data['preguntas_evaluacion']) > 0){
				$actualizar = array(
					'liberada' => 'si',
					'fecha_liberacion' => date('Y-m-d H:i:s')
				);
				$liberar = $this->ECInstrumentoActividadEvaluacionModel->actualizar($actualizar,$id_ec_instrumento_actividad_evaluacion);
				if($liberar){
					$response['success'] = true;
					$response['msg'][] = 'Se libero la evaluación correctamente, los candidatos podran responderla';
				}else{
					$response['success'] = false;
					$response['msg'][] = 'No fue posible liberar la evaluación, favor de intentar más tarde';
				}
			}else{
				$response['success'] = false;
				$response['msg'][] = 'No fue posible liberar la evaluación, debe registrar por lo menos una pregunta para poder continuar';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function agregar_pregunta($id_evaluacion,$id_banco_pregunta = false){
		perfil_permiso_operacion('preguntas_evaluacion.agregar');
		try{
			$data['id_evaluacion'] = $id_evaluacion;
			$data['cat_tipo_opciones_pregunta'] = $this->CatalogoModel->get_catalogo('cat_tipo_opciones_pregunta');
			if($id_banco_pregunta){
				$data['banco_pregunta'] = $this->BancoPreguntaModel->obtener_row($id_banco_pregunta);
				if($data['banco_pregunta']->id_cat_tipo_opciones_pregunta != OPCION_RELACIONAL){
					$opciones_pregunta = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $id_banco_pregunta));
					foreach ($opciones_pregunta['opcion_pregunta'] as $op){
						$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
					}
					$data['opcion_pregunta'] = $opciones_pregunta['opcion_pregunta'];
				}else{
					$opciones_pregunta_izq = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $id_banco_pregunta,'pregunta_relacional' => 'izquierda'));
					$opciones_pregunta_der = $this->OpcionPreguntaModel->tablero(array('id_banco_pregunta' => $id_banco_pregunta,'pregunta_relacional' => 'derecha'));
					foreach ($opciones_pregunta_izq['opcion_pregunta'] as $op){
						$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
					}foreach ($opciones_pregunta_der['opcion_pregunta'] as $op){
						$op->archivo_imagen_respuesta = isset($op->id_archivo) && !is_null($op->id_archivo) ? $this->ArchivoModel->obtener_row($op->id_archivo) : false;
					}
					$data['opcion_pregunta_izquierda'] = $opciones_pregunta_izq['opcion_pregunta'];
					$data['opcion_pregunta_derecha'] = $opciones_pregunta_der['opcion_pregunta'];
				}
			}
			$this->load->view('evaluacion/agregar_preguntas_evaluacion',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function complemento_pregunta_opciones($id_cat_tipo_opciones_pregunta){
		perfil_permiso_operacion('preguntas_evaluacion.agregar');
		switch ($id_cat_tipo_opciones_pregunta){
			case OPCION_VERDADERO_FALSO:
				$this->load->view('evaluacion/opciones_pregunta/verdadero_falso');
				break;
			case OPCION_UNICA_OPCION:
				$this->load->view('evaluacion/opciones_pregunta/unica_opcion');
				break;
			case OPCION_OPCION_MULTIPLE:
				$this->load->view('evaluacion/opciones_pregunta/opcion_multiple');
				break;
			case OPCION_IMAGEN_UNICA_OPCION:
				$this->load->view('evaluacion/opciones_pregunta/img_unica_opcion');
				break;
			case OPCION_IMAGEN_OPCION_MULTIPLE:
				$this->load->view('evaluacion/opciones_pregunta/img_opcion_multiple');
				break;
			case OPCION_SECUENCIAL:
				$this->load->view('evaluacion/opciones_pregunta/secuenciales');
				break;
			case OPCION_RELACIONAL:
				$this->load->view('evaluacion/opciones_pregunta/relacionales');
				break;
		}
	}

	public function guardar_pregunta_evaluacion($id_evaluacion,$id_banco_pregunta = false){
		perfil_permiso_operacion('preguntas_evaluacion.agregar');
		try{
			$post = $this->input->post();
			$validacion = Validaciones_Helper::formEvaluacionPreguntaOpciones($post);
			if($validacion['success']){
				$guardar_pregunta = $this->EvaluacionHasPreguntasModel->guardar_pregunta_opciones_evaluacion($post,$id_evaluacion,$id_banco_pregunta);
				if($guardar_pregunta['success']){
					$response['success'] = true;
					$response['msg'][] = $guardar_pregunta['msg'];
				}else{
					$response['success'] = false;
					$response['msg'][] = $guardar_pregunta['msg'];
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

	public function eliminar_pregunta($id_banco_pregunta){
    	perfil_permiso_operacion('preguntas_evaluacion.eliminar');
		try{
			$eliminar = $this->BancoPreguntaModel->eliminar_banco_pregunta($id_banco_pregunta);
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

	public function resultados_evaluacion_usuario($id_estandar_competencia,$id_usuario){
		perfil_permiso_operacion('evaluacion.consultar');
		try{
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
			$data['usuario'] = $this->usuario;
			$data['id_usuario_alumno'] = $id_usuario;
			//print_r($data['ec_has_evaluacion']);exit;
			$this->load->view('evaluacion/modal_evidencia',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);
		}
	}

}
