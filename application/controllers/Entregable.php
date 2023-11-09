<?php

class entregable extends CI_Controller
{
	private $usuario;
	public $entregables;
	function __construct()
	{
		parent:: __construct();
		$this->load->model('EntregableAlumnoArchivoModel');
		$this->load->model('EcEntregableAlumno');
		$this->load->model('EntregableECModel');
		$this->load->model('ActividadIEModel');
	}

	function index($id_estandar_competencia){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Entregables esperados';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => base_url().'estandar_competencia'),
				array('nombre' => 'Entregables esperados','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = '';
			$data['extra_js'] = array(
				base_url().'assets/js/ec/entregables.js',
				base_url().'assets/frm/fileinput/js/fileinput.js',
				base_url().'assets/frm/fileupload/js/vendor/jquery.ui.widget.js',
				base_url().'assets/frm/fileupload/js/jquery.iframe-transport.js',
				base_url().'assets/frm/fileupload/js/jquery.fileupload.js'
			);
			$data['extra_css'] = array(
				base_url().'assets/css/EC/entregables.css',
				base_url().'assets/frm/fileinput/css/fileinput.css',
				base_url().'assets/frm/fileupload/css/jquery.fileupload.css',

			);
			$data['usuario'] = $this->usuario;
			$data['estandar'] = $id_estandar_competencia;



			$data['instrumentos'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar_competencia);

			$datos = $this->EntregableECModel->obtener_entregables(1,10,$id_estandar_competencia);

			$data['entregables'] = $datos['data'];
			$data['liberado'] = $datos['liberado'];
			$data['btn_liberar'] = $datos['btn_liberar'];
			$this->load->view('entregables/evidencias_esperadas',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	function index_candidato($id_estandar_competencia,$id_usuario){
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
		try{
			$data['titulo_pagina'] = 'Entregables esperados';
			$data['migas_pan'] = array(
				array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
				array('nombre' => 'Estándar de competencias','activo' => false,'url' => '#'),
				array('nombre' => 'Entregables esperados','activo' => true,'url' => '#'),
			);
			$data['sidebar'] = '';
			$data['extra_js'] = array(
				base_url().'assets/js/ec/entregable_candidato.js',
			);
			$data['extra_css'] = array(
				base_url().'assets/css/EC/entregables.css'
			);
			$data['usuario'] = $this->usuario;
			$datos = $this->EntregableECModel->obtener_entregables_candidato($id_estandar_competencia,$id_usuario);

			$data['entregables'] = $datos;
			//var_dump($data);exit;
			$this->load->view('entregables/candidato/evidencias_candidato',$data);
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
			echo json_encode($response);exit;
		}
	}

	function guardar_entregable(){
		try {


			$post = $this->input->post();
			$rules = array(
				'nombre' => array("required","maxLength"=>150),
				'descripcion' => array("required","maxLength"=>1000),
				'instrucciones' => array("required"),
				'tipo_entregable' => array("required"),
				'instrumentos' => array("required")
			);


			$validaciones = Validaciones_Helper::validateFormAll($post, $rules);

			if($validaciones['success']){
				$id= false;
				if (isset($post['id_entregable'])){
					$id = $post['id_entregable'];
				}
				$data = $this->EntregableECModel->guardar_entregable($post,$id);

				$data['success'] = true;

				if($data['success']){
					$response['success'] = true;
					$response['data'] = (object) $post;
					$response['msg'] = array('Se guardo el entregable correctamente');
				}else{
					$response['success'] = false;
					$response['msg'] = array('No fue posible guardar el entregable, favor de intentar más tarde');
				}
			}else {
				$response['success'] = false;
				$response['code'] = 400;
				$response['msg'] = $validaciones['messages'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);

	}

	public function obtener_entregables($pagina = 1, $limit = 10){
		$post = $this->input->post();
		$datos = $this->EntregableECModel->obtener_entregables($pagina,$limit,$post['id_estandar_competencia']);

		$data['entregables'] = $datos['data'];
		$data['liberado'] = $datos['liberado'];
		$data['btn_liberar'] = $datos['btn_liberar'];

		$this->load->view('entregables/cards_evidencias',$data);
	}
	public function obtener_entregable($id_estandar,$id =0){

		if ($id > 0){
			$data['entregable'] = $this->EntregableECModel->obtener_entregable($id);
		}

		$data['instrumentos'] = $this->ActividadIEModel->obtener_instrumentos_ec($id_estandar);

		$this->load->view('entregables/modal_formulario',$data);
	}

	public function eliminar($id){
		try{
			$eliminar =  $this->EntregableECModel->eliminar($id);
			if($eliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $eliminar['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $eliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function eliminar_archivo($id_archivo_instrumento, $id_entregable_alumno_archivo){
		try{
			$eliminar =  $this->EntregableAlumnoArchivoModel->eliminar_archivo($id_archivo_instrumento, $id_entregable_alumno_archivo);
			if($eliminar['success']){
				$response['success'] = true;
				$response['msg'][] = $eliminar['msg'];
				$response['data'] = $eliminar['data'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $eliminar['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}
	public function cambiar_estatus($id_entregable, $id_estatus, $id_alumno, $id_formulario = false){
		try{
			$data =  $this->EcEntregableAlumno->cambiar_estatus($id_entregable, $id_alumno, $id_estatus,$id_formulario);
			if($data['success']){
				$response['success'] = true;
				$response['msg'][] = $data['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $data['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}

	public function liberar_entregables($id_estandar_competencia){
		try{
			$data =  $this->EntregableECModel->liberar_entregables($id_estandar_competencia);
			if($data['success']){
				$response['success'] = true;
				$response['msg'][] = $data['msg'];
			}else{
				$response['success'] = false;
				$response['msg'][] = $data['msg'];
			}
		}catch (Exception $ex){
			$response['success'] = false;
			$response['msg'][] = 'Hubo un error en el sistema, intente nuevamente';
			$response['msg'][] = $ex->getMessage();
		}
		echo json_encode($response);
	}
}
