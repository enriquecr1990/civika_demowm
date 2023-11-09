	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'admin/index';
$route['default_controller'] = 'publico/index';
$route['404_override'] = 'admin/no_encontrado';
$route['translate_uri_dashes'] = FALSE;

//rutas extras
$route['login'] = 'Login/index';
$route['cerrar_sesion'] = 'Login/cerrar_sesion';
$route['recuperar_password'] = 'Login/recuperar_password';
$route['registro/(:num)'] = 'Login/registro/$1';
$route['unsubscribe'] = 'Login/darse_baja';

$route['estandar_competencia'] = 'EC/index';
$route['estandar_competencia/convocatoria/(:num)'] = 'ConvocatoriasEC/index/$1';
$route['tecnicas_instrumentos/(:any)'] = 'TecnicasInstrumentos/index/$1';
$route['evaluacion_cerrada/(:any)/(:any)'] = 'EvaluacionEC/index/$1/$2';
$route['evaluacion_diagnostica/(:num)/(:num)'] = 'AlumnosEC/evaluacion_diagnostica/$1/$2';
$route['evaluacion_entregable/(:num)/(:num)'] = 'AlumnosEC/evaluacion_entregable/$1/$2';
$route['evaluacion_modulo/(:num)/(:num)'] = 'AlumnosEC/evaluacion_modulo/$1/$2';
$route['cuestionario_ati/(:num)/(:num)'] = 'EvaluacionEC/cuestionario_ati/$1/$2';
$route['preguntas_abiertas/(:num)'] = 'PreguntasAbiertas/index/$1';
$route['respuestas_preguntas_abiertas/(:num)'] = 'PreguntasAbiertas/formulario_respuestas/$1';
$route['evaluacion_calificacion/(:num)'] = 'AlumnosEC/calificacion_evaluacion/$1';
$route['ver_evaluacion/(:num)'] = 'AlumnosEC/ver_evaluacion/$1';
$route['encuesta/(:num)/(:num)'] = 'EncuestaSatisfaccion/candidato/$1/$2';
$route['encuesta_candidato/(:num)/(:num)'] = 'EncuestaSatisfaccion/candidato_lectura/$1/$2';
$route['modulo_capacitacion/(:num)'] = 'Curso/index/$1';
$route['modulo_capacitacion/modulo/(:num)'] = 'Curso/index_curso_modulos/$1';
//rutas para la evaluacion del cuestionario del instrumento
$route['evaluacion_instrumento/(:num)/(:num)'] = 'AlumnosEC/evaluacion_instrumento/$1/$2';
$route['403'] = 'admin/sin_permisos';
$route['404'] = 'admin/no_encontrado';
$route['500'] = 'admin/error_sistema';

//rutas para las opciones del menu
$route['contacto'] = 'Informacion/contacto';
$route['quienes_somos'] = 'Informacion/quienes_somos';

$route['show-session'] = 'Welcome/sesion';
$route['evidencias_esperadas/(:num)'] = 'Entregable/index/$1';
$route['evidencias_esperadas/candidato/(:num)'] = 'Entregable/index_candidato/$1';

/**
 * rutas para los catalogos
 */
$route['catalogos/msg-bienvenida'] = 'Catalogos/bienvenida';
$route['catalogos/sectores'] = 'Catalogos/sectores';

/**
 * rutas para los perfiles y usuarios
 */
$route['perfil_permisos'] = 'PerfilPermiso/index';
$route['candidato/perfil/(:num)'] = 'Perfil/editar/$1';
$route['usuario/administradores'] = 'Usuario/administradores';
$route['usuario/evaluadores'] = 'Usuario/evaluadores';
$route['usuario/candidatos'] = 'Usuario/candidatos';
