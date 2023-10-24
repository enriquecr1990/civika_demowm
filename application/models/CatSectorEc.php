<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';
class CatSectorEc extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('cat_sector_ec', 'cse');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function  obtener_sectores($pagina = 1 ,$limit = 15){
		$sql_limit = " limit ".(($pagina*$limit)-$limit).",$limit";
		if($pagina == 0){
			$sql_limit = '';
		}
		$consulta = "select * from cat_sector_ec cse where activo = 1";
		$consulta .= $sql_limit;
		$query = $this->db->query($consulta);
		$data = $query->result();
		return $data;
	}
	public function  total_data(){
		$consulta = "select count(*) total_registros from cat_sector_ec cse";
		$query = $this->db->query($consulta);
		$data = $query->row()->total_registros;
		return $data;
	}
	public function  obtener_sector($id){
		$consulta = "select * from cat_sector_ec cse where cse.id_cat_sector_ec = ".$id;
		$query = $this->db->query($consulta);
		$data = $query->row();
		return $data;
	}
	public function  eliminar($id){
		try {
			$this->db->set('activo', 0);
			$this->db->where('id_cat_sector_ec', $id);
			$this->db->update('cat_sector_ec');
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}
}
