<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcATIEvaluacionModel extends ModeloBase
{

	function __construct()
	{
		parent::__construct('ec_instrumento_actividad_evaluacion','eiae');
		$this->load->model('EvaluacionModel');
	}

	/**
	 * funciones para la evaluacion respecto al instrumento actividad cuestionario
	 */
	public function obtener_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad){
		return $this->get_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad);
	}

	private function get_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad){
		$row = $this->get_row_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad);
		if(!is_object($row)){
			$id_evaluacion = $this->insertar_nueva_evaluacion_instrumento();
			$insertar = array(
				'id_evaluacion' => $id_evaluacion,
				'id_ec_instrumento_has_actividad' => $id_ec_instrumento_has_actividad
			);
			$result = $this->guardar_row($insertar);
			if($result['success']){
				$row = $this->get_row_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad);
			}
		}return $row;
	}

	private function get_row_evaluacion_instrumento_actividad($id_ec_instrumento_has_actividad){
		$this->db->where('id_ec_instrumento_has_actividad',$id_ec_instrumento_has_actividad);
		$this->db->limit(1);
		$query = $this->db->get('ec_instrumento_actividad_evaluacion');
		if($query->num_rows() == 0){
			return false;
		}return $query->row();
	}

	private function insertar_nueva_evaluacion_instrumento(){
		$insertar = array(
			'fecha_creacion' => date('Y-m-d H:i:s'),
			'eliminado' => 'no',
			'titulo' => '',
			'intentos' => 1,
			'id_cat_evaluacion' => EVALUACION_CUESTIONARIO_INSTRUMENTO
		);
		$result = $this->EvaluacionModel->guardar_row($insertar);
		return $result['id'];
	}

}
