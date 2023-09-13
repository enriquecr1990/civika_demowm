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


define('EXTENSIONES_FILES_IMG', 'png|jpg|jpeg|gif|tiff');
define('EXTENSIONES_FILES_PDF', 'pdf');
define('EXTENSIONES_FILES_ATI', 'png|jpg|jpeg|gif|tiff|pdf');
define('MAX_FILESIZE', 15000000);
define('RUTA_PDF_TEMP','files_usr/temp/');
define('RUTA_PDF_PED','files_usr/ped/');

/**
 * constantes para los perfiles de usuario
 */
define('PERFIL_INSTRUCTOR',3);
define('PERFIL_ALUMNO',4);

/**
 * constantes para los estatus de proceso
 */
define('ESTATUS_EN_CAPTURA',1);
define('ESTATUS_ENVIADA',2);
define('ESTATUS_OBSERVACIONES',3);
define('ESTATUS_FINALIZADA',4);

/**
 * constantes para las evaluaciones
 */
define('EVALUACION_DIAGNOSTICA',1);
define('EVALUACION_CUESTIONARIO_INSTRUMENTO',2);
define('EVALUACION_ENCUESTA_SATISFACCION',3);

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
 * constantes para los archivos del expediente
 */
define('EXPEDIENTE_FICHA_REGISTRO',1);
define('EXPEDIENTE_INSTRUMENTO_EVA',2);
define('EXPEDIENTE_CERTIFICADO_EC',3);

/**
 * CONSTANTES PARA LOS INSTRUMENTOS DE EVALUACION
 */
define('INSTRUMENTO_GUIA_OBSERVACION',1);
define('INSTRUMENTO_LISTA_COTEJO',2);
define('INSTRUMENTO_CUESTIONARIO',3);
