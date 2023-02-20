<?php

defined('BASEPATH') OR exit('No tiene access al script');

class AlumnosModel extends CI_Model{

    function __construct()
    {
        $this->load->model('DocumentosModel');
    }

    /**
     * metodos para obtener información del sistema CIVIK
     */
    public function obtener_datos_alumno_inscrito_publicado($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        return $query->row();
    }

    public function obtener_datos_alumno($idAlumno){
        $consulta = "select 
              u.nombre,u.apellido_p,u.apellido_m,
              u.correo,u.telefono,a.curp,a.puesto,
              coe.denominacion ocupacion_especifica
            from alumno a 
              inner join usuario u on u.id_usuario = a.id_usuario
              inner join catalogo_ocupacion_especifica coe on coe.id_catalogo_ocupacion_especifica = a.id_catalogo_ocupacion_especifica
            where a.id_alumno = $idAlumno";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtener_datos_empresa_alumno($idAlumno){
        $consulta = "select 
              ea.nombre,ea.rfc,ea.domicilio,ea.telefono,
              ea.correo,ea.representante_legal,ea.representante_trabajadores
            from alumno a 
              inner join empresa_alumno ea on ea.id_alumno = a.id_alumno
            where a.id_alumno = $idAlumno";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtener_datos_facturacion($id_alumno_inscrito_ctn_publicado){
        $consulta = "select df.*,concat('(',cuc.clave,') ',cuc.descripcion) uso_cfdi from datos_fiscales df
            inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno_inscrito_ctn_publicado = df.id_alumno_inscrito_ctn_publicado
            left join catalogo_uso_cfdi cuc on cuc.id_catalogo_uso_cfdi = df.id_catalogo_uso_cfdi
            where aicp.id_alumno_inscrito_ctn_publicado = $id_alumno_inscrito_ctn_publicado";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtener_publicacion_material_evidencia($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        $query = $this->db->get('alumno_publicacion_ctn_has_material');
        $result = $query->result();
        foreach ($result as $r){
            $r->documento_evidencia = false;
            if(!is_null($r->id_documento)){
                $r->documento_evidencia = $this->DocumentosModel->obtenerDocumentoById($r->id_documento);;
            }
        }
        return $result;
    }

    /**
     * apartado de funciones para guardar informacion
     */
    public function guardar_publicacion_material_evidencia($post){
        return $this->guardar_alumno_material_evidencia($post['id_alumno_inscrito_ctn_publicado'],$post['alumno_publicacion_ctn_has_material']);
    }

    /**
     * apartado de funciones privadas
     */

    private function guardar_alumno_material_evidencia($id_alumno_inscrito_ctn_publicado,$array_datos){
        $this->delete_alumno_publicacion_evidencia($id_alumno_inscrito_ctn_publicado);
        foreach ($array_datos as $insert){
            $insert['id_alumno_inscrito_ctn_publicado'] = $id_alumno_inscrito_ctn_publicado;
            $this->insert_alumno_publicacion_evidencia($insert);
        }return true;
    }

    private function insert_alumno_publicacion_evidencia($insert){
        $this->db->insert('alumno_publicacion_ctn_has_material',$insert);
    }

    private function delete_alumno_publicacion_evidencia($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        return $this->db->delete('alumno_publicacion_ctn_has_material');
    }

}

?>