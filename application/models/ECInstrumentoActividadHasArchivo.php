<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECInstrumentoActividadHasArchivo extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_instrumento_actividad_has_archivo','eciha');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_instrumento_has_actividad']) && $data['id_ec_instrumento_has_actividad'] != ''){
			$criterios .= " and eciha.id_ec_instrumento_has_actividad = ".$data['id_ec_instrumento_has_actividad'];
		}
		return $criterios;
	}

}
