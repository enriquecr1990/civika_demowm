<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GaleriaCTN extends CI_Controller {

    public $usuario;
    private $notificaciones;

    function __construct(){
        parent:: __construct();
        $this->load->model('administrarCTN/CursosModel','CursosModel');
        $this->load->model('NotificacionesModel','NotificacionesModel');
        if(sesionActive()){
            $this->usuario = $this->session->userdata('usuario');
            $this->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($this->usuario->id_usuario);
        }else{
            $this->usuario = false;
        }
        if(!es_produccion()){
            $this->load->model('ContadorVisitasModel','ContadorVisitasModel');
            $this->ContadorVisitasModel->registro_contador_visitas();
        }
    }

    public function index(){
        $data = $this->CursosModel->obtener_publicaciones_ctn_galeria();
        $data['seccion'] = 'Publicaciones galeria';
        $data['usuario'] = $this->usuario;
        $data['pagina_select'] = 1;
        $data['limit_select'] = 5;
        if($data['total_registros'] != 0 && $data['total_registros'] > 5){
            $data['paginas'] = intval($data['total_registros'] / 5);
            if($data['total_registros'] % 5){
                $data['paginas']++;
            }
        }
        if(!es_produccion()){
            $data['visitas_sitio'] = $this->ContadorVisitasModel->obtener_visitas_sitio();
        }
        //print_r($data['publicaciones_ctn_galeria']);exit;
        $this->load->view('cursos_civik/admin_ctn/cursos/galeria/tablero',$data);
    }

    public function buscar_galeria_publicacion_ctn($pagina = 1,$limit = 5){
        $data = $this->CursosModel->obtener_publicaciones_ctn_galeria($pagina,$limit);
        $data['pagina_select'] = $pagina;
        $data['limit_select'] = $limit;
        $data['paginas'] = 1;
        if($data['total_registros'] != 0 && $data['total_registros'] > $limit){
            $data['paginas'] = intval($data['total_registros'] / $limit);
            if($data['total_registros'] % $limit){
                $data['paginas']++;
            }
        }
        $this->load->view('cursos_civik/admin_ctn/cursos/galeria/resultados_busqueda',$data);
    }

}
