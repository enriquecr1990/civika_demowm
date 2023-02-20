$(document).ready(function () {

    $('body').on('click','.agregar_nueva_formas_pago',function(e){
        e.isDefaultPrevented();
        FormaPago.agregar_modificar($(this));
    });

    $('body').on('click','.modificar_formas_pago',function(e){
        e.isDefaultPrevented();
        FormaPago.agregar_modificar($(this));
    });

    $('body').on('click','.eliminar_formas_pago',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_catalogo_formas_pago',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = FormaPago.validar_form();
        if(validar){
            FormaPago.guardar_catalogo(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_forma_pago',false);
                        FormaPago.trigger_buscar();
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_formas_pago');
                    }
                }
                );
        }
        Comun.btn_guardar_enable(btn);
    });

    /**
     * funciones/eventos inciales para los catalogos
     */
     Comun.funcion_tooltip();
     FormaPago.trigger_buscar();
 });

var FormaPago = {

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    //funciones de validacion de informacion
    validar_form : function () {
        $('.error').remove();
        //validacion del form con el jquery validate
        var form_valido = Comun.validar('#form_catalogo_formas_pago',FormaPago.reglas_validate());
        //validaciones secundarias
        if(form_valido){
            var numero_tarjeta = $('#input_numero_tarjeta').val();
            var cuenta_clabe = $('#input_clabe').val();
            var numero_cuenta = $('#input_cuenta').val();
            if(numero_tarjeta == '' && cuenta_clabe == '' && numero_cuenta == ''){
                form_valido = false;
                Comun.mensaje_operacion('error','Es necesario por lo menos un dato en número de cuenta, tarjeta o clabe');
            }

        }
        return form_valido;
    },

    guardar_catalogo : function (funcion) {
        Comun.enviar_formulario_post('form_catalogo_formas_pago', base_url + 'AdministrarCatalogos/guardar_catalogo_formas_pago', funcion);
    },

    //funciones para obtener informacion
    trigger_buscar : function(){
        $('#btn_buscar_formas_pago').trigger('click');
    },

    //funciones para guardar informacion
    agregar_modificar : function(btn_lnk){
        var id_catalogo_formas_pago = '';
        if(btn_lnk.data('id_catalogo_formas_pago') != undefined && btn_lnk.data('id_catalogo_formas_pago') != ''){
            id_catalogo_formas_pago = '/'+btn_lnk.data('id_catalogo_formas_pago');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCatalogos/agregar_modificar_formas_pago' + id_catalogo_formas_pago,{},
            function (response) {
                $('#conteiner_agregar_modificar_formas_pago').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_forma_pago',true);
                Comun.funcion_fileinput('Subir extra(s) logo(s)');
                FormaPago.iniciar_carga_formas_pago_logo();
            }
            );
    },

    iniciar_carga_formas_pago_logo : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadFormasPagoLogo').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {

            },
             //tiempo de ejecucion
             add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','#form_mensajes_curso_publicacion',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 5 Mb','#form_mensajes_curso_publicacion',8000);
                    goUpload = false;
                }if(goUpload){
                    data.submit();
                }
            },
            done:function (e,data) {
                var id_random = Math.floor(Math.random() * 10000000001);
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                    '<tr>' +
                    '<input type="hidden" name="cat_formas_pago_logos['+id_random+'][id_documento]" value="'+data.result.documento.id_documento+'">' +
                    '<td>'+data.result.documento.nombre+'</td>' +
                    '<td>' +
                    '<ul class="list-group">' +
                    '<li class="list-group-item">' +
                    '<a href="'+data.result.documento.ruta_documento+'" target="_blank"><img class="img-fluid" src="'+data.result.documento.ruta_documento+'"></a> ' +
                    '</li>' +
                    '</ul>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<button type="button" class="btn btn-danger btn-pill btn-sm eliminar_row_table_civik" data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
                    $('#tbodyFormasPagoLogo').append(html_respuesta);
                    Comun.funcion_popover();
                    $('.popoverShowImage').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_publicacion');
                }
            },
            error:function (xhr, ajaxOptions, thrownError) {
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

}
