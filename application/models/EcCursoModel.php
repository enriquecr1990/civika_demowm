<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcCursoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_curso', 'ecc');
		
		$this->load->model('EcCursoModuloModel');
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

	public function obtener_ec_curso($id_ec_curso, $id_estandar_competencia = false, $curso_publicado = false){
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
			inner join archivo a on a.id_archivo = ecc.id_archivo ";
		if($curso_publicado !== false){
			$consulta .= " 
			where ecc.id_estandar_competencia = $id_estandar_competencia
			and ecc.publicado = 'si'";
		} else {
			$consulta .= " 
			where ecc.id_ec_curso = $id_ec_curso";
		}
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

	public function getCursoModuloTemario($id_ec_curso){
		try{
			$result['success'] = true;

			$consulta = $this->obtener_row($id_ec_curso);			

			$result["ec_curso"] = $consulta;
			$result['ec_curso_modulos'] = $this->EcCursoModuloModel->getModuloByCurso($id_ec_curso);

			return $result;
		}catch (Exception $ex){
			log_message('error','ec_curso->getCursoModuloTemario');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	
}
