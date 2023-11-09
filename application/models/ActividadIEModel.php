<?php
defined('BASEPATH') OR exit('No tiene access al script');

class ActividadIEModel extends CI_Model
{

	private $evaluacion_instrumento;

	function __construct()
	{
		$this->evaluacion_instrumento = true;
		$this->load->model('ECInstrumentoHasActividadModel');
		$this->load->model('ECInstrumentoActividadEvaluacionModel');
		$this->load->model('EcInstrumentoAlumnoEvidenciasModel');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
	}

	public function obtener_instrumentos_ec($id_estandar_competencia){
		try{
			$consulta = "select 
				  eci.*,ci.nombre
				from estandar_competencia_instrumento eci
				  inner join cat_instrumento ci on ci.id_cat_instrumento = eci.id_cat_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia";
			$query = $this->db->query($consulta);
			$result = $query->result();
			foreach ($result as $r){
				$r->actividades = $this->obtener_actividades_instrumento($id_estandar_competencia,$r->id_cat_instrumento);
			}
			return $result;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'] = 'No fue posible guardar la actividad e instrumentos de evaluación';
		}
		return $response;
	}

	public function obtener_instrumentos_ec_alumno($id_estandar_competencia,$id_usuario_alumno = false){
		try{
			$consulta = "select 
				  eci.*,ci.nombre
				from estandar_competencia_instrumento eci
				  inner join cat_instrumento ci on ci.id_cat_instrumento = eci.id_cat_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia";
			$query = $this->db->query($consulta);
			$result = $query->result();
			foreach ($result as $r){
				$r->actividades = $this->obtener_actividades_instrumento($id_estandar_competencia,$r->id_cat_instrumento,$id_usuario_alumno);
			}
			return $result;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'] = 'No fue posible guardar la actividad e instrumentos de evaluación';
		}
		return $response;
	}

	public function obtener_actividades_instrumento($id_estandar_competencia,$id_cat_instrumento,$id_usuario_alumno = false){
		try{

			if($id_usuario_alumno){
				$consulta = "select 
       				eiha.id_ec_instrumento_has_actividad, eiha.actividad, 
       				eci.id_cat_instrumento,
       				eiha.instrucciones, eia.id_ec_instrumento_alumno, eia.id_cat_proceso, eia.fecha_carga_archivo, eia.intentos_adicionales 
				from ec_instrumento_has_actividad eiha
					inner join estandar_competencia_instrumento eci on eci.id_estandar_competencia_instrumento = eiha.id_estandar_competencia_instrumento
				  	left join ec_instrumento_alumno eia on eia.id_ec_instrumento_has_actividad = eiha.id_ec_instrumento_has_actividad
				where eci.id_estandar_competencia = $id_estandar_competencia and eci.id_cat_instrumento = $id_cat_instrumento and eia.id_usuario = $id_usuario_alumno";
				$query = $this->db->query($consulta);
				$result = $query->result();
				foreach ($result as $r){
					$r->archivos_videos = $this->obtener_archivos_videos($r->id_ec_instrumento_has_actividad);
					switch ($r->id_cat_instrumento){
						case INSTRUMENTO_GUIA_OBSERVACION:case INSTRUMENTO_LISTA_COTEJO:
							$r->alumno_evidencias = $this->obtener_archivos_instrumento_candidato($r->id_ec_instrumento_alumno);
							break;
						case INSTRUMENTO_CUESTIONARIO:
							$buscar_evaluacion_instrumento = array(
								'id_ec_instrumento_has_actividad' => $r->id_ec_instrumento_has_actividad,
								'liberada' => 'si'
							);
							$evaluacion_instrumento = $this->ECInstrumentoActividadEvaluacionModel->tablero($buscar_evaluacion_instrumento,0);
							if($evaluacion_instrumento['total_registros'] != 0){
								$r->evaluacion_instrumento = $evaluacion_instrumento['ec_instrumento_actividad_evaluacion'][0];
								//para determinar que evaluacion ya realizó
								$usuario_has_evaluacion_instrumento = $this->UsuarioHasEvaluacionRealizadaModel->tablero(array('id_ec_instrumento_actividad_evaluacion' => $r->evaluacion_instrumento->id,'enviada' => 'si'), 0);
								$r->instrumento_actividad_evaluacion = array();
								if($usuario_has_evaluacion_instrumento['total_registros'] != 0){
									$r->instrumento_actividad_evaluacion = $usuario_has_evaluacion_instrumento['usuario_has_evaluacion_realizada'];
								}
							}
							break;
					}
				}
			}else{
				$consulta = "select 
				  	eiha.*, 
					eci.id_cat_instrumento
				from ec_instrumento_has_actividad eiha
				  inner join estandar_competencia_instrumento eci on eci.id_estandar_competencia_instrumento = eiha.id_estandar_competencia_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia and eci.id_cat_instrumento = $id_cat_instrumento";
				$query = $this->db->query($consulta);
				$result = $query->result();
				foreach ($result as $r){
					$r->archivos_videos = $this->obtener_archivos_videos($r->id_ec_instrumento_has_actividad);
					//se comenta para que no valide lo de los cuestionario dado que no van aqui alimentados en la nueva version
					// switch ($r->id_cat_instrumento){
					// 	case INSTRUMENTO_CUESTIONARIO:
					// 		$buscar_evaluacion_instrumento = array(
					// 			'id_ec_instrumento_has_actividad' => $r->id_ec_instrumento_has_actividad,
					// 			'liberada' => 'si'
					// 		);
					// 		$evaluacion_instrumento = $this->ECInstrumentoActividadEvaluacionModel->tablero($buscar_evaluacion_instrumento,0);
					// 		if($evaluacion_instrumento['total_registros'] == 0){
					// 			$this->evaluacion_instrumento = false;
					// 		}
					// 		break;
					// }
				}
			}
			return $result;
		}catch (Exception $ex){
			return false;
		}
	}

	public function getEvaluacionInstrumento(){
		return $this->evaluacion_instrumento;
	}

	public function guardar_ati($post,$id_estandar_competencia){
		try{
			//validamos si ya existe un instrumento de ese estandar
			$id_estandar_competencia_instrumento = $this->obtener_estandar_competencia_instrumento_id($id_estandar_competencia,$post['id_cat_instrumento']);
			//guardamos el estandar instrumento
			$id_ec_instrumento_has_actividad = isset($post['id_ec_instrumento_has_actividad']) ? $post['id_ec_instrumento_has_actividad'] : '';
			if($id_ec_instrumento_has_actividad == ''){
				$post['instrumento_actividad']['id_estandar_competencia_instrumento'] = $id_estandar_competencia_instrumento;
				$id_ec_instrumento_has_actividad = $this->guardar_actividad_ec_nuevo($post['instrumento_actividad']);
			}else{
				//dejaremos como regla de negocio no poder cambiar de instrumento
				$this->actualizar_actividad_ec($post['instrumento_actividad'],$id_ec_instrumento_has_actividad);
			}
			//guardamos los archivos o videos cargados (los manejaremos como opcionales)
			$this->eliminar_archivo_video_instrumento($id_ec_instrumento_has_actividad);
			if(isset($post['archivo_video']) && is_array($post['archivo_video']) && sizeof($post['archivo_video']) != 0){
				foreach ($post['archivo_video'] as $av){
					$av['id_ec_instrumento_has_actividad'] = $id_ec_instrumento_has_actividad;
					$this->insertar_archivo_video_instrumento($av);
				}
			}
			$response['success'] = true;
			$response['msg'] = 'Se guardaron las actividades e instrumentos de evaluación';
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'] = 'No fue posible guardar la actividad e instrumentos de evaluación';
		}
		return $response;
	}

	public function obtener_ec_instrumento_alumno($id_estandar_competencia){
		try{
			$consulta = "select 
				  ecia.* 
				from ec_instrumento_alumno ecia
				  inner join ec_instrumento_has_actividad eciha on eciha.id_ec_instrumento_has_actividad = ecia.id_ec_instrumento_has_actividad
				  inner join estandar_competencia_instrumento eci on eci.id_estandar_competencia_instrumento = eciha.id_estandar_competencia_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia;";
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'] = 'No fue posible guardar la actividad e instrumentos de evaluación';
		}
		return $response;
	}

	public function guardar_instrumento_nuevo($nombre){
		$this->db->insert('cat_instrumento',array('nombre' => $nombre));
		return $this->db->insert_id();
	}

	public function guardar_actividad_ec_nuevo($insert){
		$this->db->insert('ec_instrumento_has_actividad',$insert);
		return $this->db->insert_id();
	}

	public function actualizar_actividad_ec($update,$id){
		$this->db->where('id_ec_instrumento_has_actividad',$id);
		$this->db->update('ec_instrumento_has_actividad',$update);
	}

	public function eliminar_ec_ati($id_ec_instrumento_has_actividad){
		try{
			$this->eliminar_archivo_video_instrumento($id_ec_instrumento_has_actividad);//eliminamos los archivos y/o videos del instrumento
			$this->eliminar_ec_instrumento_evaluacion($id_ec_instrumento_has_actividad);//eliminamos la evaluacion del instrumento
			return $this->eliminar_ec_instrumento_has_actividades($id_ec_instrumento_has_actividad);//Eliminamos el instrumento has actividad
		}catch (Exception $ex){
			return false;
		}
	}

	public function insertar_archivo_video_instrumento($insert){
		$this->db->insert('ec_instrumento_actividad_has_archivo',$insert);
		return $this->db->insert_id();
	}

	public function eliminar_archivo_video_instrumento($id_ec_instrumento_has_actividad){
		$this->db->where('id_ec_instrumento_has_actividad',$id_ec_instrumento_has_actividad);
		return $this->db->delete('ec_instrumento_actividad_has_archivo');
	}

	public function instrumentos_ec_entregados_candidato($id_estandar_competencia, $id_usuario_alumno){
		try{
			$consulta_instrumentos = "select 
				  count(*) num_entregables_ati
				from estandar_competencia_instrumento eci
				  inner join ec_instrumento_has_actividad eciha on eciha.id_estandar_competencia_instrumento = eci.id_estandar_competencia_instrumento
				where eci.id_estandar_competencia = $id_estandar_competencia";
			$query = $this->db->query($consulta_instrumentos);
			$instrumentos_ec = $query->row();
			$consulta_instrumentos_candidato = "select 
				  count(*) num_entregables_ati_candidato
				from estandar_competencia_instrumento eci
				  inner join ec_instrumento_has_actividad eciha on eciha.id_estandar_competencia_instrumento = eci.id_estandar_competencia_instrumento
				  inner join ec_instrumento_alumno ecia on ecia.id_ec_instrumento_has_actividad = eciha.id_ec_instrumento_has_actividad
				where eci.id_estandar_competencia = $id_estandar_competencia
				  and ecia.id_usuario = $id_usuario_alumno
				  and ecia.id_cat_proceso = ".ESTATUS_FINALIZADA;
			$query = $this->db->query($consulta_instrumentos_candidato);
			$instrumentos_ec_candidato = $query->row();
			$data['instrumentos_ec'] = $instrumentos_ec;
			$data['instrumentos_ec_candidato'] = $instrumentos_ec_candidato;
			return $data;
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_archivos_videos($id_ec_instrumento_has_actividad){
		$consulta = "select 
				eiaha.*,a.nombre nombre_archivo,concat(a.ruta_directorio,a.nombre) archivo
			from ec_instrumento_actividad_has_archivo eiaha 
				left join archivo a on a.id_archivo = eiaha.id_archivo
			where eiaha.id_ec_instrumento_has_actividad = $id_ec_instrumento_has_actividad";
		$query = $this->db->query($consulta);
		return $query->result();
	}

	public function obtener_archivos_instrumento_candidato($id_ec_instrumento_alumno){
		$resultados = $this->EcInstrumentoAlumnoEvidenciasModel->tablero(array('id_ec_instrumento_alumno' => $id_ec_instrumento_alumno),0);
		$retorno = array();
		if($resultados['total_registros'] != 0){
			$retorno = $resultados['ec_instrumento_alumno_evidencias'];
		}
		return $retorno;
	}

	/**
	 * apartado de funcioens privadas al model de ActividadIEModel
	 */

	private function obtener_estandar_competencia_instrumento_id($id_estandar_competencia,$id_cat_instrumento){
		$ec_instrumento = $this->get_estandar_competencia_instrumento($id_estandar_competencia,$id_cat_instrumento);
		if(!is_object($ec_instrumento)){
			return $this->insert_estandar_competencia_instrumento($id_estandar_competencia,$id_cat_instrumento);
		}return $ec_instrumento->id_estandar_competencia_instrumento;
	}

	private function get_estandar_competencia_instrumento($id_estandar_competencia,$id_cat_instrumento){
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		$this->db->where('id_cat_instrumento',$id_cat_instrumento);
		$query = $this->db->get('estandar_competencia_instrumento');
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

	private function insert_estandar_competencia_instrumento($id_estandar_competencia,$id_cat_instrumento){
		$this->db->insert('estandar_competencia_instrumento',array('id_estandar_competencia' => $id_estandar_competencia, 'id_cat_instrumento' => $id_cat_instrumento));
		return $this->db->insert_id();
	}

	private function eliminar_ec_instrumento_has_actividades($id_ec_instrumento_has_actividad){
		$this->db->where('id_ec_instrumento_has_actividad',$id_ec_instrumento_has_actividad);
		return $this->db->delete('ec_instrumento_has_actividad');
	}

	private function eliminar_ec_instrumento_evaluacion($id_ec_instrumento_has_actividad){
		$this->db->where('id_ec_instrumento_has_actividad',$id_ec_instrumento_has_actividad);
		return $this->db->delete('ec_instrumento_actividad_evaluacion');
	}

	private function eliminar_estancar_competencia_instrumento($id_estandar_competencia,$id_cat_instrumento){
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		$this->db->where('id_cat_instrumento',$id_cat_instrumento);
		return $this->db->delete('estandar_competencia_instrumento');
	}

	public function obtener_instrumentos_ec_entregable($id_estandar_competencia){

		$consulta = 'select eiha.* from ec_instrumento_has_actividad eiha
	    				join estandar_competencia_instrumento eci on eiha.id_estandar_competencia_instrumento = eci.id_estandar_competencia_instrumento 
	              		where eci.id_estandar_competencia  = '.$id_estandar_competencia;


		$query = $this->db->query($consulta);
		return $query->result();
	}




}
