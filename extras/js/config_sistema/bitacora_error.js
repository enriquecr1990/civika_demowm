$(document).ready(function(){

    $('body').on('click','.btn_view_conteiner',function(e){
        e.preventDefault();
        BitacoraErrores.mostrar_modal_view_bitacora_error($(this));
    });

    BitacoraErrores.trigger_buscar_bitacora_errores();
    Comun.funciones_datepicker();

});

var BitacoraErrores = {

    //funciones para obtener informacion
    trigger_buscar_bitacora_errores : function(){
        $('#btn_buscar_bitacora_errores').trigger('click');
    },

    mostrar_modal_view_bitacora_error : function(btn_lnk){
        var id_bitacora_error = '';
        if(btn_lnk.data('id_bitacora_error') != undefined && btn_lnk.data('id_bitacora_error') != ''){
            id_bitacora_error = '/'+btn_lnk.data('id_bitacora_error');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'ConfiguracionSistema/cargar_modal_bitacora_error' + id_bitacora_error,
            {},
            function (response) {
                $('#contenedor_modal_vista_bitacora_error').html(response);
                var json_bitacora_error = $('#content_json_bitacora_error').html();
                json_bitacora_error = $.parseJSON(json_bitacora_error);
                $('#content_json_bitacora_error').jsonViewer(json_bitacora_error,{collapsed: true,withQuotes: false});
                Comun.mostrar_modal_bootstrap('modal_bitacora_error_view',true);
            }
        );
    },

}