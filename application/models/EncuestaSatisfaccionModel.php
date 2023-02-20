<?php

defined('BASEPATH') OR exit('No tiene access al script');

class EncuestaSatisfaccionModel extends CI_Model{

    public function iniciar_encuesta_satisfacion_admin($id_instructor_asignado_ctn_publicado){
        $data['pregunta_encuesta_satisfaccion'] = $this->obtener_preguntas_encuesta_satisfaccion();
        if($this->no_existen_respuestas_encuesta_instructor_asignado($id_instructor_asignado_ctn_publicado)){
            $this->inicializar_opciones_pregunta_respuesta_encuesta($id_instructor_asignado_ctn_publicado);
        }
        foreach ($data['pregunta_encuesta_satisfaccion'] as $pes){
            $pes->opcion_respuesta_encuesta_satisfaccion = $this->obtener_opciones_pregunta_respuesta_encuesta($pes->id_pregunta_encuesta_satisfaccion,$id_instructor_asignado_ctn_publicado);
        }
        $data['encabezados_preguntas'] = $this->obtener_opciones_pregunta_respuesta_encuesta(1,$id_instructor_asignado_ctn_publicado);
        //echo '<pre>'; print_r($data);
        return $data;
    }

    public function validar_guardado_encuesta_satisfaccion($id_encuesta_satisfaccion){
        $respuesta_encuesta_satisfaccion = $this->obtener_respuesta_encuesta_satisfaccion_by_id($id_encuesta_satisfaccion);
        $pregunta_opcion = $this->obtener_pregunta_encuesta_by_id_opcion($respuesta_encuesta_satisfaccion->id_opcion_encuesta_satisfaccion);
        $porcentaje_guardado = $this->obtener_porcentaje_registrado_pregunta_instructor($pregunta_opcion->id_pregunta_encuesta_satisfaccion,$respuesta_encuesta_satisfaccion->id_instructor_asignado_curso_publicado);
        $validacion['valido'] = true;
        $validacion['msg'] = '';
        if($porcentaje_guardado > 100){
            $excedente = $porcentaje_guardado - 100;
            $validacion['valido'] = false;
            $validacion['msg'] = 'La pregunta no puede ser superior al 100%, tiene actualmente un excedente de '.$excedente;
        }
        return $validacion;
    }

    /**
     * apartado de funciones privadas
     */
    private function obtener_respuesta_encuesta_satisfaccion_by_id($id_encuesta_satisfaccion){
        $this->db->where('id_encuesta_satisfaccion',$id_encuesta_satisfaccion);
        $query = $this->db->get('encuesta_satisfaccion');
        return $query->row();
    }

    private function obtener_preguntas_encuesta_satisfaccion(){
        $query = $this->db->get('pregunta_encuesta_satisfaccion');
        return $query->result();
    }

    private function obtener_opciones_pregunta_respuesta_encuesta($id_pregunta_encuesta_satisfaccion,$id_instructor_asignado_ctn_publicado){
        $consulta = "select 
                es.id_encuesta_satisfaccion, oes.opcion, es.respuesta
            from opcion_encuesta_satisfaccion oes
                inner join encuesta_satisfaccion es on es.id_opcion_encuesta_satisfaccion = oes.id_opcion_encuesta_satisfaccion 
            where oes.id_pregunta_encuesta_satisfaccion = $id_pregunta_encuesta_satisfaccion
                and es.id_instructor_asignado_curso_publicado = $id_instructor_asignado_ctn_publicado";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    private function obtener_pregunta_encuesta_by_id_opcion($id_opcion_encuesta_satisfaccion){
        $this->db->where('id_opcion_encuesta_satisfaccion',$id_opcion_encuesta_satisfaccion);
        $query = $this->db->get('opcion_encuesta_satisfaccion');
        return $query->row();
    }

    private function obtener_porcentaje_registrado_pregunta_instructor($id_pregunta_encuesta_satisfaccion,$id_instructor_asignado_curso_publicado){
        $consulta = "select 
              sum(es.respuesta) porciento_sumatoria
            from encuesta_satisfaccion es
              inner join opcion_encuesta_satisfaccion oes on oes.id_opcion_encuesta_satisfaccion = es.id_opcion_encuesta_satisfaccion
            where oes.id_pregunta_encuesta_satisfaccion = $id_pregunta_encuesta_satisfaccion
              and es.id_instructor_asignado_curso_publicado = $id_instructor_asignado_curso_publicado";
        $query = $this->db->query($consulta);
        return $query->row()->porciento_sumatoria;
    }

    private function no_existen_respuestas_encuesta_instructor_asignado($id_instructor_asignado_curso_publicado){
        $this->db->where('id_instructor_asignado_curso_publicado',$id_instructor_asignado_curso_publicado);
        $query = $this->db->get('encuesta_satisfaccion');
        return $query->num_rows() == 0;
    }

    private function inicializar_opciones_pregunta_respuesta_encuesta($id_instructor_asignado_ctn_publicado){
        $consulta = "select INSERTS_INCIALES_ENCUESTA_SATISFACCION_ADMIN($id_instructor_asignado_ctn_publicado) inserts;";
        $query = $this->db->query($consulta);
        return $query->row()->inserts;
    }

}

?>