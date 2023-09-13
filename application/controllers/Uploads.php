<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends CI_Controller {

    private $usuario;

    function __construct(){
        parent:: __construct();
        $this->load->model('ArchivoModel');
        $this->load->model('ArchivoInstrumentoModel');
        if(sesionActive()){
			$this->usuario = usuarioSession();
        }else{
            $this->usuario = false;
			redirect(base_url().'login');
        }
    }

    public function uploadFileComunImg($transparente = false){
        $retorno['success'] = false;
        $retorno['msg'] = array('No es posible adjuntar su imagen, favor de intentar con otro o más tarde');
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                foreach ($_FILES as $name => $f){
                    $options['field'] = $name;
                    $options['path'] = getRouteFilesComun();
                    $options['pre'] = date('H_i_s').'-';
                    $data = upload_file_img($f,$options);
                    if(!isset($data['error'])){
                        $retorno['success'] = true;
                        $retorno['msg'] = 'Se adjunto el archivo con éxito';
                        //falta guardar en BD el archivo
                        $datos_doc['nombre'] = $data['file_name'];
                        $datos_doc['ruta_directorio'] = $options['path'];
                        $datos_doc['fecha'] = date('Y-m-d H:i:s');
                        $id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
						$retorno['archivo'] = $this->ArchivoModel->obtener_archivo($id_archivo);
                        if(!$transparente || $transparente == 'si'){
                        	$nuevo_archivo_img_transparente = imagenFondoTransparente($retorno['archivo']);
                        	//var_dump($nuevo_archivo_img_transparente);exit;
                        	$this->ArchivoModel->guardar_row($nuevo_archivo_img_transparente,$id_archivo);
							$retorno['archivo'] = $this->ArchivoModel->obtener_archivo($id_archivo);
						}
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
        $retorno['success'] = false;
        $retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
        if(is_ajax()){
            if(isset($_FILES) && count($_FILES) != 0){
                foreach ($_FILES as $name => $f){
					$options['field'] = $name;
					$options['path'] = getRouteFilesComun();
					$options['pre'] = date('H_i_s').'-';
					$data = upload_file_pdf($f,$options);
					if(!isset($data['error'])){
						$retorno['success'] = true;
						$retorno['msg'] = 'Se adjunto el archivo con éxito';
						//falta guardar en BD el archivo
						$datos_doc['nombre'] = $data['file_name'];
						$datos_doc['ruta_directorio'] = $options['path'];
						$datos_doc['fecha'] = date('Y-m-d H:i:s');
						$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
						$retorno['archivo'] = $this->ArchivoModel->obtener_archivo($id_archivo);
					}else{
						$retorno['msg'] = $data['error'];
					}
                }
            }
        }
        echo json_encode($retorno);
        exit;
    }

	public function uploadFileATI(){
		$retorno['success'] = false;
		$retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
		if(is_ajax()){
			if(isset($_FILES) && count($_FILES) != 0){
				foreach ($_FILES as $name => $f){
					$options['field'] = $name;
					$options['path'] = getRouteFilesComun();
					$options['pre'] = date('H_i_s').'-';
					$data = upload_file_ati($f,$options);
					if(!isset($data['error'])){
						$retorno['success'] = true;
						$retorno['msg'] = 'Se adjunto el archivo con éxito';
						//falta guardar en BD el archivo
						$datos_doc['nombre'] = $data['file_name'];
						$datos_doc['ruta_directorio'] = $options['path'];
						$datos_doc['fecha'] = date('Y-m-d H:i:s');
						$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
						$retorno['archivo'] = $this->ArchivoModel->obtener_archivo($id_archivo);
					}else{
						$retorno['msg'] = $data['error'];
					}
				}
			}
		}
		echo json_encode($retorno);
		exit;
	}

	public function uploadFileATICandidato(){
		$retorno['success'] = false;
		$retorno['msg'] = 'No es posible adjuntar su archivo, favor de intentar con otro o más tarde';
		if(is_ajax()){
			if(isset($_FILES) && count($_FILES) != 0){
				foreach ($_FILES as $name => $f){
					$options['field'] = $name;
					$options['path'] = getRouteFilesComun();
					$options['pre'] = date('H_i_s').'-';
					$data = upload_file_ati($f,$options);
					if(!isset($data['error'])){
						$retorno['success'] = true;
						$retorno['msg'] = 'Se adjunto el archivo con éxito';
						//falta guardar en BD el archivo
						$datos_doc['nombre'] = $data['file_name'];
						$datos_doc['ruta_directorio'] = $options['path'];
						$datos_doc['fecha'] = date('Y-m-d H:i:s');
						$guardar_archivo = $this->ArchivoInstrumentoModel->guardar_row($datos_doc);
						$retorno['archivo'] = $this->ArchivoInstrumentoModel->obtener_row($guardar_archivo['id']);
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
