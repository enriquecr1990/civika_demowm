<?php

defined('BASEPATH') OR exit('No tiene access al script');

class DocumentosEXCELModel extends CI_Model{

    function __construct(){
    }

    public  function excel_lista_asistencia($id_publicacion_ctn,$id_instructor_asignado){
        $inscripcion_finalizada = PROCESO_PAGO_FINALIZADO_INSCRITO;
        $consulta = "select 	
              concat(u.apellido_p,' ',u.apellido_m,' ',u.nombre) NOMBRE,
              a.curp CURP, ea.nombre EMPRESA,
              '' as FIRMA,'' as FECHA,'' as BAUCHER,'' as DOCUMENTOS
          from usuario u
              inner join alumno a on u.id_usuario = a.id_usuario
              LEFT join empresa_alumno ea on a.id_alumno = ea.id_alumno
              inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno
              inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
              where pc.id_publicacion_ctn = $id_publicacion_ctn
              and aicp.id_catalogo_proceso_inscripcion=$inscripcion_finalizada
              and aicp.id_instructor_asignado_curso_publicado = $id_instructor_asignado";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public  function excel_lista_asistencia_todos($id_publicacion_ctn){
        $consulta = "select 	
              concat(u.apellido_p,' ',u.apellido_m,' ',u.nombre) NOMBRE,
              a.curp CURP, ea.nombre EMPRESA,
              '' as FIRMA,'' as FECHA,'' as BAUCHER,'' as DOCUMENTOS
          from usuario u
              inner join alumno a on u.id_usuario = a.id_usuario
              LEFT join empresa_alumno ea on a.id_alumno = ea.id_alumno
              inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno
              inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
              where pc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public  function excel_lista_generar_constancias($id_publicacion_ctn){
        $consulta = "select 	
                  concat(u.apellido_p,' ',u.apellido_m,' ',u.nombre) nombre_alumno,
                  a.curp CURP, ea.rfc rfc_empresa, ea.nombre nombre_empresa, a.puesto, ea.representante_legal, ea.representante_trabajadores,
                  ctn.nombre nombre_curso,
                  /*DATOS INSTRUCTOR*/
                  concat (ua.nombre, ' ', ua.apellido_p, ' ', ua.apellido_m) nombre_instructor
                 from usuario u
                    inner join alumno a on u.id_usuario = a.id_usuario
                    LEFT join empresa_alumno ea on a.id_alumno = ea.id_alumno
                    inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno
                    inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn  
                    inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = pc.id_curso_taller_norma
                    left join instructor_asignado_curso_publicado iacp on iacp.id_instructor_asignado_curso_publicado = aicp.id_instructor_asignado_curso_publicado
                    left join instructor i on i.id_instructor = iacp.id_instructor
                    left join usuario ua on ua.id_usuario = i.id_usuario
                     WHERE pc.id_publicacion_ctn =$id_publicacion_ctn";
        $query = $this->db->query($consulta);
        return $query->result();
    }
}

?>