$(document).ready(function (){
	$(document).on('click','.eliminar-archivo-alumno',function(){
		var id_archivo_instrumento = $(this).data('id_archivo_instrumento');
		var id_entregable_alumno_archivo = $(this).data('id_archivo_instrumento');
		var id_entregable = $(this).data('id_entregable');
		methods.eliminarArchivo(id_archivo_instrumento,id_entregable_alumno_archivo,id_entregable)
	})

});

var methods = {

}
