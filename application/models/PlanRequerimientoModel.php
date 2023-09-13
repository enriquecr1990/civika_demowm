<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class PlanRequerimientoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia_has_requerimientos','echr');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and echr.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}
		return $criterios;
	}

	public function guardar_registros($data,$id_estandar_competencia){
		try{
			$this->eliminar_requerimientos_ec($id_estandar_competencia);
			foreach ($data['requerimientos'] as $r){
				$r['id_estandar_competencia'] = $id_estandar_competencia;
				$this->db->insert('estandar_competencia_has_requerimientos',$r);
			}
			$resultado['success'] = true;
			$resultado['msg'] = 'Se guardaron los registros del plan de requerimientos';
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = $ex->getMessage();
		}
		return $resultado;
	}

	private function eliminar_requerimientos_ec($id_estandar_competencia){
		$this->db->where('id_estandar_competencia',$id_estandar_competencia);
		return $this->db->delete('estandar_competencia_has_requerimientos');
	}

}
