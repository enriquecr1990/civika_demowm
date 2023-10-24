<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class CatalogoPreguntaFormAbiertoModel extends ModeloBase
{

	private $usuario;


	function __construct()
	{
		parent::__construct('pregunta_formulario_abierto', 'pfa');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
		$this->primary_key = 'id_cat_pregunta_formulario_abierto';
	}

	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = $this->obtener_query_base().' '.$this->criterios_join().' '.$this->criterios_busqueda($data).' '.$this->group_by().' '.$this->order_by().' '.$sql_limit;
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$retorno['preguntas_abiertas'] = $query->result();



			if (isset($data['usuario'])){
				$consulta_formulario_entregable = "select id_formulario_abierto, id_entregable_formulario from entregable_has_formulario where id_entregable = ".$data['id_entregable_evidencia'];
				$formulario_entregable = $this->db->query($consulta_formulario_entregable)->result();

				if ($formulario_entregable){
				  $respuestas =	$this->obtener_respuestas_alumno($formulario_entregable[0]->id_entregable_formulario, $data['usuario']->id_usuario);
				}


				foreach ($retorno['preguntas_abiertas'] as $pregunta){
					foreach ($respuestas as $respuesta){
						if ($pregunta->id_cat_pregunta_formulario_abierto == $respuesta->id_cat_pregunta_formulario_abierto){
							$pregunta->respuesta_pregunta_formulario_abierto = $respuesta->respuesta_pregunta_formulario_abierto;
						}
					}
				}


			}


			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	public function criterios_busqueda($data){
		$id_formulario = $this->existe_formulario($data);
		$criterios = ' where 1=1';
		if(isset($id_formulario) && $id_formulario != null ){
			$criterios .= " and pfa.id_formulario_abierto = ".$id_formulario;
		}
		return $criterios;
	}

	public function existe_formulario($data){
		$consulta= "select id_formulario_abierto, id_entregable_formulario from entregable_has_formulario where id_entregable = ".$data['id_entregable_evidencia'];
		$existe =  $this->db->query($consulta)->row();

		if ($existe){
			return $existe->id_formulario_abierto;
		}else{
			$this->db->insert('formulario_abierto',array(
				'nombre_formulario' => 'Formulario_entreganle_'.$data['id_entregable_evidencia'],
				'activo' => 1
			));

			$id_formulario = $this->db->insert_id();
			$this->db->insert('entregable_has_formulario',array(
				'id_entregable' => $data['id_entregable_evidencia'],
				'id_formulario_abierto' => $id_formulario,
				'liberado' => 0
			));

			return $id_formulario;
		}
	}



	public function guardar_pregunta_abierta($post,$id_formulario,$id_cat_pregunta_formulario_abierto){
		//var_dump($post, $id_cat_pregunta_formulario_abierto, $id_cat_pregunta_formulario_abierto === false); exit();
		if($id_cat_pregunta_formulario_abierto === false){
			return $this->guardar_row(array(
				'id_formulario_abierto' => $id_formulario,
				'pregunta_formulario_abierto' => $post['pregunta_formulario_abierto']));
		} else {
			return $this->actualizar_row_criterios(array('id_cat_pregunta_formulario_abierto' => $id_cat_pregunta_formulario_abierto,
				'id_formulario_abierto' => $id_formulario), array(
				'pregunta_formulario_abierto' => $post['pregunta_formulario_abierto']));
			
		}
	}

	public function guardar_respuesta_pregunta_abierta($inputs,$id_entregable_formulario, $id_usuario)
	{

		try {
			$consulta = ("select * from entregable_formulario_has_alumno where id_entregable_formulario = ".$id_entregable_formulario." and id_usuario = ". $id_usuario);

			$query = $this->db->query($consulta);
			$entregable_usuario = $query->result();

			if ($entregable_usuario){
				$this->db->where('id_entregable_formulario_alumno',$entregable_usuario[0]->id_entregable_formulario_has_alumno);
				$this->db->delete('respuesta_pregunta_formulario_abierto');

				$this->db->where('id_entregable_formulario_has_alumno',$entregable_usuario[0]->id_entregable_formulario_has_alumno);
				$this->db->delete('entregable_formulario_has_alumno');
			}


			$this->db->insert('entregable_formulario_has_alumno', array(
				'id_entregable_formulario' => $id_entregable_formulario,
				'id_usuario' => $id_usuario,
				'id_cat_proceso' => 1
			));
			$id_entregable_formulario_alumno = $this->db->insert_id();

			foreach ($inputs as  $item){
				$this->db->insert('respuesta_pregunta_formulario_abierto',array(
					'respuesta_pregunta_formulario_abierto' => $item->respuesta,
					'id_cat_pregunta_formulario_abierto' => $item->id_cat_pregunta_formulario_abierto,
					'id_entregable_formulario_alumno' => $id_entregable_formulario_alumno,
					'eliminado' => 'no'
				));
			}
			$return['success'] = true;
			$return['msg'] = 'Se guardaron las respuestas correctamente';
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}

	public function eliminar_pregunta_abierta($id){
		try{
			$this->eliminar_row($id);//eliminamos la pregunta
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function obtener_respuestas_alumno($id_entregable_formulario,$id_alumno){

		$consulta = "select pfa.id_cat_pregunta_formulario_abierto, pfa.pregunta_formulario_abierto, rpfa.respuesta_pregunta_formulario_abierto from respuesta_pregunta_formulario_abierto as rpfa ".
			"join pregunta_formulario_abierto pfa on pfa.id_cat_pregunta_formulario_abierto = rpfa.id_cat_pregunta_formulario_abierto ".
			"join entregable_formulario_has_alumno efha on efha.id_entregable_formulario_has_alumno = rpfa.id_entregable_formulario_alumno ".
			"where efha.id_entregable_formulario = ". $id_entregable_formulario ." and efha.id_usuario = ". $id_alumno;

		$query = $this->db->query($consulta);
		return $query->result();

	}

}
