$(document).ready(function(){

    $('body').on('click','.btn_enviar_examen',function(e){
        e.preventDefault();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        $('.btn_enviar_examen_tiempo').remove();
        if(ExamenAlumno.validar_form_examen_alumno()){
            ExamenAlumno.guardar_examen_alumno(
                function(response){
                    if(response.exito){
                        Comun.mensaje_operacion_modal_sin_cerrar('success',response.msg,'');
                        $('.btn_enviar_examen').remove();
                        $('.btn_enviar_examen_tiempo').remove();
                        var redirec = '/mis_cursos';
                        if(response.redirec != undefined && response.redirec != ''){
                            redirec = response.redirec;
                        }
                        Comun.recargar_pagina(base_url + 'Alumnos' + redirec,3000);
                    }else{
                        Comun.mensaje_operacion('error',response.msg);
                    }
                    Comun.btn_guardar_enable(btn,'Enviar examen');
                }
            );
        }else{
            Comun.btn_guardar_enable(btn,'Enviar examen');
        }
    });

    $('body').on('click','.btn_enviar_examen_tiempo',function(e){
        e.preventDefault();
        var btn = $(this);
        Comun.btn_guardar_disabled(btn);
        ExamenAlumno.guardar_examen_alumno(
            function(response){
                if(response.exito){
                    Comun.mensaje_operacion_modal_sin_cerrar('success',response.msg,'');
                    $('.btn_enviar_examen').remove();
                    $('.btn_enviar_examen_tiempo').remove();
                    Comun.recargar_pagina(base_url + 'Alumnos/mis_cursos',3000);
                }else{
                    Comun.mensaje_operacion('error',response.msg);
                }
                Comun.btn_guardar_enable(btn);
            }
        );
    });

    $(document).on("keydown", function(e) {
        //Comun.desabilitar_ctrl_r(e);
    });

    ExamenAlumno.iniciar_cuenta_atras();

});

var ExamenAlumno = {

    iniciar_cuenta_atras : function(){
        var tiempo = $('#tiempo_minutos').length;
        console.log(tiempo);
        if(tiempo > 0){
            var fecha_inicio = new Date();
            var minutos = parseInt($('#tiempo_minutos').val());
            var milisegundo = minutos * 60000;
            var limite_envio = new Date(fecha_inicio.getTime() + milisegundo);
            console.log(limite_envio);
            ExamenAlumno.evento_transcurrido_tiempo(milisegundo);
            $('#reloj_contador').countdown(limite_envio,function(event){
                var reloj = '<i class="fa fa-clock-o"></i> <span id="horas">%H</span>:<span id="minutos">%M</span>:<span id="segundos">%S</span>';
                $(this).html(event.strftime(reloj));
            });
        }
    },

    evento_transcurrido_tiempo : function (tiempo){
        setTimeout(function () {
            $('#reloj_contador').fadeOut();
            $('.btn_enviar_examen_tiempo').trigger('click');
        },tiempo);
    },

    reglas_validate : function (){
        var rules_extras = {};
        var rules_comun = Comun.reglas_validate();
        return Comun.assing_array(rules_comun,rules_extras);
    },

    validar_form_examen_alumno :function (){
        $('.error').remove();
        var form_valido = Comun.validar('#form_evaluacion_examen',ExamenAlumno.reglas_validate());
        if(form_valido){

        }
        return form_valido;
    },

    guardar_examen_alumno : function (funcion) {
        Comun.enviar_formulario_post('form_evaluacion_examen', base_url + 'Alumnos/guardar_examen_alumno', funcion);
    },

}

/**
 * codigo para desabilitar el F5 del teclado
 */
function checkKeyCode(evt)
{

    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if(event.keyCode==116)
    {
        evt.keyCode=0;
        return false
    }
}

//document.onkeydown=checkKeyCode;