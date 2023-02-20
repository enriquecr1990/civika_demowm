$(document).ready(function(){

    $('body').on('click','.agregar_nueva_config_correo',function(e){
        e.isDefaultPrevented();
        SalidaCorreo.agregar_modificar_config_correo($(this));
    });

    $('body').on('click','.modificar_config_correo',function(e){
        e.isDefaultPrevented();
        SalidaCorreo.agregar_modificar_config_correo($(this));
    });

    $('body').on('click','.eliminar_config_correo',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_config_correo',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = SalidaCorreo.validar_form_salida_correo();
        if(validar){
            SalidaCorreo.guardar_config_correo(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_config_correo',false);
                        SalidaCorreo.trigger_buscar_config_correo();
                        Comun.btn_guardar_enable(btn);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
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

    $('body').on('click','.usar_correo_electronico',function () {
        Comun.mostrar_modal_confirmacion($(this));
    });

    SalidaCorreo.trigger_buscar_config_correo();

});

var SalidaCorreo = {

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form_salida_correo : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_config_correo',SalidaCorreo.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_config_correo : function (funcion) {
        Comun.enviar_formulario_post('form_config_correo', base_url + 'ConfiguracionSistema/guardar_config_correo', funcion);
    },

    //funciones para obtener informacion
    trigger_buscar_config_correo : function(){
        $('#btn_buscar_config_correo').trigger('click');
    },

    //funciones para guardar informacion
    agregar_modificar_config_correo : function(btn_lnk){
        var id_config_correo = '';
        if(btn_lnk.data('id_config_correo') != undefined && btn_lnk.data('id_config_correo') != ''){
            id_config_correo = '/'+btn_lnk.data('id_config_correo');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'ConfiguracionSistema/agregar_modificar_config_correo' + id_config_correo,
            {},
            function (response) {
                $('#conteiner_agregar_modificar_config_correo').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_config_correo',true);
            }
        );
    },

}