<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DocumentosEXCEL extends CI_Controller {

    function __construct(){
        parent:: __construct();
        $this->load->model('DocumentosEXCELModel','DocumentosEXCELModel');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
    }

    public function Lista_Asistencia($id_publicacion_ctn,$id_instructor_asignado){
        $data['registros'] = $this->DocumentosEXCELModel->excel_lista_asistencia($id_publicacion_ctn,$id_instructor_asignado);
        $data['publicacion_ctn'] = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $data['instructor'] = $this->CursosModel->obtener_instructor_asignado($id_publicacion_ctn,$id_instructor_asignado);
        //condicion ? valor_verdador : valor_false;
        $data['existen_datos'] = sizeof($data['registros']) != 0 ? true : false;
        $data['cabeceras'] = isset($data['registros'][0]) ? $data['registros'][0] : false;
        //para complementar el numero de registros que debe tener el excel como vacios
        for($index = sizeof($data['registros']); $index < $data['instructor']->capacidad_aula; $index++){
            $registro_vacio = new stdClass();
            $registro_vacio->NOMBRE = '';
            $registro_vacio->CURP = '';
            $registro_vacio->EMPRESA = '';
            $registro_vacio->FIRMA = '';
            $registro_vacio->FECHA = '';
            $registro_vacio->BAUCHER = '';
            $registro_vacio->DOCUMENTOS = '';
            $data['registros'][$index] = $registro_vacio;
        }
        header('Content-type: text/html; charset=utf8');
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: attachment; filename=Lista_de_asistencia.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $this->load->view('cursos_civik/documentos/excel/lista_asistencia',$data);
    }

    public function lista_datos_generar_constancias($id_publicacion_ctn){
        $data['registros'] = $this->DocumentosEXCELModel->excel_lista_generar_constancias($id_publicacion_ctn);
        //condicion ? valor_verdador : valor_false;
        $data['existen_datos'] = sizeof($data['registros']) != 0 ? true : false;
        $data['cabeceras'] = $data['registros'][0];

        header('Content-type: text/html; charset=utf8');
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: attachment; filename=resultado_excel.xls");
        header("Pragma: no-cache");
        header("Expires: 0");


        $this->load->view('cursos_civik/exportar_excel',$data);
    }

}