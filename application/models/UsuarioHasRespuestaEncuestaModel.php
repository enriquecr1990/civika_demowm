<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasRespuestaEncuestaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario_has_respuesta_encuesta','uhre');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join()
	{
		return ' inner join cat_preguntas_encuesta cpe on uhre.id_cat_preguntas_encuesta = cpe.id_cat_preguntas_encuesta ';
	}

}
