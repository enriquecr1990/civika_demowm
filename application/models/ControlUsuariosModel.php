<?php

defined('BASEPATH') OR exit('No tiene access al script');

class ControlUsuariosModel extends CI_Model{

    function __construct(){
        $this->load->model('BitacoraModel');
        $this->load->model('DocumentosModel');
        $this->load->model('NotificacionesModel');
    }

    public function obtenerUsuarioSesion($form_post){
        $result['existe'] = false;
        $result['msg'] = 'No existe el usuario en el sistema';
        $this->db->where('usuario',$form_post['usuario']);
        $query = $this->db->get('usuario');
        if($query->num_rows() != 0){
            $row = $query->row();
            $pass_decryp = $row->password;
            if($pass_decryp == sha1($form_post['password'])){
                $result['existe'] = true;
                $result['usuario'] = $this->obtenerDatosUsuario($row->id_usuario);
                if($row->activo == 'si'){
                    $result['msg'] = '';
                    if($row->verificado == 'no'){
                        $result['msg'] = 'Su cuenta en el sistema no se encuentra verificada favor de realizar su verificación';
                    }
                    $result['usuario']->activo = true;
                    $result['usuario']->verificado = $row->verificado == 'si' ? true : false;
                    $result['usuario']->update_password = $row->update_password;
                }else{
                    $result['msg'] = 'Su cuenta en el sistema ha sido desactivada, favor de contactar con el administrador para verificar su estatus';
                    $result['usuario']->activo = false;
                }
            }else{
                $result['existe'] = false;
                $result['msg'] = 'Constraseña incorrecta, favor de verificar';
            }
        }
        return $result;
    }

    public function obtenerUsuariosSistema($post_form,$pagina = 1,$limit = 10){
        $sql_limit = " limit ".(($pagina*$limit)-$limit).",$limit";
        $criterios_adicionales = $this->obtenerCriteriosAdicionalesUsuarios($post_form);
        $consulta = $this->obtenerQueryBaseUsuario();
        $consulta .= $criterios_adicionales;
        $consulta .= $sql_limit;
        $query = $this->db->query($consulta);
        $result = $query->result();
        $data['listaUsuario'] = $result;
        $data['total_registros'] = $this->obtener_numero_total_usuarios($criterios_adicionales);
        return $data;
    }

    public function obtener_usuario_alumnos_sistema($post_form,$pagina = 1,$limit = 10){
        $sql_limit = " limit ".(($pagina*$limit)-$limit).",$limit";
        $criterios_adicionales = $this->obtenerCriteriosAdicionalesUsuariosAlumno($post_form);
        $consulta = $this->obtener_query_base_usuario_ctn_publicado($post_form['id_publicacion_ctn']);
        $consulta .= $criterios_adicionales;
        $consulta .= $sql_limit;
        $query = $this->db->query($consulta);
        $result = $query->result();
        $data['listaUsuario'] = $result;
        $data['total_registros'] = $this->obtener_numero_total_usuarios($criterios_adicionales);
        return $data;
    }

    public function obtenerUsuarioAdministrador($idUsuarioAdmin){
        $this->db->where('id_usuario_admin',$idUsuarioAdmin);
        $query = $this->db->get('usuario_admin');
        return $query->row();
    }

    public function obtenerArrayUsuarioInstructor(){
        $consulta = "select 
              i.id_instructor,cta.abreviatura, cta.titulo,
              u.nombre, u.apellido_p, u.apellido_m,
              concat(u.nombre, ' ', u.apellido_p, ' ', u.apellido_m ) nombre_completo,
              concat(cta.abreviatura, ' ', u.nombre, ' ', u.apellido_p, ' ', u.apellido_m ) nombre_instructor
            from usuario u
              inner join instructor i on i.id_usuario = u.id_usuario
              left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
            where u.activo = 'si'";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtenerUsuario($idUsuario){
        $this->db->where('id_usuario',$idUsuario);
        $query = $this->db->get('usuario');
        $row = $query->row();
        unset($row->password);
        $row->foto_perfil = false;
        $row->tipo_usuario = $this->obtenerTipoUsuarioById($idUsuario);
        if(!is_null($row->id_documento_perfil) && $row->id_documento_perfil != ''){
            $row->foto_perfil = $this->DocumentosModel->obtenerDocumentoById($row->id_documento_perfil);
        }
        return $row;
    }

    public function obtenerUsuarioDetalle($idUsuario,$tipoUsuario = 'alumno'){
        $data['usuario'] = $this->obtenerUsuario($idUsuario);
        if($tipoUsuario == 'alumno'){
            $data['usuario_alumno'] = $this->getDatosAlumnoByIdUsuario($idUsuario);
            $empresa_alumno = $this->obtenerEmpresaByAlumno($data['usuario_alumno']->id_alumno);
            if(is_null($empresa_alumno)){
                $this->guardarEmpresaAlumno(array('id_alumno' => $data['usuario_alumno']->id_alumno));
                $empresa_alumno = $this->obtenerEmpresaByAlumno($data['usuario_alumno']->id_alumno);
            }
            $data['empresa'] =$empresa_alumno;
        }if($tipoUsuario == 'instructor'){
            $data['usuario_instructor'] = $this->getDatosInstructorByIdUsuario($idUsuario);
        }
        return $data;
    }

    public function getDatosAlumnoByIdUsuario($idUsuario){
        $consulta = "select 
                  a.*,cta.abreviatura,cta.titulo,coe.denominacion 
                from alumno a 
                  left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = a.id_catalogo_titulo_academico
                  left join catalogo_ocupacion_especifica coe on coe.id_catalogo_ocupacion_especifica = a.id_catalogo_ocupacion_especifica
                where a.id_usuario = $idUsuario";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function getDatosInstructorByIdUsuario($idUsuario){
        $consulta = "
            select 
              i.*,cta.abreviatura,cta.titulo,i.id_documento_firma,
              concat(d.ruta_directorio,d.nombre ) ruta_documento_firma
            from instructor i 
              left join catalogo_titulo_academico cta on cta.id_catalogo_titulo_academico = i.id_catalogo_titulo_academico
              left join documento d on d.id_documento = i.id_documento_firma
            where i.id_usuario = $idUsuario
        ";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtenerTipoUsuarioById($idUsuario){
        $consulta = "select 
              u.id_usuario,u.usuario,
              if(ua.id_usuario_admin is not null and ua.tipo = 'administrador','administrador',
                if(ua.id_usuario_admin is not null and ua.tipo = 'admin','admin',
                  if(a.id_alumno is not null, 'alumno',
                    if(i.id_instructor is not null, 'instructor','no_existe')
                  )
                )
              ) tipo_usuario
            from usuario u
              left join usuario_admin ua on ua.id_usuario = u.id_usuario
              left join alumno a on a.id_usuario = u.id_usuario
              left join instructor i on i.id_usuario = u.id_usuario
            where u.id_usuario = $idUsuario";
        $query = $this->db->query($consulta);
        return $query->row()->tipo_usuario;
    }

    public function configurarUsuario($idUsuario){
        $usuario = $this->obtenerDatosUsuario($idUsuario);
        $usuario->activo = $usuario->activo == 'si' ? true : false;
        $usuario->verficado = $usuario->verificado == 'si' ? true : false;
        $usuario->update_password = $usuario->update_password;
        return $usuario;
    }

    public function guardarUsuario($form_post){
        $retorno['exito'] = true;
        $retorno['msg'] = 'Se actualizo el usuario con éxito';
        $form_post['usuario']['tipo_usuario'] = $form_post['tipo_usuario'];
        //echo '<pre>'.print_r($form_post);exit;
        if(isset($form_post['usuario']['password']) && $form_post['usuario']['password'] != ''){
            $form_post['usuario']['password'] = encrypStr($form_post['usuario']['password']);
            $form_post['usuario']['update_password']++;
        }else{
            unset($form_post['usuario']['password']);
        }

        if(isset($form_post['usuario_alumno']['id_catalogo_titulo_academico']) && $form_post['usuario_alumno']['id_catalogo_titulo_academico'] == ''){
            unset($form_post['usuario_alumno']['id_catalogo_titulo_academico']);
        }if(isset($form_post['usuario_alumno']['id_catalogo_ocupacion_especifica']) && $form_post['usuario_alumno']['id_catalogo_ocupacion_especifica'] == ''){
            unset($form_post['usuario_alumno']['id_catalogo_ocupacion_especifica']);
        }if(isset($form_post['usuario_instructor']['id_catalogo_titulo_academico']) && $form_post['usuario_instructor']['id_catalogo_titulo_academico'] == ''){
            unset($form_post['usuario_instructor']['id_catalogo_titulo_academico']);
        }

        $existe_usuario = $this->obtenerUsuarioFromUsuario($form_post['usuario']['usuario']);
        if(isset($form_post['usuario']['id_usuario']) && $form_post['usuario']['id_usuario'] == ''){
            if($existe_usuario){
                $retorno['exito'] = false;
                $retorno['msg'] = 'El usuario ya existe en el sistema, favor de verificar el nombre de usuario';
            }else{
                switch ($form_post['tipo_usuario']){
                    case 'admin':case 'administrador':
                        $this->guardarNuevoUsuarioAdmin($form_post);
                        break;
                    case 'alumno':
                        $id_alumno_nuevo = $this->guardarNuevoUsuarioAlumno($form_post);
                        $this->guardarEmpresaAlumno(array('id_alumno' => $id_alumno_nuevo));
                        break;
                    case 'instructor':
                        $this->guardarNuevoUsuarioInstructor($form_post);
                        break;
                }
                $retorno['msg'] = 'Se registró el usuario en el sistema correctamente';
            }
        }else{
            if(($existe_usuario && $existe_usuario->id_usuario == $form_post['usuario']['id_usuario'])
                || !$existe_usuario){
                switch ($form_post['tipo_usuario']){
                    case 'admin':case 'administrador':
                    $this->actualizarUsuarioAdmin($form_post);
                    break;
                    case 'alumno':
                        $this->actualizarUsuarioAlumno($form_post);
                        $this->guardarUsuarioAlumnoDatosEmpresa($form_post);
                        break;
                    case 'instructor':
                        $this->actualizarUsuarioInstructor($form_post);
                        break;
                }
                $retorno['msg'] = 'Se actualizó el usuario en el sistema correctamente';
            }else{
                $retorno['exito'] = false;
                $retorno['msg'] = 'El usuario ya existe en el sistema, favor de verificar el nombre de usuarios';
            }
        }
        return $retorno;
    }

    public function guardar_usuario_instructor_datos_to_cv($post){
        $this->eliminar_instructor_preparacion_academica($post['id_instructor']);
        $this->eliminar_instructor_certificacion_diplomado_curso($post['id_instructor']);
        $this->eliminar_instructor_experiencia_laboral($post['id_instructor']);
        if(isset($post['instructor_preparacion_academica']) && sizeof($post['instructor_preparacion_academica']) > 0){
            foreach ($post['instructor_preparacion_academica'] as $it){
                $it['id_instructor'] = $post['id_instructor'];
                $it['fecha_termino'] = fechaHtmlToBD($it['fecha_termino']);
                $this->insertar_instructor_preparacion_academica($it);
            }
        }if(isset($post['instructor_certificacion_diplomado_curso']) && sizeof($post['instructor_certificacion_diplomado_curso']) > 0){
            foreach ($post['instructor_certificacion_diplomado_curso'] as $it){
                $it['id_instructor'] = $post['id_instructor'];
                $it['fecha_finalizacion'] = fechaHtmlToBD($it['fecha_finalizacion']);
                $this->insertar_instructor_certificacion_diplomado_curso($it);
            }
        }if(isset($post['instructor_experiencia_laboral']) && sizeof($post['instructor_experiencia_laboral']) > 0){
            foreach ($post['instructor_experiencia_laboral'] as $it){
                $it['id_instructor'] = $post['id_instructor'];
                $it['fecha_ingreso'] = fechaHtmlToBD($it['fecha_ingreso']);
                if(isset($it['fecha_termino']) && $it['fecha_termino'] != ''){
                    $it['fecha_termino'] = fechaHtmlToBD($it['fecha_termino']);
                }else{
                    unset($it['fecha_termino']);
                }
                $this->insertar_instructor_experiencia_laboral($it);
            }
        }
        return true;
    }

    public function activarDesactivarUsuario($id_usuario){
        $usuario = $this->obtenerUsuario($id_usuario);
       
        $usuarioUpdate['activo'] = $usuario->activo == 'si' ? 'no' : 'si';
        $this->db->where('id_usuario',$usuario->id_usuario);
        return $this->db->update('usuario',$usuarioUpdate);
    }

    public function eliminarUsuarioAdmin($idUsuarioAdmin){
        $usuarioAdmin = $this->obtenerUsuarioAdministrador($idUsuarioAdmin);
        $this->db->where('id_usuario_admin',$usuarioAdmin->id_usuario_admin);
        $this->db->delete('usuario_admin');
        $this->db->where('id_usuario',$usuarioAdmin->id_usuario);
        return $this->db->delete('usuario');
    }

    public function obtenerUsuarioFromUsuario($nombreUsuario){
        $this->db->where('usuario',$nombreUsuario);
        $query = $this->db->get('usuario');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    public function obtenerDatosUsuario($idUsuario){
        $usuario = $this->obtenerUsuario($idUsuario);
        $usuario->usuario_sistema = $usuario->nombre.' '.$usuario->apellido_p;
        $usuario->notificaciones = $this->NotificacionesModel->obtenerNumeroNotificacionesNoLediasUsuario($idUsuario);
        if(isset($usuario->usuario_sistema) && $usuario->usuario_sistema == ' '){
            $usuario->usuario_sistema = $usuario->usuario;
        }
        $tipoUsuario = $this->obtenerTipoUsuarioById($idUsuario);
        $usuario->tipo_usuario = $tipoUsuario;
        return $usuario;
    }

    public function obtenerEmpresaByAlumno($idAlumno){
        $this->db->where('id_alumno',$idAlumno);
        $query = $this->db->get('empresa_alumno');
        return $query->row();
    }

    public function actualizarUsuario($idUsuario,$update){
        $this->db->where('id_usuario',$idUsuario);
        return $this->db->update('usuario',$update);
    }


    public function actualizarAlumnoByIdUsuario($idUsuario,$update){
        $this->db->where('id_usuario',$idUsuario);
        return $this->db->update('alumno',$update);
    }

    public function guardarUsuarioAlumnoDatosPersonales($form_post){
        $this->BitacoraModel->bitacora_datos_personales($form_post['usuario']['id_usuario'],$form_post);
        if(isset($form_post['usuario']['password']) && $form_post['usuario']['password'] != ''){
            $form_post['usuario']['password'] = encrypStr($form_post['usuario']['password']);
            $form_post['usuario']['update_password']++;
        }else{
            unset($form_post['usuario']['password']);
        }
        $form_post['usuario']['update_datos']++;
        $this->actualizarUsuario($form_post['usuario']['id_usuario'],$form_post['usuario']);
        unset($form_post['usuario_alumno']['id_publicacion_ctn']);
        $form_post['usuario_alumno']['update_datos']++;
        return $this->actualizarAlumnoByIdUsuario($form_post['usuario']['id_usuario'],$form_post['usuario_alumno']);
    }

    public function obtenerUsuariosAdminSistema(){
        $consulta = "select 
              ua.id_usuario 
            from usuario_admin ua
              inner join usuario u on u.id_usuario = ua.id_usuario  
            WHERE ua.id_usuario <> 1
              and u.activo = 'si'";
        $query = $this->db->query($consulta);
        $result = $query->result();
        $retorno = array();
        foreach ($result as $r){
            $retorno[$r->id_usuario] = $r->id_usuario;
        }return $retorno;
    }

    public function obtenerUsuarioCorreo($post){
        $data['exito'] = true;
        $data['msg'] = '';
        $data['multiple_usuario'] = false;
        $this->db->where('correo',$post['correo']);
        $query = $this->db->get('usuario');
        if($query->num_rows() == 0){
            $data['exito'] = false;
            $data['msg'] = 'Correo no registrado en el sistema';
        }if($query->num_rows() == 1){
            $data['usuario'] = $query->row();
        }if($query->num_rows() > 1){
            $data['multiple_usuario'] = true;
            $data['usuario'] = $query->result();
        }
        return $data;
    }

    public function obtener_correos_usuario_to_send_email(){
        $correo_to_send = array();
        $correos = $this->obtener_correos_usuarios();
        $correos = array_chunk($correos,50);
        foreach ($correos as $index => $c){
            $array_correo = array();
            foreach ($c as $item){
                $array_correo[] = $item->correo;
            }
            $correo_to_send[$index] = implode(',',$array_correo);
        }
        return $correo_to_send;
    }

    public function obtener_array_instructor_preparacion_academica($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        $query = $this->db->get('instructor_preparacion_academica');
        return $query->result();
    }

    public function obtener_array_instructor_certificacion_diplomado_curso($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        $query = $this->db->get('instructor_certificacion_diplomado_curso');
        return $query->result();
    }

    public function obtener_array_instructor_experiencia_laboral($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        $query = $this->db->get('instructor_experiencia_laboral');
        return $query->result();
    }

    public function obtener_usuarios_admin(){
        $consulta = $this->obtenerQueryBaseUsuario();
        $consulta .= " where ua.tipo = 'admin'";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    /**
     * apartado de funciones para el registro de alumno a un curso
     */
    public function registroAlumnoCTN($post){
        $retorno['exito'] = true;
        $retorno['msg'] = '';
        $usuario = $this->obtenerUsuarioSistema($post['usuario']);
        if($usuario === false){
            $insert_usuario = array(
                'usuario' =>$post['usuario'],
                'password' => encrypStr($post['password']),
            );
            $id_usuario_nuevo = $this->guardarUsuarioBD($insert_usuario);
            $insert_alumno = array(
                'id_usuario' => $id_usuario_nuevo
            );
            $id_alumno = $this->guardarAlumno($insert_alumno);
            $insert_empresa_alumno = array(
                'id_alumno' => $id_alumno
            );
            $this->guardarEmpresaAlumno($insert_empresa_alumno);
            $retorno['usuario'] = $this->obtenerDatosUsuario($id_usuario_nuevo);
        }else{
            $retorno['exito'] = false;
            $retorno['msg'] = 'El usuario existe en el sistema, favor de iniciar sesión para poder acceder al curso';
        }return $retorno;
    }

    public function guardarUsuarioAlumnoDatosEmpresa($form_post){
        $this->BitacoraModel->bitacora_datos_empresa($form_post['usuario']['id_usuario'],$form_post);
        $form_post['empresa']['update_datos']++;
        return $this->actualizarDatosEmpresaByAlumno($form_post['usuario_alumno']['id_alumno'],$form_post['empresa']);
    }

    public function solicitud_reset_password($post){
        $usuario = $this->obtenerUsuario($post['id_usuario']);
        $temp_password = uniqid();
        $temp_password_cifrada = encrypStr($temp_password);
        $this->actualizarUsuario($usuario->id_usuario,array('temp_password' => $temp_password_cifrada));
        $subject = 'Solicitud de reestablecimiento de contraseña';
        $url_cambio = base_url().'Login/reestablecer_password?tmp='.$temp_password_cifrada.'&id_usr='.$post['id_usuario'];
        $url_cancelar = base_url().'Login/cancelar_reset_password?tmp='.$temp_password_cifrada.'&id_usr='.$post['id_usuario'];
        $mensaje = '<br>Se solicitó un cambio de contraseña en el sistema, por lo cual se le proporciona el usuario y una contraseña temporal';
        $mensaje .= '<br><br>Datos para el acceso del sistema ';
        $mensaje .= '<br><br><span class="negrita">Usuario: </span>'.$usuario->usuario;
        $mensaje .= '<br><span class="negrita">Contraseña temporal: </span>'.$temp_password;
        $mensaje .= '<br>De click <a href="'.$url_cambio.'">aquí</a> para realizar el cambio de contraseña';
        $mensaje .= '<br><br>Si usted no hizo la solicitud de click <a href="'.$url_cancelar.'">aquí</a> para cancelar la solicitud e inicie sesión con su contraseña de siempre';
        $mensaje .= '<br><br><span class="negrita">Los link solo se podrán abrir una unica vez (el de cambio de contraseña o el de cancelación)</span>';
        //$this->NotificacionesModel->enviar_notificacion_usuario(ADMIN_ROOT,$post['id_usuario'],$mensaje);
        return $this->NotificacionesModel->enviar_correo_electronico_notificacion($post['id_usuario'],$subject,$mensaje,true);
    }

    public function reestablecer_password($get){
        $return = true;
        $usuario = $this->obtenerUsuario($get['id_usr']);
        if(isset($usuario->temp_password) && !is_null($usuario->temp_password) && $usuario->temp_password != ''){
            if($usuario->temp_password === $get['tmp'] && is_null($usuario->fecha_update_pass_olvidado)){
                $update = array(
                    'fecha_update_pass_olvidado' => date('Y-m-d H:i:s')
                );
                $this->actualizarUsuario($get['id_usr'],$update);
            }else{
                $return = false;
            }
        }else{
            $return = false;
        }
        return $return;
    }

    public function cambiar_password_usuario_by_reestablecimiento($post){
        $response['exito'] = true;
        $response['msg'] = '';
        $usuario = $this->obtenerUsuario($post['id_usuario']);
        $temp_pass_encrypt = encrypStr($post['temp_password']);
        if($usuario->temp_password === $temp_pass_encrypt){
            $new_pass_encrypt = encrypStr($post['new_password']);
            $update = array(
                'password' => $new_pass_encrypt,
                'temp_password' => null,
                'fecha_update_pass_olvidado' => null,
                'update_password' => $usuario->update_password + 1
            );
            $this->actualizarUsuario($post['id_usuario'],$update);
        }else{
            $response['exito'] = false;
            $response['msg'] = 'La contraseña temporal es incorrecta, favor de verificar su bandeja de correo electrónico para consultar su contraseña temporal';
        }
        return $response;
    }

    public function cancelar_reset_password($get){
        $return = true;
        $usuario = $this->obtenerUsuario($get['id_usr']);
        if(isset($usuario->temp_password) && !is_null($usuario->temp_password) && $usuario->temp_password != ''){
            if($usuario->temp_password === $get['tmp'] && is_null($usuario->fecha_update_pass_olvidado)){
                $update = array(
                    'temp_password' => null,
                    'fecha_update_pass_olvidado' => null
                );
                $this->actualizarUsuario($get['id_usr'],$update);
            }else{
                $return = false;
            }
        }else{
            $return = false;
        }
        return $return;
    }
    public function actualizar_recibir_correo($id_usuario,$suscripcion){
        $this->db->where('id_usuario',$id_usuario);
          return $this->db->update('usuario', array('suscripcion_correo' => $suscripcion )); 
    }

    /**
     * apartado de funciones privadas para el control de usuario del asea
     */
    private function obtenerQueryBaseUsuario(){
        $consulta = "select 
              u.*,
              if(ua.id_usuario_admin is not null and ua.tipo = 'administrador','administrador',
                if(ua.id_usuario_admin is not null and ua.tipo = 'admin','admin',
                  if(a.id_alumno is not null, 'alumno',
                    if(i.id_instructor is not null, 'instructor','no_existe')
                  )
                )
              ) tipo_usuario,
              if(u.activo = 'si',true,false ) es_activo
            from usuario u
              left join usuario_admin ua on ua.id_usuario = u.id_usuario
              left join alumno a on a.id_usuario = u.id_usuario
              left join instructor i on i.id_usuario = u.id_usuario";
        return $consulta;
    }

    private function obtener_query_base_usuario_ctn_publicado($id_publicacion_ctn){
        $consulta = "select 
              u.*,
              if(u.activo = 'si',true,false ) es_activo,
              (
                select 
                  if(count(aicp.id_alumno_inscrito_ctn_publicado) = 0,false,true) 
                from alumno_inscrito_ctn_publicado aicp 
                  where aicp.id_publicacion_ctn = $id_publicacion_ctn and aicp.id_alumno = a.id_alumno
              )alumno_inscrito 
            from usuario u
              inner join alumno a on a.id_usuario = u.id_usuario";
        return $consulta;
    }

    private function obtenerCriteriosAdicionalesUsuarios($form_post){
        $criterios = " where if(ua.id_usuario_admin is not null,ua.tipo <> 'administrador',true )";
        if(isset($form_post['nombre']) && $form_post['nombre'] != ''){
            $criterios .= " and u.nombre like '%".$form_post['nombre']."%'";
        }if(isset($form_post['apellido_p']) && $form_post['apellido_p'] != ''){
            $criterios .= " and u.apellido_p like '%".$form_post['apellido_p']."%'";
        }if(isset($form_post['correo']) && $form_post['correo'] != ''){
            $criterios .= " and u.correo like '%".$form_post['correo']."%'";
        }if(isset($form_post['tipo_usuario']) && $form_post['tipo_usuario'] != ''){
            $criterios .= " and u.tipo_usuario like '%".$form_post['tipo_usuario']."%'";
        }
        return $criterios;
    }

    private function obtenerCriteriosAdicionalesUsuariosAlumno($form_post){
        $criterios = " where 1=1";
        if(isset($form_post['nombre']) && $form_post['nombre'] != ''){
            $criterios .= " and u.nombre like '%".$form_post['nombre']."%'";
        }if(isset($form_post['apellido_p']) && $form_post['apellido_p'] != ''){
            $criterios .= " and u.apellido_p like '%".$form_post['apellido_p']."%'";
        }if(isset($form_post['correo']) && $form_post['correo'] != ''){
            $criterios .= " and u.correo like '%".$form_post['correo']."%'";
        }if(isset($form_post['tipo_usuario']) && $form_post['tipo_usuario'] != ''){
            $criterios .= " and u.tipo_usuario like '%".$form_post['tipo_usuario']."%'";
        }
        return $criterios;
    }

    private function obtenerUsuarioSistema($usuario){
        $this->db->where('usuario',$usuario);
        $query = $this->db->get('usuario');
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    private function obtener_correos_usuarios(){
        $consulta = "select 
              u.correo
            from usuario u
            where u.correo is not null 
              and u.correo <> ''";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    /**
     * apartado de funciones de obtener informacion
     */

    /**
     * apartado de funciones de guardado
     */
    private function guardarNuevoUsuarioAdmin($post){
        $idUsuarioNuevo = $this->guardarUsuarioBD($post['usuario']);
        $post['usuario_admin']['id_usuario'] = $idUsuarioNuevo;
        $post['usuario_admin']['tipo'] = $post['tipo_usuario'];
        return $this->guardarUsuarioAdmin($post['usuario_admin']);
    }

    private function guardarNuevoUsuarioAlumno($post){
        $idUsuarioNuevo = $this->guardarUsuarioBD($post['usuario']);
        $post['usuario_alumno']['id_usuario'] = $idUsuarioNuevo;
        return $this->guardarAlumno($post['usuario_alumno']);
    }

    private function guardarNuevoUsuarioInstructor($post){
        $idUsuarioNuevo = $this->guardarUsuarioBD($post['usuario']);
        $post['usuario_instructor']['id_usuario'] = $idUsuarioNuevo;
        if(isset($post['usuario_instructor']['id_catalogo_titulo_academico']) && $post['usuario_instructor']['id_catalogo_titulo_academico'] == ''){
            unset($post['usuario_instructor']['id_catalogo_titulo_academico']);
        }
        return $this->guardarInstructor($post['usuario_instructor']);
    }

    private function guardarUsuarioBD($insert){
        $this->db->insert('usuario',$insert);
        return $this->db->insert_id();
    }

    private function guardarUsuarioAdmin($insert){
        $this->db->insert('usuario_admin',$insert);
        return $this->db->insert_id();
    }

    private function guardarAlumno($insert){
        $this->db->insert('alumno',$insert);
        return $this->db->insert_id();
    }

    private function guardarInstructor($insert){
        $this->db->insert('instructor',$insert);
        return $this->db->insert_id();
    }

    public function guardarEmpresaAlumno($insert){
        $this->db->insert('empresa_alumno',$insert);
        return $this->db->insert_id();
    }

    private function insertar_instructor_preparacion_academica($insert){
        $this->db->insert('instructor_preparacion_academica',$insert);
        return $this->db->insert_id();
    }

    private function insertar_instructor_certificacion_diplomado_curso($insert){
        $this->db->insert('instructor_certificacion_diplomado_curso',$insert);
        return $this->db->insert_id();
    }

    private function insertar_instructor_experiencia_laboral($insert){
        $this->db->insert('instructor_experiencia_laboral',$insert);
        return $this->db->insert_id();
    }

    /**
     * apartado de funciones de actualizacion
     */

    private function actualizarUsuarioAdmin($post){
        return $this->actualizarUsuario($post['usuario']['id_usuario'],$post['usuario']);
    }

    private function actualizarUsuarioAlumno($post){
        $this->actualizarUsuario($post['usuario']['id_usuario'],$post['usuario']);
        return $this->actualizarAlumnoByIdUsuario($post['usuario']['id_usuario'],$post['usuario_alumno']);
    }

    private function actualizarUsuarioInstructor($post){
        $this->actualizarUsuario($post['usuario']['id_usuario'],$post['usuario']);
        if(isset($post['usuario_instructor']['id_catalogo_titulo_academico']) && $post['usuario_instructor']['id_catalogo_titulo_academico'] == ''){
            unset($post['usuario_instructor']['id_catalogo_titulo_academico']);
        }
        return $this->actualizarInstructorByIdUsuario($post['usuario']['id_usuario'],$post['usuario_instructor']);
    }

    private function actualizarAdminByIdUsuario($idUsuario,$update){
        $this->db->where('id_usuario',$idUsuario);
        return $this->db->update('usuario_admin',$update);
    }

    private function actualizarDatosEmpresaByAlumno($idAlumno,$datosEmpresa){
        $this->db->where('id_alumno',$idAlumno);
        return $this->db->update('empresa_alumno',$datosEmpresa);
    }

    private function actualizarInstructorByIdUsuario($idUsuario,$update){
        $this->db->where('id_usuario',$idUsuario);
        return $this->db->update('instructor',$update);
    }

    private function obtener_numero_total_usuarios($criterios_adicionales){
        $consulta = "select 
                count(*) total_registros 
            from usuario u
                left join usuario_admin ua on ua.id_usuario = u.id_usuario 
            $criterios_adicionales";
        $query = $this->db->query($consulta);
        return $query->row()->total_registros;
    }

    private function eliminar_instructor_preparacion_academica($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        return $this->db->delete('instructor_preparacion_academica');
    }

    private function eliminar_instructor_certificacion_diplomado_curso($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        return $this->db->delete('instructor_certificacion_diplomado_curso');
    }

    private function eliminar_instructor_experiencia_laboral($id_instructor){
        $this->db->where('id_instructor',$id_instructor);
        return $this->db->delete('instructor_experiencia_laboral');
    }
    
}

?>