<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECInstrumentoHasActividadModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_instrumento_has_actividad','ecia');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_estandar_competencia_instrumento']) && $data['id_estandar_competencia_instrumento'] != ''){
			$criterios .= " and ecia.id_estandar_competencia_instrumento = ".$data['id_estandar_competencia_instrumento'];
		}
		return $criterios;
	}

}
