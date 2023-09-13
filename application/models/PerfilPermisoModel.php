<?php
defined('BASEPATH') OR exit('No tiene access al script');

class PerfilPermisoModel extends CI_Model
{

	private $usuario;

	function __construct()
	{
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function perfiles_usuario($id_usuario){
		try{
			$query = "select 
				  cp.slug perfiles
				from usuario_has_perfil up
				  inner join cat_perfil cp ON cp.id_cat_perfil = up.id_cat_perfil
				where up.id_usuario = $id_usuario";
			$query = $this->db->query($query);
			$resultado = $query->result();
			$return = array();
			foreach ($resultado as $index => $r){
				$return[] = $r->perfiles;
			}
			return $return;
		}catch (Exception $ex){
			$data['success'] = false;
			$data['msg'] = $ex->getMessage();
		}
		return $data;
	}

	public function perfil_permisos_usuario($id_usuario){
		try{
			$query = "select 
				  concat(cp.slug,'.',cm.slug,'.',cper.slug) perfil_permiso
				from usuario_has_perfil up
				  inner join cat_perfil cp ON cp.id_cat_perfil = up.id_cat_perfil
				  inner join perfil_has_permisos php ON php.id_cat_perfil = up.id_cat_perfil
				  inner join cat_modulo cm ON cm.id_cat_modulo = php.id_cat_modulo
				  inner join cat_permiso cper ON cper.id_cat_permiso = php.id_cat_permiso
				where up.id_usuario = $id_usuario";
			$query = $this->db->query($query);
			$resultado = $query->result();
			$return = array();
			foreach ($resultado as $index => $r){
				$return[] = $r->perfil_permiso;
			}
			return $return;
		}catch (Exception $ex){
			$data['success'] = false;
			$data['msg'] = $ex->getMessage();
		}
		return $data;
	}

	public function modulo_permisos($id_cat_perfil){
		try{
			$this->db->where('id_cat_perfil',$id_cat_perfil);
			$query = $this->db->get('perfil_has_permisos');
			return $query->result();
		}catch (Exception $ex){
			$data['success'] = false;
			$data['msg'] = $ex->getMessage();
		}
		return $data;
	}

	public function agregar_modulo_permiso($data){
		try{
			return $this->db->insert('perfil_has_permisos',$data);
		}catch (Exception $ex){
			return false;
		}
	}

	public function quitar_modulo_permiso($data){
		try{
			$this->db->where('id_cat_perfil',$data['id_cat_perfil']);
			$this->db->where('id_cat_modulo',$data['id_cat_modulo']);
			$this->db->where('id_cat_permiso',$data['id_cat_permiso']);
			return $this->db->delete('perfil_has_permisos');
		}catch (Exception $ex){
			return false;
		}
	}

}
