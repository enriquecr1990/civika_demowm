$(document).ready(function () {

    $('body').on('click','.buscar_comun_civik',function(e){
        //e.isDefaultPrevented();
        Comun.busqueda_registros_comun($(this));
    });

    $('body').on('change','.input_checkbox_change',function(e){
        e.isDefaultPrevented();
        Comun.input_checkbox_change_value($(this));
    });

    $('body').on('click','.eliminar_row_table_civik',function(e){
        e.isDefaultPrevented();
        $(this).closest('tr').remove();
    });

    $('body').on('click','.popoverShowImage',function () {
        var src_img = $(this).data('src_image');
        var nombre_archivo = $(this).data('nombre_archivo');
        var width_img = '220px';
        var height_img = '120px';
        if($(this).data('width_img') != undefined && $(this).data('width_img') != ''){
            width_img = $(this).data('width_img');
        }if($(this).data('height_img') != undefined && $(this).data('height_img') != ''){
            height_img = $(this).data('height_img');
        }
        $(this).popover({
            html :true,
            trigger: 'hover',
            title: nombre_archivo,
            //placement: 'top',
            content: function () {
                return '<img src="'+src_img+'" width="'+width_img+'" height="'+height_img+'" />'
            }
        });
    });

    $('body').on('change','.slt_change_system_civik',function(e){
        e.isDefaultPrevented();
        var value = $(this).val()
        var value_show = $(this).data('value_show');
        var destino_show = $(this).data('destino_show');
        var type_input_destino = $(this).data('type_input_destino');
        $(destino_show).find(type_input_destino).val('');
        $(destino_show).fadeOut();
        if(value == value_show){
            $(destino_show).fadeIn();
        }
    });

    $('body').on('change','.civika_mayus',function(e){
        e.isDefaultPrevented();
        Comun.str_mayus($(this));
    });

    $('body').on('click','.aceptar_mensaje_confirmacion',function () {
        Comun.confirmar_eliminar_registro($(this));
    });

    $('body').on('click','.checkbox_change_show_hide',function(){
        var id_val_show = $(this).data('id_val_show');
        var div_show = $(this).data('div_show');
        var id_checked = $(this).val();
        var is_checked = $(this).is(':checked');
        if(id_val_show == id_checked){
            $(div_show).fadeOut();
            $(div_show).find('input').val();
            $(div_show).find('select').val();
            $(div_show).find('textarea').val();
            if(is_checked){
                $(div_show).fadeIn();
            }
        }
    });

    $('body').on('click','.radio_change_show_hide',function(){
        var id_val_show = $(this).data('id_val_show_radio');
        var div_show = $(this).data('div_show_radio');
        var id_checked = $(this).val();
        var is_checked = $(this).is(':radio');
        if(id_val_show == id_checked){
            $(div_show).fadeOut();
            $(div_show).find('input').val();
            $(div_show).find('select').val();
            $(div_show).find('textarea').val();
            if(is_checked){
                $(div_show).fadeIn();
            }
        }
    });

    $('body').on('change','.change_input_paginacion',function(e){
        e.isDefaultPrevented();
        Comun.busqueda_registros_comun_paginacion($(this));
    });

    $('body').on('change','.input_buscar_change',function(e){
        e.isDefaultPrevented();
        Comun.trigger_buscar_comun($(this));
    });

    $('body').on('click','.btn_copiar_link',function(e){
        e.isDefaultPrevented();
        var id_contenido_copiar = $(this).data('url_to_copy');
        Comun.copiar_link_al_portapapeles(id_contenido_copiar);
    });

    $('body').on('change','.civika_actualizacion_campo',function(e){
        e.preventDefault();
        Comun.autoguardado_campo_formulario($(this));
    });

    $('body').on('click','.eliminar_registro_table_comun',function(e){
        e.preventDefault();
        Comun.mostrar_modal_confirmacion($(this));
    });

    //funcion para trabajar modal sobre modal
    //para usarla se llama a la id de la modal a la que se quiere cerrar
    //que en este caso, seria la modal misma, en vez de usar el
    //data-dismiss, ya que en modal sobre modal, cierra a todas
    //las modales.
    $('body').on('click','.cerrar_modal_civika',function (e) {
        e.preventDefault();
        var id_modal_cerrar = $(this).data('id_modal');
        Comun.mostrar_modal_bootstrap(id_modal_cerrar,false);
    });

    Comun.mensaje_ocultar_inicio_sistema();
    Comun.funcion_tooltip();
    //ejemplo para disparar una notificacion de watnotif
    Comun.msg_flash_data();

});

var Comun = {
    /*
     * funcion para validar un formulario con jquery validate
     * se necesita el ID del formulario y reglas adicionales
     * estas reglas adicionales son por campo de un formulario
     * de ser neceario
     */
    validar : function (id_form,options){
        var validator = $(id_form).validate(options);
        validator.form();
        var result = validator.valid();
        return result;
    },

    reglas_validate : function () {
        //var rules = {};
        var rules = {
            errorElement: "span",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block invalid-feedback" );

                // Add `has-feedback` class to the parent div.form-group
                // in order to add icons to inputs
                element.parents( ".form-group" ).addClass( "has-feedback" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {
                    error.insertAfter( element );
                }

                // Add the span element, if doesn't exists, and apply the icon classes to it.
            },
            success: function ( label, element ) {
                // Add the span element, if doesn't exists, and apply the icon classes to it.
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                //$( element ).next( "span" ).addClass( "fa-exclamation" ).removeClass( "fa-check" );
            },
            unhighlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                //$( element ).next( "span" ).addClass( "fa-check" ).removeClass( "fa-exclamation" );
            }
        }
        return rules;
    },

    validar_curp : function(stringValidar){
        //return stringValidar.match(/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[0-9]{2}$/);//
        return stringValidar.match(/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[A-Z0-9]{1}[0-9]{1}$/);
    },

    validar_rfc : function(stringValidar){
        return stringValidar.match(/^[A-ZÑ]{3,4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3}$/);
    },

    validar_rfc_fisica_moral : function(rfc){
        var size = rfc.length;
        if(size == 13){
            return 'fisica';
        }if(size == 12){
            return 'moral';
        }
    },

    validar_correo : function(stringValidar){
        return stringValidar.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    },

    mostrar_modal_bootstrap : function(id_modal,mostrar,position_centered = false){
        if(position_centered){
            $('#'+id_modal).find('div.modal-dialog').addClass('modal-dialog-centered');
        }
        if(mostrar){
            $('#'+id_modal).modal({backdrop: 'static', keyboard: false});
            $('#'+id_modal).modal('show');
        }else{
            $('#'+id_modal).modal('hide');
        }
    },

    /*mensaje_operacion : function (type,msg,destino,time) {
        var id_random = Math.floor(Math.random() * 10000000001);
        var conteiner_mensajes = '#conteiner_mensajes_civik';
        var time_msg = 12000;
        var type_icon = 'exclamation-circle';
        if(destino != undefined && destino != ''){
            conteiner_mensajes = destino;
        }if(time != undefined && time != ''){
            time_msg = time;
        }
        if(type == 'danger'){
            type_icon = 'exclamation-triangle';
        }
        var html_respuesta = '' +
            '<div id="alert_mensaje_'+id_random+'" class="alert alert-'+type+' alert-dismissible">' +
                '<button id="btn_close_alert_'+id_random+'" style="color: white" type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<i class="fa fa-close"></i>' +
                '</button> ' +
                '<div class="row">' +
                    '<div class="form-group col-lg-2 col-md-2 col-sm-2 text-center">' +
                        '<i class="fa fa-'+type_icon+' fa-2x"></i>' +
                    '</div>' +
                    '<div class="form-group col-lg-10 col-md-10 col-sm-10 text-left"><label>Información del sistema</label></div>' +
                '</div>' +
                '<div class="row"><div class="form-group col-lg-12 col-md-12 col-sm-12">'+msg+'</div></div>' +
            '</div>';
        $(conteiner_mensajes).append(html_respuesta);
        $('#alert_mensaje_'+id_random).fadeIn();
        setTimeout(function () {
            $('#btn_close_alert_'+id_random).trigger('click');
        },time_msg);
    },*/

    mensaje_operacion : function(type,msg,destino,time){
        var time_growl = 6000;
        if(time != undefined && time != '' && time > 6000){
            time_growl = parseInt(time);
        }
        new Notif(msg,type).display(time_growl);
    },

    mensaje_operacion_modal : function (type, msg,btn_extra = undefined){
        var str_btn_extra = btn_extra != undefined && btn_extra != '' ? btn_extra : '';
        var html_modal = '' +
            '<div class="modal fade" role="dialog" id="modal_mensaje_operacion">' +
                '<div class="modal-dialog" role="document"> ' +
                    '<div class="modal-content"> ' +
                        '<div class="modal-header card-header"> ' +
                            '<h5 class="modal-title">Mensaje del sistema</h5> ' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                            '<div class="form-group" style="text-align: center">' +
                                '<div class="col-sm-12">' +
                                    '<div class="alert alert-'+type+'">'+msg+'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                            '' + btn_extra +
                            '<button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cerrar</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('#conteiner_modal_confirmacion').html(html_modal);
        Comun.mostrar_modal_bootstrap('modal_mensaje_operacion',true);
    },

    mensaje_operacion_modal_sin_cerrar : function (type, msg,btn_extra = undefined){
        var str_btn_extra = btn_extra != undefined && btn_extra != '' ? btn_extra : '';
        var html_modal = '' +
            '<div class="modal fade" role="dialog" id="modal_mensaje_operacion">' +
                '<div class="modal-dialog" role="document"> ' +
                    '<div class="modal-content"> ' +
                        '<div class="modal-header card-header"> ' +
                            '<h5 class="modal-title">Mensaje del sistema</h5> ' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                            '<div class="form-group" style="text-align: center">' +
                                '<div class="col-sm-12">' +
                                    '<div class="alert alert-'+type+'">'+msg+'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('#conteiner_modal_confirmacion').html(html_modal);
        Comun.mostrar_modal_bootstrap('modal_mensaje_operacion',true);
    },

    mostrar_modal_confirmacion : function(btn_lnk){
        var url = btn_lnk.data('url_operacion');
        var msg_operacion = btn_lnk.data('msg_operacion');
        var btn_trigger = btn_lnk.data('btn_trigger');
        var remove_html = btn_lnk.data('remove_html');
        var msg_show_growl = btn_lnk.data('msg_show_growl');
        var html_modal_confirmacion = '' +
            '<div class="modal fade" role="dialog" id="modal_confirmar_operacion">' +
                '<div class="modal-dialog" role="document"> ' +
                    '<div class="modal-content"> ' +
                        '<div class="modal-header card-header"> ' +
                            '<h5 class="modal-title">Mensaje de confirmación</h5> ' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' +
                        '</div>' +
                        '<form class="form-horizontal" id="form_enviar_mensaje_confirmacion">' +
                            '<div id="error_operacion"></div>' +
                            '<div class="modal-body">' +
                                '<div class="form-group" style="text-align: center">' +
                                    '<div class="col-sm-12">' +
                                        '<div class="alert alert-danger">'+msg_operacion+'</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal-footer" style="text-align: center;">' +
                                '<button type="button" class="btn btn-success btn-sm aceptar_mensaje_confirmacion" ' +
                                    'data-eliminar_row_html="'+remove_html+'"' +
                                    'data-url_eliminar="'+url+'" data-btn_trigger="'+btn_trigger+'" data-msg_show_growl="'+msg_show_growl+'" >Aceptar</button> ' +
                                '<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>' +
                            '</div>' +
                        '</form>' +
                    '</div>' +
                '</div>' +
            '</div>';
        $('#conteiner_modal_confirmacion').html(html_modal_confirmacion);
        Comun.mostrar_modal_bootstrap('modal_confirmar_operacion',true);
    },

    confirmar_eliminar_registro : function (btn) {
        var url = btn.data('url_eliminar');
        var btn_trigger = btn.data('btn_trigger');
        var eliminar_html = btn.data('eliminar_row_html');
        var msg_show_growl = btn.data('msg_show_growl');
        Comun.btn_guardar_disabled(btn);
        $.ajax({
            type: "POST",
            url: url,
            data: {},
            dataType: "json",
            success:function (respuesta) {
                if(respuesta.exito){
                    Comun.mensaje_operacion('confirmed',respuesta.msg,msg_show_growl);
                    Comun.mostrar_modal_bootstrap('modal_confirmar_operacion',false);
                    if(btn_trigger != undefined && btn_trigger != ''){
                        $(btn_trigger).trigger('click');
                    }if(eliminar_html != undefined && eliminar_html != ''){
                        $(eliminar_html).remove();
                    }
                }else{
                    Comun.mensaje_operacion('error',respuesta.msg);
                }
                Comun.btn_guardar_enable(btn);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                Comun.btn_guardar_enable(btn);
            }
        });
    },

    //funcion para obtener el html como respuesta de una peticion de un controllador
    obtener_contenido_peticion_html : function (url,parametros,processor,metodo) {
        //if(Comun.validar_login_sistema()){
            if (!metodo) {
                metodo = "POST";
            }
            $.ajax({
                type : metodo,
                data : parametros,
                dataType: "html",
                url : url,
                success : function (data) {
                    processor(data,true);
                },
                error : function (xhr,ajaxOptions,thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    processor("No se pudo establecer con el servidor",false);
                }
            });
        // }else{
        //     Comun.mensaje_operacion('danger','La session del sistema caduco, inicie nuevamente');
        //     Comun.recargar_pagina(base_url + 'Login',3000);
        // }
    },

    obtener_contenido_peticion_json : function (url,parametros,processor,metodo) {
        //if(Comun.validar_login_sistema()){
            if (!metodo) {
                metodo = "POST";
            }
            $.ajax({
                type : metodo,
                data : parametros,
                dataType: "json",
                url : url,
                success : function (data) {
                    processor(data,true);
                },
                error : function (xhr,ajaxOptions,thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    processor("No se pudo establecer con el servidor",false);
                }
            });
        // }else{
        //     Comun.mensaje_operacion_modal('danger','La session del sistema caduco, inicie nuevamente');
        //     Comun.recargar_pagina(base_url + 'Login',3000);
        // }
    },

    enviar_formulario_post : function (id_formulario,url,processor,parametros) {
        $.ajax({
            type : "POST",
            url : url,
            data : $('#'+id_formulario).serialize()+Comun.serializar_json_formulario(parametros),
            dataType : "json",
            success:function (data) {
                processor(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                //alert(thrownError);
                processor(errorResponse);
            }
        });
    },

    //funcion que nos devuel el post de un formulario para enviarlo al controller
    obtener_post_formulario : function (id_formulario) {
        return $('#'+id_formulario).serialize()+Comun.serializar_json_formulario(undefined);
    },

    //funcion que nos permite serializar en json el post un formulario
    serializar_json_formulario : function (json) {
        var strSerialized = '';
        if(json != null){
            $.each(json,function (key,value) {
                strSerialized += strSerialized == "" ? '&'+key+'='+value : '&'+key+'='+value;
            });
        }
        return strSerialized;
    },

    funcion_popover : function () {
        $('.popoverShow').popover();
    },

    funcion_popover_hover : function(){
        var span_notificaciones = $('#span_notificaciones');
        span_notificaciones.popover({
            html: true,
            placement: 'bottom',
            content : function(){
                var content_html = span_notificaciones.data('content_html');
                return $(content_html).html();
            }
        });
    },

    funcion_tooltip : function () {
        $('[data-toggle="tooltip"]').tooltip();
    },

    funcion_fileinput : function(strLabel){
        var strEtiqueta = 'Examinar';
        if(strLabel != undefined && strLabel != ''){
            strEtiqueta = strLabel;
        }
        $('.file').fileinput({
            showCaption: false,
            showPreview: false,
            showUpload: false,
            showRemove: false,
            removeLabel: '',
            removeIcon: '<i class="fa fa-upload"></i> ',
            browseClass: 'btn btn-info btn-sm btn-pill',
            browseLabel: strEtiqueta,
            browseIcon: '<i class="fa fa-upload"></i>&nbsp;',
        });
    },

    funciones_datepicker : function (disableddays) {
        var attrs = {
            clearBtn: true,
            weekStart: 0,
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true,
        };
        var attrs_extras = {};
        if(disableddays != undefined && disableddays != '' && disableddays == true){
            attrs_extras = {
                startDate: tomorrow
            };
        }
        attrs = Comun.assing_array(attrs,attrs_extras);
        $('.datepicker_shards').datepicker(attrs);
    },

    funcion_select2 : function(){
        $('.select2').select2({
            placeholder: 'Seleccione',
        });
    },

    funcion_agregar_rows_tabla : function (btn_lnk){
        var destino = $(btn_lnk.data("destino"));
        var html = $(btn_lnk.data("origen")).html();

        html = html.replace("<!--","");
        html = html.replace("-->","");
        html = html.replace(/\{id}/g, $.now()); //replace("{id}",$.now());

        destino.append(html);
    },

    funcion_position_page_by_id : function(id){
        window.location.hash = '' + id;
    },

    mensaje_ocultar_inicio_sistema:function () {
        setTimeout(function () {
            $('#btn_close_alert_inicio_sistema').trigger('click');
        },5000)
    },

    assing_array : function (array_firts,array_second){
        var objs = [array_firts,array_second],
            result =  objs.reduce(function (r, o) {
                Object.keys(o).forEach(function (k) {
                    r[k] = o[k];
                });
                return r;
            }, {});
        return result;
    },

    input_checkbox_change_value : function (input){
        var div_show_hidden = input.data('div_show_hidden');
        var checked = input.is(':checked');
        if(checked){
            $(div_show_hidden).fadeIn();
        }else{
            $(div_show_hidden).fadeOut();
            $(div_show_hidden).find('input select textarea').val('');
        }
    },

    set_loader_page : function (){
        $('body').append(loader_page);
    },

    hide_loader_page : function () {
        setTimeout(function () {
            $('.loader').addClass('hidden').delay(200).remove();
        }, 1000);
    },

    /**
     * apartado de funciones comunes
     */
    trigger_buscar_comun : function(btn_lnk){
        var btn_buscar = btn_lnk.data('btn_buscar');
        $(btn_buscar).trigger('click');
    },

    btn_guardar_disabled : function(btn_lnk){
        btn_lnk.attr('disabled',true);
        btn_lnk.html('Procesando...');
    },

    btn_guardar_enable : function(btn_lnk,html){
        btn_lnk.removeAttr('disabled');
        var html_buton = 'Guardar';
        if(html != undefined && html != ''){
            html_buton = html;
        }
        btn_lnk.html(html_buton);
    },

    str_mayus : function(input){
        var value = input.val();
        input.val(value.toUpperCase());
    },

    funcion_popover_notificaciones : function (){
        $('.popoverDescripcion').trigger('click');
    },

    funcion_data_table: function(){
        $('.data-table').dataTable({
            'paging' : false,
            'ordering' : false,
            'info' : false,
            'language':{
                'search' : 'Buscar'
            }
        });
    },

    busqueda_registros_comun : function(btn_link){
        var id_form = btn_link.data('id_form');
        var conteiner_resultados = btn_link.data('conteiner_resultados');
        var url_peticion = btn_link.data('url_peticion');
        var btn_trigger = btn_link.data('btn_trigger');
        var post_formulario = {};
        if(id_form != undefined && id_form != ''){
            post_formulario = Comun.obtener_post_formulario(id_form);
        }
        $(conteiner_resultados).html(loader_gif);
        Comun.obtener_contenido_peticion_html(url_peticion,post_formulario,
            function (response) {
                $(conteiner_resultados).html(response);
                if(btn_trigger != undefined && btn_trigger != ''){
                    $(btn_trigger).trigger('click');
                }
                Comun.funcion_tooltip();
                Comun.funcion_popover();
                Comun.iniciar_group_buttons();
                //Comun.start_page(conteiner_resultados);
            }
        );
    },

    busqueda_registros_comun_paginacion : function(cmp){
        var url_paginacion = cmp.data('url_paginacion');
        var form_busqueda = cmp.data('form_busqueda');
        var conteiner_resultados = cmp.data('conteiner_resultados');
        var id_paginacion = cmp.data('id_paginacion');
        var is_limit = cmp.data('is_limit') == 1 ? true : false;
        var pagina_select = $(id_paginacion).find('select.stl_pagina').val();
        if(is_limit){
            pagina_select = 1;
        }
        var limit_select = $(id_paginacion).find('select.slt_limit').val();
        var form_post = Comun.obtener_post_formulario(form_busqueda);
        var parametros_paginacion = '/' + pagina_select + '/' + limit_select;
        $(conteiner_resultados).html(loader_gif);
        Comun.obtener_contenido_peticion_html(
            base_url + url_paginacion + parametros_paginacion,
            form_post,
            function(response){
                $(conteiner_resultados).html(response);
                Comun.funcion_tooltip();
            }
        );
    },

    autoguardado_campo_formulario : function(campo){
        var url_peticion = campo.data('url_peticion');
        var post = {
            tabla_update : campo.data('tabla_update'),
            campo_update : campo.data('campo_update'),
            id_campo_update : campo.data('id_campo_update'),
            id_value_update : campo.data('id_value_update'),
            value_update : campo.val()
        };
        $.ajax({
            type: 'POST',
            url: url_peticion,
            data:post,
            dataType:'json',
            success:function(response){
                var random = $.now();
                var class_msg = 'badge-danger';
                var msg = 'Sin guardar :-(';
                var time_out = 2000;
                if(response.exito){
                    class_msg = 'badge-success';
                    msg = 'Guardado :-D';
                }else{
                    if(response.msg != ''){
                        msg = response.msg;
                        time_out = 4000;
                    }
                }
                var span_save = '<span id="'+random+'" class="'+class_msg+' msg_validacion_encuesta">'+msg+'</span>';
                campo.parent().append(span_save);
                setTimeout(function(){
                    $('#'+random).fadeOut();
                },time_out);
                setTimeout(function(){
                    $('#'+random).remove();
                },4100);
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    copiar_link_al_portapapeles : function (elemento){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(elemento).text()).select();
        document.execCommand("copy");
        $temp.remove();
    },

    obtener_sumatoria_tabla(tabla,input,destino){
        var sumatoria = 0;
        $(tabla).find(input).each(function(){
            sumatoria += parseInt($(this).val());
        });
        $(destino).html(sumatoria)
    },

    recargar_pagina : function(url_redirect,time = 3000){
        setTimeout(function(){
            location.href = url_redirect;
        },time);
    },

    desabilitar_ctrl_r : function(e){
        e = e || window.event;
        if (e.ctrlKey) {
            var c = e.which || e.keyCode;
            if (c == 82) {
                e.preventDefault();
                e.stopPropagation();
            }
        }
    },

    iniciar_group_buttons : function(){
        // var group_btn = $('.dropdown-toggle')[0];
        // group_btn != undefined ? $(group_btn).trigger('click') : false;
    },

    msg_flash_data : function(){
        if(msg_flashdata != undefined && msg_flashdata.trim() != ''){
            var type = 'success';
            if(type_flashdata != undefined && type_flashdata != ''){
                type = type_flashdata;
            }
            Comun.mensaje_operacion(type,msg_flashdata,'',9000);
        }
    },

    start_page : function(){
        Comun.position_html('#page-wrapper');
    },

    position_html : function(taghtml){
        $('html,body').animate({
            scrollTop: $(taghtml).offset().top
        }, 500);
    },

    addExtraScript : function(url_js){
        $.getScript(url_js,function(){});
    },

    validar_login_sistema : function(){
        var existe_session = true;
        $.ajax({
            type : 'post',
            url : base_url + 'Login/validar_session',
            data : {},
            dataType : 'json',
            success : function(response){
                existe_session = response.status;
                if(!response.status){
                    Comun.mensaje_operacion_modal('danger','Session caduco, inicie nuevamente','');
                    Comun.recargar_pagina(base_url + 'Login',2000);
                }
            },error : function(error){
                existe_session = false;
            }
        });
        return existe_session;
    }

};

var errorResponse = {
    success:false,
    printMessages:true,
    messages:[
        {
            message: "A ocurrido un error",
            priority: "error"
        }]
};

function copyToClipboard(elemento) {
    //alert('copiar');
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(elemento).text()).select();
    document.execCommand("copy");
    $temp.remove();
};

