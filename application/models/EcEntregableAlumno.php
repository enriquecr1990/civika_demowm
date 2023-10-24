<?php

defined('BASEPATH') or exit('No tiene access al script');
require_once FCPATH . 'application/models/ModeloBase.php';
class EcEntregableAlumno  extends ModeloBase
{
	function __construct()
	{
		parent::__construct('ec_entregable_alumno', 'eea');
	}

	public function cambiar_estatus($id_entregable, $id_alumno, $id_estatus,$id_entregable_formulario = false){

		try {
			$this->db->set('id_cat_proceso', $id_estatus);
			$this->db->where('id_entregable', $id_entregable);
			$this->db->where('id_usuario', $id_alumno);
			$this->db->update('ec_entregable_alumno');

			if ($id_entregable_formulario){
				$this->db->set('id_cat_proceso', $id_estatus);
				$this->db->where('id_entregable_formulario', $id_entregable_formulario);
				$this->db->where('id_usuario', $id_alumno);
				$this->db->update('entregable_formulario_has_alumno');
			}

			$return['success'] = true;
			$return['msg'] = 'Se actualizó el registro con exito';
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}
}
