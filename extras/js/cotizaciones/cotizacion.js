$(document).ready(function(){

    $('body').on('click','#agregar_cotizacion_nueva',function(e){
        e.preventDefault();
        Cotizacion.agregar_modificar_cotizacion($(this));
    });

    $('body').on('click','.modificar_cotizacion',function(e){
        e.preventDefault();
        Cotizacion.agregar_modificar_cotizacion($(this));
    });

    $('body').on('click','.enviar_cotizacion_empresa',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_cotizacion',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cotizacion.validar_form_cotizacion();
        if(form_valido){
            Cotizacion.guardar_cotizacion(
                function(response){
                    if(response.success){
                        Comun.mostrar_modal_bootstrap('modal_cotizacion_curso',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cotizacion.trigger_buscar_cotizacion();
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                        Comun.btn_guardar_enable(btn,'Guardar cotización');
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Guardar cotización');
            Comun.mensaje_operacion('error','Campos requeridos en el formulario');
        }
    });

    $('body').on('click','.aceptar_cotizacion_empresa',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cotizacion.validar_form_cotizacion_empresa();
        if(form_valido){
            Cotizacion.guardar_acepta_cotizacion_empresa(
                function(response){
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.recargar_pagina(base_url + 'Cotizaciones/recibir/' + response.id_cotizacion,2500);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                        Comun.btn_guardar_enable(btn,'Enviar cotización');
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Enviar cotización');
            Comun.mensaje_operacion('error','Campos requeridos en el formulario');
        }
    });

    $('body').on('click','.checked_acepta_cotizacion',function(){
        var checked = $('input.checked_acepta_cotizacion:checked').val();
        if(checked == 'si'){
            $('#complemento_form_orden_compra').fadeIn();
        }else{
            $('#complemento_form_orden_compra').fadeOut();
        }
    });

    $('body').on('change','.rfc_empresa_cotizacion',function(e){
        e.preventDefault();
        Cotizacion.validar_rfc_dato_fiscal($(this));
    });

    Cotizacion.trigger_buscar_cotizacion();

});

var Cotizacion = {

    trigger_buscar_cotizacion : function (){
        $('#btn_buscar_cotizaciones').trigger('click');
        setTimeout(function () {
            Cotizacion.iniciar_carga_comprobante_xml();
            Cotizacion.iniciar_carga_comprobante_pdf();
        },1000);
    },

    validar_form_cotizacion : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_cotizacion_curso',Comun.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    validar_form_cotizacion_empresa : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_cotizacion_empresa',Comun.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    agregar_modificar_cotizacion : function (btn){
        var id_cotizacion = '';
        if(btn.data('id_cotizacion') != undefined && btn.data('id_cotizacion') != ''){
            id_cotizacion = '/' + btn.data('id_cotizacion');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'Cotizaciones/agregar_modificar_cotizacion' + id_cotizacion,
            {},
            function(respuesta){
                $('#contenedor_agregar_modificar_cotizacion').html(respuesta);
                Comun.mostrar_modal_bootstrap('modal_cotizacion_curso',true);
                Comun.funciones_datepicker(true);
            }
        );
    },

    guardar_cotizacion : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_cotizacion_curso', base_url + 'Cotizaciones/guardar_cotizacion_inicial', funcion);
    },

    guardar_acepta_cotizacion_empresa : function (funcion) {
        Comun.enviar_formulario_post('form_cotizacion_empresa', base_url + 'Cotizaciones/aceptar_cotizacion_empresa', funcion);
    },

    validar_rfc_dato_fiscal : function (input){
        var dato_rfc = input.val();
        $('#row_uso_cfdi_persona_fisica').fadeOut();
        $('#row_uso_cfdi_persona_moral').fadeOut();
        $('#input_datos_fiscales_uso_cfdi_fisica').val('');
        $('#input_datos_fiscales_uso_cfdi_moral').val('');
        var es_persona_fisica = false;
        var es_persona_moral = false;
        var rfc_valido = Comun.validar_rfc(dato_rfc) != null;
        if(rfc_valido){
            var tipo_persona = Comun.validar_rfc_fisica_moral(dato_rfc);
            if(tipo_persona == 'fisica'){
                $('#row_uso_cfdi_persona_fisica').fadeIn();
            }if(tipo_persona == 'moral'){
                $('#row_uso_cfdi_persona_moral').fadeIn();
            }
        }
    },

    iniciar_carga_comprobante_xml : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var id_cotizacion;
        $('.file_upload_comprobante_xml').fileupload({
            url : base_url + 'Uploads/upload_comprobante_xml_cotizacion',
            dataType: 'json',
            start: function () {
                //$('#div_conteiner_file_recibo_pago').html(loader_gif_transparente);
            },

            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                id_cotizacion = data.fileInput.data('id_cotizacion');
                data.formData = {
                    filename : nombre_archivo,
                    id_cotizacion: id_cotizacion
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_xml + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 5 Mb','',8000);
                    goUpload = false;
                }if(goUpload){
                    $('#carga_comprobante_xml_'+id_cotizacion).html('Cargando comprobante XML');
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    Cotizacion.trigger_buscar_cotizacion();
                }else{
                    Comun.mensaje_operacion('error',data.result.msg);
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','',8000);
            }
        });
    },

    iniciar_carga_comprobante_pdf : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var id_cotizacion;
        $('.file_upload_comprobante_pdf').fileupload({
            url : base_url + 'Uploads/upload_comprobante_pdf_cotizacion',
            dataType: 'json',
            start: function () {
                //$('#div_conteiner_file_recibo_pago').html(loader_gif_transparente);
            },

            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                id_cotizacion = data.fileInput.data('id_cotizacion');
                data.formData = {
                    filename : nombre_archivo,
                    id_cotizacion: id_cotizacion
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extencion_files_doc_pdf + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 5 Mb','',8000);
                    goUpload = false;
                }if(goUpload){
                    $('#carga_comprobante_xml_'+id_cotizacion).html('Cargando comprobante XML');
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    Cotizacion.trigger_buscar_cotizacion();
                }else{
                    Comun.mensaje_operacion('error',data.result.msg);
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','',8000);
            }
        });
    },

}