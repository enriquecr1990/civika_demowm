$(document).ready(function(){

	$(document).on('click','.lnk_notificaciones_recibidas',function () {
		Notificaciones.resultados({tipo:'recibidas'});
	});

	$(document).on('click','.lnk_notificaciones_enviadas',function () {
		Notificaciones.resultados({tipo:'enviadas'});
	});

	$(document).on('click','.lnk_notificaciones_borrador',function () {
		Notificaciones.resultados({tipo:'borrador'});
	});

	$(document).on('click','.lnk_notificaciones_eliminadas',function () {
		Notificaciones.resultados({tipo:'eliminadas'});
	});

	$(document).on('click','#nueva_notificacion',function(){
		$('.regresar_notificaciones').show();
		$('#nueva_notificacion').hide();
		Notificaciones.formulario_notificacion();
	});

	$(document).on('click','.ver_notificacion',function(){
		var id_notificacion = $(this).data('id_notificacion');
		Notificaciones.lectura_notificacion(id_notificacion);
	});

	$(document).on('click','.regresar_notificaciones',function(){
		$('.regresar_notificaciones').hide();
		$('#nueva_notificacion').show();
		Notificaciones.resultados({tipo:Notificaciones.tipo_activo});
	});

	$(document).on('click','.guardar_notificacion',function(){
		var tipo_notificacion = $(this).data('tipo_notificacion');
		var id_notificacion = $(this).data('id_notificacion');
		Notificaciones.guardar_form_notificacion(id_notificacion,tipo_notificacion);
	});

	$(document).on('click','.quitar_archivo_adjunto_notificacion',function(){
		var id_archivo = $(this).data('id_archivo');
		$('#contendor_archivo_adjunto_'+id_archivo).remove();
	});

	$('.lnk_notificaciones_recibidas').trigger('click');
	//Notificaciones.resultados({tipo:'recibidas'});

});

var Notificaciones = {

	tipo_activo : 'recibidas',

	resultados : function(parametros = {}){
		$('.regresar_notificaciones').hide();
		$('#nueva_notificacion').show();
		Notificaciones.obtener_resultados(parametros);
		Notificaciones.tipo_activo = parametros.tipo;
	},

	obtener_resultados : function(parametros = {}){
		$('#contenedor_operaciones_notificaciones').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Notificaciones/resultados',parametros,
			function(response){
				$('#contenedor_operaciones_notificaciones').html(response);
				$('#titulo_mensajes_carpeta').html(parametros.tipo.toUpperCase());
				$('#notificaciones_no_leidas_tablero').html($('#inp_notificaciones_no_leidas').val());
				var num_no_leidas = parseInt($('#notificaciones_no_leidas_tablero').html());
				num_no_leidas == 0 ? num_no_leidas = '' : false;
				$('#notificaciones_no_leidas_tablero').html(num_no_leidas);
				$('span.numero_notificaciones').html(num_no_leidas);
			},
		);
	},

	formulario_notificacion : function(){
		$('#contenedor_operaciones_notificaciones').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Notificaciones/formulario' ,{},
			function(response){
				$('#contenedor_operaciones_notificaciones').html(response);
				Comun.iniciar_select2();
				Comun.funcion_fileinput('.archivo_adjunto_notificacion','Archivos adjuntos');
				Notificaciones.iniciar_editor_summernote();
				Notificaciones.iniciar_carga_adjuntos_notificacion('#procesando_adjuntos_notificacion')
			},
		);
	},

	lectura_notificacion : function(id_notificacion){
		$('#contenedor_operaciones_notificaciones').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Notificaciones/lectura/' + id_notificacion ,{},
			function(response){
				$('#contenedor_operaciones_notificaciones').html(response);
				var num_no_leidas = parseInt($('#notificaciones_no_leidas_tablero').html()) - 1;
				num_no_leidas == 0 ? num_no_leidas = '' : false;
				$('#notificaciones_no_leidas_tablero').html(num_no_leidas);
				$('span.numero_notificaciones').html(num_no_leidas);
			},
		);
	},

	iniciar_editor_summernote : function(){
		$('#textarea_notificacion').summernote({
			minHeight : 300,
			lang : 'es-ES',
			placeholder : 'Escribe el mensaje para la notificación',
			codeviewFilter: false,
			codeviewIframeFilter: true,
			toolbar : [
				['style', ['bold', 'italic', 'underline']],
				['font',['fontname','fontsize','forecolor']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture', 'video']],
				['view', [ 'help']],
			]
		});
	},

	iniciar_carga_adjuntos_notificacion : function (div_procesando) {
		Comun.iniciar_carga_imagen('.archivo_adjunto_notificacion',div_procesando,function(archivo){
			//se agrega el html correspondiente para los archivos adjuntos
			var num_archivos_adjuntos = $('.archivo_adjunto_agregado').length + 1;
			var html_adjunto = '<div class="row" id="contendor_archivo_adjunto_'+archivo.id_archivo+'">' +
				'<input type="hidden" name="archivos['+num_archivos_adjuntos+']" class="archivo_adjunto_agregado" value="'+archivo.id_archivo+'">' +
				'<li>' +
				'	<a href="'+base_url+archivo.ruta_directorio+archivo.nombre+'" target="_blank">'+archivo.nombre+'</a> &nbsp;' +
				'	<button type="button" class="btn btn-danger btn-sm quitar_archivo_adjunto_notificacion" data-id_archivo="'+archivo.id_archivo+'"><i class="fa fa-trash"></i></button>' +
				'</li>' +
				'</div>';
			$('#contenedor_archivos_notificacion').append(html_adjunto);
			$(div_procesando).html('');
		});
	},

	guardar_form_notificacion : function(id_notificacion = 0,tipo = 'borrador'){
		if(Notificaciones.validar_form_notificacion(id_notificacion)){
			Comun.enviar_formulario_post(
				'#form_notificacion',
				base_url + 'Notificaciones/guardar_notificacion/' + id_notificacion + '/' + tipo,
				function(response){
					if(response.success){
						$('.lnk_notificaciones_recibidas').trigger('click');
						Notificaciones.enviar_notificacion_correo(response.data.id_notificacion,true);
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos en la notificacion','error');
		}
	},

	validar_form_notificacion : function (id_notificacion) {
		var validar = Comun.validar_form('#form_notificacion',Comun.reglas_validacion_form());
		return validar;
	},

	enviar_notificacion_correo : function(id_notificacion,mostrar_msg_sistema = false){
		Comun.obtener_contenido_peticion_json(
			base_url + 'Notificaciones/enviar_correo/'+id_notificacion,{},
			function(response){
				console.log(response);
				if(response.success){
					mostrar_msg_sistema ? Comun.mensajes_operacion(response.msg) : false;
				}
			}
		);
	}

};
