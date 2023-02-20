<?php

defined('BASEPATH') OR exit('No tiene access al script');

class NormasASEAModel extends CI_Model{

    /**
     * metodos publicos para obtener informacion de las normas
     */
    public function obtenerListaNormasAsea($campos_busqueda){
        $consulta = "select * from normas_asea na";
        $consulta .= $this->obtenerCriteriosBusquedaNormas($campos_busqueda);
        $consulta .= " order by na.orden_norma,na.anio";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        return $query->result();
    }

    public function obtenerListaNormasAseaEstacionEmpleado($campos_busqueda,$idEstacionServicio){
        $consulta = "select na.* from normas_asea na
            inner join estacion_servicio_tiene_normas estn on estn.id_normas_asea = na.id_normas_asea";
        $consulta .= $this->obtenerCriteriosBusquedaNormas($campos_busqueda);
        $consulta .= " and estn.id_estacion_servicio = $idEstacionServicio";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        return $query->result();
    }

    public function obtenerNormaAsea($id_norma_asea){
        $this->db->where('id_normas_asea',$id_norma_asea);
        $query = $this->db->get('normas_asea');
        if($query->num_rows() == 0) return false;
        $row = $query->row();
        $row->editar_preguntas = true;
        return $row;
    }

    public function obtenerListaActividades($id_norma_asea){
        $this->db->where('id_normas_asea',$id_norma_asea);
        $query = $this->db->get('actividad_normas_asea');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->result();
    }

    public function obtenerListaPreguntasNorma($idNormaAsea){
        $consulta = "select
              pna.id_preguntas_normas_asea, pna.pregunta,ctop.opcion_pregunta
            from preguntas_normas_asea pna
              inner join catalogo_tipo_opciones_pregunta ctop on ctop.id_opciones_pregunta = pna.id_opciones_pregunta
            where pna.id_normas_asea = $idNormaAsea";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return array();
        }
        $result = $query->result();
        foreach($result as $r){
            $r->respuestas_correctas = $this->obtenerRespuestasCorrectasPregunta($r->id_preguntas_normas_asea,true);
        }
        return $result;
    }

    public function obtenerPreguntaRespuetasNorma($idPreguntaNormaAsea){
        $consulta = "select
              pna.*
            from preguntas_normas_asea pna
              inner join catalogo_tipo_opciones_pregunta ctop on ctop.id_opciones_pregunta = pna.id_opciones_pregunta
            where pna.id_preguntas_normas_asea = $idPreguntaNormaAsea";
        $query = $this->db->query($consulta);
        $row = $query->row();
        $row->respuestas = $this->obtenerRespuestasCorrectasPregunta($row->id_preguntas_normas_asea,false);
        return $row;
    }

    public function tieneEvaluacionNormaAsea($idNormaAsea){
        $this->db->where('id_normas_asea',$idNormaAsea);
        $query = $this->db->get('evaluacion_norma_asea');
        if($query->num_rows() == 0){
            return false;
        }return true;
    }


    /**
     * metodos de funciones para actualizar la  informacion de las normas
     */

    public function guardarNormaAsea($norma_asea){
        $result['exito'] = false;
        $result['msg'] = 'No fue posible registrar la norma, ya existe una con el mismo año y orden de la norma';
        $norma_asea['fecha_inicio'] = fechaHtmlToBD($norma_asea['fecha_inicio']);
        $norma_asea['fecha_fin'] = fechaHtmlToBD($norma_asea['fecha_fin']);
        if(isset($norma_asea['id_normas_asea']) && $norma_asea['id_normas_asea'] != ''){
            $norma_asea_b = $this->obtenerNormaAsea($norma_asea['id_normas_asea']);
            if($norma_asea_b->orden_norma == $norma_asea['orden_norma']){
                $this->db->where('id_normas_asea',$norma_asea['id_normas_asea']);
                $this->db->update('normas_asea',$norma_asea);
                $result['exito'] = true;
                $result['msg'] = 'Se registro la norma en el sistema con exito';
            }else{
                if(!$this->existeNormaAnioOrden($norma_asea['anio'],$norma_asea['orden_norma'])){
                    $this->db->where('id_normas_asea',$norma_asea['id_normas_asea']);
                    $this->db->update('normas_asea',$norma_asea);
                    $result['exito'] = true;
                    $result['msg'] = 'Se registro la norma en el sistema con exito';
                }
            }
        }else{
            if(!$this->existeNormaAnioOrden($norma_asea['anio'],$norma_asea['orden_norma'])){
                $this->db->insert('normas_asea',$norma_asea);
                $result['exito'] = true;
                $result['msg'] = 'Se registro la norma en el sistema con exito';
            }
        }
        return $result;
    }

    public function guardarActividadesNorma($form_post){
        $id_normas_asea = $form_post['id_normas_asea'];
        $this->eliminarActividadesNorma($id_normas_asea);
        foreach ($form_post['actividad_normas_asea'] as $ana){
            $ana['id_normas_asea'] = $id_normas_asea;
            $this->db->insert('actividad_normas_asea',$ana);
        }
        return true;
    }

    public function guardarPreguntaRespuestasNorma($form_post){
        $idPreguntasNormasAsea = $form_post['preguntas_normas_asea']['id_preguntas_normas_asea'];
        if($idPreguntasNormasAsea != ''){
            $this->db->where('id_preguntas_normas_asea',$idPreguntasNormasAsea);
            $this->db->update('preguntas_normas_asea',$form_post['preguntas_normas_asea']);

        }else{
            $this->db->insert('preguntas_normas_asea',$form_post['preguntas_normas_asea']);
            $idPreguntasNormasAsea = $this->db->insert_id();
        }
        $this->eliminarOpcionesPreguntas($idPreguntasNormasAsea);
        foreach($form_post['opcion_pregunta_norma_asea'] as $op){
            $op['id_preguntas_normas_asea'] = $idPreguntasNormasAsea;
            $this->db->insert('opcion_pregunta_norma_asea', $op);
        }
        return true;
    }

    public function eliminarNormaAsea($id_norma_asea){
        $this->db->where('id_normas_asea',$id_norma_asea);
        $this->db->delete('actividad_normas_asea');
        $this->db->where('id_normas_asea',$id_norma_asea);
        return $this->db->delete('normas_asea');
    }

    public function eliminarPreguntaNormaAsea($idPreguntasNormasAsea){
        $this->eliminarOpcionesPreguntas($idPreguntasNormasAsea);
        $this->db->where('id_preguntas_normas_asea',$idPreguntasNormasAsea);
        return $this->db->delete('preguntas_normas_asea');
    }

    /*
     * apartado de funciones privadas a las normas asea
     */
    private function obtenerCriteriosBusquedaNormas($campos_busqueda){
        $criterios = ' where 1=1';
        if($campos_busqueda['nombre'] != '') $criterios .= " and na.nombre like '%".$campos_busqueda['nombre']."%'";
        if($campos_busqueda['duracion'] != '') $criterios .= " and na.duracion like '%".$campos_busqueda['duracion']."%'";
        if($campos_busqueda['instructor'] != '') $criterios .= " and na.instructor like '%".$campos_busqueda['instructor']."%'";

        if($campos_busqueda['fecha_inicio'] != '') $criterios .= " and na.fecha_inicio = '".fechaHtmlToBD($campos_busqueda['fecha_inicio'])."'";
        if($campos_busqueda['fecha_fin'] != '') $criterios .= " and na.fecha_fin = ".fechaHtmlToBD($campos_busqueda['fecha_fin'])."'";

        if($campos_busqueda['ocupacion_especifica'] != '') $criterios .= " and na.ocupacion_especifica like '%".$campos_busqueda['ocupacion_especifica']."%'";
        if($campos_busqueda['agente_capacitador'] != '') $criterios .= " and na.agente_capacitador like '%".$campos_busqueda['agente_capacitador']."%'";
        if($campos_busqueda['area_tematica'] != '') $criterios .= " and na.area_tematica like '%".$campos_busqueda['area_tematica']."%'";
        if($campos_busqueda['anio'] != '') $criterios .= " and na.anio = ".$campos_busqueda['anio'];
        if($campos_busqueda['horario'] != '') $criterios .= " and na.horario like '%".$campos_busqueda['horario']."%'";
        return $criterios;
    }

    private function obtenerRespuestasCorrectasPregunta($idPreguntasNormasAsea,$correcta = false){
        $this->db->where('id_preguntas_normas_asea',$idPreguntasNormasAsea);
        if($correcta){
            $this->db->where('tipo_respuesta','correcta');
        }
        $query = $this->db->get('opcion_pregunta_norma_asea');
        return $query->result();
    }

    private function eliminarActividadesNorma($id_normas_asea){
        $this->db->where('id_normas_asea',$id_normas_asea);
        return $this->db->delete('actividad_normas_asea');
    }

    private function eliminarOpcionesPreguntas($idPreguntasNormasAsea){
        $this->db->where('id_preguntas_normas_asea',$idPreguntasNormasAsea);
        return $this->db->delete('opcion_pregunta_norma_asea');
    }

    private function existeNormaAnioOrden($anio,$orden_norma){
        $this->db->where('anio',$anio);
        $this->db->where('orden_norma',$orden_norma);
        $query = $this->db->get('normas_asea');
        if($query->num_rows() != 0){
            return true;
        }return false;
    }

}

?>