$(document).ready(function () {

    $('body').on('click','.popoverDescripcion',function(e){
        e.isDefaultPrevented();
        var titulo_curso = $(this).data('titulo_curso');
        var content_curso_html = $(this).data('content_curso_html');
        var content_html = $(content_curso_html).html();
        var placement = 'right';
        if($(this).data('aling_placement') != undefined && $(this).data('aling_placement') != ''){
            placement = $(this).data('aling_placement');
        }
        $(this).popover({
            html: true,
            trigger:'hover',
            title: titulo_curso,
            placement: placement,
            content : function (){
                return content_html
            }
        });
    });

    $('body').on('click','.btn_enviar_publicidad_correo',function(e){
        e.isDefaultPrevented();
        Index.enviar_correos_publicacion_ctn($(this));
    });

    Index.funcion_popover_curso();

    Comun.set_loader_page();
    Comun.hide_loader_page();

});

var Index = {

    funcion_popover_curso : function (){
        $('.popoverDescripcion').trigger('click');
    },

    enviar_correos_publicacion_ctn : function (btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        var html_btn = btn_lnk.html();
        Comun.btn_guardar_disabled(btn_lnk);
        btn_lnk.html('Enviando correos...');
        $.ajax({
            type: 'POST',
            url: base_url + 'AdministrarCTN/enviar_correos_publicacion_ctn/'+id_publicacion_ctn,
            data:{},
            dataType:'json',
            success:function(response){
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg);
                }else{
                    Comun.mensaje_operacion('success',response.msg);
                }
                Comun.btn_guardar_enable(btn_lnk,html_btn);
            },
            error: function (xhr) {
                alert(xhr.status);
                Comun.btn_guardar_enable(btn_lnk,html_btn);
            }
        });
    },

}