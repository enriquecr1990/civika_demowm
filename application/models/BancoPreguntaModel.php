<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class BancoPreguntaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('banco_pregunta','bp');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function eliminar_banco_pregunta($id){
		try{
			$this->OpcionPreguntaModel->eliminar_row_criterios(array('id_banco_pregunta' => $id));//eliminamos las opciones de la pregunta
			$this->EvaluacionHasPreguntasModel->eliminar_row_criterios(array('id_banco_pregunta' => $id));//eliminamos la pregunta de la evaluacion
			$this->eliminar_row($id);//eliminamos la pregunta
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function eliminar_row($id){
		$this->db->where('id_banco_pregunta',$id);
		return $this->db->delete('banco_pregunta');
	}

}
