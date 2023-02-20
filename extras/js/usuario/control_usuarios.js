$(document).ready(function () {

    $('body').on('click','.buscar_usuarios_sistema',function () {
        ControlUsuarios.buscar_usuarios_sistema();
    });

    $('body').on('click','.agregar_nuevo_usuario',function () {
        ControlUsuarios.agregar_modificar_usuario($(this));
    });

    $('body').on('click','.modificar_usuario',function () {
        ControlUsuarios.agregar_modificar_usuario($(this));
    });

    $('body').on('click','.experiencia_curricular_instructor',function () {
        ControlUsuarios.agregar_modificar_experiencia_curricular($(this));
    });

    $('body').on('click','.agregar_row_preparacion_academica',function (e) {
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        setTimeout(function(){
            Comun.funciones_datepicker();
        },100);
    });

    $('body').on('click','.agregar_row_experiencia_laboral',function (e) {
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        setTimeout(function(){
            Comun.funciones_datepicker();
        },100);
    });

    $('body').on('click','.agregar_row_cert_diplo_crs',function (e) {
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        setTimeout(function(){
            Comun.funciones_datepicker();
        },100);
    });

    $('body').on('click','.eliminar_usuario_admin',function () {
        var url = $(this).data('url');
        var msg_elimiar = 'Se eliminara el usuario administrador de forma permante del sistema, ¿Desea continuar?';
        var btn_trigger = $(this).data('btn_trigger');
        Comun.mostrar_modal_confirmacion(url,msg_elimiar,btn_trigger);
    });

    $('body').on('click','.activar_desactivar_usario_sistema',function () {
        
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.guardar_usuario_civik',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = ControlUsuarios.validar_usuario();
        if(validar){
            ControlUsuarios.guardar_usuario(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_usuario',false);
                        $('.buscar_usuarios_sistema').trigger('click');
                        $('#msg_cambio_pass_asea').remove();
                        $('.form_configuracion_usuario').html(loader_gif);
                        if(response.recargar != undefined && response.recargar){
                            setTimeout(function () {
                                location.reload();
                             },1000);
                        }
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_usuario_administrador');
                        Comun.btn_guardar_enable(btn);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn);
        }
    });

    $('body').on('click','.guardar_datos_instructor_para_cv',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = ControlUsuarios.validar_usuario_instructor_datos_to_cv();
        if(validar){
            ControlUsuarios.guardar_usuario_instructor_datos_cv(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_experiencia_curricular',false);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_instructor_cv');
                        Comun.btn_guardar_enable(btn);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn);
        }
    });

    $('body').on('click','.guardar_usuario_civik_perfil',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        var html_btn = btn.html();
        Comun.btn_guardar_disabled(btn);
        var validar = ControlUsuarios.validar_usuario_perfil();
        if(validar){
            ControlUsuarios.guardar_usuario(
                function (response) {
                    if(response.exito){
                        Comun.mensaje_operacion('confirmed',response.msg);
                        $('#concluir_inscripcion_curso').fadeIn(1500);
                        Comun.btn_guardar_enable(btn,html_btn);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_usuario_administrador');
                        Comun.btn_guardar_enable(btn,html_btn);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_btn);
        }

    });

    /**
     * funciones nuevas para el sistema de civik
     */
    $('body').on('change','.input_buscar',function(){
        ControlUsuarios.trigger_buscar_usuarios();
    });

    $('body').on('change','#slt_tipo_usuario',function(e){
        e.isDefaultPrevented();
        var value_select = $(this).val();
        $('#inputs_extra_form_usuario').find('input select textarea').val('');
        $('#inputs_to_alumno').fadeOut();
        $('#inputs_to_instructor').fadeOut();
        if(value_select == 'alumno'){
            $('#inputs_to_alumno').fadeIn();
        }if(value_select == 'instructor'){
            $('#inputs_to_instructor').fadeIn();
        }
    });

    ControlUsuarios.trigger_buscar_usuarios();
});

var ControlUsuarios = {

    trigger_buscar_usuarios : function(){
        $('.buscar_usuarios_sistema').trigger('click');
    },

    buscar_usuarios_sistema : function () {
        var container_resultados = '#contenedor_resultados_usuarios_sistema';
        var post_formulario = Comun.obtener_post_formulario('form_buscar_usuarios');
        $(container_resultados).html(loader_gif);
        Comun.obtener_contenido_peticion_html(base_url + 'ControlUsuarios/buscarUsuarios',post_formulario,
            function (response) {
                $(container_resultados).html(response);
                Comun.funcion_tooltip();
            }
        );
    },

    agregar_modificar_usuario : function (btn) {
        var id_usuario = btn.data('id_usuario');
        var tipo_usuario = btn.data('tipo_usuario');
        var es_configuracion = btn.data('es_configuracion')
        var post = {};
        if(tipo_usuario != undefined && tipo_usuario != ''){
            post = {tipo_usuario : tipo_usuario}
        }if(es_configuracion != undefined && es_configuracion != ''){
            post = $.extend(post,{es_configuracion:es_configuracion});
        }
        var parametrosController = '';
        if(id_usuario != undefined && id_usuario != ''){
            parametrosController += '/'+id_usuario;
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'ControlUsuarios/agregarModificarUsuario'+parametrosController,post,
            function (response) {
                $('#conteiner_agregar_modificar_usuario_admin').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_usuario',true);
                Perfil.iniciar_carga_archivos_firma_instructor();
            }
        );
    },

    agregar_modificar_experiencia_curricular : function (btn){
        var id_usuario = btn.data('id_usuario');
        Comun.obtener_contenido_peticion_html(
            base_url + 'ControlUsuarios/agregar_modificar_experiencia_curricular/' + id_usuario,{},
            function(response){
                $('#conteiner_agregar_modificar_experiencia_curricular').html(response);
                Comun.funciones_datepicker();
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_experiencia_curricular',true);
            }
        );
    },

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    validar_usuario : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_usuario',ControlUsuarios.reglas_validate());
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            var input_password = $('#form_guardar_usuario').find('#input_password');
            var input_repeat_password = $('#form_guardar_usuario').find('#input_password_repeat');
            var checked_modificar_usuario = $('#form_guardar_usuario').find('input#input_cambiar_password_usuario').is(':checked');
            var id_usuario = $('#id_usuario').val();
            var tipo_usuario = $('#slt_tipo_usuario').val();
            var curp_usuario = '';
            if((checked_modificar_usuario != undefined && checked_modificar_usuario != false) ||
                (id_usuario != undefined && id_usuario == '')){
                var password = input_password.val();
                var repeat_password = input_repeat_password.val();
                if(password != repeat_password){
                    form_valido = false;
                    input_repeat_password.addClass('is-invalid');
                    input_repeat_password.closest('div').append('<em class="error invalid-feedback" for="repeat_password">Contraseñas diferentes</em>')
                }
            }if(tipo_usuario == 'alumno'){
                curp_usuario = $('#input_curp_alumno');
            }if(tipo_usuario == 'instructor'){
                curp_usuario = $('#input_curp_instructor');
            }
            if(tipo_usuario == 'alumno' || tipo_usuario == 'instructor'){
                if(curp_usuario.val() != ''){
                    if(Comun.validar_curp(curp_usuario.val()) == null){
                        form_valido = false;
                        curp_usuario.addClass('is-invalid');
                        curp_usuario.closest('div').append('<em class="error invalid-feedback">El CURP no tiene la estructura correcta</em>')
                    }
                }
            }
            return form_valido;
        }
        return form_valido;
    },

    validar_usuario_instructor_datos_to_cv : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_datos_usuario_to_cv',ControlUsuarios.reglas_validate());
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            var num_rows_preparacion_academida = $('#tbodyPreparacionAcademida').find('tr').length;
            var num_rows_experiencia_laboral = $('#tbodyExperienciaLaboral').find('tr').length;
            var num_rows_curso_diplo_cursos = $('#tbody_crt_diplo_crs').find('tr').length;
            if(num_rows_preparacion_academida == 0){
                form_valido = false;
                $('#title_preparacion_academica').append('<em class="error requerido">Es necesario por lo menos un registro en la preparación académica</em>');
            }
            return form_valido;
        }
        return form_valido;
    },

    validar_usuario_perfil : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_usuario',ControlUsuarios.reglas_validate());
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            var input_password = $('#form_guardar_usuario').find('#input_password');
            var input_repeat_password = $('#form_guardar_usuario').find('#input_password_repeat');
            var checked_modificar_usuario = $('#form_guardar_usuario').find('input#input_cambiar_password_usuario').is(':checked');
            var id_usuario = $('#id_usuario').val();
            if((checked_modificar_usuario != undefined && checked_modificar_usuario != false) ||
                (id_usuario != undefined && id_usuario == '')){
                var password = input_password.val();
                var repeat_password = input_repeat_password.val();
                if(password != repeat_password){
                    form_valido = false;
                    input_repeat_password.addClass('is-invalid');
                    input_repeat_password.closest('div').append('<em class="error invalid-feedback" for="repeat_password">Contraseñas diferentes</em>')
                }
            }
            return form_valido;
        }
        return form_valido;
    },

    guardar_usuario : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_usuario', base_url + 'ControlUsuarios/guardarUsuario', funcion);
    },

    guardar_usuario_instructor_datos_cv : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_datos_usuario_to_cv', base_url + 'ControlUsuarios/guardar_usuario_instructor_datos_to_cv', funcion);
    },

}
