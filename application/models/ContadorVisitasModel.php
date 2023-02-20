<?php

defined('BASEPATH') OR exit('No tiene access al script');

class ContadorVisitasModel extends CI_Model{

    /**
     * apartado de funciones publicas
     */
    public function obtener_visitas_sitio(){
        $consulta = "select 
              sum(vs.num_visita) total_visitas
            from visita_sitio vs";
        $query = $this->db->query($consulta);
        return $query->row()->total_visitas;
    }

    public function registro_contador_visitas(){
        //para poder usar modelos en el helper
        $id_usuario = null;
        $user = $this->session->userdata('usuario');
        if(isset($user) && !is_null($user) && $user !== false){
            $id_usuario = $user->id_usuario;
        }
        $dispositivo = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];

        //obtener la visita por la ip
        $visita_sitio = $this->obtener_visita_by_ip($ip);
        if($visita_sitio !== false){
            //validar si se actualiza la visita al sitio actualizar la vista
            $todayBD = date('YmdHis',strtotime(todayBD()));
            $ultimo_accesso = date('YmdHis',strtotime($visita_sitio->fecha_ultima_visita));
            //actualizar el registro de la visita si transcurrieron 5 horas
            $diff = $todayBD - $ultimo_accesso;
            if($diff >= 10000){
                $update = array(
                    'num_visita' => $visita_sitio->num_visita + 1,
                    'fecha_ultima_visita' => todayBD()
                );
                $this->actualizar_visita($visita_sitio->id_visita_sitio,$update);
            }
            if(!is_null($id_usuario)){
                $update = array('id_usuario' => $id_usuario);
                $this->actualizar_visita($visita_sitio->id_visita_sitio,$update);
            }
        }else{
            //insertar la visita nueva
            $todayBD = todayBD();
            $visita = array(
                'ip' => $ip,
                'num_visita' => 1,
                'fecha_primer_visita' => $todayBD,
                'fecha_ultima_visita' => $todayBD,
                'dispositivo' => $dispositivo,
                'id_usuario' => $id_usuario
            );
            $this->insertar_visita($visita);
        }
    }

    /**
     * apartado de funciones privadas
     */
    private function obtener_visita_by_ip($ip){
        //$this->db->where('ip',$ip);
        //$query = $this->db->get('visita_sitio');
        $consulta = "select 
                vs.*,
                TIMEDIFF(NOW(), vs.fecha_ultima_visita) timediff
            from visita_sitio vs 
                where vs.ip = '$ip'";
        $query = $this->db->query($consulta);
        if($query->num_rows() == 0){
            return false;
        }return $query->row();
    }

    private function insertar_visita($insert){
        return $this->db->insert('visita_sitio',$insert);
    }

    private function actualizar_visita($id_visita_sitio,$update){
        $this->db->where('id_visita_sitio',$id_visita_sitio);
        return $this->db->update('visita_sitio',$update);
    }

}

?>