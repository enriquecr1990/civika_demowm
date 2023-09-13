<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Mpdf\Config\ConfigVariables;
use \Mpdf\Config\FontVariables;
use \iio\libmergepdf\Merger;
//librerias para modificar los pdf cargados en el sistema
use setasign\Fpdi\Fpdi;
require_once FCPATH.'vendor/setasign/fpdf/fpdf.php';
require_once FCPATH.'vendor/setasign/fpdi/src/autoload.php';

class DocsPDF extends CI_Controller {

	private $usuario;
	private $default_pdf_params;

	function __construct()
	{
		parent:: __construct();
		$this->load->library('pdf');
		$this->load->model('ActividadIEModel');
		$this->load->model('ArchivoModel');
		$this->load->model('ECUsuarioHasExpedientePEDModel');
		$this->load->model('DocsPDFModel');
		$this->load->model('PerfilModel');
		$this->load->model('UsuarioHasECModel');
		$this->load->model('UsuarioHasEncuestaModel');
		$this->load->model('UsuarioHasEvaluacionRealizadaModel');
		$this->set_variables_defaults_pdf();
	}

	public function validar_datos_generar_ped_pdf($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$data['evaluacion_diagnostica_realizada'] = false;
			$data['cargo_evidencia_ati'] = false;
			$data['cargo_expediente_digital_ped'] = false;
			$data['firma_evaluador'] = false;
			$data['candidato_expediente_digital'] = true;//foto de certificados, ine, curp, firma digital
			$data['fecha_evidencia_ati_evaluador'] = false;
			$data['ficha_registro_admin'] = false;
			$data['legend_candidato_expediente_digital'] = '';
			$data['candidato_encuesta_satisfacion'] = false;

			//validación de la evaluacion diagnostica
			$buscar_usuario_has_evaluacion_enviada =  array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno, 'enviada' => 'si');
			$usuario_has_evaluacion_enviada = $this->UsuarioHasEvaluacionRealizadaModel->tablero($buscar_usuario_has_evaluacion_enviada,0);
			$usuario_has_evaluacion_enviada['total_registros'] != 0 ? $data['evaluacion_diagnostica_realizada'] = true : $data['evaluacion_diagnostica_realizada'] = false;

			//validacion carga de evidencia ati
			$instrumentos_ec_candidato = $this->ActividadIEModel->instrumentos_ec_entregados_candidato($id_estandar_competencia,$id_usuario_alumno);
			$instrumentos_ec_candidato['instrumentos_ec']->num_entregables_ati == $instrumentos_ec_candidato['instrumentos_ec_candidato']->num_entregables_ati_candidato ? $data['cargo_evidencia_ati'] = true : false;

			//validacion cargo_expediente_digital
			$buscar_expediente_ped = array('id_estandar_competencia' => $id_estandar_competencia, 'id_usuario' => $id_usuario_alumno);
			$expediente_ped = $this->ECUsuarioHasExpedientePEDModel->tablero($buscar_expediente_ped,0);
			$expediente_ped['total_registros'] == 3 ? $data['cargo_expediente_digital_ped'] = true : false;

			//validar la firma del evaluador
			$foto_firma = $this->PerfilModel->obtener_datos_expediente($id_usuario_instructor,8);
			is_object($foto_firma) ? $data['firma_evaluador'] = true : false;

			//validar expediente del candidato
			$foto_certificado_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,2);
			$foto_firma_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,8);
			$curp_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,7);
			$ine_anverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,3);
			$ine_reverso_candidato = $this->PerfilModel->obtener_datos_expediente($id_usuario_alumno,4);
			if(!is_object($foto_certificado_candidato) || is_null($foto_certificado_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema la foto del candidato</li>';
			}if(!is_object($foto_firma_candidato) || is_null($foto_firma_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema la firma del candidato</li>';
			}if(!is_object($curp_candidato) || is_null($curp_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema el CURP del candidato</li>';
			}if(!is_object($ine_anverso_candidato) || is_null($ine_anverso_candidato) || !is_object($ine_reverso_candidato) || is_null($ine_reverso_candidato)){
				$data['candidato_expediente_digital'] = false;
				$data['legend_candidato_expediente_digital'] .= '<li>No se encuentra en el sistema el INE del Candidato (falta el anverso o reverso o ambos)</li>';
			}

			//validar fecha_evidencia_ati_evaluador
			$usuario_has_ec = $this->UsuarioHasECModel->tablero(array('id_estandar_competencia' => $id_estandar_competencia,'id_usuario' => $id_usuario_alumno),0);
			if(isset($usuario_has_ec['usuario_has_estandar_competencia'][0]->fecha_evidencia_ati) && !Validaciones_Helper::isCampoVacio($usuario_has_ec['usuario_has_estandar_competencia'][0]->fecha_evidencia_ati)){
				$data['fecha_evidencia_ati_evaluador'] = true;
			}

			$candidato_encuesta_satisfaccion = $this->UsuarioHasEncuestaModel->tablero(array('id_usuario_has_estandar_competencia' => $usuario_has_ec['usuario_has_estandar_competencia'][0]->id_usuario_has_estandar_competencia));
			if($candidato_encuesta_satisfaccion['total_registros'] != 0){
				$data['candidato_encuesta_satisfacion'] = true;
			}

			$response['success'] = true;
			$response['msg'][] = 'Se validó la información del sistema y estos son los resultados';
			$response['validaciones'] = $data;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function obtener_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$usuario_has_ec = $this->DocsPDFModel->obtener_usuario_has_ec($id_usuario_alumno,$id_estandar_competencia);
			if(is_object($usuario_has_ec) && isset($usuario_has_ec->id_archivo_ped) && !is_null($usuario_has_ec->id_archivo_ped) && $usuario_has_ec->id_archivo_ped != ''){
				$doc_ped = $this->ArchivoModel->obtener_archivo($usuario_has_ec->id_archivo_ped);
				$response['success'] = true;
				$response['existe_ped'] = true;
				$response['msg'][] = array('');
				$response['doc_portafolio_evidencia'] = base_url() . $doc_ped->ruta_directorio . $doc_ped->nombre;
			}else{
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				$response['success'] = true;
				$response['existe_ped'] = false;
				$response['msg'][] = array('');
				$response['data'] = $data;
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_portada_to_ficha_registro($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-01-portafolio_portada_ficha_registro.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_portada_ficha_registro', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Portada hasta Ficha de registro)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);die();
	}

	public function generar_pdf_diagnostico($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-02-portafolio-evaluacion_diagnostica.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//echo json_encode($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 38;
				$this->default_pdf_params['margin_bottom'] = 8;
				$this->default_pdf_params['orientation'] = 'L';
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_diagnostico', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (evaluación diagnostica)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_acuse_to_plan_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-acuse_plan_evaluacion.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 20;
				$this->default_pdf_params['margin_bottom'] = 20;
				$this->default_pdf_params['orientation'] = 'L';
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_acuse_plan_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Acuse hasta plan de evaluación)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_plan_evaluacion_requerimientos($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$pre = date('Ymd').'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-evaluacion-requerimientos.pdf';
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			//echo '<pre>'.print_r($data);exit;
			$this->default_pdf_params['margin_left'] = 0;
			$this->default_pdf_params['margin_right'] = 0;
			$this->default_pdf_params['margin_top'] = 40;
			$this->default_pdf_params['margin_bottom'] = 20;
			$this->default_pdf_params['orientation'] = 'P';
			$mpdf = $this->pdf->load($this->default_pdf_params);
			if(!es_produccion()){
				$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
			}
			$mpdf->showWatermarkText = true;
			$paginaHTML = $this->load->view('pdf/portafolio_evidencia/plan_evaluacion_requerimientos', $data, true);
			$mpdf->WriteHTML($paginaHTML);
			$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'I');
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_resultados_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia){
		try{
			$pre = date('Ymd').'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-03-portafolio-resultados-evaluacion.pdf';
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			//echo '<pre>'.print_r($data);exit;
			$this->default_pdf_params['margin_left'] = 0;
			$this->default_pdf_params['margin_right'] = 0;
			$this->default_pdf_params['margin_top'] = 40;
			$this->default_pdf_params['margin_bottom'] = 20;
			$this->default_pdf_params['orientation'] = 'P';
			$mpdf = $this->pdf->load($this->default_pdf_params);
			if(!es_produccion()){
				$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
			}
			$mpdf->showWatermarkText = true;
			$paginaHTML = $this->load->view('pdf/portafolio_evidencia/resultados_evaluacion', $data, true);
			$mpdf->WriteHTML($paginaHTML);
			$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'I');
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_cierre_eva_to_entrega_certificado($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false, $output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-04-cierre_evaluacion_entraga_certificado.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_cierre_entrega_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Cierre de evaluación Entrega de certificado)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generar_pdf_cedula_evaluacion($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false, $output = 'F'){
		try{
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-04-cierre_evaluacion.pdf';
			if(!file_exists(RUTA_PDF_TEMP.$nombre_documento)){
				subdirectorios_files(RUTA_PDF_TEMP);
				$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 0;
				$this->default_pdf_params['margin_right'] = 0;
				$this->default_pdf_params['margin_top'] = 0;
				$this->default_pdf_params['margin_bottom'] = 0;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}
				$mpdf->showWatermarkText = true;
				$paginaHTML = $this->load->view('pdf/portafolio_evidencia/generar_cedula_evaluacion', $data, true);
				if($es_html != false && $es_html != 0){
					echo $paginaHTML;exit;
				}
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, $output);
			}
			$response['success'] = true;
			$response['msg'][] = 'Se genero el PDF del portafolio de evidencias (Cierre de evaluación Entrega de certificado)';
			$response['data']['documento'] = RUTA_PDF_TEMP.$nombre_documento;
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	public function generando_pdf_completo($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia,$es_html = false,$output = 'F'){
		try{
			$mergePDF = new Merger();
			$post = $this->input->post();
			$documentos_alumno_evidencia = $this->DocsPDFModel->obtener_archivos_ec_alumno($id_usuario_alumno,$id_estandar_competencia);
			$data = $this->DocsPDFModel->get_data_portafolio_evidencia($id_usuario_alumno,$id_usuario_instructor,$id_estandar_competencia);
			$archivos_conjuntar = array();
			$archivos_conjuntar[] = $post['docs_generados'][0];//portada a antes de la ficha de registro
			if(!es_produccion()){
				//ficha registro cargado al sistema por el admin/evaluador y se le pone la marca de agua del sistema
				$archivos_conjuntar[] = $this->poner_marca_agua_doc($data['usuario_has_expediente_ped'][0]->ruta_directorio,$data['usuario_has_expediente_ped'][0]->nombre);
			}else{
				//ficha registro cargado al sistema por el admin/evaluador
				$archivos_conjuntar[] = $data['usuario_has_expediente_ped'][0]->ruta_directorio.$data['usuario_has_expediente_ped'][0]->nombre;
			}
			$archivos_conjuntar[] = $post['docs_generados'][1];//evaluacion diagnostica
			$archivos_conjuntar[] = $post['docs_generados'][2];//acuse a plan de evaluacion
			$archivos_conjuntar[] = $this->generar_entregables_instrumento(
				$data['foto_firma']->ruta_directorio.$data['foto_firma']->nombre,
				$data['foto_firma_instructor']->ruta_directorio.$data['foto_firma_instructor']->nombre,
				$data['usuario_has_expediente_ped'][1]
			); //instrumentos de evaluación de competencia al sistema por el admin/evaluador

			//entregables candidato
			$archivos_entregables_modificados = $this->generar_entregables($documentos_alumno_evidencia);
			$archivos_conjuntar = array_merge($archivos_conjuntar,$archivos_entregables_modificados);
			$archivos_conjuntar[] = $post['docs_generados'][3];//cierre hasta antes del certificado
			//certificado del conocer
			$archivos_conjuntar[] = $this->certificado_formato_ped(
				$data['foto_firma']->ruta_directorio.$data['foto_firma']->nombre,
				$data['usuario_alumno']->nombre.' '.$data['usuario_alumno']->apellido_p.' '.$data['usuario_alumno']->apellido_m,
				$data['usuario_has_expediente_ped'][2] //certificado conocer original
			);
			$archivos_conjuntar[] = 'assets/docs/final_ped.pdf';
			//conjuntamos los archivos generados previamente
			foreach ($archivos_conjuntar as $dg){
				$mergePDF->addFile(FCPATH.$dg);
			}

			$archivo_combinado = $mergePDF->merge();
			$pre = date('Ymd').'-'.$id_usuario_alumno.'-'.$id_estandar_competencia;
			$nombre_documento = $pre.'-final-portafolio-evidencias.pdf';
			$directorio = $this->subdirectorio_peds_generados();
			subdirectorios_files($directorio);
			$isArchivo_generado = file_put_contents($directorio.$nombre_documento,$archivo_combinado);
			if($isArchivo_generado){
				foreach ($archivos_conjuntar as $dg){
					if(strpos($dg,RUTA_PDF_TEMP) !== false){
						unlink(FCPATH.$dg);
					}
				}
				//almacenamos el archivo en la tabla de archivo y luego en la tabla de referencia de que se genero el PED
				$datos_doc['nombre'] = $nombre_documento;
				$datos_doc['ruta_directorio'] = $directorio;
				$datos_doc['fecha'] = date('Y-m-d H:i:s');
				$id_archivo = $this->ArchivoModel->guardar_archivo_model($datos_doc);
				$this->DocsPDFModel->actualizar_ped_generado($id_usuario_alumno,$id_estandar_competencia,$id_archivo);
				$response['success'] = true;
				$response['msg'][] = 'Se genero el Portafolio de evidencias del alumno correctamente';
				$response['data'] = $datos_doc;
			}else{
				$response['success'] = false;
				$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);exit;
	}

	protected function set_variables_defaults_pdf()
	{
		$configVariablrs =new ConfigVariables();
		$fontVariables = new FontVariables();
		$default_config = $configVariablrs->getDefaults();

		$default_font_config = $fontVariables->getDefaults();
		$font_dirs = $default_config['fontDir'];
		$font_data = $default_font_config['fontdata'];
		$this->default_pdf_params = array(
			'format' => 'Letter',
			'default_font_size' => '12',
			'default_font' => 'Arial',
			'margin_left' => 10,
			'margin_right' => 10,
			'margin_top' => 5,
			'margin_bottom' => 13,
			'orientation' => 'P',
			'fontDir' => array_merge($font_dirs, array(FCPATH . 'assets/fonts')),
			'fontdata' => $font_data + array(
					"nueva_fuente_modern" => array(
						'R' => "modern_led_board-7.ttf",
						'B' => "modern_led_board-7.ttf",
						'I' => "modern_led_board-7.ttf",
						'BI' => "modern_led_board-7.ttf",
					),

					"nueva_fuente_zillmo" => array(
						'R' => "ZILLMOO_.ttf",
						'B' => "ZILLMOO_.ttf",
						'I' => "ZILLMOO_.ttf",
						'BI' => "ZILLMOO_.ttf",
					),

					"nueva_fuente_bau" => array(
						'R' => "BauhausStd-Medium.ttf",
						'B' => "BauhausStd-Medium.ttf",
						'I' => "BauhausStd-Medium.ttf",
						'BI' => "BauhausStd-Medium.ttf",
					),
				)
		);
	}

	protected function subdirectorio_peds_generados(){
		return RUTA_PDF_PED.date('Y').'/'.date('m').'/'.date('d').'/';
	}

	protected function generar_entregables_instrumento($firma_candidato,$firma_evaluador,$instrumento){
		try{

			$pdf = new Fpdi();
			//leemos el entregable cargado por el candidato
			$paginasPDF = $pdf->setSourceFile($instrumento->ruta_directorio.$instrumento->nombre);
			for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
				$paginaActual = $pdf->importPage($pagina);
				$paPlantilla = $pdf->getTemplatesize($paginaActual);
				$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
				$pdf->useImportedPage($paginaActual);
				//agregamos la marca de agua para pruebas
				if(!es_produccion()) {
					//agregamos el texto
					$pdf->SetFont('Arial','',40);
					$pdf->SetTextColor(150, 150, 150);
					$pdf->SetXY(20, $paPlantilla[1] / 2);
					$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
				}
				$pdf->Image(FCPATH.$firma_evaluador,50,240,25,20);
				$pdf->Image(FCPATH.$firma_candidato,150,240,25,20);
			}

			$pdf->Output('F', RUTA_PDF_TEMP.$instrumento->nombre);
			$pdf->cleanUp();
			return RUTA_PDF_TEMP.$instrumento->nombre;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_entregables_instrumento');
			log_message('error',$ex->getMessage());
		}
		return false;
	}

	protected function generar_entregables($entregables){
		try{
			$archivos_modificados = array();
			if(es_produccion()) {
				foreach ($entregables as $e){
					//Para saber si es una url de video o es una imagen
					if(!is_null($e->url_video) && $e->url_video != ''){
						//es un video
						$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,false);
						$archivos_modificados[] = $archivos_modificado['ruta_directorio'].$archivos_modificado['nombre'];
					}else{
						if(!strpos(strMinusculas($e->nombre),'.pdf')){
							//es una imagen
							$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,true);
							$archivos_modificados[] = $archivos_modificado['ruta_directorio'].$archivos_modificado['nombre'];
						}if(strpos(strMinusculas($e->nombre),'.pdf')){
							//es un pdf
							$archivos_modificados[] = $e->ruta_directorio.$e->nombre;
						}
					}
				}
			}else{
				//el else es para unicamente ponerle la marca de agua a los entregables del alumno
				foreach ($entregables as $e){
					//Para saber si es una url de video o es una imagen
					if(!is_null($e->url_video) && $e->url_video != ''){
						//es un video
						$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,false);
						$archivos_modificados[] = $this->poner_marca_agua_doc($archivos_modificado['ruta_directorio'],$archivos_modificado['nombre']);
					}else{
						if(!strpos(strMinusculas($e->nombre),'.pdf')){
							//es una imagen
							$archivos_modificado = $this->generar_evidencia_pdf_img_video($e,true);
							$archivos_modificados[] = $this->poner_marca_agua_doc($archivos_modificado['ruta_directorio'],$archivos_modificado['nombre']);
						}if(strpos(strMinusculas($e->nombre),'.pdf')){
							//es un pdf
							$archivos_modificados[] = $this->poner_marca_agua_doc($e->ruta_directorio,$e->nombre);
						}
					}
				}
			}
			return $archivos_modificados;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_entregables');
			log_message('error',$ex->getMessage());
			return array();
		}
	}

	protected function poner_marca_agua_doc($ruta_documento,$nombre_documento){
		$pdf = new Fpdi();
		//leemos el entregable cargado por el candidato
		$paginasPDF = $pdf->setSourceFile($ruta_documento.$nombre_documento);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos la marca de agua para pruebas
			$pdf->SetFont('Arial','',40);
			$pdf->SetTextColor(150, 150, 150);
			$pdf->SetXY(20, $paPlantilla[1] / 2);
			$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
		}

		$pdf->Output('F', RUTA_PDF_TEMP.$nombre_documento);
		$pdf->cleanUp();
		return RUTA_PDF_TEMP.$nombre_documento;
	}

	protected function certificado_formato_ped($firma_candidato,$nombre_candidato,$entregable){
		$pdf = new Fpdi();
		//leemos el entregable cargado por el candidato
		$paginasPDF = $pdf->setSourceFile(FCPATH.$entregable->ruta_directorio.$entregable->nombre);
		for($pagina = 1; $pagina <= $paginasPDF; $pagina++ ){
			$paginaActual = $pdf->importPage($pagina);
			$paPlantilla = $pdf->getTemplatesize($paginaActual);
			$pdf->AddPage($paPlantilla['orientation'],$paPlantilla);
			$pdf->useImportedPage($paginaActual);
			//agregamos el texto
			$pdf->SetFont('Arial','',9);
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetXY(135, 120);$pdf->Write(0, utf8_decode('RECIBI CERTIFICADO DIGITAL'));
			$pdf->SetXY(135, 125);$pdf->Write(0, utf8_decode($nombre_candidato));
			$pdf->SetXY(135, 130);$pdf->Write(0, utf8_decode(fechaBDToHtml($entregable->fecha)));
			//agregamos la marca de agua para pruebas
			if(!es_produccion()) {
				//agregamos el texto
				$pdf->SetFont('Arial','',40);
				$pdf->SetTextColor(150, 150, 150);
				$pdf->SetXY(20, $paPlantilla[1] / 2);
				$pdf->Write(0, utf8_decode('PED Demo - ECO SOFTyH'));
			}
			$pdf->Image(FCPATH.$firma_candidato,150,95,25,20);
		}

		$pdf->Output('F', RUTA_PDF_TEMP.$entregable->nombre);
		return RUTA_PDF_TEMP.$entregable->nombre;
	}

	protected function generar_evidencia_pdf_img_video($entregable,$esImg){
		try{
			$pre = date('Ymd').'-';
			$nombre_documento = $pre.uniqid().'.pdf';
			$archivo_generado = RUTA_PDF_TEMP.$nombre_documento;
			$retorno = array('ruta_directorio' => RUTA_PDF_TEMP, 'nombre' =>$nombre_documento);
			if(!file_exists($archivo_generado)){
				subdirectorios_files(RUTA_PDF_TEMP);
				//var_dump($data);exit;
				$this->default_pdf_params['margin_left'] = 10;
				$this->default_pdf_params['margin_right'] = 10;
				$this->default_pdf_params['margin_top'] = 15;
				$this->default_pdf_params['margin_bottom'] = 15;
				$mpdf = $this->pdf->load($this->default_pdf_params);
				/*if(!es_produccion()){
					$mpdf->SetWatermarkText('PED Demo - ECO SOFTyH');
				}*/
				$mpdf->showWatermarkText = true;
				$data['es_evidencia_imagen'] = $esImg;
				$data['evidencia'] = $entregable;
				$paginaHTML = $this->load->view('pdf/evidencia_imagen_video', $data, true);
				$mpdf->WriteHTML($paginaHTML);
				$mpdf->Output(RUTA_PDF_TEMP.$nombre_documento, 'F');
			}
			return $retorno;
		}catch (Exception $ex){
			log_message('error','***** DocsPDFModel -> generar_entregables');
			log_message('error',$ex->getMessage());
		}
		return false;
	}

}
