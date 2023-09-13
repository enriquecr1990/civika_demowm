<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasECProgresoModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('usuario_has_ec_progreso','uecp');
	}

	public function criterios_busqueda($data)
	{
		$criterios = ' where 1=1';
		if(isset($data['id_usuario_has_estandar_competencia']) && $data['id_usuario_has_estandar_competencia'] != ''){
			$criterios .= " and uecp.id_usuario_has_estandar_competencia = ".$data['id_usuario_has_estandar_competencia'];
		}if(isset($data['numero_paso']) && $data['numero_paso'] != ''){
			$criterios .= " and uecp.numero_paso = ".$data['numero_paso'];
		}
		return $criterios;
	}
}
