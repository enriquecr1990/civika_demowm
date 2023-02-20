<?php

defined('BASEPATH') OR exit('No tiene access al script');

class CatalogosModel extends CI_Model{

    /**
     * metodos para obtener los catalogos del sistema CIVIK
     */
    public function obtenerCatalogoOpcionesPregunta(){
        $query = $this->db->get('catalogo_tipo_opciones_pregunta');
        return $query->result();
    }

    public function obtenerUsuarioSistema(){
        $catalogo = array(
            array('value' => 'admin','label' => 'Administrador'),
            array('value' => 'alumno','label' => 'Alumno'),
            array('value' => 'instructor','label' => 'Instructor'),
        );
        return $catalogo;
    }

    public function obtener_prioridad_cursos(){
        $catalogo = array(
            array('value' => '99999','label' =>'Fecha publicacion'),
            array('value' => '1','label' =>'1'),
            array('value' => '2','label' =>'2'),
            array('value' => '3','label' =>'3'),
            array('value' => '4','label' =>'4'),
            array('value' => '5','label' =>'5')
        );
        return $catalogo;
    }

    public function obtenerCatalogoAnio(){
        $anios = array();
        for ($i = 2017; $i <= date('Y');$i++){
            $anios[$i] = $i;
        }
        return $anios;
    }

    public function obtenerCatalogoTituloAcademico(){
        $this->db->order_by('orden_catalogo','asc');
        $query = $this->db->get('catalogo_titulo_academico');
        return $query->result();
    }

    public function obtenerOrdenamientoNorma(){
        $ordenamieto = array();
        for ($i = 1; $i < 13 ;$i++){
            $ordenamieto[$i] = $i;
        }
        return $ordenamieto;
    }

    public function obtenerCatalogoConstancias(){
        $this->db->order_by('id_catalogo_constancia','asc');
        $query = $this->db->get('catalogo_constancia');
        return $query->result();
    }

    public function obtenerCatalogoCoffeBreak(){
        $query = $this->db->get('catalogo_break_curso');
        return $query->result();
    }

    public function obtenerCatalogoFormasPago(){
        $query = $this->db->get('catalogo_formas_pago');
        $result = $query->result();
        foreach ($result as $r){
            $r->documento_logos = $this->get_logos_catalogos_formas_pago($r->id_catalogo_formas_pago);
        }
        return $result;
    }

    public function obtenerCatalogoFormasPagoAdmin(){
        $query = $this->db->get('catalogo_formas_pago');
        $result = $query->result();
        foreach ($result as $r){
            $r->documento_logos = $this->get_logos_catalogos_formas_pago($r->id_catalogo_formas_pago);
        }
        return $result;
    }

    public function obtener_catalogo_tipo_publicacion(){
        $query = $this->db->get('catalogo_tipo_publicacion');
        return $query->result();
    }

    //aulas
    public function obtenerCatalogoAulas(){
        $query = $this->db->get('catalogo_aula');
        return $query->result();
    }

    public function obtenerAulaById($idCatalogoAula){
        $this->db->where('id_catalogo_aula',$idCatalogoAula);
        $query = $this->db->get('catalogo_aula');
        return $query->row();
    }

    public function obtenerUsoCFDI($persona='fisica'){
        if($persona == 'fisica'){
            $this->db->where('aplica_p_fisica','si');
        }if($persona == 'moral'){
            $this->db->where('aplica_p_moral','si');
        }
        $query = $this->db->get('catalogo_uso_cfdi');
        return $query->result();
    }

    //ocupaciones_especificas
    public function obtenerCatalogoOcupacionesEspecificasTablero(){
        $result = $this->obtenerCatalogoOcupacionesEspecificasAreas();
        foreach ($result as $r){
            $r->subAreas = $this->obtenerCatalogoOcupacionesEspecificasAreas($r->id_catalogo_ocupacion_especifica);
        }
        return $result;
    } 
    public function obtenerCatalogoOcupacionEspecificaById($idCatalogoOcupacionEspecifica){
        $this->db->where('id_catalogo_ocupacion_especifica',$idCatalogoOcupacionEspecifica);
        $this->db->order_by('clave_area_subarea','asc');
        $query = $this->db->get('catalogo_ocupacion_especifica');
        return $query->row();
    }

    public function obtenerCatalogoOcupacionesEspecificasAreas($idOcuacionEspecifica = null){
        $this->db->where('id_catalogo_ocupacion_especifica_parent',$idOcuacionEspecifica);
        $this->db->order_by('clave_area_subarea','asc');
        $query = $this->db->get('catalogo_ocupacion_especifica');
        return $query->result();
    }
    //mis funciones
  public function obtenerTipoSanguineo($id_sanguineo){
        $this->db->where('id_tipo_sanguineo',$id_sanguineo);
        $query = $this->db->get('catalogo_sanguineo');
        return $query->result();
    }


    //areas tematicas
    public function obtenerCatalogoAreaTematica(){
        $query = $this->db->get('catalogo_area_tematica');
        return $query->result();
    }

    public function obtenerAreaTematicaById($idCatalogoAreaTematica){
        $this->db->where('id_catalogo_area_tematica',$idCatalogoAreaTematica);
        $query = $this->db->get('catalogo_area_tematica');
        return $query->row();
    }

    //formas de pago

    public function obtenerFormasPagoById($idCatalogoFormasPago){
        $this->db->where('id_catalogo_formas_pago',$idCatalogoFormasPago);
        $query = $this->db->get('catalogo_formas_pago');
        $row = $query->row();
        $row->documento_logos = $this->get_logos_catalogos_formas_pago($row->id_catalogo_formas_pago);
        return $row;
    }

    public function obtener_catalogo_tipo_cdc(){
        $query = $this->db->get('catalogo_tipo_cdc');
        return $query->result();
    }

    public function obtener_catalogo_proceso_cotizacion(){
        $query = $this->db->get('catalogo_proceso_cotizacion');
        return $query->result();
    }

    /**
     * apartado de funciones para guardar información de los catalogos
     */
    public function guardar_catalogo_ocupacion_especifica($post){
        if(isset($post['catalogo_ocupacion_especifica']['id_catalogo_ocupacion_especifica'])
            && $post['catalogo_ocupacion_especifica']['id_catalogo_ocupacion_especifica'] != ''){
            $this->update_catalogo_ocupacion_especifica($post['catalogo_ocupacion_especifica']['id_catalogo_ocupacion_especifica'],$post['catalogo_ocupacion_especifica']);
        }else{
            $this->insert_catalogo_ocupacion_especifica($post['catalogo_ocupacion_especifica']);
        }
        return true;
    }

    public function guardar_catalogo_aula($post){
        if(isset($post['catalogo_aula']['id_catalogo_aula'])
            && $post['catalogo_aula']['id_catalogo_aula'] != ''){
            $this->update_catalogo_aula($post['catalogo_aula']['id_catalogo_aula'],$post['catalogo_aula']);
        }else{
            $this->insert_catalogo_aula($post['catalogo_aula']);
        }
        return true;
    }

    public function guardar_catalogo_area_tematica($post){
        if(isset($post['catalogo_area_tematica']['id_catalogo_area_tematica'])
            && $post['catalogo_area_tematica']['id_catalogo_area_tematica'] != ''){
            $this->update_catalogo_area_tematica($post['catalogo_area_tematica']['id_catalogo_area_tematica'],$post['catalogo_area_tematica']);
        }else{
            $this->insert_catalogo_area_tematica($post['catalogo_area_tematica']);
        }
        return true;
    }

    public function guardar_catalogo_formas_pago($post){
        if(isset($post['catalogo_formas_pago']['id_catalogo_formas_pago'])
            && $post['catalogo_formas_pago']['id_catalogo_formas_pago'] != ''){
            $this->update_catalogo_formas_pago($post['catalogo_formas_pago']['id_catalogo_formas_pago'],$post['catalogo_formas_pago']);
        }else{
            $this->insert_catalogo_formas_pago($post['catalogo_formas_pago']);
        }
        return true;
    }

    public function guardar_detalle_pdf($post){
        if(isset($post['id_catalogo_forma_pago_detalle']) && $post['id_catalogo_forma_pago_detalle'] != ''){
            $this->db->where('id_catalogo_forma_pago_detalle',$post['id_catalogo_forma_pago_detalle']);
            $update = array(
                'descripcion' => isset($post['detalle_pdf']) ? $post['detalle_pdf'] : ''
            );
            $this->db->update('catalogo_forma_pago_detalle',$update);
        }return true;
    }

    /**
     * apartado de funciones para eliminar informacion de los catalogos
     */
    public function eliminar_aula($idCatalogoAula){
        $retorno['exito'] = true;
        $retorno['msg'] = '';
        if($this->get_aula_ocupada_curso_publicado($idCatalogoAula)){
            $retorno['exito'] = false;
            $retorno['msg'] = 'No es posible eliminar el aula, ya ha sido ocupada en algún curso del sistema';
        }
        $this->delete_catalago_aula_by_id($idCatalogoAula);
        return $retorno;

    }

    public function eliminar_area_tematica($idAreaTematica){
        $retorno['exito'] = true;
        $retorno['msg'] = '';
        if($this->get_area_tematica_ocupada($idAreaTematica)){
            $retorno['exito'] = false;
            $retorno['msg'] = 'No es posible eliminar el aula, ya ha sido ocupada en algún curso del sistema';
        }
        $this->delete_catalago_area_tematica_by_id($idAreaTematica);
        return $retorno;
    }

    public function eliminar_formas_pago($idCatalogoFormaPago){
        return $this->delete_catalago_formas_pago_by_id($idCatalogoFormaPago);
    }

    /**
     * seccion para guardar informacion de las sedes de civika
     */
    public function obtener_sedes_civika(){
        $query = $this->db->get('sede_presencial');
        $result = $query->result();
        foreach ($result as $r){
            $r->informe_sede = $this->obtener_informe_sede($r->id_sede_presencial);
        }
        return $result;
    }

    public function obtener_sede_civika($id_sede_presencial){
        $this->db->where('id_sede_presencial',$id_sede_presencial);
        $query = $this->db->get('sede_presencial');
        $row = $query->row();
        $row->informe_sede = $this->obtener_informe_sede($id_sede_presencial);
        return $row;
    }

    public function guardar_sede_presencial($post){
        if(isset($post['sede_presencial']['id_sede_presencial'])
            && $post['sede_presencial']['id_sede_presencial'] != ''){
            $this->update_sede_presencial($post['sede_presencial']['id_sede_presencial'],$post['sede_presencial']);
            $id_sede_presencial = $post['sede_presencial']['id_sede_presencial'];
        }else{
            $id_sede_presencial = $this->insert_sede_presencial($post['sede_presencial']);
        }
        $this->insertar_informe_sede_usuarios($id_sede_presencial,$post['informe_sede']);
        return true;
    }

    public function eliminar_sede_presencial($id_sede_presencial){
        $this->db->where('id_sede_presencial',$id_sede_presencial);
        return $this->db->delete('sede_presencial');
    }
///
    public function obtener_forma_pago_detalle(){
        $query = $this->db->get('catalogo_forma_pago_detalle');
        if($query->num_rows() == 0){
            $this->insertar_forma_pago_detalle();
            return $this->obtener_forma_pago_detalle();
        }
        return $query->row();
    }

  

     
    /**
     * apartado de funciones privadas
     */
    //get's
    private function insertar_forma_pago_detalle(){
            return $this->db->insert('catalogo_forma_pago_detalle',array('descripcion' => ''));
    }
    private function get_aula_ocupada_curso_publicado($idCatalogoAula){
        $this->db->where('id_catalogo_aula',$idCatalogoAula);
        $query = $this->db->get('instructor_asignado_curso_publicado');
        if($query->num_rows() == 0){
            return false;
        }return true;
    }

    private function get_area_tematica_ocupada($idCatalogoAreaTematica){
        $this->db->where('id_catalogo_area_tematica',$idCatalogoAreaTematica);
        $query = $this->db->get('curso_taller_norma');
        if($query->num_rows() == 0){
            return false;
        }return true;
    }

    private function get_logos_catalogos_formas_pago($id_catalogo_formas_pago){
        $consulta = "select d.* from documento d 
              inner join cat_formas_pago_logos cfg on cfg.id_documento = d.id_documento 
              where cfg.id_catalogo_formas_pago = $id_catalogo_formas_pago";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    private function obtener_informe_sede($id_sede_presencial){
        $consulta = "select 
                concat(u.nombre,u.apellido_p,u.apellido_m) nombre_contacto,
                u.telefono 
              from informe_sede i 
                inner join usuario u on i.id_usuario = u.id_usuario
              where i.id_sede_presencial = $id_sede_presencial";
        $query = $this->db->query($consulta);
        return $query->result();
    }

    //insert's
    private function insert_catalogo_ocupacion_especifica($insert){
        $this->db->insert('catalogo_ocupacion_especifica',$insert);
        return $this->db->insert_id();
    }

    private function insert_catalogo_aula($insert){
        $this->db->insert('catalogo_aula',$insert);
        return $this->db->insert_id();
    }

    private function insert_catalogo_area_tematica($insert){
        $this->db->insert('catalogo_area_tematica',$insert);
        return $this->db->insert_id();
    }

    private function insert_catalogo_formas_pago($insert){
        $this->db->insert('catalogo_formas_pago',$insert);
        return $this->db->insert_id();
    }

    private function insert_sede_presencial($insert){
        $this->db->insert('sede_presencial',$insert);
        return $this->db->insert_id();
    }

    private function insertar_informe_sede_usuarios($id_sede_presencial,$array_informe_sede){
        $this->db->where('id_sede_presencial',$id_sede_presencial);
        $this->db->delete('informe_sede');
        foreach ($array_informe_sede as $is){
            $insert['id_sede_presencial'] = $id_sede_presencial;
            $insert['id_usuario'] = $is;
            $this->db->insert('informe_sede',$insert);
        }return true;
    }

    //update's
    private function update_catalogo_ocupacion_especifica($idOcupacionEspecifica,$update){
        $this->db->where('id_catalogo_ocupacion_especifica',$idOcupacionEspecifica);
        return $this->db->update('catalogo_ocupacion_especifica',$update);
    }

    private function update_catalogo_aula($idAula,$update){
        $this->db->where('id_catalogo_aula',$idAula);
        return $this->db->update('catalogo_aula',$update);
    }

    private function update_catalogo_area_tematica($idAreaTematica,$update){
        $this->db->where('id_catalogo_area_tematica',$idAreaTematica);
        return $this->db->update('catalogo_area_tematica',$update);
    }

    private function update_catalogo_formas_pago($idFormasPago,$update){
        $this->db->where('id_catalogo_formas_pago',$idFormasPago);
        return $this->db->update('catalogo_formas_pago',$update);
    }

    private function update_sede_presencial($id_sede_presencial,$update){
        $this->db->where('id_sede_presencial',$id_sede_presencial);
        return $this->db->update('sede_presencial',$update);
    }

    //delete's
    private function delete_catalago_aula_by_id($idCatalogoAula){
        $this->db->where('id_catalogo_aula',$idCatalogoAula);
        return $this->db->delete('catalogo_aula');
    }

    private function delete_catalago_area_tematica_by_id($idAreaTematica){
        $this->db->where('id_catalogo_area_tematica',$idAreaTematica);
        return $this->db->delete('catalogo_area_tematica');
    }

    private function delete_catalago_formas_pago_by_id($idFormasPago){
        $this->db->where('id_catalogo_formas_pago',$idFormasPago);
        return $this->db->delete('catalogo_formas_pago');
    }

}

?>