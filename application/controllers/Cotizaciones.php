<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('AutoguardadoModel');
        $this->load->model('ControlUsuariosModel','ControlUsuariosModel');
        $this->load->model('CatalogosModel');
        $this->load->model('Evaluacion_model');
        $this->load->model('NotificacionesModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('Cotizaciones_model');
        $this->load->model('DocumentosModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
        }
    }

    public function index(){
        $data['seccion'] = 'Cotizaciones';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/cotizaciones/cotizacion.js',
            base_url().'extras/plugins/datepicker/locales/bootstrap-datepicker.es.min.js',
        );
        //var_dump($data);exit;
        $get = $this->input->get();
        $data['folio_cotizacion'] = isset($get['folio']) ? $get['folio'] : '';
        $this->load->view('cursos_civik/cotizaciones/tablero_cotizaciones',$data);
    }

    public function buscar_cotizaciones($pagina = 1,$limit = 5){
        $post = $this->input->post();
        $data = $this->Cotizaciones_model->obtener_data_cotizaciones($post,$pagina,$limit);
        $data['catalogo_proceso_cotizacion'] = $this->CatalogosModel->obtener_catalogo_proceso_cotizacion();
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
        $this->load->view('cursos_civik/cotizaciones/resultados_cotizaciones',$data);
    }

    public function agregar_modificar_cotizacion($id_cotizacion = false){
        $data['cursos_stps'] = $this->CursosModel->obtener_cursos_disponibles_stps();
        if($id_cotizacion){
            $data['cotizacion'] = $this->Cotizaciones_model->obtener_cotizacion($id_cotizacion);
        }
        $this->load->view('cursos_civik/cotizaciones/formulario_cotizacion',$data);
    }

    public function guardar_cotizacion_inicial(){
        $post = $this->input->post();
        $resultado['success'] = false;
        $resultado['msg'] = ERROR_SOLICITUD;
        if($this->Cotizaciones_model->guardar_cotizacion_inicial($post)){
            $resultado['success'] = true;
            $resultado['msg'] = 'Se guardó la cotizacion con éxito';
        }
        echo json_encode($resultado);
        exit;
    }

    public function enviar_cotizacion_empresa($id_cotizacion){
        $actualizar['id_cotizacion'] = $id_cotizacion;
        $actualizar['id_catalogo_proceso_cotizacion'] = COTIZACION_ENVIADA;
        $actualizar['fecha_envio'] = todayBD();
        $this->Cotizaciones_model->actualizar_cotizacion($actualizar);
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        if($this->NotificacionesModel->enviar_notificacion_empresa_cotizacion($id_cotizacion)){
            $result['exito'] = true;
            $result['msg'] = 'Se envio la cotización al correo registrado en el sistema';
        }
        echo json_encode($result);
        exit;
    }

    public function recibir($id_cotizacion){
        $cotizacion = $this->Cotizaciones_model->obtener_cotizacion($id_cotizacion);
        if($cotizacion->id_catalogo_proceso_cotizacion == COTIZACION_ENVIADA){
            $actualizar['id_cotizacion'] = $id_cotizacion;
            $actualizar['id_catalogo_proceso_cotizacion'] = COTIZACION_RECIBIDA;
            $actualizar['fecha_recepcion'] = todayBD();
            $this->Cotizaciones_model->actualizar_cotizacion($actualizar);
            $cotizacion = $this->Cotizaciones_model->obtener_cotizacion($id_cotizacion);
        }
        $data['seccion'] = 'Cotizaciones';
        $data['usuario'] = $this->usuario;
        $data['notificaciones'] = $this->notificaciones;
        $data['extra_js'] = array(
            base_url().'extras/js/adminCtn/cursos.js',
            base_url().'extras/js/cotizaciones/cotizacion.js',
            base_url().'extras/plugins/datepicker/locales/bootstrap-datepicker.es.min.js',
        );
        $data['cotizacion'] = $cotizacion;
        $data['comprobante_xml'] = false;
        $data['comprobante_pdf'] = false;
        if(existe_valor($cotizacion->id_documento_factura_xml)){
            $data['comprobante_xml'] = $this->DocumentosModel->obtenerDocumentoById($cotizacion->id_documento_factura_xml);
        }if(existe_valor($cotizacion->id_documento_factura_pdf)){
            $data['comprobante_pdf'] = $this->DocumentosModel->obtenerDocumentoById($cotizacion->id_documento_factura_pdf);
        }
        $data['datos_fiscales'] = $this->Cotizaciones_model->obtener_datos_fiscales_cotizales($id_cotizacion);
        $data['catalogo_uso_cfdi_persona_fisica'] = $this->CatalogosModel->obtenerUsoCFDI('fisica');
        $data['catalogo_uso_cfdi_persona_moral'] = $this->CatalogosModel->obtenerUsoCFDI('moral');
        $this->load->view('cursos_civik/cotizaciones/recibir_empresa',$data);
    }

    public function aceptar_cotizacion_empresa(){
        $result['exito'] = false;
        $result['msg'] = ERROR_SOLICITUD;
        $post = $this->input->post();
        if($this->Cotizaciones_model->aceptar_cotizacion_empresa($post)){
            if($this->NotificacionesModel->enviar_notificacion_empresa_cotizacion_aceptacion($post['cotizacion']['id_cotizacion'])){
                $result['exito'] = true;
                $result['msg'] = 'Se aceptó la cotización del curso, espera a su publicación en envio de su factura XML/PDF';
            }
        }
        $result['id_cotizacion'] = $post['cotizacion']['id_cotizacion'];
        echo json_encode($result);
        exit;
    }

}