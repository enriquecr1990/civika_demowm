<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class EstandarCompetenciaModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('estandar_competencia','ec');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function obtener_instructor_ec($id_estandar_competencia,$id_usuario_evaluador){
		try{
			$consulta = "select 
				  du.* 
				from usuario_has_estandar_competencia uhec
				  inner join datos_usuario du on du.id_usuario = uhec.id_usuario
				  inner join usuario_has_perfil uhp on uhp.id_usuario = uhec.id_usuario	
				where uhec.id_estandar_competencia = $id_estandar_competencia
				  and du.id_usuario = $id_usuario_evaluador	
				  and uhp.id_cat_perfil = ".PERFIL_INSTRUCTOR;
			$query = $this->db->query($consulta);
			return $query->row();
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function criterios_join()
	{
		$joins = ' left join archivo a on a.id_archivo = ec.id_archivo ';
		if(in_array($this->usuario->perfil,array('instructor','alumno'))){
			$joins .= ' inner join usuario_has_estandar_competencia uhec on uhec.id_estandar_competencia = ec.id_estandar_competencia ';
		}
		return $joins;
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
			$retorno['estandar_competencia'] = $query->result();
			$retorno['total_registros'] = $this->obtener_total_registros($data);
			return $retorno;
		}catch (Exception $ex){
			log_message('error',$this->table.'->tablero');
			log_message('error',$ex->getMessage());
			return false;
		}
	}

	public function guardar_row($data,$id = false){
		try{
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
			if($id){
				if($this->actualizar($data,$id)){
					$return['success'] = true;
					$return['msg'] = 'Se actualizó el registro con exito';
				}
			}else{
				if($this->existe_ec($data)){
					$return['success'] = false;
					$return['msg'] = 'No es posible guardar este Estándar de competencia, el código ya existe';
				}else{
					if($this->insertar($data)){
						$return['success'] = true;
						$return['msg'] = 'Se guardo el nuevo registro con exito';
					}
				}
			}
		}catch (Exception $ex){
			$return['success'] = false;
			$return['msg'] = 'Hubo un error en el sistema, favor de intentar más tarde';
		}
		return $return;
	}

	public function existe_ec($ec){
		$resultado = $this->tablero(array('busqueda' => $ec['codigo']),1,10);
		if($resultado['success'] && $resultado['total_registros'] != 0){
			return true;
		}return false;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['busqueda']) && $data['busqueda'] != ''){
			$data['busqueda'] = strtoupper($data['busqueda']);
			$criterios .= " and (UPPER(ec.codigo) like '%".$data['busqueda']."%' OR UPPER(ec.titulo) LIKE '%".$data['busqueda']."%')";
		}if($this->usuario->perfil <> 'root'){
			$criterios .= " and ec.eliminado = 'no'";
		}if(isset($data['id_usuario']) && $data['id_usuario'] != ''){ //para buscar por los EC asignados a los usuarios instructor y alumno
			$criterios .= ' and uhec.id_usuario = '.$data['id_usuario'];
		}
		return $criterios;
	}

	public function order_by()
	{
		return ' ORDER BY ec.codigo ASC';
	}

	public function obtener_query_base(){
		$params_slt = "ec.*,a.*";
		if(in_array($this->usuario->perfil,array('instructor','alumno'))){
			$params_slt .= ', uhec.*';
		}
		$consulta = "select $params_slt from estandar_competencia ec ";
		return $consulta;
	}


}
