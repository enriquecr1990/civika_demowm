$(document).ready(function () {

    $('body').on('click','.test_modal_show',function(e){
        e.isDefaultPrevented();
        Test.lanzar_modal_demo($(this));
    });

    /**
     * funciones/eventos inciales para los catalogos
     */
});

var Test = {

    //funciones para guardar informacion
    lanzar_modal_demo : function(btn_lnk){
        var conteiner_modal = btn_lnk.data('conteiner_modal');
        var id_modal_show = btn_lnk.data('id_modal_show');
        var url_modal = btn_lnk.data('url_modal');
        Comun.obtener_contenido_peticion_html(
            url_modal,{},
            function (response) {
                $(conteiner_modal).html(response);
                Comun.mostrar_modal_bootstrap(id_modal_show,true);
            }
        );
    },

}
