<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class UsuarioHasNotificacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('usuario_has_notificacion','uhn');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_busqueda($data)
	{
		$criterios_busqueda = ' where 1=1';
		if(isset($data['id_usuario_recibe']) && $data['id_usuario_recibe'] != ''){
			$criterios_busqueda .= ' and uhn.id_usuario_recibe = '.$data['id_usuario_recibe'];
		}if(isset($data['id_notificacion']) && $data['id_notificacion'] != ''){
			$criterios_busqueda .= ' and uhn.id_notificacion = '.$data['id_notificacion'];
		}
		return $criterios_busqueda;
	}

}
