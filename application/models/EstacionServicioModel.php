<?php

defined('BASEPATH') OR exit('No tiene access al script');

class EstacionServicioModel extends CI_Model{

    /**
     * metodos publicos para obtener informacion de las estaciones de servicio
     */
    public function obtenerEstacionesServicio($form_buscar){
        $consulta = "select * from estacion_servicio es";
        $consulta .= $this->obtenerCriteriosBusqueda($form_buscar);
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }
        $result = $query->result();
        foreach ($result as $r){
            $usuario = $this->obtenerUsuarioEstacion($r->id_usuario);
            $r->activo = $usuario->activo;
            $r->es_activo = $usuario->activo == 'si' ? true : false;
        }
        return $result;
    }

    public function obtenerEstacionServicioFromId($idEstacionServicio){
        $this->db->where('id_estacion_servicio',$idEstacionServicio);
        $query = $this->db->get('estacion_servicio');
        $row = $query->row();
        $tiene_documento = $this->obtenerEstacionServicioTieneDocumento($idEstacionServicio);
        $row->id_documento_asea = $tiene_documento->id_documento_asea;
        return $row;
    }

    public function obtenerEstacionServicioFromIdUsuario($idUsuario){
        $this->db->where('id_usuario',$idUsuario);
        $query = $this->db->get('estacion_servicio');
        return $query->row();
    }

    public function obtenerListaEmpleadosES($idEstacionServicio){
        $this->db->where('id_estacion_servicio',$idEstacionServicio);
        $query = $this->db->get('empleado_es');
        $result = $query->result();
        foreach ($result as $r){
            $r->usuario = $this->obtenerUsuarioEstacion($r->id_usuario);
        }
        return $result;
    }

    public function obtenerUsuarioEstacion($idUsuario){
        $this->db->where('id_usuario',$idUsuario);
        $query = $this->db->get('usuario');
        $row = $query->row();
        //$row->password = decrypAsea($row->password);
        return $row;
    }

    public function obtenerUsuarioAsea($nombreUsuario){
        $this->db->where('usuario',$nombreUsuario);
        $query = $this->db->get('usuario');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    public function obtenerListaNormasEstacion($idEstacionServicio,$anio){
        $consulta = "select 
              na.*,
              (select if(count(estn.id_estacion_servicio_tiene_normas) = 0, false,true) 
                from estacion_servicio_tiene_normas estn 
                where estn.id_normas_asea = na.id_normas_asea
                and estn.id_estacion_servicio = $idEstacionServicio)tiene_norma
            from normas_asea na
              where na.anio = $anio
              order by na.orden_norma";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    /**
     * metodos de funciones para actualizar la  informacion de las ES
     */
    public function guardarEstacionServicio($form_post){
        $retorno['exito'] = true;
        $retorno['msg'] = 'Se guardo la estación de servicio con éxito';
        if(isset($form_post['estacion_servicio']['id_estacion_servicio']) && $form_post['estacion_servicio']['id_estacion_servicio'] == ''){
            if($this->obtenerUsuarioAsea($form_post['usuario']['usuario']) ||
                $this->obtenerEstacionServicio($form_post['estacion_servicio']['rfc'])){
                $retorno['exito'] = false;
                $retorno['msg'] = 'Usuario existe en el sistema o el RFC registrado ya existe, favor de ingresar un usuario o RFC diferente';
            }else{
                $form_post['usuario']['tipo'] = 'rh_empresa';
                $form_post['usuario']['password'] = encrypAsea($form_post['usuario']['password']);
                $this->db->insert('usuario',$form_post['usuario']);
                $id_usuario_insertado = $this->db->insert_id();
                $form_post['estacion_servicio']['id_usuario'] = $id_usuario_insertado;
                $form_post['fecha_registro'] = date('Y-m-d H:i:s');
                $this->db->insert('estacion_servicio',$form_post['estacion_servicio']);
                $idEstacionServicio = $this->db->insert_id();
                $form_post['estacion_servicio_tiene_documento']['id_estacion_servicio'] = $idEstacionServicio;
                $this->db->insert('estacion_servicio_tiene_documento',$form_post['estacion_servicio_tiene_documento']);
            }
        } else{
            $form_post['fecha_actualizacion'] = date('Y-m-d H:i:s');
            $this->db->where('id_estacion_servicio',$form_post['estacion_servicio']['id_estacion_servicio']);
            $this->db->update('estacion_servicio',$form_post['estacion_servicio']);
            $form_post['usuario']['password'] = encrypAsea($form_post['usuario']['password']);
            $this->db->where('id_usuario',$form_post['estacion_servicio']['id_usuario']);
            $this->db->update('usuario',$form_post['usuario']);
            $this->eliminarEstacionServicioTieneDocumento($form_post['estacion_servicio']['id_estacion_servicio']);
            $this->db->insert('estacion_servicio_tiene_documento',$form_post['estacion_servicio_tiene_documento']);
            $retorno['msg'] = 'Se actualizó la estación de servicio con éxito';
        }

        return $retorno;
    }

    public function guardarNormasEstacionServicio($form_post){
        if(isset($form_post['estacion_servicio_tiene_normas'])){
            $this->db->where('id_estacion_servicio',$form_post['id_estacion_servicio']);
            $this->db->delete('estacion_servicio_tiene_normas');
            foreach ($form_post['estacion_servicio_tiene_normas'] as $estn){
                $estn['id_estacion_servicio'] = $form_post['id_estacion_servicio'];
                $this->db->insert('estacion_servicio_tiene_normas',$estn);
            }
            return true;
        }
        return false;
    }

    public function guardarEmpleadosES($form_post){
        $retorno['exito'] = false;
        $retorno['msg'] = 'Error al momento de guardar sus empleados';
        $puedo_guardar = true;
        $idEstacionServicio = $form_post['id_estacion_servicio'];
        foreach ($form_post['usuario'] as $index => $usr){
            $idEmpleadoEs = $form_post['empleado_es'][$index]['id_empleado_es'];
            if($idEmpleadoEs == ''){
                $usuario_existe = $this->obtenerUsuarioAsea($usr['usuario']);
                if($usuario_existe){
                    $puedo_guardar = false;
                    $retorno['msg'] .= '<li>El usuario '.$usr['usuario'].' del empleado existe en el sistema, cambiar usuario</li>';
                }
            }
        }
        if($puedo_guardar){
            foreach ($form_post['usuario'] as $index => $usr){
                $usr['password'] = encrypAsea($usr['password']);
                $usr['tipo'] = 'trabajador';
                if($usr['id_usuario'] == ''){
                    $this->db->insert('usuario',$usr);
                    $idUsuario = $this->db->insert_id();
                    $emp = $form_post['empleado_es'][$index];
                    $emp['id_usuario'] = $idUsuario;
                    $emp['id_estacion_servicio'] = $idEstacionServicio;
                    $this->db->insert('empleado_es',$emp);
                }else{
                    $this->db->where('id_usuario',$usr['id_usuario']);
                    $this->db->update('usuario',$usr);
                    $emp = $form_post['empleado_es'][$index];
                    $emp['es_representante'] = isset($emp['es_representante']) ? $emp['es_representante'] : 'no';
                    $this->db->where('id_empleado_es',$emp['id_empleado_es']);
                    $this->db->update('empleado_es',$emp);
                }
            }
            $retorno['exito'] = true;
            $retorno['msg'] = 'Se guardaron los empleados de la estación de servicio exitosamente';
        }
        return $retorno;
    }

    public function eliminarEstacionServicioTieneDocumento($idEstacionServicio,$tipo='logo'){
        $this->db->where('id_estacion_servicio',$idEstacionServicio);
        $this->db->where('tipo',$tipo);
        return $this->db->delete('estacion_servicio_tiene_documento');
    }

    public function eliminarDocumentoEstacionServicio($idDocumentoAsea){
        $this->db->where('id_documento_asea',$idDocumentoAsea);
        return $this->db->delete('estacion_servicio_tiene_documento');
    }

    public function eliminarEmpleadoES($idEmpleadoES){
        $this->load->model('EmpleadosESModel');
        $empleado = $this->EmpleadosESModel->obtenerEmpleadoEs($idEmpleadoES);
        $this->db->where('id_empleado_es',$idEmpleadoES);
        $this->db->delete('empleado_cursa_norma');
        $this->db->where('id_empleado_es',$idEmpleadoES);
        $this->db->delete('evaluacion_norma_asea');
        $this->db->where('id_empleado_es',$idEmpleadoES);
        $this->db->delete('evaluacion_norma_asea');
        $this->db->where('id_empleado_es',$idEmpleadoES);
        $this->db->delete('empleado_es');
        $this->db->where('id_usuario',$empleado->id_usuario);
        return $this->db->delete('usuario');
    }

    public function activarDesactivarES($idEstacionServicio,$operacion){
        $activo = $operacion == 1 ? 'si':'no';
        $estacionES = $this->obtenerEstacionServicioFromId($idEstacionServicio);
        $empleadosEs = $this->obtenerListaEmpleadosES($idEstacionServicio);
        $this->db->where('id_usuario',$estacionES->id_usuario);
        $this->db->update('usuario',array('activo' => $activo));
        foreach ($empleadosEs as $empEs){
            $this->db->where('id_usuario',$empEs->id_usuario);
            $this->db->update('usuario',array('activo' => $activo));
        }
        return true;
    }

    /*
     * apartado de funciones privadas a las ES
     */
    private function obtenerEstacionServicio($rfc){
        $this->db->where('rfc',$rfc);
        $query = $this->db->get('estacion_servicio');
        if($query->num_rows() == 0){
            return false;
        }
        return true;
    }

    private function obtenerEstacionServicioTieneDocumento($idEstacionServicio,$tipo='logo'){
        $this->db->where('id_estacion_servicio',$idEstacionServicio);
        $this->db->where('tipo',$tipo);
        $this->db->order_by('id_estacion_servicio_tiene_documento','desc');
        $this->db->limit(1);
        $query = $this->db->get('estacion_servicio_tiene_documento');
        if($query->num_rows() == 0){
            return false;
        }
        return $query->row();
    }

    private function obtenerCriteriosBusqueda($form_buscar){
        $queryAdicional = ' where 1=1';
        return $queryAdicional;
    }

    private function eliminarEmpleadosES($idEstacionServicio){
        $this->db->where('id_estacion_servicio',$idEstacionServicio);
        $query = $this->db->get('empleado_es');
        $result = $query->result();
        foreach ($result as $r){
            $this->db->where('id_empleado_es',$r->id_empleado_es);
            $this->db->delete('empleado_es');
            $this->db->where('id_usuario',$r->id_usuario);
            $this->db->delete('usuario');
        }
        return true;
    }

}

?>