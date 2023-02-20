<?php

function fechaHtmlToBD($fecha)
{
    if ($fecha == '' || $fecha == null) {
        return '';
    }
    $fecha_explode = explode('/', $fecha);
    $fecha_retorno = $fecha_explode[2] . '-' . $fecha_explode[1] . '-' . $fecha_explode[0];
    return $fecha_retorno;
}

function fechaBDToHtml($fecha)
{
    if(isset($fecha) && !is_null($fecha) && trim($fecha)!=''){
        $fecha_html = date_format(date_create($fecha), 'd/m/Y');
        return $fecha_html;
    }return '';
}

function fechaHoraBDToHTML($fecha){
    $fecha_html = date_format(date_create($fecha), 'd/m/Y h:i A');
    return $fecha_html;
}

function enConstrucion()
{
    redirect(base_url() . 'Asea/enCostruccion');
}

function testHost()
{
    var_dump($_SERVER);
}

function esServerAndroid()
{
    $retorno = false;
    $server = $_SERVER;
    if (strpos($server['SERVER_SOFTWARE'], 'AndroPHP')) {
        $retorno = true;
    }
    return $retorno;
}

function base_url_asea()
{
    $esAndroid = esServerAndroid();
    if ($esAndroid) {
        return base_url() . 'index.php/';
    } else {
        return base_url();
    }
}

function is_ajax()
{
    $CI =& get_instance();
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || $CI->input->is_ajax_request())
        return true;
    else
        return false;
}

function upload_file_img($file, $values = array())
{
    $options = array(
        'field' => 'file',
        'pre' => rand(1000000, 9999999) . '-',
        'path' => '',
        'filename' => ''
    );
    $options = array_merge($options, $values);
    //falta agregar subdirectorios en caso de existan
    if ($options['path'] != '') {
        $path = explode('/',$options['path'] );
        $ruta = '';
        foreach ($path as $directorio){
            $ruta .= $directorio;
            if (!file_exists(FCPATH . $ruta)) {
                mkdir(FCPATH . $ruta, 0777, true);
                chmod(FCPATH . $ruta,0777);
            }
            $ruta .= '/';
        }
    }

    $config['upload_path'] = FCPATH . $options['path'];
    $config['allowed_types'] = EXTENSIONES_FILES_IMG;
    $config['max_size'] = MAX_FILESIZE;
    $config['file_name'] = $options['pre'] . remove_caracteres_especiales($file['name']);
    $CI =& get_instance();
    $CI->load->library('upload', $config);
    if (!$CI->upload->do_upload($options['field']))
        return array('error' => $CI->upload->display_errors() . ' ' . $config['file_name']);
    else
        return $CI->upload->data();
}

function upload_file_pdf($file, $values = array()){
    $options = array(
        'field' => 'file',
        'pre' => rand(1000000, 9999999) . '-',
        'path' => '',
        'filename' => ''
    );
    $options = array_merge($options, $values);
    //falta agregar subdirectorios en caso de existan
    if ($options['path'] != '') {
        $path = explode('/',$options['path'] );
        $ruta = '';
        foreach ($path as $directorio){
            $ruta .= $directorio;
            if (!file_exists(FCPATH . $ruta)) {
                mkdir(FCPATH . $ruta, 0777, true);
                chmod(FCPATH . $ruta,0777);
            }
            $ruta .= '/';
        }
    }

    $config['upload_path'] = FCPATH . $options['path'];
    $config['allowed_types'] = EXTENSION_FILES_DOC_PDF;
    $config['max_size'] = MAX_FILESIZE;
    $config['file_name'] = $options['pre'] . remove_caracteres_especiales($file['name']);
    $CI =& get_instance();
    $CI->load->library('upload', $config);
    if (!$CI->upload->do_upload($options['field']))
        return array('error' => $CI->upload->display_errors() . ' ' . $config['file_name']);
    else
        return $CI->upload->data();
}

function upload_file_material_evidencia($file, $values = array()){
    $options = array(
        'field' => 'file',
        'pre' => rand(1000000, 9999999) . '-',
        'path' => '',
        'filename' => ''
    );
    $options = array_merge($options, $values);
    //falta agregar subdirectorios en caso de existan
    if ($options['path'] != '') {
        $path = explode('/',$options['path'] );
        $ruta = '';
        foreach ($path as $directorio){
            $ruta .= $directorio;
            if (!file_exists(FCPATH . $ruta)) {
                mkdir(FCPATH . $ruta, 0777, true);
                chmod(FCPATH . $ruta,0777);
            }
            $ruta .= '/';
        }
    }

    $config['upload_path'] = FCPATH . $options['path'];
    $config['allowed_types'] = EXTENSIONES_FILES_EVIDENCIA;
    $config['max_size'] = MAX_FILESIZE;
    $config['file_name'] = $options['pre'] . remove_caracteres_especiales($file['name']);
    $CI =& get_instance();
    $CI->load->library('upload', $config);
    if (!$CI->upload->do_upload($options['field']))
        return array('error' => $CI->upload->display_errors() . ' ' . $config['file_name']);
    else
        return $CI->upload->data();
}

function upload_file_xml($file, $values = array()){
    $options = array(
        'field' => 'file',
        'pre' => rand(1000000, 9999999) . '-',
        'path' => '',
        'filename' => ''
    );
    $options = array_merge($options, $values);
    //falta agregar subdirectorios en caso de existan
    if ($options['path'] != '') {
        $path = explode('/',$options['path'] );
        $ruta = '';
        foreach ($path as $directorio){
            $ruta .= $directorio;
            if (!file_exists(FCPATH . $ruta)) {
                mkdir(FCPATH . $ruta, 0777, true);
                chmod(FCPATH . $ruta,0777);
            }
            $ruta .= '/';
        }
    }

    $config['upload_path'] = FCPATH . $options['path'];
    $config['allowed_types'] = EXTENSION_FILES_XML;
    $config['max_size'] = MAX_FILESIZE;
    $config['file_name'] = $options['pre'] . remove_caracteres_especiales($file['name']);
    $CI =& get_instance();
    $CI->load->library('upload', $config);
    if (!$CI->upload->do_upload($options['field']))
        return array('error' => $CI->upload->display_errors() . ' ' . $config['file_name']);
    else
        return $CI->upload->data();
}

function remove_caracteres_especiales($str)
{
    $str = strtolower($str);
    $text = htmlentities($str, ENT_QUOTES, 'UTF-8');
    $patron = array(
        // Espacios, puntos y comas por guion
        //'/[\., ]+/' => ' ',
        // Vocales
        '/\+/' => '',
        '/&agrave;/' => 'a',
        '/&egrave;/' => 'e',
        '/&igrave;/' => 'i',
        '/&ograve;/' => 'o',
        '/&ugrave;/' => 'u',

        '/&aacute;/' => 'a',
        '/&eacute;/' => 'e',
        '/&iacute;/' => 'i',
        '/&oacute;/' => 'o',
        '/&uacute;/' => 'u',

        '/&acirc;/' => 'a',
        '/&ecirc;/' => 'e',
        '/&icirc;/' => 'i',
        '/&ocirc;/' => 'o',
        '/&ucirc;/' => 'u',

        '/&atilde;/' => 'a',
        '/&etilde;/' => 'e',
        '/&itilde;/' => 'i',
        '/&otilde;/' => 'o',
        '/&utilde;/' => 'u',

        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',

        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',

        // Otras letras y caracteres especiales
        '/&aring;/' => 'a',
        '/&ntilde;/' => 'n',

        // Agregar aqui mas caracteres si es necesario

    );

    $text = preg_replace(array_keys($patron), array_values($patron), $text);
    $text = stripslashes(str_replace(array('\\', ')', '[', ']', '{', '}', '(', ' ', '.', '/', '\/'), '', $text));
    return $text;

}

function getRouteFilesComun(){
    $route = 'files_uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
    //$route = 'files_uploads/';
    return $route;
}

function getRouteFilesDirectorio(){
    $route = 'files_uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
    //$route = 'files_uploads/';
    return $route;
}

function es_produccion(){
    $es_produccion = false;
    if($_SERVER['SERVER_NAME'] == 'cursos.civika.edu.mx'){
        $es_produccion = true;
    }
    return $es_produccion;
}

function es_pruebas(){
    $es_pruebas = false;
    if($_SERVER['SERVER_NAME'] == 'pruebas-cursos.civika.edu.mx'){
        $es_pruebas = true;
    }
    return $es_pruebas;
}

function listar_directorios_ruta($ruta)
{
    $subruta = $ruta;
    $ruta_directorio = FCPATH . $ruta;
    $retorno = array();
    if (is_dir($ruta)) {
        $index = 0;
        $directorio = dir($ruta_directorio);
        while ($archivo = $directorio->read()) {
            if ($archivo != '.' && $archivo != '..') {
                if (is_dir($ruta_directorio . '/' . $archivo)) {
                    $retorno[$index]['es_carpeta'] = true;
                    $retorno[$index]['nombre_carpeta'] = $archivo;
                    $retorno[$index]['ruta_carpeta'] = $subruta;
                    $retorno[$index]['contenido'] = listar_directorios_ruta($subruta . '/' . $archivo);
                } else {
                    $retorno[$index]['es_carpeta'] = false;
                    $retorno[$index]['nombre_archivo'] = $archivo;
                    $retorno[$index]['ruta_archivo'] = $subruta;
                }
                $index++;
            }
        }
        $directorio->close();
    }
    return $retorno;
}

function sesionActive()
{
    if(es_produccion()){
        header('Location: '.base_url());exit;
    }
    $ch =& get_instance();
    $sesion = $ch->session->userdata();
    //var_dump($sesion);exit;
    if (isset($sesion['usuario']) && $sesion['usuario']) {
        return $sesion;
    }
    return false;
}

function encriptarAsea($strEncriptar)
{
    return base64_encode($strEncriptar);
}

function desencritarAsea($strDesencriptar)
{
    return base64_decode($strDesencriptar);
}

function encrypStr($strEncriptar)
{
    return sha1($strEncriptar);
}

function decrypStr($strDesencriptar)
{
    $ch =& get_instance();
    return $ch->encrypt->decode($strDesencriptar);
}

function enviarCorreo($to, $subject, $message)
{
    $CI =& get_instance();
    $retorno['envio'] = false;
    $retorno['msg'] = 'No fue posible mandar el correo a <label>' . $to . '</label>, favor de intentar más tarde';
    $user = 'home@ecorona.com';
    $password = 'enrique0406=$=&';
    $config['protocol'] = 'mail';
    $config['smtp_host'] = 'mx1.hostinger.mx';
    $config['stmp_timeout'] = '7';
    $config['smtp_port'] = 587;
    $config['charset'] = 'utf-8';
    $config['mailtype'] = 'text';
    $config['smtp_user'] = $user;
    $config['smtp_pass'] = $password;
    $CI->load->library('email', $config);
    $CI->email->from($user, 'Enrique Corona');
    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($message);
    if ($CI->email->send()) {
        $retorno['envio'] = true;
        $retorno['msg'] = 'Se envio información a su correo <label>' . $to . '</label>, favor de revisar su bandeja de entrada o correo no deseado';
    }
    return $retorno;
}

function fechaCastellano($fecha){
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
//return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    return $numeroDia." de ".$nombreMes." de ".$anio;
}

function fecha_castellano_sin_anio($fecha){
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia." de ".$nombreMes;
}

function fecha_con_dia_sin_anio($fecha){
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $dia = date('l', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $nombredia.' '.$numeroDia." de ".$nombreMes;
}

function strMayusculas($str){
    return mb_strtoupper($str,'utf-8');
}

function strMinusculas($str){
    return mb_strtolower($str,'utf-8');
}

function todayBD(){
    return date('Y-m-d H:i:s');
}

function rango_fecha_castellano($fecha_inicio,$fecha_fin){
    $inicio = explode('/',date('Y/m/d',strtotime($fecha_inicio)));
    $fin = explode('/',date('Y/m/d',strtotime($fecha_fin)));
    $fecha = 'del ';
    //verificar diferencia de año
    if($inicio[0] == $fin[0]){
        //verificar diferencia de mes
        if($inicio[1] == $fin[1]){
            if($inicio[2] == $fin[2]){
                $fecha = 'el '.fechaCastellano($fecha_inicio);
            }else{
                $fecha .= $inicio[2]. ' al '.fecha_castellano_sin_anio($fecha_fin);
            }
        }else{
            $fecha .= fecha_castellano_sin_anio($fecha_inicio). ' al '.fechaCastellano($fecha_fin);
        }
    }else{
        $fecha .= fechaCastellano($fecha_inicio).' al '.fechaCastellano($fecha_fin);
    }
    return $fecha;
}

function existe_valor($campo){
    $existe = false;
    if(!is_null($campo) && $campo != ''){
        $existe = true;
    }
    return $existe;
}

?>