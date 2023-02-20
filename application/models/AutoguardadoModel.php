<?php

defined('BASEPATH') OR exit('No tiene access al script');

class AutoguardadoModel extends CI_Model{

    public function actualizar_campo_tabla($post_update){
        $tabla_update = $post_update['tabla_update'];
        $campo_update = $post_update['campo_update'];
        $id_campo_update = $post_update['id_campo_update'];
        $id_value_update = $post_update['id_value_update'];
        $value_update = isset($post_update['value_update']) && !is_null($post_update['value_update']) && $post_update['value_update'] != '' ? $post_update['value_update'] : null;
        $this->db->where($id_campo_update,$id_value_update);
        return $this->db->update($tabla_update,array($campo_update => $value_update));
    }

}

?>