<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ECUsuarioHasExpedientePEDModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_usuario_has_expediente_ped','bp');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join()
	{
		$joins = " inner join archivo a on a.id_archivo = bp.id_archivo ";
		return $joins;
	}

	public function order_by()
	{
		return " order by bp.id_cat_expediente_ped asc ";
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_cat_expediente_ped']) && $data['id_cat_expediente_ped'] != ''){
			$criterios .= " and bp.id_cat_expediente_ped = ".$data['id_cat_expediente_ped'];
		}if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and bp.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}if(isset($data['id_usuario']) && $data['id_usuario'] != ''){
			$criterios .= " and bp.id_usuario = ".$data['id_usuario'];
		}
		return $criterios;
	}

	public function guardar_archivo_expediente($data){
		try{
			$registro_existente = $this->obtener_registro_existente($data['id_estandar_competencia'],$data['id_usuario'],$data['id_cat_expediente_ped']);
			if($registro_existente){
				//update
				$this->db->where('id_ec_usuario_has_expediente_ped',$registro_existente->id_ec_usuario_has_expediente_ped);
				return $this->db->update('ec_usuario_has_expediente_ped',$data);
			}else{
				//insert
				return $this->db->insert('ec_usuario_has_expediente_ped',$data);
			}
		}catch (Exception $ex){
			//$resultado['success'] = false;
			//$resultado['msg'] = $ex->getMessage();
			return false;
		}
	}

	public function obtener_registro_existente($id_estandar_competencia,$id_usuario,$id_cat_expediente_ped = EXPEDIENTE_FICHA_REGISTRO){
		$consulta = "select 
			  * 
			from ec_usuario_has_expediente_ped euhe
			  inner join archivo a on a.id_archivo = euhe.id_archivo
			where euhe.id_estandar_competencia = $id_estandar_competencia 
			  and euhe.id_usuario = $id_usuario
			  and euhe.id_cat_expediente_ped = $id_cat_expediente_ped";
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}return $query->row();
	}

}
