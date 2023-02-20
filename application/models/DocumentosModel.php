<?php

defined('BASEPATH') OR exit('No tiene access al script');

class DocumentosModel extends CI_Model{

    private $contancias_dc_3;
    private $promedio_eva_diagnostica;
    private $promedio_eva_final;

    function __construct()
    {
        $this->contancias_dc_3 = 0;
        $this->promedio_eva_diagnostica = 0;
        $this->promedio_eva_final = 0;
    }

    /**
     * metodos publicos para obtener informacion de las estaciones de servicio
     */

    public function obtenerDocumentoById($idDocumento){
        $this->db->where('id_documento',$idDocumento);
        $query = $this->db->get('documento');
        $documento = $query->row();
        $documento->ruta_documento = base_url().$documento->ruta_directorio.$documento->nombre;
        return $documento;
    }

    public function obtenerDocumentoByIdPDF($idDocumento){
        $this->db->where('id_documento',$idDocumento);
        $query = $this->db->get('documento');
        $documento = $query->row();
        $documento->ruta_documento = base_url().$documento->ruta_directorio.$documento->nombre;
        return $documento;
    }

    public function obtenerDatosConstancia($id_publicacion_ctn,$asistio = true){
        $base_url = base_url();
        $base_url1 = base_url();
        $base_url2 = base_url();
         $consulta = " select 
                /*DATOS ALUMNO*/
                aicp.id_alumno_inscrito_ctn_publicado,concat (u.apellido_p, ' ', u.apellido_m,' ',u.nombre) Nombre_alumno,a.id_alumno,
                coe.clave_area_subarea clave_ocupacion_especifica, coe.denominacion alumno_denominacion, coe.denominacion ocupacion_especifica, a.curp, a.puesto,
                /*DATOS CURSO*/
                pc.id_publicacion_ctn,ctn.nombre nombre_curso, pc.direccion_imparticion, pc.fecha_inicio, pc.fecha_fin, 
                pc.nombre_curso_comercial, pc.duracion, pc.horario, pc.agente_capacitador,
                ctn.nombre Nombre_Taller, cat.clave clave_area_tematica, cat.denominacion Denominacion_Curso,
                /*DATOS INSTRUCTOR*/
                cta.abreviatura instructor_titulo, i.id_documento_firma,
                concat (ua.nombre, ' ', ua.apellido_p, ' ', ua.apellido_m) Nombre_Instructor,
                concat (dcmto.ruta_directorio,dcmto.nombre) ruta_documento_firma, 
                /*DATOS EMPRESA ALUMNO*/
                ea.nombre, ea.nombre nombre_empresa, ea.rfc, ea.representante_legal, ea.representante_trabajadores,
                aicp.folio_habilidades,
                /* datos para el informe final */
                aicp.id_instructor_asignado_curso_publicado,
                aicp.perciento_asistencia,aicp.calificacion_diagnostica,aicp.calificacion_final,
                concat('$base_url','DocumentosPDF/constancia_dc3/',a.id_alumno,'/',$id_publicacion_ctn) link_to_qr,
                concat('$base_url1','DocumentosPDF/habilidades_const/',a.id_alumno,'/',$id_publicacion_ctn)link_to_qr1,
                concat('$base_url2','DocumentosPDF/constancia_fdh_alumno/',a.id_alumno,'/',$id_publicacion_ctn)
                    link_to_qr2
            from usuario u
                inner join alumno a on a.id_usuario = u.id_usuario
                inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno
                inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
                inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
                inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
                inner join instructor_asignado_curso_publicado iacp on iacp.id_instructor_asignado_curso_publicado = aicp.id_instructor_asignado_curso_publicado
                inner join instructor i on i.id_instructor = iacp.id_instructor
                inner join usuario ua on ua.id_usuario = i.id_usuario
                left join documento dcmto on dcmto.id_documento = i.id_documento_firma
                left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
                left join catalogo_ocupacion_especifica coe on coe.id_catalogo_ocupacion_especifica = a.id_catalogo_ocupacion_especifica
                left join empresa_alumno ea on ea.id_alumno = a.id_alumno
            WHERE pc.id_publicacion_ctn = $id_publicacion_ctn
              and aicp.id_catalogo_proceso_inscripcion = 5";
        if($asistio){
            $consulta .= " and aicp.asistio = 'si'";
        }
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach ($result as $r){
            $r = $this->complement_row_datos_constancia($r);
        }
        $this->promedio_eva_diagnostica = $this->promedio_eva_diagnostica / sizeof($result);
        $this->promedio_eva_final = $this->promedio_eva_final / sizeof($result);
        return $result;
    }

    public function obtenerDatosConstanciaAlumno($id_alumno, $id_publicacion_ctn){
        $base_url = base_url();
        $base_url1 = base_url();
        $base_url2 = base_url();

        $consulta = " select 
                 /*DATOS ALUMNO*/
                aicp.id_alumno_inscrito_ctn_publicado,concat (u.apellido_p, ' ', u.apellido_m,' ',u.nombre) Nombre_alumno,a.id_alumno,
                coe.clave_area_subarea clave_ocupacion_especifica, coe.denominacion alumno_denominacion, coe.denominacion ocupacion_especifica, a.curp, a.puesto,
                /*DATOS CURSO*/
                pc.id_publicacion_ctn,ctn.nombre nombre_curso, pc.direccion_imparticion, pc.fecha_inicio, pc.fecha_fin, 
                pc.nombre_curso_comercial, pc.duracion, pc.horario, pc.agente_capacitador,
                ctn.nombre Nombre_Taller, cat.clave clave_area_tematica, cat.denominacion Denominacion_Curso,
                /*DATOS INSTRUCTOR*/
                cta.abreviatura instructor_titulo,
                concat (ua.nombre, ' ', ua.apellido_p, ' ', ua.apellido_m) Nombre_Instructor,
                concat (dcmto.ruta_directorio,dcmto.nombre) ruta_documento_firma, 
                /*DATOS EMPRESA ALUMNO*/
                ea.nombre, ea.nombre nombre_empresa, ea.rfc, ea.representante_legal, ea.representante_trabajadores,
                aicp.folio_habilidades,
                /* datos para el informe final */
                aicp.perciento_asistencia,aicp.calificacion_diagnostica,aicp.calificacion_final,
                concat('$base_url','DocumentosPDF/constancia_dc3/',$id_alumno,'/',$id_publicacion_ctn) link_to_qr,
                 concat('$base_url1','DocumentosPDF/habilidades_const/',$id_alumno,'/',$id_publicacion_ctn) link_to_qr1,

                  concat('$base_url2','DocumentosPDF/constancia_fdh_alumno/',$id_alumno,'/',$id_publicacion_ctn) link_to_qr2

            from usuario u
                inner join alumno a on a.id_usuario = u.id_usuario
                inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno
                inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
                inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
                inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
                inner join instructor_asignado_curso_publicado iacp on iacp.id_instructor_asignado_curso_publicado = aicp.id_instructor_asignado_curso_publicado
                inner join instructor i on i.id_instructor = iacp.id_instructor
                inner join usuario ua on ua.id_usuario = i.id_usuario
                left join documento dcmto on dcmto.id_documento = i.id_documento_firma
                left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
                left join catalogo_ocupacion_especifica coe on coe.id_catalogo_ocupacion_especifica = a.id_catalogo_ocupacion_especifica
                left join empresa_alumno ea on ea.id_alumno = a.id_alumno
            WHERE a.id_alumno = $id_alumno and pc.id_publicacion_ctn = $id_publicacion_ctn
              and aicp.id_catalogo_proceso_inscripcion = 5
              and aicp.asistio = 'si'";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $row = $query->row();
        return $this->complement_row_datos_constancia($row);
    }

    public function obtener_datos_carta_descritiva_publicacion_ctn($id_publicacion_ctn){
        $consulta = "select 
              ctn.nombre nombre_dc3,
              pc.duracion,
              pc.fecha_inicio,
              pc.fecha_fin,
              concat(cat.clave,' ',cat.denominacion) area_tematica,
              pc.agente_capacitador,
              concat(u.nombre,' ',u.apellido_p,' ',u.apellido_m) instructor,
              i.experiencia_curricular,
              concat(ca.aula,' - ',pc.direccion_imparticion) lugar_imparticion,
              ctn.objetivo,
              pc.eje_tematico
            from publicacion_ctn pc
              inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
              inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
              inner join instructor_asignado_curso_publicado iacp on iacp.id_publicacion_ctn = pc.id_publicacion_ctn
              inner join instructor i on i.id_instructor = iacp.id_instructor
              inner join catalogo_aula ca on ca.id_catalogo_aula = iacp.id_catalogo_aula
              inner join usuario u on u.id_usuario = i.id_usuario
            where pc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function insertarAlumnoInscritoHasDocumento($insert){
        $this->db->insert('alumno_inscrito_has_documento',$insert);
        return $this->db->insert_id();
    }

    /**
     * metodos de funciones para actualizar la  informacion de las ES
     */
    public function guardarDocumento($datos_doc){
        $datos_doc['fecha'] = date('Y-m-d H:i:s');
        $this->db->insert('documento',$datos_doc);
        return $this->db->insert_id();
    }


    public function guardarDocumentoPDF($datos_documento){
        $datos_documento['fecha'] = date('Y-m-d H:i:s');
        $this->db->insert('documento',$datos_documento);
        return $this->db->insert_id();
    }

    public function eliminarDocumentoAsea($idDocumento){
        $this->db->where('id_documento',$idDocumento);
        return $this->db->delete('documento');
    }

    /**
     * getters
     */
    public function getContanciasDc3()
    {
        return $this->contancias_dc_3;
    }

    /**
     * @return int
     */
    public function getPromedioEvaDiagnostica()
    {
        return $this->promedio_eva_diagnostica;
    }

    /**
     * @return int
     */
    public function getPromedioEvaFinal()
    {
        return $this->promedio_eva_final;
    }



    /*
     * apartado de funciones privadas a las ES
     */
    private function complement_row_datos_constancia($row){
        $row->Nombre_alumno = strMayusculas($row->Nombre_alumno);
        $row->array_curp = str_split($row->curp);
        $row->ocupacion_especifica_ctn = strMayusculas($row->clave_ocupacion_especifica.' '.$row->ocupacion_especifica);
        $row->puesto = strMayusculas($row->puesto);
        $row->razon_social_empresa = strMayusculas($row->nombre_empresa);
        $row->array_rfc = array();
        $row->rfc = strlen($row->rfc) == 12 ? ' '.$row->rfc : $row->rfc;
        foreach (str_split($row->rfc) as $i => $letra){
            if($i == 4){
                $row->array_rfc[] = '-';
            }if($i == 10){
                $row->array_rfc[] = '-';
            }
            $row->array_rfc[] = $letra;
        }
        $row->nombre_ctn = strMayusculas($row->nombre_curso);
        $row->duracion_ctn = strMayusculas($row->duracion);
        $fecha = explode('-',$row->fecha_inicio);
        $row->fecha_inicio_constancia = str_split($fecha[0].$fecha[1].$fecha[2]);
        $fecha = explode('-',$row->fecha_fin);
        $row->fecha_fin_constancia = str_split($fecha[0].$fecha[1].$fecha[2]);
        $row->area_tematica_ctn = strMayusculas($row->clave_area_tematica.' '.$row->Denominacion_Curso);
        $row->agente_capacitador = strMayusculas($row->agente_capacitador);
        $row->instructor = strMayusculas($row->Nombre_Instructor);
        $row->representante_legal = strMayusculas($row->representante_legal);
        $row->representante_trabajadores = strMayusculas($row->representante_trabajadores);
        $row->salto_linea_firma = false;
        $row->salto_linea_dc3_habilidades = false;
        if(strlen($row->nombre_curso_comercial) < 55){
            $row->salto_linea_firma = true;
        }if(strlen($row->nombre_ctn) < 55){
            $row->salto_linea_dc3_habilidades = true;
        }
        //para el folio si no se ha generado
        if(is_null($row->folio_habilidades) || $row->folio_habilidades == ''){
            $row->folio_habilidades = $this->get_folio_constancia();
            $update_folio = array(
                'folio_habilidades' => $row->folio_habilidades,
                'fecha_folio_generado' => todayBD()
            );
            $this->db->where('id_alumno_inscrito_ctn_publicado',$row->id_alumno_inscrito_ctn_publicado);
            $this->db->update('alumno_inscrito_ctn_publicado',$update_folio);
        }
        if(isset($row->calificacion_final) && $row->calificacion_final >= 80){
            $this->contancias_dc_3++;
            $this->promedio_eva_diagnostica+=$row->calificacion_diagnostica;
            $this->promedio_eva_final+=$row->calificacion_final;
        }
        return $row;
    }

    private function get_folio_constancia(){
        $today = date('Y-m-d');
        $folio = date('Ymd');
        $consulta = "select 
              count(aicp.id_alumno_inscrito_ctn_publicado) folios_generados
            from alumno_inscrito_ctn_publicado aicp
            where date_format(aicp.fecha_folio_generado,'%Y-%m-%d') = date_format('$today','%Y-%m-%d')
              and (aicp.folio_habilidades is not null and aicp.folio_habilidades <> '')";
        $query = $this->db->query($consulta);
        $folios_generados = $query->row()->folios_generados;
        $consecutivo = $folios_generados + 1;
        $folio .= $this->get_consecutivo($consecutivo);
        return $folio;
    }

    private function get_consecutivo($numero){
        $consecutivo = '';
        if($numero >= 1 && $numero < 9){
            $consecutivo .= '000'.$numero;
        }if($numero >= 10 && $numero < 99){
            $consecutivo .= '00'.$numero;
        }if($numero >= 100 && $numero < 999){
            $consecutivo .= '0'.$numero;
        }if($numero >= 1000){
            $consecutivo .= $numero;
        }
        return $consecutivo;
    }
}

?>