<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DocumentosPDF extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DocumentosPDFModel', 'DocumentosPDFModel');
    }

    public function formato_pago()
    {
        $this->DocumentosPDFModel->formato_pago();
    }

    public function datos_alumno($id_alumno, $fisico = false)
    {
        $this->DocumentosPDFModel->datos_alumno($id_alumno, $fisico);
    }

/*
funcion de evaluavion pdf
 */
    public function evaluacionpdf_alumno($id_evaluacion_publicacion_ctn)
    {
        $this->DocumentosPDFModel->evaluacionpdf_alumnos($id_evaluacion_publicacion_ctn);
    }

    public function habilidades_const($id_alumno, $id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->const_habilididades($id_alumno, $id_publicacion_ctn);
    }

    public function constancia_cigede($id_alumno, $id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->cigede_const($id_alumno, $id_publicacion_ctn);
    }

    public function constancia_cigede_blanco($id_alumno, $id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->cigede_const_blanco($id_alumno, $id_publicacion_ctn);
    }

    public function constancia_otra_blanco_todos($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->cigede_const_blanco(false, $id_publicacion_ctn);
    }

    //MATERIALIZAR CONSTANCIA INDIVIDUAL POR ALUMNO
    public function habilidades_const_fisico($id_alumno, $id_publicacion_ctn)
    {
        $constancia_habilidades = $this->DocumentosPDFModel->materializar_constancia_habilidades($id_alumno, $id_publicacion_ctn, true);
        redirect($constancia_habilidades->ruta_documento);
    }
    public function constancia_cigede_fisico($id_alumno, $id_publicacion_ctn)
    {
        $constancia_cigede = $this->DocumentosPDFModel->materializar_constancia_cigede($id_alumno, $id_publicacion_ctn, true);
        redirect($constancia_cigede->ruta_documento);
    }

    //PARA OBTENER TODAS LAS CONSTANCIAS EN UN PDF
    public function cons_cigede($idPublicacionCTN)
    {
        $this->DocumentosPDFModel->constancia_cigede($idPublicacionCTN);
    }

    public function cons_habilidades($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->constancia_habilidades($id_publicacion_ctn);
    }
    public function cons_habilidades_sin_sello($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->cons_habilidades_sin_sello($id_publicacion_ctn);
    }

    public function cons_dc3($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->constancia_dc3_todos($id_publicacion_ctn);
    }
    
    public function cons_dc3_sin_firma($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->constancia_dc3_todos_sin_firma($id_publicacion_ctn);
    }

    public function constancia_dc3($id_alumno, $id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->constancia_dc3($id_alumno, $id_publicacion_ctn);
        //redirect($constancia_dc3->ruta_documento);
    }

    public function constancia_dc3_sin_materializar($id_alumno, $id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->constancia_dc3($id_alumno, $id_publicacion_ctn, true);

    }

    public function constancia_instructor_publicacion_ctn($id_publicacion_ctn, $id_instructor)
    {
        $this->DocumentosPDFModel->constancia_instructor_publicacion_ctn($id_publicacion_ctn, $id_instructor);
    }

    public function carta_descriptiva_empresa($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->carta_descriptiva_empresa($id_publicacion_ctn);
    }

    public function informe_final_empresa($id_publicacion_ctn)
    {
        $this->DocumentosPDFModel->informe_final_empresa($id_publicacion_ctn);
    }

    public function constancia_fdh_alumno($id_publicacion_ctn, $id_alumno = false)
    {
        $this->DocumentosPDFModel->constancia_fdh_alumno($id_publicacion_ctn, $id_alumno);
    }
    public function constancia_fdh_alumno_sin_sello($id_publicacion_ctn, $id_alumno = false)
    {
        $this->DocumentosPDFModel->constancia_fdh_alumno_sin_sello($id_publicacion_ctn, $id_alumno);
    }
//PDF ficha de registro
   public function constancia_ficha_registro($id_publicacion_ctn, $id_alumno = false)
   {
    $this->DocumentosPDFModel->constancia_ficha_registro($id_publicacion_ctn, $id_alumno);
   }
    public function cotizacion($id_cotizacion)
    {
        $this->DocumentosPDFModel->cotizacion($id_cotizacion);
    }

    public function evaluacion($id_publicacion_ctn,$tipo = 'diagnostica',$id_evaluacion_alumno_publicacion_ctn = false,$es_html = false){
        $this->DocumentosPDFModel->evaluacion($id_publicacion_ctn,$tipo,$id_evaluacion_alumno_publicacion_ctn,$es_html);
    }
    public function crenciales_instructor(){
       $this->DocumentosPDFModel->crenciales_instructor();

    }
  

}
