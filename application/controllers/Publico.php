<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publico extends CI_Controller {

	private $usuario;

	function __construct()
	{
		parent:: __construct();
		if(sesionActive()){
			$this->usuario = usuarioSession();
		}else{
			$this->usuario = null;
		}
	}

	public function index()
	{
		$data['titulo_pagina'] = 'Walmart Certificaciones Civika';
		$data['usuario'] = $this->usuario;
		$this->load->view('publico',$data);
	}

}
