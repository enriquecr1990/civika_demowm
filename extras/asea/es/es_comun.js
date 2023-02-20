$(document).ready(function () {

    $('body').on('click','.consultar_evaluaciones_empleado',function () {
        var id_empleado_es = $(this).data('id_empleado_es');
        EstacionServicio.obtener_evaluaciones_empleado(id_empleado_es);
    });

    ASEA.funcion_tooltip();

});

var EstacionServicio = {

    obtener_evaluaciones_empleado : function(idEmpleadoES){
        ASEA.obtener_contenido_peticion_html(
            base_url + 'EstacionServicio/consultarEvaluacionesEmpleado/'+idEmpleadoES,{},
            function (response) {
                $('#conteiner_evaluaciones_empleado').html(response);
                ASEA.mostrar_modal_bootstrap('modal_consultar_evaluaciones_empleado',true);
                ASEA.funcion_tooltip();
            }
        );
    }

}
