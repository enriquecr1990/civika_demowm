<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ArchivoInstrumentoModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('archivo_instrumento','ai');
	}
}
