$(document).ready(function () {

    $('body').on('click','.registro_curso_incripcion',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = Inscripciones.validar_form_sesion_inscripcion();
        if(form_valido){
            Inscripciones.guardar_registro_inscripcion(
                function(response){
                    if(response.exito == false){
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_registro_inscripcion');
                    }else{
                        location.href = base_url + 'InscripcionesCTN/actualizarDatosAlumno/'+response.id_publicacion_ctn;
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Regístrate');
    });

    $('body').on('click','.guardar_nuevo_alumno_ctn_publicado',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = Inscripciones.validar_form_registro_nuevo_alumno();
        if(form_valido){
            Inscripciones.guardar_nuevo_alumno_ctn_publicado(
                function(response){
                    if(response.exito){
                        Comun.mensaje_operacion('success',response.msg,'#msg_validacion_registro_alumnos');
                        $('#seccion_resutados_alumnos_registrados').fadeIn();
                        $('#container_registro_alumno_nuevo_ctn_publicado').fadeOut();
                        $('#btn_buscar_registro_alumno_publicacion').trigger('click');
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#msg_validacion_registro_alumnos');
                    }
                    Comun.btn_guardar_enable(btn,'Aceptar');
                }
            )
        }else{
            Comun.btn_guardar_enable(btn,'Aceptar');
        }
    });

    $('body').on('click','.registrar_alumno_existente_ctn_publicado',function(e){
        e.isDefaultPrevented();
        Inscripciones.registrar_alumno_existente_ctn_publicado($(this));
    });

    $('body').on('change','.checked_required_factura',function(e){
        e.preventDefault();
        var value_checked= $('input.checked_required_factura:checked').val();
        $('#form_data_facturacion').hide();
        if(value_checked == 'si'){
            $('#form_data_facturacion').fadeIn();
            if($('input#input_datos_fiscales_rfc').val() != ''){
                Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
            }
        }else{
            $('#form_data_facturacion').find('input').val('')
        }
    });

    $('body').on('click','.civika_enviar_recibo_validacion_alumno',function(e){
        e.preventDefault();
        Inscripciones.iniciar_envio_recibio_inscripcion_alumno($(this));
    });

    $('body').on('click','.civika_enviar_complemento_inscripcion',function(e){
        e.preventDefault();
        Inscripciones.iniciar_envio_complemento_inscripcion($(this));
    });

    $('body').on('click','.civika_guardar_facturacion',function(e){
        e.preventDefault();
        Inscripciones.guardar_datos_recibo_facturacion_form($(this));
    });

    $('body').on('click','.civika_enviar_recibo_pago_inscripcion',function(e){
        e.preventDefault();
        Inscripciones.iniciar_envio_recibio_inscripcion_alumno($(this));
    });

    $('body').on('click','.concluir_inscripcion_curso_taller_norma',function(e){
        e.isDefaultPrevented();
        Inscripciones.finalizar_inscripcion_alumno($(this));
    });

    $('body').on('change','.dato_rfc_factura',function (e) {
        e.preventDefault();
        Inscripciones.validar_rfc_dato_fiscal($(this));
    });

    $('body').on('click','.guardar_usuario_alumno_datos_personales',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_usuario_alumno_datos_generales();
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_personales(
                function (response) {
                    if(response.exito){
                        var usuario_update_datos = parseInt($('#usuario_update_datos').val()) + 1;
                        var usuario_alumno_update_datos = parseInt($('#usuario_alumno_update_datos').val()) + 1;
                        var usuario_sistema = response.usuario.nombre + ' ' + response.usuario.apellido_p;
                        $('span#usuario_sistema').html(usuario_sistema);
                        $('#usuario_update_datos').val(usuario_update_datos);
                        $('#usuario_alumno_update_datos').val(usuario_alumno_update_datos);
                        if(usuario_update_datos == 1){
                            $('#seccion_recibo_pago').fadeIn();
                        }
                        $('.civika_forma_pago_efectivo').fadeIn();
                        $('.civika_forma_pago_online').fadeIn();
                        Inscripciones.reinicio_formato_dc3_pdf();
                        Comun.mensaje_operacion('confirmed',response.msg);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Guardar datos personales');
    });

    $('body').on('click','.guardar_usuario_alumno_datos_personales_paso_1',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_usuario_alumno_datos_generales();
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_personales(
                function (response) {
                    if(response.exito){
                        var empresa_update_datos = parseInt($('#empresa_update_datos').val()) + 1;
                        $('#empresa_update_datos').val(empresa_update_datos);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if($('#nav_paso_2').find('.fa-check').length == 0){
                            $('#nav_paso_2').append('<span class="fa fa-check fa-2x"></span>');
                        }
                        $('#nav_paso_2').removeClass('disabled');
                        $('#nav_paso_2').trigger('click');
                        var razon_social_dc3 = $('input#input_nombre_empresa').val();
                        var rfc_dc3 = $('input#input_rfc_empresa').val();
                        var correo_dc3 = $('input#input_correo_empresa').val();
                        var domicilio_dc3 = $('input#input_domicilio_empresa').val();
                        if($('input#input_datos_fiscales_razon_social').val() == ''){
                            $('input#input_datos_fiscales_razon_social').val(razon_social_dc3);
                        }if($('input#input_datos_fiscales_rfc').val() == ''){
                            $('input#input_datos_fiscales_rfc').val(rfc_dc3);
                        }if($('input#input_datos_fiscales_correo').val() == ''){
                            $('input#input_datos_fiscales_correo').val(correo_dc3);
                        }if($('input#input_datos_fiscales_direccion').val() == ''){
                            $('input#input_datos_fiscales_direccion').val(domicilio_dc3);
                        }
                        Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Guardar datos personales');
    });

    $('body').on('click','.guardar_usuario_alumno_datos_empresa',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_usuario_alumno_datos_empresa();
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_empresa(
                function (response) {
                    if(response.exito){
                        var empresa_update_datos = parseInt($('#empresa_update_datos').val()) + 1;
                        $('#empresa_update_datos').val(empresa_update_datos);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if($('#nav_paso_2').find('.fa-check').size == 0){
                            $('#nav_paso_2').append('<span class="fa fa-check fa-2x"></span>');
                        }
                        $('#nav_registro_pago_complemento').removeClass('disabled');
                        $('#nav_registro_pago_complemento').trigger('click');
                        var razon_social_dc3 = $('input#input_nombre_empresa').val();
                        var rfc_dc3 = $('input#input_rfc_empresa').val();
                        var correo_dc3 = $('input#input_correo_empresa').val();
                        var domicilio_dc3 = $('input#input_domicilio_empresa').val();
                        if($('input#input_datos_fiscales_razon_social').val() == ''){
                            $('input#input_datos_fiscales_razon_social').val(razon_social_dc3);
                        }if($('input#input_datos_fiscales_rfc').val() == ''){
                            $('input#input_datos_fiscales_rfc').val(rfc_dc3);
                        }if($('input#input_datos_fiscales_correo').val() == ''){
                            $('input#input_datos_fiscales_correo').val(correo_dc3);
                        }if($('input#input_datos_fiscales_direccion').val() == ''){
                            $('input#input_datos_fiscales_direccion').val(domicilio_dc3);
                        }
                        Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Guardar datos DC-3');
    });

    $('body').on('click','.guardar_usuario_alumno_datos_empresa_paso_2',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_usuario_alumno_datos_empresa();
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_empresa(
                function (response) {
                    if(response.exito){
                        var empresa_update_datos = parseInt($('#empresa_update_datos').val()) + 1;
                        $('#empresa_update_datos').val(empresa_update_datos);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if($('#nav_paso_2').find('.fa-check').size == 0){
                            $('#nav_paso_2').append('<span class="fa fa-check fa-2x"></span>');
                        }
                        $('#nav_registro_pago_complemento').removeClass('disabled');
                        $('#nav_registro_pago_complemento').trigger('click');
                        var razon_social_dc3 = $('input#input_nombre_empresa').val();
                        var rfc_dc3 = $('input#input_rfc_empresa').val();
                        var correo_dc3 = $('input#input_correo_empresa').val();
                        var domicilio_dc3 = $('input#input_domicilio_empresa').val();
                        if($('input#input_datos_fiscales_razon_social').val() == ''){
                            $('input#input_datos_fiscales_razon_social').val(razon_social_dc3);
                        }if($('input#input_datos_fiscales_rfc').val() == ''){
                            $('input#input_datos_fiscales_rfc').val(rfc_dc3);
                        }if($('input#input_datos_fiscales_correo').val() == ''){
                            $('input#input_datos_fiscales_correo').val(correo_dc3);
                        }if($('input#input_datos_fiscales_direccion').val() == ''){
                            $('input#input_datos_fiscales_direccion').val(domicilio_dc3);
                        }
                        Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
                        $('#nav_paso_3').trigger('click');
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,'Guardar datos DC-3');
    });

    $('body').on('click','.guardar_usuario_alumno_datos_sin_empresa',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        var btn_html = btn.html();
        Comun.btn_guardar_disabled(btn);
        //var validar = Inscripciones.validar_usuario_alumno_datos_empresa();
        var validar = true;
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_empresa(
                function (response) {
                    if(response.exito){
                        var empresa_update_datos = parseInt($('#empresa_update_datos').val()) + 1;
                        $('#empresa_update_datos').val(empresa_update_datos);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if($('#nav_paso_2').find('.fa-check').size == 0){
                            $('#nav_paso_2').append('<span class="fa fa-check fa-2x"></span>');
                        }
                        $('#nav_registro_pago_complemento').removeClass('disabled');
                        $('#nav_registro_pago_complemento').trigger('click');
                        var razon_social_dc3 = $('input#input_nombre_empresa').val();
                        var rfc_dc3 = $('input#input_rfc_empresa').val();
                        var correo_dc3 = $('input#input_correo_empresa').val();
                        var domicilio_dc3 = $('input#input_domicilio_empresa').val();
                        if($('input#input_datos_fiscales_razon_social').val() == ''){
                            $('input#input_datos_fiscales_razon_social').val(razon_social_dc3);
                        }if($('input#input_datos_fiscales_rfc').val() == ''){
                            $('input#input_datos_fiscales_rfc').val(rfc_dc3);
                        }if($('input#input_datos_fiscales_correo').val() == ''){
                            $('input#input_datos_fiscales_correo').val(correo_dc3);
                        }if($('input#input_datos_fiscales_direccion').val() == ''){
                            $('input#input_datos_fiscales_direccion').val(domicilio_dc3);
                        }
                        Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
        }
        Comun.btn_guardar_enable(btn,btn_html);
    });

    $('body').on('click','.guardar_usuario_alumno_datos_sin_empresa_paso_2',function (e) {
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_usuario_alumno_datos_sin_empresa_paso_2();
        if(validar){
            Inscripciones.guardar_usuario_alumno_datos_empresa(
                function (response) {
                    if(response.exito){
                        var empresa_update_datos = parseInt($('#empresa_update_datos').val()) + 1;
                        $('#empresa_update_datos').val(empresa_update_datos);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if($('#nav_paso_2').find('.fa-check').size == 0){
                            $('#nav_paso_2').append('<span class="fa fa-check fa-2x"></span>');
                        }
                        $('#nav_registro_pago_complemento').removeClass('disabled');
                        $('#nav_registro_pago_complemento').trigger('click');
                        var razon_social_dc3 = $('input#input_nombre_empresa').val();
                        var rfc_dc3 = $('input#input_rfc_empresa').val();
                        var correo_dc3 = $('input#input_correo_empresa').val();
                        var domicilio_dc3 = $('input#input_domicilio_empresa').val();
                        if($('input#input_datos_fiscales_razon_social').val() == ''){
                            $('input#input_datos_fiscales_razon_social').val(razon_social_dc3);
                        }if($('input#input_datos_fiscales_rfc').val() == ''){
                            $('input#input_datos_fiscales_rfc').val(rfc_dc3);
                        }if($('input#input_datos_fiscales_correo').val() == ''){
                            $('input#input_datos_fiscales_correo').val(correo_dc3);
                        }if($('input#input_datos_fiscales_direccion').val() == ''){
                            $('input#input_datos_fiscales_direccion').val(domicilio_dc3);
                        }
                        Inscripciones.validar_rfc_dato_fiscal($('input#input_datos_fiscales_rfc'));
                        $('#nav_paso_3').trigger('click');
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                }
            );
            Comun.btn_guardar_enable(btn,'Guardar datos DC-3');
        }else{
            Comun.btn_guardar_enable(btn,'Guardar datos DC-3');
        }
    });

    $('body').on('click','#check_revisar_datos',function (e) {
        e.isDefaultPrevented();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('.enviar_recibo_inscripcion_validacion_civik').removeAttr('disabled');
        }else{
            $('.enviar_recibo_inscripcion_validacion_civik').attr('disabled',true);
        }
    });

    $('body').on('click','#check_revisar_datos_sin_dc3',function (e) {
        e.isDefaultPrevented();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('.enviar_recibo_inscripcion_validacion_civik_sin_dc3').removeAttr('disabled');
        }else{
            $('.enviar_recibo_inscripcion_validacion_civik_sin_dc3').attr('disabled',true);
        }
    });

    $('body').on('click','#check_revisar_datos_formato_dc3',function (e) {
        e.isDefaultPrevented();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('.concluir_registro_dc3').removeAttr('disabled');
        }else{
            $('.concluir_registro_dc3').attr('disabled',true);
        }
    });

    $('body').on('click','.enviar_recibo_inscripcion_validacion_civik',function(e){
        e.preventDefault();
        Inscripciones.enviar_recibo_validacion_civika($(this));
    });

    $('body').on('click','.enviar_recibo_inscripcion_validacion_civik_sin_dc3',function(e){
        e.preventDefault();
        Inscripciones.enviar_recibo_validacion_civika_sin_dc3($(this));
    });

    $('body').on('click','.concluir_registro_dc3',function(e){
        e.preventDefault();
        Inscripciones.concluir_registro_dc3($(this));
    });

    $('body').on('click','.btn_validacion_observacion_comprobante_civika',function(e){
        e.isDefaultPrevented();
        Inscripciones.validar_observar_comprobante_alumno($(this));
    });

    $('body').on('click','.btn_cargar_carta_descriptiva_curso',function(e){
        e.isDefaultPrevented();
        Inscripciones.cargar_carta_descriptiva($(this));
    });

    $('body').on('change','.slt_validar_comprobante_alumno',function(e){
        e.isDefaultPrevented();
        var value = $(this).val();
        var btn_validacion = $($(this).data('btn_validacion'));
        btn_validacion.fadeOut();
        if(value == 'si'){
            btn_validacion.html('Validar e inscribir');
            btn_validacion.removeClass('btn-danger');
            btn_validacion.addClass('btn-success');
        }if(value == 'no'){
            btn_validacion.html('Observar comprobante');
            btn_validacion.removeClass('btn-success');
            btn_validacion.addClass('btn-danger');
        }
        if(value != ''){
            btn_validacion.fadeIn();
        }
    });

    $('body').on('click','.close_modal_registro_alumnos_publicacion',function(e){
        e.isDefaultPrevented();
        var id_curso_taller_norma = $(this).data('id_curso_taller_norma');
        setTimeout(function(){
            location.href = base_url + 'AdministrarCTN/verPublicacionCtn/'+id_curso_taller_norma;
        },300);
    });

    $('body').on('click','#check_show_password',function(e){
        e.isDefaultPrevented();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('#input_password_registro').removeAttr('type');
            $('#input_password_registro').attr('type','text');
        }else{
            $('#input_password_registro').removeAttr('type');
            $('#input_password_registro').attr('type','password');
        }
    });

    $('body').on('click','.registrar_nuevo_alumno_curso_publicado_presencial',function(e){
        e.isDefaultPrevented();
        //Inscripciones.iniciar_registro_alumno_curso_publicado($(this));
        $('#container_registro_alumno_nuevo_ctn_publicado').fadeIn();
        $('#seccion_resutados_alumnos_registrados').fadeOut();
    });

    $('body').on('change','.input_check_alumno_registro_ctu_publicado',function(e){
        e.isDefaultPrevented();
        var value_checked = $('.input_check_alumno_registro_ctu_publicado:checked').val();
        if(value_checked == 'si'){
            $('#registro_alumno_existente').fadeIn();
            $('#btn_buscar_alumnos_registrados_sistema').trigger('click');
            $('#registro_alumno_nuevo').fadeOut();
        }if(value_checked == 'no'){
            $('#registro_alumno_nuevo').fadeIn();
            $('#registro_alumno_existente').fadeOut();
        }
    });

    $('body').on('click','.asistencia_semaforo',function (e) {
        e.isDefaultPrevented();
        Inscripciones.actualizacion_semaforo_alumno_confirmacion($(this));
    });

    $('body').on('click','.cancelar_registro_alumno_ctn_publicacion',function (e) {
        e.isDefaultPrevented();
        $('#seccion_resutados_alumnos_registrados').fadeIn();
        $('#container_registro_alumno_nuevo_ctn_publicado').fadeOut();
    });

    $('body').on('change','.cheked_inscripcion_trabaja_empresa',function(e){
        e.preventDefault();
        var value_checked = $('input.cheked_inscripcion_trabaja_empresa:checked').val();
        if(value_checked == 'si'){
            $('#datos_empresa_alumno').fadeIn();
            $('#btn_guardar_dc3_pasos_con_empresa').fadeIn();
            $('#btn_guardar_dc3_pasos_sin_empresa').fadeOut();
        }else{
            $('#datos_empresa_alumno').fadeOut();
            $('#btn_guardar_dc3_pasos_con_empresa').fadeOut();
            $('#btn_guardar_dc3_pasos_sin_empresa').fadeIn();
        }
    });

    $('body').on('click','.validar_rfc_inscripcion_masiva',function(e){
        e.preventDefault();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_rfc_empresa_inscripcion_masiva();
        if(validar){
            Inscripciones.validar_rfc_publicacion_ctn_masivo(btn);
        }else{
            Comun.btn_guardar_enable(btn,'Validar RFC');
        }
    });

    $('body').on('click','.agregar_row_empleado_empresa_masivo', function(e){
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
    });

    $('body').on('click','.guardar_registro_empleados_empresa_masivo',function(e){
        e.preventDefault();
        var btn = $(this);
        var confirmar = confirm('He revisado la información y confirmó que son correctos los datos de la empresa y de los empleados que asistiran al curso');
        if(confirmar){
            Comun.btn_guardar_disabled(btn);
            var validar = Inscripciones.validar_from_empresa_empleados_masiva();
            if(validar){
                Inscripciones.guardar_empresa_empleados_publicacion_ctn_masivo(
                    function(response){
                        if(response.exito){
                            Comun.mensaje_operacion_modal('success',response.msg,'');
                            setTimeout(function(){
                                location.href = base_url;
                            },3000);
                        }else{
                            Comun.mensaje_operacion('error',response.msg);
                        }
                    }
                );
            }else{
                Comun.btn_guardar_enable(btn,'Guardar empleados');
            }
        }
    });

    $('body').on('click','.guardar_registro_parcial_empleados_empresa_masivo',function(e){
        e.preventDefault();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var validar = Inscripciones.validar_from_empresa_empleados_masiva();
        if(validar){
            Inscripciones.guardar_empresa_empleados_parcial_publicacion_ctn_masivo(
                function(response){
                    if(response.exito){
                        Comun.mensaje_operacion_modal('success',response.msg,'');
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                    $('#validacion_registro_empresa_trabajadores').html(loader_gif);
                    Comun.obtener_contenido_peticion_html(
                        base_url + 'InscripcionesCTN/capturar_empleados_publicacion_ctn_masivo',
                        {
                            id_publicacion_ctn : btn.data('id_publicacion_ctn'),
                            rfc : btn.data('rfc'),
                        },
                        function(response){
                            $('#validacion_registro_empresa_trabajadores').html(response);
                            Comun.funcion_fileinput('Subir logotipo');
                            Cursos.iniciar_carga_archivos_logotipo_empresa();
                        }
                    );
                    Comun.btn_guardar_enable(btn,'Guardado parcial empleados');
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Guardado parcial empleados');
        }
    });

    $('body').on('click','.check_validacion_datos_carga_masiva_empresa',function(e){
        e.preventDefault();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('.guardar_registro_empleados_empresa_masivo').removeAttr('disabled');
        }else{
            $('.guardar_registro_empleados_empresa_masivo').attr('disabled',true);
        }
    });

    $('body').on('click','.eliminar_alumno_registrado_ctn_masivo',function(e){
        e.preventDefault();
        var btn = $(this);
        var confimacion = confirm('Está a punto de eliminar el alumno seleccionado, ¿Desea continuar?');
        if(confimacion){
            Inscripciones.eliminar_alumno_inscrito_ctn_publicado(btn);
        }
    });

    $('body').on('click','a#nav_paso_3',function(){
        Inscripciones.reinicio_formato_dc3_pdf();
    });

    /**
     * funciones para el pago online en la inscripcion
     */
    $('body').on('click','#check_revisar_datos_to_pago_online',function (e) {
        e.isDefaultPrevented();
        var is_checked = $(this).is(':checked');
        if(is_checked){
            $('#formas_pago_inscripcion_alumno').fadeIn();
        }else{
            $('#formas_pago_inscripcion_alumno').fadeOut();
        }
    });

    /**
     * funciones comunes para las inscripciones
     */
    Comun.funcion_fileinput('Subir recibo de pago');

    Inscripciones.iniciar_carga_archivos_recibo_pago();

    Comun.funcion_popover();
    $('.popoverShowImage').trigger('click');

    // se cambia el script dado que se revierte la funcionalidad por requerimiento
    // Inscripciones.es_publicacion_unica();

});

var Inscripciones = {

    reglas_validate_inscripcion : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    reglas_validar_datos_empresa_alumno : function(){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    reglas_validar_datos_sin_empresa_alumno : function(){
        var rules_extras = {
            rules : {
                "empresa[nombre]" : {required : false},
                "empresa[rfc]" : {required : false},
                "empresa[representante_legal]" : {required : false},
                "empresa[representante_trabajadores]" : {required : false},
                "empresa[correo]" : {required : false},
                "empresa[telefono]" : {required : false},
                "empresa[domicilio]" : {required : false}
            }
        };
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    validar_form_sesion_inscripcion : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_iniciar_sesion_inscripcion',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            return form_valido;
        }
        return form_valido;
    },

    validar_usuario_alumno_datos_generales :  function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_usuario_alumno_datos_generales',ControlUsuarios.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    validar_usuario_alumno_datos_empresa :  function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_usuario_alumno_datos_empresa',Inscripciones.reglas_validar_datos_empresa_alumno());
        if(form_valido){
            var rfc_empresa = $('#form_guardar_usuario_alumno_datos_empresa').find('#input_rfc_empresa');
            var curp_alumno = $('#form_guardar_usuario_alumno_datos_empresa').find('#input_curp_alumno');
            if(Comun.validar_rfc(rfc_empresa.val()) == null){
                form_valido = false;
                rfc_empresa.addClass('is-invalid');
                rfc_empresa.closest('div').append('<em class="error invalid-feedback">El RFC no tiene la estructura correcta</em>');
            }if(Comun.validar_curp(curp_alumno.val()) == null){
                form_valido = false;
                curp_alumno.addClass('is-invalid');
                curp_alumno.closest('div').append('<em class="error invalid-feedback">El CURP no tiene la estructura correcta</em>');
            }
        }
        return form_valido;
    },

    validar_usuario_alumno_datos_sin_empresa_paso_2 : function(){
        $('div#datos_empresa_alumno').find('input').removeAttr('data-rule-required');
        var form_valido = Comun.validar('#form_guardar_usuario_alumno_datos_empresa',Inscripciones.reglas_validar_datos_sin_empresa_alumno());
        if(form_valido){

        }
        return form_valido;
    },

    validar_form_registro_facturacion : function (){
        $('.error').remove();
        var form_valido = Comun.validar('#form_registro_pago_facturacion',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){

        }return form_valido;
    },

    validar_form_registro_pago : function (complemento_formulario) {
        $('.error').remove();
        var form_valido = Comun.validar('#form_registro_pago',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            /* validacion del rfc
            if($('input.checked_required_factura:checked').val() == 'si'){
                var input_rfc_factura = $('input#input_datos_fiscales_rfc');
                var rfc_valido = Comun.validar_rfc(input_rfc_factura.val()) != null;
                if(!rfc_valido){
                    form_valido = false;
                    input_rfc_factura.closest('div').append('<em class="error invalid-feedback" style="display: block;">El RFC no tiene la estructura correcta</em>');
                }
            }
            */
            if(complemento_formulario != undefined && !complemento_formulario) {
                if($('#recibo_pago_id_documento').length == 0){
                    form_valido = false;
                    $('#div_conteiner_file_recibo_pago').html('<em class="error invalid-feedback" style="display: block;">El recibo de pago es requerido</em>');
                }
            }

            return form_valido;
        }
        return form_valido;
    },

    validar_form_registro_nuevo_alumno : function (){
        $('.error').remove();
        var form_valido = Comun.validar('#form_registrar_alumno_nuevo_ctn_publicado',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){
            var curp_alumno = $('#form_registrar_alumno_nuevo_ctn_publicado').find('#curp_alumno');
            var rfc_empresa = $('#form_registrar_alumno_nuevo_ctn_publicado').find('#rfc_empresa');
            if(curp_alumno.val() != ''){
                if(Comun.validar_curp(curp_alumno.val()) == null){
                    form_valido = false;
                    curp_alumno.addClass('is-invalid');
                    curp_alumno.closest('div').append('<em class="error invalid-feedback">El CURP no tiene la estructura correcta</em>');
                }
            }if(rfc_empresa.val() != ''){
                if(Comun.validar_rfc(rfc_empresa.val()) == null){
                    form_valido = false;
                    rfc_empresa.addClass('is-invalid');
                    rfc_empresa.closest('div').append('<em class="error invalid-feedback">El RFC no tiene la estructura correcta</em>');
                }
            }
        }
        return form_valido;
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

    validar_rfc_empresa_inscripcion_masiva : function(){
        $('.error').remove();
        var form_valido = Comun.validar('#form_validar_rfc_registro_masivo_curso',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){
            var rfc_empresa = $('#form_validar_rfc_registro_masivo_curso').find('#rfc_empresa');
            if(rfc_empresa.val() != ''){
                if(Comun.validar_rfc(rfc_empresa.val()) == null){
                    form_valido = false;
                    rfc_empresa.addClass('is-invalid');
                    rfc_empresa.closest('div').append('<em class="error invalid-feedback">El RFC no tiene la estructura correcta</em>');
                }
            }
        }
        return form_valido;
    },

    validar_from_empresa_empleados_masiva : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_registro_alumnos_empleados_inscripcion_masiva',Inscripciones.reglas_validate_inscripcion());
        if(form_valido){
            var row_empleados = $('#form_registro_alumnos_empleados_inscripcion_masiva').find('#tbody_empleado_empresa_masivo tr');
            if(row_empleados.length == 0){
                form_valido = false;
                Comun.mensaje_operacion('error','Es necesario que registre por lo menos un empleado');
            }else{
                row_empleados.each(function(){
                    var rfc_empleado = $(this).find('input.curp_empleado');
                    if(rfc_empleado.val() != ''){
                        if(Comun.validar_curp(rfc_empleado.val()) == null){
                            form_valido = false;
                            rfc_empleado.addClass('is-invalid');
                            rfc_empleado.closest('td').append('<em class="error invalid-feedback">El CURP no tiene la estructura correcta</em>');
                        }
                    }
                });
            }
        }
        return form_valido;
    },

    iniciar_carga_archivos_recibo_pago : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadReciboPago').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {
                $('#div_conteiner_file_recibo_pago').html(loader_gif_transparente);
            },

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
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 5 Mb','',8000);
                    goUpload = false;
                }if(goUpload){
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div>' +
                            '<label for="recibo_pago_id_documento" class="col-form-label">Imagen del recibo de pago</label> <span class="help-block help-span">Puede reemplazar el recibo subiendo otra imagen</span> <br>' +
                            '<input id="recibo_pago_id_documento" class="recibo_pago_inscripcion" type="hidden" name="alumno_inscrito_ctn_publicado[id_documento]" value="'+data.result.documento.id_documento+'">' +
                            '<button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage" ' +
                                    'data-nombre_archivo="'+data.result.documento.nombre+'" ' +
                                    'data-src_image="'+data.result.documento.ruta_documento+'" ' +
                                    'data-width_img="200px" data-height_img="350px">' +
                                '<i class="fa fa-image"></i>' +
                            '</button>' +
                            '<a href="'+data.result.documento.ruta_documento+'" class="btn btn-light btn-pill btn-sm" target="_blank">' +
                                '<i class="fa fa-file-o"></i> Ver recibo' +
                            '</a>' +
                        '</div>';
                    $('#div_conteiner_file_recibo_pago').html(html_respuesta);
                    Comun.funcion_popover();
                    $('.popoverShowImage').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',data.result.msg);
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','',8000);
            }
        });
    },

    finalizar_inscripcion_alumno : function(btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        var id_instructor = btn_lnk.data('id_instructor');
        var id_alumno = btn_lnk.data('id_alumno');
        var msg_success = btn_lnk.data('msg_success');
        var post_send = {
            alumno_inscrito_ctn : {
                id_alumno : id_alumno,
                id_publicacion_ctn : id_publicacion_ctn,
                id_instructor : id_instructor
            },
            msg_success : msg_success
        };
        $.ajax({
            type : "POST",
            url : base_url + 'InscripcionesCTN/concluirRegistroAlumnoCTN',
            data : post_send,
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg,'#form_mensajes_curso_registro');
                    setTimeout(function(){
                        location.href = base_url;
                    },2000);
                }else{
                    Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_registro');
                }
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    guardar_datos_recibo_facturacion_form : function (btn_lnk){
        var validar_form_registro_pago = Inscripciones.validar_form_registro_facturacion();
        if(validar_form_registro_pago){
            Inscripciones.guardar_datos_recibo_facturacion(function(response){
                if(response.exito){
                    $('.civika_forma_pago_efectivo').fadeIn();
                    $('.civika_forma_pago_online').fadeIn();
                    Comun.mensaje_operacion('success',response.msg);
                    Inscripciones.reinicio_formato_dc3_pdf();
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                }
            })
        }
    },

    iniciar_envio_recibio_inscripcion_alumno : function (btn_lnk){
        var validar_form_registro_pago = Inscripciones.validar_form_registro_pago(false);
        if(validar_form_registro_pago){
            Inscripciones.guardar_datos_recibo(function(response){
                if(response.exito){
                    var id_alumno_inscrito_ctn_publicado = btn_lnk.data('id_alumno_inscrito_ctn_publicado');
                    Comun.obtener_contenido_peticion_html(
                        base_url + 'InscripcionesCTN/iniciar_envio_recibo_alumno_validacion/' + id_alumno_inscrito_ctn_publicado,{},
                        function (response) {
                            $('#container_modal_validar_datos_alumno_envio_recibo').html(response);
                            Comun.mostrar_modal_bootstrap('modal_validar_datos_alumno_validar_recibo',true);
                        }
                    );
                }
            })
        }
    },

    iniciar_envio_complemento_inscripcion : function (btn_lnk){
        var validar_form_registro_pago = Inscripciones.validar_form_registro_pago(false);
        if(validar_form_registro_pago){
            Inscripciones.guardar_datos_recibo(function(response){
                if(response.exito){
                    var id_alumno_inscrito_ctn_publicado = btn_lnk.data('id_alumno_inscrito_ctn_publicado');
                    Comun.obtener_contenido_peticion_html(
                        base_url + 'InscripcionesCTN/iniciar_envio_complemento_inscripcion/' + id_alumno_inscrito_ctn_publicado,{},
                        function (response) {
                            $('#container_modal_validar_datos_alumno_envio_recibo').html(response);
                            Comun.mostrar_modal_bootstrap('modal_validar_datos_alumno_validar_recibo',true);
                        }
                    );
                }
            })
        }
    },

    guardar_usuario_alumno_datos_personales : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_usuario_alumno_datos_generales', base_url + 'InscripcionesCTN/guardarUsuarioAlumnoDatosPersonales', funcion);
    },

    guardar_usuario_alumno_datos_empresa : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_usuario_alumno_datos_empresa', base_url + 'InscripcionesCTN/guardarUsuarioAlumnoDatosEmpresa', funcion);
    },

    guardar_registro_inscripcion : function (funcion) {
        Comun.enviar_formulario_post('form_iniciar_sesion_inscripcion', base_url + 'InscripcionesCTN/iniciarSesion', funcion);
    },

    guardar_datos_recibo_facturacion : function (funcion){
        Comun.enviar_formulario_post('form_registro_pago_facturacion', base_url + 'InscripcionesCTN/guardar_registro_pago_facturacion', funcion);
    },

    guardar_datos_recibo : function (funcion){
        Comun.enviar_formulario_post('form_registro_pago', base_url + 'InscripcionesCTN/guardar_registro_pago', funcion);
    },

    guardar_nuevo_alumno_ctn_publicado : function (funcion){
        Comun.enviar_formulario_post('form_registrar_alumno_nuevo_ctn_publicado', base_url + 'InscripcionesCTN/registrar_nuevo_alumno_ctn_publicado', funcion);
    },

    guardar_empresa_empleados_publicacion_ctn_masivo : function (funcion){
        Comun.enviar_formulario_post('form_registro_alumnos_empleados_inscripcion_masiva', base_url + 'InscripcionesCTN/guardar_empleados_publiacion_ctn_masivo', funcion);
    },

    guardar_empresa_empleados_parcial_publicacion_ctn_masivo : function (funcion){
        Comun.enviar_formulario_post('form_registro_alumnos_empleados_inscripcion_masiva', base_url + 'InscripcionesCTN/guardar_parcial_empleados_publicacion_ctn_masivo', funcion);
    },

    enviar_recibo_validacion_civika : function (btn){
        var id_alumno_inscrito_ctn_publicaco = btn.data('id_alumno_inscrito_ctn_publicado');
        var html_buton = btn.html();
        btn.attr('disabled',true);
        btn.html('Procesando...');
        $.ajax({
            type : "POST",
            url : base_url + 'InscripcionesCTN/enviar_recibo_validacion_civik_alumno/' + id_alumno_inscrito_ctn_publicaco,
            data : {},
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mostrar_modal_bootstrap('modal_validar_datos_alumno_validar_recibo',false);
                    Comun.mensaje_operacion_modal('success',response.msg,'');
                    setTimeout(function(){
                        location.href = base_url;
                    },1500);
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                    btn.removeAttr('disabled');
                    btn.html(html_buton);
                }
            },
            error: function (xhr) {
                alert(xhr.status);
                btn.removeAttr('disabled');
                btn.html(html_buton);
            }
        });
    },

    enviar_recibo_validacion_civika_sin_dc3 : function (btn){
        var id_alumno_inscrito_ctn_publicaco = btn.data('id_alumno_inscrito_ctn_publicado');
        var html_buton = btn.html();
        btn.attr('disabled',true);
        btn.html('Procesando...');
        $.ajax({
            type : "POST",
            url : base_url + 'InscripcionesCTN/enviar_recibo_validacion_civik_alumno_sin_dc3/' + id_alumno_inscrito_ctn_publicaco,
            data : {},
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mostrar_modal_bootstrap('modal_validar_datos_alumno_validar_recibo',false);
                    Comun.mensaje_operacion_modal('success',response.msg,'');
                    setTimeout(function(){
                        location.href = base_url;
                    },1500);
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                    btn.removeAttr('disabled');
                    btn.html(html_buton);
                }
            },
            error: function (xhr) {
                alert(xhr.status);
                btn.removeAttr('disabled');
                btn.html(html_buton);
            }
        });
    },

    concluir_registro_dc3 : function (btn){
        var id_alumno_inscrito_ctn_publicado = btn.data('id_alumno_inscrito_ctn_publicado');
        var html_buton = btn.html();
        btn.attr('disabled',true);
        btn.html('Procesando...');
        $.ajax({
            type : "POST",
            url : base_url + 'InscripcionesCTN/concluir_registro_dc3/' + id_alumno_inscrito_ctn_publicado,
            data : {},
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mostrar_modal_bootstrap('modal_validar_datos_alumno_validar_recibo',false);
                    Comun.mensaje_operacion_modal('success',response.msg,'');
                    setTimeout(function(){
                        location.href = base_url;
                    },1500);
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                    btn.removeAttr('disabled');
                    btn.html(html_buton);
                }
            },
            error: function (xhr) {
                alert(xhr.status);
                btn.removeAttr('disabled');
                btn.html(html_buton);
            }
        });
    },

    actualizacion_semaforo_alumno_confirmacion : function (ipt_radio){
        var ul = ipt_radio.closest('ul');
        var value = ipt_radio.val();
        var id_alumno_inscrito_ctn_publicado = ipt_radio.data('id_alumno_inscrito_ctn_publicado');
        $.ajax({
            type : "POST",
            url : base_url + 'InscripcionesCTN/semaforo_alumno_confirmacion',
            data : {
                id_alumno_inscrito_ctn_publicado : id_alumno_inscrito_ctn_publicado,
                semaforo_asistencia : value
            },
            dataType : "json",
            success:function (response) {
                if(!response.exito){
                    Comun.mensaje_operacion('error',response.msg);
                }else{
                    ul.find('span#no_asiste_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-danger');
                    ul.find('span#no_asiste_'+id_alumno_inscrito_ctn_publicado).addClass('badge-outline-danger');
                    ul.find('span#no_seguro_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-warning');
                    ul.find('span#no_seguro_'+id_alumno_inscrito_ctn_publicado).addClass('badge-outline-warning');
                    ul.find('span#asiste_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-success');
                    ul.find('span#asiste_'+id_alumno_inscrito_ctn_publicado).addClass('badge-outline-success');
                    if(value == 'no_asiste'){
                        ul.find('span#no_asiste_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-outline-danger');
                        ul.find('span#no_asiste_'+id_alumno_inscrito_ctn_publicado).addClass('badge-danger');
                    }if(value == 'no_seguro'){
                        ul.find('span#no_seguro_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-outline-warning');
                        ul.find('span#no_seguro_'+id_alumno_inscrito_ctn_publicado).addClass('badge-warning');
                    }if(value == 'asiste'){
                        ul.find('span#asiste_'+id_alumno_inscrito_ctn_publicado).removeClass('badge-outline-success');
                        ul.find('span#asiste_'+id_alumno_inscrito_ctn_publicado).addClass('badge-success');
                    }
                }
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    validar_observar_comprobante_alumno : function(btn_lnk){
        $('.error').remove();
        $('.is-invalid').removeClass();
        var id_alumno = btn_lnk.data('id_alumno');
        var html_btn_lnk = btn_lnk.html();
        btn_lnk.html('Procesando...');
        btn_lnk.attr('disabled',true);
        var id_alumno_inscrito_ctn_publicado = btn_lnk.data('id_alumno_inscrito_ctn_publicado');
        var slt_comprobante = $('#slt_cumple_comprobante_'+id_alumno);
        var txt_observacion_comprobante = $('#txt_observacion_comprobante_'+id_alumno);
        var cumple_comprobante = slt_comprobante.val();
        var observacion_comprobante = txt_observacion_comprobante.val();
        var validacion = true;
        if(cumple_comprobante == ''){
            validacion = false;
            slt_comprobante.closest('div').append('<em class="error invalid-feedback">Campo requerido</em>');
            Comun.mensaje_operacion('error','El "¿Cumple comprobante es requerido?"','#msg_validacion_registro_alumnos',6000);
        }if(cumple_comprobante == 'no' && observacion_comprobante == ''){
            validacion = false;
            txt_observacion_comprobante.closest('div').append('<em class="error invalid-feedback">Campo requerido</em>');
            Comun.mensaje_operacion('error','La observación es requerida','#msg_validacion_registro_alumnos',6000);
        }
        if(validacion){
            var post = {
                id_alumno : id_alumno,
                id_alumno_inscrito_ctn_publicado : id_alumno_inscrito_ctn_publicado,
                cumple_comprobante : cumple_comprobante,
                observacion_comprobante : observacion_comprobante
            };
            $.ajax({
                type: "POST",
                url: base_url + 'InscripcionesCTN/validarObservarComprobantePagoAlumno',
                data: post,
                dataType: "json",
                success:function (respuesta) {
                    if(respuesta.exito){
                        Comun.mensaje_operacion('confirmed',respuesta.msg,'#msg_validacion_registro_alumnos');
                        $('#slt_cumple_comprobante_'+id_alumno).attr('disabled',true);
                        $('#txt_observacion_comprobante_'+id_alumno).attr('disabled',true);
                        var row = btn_lnk.closest('tr');
                        if(respuesta.inscripcion_realizada){
                            var instructor_asignado = respuesta.instructor_asignado;
                            var fecha_pago_validado = respuesta.fecha_pago_validado;
                            row.find('span.instructor_asignado').html(instructor_asignado);
                            row.find('span.fecha_pago_validado').html(fecha_pago_validado);
                            row.find('span.estatus_inscripcion').html('Inscrito');
                            row.find('span.estatus_inscripcion').removeClass('badge-warning');
                            row.find('span.estatus_inscripcion').addClass('badge-success');
                        }else{
                            row.find('span.estatus_inscripcion').html('Pago observado');
                        }
                        btn_lnk.remove();
                        //$('.cerrar_modal_alumnos_publicacion').addClass('close_modal_registro_alumnos_publicacion');
                    }else{
                        Comun.mensaje_operacion('error',respuesta.msg);
                        btn_lnk.html(html_btn_lnk);
                        btn_lnk.removeAttr('disabled');
                    }
                },
                error: function (xhr) {
                    alert(xhr.status);
                }
            });
        }else{
            btn_lnk.html(html_btn_lnk);
            btn_lnk.removeAttr('disabled');
        }
    },

    cargar_carta_descriptiva : function(btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        $('#container_operacion_carta_descriptiva').html('');
        Comun.obtener_contenido_peticion_html(
            base_url + 'InscripcionesCTN/carta_descriptiva_curso/' + id_publicacion_ctn,{},
            function (response) {
                $('#container_operacion_carta_descriptiva').html(response);
                Comun.mostrar_modal_bootstrap('modal_carta_descriptiva_ctn',true);
            }
        );
    },

    iniciar_registro_alumno_curso_publicado : function (btn){
        $('#container_registro_alumno_nuevo_ctn_publicado').html('');
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_registro_nuevo_alumno_ctn_publicado/' + id_publicacion_ctn,{},
            function(response){
                $('#container_registro_alumno_nuevo_ctn_publicado').html(response);
                $('#seccion_resutados_alumnos_registrados').fadeOut();
            }
        );
    },

    registrar_alumno_existente_ctn_publicado : function (btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        var id_usuario = btn.data('id_usuario');
        var post = {
            id_publicacion_ctn : id_publicacion_ctn,
            id_usuario : id_usuario
        };
        $.ajax({
            type: "POST",
            url: base_url + 'InscripcionesCTN/registrar_alumno_existente_ctn_publicado',
            data: post,
            dataType: "json",
            success:function (response) {
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg,'#form_mensajes_curso_registro');
                }else{
                    Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_registro');
                }
                $('#btn_buscar_alumnos_registrados_sistema').trigger('click');
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    validar_rfc_publicacion_ctn_masivo : function (btn){
        var post = Comun.obtener_post_formulario('form_validar_rfc_registro_masivo_curso');
        Inscripciones.validar_rfc_publicacion_ctn_masivo_post_send(post);
    },

    validar_rfc_publicacion_ctn_masivo_post_send : function(post,mostrar_mensaje = true){
        $.ajax({
            type: "POST",
            url: base_url + 'InscripcionesCTN/validar_rfc_empresa_publicacion_ctn',
            data: post,
            dataType: 'json',
            success : function(response){
                if(response.exito){
                    if(mostrar_mensaje){
                        Comun.mensaje_operacion('success',response.msg);
                    }
                    $('#validacion_registro_empresa_trabajadores').html(loader_gif);
                    Comun.obtener_contenido_peticion_html(
                        base_url + 'InscripcionesCTN/capturar_empleados_publicacion_ctn_masivo',post,
                        function(response){
                            $('#validacion_registro_empresa_trabajadores').html(response);
                            Comun.funcion_fileinput('Subir logotipo');
                            Cursos.iniciar_carga_archivos_logotipo_empresa();
                        }
                    );
                }else{
                    //Comun.btn_guardar_enable(btn,'Validar RFC');
                    $('.validar_rfc_inscripcion_masiva').removeAttr('disabled');
                    $('.validar_rfc_inscripcion_masiva').html('Validar RFC');
                    Comun.mensaje_operacion('error',response.msg);
                }
            },
            error :  function (xhr){
                alert(xhr.status);
                Comun.btn_guardar_enable(btn,'Validar RFC');
            }
        });
    },

    eliminar_alumno_inscrito_ctn_publicado : function(btn){
        var id_usuario = btn.data('id_usuario');
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        var rfc_empresa = btn.data('rfc_empresa');
        $.ajax({
            type: "POST",
            url: base_url + 'InscripcionesCTN/eliminar_alumno_inscrito_ctn_publicado/' + id_usuario,
            data: {},
            dataType: 'json',
            success : function(response){
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg);
                    var post_send_validacion = {
                        id_publicacion_ctn : id_publicacion_ctn,
                        rfc : rfc_empresa
                    };
                    Inscripciones.validar_rfc_publicacion_ctn_masivo_post_send(post_send_validacion,false);
                }else{
                    Comun.btn_guardar_enable(btn,'<i class="fa fa-trash"></i>');
                    Comun.mensaje_operacion('error',response.msg);
                }
            },
            error :  function (xhr){
                alert(xhr.status);
                Comun.btn_guardar_enable(btn,'<i class="fa fa-trash"></i>');
            }
        });
    },

    es_publicacion_unica : function(){
        var es_unica = $('#es_publicacion_unica');
        if(es_unica.val() == 'si'){
            var id_publicacion_ctn = es_unica.data('id_publicacion_ctn');
            setTimeout(function(){
                $('#btn_carta_descriptiva_'+id_publicacion_ctn).trigger('click')
            },1000);
        }
    },

    reinicio_formato_dc3_pdf : function(){
        var html_frame_dc3 = $('#frame_validacion_dc3_pago_online').html();
        $('#frame_validacion_dc3_pago_online').html(loader_gif);
        setTimeout(function(){
            $('#frame_validacion_dc3_pago_online').html(html_frame_dc3);
        },500);
    }

}
