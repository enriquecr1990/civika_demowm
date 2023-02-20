<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdministrarCatalogos extends CI_Controller
{

    private $usuario;
    private $mensaje;
    private $type_msg;
    private $notificaciones;

    function __construct()
    {
        parent:: __construct();
        $this->load->model('CatalogosModel', 'CatalogosModel');
        $this->load->model('ControlUsuariosModel', 'ControlUsuariosModel');
        $this->load->model('NotificacionesModel', 'NotificacionesModel');
        $this->load->model('AutoguardadoModel');

        if (sesionActive()) {
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        } else {
            $this->usuario = false;
            redirect(base_url());
        }
    }

    /**
     * seccion para la aulas
     */
    public function aulas()
    {
        $data['seccion'] = 'Administrar Catálogos';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/aulas.js',
        );
        $data['extra_css'] = array();
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $this->load->view('cursos_civik/catalogos/aulas/tablero', $data);
    }

    public function aulas_resultados()
    {
        $data['catalogo_aulas'] = $this->CatalogosModel->obtenerCatalogoAulas();
        $this->load->view('cursos_civik/catalogos/aulas/resultados_busqueda', $data);
    }

    public function agregar_modificar_aula($idCatalogoAula = false)
    {
        $data = array();
        if ($idCatalogoAula) {
            $data['aula'] = $this->CatalogosModel->obtenerAulaById($idCatalogoAula);
        }
        $this->load->view('cursos_civik/catalogos/aulas/form_aula', $data);
    }

    public function guardar_catalogo_aula()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo guardar el aula, favor de intentar más tarde';
        if ($this->CatalogosModel->guardar_catalogo_aula($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo el aula con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function eliminar_aula($idCatalogoAula)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo eliminar el aula, favor de intentar más tarde';
        $operacion = $this->CatalogosModel->eliminar_aula($idCatalogoAula);
        if ($operacion['exito']) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se eliminó el aula con éxito';
        } else {
            $respuesta['msg'] = $operacion['msg'];
        }
        echo json_encode($respuesta);
        exit;
    }

    /*
     * seccion para las ocupaciones especificas
     */

    public function ocupaciones_especificas()
    {
        $data['seccion'] = 'Administrar Catálogos';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/ocupaciones_especificas.js',
        );
        $data['extra_css'] = array();
        $data['catalogo_ocupaciones_tablero'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $this->load->view('cursos_civik/catalogos/ocupacion_especifica/tablero', $data);
    }

    public function ocupaciones_especificas_resultados()
    {
        $data['catalogo_ocupaciones_tablero'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasTablero();
        $this->load->view('cursos_civik/catalogos/ocupacion_especifica/resultados_busqueda', $data);
    }

    public function agregar_modificar_ocupacion_especifica()
    {
        $post = $this->input->post();
        $data['tipo_ocupacion_especifica'] = $post['tipo_ocupacion_especifica'];
        $data['es_sub_area'] = $data['tipo_ocupacion_especifica'] == 'subarea';
        if (isset($post['id_catalogo_ocupacion_especifica']) && $post['id_catalogo_ocupacion_especifica'] != '') {
            $data['ocupacion_especifica'] = $this->CatalogosModel->obtenerCatalogoOcupacionEspecificaById($post['id_catalogo_ocupacion_especifica']);
        }
        if ($data['es_sub_area']) {
            $data['areas'] = $this->CatalogosModel->obtenerCatalogoOcupacionesEspecificasAreas();
        }
        $this->load->view('cursos_civik/catalogos/ocupacion_especifica/form_ocupacion_especifica', $data);
    }

    public function guardar_catalogo_ocupacion_especifica()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo guardar la ocupación especifíca, favor de intentar más tarde';
        if ($this->CatalogosModel->guardar_catalogo_ocupacion_especifica($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo el la ocupación específica con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * seccion para áreas temáticas
     */
    public function areas_tematicas()
    {
        $data['seccion'] = 'Administrar Catálogos';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/area_tematica.js',
        );
        $data['extra_css'] = array();
        $data['catalogo_area_tematica'] = $this->CatalogosModel->obtenerCatalogoAreaTematica();
        $this->load->view('cursos_civik/catalogos/area_tematica/tablero', $data);
    }

    public function area_tematica_resultados()
    {
        $data['catalogo_area_tematica'] = $this->CatalogosModel->obtenerCatalogoAreaTematica();
        $this->load->view('cursos_civik/catalogos/area_tematica/resultados_busqueda', $data);
    }

    public function agregar_modificar_area_tematica($idCatalogoAreaTematica = false)
    {
        $data = array();
        if ($idCatalogoAreaTematica) {
            $data['area_tematica'] = $this->CatalogosModel->obtenerAreaTematicaById($idCatalogoAreaTematica);
        }
        $this->load->view('cursos_civik/catalogos/area_tematica/form_area_tematica', $data);
    }

    public function guardar_catalogo_area_tematica()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo guardar el área temática, favor de intentar más tarde';
        if ($this->CatalogosModel->guardar_catalogo_area_tematica($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo el área temática con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function eliminar_catalogo_area_tematica($idCatalogoAreaTematica)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo eliminar el área temática, favor de intentar más tarde';
        $operacion = $this->CatalogosModel->eliminar_area_tematica($idCatalogoAreaTematica);
        if ($operacion['exito']) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se eliminó el área temática con éxito';
        } else {
            $respuesta['msg'] = $operacion['msg'];
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * seccion para formas de pago
     */

    //funcion que carga el tablero principal de formas de pago
    //la que es de la url: base_url() /AdministrarCatalogos/formas_pago
    public function formas_pago()
    {
        $data['seccion'] = 'Administrar Catálogos';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/formas_pago.js',
            //base_url().'extras/plugins/editorWord/tiny_mce.js',
            //base_url().'extras/plugins/editorWord/tiny.js',
        );
        $data['catalogo_formas_pago'] = $this->CatalogosModel->obtenerCatalogoFormasPagoAdmin();
        $post = $this->input->post();
        if (is_array($post) && sizeof($post) > 0) {
            $this->CatalogosModel->guardar_detalle_pdf($post);
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/catalogos/formas_pago/tablero', $data);
    }

    public function formas_pago_resultados()
    {
        $data['catalogo_formas_pago'] = $this->CatalogosModel->obtenerCatalogoFormasPagoAdmin();
        $data['catalogo_forma_pago_detalle'] = $this->CatalogosModel->obtener_forma_pago_detalle();
        //var_dump($data);exit;
        $this->load->view('cursos_civik/catalogos/formas_pago/resultados_busqueda', $data);
    }

    public function forma_pago_detalle()
    {
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/formas_pago.js',
            //base_url().'extras/plugins/editorWord/tiny_mce.js',
            //base_url().'extras/plugins/editorWord/tiny.js',
        );
        $data = array();
        $post = $this->input->post();
        $this->load->view('cursos_civik/catalogos/formas_pago/tablero', $data);

    }

    public function actualizar_forma_pago_detalle()
    {
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        $post = $this->input->post();
        if ($this->AutoguardadoModel->actualizar_campo_tabla($post)) {
            $result['exito'] = true;
            $result['msg'] = 'Se publicó la evaluación para los alumnos con éxito';
        }
        echo json_encode($result);
        exit;
    }

    public function agregar_modificar_formas_pago($idCatalogoFormasPago = false)
    {
        $data = array();
        if ($idCatalogoFormasPago) {
            $data['formas_pago'] = $this->CatalogosModel->obtenerFormasPagoById($idCatalogoFormasPago);
        }
        $this->load->view('cursos_civik/catalogos/formas_pago/form_registro', $data);
    }

    public function guardar_catalogo_formas_pago()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo guardar la forma de pago, favor de intentar más tarde';
        if ($this->CatalogosModel->guardar_catalogo_formas_pago($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo la forma de pago con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function eliminar_catalogo_formas_pago($idCatalogoFormasPago)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo eliminar la forma de pago, favor de intentar más tarde';
        if ($this->CatalogosModel->eliminar_formas_pago($idCatalogoFormasPago)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se eliminó la forma de pago con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    /**
     * seccion para las sedes de civika
     */
    public function sedes_presenciales()
    {
        $data['seccion'] = 'Administrar Catálogos';
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url() . 'extras/js/catalogos/sede_presencial.js',
        );
        //var_dump($data);exit;
        $this->load->view('cursos_civik/catalogos/sede_presencial/tablero', $data);
    }

    public function sedes_presenciales_resultados()
    {
        $data['array_sede_presencial'] = $this->CatalogosModel->obtener_sedes_civika();
        $this->load->view('cursos_civik/catalogos/sede_presencial/resultados_busqueda', $data);
    }

    public function agregar_modificar_sede_presencial($id_sede_presencial = false)
    {
        $data['usuarios_admin'] = $this->ControlUsuariosModel->obtener_usuarios_admin();
        if ($id_sede_presencial) {
            $data['sede_presencial'] = $this->CatalogosModel->obtener_sede_civika($id_sede_presencial);
        }
        //var_dump($data);exit;
        $this->load->view('cursos_civik/catalogos/sede_presencial/form_registro', $data);
    }

    public function guardar_sede_presencial()
    {
        $post = $this->input->post();
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo guardar la sede en el sistema, favor de intentar más tarde';
        if ($this->CatalogosModel->guardar_sede_presencial($post)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se guardo la sede en el sistema con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

    public function eliminar_sede_civika($id_sede_presencial)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No se pudo eliminar la sede, favor de intentar más tarde';
        if ($this->CatalogosModel->eliminar_sede_presencial($id_sede_presencial)) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = 'Se eliminó la sede del sistema con éxito';
        }
        echo json_encode($respuesta);
        exit;
    }

}