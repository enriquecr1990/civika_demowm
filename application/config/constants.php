<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/**
 * CUSTOM CONSTANS
 */

define('EXTENSION_FILES_DOC_PDF', 'pdf|doc|docx|ppt|pptx|xls|xlsx');
define('EXTENSION_FILES_XML', 'xml');
define('EXTENSIONES_FILES_IMG', 'png|jpg|jpeg|gif|tiff');
define('EXTENSIONES_FILES_EVIDENCIA', 'pdf|doc|docx|ppt|pptx|xls|xlsx|png|jpg|jpeg|gif|tiff');
define('MAX_FILESIZE', 15360);
define('RUTA_VIDEOS_NORMAS','extras/videos/normas');

/**
 * constante para el usuario del sistema root
 */
define('ADMIN_ROOT',1);

/**
 * constantes para las publicaciones de un curso publicado
 */
define('CURSO_PRESENCIAL',1);
define('CURSO_EMPRESA',2);
define('CURSO_ONLINE',3);
define('CURSO_EVALUACION_ONLINE',4);

/**
 * constantes de proceso de pago
 */
define('PROCESO_PAGO_ACTUALIZACION_DATOS',1);
define('PROCESO_PAGO_NO_REGISTRADO',2);
define('PROCESO_PAGO_EN_VALIDACION',3);
define('PROCESO_PAGO_OBSERVADO',4);
define('PROCESO_PAGO_FINALIZADO_INSCRITO',5);
define('PROCESO_PAGO_FINALIZADO_CUPO_LLENO',6);

/**
 * constanctes para las constancias
 */

define('CONSTANCIA_HABILIDADES',1);
define('CONSTANCIA_DC3',2);
define('CONSTANCIA_FDH',3);
define('CONSTANCIA_OTRA',99999);

/**
 * constantes para las opciones de pregunta
 */
define('OPCION_VERDADERO_FALSO',1);
define('OPCION_UNICA_OPCION',2);
define('OPCION_OPCION_MULTIPLE',3);
define('OPCION_IMAGEN_UNICA_OPCION',4);
define('OPCION_IMAGEN_OPCION_MULTIPLE',5);
define('OPCION_SECUENCIAL',6);
define('OPCION_RELACIONAL',7);

/**
 * constantes para el proceso de cotizaciones
 */
define('COTIZACION_REALIZADA',1);
define('COTIZACION_ENVIADA',2);
define('COTIZACION_RECIBIDA',3);
define('COTIZACION_ORDEN_COMPRA',4);
define('COTIZACION_REGISTRO_ALUMNO_EMPRESA',5);
define('COTIZACION_EN_ESPERA_CURSO',6);
define('COTIZACION_FINALIZADO',7);
define('COTIZACION_CERRADA_CANCELADA',8);

define('ID_OTRO_A',99999);

define('PASS_CIVIKA2018','30e75439d9abe3fdb891cf3b88fa1f8c2c4ef63d');

define('ERROR_SOLICITUD','Ocurrio un error al procesar su solicitud, favor de intentar más tarde');
define('CUPO_LLENO_INSCRIPCION','se cubrio el monto de la inscripción, lamentablemente no alcanzo el cupo para el curso; nos contactaremos a la brevedad para darle seguimiento a su caso');
/**
 * Constantes para el metodo de pago
 */
define('SRC_JS_MP','https://www.mercadopago.com.mx/integrations/v1/web-tokenize-checkout.js');
if($_SERVER['SERVER_NAME'] == 'cursos.civika.edu.mx'){
    define('PUBLIC_KEY_MP','APP_USR-10e4ba65-5726-4d3d-8e9c-a0a27b0b9bd6');
    define('ACCESS_TOKEN_MP','APP_USR-2674302978955181-062811-b902a974454cac4a52aedff69fd95977-265303870');
}else{
    define('PUBLIC_KEY_MP','TEST-c5ff7e6f-c429-47ab-9fb9-16a906564969');
    define('ACCESS_TOKEN_MP','TEST-2674302978955181-062811-b02cd176292f6c43a42760b33d511f3d-265303870');
}
define('REINTENTAR_PAGO','Favor de verificar los datos de la tarjeta e intente nuevamente');


/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
