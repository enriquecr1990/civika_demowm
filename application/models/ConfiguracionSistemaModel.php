<?php

defined('BASEPATH') OR exit('No tiene access al script');

class ConfiguracionSistemaModel extends CI_Model{

    /**
     * funciones para la configuracion del correo
     */
    public function obtener_listado_config_correo(){
        $query = $this->db->get('config_correo');
        return $query->result();
    }

    public function obtener_config_correo($id_config_correo){
        $this->db->where('id_config_correo',$id_config_correo);
        $query = $this->db->get('config_correo');
        return $query->row();
    }

    public function obtener_config_correo_default_array(){
        $this->db->where('active','si');
        $query = $this->db->get('config_correo');
        return $query->row_array();
    }

    public function guardar_configuracion_correo($register){
        if(isset($register['id_config_correo']) && $register['id_config_correo'] != ''){
            return $this->update_configuracion_correo($register['id_config_correo'],$register);
        }else{
            return $this->insert_config_correo($register);
        }
    }

    public function set_default_config_correo($id_config_correo){
        $this->desactivar_all_config_correo();
        $this->db->where('id_config_correo',$id_config_correo);
        return $this->db->update('config_correo',array('active' => 'si'));
    }

    private function insert_config_correo($insert){
        $this->db->insert('config_correo',$insert);
        return $this->db->insert_id();
    }

    private function update_configuracion_correo($id_config_correo,$update){
        $this->db->where('id_config_correo',$id_config_correo);
        return $this->db->update('config_correo',$update);
    }

    private function desactivar_all_config_correo(){
        return $this->db->update('config_correo',array('active' => 'no'));
    }

    /**
     * funciones para el tablero de la bitacora de errores
     */
    public function listado_errores($post){
        $fecha_busqueda = isset($post['fecha']) && existe_valor($post['fecha']) ? fechaHtmlToBD($post['fecha']):todayBD();
        $consulta = "select * from bitacora_error be 
              where date_format(be.fecha,'%Y-%m-%d') = date_format('$fecha_busqueda','%Y-%m-%d')";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    public function obtener_bitacora_error($id_bitacora_error){
        $this->db->where('id_bitacora_error',$id_bitacora_error);
        $query = $this->db->get('bitacora_error');
        return $query->row();
    }

}

?>