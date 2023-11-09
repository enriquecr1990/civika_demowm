<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EcCursoModuloModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		
		parent::__construct('ec_curso_modulo', 'eccm');
	
		$this->load->model('EcCursoModuloTemarioModel');
	}
	

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_ec_curso']) && $data['id_ec_curso'] != ''){
			$criterios .= " and eccm.id_ec_curso = ".$data['id_ec_curso'];
		}

		if(isset($data['id_evaluacion']) && $data['id_evaluacion']){
			$criterios .= " and eccm.id_evaluacion = ".$data['id_evaluacion'];
		}

		if(isset($data['id_evaluacion_not_null']) && $data['id_evaluacion_not_null']){
			$criterios .= " and eccm.id_evaluacion IS NOT NULL";
		}

		return $criterios;
	}


	public function tablero($data,$pagina = 1, $registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = $this->obtener_query_base().' '.$this->criterios_join().' '.$this->criterios_busqueda($data).' '.$this->group_by().' '.$this->order_by().' '.$sql_limit;
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$result = $query->result();

			foreach($result as $r){
				$r->ec_curso_modulo_temario = $this->getTemarioByModulo($r->id_ec_curso_modulo);
			}
			$retorno["ec_curso_modulo"] = $result;


			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error','ec_curso_modulo->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}


	private function getTemarioByModulo($id_ec_curso_modulo){

		try{

			$criterios_busqueda = array(
				'id_ec_curso_modulo' => $id_ec_curso_modulo,
				'id_evaluacion' => "IS NOT NULL"
			);

			$varaiable_datos = $this->EcCursoModuloTemarioModel->tablero($criterios_busqueda, 1, 100);
			return $varaiable_datos['ec_curso_modulo_temario'];
		} catch(Exception $ex){
			log_message('error','ec_curso_modulo_temario->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}


	}

	public function getModuloByCurso($id_ec_curso){

		try{

			$criterios_busqueda = array(
				'id_ec_curso' => $id_ec_curso,
				//'id_evaluacion_not_null' => true,
			);

			$consulta = $this->obtener_query_base().' '.$this->criterios_join().' '.$this->criterios_busqueda($criterios_busqueda).' '.$this->group_by().' '.$this->order_by();
			$query = $this->db->query($consulta);
			$retorno['success'] = true;
			$result = $query->result();

			
			foreach($result as $r){
				$r->ec_curso_modulo_temario = $this->getTemarioByModulo($r->id_ec_curso_modulo);
			}
			$retorno["ec_curso_modulo"] = $result;

			//dd($result); exit();
			return $retorno["ec_curso_modulo"];
		} catch(Exception $ex){
			log_message('error','ec_curso_modulo->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}


	}
	
}

