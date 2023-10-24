<?php
defined('BASEPATH') OR exit('No tiene access al script');

class ModeloBase extends CI_Model
{

	private $table;
	private $alias;
	protected $primary_key;
	private $criterios;

	function __construct($table,$alias)
	{
		$this->table = $table;
		$this->alias = $alias;
		$this->primary_key = 'id_'.$table;
		$this->criterios = '';
	}
 
	public function criterios_busqueda($data){
		return '';
	}

	public function order_by(){
		return '';
	}

	public function criterios_join(){
		return '';
	}

	public function group_by(){
		return '';
	}

	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = $this->obtener_query_base().' '.$this->criterios_join().' '.$this->criterios_busqueda($data).' '.$this->group_by().' '.$this->order_by().' '.$sql_limit;
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$retorno[$this->table] = $query->result();
			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	public function obtener_row($id_primary){
		$this->db->where($this->primary_key,$id_primary);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	public function guardar_row($data,$id = false){
		try{
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
			if($id !== false){
				if($this->actualizar($data,$id)){
					$return['success'] = true;
					$return['msg'] = 'Se actualizó el registro con exito';
					$return['id'] = $id;
				}
			}else{
				$insertar_id = $this->insertar($data);
				if($insertar_id){
					$return['success'] = true;
					$return['msg'] = 'Se guardo el nuevo registro con exito';
					$return['id'] = $insertar_id;
				}
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function actualizar_row_criterios($criterios,$valores){
		try{
			foreach ($criterios as $campo => $valor){
				$this->db->where($campo,$valor);
			}
			$return['sucess'] = false;
			$return['msg'] = 'No fue posible eliminar el registro por criterios';
			if($this->db->update($this->table,$valores)){
				$return['success'] = true;
				$return['msg'] = 'Se actualizó el registro por criterios';
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function eliminar_row($id){
		try{
			if($this->actualizar(array('eliminado' => 'si'),$id)){
				$return['success'] = true;
				$return['msg'] = 'Se eliminó el registro con exito';
			}else{
				$return['success'] = true;
				$return['msg'] = 'No fue posible eliminar el registro, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function eliminar_row_criterios($criterios){
		try{
			foreach ($criterios as $campo => $valor){
				$this->db->where($campo,$valor);
			}
			$return['sucess'] = false;
			$return['msg'] = 'No fue posible eliminar el registro por criterios';
			if($this->db->delete($this->table)){
				$return['success'] = true;
				$return['msg'] = 'Se elimino el registro por criterios';
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function deseliminar_row($id){
		try{
			if($this->actualizar(array('eliminado' => 'no'),$id)){
				$return['success'] = true;
				$return['msg'] = 'Se deseliminó el registro con exito';
			}else{
				$return['success'] = true;
				$return['msg'] = 'No fue posible deseliminar el registro, favor de intentar más tarde';
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function obtener_query_base(){
		$consulta = "select * from ".$this->table." ".$this->alias;
		return $consulta;
	}

	public function obtener_total_registros($data = array()){
		$consulta = "select count(*) total_registros from ".$this->table . ' '. $this->alias . $this->criterios_join() . $this->criterios_busqueda($data).$this->group_by();
		$query = $this->db->query($consulta);
		return $query->row()->total_registros;
	}

	public function insertar($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	public function actualizar($data,$id){
		$this->db->where($this->primary_key,$id);
		return $this->db->update($this->table,$data);
	}

	public function ultima_query(){
		return $this->db->last_query();
	}

}
