<?php
defined('BASEPATH') or exit('No tiene access al script');
require_once FCPATH . 'application/models/ModeloBase.php';

class EntregableECModel extends ModeloBase
{
	private $usuario;

	public function __construct()
	{
		parent::__construct('entregable_ec', 'ee');
		if (sesionActive()) {
			$this->usuario = usuarioSession();
		}
	}

	public function guardar_entregable($parametros, $id = false)
	{
		try {
			$return['success'] = false;
			$return['msg'] = 'Se guardo el nuevo registro con exito';


			if ($id) {
				$this->db->set('nombre', $parametros['nombre']);
				$this->db->set('descripcion', $parametros['descripcion']);
				$this->db->set('instrucciones', $parametros['instrucciones']);
				$this->db->set('tipo_entregable', $parametros['tipo_entregable']);
				$this->db->where('id_entregable', $id);
				$this->db->update('entregable_ec');
			} else {
				$this->db->insert('entregable_ec', array(
					'nombre' => $parametros['nombre'],
					'descripcion' => $parametros['descripcion'],
					'instrucciones' => $parametros['instrucciones'],
					'tipo_entregable' => $parametros['tipo_entregable'],
					'activo' => true,
					'id_estandar_competencia' => $parametros['id_estandar_comptencia'],
				));

				$id = $this->db->insert_id();
			}

			$this->db->where('id_entregable', $id);
			$this->db->delete('entregable_has_instrumento');

			$this->db->where('id_entregable', $id);
			$this->db->delete('entregable_has_archivo');


			foreach ($parametros['instrumentos'] as $item) {
				$this->db->insert('entregable_has_instrumento', array(
					'id_entregable' => $id,
					'id_ec_instrumento_has_actividad' => $item));
				$this->db->insert_id();
			}

			if (isset($parametros['id_archivo'])  && $parametros['id_archivo'] != null){
				$this->db->insert('entregable_has_archivo', array(
					'id_entregable' => $id,
					'id_archivo' => $parametros['id_archivo']));
				$this->db->insert_id();
			}



		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function obtener_entregables($pagina, $limit, $id_estandar_competencia)
	{
		$sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";

		if ($pagina == 0) {
			$sql_limit = '';
		}
		$consulta = "select * from entregable_ec ee where activo = 1 and ee.id_estandar_competencia = " . $id_estandar_competencia;
		$consulta .= $sql_limit;
		$query = $this->db->query($consulta);
		$data = $query->result();

		foreach ($data as $item) {

			$consulta = "select eiha.actividad from ec_instrumento_has_actividad eiha
                      join entregable_has_instrumento ehi on ehi.id_ec_instrumento_has_actividad = eiha.id_ec_instrumento_has_actividad
                      where ehi.id_entregable = " . $item->id_entregable;
			$query = $this->db->query($consulta);
			$item->instrumentos = $query->result();
		}

		return $data;
	}

	public function obtener_entregables_candidato($id_estandar_competencia, $id_usuario)
	{
		$consulta = "select ee.*,ee.nombre as nombre_entregable, ci.*, eiha.id_ec_instrumento_has_actividad , eiha.actividad ,
       			(select eea.id_cat_proceso from ec_entregable_alumno eea where eea.id_entregable = ee.id_entregable and eea.id_usuario = ".$id_usuario.") as id_estatus, ".
       			"(select ehf.id_entregable_formulario from entregable_has_formulario ehf where ehf.id_entregable = ee.id_entregable limit 1 ) as id_entregable_formulario, ".
       			"(select efa.id_cat_proceso from entregable_formulario_has_alumno efa join entregable_has_formulario ehf on ehf.id_entregable_formulario = efa.id_entregable_formulario  where ehf.id_entregable = ee.id_entregable and efa.id_usuario = ".$id_usuario.") as id_estatus_formulario "
			. "from entregable_ec ee "
			. "join entregable_has_instrumento ehi ON ehi.id_entregable = ee.id_entregable "
			. "join ec_instrumento_has_actividad eiha ON eiha.id_ec_instrumento_has_actividad = ehi.id_ec_instrumento_has_actividad "
			. "join estandar_competencia_instrumento eci on eci.id_estandar_competencia_instrumento =eiha.id_estandar_competencia_instrumento "
			. "join cat_instrumento ci on ci.id_cat_instrumento = eci.id_cat_instrumento "
			. "where ee.activo and ee.liberado = 'si' and ee.id_estandar_competencia = " . $id_estandar_competencia;

		$query = $this->db->query($consulta);
		$data = $query->result();

		$entregables = array();
		foreach ($data as $item) {

			if ($item->tipo_entregable == 'form'){
				$item->id_estatus = $item-> id_estatus_formulario;
			}

			$object = (object)array(
				'id_entregable' => $item->id_entregable,
				'nombre_entregable' => $item->nombre_entregable,
				'descripcion' => $item->descripcion,
				'instrucciones' => $item->instrucciones,
				'tipo_entregable' => $item->tipo_entregable,
				'id_estatus' => $item->id_estatus,
				'id_entregable_formulario' => $item->id_entregable_formulario,
				'id_usuario' => $id_usuario,
				'instrumentos' => array(),
				'archivos' => array(),
				'comentarios' => array()
			);
			if (!in_array($object, $entregables)) {
				$entregables[] = $object;
			}

		}
		foreach ($entregables as $item) {
			$item->instrumentos = array_filter($data, function ($i) use ($item) {
				return $i->id_entregable == $item->id_entregable;
			});

			$consulta = "select ai.*, eaa.id_entregable_alumno_archivo from archivo_instrumento ai "
				. " join entregable_alumno_archivo eaa on eaa.id_archivo_instrumento = ai.id_archivo_instrumento"
				. " join ec_entregable_alumno ea on ea.id_entregable_alumno = eaa.id_entregable_alumno"
				. " where ea.id_entregable = " . $item->id_entregable
				. " and ea.id_usuario = " . $id_usuario;

			$query = $this->db->query($consulta);
			$item->archivos = $query->result();

			$consulta = "select eac.*, ea.id_entregable_alumno from entregable_alumno_comentarios eac "
				. " join ec_entregable_alumno ea on ea.id_entregable_alumno = eac.id_entregable_alumno"
				. " where ea.id_entregable = " . $item->id_entregable
				. " and ea.id_usuario = " . $id_usuario;

			$query = $this->db->query($consulta);
			$item->comentarios = $query->result();
		}
		return $entregables;
	}

	public function obtener_entregable($id)
	{
		$consulta = "select * from entregable_ec ee where ee.id_entregable = " . $id;
		$query = $this->db->query($consulta);
		$data = $query->row();


		$consulta = "select ehi.id_ec_instrumento_has_actividad from entregable_has_instrumento ehi
                      where ehi.id_entregable = " . $id;
		$query = $this->db->query($consulta);

		$instrumentos = $query->result();
		$data->instrumentos = array();
		foreach ($instrumentos as $item) {
			$data->instrumentos[] = $item->id_ec_instrumento_has_actividad;
		}

		$consulta = "select a.* from entregable_has_archivo eha
                                  join archivo a on a.id_archivo = eha.id_archivo
                      where eha.id_entregable = " . $id;
		$query = $this->db->query($consulta);

		$archivos = $query->result();

		if (!empty($archivos)) {
			$data->archivo = $archivos[0]->nombre;
			$data->id_archivo = $archivos[0]->id_archivo;
		}


		return $data;
	}

	public function eliminar($id)
	{
		try {
			$this->db->set('activo', 0);
			$this->db->where('id_entregable', $id);
			$this->db->update('entregable_ec');
			$return['success'] = true;
			$return['msg'] = 'Se eliminó el registro con exito';
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;

	}

	public function liberar_entregables($id_estandar_competencia){

		try {
			$this->db->set('liberado', 'si');
			$this->db->where('id_estandar_competencia', $id_estandar_competencia);
			$this->db->update('entregable_ec');
			$return['success'] = true;
			$return['msg'] = 'Se liberaron los entregables del estandar de competencia';
		} catch (Exception $ex) {
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}
}
