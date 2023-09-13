<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informacion extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = false;
			redirect(base_url().'login');
		}
	}

	public function contacto(){
		$data['titulo_pagina'] = 'Contacto';
		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Contacto','activo' => true,'url' => '#'),
		);
		$data['sidebar'] = '';
		$data['usuario'] = $this->usuario;
		$this->load->view('informacion/contacto',$data);
	}

	public function quienes_somos(){
		$data['titulo_pagina'] = 'Grupo Cívika';
		$data['migas_pan'] = array(
			array('nombre' => 'Inicio','activo' => false,'url' => base_url()),
			array('nombre' => 'Quienes somos','activo' => true,'url' => '#'),
		);
		$data['sidebar'] = '';
		$data['usuario'] = $this->usuario;
		$this->load->view('informacion/quienes_somos',$data);
	}

}
