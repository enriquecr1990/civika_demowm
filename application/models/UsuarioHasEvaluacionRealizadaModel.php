<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasEvaluacionRealizadaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario_has_evaluacion_realizada','uher');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data){
		$criterios = " where 1=1";
		if(isset($data['id_evaluacion']) && $data['id_evaluacion'] != ''){
			$criterios .= " and uher.id_evaluacion = ".$data['id_evaluacion']."";
		}if(isset($data['id_estandar_competencia_has_evaluacion']) && $data['id_estandar_competencia_has_evaluacion'] != ''){
			$criterios .= " and uher.id_estandar_competencia_has_evaluacion = ".$data['id_estandar_competencia_has_evaluacion']."";
		}if(isset($data['id_ec_instrumento_actividad_evaluacion']) && $data['id_ec_instrumento_actividad_evaluacion'] != ''){
			$criterios .= " and uher.id_ec_instrumento_actividad_evaluacion = ".$data['id_ec_instrumento_actividad_evaluacion']."";
		}if(isset($data['enviada']) && $data['enviada'] != ''){
			$criterios .= " and uher.enviada ='".$data['enviada']."'";
		}if(isset($data['calificacion_max']) && $data['calificacion_max']){
			$criterios .= " and max(uher.calificacion)";
		}if(isset($data['id_usuario']) && $data['id_usuario']){
			$criterios .= " and uher.id_usuario = ".$data['id_usuario'];
		}if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia']){
			$criterios .= " and uher.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}
		return $criterios;
	}

	public function order_by()
	{
		return ' ORDER BY uher.id_usuario_has_evaluacion_realizada DESC';
	}

}
