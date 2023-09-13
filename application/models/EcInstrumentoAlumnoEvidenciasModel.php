<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcInstrumentoAlumnoEvidenciasModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('ec_instrumento_alumno_evidencias','eiae');
	}

	public function obtener_query_base()
	{
		$query_base = "select 
       			eiae.*, ai.nombre,ai.ruta_directorio 
			from ec_instrumento_alumno_evidencias eiae
				left join archivo_instrumento ai on ai.id_archivo_instrumento = eiae.id_archivo_instrumento";
		return $query_base;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_instrumento_alumno']) && $data['id_ec_instrumento_alumno'] != ''){
			$criterios .= " and eiae.id_ec_instrumento_alumno = ".$data['id_ec_instrumento_alumno'];
		}
		return $criterios;
	}

}
