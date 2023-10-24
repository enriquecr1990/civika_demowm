<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use setasign\Fpdi\Fpdi;
use \PHPMailer\PHPMailer\PHPMailer;

require_once FCPATH.'vendor/setasign/fpdf/fpdf.php';
require_once FCPATH.'vendor/setasign/fpdi/src/autoload.php';

class Welcome extends CI_Controller {

	private $usuario;

	public function index()
	{
		$this->load->view('welcome_message');
		/*if(sesionActive()){
			$this->usuario = usuarioSession();
		}*/
	}

	public function prueba(){
		//var_dump(base_url());exit;
		$this->load->view('index');
	}

	public function pass(){
		$strPass = 'Pa$$word1234';
		echo sha1($strPass);
	}

	public function sesion(){
		//var_dump(perfil_permiso_operacion_menu('usuarios.consultar'));exit;
		dd($this->session->userdata());exit;
	}

	public function paginacion(){
		$data['paginas'] = 15;
		$data['pagina_select'] = 4;
		$data['url_paginacion'] = '#';
		$this->load->view('default/paginacion',$data);
	}

	public function validar_correo(){
		$correo = 'enrique_cr1990@hotmail.edu.mx';
		$val_correo = Validaciones_Helper::isValidRegex($correo,'/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/');
		var_dump($val_correo);exit;
	}

	public function url(){
		$direccion = "www.google.com.mx";
		var_dump(filter_var($direccion,FILTER_VALIDATE_URL));
	}

	public function enviar_correo(){
		$this->load->model('NotificacionModel');
		$destinatario = new stdClass();
		$destinatario->correo = 'test-s0rza3hsa@srv1.mail-tester.com';
		$destinatario->nombre = 'Enrique Hotmail';
		$destinatarios = array($destinatario);
		$text_msg = 'Sistema Integral PED - Civika 
			Este mensaje es enviado automaticamente por el sistema, no es necesario responder
			al correo ya que no cuenta habilitada la bandeja de entrada
			Puede darse de baja de nuestras promociones dando click en: "Darse de baja"
			solo que seguira recibiendo correos de las notificaciones y avisos del sistema
			
			Centro Educativo Campus Civika. Ferrocarril Mexicano 286.
			Colonia 20 de noviembre. Apizaco, Tlax. C.P. 90341 ';
		$this->NotificacionModel->enviar_correo($destinatarios,'Asignación de estandar de competencia',$text_msg,$text_msg);
		//probar la vista para la salida de correos
		//$this->load->view('notificacion/correo');
	}

	public function demo_pdf(){
		$this->load->model('DocsPDFModel');
		$this->DocsPDFModel->portafolio_evidencia(5,4,1);
	}

	public function img_transparente(){
		$archivo = new stdClass();
		$archivo->ruta_directorio = 'assets/imgs/logos/';
		$archivo->nombre = 'footer_pdf.jpg';
		imagenFondoTransparente($archivo);
		echo 'converti la imagen con fondo transparente';
	}

	public function server(){
		var_dump($_SERVER);
	}

	public function demoInstrumentoEvaluacion(){
		$pdf = new Fpdi();
		$ruta_base = "files_uploads/2021/09/05/";
		$file = "demo_test.pdf";
		$firma_candidato = "14_51_24-firma_ecrjpeg.png";
		$firma_instructor = "15_35_22-firmafalsajpg.png";
		// initiate FPDI
		$pdf = new Fpdi();
		$paginasPDF = $pdf->setSourceFile($ruta_base.$file);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos el texto
			$pdf->SetFont('Arial','',40);
			$pdf->SetTextColor(150, 150, 150);
			$pdf->SetXY(20, $paPlantilla[1] / 2);
			$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
			//$pdf->Cell($paPlantilla[0] / 2,$paPlantilla[1] / 2,"enrique corona demo ped",0,1,'C');
			$pdf->Image($ruta_base.$firma_instructor,50,240,25,20);
			$pdf->Image($ruta_base.$firma_candidato,150,240,25,20);
		}

		$pdf->Output('I', 'generated.pdf');
	}

	public function demoCertificado(){
		$pdf = new Fpdi();
		$ruta_base = "files_uploads/2021/09/05/";
		$ruta_base_certificado = "files_uploads/2021/09/07/";
		$file = "demo_certificado.pdf";
		$firma_candidato = "14_51_24-firma_ecrjpeg.png";
		// initiate FPDI
		$pdf = new Fpdi();
		$paginasPDF = $pdf->setSourceFile($ruta_base_certificado.$file);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos el texto
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetXY(135, 120);$pdf->Write(0, utf8_decode('RECIBI CERTIFICADO DIGITAL'));
			$pdf->SetXY(135, 125);$pdf->Write(0, utf8_decode('ENRIQUE CORONA RICAÑO'));
			$pdf->SetXY(135, 130);$pdf->Write(0, utf8_decode(date('d/m/Y')));
			//$pdf->Cell($paPlantilla[0] / 2 - 10,$paPlantilla[1] / 2,"PED Demo - ECO SOFTyH",0,1,'C');
			$pdf->Image($ruta_base.$firma_candidato,150,95,25,20);
		}

		$pdf->Output('I', 'generated.pdf');
	}

	public function testUUIDPass(){
		var_dump(uniqid());
	}

	public function testIMGPDF(){
		$array_archivos_convert = '[{"ruta_directorio":"files_uploads\/2021\/10\/29\/","nombre":"17_44_38-223970601260pdf.pdf","url_video":null},{"ruta_directorio":"files_uploads\/2021\/10\/31\/","nombre":"15_52_51-223970601260pdf.pdf","url_video":null},{"ruta_directorio":"files_uploads\/2021\/10\/31\/","nombre":"15_57_34-223970601260pdf.pdf","url_video":null},{"ruta_directorio":"files_uploads\/2021\/11\/01\/","nombre":"19_52_33-core900406htlrcn08pdf.pdf","url_video":null},{"ruta_directorio":"files_uploads\/2021\/11\/04\/","nombre":"21_40_02-223970601260pdf.pdf","url_video":null},{"ruta_directorio":null,"nombre":null,"url_video":"https:\/\/www.youtube.com\/watch?v=XP7KSNDxOcQ"},{"ruta_directorio":"files_uploads\/2021\/11\/07\/","nombre":"20_28_34-01_cedula_frentejpg.jpg","url_video":null}]';
		$array_archivos_convert = json_decode($array_archivos_convert);
		var_dump($array_archivos_convert);
		foreach ($array_archivos_convert as $index => $a){
			//Para saber si es una url de video o es una imagen
			if(!is_null($a->url_video) && $a->url_video != ''){
				var_dump('es un video ' . $index);
			}else{
				if(!strpos(strMinusculas($a->nombre),'.pdf')){
					var_dump('es una imagen '. $index);
				}if(strpos(strMinusculas($a->nombre),'.pdf')){
					var_dump('es un pdf '. $index);
				}
			}
		}exit;
	}

	public function testMail(){
		try{
			$mail = new PHPMailer(true);
			//configuracion de phpmailer
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 1;//comentar para cuando sea en produccion o pruebas 1. error, 2. mensajes
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;

			//configurar smtp server
			$mail->Host = 'smtp.hostinger.com';
			$mail->Username = 'contacto@enriquecr-mx.info';
			$mail->Password = 'Pa$$word1234';

			//configuracion del email
			$mail->setFrom('contacto@enriquecr-mx.info', 'Enrique Corona Developer');
			$mail->addCustomHeader('List-Unsubscribe',base_url().'unsubscribe');
			//$mail->addAddress('test-2mw4hno4f@srv1.mail-tester.com', 'Mail testet');//para las pruebas
			$mail->Subject = 'Sistema Integral PED-Civika';
			$objD1 = new stdClass();$objD2 = new stdClass();$objD3 = new stdClass();
			$notificacion = new stdClass();
			$objD1->correo = 'test-cnf4l58pw@srv1.mail-tester.com';$objD1->nombre = 'mail tester';$destinatarios[] = $objD1;
			$objD2->correo = 'enrique_cr1990@hotmail.com';$objD2->nombre = 'ecorona hotmail';$destinatarios[] = $objD2;
			$objD3->correo = 'enriquecr1990@gmail.com';$objD3->nombre = 'ecorona gmail';$destinatarios[] = $objD3;
			//var_dump($destinatarios);exit;
			$notificacion->asunto = 'Bienvenido al sistema PED demo';
			$notificacion->mensaje = 'esto es el mensaje que se debera mandar en el correo saludos :-D';
			$data['notificacion'] = $notificacion;
			$html_msg = $this->load->view('notificacion/correo',$data,true);
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
				echo 'Mensaje de correo con error: ' . $mail->ErrorInfo;
				return false;
			} else {
				echo 'Se envio el mensaje con exito';
				return true;
			}
		}catch (Exception $ex){
			echo $ex->getMessage();
		}
	}

	public function qrGenerate($nameQR){
		$stringToQR = 'https://enriquecr.com/demos/civika/ped/PantallasPrototipo/progresoCandidato/1/1';
		//var_dump('aqui toy');exit;
		$this->load->library('ciqrcode');
		pathDirectorioArchivos(RUTA_QR_FILES.'/demos');
		$qr_image = $nameQR.'.png';
		$params['data'] = $stringToQR;
		$params['level'] = 'l';
		$params['size'] = 300;
		$params['savename'] =FCPATH.RUTA_QR_FILES.'/demos/'.$qr_image;
		if(!file_exists($params['savename'])){
		    $this->ciqrcode->generate($params);
		}
		echo 'se genero el qr';
		echo '<br><label>'.$nameQR.'</label><br><br>';
		echo '<img src="'.base_url().RUTA_QR_FILES.'/testing/'.$qr_image.'" alt="qr generaado">';
	}
}
