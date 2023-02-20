<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdministrarCTN extends CI_Controller {

    private $usuario;
    private $mensaje;
    private $type_msg;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('CatalogosModel','CatalogosModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('NotificacionesModel','NotificacionesModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('EncuestaSatisfaccionModel');
        $this->load->model('Cotizaciones_model');
        $this->load->model('Evaluacion_model');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    public function cursosOnline(){
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/OnlineTablero',$data);
    }

    public function cursos(){
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/tablero',$data);
    }

    public function buscarCursos($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $data = $this->CursosModel->buscarCursos($post,$pagina,$limit);
        $data['usuario'] = $this->usuario;
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/ResultadosBusqueda',$data);
    }

    public function agregarModificarCurso($idCursoTallerNorma = false){
        $data['catalogo_area_tematica'] = $this->CatalogosModel->obtenerCatalogoAreaTematica();
        $data['instructores'] = $this->ControlUsuariosModel->obtenerArrayUsuarioInstructor();
        if($idCursoTallerNorma !== false){
            $data['curso'] = $this->CursosModel->obtenerCursoById($idCursoTallerNorma);
            $data['instructores_ctn'] = $this->getInstructoresAsignadosCTN($idCursoTallerNorma);
        }
        $this->load->view('cursos_civik/admin_ctn/cursos/RegistrarModificar',$data);
    }

    public function guardarCurso(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar el curso';
        $post = $this->input->post();
        if($this->CursosModel->guardarCurso($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se guardo el curso con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function iniciar_cancelacion_curso($idCursoTallerNorma){
        $data = $this->CursosModel->obtenerPublicacionesCTN($idCursoTallerNorma);
        $this->load->view('cursos_civik/admin_ctn/cursos/confirmacion/cancelar_curso',$data);
    }

    public function cancelar_curso(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible cancelar el curso';
        $post = $this->input->post();
        if($this->CursosModel->guardar_cancelar_curso($post)){
            if(isset($post['notificacion_cancelacion']) && $post['notificacion_cancelacion'] == 'si'){
                $this->NotificacionesModel->notificar_cancelacion_curso($this->usuario->id_usuario,$post);
            }
            $result['exito'] = true;
            $result['msg'] = 'Se canceló el curso con éxito';
        }
        echo json_encode($result);
        exit;
    }

    /**
     * funciones para publicar curso
     */
    public function ver_detalle_publicacion_ctn($id_publicacion_ctn){
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['curso'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['publicacion_ctn_has_constancia'] = $this->CursosModel->obtener_publicacion_has_constancias($id_publicacion_ctn);
        $data['publicacion_ctn_banner'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'img');
        $data['publicacion_ctn_material_apoyo'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'doc');
        $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
        $data['instructores'] = $this->ControlUsuariosModel->obtenerArrayUsuarioInstructor();
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $data['catalogo_constancias'] = $this->CatalogosModel->obtenerCatalogoConstancias();
        $data['catalogo_coffe_break'] = $this->CatalogosModel->obtenerCatalogoCoffeBreak();
        $data['catalogo_prioridad_curso'] = $this->CatalogosModel->obtener_prioridad_cursos();
        $this->load->view('cursos_civik/admin_ctn/cursos/detalle_publicacion_curso',$data);
    }

    public function iniciarModificarPublicacionCTN($idCursoTallerNorma,$id_publicacion_ctn = false){
        $this->load->model('ControlUsuariosModel');
        $data['curso'] = $this->CursosModel->obtenerCursoById($idCursoTallerNorma);
        $data['instructores'] = $this->ControlUsuariosModel->obtenerArrayUsuarioInstructor();
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $data['catalogo_constancias'] = $this->CatalogosModel->obtenerCatalogoConstancias();
        $data['catalogo_coffe_break'] = $this->CatalogosModel->obtenerCatalogoCoffeBreak();
        $data['catalogo_prioridad_curso'] = $this->CatalogosModel->obtener_prioridad_cursos();
        $data['sede_presenciales'] = $this->CatalogosModel->obtener_sedes_civika();
        if($id_publicacion_ctn){
            $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
            $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN(array('id_publicacion_ctn' => $id_publicacion_ctn));
            $data['publicacion_ctn_has_constancia'] = $this->CursosModel->obtener_publicacion_has_constancias($id_publicacion_ctn);
            $data['publicacion_ctn_banner'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'img');
            if($data['publicacion_ctn']->publicacion_empresa_masiva == 'si'){
                $data['publicacion_ctn_banner'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'logo_empresa');
            }
            $data['publicacion_ctn_material_apoyo'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'doc');
            $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
            if(existe_valor($data['publicacion_ctn']->id_sede_presencial)){
                $data['sede_presencial_activa'] = $this->CatalogosModel->obtener_sede_civika($data['publicacion_ctn']->id_sede_presencial);
            }
        }
        //var_dump($data);exit;
        //$this->load->view('cursos_civik/admin_ctn/cursos/publicarCurso',$data);
        $this->load->view('cursos_civik/admin_ctn/cursos/publicar_curso_abierto',$data);
    }

    public function iniciar_modificacion_publicacion_ctn_masivo($id_curso_taller_norma, $id_publicacion_ctn = false){
        $this->load->model('ControlUsuariosModel');
        $post = $this->input->post();
        $data['id_cotizacion'] = isset($post['id_cotizacion']) ? $post['id_cotizacion'] : 0;
        $data['curso'] = $this->CursosModel->obtenerCursoById($id_curso_taller_norma);
        $data['instructores'] = $this->ControlUsuariosModel->obtenerArrayUsuarioInstructor();
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $data['catalogo_constancias'] = $this->CatalogosModel->obtenerCatalogoConstancias();
        $data['catalogo_coffe_break'] = $this->CatalogosModel->obtenerCatalogoCoffeBreak();
        $data['catalogo_prioridad_curso'] = $this->CatalogosModel->obtener_prioridad_cursos();
        if($id_publicacion_ctn){
            $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
            $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN(array('id_publicacion_ctn' => $id_publicacion_ctn));
            $data['publicacion_ctn_has_constancia'] = $this->CursosModel->obtener_publicacion_has_constancias($id_publicacion_ctn);
            $data['publicacion_ctn_banner'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'logo_empresa');
            $data['publicacion_ctn_material_apoyo'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'doc');
            $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
            $data['publicacion_ctn_empresa'] = $this->CursosModel->obtener_empresa_publicacion_ctn_masivo($id_publicacion_ctn);
        }
        $this->load->view('cursos_civik/admin_ctn/cursos/publicar_curso_masivo',$data);
    }

    public function guardarPublicacionCurso(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible publicar el curso';
        $post = $this->input->post();
        $publicacion_id = $this->CursosModel->guardarPublicacionCurso($post);
        if($publicacion_id){
            $result['exito'] = true;
            $result['msg'] = 'Se público el curso con éxito, los alumnos ya podran inscribirse hasta antes de que finalize el curso';
            $constancias_publicacion = $this->CursosModel->obtenerConstanciaDescripcion($publicacion_id);
            $result['mensaje_redes_sociales'] = '<div id="mensaje_redes_sociales_'.$publicacion_id.'">';
            $result['mensaje_redes_sociales'] .= $post['publicacion_ctn']['descripcion'].' ';
            $result['mensaje_redes_sociales'] .= '<br>CURSO: '.$post['publicacion_ctn']['nombre_curso_comercial'].' ';
            $result['mensaje_redes_sociales'] .= '<br>SEDE: '.$post['nombre_sede'].' ';
            $result['mensaje_redes_sociales'] .= '<br>Fecha: '.fecha_con_dia_sin_anio(fechaHtmlToBD($post['publicacion_ctn']['fecha_inicio'])).' ';
            $result['mensaje_redes_sociales'] .= ' de '.$post['publicacion_ctn']['horario'].' ';
            $result['mensaje_redes_sociales'] .= '<br>Duración curso: '.$post['publicacion_ctn']['duracion'].' ';
            $result['mensaje_redes_sociales'] .= ' Valor de la constancia: '.$post['valor_constancia'].' horas'.' ';
            $result['mensaje_redes_sociales'] .= '<br>Costo: $'.number_format($post['publicacion_ctn']['costo_en_tiempo'],2).'(IVA includo)'.' ';
            $result['mensaje_redes_sociales'] .= '<br>3, 6 , 9 y 12 meses sin interés en todas las tarjetas de crédito';
            $result['mensaje_redes_sociales'] .= '<br>Valor Curricular: ';
            foreach ($constancias_publicacion as $index => $cp){
                $result['mensaje_redes_sociales'] .= $cp->constancia;
                if($index < sizeof($constancias_publicacion) - 1){
                    $result['mensaje_redes_sociales'] .= ', ';
                }
            }
            $result['mensaje_redes_sociales'] .= '<br>DESCUENTOS Y ENTRADA LIBRE: CONSULTA BASES'.' ';
            $result['mensaje_redes_sociales'] .= '<br>Whatsapp: '.$this->usuario->telefono.' ';
            $result['mensaje_redes_sociales'] .= '<br>Oficina: '.$post['telefono_sede'].' ';
            $result['mensaje_redes_sociales'] .= '<br><a href="'.base_url().'?id_publicacion_ctn='.$publicacion_id.'" target="_blank">'.base_url().'?id_publicacion_ctn='.$publicacion_id.'</a>'.' ';
            $result['mensaje_redes_sociales'] .= '</div>';
            $btn_copy = '<button class="btn btn-sm btn-pill btn-success btn_copiar_link" data-url_to_copy="#mensaje_redes_sociales_'.$publicacion_id.'">Copiar Mensaje</button>';
            $result['mensaje_redes_sociales_btn'] = $btn_copy;
            if(isset($post['publicacion_ctn']['id_publicacion_ctn'])
                && $post['publicacion_ctn']['id_publicacion_ctn'] != 0
                && isset($post['notificacion_modificacion']) && $post['notificacion_modificacion'] == 'si'){
                $this->NotificacionesModel->notificar_modificacion_publicacion_curso($this->usuario->id_usuario,$post);
                $result['msg'] = 'Se actualizó el curso con éxito';
            }
        }else{
            $result['msg'] = $this->CursosModel->getMsgValidacion();
        }
        echo json_encode($result);
        exit;
    }

    public function guardar_publicacion_curso_empresa(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible publicar el curso';
        $post = $this->input->post();
        $publicacion = $this->CursosModel->guardar_publicacion_curso_empresa($post);
        if($publicacion){
            $result['exito'] = true;
            $result['msg'] = 'Se público el curso para la empresa con éxito, la empresa podra iniciar la carga de alumnos';
            if(isset($post['publicacion_ctn']['id_publicacion_ctn'])
                && $post['publicacion_ctn']['id_publicacion_ctn'] != 0
                && isset($post['notificacion_modificacion']) && $post['notificacion_modificacion'] == 'si'){
                $this->NotificacionesModel->notificar_modificacion_publicacion_curso($this->usuario->id_usuario,$post);
                $result['msg'] = 'Se actualizó el curso con éxito';
            }if(isset($post['id_cotizacion']) && $post['id_cotizacion'] != 0){
                $cotizacion['id_cotizacion'] = $post['id_cotizacion'];
                $cotizacion['id_catalogo_proceso_cotizacion'] = COTIZACION_REGISTRO_ALUMNO_EMPRESA;
                $cotizacion['id_publicacion_ctn'] = $publicacion;
                $this->Cotizaciones_model->actualizar_cotizacion($cotizacion);
            }
            if($publicacion !== true){
                $result['id_publicacion_ctn'] = $publicacion;
                $result['rfc'] = $post['publicacion_ctn_has_empresa_masivo']['rfc'];
                $result['correo'] = $post['publicacion_ctn_has_empresa_masivo']['correo'];
            }
        }else{
            $result['msg'] = $this->CursosModel->getMsgValidacion();
        }
        echo json_encode($result);
        exit;
    }

    public function guardar_publicacion_evaluacion_online(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible publicar el curso';
        $post = $this->input->post();
        $publicacion_id = $this->CursosModel->guardarPublicacionCurso($post);
        if($publicacion_id){
            $result['exito'] = true;
            $result['msg'] = 'Se público la evaluación en linea con éxito, para continuar es necesario que registre la evaluación y la publique para los alumnos';
            if(isset($post['publicacion_ctn']['id_publicacion_ctn'])
                && $post['publicacion_ctn']['id_publicacion_ctn'] != 0
                && isset($post['notificacion_modificacion']) && $post['notificacion_modificacion'] == 'si'){
                $this->NotificacionesModel->notificar_modificacion_publicacion_curso($this->usuario->id_usuario,$post);
                $result['msg'] = 'Se actualizó el curso con éxito';
            }
        }else{
            $result['msg'] = $this->CursosModel->getMsgValidacion();
        }
        echo json_encode($result);
        exit;
    }

    public function cargar_modal_notificar_informacion_empresa($id_publicacion_ctn){
        $data['id_publicacion_ctn'] = $id_publicacion_ctn;
        $data['rfc'] = $this->input->post('rfc');
        $data['correo'] = $this->input->post('correo');
        $data['id_cotizacion'] = $this->input->post('id_cotizacion');
        $this->load->view('cursos_civik/admin_ctn/cursos/envio_datos_publicacion_masiva',$data);
    }

    public function notificar_empresa_publicacion_ctn_masivo(){
        $post = $this->input->post();
        $result['exito'] = true;
        $result['msg'] = 'Se envió la informacion del curso para la empresa con éxito, la empresa podra iniciar la carga de alumnos.';
        if(!$this->NotificacionesModel->notificar_empresa_publicacion_ctn_masivo($post['id_publicacion_ctn'],$post['rfc'],$post['correo'])){
            $result['exito'] = false;
            $result['msg'] = 'Hay un problema con el proveedor de correo electrónico favor de intentar más tarde';
        }
        echo json_encode($result);exit;
    }

    public function enviar_correos_publicacion_ctn($id_publicacion_ctn){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible mandar los correos de la publicación';
        if($this->NotificacionesModel->enviar_correo_curso_publicado($id_publicacion_ctn)){
            $result['exito'] = true;
            $result['msg'] = 'Se enviaron correos electrónicos a todos los usuarios registrados en el sistema';
        }
        echo json_encode($result);
        exit;
    }

    public function iniciar_cancelacion_publicacion_curso($id_publicacion_ctn){
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN(array('id_publicacion_ctn' => $id_publicacion_ctn));
        $this->load->view('cursos_civik/admin_ctn/cursos/confirmacion/cancelar_publicacion_curso',$data);
    }

    public function cancelar_publicacion_curso(){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible cancelar la publicación del curso';
        $post = $this->input->post();
        if($this->CursosModel->guardar_cancelar_publicacion_curso($post)){
            if(isset($post['notificacion_cancelacion']) && $post['notificacion_cancelacion'] == 'si'){
                $this->NotificacionesModel->notificar_cancelacion_publicacion_curso($this->usuario->id_usuario,$post);
            }
            $result['exito'] = true;
            $result['msg'] = 'Se canceló el curso con éxito';
        }
        echo json_encode($result);
        exit;
    }

    //funciones para ver las publicaciones activas
    public function ver_publicaciones_ctn(){
        $data['get'] = $this->input->get();
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['catalogo_tipo_publicacion'] = $this->CatalogosModel->obtener_catalogo_tipo_publicacion();
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/usuario/control_usuarios.js',
            base_url().'extras/js/adminCtn/inscripciones.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/tablero_todas_publicaciones',$data);
    }

    public function buscar_todas_publicacion_ctn($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $data = $this->CursosModel->obtener_todas_publicaciones_ctn($post,$pagina,$limit);
        $data['usuario'] = $this->usuario;
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        //echo '<pre>';print_r($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/resultados_todas_publicaciones',$data);
    }

    public function verPublicacionCtn($idCursoTallerNorma){
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($idCursoTallerNorma);
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/usuario/control_usuarios.js',
            base_url().'extras/js/adminCtn/inscripciones.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/tablero',$data);
    }

    public function ver_publicacion_ctn_empresas($id_curso_taller_norma){
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($id_curso_taller_norma);
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/usuario/control_usuarios.js',
            base_url().'extras/js/adminCtn/inscripciones.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/tablero_empresa',$data);
    }

    public function buscar_publicaciones_curso($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $data = $this->CursosModel->obtener_publicaciones_ctn($post);
        $data['usuario'] = $this->usuario;
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        //var_dump($data);
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/resultados_publicaciones',$data);
    }

    public function registro_alumnos_publicacion_ctn($idPublicacionCTN){
        $data['usuario'] = $this->usuario;
        $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($idPublicacionCTN);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($idPublicacionCTN);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/registro_alumnos',$data);
    }

    public function registro_alumnos_pub_ctn($idPublicacionCTN){
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['catalogo_tipo_publicacion'] = $this->CatalogosModel->obtener_catalogo_tipo_publicacion();
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/usuario/control_usuarios.js',
            base_url().'extras/js/adminCtn/inscripciones.js',
            base_url().'extras/js/adminCtn/evaluacion_publicacion_ctn.js',
        );
        $data['usuario'] = $this->usuario;
        $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($idPublicacionCTN);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($idPublicacionCTN);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['catalogo_ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/registro_alumnos_page',$data);
    }

    public function registro_antologia($id_publicacion_ctn){
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['archivos_vademecum'] = $this->CursosModel->obtenerMaterialDidactico($id_publicacion_ctn);
        $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
        $this->load->view('cursos_civik/admin_ctn/cursos/antologia_modal',$data);
    }

    public function buscar_registro_alumnos_publicacion_ctn(){
        $post = $this->input->post();
        $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN($post);
        $data['alumnos_asistieron'] = $this->CursosModel->obtener_numero_alumnos_asistieron_curso_publicado($post['id_publicacion_ctn']);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($post['id_publicacion_ctn']);
        $publicacion_ctn_has_empresa = $this->CursosModel->obtener_empresa_publicacion_ctn_masivo($post['id_publicacion_ctn']);
        $data['es_publicacion_empresa'] = false;
        if($publicacion_ctn_has_empresa !== false){
            $data['es_publicacion_empresa'] = true;
            $data['realizo_envio_empresa_masivo'] = isset($publicacion_ctn_has_empresa->fecha_envio_informacion) && !is_null($publicacion_ctn_has_empresa->fecha_envio_informacion);
        }
        //echo '<pre>';var_dump($data);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/registro_alumnos_resultados',$data);
    }

    public function registrar_asistencia_alumno(){
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible registrar la asistencia del alumno';
        if($this->CursosModel->registrar_asistencia_alumno($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se registró el dato de la asistencia del alumno con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function registrar_asistencia_masiva_alumno(){
        $post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible registrar la asistencia masiva de los alumnos';
        if($this->CursosModel->registrar_asistencia_masiva_alumno($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se registró la asistencia masiva de los alumno con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function iniciar_registro_nuevo_alumno_ctn_publicado($id_publicacion_ctn){
        $data['id_publicacion_ctn'] = $id_publicacion_ctn;
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/registro_nuevo_alumno_ctn_publicado',$data);
    }

    public function iniciar_publicacion_galeria_ctn($id_publicacion_ctn){
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['curso_taller_norma'] = $this->CursosModel->obtenerCursoById($data['publicacion_ctn']->id_curso_taller_norma);
        $data['publicacion_ctn_galeria'] = $this->CursosModel->obtener_publicacion_ctn_galeria($id_publicacion_ctn);
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/publicar_galeria_ctn',$data);
    }

    public function eliminar_img_galeria($id_documento){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible eliminar la imagen de la gelaria de curso';
        if($this->CursosModel->eliminar_publicacion_ctn_has_img_galeria($id_documento)){
            $result['exito'] = true;
            $result['msg'] = 'Se eliminó la imagen de la galeria del curso';
        }
        echo json_encode($result);
        exit;
    }

    public function buscar_alumnos_sistema($pagina = 1,$limit = 10){
        $this->load->model('ControlUsuariosModel');
        $post = $this->input->post();
        $data = $this->ControlUsuariosModel->obtener_usuario_alumnos_sistema($post,$pagina,$limit);
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        $data['id_publicacion_ctn'] = $post['id_publicacion_ctn'];
        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumnos_sistema',$data);
    }

    /**
     * apartado de funciones para la encuesta de satisfaccion admin
     */
    public function iniciar_encuesta_satisfacion_admin($id_instructor_asignado_ctn_publicado){
        $data = $this->EncuestaSatisfaccionModel->iniciar_encuesta_satisfacion_admin($id_instructor_asignado_ctn_publicado);
        $this->load->View('cursos_civik/admin_ctn/cursos/publicacion/encuesta_satisfaccion_admin',$data);
    }

    public function actualizar_dato_encuesta_admin(){
        $this->load->model('AutoguardadoModel');
        $post = $this->input->post();
        $data['exito'] = false;
        $data['msg'] = ERROR_SOLICITUD;
        if($post['value_update'] <= 100){
            if($this->AutoguardadoModel->actualizar_campo_tabla($post)){
                $validacion = $this->EncuestaSatisfaccionModel->validar_guardado_encuesta_satisfaccion($post['id_value_update']);
                $data['exito'] = true;
                $data['msg'] = 'Guardado';
                if(!$validacion['valido']){
                    $data['exito']= false;
                    $data['msg'] = $validacion['msg'];
                }
            }
        }else{
            $data['msg'] = 'El dato no puede ser mayor 100%';
        }
        echo json_encode($data);
        exit;
    }

    public function asistencia_alumnos(){
        $data['seccion'] = 'Administrar CTN';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/plugins/datepicker/locales/bootstrap-datepicker.es.min.js',
        );
        $this->load->view('cursos_civik/admin_ctn/cursos/tablero_asistencia',$data);
    }

    public function buscar_tablero_asistencia(){
        $post = $this->input->post();
        $data['array_asistencia_cursos'] = $this->CursosModel->buscar_tablero_asistencia($post);
        $this->load->view('cursos_civik/admin_ctn/cursos/resultado_busqueda_asistencia',$data);
    }

    /**
     * apartado de funciones para las evaluaciones online
     */
    public function iniciar_modificacion_publicacion_evaluacion_online($id_curso_taller_norma, $id_publicacion_ctn = false){
        $this->load->model('ControlUsuariosModel');
        $post = $this->input->post();
        $data['id_cotizacion'] = isset($post['id_cotizacion']) ? $post['id_cotizacion'] : 0;
        $data['curso'] = $this->CursosModel->obtenerCursoById($id_curso_taller_norma);
        $data['instructores'] = $this->ControlUsuariosModel->obtenerArrayUsuarioInstructor();
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $data['catalogo_constancias'] = $this->CatalogosModel->obtenerCatalogoConstancias();
        if($id_publicacion_ctn){
            $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
            $data['array_alumnos_publicacion'] = $this->CursosModel->obtenerAlumnosInscritosPublicacionCTN(array('id_publicacion_ctn' => $id_publicacion_ctn));
            $data['publicacion_ctn_has_constancia'] = $this->CursosModel->obtener_publicacion_has_constancias($id_publicacion_ctn);
            $data['publicacion_ctn_banner'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'img');
            $data['publicacion_ctn_material_apoyo'] = $this->CursosModel->obtener_banner_docs_publicacion_ctn($id_publicacion_ctn,'doc');
            $data['instructores_asignados'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn);
            $data['publicacion_ctn_empresa'] = $this->CursosModel->obtener_empresa_publicacion_ctn_masivo($id_publicacion_ctn);
        }
        $this->load->view('cursos_civik/admin_ctn/cursos/publicar_evaluacion_online',$data);
    }

    public function publicar_link_evaluacion_online($id_publicacion_ctn){
        $data['id_publicacion_ctn'] = $id_publicacion_ctn;
        $data['evaluacion_online_ctn'] = $this->Evaluacion_model->obtener_evaluacion_online_ctn($id_publicacion_ctn);
        $this->load->view('cursos_civik/admin_ctn/cursos/publicar_link_evaluacion_online',$data);
    }

    public function guardar_evalucacion_online_link(){
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = ERROR_SOLICITUD;
        if($this->Evaluacion_model->guardar_evaluacion_online_link($post)){
            if($post['empresa'] == 'si'){
                $this->NotificacionesModel->enviar_correo_evaluacion_online_link($post);
            }
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se generó el link del curso con exito';
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * apartado de funciones privadas
     */
    private function getInstructoresAsignadosCTN($idCursoTallerNorma){
        $instructores_asignados = $this->CursosModel->obtener_ctn_has_instructores($idCursoTallerNorma);
        $idsInstructores = array();
        foreach ($instructores_asignados as $i){
            array_push($idsInstructores,$i->id_instructor);
        }
        return $idsInstructores;
    }

}