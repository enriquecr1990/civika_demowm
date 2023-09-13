<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECInstrumentoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia_instrumento','eci');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}


}
