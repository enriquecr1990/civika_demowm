<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('ControlUsuariosModel');
        $this->load->model('CursosModel');
        $this->load->model('DocumentosModel');
        $this->load->model('Cotizaciones_model');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
        }else{
            $this->usuario = false;
        }
    }

    public function uploadFileComunImg(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_img($f,$options);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $retorno['documento'] = $this->DocumentosModel->obtenerDocumentoById($idDocumento);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function uploadFileComunPDF(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_pdf($f,$options);
                    //var_dump($data);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $retorno['documento'] = $this->DocumentosModel->obtenerDocumentoById($idDocumento);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function uploadFileMaterialEvidencia(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_material_evidencia($f,$options);
                    //var_dump($data);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $retorno['documento'] = $this->DocumentosModel->obtenerDocumentoById($idDocumento);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function uploadFileImgFotoPerfil(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_img($f,$options);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $retorno['documento'] = $this->DocumentosModel->obtenerDocumentoById($idDocumento);
                        $this->ControlUsuariosModel->actualizarUsuario($post['id_usuario'],array('id_documento_perfil' => $idDocumento));
                        $usuario = $this->usuario;
                        $usuario->foto_perfil = $retorno['documento'];
                        $this->session->set_userdata(array('usuario' => $usuario));
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function uploadFileImgGaleriaCurso(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_img($f,$options);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $retorno['documento'] = $this->DocumentosModel->obtenerDocumentoById($idDocumento);
                        $this->CursosModel->guardar_img_galeria_publicacion_ctn($post['id_publicacion_ctn'],$idDocumento);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function upload_comprobante_xml_cotizacion(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_xml($f,$options);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $update_cotizacion = array(
                            'id_cotizacion' => $post['id_cotizacion'],
                            'id_documento_factura_xml' => $idDocumento
                        );
                        $this->Cotizaciones_model->actualizar_cotizacion($update_cotizacion);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

    public function upload_comprobante_pdf_cotizacion(){
        $retorno['exito'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                $post = $this->input->post();
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_pdf($f,$options);
                    if(!isset($data['error'])){
                        $retorno['exito'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $idDocumento = $this->DocumentosModel->guardarDocumento($datos_doc);
                        $update_cotizacion = array(
                            'id_cotizacion' => $post['id_cotizacion'],
                            'id_documento_factura_pdf' => $idDocumento
                        );
                        $this->Cotizaciones_model->actualizar_cotizacion($update_cotizacion);
                    }else{
                        $retorno['msg'] = $data['error'];
                    }
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

}