<?php

class EntregableAlumnoComentariosModel extends ModeloBase
{
	function __construct()
	{
		parent::__construct('entregable_alumno_comentarios', 'eac');
	}


	public function guardar_comentario($params)
	{
		try {
			$return['success'] = false;
			$return['msg'] = 'Se guardo el nuevo archivo con exito';

			$consulta = "select  * from ec_entregable_alumno as eea where eea.id_entregable = " . $params['id_entregable'] . " and id_usuario = " . $params['id_usuario_alumno'];
			$query = $this->db->query($consulta);
			$data = $query->row();
			if (!$data) {
				$this->db->insert('ec_entregable_alumno', array(
					'id_usuario' => $params['id_usuario_alumno'],
					'id_entregable' => $params['id_entregable'],
					'id_cat_proceso' => 1,
				));
				$id = $this->db->insert_id();
			} else {
				$id = $data->id_entregable_alumno;
			}
			unset($params['id_entregable']);
			unset($params['id_usuario_alumno']);
			$params['id_entregable_alumno'] = $id;
			$return = $this->guardar_row($params);

		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}

}
