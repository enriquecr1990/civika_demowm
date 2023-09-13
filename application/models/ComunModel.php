<?php
defined('BASEPATH') OR exit('No tiene access al script');

class ComunModel extends CI_Model
{

	private $usuario;

	function __construct()
	{
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function actualizar_comun($data){
		try{
			$update = array(
				$data['campo_actualizar'] => $data['campo_actualizar_valor']
			);
			$this->db->where($data['id_actualizar'],$data['id_actualizar_valor']);
			if($this->db->update($data['tabla_actualizar'],$update)){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se actualizó el campo correctamente';
			} else{
				$resultado['success'] = false;
				$resultado['msg'] = 'No fue posible actualizar el dato, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = $ex->getMessage();
		}
		return $resultado;
	}

	public function eliminar_comun($data){
		try{
			$this->db->where($data['id_eliminar'],$data['id_eliminar_valor']);
			if($this->db->delete($data['tabla_eliminar'])){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se eliminó el registro correctamente';
			} else{
				$resultado['success'] = false;
				$resultado['msg'] = 'No fue posible eliminar el dato, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = $ex->getMessage();
		}
		return $resultado;
	}

}
