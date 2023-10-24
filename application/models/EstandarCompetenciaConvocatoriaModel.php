<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EstandarCompetenciaConvocatoriaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia_convocatoria','ecc');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join()
	{
		$joins = ' inner join estandar_competencia ec on ec.id_estandar_competencia = ecc.id_estandar_competencia ';
		$joins .= ' inner join archivo a on a.id_archivo = ec.id_archivo ';
		$joins .= ' inner join cat_sector_ec csec on csec.id_cat_sector_ec = ecc.id_cat_sector_ec ';
		$joins .= ' left join usuario u on u.id_usuario = ecc.id_usuario ';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($this->usuario->perfil) && $this->usuario->perfil <> 'root'){
			$criterios .= " and ecc.eliminado = 'no'";
		}if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){ //para buscar por los EC asignados a los usuarios instructor y alumno
			$criterios .= ' and ecc.id_estandar_competencia = '.$data['id_estandar_competencia'];
		}if(isset($data['fecha']) && $data['fecha'] != ''){
			$criterios .= " and ecc.alineacion_fin >= '".$data['fecha']."'";
		}if(isset($data['id_estandar_competencia_convocatoria']) && $data['id_estandar_competencia_convocatoria'] != ''){
			$criterios .= ' and ecc.id_estandar_competencia_convocatoria = '.$data['id_estandar_competencia_convocatoria'];
		}if(isset($data['publicada']) && $data['publicada'] != ''){
			$criterios .= " and ecc.publicada = 'si'";
		}
		return $criterios;
	}
	
	public function obtener_query_base(){
		$fechaHoy = date('Y-m-d');
		$consulta = "
			select 
				ec.*,
				ecc.*,
				a.*,
				csec.nombre as nombre_sector,
				if(ecc.alineacion_fin >= '".$fechaHoy."', true,false) as convocatoria_vigente,
				if(ecc.id_usuario is null, '', u.usuario) as usuario_registra_convocatoria
			from estandar_competencia_convocatoria ecc";
		return $consulta;
	}

}
