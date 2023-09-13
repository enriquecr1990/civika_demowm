<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ConfigCorreoModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('config_correo','n');
	}

	public function activar_config_correo($id_config_correo){
		$this->desactivar_config_correo();
		$this->db->where('id_config_correo',$id_config_correo);
		return $this->db->update('config_correo',array('activo' => 'si'));
	}

	private function desactivar_config_correo(){
		$this->db->update('config_correo',array('activo' => 'no'));
	}

}
