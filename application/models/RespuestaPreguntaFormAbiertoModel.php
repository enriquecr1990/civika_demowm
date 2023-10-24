<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class RespuestaPreguntaFormAbiertoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('respuesta_pregunta_formulario_abierto', 'rpfa');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}
}