<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class OpcionPreguntaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('opcion_pregunta','op');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$consulta = $this->obtener_query_base().' '.$this->criterios_busqueda($data);
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$retorno['opcion_pregunta'] = $query->result();
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('info',$ex->getMessage());
			return false;
		}
	}

	public function criterios_busqueda($data){
		$criterios = ' where op.id_banco_pregunta = '.$data['id_banco_pregunta'];
		if(isset($data['pregunta_relacional']) && $data['pregunta_relacional'] != ''){
			$criterios .= " and op.pregunta_relacional = '".$data['pregunta_relacional']."'";
		}
		return $criterios;
	}

}
