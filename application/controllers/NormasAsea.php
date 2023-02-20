<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NormasAsea extends CI_Controller {

    public $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('NormasASEAModel');
        $this->load->model('CatalogosAseaModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
        }else{
            $this->usuario = false;
            redirect(base_url('Asea'));
        }
    }

    /*
     * apartado de funciones para la administracion de normas asea
     */

    public function ControlNormasAsea(){
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/datepicker/js/bootstrap-datepicker.js',
            base_url().'extras/datepicker/locales/bootstrap-datepicker.es.min.js',
            base_url().'extras/asea/normas/normas_asea.js',
        );
        $data['catalogo_anios'] = $this->CatalogosAseaModel->obtenerCatalogoAnio();
        $this->load->view('asea/normas/PrincipalNormas',$data);
    }

    public function buscarNormasAsea(){
        $data['usuario'] = $this->usuario;
        $campos_busqueda = $this->input->post();
        //var_dump($data);exit;
        if(isset($data['usuario']->es_administrador) && $data['usuario']->es_administrador
            || isset($data['usuario']->es_admin) && $data['usuario']->es_admin){
            $data['listaNormasAsea'] = $this->NormasASEAModel->obtenerListaNormasAsea($campos_busqueda);
        }else{
            $data['listaNormasAsea'] = $this->NormasASEAModel->obtenerListaNormasAseaEstacionEmpleado($campos_busqueda,$data['usuario']->id_estacion_servicio);
        }
        $this->load->view('asea/normas/BusquedaNormas',$data);
    }

    public function agregarModificarNormaAsea($id_norma_asea=false){
        $data['catalogo_anios'] = $this->CatalogosAseaModel->obtenerCatalogoAnio();
        $data['catalogo_ordenamiento_norma'] = $this->CatalogosAseaModel->obtenerOrdenamientoNorma();
        $data['titulo_norma'] = $id_norma_asea ? 'Modificiar norma ASEA' : 'Registrar nueva norma ASEA';
        if($id_norma_asea){
            $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($id_norma_asea);
        }
        $this->load->view('asea/normas/RegistrarModificarNorma',$data);
    }

    public function guardarNormaAsea(){
        $form_post = $this->input->post();
        $result = $this->NormasASEAModel->guardarNormaAsea($form_post['normas_asea']);
        echo json_encode($result);
    }

    public function guardarActividadesNorma(){
        $form_post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar las actividades norma con éxito, favor de intentar más tarde';
        if($this->NormasASEAModel->guardarActividadesNorma($form_post)){
            $result['exito'] = true;
            $result['msg'] = 'Se guardaron las actividades norma con éxito';
        }
        echo json_encode($result);
    }

    public function inicarNavegacionSeleccionarVideo(){
        $post = $this->input->post();
        $ruta = RUTA_VIDEOS_NORMAS;
        $data['ruta_videos'] = listar_directorios_ruta($ruta);
        $data['destino_video'] = $post['destino_video'];
        $this->load->view('asea/normas/RegistroActividadVideo',$data);
    }

    public function consultarNormaAseaActividades($id_norma_asea){
        $editar_norma = $this->input->post('editar_norma') == 'true' ? true : false;
        $data['normasAsea'] = $this->NormasASEAModel->obtenerNormaAsea($id_norma_asea);
        $data['listaActividadesNorma'] = $this->NormasASEAModel->obtenerListaActividades($id_norma_asea);
        $data['tituloConsultarNorma'] = 'Consultar norma ASEA';
        $data['editarNormaActividad'] = false;
        if($editar_norma){
            $data['tituloConsultarNorma'] = 'Agregar actividades norma ASEA';
            $data['editarNormaActividad'] = true;
        }
        //var_dump($data['listaActividadesNorma']);exit;
        $this->load->view('asea/normas/ConsultarNormaActividades',$data);
    }

    public function consultarActividadesNorma($idNormasAsea){
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormasAsea);
        $data['actividades_norma'] = $this->NormasASEAModel->obtenerListaActividades($idNormasAsea);
        $this->load->view('asea/estacion_servicio/ConsultarActividadesNorma',$data);
    }

    public function eliminarNormaAsea($id_norma_asea){
        $result['exito'] = false;
        $result['msg'] = 'Ocurrio un error al eliminar la norma ASEA';
        $result['destino'] = '#error_eliminar_registro';
        if($this->NormasASEAModel->eliminarNormaAsea($id_norma_asea)){
            $result['exito'] = true;
            $result['msg'] = 'Se elimino la norma ASEA del sistema';
            $result['destino'] = '#guardar_form_busqueda_normas_asea';
        }
        echo json_encode($result);
    }

    public function registrarPreguntasNorma($idNormaAsea){
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/datepicker/js/bootstrap-datepicker.js',
            base_url().'extras/datepicker/locales/bootstrap-datepicker.es.min.js',
            base_url().'extras/asea/normas/normas_asea.js'
        );
        $data['catalogo_opciones_pregunta'] = $this->CatalogosAseaModel->obtenerCatalogoOpcionesPregunta();
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormaAsea);
        $data['preguntas_normas_asea'] = $this->NormasASEAModel->obtenerListaPreguntasNorma($idNormaAsea);
        $data['tiene_evaluacion_norma'] = $this->NormasASEAModel->tieneEvaluacionNormaAsea($idNormaAsea);
        $this->load->view('asea/normas/examen/PreguntasNormaAsea',$data);
    }

    public function buscarPreguntasNorma($idNormaAsea){
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormaAsea);
        $data['preguntas_normas_asea'] = $this->NormasASEAModel->obtenerListaPreguntasNorma($idNormaAsea);
        $data['tiene_evaluacion_norma'] = $this->NormasASEAModel->tieneEvaluacionNormaAsea($idNormaAsea);
        $this->load->view('asea/normas/examen/BusquedaPreguntasNormaAsea',$data);
    }

    public function agregarModificarPreguntaNorma($idPreguntaNormaAsea=false){
        $post = $this->input->post();
        $data['catalogo_opciones_pregunta'] = $this->CatalogosAseaModel->obtenerCatalogoOpcionesPregunta();
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($post['id_normas_asea']);
        $data['tiene_evaluacion_norma'] = $this->NormasASEAModel->tieneEvaluacionNormaAsea($post['id_normas_asea']);
        if($idPreguntaNormaAsea){
            $data['pregunta_norma_asea'] = $this->NormasASEAModel->obtenerPreguntaRespuetasNorma($idPreguntaNormaAsea);
            $data['vista_preguntas'] = $this->obtenerVistaRegistroPregunta($data['pregunta_norma_asea']->id_opciones_pregunta);
        }
        //var_dump($data['pregunta_norma_asea']);exit;
        $this->load->view('asea/normas/examen/RegistroPreguntaNorma',$data);
    }

    public function registrarRespuestasPreguntaNorma($idTipoPregunta){
        $view_load = $this->obtenerVistaRegistroPregunta($idTipoPregunta);
        if($view_load != ''){
            $this->load->view('asea/normas/examen/'.$view_load);
        }else{
            echo '<span class="label label-primary">Selecione un tipo de pregunta</span>';
        }
    }

    public function guardarPreguntaRespuestasNorma(){
        $form_post = $this->input->post();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible guardar la pregunta y las respuestas de la norma, intentar más tarde';
        if($this->NormasASEAModel->guardarPreguntaRespuestasNorma($form_post)){
            $result['exito'] = true;
            $result['msg'] = 'Se registró la pregunta y las respuestas de la norma con éxito';
        }
        echo json_encode($result);
    }

    public function eliminarPreguntaNormaAsea($idPreguntasNormasAsea){
        $result['exito'] = false;
        $result['msg'] = 'Ocurrio un error al eliminar la norma ASEA';
        $result['destino'] = '#conteiner_mensajes_sistema_asea';
        if($this->NormasASEAModel->eliminarPreguntaNormaAsea($idPreguntasNormasAsea)){
            $result['exito'] = true;
            $result['msg'] = 'Se elimino la pregunta de la norma del sistema';
        }
        echo json_encode($result);
    }

    /*
     * apartado para metodo privadaos al controllador
     */

    private function obtenerVistaRegistroPregunta($idTipoPregunta){
        $view_load = '';
        switch($idTipoPregunta){
            case 1: $view_load = 'RegistroPreguntaVF';break;
            case 2: $view_load = 'RegistroPreguntaUO';break;
            case 3: $view_load = 'RegistroPreguntaOM';break;
        }
        return $view_load;
    }
}