<?php

defined('BASEPATH') OR exit('No tiene access al script');

class InscripcionModel extends CI_Model{

    function __construct(){
        $this->load->model('ControlUsuariosModel');
        $this->load->model('DocumentosModel');
        $this->load->model('DocumentosPDFModel');
        $this->load->model('NotificacionesModel');
    }

    /**
     * metodos publicos para las inscripciones model
     */
    public function alumnoProcesoInscripcion($idPublicacion,$idAlumno){
        return $this->obtenerAlumnoInscritoCTNPublicacion($idPublicacion,$idAlumno);
    }

    public function obtenerAlumnoInscritoCTNPublicacion($idPublicacionCTN,$idAlumno){
        $this->db->where('id_publicacion_ctn',$idPublicacionCTN);
        $this->db->where('id_alumno',$idAlumno);
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        if($query->num_rows() == 0){
            $insert = array(
                'fecha_actualizacion_datos' => date('Y-m-d H:i:s'),
                'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_ACTUALIZACION_DATOS,
                'id_alumno' => $idAlumno,
                'id_publicacion_ctn' => $idPublicacionCTN
            );
            $this->insertarAlumnoInscritoCTNPublicacion($insert);
            return $this->obtenerAlumnoInscritoCTNPublicacion($idPublicacionCTN,$idAlumno);
        }else{
            $row = $query->row();
            if(isset($row->id_documento) && !is_null($row->id_documento)){
                $row->documento_recibo_pago = $this->DocumentosModel->obtenerDocumentoById($row->id_documento);
            }
            return $row;
        }
    }

    public function guardarUsuarioAlumnoDatosPersonales($form_post){
        $this->ControlUsuariosModel->guardarUsuarioAlumnoDatosPersonales($form_post);
        $update_alumno_inscrito = array(
            'fecha_actualizacion_datos' => date('Y-m-d H:i:s')
        );
        return $this->actualizarAlumnoInscritoCTNPublicacion($form_post['alumno_inscrito_ctn_publicado']['id_alumno_inscrito_ctn_publicado'],$update_alumno_inscrito);
    }

    public function guardarUsuarioAlumnoDatosEmpresa($form_post){
        $this->ControlUsuariosModel->actualizarAlumnoByIdUsuario($form_post['usuario']['id_usuario'],$form_post['usuario_alumno']);
        $this->ControlUsuariosModel->guardarUsuarioAlumnoDatosEmpresa($form_post);
        $update_alumno_inscrito = array(
            'fecha_preinscripcion' => date('Y-m-d H:i:s')
        );
        return $this->actualizarAlumnoInscritoCTNPublicacion($form_post['id_alumno_inscrito_ctn_publicado'],$update_alumno_inscrito);
    }

    public function guardar_registro_pago($post){
        $this->BitacoraModel->bitacora_datos_registro_pago($post['usuario']['id_usuario'],$post);
        $post['alumno_inscrito_ctn_publicado']['fecha_pago_registrado'] = date('Y-m-d H:i:s');
        $this->actualizarAlumnoInscritoCTNPublicacion($post['alumno_inscrito_ctn_publicado']['id_alumno_inscrito_ctn_publicado'],$post['alumno_inscrito_ctn_publicado']);
        if(isset($post['uso_cfdi_fisica']) && $post['uso_cfdi_fisica'] != ''){
            $post['datos_fiscales']['id_catalogo_uso_cfdi'] = $post['uso_cfdi_fisica'];
        }if(isset($post['uso_cfdi_moral']) && $post['uso_cfdi_moral'] != ''){
            $post['datos_fiscales']['id_catalogo_uso_cfdi'] = $post['uso_cfdi_moral'];
        }
        $this->guardarDatosFiscalesAlumnoInscritoPublicacion($post['datos_fiscales']);
        return true;
    }

    public function enviar_recibo_validacion_civik_alumno($id_alumno_inscrito_ctn_publicado){
        $documento_dc3 = $this->DocumentosPDFModel->datos_alumno($id_alumno_inscrito_ctn_publicado,true);
        $update_inscripcion = array(
            'fecha_pago_registrado' => date('Y-m-d H:i:s'),
            'fecha_preinscripcion' => date('Y-m-d H:i:s'),
            'envio_datos_dc3' => 'si',
            'fecha_envio_datos_dc3' => date('Y-m-d H:i:s'),
            'id_documento_dc3' => $documento_dc3->id_documento,
            'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_EN_VALIDACION
        );
        return $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn_publicado,$update_inscripcion);
    }

    public function enviar_recibo_validacion_civik_alumno_sin_dc3($id_alumno_inscrito_ctn_publicado){
        $update_inscripcion = array(
            'fecha_pago_registrado' => date('Y-m-d H:i:s'),
            'fecha_preinscripcion' => date('Y-m-d H:i:s'),
            'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_EN_VALIDACION
        );
        return $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn_publicado,$update_inscripcion);
    }

    public function concluir_registro_dc3($id_alumno_inscrito_ctn_publicado){
        $documento_dc3 = $this->DocumentosPDFModel->datos_alumno($id_alumno_inscrito_ctn_publicado,true);
        $update_inscripcion = array(
            'envio_datos_dc3' => 'si',
            'fecha_envio_datos_dc3' => date('Y-m-d H:i:s'),
            'id_documento_dc3' => $documento_dc3->id_documento,
            'id_catalogo_proceso_inscripcion' => $this->obtener_estatus_update_inscripcion($id_alumno_inscrito_ctn_publicado)
        );
        $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn_publicado,$update_inscripcion);
        $this->proceso_inscripcion_evaluacion_online($id_alumno_inscrito_ctn_publicado);
        return $documento_dc3;
    }

    public function concluir_registro_alumno_pago_online($id_alumno_inscrito_ctn){
        $return['exito'] = true;
        $documento_dc3 = $this->DocumentosPDFModel->datos_alumno($id_alumno_inscrito_ctn,true);
        $return['documento_dc3'] = $documento_dc3;
        $update_inscripcion = array(
            'envio_datos_dc3' => 'si',
            'fecha_envio_datos_dc3' => date('Y-m-d H:i:s'),
            'id_documento_dc3' => $documento_dc3->id_documento,
            'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_FINALIZADO_INSCRITO
        );
        $alumno_inscrito_ctn_publicado = $this->obtenerAlumnoInscritoCTNPublicado($id_alumno_inscrito_ctn);
        $publicacion_ctn = $this->obtener_publicacion_ctn($alumno_inscrito_ctn_publicado->id_publicacion_ctn);
        $capacidad_publicacion_ctn = $this->obtenerCapacidadAlumnosCTNPublicacion($publicacion_ctn->id_publicacion_ctn,$publicacion_ctn->id_catalogo_tipo_publicacion);
        if($capacidad_publicacion_ctn->alumnos_inscritos < $capacidad_publicacion_ctn->total_alumno_soportados){
            $instructor_para_asignar = $this->obtenerInstructorParaAsignar($alumno_inscrito_ctn_publicado->id_publicacion_ctn);
            $return['instructur_asignado'] = $instructor_para_asignar->nombre.' '.$instructor_para_asignar->apellido_p.' '.$instructor_para_asignar->apellido_m;
            $update_inscripcion['fecha_pago_validado'] = date('Y-m-d H:i:s');
            $update_inscripcion['id_instructor_asignado_curso_publicado'] = $instructor_para_asignar->id_instructor_asignado_curso_publicado;
            if($publicacion_ctn->id_catalogo_tipo_publicacion == CURSO_EVALUACION_ONLINE){
                $update_inscripcion['asistio'] = 'si';
                $update_inscripcion['semaforo_asistencia'] = 'asiste';
            }
            $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn,$update_inscripcion);
        }else{
            $return['exito'] = false;
            $return['msg'] = 'Se lleno la capacidad máxima soportada para la curso seleccionado, el cupo de alumnos esta completo';
            $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn,array('id_catalogo_proceso_inscripcion' => PROCESO_PAGO_FINALIZADO_CUPO_LLENO));
        }
        return $return;
    }


    public function validarObservarComprobantePagoAlumno($post){
        $return['exito'] = true;
        if($post['cumple_comprobante'] == 'si'){
            return $this->concluir_inscripcion_alumno_publicacion_ctn($post['id_alumno_inscrito_ctn_publicado'],$post);
        }else{
            $post['fecha_pago_observado'] = date('Y-m-d H:i:s');
            $post['id_catalogo_proceso_inscripcion'] = PROCESO_PAGO_OBSERVADO;
            $this->actualizarAlumnoInscritoCTNPublicacion($post['id_alumno_inscrito_ctn_publicado'],$post);
        }
        return $return;
    }

    public function registrar_nuevo_alumno_ctn_publicado($post){
        $id_usuario = $this->insertar_usuario_alumno_ctn_publicado($post['usuario']);
        $id_alumno = $this->insertar_alumno_ctn_publicado($id_usuario,$post['alumno']);
        $this->insertar_alumno_alumno_inscrito_ctn_publicado($id_alumno,$post['id_publicacion_ctn']);
        $this->insertar_empresa_alumno_ctn_publicado($id_alumno,$post['empresa']);
        return true;
    }

    public function registrar_alumno_existente_ctn_publicado($post){
        try{
            $alumno = $this->obtener_alumno_sistema($post['id_usuario']);
            $this->insertar_alumno_alumno_inscrito_ctn_publicado($alumno->id_alumno,$post['id_publicacion_ctn']);
            return true;
        }catch (Exception $ex){
            return false;
        }
    }

    public function semaforo_alumno_confirmacion($post){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$post['id_alumno_inscrito_ctn_publicado']);
        return $this->db->update('alumno_inscrito_ctn_publicado',$post);
    }

    public function validar_rfc_empresa_publicacion_ctn($post){
        $this->db->where('id_publicacion_ctn',$post['id_publicacion_ctn']);
        $this->db->where('rfc',$post['rfc']);
        $query = $this->db->get('publicacion_ctn_has_empresa_masivo');
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    public function guardar_empleados_publiacion_ctn_masivo($post,$es_envio_final = false){
        //echo '<pre>';print_r($post);exit;
        if(isset($post['empleados']) && is_array($post['empleados']) && sizeof($post['empleados']) != 0){
            $instructor_para_asignar = $this->obtenerInstructorParaAsignar($post['id_publicacion_ctn']);
            $his = date('His');
            foreach ($post['empleados'] as $empleado){
                if(isset($empleado['id_usuario']) && $empleado['id_usuario'] != 0){
                    $this->guadar_empleado_actualizar_inscripcion_masiva($post,$empleado);
                }else{
                    $this->guardar_empleado_nuevo_inscripcion_masiva($post,$empleado,$instructor_para_asignar,$his);
                    $his++;
                }
            }

            if($es_envio_final){
                $this->db->where('id_publicacion_ctn',$post['id_publicacion_ctn']);
                $this->db->update('publicacion_ctn_has_empresa_masivo',array('fecha_envio_informacion' => todayBD()));
            }
            //para la actualizacion del banner de la publicacion para el logo de la empresa
            if(isset($post['publicacion_has_doc_banner']['banner'])){
                $this->db->where('id_publicacion_ctn',$post['id_publicacion_ctn']);
                $this->db->where('tipo','logo_empresa');
                $this->db->update('publicacion_has_doc_banner',$post['publicacion_has_doc_banner']['banner']);
            }
            return true;
        }return false;
    }

    public function baja_suscripcion_mail($email){
        $this->db->where('correo',$email);
        return $this->db->update('usuario',array('suscripcion_correo' => 'no'));
    }

    /**
     * apartado de funciones para eliminar informacion
     */
    public function eliminar_alumno_inscrito_ctn_publicado($id_usuario){
        $this->db->where('id_usuario',$id_usuario);
        $query = $this->db->get('alumno');
        $alumno = $query->row();
        $this->db->where('id_alumno',$alumno->id_alumno);
        $this->db->delete('alumno_inscrito_ctn_publicado');
        $this->db->where('id_alumno',$alumno->id_alumno);
        $this->db->delete('empresa_alumno');
        $this->db->where('id_usuario',$id_usuario);
        $this->db->delete('alumno');
        $this->db->where('id_usuario',$id_usuario);
        return $this->db->delete('usuario');
    }

    /**
     * apartado de funciones privadas al modelo de inscripciones
     */

    private function concluir_inscripcion_alumno_publicacion_ctn($id_alumno_inscrito_ctn_publicado,$post){
        $return['exito'] = true;
        $alumno_inscrito_ctn_publicado = $this->obtenerAlumnoInscritoCTNPublicado($id_alumno_inscrito_ctn_publicado);
        $capacidad_publicacion_ctn = $this->obtenerCapacidadAlumnosCTNPublicacion($alumno_inscrito_ctn_publicado->id_publicacion_ctn);
        if($capacidad_publicacion_ctn->alumnos_inscritos < $capacidad_publicacion_ctn->total_alumno_soportados){
            $instructor_para_asignar = $this->obtenerInstructorParaAsignar($alumno_inscrito_ctn_publicado->id_publicacion_ctn);
            $return['instructur_asignado'] = $instructor_para_asignar->nombre.' '.$instructor_para_asignar->apellido_p.' '.$instructor_para_asignar->apellido_m;
            $post['fecha_pago_validado'] = date('Y-m-d H:i:s');
            $post['id_catalogo_proceso_inscripcion'] = PROCESO_PAGO_FINALIZADO_INSCRITO;
            $post['id_instructor_asignado_curso_publicado'] = $instructor_para_asignar->id_instructor_asignado_curso_publicado;
            $this->actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn_publicado,$post);
        }else{
            $return['exito'] = false;
            $return['msg'] = 'Se lleno la capacidad máxima soportada para la publicación, el cupo de alumnos esta completo';
        }
        return $return;
    }

    private function proceso_inscripcion_evaluacion_online($id_alumno_inscrito_ctn_publicado){
        $alumno_inscrito_ctn_publicado = $this->obtenerAlumnoInscritoCTNPublicado($id_alumno_inscrito_ctn_publicado);
        $publicacion_evaluacion_online_empresa = $this->obtener_publicacion_evaluacion_online_empresa($alumno_inscrito_ctn_publicado->id_publicacion_ctn);
        if($publicacion_evaluacion_online_empresa){
            $post['cumple_comprobante'] = 'si';
            $post['asistio'] = 'si';
            return $this->concluir_inscripcion_alumno_publicacion_ctn($id_alumno_inscrito_ctn_publicado,$post);
        }return true;
    }

    private function guardar_empleado_nuevo_inscripcion_masiva($post,$empleado,$instructor_para_asignar,$his){
        $today = todayBD();
        //se opto por insertar el usuario por el curp primero diez caracteres mas el $his que llega a la funcion
        $insert_usuario = array(
            'usuario' => substr($empleado['curp'],0,10).$his,
            'password' => '30e75439d9abe3fdb891cf3b88fa1f8c2c4ef63d',
            'nombre' => $empleado['nombre'],
            'apellido_p' => $empleado['apellido_p'],
            'apellido_m' => $empleado['apellido_m'],
            'correo' => $post['empresa_alumno']['correo'],
            'telefono' => $post['empresa_alumno']['telefono'],
        );

        $this->db->insert('usuario',$insert_usuario);
        $id_usuario = $this->db->insert_id();
        $insert_alumno = array(
            'curp' => $empleado['curp'],
            'puesto' => $empleado['puesto'],
            'id_usuario' => $id_usuario,
            'id_catalogo_ocupacion_especifica' => $empleado['id_catalogo_ocupacion_especifica']
        );

        $this->db->insert('alumno',$insert_alumno);
        $id_alumno = $this->db->insert_id();

        $insert_alumno_inscrito_ctn_publicado = array(
            'fecha_actualizacion_datos' => $today,
            'fecha_preinscripcion' => $today,
            'fecha_pago_registrado' => $today,
            'fecha_pago_validado' => $today,
            'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_FINALIZADO_INSCRITO,
            'id_alumno' => $id_alumno,
            'id_publicacion_ctn' => $post['id_publicacion_ctn'],
            'id_instructor_asignado_curso_publicado' => $instructor_para_asignar->id_instructor_asignado_curso_publicado
        );
        $this->db->insert('alumno_inscrito_ctn_publicado',$insert_alumno_inscrito_ctn_publicado);
        $insert_empresa_alumno = array(
            'nombre' => $post['empresa_alumno']['nombre'],
            'rfc' => $post['empresa_alumno']['rfc'],
            'domicilio' => $post['empresa_alumno']['domicilio'],
            'telefono' => $post['empresa_alumno']['telefono'],
            'correo' => $post['empresa_alumno']['correo'],
            'representante_legal' => $post['empresa_alumno']['representante_legal'],
            'representante_trabajadores' => $post['empresa_alumno']['representante_trabajadores'],
            'id_alumno' => $id_alumno
        );
        $this->db->insert('empresa_alumno',$insert_empresa_alumno);
        return true;
    }

    private function guadar_empleado_actualizar_inscripcion_masiva($post,$empleado){
        $insert_usuario = array(
            'nombre' => $empleado['nombre'],
            'apellido_p' => $empleado['apellido_p'],
            'apellido_m' => $empleado['apellido_m'],
            'correo' => $post['empresa_alumno']['correo'],
            'telefono' => $post['empresa_alumno']['telefono'],
        );

        $this->db->where('id_usuario',$empleado['id_usuario']);
        $this->db->update('usuario',$insert_usuario);
        $id_usuario = $empleado['id_usuario'];

        $insert_alumno = array(
            'curp' => $empleado['curp'],
            'puesto' => $empleado['puesto'],
            'id_usuario' => $id_usuario,
            'id_catalogo_ocupacion_especifica' => isset($empleado['id_catalogo_ocupacion_especifica']) && $empleado['id_catalogo_ocupacion_especifica'] != '' ? $empleado['id_catalogo_ocupacion_especifica'] : null
        );

        $this->db->where('id_usuario',$id_usuario);
        $this->db->update('alumno',$insert_alumno);
        $id_alumno = $empleado['id_alumno'];

        $insert_empresa_alumno = array(
            'nombre' => $post['empresa_alumno']['nombre'],
            'rfc' => $post['empresa_alumno']['rfc'],
            'domicilio' => $post['empresa_alumno']['domicilio'],
            'telefono' => $post['empresa_alumno']['telefono'],
            'correo' => $post['empresa_alumno']['correo'],
            'representante_legal' => $post['empresa_alumno']['representante_legal'],
            'representante_trabajadores' => $post['empresa_alumno']['representante_trabajadores'],
        );
        $this->db->where('id_alumno',$id_alumno);
        $this->db->update('empresa_alumno',$insert_empresa_alumno);
        return true;
    }

    private function guardarDatosFiscalesAlumnoInscritoPublicacion($post_datos_fiscales){
        $datos_fiscales = $this->obtenerDatosFiscalesByAlumnoIncritoPublicacion($post_datos_fiscales['id_alumno_inscrito_ctn_publicado']);
        if(!$datos_fiscales){
            $this->insertarAlumnoDatosFiscales($post_datos_fiscales);
        }else{
            $this->actualizarAlumnoDatosFiscales($datos_fiscales->id_datos_fiscales,$post_datos_fiscales);
        }return true;
    }

    //funciones de obtener informacion
    private function obtenerDatosFiscalesByAlumnoIncritoPublicacion($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        $query = $this->db->get('datos_fiscales');
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    private function obtenerCapacidadAlumnosCTNPublicacion($idPublicacionCTN,$id_catalogo_tipo_curso = CURSO_PRESENCIAL){
        if($id_catalogo_tipo_curso == CURSO_PRESENCIAL){
            $consulta = "select 
              sum(ca.cupo) total_alumno_soportados,
              count(aicp.id_alumno_inscrito_ctn_publicado) alumnos_inscritos
            from publicacion_ctn pc
              inner join instructor_asignado_curso_publicado iacp on iacp.id_publicacion_ctn = pc.id_publicacion_ctn
              inner join catalogo_aula ca on ca.id_catalogo_aula = iacp.id_catalogo_aula
              left join alumno_inscrito_ctn_publicado aicp on aicp.id_instructor_asignado_curso_publicado = iacp.id_instructor_asignado_curso_publicado
            where pc.id_publicacion_ctn = $idPublicacionCTN";
            $query = $this->db->query($consulta);
            return $query->row();
        }
        $obj = new stdClass();
        $obj->total_alumno_soportados = 9999999999;
        $obj->alumnos_inscritos = 0;
        return $obj;
    }

    private function obtenerAlumnoInscritoCTNPublicado($id_alumno_inscrito_ctn_publicado){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        $query = $this->db->get('alumno_inscrito_ctn_publicado');
        return $query->row();
    }

    private function obtenerInstructorParaAsignar($idPublicacionCTN){
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

    private function obtener_publicacion_ctn($id_publicacion_ctn){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $query = $this->db->get('publicacion_ctn');
        return $query->row();
    }

    private function obtener_publicacion_evaluacion_online_empresa($id_publicacion_ctn){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        $this->db->where('id_catalogo_tipo_publicacion',CURSO_EMPRESA);
        $query = $this->db->get('publicacion_ctn');
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    //funciones de insertado
    private function insertarAlumnoInscritoCTNPublicacion($insert){
        $this->db->insert('alumno_inscrito_ctn_publicado',$insert);
        return $this->db->insert_id();
    }

    private function insertarAlumnoDatosFiscales($insert){
        $this->db->insert('datos_fiscales',$insert);
        return $this->db->insert_id();
    }

    //funciones de update
    private function actualizarAlumnoInscritoCTNPublicacion($id_alumno_inscrito_ctn_publicado,$update){
        $this->db->where('id_alumno_inscrito_ctn_publicado',$id_alumno_inscrito_ctn_publicado);
        return $this->db->update('alumno_inscrito_ctn_publicado',$update);
    }

    private function actualizarAlumnoDatosFiscales($idDatosFiscales,$update){
        $this->db->where('id_datos_fiscales',$idDatosFiscales);
        return $this->db->update('datos_fiscales',$update);
    }

    private function insertar_usuario_alumno_ctn_publicado($usuario){
        $insert = array(
            'nombre' => $usuario['nombre'],
            'password' => PASS_CIVIKA2018,
            'apellido_p' => $usuario['apellido_p'],
            'apellido_m' => $usuario['apellido_m'],
            'correo' => $usuario['correo'],
            'telefono' => $usuario['telefono']
        );
        $insert['usuario'] = substr($usuario['nombre'],0,2).$usuario['apellido_p'].substr($usuario['apellido_m'],0,2);
        $insert['usuario'] = strMinusculas($insert['usuario']);
        $this->db->insert('usuario',$insert);
        return $this->db->insert_id();
    }

    private function insertar_alumno_ctn_publicado($id_usuario,$alumno){
        $insert = array(
            'curp' => $alumno['curp'],
            'puesto' => $alumno['puesto'],
            'id_usuario' => $id_usuario,
        );
        if(isset($alumno['id_catalogo_ocupacion_especifica']) && $alumno['id_catalogo_ocupacion_especifica'] != ''){
            $insert['id_catalogo_ocupacion_especifica'] = $alumno['id_catalogo_ocupacion_especifica'];
        }
        $this->db->insert('alumno',$insert);
        return $this->db->insert_id();
    }

    private function insertar_empresa_alumno_ctn_publicado($id_alumno,$empresa){
        $insert = array(
            'nombre' => $empresa['nombre'],
            'rfc' => $empresa['rfc'],
            'representante_legal' => $empresa['representante_legal'],
            'representante_trabajadores' => $empresa['representante_trabajadores'],
            'id_alumno' => $id_alumno
        );
        $this->db->insert('empresa_alumno',$insert);
        return $this->db->insert_id();
    }

    private function insertar_alumno_alumno_inscrito_ctn_publicado($id_alumno,$id_publicacion_ctn){
        $today = todayBD();
        $instructor_para_asignar = $this->obtenerInstructorParaAsignar($id_publicacion_ctn);
        $insert = array(
            'fecha_actualizacion_datos' => $today,
            'fecha_preinscripcion' => $today,
            'fecha_pago_registrado' => $today,
            'fecha_pago_validado' => $today,
            'id_catalogo_proceso_inscripcion' => PROCESO_PAGO_FINALIZADO_INSCRITO,
            'id_alumno' => $id_alumno,
            'id_publicacion_ctn' => $id_publicacion_ctn,
            'id_instructor_asignado_curso_publicado' => $instructor_para_asignar->id_instructor_asignado_curso_publicado,
            'asistio' => 'si'
        );
        $this->db->insert('alumno_inscrito_ctn_publicado',$insert);
        return $this->db->insert_id();
    }

    private function obtener_alumno_sistema($id_usuario){
        $this->db->where('id_usuario',$id_usuario);
        $query = $this->db->get('alumno');
        return $query->row();
    }

    private function obtener_estatus_update_inscripcion($id_alumno_inscrito_ctn_publicado){
        //faltaria implementar la opcion de para cuando se haya realizado el pago con tarjeta
        /*$alumno_inscripcion = $this->obtenerAlumnoInscritoCTNPublicado($id_alumno_inscrito_ctn_publicado);
        switch ($alumno_inscripcion->id_catalogo_proceso_inscripcion){
            case PROCESO_PAGO_ACTUALIZACION_DATOS: case PROCESO_PAGO_NO_REGISTRADO: case PROCESO_PAGO_OBSERVADO:
                $estatus_retorno = PROCESO_PAGO_EN_VALIDACION;
                break;
        }*/
        return PROCESO_PAGO_EN_VALIDACION;
    }
}

?>