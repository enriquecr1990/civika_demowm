$(document).ready(function () {

    /**
     * funciones/eventos para el administrar ctn
     */
    $('body').on('click','.agregar_nuevo_curso_civik',function(e){
        e.isDefaultPrevented();
        Cursos.agregar_modificar_curso($(this));
    });

    $('body').on('click','.modificar_curso_civik',function(e){
        e.isDefaultPrevented();
        Cursos.agregar_modificar_curso($(this));
    });

    $('body').on('click','.ver_detalle_publicacion_ctn',function (e) {
        e.preventDefault();
        Cursos.ver_detalle_curso($(this));
    });

    $('body').on('click','.publicar_curso_civik',function(e){
        e.isDefaultPrevented();
        Cursos.publicar_curso($(this));
    });

    $('body').on('click','.modificar_publicacion_curso_civik',function(e){
        e.isDefaultPrevented();
        Cursos.publicar_curso($(this));
    });

    $('body').on('click','.publicar_curso_masivo_civik',function(e){
        e.isDefaultPrevented();
        Cursos.publicar_curso_masivo($(this));
    });

    $('body').on('click','.modificar_publicacion_curso_masivo_civik',function(e){
        e.isDefaultPrevented();
        Cursos.publicar_curso_masivo($(this));
    });

    $('body').on('click','.publicar_evaluacion_online',function(e){
        e.preventDefault();
        Cursos.publicar_evaluacion_online($(this));
    });

    $('body').on('click','.modificar_publicacion_evaluacion_online',function(e){
        e.preventDefault();
        Cursos.publicar_evaluacion_online($(this));
    });

    $('body').on('click','.agregar_row_material_apoyo', function(e){
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        Comun.funcion_fileinput('Subir material');
        Cursos.iniciar_carga_archivos_material_apoyo();
    });

    $('body').on('click','.agregar_row_instructor_aula', function(e){
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
    });

    $('body').on('click','.registro_alumnos_publiacion_ctn',function(e){
        e.preventDefault();
        Cursos.obtener_registro_alumnos_publicacion($(this));
    });

    $('body').on('click','.antologia_ctn',function(e){
        e.preventDefault();
        Cursos.obtener_antologia_ctn($(this));
    });

    $('body').on('change','#input_nombre_comercial',function(e){
        e.preventDefault();
        var value= $(this).val();
        $('#nombre_aparece_constancia').html(value);
    });

    //funciones para guardar informacion
    $('body').on('click','.guardar_curso_civik',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_curso();
        if(form_valido){
            Cursos.guardar_curso(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_curso',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_cursos();
                        Comun.btn_guardar_enable(btn,'Aceptar');
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_registro');
                        Comun.btn_guardar_enable(btn,'Aceptar');
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Aceptar');
        }
    });

    $('body').on('click','.guardar_publicacion_ctn',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicicacion_curso();
        if(form_valido){
            Cursos.guardar_publicacion_curso(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_curso_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_cursos();
                        Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                        setTimeout(function(){
                            Comun.mensaje_operacion_modal(undefined,response.mensaje_redes_sociales,response.mensaje_redes_sociales_btn);
                        },1000);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_publicacion');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
            Comun.btn_guardar_enable(btn,html_button);
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.guardar_publicacion_ctn_empresa',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicicacion_curso_empresa();
        if(form_valido){
            Cursos.guardar_publicacion_curso_empresa(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_curso_masivo_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        if(response.id_publicacion_ctn != undefined && response.id_publicacion_ctn != ''){
                            var post = {
                                rfc : response.rfc,
                                correo : response.correo,
                                id_cotizacion : response.id_cotizacion
                            }
                            Cursos.iniciar_registro_envio_masivo_empresa(response.id_publicacion_ctn,post);
                        }else{
                            Cursos.trigger_buscar_cursos();
                            Cursos.trigger_buscar_publicaciones_cursos();
                            Comun.btn_guardar_enable(btn,html_button);
                        }
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_publicacion');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.guardar_publicacion_evaluacion_online',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicicacion_evaluacion_online();
        if(form_valido){
            Cursos.guardar_publicacion_evaluacion_online(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_evaluacion_online_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_cursos();
                        Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_publicacion');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.enviar_informacion_publicacion_masiva',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicicacion_curso_empresa_envio_informacion();
        if(form_valido){
            Cursos.enviar_publicacion_curso_masivo(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_curso_masivo_envio_publicacion',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_cursos();
                        Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                        if($('#id_cotizacion').val() != undefined && $('#id_cotizacion').val() != 0){
                            Cotizacion.trigger_buscar_cotizacion();
                        }
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_curso_publicacion');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.iniciar_cancelacion_curso',function(e){
        e.isDefaultPrevented();
        Cursos.iniciar_cancelacion_curso($(this));
    });

    $('body').on('click','.cancelar_curso',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_cancelacion_curso();
        if(form_valido){
            Cursos.guardar_cancelacion_curso(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_cancelacion_curso_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_cancelacion_curso');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.iniciar_cancelacion_publicacion_curso',function(e){
        e.isDefaultPrevented();
        Cursos.iniciar_cancelacion_publicacion_curso($(this));
    });

    $('body').on('click','.cancelar_publicacion_curso',function(e){
        e.isDefaultPrevented();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_cancelacion_publicacion_curso();
        if(form_valido){
            Cursos.guardar_cancelacion_publicacion_curso(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_cancelacion_publicacion_curso_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_mensajes_cancelacion_curso_presencial');
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.iniciar_publicacion_galeria_imagenes',function(e){
        e.isDefaultPrevented();
        Cursos.iniciar_publicacion_galeria_ctn($(this));
    });

    $('body').on('click','.eliminar_foto_galeria_pub_ctn',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('change','.input_asistencia_alumno',function(e){
        e.isDefaultPrevented();
        Cursos.registrar_asistencia_alumno($(this));
    });

    $('body').on('click','#check_box_asistencia_masiva',function(e){
        e.isDefaultPrevented();
        Cursos.registrar_asistencia_masiva_alumno($(this));
    });

    $('body').on('click','.iniciar_encuesta_satisfaccion',function(e){
        e.preventDefault();
        Cursos.iniciar_encuesta_satisfacion($(this));
    });

    $('body').on('click','#buscar_tablero_asistencia',function (e) {
        e.preventDefault();
        Comun.obtener_sumatoria_tabla('#tbl_asistencia_alumnos','input.asistieron','#total_asistencia');
    });

    $('body').on('change','.slt_sede_imparticion',function(){
        var value = $(this).val();
        var span_help = '';
        $('#input_lugar_imparticion').val('');
        $('#input_mapa').val('');
        if(value != ''){
            var lugar_imparticion = $(this).find('option[value="'+value+'"]').data('lugar_imparticion');
            var mapa = $(this).find('option[value="'+value+'"]').data('mapa');
            var sede = $(this).find('option[value="'+value+'"]').data('sede');
            var telefono_sede = $(this).find('option[value="'+value+'"]').data('telefono_sede');
            span_help += '<a target="_blank" href="'+mapa+'">'+lugar_imparticion+'</a>';
            $('#input_lugar_imparticion').val(lugar_imparticion);
            $('#input_mapa').val(mapa);
            $('#nombre_sede').val(sede);
            $('#telefono_sede').val(telefono_sede);
        }
        $('span#selected_sede_impartición').html(span_help);
    });

    $('body').on('click','.publicar_link_evaluacion',function(e){
        e.preventDefault();
        Cursos.publicar_link_evaluacion_online($(this));
    });

    $('body').on('change','#slt_empresa_publicacion_online',function (e) {
        e.preventDefault();
        var select = $(this).val();
        if(select == 'si'){
            $('#link_evaluacion_online').fadeIn();
        }else{
            $('#link_evaluacion_online').fadeOut();
        }
    });

    $('body').on('click','.guardar_publicacion_evaluacion_online_link',function(e){
        e.preventDefault();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicacion_evalucion_online_link();
        if(form_valido){
            Cursos.guardar_publicacion_link_evaluacion_online(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_link_evaluacion_online_civika',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    $('body').on('click','.publicacion_ctn_vademecum',function(e){
        e.preventDefault();
        Cursos.obtener_modal_archivo_vademecum($(this));
    });

    $('body').on('click','.publicacion_aceptar_descarga_vademecum',function (e) {
        e.preventDefault();
        var btn = $(this);
        var confirmacion = confirm('¿Está seguro de que ya descargo todos los archivos vademecum disponibles?');
        if(confirmacion){
            Cursos.aceptar_descarga_vademecum(btn);
        }
    });

    $('body').on('click','.publicacion_eva_subir_material',function(e){
        e.preventDefault();
        Cursos.obtener_modal_subir_material($(this));
    });

    $('body').on('click','.agregar_row_material_evidencia', function(e){
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        Comun.funcion_fileinput('Subir material');
        Cursos.iniciar_carga_archivos_material_evidencia();
    });

    $('body').on('change','.slt_material_tipo_evidencia',function(e){
        e.preventDefault();
        var row = $(this).closest('tr');
        var id_slt = $(this).val();
        row.find('div.contenedor_video').hide();
        row.find('div.contenedor_archivo_documento').hide();
        if(id_slt == 1){
            row.find('div.contenedor_archivo_documento').fadeIn();
        }if(id_slt == 2){
            row.find('div.contenedor_video').fadeIn();
        }
    });

    $('body').on('click','.publicacion_guardar_material_evidencia',function(e){
        e.preventDefault();
        var btn = $(this);
        var html_button = btn.html();
        Comun.btn_guardar_disabled(btn);
        var form_valido = Cursos.validar_form_publicacion_material_evidencia();
        if(form_valido){
            Cursos.guardar_publicacion_material_evidencia(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_publicacion_subir_archivos_material',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        //Cursos.trigger_buscar_publicaciones_cursos();
                        Comun.btn_guardar_enable(btn,html_button);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                        Comun.btn_guardar_enable(btn,html_button);
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,html_button);
        }
    });

    /**
     * funciones comunes para el adminctn
     */
    Comun.funciones_datepicker(false);
    Comun.funcion_tooltip();

    /**
     * funciones iniciales para el adminCTN
     */
    Cursos.trigger_buscar_cursos();
    Cursos.trigger_buscar_publicaciones_cursos();
    Cursos.trigger_buscar_publicaciones_cursos_alumnos();

});

var Cursos = {

    //funciones para validar y guardar curso
    reglas_validate_curso : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    reglas_validate_curso_publicacion : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    validar_form_curso : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_curso_civika',Cursos.reglas_validate_curso());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            var checked_mostrar_banner_principal = $('#form_guardar_curso_civika').find('input#chk_mostrar_banner').is(':checked');
            if(checked_mostrar_banner_principal){
                var documento_banner = $('#form_guardar_curso_civika').find('input.documento_banner_proximo_curso');
                if(documento_banner.length == 0){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Existen campos requeridos en el formulario, favor de revisar');
                    $('#div_conteiner_file_banner_proxico_curso').append('<span class="error requerido">La imagen de banner para proximo curso es necesario</span>');
                }
            }
            return form_valido;
        }
        return form_valido;
    },

    validar_form_publicicacion_curso : function (es_curso_abierto = true) {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_publicacion_curso',Cursos.reglas_validate_curso_publicacion());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            var banner_id_documento = $('#form_guardar_publicacion_curso').find('input#banner_id_documento');
            var rows_material_apoyo = $('#tbodyMaterialApoyo').find('tr');
            var num_checkeds = $('.catalogo_constancia:checked').length;
            if(banner_id_documento.length == 0 && es_curso_abierto){
                form_valido = false;
                $('#div_conteiner_file_banner').html('<span class="error requerido">La imagen del curso es obligatoria.</span>');
            }if(rows_material_apoyo.length != 0){
                rows_material_apoyo.each(function(){
                    var row = $(this);
                    var material_apoyo_publicar_curso = row.find('input.material_apoyo_publicar_curso');
                    if(material_apoyo_publicar_curso.length == 0){
                        form_valido = false;
                        row.find('div.conteiner_file_material_apoyo').html('<span class="error requerido">Documento obligatorio.</span>');
                    }
                });
            }if(num_checkeds == 0){
                form_valido = false;
                $('#inputs_checkeds_constancias').append('<span class="error requerido">Es necesario por lo menos una constancia otorgada.</span>');
            }
            return form_valido;
        }
        if(!form_valido){
            window.location.hash = '#form_guardar_publicacion_curso';
            Comun.mensaje_operacion('error','Existen campos requeridos en su formulario, favor de revisar','#form_mensajes_curso_publicacion');
        }
        return form_valido;
    },

    validar_form_publicicacion_curso_empresa : function(){
        var form_valido = Cursos.validar_form_publicicacion_curso(false);
        if(form_valido){
            var rfc_empresa = $('#input_rfc_empresa');
            if(Comun.validar_rfc(rfc_empresa.val()) == null){
                form_valido = false;
                rfc_empresa.addClass('is-invalid');
                rfc_empresa.closest('div').append('<em class="error invalid-feedback">El RFC no tiene la estructura correcta</em>');
            }
        }
        return form_valido;
    },

    validar_form_publicicacion_curso_empresa_envio_informacion : function(){
        var form_valido = Cursos.validar_form_publicicacion_curso(false);
        if(form_valido){
            /*var rfc_empresa = $('#input_rfc_empresa');
            if(Comun.validar_rfc(rfc_empresa.val()) == null){
                form_valido = false;
                rfc_empresa.addClass('is-invalid');
                rfc_empresa.closest('div').append('<em class="error invalid-feedback">El RFC no tiene la estructura correcta</em>');
            }*/
        }
        return form_valido;
    },

    validar_form_cancelacion_curso : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_cancelar_curso_presencial',Cursos.reglas_validate_curso());
        if(form_valido){
            return form_valido;
        }
        return form_valido;
    },

    validar_form_cancelacion_publicacion_curso : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_cancelar_publicacion_curso_presencial',Cursos.reglas_validate_curso());
        if(form_valido){
            return form_valido;
        }
        return form_valido;
    },

    validar_form_publicicacion_evaluacion_online : function(){
        var form_valido = Cursos.validar_form_publicicacion_curso();
        if(form_valido){
            var rows_material_apoyo = $('#tbodyMaterialApoyo').find('tr');
            if(rows_material_apoyo.length == 0){
                form_valido = false;
                Comun.mensaje_operacion('error','Es necesario por lo menos un archivo del Vademecum para el alumno');
            }
        }
        return form_valido;
    },

    validar_form_publicacion_evalucion_online_link : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_publicacion_link_evaluacion_online',Cursos.reglas_validate_curso());
        if(form_valido){
            return form_valido;
        }
        return form_valido;
    },

    validar_form_publicacion_material_evidencia : function () {
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_material_evidencia',Cursos.reglas_validate_curso());
        if(form_valido){
            var rows_material_evidencia = $('#tbodyMaterialEvidencia').find('tr');
            if(rows_material_evidencia.length == 0){
                form_valido = false;
                Comun.mensaje_operacion('error','Es necesario por lo menos un registro de la evidencia de trabajo');
            }else{
                var flag_archivos = true;
                rows_material_evidencia.each(function(){
                    var row = $(this);
                    if(row.find('select.slt_material_tipo_evidencia').val() == 1 && row.find('input.publicacion_material_evidencia').length == 0){
                        flag_archivos = false;
                    }
                });
                if(!flag_archivos){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Es necesario que agrege todos los archivos de la evidencia');
                }
            }
            return form_valido;
        }
        return form_valido;
    },

    guardar_curso : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_curso_civika', base_url + 'AdministrarCTN/guardarCurso', funcion);
    },

    guardar_publicacion_curso : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_publicacion_curso', base_url + 'AdministrarCTN/guardarPublicacionCurso', funcion);
    },

    guardar_publicacion_curso_empresa : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_publicacion_curso', base_url + 'AdministrarCTN/guardar_publicacion_curso_empresa', funcion);
    },

    guardar_publicacion_evaluacion_online : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_publicacion_curso', base_url + 'AdministrarCTN/guardar_publicacion_evaluacion_online', funcion);
    },

    guardar_cancelacion_curso : function (funcion) {
        Comun.enviar_formulario_post('form_cancelar_curso_presencial', base_url + 'AdministrarCTN/cancelar_curso', funcion);
    },

    guardar_publicacion_link_evaluacion_online : function (funcion) {
        Comun.enviar_formulario_post('form_publicacion_link_evaluacion_online', base_url + 'AdministrarCTN/guardar_evalucacion_online_link', funcion);
    },

    guardar_cancelacion_publicacion_curso : function (funcion) {
        Comun.enviar_formulario_post('form_cancelar_publicacion_curso_presencial', base_url + 'AdministrarCTN/cancelar_publicacion_curso', funcion);
    },

    guardar_publicacion_material_evidencia : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_material_evidencia', base_url + 'Alumnos/guardar_publicacion_material_evidencia', funcion);
    },

    enviar_publicacion_curso_masivo : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_publicacion_curso_enviar_informacion', base_url + 'AdministrarCTN/notificar_empresa_publicacion_ctn_masivo', funcion);
    },

    trigger_buscar_cursos : function(){
        $('#btn_buscar_cursos').trigger('click');
    },

    trigger_buscar_publicaciones_cursos : function(){
        $('#btn_buscar_publicaciones_curso').trigger('click');
    },

    trigger_buscar_publicaciones_cursos_alumnos : function(){
        $('#btn_buscar_registro_alumno_publicacion').trigger('click');
    },

    agregar_modificar_curso : function (btn_lnk){
        var id_curso_taller_norma = (btn_lnk.data('id_curso_taller_norma') != undefined && btn_lnk.data('id_curso_taller_norma') != '') ? btn_lnk.data('id_curso_taller_norma') : '';
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/agregarModificarCurso/' + id_curso_taller_norma,{},
            function(response){
                $('#conteiner_agregar_modificar_curso').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_curso',true);
                Comun.funcion_fileinput('Subir banner');
                Cursos.iniciar_carga_archivos_banner_proxico_curso();
            }
        );
    },

    ver_detalle_curso : function (btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/ver_detalle_publicacion_ctn/' + id_publicacion_ctn,{},
            function(response){
                $('#conteiner_publicar_curso').html(response);
                Comun.mostrar_modal_bootstrap('modal_detalle_publicacion_curso_civika',true);
                Comun.funcion_popover();
                $('.popoverShowImage').trigger('click');
                $('#modal_detalle_publicacion_curso_civika').find('select').attr('disabled',true);
            }
        )
    },

    publicar_curso : function (btn_lnk){
        var id_curso_taller_norma = btn_lnk.data('id_curso_taller_norma');
        var id_publicacion_ctn = '';
        if(btn_lnk.data('id_publicacion_ctn') != undefined && btn_lnk.data('id_publicacion_ctn') != ''){
            id_publicacion_ctn = '/' + btn_lnk.data('id_publicacion_ctn');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciarModificarPublicacionCTN/' + id_curso_taller_norma + id_publicacion_ctn,{},
            function(response){
                $('#conteiner_publicar_curso').html(response);
                Comun.mostrar_modal_bootstrap('modal_publicacion_curso_civika',true);
                Comun.funcion_fileinput('Subir banner');
                Comun.funciones_datepicker(true);
                Comun.funcion_tooltip();
                Cursos.iniciar_carga_archivos_banner();
                if($('#tbodyInstructorAula').find('tr').length == 0){
                    $('#agregar_instructor_aula').trigger('click');
                }
            }
        )
    },

    publicar_curso_masivo : function (btn_lnk){
        var id_curso_taller_norma = btn_lnk.data('id_curso_taller_norma');
        var id_publicacion_ctn = '';
        var post_send = {
            id_cotizacion: 0
        };
        if(btn_lnk.data('id_publicacion_ctn') != undefined && btn_lnk.data('id_publicacion_ctn') != ''){
            id_publicacion_ctn = '/' + btn_lnk.data('id_publicacion_ctn');
        }if(btn_lnk.data('id_cotizacion') != undefined && btn_lnk.data('id_cotizacion') != ''){
            post_send = {
                id_cotizacion:btn_lnk.data('id_cotizacion')
            };
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_modificacion_publicacion_ctn_masivo/' + id_curso_taller_norma + id_publicacion_ctn,post_send,
            function(response){
                $('#conteiner_publicar_curso_masivo').html(response);
                Comun.mostrar_modal_bootstrap('modal_publicacion_curso_masivo_civika',true);
                Comun.funcion_fileinput('Subir logotipo');
                Comun.funciones_datepicker();
                Comun.funcion_tooltip();
                Cursos.iniciar_carga_archivos_logotipo_empresa();
                if($('#tbodyInstructorAula').find('tr').length == 0){
                    $('#agregar_instructor_aula').trigger('click');
                }
            }
        )
    },

    publicar_evaluacion_online : function (btn_lnk){
        var id_curso_taller_norma = btn_lnk.data('id_curso_taller_norma');
        var id_publicacion_ctn = '';
        if(btn_lnk.data('id_publicacion_ctn') != undefined && btn_lnk.data('id_publicacion_ctn') != ''){
            id_publicacion_ctn = '/' + btn_lnk.data('id_publicacion_ctn');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_modificacion_publicacion_evaluacion_online/' + id_curso_taller_norma + id_publicacion_ctn,{},
            function(response){
                $('#conteiner_publicar_curso_masivo').html(response);
                Comun.mostrar_modal_bootstrap('modal_publicacion_evaluacion_online_civika',true);
                Comun.funcion_fileinput('Subir material');
                Comun.funciones_datepicker();
                Comun.funcion_tooltip();
                Cursos.iniciar_carga_archivos_banner();
                if($('#tbodyInstructorAula').find('tr').length == 0){
                    $('#agregar_instructor_aula').trigger('click');
                }
            }
        )
    },

    obtener_registro_alumnos_publicacion :  function (btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/registro_alumnos_publicacion_ctn/' + id_publicacion_ctn,{},
            function (response) {
                $('#container_registro_alumnos_publicacion').html(response);
                Comun.mostrar_modal_bootstrap('modal_registro_alumnos_publicacion',true);
                //Comun.funcion_data_table();
                Comun.funcion_tooltip();
                $('#btn_buscar_registro_alumno_publicacion').trigger('click');
                $('#btn_group_lista_asistencia').trigger('click');
                $('#btn_group_constancias').trigger('click');
                $('#btn_group_constancias_instructor').trigger('click');
            }
        );
    },
    //// mi funcion
    obtener_antologia_ctn :  function (btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/registro_antologia/' + id_publicacion_ctn,{},
            function (response) {
                $('#container_antologia_ctn').html(response);
                Comun.mostrar_modal_bootstrap('modal_antologia_civika',true);
                //Comun.funcion_data_table();

            }
        );
    },

    /**
     * funciones para los upload de las imagenes
     */
    iniciar_carga_archivos_banner : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var tipo_img = 'img';
        $('.fileUploadBannerCurso').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {
                $('#div_conteiner_file_banner').html(loader_gif_transparente);
            },
            //tiempo de ejecucion
            add: function (e,data) {
                tipo_img = data.fileInput.data('tipo_banner') != undefined ? data.fileInput.data('tipo_banner') : 'img';
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
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div>' +
                        '<label for="banner_id_documento" class="col-form-label">Imagen del banner</label> <span class="help-block help-span">Puede reemplazar el banner subiendo otra imagen</span> <br>' +
                        '<input id="banner_id_documento" class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[banner][id_documento]" value="'+data.result.documento.id_documento+'">' +
                        '<input type="hidden" name="publicacion_has_doc_banner[banner][tipo]" value="'+tipo_img+'">' +
                        '<input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][titulo]" value="Banner del curso">' +
                        '<input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][descripcion]" value="Es la imagen principal que aparecerá en el banner del curso">' +
                        '<button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage" ' +
                        'data-nombre_archivo="'+data.result.documento.nombre+'" data-src_image="'+data.result.documento.ruta_documento+'">' +
                        '<i class="fa fa-image"></i>' +
                        '</button>' +
                        '</div>';
                    $('#div_conteiner_file_banner').html(html_respuesta);
                    Comun.funcion_popover();
                    $('.popoverShowImage').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_publicacion');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_carga_archivos_logotipo_empresa : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadLogotipoEmpresa').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {
                $('#div_conteiner_file_banner').html(loader_gif_transparente);
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
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<label for="banner_id_documento" class="col-form-label">Imagen del logotipo</label> <span class="help-block help-span">Puede reemplazar el banner subiendo otra imagen</span> <br>' +
                        '<input id="banner_id_documento" class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[banner][id_documento]" value="'+data.result.documento.id_documento+'">' +
                        '<input type="hidden" name="publicacion_has_doc_banner[banner][tipo]" value="logo_empresa">' +
                        '<input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][titulo]" value="Logotipo de la empresa">' +
                        '<input class="form-control" type="hidden" name="publicacion_has_doc_banner[banner][descripcion]" value="Es el logotipo de la empresa que se usara en la constancia de la DC-3">' +
                        '<button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage" ' +
                        'data-nombre_archivo="'+data.result.documento.nombre+'" data-src_image="'+data.result.documento.ruta_documento+'">' +
                        '<i class="fa fa-image"></i>' +
                        '</button>';
                    $('#div_conteiner_file_banner').html(html_respuesta);
                    Comun.funcion_popover();
                    $('.popoverShowImage').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_publicacion');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_carga_archivos_banner_proxico_curso : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadBannerProximoCurso').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {
                $('#div_conteiner_file_banner_proxico_curso').html(loader_gif_transparente);
            }, //tiempo de ejecucion
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
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div>' +
                        '<label for="banner_proximo_curso_id_documento" class="col-form-label">Imagen del banner</label> ' +
                        '<span class="help-block help-span">Puede reemplazar el banner subiendo otra imagen</span> <br>' +
                        '<input id="banner_proximo_curso_id_documento" class="documento_banner_proximo_curso" type="hidden" name="curso_taller_norma[id_documento]" value="'+data.result.documento.id_documento+'">' +
                        '<button type="button" class="btn btn-sm btn-pill btn-success popoverShowImage" ' +
                        'data-nombre_archivo="'+data.result.documento.nombre+'" data-src_image="'+data.result.documento.ruta_documento+'">' +
                        '<i class="fa fa-image"></i>' +
                        '</button>' +
                        '<a class="btn btn-secondary btn-pill btn-sm" href="'+data.result.documento.ruta_documento+'" target="_blank">Ver imagen</a> ' +
                        '</div>';
                    $('#div_conteiner_file_banner_proxico_curso').html(html_respuesta);
                    Comun.funcion_popover();
                    $('.popoverShowImage').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_registro');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_registro',8000);
            }
        });
    },

    iniciar_carga_archivos_material_apoyo : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var id_row = '';
        $('.fileUploadDocCurso').fileupload({
            url : base_url + 'Uploads/uploadFileComunPDF',
            dataType: 'json',
            start: function () {
                $('#div_conteiner_file_material_apoyo').html(loader_gif_transparente);
            }, //tiempo de ejecucion
            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo
                };
                id_row = data.fileInput.data('id_row');
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extencion_files_doc_pdf + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no permitido','#form_mensajes_curso_publicacion',8000);
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
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div>' +
                        '<input class="material_apoyo_publicar_curso" type="hidden" name="publicacion_has_doc_banner[material]['+id_row+'][id_documento]" value="'+data.result.documento.id_documento+'">' +
                        '<a href="'+data.result.documento.ruta_documento+'" target="_blank" class="btn btn-sm btn-pill btn-success " data-toggle="tooltip" title="Ver material de apoyo" >' +
                        '<i class="fa fa-file-pdf-o"></i>' +
                        '</a> ' +
                        '</div>';
                    $('#div_conteiner_file_material_apoyo_'+id_row).html(html_respuesta);
                    Comun.funcion_tooltip();
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_publicacion');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_carga_archivos_img_galeria_ctn : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadGaleriaCTN').fileupload({
            url : base_url + 'Uploads/uploadFileImgGaleriaCurso',
            dataType: 'json',
            start: function () {
                $('#loader_img_galeria_ctn').fadeIn();
            }, //tiempo de ejecucion
            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo,
                    id_publicacion_ctn: $('#id_publicacion_ctn').val()
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','#mensajes_img_galeria_ctn',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 1 Mb','#mensajes_img_galeria_ctn',8000);
                    goUpload = false;
                }if(goUpload){
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div id="img_publicacion_galeria_ctn_'+data.result.documento.id_documento+'" class="form-group col-lg-3 col-md-4 col-sm-6 col-12" > ' +
                        '<div class="card text-white text-right"> ' +
                        '<img class="card-img" src="'+data.result.documento.ruta_documento+'"> ' +
                        '<div class="card-overlay-galeria">' +
                        '<button type="button" class="btn btn-pill btn-sm btn-danger eliminar_foto_galeria_pub_ctn"' +
                        'data-url_operacion="'+base_url+'AdministrarCTN/eliminar_img_galeria/'+data.result.documento.id_documento+'"' +
                        'data-msg_operacion="Se eliminará la imágen de la galeria <label>¿deseá continuar?</label>" ' +
                        'data-remove_html="#img_publicacion_galeria_ctn_'+data.result.documento.id_documento+'">' +
                        '<i class="fa fa-trash-o"></i> ' +
                        '</button> ' +
                        '</div> ' +
                        '</div> ' +
                        '</div>';
                    $('#galeria_imagenes_ctn').append(html_respuesta);
                    $('#loader_img_galeria_ctn').fadeOut();
                }else{
                    $('#loader_img_galeria_ctn').fadeOut();
                    Comun.mensaje_operacion('error',data.result.msg,'#mensajes_img_galeria_ctn');
                }
            },
            error:function (xhr, ajaxOptions, thrownError) {
                $('#loader_img_galeria_ctn').fadeOut();
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_carga_archivos_img_galeria_banner : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        $('.fileUploadGaleriaCTN').fileupload({
            url : base_url + 'Uploads/uploadFileImgGaleriaCurso',
            dataType: 'json',
            start: function () {
                $('#loader_img_galeria_ctn').fadeIn();
            }, //tiempo de ejecucion
            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo,
                    id_publicacion_ctn: $('#id_publicacion_ctn').val()
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imagen admitida','#mensajes_img_galeria_ctn',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 1 Mb','#mensajes_img_galeria_ctn',8000);
                    goUpload = false;
                }if(goUpload){
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div id="img_publicacion_galeria_ctn_'+data.result.documento.id_documento+'" class="form-group col-lg-3 col-md-4 col-sm-6 col-12" > ' +
                        '<div class="card text-white text-right"> ' +
                        '<img class="card-img" src="'+data.result.documento.ruta_documento+'"> ' +
                        '<div class="card-overlay-galeria">' +
                        '<button type="button" class="btn btn-pill btn-sm btn-danger eliminar_foto_galeria_pub_ctn"' +
                        'data-url_operacion="'+base_url+'AdministrarCTN/eliminar_img_galeria/'+data.result.documento.id_documento+'"' +
                        'data-msg_operacion="Se eliminará la imágen de la galeria <label>¿deseá continuar?</label>" ' +
                        'data-remove_html="#img_publicacion_galeria_ctn_'+data.result.documento.id_documento+'">' +
                        '<i class="fa fa-trash-o"></i> ' +
                        '</button> ' +
                        '</div> ' +
                        '</div> ' +
                        '</div>';
                    $('#galeria_imagenes_ctn').append(html_respuesta);
                    $('#loader_img_galeria_ctn').fadeOut();
                }else{
                    $('#loader_img_galeria_ctn').fadeOut();
                    Comun.mensaje_operacion('error',data.result.msg,'#mensajes_img_galeria_ctn');
                }
            },
            error:function (xhr, ajaxOptions, thrownError) {
                $('#loader_img_galeria_ctn').fadeOut();
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_carga_archivos_material_evidencia : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var id_row = '';
        $('.fileUploadDocsEvidencia').fileupload({
            url : base_url + 'Uploads/uploadFileMaterialEvidencia',
            dataType: 'json',
            start: function () {
                //$('#div_conteiner_file_material_apoyo').html(loader_gif_transparente);
            }, //tiempo de ejecucion
            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo
                };
                id_row = data.fileInput.data('id_row');
                $('#div_conteiner_file_material_apoyo_'+id_row).html(loader_gif_transparente);
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extencion_files_material_evidencia + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no permitido','#form_mensajes_curso_publicacion',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 15 Mb','#form_mensajes_curso_publicacion',8000);
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
                        '<input class="publicacion_material_evidencia" type="hidden" name="alumno_publicacion_ctn_has_material['+id_row+'][id_documento]" value="'+data.result.documento.id_documento+'">' +
                        '<a href="'+data.result.documento.ruta_documento+'" target="_blank" class="btn btn-sm btn-pill btn-success " data-toggle="tooltip" title="Ver material de apoyo" >' +
                        '<i class="fa fa-file-pdf-o"></i>' +
                        '</a> ' +
                        '</div>';
                    $('#div_conteiner_file_material_apoyo_'+id_row).html(html_respuesta);
                    Comun.funcion_tooltip();
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_publicacion');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_publicacion',8000);
            }
        });
    },

    iniciar_cancelacion_curso : function(btn_lnk){
        var id_curso_taller_norma = btn_lnk.data('id_curso_taller_norma');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_cancelacion_curso/' + id_curso_taller_norma,{},
            function (response) {
                $('#conteiner_confirmacion_modal_cursos').html(response);
                Comun.mostrar_modal_bootstrap('modal_cancelacion_curso_civika',true);
            }
        );
    },

    iniciar_cancelacion_publicacion_curso : function(btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_cancelacion_publicacion_curso/' + id_publicacion_ctn,{},
            function (response) {
                $('#container_confirmacion_modal_publicacion_curso').html(response);
                Comun.mostrar_modal_bootstrap('modal_cancelacion_publicacion_curso_civika',true);
            }
        );
    },

    iniciar_publicacion_galeria_ctn: function (btn_lnk){
        var id_publicacion_ctn = btn_lnk.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_publicacion_galeria_ctn/' + id_publicacion_ctn,{},
            function(respuesta){
                $('#container_publicacion_galeria_ctn').html(respuesta);
                Comun.mostrar_modal_bootstrap('modal_publicacion_galeria_ctn',true);
                Comun.funcion_fileinput('Subir foto a galeria');
                Cursos.iniciar_carga_archivos_img_galeria_ctn();
            }
        );
    },

    iniciar_registro_envio_masivo_empresa:function(id_publicacion_ctn,post){
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/cargar_modal_notificar_informacion_empresa/' + id_publicacion_ctn,
            post,
            function(respuesta_ajax){
                $('#conteiner_enviar_informacion_empresa_curso').html(respuesta_ajax);
                Comun.mostrar_modal_bootstrap('modal_publicacion_curso_masivo_envio_publicacion',true);
            }
        );
    },

    registrar_asistencia_alumno : function (check){
        var id_alumno_inscrito_ctn_publicado = check.data('id_alumno_inscrito_ctn_publicado');
        var asistio = 'no';
        if(check.is(':checked')){
            asistio = 'si';
        }
        var post = {
            'id_alumno_inscrito_ctn_publicado' : id_alumno_inscrito_ctn_publicado,
            'asistio' : asistio
        };
        $.ajax({
            type : "POST",
            url : base_url + 'AdministrarCTN/registrar_asistencia_alumno',
            data : post,
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg,'#msg_validacion_registro_alumnos');
                    $('#btn_buscar_registro_alumno_publicacion').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',response.msg,'#msg_validacion_registro_alumnos');
                }
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    registrar_asistencia_masiva_alumno : function (check){
        var id_publicacion_ctn = check.data('id_publicacion_ctn');
        var asistio = 'no';
        if(check.is(':checked')){
            asistio = 'si';
        }
        var post = {
            'id_publicacion_ctn' : id_publicacion_ctn,
            'asistio' : asistio
        };
        $.ajax({
            type : "POST",
            url : base_url + 'AdministrarCTN/registrar_asistencia_masiva_alumno',
            data : post,
            dataType : "json",
            success:function (response) {
                if(response.exito){
                    Comun.mensaje_operacion('success',response.msg,'#msg_validacion_registro_alumnos');
                    $('#btn_buscar_registro_alumno_publicacion').trigger('click');
                }else{
                    Comun.mensaje_operacion('error',response.msg,'#msg_validacion_registro_alumnos');
                }
            },
            error: function (xhr) {
                alert(xhr.status);
            }
        });
    },

    iniciar_encuesta_satisfacion : function(btn){
        var id_instructor_asignado_ctn_publicado = btn.data('id_instructor_asignado_ctn_publicado');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/iniciar_encuesta_satisfacion_admin/' + id_instructor_asignado_ctn_publicado,
            {},
            function(respuesta_ajax){
                $('#conteiner_encuesta_satisfacion').html(respuesta_ajax);
                Comun.mostrar_modal_bootstrap('modal_encuesta_satisfaccion_admin',true);
            }
        );
    },

    publicar_link_evaluacion_online : function(btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'AdministrarCTN/publicar_link_evaluacion_online/' + id_publicacion_ctn,{},
            function(respuesta_ajax){
                $('#conteiner_publicar_curso').html(respuesta_ajax);
                Comun.mostrar_modal_bootstrap('modal_publicacion_link_evaluacion_online_civika',true);
            }
        );
    },

    obtener_modal_archivo_vademecum : function(btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        var id_alumno_inscrito_ctn_publicado = btn.data('id_alumno_inscrito_ctn_publicado');
        Comun.obtener_contenido_peticion_html(
            base_url + 'Alumnos/obtener_archivos_vademecum/' + id_publicacion_ctn + '/' + id_alumno_inscrito_ctn_publicado,{},
            function(respuesta_html){
                $('#contenedor_archivos_vademecum').html(respuesta_html);
                Comun.mostrar_modal_bootstrap('modal_publicacion_archivos_vademun',true);
            }
        );
    },

    aceptar_descarga_vademecum : function(btn){
        var id_alumno_inscrito_ctn_publicado = btn.data('id_alumno_inscrito_ctn_publicado');
        Comun.obtener_contenido_peticion_json(
            base_url + 'Alumnos/aceptar_descarga_vademecum/' + id_alumno_inscrito_ctn_publicado,{},
            function(response){
                if(response.exito){
                    Comun.mostrar_modal_bootstrap('modal_publicacion_archivos_vademun',false);
                    Comun.mensaje_operacion('confirmed',response.msg);
                    Cursos.trigger_buscar_publicaciones_cursos();
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                    Comun.btn_guardar_enable(btn,html_button);
                }
            }
        );
    },

    obtener_modal_subir_material : function(btn){
        var id_alumno_inscrito_ctn_publicado = btn.data('id_alumno_inscrito_ctn_publicado');
        var lectura = btn.data('lectura');
        Comun.obtener_contenido_peticion_html(
            base_url + 'Alumnos/obtener_modal_subir_material/' +  id_alumno_inscrito_ctn_publicado,{lectura : lectura},
            function(respuesta_html){
                $('#contenedor_subir_archivos_material').html(respuesta_html);
                Comun.mostrar_modal_bootstrap('modal_publicacion_subir_archivos_material',true,true);
                Comun.funcion_fileinput('Subir evidencia');
            }
        );
    },

}
