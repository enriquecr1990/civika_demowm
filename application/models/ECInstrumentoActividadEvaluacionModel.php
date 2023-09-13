<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECInstrumentoActividadEvaluacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_instrumento_actividad_evaluacion','eciae');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_evaluacion']) && $data['id_evaluacion'] != ''){
			$criterios .= " and eciae.id_evaluacion = ".$data['id_evaluacion'];
		}if(isset($data['id_ec_instrumento_has_actividad']) && $data['id_ec_instrumento_has_actividad'] != ''){
			$criterios .= " and eciae.id_ec_instrumento_has_actividad = ".$data['id_ec_instrumento_has_actividad'];
		}if(isset($data['liberada']) && $data['liberada'] != ''){
			$criterios .= " and eciae.liberada = '".$data['liberada']."'";
		}
		return $criterios;
	}

	public function actualizar($data,$id){
		$this->db->where('id',$id);
		return $this->db->update('ec_instrumento_actividad_evaluacion',$data);
	}

	public function obtener_row($id_primary){
		$this->db->where('id',$id_primary);
		$query = $this->db->get('ec_instrumento_actividad_evaluacion');
		return $query->row();
	}

}
