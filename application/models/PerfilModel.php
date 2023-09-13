<?php
defined('BASEPATH') OR exit('No tiene access al script');


class PerfilModel extends CI_Model
{

	private $usuario;

	function __construct()
	{
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function foto_perfil($id_usuario = false){
		if($id_usuario){
			$consulta = "select 
			  a.nombre,a.ruta_directorio 
			from datos_expediente de
			  inner join archivo a on de.id_archivo = a.id_archivo
			where de.activo = 'si' and de.id_cat_expediente = 1 and de.id_usuario = ".$id_usuario;
		}else{
			$consulta = "select 
			  a.nombre,a.ruta_directorio 
			from datos_expediente de
			  inner join archivo a on de.id_archivo = a.id_archivo
			where de.activo = 'si' and de.id_cat_expediente = 1 and de.id_usuario = ".$this->usuario->id_usuario;
		}

		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			$class = new stdClass();
			$class->nombre = 'admin.png';
			$class->ruta_directorio = 'assets/imgs/iconos/';
			return $class;
		}
		return $query->row();
	}

	public function actualizar_foto_perfil($id_archivo,$id_usuario){
		try{
			$this->desactivar_archivo_usuario($id_usuario);//foto_perfil
			$insert = array(
				'id_usuario' => $id_usuario,
				'id_cat_expediente' => 1, //foto perfil
				'id_archivo' => $id_archivo
			);
			return $this->guardar_registro_expediente($insert);
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_datos_expediente($id_usuario,$id_cat_expediente = 1){
		try{
			$consulta = "select 
			  a.nombre,a.ruta_directorio 
			from datos_expediente de
			  inner join archivo a on de.id_archivo = a.id_archivo
			where de.activo = 'si' and de.id_cat_expediente = $id_cat_expediente and de.id_usuario = ".$id_usuario;
			$query = $this->db->query($consulta);
			return $query->row();
		}catch (Exception $ex){
			log_message('error','******* PerfilModel->obtener_datos_expediente');
			log_message('info',$ex->getMessage());
			return false;
		}
	}

	public function obtener_datos_direcciones($id_usuario,$principal = false){
		try{
			$consulta = "select 
				  dd.*,ce.nombre estado, cm.nombre municipio, cl.nombre localidad
				from datos_domicilio dd
				  inner join cat_estado ce on ce.id_cat_estado = dd.id_cat_estado
				  inner join cat_municipio cm on cm.id_cat_municipio = dd.id_cat_municipio
				  inner join cat_localidad cl on cl.id_cat_localidad = dd.id_cat_localidad
				where dd.id_usuario = $id_usuario";
			if($principal){
				$consulta .= " and dd.predeterminado = 'si'";
				$query = $this->db->query($consulta);
				return $query->row();
			}
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			log_message('error','******* PerfilModel->obtener_datos_expediente');
			log_message('info',$ex->getMessage());
			return false;
		}
	}

	public function actualizar_expediente_usuario($id_archivo,$id_usuario,$id_cat_expediente = 2){
		try{
			$this->desactivar_archivo_usuario($id_usuario,$id_cat_expediente);
			$insert = array(
				'id_usuario' => $id_usuario,
				'id_cat_expediente' => $id_cat_expediente,
				'id_archivo' => $id_archivo
			);
			return $this->guardar_registro_expediente($insert);
		}catch (Exception $ex){
			return false;
		}
	}

	private function desactivar_archivo_usuario($id_usuario,$id_cat_expediente = 1){
		$this->db->where('id_usuario',$id_usuario);
		$this->db->where('id_cat_expediente',$id_cat_expediente);
		return $this->db->update('datos_expediente',array('activo' => 'no'));
	}

	private function guardar_registro_expediente($data){
		$this->db->insert('datos_expediente',$data);
		return $this->db->insert_id();
	}

}
