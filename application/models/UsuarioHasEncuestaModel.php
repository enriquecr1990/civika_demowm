<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasEncuestaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario_has_encuesta_satisfaccion','uhes');
		$this->load->model('UsuarioHasRespuestaEncuestaModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function encuesta_satisfacion_usuario_ec($id_usuario_has_ec){
		$this->db->where('id_usuario_has_estandar_competencia',$id_usuario_has_ec);
		$query = $this->db->get('usuario_has_encuesta_satisfaccion');
		return $query->row();
	}

	public function respuesta_candidato_pregunta($id_pregunta,$id_usuario_has_encuesta){
		$this->db->where('id_cat_preguntas_encuesta',$id_pregunta);
		$this->db->where('id_usuario_has_encuesta_satisfaccion',$id_usuario_has_encuesta);
		$query = $this->db->get('usuario_has_respuesta_encuesta');
		return $query->row()->respuesta;
	}

	public function guardar_respuestas_candidato($id_usuario_has_ec,$data){
		try{
			$save['id_usuario_has_estandar_competencia'] = $id_usuario_has_ec;
			$save['fecha_envio'] = date('Y-m-d H:i:s');
			$save['observaciones'] = $data['observaciones'];
			$usuario_has_encuesta_satisfacion =$this->guardar_row($save);
			foreach ($data['respuesta'] as $id_cat_preguntas_encuesta => $r){
				$respuesta['id_cat_preguntas_encuesta'] = $id_cat_preguntas_encuesta;
				$respuesta['respuesta'] = $r;
				$respuesta['id_usuario_has_encuesta_satisfaccion'] = $usuario_has_encuesta_satisfacion['id'];
				$this->UsuarioHasRespuestaEncuestaModel->guardar_row($respuesta);
			}
			$response['success'] = true;
			$response['msg'] = 'Se guardo la encuesta de satisfacion con éxito';
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'] = $ex->getMessage();
		}
		return $response;
	}

}
