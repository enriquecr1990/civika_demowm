<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EvaluacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('evaluacion','e');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function guardar_estandar_competencia_evaluacion($id_estandar_competencia,$id_evaluacion){
		try{
			$insert = array(
				'id_estandar_competencia' => $id_estandar_competencia,
				'id_evaluacion' => $id_evaluacion
			);
			return $this->db->insert('estandar_competencia_has_evaluacion',$insert);
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_query_base(){
		$consulta = "select 
				ce.nombre cat_evaluacion, 
				eche.id_estandar_competencia_has_evaluacion, eche.liberada liberada_ec, eche.fecha_liberacion fecha_liberacion_ec,
				eiae.id id_ec_instrumento_actividad_evaluacion, eiae.liberada liberada_instrumento, eiae.fecha_liberacion fecha_liberacion_instrumento,
				e.*
			from evaluacion e
				inner join cat_evaluacion ce on ce.id_cat_evaluacion = e.id_cat_evaluacion 
				left join estandar_competencia_has_evaluacion eche on e.id_evaluacion = eche.id_evaluacion 
				left join ec_instrumento_actividad_evaluacion eiae ON e.id_evaluacion = eiae.id_evaluacion";
		return $consulta;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and eche.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}if(isset($data['id_ec_instrumento_has_actividad']) && $data['id_ec_instrumento_has_actividad'] != ''){
			$criterios .= " and eiae.id_ec_instrumento_has_actividad = ".$data['id_ec_instrumento_has_actividad'];
		}if(isset($data['id_cat_evaluacion']) && $data['id_cat_evaluacion'] != ''){
			$criterios .= " and e.id_cat_evaluacion = ".$data['id_cat_evaluacion'];
		}if(isset($this->usuario->perfil) && $this->usuario->perfil <> 'root'){
			$criterios .= " and e.eliminado = 'no'";
		}
		return $criterios;
	}

	public function obtener_total_registros($data = array()){
		$consulta = "select 
				count(*) total_registros 
			from evaluacion e
				left join estandar_competencia_has_evaluacion eche on eche.id_evaluacion = e.id_evaluacion 
				left join ec_instrumento_actividad_evaluacion eiae on eiae.id_evaluacion = e.id_evaluacion ".$this->criterios_busqueda($data);
		$query = $this->db->query($consulta);
		return $query->row()->total_registros;
	}

}
