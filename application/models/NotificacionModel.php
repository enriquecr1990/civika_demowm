<?php
defined('BASEPATH') OR exit('No tiene access al script');

use \PHPMailer\PHPMailer\PHPMailer;

require_once FCPATH.'application/models/ModeloBase.php';

class NotificacionModel extends ModeloBase
{

	private $usuario;

	function __construct()
	{
		parent::__construct('notificacion','n'); 
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}
	}

	public function obtener_query_base()
	{
		$consulta = "select 
			  n.*,uhn.fecha_leida, if(uhn.fecha_leida is null, false,true) notificacion_leida,
			  concat(du.nombre, ' ',du.apellido_p ) destinatario, uhn.id_usuario_envia, uhn.id_usuario_recibe,
			  if(
			  	uhn.id_usuario_envia is not null,
			  	(select concat(dur.nombre, ' ',dur.apellido_p ) remitente from datos_usuario dur where dur.id_usuario = uhn.id_usuario_envia),
			  	'Administrador Sistema'
			  ) remitente
			from notificacion n 
			  left join usuario_has_notificacion uhn on n.id_notificacion = uhn.id_notificacion 
			  left join datos_usuario du on du.id_usuario = uhn.id_usuario_recibe ";
		return $consulta;
	}

	public function order_by()
	{
		$order_by = " order by n.id_notificacion desc ";
		return $order_by;
	}

	public function group_by()
	{
		return ' group by n.id_notificacion';
	}

	public function criterios_busqueda($data = array())
	{
		//$criterios = ' where uhn.id_usuario_recibe = '.$this->usuario->id_usuario;
		$criterios = ' where 1=1';
		if(isset($data['id_notificacion']) && $data['id_notificacion'] != ''){
			$criterios .= ' and n.id_notificacion = '.$data['id_notificacion'];
		}
		if(isset($data['id_usuario_recibe']) && $data['id_usuario_recibe'] != ''
			&& isset($data['id_usuario_envia']) && $data['id_usuario_envia'] != ''){
			$criterios .= ' and (uhn.id_usuario_recibe = '.$data['id_usuario_recibe'] .' or uhn.id_usuario_envia = '.$data['id_usuario_envia'].')';
		}else{
			if(isset($data['id_usuario_recibe']) && $data['id_usuario_recibe'] != ''){
				$criterios .= ' and uhn.id_usuario_recibe = '.$data['id_usuario_recibe'];
			}if(isset($data['id_usuario_envia']) && $data['id_usuario_envia'] != ''){
				$criterios .= ' and uhn.id_usuario_envia = '.$data['id_usuario_envia'];
			}
		}
		if(isset($data['estado']) && $data['estado'] != ''){
			$criterios .= ' and uhn.estado = "'.$data['estado'].'"';
		}if(isset($data['bells'])){
			$criterios .= ' and uhn.fecha_leida is null';
		}
		return $criterios;
	}

	public function obtener_total_registros($data = array()){
		$consulta = "SELECT 
				count(*) total_registros
			FROM notificacion n 
				INNER JOIN usuario_has_notificacion uhn ON n.id_notificacion = uhn.id_notificacion 
				INNER JOIN datos_usuario du ON du.id_usuario = uhn.id_usuario_recibe ". $this->criterios_busqueda($data)." group by uhn.id_usuario_recibe";	
		$query = $this->db->query($consulta);
		if($query->num_rows() == 0){
			return 0;
		}
		return $query->row()->total_registros;
	}

	public function guardar_notificacion($data){
		try{
			$notificacion = array(
				'asunto' => $data['asunto'],
				'mensaje' => $data['mensaje'],
				'fecha' => date('Y-m-d H:i:s')
			);
			$notificacion = $this->guardar_row($notificacion,$data['id_notificacion']);
			$id_notificacion = isset($data['id_notificacion']) && $data['id_notificacion'] ? $data['id_notificacion'] : $notificacion['id'];
			if($notificacion['success']){
				$usuario_has_notificacion = array(
					'id_usuario_envia' => isset($this->usuario->id_usuario) ? $this->usuario->id_usuario : null,
					'id_notificacion' => $id_notificacion,
					'estado' => $data['estado'],
				);
				$data['estado'] == 'borrador' ? $this->eliminar_usuario_has_notificacion($id_notificacion) : false;
				foreach ($data['destinatarios'] as $usuario_recibe) {
					$usuario_has_notificacion['id_usuario_recibe'] = $usuario_recibe;
					$this->db->insert('usuario_has_notificacion',$usuario_has_notificacion);
				}
				$this->eliminar_archivos_notificacion($id_notificacion);
				if(isset($data['archivos']) && is_array($data['archivos']) && sizeof($data['archivos'])){
					foreach ($data['archivos'] as $archivo){
						$notificacion_archivo = array(
							'id_notificacion' => $id_notificacion,
							'id_archivo' => $archivo
						);
						$this->db->insert('notificacion_has_archivos',$notificacion_archivo);
					}
				}
			}
			return $id_notificacion;
		}catch (Exception $ex){
			return false;
		}
	}

	public function obtener_destinatarios_correo($id_notificacion){
		try{
			$consulta = "select 
				  du.correo, concat(du.nombre,' ',du.apellido_p) nombre
				from usuario_has_notificacion uhn
				  inner join datos_usuario du on du.id_usuario = uhn.id_usuario_recibe
				where uhn.id_notificacion = $id_notificacion";
			if(isset($this->usuario->id_usuario)){
				$consulta .= ' and uhn.id_usuario_envia = '.$this->usuario->id_usuario;
			}
			$query = $this->db->query($consulta);
			return $query->result();
		}catch (Exception $ex){
			return false;
		}
	}

	public function enviar_correo($destinatarios,$asunto,$html_msg,$txt_msg){
		try{
			if(!es_development()){
				//obtenemos la configuracion del correo de la BD
				$config_correo = $this->get_config_correo();
				if(!is_object($config_correo)){
					$config_correo = new stdClass();
					$config_correo->smtp_secure = 'ssl';
					$config_correo->host = 'smtp.hostinger.com';
					$config_correo->port = '465';
					$config_correo->usuario = 'contacto@enriquecr.com';
					$config_correo->password = 'Pa$$word0192';
					$config_correo->name = 'Enrique Corona Developer';
				}
				$mail = new PHPMailer(true);
				//configuracion de phpmailer
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				//$mail->SMTPDebug = 1;//comentar para cuando sea en produccion o pruebas 1. error, 2. mensajes
				$mail->SMTPSecure = $config_correo->smtp_secure;
				$mail->Port = $config_correo->port;

				//configurar smtp server
				$mail->Host = $config_correo->host;
				$mail->Username = $config_correo->usuario;
				$mail->Password = $config_correo->password;

				//configuracion del email
				$mail->setFrom($config_correo->usuario, $config_correo->name);
				$mail->addCustomHeader('List-Unsubscribe',base_url().'unsubscribe');
				//$mail->addAddress('test-2mw4hno4f@srv1.mail-tester.com', 'Mail testet');//para las pruebas
				$mail->Subject = $asunto == '' ? 'Sistema Integral PED-Civika' : $asunto;
				foreach ($destinatarios as $d){
					if(Validaciones_Helper::isValidRegex($d->correo,'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/')){
						$mail->addAddress($d->correo, $d->nombre);
					}
				}
				$mail->isHTML(true);
				$mail->msgHTML($html_msg);
				$mail->CharSet = 'UTF-8';
				//$mail->Body = $html_msg;
				//$mail->addAttachment('test.txt');

				//enviar el correo
				if (!$mail->send()) {
					return false;//echo 'Mensaje de correo con error: ' . $mail->ErrorInfo;
				} else {
					return true;//echo 'Se envio el mensaje con exito';
				}
			}
			return true;
		}catch (Exception $ex){
			log_message('error','******* NotificacionesModel->enviar_correo()');
			log_message('info',$ex->getMessage());
			return false;
		}
	}

	/**
	 * apartado de funciones privadas al modelo
	 */
	private function eliminar_usuario_has_notificacion($id_notificacion){
		$this->db->where('id_notificacion',$id_notificacion);
		$this->db->where('id_usuario_envia',$this->usuario->id_usuario);
		return $this->db->delete('usuario_has_notificacion');
	}

	private function eliminar_archivos_notificacion($id_notificacion){
		$this->db->where('id_notificacion',$id_notificacion);
		$this->db->delete('notificacion_has_archivos');
	}

	private function get_config_correo(){
		$this->db->where('activo','si');
		$query = $this->db->get('config_correo');
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

}
