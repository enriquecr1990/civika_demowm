<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EvaluacionRespuestasUsuarioModel extends ModeloBase
{

	private $usuario;
	private $aciertosCandidato;
	private $preguntasEvaluacion;

	function __construct()
	{
		parent::__construct('evaluacion_respuestas_usuario','eru');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
		$this->load->model('ECHasEvaluacionModel');
		$this->load->model('EvaluacionHasPreguntasModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function obtener_respuesta_usuario($id_banco_pregunta,$id_usuario_has_evaluacion_realizada){
		$this->db->where('id_banco_pregunta',$id_banco_pregunta);
		//$this->db->where('id_usuario',$id_usuario);
		$this->db->where('id_usuario_has_evaluacion_realizada',$id_usuario_has_evaluacion_realizada);
		$query = $this->db->get('evaluacion_respuestas_usuario');
		$respuesta = $query->result();
		$retorno = array();
		foreach ($respuesta as $r){
			$retorno[] = $r->orden_relacion_respuesta != null && $r->orden_relacion_respuesta != '' ? $r->orden_relacion_respuesta : $r->id_opcion_respuesta;
		}
		return $retorno;
	}



	public function guardar_respuestas_evaluacion_diagnostica($post){
		try{
			return $this->guardar_respuestas_candidato($post);
		}catch (Exception $ex){
			return false;
		}
	}

	public function guardar_respuestas_evaluacion_instrumento($post){
		try{
			return $this->guardar_respuestas_candidato($post);
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_calificacion_evaluacion($id_usuario_has_evaluacion_realizada,$id_evaluacion){
		try{
			$respuestas_candidato = $this->obtener_respuestas_candidato($id_usuario_has_evaluacion_realizada);
			$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->obtener_row($id_usuario_has_evaluacion_realizada);
			$ec_has_evaluacion = $this->ECHasEvaluacionModel->obtener_row($usuario_has_evaluacion_realizada->id_estandar_competencia_has_evaluacion);
			$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $id_evaluacion));
			$preguntas_correctas = 0;
			foreach ($respuestas_candidato as $pregunta){
				$pregunta->correctas_alumno == $pregunta->numero_opciones_correctas && $pregunta->incorrectas_alumno == 0 ? $preguntas_correctas++ : false;
			}
			$this->preguntasEvaluacion = sizeof($evaluacion_preguntas['preguntas_evaluacion']);
			$this->aciertosCandidato = $preguntas_correctas;
			$calificacion = ($preguntas_correctas / sizeof($evaluacion_preguntas['preguntas_evaluacion'])) * 100;
			return number_format($calificacion,2);
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_calificacion_evaluacion_instrumento($id_usuario_has_evaluacion_realizada){
		try{
			$this->load->model('ECInstrumentoActividadEvaluacionModel');
			$respuestas_candidato = $this->obtener_respuestas_candidato($id_usuario_has_evaluacion_realizada);
			$usuario_has_evaluacion_realizada = $this->UsuarioHasEvaluacionRealizadaModel->obtener_row($id_usuario_has_evaluacion_realizada);
			$ec_instrumento_actividad_evaluacion = $this->ECInstrumentoActividadEvaluacionModel->obtener_row($usuario_has_evaluacion_realizada->id_ec_instrumento_actividad_evaluacion);
			$evaluacion_preguntas = $this->EvaluacionHasPreguntasModel->tablero(array('id_evaluacion' => $ec_instrumento_actividad_evaluacion->id_evaluacion));
			$preguntas_correctas = 0;
			foreach ($respuestas_candidato as $pregunta){
				$pregunta->correctas_alumno == $pregunta->numero_opciones_correctas && $pregunta->incorrectas_alumno == 0 ? $preguntas_correctas++ : false;
			}
			$calificacion = ($preguntas_correctas / sizeof($evaluacion_preguntas['preguntas_evaluacion'])) * 100;
			return number_format($calificacion,2);
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_respuestas_candidato($id_usuario_has_evaluacion){
		$consulta = "select 
				  eru.id_evaluacion_respuestas_usuario,
				  eru.id_banco_pregunta,
				  sum(
					if(
					  if(bp.id_cat_tipo_opciones_pregunta in(".OPCION_SECUENCIAL.",".OPCION_RELACIONAL."),
						if(op.orden_pregunta = eru.orden_relacion_respuesta,'correcta','incorrecta'),
						op.tipo_respuesta
					  ) = 'correcta',1,0
					)
				  )correctas_alumno,
				  sum(
					if(
					  if(bp.id_cat_tipo_opciones_pregunta in(".OPCION_SECUENCIAL.",".OPCION_RELACIONAL."),
						if(op.orden_pregunta = eru.orden_relacion_respuesta,'correcta','incorrecta'),
						op.tipo_respuesta
					  ) = 'incorrecta',1,0
					)
				  )incorrectas_alumno,
				  (
					select 
					  if(bp.id_cat_tipo_opciones_pregunta <> ".OPCION_RELACIONAL.", count(opp.id_opcion_pregunta),cast(count(opp.id_opcion_pregunta)/2 as SIGNED)) 
					from opcion_pregunta opp 
					  where opp.id_banco_pregunta = bp.id_banco_pregunta 
						and opp.tipo_respuesta = 'correcta'
				  )numero_opciones_correctas
				from evaluacion_respuestas_usuario eru
				  inner join banco_pregunta bp on bp.id_banco_pregunta = eru.id_banco_pregunta
				  inner join opcion_pregunta op on op.id_opcion_pregunta = eru.id_opcion_respuesta
				where eru.id_usuario_has_evaluacion_realizada = $id_usuario_has_evaluacion
				  group by bp.id_banco_pregunta
				  order by eru.id_evaluacion_respuestas_usuario";
		$query = $this->db->query($consulta);
		return $query->result();
	}

	private function eliminar_respuestas_candidato($id_usuario_has_evaluacion_realizada){
		$this->db->where('id_usuario_has_evaluacion_realizada',$id_usuario_has_evaluacion_realizada);
		return $this->db->delete('evaluacion_respuestas_usuario');
	}

	private function guardar_respuestas_candidato($post){
		try{
			//almacenamos las respuestas del alumno de las preguntas
			if(isset($post['pregunta']) && sizeof($post['pregunta']) != 0){
				$this->eliminar_respuestas_candidato($post['id_usuario_has_evaluacion_realizada']);
				foreach ($post['pregunta'] as $id_banco_pregunta => $respuestas){
					//$insert['id_usuario'] = $this->usuario->id_usuario;
					$insert['id_usuario_has_evaluacion_realizada'] = $post['id_usuario_has_evaluacion_realizada'];
					$insert['id_banco_pregunta'] = $id_banco_pregunta;
					//insertamos las respuestas
					foreach ($respuestas as $tipo_respuesta => $respuesta){
						switch ($tipo_respuesta){
							//opcion de unica opcion para los casos de solo radio
							case OPCION_VERDADERO_FALSO:case OPCION_UNICA_OPCION:case OPCION_IMAGEN_UNICA_OPCION:
							$insert['id_opcion_respuesta'] = $respuesta;
							$this->insertar($insert);
							break;
							//opcion de opcion multiple para los casos de checks
							case OPCION_OPCION_MULTIPLE:case OPCION_IMAGEN_OPCION_MULTIPLE:
							foreach ($respuesta as $r){
								$insert['id_opcion_respuesta'] = $r;
								$this->insertar($insert);
							}
							break;
							//opcion para la de ordenar cronologicamente && opcion para la de relacionar preguntas
							case OPCION_SECUENCIAL:case OPCION_RELACIONAL:
							foreach ($respuesta as $id_opcion_respuesta => $r){
								$insert['id_opcion_respuesta'] = $id_opcion_respuesta;
								$insert['orden_relacion_respuesta'] = $r;
								$this->insertar($insert);
							}
							break;
						}
					}
				}
			}
			$update_evaluacion_realizada = array(
				'enviada' => 'si',
				'fecha_enviada' => date('Y-m-d H:i:s')
			);
			return $this->UsuarioHasEvaluacionRealizadaModel->actualizar($update_evaluacion_realizada,$post['id_usuario_has_evaluacion_realizada']);
		}catch (Exception $ex){
			return false;
		}
	}

}
