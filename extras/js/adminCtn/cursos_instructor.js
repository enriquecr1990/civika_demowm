$(document).ready(function(){

    $('body').on('click','.registro_alumnos_publiacion_ctn_instructor',function(e){
        e.preventDefault();
        CursosInstructor.obtener_registro_alumnos_publicacion_instructor($(this));
    });

});

var CursosInstructor = {

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

}