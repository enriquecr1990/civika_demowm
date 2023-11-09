<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasECModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario_has_estandar_competencia','uhec');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function obtener_query_base(){
		$consulta = "select 
			  	uhec.*,du.*,
  				DATE(uhec.fecha_evidencia_ati) fecha_evidencia_ati, time (uhec.fecha_evidencia_ati) hora_evidencia_ati,
  				DATE(uhec.fecha_presentacion_resultados) fecha_presentacion_resultados, time (uhec.fecha_presentacion_resultados) hora_presentacion_resultados
			from usuario_has_estandar_competencia uhec
			  inner join usuario_has_perfil uhp on uhp.id_usuario = uhec.id_usuario
			  inner join datos_usuario du on du.id_usuario = uhec.id_usuario
			  inner join cat_perfil cp on cp.id_cat_perfil = uhp.id_cat_perfil";
		return $consulta;
	}

	public function criterios_busqueda($data){
		$criterios = " where 1=1";
		if(isset($data['id_estandar_competencia']) && $data['id_estandar_competencia'] != ''){
			$criterios .= " and uhec.id_estandar_competencia = ".$data['id_estandar_competencia'];
		}if(isset($data['id_usuario']) && $data['id_usuario'] != ''){
			$criterios .= " and uhec.id_usuario = '".$data['id_usuario']."'";
		}if(isset($data['perfil']) && $data['perfil'] != ''){
			$criterios .= " and cp.slug = '".$data['perfil']."'";
		}
		return $criterios;
	}

	public function obtener_total_registros($data = array()){
		$consulta = "select 
			  count(*) total_registros 
			from usuario_has_estandar_competencia uhec
			  inner join usuario_has_perfil uhp on uhp.id_usuario = uhec.id_usuario
			  inner join cat_perfil cp on cp.id_cat_perfil = uhp.id_cat_perfil". $this->criterios_busqueda($data);
		$query = $this->db->query($consulta);
		return $query->row()->total_registros;
	}

	/**
	 * consulta para los intructores que veran que alumnos estan registrados a la EC
	 */
	public function alumnos_inscritos_ec($id_estandar_competencia,$id_perfil = PERFIL_ALUMNO,$pagina = 1,$registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = "select 
			  du.*,uhec.*
			from usuario_has_estandar_competencia uhec
			  inner join usuario_has_perfil uhp on uhp.id_usuario = uhec.id_usuario
			  inner join datos_usuario du on du.id_usuario = uhec.id_usuario
			where uhp.id_cat_perfil = $id_perfil
			  and uhec.id_estandar_competencia = $id_estandar_competencia order by uhec.id_usuario asc $sql_limit ";
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->alumnos_inscritos_ec');
			log_message('error',$ex->getMessage());
			return array();
		}
	}

	public function total_registros_alumnos_inscritos_ec($id_estandar_competencia,$id_perfil = PERFIL_ALUMNO){
		try{
			$consulta = "select 
			  count(*) total_registros
			from usuario_has_estandar_competencia uhec
			  inner join usuario_has_perfil uhp on uhp.id_usuario = uhec.id_usuario
			  inner join datos_usuario du on du.id_usuario = uhec.id_usuario
			where uhp.id_cat_perfil = $id_perfil
			  and uhec.id_estandar_competencia = $id_estandar_competencia";
			$query = $this->db->query($consulta);
			return $query->row()->total_registros;
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->alumnos_inscritos_ec');
			log_message('error',$ex->getMessage());
			return 0;
		}
	}

	public function obtener_instructor_para_registro_candidato($data){
		try{
			$consulta = $this->obtener_query_base().$this->criterios_busqueda($data)." ORDER BY RAND() limit 1";
			//pasamos los parametros en el data
			$query = $this->db->query($consulta);
			return $query->row();
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->alumnos_inscritos_ec');
			log_message('error',$ex->getMessage());
			return 0;
		}
	}

	public function registrar_usuario_ec_by_convocatoria($id_estandar_compentencia_convocatoria,$id_usuario){
		try{
			if(!$this->existe_registro_usuario_ec_by_convocatoria($id_estandar_compentencia_convocatoria,$id_usuario)){
				$estandar_competencia_convocatoria = $this->EstandarCompetenciaConvocatoriaModel->obtener_row($id_estandar_compentencia_convocatoria);
				$insert = array(
					'id_estandar_competencia' => $estandar_competencia_convocatoria->id_estandar_competencia,
					'id_usuario' => $id_usuario,
					//'id_usuario_evaluador' => $instructor->id_usuario,
					'fecha_registro' => date('Y-m-d')
				);
				$insert['id_usuario_evaluador'] = $estandar_competencia_convocatoria->id_usuario;
				//validamos si existe un instructor que haya registrado la convocatoria
				if(is_null($estandar_competencia_convocatoria->id_usuario)){
					$parametros_busqueda = [
						'id_estandar_competencia' => $estandar_competencia_convocatoria->id_estandar_competencia,
						'perfil' => 'instructor'
					];
					$instructor = $this->UsuarioHasECModel->obtener_instructor_para_registro_candidato($parametros_busqueda);
					$insert['id_usuario_evaluador'] = $instructor->id_usuario;
				}
				$guardar = $this->UsuarioHasECModel->guardar_row($insert);
				return [
					'success' => true,
					'msg' => ['Se registro el candidato en la convocatoria del Estándar de competencia']
				];
			}else{
				return [
					'success' => false,
					'msg' => ['No fue posible registro el candidato en la convocatoria del Estándar de competencia']
				];
			}
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->registrar_usuario_ec_by_convocatoria');
			log_message('error',$ex->getMessage());
			return 0;
		}
	}

	public function existe_registro_usuario_ec_by_convocatoria($id_estandar_competencia_convocatoria,$id_usuario){
		try{
			$consulta = "select 
					if(count(*) = 0,false,true) if(count(*) = 0,false,true) existe_registro  
				from estandar_competencia_convocatoria ecc 
					inner join usuario_has_estandar_competencia uhec ON uhec.id_estandar_competencia = ecc.id_estandar_competencia 
				where uhec.id_usuario = $id_usuario
					and ecc.id_estandar_competencia_convocatoria = $id_estandar_competencia_convocatoria";
			$query = $this->db->query($consulta);
			return $query->row()->existe_registro;
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->existe_registro_usuario_ec_by_convocatoria');
			log_message('error',$ex->getMessage());
			return 0;
		}
	}

	public function existe_progreso_candidato_convocatoria($id_estandar_compentencia,$id_usuario){
		try{
			$consulta = 'SELECT 
					count(*) progreso_pasos 
				FROM usuario_has_estandar_competencia uhec
					INNER JOIN usuario_has_ec_progreso uhecp ON uhecp.id_usuario_has_estandar_competencia = uhec.id_usuario_has_estandar_competencia
				WHERE uhec.id_estandar_competencia ='.$id_estandar_compentencia.'
					AND uhec.id_usuario = '.$id_usuario;
			$query = $this->db->query($consulta);
			if($query->row()->progreso_pasos != 0){
				return true;
			}return false;
		}catch (Exception $ex){
			log_message('error','UsuarioHasECModel->existe_progreso_candidato_convocatoria');
			log_message('error',$ex->getMessage());
			return 0;
		}
	}

}
