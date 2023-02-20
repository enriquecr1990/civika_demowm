<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller {

    function __construct(){
        parent:: __construct();
        $this->load->model('testing_model','Testing_model');
    }

    public function Tabla()
    {
        $this->load->view('test/table');
    }

    public function test_select(){
        $this->Testing_model->testing_select();
    }

    public function test_helper(){
        $fecha = '04/06/1990';
        $fecha_db = fechaHtmlToBD($fecha);
        var_dump($fecha,$fecha_db);
    }

    public function test_host(){
        var_dump(esServerAndroid());
    }




    public function Index()
    {
       // $this->load->view('default/header');
         //$this->load->view('default/footer');
    	$this->load->view('test/testing');
    }

    public function test_encript(){
        $this->load->model('ControlUsuariosModel');
        $strOriginal = 'password1234';
        $strEncripAsea = encriptarAsea($strOriginal);
        $strDecrypAsea = desencritarAsea($strEncripAsea);
        var_dump($strOriginal,$strEncripAsea,$strDecrypAsea);
        $strEncryp = encrypStr($strOriginal);
        $strDecryp = decrypStr($strEncryp);
        var_dump($strEncryp,$strDecryp);
        //$this->ControlUsuariosModel->obtenerUsuarioSesion(array('usuario'=>'civikholding','password'=>'Pa$$wordCivik'));
    }

    /*public function otro_encrytp(){
        $plain_text = 'Pa$$wordCivik';
        $ciphertext = $this->encryption->encrypt($plain_text);
        echo  $ciphertext;
    }*/

    public function test_date(){
        var_dump(date('Y-m-d H:i:s'));
        var_dump(date('Y-m-d h:i:s'));
    }

    public function testDirectorios(){
        $ruta =  RUTA_VIDEOS_NORMAS;
        $data['navegacion'] = listar_directorios_ruta($ruta);
        print_r($data['navegacion']);
        //var_dump($data['navegacion']);
    }

    public function testMargueArray(){
        $dataUno['uno'] = 1;
        $dataUno['dos'] = 2;
        $dataUno['tres'] = 3;
        $dataDos['cuatro'] = 4;
        $dataDos['cinco'] = 5;
        $dataDos['seis'] = 6;
        $data = array_merge($dataUno,$dataDos);
        var_dump($data);
    }

    public function testSession(){
        var_dump(sesionActive());exit;
    }

    public function testPDF(){
        $this->load->library();
    }

    public function testHost(){
        var_dump($_SERVER);exit;
    }

    public function testCorreo(){
        $correo = enviarCorreo('enrique_cr1990@hotmail.com,enriquecr1990@gmail.com','primer correo de prueba','estoy mandando un correo de prueba desde el asea');
        var_dump($correo);exit;
    }

    public function modal_show(){
        $this->load->view('test/modal');
    }

    public function password($str){
        //echo encrypStr('Pa$$word1234'); adm
        //echo encrypStr('JoselitoCivik@'); cvkhlg
        echo encrypStr($str);
    }

    public function fecha_hora(){
        $today = date('Y-m-d H:i:s');
        $format = date_format(date_create($today), 'd/m/Y h:i A');
        var_dump($format);
        var_dump(date('Y_m_d_H_i_s'));
    }

    public function error404(){
        $this->load->view('default/error_404');
    }

    public function mail(){
        /*$correo = enviarCorreo('enrique_cr1990@hotmail.com,enriquecr1990@gmail.com','primer correo de prueba','estoy mandando un correo de prueba desde el asea');
        var_dump($correo);exit;*/
        //Cargamos la librería email
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mx1.hostinger.mx',
            'smtp_port' => '587',
            'smtp_user' => 'hola@civika.edu.mx',
            'smtp_pass' => 'JoselitoCivik@',
        );

        $this->load->library('email',$config);

        $this->email->from('hola@civika.edu.mx','Civika');
        $this->email->to('enriquecr1990@gmail.com');
        $this->email->subject('test mail from sistema cursos');
        $this->email->message('prueba de envio de correo del sistema de cursos civik');

        //Enviamos el email y si se produce bien o mal que avise con una flasdata
        if($this->email->send()){
            echo 'wiiiiii se envio el correo';
            echo $this->email->print_debugger();
        }else{
            echo 'uuuuuu no se envio el correo';
            echo $this->email->print_debugger();
        }
    }

    public function plantillaCorreo(){
        $data['mensaje'] = 'Probando la salida de correos con plantilla';
        $data['usuario'] = new stdClass();
        $data['usuario']->nombre = 'Nombre propio';
        $data['usuario']->apellido_p = 'Paterno';
        //$data['email_baja'] = 'enrique_cr1990@hotmail.com';
        $html_msg = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        echo $html_msg;
    }

    public function mail_testing_old(){
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mx1.hostinger.mx';
        $config['smtp_user'] = 'sistemas@civika.edu.mx';
        $config['smtp_pass'] = 'Civik@Cursos18';
        $config['smtp_port'] = '587';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['validate'] = true;
        $config['mailtype'] = 'html';
        $data['mensaje'] = 'Probando la salida de correos con plantilla';
        $data['usuario'] = new stdClass();
        $data['usuario']->nombre = 'Nombre propio';
        $data['usuario']->apellido_p = 'Paterno';
        $html_msg = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        $this->email->initialize($config);
        $this->email->from('sistemas@civika.edu.mx','Sistema Cursos Civika');
        //$this->email->to('enrique_cr1990@hotmail.com');
        $this->email->bcc('enriquecr1990@gmail.com','enrique_cr1990@hotmail.com');
        $this->email->subject('test mail from sistema cursos');
        $this->email->message($html_msg);
        if($this->email->send()){
            echo 'wiiiiii se envio el correo';
        }else{
            echo $this->email->print_debugger();
            echo '<br>uuuuuu no se envio el correo';
        }
    }

    public function url_base(){
        echo base_url();
    }

    public function test_excel_lista(){
        $this->load->library('PHPExcel/PHPExcel.php');
        $data=$this->Testing_model->testing_excel_lista();
        $this->load->view('cursos_civik/constancias/ListaAsistencia.php',$data);
}

    public function generar_excel(){
        //$data['registros'] = $this->Testing_model->obtener_usuarios();
        $data['registros'] = $this->Testing_model->testing_excel_listas();
        //condicion ? valor_verdador : valor_false;
        $data['existen_datos'] = sizeof($data['registros']) != 0 ? true : false;
        $data['cabeceras'] = $data['registros'][0];

        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: attachment; filename=resultado_excel.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        header('Content-type: text/html; charset=utf8');
        $this->load->view('cursos_civik/exportar_excel',$data);
    }

    public function cons_habilidades(){
        $this->load->model('DocumentosPDFModel','DocumentosPDFModel');
        $data = array();
        $data= $this->DocumentosPDFModel->constancia_habilidades();
    }
    public function cons_cigede(){
        $this->load->model('DocumentosPDFModel','DocumentosPDFModel');
        $data = array();
        $data= $this->DocumentosPDFModel->constancia_cigede();
    }

    public function consecutivo(){
        var_dump(time());
    }

    public function correo_masivo(){
        $this->load->model('NotificacionesModel','NotificacionesModel');
        $this->NotificacionesModel->enviar_correo_curso_publicado(14);
    }

    public function visaCheckout(){
        $this->load->view('boton_visa');
    }

    public function mk_dir(){
        $post = $this->input->post();
        $ruta = $post['ruta'];
        if ($ruta) {
            $path = explode('/',$ruta);
            $ruta = '';
            foreach ($path as $directorio){
                $ruta .= $directorio;
                if (!file_exists(FCPATH . $ruta)) {
                    mkdir(FCPATH . $ruta, 0777, true);
                    chmod(FCPATH . $ruta,0777);
                }
                $ruta .= '/';
            }
        }else{
            echo 'sin ruta recibida';
        }
    }

    public function dif_date(){
        $date_1 = date('20180518130000'); //fecha actual
        $date_2 = date('20180518150000');//ultimo accesso
        $dif = $date_2 - $date_1;
        var_dump($dif);
    }

    public function rango_fecha(){
        $fecha = rango_fecha_castellano('2018-07-10','2018-07-10');
        var_dump($fecha);
    }

    public function crm($pagina = 1, $limit = 10)
    {
        $this->load->model('ControlUsuariosModel');
        $post['tipo_usuario'] = 'alumno';
        $data = $this->ControlUsuariosModel->obtenerUsuariosSistema($post, $pagina, $limit);
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $data['cursos_disponibles'] = $this->CursosModel->obtenerCursosPublicados();
        //var_dump($data);exit;
        $this->load->view('cursos_civik/crm/tablero_alumnos', $data);
    }

    public function sopa_crusigrama()
    {
        $data['extra_css'] = array(
            base_url() . 'extras/css/juegos/style.css',
            base_url() . 'extras/css/juegos/jquery.tagit.css',
            base_url() . 'extras/css/juegos/jquery-ui.css',

        );
        $data['extra_js'] = array(
            base_url() . 'extras/plugin1/jquery-ui.min.js',
            base_url() . 'extras/plugin1/tag-it.js',
            base_url() . 'extras/plugin1/jquery.min.js',
            base_url() . 'extras/plugin1/wordfind.js',
            base_url() . 'extras/plugin1/wordfindgame.js',
            base_url() . 'extras/plugin1/segunda.js',
            base_url() . 'extras/plugin1/primera.js',
            base_url() . 'extras/plugin1/google.js',
        );

        $this->load->view('aprendizaje/sopa_crusigrama', $data);

    }

    public function crusigrama()
    {
        $data['extra_css'] = array(
            base_url() . 'extras/css/juegos/estilos.css',
        );
        $data['extra_js'] = array(
            base_url() . 'extras/crusigram/jquery.min.js',
            base_url() . 'extras/crusigram/jquery.crossword.js',
            base_url() . 'extras/crusigram/script.js',

        );
        $this->load->view('aprendizaje/crusigrama.php', $data);
    }

    /**
     * probando la nueva configuracion del correo electronico por el servicio
     * adquirido con el proveedor
     */
    public function enviar_correo_ejemplo(){
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'us3.smtp.mailhostbox.com';
        $config['smtp_user'] = 'sistemas@civika.edu.mx';
        //$config['smtp_pass'] = 'Civik@Cursos18';
        $config['smtp_pass'] = 'HCD*fIG9';
        $config['smtp_port'] = '587';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['validate'] = true;
        $config['mailtype'] = 'html';
        $data['mensaje'] = 'Probando la salida de correos con plantilla';
        $data['usuario'] = new stdClass();
        $data['usuario']->nombre = 'Nombre propio';
        $data['usuario']->apellido_p = 'Paterno';
        $html_msg = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        $this->email->initialize($config);
        $this->email->from('sistemas@civika.edu.mx','Sistema Cursos Civika');
        //$this->email->to('enriquecr1990@gmail.com,enrique_cr1990@hotmail.com,marilita_mm@hotmail.com,jl_salazarh@hotmail.com,bbmarcholita@gmail.com');
        $this->email->to('test-wmwxg@mail-tester.com,enrique_cr1990@hotmail.com,enriquecr1990@gmail.com');
        $this->email->subject('test mail from sistema cursos');
        $this->email->message($html_msg);
        if($this->email->send()){
            echo 'wiiiiii se envio el correo';
        }else{
            echo $this->email->print_debugger();
            echo '<br>uuuuuu no se envio el correo';
        }
    }

    public function ci_version(){
        var_dump(CI_VERSION);
        var_dump(BASEPATH);
        var_dump(APPPATH);
        var_dump(FCPATH);
        exit;
    }

    public function mpdf8(){
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML('Hello World');
        $pdf->Output();
    }

    public function mercado_pago(){
        $this->load->view('test/mercado_pago_tokenize');
    }

    public function mp_payment(){
        require_once FCPATH.'vendor/autoload.php';
        MercadoPago\SDK::setAccessToken('TEST-2674302978955181-062811-b02cd176292f6c43a42760b33d511f3d-265303870');

        $token = $_REQUEST["token"];
        $payment_method_id = $_REQUEST["payment_method_id"];
        $installments = $_REQUEST["installments"];
        $issuer_id = $_REQUEST["issuer_id"];

        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = 189;
        $payment->token = $token;
        $payment->description = "Probando el pago de 'Mercado Pago'";
        $payment->installments = $installments;
        $payment->payment_method_id = $payment_method_id;
        $payment->issuer_id = $issuer_id;
        $payment->payer = array(
            "email" => "enriquecr1990@gmail.com"
        );
        // Guarda y postea el pago
        $payment->save();
        //...
        // Imprime el estado del pago
        echo $payment->status;
        var_dump($_REQUEST,$payment);exit;
    }
}