<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECHasEvaluacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia_has_evaluacion','eche');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_evaluacion']) && $data['id_evaluacion'] != ''){
			$criterios .= " and eche.id_evaluacion = ".$data['id_evaluacion'];
		}if(isset($data['liberada']) && $data['liberada'] != ''){
			$criterios .= " and eche.liberada = '".$data['liberada']."'";
		}
		return $criterios;
	}

	public function obtener_evaluaciones_ec($id_estandar_competencia){
		$consulta = "select 
			  eche.*,e.*, ce.nombre tipo_evaluacion
			from estandar_competencia_has_evaluacion eche
			  inner join evaluacion e on e.id_evaluacion = eche.id_evaluacion
			  inner join cat_evaluacion ce on ce.id_cat_evaluacion = e.id_cat_evaluacion
			where eche.liberada = 'si'
			  and e.eliminado = 'no'
			  and eche.id_estandar_competencia = $id_estandar_competencia";
		$query = $this->db->query($consulta);
		return $query->result();
	}

	public function obtener_evaluacion_diagnostica_liberada($id_estandar_competencia){
		$consulta = "select 
			  * 
			from estandar_competencia_has_evaluacion eche
			  inner join evaluacion e on e.id_evaluacion = eche.id_evaluacion
			where e.id_cat_evaluacion = 1
			  and eche.liberada = 'si'
			  and eche.id_estandar_competencia = $id_estandar_competencia";
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

}
