<?php
defined('BASEPATH') OR exit('No tiene access al script');

require_once FCPATH.'application/models/ModeloBase.php';

class NotificacionHasArchivoModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('notificacion_has_archivos','nha');
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function criterios_join(){
		$joins = ' inner join archivo a on a.id_archivo = nha.id_archivo';
		return $joins;
	}

	public function criterios_busqueda($data){
		$criterios = ' where 1=1';
		if(isset($data['id_notificacion']) && $data['id_notificacion'] != ''){
			$criterios .= ' and nha.id_notificacion = '.$data['id_notificacion'];
		}
		return $criterios;
	}

}
