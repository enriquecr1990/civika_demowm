<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcInstrumentoAlumnoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_instrumento_alumno','ecia');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function obtener_query_base(){
		$consulta = "select 
			  * 
			from ec_instrumento_alumno ecia";
		return $consulta;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_instrumento_has_actividad']) && $data['id_ec_instrumento_has_actividad'] != ''){
			$criterios .= " and ecia.id_ec_instrumento_has_actividad = ".$data['id_ec_instrumento_has_actividad'];
		}if(isset($data['id_usuario']) && $data['id_usuario'] != ''){
			$criterios .= " and ecia.id_usuario = ".$data['id_usuario'];
		}
		return $criterios;
	}

	public function obtener_instrumentos_entrega_alumno($id_usuario_alumno,$id_estandar_competencia){
		$consulta = "select 
		  count(eiha.id_ec_instrumento_has_actividad) num_actividades_ec,
		  count(eia.id_ec_instrumento_alumno) num_actividades_ec_candidato
		from estandar_competencia_instrumento eci
		  inner join ec_instrumento_has_actividad eiha on eiha.id_estandar_competencia_instrumento = eci.id_estandar_competencia_instrumento
		  left join ec_instrumento_alumno eia on (eia.id_ec_instrumento_has_actividad = eiha.id_ec_instrumento_has_actividad and eia.id_cat_proceso = 4)
		where eci.id_estandar_competencia = $id_estandar_competencia
		  and eia.id_usuario = $id_usuario_alumno";
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

}
