$(document).ready(function () {

    $('body').on('click','.agregar_nueva_aula',function(e){
        e.isDefaultPrevented();
        Aulas.agregar_modificar_aula($(this));
    });

    $('body').on('click','.modificar_aula',function(e){
        e.isDefaultPrevented();
        Aulas.agregar_modificar_aula($(this));
    });

    $('body').on('click','.eliminar_aula_civika',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_catalogo_aula',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Aulas.validar_form_aula();
        if(validar){
            Aulas.guardar_catalogo_aula(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_aula',false);
                        Aulas.trigger_buscar_aulas();
                        Comun.btn_guardar_enable(btn);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_aula');
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

var Aulas = {

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form_aula : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_catalogo_aula',Aulas.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_catalogo_aula : function (funcion) {
        Comun.enviar_formulario_post('form_catalogo_aula', base_url + 'AdministrarCatalogos/guardar_catalogo_aula', funcion);
    },

    //funciones para obtener informacion
    trigger_buscar_aulas : function(){
        $('#btn_buscar_aulas').trigger('click');
    },

    //funciones para guardar informacion
    agregar_modificar_aula : function(btn_lnk){
        var id_catalogo_aula = '';
        if(btn_lnk.data('id_catalogo_aula') != undefined && btn_lnk.data('id_catalogo_aula') != ''){
            id_catalogo_aula = '/'+btn_lnk.data('id_catalogo_aula');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCatalogos/agregar_modificar_aula' + id_catalogo_aula,
            {},
            function (response) {
                $('#conteiner_agregar_modificar_aula').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_aula',true);
            }
        );
    },

}
