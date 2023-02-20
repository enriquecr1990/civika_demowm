$(document).ready(function () {

    $('body').on('click','.agregar_ocupacion_especificia_area',function(e){
        e.isDefaultPrevented();
        Catalogos.agregar_modificar_ocupacion_especifica($(this));
    });

    $('body').on('click','.agregar_ocupacion_especificia_subarea',function(e){
        e.isDefaultPrevented();
        Catalogos.agregar_modificar_ocupacion_especifica($(this));
    });

    $('body').on('click','.modificar_ocupacion_especificia_area',function(e){
        e.isDefaultPrevented();
        Catalogos.agregar_modificar_ocupacion_especifica($(this));
    });

    $('body').on('click','.modificar_ocupacion_especificia_subarea',function(e){
        e.isDefaultPrevented();
        Catalogos.agregar_modificar_ocupacion_especifica($(this));
    });

    $('body').on('click','.guardar_catalogo_ocupacion_especifica',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Catalogos.validar_form_catalgo_ocupacion_especifica();
        if(validar){
            Catalogos.guardar_catalogo_ocupacion_especifica(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_ocupacion_especifica',false);
                        Catalogos.trigger_buscar_ocupaciones_especificas();
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_ocupacion_especifica');
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn);
    });

    /**
     * funciones/eventos inciales para los catalogos
     */
});

var Catalogos = {

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form_catalgo_ocupacion_especifica : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_catalogo_ocupacion_especifica',Catalogos.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_catalogo_ocupacion_especifica : function (funcion) {
        Comun.enviar_formulario_post('form_catalogo_ocupacion_especifica', base_url + 'AdministrarCatalogos/guardar_catalogo_ocupacion_especifica', funcion);
    },

    //funciones para obtener informacion
    trigger_buscar_ocupaciones_especificas : function(){
        $('#btn_buscar_ocupaciones_especificas').trigger('click');
    },

    //funciones para guardar informacion
    agregar_modificar_ocupacion_especifica : function(btn_lnk){
        var post = {
            tipo_ocupacion_especifica : btn_lnk.data('tipo_ocupacion_especifica')
        };
        if(btn_lnk.data('id_catalogo_ocupacion_especifica') != undefined && btn_lnk.data('id_catalogo_ocupacion_especifica') != ''){
            post['id_catalogo_ocupacion_especifica'] = btn_lnk.data('id_catalogo_ocupacion_especifica');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCatalogos/agregar_modificar_ocupacion_especifica',post,
            function (response) {
                $('#conteiner_agregar_modificar_ocupacion_especifica').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_ocupacion_especifica',true);
            }
        );
    },

}
