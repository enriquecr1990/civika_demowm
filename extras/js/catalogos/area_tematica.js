$(document).ready(function () {

    $('body').on('click','.agregar_nueva_area_tematica',function(e){
        e.isDefaultPrevented();
        AreaTematica.agregar_modificar_area_tematica($(this));
    });

    $('body').on('click','.modificar_area_tematica',function(e){
        e.isDefaultPrevented();
        AreaTematica.agregar_modificar_area_tematica($(this));
    });

    $('body').on('click','.eliminar_aula_civika',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_catalogo_area_tematica',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = AreaTematica.validar_form_area_tematica();
        if(validar){
            AreaTematica.guardar_catalogo_area_tematica(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_area_tematica',false);
                        AreaTematica.trigger_buscar_area_tematica();
                        Comun.btn_guardar_enable(btn);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_area_tematica');
                        Comun.btn_guardar_enable(btn);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn);
        }
    });

    /**
     * funciones/eventos inciales para los catalogos
     */
    Comun.funcion_tooltip();
});

var AreaTematica = {

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form_area_tematica : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_catalogo_area_tematica',AreaTematica.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_catalogo_area_tematica : function (funcion) {
        Comun.enviar_formulario_post('form_catalogo_area_tematica', base_url + 'AdministrarCatalogos/guardar_catalogo_area_tematica', funcion);
    },

    //funciones para obtener informacion
    trigger_buscar_area_tematica : function(){
        $('#btn_buscar_areas_tematicas').trigger('click');
    },

    //funciones para guardar informacion
    agregar_modificar_area_tematica : function(btn_lnk){
        var id_catalogo_area_tematica = '';
        if(btn_lnk.data('id_catalogo_area_tematica') != undefined && btn_lnk.data('id_catalogo_area_tematica') != ''){
            id_catalogo_area_tematica = '/'+btn_lnk.data('id_catalogo_area_tematica');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCatalogos/agregar_modificar_area_tematica' + id_catalogo_area_tematica,{},
            function (response) {
                $('#conteiner_agregar_modificar_area_tematica').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_area_tematica',true);
            }
        );
    },

}
