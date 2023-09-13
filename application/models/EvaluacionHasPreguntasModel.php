<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EvaluacionHasPreguntasModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('evaluacion_has_preguntas','ehp');
		$this->load->model('BancoPreguntaModel');
		$this->load->model('OpcionPreguntaModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$consulta = $this->obtener_query_base().' '.$this->criterios_busqueda($data);
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$retorno['preguntas_evaluacion'] = $query->result();
			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('info',$ex->getMessage());
			return false;
		}
	}

	public function obtener_query_base(){
		$consulta = "select 
			  ehp.*,bp.pregunta,ctop.id_cat_tipo_opciones_pregunta, ctop.nombre tipo_pregunta
			from evaluacion_has_preguntas ehp
			  inner join banco_pregunta bp on bp.id_banco_pregunta = ehp.id_banco_pregunta
			  inner join cat_tipo_opciones_pregunta ctop on ctop.id_cat_tipo_opciones_pregunta = bp.id_cat_tipo_opciones_pregunta";
		return $consulta;
	}

	public function criterios_busqueda($data){
		$criterios = ' where ehp.id_evaluacion = '.$data['id_evaluacion'];
		return $criterios;
	}

	public function obtener_total_registros($data = array()){
		$consulta = "select 
				count(*) total_registros 
			from evaluacion_has_preguntas ehp 
				inner join evaluacion e on e.id_evaluacion = ehp.id_evaluacion ".$this->criterios_busqueda($data);
		$query = $this->db->query($consulta);
		return $query->row()->total_registros;
	}

	public function guardar_pregunta_opciones_evaluacion($post,$id_evaluacion,$id_banco_pregunta){
		$retorno = array();
		switch ($post['banco_pregunta']['id_cat_tipo_opciones_pregunta']){
			case OPCION_VERDADERO_FALSO:case OPCION_UNICA_OPCION:case OPCION_OPCION_MULTIPLE:case OPCION_IMAGEN_UNICA_OPCION:case OPCION_IMAGEN_OPCION_MULTIPLE:
				$retorno = $this->guardar_pregunta_opciones_vf($post,$id_evaluacion,$id_banco_pregunta);
				break;
			case OPCION_SECUENCIAL:
				$retorno = $this->guardar_publicacion_pregunta_respuesta_secuencial($post,$id_evaluacion,$id_banco_pregunta);
				break;
			case OPCION_RELACIONAL:
				$retorno = $this->guardar_publicacion_pregunta_respuesta_relacional($post,$id_evaluacion,$id_banco_pregunta);
				break;
		}
		return $retorno;
	}

	private function guardar_pregunta_opciones_vf($post,$id_evaluacion,$id_banco_pregunta){
		try{
			//guardamos el banco pregunta
			$guardar_bp = $this->BancoPreguntaModel->guardar_row($post['banco_pregunta'],$id_banco_pregunta);
			if($guardar_bp['success']){
				//guardamos las opciones de la pregunta
				$id_banco_pregunta = $guardar_bp['id'];
				//eliminamos las opciones de la pregunta registrados
				$eliminar_opciones = $this->OpcionPreguntaModel->eliminar_row_criterios(array('id_banco_pregunta' => $id_banco_pregunta));
				if($eliminar_opciones){
					//guardamos las opciones de la pregunta
					foreach ($post['opcion_pregunta'] as $op){
						$op['id_banco_pregunta'] = $id_banco_pregunta;
						$this->OpcionPreguntaModel->guardar_row($op);
					}
					//guardamos la evaluacion has preguntas
					$this->evaluacion_has_preguntas($id_evaluacion,$id_banco_pregunta);
				}
				$response['success'] = true;
				$response['msg'] = 'Se guardo la pregunta con sus respectivas opciones de la evaluación';
			}else{
				$response['success'] = false;
				$response['msg'] = $guardar_bp['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Ocurrio un error al guardar la pregunta con sus respectivas opciones';
			$response['msg'][] = $ex->getMessage();
		}
		return $response;
	}

	private function guardar_publicacion_pregunta_respuesta_secuencial($post,$id_evaluacion,$id_banco_pregunta){
		try{
			//guardamos el banco pregunta
			$guardar_bp = $this->BancoPreguntaModel->guardar_row($post['banco_pregunta'],$id_banco_pregunta);
			if($guardar_bp['success']){
				//guardamos las opciones de la pregunta
				$id_banco_pregunta = $guardar_bp['id'];
				//eliminamos las opciones de la pregunta registrados
				$eliminar_opciones = $this->OpcionPreguntaModel->eliminar_row_criterios(array('id_banco_pregunta' => $id_banco_pregunta));
				if($eliminar_opciones){
					//guardamos las opciones de la pregunta
					foreach ($post['opcion_pregunta'] as $index => $op){
						$op['id_banco_pregunta'] = $id_banco_pregunta;
						$op['consecutivo'] = $index + 1;
						$op['tipo_respuesta'] = 'correcta';
						$op['id_archivo'] = isset($op['id_archivo']) && $op['id_archivo'] != '' ? $op['id_archivo'] : null;
						$this->OpcionPreguntaModel->guardar_row($op);
					}
					//guardamos la evaluacion has preguntas
					$this->evaluacion_has_preguntas($id_evaluacion,$id_banco_pregunta);
				}
				$response['success'] = true;
				$response['msg'] = 'Se guardo la pregunta con sus respectivas opciones de la evaluación';
			}else{
				$response['success'] = false;
				$response['msg'] = $guardar_bp['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Ocurrio un error al guardar la pregunta con sus respectivas opciones';
			$response['msg'][] = $ex->getMessage();
		}
		return $response;
	}

	private function guardar_publicacion_pregunta_respuesta_relacional($post,$id_evaluacion,$id_banco_pregunta){
		try{
			//guardamos el banco pregunta
			$guardar_bp = $this->BancoPreguntaModel->guardar_row($post['banco_pregunta'],$id_banco_pregunta);
			if($guardar_bp['success']){
				//guardamos las opciones de la pregunta
				$id_banco_pregunta = $guardar_bp['id'];
				//eliminamos las opciones de la pregunta registrados
				$eliminar_opciones = $this->OpcionPreguntaModel->eliminar_row_criterios(array('id_banco_pregunta' => $id_banco_pregunta));
				if($eliminar_opciones){
					//guardamos las opciones de la pregunta
					$index = 1;
					foreach ($post['opcion_pregunta']['izquierda'] as $op){//insertar preguntas de lado izquierdo
						$op['id_banco_pregunta'] = $id_banco_pregunta;
						$op['consecutivo'] = $index;
						$op['tipo_respuesta'] = 'correcta';
						$op['pregunta_relacional'] = 'izquierda';
						$op['id_archivo'] = isset($op['id_archivo']) && $op['id_archivo'] != '' ? $op['id_archivo'] : null;
						$this->OpcionPreguntaModel->guardar_row($op);
						$index++;
					}
					$index = 1;
					foreach ($post['opcion_pregunta']['derecha'] as $op){//insertar preguntas de lado derecho
						$op['id_banco_pregunta'] = $id_banco_pregunta;
						$op['consecutivo'] = $index;
						$op['tipo_respuesta'] = 'correcta';
						$op['pregunta_relacional'] = 'derecha';
						$op['id_archivo'] = isset($op['id_archivo']) && $op['id_archivo'] != '' ? $op['id_archivo'] : null;
						$this->OpcionPreguntaModel->guardar_row($op);
						$index++;
					}
					//guardamos la evaluacion has preguntas
					$this->evaluacion_has_preguntas($id_evaluacion,$id_banco_pregunta);
				}
				$response['success'] = true;
				$response['msg'] = 'Se guardo la pregunta con sus respectivas opciones de la evaluación';
			}else{
				$response['success'] = false;
				$response['msg'] = $guardar_bp['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Ocurrio un error al guardar la pregunta con sus respectivas opciones';
			$response['msg'][] = $ex->getMessage();
		}
		return $response;
	}

	private function evaluacion_has_preguntas($id_evaluacion,$id_banco_pregunta){
		$this->db->where('id_evaluacion',$id_evaluacion);
		$this->db->where('id_banco_pregunta',$id_banco_pregunta);
		$query = $this->db->get('evaluacion_has_preguntas');
		if($query->num_rows() == 0){
			return $this->guardar_row(array('id_evaluacion' => $id_evaluacion,'id_banco_pregunta' => $id_banco_pregunta));
		}return true;
	}

}
