$(document).ready(function () {
    //funciones de busqueda/consulta de informacion
    $('body').on('click','.buscar_normas_asea',function () {
        NormasASEA.buscar_normas_asea();
    });

    $('body').on('click','.buscar_preguntas_respuestas_norma',function(){
        var id_norma = $(this).data('id_norma');
        NormasASEA.buscar_preguntas_respuestas_norma(id_norma);
    });

    $('body').on('click','.consultar_norma_asea, .consultar_norma_asea_actividades',function () {
        NormasASEA.consultar_norma_actividad($(this));
    });

    $('body').on('click','.consultar_actividades_norma',function () {
        NormasASEA.consultar_actividades_norma($(this).data('id_norma'));
    });

    //funciones de agregar/modificar informacion informacion
    $('body').on('click','.agregar_norma_asea',function () {
        NormasASEA.agregar_modificar_norma_asea();
    });

    $('body').on('click','.agregar_actividad_norma',function () {
        var html_actividad = NormasASEA.obtener_html_actividad_norma();
        $('.tbodyActividadesNorma').append(html_actividad);
        if($('.tbodyActividadesNorma tr').length == 1){
            $('.eliminar_row_tabla').remove();
        }
        ASEA.funcion_tooltip();
    });

    $('body').on('click','.agregar_pregunta_repuesta_norma',function(){
        var id_normas_asea = $(this).data('id_normas_asea');
        NormasASEA.agregar_modificar_preguntas_norma_asea(id_normas_asea);
    });

    $('body').on('click','.buscar_video_actividad_norma', function () {
        var destino_video = $(this).data('destino_video');
        NormasASEA.buscar_video_actividad_norma(destino_video);
    });

    $('body').on('click','.modificar_norma_asea',function () {
        var id_norma = $(this).data('id_norma');
        NormasASEA.agregar_modificar_norma_asea(id_norma);
    });

    $('body').on('click','.modificar_pregunta_repuesta_norma',function(){
        var id_normas_asea = $(this).data('id_normas_asea');
        var id_preguntas_norma_asea = $(this).data('id_preguntas_norma_asea');
        NormasASEA.agregar_modificar_preguntas_norma_asea(id_normas_asea,id_preguntas_norma_asea);
    });

    //funciones de guardar informacion
    $('body').on('click','.guardar_norma_asea',function () {
        var boton = $(this);
        boton.attr('disabled',true);
        boton.html('Procesando...');
        var html_respuesta = '';
        var validar_norma = NormasASEA.validar_norma();
        if(validar_norma){
            NormasASEA.guardar_norma_asea(
                function (response) {
                    if(response.exito){
                        ASEA.mensaje_operacion('info',response.msg);
                        ASEA.mostrar_modal_bootstrap('modal_registrar_modificar_norma',false);
                        NormasASEA.boton_buscar_normas();
                    }else{
                        ASEA.mensaje_operacion('warning',response.msg,'#guardar_form_busqueda_normas_asea_modal');
                        boton.removeAttr('disabled');
                        boton.html('Aceptar');
                    }
                }
            );
        }else{
            boton.removeAttr('disabled');
            boton.html('Guardar')
        }
    });

    $('body').on('click','.guardar_activiades_norma',function () {
        $('.error_validaciones').remove();
        $(this).attr('disabled',true);
        $(this).html('Procesando...');
        var html_respuesta = '';
        var validar_actividad = NormasASEA.validar_actividad_norma();
        if(validar_actividad){
            NormasASEA.guardar_actividad_norma(
                function (response) {
                    if(response.exito){
                        ASEA.mensaje_operacion('info',response.msg);
                        ASEA.mostrar_modal_bootstrap('modal_consultar_norma_asea_actividad',false);
                        NormasASEA.boton_buscar_normas();
                    }else{
                        ASEA.mensaje_operacion('warning',response.msg,'#guardar_form_busqueda_normas_asea_modal');
                    }
                    $(this).removeAttr('disabled');
                    $(this).html('Aceptar');
                }
            );
        }else{
            $(this).removeAttr('disabled');
            $(this).html('Guardar')
        }
    });

    $('body').on('click','.guardar_preguntas_respuestas_norma',function(){
        var boton = $(this);
        boton.attr('disabled',true);
        boton.html('Procesando...');
        $('.error_validaciones').remove();
        var html_respuesta = '';
        var validar_form = NormasASEA.validar_pregunta_respuestas_norma();
        if(validar_form){
            NormasASEA.guardar_pregunta_respuesta_norma(
                function (response) {
                    if(response.exito){
                        ASEA.mensaje_operacion('info',response.msg);
                        ASEA.mostrar_modal_bootstrap('modal_registro_pregunta_norma_asea',false);
                        $('.buscar_preguntas_respuestas_norma').trigger('click');
                    }else{
                        ASEA.mensaje_operacion('info',response.msg,'#conteiner_mensaje_registro_pregunta_norma');
                    }
                    boton.removeAttr('disabled');
                    boton.html('Aceptar');
                }
            );
        }else{
            boton.removeAttr('disabled');
            boton.html('Guardar')
        }
    });

    //funciones de eliminar informacion
    $('body').on('click','.eliminar_norma_asea',function () {
        var url = $(this).data('url');
        var msg_elimiar = 'Se eliminara la norma de forma permante del sistema, ¿Desea continuar?';
        var btn_trigger = $(this).data('btn_trigger');
        ASEA.mostrar_modal_confirmacion(url,msg_elimiar,btn_trigger);
    });

    $('body').on('click','.elminar_pregunta_norma_asea',function () {
        var url = $(this).data('url');
        var msg_elimiar = 'Se eliminara la pregunta de forma permante del sistema, ¿Desea continuar?';
        var btn_trigger = $(this).data('btn_trigger');
        ASEA.mostrar_modal_confirmacion(url,msg_elimiar,btn_trigger);
    });

    $('body').on('change','.select_tipo_pregunta',function(){
        var idTipoPregunta = $(this).val();
        NormasASEA.cargar_respuesta_tipo_pregunta(idTipoPregunta);
    });

    $('body').on('click','.seleccionar_archivo_video',function(){
        var destino_video = $(this).data('destino_video');
        var url_video = $(this).data('url_video');
        var nombre_video = $(this).data('nombre_video');
        $(destino_video).find('input#url_video').val(url_video);
        $(destino_video).find('input#nombre_video').val(nombre_video);
        $(destino_video).find('span#nombre_video').html(nombre_video);
        ASEA.mostrar_modal_bootstrap('modal_registrar_video_norma_actividad',false);
    });

    NormasASEA.boton_buscar_normas();
    NormasASEA.funciones_datepicker();
});

var NormasASEA = {

    buscar_normas_asea : function () {
        var id_formulario = 'form_busqueda_normas_asea';
        var container_resultados = '#contenedor_resultados_normas_aseas';
        var post_formulario = ASEA.obtener_post_formulario(id_formulario);
        $(container_resultados).html(loader_gif);
        ASEA.obtener_contenido_peticion_html(base_url + 'NormasAsea/buscarNormasAsea',post_formulario,
            function (response) {
                $(container_resultados).html(response);
                ASEA.funcion_tooltip();
            }
        );
    },

    buscar_preguntas_respuestas_norma : function (id_norma){
        var conteiner_resultados = '#conteiner_preguntas_respuestas_norma';
        $(conteiner_resultados).html(loader_gif);
        ASEA.obtener_contenido_peticion_html(
            base_url + 'NormasAsea/buscarPreguntasNorma/'+id_norma,{},
            function(response){
                $(conteiner_resultados).html(response);
                ASEA.funcion_tooltip();
                ASEA.mensaje_operacion('info','')
            }
        );
    },

    buscar_video_actividad_norma : function(destino_video){
        ASEA.obtener_contenido_peticion_html(
            base_url + 'NormasAsea/inicarNavegacionSeleccionarVideo',{destino_video:destino_video},
            function(response){
                $('#conteiner_busqueda_video_actividad').html(response);
                ASEA.mostrar_modal_bootstrap('modal_registrar_video_norma_actividad',true);
            }
        );
    },

    consultar_norma_actividad : function (boton) {
        var id_norma = boton.data('id_norma');
        var editar_norma = boton.data('editar_norma') == 1 ? true:false;
        ASEA.obtener_contenido_peticion_html(base_url + 'NormasAsea/consultarNormaAseaActividades/'+id_norma,{editar_norma:editar_norma},
            function (response) {
                $('#conteiner_consultar_norma_actividad').html(response);
                if($('.tbodyActividadesNorma tr').length == 0) $('.agregar_actividad_norma').trigger('click');
                ASEA.mostrar_modal_bootstrap('modal_consultar_norma_asea_actividad',true);
                ASEA.funcion_tooltip();
            }
        );
    },

    consultar_actividades_norma : function(id_norma_asea){
        ASEA.obtener_contenido_peticion_html(
            base_url + 'NormasAsea/consultarActividadesNorma/'+id_norma_asea,{},
            function (response) {
                $('#conteiner_consultar_norma_actividad').html(response);
                ASEA.mostrar_modal_bootstrap('modal_norma_actividades_asea',true);
            }
        );
    },

    cargar_respuesta_tipo_pregunta : function(idTipoPregunta){
        var conteiner_resultado = '#conteiner_tipo_pregunta_para_respuestas';
        $(conteiner_resultado).html(loader_gif);
        var count_respuestas = 0;
        if(idTipoPregunta != undefined && idTipoPregunta != ''){
            ASEA.obtener_contenido_peticion_html(
                base_url + 'NormasAsea/registrarRespuestasPreguntaNorma/'+idTipoPregunta,{},
                function (response) {
                    $(conteiner_resultado).html(response);
                    if(idTipoPregunta == 2){
                        count_respuestas = $('#tbodyRespuestaPreguntaUO').find('tr').length;
                        if(count_respuestas == 0){
                            $('#btnAgregarPreguntaUO').trigger('click')
                        }
                    }if(idTipoPregunta == 3){
                        count_respuestas = $('#tbodyRespuestaPreguntaOM').find('tr').length;
                        if(count_respuestas == 0){
                            $('#btnAgregarPreguntaOM').trigger('click')
                        }
                    }
                }
            );
        }else{
            var html_reponse = '<div class="col-sm-12">' +
                '<span class="label label-primary">Selecione un tipo de pregunta</span>' +
                '</div>';
            $(conteiner_resultado).html(html_reponse);
        }
    },

    agregar_modificar_norma_asea : function (id_norma) {
        var parametrosController = '';
        if(id_norma != undefined && id_norma != ''){
            parametrosController += '/'+id_norma;
        }
        ASEA.obtener_contenido_peticion_html(
            base_url + 'NormasAsea/agregarModificarNormaAsea'+parametrosController,{},
            function (response) {
                $('#conteiner_registrar_modificar_norma').html(response);
                ASEA.mostrar_modal_bootstrap('modal_registrar_modificar_norma',true);
                ASEA.funciones_datepicker();
            }
        );
    },

    agregar_modificar_preguntas_norma_asea : function (id_norma,id_preguntas_norma_asea) {
        var parametros_peticion = '';
        if(id_preguntas_norma_asea != undefined && id_preguntas_norma_asea != ''){
            parametros_peticion = '/'+id_preguntas_norma_asea;
        }
        ASEA.obtener_contenido_peticion_html(
            base_url + 'NormasAsea/agregarModificarPreguntaNorma'+parametros_peticion,{id_normas_asea : id_norma},
            function (response) {
                $('#conteiner_registro_preguntas_respuestas_norma_asea').html(response);
                ASEA.mostrar_modal_bootstrap('modal_registro_pregunta_norma_asea',true);
                ASEA.funcion_tooltip();
            }
        );
    },

    validar_norma : function () {
        var form_valido = ASEA.validar('#form_guardar_norma_asea',{});
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            return form_valido;
        }
        return form_valido;
    },

    validar_actividad_norma : function () {
        var form_valido = ASEA.validar('#form_actividades_norma',{});
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            var numero_actividades = $('.tbodyActividadesNorma tr').length;
            if(numero_actividades == 0){
                form_valido = false;
                var msg_validacion = '<div class="col-sm-12">' +
                    '<div class="alert alert-warning error_validaciones">' +
                        '<span class="glyphicon glyphicon-warning-sign">Es necesario que agregue una actividad</span>' +
                    '</div>' +
                '</div>'
                $('.tbodyActividadesNorma').closest('div').append(msg_validacion);
            }
            return form_valido;
        }
        return form_valido;
    },

    validar_pregunta_respuestas_norma : function () {
        var form_valido = ASEA.validar('#form_registro_pregunta_norma',{});
        if(form_valido){
            //apartado de validaciones secundarias a la validaciones general
            var id_opcion_tipo_pregunta = $('.select_tipo_pregunta').val();
            if(id_opcion_tipo_pregunta == 1){
                var tbodyResVF =  $('#tbodyRespuestaPreguntaVF');
                var count_checked_correctas = tbodyResVF.find('input[value="correcta"]:checked').length;
                if(count_checked_correctas != 1){
                    form_valido =false;
                    $('.error_validaciones_pregunta_vf').html('<label class="error">Es necesario registrar una respuesta correcta</label>');
                }
            }
            if(id_opcion_tipo_pregunta == 2){
                var tbodyResUO =  $('#tbodyRespuestaPreguntaUO');
                var count_respuestas_uo = tbodyResUO.find('tr').length;
                if(count_respuestas_uo < 2){
                    form_valido = false;
                    $('.error_validaciones_pregunta_uo').html('<label class="error">Es necesario que registre como minimo 3 respuestas</label>');
                }else{
                    var count_checked_correctas = tbodyResUO.find('input[value="correcta"]:checked').length;
                    if(count_checked_correctas != 1){
                        form_valido =false;
                        $('.error_validaciones_pregunta_uo').html('<label class="error">Es necesario registrar unicamente una respuesta como correcta</label>');
                    }
                }
            }if(id_opcion_tipo_pregunta == 3){
                var tbodyResOM =  $('#tbodyRespuestaPreguntaOM');
                var count_respuestas_om = tbodyResOM.find('tr').length;
                if(count_respuestas_om < 2){
                    form_valido = false;
                    $('.error_validaciones_pregunta_om').html('<label class="error">Es necesario que registre como minimo tres respuestas</label>');
                }else{
                    var count_checked_incorrectas = tbodyResOM.find('input[value="incorrecta"]:checked').length;
                    var count_checked_correctas = tbodyResOM.find('input[value="correcta"]:checked').length;
                    if(count_checked_incorrectas == 0 || count_respuestas_om == count_checked_incorrectas){
                        form_valido =false;
                        $('.error_validaciones_pregunta_om').html('<label class="error">No es posible guardar todas las respuestas como incorrectas</label>');
                    }else{
                        if(count_respuestas_om == count_checked_correctas){
                            form_valido =false;
                            $('.error_validaciones_pregunta_om').html('<label class="error">No es posible guardar todas las respuestas como correctas</label>');
                        }if(count_checked_correctas == 1){
                            form_valido = false;
                            $('.error_validaciones_pregunta_om').html('<label class="error">No es posible guardar una respuesta como correcta</label>');
                        }
                    }
                }
            }
        }
        return form_valido;
    },

    guardar_norma_asea :  function (funcion) {
        ASEA.enviar_formulario_post('form_guardar_norma_asea', base_url + 'NormasAsea/guardarNormaAsea', funcion);
    },

    guardar_actividad_norma : function (funcion) {
        ASEA.enviar_formulario_post('form_actividades_norma', base_url + 'NormasAsea/guardarActividadesNorma', funcion);
    },

    guardar_pregunta_respuesta_norma : function (funcion) {
        ASEA.enviar_formulario_post('form_registro_pregunta_norma', base_url + 'NormasAsea/guardarPreguntaRespuestasNorma', funcion);
    },

    boton_buscar_normas : function () {
        $('.buscar_normas_asea').trigger('click');
        $('.buscar_preguntas_respuestas_norma').trigger('click');
    },

    obtener_html_actividad_norma : function () {
        var id_random = Math.floor(Math.random() * 10000000001);
        var html_actividad = '' +
        '<tr id="actividad_norma_'+id_random+'"> ' +
            '<td> ' +
                '<input class="form-control" placeholder="Describa la actividad" data-rule-required="true"' +
                    'name="actividad_normas_asea['+id_random+'][descripcion]">' +
            '</td> ' +
            '<td> ' +
                '<input class="form-control" placeholder="Describa el objetivo" data-rule-required="true"' +
                    'name="actividad_normas_asea['+id_random+'][objetivo]">' +
            '</td> ' +
            '<td> ' +
                '<input class="form-control" placeholder="Tiempo (Minutos)" data-rule-required="true" data-rule-number="true" ' +
                    'name="actividad_normas_asea['+id_random+'][tiempo]">' +
            '</td> ' +
            '<td> ' +
                '<input type="hidden" placeholder="Describa el objetivo de la norma" data-rule-required="true" id="url_video_'+id_random+'"' +
                    'name="actividad_normas_asea['+id_random+'][url_video]" value=""> ' +
                '<input type="hidden" placeholder="Describa el objetivo de la norma" data-rule-required="true"' +
                    'name="actividad_normas_asea['+id_random+'][nombre_video]" value=""> ' +
                '<button type="button" class="btn btn-primary btn-xs buscar_video_actividad_norma" data-toggle="tooltip" data-placement="bottom" ' +
                        'title="Seleccionar video" data-destino_video="#actividad_norma_'+id_random+'"> ' +
                    '<i class="glyphicon glyphicon-film"></i> ' +
                '</button> ' +
                '<span class="label label-info nombre_video_actividad"></span> ' +
            '</td>' +
            '<td> ' +
                '<button type="button" class="btn btn-danger btn-xs eliminar_row_tabla" data-toggle="tooltip"' +
                    'data-placement="bottom" title="Eliminar actividad norma" > ' +
                        '<span class="glyphicon glyphicon-trash"></span> ' +
                '</button> ' +
            '</td> ' +
        '</tr>';
        return html_actividad;
    },

    funciones_datepicker : function () {
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true
        });
    },

}
