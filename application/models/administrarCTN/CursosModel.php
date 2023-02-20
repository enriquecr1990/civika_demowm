<?php

defined('BASEPATH') OR exit('No tiene access al script');

class CursosModel extends CI_Model
{

    private $msg_validacion;

    function __construct()
    {
        $this->load->model('DocumentosModel');
        $this->load->model('ControlUsuariosModel');
        $this->load->model('NotificacionesModel', 'NotificacionesModel');
        $this->load->model('administrarCTN/ComunCTNModel', 'ComunCTNModel');
        $this->msg_validacion = '';
    }

    /**
     * apartado de funciones de busqueda de cursos
     */
    public function buscarCursos($post, $pagina = 1, $limit = 10)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $criterios_adicionales = $this->obtenerCriteriosAdicionales($post);
        $consulta = $this->ComunCTNModel->obtenerQueryBaseCursos();
        $consulta .= $criterios_adicionales;
        $consulta .= $sql_limit;
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            $r->publicaciones_activas_finalizadas = $this->ComunCTNModel->obtenerPublicacionesActivasFinalizas($r->id_curso_taller_norma);
            $r->instructores_ctn = $this->obtener_ctn_has_instructores($r->id_curso_taller_norma);
        }
        $data['array_cursos'] = $result;
        $data['total_registros'] = $this->ComunCTNModel->obtener_numero_total_ctn($criterios_adicionales);
        return $data;
    }

    public function obtenerMaterialDidactico($id_publicacion_ctn)
    {
        $ruta_documento = base_url();
        $consulta = "select 
        pdc.*,
        concat('$ruta_documento',d.ruta_directorio,d.nombre ) ruta_documento
        from publicacion_ctn pc
        inner join publicacion_has_doc_banner pdc on pdc.id_publicacion_ctn = pc.id_publicacion_ctn
        inner join documento d on d.id_documento = pdc.id_documento
        where pdc.id_publicacion_ctn = $id_publicacion_ctn 
        and pdc.tipo = 'doc'";
        $query = $this->db->query($consulta);
        if ($query->num_rows() != 0) {
            return $query->result();
        }
        return false;
    }

    public function obtenerCoffeBreak($id_publicacion_ctn)
    {
        $consulta = "select 
        cbc.nombre, pc.descripcion_break_curso
        from publicacion_ctn pc
        inner join catalogo_break_curso cbc on cbc.id_catalogo_break_curso = pc.id_catalogo_break_curso
        where pc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        if ($query->num_rows() != 0) {
            return $query->row();
        }
        return false;
    }

    public function obtenerConstanciaDescripcion($id_publicacion_ctn)
    {
        $id_otro = ID_OTRO_A;
        $consulta = "select 
        cc.id_catalogo_constancia,
        if(pcc.id_catalogo_constancia = $id_otro,pcc.especifique_otra_constancia,cc.descripcion ) constancia
        from publicacion_ctn_has_constancia pcc
        inner join catalogo_constancia cc on cc.id_catalogo_constancia = pcc.id_catalogo_constancia
        where pcc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        if ($query->num_rows() != 0) {
            return $query->result();
        }
        return false;
    }

    public function obtenerCursosPorPublicar()
    {
        $today = date('Y-m-d');
        $consulta = "select 
        ctn.*,
        (select sum(if(pc.fecha_fin > '$today',1,0)) activas
        from publicacion_ctn pc
        where pc.id_curso_taller_norma = ctn.id_curso_taller_norma
        and pc.publicacion_eliminada = 'no'
        )activas,
        (select sum(if(pc.fecha_fin < '$today',1,0)) finalizadas
        from publicacion_ctn pc
        where pc.id_curso_taller_norma = ctn.id_curso_taller_norma
        and pc.publicacion_eliminada = 'no'
        )finalizadas
        from curso_taller_norma ctn
        where ctn.mostrar_banner = 'si' ";
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            $r->documento_banner = false;
            if (isset($r->id_documento) && !is_null($r->id_documento) && $r->id_documento != '') {
                $r->documento_banner = $this->DocumentosModel->obtenerDocumentoById($r->id_documento);
            }
        }
        return $result;
    }

    public function obtenerCursosPublicados($idUsuario = false, $id_catalogo_tipo_publicacion = CURSO_PRESENCIAL)
    {
        $consulta = $this->ComunCTNModel->obtenerQueryBaseCursosPublicados($id_catalogo_tipo_publicacion);
        $consulta .= " group by pc.id_publicacion_ctn";
        $consulta .= " order by pc.orden_publicacion,pc.fecha_inicio asc";
        //echo '<pre>'.$consulta;
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            if ($idUsuario) {
                $r->alumno_inscripcion = $this->ComunCTNModel->obtenerAlumnoInscritoCTN($idUsuario, $r->id_publicacion_ctn);
            }
            $r->img_banner = $this->obtener_banner_ctn_publicado($r->id_publicacion_ctn);
            $r->campus_aula = $this->obtener_campus_aula_ctn_publicado($r->id_publicacion_ctn);
        }
        return $result;
    }

    public function obtener_curso_publicacion($id_publicacion_ctn, $idUsuario = false, $id_catalogo_tipo_publicacion = CURSO_PRESENCIAL)
    {
        $consulta = $this->ComunCTNModel->obtenerQueryBaseCursosPublicados($id_catalogo_tipo_publicacion);
        $consulta .= ' and pc.id_publicacion_ctn = ' . $id_publicacion_ctn;
        $consulta .= " order by pc.orden_publicacion,pc.fecha_inicio asc";
        $query = $this->db->query($consulta);
        if ($query->num_rows() != 0) {
            $result = $query->row();
            if ($idUsuario) {
                $result->alumno_inscripcion = $this->ComunCTNModel->obtenerAlumnoInscritoCTN($idUsuario, $result->id_publicacion_ctn);
            }
            return $result;
        }
        return false;
    }

    public function obtenerCursoByIdAlumnoInscritoPublicacion($id_alumno_inscrito_ctn_publicado)
    {
        $consulta = "select 
        pc.*,
        u.id_usuario, u.nombre,u.apellido_p,u.apellido_m
        from alumno_inscrito_ctn_publicado aicp
        inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
        inner join alumno a on a.id_alumno = aicp.id_alumno
        inner join usuario u on u.id_usuario = a.id_usuario
        where aicp.id_alumno_inscrito_ctn_publicado = $id_alumno_inscrito_ctn_publicado";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtenerDatosInstructorAulaPublicacionCTN($id_alumno_inscrito_ctn_publicado)
    {
        $consulta = "select 
        u.nombre,u.apellido_p, u.apellido_m,ca.aula
        from alumno_inscrito_ctn_publicado aicp
        inner join instructor_asignado_curso_publicado iacp on iacp.id_instructor_asignado_curso_publicado = aicp.id_instructor_asignado_curso_publicado
        inner join instructor i on i.id_instructor = iacp.id_instructor
        inner join usuario u on u.id_usuario = i.id_usuario
        inner join catalogo_aula ca on ca.id_catalogo_aula = iacp.id_catalogo_aula
        where aicp.id_alumno_inscrito_ctn_publicado = $id_alumno_inscrito_ctn_publicado";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtenerCursoById($idCursoTallerNorma)
    {
        return $this->ComunCTNModel->obtenerCursoTallerNorma($idCursoTallerNorma);
    }

    public function obtenerPublicacionCTN($idPublicacionCTN, $id_usuario = false)
    {
        $today = date('Y-m-d');
        $consulta = "select 
            pc.*,
            if(date_format('$today','%Y-%m-%d') <= date_format(pc.fecha_fin, '%Y-%m-%d'),false,true ) publicacion_finalizada,
            cbc.nombre nombre_break_curso,
            if(pc.fecha_limite_inscripcion > '$today' or pc.id_catalogo_tipo_publicacion = 4,pc.costo_en_tiempo,pc.costo_extemporaneo) costo
        from publicacion_ctn pc 
            left join catalogo_break_curso cbc on cbc.id_catalogo_break_curso = pc.id_catalogo_break_curso
        where pc.id_publicacion_ctn = $idPublicacionCTN";
        $query = $this->db->query($consulta);
        $row = $query->row();
        $row->aplica_habilidades = $this->obtener_si_tiene_constancia($idPublicacionCTN, CONSTANCIA_HABILIDADES);
        $row->aplica_dc3 = $this->obtener_si_tiene_constancia($idPublicacionCTN, CONSTANCIA_DC3);
        $row->aplica_fdh = $this->obtener_si_tiene_constancia($idPublicacionCTN, CONSTANCIA_FDH);
        $row->aplica_otra = $this->obtener_si_tiene_constancia($idPublicacionCTN, CONSTANCIA_OTRA);
        if ($id_usuario) {
            $row->alumno_inscripcion = $this->ComunCTNModel->obtenerAlumnoInscritoCTN($id_usuario, $idPublicacionCTN);
        }
        return $row;
    }

    public function obtenerPublicacionesCTN($idCursoTallerNorma)
    {
        $data['curso_taller_norma'] = $this->obtenerCursoById($idCursoTallerNorma);
        $data['curso_taller_norma']->publicaciones_activas_finalizadas = $this->ComunCTNModel->obtenerPublicacionesActivasFinalizas($idCursoTallerNorma);
        return $data;
    }

    public function obtener_todas_publicaciones_ctn($post, $pagina = 1, $limit = 5)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $criterios_adicionales = $this->obtener_criterios_adicionales_todas($post);
        $data['array_publicacion_ctn'] = $this->obtenerArrayTodasPublicacionesCTN($sql_limit, $criterios_adicionales);
        $data['total_registros'] = $this->obtener_total_registros_publicaciones_todas($criterios_adicionales);
        return $data;
    }

    public function obtener_publicaciones_ctn_instructor($post, $pagina = 1, $limit = 5)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $criterios_adicionales = $this->obtener_criterios_adicionales_todas($post);
        $data['array_publicacion_ctn'] = $this->obtenerArrayPublicacionesCTNInstructor($post['id_usuario'], $sql_limit, $criterios_adicionales);
        $data['total_registros'] = $this->obtener_total_registros_publicaciones_instructor($post['id_usuario'], $criterios_adicionales);
        return $data;
    }

    public function obtener_publicacion_ctn_alumno($post, $pagina = 1, $limit = 5)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $criterios_adicionales = $this->obtener_criterios_adicionales_todas($post);
        if (!isset($post['id_catalogo_tipo_publicacion']) || !existe_valor($post['id_catalogo_tipo_publicacion'])) {
            $criterios_adicionales .= ' and pc.id_catalogo_tipo_publicacion <> ' . CURSO_EVALUACION_ONLINE;
        }
        $data['array_publicacion_ctn'] = $this->obtener_publicaciones_ctn_alumno($post['id_usuario'], $sql_limit, $criterios_adicionales);
        $data['total_registros'] = $this->obtener_total_registros_publicaciones_alumno($post['id_usuario'], $criterios_adicionales);
        return $data;
    }

    public function obtener_publicaciones_ctn($post, $pagina = 1, $limit = 5)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $criterios_adicionales = $this->obtener_criterios_adicionales($post);
        $data['array_publicacion_ctn'] = $this->obtenerArrayPublicacionesCTN($post['id_curso_taller_norma'], $sql_limit, $criterios_adicionales);
        $data['total_registros'] = $this->obtener_total_registros_publicaciones($post['id_curso_taller_norma'], $criterios_adicionales);
        return $data;
    }

    public function obtener_instructor_asignado($id_publicacion_ctn, $id_instructor_asinado = false)
    {
        $consulta = "select 
        iacp.id_instructor_asignado_curso_publicado,i.*,cta.titulo,
        ca.id_catalogo_aula,ca.campus, ca.aula,
        ca.cupo capacidad_aula,
        u.nombre, u.apellido_p, u.apellido_m
        from instructor_asignado_curso_publicado iacp
        inner join instructor i on i.id_instructor = iacp.id_instructor
        inner join catalogo_aula ca on ca.id_catalogo_aula = iacp.id_catalogo_aula
        inner join usuario u on u.id_usuario = i.id_usuario
        left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
        where iacp.id_publicacion_ctn = $id_publicacion_ctn";
        if ($id_instructor_asinado) {
            $consulta .= " and iacp.id_instructor_asignado_curso_publicado = $id_instructor_asinado";
            $query = $this->db->query($consulta);
            return $query->row();
        }
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtenerAlumnosInscritosPublicacionCTN($post)
    {
        $idPublicacionCTN = $post['id_publicacion_ctn'];
        $criterios_adicionales = '';
        if (isset($post['nombre']) && $post['nombre'] != '') {
            $criterios_adicionales .= "and u.nombre like '%" . $post['nombre'] . "%'";
        }
        if (isset($post['apellido_paterno']) && $post['apellido_paterno'] != '') {
            $criterios_adicionales .= "and u.apellido_p like '%" . $post['nombre'] . "%'";
        }
        $consulta = "select 
        aicp.id_alumno_inscrito_ctn_publicado, aicp.id_alumno,aicp.id_publicacion_ctn, aicp.envio_datos_dc3,
        aicp.id_documento_dc3, aicp.id_documento,u.nombre,u.apellido_p,u.apellido_m,aicp.id_catalogo_proceso_inscripcion,
        aicp.fecha_preinscripcion,aicp.fecha_pago_registrado,aicp.fecha_pago_validado,
        aicp.cumple_comprobante, aicp.observacion_comprobante,aicp.asistio,
        aicp.perciento_asistencia,aicp.calificacion_diagnostica,aicp.calificacion_final,
        cpi.descripcion estatus_inscripcion, aicp.requiere_factura,
        aicp.id_instructor_asignado_curso_publicado,
        a.id_catalogo_ocupacion_especifica,a.curp,a.puesto,
        u.id_usuario, u.telefono telefono_alumno,
        aicp.semaforo_asistencia
        from alumno_inscrito_ctn_publicado aicp 
        inner join catalogo_proceso_inscripcion cpi on cpi.id_catalogo_proceso_inscripcion = aicp.id_catalogo_proceso_inscripcion
        inner join alumno a on a.id_alumno = aicp.id_alumno
        inner join usuario u on u.id_usuario = a.id_usuario
        where aicp.id_publicacion_ctn = $idPublicacionCTN
        $criterios_adicionales
        order by u.apellido_p asc;";
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            if (isset($r->id_documento) && !is_null($r->id_documento)) {
                $r->comprobante_pago = $this->DocumentosModel->obtenerDocumentoById($r->id_documento);
            }
            if (isset($r->id_documento_dc3) && !is_null($r->id_documento_dc3)) {
                $r->documento_dc3 = $this->DocumentosModel->obtenerDocumentoById($r->id_documento_dc3);
            }
            if (isset($r->id_instructor_asignado_curso_publicado) && !is_null($r->id_instructor_asignado_curso_publicado)) {
                $r->instructor = $this->obtenerDatosInstructorAulaPublicacionCTN($r->id_alumno_inscrito_ctn_publicado);
            }
            $r->empresa_alumno = $this->ControlUsuariosModel->obtenerEmpresaByAlumno($r->id_alumno);
        }
        return $result;
    }

    public function obtener_numero_alumnos_asistieron_curso_publicado($id_publicacion_ctn)
    {
        $this->db->where('id_publicacion_ctn', $id_publicacion_ctn);
        $this->db->where('asistio', 'si');
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        return $query->num_rows();
    }

    public function obtener_publicacion_has_constancias($id_publicacion_ctn)
    {
        $this->db->where('id_publicacion_ctn', $id_publicacion_ctn);
        $query = $this->db->get('publicacion_ctn_has_constancia');
        $result = $query->result();
        $retorno = array();
        foreach ($result as $r) {
            $retorno[$r->id_catalogo_constancia] = $r;
        }
        return $retorno;
    }

    public function obtener_banner_docs_publicacion_ctn($id_publicacion_ctn, $tipo = 'img')
    {
        return $this->ComunCTNModel->obtenerBannerDocsPublicacionCTN($id_publicacion_ctn, $tipo);
    }

    public function obtener_publicaciones_ctn_galeria($pagina = 1, $limit = 5)
    {
        $sql_limit = " limit " . (($pagina * $limit) - $limit) . ",$limit";
        $consulta = $this->ComunCTNModel->obtener_query_base_cursos_publicados_galeria();
        $consulta .= $sql_limit;
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            $r->img_galeria = $this->obtener_publicacion_ctn_galeria($r->id_publicacion_ctn);
        }
        $data['publicaciones_ctn_galeria'] = $result;
        $data['total_registros'] = $this->ComunCTNModel->obtener_total_rows_publicacion_ctn_galeria();
        return $data;
    }

    public function obtener_publicacion_ctn_galeria($id_publicacion_ctn)
    {
        $base_url = base_url();
        $consulta = "select 
        d.*,
        concat('$base_url',d.ruta_directorio,d.nombre) ruta_documento
        from publicacion_ctn_has_galeria pcg
        inner join documento d on pcg.id_documento = d.id_documento
        where pcg.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtener_empresa_publicacion_ctn_masivo($id_publicacion_ctn)
    {
        $this->db->where('id_publicacion_ctn', $id_publicacion_ctn);
        $query = $this->db->get('publicacion_ctn_has_empresa_masivo');
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->row();
    }

    public function obtener_ctn_has_instructores($id_curso_taller_norma)
    {
        $consulta = "select
          i.id_instructor, 
          cta.abreviatura,
          concat(u.nombre,' ',u.apellido_p,' ',u.apellido_m) nombre_completo 
        from curso_taller_norma_has_instructores ctni 
          inner join instructor i on i.id_instructor = ctni.id_instructor
          inner join usuario u on i.id_usuario = u.id_usuario
          left join catalogo_titulo_academico cta on i.id_catalogo_titulo_academico = cta.id_catalogo_titulo_academico
        where ctni.id_curso_taller_norma = $id_curso_taller_norma";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtner_publicacion_ctn_banner_logo_empresa($id_publicacion_ctn,$tipo = 'img'){
        $consulta = "select
          pdb.*, d.*,
          concat(d.ruta_directorio,d.nombre) img_banner
        from publicacion_has_doc_banner pdb
          inner join documento d on d.id_documento = pdb.id_documento
        where pdb.tipo = '$tipo'
          and pdb.id_publicacion_ctn = $id_publicacion_ctn
        order by pdb.id_publicacion_has_doc_banner desc limit 1";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $row = $query->row();
        return $row;
    }

    public function buscar_tablero_asistencia($post)
    {
        $criterios = '';
        if (isset($post['fecha_inicio_de']) && $post['fecha_inicio_de'] != '') {
            $fecha_de = fechaHtmlToBD($post['fecha_inicio_de']);
            $criterios .= " and date_format(pc.fecha_inicio,'%Y-%m-%d') >= date_format('$fecha_de', '%Y-%m-%d')";
        }
        if (isset($post['fecha_inicio_a']) && $post['fecha_inicio_a'] != '') {
            $fecha_a = fechaHtmlToBD($post['fecha_inicio_a']);
            $criterios .= " and date_format(pc.fecha_inicio,'%Y-%m-%d') <= date_format('$fecha_a', '%Y-%m-%d')";
        }
        $consulta = "select 
            ctn.nombre nombre_dc3,
            pc.nombre_curso_comercial,
            pc.fecha_inicio fecha_imparticion,
            (select 
                  group_concat(concat(u.nombre,' ',u.apellido_p) separator '<br>')
              from instructor_asignado_curso_publicado iacp
                  inner join instructor i on i.id_instructor = iacp.id_instructor
                  inner join usuario u on u.id_usuario = i.id_usuario
              where iacp.id_publicacion_ctn = aicp.id_publicacion_ctn
            )instructor,
            count(aicp.id_alumno_inscrito_ctn_publicado) asistieron,
            ctp.nombre tipo_publicacion
        from alumno_inscrito_ctn_publicado aicp
            inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
            inner join catalogo_tipo_publicacion ctp on ctp.id_catalogo_tipo_publicacion = pc.id_catalogo_tipo_publicacion
            inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        where aicp.asistio = 'si' and pc.publicacion_eliminada = 'no'
            $criterios
        group by pc.id_publicacion_ctn
        order by pc.fecha_inicio asc;";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtener_cursos_disponibles_stps()
    {
        $consulta = "select 
        ctn.id_curso_taller_norma,ctn.nombre,cat.clave,cat.denominacion
        from curso_taller_norma ctn 
        inner join catalogo_area_tematica cat on cat.id_catalogo_area_tematica = ctn.id_catalogo_area_tematica
        where ctn.ctn_cancelado = 'no'
        order by cat.id_catalogo_area_tematica asc;";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    /**
     * apartado de funciones para guardar informacion
     */
    public function guardarCurso($post)
    {
        //convertir las fechas que se recibieron del HTML para BD
        $post['curso_taller_norma']['mostrar_banner'] = isset($post['curso_taller_norma']['mostrar_banner']) && $post['curso_taller_norma']['mostrar_banner'] == 1 ? 'si' : 'no';
        if (isset($post['curso_taller_norma']['id_curso_taller_norma']) && $post['curso_taller_norma']['id_curso_taller_norma'] != '') {
            $this->ComunCTNModel->actualizarCursoTallerNorma($post['curso_taller_norma']['id_curso_taller_norma'], $post['curso_taller_norma']);
            $id_curso_taller_norma = $post['curso_taller_norma']['id_curso_taller_norma'];
        } else {
            $id_curso_taller_norma = $this->ComunCTNModel->insertarCursoTallerNorma($post['curso_taller_norma']);
        }
        return $this->actualizar_curso_taller_norma_has_instructores($id_curso_taller_norma, $post['instructores']);
    }

    public function guardarPublicacionCurso($post)
    {
        //print_r($post);exit;
        $retorno = true;
        if (isset($post['publicacion_ctn']['id_publicacion_ctn']) && $post['publicacion_ctn']['id_publicacion_ctn'] != 0) {
            $retorno = $this->actualizar_publicacion_ctn($post);
        } else {
            if ($this->validar_disponibilidad_instructor($post['instrutores_asignados'], fechaHtmlToBD($post['publicacion_ctn']['fecha_inicio']))) {
                $retorno = $this->insertar_publicacion_ctn_nueva($post);
            } else {
                $retorno = false;
            }
        }
        return $retorno;
    }

    public function guardar_publicacion_curso_empresa($post)
    {
        //echo '<pre>';print_r($post);exit;
        if (isset($post['publicacion_ctn']['id_publicacion_ctn']) && $post['publicacion_ctn']['id_publicacion_ctn'] != 0) {
            $this->actualizar_publicacion_ctn($post, 'logo_empresa');
        } else {
            if ($this->validar_disponibilidad_instructor($post['instrutores_asignados'], fechaHtmlToBD($post['publicacion_ctn']['fecha_inicio']))) {
                $id_publicacion_ctn = $this->insertar_publicacion_ctn_nueva($post);
                $this->insertar_publicacion_ctn_to_empresa($id_publicacion_ctn, $post['publicacion_ctn_has_empresa_masivo']);
                return $id_publicacion_ctn;
            } else {
                return false;
            }
        }
        return true;
    }

    public function actualizar_visitas_publicacion_cd($id_publicacion_ctn)
    {
        $publicacion_ctn = $this->obtenerPublicacionCTN($id_publicacion_ctn);
        $update = array(
            'visitas_carta_descriptiva' => $publicacion_ctn->visitas_carta_descriptiva + 1
        );
        $this->db->where('id_publicacion_ctn', $id_publicacion_ctn);
        return $this->db->update('publicacion_ctn', $update);
    }

    public function guardarInscripcionAlumno($post)
    {
        $respuesta['exito'] = false;
        $respuesta['msg'] = 'No fue posible realizar la operación, favor de intentar más tarde';
        $inscripcion = $this->ComunCTNModel->insertAlumnoInscritoCTN($post['alumno_inscrito_ctn']);
        if ($inscripcion) {
            $respuesta['exito'] = true;
            $respuesta['msg'] = $post['msg_success'];
        }
        return $respuesta;
    }

    public function guardar_cancelar_curso($post)
    {
        $post['curso_taller_norma']['fecha_cancelado'] = date('Y-m-d H:i:s');
        $this->ComunCTNModel->actualizarCursoTallerNorma($post['curso_taller_norma']['id_curso_taller_norma'], $post['curso_taller_norma']);
        return $this->cancelar_publicaciones_by_id_ctn(
            $post['curso_taller_norma']['id_curso_taller_norma'],
            $post['curso_taller_norma']['fecha_cancelado'],
            $post['curso_taller_norma']['descripcion_cancelacion']
        );
    }

    public function guardar_cancelar_publicacion_curso($post)
    {
        $post['publicacion_ctn']['fecha_eliminada'] = todayBD();
        return $this->ComunCTNModel->actualizar_publiacion_ctn($post['publicacion_ctn']['id_publicacion_ctn'], $post['publicacion_ctn']);
    }

    public function guardar_img_galeria_publicacion_ctn($id_publicacion_ctn, $id_documento)
    {
        $insert = array(
            'id_publicacion_ctn' => $id_publicacion_ctn,
            'id_documento' => $id_documento
        );
        return $this->db->insert('publicacion_ctn_has_galeria', $insert);
    }

    public function registrar_asistencia_alumno($post)
    {
        $alumno_inscrito = $this->obtener_alumno_inscrito_by_id($post['id_alumno_inscrito_ctn_publicado']);
        $update = array(
            'asistio' => $post['asistio'],
        );
        if ($alumno_inscrito->id_catalogo_proceso_inscripcion != PROCESO_PAGO_FINALIZADO_INSCRITO) {
            $instructor_para_asignar = $this->obtenerInstructorParaAsignar($alumno_inscrito->id_publicacion_ctn);
            $update['id_catalogo_proceso_inscripcion'] = PROCESO_PAGO_FINALIZADO_INSCRITO;
            $update['id_instructor_asignado_curso_publicado'] = $instructor_para_asignar->id_instructor_asignado_curso_publicado;
        }
        $this->db->where('id_alumno_inscrito_ctn_publicado', $post['id_alumno_inscrito_ctn_publicado']);
        return $this->db->update('alumno_inscrito_ctn_publicado', $update);
    }

    public function registrar_asistencia_masiva_alumno($post)
    {
        try {
            $this->db->where('id_publicacion_ctn', $post['id_publicacion_ctn']);
            $query = $this->db->get('alumno_inscrito_ctn_publicado');
            $result = $query->result();
            foreach ($result as $r) {
                $armar_post_update['id_alumno_inscrito_ctn_publicado'] = $r->id_alumno_inscrito_ctn_publicado;
                $armar_post_update['asistio'] = $post['asistio'];
                $this->registrar_asistencia_alumno($armar_post_update);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * apartado de funciones para eliminar informacion
     */
    public function eliminar_publicacion_ctn_has_img_galeria($id_documento)
    {
        $this->db->where('id_documento', $id_documento);
        return $this->db->delete('publicacion_ctn_has_galeria');
    }

    /**
     * getters and setters
     */
    public function getMsgValidacion()
    {
        return $this->msg_validacion;
    }

    /**
     * apartado de funciones privadas al modelo
     */
////mi funcion
    public function obtener_formacion_academica_instructor($id_instructor)
    {
        $this->db->where('id_instructor', $id_instructor);
        $query = $this->db->get('instructor_preparacion_academica');
        return $query->result();

    }

    public function obtener_certtificacion_instructor($id_instructor)
    {
        $this->db->where('id_instructor', $id_instructor);
        $query = $this->db->get('instructor_experiencia_laboral');
        return $query->result();

    }

    public function obtener_diplomados_cursos_instructor($id_instructor)
    {
        $this->db->where('id_instructor', $id_instructor);
        $query = $this->db->get('instructor_certificacion_diplomado_curso');
        return $query->result();

    }

    private function obtenerCriteriosAdicionales($post)
    {
        $criterios = '';
        if (isset($post['nombre']) && $post['nombre'] != '') {
            $criterios .= " and ctn.nombre like '%" . $post['nombre'] . "%'";
        }
        if (isset($post['descripcion']) && $post['descripcion'] != '') {
            $criterios .= " and ctn.descripcion like '%" . $post['descripcion'] . "%'";
        }
        if (isset($post['ctn_cancelado']) && $post['ctn_cancelado'] != '') {
            $criterios .= " and ctn.ctn_cancelado = '" . $post['ctn_cancelado'] . "'";
        }
        return $criterios;
    }

    private function obtenerArrayTodasPublicacionesCTN($limit, $criterios_adicionales = '')
    {
        $today = todayBD();
        $consulta = "select 
        ctn.nombre nombre_dc3,
        pc.*,
        if(date_format('$today','%Y-%m-%d') <= date_format(pc.fecha_fin, '%Y-%m-%d'),false,true ) publicacion_finalizada,
        count(aicp.id_alumno_inscrito_ctn_publicado) alumnos_registrados,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 1,1,0 )) alumnos_actualizacion_datos,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 3,1,0 )) alumnos_recibo_enviado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 4,1,0 )) alumnos_pago_observado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 5,1,0 )) alumnos_inscritos,
        sum(if(aicp.asistio = 'si',1,0 )) alumnos_asistencia,
        pc.publicacion_empresa_masiva,pc.aplica_evaluacion
        from publicacion_ctn pc
        inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        left join alumno_inscrito_ctn_publicado aicp on aicp.id_publicacion_ctn = pc.id_publicacion_ctn
        where 1=1
        $criterios_adicionales 
        GROUP by pc.id_publicacion_ctn
        $limit";
        $query = $this->db->query($consulta);
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result();
        foreach ($result as $r) {
            $r->instructores_asignados = $this->obtener_instructor_asignado($r->id_publicacion_ctn);
            if ($r->aplica_evaluacion == 'si') {
                $this->load->model('Evaluacion_model');
                $r->evaluacion_online_disponible = $this->Evaluacion_model->obtener_evaluacion_online_ctn($r->id_publicacion_ctn);
                $r->evaluacion_diagnostica_disponible = $this->Evaluacion_model->existe_evaluacion_publicacion_ctn_disponible($r->id_publicacion_ctn, 'diagnostica');
                $r->evaluacion_final_disponible = $this->Evaluacion_model->existe_evaluacion_publicacion_ctn_disponible($r->id_publicacion_ctn, 'final');
            }
        }
        return $result;
    }

    private function obtenerArrayPublicacionesCTNInstructor($id_usuario, $limit, $criterios_adicionales = '')
    {
        $today = todayBD();
        $consulta = "select 
        ctn.nombre nombre_dc3,
        pc.*,
        if(date_format('$today','%Y-%m-%d') <= date_format(pc.fecha_fin, '%Y-%m-%d'),false,true ) publicacion_finalizada,
        count(aicp.id_alumno_inscrito_ctn_publicado) alumnos_registrados,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 1,1,0 )) alumnos_actualizacion_datos,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 3,1,0 )) alumnos_recibo_enviado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 4,1,0 )) alumnos_pago_observado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 5,1,0 )) alumnos_inscritos,
        sum(if(aicp.asistio = 'si',1,0 )) alumnos_asistencia
        from publicacion_ctn pc
        inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        inner join instructor_asignado_curso_publicado iacp on iacp.id_publicacion_ctn = pc.id_publicacion_ctn
        inner join instructor i on i.id_instructor = iacp.id_instructor
        left join alumno_inscrito_ctn_publicado aicp on aicp.id_publicacion_ctn = pc.id_publicacion_ctn
        where i.id_usuario = $id_usuario
        $criterios_adicionales 
        and pc.publicacion_eliminada = 'no'
        GROUP by pc.id_publicacion_ctn
        $limit";
        $query = $this->db->query($consulta);
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->result();
    }

    private function obtener_publicaciones_ctn_alumno($id_usuario, $limit, $criterios_adicionales = '')
    {
        $today = todayBD();
        $consulta = "
            select
                ctn.nombre nombre_dc3,aicp.id_catalogo_proceso_inscripcion,a.id_alumno,aicp.descargo_vademecum,aicp.id_alumno_inscrito_ctn_publicado,
                aicp.asistio asistio_alumno, pc.id_publicacion_ctn,pc.nombre_curso_comercial,pc.fecha_publicacion, pc.fecha_inicio,pc.fecha_fin,pc.direccion_imparticion,
                pc.agente_capacitador,pc.aplica_evaluacion,pc.id_catalogo_tipo_publicacion,ctp.nombre tipo_publicacion,
                if(date_format('$today','%Y-%m-%d') <= date_format(pc.fecha_fin, '%Y-%m-%d'),false,true ) publicacion_finalizada,
                concat(if(i.id_catalogo_titulo_academico is not null,cta.abreviatura,''),' ',u.nombre,' ',u.apellido_p) instructor,
                pc.tiene_constancia_externa
            from publicacion_ctn pc
                inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
                inner join alumno_inscrito_ctn_publicado aicp on aicp.id_publicacion_ctn = pc.id_publicacion_ctn
                inner join alumno a on a.id_alumno = aicp.id_alumno
                left join instructor_asignado_curso_publicado iacp on iacp.id_instructor_asignado_curso_publicado = aicp.id_instructor_asignado_curso_publicado
                left join instructor i on i.id_instructor = iacp.id_instructor
                left join usuario u on u.id_usuario = i.id_usuario
                left join catalogo_tipo_publicacion ctp on ctp.id_catalogo_tipo_publicacion = pc.id_catalogo_tipo_publicacion
                left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
            where a.id_usuario = $id_usuario
                and pc.publicacion_eliminada <> 'si'
                $criterios_adicionales 
            GROUP by pc.id_publicacion_ctn
                $limit";
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r) {
            $r->aplica_habilidades = $this->obtener_si_tiene_constancia($r->id_publicacion_ctn, CONSTANCIA_HABILIDADES);
            $r->aplica_dc3 = $this->obtener_si_tiene_constancia($r->id_publicacion_ctn, CONSTANCIA_DC3);
            $r->aplica_fdh = $this->obtener_si_tiene_constancia($r->id_publicacion_ctn, CONSTANCIA_FDH);
            $r->aplica_otra = $this->obtener_si_tiene_constancia($r->id_publicacion_ctn, CONSTANCIA_OTRA);
        }
        return $result;
    }

    private function obtenerArrayPublicacionesCTN($idCursoTallerNorma, $limit, $criterios_adicionales = '')
    {
        $today = todayBD();
        $consulta = "select 
        pc.*,
        if(date_format('$today','%Y-%m-%d') <= date_format(pc.fecha_fin, '%Y-%m-%d'),false,true ) publicacion_finalizada,
        count(aicp.id_alumno_inscrito_ctn_publicado) alumnos_registrados,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 1,1,0 )) alumnos_actualizacion_datos,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 3,1,0 )) alumnos_recibo_enviado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 4,1,0 )) alumnos_pago_observado,
        sum(if(aicp.id_catalogo_proceso_inscripcion = 5,1,0 )) alumnos_inscritos
        from publicacion_ctn pc
        left join alumno_inscrito_ctn_publicado aicp on aicp.id_publicacion_ctn = pc.id_publicacion_ctn
        where pc.id_curso_taller_norma = $idCursoTallerNorma
        $criterios_adicionales 
        GROUP by pc.id_publicacion_ctn
        $limit";
        $query = $this->db->query($consulta);
        if ($query->num_rows() == 0) {
            return false;
        }
        return $query->result();
    }

    private function obtener_total_registros_publicaciones_todas($criterios_adicionales)
    {
        $consulta = "select 
        count(pc.id_publicacion_ctn) total_registros
        from publicacion_ctn pc
        inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        where 1=1
        $criterios_adicionales ";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    private function obtener_total_registros_publicaciones_instructor($id_usuario, $criterios_adicionales)
    {
        $consulta = "select 
        count(pc.id_publicacion_ctn) total_registros
        from publicacion_ctn pc
        inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        inner join instructor_asignado_curso_publicado iacp on iacp.id_publicacion_ctn = pc.id_publicacion_ctn
        inner join instructor i on i.id_instructor = iacp.id_instructor
        where i.id_usuario = $id_usuario
        $criterios_adicionales ";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    private function obtener_total_registros_publicaciones_alumno($id_usuario, $criterios_adicionales)
    {
        $consulta = "select 
        count(pc.id_publicacion_ctn) total_registros
        from publicacion_ctn pc
        inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
        inner join alumno_inscrito_ctn_publicado aicp on aicp.id_publicacion_ctn = pc.id_publicacion_ctn
        inner join alumno a on a.id_alumno = aicp.id_alumno
        where a.id_usuario = $id_usuario
        $criterios_adicionales ";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    private function obtener_total_registros_publicaciones($id_curso_taller_norma, $criterios_adicionales)
    {
        $consulta = "select 
        count(pc.id_publicacion_ctn) total_registros
        from publicacion_ctn pc
        where pc.id_curso_taller_norma = $id_curso_taller_norma
        $criterios_adicionales ";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    private function obtener_criterios_adicionales_todas($post)
    {
        $criterios = '';
        if (isset($post['nombre_curso_comercial']) && $post['nombre_curso_comercial'] != '') {
            $criterios .= " and pc.nombre_curso_comercial like '%" . $post['nombre_curso_comercial'] . "%'";
        }
        if (isset($post['nombre_dc3']) && $post['nombre_dc3'] != '') {
            $criterios .= " and ctn.nombre like '%" . $post['nombre_dc3'] . "%'";
        }
        if (isset($post['agente_capacitador']) && $post['agente_capacitador'] != '') {
            $criterios .= " and pc.agente_capacitador like '%" . $post['agente_capacitador'] . "%'";
        }
        if (isset($post['fecha_inicio']) && $post['fecha_inicio'] != '') {
            $fecha_inicio = fechaHtmlToBD($post['fecha_inicio']);
            $criterios .= " and date_format(pc.fecha_inicio,'%Y-%m-%d') = date_format('" . $fecha_inicio . "','%Y-%m-%d')";
        }
        if (isset($post['publicacion_empresa_masiva']) && $post['publicacion_empresa_masiva'] != '') {
            $criterios .= " and pc.publicacion_empresa_masiva = '" . $post['publicacion_empresa_masiva'] . "'";
        }
        if (isset($post['id_catalogo_tipo_publicacion']) && $post['id_catalogo_tipo_publicacion'] != '') {
            $criterios .= " and pc.id_catalogo_tipo_publicacion = '" . $post['id_catalogo_tipo_publicacion'] . "'";
        }
        if (isset($post['id_publicacion_ctn']) && existe_valor($post['id_publicacion_ctn'])) {
            $criterios .= " and pc.id_publicacion_ctn = '" . $post['id_publicacion_ctn'] . "'";
        }
        return $criterios;
    }

    private function obtener_criterios_adicionales($post)
    {
        $criterios = '';
        if (isset($post['nombre_curso_comercial']) && $post['nombre_curso_comercial'] != '') {
            $criterios .= " and pc.nombre_curso_comercial like '%" . $post['nombre_curso_comercial'] . "%'";
        }
        if (isset($post['agente_capacitador']) && $post['agente_capacitador'] != '') {
            $criterios .= " and pc.agente_capacitador like '%" . $post['agente_capacitador'] . "%'";
        }
        if (isset($post['fecha_inicio']) && $post['fecha_inicio'] != '') {
            $fecha_inicio = fechaHtmlToBD($post['fecha_inicio']);
            $criterios .= " and date_format(pc.fecha_inicio,'%Y-%m-%d') = date_format('" . $fecha_inicio . "','%Y-%m-%d')";
        }
        if (isset($post['publicacion_empresa_masiva']) && $post['publicacion_empresa_masiva'] != '') {
            $criterios .= " and pc.publicacion_empresa_masiva = '" . $post['publicacion_empresa_masiva'] . "'";
        }
        if (isset($post['id_catalogo_tipo_publicacion']) && $post['id_catalogo_tipo_publicacion'] != '') {
            $criterios .= " and pc.id_catalogo_tipo_publicacion = '" . $post['id_catalogo_tipo_publicacion'] . "'";
        }
        return $criterios;
    }

    private function obtener_si_tiene_constancia($id_publicacion_ctn, $tipo_constancia = CONSTANCIA_HABILIDADES)
    {
        $consulta = "select 
        pcc.*
        from publicacion_ctn_has_constancia pcc 
        where pcc.id_publicacion_ctn = $id_publicacion_ctn 
        and pcc.id_catalogo_constancia = $tipo_constancia";
        $query = $this->db->query($consulta);
        if ($query->num_rows() != 0) {
            return $query->row();
        }
        return false;
    }

    private function insertar_publicacion_ctn_nueva($post)
    {
        $idPublicacionCTN = $this->ComunCTNModel->insertPublicacionCursoTallerNorma($post['publicacion_ctn']);
        if (isset($post['publicacion_has_doc_banner']['banner'])) {
            $post['publicacion_has_doc_banner']['banner']['id_publicacion_ctn'] = $idPublicacionCTN;
            $this->ComunCTNModel->insertPublicacionHasDocBanner($post['publicacion_has_doc_banner']['banner']);
        }
        if (isset($post['publicacion_has_doc_banner']['material'])) {
            $this->ComunCTNModel->insertPublicacionMaterialApoyo($idPublicacionCTN, $post['publicacion_has_doc_banner']['material']);
        }
        if (isset($post['instrutores_asignados']) && is_array($post['instrutores_asignados']) && sizeof($post['instrutores_asignados']) != 0) {
            $this->ComunCTNModel->insertarInstructoresAsignados($idPublicacionCTN, $post['instrutores_asignados']);
        }
        if (isset($post['publicacion_ctn_has_constancia']) && is_array($post['publicacion_ctn_has_constancia']) && sizeof($post['publicacion_ctn_has_constancia']) != 0) {
            $this->ComunCTNModel->insertarPublicacionHasConstancias($idPublicacionCTN, $post['publicacion_ctn_has_constancia']);
        }
        return $idPublicacionCTN;
    }

    private function insertar_publicacion_ctn_to_empresa($id_publicacion_ctn, $datos_empresa)
    {
        $insert = array(
            'rfc' => $datos_empresa['rfc'],
            'correo' => $datos_empresa['correo'],
            'id_publicacion_ctn' => $id_publicacion_ctn
        );
        return $this->db->insert('publicacion_ctn_has_empresa_masivo', $insert);
    }

    private function actualizar_publicacion_ctn($post, $tipo_banner = 'img')
    {
        $idPublicacionCTN = $post['publicacion_ctn']['id_publicacion_ctn'];
        $post['publicacion_ctn']['fecha_modificada'] = todayBD();
        $this->ComunCTNModel->actualizar_publiacion_ctn($idPublicacionCTN, $post['publicacion_ctn']);
        if (isset($post['publicacion_has_doc_banner']['banner'])) {
            $post['publicacion_has_doc_banner']['banner']['id_publicacion_ctn'] = $idPublicacionCTN;
            $this->ComunCTNModel->eliminar_publicacion_has_banner($idPublicacionCTN, $tipo_banner);
            $this->ComunCTNModel->insertPublicacionHasDocBanner($post['publicacion_has_doc_banner']['banner']);
        }
        if (isset($post['publicacion_has_doc_banner']['material'])) {
            $this->ComunCTNModel->eliminar_publicacion_has_banner($idPublicacionCTN, 'doc');
            $this->ComunCTNModel->insertPublicacionMaterialApoyo($idPublicacionCTN, $post['publicacion_has_doc_banner']['material']);
        }
        if (isset($post['publicacion_ctn_has_constancia']) && is_array($post['publicacion_ctn_has_constancia']) && sizeof($post['publicacion_ctn_has_constancia']) != 0) {
            $this->ComunCTNModel->eliminar_publicacion_has_constancias($idPublicacionCTN);
            $this->ComunCTNModel->insertarPublicacionHasConstancias($idPublicacionCTN, $post['publicacion_ctn_has_constancia']);
        }
        //realizar preferente update e inserts por lo de los instructores que posiblemente esten asignados a algun alumno
        if (isset($post['instrutores_asignados']) && is_array($post['instrutores_asignados']) && sizeof($post['instrutores_asignados']) != 0) {
            $this->ComunCTNModel->actualizar_instructores_asignados_publicacion_ctn($idPublicacionCTN, $post['instrutores_asignados']);
        }
        return $idPublicacionCTN;
    }

    private function cancelar_publicaciones_by_id_ctn($id_curso_taller_norma, $fecha, $motivo)
    {
        $this->db->where('id_curso_taller_norma', $id_curso_taller_norma);
        $this->db->where('fecha_fin > ', $fecha);
        return $this->db->update('publicacion_ctn', array(
            'publicacion_eliminada' => 'si',
            'fecha_eliminada' => $fecha,
            'detalle_eliminacion' => $motivo
        ));
    }

    private function obtener_alumno_inscrito_by_id($id_alumno_inscrito)
    {
        $this->db->where('id_alumno_inscrito_ctn_publicado', $id_alumno_inscrito);
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        return $query->row();
    }

    private function obtenerInstructorParaAsignar($idPublicacionCTN)
    {
        $consulta = "select 
        iacp.id_instructor_asignado_curso_publicado, 
        u.nombre,u.apellido_p, u.apellido_m, ca.cupo,
        count(aicp.id_alumno_inscrito_ctn_publicado) alumnos_inscritos
        from instructor_asignado_curso_publicado iacp
        inner join catalogo_aula ca on ca.id_catalogo_aula = iacp.id_catalogo_aula
        inner join instructor i on i.id_instructor = iacp.id_instructor
        inner join usuario u on u.id_usuario = i.id_usuario
        inner join publicacion_ctn pc on pc.id_publicacion_ctn = iacp.id_publicacion_ctn
        left join alumno_inscrito_ctn_publicado aicp on aicp.id_instructor_asignado_curso_publicado = iacp.id_instructor_asignado_curso_publicado
        where pc.id_publicacion_ctn = $idPublicacionCTN
        group by iacp.id_instructor_asignado_curso_publicado
        order by alumnos_inscritos,u.nombre asc 
        limit 1";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    private function obtener_banner_ctn_publicado($id_publicacion_ctn, $tipo_banner = 'img')
    {
        $consulta = "select 
        concat(d.ruta_directorio,d.nombre) img_banner
        from publicacion_has_doc_banner pdb
        inner join documento d on d.id_documento = pdb.id_documento
        where pdb.tipo = '$tipo_banner'
        and pdb.id_publicacion_ctn = $id_publicacion_ctn
        order by pdb.id_publicacion_has_doc_banner desc limit 1";
        $query = $this->db->query($consulta);
        return $query->row()->img_banner;
    }

    private function obtener_campus_aula_ctn_publicado($id_publicacion_ctn)
    {
        $consulta = "
        select 
        a.campus,a.aula 
        from instructor_asignado_curso_publicado iacp 
        inner join catalogo_aula a on iacp.id_catalogo_aula = a.id_catalogo_aula
        where iacp.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    /**
     * apartado de validaciones para los cursos model
     */
    private function validar_disponibilidad_instructor($post_instructores, $fecha_imparticion)
    {
        $validacion = true;
        foreach ($post_instructores as $i) {
            $instructor_disponible = $this->instructor_disponible_fecha_imparticion($i['id_instructor'], $fecha_imparticion);
            if ($instructor_disponible !== true) {
                $validacion = false;
                $this->msg_validacion .= 'El instructor "' . $instructor_disponible->nombre_instructor . '" tiene curso asignado para esa fecha';
            }
        }
        return $validacion;
    }

    private function instructor_disponible_fecha_imparticion($id_instructor, $fecha_imparticion)
    {
        $consulta = "select 
        concat(u.nombre,' ',u.apellido_p) nombre_instructor
        from publicacion_ctn pc 
        inner join instructor_asignado_curso_publicado iacp on iacp.id_publicacion_ctn = pc.id_publicacion_ctn
        inner join instructor i on i.id_instructor = iacp.id_instructor
        inner join usuario u on u.id_usuario = i.id_usuario
        where iacp.id_instructor = $id_instructor
        and pc.fecha_inicio = '$fecha_imparticion'
        and pc.publicacion_eliminada = 'no'";
        $query = $this->db->query($consulta);
        if ($query->num_rows() == 0) {
            return true;
        }
        return $query->row();
    }

    private function actualizar_curso_taller_norma_has_instructores($id_curso_taller_norma, $array_instructores)
    {
        $this->db->where('id_curso_taller_norma', $id_curso_taller_norma);
        $this->db->delete('curso_taller_norma_has_instructores');
        foreach ($array_instructores as $i) {
            $insert = array(
                'id_instructor' => $i,
                'id_curso_taller_norma' => $id_curso_taller_norma
            );
            $this->db->insert('curso_taller_norma_has_instructores', $insert);
        }
        return true;
    }
}

?>