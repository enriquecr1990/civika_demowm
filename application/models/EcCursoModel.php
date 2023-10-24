<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcCursoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_curso', 'ecc');
		
	}

	public function criterios_join()
	{
		//$joins = ' inner join estandar_competencia ec on ec.id_estandar_competencia = ecc.id_estandar_competencia ';
		$joins = ' inner join archivo a on a.id_archivo = ecc.id_archivo ';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and ecc.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}
		return $criterios;
	}

	public function obtener_ec_curso($id_ec_curso){
		$consulta = "select 
		  ecc.id_ec_curso,
		  ecc.nombre_curso,
		  ecc.descripcion,
		  ecc.que_aprenderas,
		  ecc.publicado,
		  ecc.fecha_publicado,
		  ecc.eliminado,
		  ecc.id_estandar_competencia,
		  ecc.id_archivo,
		  a.nombre,
		  a.ruta_directorio,
		  a.fecha,
		  a.tipo
		from ec_curso ecc
			inner join archivo a on a.id_archivo = ecc.id_archivo 
		where ecc.id_ec_curso = $id_ec_curso";
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}
}
