<?php
defined('BASEPATH') or exit('No tiene access al script');
require_once FCPATH . 'application/models/ModeloBase.php';
class EntregableAlumnoArchivoModel extends ModeloBase
{
	function __construct()
	{
		parent::__construct('entregable_alumno_archivo', 'eaa');
	}

	public function guardar_archivo($params, $id_entregable, $id_usuario)
	{
		try {
			$return['success'] = false;
			$return['msg'] = 'Se guardo el nuevo archivo con exito';


			$consulta = "select  * from ec_entregable_alumno as eea where eea.id_entregable = " . $id_entregable . " and id_usuario = " . $id_usuario;
			$query = $this->db->query($consulta);
			$data = $query->row();

			if (!$data) {
				$this->db->insert('ec_entregable_alumno', array(
					'id_usuario' => $id_usuario,
					'id_entregable' => $id_entregable,
					'id_cat_proceso' => 1,
				));
				$id = $this->db->insert_id();
			} else {
				$id = $data->id_entregable_alumno;
			}
			$params['id_entregable_alumno'] = $id;

			$data = $this->guardar_row($params);
			$data['id_entregable'] = $id_entregable;
			$return = $data;
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}


	public function eliminar_archivo($id_archivo_instrumento, $id_entregable_alumno_archivo)
	{

		try {
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el archivo con exito';

			$consulta = "select * from entregable_alumno_archivo ee where ee.id_entregable_alumno_archivo = " . $id_entregable_alumno_archivo;
			$query = $this->db->query($consulta);
			$data = $query->row();

			$id_entregable_alumno = $data->id_entregable_alumno;

			$this->db->where('id_entregable_alumno_archivo', $id_entregable_alumno_archivo);
			$this->db->delete('entregable_alumno_archivo');

			$this->db->where('id_archivo_instrumento', $id_archivo_instrumento);
			$this->db->delete('archivo_instrumento');

			$consulta = "select ai.*, eaa.id_entregable_alumno_archivo from archivo_instrumento ai "
				. " join entregable_alumno_archivo eaa on eaa.id_archivo_instrumento = ai.id_archivo_instrumento"
				. " join ec_entregable_alumno ea on ea.id_entregable_alumno = eaa.id_entregable_alumno"
				. " where ea.id_entregable_alumno = " . $id_entregable_alumno;

			$query = $this->db->query($consulta);
			$return['data'] = $query->result();

		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
			$return['data'] = array();
		}
		return $return;


	}
}
