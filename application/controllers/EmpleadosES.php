<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmpleadosES extends CI_Controller {

    public $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('EmpleadosESModel');
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
     * apartado de funciones para el control de empleados ES
     */

    public function CursosNormasAsea(){
        $idEmpleadoEs = $this->obtenerIdEmpleadoEs();
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/asea/empleados_es/empleados_es.js'
        );
        $data['catalogo_anios'] = $this->CatalogosAseaModel->obtenerCatalogoAnio();
        $data['normas_asea'] = $this->EmpleadosESModel->obtenerNormasAseaDisponibles($idEmpleadoEs);
        $this->load->view('asea/empleados_es/CursosNormasAsea',$data);
    }

    public function iniciarCursoNormaAsea($idNormasAsea){
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormasAsea);
        $data['actividades_norma'] = $this->EmpleadosESModel->obtenerActividadesNorma($idNormasAsea);
        $data['tiempo_actividades'] = $this->EmpleadosESModel->obtenerTiempoActividadesNorma($idNormasAsea);
        $this->load->view('asea/empleados_es/CursarNormaAsea',$data);
    }

    public function registrarEmpleadoCursoNormaAsea(){
        $form_post = $this->input->post();
        $form_post['id_empleado_es'] = $this->obtenerIdEmpleadoEs();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible registrar el curso que está tomando, favor de intentar más tarde';
        if($this->EmpleadosESModel->registrarEmpleadoCursoNormaAsea($form_post)){
            $result['exito'] = true;
            $result['msg'] = 'Se registro el curso que acaba de tomar, puede realizar su evaluación';
        }
        echo json_encode($result);
        exit;
    }

    public function consultarCursosNorma($periodo=false){
        $idEmpleadoEs = $this->obtenerIdEmpleadoEs();
        $data['normas_asea'] = $this->EmpleadosESModel->obtenerNormasAseaDisponibles($idEmpleadoEs,$periodo);
        $this->load->view('asea/empleados_es/ListaCursosNormasAsea',$data);
    }

    public function obtenerEvaluacionesNormas($idNormasAsea){
        $idEmpleadoEs = $this->obtenerIdEmpleadoEs();
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormasAsea);
        $data['evaluaciones_norma_asea'] = $this->EmpleadosESModel->obtenerListaEvaluacionesNorma($idNormasAsea,$idEmpleadoEs);
        $data['existe_aprobado'] = false;
        if($data['evaluaciones_norma_asea']){
            foreach($data['evaluaciones_norma_asea'] as $ena){
                if($ena->aprobado){
                    $data['existe_aprobado'] = true;
                }
            }
        }
        $data['empleado_es'] = $this->EmpleadosESModel->obtenerEmpleadoEs($idEmpleadoEs);
        $this->load->view('asea/empleados_es/ListaEvaluacionesNormaAsea',$data);
    }

    public function iniciarEvaluacionNorma($idNormasAsea){
        $data['usuario'] = $this->usuario;
        $idEmpleadoEs = $this->obtenerIdEmpleadoEs();
        //$data['evaluacion_norma_asea'] = $this->EmpleadosESModel->obtenerEvaluacionNormaEmpleado($idNormasAsea,$idEmpleadoEs);
        $data['empleado_es'] = $this->EmpleadosESModel->obtenerEmpleadoEs($idEmpleadoEs);
        $data['extra_js'] = array(
            base_url().'extras/asea/empleados_es/empleados_es.js'
        );
        $data['normas_asea'] = $this->NormasASEAModel->obtenerNormaAsea($idNormasAsea);
        $data['evaluaciones_norma_asea'] = $this->EmpleadosESModel->obtenerListaEvaluacionesNorma($idNormasAsea,$idEmpleadoEs);
        $data['puede_evaluar'] = sizeof($data['evaluaciones_norma_asea']) < 3 ? true : false;
        $data['preguntas_normas'] = $this->EmpleadosESModel->obtenerListaPreguntasNorma($idNormasAsea);
        $data['evaluaciones_norma_asea'] = $this->EmpleadosESModel->obtenerListaEvaluacionesNorma($idNormasAsea,$idEmpleadoEs);
        $data['existe_aprobado'] = false;
        if($data['evaluaciones_norma_asea']){
            foreach($data['evaluaciones_norma_asea'] as $ena){
                if($ena->aprobado){
                    $data['existe_aprobado'] = true;
                }
            }
        }
        //var_dump($data);exit;
        $this->load->view('asea/empleados_es/EvaluacionNormaAsea',$data);
    }

    public function guardarEvaluacionEmpleadoEs(){
        $form_post = $this->input->post();
        $form_post['evaluacion_norma_asea']['id_empleado_es'] = $this->obtenerIdEmpleadoEs();
        $result['exito'] = false;
        $result['msg'] = 'No fue posible mandar su evaluación favor de intentar más tarde';
        if($this->EmpleadosESModel->guardarEvaluacionEmpleadoEs($form_post)){
            $result['exito'] = false;
            $result['msg'] = 'Se mando su evaluación con exito en el sistema';
        }
        echo json_encode($result);
        exit;
    }

    public function constanciaDC3($idNormasAsea,$idEmpleadoES,$tipo){
        $this->EmpleadosESModel->generarConstanciaDC3($idNormasAsea,$idEmpleadoES,$tipo);
    }

    public function modificarEmpleadoESSistema($idEmpleadosES){
        $this->load->model('ControlUsuariosModel');
        $data['empleado'] = $this->EmpleadosESModel->obtenerEmpleadoEs($idEmpleadosES);
        $data['usuario'] = $this->ControlUsuariosModel->obtenerUsuario($data['empleado']->id_usuario);
        $this->load->view('asea/empleados_es/FormEmpleadoES',$data);
    }

    public function guardarEmpleadosESSistema(){
        $this->load->model('EstacionServicioModel');
        $post = $this->input->post();
        $result = $this->EstacionServicioModel->guardarEmpleadosES($post);
        echo json_encode($result);
        exit;
    }

    /**
     * apartado de funciones privadas de los empleados ES
     */

    private function obtenerIdEmpleadoEs(){
        return $this->usuario->id_empleado_es;
    }

}