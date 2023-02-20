<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EstacionServicio extends CI_Controller {

    public $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('CatalogosAseaModel');
        $this->load->model('DocumentosAseaModel');
        $this->load->model('EstacionServicioModel');
        $this->load->model('EmpleadosESModel');
        $this->load->model('ControlUsuariosModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
        }else{
            $this->usuario = false;
            redirect(base_url());
        }
    }

    public function ControlEs(){
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/datepicker/js/bootstrap-datepicker.js',
            base_url().'extras/datepicker/locales/bootstrap-datepicker.es.min.js',
            base_url().'extras/fileinput/js/fileinput.js',
            base_url().'extras/fileupload/js/vendor/jquery.ui.widget.js',
            base_url().'extras/fileupload/js/jquery.iframe-transport.js',
            base_url().'extras/fileupload/js/jquery.fileupload.js',
            base_url().'extras/asea/es/es_registro.js'
        );
        $this->load->view('asea/estacion_servicio/PrincipalES',$data);
    }

    public function buscarEstacionesServicio(){
        $form_buscar = $this->input->post();
        $data['listaEstaciones'] = $this->EstacionServicioModel->obtenerEstacionesServicio($form_buscar);
        //var_dump($data['listaEstaciones']);exit;
        $this->load->view('asea/estacion_servicio/ResultadosBusquedaES',$data);
    }

    public function modificarAgregarEstacionServicio($idEstacionServicio = false){
        $data = array();
        $post = $this->input->post();
        if($idEstacionServicio){
            $data['estacion_servicio'] = $this->EstacionServicioModel->obtenerEstacionServicioFromId($idEstacionServicio);
            $data['usuario_estacion'] = $this->EstacionServicioModel->obtenerUsuarioEstacion($data['estacion_servicio']->id_usuario);
            $data['documento_asea'] = $this->DocumentosAseaModel->obtenerDocumentoAsea($data['estacion_servicio']->id_documento_asea);
            $data['es_configuracion'] = isset($post['es_configuracion']) ? true : false;
        }
        $this->load->view('asea/estacion_servicio/RegistroES',$data);
    }

    public function guardarEstacionServicio(){
        $post = $this->input->post();
        $usuario = $this->usuario;
        $post['usuario']['update_password'] = $usuario->update_password + 1;
        $retorno = $this->EstacionServicioModel->guardarEstacionServicio($post);
        if(isset($post['es_configuracion']) && $post['es_configuracion'] == 1){
            if($retorno['exito']){
                $usuario_estacion = $this->ControlUsuariosModel->obtenerDatosUsuario($usuario->id_usuario,'rh_empresa');
                $usuario_estacion->activo = $usuario->activo;
                $usuario_estacion->update_password = $usuario->update_password;
                $usuario_estacion->verificado = $usuario->verificado;
                $sesion['existe'] = true;
                $sesion['msg'] = '';
                $sesion['usuario'] = $usuario_estacion;
                $this->session->set_userdata($sesion);
                $this->usuario = $usuario_estacion;
                $retorno['recargar'] = true;
            }
        }
        echo json_encode($retorno);
    }

    public function registrarNormasEstacionServicio($idEstacionServicio){
        $data['catalogo_anios'] = $this->CatalogosAseaModel->obtenerCatalogoAnio();
        $data['anio_selected'] = reset($data['catalogo_anios']);
        $data['estacion_servicio'] = $this->EstacionServicioModel->obtenerEstacionServicioFromId($idEstacionServicio);
        $data['normas_asea'] = $this->EstacionServicioModel->obtenerListaNormasEstacion($idEstacionServicio,$data['anio_selected']);
        //var_dump($data);exit;
        $this->load->view('asea/estacion_servicio/NormasEstacionServicio',$data);
    }

    public function normasAnioEstacionServicio(){
        $post = $this->input->post();
        $data['normas_asea'] = $this->EstacionServicioModel->obtenerListaNormasEstacion($post['id_estacion_servicio'],$post['anio']);
        //var_dump($data);exit;
        $this->load->view('asea/estacion_servicio/ResultadosNormaEstacionServicio',$data);
    }

    public function guardarNormasEstacionServicio(){
        $result['exito'] = false;
        $result['msg'] = 'No se pudo realizar la actualización del sistema, favor de intentar más tarde';
        $post = $this->input->post();
        if($this->EstacionServicioModel->guardarNormasEstacionServicio($post)){
            $result['exito'] = true;
            $result['msg'] = 'Se guardaron las normas a la estación de servicio';
        }
        echo json_encode($result);
        exit;
    }

    public function activarDesactivarES($idEstacionServicio,$operacion){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible realizar la operación en la estación de servicio, favor de intentar más tarde';
        if($this->EstacionServicioModel->activarDesactivarES($idEstacionServicio,$operacion)){
            $result['exito'] = true;
            $result['msg'] = 'Se actualizó la estación de servicio con éxito';
        }
        echo json_encode($result);
    }

    public function eliminarDocumentoAsea($idDocumentoAsea){
        $documentoAsea = $this->DocumentosAseaModel->obtenerDocumentoAsea($idDocumentoAsea);
        $eliminar_tiene_doc = $this->EstacionServicioModel->eliminarDocumentoEstacionServicio($idDocumentoAsea);
        $eliminar_doc = $this->DocumentosAseaModel->elimiarDocumentoAsea($idDocumentoAsea);
        $file_delete = FCPATH.$documentoAsea->ruta_directorio.$documentoAsea->nombre;
        if($eliminar_tiene_doc && $eliminar_doc){
            if(file_exists($file_delete)){
                unlink($file_delete);
            }
        }
        echo json_encode(array('exito' => true));
        exit;
    }

    public function agregarEmpleadosES($idEstacionServicio){
        $post = $this->input->post();
        $data['editarRegistroEmpleados'] = false;
        if($post['editarEmpleados'] == 'true'){
            $data['editarRegistroEmpleados'] = true;
        }
        $data['estacion_servicio'] = $this->EstacionServicioModel->obtenerEstacionServicioFromId($idEstacionServicio);
        $data['listaEmpleadosES'] = $this->EstacionServicioModel->obtenerListaEmpleadosES($idEstacionServicio);
        $this->load->view('asea/estacion_servicio/ControlEmpleadosES',$data);
    }

    public function administracionEmpleadosES($idEstacionServicio){
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/asea/es/es_registro.js'
        );
        $data['editarRegistroEmpleados'] = true;
        $data['estacion_servicio'] = $this->EstacionServicioModel->obtenerEstacionServicioFromId($idEstacionServicio);
        $data['listaEmpleadosES'] = $this->EstacionServicioModel->obtenerListaEmpleadosES($idEstacionServicio);
        //var_dump($data);exit;
        $this->load->view('asea/estacion_servicio/AdministracionEmpleadosES',$data);
    }

    public function guardarEmpleadosES(){
        $form_post = $this->input->post();
        $retorno = $this->EstacionServicioModel->guardarEmpleadosES($form_post);
        echo json_encode($retorno);
        exit;
    }

    public function eliminarEmpleadosES($idEmpleadoEs=false){
        $result['exito'] = false;
        if($idEmpleadoEs && $idEmpleadoEs == ''){
            $result['exito'] = true;
            $result['msg'] = 'Se elimino el empleado con exito';
        }else{
            $result['exito'] = $this->EstacionServicioModel->eliminarEmpleadoES($idEmpleadoEs);
            $result['msg'] = 'No fue posible eliminar el empleado, favor de intentar más tarde';
            if($result['exito']){
                $result['msg'] = 'Se elimino el empleado con exito';
            }
        }
        echo json_encode($result);
        exit;
    }

    public function seguimientoEmpleadosEs($idEstacionServicio){
        $data['usuario'] = $this->usuario;
        $data['extra_js'] = array(
            base_url().'extras/asea/es/es_comun.js',
            base_url().'extras/asea/empleados_es/empleados_es.js'
        );
        $data['listaEmpleadosES'] = $this->EstacionServicioModel->obtenerListaEmpleadosES($idEstacionServicio);
        $this->load->view('asea/estacion_servicio/SeguimientoEmpleadosES',$data);
    }

    public function consultarEvaluacionesEmpleado($idEmpleadosEs){
        $data['empleado_es'] = $this->EmpleadosESModel->obtenerEmpleadoEs($idEmpleadosEs);
        $data['normas_cursadas_empleados'] = $this->EmpleadosESModel->obtenerNormasCursadasEmpleado($idEmpleadosEs);
        $this->load->view('asea/estacion_servicio/ConsultarEvaluacionesEmpleado',$data);
    }

    public function uploadFileLogo(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = 'extras/imagenes/logos_es/';
                    $data = upload_file_asea($f,$options);
                    //var_dump($data);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumentoAsea = $this->DocumentosAseaModel->guardarDocumentoAsea($datos_doc);
                        $retorno['documento_asea'] = $this->DocumentosAseaModel->obtenerDocumentoAsea($idDocumentoAsea);
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

}