<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';
class DatosEmpresaModel extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('datos_empresa', 'de');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function actualizar_vigente($id_usuario){
		$this->db->where('id_usuario',$id_usuario);
		return $this->db->update('datos_empresa',array('vigente' => 'no'));
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_usuario']) && $data['id_usuario'] != ''){
			$criterios .= " and de.id_usuario = ".$data['id_usuario'];
		}
		return $criterios;
	}


}
