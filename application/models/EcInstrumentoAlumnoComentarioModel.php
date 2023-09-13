<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcInstrumentoAlumnoComentarioModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_instrumento_alumno_has_comentario','eciac');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_instrumento_alumno']) && $data['id_ec_instrumento_alumno'] != ''){
			$criterios .= " and eciac.id_ec_instrumento_alumno = ".$data['id_ec_instrumento_alumno'];
		}
		return $criterios;
	}

}
