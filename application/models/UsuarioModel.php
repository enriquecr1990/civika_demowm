<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario','u');
		$this->load->model('PerfilModel');
		$this->load->model('PerfilPermisoModel');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function login_usuario($data_login){
		$result['success'] = false;
		$result['msg'] = array();
		try{
			$usuario = $this->obtener_usuario_by_usr($data_login['usuario']);
			if(is_object($usuario)){
				$pass_sha1 = sha1($data_login['password']);
				if($pass_sha1 == $usuario->password){
					if($usuario->activo == 'si'){
						$result['success'] = true;
						$result['msg'][] = 'Bienvenido al sistema '.$usuario->usuario;
						unset($usuario->password);
						unset($usuario->password_temp);
						$usuario->datos_usuario = $this->obtener_data_usuario_id($usuario->id_usuario);
						$usuario->perfiles = $this->PerfilPermisoModel->perfiles_usuario($usuario->id_usuario);
						$usuario->perfil_modulo_permisos = $this->PerfilPermisoModel->perfil_permisos_usuario($usuario->id_usuario);
						$result['usuario'] = $usuario;
					}else{
						$result['success'] = false;
						$result['msg'] = 'Su cuenta, actualmente se encuentra desactivada, no podrá iniciar sesión actualmente, contacte al administrador';
					}
				}else{
					$result['success'] = false;
					$result['msg'] = 'Error, contraseña incorrecta';
				}
			}else{
				$result['msg'] = 'Error, no existe el usuario en el sistema';
			}
		}catch (Exception $ex){
			$result['msg'] = $ex->getMessage();
		}
		return $result;
	}

	public function regenerar_password($data){
		$result['success'] = false;
		$result['msg'] = array();
		try{
			$usuario = $this->obtener_usuario_by_usr($data['usuario']);
			if(is_object($usuario)){
				$pass_nuevo = uniqid();
				$this->actualizar_password_usuario($usuario->id_usuario,$pass_nuevo);
				$result['nuevo_pass'] = $pass_nuevo;
				$result['usuario'] = $usuario;
				$result['success'] = true;
			}else{
				$result['msg'] = 'Error, no existe el usuario en el sistema';
			}
		}catch (Exception $ex){
			$result['msg'] = $ex->getMessage();
		}
		return $result;
	}

	public function obtener_usuarios_tablero($data_busqueda, $perfil = false,$pagina = 1,$registros = 10){
		try{
			$sql_limit = " limit ".(($pagina*$registros)-$registros).",$registros";
			if($pagina == 0){
				$sql_limit = '';
			}
			$consulta = $this->obtener_query_base_usuarios($perfil);
			$consulta .= $this->obtener_criterios_adicionales_usuarios($data_busqueda);
			$consulta .= $sql_limit;
			//var_dump($consulta);exit;
			$query = $this->db->query($consulta);
			$usuarios = $query->result();
			foreach($usuarios as $u){
				$foto_perfil = $this->PerfilModel->foto_perfil($u->id_usuario);
				$u->foto_perfil = base_url() . $foto_perfil->ruta_directorio . $foto_perfil->nombre;
			}
			$data['success'] = true;
			$data['usuarios'] = $usuarios;
			$data['total_registros'] = $this->obtener_numero_registros_usuario($perfil,$data_busqueda);
		}catch (Exception $ex){
			$data['success'] = false;
			$data['msg'] = $ex->getMessage();
		}
		return $data;
	}

	public function obtener_usuario_modificar_id($id_usuario){
		$consulta = "select 
			  u.usuario,u.activo,u.perfil,
			  du.*,u.id_usuario, cna.nombre as nivel_academico,
			  csp.nombre as sector_productivo
			from usuario u
			  left join datos_usuario du on du.id_usuario = u.id_usuario
			  left join cat_nivel_academico cna on cna.id_cat_nivel_academico = du.id_cat_nivel_academico
			  left join cat_sector_productivo csp on csp.id_cat_sector_productivo = du.id_cat_sector_productivo
			where u.id_usuario = $id_usuario";
		$query = $this->db->query($consulta);
		return $query->row();
	}

	public function guardar_usuario_admin($data,$id_usuario = false){
		try{
			if($id_usuario){
				$resultado['success'] = false;
				$resultado['msg'] = 'No fue posible actualizar el administrador';
				if($this->actualizar_usuario($data,$id_usuario)){
					$resultado['success'] = true;
					$resultado['msg'] = 'Se actualizó el administrador con exito';
				}
			}else{
				$resultado = $this->nuevo_usuario($data,'admin');
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de guardar el administrador';
		}
		return $resultado;
	}

	public function guardar_usuario_instructor($data,$id_usuario = false){
		try{
			if($id_usuario){
				$resultado['success'] = false;
				$resultado['msg'] = 'No fue posible actualizar el evaluador';
				if($this->actualizar_usuario($data,$id_usuario)){
					$resultado['success'] = true;
					$resultado['msg'] = 'Se actualizó el evaluador con exito';
				}
			}else{
				$resultado = $this->nuevo_usuario($data,'instructor');
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de guardar el instructor';
		}
		return $resultado;
	}

	public function guardar_usuario_candidato($data,$id_usuario = false){
		try{
			if($id_usuario){
				$resultado['success'] = false;
				$resultado['msg'] = 'No fue posible actualizar el candidato';
				if($this->actualizar_usuario($data,$id_usuario)){
					$resultado['success'] = true;
					$resultado['msg'] = 'Se actualizó el candidato con exito';
				}
			}else{
				$data['password'] = $data['curp'];
				$resultado = $this->nuevo_usuario($data,'candidato');
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de guardar el candidato';
		}
		return $resultado;
	}

	public function activar_usuario($id_usuario){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de activar el usuario';
			$this->db->where('id_usuario',$id_usuario);
			if($this->db->update('usuario',array('activo' => 'si'))){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se activo el usuario correctamente';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de activar el usuario';
		}
		return $resultado;
	}

	public function desactivar_usuario($id_usuario){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de desactivar el usuario';
			$this->db->where('id_usuario',$id_usuario);
			if($this->db->update('usuario',array('activo' => 'no'))){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se desactivo el usuario correctamente';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de desactivar el usuario';
		}
		return $resultado;
	}

	public function eliminar_usuario($id_usuario){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de eliminar el usuario';
			$this->db->where('id_usuario',$id_usuario);
			if($this->db->update('usuario',array('eliminado' => 'si'))){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se eliminó el usuario correctamente';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de eliminar el usuario';
		}
		return $resultado;
	}

	public function deseliminar_usuario($id_usuario){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de deseliminar el usuario';
			$this->db->where('id_usuario',$id_usuario);
			if($this->db->update('usuario',array('eliminado' => 'no'))){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se deseliminó el usuario correctamente';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de deseliminar el usuario';
		}
		return $resultado;
	}

	public function actualizar_password_usuario($id_usuario,$password){
		try {
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de cambiar la contraseña del usuario';
			$this->db->where('id_usuario',$id_usuario);
			if($this->db->update('usuario',array('password' => sha1($password)))){
				$resultado['success'] = true;
				$resultado['msg'] = 'Se cambió la contraseña del usuario correctamente';
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de cambiar la contraseña del usuario';
		}
		return $resultado;
	}

	public function actualizar_password_perfil($id_usuario,$data){
		try{
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de cambiar la contraseña del usuario';
			$usuario = $this->obtener_usuario_by_id($id_usuario);
			if(sha1($data['password_anterior']) != $usuario->password){
				$resultado['msg'] = 'La contraseña anterior es incorrecta, favor de validar';
			}else{
				$this->db->where('id_usuario',$id_usuario);
				if($this->db->update('usuario',array('password' => sha1($data['password_nueva'])))){
					$resultado['success'] = true;
					$resultado['msg'] = 'Se actualizo su contraseña correctamente';
				}
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de cambiar la contraseña del usuario';
		}
		return $resultado;
	}

	public function nuevo_usuario($data,$perfil = 'admin'){
		try{
			//obtenemos el usuario conforme al perfil
			$usuario = $perfil != 'candidato' ? $this->obtener_usuario_by_usr($data['correo']) : $this->obtener_usuario_by_usr($data['curp']);
			if(is_object($usuario)){
				$resultado['success'] = false;
				$resultado['msg'] = $perfil != 'candidato' ? 'Error, existe un usuario con el correo proporcionado' : 'Error, existe un candidato con el CURP proporcionado';
			}else{
				$curp_usuario = isset($data['curp']) ? substr($data['curp'],0,10) : '';
				$usuario_guardar = array(
					'usuario' => $perfil != 'candidato' ? $data['correo'] : $curp_usuario,
					'password' => $perfil != 'candidato' ? sha1($data['password']) : sha1($curp_usuario),
				);
				$id_usuario = $this->guardar_usuario($usuario_guardar);
				$this->insertar_perfil_usuario($id_usuario,$perfil);
				$datos_usuario = $data;
				$datos_usuario['id_usuario'] = $id_usuario;
				unset($datos_usuario['password']);
				$id_datos_usuario = $this->guardar_datos_usuario($datos_usuario);
				if($id_datos_usuario) {
					$resultado['success'] = true;
					$resultado['msg'] = 'Se guardo el '.$perfil.' correctamente';
				}else{
					$resultado['success'] = false;
					$resultado['msg'] = 'No fue posible guardar el '.$perfil.', favor de intentar más tarde';
				}
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de guardar el '.$perfil;
		}
		return $resultado;
	}

	public function actualizar_usuario($data,$id_usuario){
		try{
			$datos_usuario = $this->obtener_data_usuario_id($id_usuario);
			if(is_object($datos_usuario)){
				$this->db->where('id_usuario',$id_usuario);
				return $this->db->update('datos_usuario',$data);
			}else{
				$data['id_usuario'] = $id_usuario;
				return $this->guardar_datos_usuario($data);
			}
		}catch (Exception $ex){
			$resultado['success'] = false;
			$resultado['msg'] = 'Ocurrio un error al tratar de actualizar el administrador';
		}
		return $resultado;
	}

	public function obtener_usuario_by_id($id_usuario){
		$this->db->where('id_usuario',$id_usuario);
		$query = $this->db->get('usuario');
		return $query->row();
	}

	public function obtener_usuario_by_usr($usuario){
		//$this->db->where('usuario',$usuario);
		//$query = $this->db->get('usuario');
		$consulta = "select 
			  u.id_usuario,u.usuario, u.password,u.activo,u.eliminado,cp.slug perfil 
			from usuario u
			  inner join usuario_has_perfil uhp on uhp.id_usuario = u.id_usuario
			  inner join cat_perfil cp on cp.id_cat_perfil = uhp.id_cat_perfil
			where u.usuario = '$usuario' limit 1";
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return false;
		}return $query->row();
	}

	public function obtener_data_usuario_id($id_usuario){
		try{
			$this->db->where('id_usuario',$id_usuario);
			$query = $this->db->get('datos_usuario');
			if($query->num_rows() == 0){
				return false;
			}return $query->row();
		}catch (Exception $ex){
			return false;
		}
	}

	private function obtener_query_base_usuarios($perfil = false){
		$consulta = "select 
				u.id_usuario,u.usuario,u.activo,u.eliminado,
				du.nombre, du.apellido_p, du.apellido_m, du.genero, du.fecha_nacimiento, du.correo, du.celular, du.telefono, du.curp, du.profesion, du.puesto, du.educacion, du.habilidades, du.codigo_evaluador,
				cp.slug perfil
			from usuario u
				inner join usuario_has_perfil uhp on uhp.id_usuario = u.id_usuario
  				inner join cat_perfil cp on cp.id_cat_perfil = uhp.id_cat_perfil
			  	left join datos_usuario du on du.id_usuario = u.id_usuario 
			where cp.slug <> 'root' ";
		if($this->usuario->perfil == 'root'){
			$consulta .= " and u.eliminado in('no','si') ";
		}else{
			$consulta .= " and u.eliminado = 'no' ";
		}if($perfil){
			$consulta .= " and cp.slug = '$perfil'";
		}
		return $consulta;
	}

	private function obtener_criterios_adicionales_usuarios($data_adicionales){
		$criterios = '';
		if(isset($data_adicionales['busqueda']) && $data_adicionales['busqueda']){
			$data_adicionales['busqueda'] = strtoupper($data_adicionales['busqueda']);
			$criterios .= " and (
				UPPER(du.nombre) like '%".$data_adicionales['busqueda']."%' or
				UPPER(du.apellido_p) like '%".$data_adicionales['busqueda']."%' or
				UPPER(du.apellido_m) like '%".$data_adicionales['busqueda']."%' or
				UPPER(du.correo) like '%".$data_adicionales['busqueda']."%' or
				UPPER(du.telefono) like '%".$data_adicionales['busqueda']."%' or
				UPPER(du.curp) like '%".$data_adicionales['busqueda']."%'
			  )";
		}
		return $criterios;
	}

	private function obtener_numero_registros_usuario($perfil = false,$array_busqueda = array()){
		$consulta = "select 
			  count(*) total_registros
			from usuario u
				inner join usuario_has_perfil uhp on uhp.id_usuario = u.id_usuario
  				inner join cat_perfil cp on cp.id_cat_perfil = uhp.id_cat_perfil
			  	left join datos_usuario du on du.id_usuario = u.id_usuario
			where cp.slug <> 'root' ";
		if($perfil){
			$consulta .= " and cp.slug = '$perfil'";
		}
		$consulta .= $this->obtener_criterios_adicionales_usuarios($array_busqueda);
		$query = $this->db->query($consulta);
		return $query->row()->total_registros;
	}

	public function guardar_usuario($usuario){
		$this->db->insert('usuario',$usuario);
		return $this->db->insert_id();
	}

	public function guardar_datos_usuario($datos_usuario){
		$this->db->insert('datos_usuario',$datos_usuario);
		return $this->db->insert_id();
	}

	public function insertar_perfil_usuario($id_usuario,$perfil){
		$insert['id_usuario'] = $id_usuario;
		switch ($perfil){
			case 'admin': $insert['id_cat_perfil'] = 2; break;
			case 'instructor': $insert['id_cat_perfil'] = 3;break;
			case 'candidato': $insert['id_cat_perfil'] = 4;break;
		}
		$this->db->insert('usuario_has_perfil',$insert);
		return $this->db->insert_id();
	}

}
