<?php

defined('BASEPATH') OR exit('No tiene access al script');

class EmpleadosESModel extends CI_Model{

    /**
     * apartado de funciones para obtener informacion para los empleados ES
     */
    public function obtenerEmpleadoEs($idEmpleadoES){
        $this->db->where('id_empleado_es',$idEmpleadoES);
        $query = $this->db->get('empleado_es');
        return $query->row();
    }

    public function obtenerNormasAseaDisponibles($idEmpleadoES,$periodo=false){
        $consulta = "select 
              na.* 
            from normas_asea na 
              inner join estacion_servicio_tiene_normas estn on estn.id_normas_asea = na.id_normas_asea
              inner join empleado_es es on es.id_estacion_servicio = estn.id_estacion_servicio
            where es.id_empleado_es = $idEmpleadoES";
        if($periodo){
            $consulta .= " and na.anio = $periodo";
        }
        $consulta .= " order by na.orden_norma asc";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        $normas_id = array();
        foreach($result as $index => $r){
            $normas_id[$index] = $r->id_normas_asea;
            if($index == 0){
                $r->aplica_cursar = true;
            }else{
                $idNormasAseaAnterior = $normas_id[$index - 1];
                $r->aplica_cursar = $this->cursarNormaAseaConEvaluacion($idNormasAseaAnterior,$idEmpleadoES);
            }
            $r->aplica_curso = $this->validarEmpleadoTieneCurso($r->id_normas_asea,$idEmpleadoES);
            $r->aplica_evaluacion = false;
            $r->aplica_constancia = false;
            if($r->aplica_cursar){
                $r->aplica_evaluacion = $this->validarAplicaEvaluacion($r->id_normas_asea,$idEmpleadoES);
                $r->aplica_constancia = $this->validarAplicaConstancia($r->id_normas_asea,$idEmpleadoES);
            }
        }
        return $result;
    }

    public function obtenerActividadesNorma($idNormasAsea){
        $this->db->where('id_normas_asea',$idNormasAsea);
        $query = $this->db->get('actividad_normas_asea');
        $result = $query->result();
        return $result;
    }

    public function obtenerTiempoActividadesNorma($idNormasAsea){
        $consulta = "select sum(ana.tiempo) tiempo from actividad_normas_asea ana where ana.id_normas_asea = $idNormasAsea";
        $query = $this->db->query($consulta);
        $milisegundos = $this->calcularMilisegundosVideo($query->row()->tiempo);
        return $milisegundos;
    }

    public function obtenerListaPreguntasNorma($idNormaAsea){
        $consulta = "select
              pna.id_preguntas_normas_asea, pna.pregunta, pna.id_opciones_pregunta
            from preguntas_normas_asea pna
            where pna.id_normas_asea = $idNormaAsea";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach($result as $r){
            $r->is_checkbox = false;
            if($r->id_opciones_pregunta == 3){
                $r->is_checkbox = true;
            }
            $r->respuestas = $this->obtenerRespuestasPregunta($r->id_preguntas_normas_asea);
        }
        return $result;
    }

    public function obtenerListaEvaluacionesNorma($idNormaAsea,$idEmpleadoEs){
        $this->db->where('id_normas_asea',$idNormaAsea);
        $this->db->where('id_empleado_es',$idEmpleadoEs);
        $query = $this->db->get('evaluacion_norma_asea');
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach($result as $r){
            $r->calificacion_evaluacion = $this->obtenerCalificacionEvaluacion($r->id_evaluacion_norma_asea);
            $r->aprobado = false;
            if($r->calificacion_evaluacion >= 80){
                $r->aprobado = true;
            }
            $r->color_calificacion = $this->obtenerColoresCalificacion($r->calificacion_evaluacion);
        }
        return $result;
    }

    public function obtenerCalificacionEvaluacion($idEvaluacionNormaAsea){
        $this->db->where('id_evaluacion_norma_asea',$idEvaluacionNormaAsea);
        $query = $this->db->get('evaluacion_norma_asea');
        $evaluacion = $query->row();
        $this->db->where('id_normas_asea',$evaluacion->id_normas_asea);
        $query = $this->db->get('preguntas_normas_asea');
        $preguntas = $query->result();
        $respuestasCorrectas = 0;
        $calificacion = 0;
        foreach($preguntas as $p){
            $existe_correcta = false;
            $id_preguntas_normas_asea = $p->id_preguntas_normas_asea;
            $consulta = "select
                  opna.tipo_respuesta
                from respuesta_empleado_es res
                  inner join opcion_pregunta_norma_asea opna on opna.id_opcion_pregunta = res.id_opcion_pregunta
                where res.id_evaluacion_norma_asea = $idEvaluacionNormaAsea
                  and res.id_preguntas_normas_asea = $id_preguntas_normas_asea";
            $query = $this->db->query($consulta);
            $respuestas_empleado = $query->result();
            $this->db->where('id_preguntas_normas_asea',$p->id_preguntas_normas_asea);
            $query = $this->db->get('opcion_pregunta_norma_asea');
            $respuestas_pregunta = $query->result();
            foreach($respuestas_empleado as $re){
                if($re->tipo_respuesta == 'correcta'){
                    $existe_correcta = true;
                }
            }
            if($p->id_opciones_pregunta == 3){
                if(sizeof($respuestas_empleado) == sizeof($respuestas_pregunta)){
                    $existe_correcta = false;
                }
            }
            if($existe_correcta){
                $respuestasCorrectas++;
            }
        }
        $numero_preguntas = sizeof($preguntas);
        if($respuestasCorrectas != 0){
            $calificacion = ($respuestasCorrectas/$numero_preguntas ) * 100;
        }
        $calificacion = number_format($calificacion, 2, '.', '');
        return $calificacion;
    }

    public function obtenerNormasCursadasEmpleado($idEmpleadoES){
        $consulta = "select 
              na.nombre,na.id_normas_asea,
              ecn.ingresos_curso, ecn.fecha_ingreso, ecn.fecha_ultimo_ingreso
            from empleado_cursa_norma ecn 
              inner join normas_asea na on na.id_normas_asea = ecn.id_normas_asea
            where ecn.id_empleado_es = $idEmpleadoES";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach ($result as $r){
            $r->lista_evaluaciones = $this->obtenerListaEvaluacionesNorma($r->id_normas_asea,$idEmpleadoES);
        }
        return $result;
    }

    public function generarConstanciaDC3($idNormaAsea,$idEmpleadoEs,$tipo='D'){
        $this->load->library('../libraries/m_pdf');
        $mpdf = new mpdf('','letter', '12', 'Arial Narrow', 5, 5, 5, 13, '', '', 'p');
        $data['constanciaDC3'] = $this->obtenerDatosConstanciaDC3($idNormaAsea,$idEmpleadoEs);
        $contenido_pagina = $this->load->view('asea/empleados_es/ConstanciaDC3',$data,true);
        //var_dump($data);exit;
        //echo $contenido_pagina;exit;
        $mpdf->WriteHTML($contenido_pagina);
        $mpdf->Output('ConstanciaDC3.pdf',$tipo);
    }

    /**
     * apartado de funciones para guardar informacion para los empleados ES
     */
    public function registrarEmpleadoCursoNormaAsea($form_post){
        $this->db->flush_cache();
        $this->db->where('id_empleado_es',$form_post['id_empleado_es']);
        $this->db->where('id_normas_asea',$form_post['id_normas_asea']);
        $query = $this->db->get('empleado_cursa_norma');
        if($query->num_rows() == 0){
            $form_post['fecha_ingreso'] = date('Y-m-d h:i:s');
            return $this->db->insert('empleado_cursa_norma',$form_post);
        }else{
            $empleado_curso_norma = $query->row();
            $ingresos_curso = $empleado_curso_norma->ingresos_curso + 1;
            $this->db->where('id_empleado_cursa_norma',$empleado_curso_norma->id_empleado_cursa_norma);
            return $this->db->update('empleado_cursa_norma',array('fecha_ultimo_ingreso' => date('Y-m-d h:i:s'), 'ingresos_curso' => $ingresos_curso));
        }
    }

    public function guardarEvaluacionEmpleadoEs($form_post){
        $form_post['evaluacion_norma_asea']['fecha_evaluacion'] = date('Y-m-d h:i:s');
        $this->db->insert('evaluacion_norma_asea',$form_post['evaluacion_norma_asea']);
        $idEvaluacionNormaAsea = $this->db->insert_id();
        foreach($form_post['respuesta_empleado_es'] as $rees){
            $id_preguntas_normas_asea = $rees['id_preguntas_normas_asea'];
            foreach($rees['respuestas'] as $respuesta){
                if(!is_array($respuesta)){
                    $insert_respuestas = array(
                        'id_evaluacion_norma_asea' => $idEvaluacionNormaAsea,
                        'id_preguntas_normas_asea' => $id_preguntas_normas_asea,
                        'id_opcion_pregunta' => $respuesta
                    );
                    $this->db->insert('respuesta_empleado_es',$insert_respuestas);
                }else{
                    foreach($respuesta as $r){
                        $insert_respuestas = array(
                            'id_evaluacion_norma_asea' => $idEvaluacionNormaAsea,
                            'id_preguntas_normas_asea' => $id_preguntas_normas_asea,
                            'id_opcion_pregunta' => $r
                        );
                        $this->db->insert('respuesta_empleado_es',$insert_respuestas);
                    }
                }
            }
        }
        return true;
    }

    /**
     * apartado de funciones privadas para los empleados ES
     */
    private function validarEmpleadoTieneCurso($idNormasAsea,$idEmpleadoEs){
        $this->db->where('id_normas_asea',$idNormasAsea);
        $this->db->where('id_empleado_es',$idEmpleadoEs);
        $query = $this->db->get('empleado_cursa_norma');
        if($query->num_rows() == 0){
            return false;
        }return true;
    }

    private function validarAplicaEvaluacion($idNormasAsea,$idEmpleadoEs){
        /**
         * considerar que el obtener aplica examen es saber
         * si ya tiene ha cursado la norma y  que no pase de 3 evaluaciones
         */
        $this->db->where('id_normas_asea',$idNormasAsea);
        $this->db->where('id_empleado_es',$idEmpleadoEs);
        $query = $this->db->get('evaluacion_norma_asea');
        if($query->num_rows() <= 3){
            return true;
        }return false;
    }

    private function validarAplicaConstancia($idNormasAsea,$idEmpleadoES){
        /**
         * validar si tiene alguna evaluacion aprobatoria para descargar la constancia
         * y considerando que solo debe tener 3 evaluaciones
         */
        return false;
    }

    private function cursarNormaAseaConEvaluacion($idNormasAsea,$idEmpleadoEs){
        $this->db->where('id_normas_asea',$idNormasAsea);
        $this->db->where('id_empleado_es',$idEmpleadoEs);
        $query = $this->db->get('empleado_cursa_norma');
        if($query->num_rows() == 0){
            return false;
        }else{
            $this->db->where('id_normas_asea',$idNormasAsea);
            $this->db->where('id_empleado_es',$idEmpleadoEs);
            $query = $this->db->get('evaluacion_norma_asea');
            if($query->num_rows() == 0){
                return false;
            }return true;
        }
    }

    private function obtenerRespuestasPregunta($idPreguntasNormaAsea){
        $consulta = "select opna.id_opcion_pregunta, opna.descripcion
            from opcion_pregunta_norma_asea opna
            where opna.id_preguntas_normas_asea = $idPreguntasNormaAsea";
        $query =  $this->db->query($consulta);
        return $query->result();
    }

    private function obtenerColoresCalificacion($calificacion){
        $color = 'danger';
        if($calificacion >= 70 && $calificacion < 80){
            $color = 'warning';
        }if($calificacion >= 80 && $calificacion < 90){
            $color = 'info';
        }if($calificacion >= 90){
            $color = 'success';
        }
        return $color;
    }

    private function calcularMilisegundosVideo($tiempo){
        return 3000;
        $milisegundos = 30000;
        if($tiempo != null){
            $milisegundos = ($tiempo * 60000);
        }
        return $milisegundos;
    }

    private function obtenerDatosConstanciaDC3($idNormaAsea,$idEmpleadoEs){
        $consulta = "select 
              concat(ee.nombre,' ',ee.apellido_p,' ',ee.apellido_m) nombre_trabajador,
              ee.curp,na.ocupacion_especifica, ee.puesto,
              es.nombre nombre_estacion, es.rfc,
              na.nombre nombre_norma,na.duracion duracion_norma,na.fecha_inicio, na.fecha_fin, na.area_tematica,
              na.agente_capacitador, na.instructor, es.representante_legal,
              concat(esr.nombre,' ',esr.apellido_p,' ',esr.apellido_m ) representante_trabajadores,
              concat(da.ruta_directorio ,da.nombre ) ruta_logo
            from empleado_es ee 
              inner join estacion_servicio es on es.id_estacion_servicio = ee.id_estacion_servicio
              inner join estacion_servicio_tiene_documento estd on estd.id_estacion_servicio = es.id_estacion_servicio
              inner join documento_asea da on da.id_documento_asea = estd.id_documento_asea
              inner join empleado_cursa_norma ecn on ecn.id_empleado_es = ee.id_empleado_es
              inner join normas_asea na on na.id_normas_asea = ecn.id_normas_asea
              left join empleado_es esr on (esr.id_estacion_servicio = es.id_estacion_servicio and esr.es_representante = 'si')  
            where ee.id_empleado_es = $idEmpleadoEs and na.id_normas_asea = $idNormaAsea";
        $query = $this->db->query($consulta);
        $row = $query->row();
        $row->nombre_trabajador = $this->strMayusculas($row->nombre_trabajador);
        $row->array_curp = str_split($row->curp);
        $row->ocupacion_especifica = $this->strMayusculas($row->ocupacion_especifica);
        $row->puesto = $this->strMayusculas($row->puesto);
        $row->nombre_estacion = $this->strMayusculas($row->nombre_estacion);
        $row->array_rfc = array();
        $row->array_rfc[] = '';
        $i = 0;
        foreach (str_split($row->rfc) as $letra){
            $i++;
            if($i == 4){
                $row->array_rfc[] = '-';
            }
            $row->array_rfc[] = $letra;
        }
        $row->nombre_norma = $this->strMayusculas($row->nombre_norma);
        $row->duracion_norma = $this->strMayusculas($row->duracion_norma);
        $fecha = explode('-',$row->fecha_inicio);
        $row->fecha_inicio = str_split($fecha[0].$fecha[1].$fecha[2]);
        $fecha = explode('-',$row->fecha_fin);
        $row->fecha_fin = str_split($fecha[0].$fecha[1].$fecha[2]);
        $row->area_tematica = $this->strMayusculas($row->area_tematica);
        $row->agente_capacitador = $this->strMayusculas($row->agente_capacitador);
        $row->instructor = $this->strMayusculas($row->instructor);
        $row->representante_legal = $this->strMayusculas($row->representante_legal);
        $row->representante_trabajadores = $this->strMayusculas($row->representante_trabajadores);
        return $row;
    }

    private function strMayusculas($str){
        return mb_strtoupper($str,'utf-8');
    }

}

?>