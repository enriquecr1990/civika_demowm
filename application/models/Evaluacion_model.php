<?php

defined('BASEPATH') OR exit('No tiene access al script');

class Evaluacion_model extends CI_Model{

    private $paso_evaluacion;
    private $evaluacion_aprobatoria;
    private $puede_realizar_evaluacion;
    private $etiqueta_evaluacion;

    public function __construct(){
        $this->load->model('DocumentosModel');
        $this->load->model('administrarCTN/InscripcionModel','InscripcionModel');
        $this->load->model('ControlUsuariosModel');
        $this->inicializar_variables_model();
    }

    /**
     * apartado de funciones para obtener informacion
     */
    public function existe_evaluacion_publicacion_ctn_disponible($id_publicacion_ctn,$tipo = 'diagnostica'){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('tipo',$tipo);
        $this->db->where('disponible_alumnos','si');
        $query = $this->db->get('evaluacion_publicacion_ctn');
        if($query->num_rows() == 0){
            return false;
        }return true;
    }

    public function obtener_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo = 'diagnostica'){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('tipo',$tipo);
        $query = $this->db->get('evaluacion_publicacion_ctn');
        if($query->num_rows() == 0){
            $this->insertar_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo);
            return $this->obtener_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo);
        }
        return $query->row();
    }

    public function obtener_evaluacion_calificacion_alumno_publicacion_ctn($id_alumno_inscrito_ctn_publicado,$tipo = false){
        $consulta = "select 
                eapc.*, ctn.tipo,ctn.titulo_evaluacion
            from evaluacion_alumno_publicacion_ctn eapc 
                inner join evaluacion_publicacion_ctn ctn on eapc.id_evaluacion_publicacion_ctn = ctn.id_evaluacion_publicacion_ctn
            where eapc.id_alumno_inscrito_ctn_publicado = $id_alumno_inscrito_ctn_publicado
                and eapc.fecha_envio is not null";
        if($tipo){
            $consulta .= " and ctn.tipo = '$tipo'";
        }
        $query = $this->db->query($consulta);
        $result = $query->result();
        foreach ($result as $r){
            $r->calificacion_evaluacion = $this->calcular_calificacion_evalucion($r->id_evaluacion_alumno_publicacion_ctn,$r->tipo);
            $r->etiqueta_evaluacion = 'danger';
            if($r->calificacion_evaluacion >= 70){
                //$this->paso_evaluacion = true;
                $this->evaluacion_aprobatoria = $r->calificacion_evaluacion;
                $r->etiqueta_evaluacion = 'warning';
            }if($r->calificacion_evaluacion > 85){
                $r->etiqueta_evaluacion = 'info';
            }if($r->calificacion_evaluacion > 95){
                $r->etiqueta_evaluacion = 'success';
            }if($r->calificacion_evaluacion > 95){
                $this->paso_evaluacion = true;
            }
        }
        return $result;
    }

    public function obtener_evaluacion_publicacion_ctn_by_id($id_evaluacion_publicacion_ctn){
        $this->db->where('id_evaluacion_publicacion_ctn',$id_evaluacion_publicacion_ctn);
        $query = $this->db->get('evaluacion_publicacion_ctn');
        return $query->row();
    }

    public function buscar_preguntas_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn){
        $consulta = "select 
                ppc.*,ctop.opcion_pregunta
            from pregunta_publicacion_ctn ppc
                inner join catalogo_tipo_opciones_pregunta ctop on ctop.id_opciones_pregunta = ppc.id_opciones_pregunta
            where ppc.id_evaluacion_publicacion_ctn = $id_evaluacion_publicacion_ctn order by ppc.id_pregunta_publicacion_ctn asc";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach ($result as $r){
            $ordenamiento = true;
            if(in_array($r->id_opciones_pregunta,array(OPCION_SECUENCIAL,OPCION_RELACIONAL))){
                $ordenamiento = false;
            }
            $r->opciones_pregunta_publicacion_ctn = $this->obtener_opciones_pregunta_evaluacion_ctn($r->id_pregunta_publicacion_ctn,$ordenamiento);
            if($r->id_opciones_pregunta == OPCION_RELACIONAL){
                $r->opciones_pregunta_publicacion_ctn_izq = $this->obtener_opciones_pregunta_evaluacion_ctn($r->id_pregunta_publicacion_ctn,$ordenamiento,'izquierda');
                $r->opciones_pregunta_publicacion_ctn_der = $this->obtener_opciones_pregunta_evaluacion_ctn($r->id_pregunta_publicacion_ctn,$ordenamiento,'derecha');
            }
        }
        return $result;
    }

    public function obtener_pregunta_evaluacion_publicacion_ctn($id_pregunta_publicacion_ct){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta_publicacion_ct);
        $query = $this->db->get('pregunta_publicacion_ctn');
        return $query->row();
    }

    public function obtener_opciones_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn,$ordenamiento = false,$pregunta_relacional = false){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta_publicacion_ctn);
        if($pregunta_relacional){
            $this->db->where('pregunta_relacional',$pregunta_relacional);
        }
        if($ordenamiento){
            $this->db->order_by('orden_pregunta','asc');
        }
        $query = $this->db->get('opcion_pregunta_publicacion_ctn');
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach ($result as $r){
            $r->documento_imagen_respuesta = false;
            if(!is_null($r->id_documento)){
                $r->documento_imagen_respuesta = $this->DocumentosModel->obtenerDocumentoById($r->id_documento);
            }
        }
        return $result;
    }

    public function obtener_datos_examen_alumno($id_publicacion_ctn,$id_usuario,$tipo = 'diagnostica')
    {
        $this->inicializar_variables_model();
        $data['alumno'] = $this->ControlUsuariosModel->getDatosAlumnoByIdUsuario($id_usuario);
        $data['alumno_inscrito_ctn_publicado'] = $this->InscripcionModel->obtenerAlumnoInscritoCTNPublicacion($id_publicacion_ctn, $data['alumno']->id_alumno);
        $data['evaluaciones_alumno_publicacion_ctn'] = $this->obtener_evaluacion_calificacion_alumno_publicacion_ctn($data['alumno_inscrito_ctn_publicado']->id_alumno_inscrito_ctn_publicado,$tipo);
        $data['tiene_evaluacion_aprobatoria'] = $this->paso_evaluacion;
        $data['evaluacion_aprobatoria'] = $this->evaluacion_aprobatoria;
        $data['etiqueta_evaluacion'] = 'warning';
        if($this->evaluacion_aprobatoria > 85){
            $data['etiqueta_evaluacion'] = 'info';
        }if($this->evaluacion_aprobatoria > 95){
            $data['etiqueta_evaluacion'] = 'success';
        }
        $data['puede_realizar_evaluacion'] = true;
        if(!$this->paso_evaluacion){
            $data['evaluacion_publicacion_ctn'] = $this->obtener_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo);
            $data['pregunta_publicacion_ctn'] = $this->buscar_preguntas_evaluacion_publicacion_ctn($data['evaluacion_publicacion_ctn']->id_evaluacion_publicacion_ctn);
            if($data['evaluacion_publicacion_ctn']->intentos_evaluacion == sizeof($data['evaluaciones_alumno_publicacion_ctn'])
                && existe_valor($data['evaluacion_publicacion_ctn']->intentos_evaluacion)){
                $data['puede_realizar_evaluacion'] = false;
            }else{
                $data['evaluacion_alumno_publicacion_ctn'] = $this->obtener_evaluacion_alumno_publicacion_ctn($id_publicacion_ctn,$data['alumno']->id_alumno,$data['evaluacion_publicacion_ctn']->id_evaluacion_publicacion_ctn);
            }
        }
        //var_dump($data);exit;
        return $data;
    }

    public function obtener_examen_alumno_lectura($id_evaluacion_alumno_publicacion_ctn){
        $data['evaluacion_alumno_publicacion_ctn'] = $this->obtener_evaluacion_alumno_publicacion_ctn_id($id_evaluacion_alumno_publicacion_ctn);
        $data['evaluacion_publicacion_ctn'] = $this->obtener_evaluacion_publicacion_ctn_by_id($data['evaluacion_alumno_publicacion_ctn']->id_evaluacion_publicacion_ctn);
        $data['pregunta_publicacion_ctn'] = $this->buscar_preguntas_evaluacion_publicacion_ctn($data['evaluacion_publicacion_ctn']->id_evaluacion_publicacion_ctn);
        $data['respuestas_alumno'] = array();
        $respuestas_alumno = $this->obtener_respuestas_alumno_publicacion_ctn($id_evaluacion_alumno_publicacion_ctn);
        $opciones_correctas = 0;
        foreach ($data['pregunta_publicacion_ctn'] as $pregunta) {
            $pregunta->respuestas_alumno = $this->obtener_respuestas_alumno($pregunta->id_pregunta_publicacion_ctn,$id_evaluacion_alumno_publicacion_ctn);
        }
        foreach ($respuestas_alumno as $index => $ra){
            $data['respuestas_alumno'][$ra->id_pregunta_publicacion_ctn]['es_correcta'] = $ra->correctas_alumno == $ra->numero_opciones_correctas;
            $data['respuestas_alumno'][$ra->id_pregunta_publicacion_ctn]['op_seleccionada'] = $ra->id_opcion_pregunta_publicacion_ctn;
            $data['respuestas_alumno'][$ra->id_pregunta_publicacion_ctn]['es_correcta'] ? $opciones_correctas++ : false;
        }
        //datos del usuario por evaluacion
        $data['usuario'] = $this->obtenerUsuarioByEvaluacionAlumno($id_evaluacion_alumno_publicacion_ctn);
        $data['opciones_correctas'] = $opciones_correctas;
        $data['calificacion'] = number_format((($opciones_correctas / sizeof($data['pregunta_publicacion_ctn'])) * 100),2);
        //var_dump($data['pregunta_publicacion_ctn'],$respuestas_alumno);exit;
        return $data;
    }

    public function obtener_respuestas_alumno($id_pregunta,$id_evaluacion_alumno){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta);
        $this->db->where('id_evaluacion_alumno_publicacion_ctn',$id_evaluacion_alumno);
        $query = $this->db->get('respuesta_alumno_evaluacion');
        $result = $query->result();
        $retorno = array();
        foreach ($result as $r){
            $retorno[] = $r->orden_relacion_respuesta != null && $r->orden_relacion_respuesta != '' ? $r->orden_relacion_respuesta : $r->id_opcion_pregunta_publicacion_ctn;
        }
        return $retorno;
    }

    public function obtener_datos_examen_publicacion_alumno($id_publicacion_ctn,$id_alumno,$tipo = 'diagnostica'){
        $this->inicializar_variables_model();
        $alumno_inscrito_ctn_publicado = $this->InscripcionModel->obtenerAlumnoInscritoCTNPublicacion($id_publicacion_ctn, $id_alumno);
        $evaluaciones_alumno = $this->obtener_evaluacion_calificacion_alumno_publicacion_ctn($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado,$tipo);
        $evaluacion_publicacion_ctn = $this->obtener_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo);
        if(sizeof($evaluaciones_alumno) >= $evaluacion_publicacion_ctn->intentos_evaluacion
            && existe_valor($evaluacion_publicacion_ctn->intentos_evaluacion)){
            $this->puede_realizar_evaluacion = false;
        }
        if($this->evaluacion_aprobatoria > 85){
            $this->etiqueta_evaluacion = 'info';
        }if($this->evaluacion_aprobatoria > 95){
            $this->etiqueta_evaluacion = 'success';
        }return $evaluacion_publicacion_ctn;
    }

    public function obtener_evaluaciones_publicacion_alumno($id_publicacion_ctn,$id_alumno){
        $alumno_inscrito_ctn_publicado = $this->InscripcionModel->obtenerAlumnoInscritoCTNPublicacion($id_publicacion_ctn, $id_alumno);
        return $this->obtener_evaluacion_calificacion_alumno_publicacion_ctn($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
    }

    public function obtener_evaluacion_online_ctn($id_publicacion_ctn){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $query  = $this->db->get('evaluacion_online_ctn');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    public function guardar_examen_alumno($post){
        $this->guardar_respuestas_alumno($post);
        return $this->actualizar_evaluacion_alumno_publicacion($post['id_evaluacion_alumno_publicacion_ctn'],array('fecha_envio' => todayBD()));
    }

    public function calcular_calificacion_evalucion($id_evaluacion_alumno_publicacion_ctn,$tipo = 'diagnostica'){
        $respuestas_correctas_incorrectas_alumno = $this->obtener_respuestas_alumno_publicacion_ctn($id_evaluacion_alumno_publicacion_ctn);
        $numero_preguntas_evaluacion_publicacion_ctn = $this->obtener_numero_preguntas_evaluacion_publicacion($id_evaluacion_alumno_publicacion_ctn,$tipo);
        $preguntas_correctas = 0;
        foreach ($respuestas_correctas_incorrectas_alumno as $pregunta){
            $pregunta->correctas_alumno == $pregunta->numero_opciones_correctas && $pregunta->incorrectas_alumno == 0 ? $preguntas_correctas++ : false;
            //if($pregunta->correctas_alumno == $pregunta->numero_opciones_correctas){
            //    $preguntas_correctas++;
            //}
        }
        $calificacion = ($preguntas_correctas / $numero_preguntas_evaluacion_publicacion_ctn) * 100;
        //var_dump($respuestas_correctas_incorrectas_alumno,$calificacion);exit;
        return number_format($calificacion,2);
    }

    public function guardar_evaluacion_online_link($post){
        $evaluacion_online_ctn = $this->obtener_evaluacion_online_ctn($post['id_publicacion_ctn']);
        if($evaluacion_online_ctn){
            return $this->actualizar_evaluacion_online_ctn($evaluacion_online_ctn->id_evaluacion_online_ctn,$post);
        }else{
            return $this->insertar_evaluacion_online_ctn($post);
        }
    }

    public function aceptar_descarga_vademecum($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        return $this->db->update('alumno_inscrito_ctn_publicado',array('descargo_vademecum' => 'si'));
    }


    /**
     * getters and setters
     */
    public function isPasoEvaluacion()
    {
        return $this->paso_evaluacion;
    }

    public function getEvaluacionAprobatoria()
    {
        return $this->evaluacion_aprobatoria;
    }

    public function isPuedeRealizarEvaluacion()
    {
        return $this->puede_realizar_evaluacion;
    }

    public function getEtiquetaEvaluacion()
    {
        return $this->etiqueta_evaluacion;
    }

    /**
     * apartado de funciones para guardar informacion
     */
    public function guardar_pregunta_opciones_evaluacion_ctn($post){
        $retorno = false;
        switch ($post['pregunta_publicacion_ctn']['id_opciones_pregunta']){
            case OPCION_VERDADERO_FALSO:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_vf($post);
                break;
            case OPCION_UNICA_OPCION:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_up($post);
                break;
            case OPCION_OPCION_MULTIPLE:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_om($post);
                break;
            case OPCION_IMAGEN_UNICA_OPCION:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_imagen_uo($post);
                break;
            case OPCION_IMAGEN_OPCION_MULTIPLE:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_imagen_om($post);
                break;
            case OPCION_SECUENCIAL:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_secuencial($post);
                break;
            case OPCION_RELACIONAL:
                $retorno = $this->guardar_publicacion_pregunta_respuesta_relacional($post);
                break;
        }
        return $retorno;
    }

    public function publicar_evaluacion($id_evaluacion_publicacion_ctn){
        $update = array(
            'disponible_alumnos' => 'si',
            'fecha_publicacion_alumno' => todayBD()
        );
        return $this->actualizar_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn,$update);
    }

    /**
     * apartado de funciones para eliminar informacion
     */
    public function eliminar_pregunta_pregunta_evaluacion_ctn($id_pregunta_publicacion_ctn){
        $this->eliminar_opciones_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn);
        return $this->eliminar_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn);
    }

    /**
     * apartado de funciones privadas
     */
    private function inicializar_variables_model(){
        $this->paso_evaluacion = false;
        $this->evaluacion_aprobatoria = 0;
        $this->puede_realizar_evaluacion = true;
        $this->etiqueta_evaluacion = 'warning';
    }

    private function obtener_evaluacion_alumno_publicacion_ctn($id_publicacion_ctn,$id_alumno,$id_evaluacion_publicacion_ctn){
        $alumno_inscrito_ctn_publicado = $this->obtener_alumno_inscrito_ctn_publicado($id_publicacion_ctn,$id_alumno);
        $evaluacion_alumno_publicacion_ctn = $this->obtener_evaluacion_alumno($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
        if($evaluacion_alumno_publicacion_ctn === false){
            $this->insertar_evaluacion_alumno_publicacion($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado,$id_evaluacion_publicacion_ctn);
            $evaluacion_alumno_publicacion_ctn = $this->obtener_evaluacion_alumno($alumno_inscrito_ctn_publicado->id_alumno_inscrito_ctn_publicado);
        }
        return $evaluacion_alumno_publicacion_ctn;
    }

    private function obtener_evaluacion_alumno_publicacion_ctn_id($id_evaluacion_alumno_publicacion_ctn){
        $this->db->where('id_evaluacion_alumno_publicacion_ctn',$id_evaluacion_alumno_publicacion_ctn);
        $query = $this->db->get('evaluacion_alumno_publicacion_ctn');
        return $query->row();
    }

    private function obtener_respuestas_alumno_publicacion_ctn($id_evaluacion_alumno_publicacion_ctn){
        $consulta = "select 
                      rae.id_respuesta_alumno_evaluacion, rae.id_opcion_pregunta_publicacion_ctn,
                      ppc.id_pregunta_publicacion_ctn, ppc.id_evaluacion_publicacion_ctn, ppc.id_opciones_pregunta,
                      sum(
                            if(
                                if(
                                    ppc.id_opciones_pregunta in(".OPCION_SECUENCIAL.",".OPCION_RELACIONAL."),
                                    if(oppc.orden_pregunta = rae.orden_relacion_respuesta,'correcta','incorrecta'),
                                    oppc.tipo_respuesta 
                                ) = 'correcta',1,0
                            )
                      ) correctas_alumno,
                      sum(
                            if(
                                if(
                                    ppc.id_opciones_pregunta in(".OPCION_SECUENCIAL.",".OPCION_RELACIONAL."),
                                    if(oppc.orden_pregunta = rae.orden_relacion_respuesta,'correcta','incorrecta'),
                                    oppc.tipo_respuesta 
                                ) = 'incorrecta',1,0
                            )
                      ) incorrectas_alumno,
                      (
                        select 
                            if(ppc.id_opciones_pregunta <> ".OPCION_RELACIONAL.",count(op.id_opcion_pregunta_publicacion_ctn), count(op.id_opcion_pregunta_publicacion_ctn))
                        from opcion_pregunta_publicacion_ctn op where op.id_pregunta_publicacion_ctn = ppc.id_pregunta_publicacion_ctn
                            and op.tipo_respuesta='correcta' 
                      ) numero_opciones_correctas
                    from respuesta_alumno_evaluacion rae
                      inner join opcion_pregunta_publicacion_ctn oppc on oppc.id_opcion_pregunta_publicacion_ctn = rae.id_opcion_pregunta_publicacion_ctn
                      inner join pregunta_publicacion_ctn ppc on ppc.id_pregunta_publicacion_ctn = oppc.id_pregunta_publicacion_ctn
                    where rae.id_evaluacion_alumno_publicacion_ctn = $id_evaluacion_alumno_publicacion_ctn
                    group by ppc.id_pregunta_publicacion_ctn
                    order by rae.id_respuesta_alumno_evaluacion asc;";
        $query = $this->db->query($consulta);
        //echo $consulta;
        return $query->result();
    }

    private function obtener_numero_preguntas_evaluacion_publicacion($id_evaluacion_alumno_publicacion_ctn,$tipo){
        $consulta = "select 
              count(ppc.id_pregunta_publicacion_ctn) numero_preguntas_evaluacion
            from evaluacion_alumno_publicacion_ctn eapc
              inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno_inscrito_ctn_publicado = eapc.id_alumno_inscrito_ctn_publicado
              inner join evaluacion_publicacion_ctn epc on epc.id_publicacion_ctn = aicp.id_publicacion_ctn
              inner join pregunta_publicacion_ctn ppc on ppc.id_evaluacion_publicacion_ctn = epc.id_evaluacion_publicacion_ctn
            where eapc.id_evaluacion_alumno_publicacion_ctn = $id_evaluacion_alumno_publicacion_ctn
              and epc.tipo = '$tipo'
            group by eapc.id_evaluacion_alumno_publicacion_ctn;";
        $query = $this->db->query($consulta);
        return $query->row()->numero_preguntas_evaluacion;
    }

    private function obtener_alumno_inscrito_ctn_publicado($id_publicacion_ctn,$id_alumno){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('id_alumno',$id_alumno);
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        return $query->row();
    }

    private function obtener_evaluacion_alumno($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        $this->db->where('fecha_envio',null);
        $query = $this->db->get('evaluacion_alumno_publicacion_ctn');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    private function obtenerUsuarioByEvaluacionAlumno($id_evaluacion_publicacion_ctn){
        $consulta = "select 
                u.* 
            from alumno a 
                inner join alumno_inscrito_ctn_publicado aicp on aicp.id_alumno = a.id_alumno 
                inner join evaluacion_alumno_publicacion_ctn eapc on eapc.id_alumno_inscrito_ctn_publicado = aicp.id_alumno_inscrito_ctn_publicado 
                inner join usuario u on u.id_usuario = a.id_usuario
            where eapc.id_evaluacion_alumno_publicacion_ctn = $id_evaluacion_publicacion_ctn limit 1";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    private function guardar_publicacion_pregunta_respuesta_vf($post){
        if(isset($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn']) && $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'] != ''){
            $this->actualizar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'],$post['pregunta_publicacion_ctn']);
            $id_pregunta_publicacion_ctn = $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'];
        }else{
            $id_pregunta_publicacion_ctn = $this->insertar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']);
        }
        //actualizar las opciones
        $this->eliminar_opciones_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn);
        foreach ($post['opcion_pregunta_publicacion_ctn'] as $op){
            $op['id_pregunta_publicacion_ctn'] = $id_pregunta_publicacion_ctn;
            $this->insertar_opcion_pregunta_publicacion_ctn($op);
        }return true;
    }

    private function guardar_publicacion_pregunta_respuesta_up($post){
        //se guarda igual que en la preguntas respuestas de VF
        return $this->guardar_publicacion_pregunta_respuesta_vf($post);
    }

    private function guardar_publicacion_pregunta_respuesta_om($post){
        //se guarda igual que en la preguntas respuestas de VF
        return $this->guardar_publicacion_pregunta_respuesta_vf($post);
    }

    private function guardar_publicacion_pregunta_respuesta_imagen_uo($post){
        //se guarda igual que en la preguntas respuestas de VF
        return $this->guardar_publicacion_pregunta_respuesta_vf($post);
    }

    private function guardar_publicacion_pregunta_respuesta_imagen_om($post){
        //se guarda igual que en la preguntas respuestas de VF
        return $this->guardar_publicacion_pregunta_respuesta_vf($post);
    }

    private function guardar_publicacion_pregunta_respuesta_secuencial($post){
        if(isset($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn']) && $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'] != ''){
            $this->actualizar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'],$post['pregunta_publicacion_ctn']);
            $id_pregunta_publicacion_ctn = $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'];
        }else{
            $id_pregunta_publicacion_ctn = $this->insertar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']);
        }
        //actualizar las opciones
        $this->eliminar_opciones_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn);
        foreach ($post['opcion_pregunta_publicacion_ctn'] as $index => $op){
            $op['id_pregunta_publicacion_ctn'] = $id_pregunta_publicacion_ctn;
            $op['consecutivo'] = $index + 1;
            $op['tipo_respuesta'] = 'correcta';
            $this->insertar_opcion_pregunta_publicacion_ctn($op);
        }return true;
    }

    private function guardar_publicacion_pregunta_respuesta_relacional($post){
        if(isset($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn']) && $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'] != ''){
            $this->actualizar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'],$post['pregunta_publicacion_ctn']);
            $id_pregunta_publicacion_ctn = $post['pregunta_publicacion_ctn']['id_pregunta_publicacion_ctn'];
        }else{
            $id_pregunta_publicacion_ctn = $this->insertar_pregunta_publicacion_ctn($post['pregunta_publicacion_ctn']);
        }
        //actualizar las opciones
        $this->eliminar_opciones_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn);
        //insertar preguntas de lado izquierdo
        $index = 1;
        foreach ($post['opcion_pregunta_publicacion_ctn']['izquierda'] as $op){
            $op['id_pregunta_publicacion_ctn'] = $id_pregunta_publicacion_ctn;
            $op['consecutivo'] = $index;
            $op['tipo_respuesta'] = 'correcta';
            $op['pregunta_relacional'] = 'izquierda';
            $this->insertar_opcion_pregunta_publicacion_ctn($op);
            $index++;
        }
        //insertar preguntas de lado izquierdo
        $index = 1;
        foreach ($post['opcion_pregunta_publicacion_ctn']['derecha'] as $op){
            $op['id_pregunta_publicacion_ctn'] = $id_pregunta_publicacion_ctn;
            $op['consecutivo'] = $index + 1;
            $op['tipo_respuesta'] = null;
            $op['pregunta_relacional'] = 'derecha';
            $this->insertar_opcion_pregunta_publicacion_ctn($op);
            $index++;
        }
        //insertar preguntas de lado derecho
        return true;
    }

    private function guardar_respuestas_alumno($post){
        //hay que eliminar las posibles respuestas que hayan existido previamente
        $this->eliminar_respuestas_alumno_previas($post['id_evaluacion_alumno_publicacion_ctn']);
        $insert_respuesta = array(
            'id_evaluacion_publicacion_ctn' => $post['id_evaluacion_publicacion_ctn'],
            'id_evaluacion_alumno_publicacion_ctn' => $post['id_evaluacion_alumno_publicacion_ctn']
        );
        if(isset($post['pregunta']) && is_array($post['pregunta']) && sizeof($post['pregunta']) != 0){
            foreach ($post['pregunta'] as $id_pregunta => $tipo_respuesta){
                foreach ($tipo_respuesta as $tipo => $respuestas){
                    foreach ($respuestas as $index => $r){
                        $insert_respuesta['id_pregunta_publicacion_ctn'] = $id_pregunta;
                        if(in_array($tipo,array('respuesta_secuencial','respuesta_relacional'))){
                            $insert_respuesta['id_opcion_pregunta_publicacion_ctn'] = $index;
                            $insert_respuesta['orden_relacion_respuesta'] = $r;
                        }else{
                            $insert_respuesta['id_opcion_pregunta_publicacion_ctn'] = $r;
                        }
                        $this->insertar_respuesta_alumno_evaluacion($insert_respuesta);
                    }
                }
            }
        }return true;
    }

    private function insertar_evaluacion_publicacion_ctn($id_publicacion_ctn,$tipo){
        $insert['fecha_creacion'] = todayBD();
        $insert['id_publicacion_ctn'] = $id_publicacion_ctn;
        $insert['tipo'] = $tipo;
        return $this->db->insert('evaluacion_publicacion_ctn',$insert);
    }

    private function insertar_pregunta_publicacion_ctn($insert){
        $this->db->insert('pregunta_publicacion_ctn',$insert);
        return $this->db->insert_id();
    }

    private function insertar_opcion_pregunta_publicacion_ctn($insert){
        $this->db->insert('opcion_pregunta_publicacion_ctn',$insert);
        return $this->db->insert_id();
    }

    private function insertar_evaluacion_alumno_publicacion($id_alumno_inscrito_ctn_publicado,$id_evaluacion_publicacion_ctn){
        $insert = array(
            'id_alumno_inscrito_ctn_publicado' => $id_alumno_inscrito_ctn_publicado,
            'id_evaluacion_publicacion_ctn' => $id_evaluacion_publicacion_ctn,
            'fecha_inicio' => todayBD()
        );
        $this->db->insert('evaluacion_alumno_publicacion_ctn',$insert);
        return $this->db->insert_id();
    }

    private function insertar_respuesta_alumno_evaluacion($insert){
        $this->db->insert('respuesta_alumno_evaluacion',$insert);
        return $this->db->insert_id();
    }

    private function insertar_evaluacion_online_ctn($insert){
        return $this->db->insert('evaluacion_online_ctn',$insert);
    }

    private function actualizar_evaluacion_publicacion_ctn($id_evaluacion_publicacion_ctn,$update){
        $this->db->where('id_evaluacion_publicacion_ctn',$id_evaluacion_publicacion_ctn);
        return $this->db->update('evaluacion_publicacion_ctn',$update);
    }

    private function actualizar_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn,$update){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta_publicacion_ctn);
        return $this->db->update('pregunta_publicacion_ctn',$update);
    }

    private function actualizar_evaluacion_alumno_publicacion($id_evaluacion_alumno_publicacion_ctn,$update){
        $this->db->where('id_evaluacion_alumno_publicacion_ctn',$id_evaluacion_alumno_publicacion_ctn);
        return $this->db->update('evaluacion_alumno_publicacion_ctn',$update);
    }

    private function actualizar_evaluacion_online_ctn($id_evaluacion_online_ctn,$update){
        $this->db->where('id_evaluacion_online_ctn',$id_evaluacion_online_ctn);
        return $this->db->update('evaluacion_online_ctn',$update);
    }

    private function eliminar_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta_publicacion_ctn);
        return $this->db->delete('pregunta_publicacion_ctn');
    }

    private function eliminar_opciones_pregunta_publicacion_ctn($id_pregunta_publicacion_ctn){
        $this->db->where('id_pregunta_publicacion_ctn',$id_pregunta_publicacion_ctn);
        return $this->db->delete('opcion_pregunta_publicacion_ctn');
    }

    private function eliminar_respuestas_alumno_previas($id_evaluacion_alumno_publicacion_ctn){
        $this->db->where('id_evaluacion_alumno_publicacion_ctn',$id_evaluacion_alumno_publicacion_ctn);
        return $this->db->delete('respuesta_alumno_evaluacion');
    }

}

?>