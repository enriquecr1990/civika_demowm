<?php

defined('BASEPATH') OR exit('No tiene access al script');

class Cotizaciones_model extends CI_Model{

    public function __construct(){
        $this->load->model('DocumentosModel');
        $this->load->model('ControlUsuariosModel');
    }

    /**
     * apartado de funciones publicas para obtener informacion
     */

    public function obtener_data_cotizaciones($post,$pagina = 1, $limit = 5){
        $sql_limit = " limit ".(($pagina*$limit)-$limit).",$limit";
        $criterios_adicionales = $this->get_criterios_busqueda($post);
        $data['array_cotizaciones'] = $this->obtener_cotizaciones($sql_limit,$criterios_adicionales);
        $data['total_registros'] = $this->obtener_total_cotizaciones($criterios_adicionales);
        return $data;
    }

    public function obtener_cotizacion($id_cotizacion){
        $consulta = "select 
                  c.*,ctn.nombre,ctn.duracion
              from cotizacion c 
                  inner join curso_taller_norma ctn on c.id_curso_taller_norma = ctn.id_curso_taller_norma
              where c.id_cotizacion = $id_cotizacion";
        $query = $this->db->query($consulta);
        return $query->row();
    }

    public function obtener_datos_fiscales_cotizales($id_cotizacion){
        $this->db->where('id_cotizacion',$id_cotizacion);
        $query = $this->db->get('datos_fiscales');
        return $query->row();
    }

    /**
     * apartade de funciones para guardar informacion
     */

    public function guardar_cotizacion_inicial($post){
        if(existe_valor($post['cotizacion']['id_cotizacion'])){
            $post['cotizacion']['fecha_fin_vigencia'] = fechaHtmlToBD($post['cotizacion']['fecha_fin_vigencia']);
            return $this->actualizar_cotizacion($post['cotizacion']);
        }else{
            return $this->insertar_cotizacion_nueva($post['cotizacion']);
        }
    }

    public function aceptar_cotizacion_empresa($post){
        if(isset($post['uso_cfdi_fisica']) && existe_valor($post['uso_cfdi_fisica'])){
            $post['datos_fiscales']['id_catalogo_uso_cfdi'] = $post['uso_cfdi_fisica'];
        }if(isset($post['uso_cfdi_moral']) && existe_valor($post['uso_cfdi_moral'])){
            $post['datos_fiscales']['id_catalogo_uso_cfdi'] = $post['uso_cfdi_moral'];
        }
        if($post['acepta_cotizacion'] == 'si'){
            $post['cotizacion']['fecha_orden_compra'] = todayBD();
            $post['cotizacion']['id_catalogo_proceso_cotizacion'] = COTIZACION_ORDEN_COMPRA;
            $this->actualizar_cotizacion($post['cotizacion']);
            $post['datos_fiscales']['id_cotizacion'] = $post['cotizacion']['id_cotizacion'];
            $this->actualiazar_datos_fiscales_cotizacion($post['cotizacion']['id_cotizacion'],$post['datos_fiscales']);
        }else{
            $post['cotizacion']['id_catalogo_proceso_cotizacion'] = COTIZACION_CERRADA_CANCELADA;
            $this->actualizar_cotizacion($post['cotizacion']);
            $this->insertar_datos_fiscales_cotizacion($post['datos_fiscales']);
        }return true;
    }

    public function actualizar_cotizacion($cotizacion){
        $this->db->where('id_cotizacion',$cotizacion['id_cotizacion']);
        return $this->db->update('cotizacion',$cotizacion);
    }

    public function actualizar_cotizacion_publicacion($id_publicacion_ctn,$update){
        $this->db->where('id_publicacion_ctn',$id_publicacion_ctn);
        return $this->db->update('cotizacion',$update);
    }

    /**
     * apartado de funciones privadas
     */
    private function get_criterios_busqueda($post){
        $criterios = '';
        if(isset($post['nombre_dc3']) && $post['nombre_dc3'] != ''){
            $criterios .= " and ctn.nombre like '%".$post['nombre_dc3']."%'";
        }if(isset($post['folio_cotizacion']) && $post['folio_cotizacion'] != ''){
            $criterios .= " and c.folio_cotizacion like '%".$post['folio_cotizacion']."%'";
        }if(isset($post['fecha_cotizacion']) && $post['fecha_cotizacion'] != ''){
            $criterios .= " and c.fecha_cotizacion = '%".fechaHtmlToBD($post['fecha_cotizacion'])."%'";
        }
        return $criterios;
    }

    private function obtener_cotizaciones($sql_limit,$criterios_adicionales){
        //$documento->ruta_documento = base_url().$documento->ruta_directorio.$documento->nombre;
        $base_url = base_url();
        $today = todayBD();
        $consulta = "select 
              c.*,ctn.nombre,
              DATEDIFF(date_format(c.fecha_fin_vigencia,'%Y-%m-%d'),date_format('$today','%Y-%m-%d')) dias_vigencia,
              if(c.id_catalogo_proceso_cotizacion > 3 and c.id_catalogo_proceso_cotizacion < 8, c.id_catalogo_proceso_cotizacion,
                if(DATEDIFF(date_format(c.fecha_fin_vigencia,'%Y-%m-%d'),date_format('$today','%Y-%m-%d')) < 0, 8,c.id_catalogo_proceso_cotizacion)
              )id_catalogo_proceso_cotizacion,
              if(c.id_documento_factura_xml is null,false,concat('$base_url',dxml.ruta_directorio,dxml.nombre) ) comprobante_xml,
              if(c.id_documento_factura_pdf is null,false,concat('$base_url',dpdf.ruta_directorio,dpdf.nombre) ) comprobante_pdf
            from cotizacion c
              inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = c.id_curso_taller_norma
              left join documento dxml on dxml.id_documento = c.id_documento_factura_xml
              left join documento dpdf on dpdf.id_documento = c.id_documento_factura_pdf
            where 1=1 $criterios_adicionales $sql_limit";
        $query = $this->db->query($consulta);
        //echo '<pre>'.$consulta;exit;
        return $query->result();
    }

    private function obtener_total_cotizaciones($criterios_adicionales){
        $consulta = "select 
              count(c.id_cotizacion) cotizaciones 
            from cotizacion c
              inner join curso_taller_norma ctn on ctn.id_curso_taller_norma = c.id_curso_taller_norma
            where 1=1 $criterios_adicionales";
        $query = $this->db->query($consulta);
        return $query->row()->cotizaciones;
    }

    private function insertar_cotizacion_nueva($insert){
        $insert['folio_cotizacion'] = $this->get_folio_cotizacion();
        $insert['fecha_cotizacion'] = todayBD();
        $insert['fecha_fin_vigencia'] = fechaHtmlToBD($insert['fecha_fin_vigencia']);
        $insert['id_catalogo_proceso_cotizacion'] = COTIZACION_REALIZADA;
        $this->db->insert('cotizacion',$insert);
        return $this->db->insert_id();
    }

    private function insertar_datos_fiscales_cotizacion($insert){
        $this->db->insert('datos_fiscales',$insert);
        return $this->db->insert_id();
    }

    private function actualiazar_datos_fiscales_cotizacion($id_cotizacion,$update){
        $this->db->where('id_cotizacion',$id_cotizacion);
        return $this->db->update('datos_fiscales',$update);
    }

    private function get_folio_cotizacion(){
        $date = date('Y-m');
        $cotizaciones = $this->obtener_cotizaciones_to_folio($date);
        return $this->get_consecutivo($cotizaciones+1);
    }

    private function obtener_cotizaciones_to_folio($date){
        $consulta = "select count(c.id_cotizacion) cotizaciones
                from cotizacion c 
            where date_format(c.fecha_cotizacion,'%Y-%m') = '$date'";
        $query = $this->db->query($consulta);
        return $query->row()->cotizaciones;
    }

    private function get_consecutivo($cotizaciones){
        $date = date('Ym');
        $consecutivo = 'CVK-'.$date.'-';
        if($cotizaciones > 0 && $cotizaciones < 10){
            $consecutivo .= '000'.$cotizaciones;
        }if($cotizaciones >= 10 && $cotizaciones < 100){
            $consecutivo .= '00'.$cotizaciones;
        }if($cotizaciones >= 100 && $cotizaciones < 1000){
            $consecutivo .= '0'.$cotizaciones;
        }if($cotizaciones >= 1000 && $cotizaciones < 10000){
            $consecutivo .= ''.$cotizaciones;
        }return $consecutivo;
    }
}

?>