<?php

defined('BASEPATH') or exit('No tiene access al script');

class DocumentosPDFModel extends CI_Model
{

    private $default_pdf_params;

    public function __construct()
    {
        //$this->load->library('m_pdf');
        $this->load->library('pdf');
        $this->load->model('DocumentosModel');
        $this->load->model('CatalogosModel', 'CatalogosModel');
        $this->load->model('EncuestaSatisfaccionModel');
        $this->load->model('Cotizaciones_model');
        $this->load->model('Evaluacion_model');
        $this->set_variables_defaults_pdf();
    }

    /**
     * metodos publicos para obtener informacion de las estaciones de servicio
     */
    public function formato_pago()
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 13, '', '', 'p');
        //catalogo_formas_pago
        $this->default_pdf_params['margin_left'] = 26;
        $this->default_pdf_params['margin_right'] = 26;
        $this->default_pdf_params['margin_top'] = 10;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['catalogo_formas_pago'] = $this->CatalogosModel->obtenerCatalogoFormasPagoAdmin();
        $data['catalogo_forma_pago_detalle'] = $this->CatalogosModel->obtener_forma_pago_detalle();
        //var_dump($data);exit; 
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/pago/formas_pago', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Formato de pago.pdf', 'I');
    }

    public function datos_alumno($id_alumno_inscrito_ctn_publicado, $fisico = false)
    {
        $this->load->model('AlumnosModel');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 5, 13, '', '', 'p');
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['alumno_inscrito_ctn_publicado'] = $this->AlumnosModel->obtener_datos_alumno_inscrito_publicado($id_alumno_inscrito_ctn_publicado);
        $id_alumno = $data['alumno_inscrito_ctn_publicado']->id_alumno;
        $data['alumno'] = $this->AlumnosModel->obtener_datos_alumno($id_alumno);
        $data['empresa'] = $this->AlumnosModel->obtener_datos_empresa_alumno($id_alumno);
        $data['factura'] = $this->AlumnosModel->obtener_datos_facturacion($id_alumno_inscrito_ctn_publicado);
        $output = 'I';
        $nombre_file = 'Formato registro inscripcion.pdf';
        if ($fisico) {
            $nombre_file = date('H_i_s') . '-' . 'Formato_registro_inscripcion.pdf';
            $output = 'F';
            $directorio = getRouteFilesComun();
            $datos_doc = array(
                'nombre' => $nombre_file,
                'ruta_directorio' => $directorio,
            );
            $id_documento = $this->DocumentosModel->guardarDocumento($datos_doc);
            $documento = $this->DocumentosModel->obtenerDocumentoById($id_documento);
            if (!file_exists(FCPATH . $directorio)) {
                mkdir(FCPATH . $directorio, 0775, true);
            }
        }
        //var_dump($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/datos_alumno', $data, true);
        $mpdf->WriteHTML($paginaHTML);
        $ruta = ($output == 'F') ? FCPATH . $directorio : '';
        $mpdf->Output($ruta . '/' . $nombre_file, $output);
        if ($fisico) {
            return $documento;
        }
    }

    public function const_habilididades($id_alumno, $id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', '', 0, 0, 0, 0, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_top'] = 0;
        $this->default_pdf_params['margin_bottom'] = 0;
        $this->default_pdf_params['margin_left'] = 0;
        $this->default_pdf_params['margin_right'] = 0;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        $data['Constancia'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['Constancia'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }

        $data['numero_alumnos'] = sizeof($data['Constancia']);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_habilidades_todos', $data, true);
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    public function constancia_dc3($id_alumno, $id_publicacion_ctn, $fisico = false)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 3, 7, '', '', 'p');
        //

        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 3;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $mpdf->SetWatermarkImage(base_url().'extras/imagenes/fondos_pdf/marca_agua_demo.png',0.5,'');
        $mpdf->showWatermarkImage = true;
        //$data['constancia'] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        $data['Constancia_dc3'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['Constancia_dc3'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }

        //var_dump($data);exit;
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        //var_dump($data);exit;
        //
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3_todos', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia DC3.pdf', 'I');

    }

    public function generarCodigo($longitud)
    {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $longitud; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }

        return $key;

    }

    /*INDIVIDUAL CONSTANCIA CIGEDE */
    public function cigede_const($id_alumno, $id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', 'Arial', 1.5, 1.5, 1.4, 1.4, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_top'] = 1.4;
        $this->default_pdf_params['margin_bottom'] = 1.4;
        $this->default_pdf_params['margin_left'] = 1.5;
        $this->default_pdf_params['margin_right'] = 1.5;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        $data['Constancia_Cigede'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['Constancia_Cigede'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        //var_dump($data);exit;
        $mpdf->SetWatermarkImage(base_url('extras/imagenes/constancia_cigede/fondo_cigede.png'), 1);
        $mpdf->showWatermarkImage = true;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_cigede.php', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    public function cigede_const_blanco($id_alumno, $id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', 'Arial', 1.5, 1.5, 1.4, 1.4, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_top'] = 1.4;
        $this->default_pdf_params['margin_bottom'] = 1.4;
        $this->default_pdf_params['margin_left'] = 1.5;
        $this->default_pdf_params['margin_right'] = 1.5;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        if ($id_alumno) {
            $data['Constancia_Cigede'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
            if ($data['Constancia_Cigede'][0] === false) {
                echo 'Sin registro de alumno(s) con asistencia';
                exit;
            }
            $data['numero_alumnos'] = 1;
        } else {
            $data['Constancia_Cigede'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
            if ($data['Constancia_Cigede'] === false) {
                echo 'Sin registro de alumno(s) con asistencia';
                exit;
            }
            $data['numero_alumnos'] = sizeof($data['Constancia_Cigede']);
        }
        //var_dump($data['Constancia_Cigede'][0]);exit;
        //$mpdf->SetWatermarkImage(base_url('extras/imagenes/constancia_cigede/fondo_const_cigede.png'));
        // $mpdf->showWatermarkImage = true;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancia_cigede_blanco.php', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    /**
     * funciones para materializar documentos
     */
    //MATERIALIZAR CONSTANCIA CIGEDE INDIVIDUAL
    public function materializar_constancia_cigede($id_alumno, $id_publicacion_ctn)
    {
        //obtener los datos del alumno inscrito en la publicacion
        $alumno_inscrito_ctn_publicado = $this->get_alumno_inscrito_publicacion_ctn($id_alumno, $id_publicacion_ctn);
        $documento_costancia_cigede = $this->obtener_documento_constancia_alumno($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
        if ($documento_costancia_cigede === false) {
            //generar la constancia en fisico y recuperar el registro de la costancia
            $cigede_materializado = $this->cigede_const_guardar_local($id_alumno, $id_publicacion_ctn, true);
            //almacenar la referencia de la constancia materializada que va a tener el alumno
            $insert_constancia_cigede = array(
                'tipo_documento' => 'externa',
                'id_alumno_inscrito_ctn_publicado' => $alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado,
                'id_documento' => $cigede_materializado->id_documento,
            );
            $this->DocumentosModel->insertarAlumnoInscritoHasDocumento($insert_constancia_cigede);
            return $cigede_materializado;
        }
        return $this->DocumentosModel->obtenerDocumentoById($documento_costancia_cigede->id_documento);
    }

    public function cigede_const_guardar_local($id_alumno, $id_publicacion_ctn, $fisico = false)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', 'Arial', 1.5, 1.5, 1.4, 1.4, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_left'] = 1.5;
        $this->default_pdf_params['margin_right'] = 1.5;
        $this->default_pdf_params['margin_top'] = 1.4;
        $this->default_pdf_params['margin_bottom'] = 1.4;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        //var_dump($data);exit;
        $data['Constancia_Cigede'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['Constancia_Cigede'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $mpdf->SetWatermarkImage(base_url('extras/imagenes/constancia_cigede/fondo_cigede.png'), 1);
        $mpdf->showWatermarkImage = true;
        $output = 'I';
        $nombre_pdf = 'Constancia Cigede.pdf';
        if ($fisico) {
            $nombre_pdf = date('H_i_s') . '-' . 'Constancia_Cigede.pdf';
            $output = 'F';
            $directorio = getRouteFilesComun();
            $datos_documento = array(
                'nombre' => $nombre_pdf,
                'ruta_directorio' => $directorio,
            );
            $id_documento = $this->DocumentosModel->guardarDocumentoPDF($datos_documento);
            $documento = $this->DocumentosModel->obtenerDocumentoByIdPDF($id_documento);
            if (!file_exists(FCPATH . $directorio)) {
                mkdir(FCPATH . $directorio, 0775, true);
            }
        }

        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_cigede', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $ruta = ($output == 'F') ? FCPATH . $directorio : '';
        $mpdf->Output($ruta . '/' . $nombre_pdf, $output);
        if ($fisico) {
            return $documento;
        }
    }

    //MATERIALIZAR CONSTANCIA HABILIDADES INDIVIDUAL
    public function materializar_constancia_habilidades($id_alumno, $id_publicacion_ctn)
    {
        //obtener los datos del alumno inscrito en la publicacion
        $alumno_inscrito_ctn_publicado = $this->get_alumno_inscrito_publicacion_ctn($id_alumno, $id_publicacion_ctn);
        $documento_costancia_habilidades = $this->obtener_documento_constancia_habilidades_alumno($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
        if ($documento_costancia_habilidades === false) {
            //generar la constancia en fisico y recuperar el registro de la costancia
            $habilidades_materializado = $this->habilidades_const_guardar_local($id_alumno, $id_publicacion_ctn, true);
            //almacenar la referencia de la constancia materializada que va a tener el alumno
            $insert_constancia_habilidades = array(
                'tipo_documento' => 'habilidades',
                'id_alumno_inscrito_ctn_publicado' => $alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado,
                'id_documento' => $habilidades_materializado->id_documento,
            );
            $this->DocumentosModel->insertarAlumnoInscritoHasDocumento($insert_constancia_habilidades);
            return $habilidades_materializado;
        }
        return $this->DocumentosModel->obtenerDocumentoById($documento_costancia_habilidades->id_documento);
    }

    public function habilidades_const_guardar_local($id_alumno, $id_publicacion_ctn, $fisico = false)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', '', 0, 0, 0, 0, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_top'] = 0;
        $this->default_pdf_params['margin_bottom'] = 0;
        $this->default_pdf_params['margin_left'] = 0;
        $this->default_pdf_params['margin_right'] = 0;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        $data['Constancia'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['Constancia_Cigede'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        //var_dump($data);exit;
        $data['numero_alumnos'] = sizeof($data['Constancia_Habilidades']);
        $output = 'I';
        $nombre_pdf = 'Constancia Habilidades.pdf';
        if ($fisico) {
            $nombre_pdf = date('H_i_s') . '-' . 'Constancia_Habilidades.pdf';
            $output = 'F';
            $directorio = getRouteFilesComun();
            $datos_documento = array(
                'nombre' => $nombre_pdf,
                'ruta_directorio' => $directorio,
            );
            $id_documento = $this->DocumentosModel->guardarDocumentoPDF($datos_documento);
            $documento = $this->DocumentosModel->obtenerDocumentoByIdPDF($id_documento);
            if (!file_exists(FCPATH . $directorio)) {
                mkdir(FCPATH . $directorio, 0775, true);
            }
            $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_habilidades', $data, true);
            //echo $paginaHTML;exit;
            $mpdf->WriteHTML($paginaHTML);
            $ruta = ($output == 'F') ? FCPATH . $directorio : '';
            $mpdf->Output($ruta . '/' . $nombre_pdf, $output);
            if ($fisico) {
                return $documento;
            }
        }
    }

    //MATERIALIZAR CONSTANCIA DC-3
    public function materializar_constancia_dc3($id_alumno, $id_publicacion_ctn)
    {
        //obtener los datos del alumno inscrito en la publicacion
        $alumno_inscrito_ctn_publicado = $this->get_alumno_inscrito_publicacion_ctn($id_alumno, $id_publicacion_ctn);
        $documento_costancia_dc3 = $this->obtener_documento_const_dc3_alumno($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
        if ($documento_costancia_dc3 === false) {
            //generar la constancia en fisico y recuperar el registro de la costancia
            $dc3_materializado = $this->dc3_const_guardar_local($id_alumno, $id_publicacion_ctn, true);
            //almacenar la referencia de la constancia materializada que va a tener el alumno
            $insert_constancia_dc3 = array(
                'tipo_documento' => 'dc_3',
                'id_alumno_inscrito_ctn_publicado' => $alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado,
                'id_documento' => $dc3_materializado->id_documento,
            );
            $this->DocumentosModel->insertarAlumnoInscritoHasDocumento($insert_constancia_dc3);
            return $dc3_materializado;
        }
        return $this->DocumentosModel->obtenerDocumentoById($documento_costancia_dc3->id_documento);
    }

    public function dc3_const_guardar_local($id_alumno, $id_publicacion_ctn, $fisico = false)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 11, '', '', 'p');
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 11;
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['constancia'] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn);
        if ($data['constancia'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        //var_dump($data);exit;
        $data['numero_alumnos'] = sizeof($data['Constancia_DC-3']);
        $output = 'I';
        $nombre_pdf = 'Constancia DC3.pdf';
        if ($fisico) {
            $nombre_pdf = date('H_i_s') . '-' . 'Constancia_DC-3.pdf';
            $output = 'F';
            $directorio = getRouteFilesComun();
            $datos_documento = array(
                'nombre' => $nombre_pdf,
                'ruta_directorio' => $directorio,
            );
            $id_documento = $this->DocumentosModel->guardarDocumentoPDF($datos_documento);
            $documento = $this->DocumentosModel->obtenerDocumentoByIdPDF($id_documento);
            if (!file_exists(FCPATH . $directorio)) {
                mkdir(FCPATH . $directorio, 0775, true);
            }
            $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3', $data, true);

            $mpdf->WriteHTML($paginaHTML);
            $ruta = ($output == 'F') ? FCPATH . $directorio : '';
            $mpdf->Output($ruta . '/' . $nombre_pdf, $output);
            if ($fisico) {
                return $documento;
            }
        }
    }

    //FIN MATERIALIZAR INDIVIDUAL

    /*TODAS LAS CONSTANCIAS CIGEDE DE UNA PUBLICACION*/
    public function constancia_cigede($idPublicacionCTN)
    {
        //$mpdf = new mpdf('', 'letter-l', '12', 'Arial', 1.5, 1.5, 1.4, 1.4, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_left'] = 1.5;
        $this->default_pdf_params['margin_right'] = 1.5;
        $this->default_pdf_params['margin_top'] = 1.4;
        $this->default_pdf_params['margin_bottom'] = 1.4;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        //var_dump($data);exit;
        $data['Constancia_Cigede'] = $this->DocumentosModel->obtenerDatosConstancia($idPublicacionCTN);
        if ($data['Constancia_Cigede'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $data['numero_alumnos'] = sizeof($data['Constancia_Cigede']);
        $mpdf->SetWatermarkImage(base_url('extras/imagenes/constancia_cigede/fondo_cigede.png'), 1);
        //$this->watermarkImageAlpha =0.5;
        $mpdf->showWatermarkImage = true;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_cigede_todos', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    public function constancia_habilidades($id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', '', 0, 0, 0, 0, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_left'] = 0;
        $this->default_pdf_params['margin_right'] = 0;
        $this->default_pdf_params['margin_top'] = 0;
        $this->default_pdf_params['margin_bottom'] = 0;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        $data['Constancia'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
        if ($data['Constancia'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $data['numero_alumnos'] = sizeof($data['Constancia']);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_habilidades_todos', $data, true);
        //var_dump('termine');exit;
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    public function cons_habilidades_sin_sello($id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter-l', '12', '', 0, 0, 0, 0, '', '', '-l');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_left'] = 0;
        $this->default_pdf_params['margin_right'] = 0;
        $this->default_pdf_params['margin_top'] = 0;
        $this->default_pdf_params['margin_bottom'] = 0;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        $data['Constancia'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
        if ($data['Constancia'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $data['numero_alumnos'] = sizeof($data['Constancia']);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_habilidades_todos_sin_sello', $data, true);
        //var_dump('termine');exit;
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }


    public function constancia_dc3_todos($id_publicacion_ctn)
    {
        set_time_limit(9999999999);
		ini_set("pcre.backtrack_limit", "99999999");
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 7, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 3;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['Constancia_dc3'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
        //var_dump($data['Constancia_dc3']);exit;
        if ($data['Constancia_dc3'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;

        }
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3_todos', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

    public function constancia_dc3_todos_sin_firma($id_publicacion_ctn)
    {
        set_time_limit(9999999999);
        ini_set("pcre.backtrack_limit", "99999999");
        $this->load->model('DocumentosModel', 'DocumentosModel');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 7, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 3;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['Constancia_dc3'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
        //var_dump($data['Constancia_dc3']);exit;
        if ($data['Constancia_dc3'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;

        }
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de DC-3.pdf', 'I');
    }

    public function constancia_fdh_alumno($idPublicacionCTN, $id_alumno = false)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 7, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        //var_dump($data);exit;
        if ($id_alumno) {
            $data['Constancia_Cigede'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $idPublicacionCTN);
        } else {
            $data['Constancia_Cigede'] = $this->DocumentosModel->obtenerDatosConstancia($idPublicacionCTN, true);
        }
        if ($data['Constancia_Cigede'] === false || (isset($data['Constancia_Cigede'][0]) && $data['Constancia_Cigede'][0] === false)) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $data['numero_alumnos'] = sizeof($data['Constancia_Cigede']);
        //var_dump($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/contancia_fdh', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia FDH.pdf', 'I');
    }

    public function constancia_fdh_alumno_sin_sello($idPublicacionCTN, $id_alumno = false)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 7, '', '', 'p');
		set_time_limit(9999999999);
        ini_set("pcre.backtrack_limit", "99999999");
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = array();
        //var_dump($data);exit;
        if ($id_alumno) {
            $data['Constancia_Cigede'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($id_alumno, $idPublicacionCTN);
        } else {
            $data['Constancia_Cigede'] = $this->DocumentosModel->obtenerDatosConstancia($idPublicacionCTN, true);
        }
        if ($data['Constancia_Cigede'] === false || (isset($data['Constancia_Cigede'][0]) && $data['Constancia_Cigede'][0] === false)) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        $data['numero_alumnos'] = sizeof($data['Constancia_Cigede']);
        //var_dump($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_fdh_sin_sello', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia FDH.pdf', 'I');
    }

    public function constancia_ficha_registro($id_publicacion_ctn, $id_alumno = false)
    {
		set_time_limit(9999999999);
        ini_set("pcre.backtrack_limit", "99999999");
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 16;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);

        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/ficha_registro', $data, true);
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Ficha De Registro.pdf', 'I');

    }


    public function constancia_instructor_publicacion_ctn($id_publicacion_ctn, $id_instructor)
    {
		set_time_limit(9999999999);
        ini_set("pcre.backtrack_limit", "99999999");
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 11, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 11;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['instructor'] = $this->obtener_instructor_by_id($id_instructor);
        $data['publicacion_ctn'] = $this->get_ctn($id_publicacion_ctn);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/constancia_instructor', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia Instructor', 'I');
    }

    public function carta_descriptiva_empresa($id_publicacion_ctn)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 8, 7, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 10;
        $this->default_pdf_params['margin_right'] = 10;
        $this->default_pdf_params['margin_top'] = 8;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        //$data['publicacion_ctn_has_empresa_masivo'] = $this->obtener_publicacion_ctn_has_empresa_by_id($id_publicacion_ctn_has_empresa_masivo);
        $data['carta_descriptiva'] = $this->DocumentosModel->obtener_datos_carta_descritiva_publicacion_ctn($id_publicacion_ctn);
        if ($data['constancia'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        //var_dump($data);exit;
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        //var_dump($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/carta_descriptiva_empresa', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia DC3.pdf', 'I');
    }

    public function informe_final_empresa($id_publicacion_ctn)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 13, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 13;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        //$data['publicacion_ctn_has_empresa_masivo'] = $this->obtener_publicacion_ctn_has_empresa_by_id($id_publicacion_ctn_has_empresa_masivo);
        $data['carta_descriptiva'] = $this->DocumentosModel->obtener_datos_carta_descritiva_publicacion_ctn($id_publicacion_ctn);
        $data['empleados_curso'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn, false);
        $data['pregunta_encuesta_satisfaccion'] = false;
        if (is_array($data['empleados_curso']) && sizeof($data['empleados_curso']) != 0) {
            $preguntas = $this->EncuestaSatisfaccionModel->iniciar_encuesta_satisfacion_admin($data['empleados_curso'][0]->id_instructor_asignado_curso_publicado);
            $data = array_merge($data, $preguntas);
        }
        $data['constancias_dc3_entregadas'] = $this->DocumentosModel->getContanciasDc3();
        $data['promedio_evaluacion_diagnostica'] = $this->DocumentosModel->getPromedioEvaDiagnostica();
        $data['promedio_evaluacion_final'] = $this->DocumentosModel->getPromedioEvaFinal();
        if ($data['constancia'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }
        //var_dump($data);exit;
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        //var_dump($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/informe_final_empresa', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia DC3.pdf', 'I');
    }

    public function cotizacion($id_contizacion)
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 35, 25, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 10;
        $this->default_pdf_params['margin_right'] = 10;
        $this->default_pdf_params['margin_top'] = 35;
        $this->default_pdf_params['margin_bottom'] = 25;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['cotizacion'] = $this->Cotizaciones_model->obtener_cotizacion($id_contizacion);
        $data['curso_taller_norma'] = $this->obtener_curso_taller_norma($data['cotizacion']->id_curso_taller_norma);
        //$mpdf->SetWatermarkImage(base_url('extras/imagenes/fondos_pdf/cotizacion.png'),1);
        //$mpdf->showWatermarkImage = true;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/cotizacion_civika', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Cotizacion Civika.pdf', 'I');
    }

    /**fUNCION PARA CREAR PDF EVALUACION
     * @author Angel
     */

    public function evaluacionpdf_alumnos($id_evaluacion_publicacion_ctn)
    {
        $this->load->model('Evaluacion_model');
        //$mpdf = new mpdf('', 'A4-L', '10', 'Arial', 4, 4, 1, 3, '', '', '-L');
        $this->default_pdf_params['orientation'] = 'L';
        $this->default_pdf_params['margin_left'] = 4;
        $this->default_pdf_params['margin_right'] = 4;
        $this->default_pdf_params['margin_top'] = 1;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['evaluacion_publicacion_ctn'] = $this->Evaluacion_model->obtener_evaluacion_publicacion_ctn_by_id($id_evaluacion_publicacion_ctn);
        $data['preguntas_publicacion_ctn'] = $this->Evaluacion_model->buscar_preguntas_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn);

        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/datos_examen', $data, true);
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('examen.pdf', 'I');
    }

    public function evaluacion($id_publicacion_ctn, $tipo = 'diagnostica', $id_evaluacion_alumno_publicacion_ctn = false, $es_html = false)
    {
        $this->load->model('Evaluacion_model');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 7, 7, '', '', 'p');
        $this->default_pdf_params['margin_top'] = 7;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data['tipo_evaluacion'] = $tipo;
        $data['publicacion'] = $this->get_ctn($id_publicacion_ctn);
        $data['evaluacion_publicacion_ctn'] = $this->Evaluacion_model->obtener_evaluacion_publicacion_ctn($id_publicacion_ctn, $tipo);
        $data['pregunta_publicacion_ctn'] = $this->Evaluacion_model->buscar_preguntas_evaluacion_publicacion_ctn($data['evaluacion_publicacion_ctn']->id_evaluacion_publicacion_ctn);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/examen_publicacion_ctn', $data, true);
        if ($es_html) {
            echo $paginaHTML;
            exit;
        }
        //var_dump($data);exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Evaluación ' . $tipo . '.pdf', 'I');
    }

    public function evaluacion_lectura($id_publicacion_ctn, $tipo = 'diagnostica', $id_evaluacion_alumno_publicacion_ctn = false, $es_html = false)
    {
        $this->load->model('Evaluacion_model');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 7, 7, '', '', 'p');
        $this->default_pdf_params['margin_top'] = 7;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        $data['tipo_evaluacion'] = $tipo;
        $data['publicacion'] = $this->get_ctn($id_publicacion_ctn);
        //echo '<pre>'.print_r($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/examen_publicacion_ctn_lectura', $data, true);
        if ($es_html) {
            echo $paginaHTML;
            exit;
        }
        //var_dump($data);exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Evaluación ' . $tipo . '.pdf', 'I');
    }

    public function evaluacion_conocimientos($id_publicacion_ctn, $id_evaluacion_alumno_publicacion_ctn, $es_html = false)
    {

        $this->load->model('Evaluacion_model');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 7, 7, '', '', 'p');
        $this->default_pdf_params['margin_top'] = 5;
        $this->default_pdf_params['margin_bottom'] = 7;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        $data = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        $data['publicacion'] = $this->get_ctn($id_publicacion_ctn);
        $usuario_datos = $this->ControlUsuariosModel->obtenerUsuarioDetalle($data['usuario']->id_usuario,'alumno');
        $data = array_merge($data,$usuario_datos);

        //para el QR
        $this->load->library('ciqrcode');
        $nombreQR = fechaDBToNameQR($data['evaluacion_alumno_publicacion_ctn']->fecha_envio);
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_evaluacion_alumno_publicacion_ctn;
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_alumno_inscrito_ctn_publicado;
        $qr_image = $nombreQR.'.png';
        $params['data'] = base_url().'DocumentosPDF/evaluacion_conocimientos/'.$id_publicacion_ctn.'/'.$id_evaluacion_alumno_publicacion_ctn;
        $params['level'] = 'l';
        $params['size'] = 2;

        $params['savename'] =FCPATH."imagenes/QR".$qr_image;
        if(!file_exists($params['savename'])){
            if($this->ciqrcode->generate($params))
            {
                //se genero el qr correctamente
            }
        }
        $data['qr_image_WM'] = base_url().'imagenes/QR'.$qr_image;
        //echo '<pre>'.print_r($data);exit;
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/evaluacion_conocimientos', $data, true);
        if ($es_html) {
            echo $paginaHTML;
            exit;
        }
        //var_dump($data);exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Evaluación Conocimientos - '.$id_publicacion_ctn.' - '.$id_evaluacion_alumno_publicacion_ctn.'.pdf', 'I');
    }

    public function constancia_wm($id_publicacion_ctn,$id_evaluacion_alumno_publicacion_ctn = false,$es_html = false){
        $tipo = 'final';
        $this->load->model('Evaluacion_model');
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 7, 7, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 5;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 3;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);

        //datos para la evaluacion de conocimientos
        $data = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        $data['publicacion'] = $this->get_ctn($id_publicacion_ctn);
        $usuario_datos = $this->ControlUsuariosModel->obtenerUsuarioDetalle($data['usuario']->id_usuario,'alumno');
        $data['usuario'] = $usuario_datos['usuario'];
        $data = array_merge($data,$usuario_datos);

        //datos para la dc3
        $data['Constancia_dc3'][0] = $this->DocumentosModel->obtenerDatosConstanciaAlumno($data['usuario_alumno']->id_alumno, $id_publicacion_ctn);
        $firma_instructor = false;
        if ($data['Constancia_dc3'][0] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;
        }else{
            if(isset($data['Constancia_dc3'][0]->ruta_documento_firma) && existe_valor($data['Constancia_dc3'][0]->ruta_documento_firma)){
                $firma_instructor = true;
            }
        }
        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);

        //datos para la evaluacion lectura
        $data_evaluacion_lectura = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        $data['tipo_evaluacion'] = $tipo;
        $data['publicacion'] = $this->get_ctn($id_publicacion_ctn);

        $data = array_merge($data,$data_evaluacion_lectura);

        //para el QR
        $this->load->library('ciqrcode');
        $nombreQR = fechaDBToNameQR($data['evaluacion_alumno_publicacion_ctn']->fecha_envio);
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_evaluacion_alumno_publicacion_ctn;
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_alumno_inscrito_ctn_publicado;
        $qr_image = $nombreQR.'.png';
        $params['data'] = base_url().'DocumentosPDF/constancia_wm/'.$id_publicacion_ctn.'/'.$id_evaluacion_alumno_publicacion_ctn;
        $params['level'] = 'l';
        $params['size'] = 2;

        $params['savename'] =FCPATH."imagenes/QRWM".$qr_image;
        if(!file_exists($params['savename'])){
            if($this->ciqrcode->generate($params))
            {
                //se genero el qr correctamente
            }
        }
        $data['qr_image_WM'] = base_url().'imagenes/QRWM'.$qr_image;

        $data['usuario'] = $usuario_datos['usuario'];
        $data = array_merge($data,$usuario_datos);
        $paginaHTMLConstanciaWM = $this->load->view('cursos_civik/documentos_pdf/evaluacion_conocimientos', $data, true);
        $paginaHTMLConstanciaDC3 = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3_todos', $data, true);
        $paginaHTMLEvaluacionLectura = $this->load->view('cursos_civik/documentos_pdf/examen_publicacion_ctn_lectura', $data, true);

        $mpdf->WriteHTML($paginaHTMLConstanciaWM);

        $mpdf->AddPage();
        $mpdf->SetWatermarkImage(base_url().'extras/imagenes/fondos_pdf/marca_agua_demo.png',0.5,'');
        $mpdf->showWatermarkImage = true;

        $mpdf->WriteHTML($paginaHTMLConstanciaDC3);

        $mpdf->AddPage();
        $mpdf->showWatermarkImage = false;
        $mpdf->WriteHTML($paginaHTMLEvaluacionLectura);
        $mpdf->Output('Constancia WM - '.$id_publicacion_ctn.' - '.$id_evaluacion_alumno_publicacion_ctn.'.pdf', 'I');
    }

    public function gafete_wm($id_publicacion_ctn,$id_evaluacion_alumno_publicacion_ctn){
        $this->default_pdf_params['margin_left'] = 15;
        $this->default_pdf_params['margin_right'] = 5;
        $this->default_pdf_params['margin_top'] = 7;
        $this->default_pdf_params['margin_bottom'] = 3;
        $mpdf = $this->pdf->load($this->default_pdf_params);
        //datos para la evaluacion de conocimientos
        $data = $this->Evaluacion_model->obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn);
        $usuario_datos = $this->ControlUsuariosModel->obtenerUsuarioDetalle($data['usuario']->id_usuario,'alumno');
        $data['usuario'] = $usuario_datos['usuario'];
        $data = array_merge($data,$usuario_datos);

        //para el QR
        $this->load->library('ciqrcode');
        $nombreQR = fechaDBToNameQR($data['evaluacion_alumno_publicacion_ctn']->fecha_envio);
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_evaluacion_alumno_publicacion_ctn;
        $nombreQR .= '-'.$data['evaluacion_alumno_publicacion_ctn']->id_alumno_inscrito_ctn_publicado;
        $qr_image = $nombreQR.'.png';
        $params['data'] = base_url().'DocumentosPDF/constancia_wm/'.$id_publicacion_ctn.'/'.$id_evaluacion_alumno_publicacion_ctn;
        $params['level'] = 'l';
        $params['size'] = 2;

        $params['savename'] =FCPATH."imagenes/QRWM".$qr_image;
        if(!file_exists($params['savename'])){
            if($this->ciqrcode->generate($params))
            {
                //se genero el qr correctamente
            }
        }
        $data['qr_image_WM'] = base_url().'imagenes/QRWM'.$qr_image;

        $paginaHTMLgafeteWM = $this->load->view('cursos_civik/documentos_pdf/gafete_wm', $data, true);
        $mpdf->WriteHTML($paginaHTMLgafeteWM);
        $mpdf->Output('Gafete WM - '.$id_evaluacion_alumno_publicacion_ctn.'.pdf', 'I');
    }

    /**
     * Funcion para crear credenciales de intructores
     */
    public function crenciales_instructor()
    {
        //$mpdf = new mpdf('', 'letter', '12', 'Arial', 10, 10, 35, 25, '', '', 'p');
        $this->default_pdf_params['margin_left'] = 10;
        $this->default_pdf_params['margin_right'] = 10;
        $this->default_pdf_params['margin_top'] = 15;
        $this->default_pdf_params['margin_bottom'] = 15;
        $mpdf = $this->pdf->load($this->default_pdf_params);

        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/crenciales_instructor', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Credenciales DE Instructores.pdf', 'I');
    }

    /**
     * apartado de funciones privada
     */
    private function obtener_curso_taller_norma($id_curso_taller_norma)
    {
        $this->db->where('id_curso_taller_norma', $id_curso_taller_norma);
        $query = $this->db->get('curso_taller_norma');
        return $query->row();
    }

    private function get_ctn($idPublicacionCTN)
    {
        $today = date('Y-m-d');
        $consulta = "select
              ctn.nombre,
              pc.nombre_curso_comercial,pc.fecha_inicio,
              pc.fecha_fin,pc.direccion_imparticion,pc.duracion,
              if(pc.fecha_limite_inscripcion > '$today',pc.costo_en_tiempo,pc.costo_extemporaneo) costo
            from publicacion_ctn pc
              inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
            where pc.id_publicacion_ctn = $idPublicacionCTN";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    private function get_alumno_inscrito_publicacion_ctn($id_alumno, $id_publicacion_ctn)
    {
        $consulta = "select * from alumno_inscrito_ctn_publicado aicp
            where aicp.id_alumno = $id_alumno
            and aicp.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    private function obtener_documento_constancia_alumno($id_alumno_inscrito_ctn_publicado, $tipo_documento = 'externa')
    {
        $this->db->where('id_alumno_inscrito_ctn_publicado', $id_alumno_inscrito_ctn_publicado);
        $this->db->where('tipo_documento', $tipo_documento);
        $query = $this->db->get('alumno_inscrito_has_documento');
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();

    }

    private function obtener_documento_constancia_habilidades_alumno($id_alumno_inscrito_ctn_publicado, $tipo_documento = 'habilidades')
    {
        $this->db->where('id_alumno_inscrito_ctn_publicado', $id_alumno_inscrito_ctn_publicado);
        $this->db->where('tipo_documento', $tipo_documento);
        $query = $this->db->get('alumno_inscrito_has_documento');
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();

    }

    private function obtener_documento_const_dc3_alumno($id_alumno_inscrito_ctn_publicado, $tipo_documento = 'dc_3')
    {
        $this->db->where('id_alumno_inscrito_ctn_publicado', $id_alumno_inscrito_ctn_publicado);
        $this->db->where('tipo_documento', $tipo_documento);
        $query = $this->db->get('alumno_inscrito_has_documento');
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();

    }

    private function obtener_instructor_by_id($id_instructor)
    {
        $consulta = "select
              u.nombre, u.apellido_p, u.apellido_m
            from instructor i
              inner join usuario u on u.id_usuario = i.id_usuario
            where i.id_instructor = $id_instructor";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    private function obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn)
    {
        $consulta = "select
              d.*
            from publicacion_has_doc_banner pdb
              inner join documento d on d.id_documento = pdb.id_documento
            where pdb.id_publicacion_ctn = $id_publicacion_ctn
              and pdb.tipo = 'logo_empresa'
            order by pdb.id_publicacion_has_doc_banner desc
            limit 1";
        $query = $this->db->query($consulta);
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();
    }

    private function obtener_publicacion_ctn_has_empresa_by_id($id_publicacion_ctn_has_empresa_masivo)
    {
        $this->db->where('id_publicacion_ctn_has_empresa_masivo', $id_publicacion_ctn_has_empresa_masivo);
        $query = $this->db->get('publicacion_ctn_has_empresa_masivo');
        return $query->row();
    }

    protected function set_variables_defaults_pdf()
    {
        require_once FCPATH . 'vendor/autoload.php';
        $default_config = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $default_font_config = (new \Mpdf\Config\FontVariables())->getDefaults();
        $font_dirs = $default_config['fontDir'];
        $font_data = $default_font_config['fontdata'];
        $this->default_pdf_params = [
            'format' => 'Letter',
            'default_font_size' => '12',
            'default_font' => 'Arial',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 13,
            'orientation' => 'P',
            'fontDir' => array_merge($font_dirs, [
                FCPATH . 'extras/fonts'
            ]),
            'fontdata' => $font_data + [
                    "nueva_fuente_modern" => [
                        'R' => "modern_led_board-7.ttf",
                        'B' => "modern_led_board-7.ttf",
                        'I' => "modern_led_board-7.ttf",
                        'BI' => "modern_led_board-7.ttf",
                    ],

                    "nueva_fuente_zillmo" => [
                        'R' => "ZILLMOO_.ttf",
                        'B' => "ZILLMOO_.ttf",
                        'I' => "ZILLMOO_.ttf",
                        'BI' => "ZILLMOO_.ttf",
                    ],

                    "nueva_fuente_bau" => [
                        'R' => "BauhausStd-Medium.ttf",
                        'B' => "BauhausStd-Medium.ttf",
                        'I' => "BauhausStd-Medium.ttf",
                        'BI' => "BauhausStd-Medium.ttf",
                    ],
                ]
        ];
    }
}
