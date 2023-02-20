<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PagoOnline extends CI_Controller {

    private $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('NotificacionesModel');
        $this->load->model('PagoOnlineModel');
        $this->load->model('administrarCTN/CursosModel', 'CursosModel');
        $this->load->model('administrarCTN/InscripcionModel', 'InscripcionModel');
        if (sesionActive()) {
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }
    }

    /**
     * seccion para el apartado del crud que se implementara para los metodos de pago o bancos
     */

    public function metodos_pago_online(){

    }

    public function resultados_metodo_pago_online(){

    }

    public function agregar_modificar_metodo_pago_online(){

    }

    public function guardar_metodo_pago(){

    }

    public function eliminar_metodo_pago(){

    }

    /**
     * fin de la seccion para el apartado del crud
     */

    /**
     * apartado de las funciones para realizar el pago de los cursos
     * a partir de aqui se agregaran todos los metodos que necesiten metodo de pago
     */

    public function mp_inscripcion_ca($id_publicacion_ctn,$id_alumno_inscrito_ctn){
        $request = $_REQUEST;
        if(is_array($_REQUEST) && sizeof($_REQUEST) > 1){
            $curso_incripcion = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
            $request['costo'] = $curso_incripcion->costo;
            $request['descripcion_pago'] = 'Pago del curso: "'. $curso_incripcion->nombre_curso_comercial.'"';
            $payment = $this->PagoOnlineModel->process_payment($request);
            $msg_detail = $this->PagoOnlineModel->getDetailsRejectedPayment('MERCADO_PAGO',$payment->status_detail);
            $this->PagoOnlineModel->insertDetAlumnoPagoCurso($payment->id_ms_pago_online,$id_alumno_inscrito_ctn);
            switch ($payment->status){
                case 'rejected': //reintentar_pago
                    $this->session->set_flashdata('type_message', 'error');
                    $this->session->set_flashdata('message', $msg_detail->descripcion.'<br>'.REINTENTAR_PAGO);
                    redirect('InscripcionesCTN/actualizarDatosAlumno/'.$id_publicacion_ctn);
                    break;
                case 'in_process':
                    $this->session->set_flashdata('type_message', 'confirmed');
                    $msg_flash = $msg_detail->descripcion.'<br>Una vez que se acredite, quedará inscrito al curso.';
                    if ($this->InscripcionModel->enviar_recibo_validacion_civik_alumno($id_alumno_inscrito_ctn)) {
                        $this->NotificacionesModel->enviar_notificacion_recibo_pago_a_validar($id_alumno_inscrito_ctn);
                    }
                    $this->session->set_flashdata('message', $msg_flash);
                    redirect(base_url());
                    break;
                case 'approved':
                    $this->session->set_flashdata('type_message', 'success');
                    $msg_flash = $msg_detail->descripcion;
                    $inscripcion = $this->InscripcionModel->concluir_registro_alumno_pago_online($id_alumno_inscrito_ctn);
                    if($inscripcion['exito']){
                        $this->NotificacionesModel->enviar_notificacion_conclusion_registro_dc3($id_alumno_inscrito_ctn, $inscripcion['documento_dc3']);
                        $msg_flash .= '<br> Se concluyo el registro al curso con éxito';
                        $this->session->set_flashdata('message', $msg_flash);
                    }else{
                        $this->session->set_flashdata('type_message', 'confirmed');
                        $msg_flash .= '<br>'.CUPO_LLENO_INSCRIPCION;
                        $this->session->set_flashdata('message', $msg_flash);
                    }
                    redirect(base_url());
                    break;
            }
        }else{
            $this->load->view('default/error_404');
        }
    }

    /**
     * apartado de funciones privadas al controlador
     */


}