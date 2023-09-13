<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class CatMsgModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('cat_msg_bienvenida','bp');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

}
