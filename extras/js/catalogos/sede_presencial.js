$(document).ready(function(){

    $('body').on('click','.agregar_nueva_sede_presencial',function(e){
        e.isDefaultPrevented();
        SedePresencial.agregar_modificar($(this));
    });

    $('body').on('click','.modificar_sede_presencial',function(e){
        e.isDefaultPrevented();
        SedePresencial.agregar_modificar($(this));
    });

    $('body').on('click','.eliminar_sede_presencial',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_sede_presencial',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = SedePresencial.validar_form();
        if(validar){
            SedePresencial.guardar_sede_presencial(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_sede_presencial',false);
                        SedePresencial.trigger_buscar();
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_formas_pago');
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn);
    });


    SedePresencial.trigger_buscar();

});

var SedePresencial = {

    //funciones para obtener informacion
    trigger_buscar : function(){
        $('#btn_buscar_sedes_presenciales').trigger('click');
    },

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_sede_presencial',SedePresencial.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_sede_presencial : function (funcion) {
        Comun.enviar_formulario_post('form_sede_presencial', base_url + 'AdministrarCatalogos/guardar_sede_presencial', funcion);
    },

    //funciones para guardar informacion
    agregar_modificar : function(btn_lnk){
        var id_sede_presencial = '';
        if(btn_lnk.data('id_sede_presencial') != undefined && btn_lnk.data('id_sede_presencial') != ''){
            id_sede_presencial = '/'+btn_lnk.data('id_sede_presencial');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCatalogos/agregar_modificar_sede_presencial' + id_sede_presencial,{},
            function (response) {
                $('#conteiner_agregar_modificar_sede_presencial').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_sede_presencial',true);
            }
        );
    },

}