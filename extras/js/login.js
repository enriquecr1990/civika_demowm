$(document).ready(function () {

    $('body').on('change','#input_usuario_sesion',function(e){
        e.isDefaultPrevented();
        var usuario = $(this).val();
        $('#input_password_sesion').attr('data-rule-required',true);
        if(usuario == 'civikholding'){
            $('#input_password_sesion').removeAttr('data-rule-required');
        }
    });

    $('body').on('click','.iniciar_sesion_sistema_civka',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = LoginSistema.validar_form_login();
        if(form_valido){
            LoginSistema.iniciar_sesion_sistema(
                function(response){
                    if(response.exito == false){
                        Comun.mensaje_operacion('error',response.msg);
                    }else{
                        if(response.id_publicacion_ctn != undefined && response.id_publicacion_ctn != ''){
                            location.href = base_url + 'InscripcionesCTN/registroCursoTallerNorma/' + response.id_publicacion_ctn;
                        }else{
                            location.href = base_url;
                        }
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Aceptar');
    });

    $('body').on('click','.reestablecer_password_civik',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_buton = btn.html();
        btn.attr('disabled',true);
        btn.html('Procesando...');
        var form_valido = LoginSistema.validar_form_reset_pass();
        if(form_valido){
            LoginSistema.reset_password_usuario(
                function(response){
                    if(response.exito){
                        btn.html(html_buton);
                        Comun.mensaje_operacion_modal('success',response.msg,'');
                        setTimeout(function(){
                            location.href = base_url;
                        },3000);
                    }else{
                        btn.html(html_buton);
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        btn.html(html_buton);
    });

    $('body').on('click','.reset_password_civik',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = LoginSistema.validar_form_reestablecer_pass();
        if(form_valido){
            LoginSistema.reestablecer_password_usuario(
                function(response){
                    if(response.exito){
                        Comun.mensaje_operacion_modal('success',response.msg,'');
                        setTimeout(function(){
                            location.href = base_url + 'Login';
                        },3000);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Cambiar contraseña');
    });

    $('body').on('change','#input_correo_reset_pass',function(e){
        e.isDefaultPrevented();
        var correo = $(this);
        if(Comun.validar_correo(correo.val()) != null){
            LoginSistema.obtener_usuario_sistema_correo(correo.val());
        }else{
            $('#btn_solicitud_reset_pass').fadeOut();
        }
    });

    /*$('body').on('change','#input_password_sesion',function(e){
        e.isDefaultPrevented();
        $('.iniciar_sesion_sistema_civka').trigger('click');
    });*/

});

var LoginSistema = {

    reglas_validate_iniciar_sesion : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    validar_form_login : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_iniciar_sesion',LoginSistema.reglas_validate_iniciar_sesion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            return form_valido;
        }
        return form_valido;
    },

    validar_form_reset_pass : function(){
        $('.error').remove();
        var form_valido = Comun.validar('#form_reestabler_password',LoginSistema.reglas_validate_iniciar_sesion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            return form_valido;
        }
        return form_valido;
    },

    validar_form_reestablecer_pass : function (){
        $('.error').remove();
        var form_valido = Comun.validar('#form_cambiar_password_by_reestablecer',LoginSistema.reglas_validate_iniciar_sesion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            var input_password = $('#form_cambiar_password_by_reestablecer').find('#new_password');
            var input_repeat_password = $('#form_cambiar_password_by_reestablecer').find('#repeat_new_password');
            var password = input_password.val();
            var repeat_password = input_repeat_password.val();
            if(password != repeat_password){
                form_valido = false;
                input_repeat_password.addClass('is-invalid');
                input_repeat_password.closest('div').append('<em class="error invalid-feedback" for="repeat_password">Contraseñas diferentes</em>')
            }
            return form_valido;
        }
        return form_valido;
    },

    iniciar_sesion_sistema : function (funcion) {
        Comun.enviar_formulario_post('form_iniciar_sesion', base_url + 'Login/iniciarSesion', funcion);
    },

    obtener_usuario_sistema_correo : function(correo){
        $.ajax({
            type : "POST",
            url : base_url + 'Login/obtener_usuario_correo',
            data : {correo : correo},
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    if(response.multiple_usuario){
                        var html_select = '<select class="custom-select" data-rule-required="true" name="id_usuario">' +
                            '<option value="">Seleccione</option>';
                        for(var i = 0; i < response.usuario.length; i++){
                            html_select += '<option value="'+response.usuario[i].id_usuario+'">'+response.usuario[i].usuario+'</option>';
                        }
                        html_select += '</select>';
                        var html_input_slt = '' +
                            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' +
                            '<div class="alert alert-light">' +
                            'Se encontraron varios usuarios registrados con este correo, seleccione el usuario que desea reestablecer la contraseña' +
                            '' + html_select +
                            '</div>' +
                            '</div>';
                        $('#input_select_usuario_encontrado').html(html_input_slt);
                        $('#input_select_usuario_encontrado').fadeIn();
                        $('#btn_solicitud_reset_pass').fadeIn();
                    }else{
                        $('#input_select_usuario_encontrado').fadeOut();
                        var input_usuario = '<input type="hidden" name="id_usuario" value="'+response.usuario.id_usuario+'">';
                        $('#input_select_usuario_encontrado').html(input_usuario);
                        $('#btn_solicitud_reset_pass').fadeIn();
                    }
                }else{
                    $('#btn_solicitud_reset_pass').fadeOut();
                }
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    reset_password_usuario : function(funcion){
        Comun.enviar_formulario_post('form_reestabler_password', base_url + 'Login/solicitud_reset_password', funcion);
    },

    reestablecer_password_usuario : function(funcion){
        Comun.enviar_formulario_post('form_cambiar_password_by_reestablecer', base_url + 'Login/cambiar_password_usuario_by_reestablecimiento', funcion);
    }

}
