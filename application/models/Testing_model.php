<?php

defined('BASEPATH') OR exit('No tiene access al script');

class Testing_model extends CI_Model{

    /**
     * metoso publics para guardar informacion
     */
    public function testing_select(){
        $query = $this->db->get('usuario');
        $result = $query->result();
        var_dump($result);
    }

    public  function testing_excel_listas(){
        $consulta = "select 	
              concat(u.apellido_p,' ',u.apellido_m,' ',u.nombre) NOMBRE,
              a.curp CURP, ea.nombre EMPRESA,
              '' as FIRMA,'' as FECHA,'' as BAUCHER,'' as DOCUMENTOS
          from usuario u
              inner join alumno a on u.id_usuario = a.id_usuario
              LEFT join empresa_alumno ea on a.id_alumno = ea.id_alumno";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtener_usuarios(){
        $query = $this->db->get('usuario');
        $result = $query->result();
        return $result;
    }

    public function alumnos_curso(){
        $consulta = "select 
              u.nombre,u.apellido_p,u.apellido_m,
              aicp.fecha_preinscripcion,aicp.fecha_pago_registrado,aicp.fecha_pago_validado,
              aicp.cumple_comprobante, aicp.observacion_comprobante,
              cpi.descripcion estatus_inscripcion, aicp.requiere_factura,
              aicp.id_instructor_asignado_curso_publicado
            from alumno_inscrito_ctn_publicado aicp 
              inner join catalogo_proceso_inscripcion cpi on cpi.id_catalogo_proceso_inscripcion = aicp.id_catalogo_proceso_inscripcion
              inner join alumno a on a.id_alumno = aicp.id_alumno
              inner join usuario u on u.id_usuario = a.id_usuario
            order by u.apellido_p asc;";
        $query = $this->db->query($consulta);
        $result = $query->result();
        return $result;
    }

 public function constancia_dc3_todos($id_publicacion_ctn)
    {
        $this->load->model('DocumentosModel', 'DocumentosModel');
        $mpdf = new mpdf('', 'letter', '12', 'Arial', 5, 5, 5, 7, '', '', 'p');
        $data['Constancia_dc3'] = $this->DocumentosModel->obtenerDatosConstancia($id_publicacion_ctn);
        //var_dump($data['Constancia_dc3']);exit;
        if ($data['Constancia_dc3'] === false) {
            echo 'Sin registro de alumno(s) con asistencia';
            exit;

        }
        // este esl codigo de qr                   
       $this->load->library('ciqrcode');// llamda a' la libreria
            $qr_image=rand().'.png';// formato en q' se guardara el qr
        $params['data'] = base_url().'DocumentosPDF/constancia_dc3/'.$alumno->id_alumno.'/'.$alumno->id_publicacion_ctn; //url que imprime en qr 
            $params['level'] = 'l'; // nivel de seguridad del qr
            $params['size'] = 3;//  tamaño de la imagen qr
            $params['savename'] =FCPATH."imagenes/QR".$qr_image;//aqui se ponen los parametros para guarda en una carpta 
            if($this->ciqrcode->generate($params)) 
            {
                $data['img_url']=$qr_image; 
            }
         $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3_todos',$data); //aqui envia la imagen a los formatos de las dc3
        // este esl codigo de qr                   

        //para integrar logo empresa a la dc3
        $data['logo_empresa'] = $this->obtener_logo_empresa_publicacion_masiva($id_publicacion_ctn);
        $paginaHTML = $this->load->view('cursos_civik/documentos_pdf/constancias/formato_dc3_todos', $data, true);
        //echo $paginaHTML;exit;
        $mpdf->WriteHTML($paginaHTML);
        $mpdf->Output('Constancia de habilidades.pdf', 'I');
    }

}

?>