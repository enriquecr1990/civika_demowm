<?php

defined('BASEPATH') OR exit('No tiene access al script');

class ComunCTNModel extends CI_Model{

    function __construct(){
        $this->load->model('DocumentosModel','DocumentosModel');
    }

    /**
     * apartado de datos generales
     */
    public function obtenerQueryBaseCursos($tipo = 'curso',$tipo_aplicacion = 'presencial'){
        $consulta = "select 
              ctn.*,cat.clave,cat.denominacion,concat(cat.clave,' ',cat.denominacion ) area_tematica,
              (select if(count(pc.id_publicacion_ctn) = 0,true,false) from publicacion_ctn pc where pc.id_curso_taller_norma = ctn.id_curso_taller_norma ) puede_editarse
            from curso_taller_norma ctn
              inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
            where ctn.tipo = '$tipo' 
              and ctn.tipo_aplicacion = '$tipo_aplicacion'";
        return $consulta;
    }

    public function obtener_numero_total_ctn($criterios_adicionales,$tipo = 'curso',$tipo_aplicacion = 'presencial'){
        $consulta = "select 
                count(*) total_registros 
            from curso_taller_norma ctn 
            where ctn.tipo = '$tipo' 
                and ctn.tipo_aplicacion = '$tipo_aplicacion' $criterios_adicionales";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    public function obtenerQueryBaseCursosPublicados($id_catalogo_tipo_publicacion = CURSO_PRESENCIAL){
        $today = date('Y-m-d');
        $extra_join = '';
        if($id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE){
            $extra_join = 'inner join evaluacion_online_ctn eoc on eoc.id_publicacion_ctn = pc.id_publicacion_ctn';
        }
        $consulta = "select 
              ctn.id_curso_taller_norma,ctn.nombre,pc.nombre_curso_comercial,
              ctn.objetivo,pc.id_publicacion_ctn,pc.direccion_imparticion,
              if(pc.fecha_limite_inscripcion > '$today',pc.fecha_limite_inscripcion,pc.fecha_fin)fecha_limite_inscripcion,
              pc.fecha_inicio,pc.fecha_fin,pc.horario,pc.duracion,
              pc.visitas_carta_descriptiva,
              if(pc.descripcion is null or pc.descripcion = '',ctn.descripcion,pc.descripcion) descripcion,
              concat(d.ruta_directorio,d.nombre) img_banner,
              if(pc.fecha_limite_inscripcion is null, pc.costo_en_tiempo, if(pc.fecha_limite_inscripcion > '$today',pc.costo_en_tiempo,pc.costo_extemporaneo)) costo
            from curso_taller_norma ctn
              inner join publicacion_ctn pc on pc.id_curso_taller_norma = ctn.id_curso_taller_norma
              inner join publicacion_has_doc_banner phb on (phb.id_publicacion_ctn = pc.id_publicacion_ctn and phb.tipo = 'img')
              inner join documento d on phb.id_documento = d.id_documento
              $extra_join
            where ctn.ctn_cancelado = 'no' 
              and pc.id_catalogo_tipo_publicacion = $id_catalogo_tipo_publicacion
              and pc.publicacion_eliminada = 'no'
              and pc.publicacion_empresa_masiva = 'no'";
        if($id_catalogo_tipo_publicacion == CURSO_PRESENCIAL){
            $consulta .= " and date_format(pc.fecha_fin,'%Y-%m-%d') >= date_format('$today','%Y-%m-%d')";
        }
        return $consulta;
    }

    public function obtener_query_base_cursos_publicados_galeria($tipo = 'curso',$tipo_aplicacion = 'presencial'){
        $base_url = base_url();
        $consulta = "select 
                pc.id_publicacion_ctn,
                concat(cat.clave,' ',cat.denominacion ) area_tematica,
                ctn.descripcion,
                pc.nombre_curso_comercial,
                d.nombre nombre_archivo,
                pc.fecha_inicio,pc.agente_capacitador,
                concat('$base_url',d.ruta_directorio,d.nombre) banner_curso
            from curso_taller_norma ctn
                inner join publicacion_ctn pc on pc.id_curso_taller_norma = ctn.id_curso_taller_norma
                inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
                inner join publicacion_has_doc_banner phb on (phb.id_publicacion_ctn = pc.id_publicacion_ctn and phb.tipo = 'img')
                inner join documento d on phb.id_documento = d.id_documento
            where ctn.tipo = '$tipo' 
              and ctn.tipo_aplicacion = '$tipo_aplicacion'
              and ctn.ctn_cancelado = 'no' 
              and pc.publicacion_eliminada = 'no'
              and pc.fecha_inicio < date_format(now(),'%Y-%m-%d')";
        return $consulta;
    }

    public function obtenerPublicacionCTN($idCursoTallerNorma){
        $today = date('Y-m-d');
        $consulta = "select 
                  pc.*,
                  if(pc.fecha_limite_inscripcion > '$today',pc.fecha_limite_inscripcion,pc.fecha_fin)fecha_limite_inscripcion,
                  pc.fecha_inicio,pc.fecha_fin,pc.horario,pc.duracion,
                  concat(d.ruta_directorio,d.nombre) img_banner,
                  if(pc.fecha_limite_inscripcion > '$today',pc.costo_en_tiempo,pc.costo_extemporaneo) costo
            from publicacion_ctn pc
                inner join publicacion_has_doc_banner phb on (phb.id_publicacion_ctn = pc.id_publicacion_ctn and phb.tipo = 'img')
                inner join documento d on phb.id_documento = d.id_documento
            where pc.id_curso_taller_norma = $idCursoTallerNorma";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    public function obtenerPublicacionesActivasFinalizas($idCursoTallerNorma){
        $today = date('Y-m-d');
        $consulta = "select 
              sum(if(pc.fecha_fin >= '$today' and pc.publicacion_eliminada = 'no',1,0)) activas,
              sum(if(pc.fecha_fin < '$today' and pc.publicacion_eliminada = 'no',1,0)) finalizadas,
              sum(if(pc.publicacion_eliminada = 'si',1,0)) canceladas
            from publicacion_ctn pc
            where pc.id_curso_taller_norma = $idCursoTallerNorma";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtenerCursoTallerNorma($idCursoTallerNorma){
        $consulta = "select ctn.*,cat.clave,cat.denominacion from curso_taller_norma ctn 
            inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
            where ctn.id_curso_taller_norma = $idCursoTallerNorma";
        $query = $this->db->query($consulta);
        $row = $query->row();
        if(!is_null($row->id_documento) && $row->id_documento != ''){
            $row->documento_banner = $this->DocumentosModel->obtenerDocumentoById($row->id_documento);
        }
        return $row;
    }

    public function obtenerAlumnoInscritoCTN($idUsuario,$id_publicacion_ctn){
        $consulta = "select 
              aic.*
            from alumno a
              inner join alumno_inscrito_ctn_publicado aic on aic.id_alumno = a.id_alumno
              inner join publicacion_ctn pc on pc.id_publicacion_ctn = aic.id_publicacion_ctn
            where a.id_usuario = $idUsuario
              and pc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    public function obtenerBannerDocsPublicacionCTN($id_publicacion_ctn,$tipo = 'img'){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('tipo',$tipo);
        $this->db->order_by('id_publicacion_has_doc_banner','desc');
        $query = $this->db->get('publicacion_has_doc_banner');
        if($query->num_rows() == 0){
            return array();
        }
        if($tipo == 'img' || $tipo == 'logo_empresa'){
            $row = $query->row();
            $row->documento_banner = $this->DocumentosModel->obtenerDocumentoById($row->id_documento);
            return $row;
        }if($tipo == 'doc'){
            $result = $query->result();
            foreach ($result as $r){
                $r->documento_banner = $this->DocumentosModel->obtenerDocumentoById($r->id_documento);
            }
            return $result;
        }
    }

    public function obtener_total_rows_publicacion_ctn_galeria($tipo = 'curso',$tipo_aplicacion = 'presencial'){
        $consulta = "select 
                count(pc.id_publicacion_ctn) total_registros
            from curso_taller_norma ctn
                inner join publicacion_ctn pc on pc.id_curso_taller_norma = ctn.id_curso_taller_norma
                inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
                inner join publicacion_has_doc_banner phb on (phb.id_publicacion_ctn = pc.id_publicacion_ctn and phb.tipo = 'img')
                inner join documento d on phb.id_documento = d.id_documento
            where ctn.tipo = '$tipo' 
              and ctn.tipo_aplicacion = '$tipo_aplicacion'
              and ctn.ctn_cancelado = 'no' 
              and pc.publicacion_eliminada = 'no'
              and pc.fecha_inicio < date_format(now(),'%Y-%m-%d')";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    /**
     * apartado de insert y de guardar informacion de los CTN
     */

    public function insertarCursoTallerNorma($ctnPost){
        $this->db->insert('curso_taller_norma',$ctnPost);
        return $this->db->insert_id();
    }

    public function insertPublicacionCursoTallerNorma($insert){
        $insert['fecha_publicacion'] = date('Y-m-d H:i:s');
        $insert['fecha_inicio'] = fechaHtmlToBD($insert['fecha_inicio']);
        $insert['fecha_fin'] = fechaHtmlToBD($insert['fecha_fin']);
        if(isset($insert['fecha_limite_inscripcion']) && $insert['fecha_limite_inscripcion'] != ''){
            $insert['fecha_limite_inscripcion'] = fechaHtmlToBD($insert['fecha_limite_inscripcion']);
        }
        $this->db->insert('publicacion_ctn',$insert);
        return $this->db->insert_id();
    }

    public function insertPublicacionBanner($idPublicacionCTN,$insert){
        $insert['id_publicacion_ctn'] = $idPublicacionCTN;
        $this->db->insert('publicacion_has_doc_banner',$insert);
        return $this->db->insert_id();
    }

    public function insertPublicacionMaterialApoyo($idPublicacionCTN,$arrayMaterialApoyo){
        $this->eliminarMaterialApoyoPublicacionCTN($idPublicacionCTN);
        if(is_array($arrayMaterialApoyo) && sizeof($arrayMaterialApoyo)){
            foreach ($arrayMaterialApoyo as $insert){
                $insert['id_publicacion_ctn'] = $idPublicacionCTN;
                $insert['documento_publico'] = 'si';
                $this->insertPublicacionHasDocBanner($insert);
            }
        }
    }

    public function insertPublicacionHasDocBanner($insert){
        return $this->db->insert('publicacion_has_doc_banner',$insert);
    }

    public function insertarInstructoresAsignados($idPublicacionCTN,$instructoresAsignados){
        foreach ($instructoresAsignados as $ia){
            $ia['id_publicacion_ctn'] = $idPublicacionCTN;
            $this->db->insert('instructor_asignado_curso_publicado',$ia);
        }return true;
    }

    public function insertarPublicacionHasConstancias($idPublicacionCTN,$constancias){
        foreach ($constancias as $c){
            if(isset($c['id_catalogo_constancia']) && $c['id_catalogo_constancia'] != '' && $c['id_catalogo_constancia'] != 0){
                $c['id_publicacion_ctn'] = $idPublicacionCTN;
                $this->db->insert('publicacion_ctn_has_constancia',$c);
            }
        }return true;
    }

    public function insertAlumnoInscritoCTN($insert){
        $insert['fecha_ingreso'] = date('Y-m-d H:i:s');
        $this->db->insert('alumno_inscrito_ctn',$insert);
        return $this->db->insert_id();
    }

    public function insertarInscripcionAlumnoCTN($insert){

    }

    /**
     * apartado de update
     */
    public function actualizarCursoTallerNorma($idCursoTallerNorma,$update){
        $this->db->where('id_curso_taller_norma',$idCursoTallerNorma);
        return $this->db->update('curso_taller_norma',$update);
    }

    public function actualizar_publiacion_ctn($id_publicacion_ctn,$update){
        if(isset($update['fecha_inicio'])){
            $update['fecha_inicio'] = fechaHtmlToBD($update['fecha_inicio']);
        }if(isset($update['fecha_fin'])){
            $update['fecha_fin'] = fechaHtmlToBD($update['fecha_fin']);
        }if(isset($update['fecha_limite_inscripcion'])){
            $update['fecha_limite_inscripcion'] = fechaHtmlToBD($update['fecha_limite_inscripcion']);
        }
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        return $this->db->update('publicacion_ctn',$update);
    }

    public function actualizar_instructores_asignados_publicacion_ctn($id_publicacion_ctn,$instructores_asignados){
        foreach ($instructores_asignados as $ia){
            if($ia['id_instructor_asignado_curso_publicado'] != 0){
                $this->actualizar_instructor_asignado_publicacion($ia['id_instructor_asignado_curso_publicado'],$ia);
            }else{
                $ia['id_publicacion_ctn'] = $id_publicacion_ctn;
                $this->insertar_instructor_asignado_publicacion_ctn($ia);
            }
        }return true;
    }

    /**
     * apartado de delete
     */
    public function eliminar_publicacion_has_banner($id_publicacion_ctn,$tipo = 'img'){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('tipo',$tipo);
        return $this->db->delete('publicacion_has_doc_banner');
    }

    public function eliminar_publicacion_has_constancias($id_publicacion_ctn){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        return $this->db->delete('publicacion_ctn_has_constancia');
    }

    /**
     * apartado de funcioens privadas al modelo
     */

    private function insertar_instructor_asignado_publicacion_ctn($insert){
        return $this->db->insert('instructor_asignado_curso_publicado',$insert);
    }

    private function actualizar_instructor_asignado_publicacion($id_instructor_asignado_curso_publicado,$update){
        $this->db->where('id_instructor_asignado_curso_publicado',$id_instructor_asignado_curso_publicado);
        return $this->db->update('instructor_asignado_curso_publicado',$update);
    }

    private function eliminarInstructoresAsignadosCTN($idCursoTallerNorma){
        $this->db->where('id_curso_taller_norma',$idCursoTallerNorma);
        return $this->db->delete('instructor_asignado_ctn');
    }

    private function eliminarMaterialApoyoPublicacionCTN($idPublicacionCTN,$tipo = 'doc'){
        $this->db->where('id_publicacion_ctn',$idPublicacionCTN);
        $this->db->where('tipo',$tipo);
        return $this->db->delete('publicacion_has_doc_banner');
    }

}

?>