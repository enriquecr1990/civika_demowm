$(document).ready(function(){

    $('body').on('click','.registro_alumnos_publiacion_ctn_instructor',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.obtener_registro_alumnos_publicacion_instructor($(this));
    });

    $('body').on('click','.evaluacion_publicacion_ctn_agregar_pregunta',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.obtener_modal_agregar_modificar_pregunta($(this));
    });

    $('body').on('click','.evaluacion_publicacion_ctn_modificar_pregunta',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.obtener_modal_agregar_modificar_pregunta($(this));
    });

    $('body').on('change','#slt_opcion_pregunta_form',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.obtener_complemento_registro_opciones_pregunta($(this));
    });

    $('body').on('click','.agregar_row_respuesta_pregunta_up', function(e){
        e.preventDefault();
        Comun.funcion_agregar_rows_tabla($(this));
        Comun.funcion_fileinput('Imagen');
        EvaluacionPublicacionCTN.iniciar_carga_archivos_img_respuestas_evaluacion();
    });

    $('body').on('click','.guardar_pregunta_evaluacion_ctn',function(e){
        e.preventDefault();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        var form_valido = EvaluacionPublicacionCTN.validar_form_registro_pregunta_opciones();
        if(form_valido){
            EvaluacionPublicacionCTN.guardar_pregunta_opciones(
                function(response){
                    if(response.exito){
                        Comun.mostrar_modal_bootstrap('modal_registrar_modificar_pregunta_evaluacion',false);
                        Comun.mensaje_operacion('confirmed',response.msg);
                        EvaluacionPublicacionCTN.trigger_buscar_preguntas_evaluacion();
                    }else{
                        Comun.mensaje_operacion('error',response.msg,'#form_guardar_pregunta_evaluacion_ctn_msg');
                        Comun.btn_guardar_enable(btn,'Aceptar');
                    }
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Aceptar');
        }
    });

    $('body').on('click','.actualizar_rows_respuestas_preguntas_relacionales',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.actualizar_secuenciales_preguntas_relaciones();
    });

    $('body').on('click','.publicar_evaluacion_publicacion_ctn',function(e){
        e.isDefaultPrevented();
        Comun.mostrar_modal_confirmacion($(this));
    });

    $('body').on('click','.ver_resultados_evaluacion',function(e){
        e.preventDefault();
        EvaluacionPublicacionCTN.ver_resultados_evaluacion_alumno($(this));
    });

    $(document).on('click','.btn_ver_evaluacion_lectura',function(e){
        e.preventDefault();
        var id_evaluacion_alumno_publicacion_ctn = $(this).data('id_evaluacion_alumno_publicacion_ctn');
        EvaluacionPublicacionCTN.ver_evaluacion_lectura(id_evaluacion_alumno_publicacion_ctn)
    });

    $(document).on('click','#btn_cerrar_evaluacion_lectura',function(e){
        e.preventDefault();
        $('#contenedor_resultado_evaluacion_lectura').fadeOut();
        setTimeout(function (){$('#contenedor_resultado_evaluacion_lectura').html('')},500);
    });

    /**
     * inicializar las variables para el JS
     */
    EvaluacionPublicacionCTN.trigger_buscar_preguntas_evaluacion();

});

var EvaluacionPublicacionCTN = {

    trigger_buscar_preguntas_evaluacion : function (){
        $('#btn_buscar_preguntas_evaluacion').trigger('click');
    },

    obtener_registro_alumnos_publicacion_instructor :  function (btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        Comun.obtener_contenido_peticion_html(
            base_url + 'Instructores/registro_alumnos_publicacion_ctn/' + id_publicacion_ctn,{},
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

    obtener_modal_agregar_modificar_pregunta : function(btn){
        var id_evaluacion_publicacion_ctn = btn.data('id_evaluacion_publicacion_ctn');
        var id_pregunta_publicacion_ctn = '';
        if(btn.data('id_pregunta_publicacion_ctn') != undefined && btn.data('id_pregunta_publicacion_ctn') != ''){
            id_pregunta_publicacion_ctn = '/' + btn.data('id_pregunta_publicacion_ctn');
        }
        Comun.obtener_contenido_peticion_html(
            base_url + 'Instructores/agregar_modificar_pregunta_evaluacion/' + id_evaluacion_publicacion_ctn + id_pregunta_publicacion_ctn,{},
            function(response){
                $('#container_agregar_modificar_pregunta').html(response);
                Comun.mostrar_modal_bootstrap('modal_registrar_modificar_pregunta_evaluacion',true);
                Comun.funcion_fileinput('Subir Imagen');
                EvaluacionPublicacionCTN.iniciar_carga_archivos_img_respuestas_evaluacion();
            }
        );
    },

    obtener_complemento_registro_opciones_pregunta : function(slt){
        $('#destino_registro_opciones_pregunta_complemento').html(loader_gif);
        var id_opciones_pregunta = slt.val();
        if(id_opciones_pregunta != ''){
            var id_pregunta_publicacion_ctn = slt.data('id_pregunta_publicacion_ctn');
            if(id_pregunta_publicacion_ctn != undefined && id_pregunta_publicacion_ctn != ''){
                id_pregunta_publicacion_ctn = '/' + id_pregunta_publicacion_ctn;
            }
            Comun.obtener_contenido_peticion_html(
                base_url + 'Instructores/obtener_complemento_registro_opciones_pregunta/' + id_opciones_pregunta + id_pregunta_publicacion_ctn,{},
                function(response){
                    $('#destino_registro_opciones_pregunta_complemento').html(response);
                    Comun.funcion_fileinput('Imagen');
                    Comun.mostrar_modal_bootstrap('modal_registrar_modificar_pregunta_evaluacion',true);
                }
            );
        }else{
            $('#destino_registro_opciones_pregunta_complemento').html('<span class="badge badge-danger">Seleccione un tipo de pregunta</span>');
        }
    },

    reglas_validate_pregunta_opciones : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    actualizar_secuenciales_preguntas_relaciones : function(){
        var consecutivo = 1;
        $('#tbody_respuesta_pregunta_secuenciales tr').each(function(){
            var row = $(this);
            row.find('input.consecutivo_derecho').val(consecutivo);
            row.find('span.consecutivo_derecho').html(consecutivo);
            consecutivo++;
        });
    },

    validar_form_registro_pregunta_opciones : function (){
        $('.error').remove();
        var form_valido = Comun.validar('#form_guardar_pregunta_evaluacion_ctn',EvaluacionPublicacionCTN.reglas_validate_pregunta_opciones());
        if(form_valido){
            //apartado de validaciones secundarias a las validaciones general
            var slt_opcion_pregunta_form_val = $('#slt_opcion_pregunta_form').val();
            if(slt_opcion_pregunta_form_val == 1){
                var count_respuestas_incorrectas = $('#form_guardar_pregunta_evaluacion_ctn').find('input.radio_verdadero_incorrecta:checked').length;
                if(count_respuestas_incorrectas != 1){
                    form_valido = false;
                    var msg_error = 'Solo es posible tener una respuesta correcta y una incorrecta';
                    Comun.mensaje_operacion('error',msg_error,'#form_guardar_pregunta_evaluacion_ctn_msg');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">'+msg_error+'</span>');
                }
            }if(slt_opcion_pregunta_form_val == 2 || slt_opcion_pregunta_form_val == 4){
                var count_respuestas_correctas = $('#form_guardar_pregunta_evaluacion_ctn').find('input.radio_verdadero_correcta:checked').length;
                if(count_respuestas_correctas != 1){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Solo es posible tener una respuesta correcta','#form_guardar_pregunta_evaluacion_ctn_msg');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">Solo es posible tener una respuesta correcta</span>');
                }
            }if(slt_opcion_pregunta_form_val == 3 || slt_opcion_pregunta_form_val == 5){
                var count_respuestas_correctas = $('#form_guardar_pregunta_evaluacion_ctn').find('input.radio_verdadero_correcta:checked').length;
                var count_respuestas_incorrectas = $('#form_guardar_pregunta_evaluacion_ctn').find('input.radio_verdadero_incorrecta:checked').length;
                if(count_respuestas_correctas < 2){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Debe registrar por lo menos dos respuestas como correctas','#form_guardar_pregunta_evaluacion_ctn_msg');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">Debe registrar por lo menos dos respuestas como correctas</span>');
                }if(count_respuestas_incorrectas < 1){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Debe registrar por lo menos una respuesta como incorrecta','#form_guardar_pregunta_evaluacion_ctn_msg');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">Debe registrar por lo menos una respuesta como incorrecta</span>');
                }
            }if(slt_opcion_pregunta_form_val == 4 || slt_opcion_pregunta_form_val == 5){
                var num_rows_preguntas = $('#form_guardar_pregunta_evaluacion_ctn').find('#tbody_respuesta_pregunta_up tr').length;
                var num_imegenes_pregunta = $('#form_guardar_pregunta_evaluacion_ctn').find('.img_pregunta_evaluacion_ctn').length;
                if(num_rows_preguntas != num_imegenes_pregunta){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Debe registrar la imagen en cada una de las respuestas');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">Debe registrar la imagen en cada una de las respuestas</span>');
                }
            }if(slt_opcion_pregunta_form_val == 6 || slt_opcion_pregunta_form_val == 7){
                var row_preguntas = $('#form_guardar_pregunta_evaluacion_ctn').find('#tbody_respuesta_pregunta_secuenciales tr');
                if(row_preguntas.length == 0){
                    form_valido = false;
                    Comun.mensaje_operacion('error','Debe registrar por lo menos una respuesta');
                    $('#contenedor_mensajes_validacion_footer_modal').append('<span class="error requerido">Debe registrar por lo menos una respuesta</span>');
                }else{
                    var array_consecutivo = new Array();
                    var contador_consecutivos = [];
                    row_preguntas.each(function () {
                        var consecutivo = parseInt($(this).find('.consecutivo').val());
                        contador_consecutivos[consecutivo] = 0;
                        array_consecutivo.push(consecutivo);
                    });
                    //buscar algun consecutivo mayor al numero de respuestas
                    var consecutivo_mayor = array_consecutivo.filter(v => v > row_preguntas.length);
                    if(consecutivo_mayor.length != 0){
                        form_valido = false;
                        Comun.mensaje_operacion('error','Existe un orden de la opción mayor al número de respuestas');
                    }else{
                        row_preguntas.each(function () {
                            var consecutivo = parseInt($(this).find('.consecutivo').val());
                            contador_consecutivos[consecutivo]++;
                        });
                        contador_consecutivos.forEach(function (value,index) {
                            if(value > 1){
                                form_valido = false;
                                Comun.mensaje_operacion('error','El orden de la opción "'+index+'" se repite, favor de verificar');
                            }
                        })
                    }
                }
            }
            return form_valido;
        }
        return form_valido;
    },

    guardar_pregunta_opciones : function (funcion) {
        Comun.enviar_formulario_post('form_guardar_pregunta_evaluacion_ctn', base_url + 'Instructores/guardar_pregunta_opciones_evaluacion_ctn', funcion);
    },

    iniciar_carga_archivos_img_respuestas_evaluacion : function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var destino_img = '';
        var identificador_row = '';
        var posicion_img = '';
        $('.fileUploadImgPreguntaEvaluacion').fileupload({
            url : base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function (e,data) {
                $('#div_conteiner_file_banner_proxico_curso').html(loader_gif_transparente);
            }, //tiempo de ejecucion
            add: function (e,data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
                data.formData = {
                    filename : nombre_archivo
                };
                destino_img = data.fileInput.data('destino_img');
                identificador_row = data.fileInput.data('identificador_row');
                posicion_img = data.fileInput.data('posicion_img') != undefined && data.fileInput.data('posicion_img') != '' ? data.fileInput.data('posicion_img')  : '';
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if(!regExp.test(uploadFile.name.toLowerCase())){
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error','Archivo no es una imágen admitida','#form_mensajes_curso_publicacion',8000);
                    goUpload = false;
                }if(uploadFile.size > 15000000){
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error','El archivo es mayor a 5 Mb','#form_mensajes_curso_publicacion',8000);
                    goUpload = false;
                }if(goUpload){
                    $(destino_img).html(loader_gif_transparente);
                    data.submit();
                }
            },
            done:function (e,data) {
                if(data.result.exito){
                    //construir el html de la respuesta de cuando suba el archivo de imagen al sistema y en BD
                    html_respuesta = '' +
                        '<div>' +
                            '<input type="hidden" class="img_pregunta_evaluacion_ctn" name="opcion_pregunta_publicacion_ctn'+posicion_img+'['+identificador_row+'][id_documento]" value="'+data.result.documento.id_documento+'">' +
                            '<img class="img-thumbnail" style="width: 75px !important;" src="'+data.result.documento.ruta_documento+'" alt="'+data.result.documento.nombre+'">' +
                        '</div>';
                    $(destino_img).html(html_respuesta);
                }else{
                    Comun.mensaje_operacion('error',data.result.msg,'#form_mensajes_curso_registro');
                }
            },
            error:function (xhr, ajaxOptions, thrownError){
                Comun.mensaje_operacion('error','Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','#form_mensajes_curso_registro',8000);
            }
        });
    },

    ver_resultados_evaluacion_alumno : function(btn){
        var id_publicacion_ctn = btn.data('id_publicacion_ctn');
        var id_alumno = btn.data('id_alumno');
        Comun.obtener_contenido_peticion_html(
            base_url + 'Instructores/resultados_evaluacion/' + id_publicacion_ctn + '/' + id_alumno,{},
            function(response){
                $('#contenedor_resultados_evaluacion').html(response);
                Comun.mostrar_modal_bootstrap('modal_resultados_evaluacion',true);
            }
        );
    },

    ver_evaluacion_lectura : function(id_evaluacion_alumno_publicacion_ctn){
        $('#contenedor_resultado_evaluacion_lectura').html(loader_gif_transparente);
        Comun.obtener_contenido_peticion_html(
            base_url + 'Instructores/examen_lectura/' + id_evaluacion_alumno_publicacion_ctn,{},
            function(response){
                $('#contenedor_resultado_evaluacion_lectura').html(response);
                $('#contenedor_resultado_evaluacion_lectura').fadeIn();
            }
        );
    },

}