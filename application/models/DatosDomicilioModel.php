<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class DatosDomicilioModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('datos_domicilio','dd');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function actualizar_predeterminado($id_usuario){
		$this->db->where('id_usuario',$id_usuario);
		return $this->db->update('datos_domicilio',array('predeterminado' => 'no'));
	}

	public function obtener_domicilio_usuario($id_usuario){
		$consulta = "select 
				  dd.*,ce.nombre estado, cm.nombre municipio, cl.nombre localidad
				from datos_domicilio dd
				  inner join cat_estado ce on ce.id_cat_estado = dd.id_cat_estado
				  inner join cat_municipio cm on cm.id_cat_municipio = dd.id_cat_municipio
				  inner join cat_localidad cl on cl.id_cat_localidad = dd.id_cat_localidad
				where dd.id_usuario = $id_usuario and dd.predeterminado ='si' limit 1";
		$query = $this->db->query($consulta);
		return $query->row();
	}

}
