<?php

defined('BASEPATH') OR exit('No tiene access al script');

class NotificacionesModel extends CI_Model
{

    function __construct()
    {
        $this->load->model('BitacoraModel');
        $this->load->model('ControlUsuariosModel');
        $this->load->model('Cotizaciones_model');
        $this->load->model('administrarCTN/CursosModel','CursosModel');
    }

    /**
     * funciones para el envio de correos electronicos
     */
    public function enviar_correo_curso_publicado($id_publicacion_ctn){
        $correos_enviar = $this->ControlUsuariosModel->obtener_correos_usuario_to_send_email();
        $detalle_mensaje = $this->obtener_mensaje_correo_publicacion($id_publicacion_ctn);
        $data['correo_masivo'] = true;
        $data['mensaje'] = $detalle_mensaje['mensaje'];
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        foreach ($correos_enviar as $correos){
            $this->enviar_correo($correos,$detalle_mensaje['asunto'],$html_mensaje,es_pruebas());
        }
        return true;
    }

    /**
     * metodo para enviar las notificaciones de un usuario remitente a un receptor
     */

    public function enviar_notificacion_recibo_pago_a_validar($id_alumno_inscrito_ctn_publicado){
        $array_id_usuario_admin = $this->ControlUsuariosModel->obtenerUsuariosAdminSistema();
        $publicacion_ctn = $this->CursosModel->obtenerCursoByIdAlumnoInscritoPublicacion($id_alumno_inscrito_ctn_publicado);
        $mensaje = 'El alumno '.$publicacion_ctn->nombre.' '.$publicacion_ctn->apellido_p.' '.$publicacion_ctn->apellido_m.' envió su recibo para validación de pago del curso ';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= ' de click <a href="'.base_url().'AdministrarCTN/verPublicacionCtn/'.$publicacion_ctn->id_curso_taller_norma.'">aquí</a> en la sección de alumnos para validar su pago';
        $this->enviar_notificacion_usuarios(ADMIN_ROOT,$array_id_usuario_admin,$mensaje);
        $this->enviar_correos_electronicos_notificacion($array_id_usuario_admin,'Comprobante de pago de curso',$mensaje);
        $mensaje = 'Se envió su comprobante a validación de pago para el curso ';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= '. Quede atento al sistema para futuras publicaciones de cursos y la acreditación de su pago';
        $this->enviar_notificacion_usuario(ADMIN_ROOT,$publicacion_ctn->id_usuario,$mensaje);
        $this->enviar_correo_electronico_notificacion($publicacion_ctn->id_usuario,'Comprobante de pago de curso',$mensaje);
        return true;
    }

    public function enviar_notificacion_conclusion_registro_dc3($id_alumno_inscrito_ctn_publicado,$documnto_dc3){
        $array_id_usuario_admin = $this->ControlUsuariosModel->obtenerUsuariosAdminSistema();
        $publicacion_ctn = $this->CursosModel->obtenerCursoByIdAlumnoInscritoPublicacion($id_alumno_inscrito_ctn_publicado);
        $mensaje_documento_dc3 = ' de click <a href="'.$documnto_dc3->ruta_documento.'" target="_blank">aquí</a> para ver el formulario completo de inscripción';
        $mensaje = 'El alumno '.$publicacion_ctn->nombre.' '.$publicacion_ctn->apellido_p.' '.$publicacion_ctn->apellido_m.' concluyó su registro de inscripción con los datos para la DC-3 en caso de ser requerido para el curso ';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= $mensaje_documento_dc3;
        $this->enviar_notificacion_usuarios(ADMIN_ROOT,$array_id_usuario_admin,$mensaje);
        $this->enviar_correos_electronicos_notificacion($array_id_usuario_admin,'Conclusión del registro de inscripcion (datos DC-3)',$mensaje);
        $mensaje = 'Gracias y bienvenido al curso ';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= $mensaje_documento_dc3;
        $mensaje .= '. Quede atento al sistema para futuras publicaciones de cursos';
        $this->enviar_notificacion_usuario(ADMIN_ROOT,$publicacion_ctn->id_usuario,$mensaje);
        $this->enviar_correo_electronico_notificacion($publicacion_ctn->id_usuario,'Conclusión del registro de inscripcion (datos DC-3)',$mensaje);
        return true;
    }

    public function enviar_notificacion_observacion_pago($id_usuario_envia,$id_alumno_inscrito_ctn_publicado){
        $publicacion_ctn = $this->CursosModel->obtenerCursoByIdAlumnoInscritoPublicacion($id_alumno_inscrito_ctn_publicado);
        $mensaje = 'Se detecto una observación en el comprobante de pago para el curso ';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $this->enviar_correo_electronico_notificacion($publicacion_ctn->id_usuario,'Observación de Comprobante de pago de curso',$mensaje);
        $mensaje .= ' de click, <a href="'.base_url().'InscripcionesCTN/actualizarDatosAlumno/'.$publicacion_ctn->id_publicacion_ctn.'">aquí</a> para ver el detalle y solventar su recibo';
        $this->enviar_notificacion_usuario($id_usuario_envia,$publicacion_ctn->id_usuario,$mensaje);
        return true;
    }

    public function enviar_notificacion_validacion_pago($id_usuario_envia,$id_alumno_inscrito_ctn_publicado){
        $publicacion_ctn = $this->CursosModel->obtenerCursoByIdAlumnoInscritoPublicacion($id_alumno_inscrito_ctn_publicado);
        $instructor_aula = $this->CursosModel->obtenerDatosInstructorAulaPublicacionCTN($id_alumno_inscrito_ctn_publicado);
        $mensaje = 'Gracias por haber subido a nuestro sistema su comprobante de pago.';
        $mensaje .= '<br>Confirmamos de recibido, su inscripción ha sido realizada para el curso';
        $mensaje .= '"'.$publicacion_ctn->nombre_curso_comercial.'", el cuál será impartido ';
        $mensaje .= ' en '.$publicacion_ctn->direccion_imparticion.' ';
        $mensaje .= 'el día <span class="negrita">'.fechaBDToHtml($publicacion_ctn->fecha_inicio).'</span> en un horario de '.$publicacion_ctn->horario;
        $mensaje .= ' con el instructor <span class="negrita">'.$instructor_aula->nombre.' '.$instructor_aula->apellido_p.' '.$instructor_aula->apellido_m.'</span> en "'.$instructor_aula->aula.'"';
        //$mensaje .= '<br>Favor de ingresar al sistema para realizar un registro completo de sus datos para la generación de las constancias. Presentarse unos 10 minutos antes de la fecha, hora, lugar acordados para el curso ';
        $mensaje .= '<br>Presentarse unos 10 minutos antes de la fecha, hora, lugar acordados para el curso ';
        $mensaje .= 'y ENTREGAR SU BAUCHER DE DEPÓSITO EN ORIGINAL AL MOMENTO DE FIRMAR SU INGRESO. No requiere traer materiales adicionales, aquí le proporcionamos lo que va a ocupar.';
        $despedida = '<br>Fue un placer atenderle. Saludos y excelente día';
        $this->enviar_correo_electronico_notificacion($publicacion_ctn->id_usuario,'Inscripción al curso y registro de datos para generación de constancias',$mensaje.$despedida);
        //$mensaje .= 'de click  <a href="'.base_url().'/InscripcionesCTN/actualizarDatosInscripcion/'.$publicacion_ctn->id_publicacion_ctn.'">aqui</a> para concluir el registro de sus datos';
        $this->enviar_notificacion_usuario($id_usuario_envia,$publicacion_ctn->id_usuario,$mensaje);
        return true;
    }

    public function enviar_correos_electronicos_notificacion($array_id_usuarios_recibe,$subject,$mensaje){
        if(is_array($array_id_usuarios_recibe) && sizeof($array_id_usuarios_recibe)){
            $to_msg = '';
            $correos = array();
            $size_usr_recibe = sizeof($array_id_usuarios_recibe);
            foreach ($array_id_usuarios_recibe as $index => $id_usuario_recibe){
                $usuario = $this->ControlUsuariosModel->obtenerUsuario($id_usuario_recibe);
                $correos[] = $usuario->correo;
                if($index < $size_usr_recibe - 1){
                    $to_msg .= ',';
                }
            }
            $to_msg = implode(',',$correos);
            $data['correo_masivo'] = true;
            $data['mensaje'] = $mensaje;
            $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
            return $this->enviar_correo($to_msg,$subject,$html_mensaje);
        }return true;
    }

    public function enviar_correo_electronico_notificacion($id_usuario_recibe,$subject,$mensaje,$test_correo = false){
        $data['correo_masivo'] = false;
        $data['usuario'] = $this->ControlUsuariosModel->obtenerUsuario($id_usuario_recibe);
        $data['mensaje'] = $mensaje;
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        return $this->enviar_correo($data['usuario']->correo,$subject,$html_mensaje,$test_correo);
    }

    public function notificar_cancelacion_curso($id_usuario_envia,$post_cancelacion){
        $alumnos = $this->obtener_correos_alumno_curso_cancelado($post_cancelacion['curso_taller_norma']['id_curso_taller_norma']);
        if($alumnos){
            $to_msg = '';
            $num_alumnos = sizeof($alumnos);
            foreach ($alumnos as $index => $a){
                $to_msg .= $a->correo;
                $this->enviar_notificacion_usuario($id_usuario_envia,$a->id_usuario,$post_cancelacion['curso_taller_norma']['descripcion_cancelacion']);
                if($index < $num_alumnos - 1){
                    $to_msg .= ',';
                }
            }
            $data['correo_masivo'] = true;
            $data['mensaje'] = $post_cancelacion['curso_taller_norma']['descripcion_cancelacion'];
            $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
            return $this->enviar_correo($to_msg,'Cancelación de curso presencial',$html_mensaje);
        }return true;
    }

    public function notificar_cancelacion_publicacion_curso($id_usuario_envia,$post_cancelacion){
        $alumnos = $this->obtener_correos_alumno_publicacion_ctn_modificado_cancelado($post_cancelacion['publicacion_ctn']['id_publicacion_ctn']);
        if($alumnos){
            $to_msg = '';
            $num_alumnos = sizeof($alumnos);
            $mensaje = '';
            foreach ($alumnos as $index => $a){
                $to_msg .= $a->correo;
                $mensaje = 'El curso "'.$a->nombre_curso_comercial.'" que se tenía programado para el dia '.fechaBDToHtml($a->fecha_inicio);
                $mensaje .= ' fue cancelado por: ';
                $mensaje .= '<strong>'.$post_cancelacion['publicacion_ctn']['detalle_eliminacion'].'</strong>';
                $this->enviar_notificacion_usuario($id_usuario_envia,$a->id_usuario,$mensaje);
                if($index < $num_alumnos - 1){
                    $to_msg .= ',';
                }
            }
            $data['correo_masivo'] = true;
            $data['mensaje'] = $mensaje;
            $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
            return $this->enviar_correo($to_msg,'Cancelación de curso presencial',$html_mensaje);
        }return true;
    }

    public function notificar_modificacion_publicacion_curso($id_usuario_envia,$post_modificacion){
        $alumnos = $this->obtener_correos_alumno_publicacion_ctn_modificado_cancelado($post_modificacion['publicacion_ctn']['id_publicacion_ctn']);
        if($alumnos){
            $to_msg = '';
            $num_alumnos = sizeof($alumnos);
            $mensaje = '';
            foreach ($alumnos as $index => $a){
                $to_msg .= $a->correo;
                $mensaje = 'El curso "'.$a->nombre_curso_comercial.'" que se tenía programado para el dia '.fechaBDToHtml($a->fecha_inicio);
                $mensaje .= ' fue actualizaco en el sistema por: ';
                $mensaje .= '<strong>'.$post_modificacion['publicacion_ctn']['detalle_modificacion'].'</strong>';
                $this->enviar_notificacion_usuario($id_usuario_envia,$a->id_usuario,$mensaje);
                if($index < $num_alumnos - 1){
                    $to_msg .= ',';
                }
            }
            $data['correo_masivo'] = true;
            $data['mensaje'] = $mensaje;
            $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
            return $this->enviar_correo($to_msg,'Actualización de curso presencial',$html_mensaje);
        }return true;
    }

    public function notificar_empresa_publicacion_ctn_masivo($id_publicacion_ctn,$rfc,$correo_empresa){
        $publicacion_ctn = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $mensaje = '<br> Se le informa que esta habilitada en la plataforma el curso denominado "'.$publicacion_ctn->nombre_curso_comercial.'"';
        $mensaje .= ', el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= ', en '.$publicacion_ctn->direccion_imparticion.'.';
        $mensaje .= '<br> De click <a href="'.base_url().'InscripcionesCTN/registro_empresa_ctn/'.$id_publicacion_ctn.'">aquí</a> para registrar los datos de los participantes que recibirán este curso.';
        $mensaje .= '<br><br> Sin más por el momento quedamos a sus ordenes.';
        $usuario = new stdClass();
        $usuario->nombre = $rfc;
        $usuario->apellido_p = $correo_empresa;
        $subject = 'Inscripción empresarial al curso "'.$publicacion_ctn->nombre_curso_comercial.'"';
        $data['correo_masivo'] = false;
        $data['usuario'] = $usuario;
        $data['mensaje'] = $mensaje;
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        return $this->enviar_correo($correo_empresa,$subject,$html_mensaje,true);
    }

    public function notificar_administradores_envio_empleados_publicacion_masiva($id_publicacion_ctn,$rfc){
        $array_id_usuario_admin = $this->ControlUsuariosModel->obtenerUsuariosAdminSistema();
        $publicacion_ctn = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $mensaje = 'La empresa con RFC: '.$rfc;
        $mensaje .= ' ha enviado la información de los empleados que participaran en el curso denominado "'.$publicacion_ctn->nombre_curso_comercial.'"';
        $mensaje .= ', el cuál será impartido el día '.fechaBDToHtml($publicacion_ctn->fecha_inicio);
        $mensaje .= ', en '.$publicacion_ctn->direccion_imparticion.'.';
        $mensaje .= ' de click <a href="'.base_url().'AdministrarCTN/verPublicacionCtn/'.$publicacion_ctn->id_curso_taller_norma.'">aquí</a> en la sección de alumnos para validar su pago';
        $mensaje .= '<br>Solo basta esperar el día del evento, marcar la asistencia de los empleados y generar sus constancias vía sistema';
        $this->enviar_notificacion_usuarios(ADMIN_ROOT,$array_id_usuario_admin,$mensaje);
        $this->enviar_correos_electronicos_notificacion($array_id_usuario_admin,'Empresa con RFC '.$rfc.' cargo los empleados al curso',$mensaje);
    }

    public function enviar_notificacion_empresa_cotizacion($id_cotizacion){
        $array_id_usuario_admin = $this->ControlUsuariosModel->obtenerUsuariosAdminSistema();
        $cotizacion = $this->Cotizaciones_model->obtener_cotizacion($id_cotizacion);
        $mensaje = 'Se encuentra la cotización disponible en el sistema, con número de folio: ';
        $mensaje .= $cotizacion->folio_cotizacion.' del curso con denominación: "'.$cotizacion->nombre.'" y una duración de '.$cotizacion->duracion.' horas';
        $mensaje .= ' de click <a href="'.base_url().'Cotizaciones/recibir/'.$id_cotizacion.'">aquí</a> para ver el detalle';
        $this->enviar_notificacion_usuarios(ADMIN_ROOT,$array_id_usuario_admin,$mensaje);
        $data['correo_masivo'] = false;
        $data['nombre_destinatario'] = $cotizacion->persona_recibe;
        $data['mensaje'] = $mensaje;
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        return $this->enviar_correo($cotizacion->correo,'Cotización CIVIKA "'.$cotizacion->nombre.'"',$html_mensaje,true);
    }

    public function enviar_notificacion_empresa_cotizacion_aceptacion($id_cotizacion){
        $array_id_usuario_admin = $this->ControlUsuariosModel->obtenerUsuariosAdminSistema();
        $cotizacion = $this->Cotizaciones_model->obtener_cotizacion($id_cotizacion);
        $mensaje = 'La empresa "'.$cotizacion->empresa.'" ha aceptado la cotizacion';
        $mensaje .= $cotizacion->folio_cotizacion.' del curso con denominación: "'.$cotizacion->nombre.'"';
        $mensaje .= ' de click <a href="'.base_url().'Cotizaciones?folio='.$cotizacion->folio_cotizacion.'">aquí</a> para ver el detalle';
        $this->enviar_notificacion_usuarios(ADMIN_ROOT,$array_id_usuario_admin,$mensaje);
        $data['correo_masivo'] = true;
        $data['mensaje'] = $mensaje;
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        return $this->enviar_correo($cotizacion->correo,'Cotización CIVIKA "'.$cotizacion->nombre.'"',$html_mensaje);
    }

    public function enviar_correo_evaluacion_online_link($post){
        $publicacion_ctn = $this->CursosModel->obtenerPublicacionCTN($post['id_publicacion_ctn']);
        $mensaje = "<p>Estimado(a) candidato(a) a ".strMayusculas($publicacion_ctn->nombre_curso_comercial).'</p>';
        $mensaje .= "<p>Ponemos a su amable disposición, el link para la realización de su evaluación online,";
        $mensaje .= ' de click <a href="'.base_url().'?id_publicacion_ctn='.$post['id_publicacion_ctn'].'&tipo_pubicacion=4">aquí</a>';
        $mensaje .= ' para iniciarla.</p>';
        $mensaje .= '<p>Te deseamos éxito rotundo en este proceso, y te recordamos que a partir de hoy tienes 30 días para dar respuesta a tus cuestionarios. ';
        $mensaje .= ' De lo contrario la plataforma se cerrará y ya no podrás realizar estás acciones.</p>';
        $mensaje .= '<P>Instrucciones: </P>';
        $mensaje .= '<ol>
                <li>Ingresa con tu usuario y contraseña asignados para acceder a la página.</li>
                <li>En el menú superior, busca la opción "mis evaluaciones" y da clic.</li>
                <li>Enseguida dirígete a "descargar material".</li>
                <li>Una vez hecho esto, responde los cuestionarios de conocimientos. </li>
                <li>Al finalizar los cuestionarios obtendrás una calificación que determinará si haz aprobado o no. </li>
            </ol>
            <p>Durante el proceso de evaluación, si tienes alguna duda, problema o requieres soporte técnico o académico, ponte en contacto con el tutor de tu proceso de evaluación.</p>
               

            <p> ¡ Muchas felicidades por tu constanste profesionalización ! </p>
        ';
        //mensaje de post data
       // $mensaje .= '<p>Pd. Cada cuestionario de conocimientos, tiene hasta 3 intentos de 30 minutos cada uno, para obtener un porcentaje de acreditación mayor a 96.7</p>';
        /*$data_post_data = $this->obtener_datos_postdata_correo($post['id_publicacion_ctn']);
        if(sizeof($data_post_data) > 1){
            //$mensaje .= 'PD. Pd. Cada cuestionario de conocimientos, tiene hasta 3 intentos de 30 minutos cada uno, para obtener un porcentaje de acreditación mayor a 96.7';
            $mensaje .= '<p>Consideraciones de la evaluación(es):</p>';
            foreach ($data_post_data as $index => $it){
                $mensaje .= '<p>La evaluación <strong>'.$it->titulo_evaluacion.'</strong> tiene hasta <strong>'.$it->intentos_evaluacion.' intentos</strong>';
                $mensaje .= ' de <strong>'.$it->tiempo_evaluacion.' minutos</strong> cada uno, para obtener un porcentaje de acreditacion mayor a 96.7';
                $mensaje .= '</p>';
            }
        }*/
        //$mensaje .= '<p>Dejamos como guía de apoyo para la evaluación en línea, presione <a href="'.base_url().'extras/guia_apoyo_evaluacion_online.pdf">aquí</a> para abrila</p>';
        $data['correo_masivo'] = false;
        $data['nombre_destinatario'] = $post['destinatario'];
        $data['mensaje'] = $mensaje;
        $html_mensaje = $this->load->view('cursos_civik/correo/notificacion',$data,true);
        return $this->enviar_correo($post['correo_link'],'Evaluación en línea - "'.$post['destinatario'].'"',$html_mensaje,true);
    }

    /**
     * apartado de funciones secundarias para las notificaciones
     */

    public function obtenerNumeroNotificacionesNoLediasUsuario($idUsuarioRecibe){
        $consulta = "select 
              sum(if(uan.fecha_leido is null,1,0)) mensajes_no_leidos
            from notificacion n 
              inner join usuario_sistema_has_notificacion uan on uan.id_notificacion = n.id_notificacion
            where uan.id_usuario_recibe = $idUsuarioRecibe";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtenerNotificacionesUsuario($idUsuarioRecibe,$pagina = 1){
        $sql_limit = " limit ".(($pagina*20)-20).",20";
        if($pagina == 0){
            $consulta = "select 
              count(uan.id_usuario_sistema_has_notificacion) registros
            from notificacion n 
              inner join usuario_sistema_has_notificacion uan on uan.id_notificacion = n.id_notificacion
            where uan.id_usuario_recibe = $idUsuarioRecibe";
        }else{
            $consulta = "select 
              n.*,
              ue.nombre nombre_envia,ue.apellido_p apellido_p_envia, ue.apellido_m apellido_m_envia,
              if(uan.fecha_leido is null,false,true) notificacion_leida
            from notificacion n 
              inner join usuario_sistema_has_notificacion uan on uan.id_notificacion = n.id_notificacion
              inner join usuario ue on ue.id_usuario = uan.id_usuario_envia
            where uan.id_usuario_recibe = $idUsuarioRecibe
            order by n.id_notificacion desc $sql_limit";
        }
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }if($pagina == 0){
            return $query->row()->registros;
        }
        return $query->result();
    }

    public function enviar_notificacion_usuarios($id_usuario_envia,$array_usuario_recibe,$mensaje){
        foreach ($array_usuario_recibe as $id_usuario_recibe){
            $id_notificacion = $this->insertar_notificacion($mensaje);
            $this->insertar_usuario_sistema_has_notificacion($id_notificacion,$id_usuario_envia,$id_usuario_recibe);
        }return true;
    }

    public function enviar_notificacion_usuario($id_usuario_envia,$id_usuario_recibe,$mensaje){
        $id_notificacion = $this->insertar_notificacion($mensaje);
        return $this->insertar_usuario_sistema_has_notificacion($id_notificacion,$id_usuario_envia,$id_usuario_recibe);
    }

    public function actualizar_notificaciones_leida($id_usuario_recibe){
        $today = date('Y-m-d H:i:s');
        $update = "update usuario_sistema_has_notificacion set fecha_leido = '$today' 
                    where id_usuario_recibe = $id_usuario_recibe and fecha_leido is null";
        return $this->db->query($update);
    }

    /**
     * apartado de funciones privadas al metodo
     */

    private function obtener_mensaje_correo_publicacion($id_publicacion_ctn){
        $publicacion_ctn = $this->CursosModel->obtenerPublicacionCTN($id_publicacion_ctn);
        $curso_taller_norma = $this->CursosModel->obtenerCursoById($publicacion_ctn->id_curso_taller_norma);
        $valor_curricular = $this->CursosModel->obtenerConstanciaDescripcion($id_publicacion_ctn);
        $data['asunto'] = $publicacion_ctn->nombre_curso_comercial.'. '.fechaCastellano($publicacion_ctn->fecha_inicio);
        $mensaje = 'Tenemos el honor de invitarlo a tomar el';
        $mensaje .= '<br>Curso: '.$publicacion_ctn->nombre_curso_comercial;
        $mensaje .= '<br>Fecha: '.fechaCastellano($publicacion_ctn->fecha_inicio);
        $mensaje .= '<br>Duración: '.$publicacion_ctn->duracion. ' horas';
        $mensaje .= '<br>Lugar: '.$publicacion_ctn->direccion_imparticion;
        $mensaje .= ' <a href="'.$publicacion_ctn->mapa.'">Ver mapa</a>';
        $mensaje .= '<br>Costo: $: '.number_format($publicacion_ctn->costo_en_tiempo,2);
        $mensaje .= '<br>Valor curricular: ';
        $mensaje .= '<ul>';
        foreach ($valor_curricular as $vc){
            $mensaje .= '<li>'.$vc->constancia.'</li>';
        }
        $mensaje .= '</ul>';
        $mensaje .= '<br>Objetivo: '.$curso_taller_norma->objetivo;
        $mensaje .= '<br>Informes e incripciones:';
        $mensaje .= '<br>Oficina: (01) 241 417 75 65';
        $mensaje .= '<br>WhatsApp: 241 135 62 52';
        $mensaje .= '<br><a href="'.base_url().'">'.base_url().'</a>';
        $data['mensaje'] = $mensaje;
        return $data;
    }

    private function insertar_notificacion($mensaje){
        $insert = array(
            'mensaje' => $mensaje,
            'fecha' => date('Y-m-d H:i:s')
        );
        $this->db->insert('notificacion',$insert);
        return $this->db->insert_id();
    }

    private function insertar_usuario_sistema_has_notificacion($id_notificacion,$id_usuario_envia,$id_usuario_recibe){
        $insert = array(
            'id_notificacion' => $id_notificacion,
            'id_usuario_envia' => $id_usuario_envia,
            'id_usuario_recibe' => $id_usuario_recibe
        );
        $this->db->insert('usuario_sistema_has_notificacion',$insert);
        return $this->db->insert_id();
    }

    private function obtener_correos_alumno_curso_cancelado($id_curso_taller_norma){
        $today = todayBD();
        $consulta = "select 
              u.id_usuario,u.correo,pc.nombre_curso_comercial,pc.fecha_inicio
            from alumno_inscrito_ctn_publicado aicp
              inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
              inner join alumno a on a.id_alumno = aicp.id_alumno
              inner join usuario u on u.id_usuario = a.id_usuario
            where pc.id_curso_taller_norma = $id_curso_taller_norma
              and pc.fecha_inicio <= '$today'";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        return $query->result();
    }

    private function obtener_correos_alumno_publicacion_ctn_modificado_cancelado($id_publicacion_ctn){
        $consulta = "select 
              u.id_usuario,u.correo,pc.nombre_curso_comercial,pc.fecha_inicio
            from alumno_inscrito_ctn_publicado aicp
              inner join publicacion_ctn pc on pc.id_publicacion_ctn = aicp.id_publicacion_ctn
              inner join alumno a on a.id_alumno = aicp.id_alumno
              inner join usuario u on u.id_usuario = a.id_usuario
            where pc.id_publicacion_ctn = $id_publicacion_ctn";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }return $query->result();
    }

    private function obtener_datos_postdata_correo($id_publicacion_ctn){
        $consulta = "select 
                if(epc.tiempo_evaluacion is not null,epc.tiempo_evaluacion,'Sin limite de tiempo' ) tiempo_evaluacion,
                if(epc.intentos_evaluacion is not null,epc.intentos_evaluacion,'hasta 100' ) intentos_evaluacion,
                if(epc.titulo_evaluacion is not null,epc.titulo_evaluacion,epc.tipo ) titulo_evaluacion
            from evaluacion_publicacion_ctn epc 
            where epc.id_publicacion_ctn = $id_publicacion_ctn
                and epc.disponible_alumnos = 'si'";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    private function enviar_correo($to,$subject,$html_mensaje,$test_correo = false){
        $retorno = false;
        if(es_produccion() || $test_correo){
            $this->load->library('email');
            $config = $this->get_config_correo_initialize();
            $this->email->initialize($config);
            $this->email->from($config['smtp_user'],'Sistemas Cursos Civika');
            //$this->email->to('enrique_cr1990@hotmail.com,enriquecr1990@gmail.com');
            $this->email->bcc($to);
            $this->email->subject($subject);
            $this->email->message($html_mensaje);
            if($this->email->send()){
                $retorno = true;
            }else{
                $this->BitacoraModel->save_bitacora_error($this->email->print_debugger());
                $retorno = false;
            }
        }
        return $retorno;
    }

    private function get_config_correo_initialize(){
        /*
        CONFIGURACION DE MAIL sistemas@civika.edu.mx
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'us3.smtp.mailhostbox.com';
        $config['smtp_user'] = 'sistemas@civika.edu.mx';
        $config['smtp_pass'] = 'HCD*fIG9';
        $config['smtp_port'] = '587';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['validate'] = true;
        $config['mailtype'] = 'html';

        CONFIGURACION DE MAIL infocivika@gmail.com
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_user'] = 'infocivika@gmail.com';
        $config['smtp_pass'] = 'avg10c127716y';
        $config['smtp_port'] = '465';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['validate'] = true;
        $config['mailtype'] = 'html';
        */
        $this->db->where('active','si');
        $this->db->limit(1);
        $query = $this->db->get('config_correo');
        $config_correo = $query->row();
        $config['protocol'] = $config_correo->protocol;
        $config['smtp_host'] = $config_correo->smtp_host;
        $config['smtp_user'] = $config_correo->smtp_user;
        $config['smtp_pass'] = $config_correo->smtp_pass;
        $config['smtp_port'] = $config_correo->smtp_port;
        $config['charset'] = $config_correo->charset;
        $config['wordwrap'] = true;
        $config['validate'] = true;
        $config['mailtype'] = $config_correo->mailtype;
        return $config;
    }

}

?>