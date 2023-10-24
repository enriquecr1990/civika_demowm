<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcCursoModuloTemarioModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('ec_curso_modulo_temario', 'eccmt');	
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_curso_modulo']) && $data['id_ec_curso_modulo'] != ''){
			$criterios .= " and eccmt.id_ec_curso_modulo = ".$data['id_ec_curso_modulo'];
		}
		return $criterios;
	}

	public function criterios_join()
	{
		//$joins = ' inner join estandar_competencia ec on ec.id_estandar_competencia = ecc.id_estandar_competencia ';
		$joins = ' left join archivo a on a.id_archivo = eccmt.id_archivo ';
		return $joins;
	}

}
