<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class ArchivoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('archivo','bp');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function guardar_archivo_model($data){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al guardar el archivo en el sistema, Favor de intentar más tarde';
			$this->db->insert('archivo',$data);
			return $this->db->insert_id();
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = $ex->getMessage();
		}
		return $resultado;
	}

	public function obtener_archivo($id_archivo){
		try{
			$this->db->where('id_archivo',$id_archivo);
			$query = $this->db->get('archivo');
			return $query->row();
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = $ex->getMessage();
		}
		return $resultado;
	}

}
