<?php

defined('BASEPATH') OR exit('No tiene access al script');

class BitacoraModel extends CI_Model{

    public function bitacora_datos_personales($id_usuario,$post){
        $insert = array(
            'id_usuario' => $id_usuario,
            'seccion' => 'datos_personales',
            'fecha' => date('Y-m-d H:i:s'),
            'datos' => json_encode($post)
        );
        $this->db->insert('bitacora_datos_usuario',$insert);
        return $this->db->insert_id();
    }

    public function bitacora_datos_empresa($id_usuario,$post){
        $insert = array(
            'id_usuario' => $id_usuario,
            'seccion' => 'datos_empresa',
            'fecha' => date('Y-m-d H:i:s'),
            'datos' => json_encode($post)
        );
        $this->db->insert('bitacora_datos_usuario',$insert);
        return $this->db->insert_id();
    }

    public function bitacora_datos_registro_pago($id_usuario,$post){
        $insert = array(
            'id_usuario' => $id_usuario,
            'seccion' => 'datos_registro_pago',
            'fecha' => date('Y-m-d H:i:s'),
            'datos' => json_encode($post)
        );
        $this->db->insert('bitacora_datos_usuario',$insert);
        return $this->db->insert_id();
    }

    public function save_bitacora_error($msg_error){
        $CI = &get_instance();
        $data_usr = array('no_login' => true);
        if(!is_null($this->session->userdata('usuario'))){
            $data_usr = new stdClass();
            $usario_sistema = $this->session->userdata('usuario');
            $data_usr->id_usuario = $usario_sistema->id_usuario;
            $data_usr->usuario = $usario_sistema->usuario;
            $data_usr->correo = $usario_sistema->correo;
            $data_usr->telefono = $usario_sistema->telefono;
            $data_usr->usuario_sistema = $usario_sistema->usuario_sistema;
        }
        $insert = array(
            'fecha' => todayBD(),
            'controller' => $CI->uri->segments[1],
            'function' => $CI->uri->segments[2],
            'post_usr' => json_encode($data_usr),
            'respose_error' => utf8_encode($msg_error)
        );
        return $this->db->insert('bitacora_error',$insert);
    }
}

?>