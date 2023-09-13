<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

use \Mpdf\Config\ConfigVariables;
use \Mpdf\Config\FontVariables;

class DocsPDFModel extends ModeloBase
{

	private $usuario;
	private $default_pdf_params;

	function __construct()
	{
		parent::__construct('archivo','a');
		$this->load->library('pdf');
		$this->load->model('ActividadIEModel');
		$this->load->model('ArchivoModel');
		$this->load->model('DatosDomicilioModel');
		$this->load->model('EstandarCompetenciaModel');
		$this->load->model('EvaluacionModel');
		$this->load->model('EvaluacionRespuestasUsuarioModel');
		$this->load->model('PerfilModel');
		$this->load->model('OpcionPreguntaModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioHasEncuestaModel');
		$this->load->model('UsuarioHasRespuestaEncuestaModel');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
		$this->load->model('UsuarioModel');
		$this->set_variables_defaults_pdf();
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			//apartado para la obtención de los datos
			$data['titulo_documento'] = 'Portafolio de evidencia';
			$data['usuario_alumno'] = $this->UsuarioModel->obtener_data_usuario_id($id_usuario_alumno);
			$data['usuario_instructor'] = $this->UsuarioModel->obtener_data_usuario_id($id_usuario_instructor);
			$data['estandar_competencia'] = $this->EstandarCompetenciaModel->obtener_row($id_estandar_competencia);
			$data['datos_domicilio'] = $this->DatosDomicilioModel->obtener_domicilio_usuario($id_usuario_alumno);
			$data['foto_certificados'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,2);
			$data['ine_anverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,3);
			$data['ine_reverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,4);
			$data['cedula_anverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,5);
			$data['cedula_reverso'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,6);
			$data['foto_firma'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,8);
			$data['foto_firma_instructor'] = $this->PerfilModel->obtener_datos_expediente($id_usuario_instructor,8);
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' =>$id_estandar_competencia,'id_usuario' => $id_usuario_alumno),0);
			$data['usuario_has_ec'] = $usuario_has_ec['usuario_has_estandar_competencia'][0];
			$busqueda = array('id_estandar_competencia' => $data['estandar_competencia']->id_estandar_competencia, 'id_cat_evaluacion' => EVALUACION_DIAGNOSTICA);
			$data_evaluacion = $this->EvaluacionModel->tablero($busqueda);
			$data['evaluacion_diagnostica'] = $data_evaluacion['evaluacion'][0];
			$busqueda = array('id_usuario' => $id_usuario_alumno, 'id_estandar_competencia_has_evaluacion' => $data['evaluacion_diagnostica']->id_estandar_competencia_has_evaluacion, 'enviada' => 'si');
			$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($busqueda,0);
			$data['evaluacion_diagnostica_realizada'] = $usuario_has_evaluacion_realizada['usuario_has_evaluacion_realizada'][0];
			$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $data['evaluacion_diagnostica']->id_evaluacion));
			$data['preguntas_evaluacion'] = $evaluacion_preguntas['preguntas_evaluacion'];
			$data['rango_aciertos'][] = intval($evaluacion_preguntas['total_registros'] * 0.33);
			$data['rango_aciertos'][] = intval($evaluacion_preguntas['total_registros'] * 0.66);
			$data['estandar_competencia_instrumento'] = $this->ActividadIEModel->obtener_instrumentos_ec_alumno($id_estandar_competencia);
			$data['estandar_competencia_requerimientos'] = $this->obtener_requerimientos_ec($id_estandar_competencia);
			$data['usuario_has_encuesta'] = $this->UsuarioHasEncuestaModel->encuesta_satisfacion_usuario_ec($data['usuario_has_ec']->id_usuario_has_estandar_competencia);
			$data['respuestas_encuesta_satisfacion'] = array();
			if(!is_null($data['usuario_has_encuesta'])){
				$respuestas_encuesta = $this->UsuarioHasRespuestaEncuestaModel->tablero(array('id_usuario_has_encuesta_satisfaccion' => $data['usuario_has_encuesta']->id_usuario_has_encuesta_satisfaccion),0);
				$data['respuestas_encuesta_satisfacion'] = $respuestas_encuesta['usuario_has_respuesta_encuesta'];
			}
			$buscar_expediente_ped = array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno);
			$expediente_ped = $this->ECUsuarioHasExpedientePEDModel->tablero($buscar_expediente_ped,0);
			$data['usuario_has_expediente_ped'] = $expediente_ped['ec_usuario_has_expediente_ped'];
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
				$pe->respuesta_candidato = $this->EvaluacionRespuestasUsuarioModel->obtener_respuesta_usuario($pe->id_banco_pregunta,$data['evaluacion_diagnostica_realizada']->id_usuario_has_evaluacion_realizada);
			}
			$respuestas_candidato = $this->EvaluacionRespuestasUsuarioModel->obtener_respuestas_candidato($data['evaluacion_diagnostica_realizada']->id_usuario_has_evaluacion_realizada);
			$data['respuestas_candidato'] = array();
			$data['numero_preguntas_evaluacion'] = $evaluacion_preguntas['total_registros'];
			$data['respuestas_correctas_candidato'] = 0;
			foreach ($respuestas_candidato as $rc){
				$rc->incorrectas_alumno == 0 && $rc->correctas_alumno == $rc->numero_opciones_correctas ? $data['respuestas_correctas_candidato']++ : false;
				$data['respuestas_candidato'][$rc->id_banco_pregunta] = $rc->incorrectas_alumno == 0 && $rc->correctas_alumno == $rc->numero_opciones_correctas;
			}
			$data['calificacion_evaluacion'] = ($data['respuestas_correctas_candidato'] / $data['numero_preguntas_evaluacion']) * 100;
			$data['check_resultado_evaluacion_sistema'] = 'tomar_capacitacion';
			if($data['calificacion_evaluacion'] > 33 && $data['calificacion_evaluacion'] <= 66){
				$data['check_resultado_evaluacion_sistema'] = 'tomar_alineacion';
			}if($data['calificacion_evaluacion'] > 66){
				$data['check_resultado_evaluacion_sistema'] = 'tomar_proceso';
			}
			return $data;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> portafolio_evidencia');
		}
	}

	public function obtener_usuario_has_ec($id_usuario_alumno, $id_estandar_competencia){
		$this->db->where('id_usuario',$id_usuario_alumno);
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		$query = $this->db->get('usuario_has_estandar_competencia');
		return $query->row();
	}

	public function actualizar_ped_generado($id_usuario_alumno, $id_estandar_competencia,$id_archivo_ped){
		$this->db->where('id_usuario',$id_usuario_alumno);
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		return $this->db->update('usuario_has_estandar_competencia',array('id_archivo_ped' => $id_archivo_ped));
	}

	public function obtener_archivos_ec_alumno($id_usuario_alumno,$id_estandar_competencia){
		try{
			$consulta = "select 
				  a.ruta_directorio,a.nombre,eiae.url_video
				from ec_instrumento_has_actividad eiha
				  	inner join estandar_competencia_instrumento eci on eci.id_estandar_competencia_instrumento = eiha.id_estandar_competencia_instrumento
				  	inner join ec_instrumento_alumno eia on eia.id_ec_instrumento_has_actividad = eiha.id_ec_instrumento_has_actividad
					inner join ec_instrumento_alumno_evidencias eiae on eiae.id_ec_instrumento_alumno = eia.id_ec_instrumento_alumno
				  	left join archivo_instrumento a on eiae.id_archivo_instrumento = a.id_archivo_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia
				  and eia.id_usuario = $id_usuario_alumno
				order by eci.id_estandar_competencia_instrumento";
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> portafolio_evidencia');
			return false;
		}
	}

	public function obtener_requerimientos_ec($id_estandar_competencia){
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		$query = $this->db->get('estandar_competencia_has_requerimientos');
		return $query->result();
	}

	protected function set_variables_defaults_pdf()
	{
		$configVariablrs =new ConfigVariables();
		$fontVariables = new FontVariables();
		$default_config = $configVariablrs->getDefaults();

		$default_font_config = $fontVariables->getDefaults();
		$font_dirs = $default_config['fontDir'];
		$font_data = $default_font_config['fontdata'];
		$this->default_pdf_params = array(
			'format' => 'Letter',
			'default_font_size' => '12',
			'default_font' => 'Arial',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 5,
			'margin_bottom' => 13,
			'orientation' => 'P',
			'fontDir' => array_merge($font_dirs, array(FCPATH . 'assets/fonts')),
			'fontdata' => $font_data + array(
				"nueva_fuente_modern" => array(
					'R' => "modern_led_board-7.ttf",
					'B' => "modern_led_board-7.ttf",
					'I' => "modern_led_board-7.ttf",
					'BI' => "modern_led_board-7.ttf",
				),

				"nueva_fuente_zillmo" => array(
					'R' => "ZILLMOO_.ttf",
					'B' => "ZILLMOO_.ttf",
					'I' => "ZILLMOO_.ttf",
					'BI' => "ZILLMOO_.ttf",
				),

				"nueva_fuente_bau" => array(
					'R' => "BauhausStd-Medium.ttf",
					'B' => "BauhausStd-Medium.ttf",
					'I' => "BauhausStd-Medium.ttf",
					'BI' => "BauhausStd-Medium.ttf",
				),
			)
		);
	}

}
