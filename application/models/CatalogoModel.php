<?php
defined('BASEPATH') OR exit('No tiene access al script');

class CatalogoModel extends CI_Model
{

	private $usuario;

	function __construct()
	{
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function cat_estado(){
		$query = $this->db->get('cat_estado');
		return $query->result();
	}

	public function cat_municipio($id_cat_estado){
		$this->db->where('id_cat_estado',$id_cat_estado);
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_municipio');
		return $query->result();
	}

	public function cat_localidad($id_cat_municipio){
		$this->db->where('id_cat_municipio',$id_cat_municipio);
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_localidad');
		return $query->result();
	}

	public function get_catalogo($tabla){
		$query = $this->db->get($tabla);
		return $query->result();
	}

	public function cat_perfil(){
		$this->db->where('id_cat_perfil <>',1);
		$query = $this->db->get('cat_perfil');
		return $query->result();
	}

	public function cat_modulo(){
		$this->db->where('id_cat_modulo <>',1);
		$query = $this->db->get('cat_modulo');
		return $query->result();
	}

	public function cat_permiso(){
		$this->db->where('id_cat_permiso <>',1);
		$query = $this->db->get('cat_permiso');
		return $query->result();
	}

	public function actividad_ec($id_cat_instrumento){
		$this->db->where('id_cat_instrumento',$id_cat_instrumento);
		$query = $this->db->get('activida_ec');
		return $query->result();
	}

	public function cat_sector_productivo(){
		$this->db->order_by('nombre','asc');
		$query = $this->db->get('cat_sector_productivo');
		return $query->result();
	}

	public function cat_preguntas_encuesta(){
		$this->db->where('eliminado','no');
		$query = $this->db->get('cat_preguntas_encuesta');
		return $query->result();
	}

	public function cat_msg_bienvenida(){
		$query = $this->db->get('cat_msg_bienvenida');
		$row = $query->row();
		if($query->num_rows() == 0){
			$this->db->insert('cat_msg_bienvenida',array('nombre' => ''));
			$query = $this->db->get('cat_msg_bienvenida');
			$row = $query->row();
		}return $row;
	}

}
