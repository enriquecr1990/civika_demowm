$(document).ready(function(){

	$(document).on('click','.leer_notificacion_menu',function(){
		var id_notificacion = $(this).data('id_notificacion');
		Bells.mostrar_notificacion_menu_modal(id_notificacion);
	});

	Bells.obtener_notificacion_no_leidas();

});

var Bells = {

	obtener_notificacion_no_leidas : function(){
		Comun.obtener_contenido_peticion_json(
			base_url + 'Notificaciones/notificaciones_no_leidas',{},
			function(response){
				if(response.success){
					var html_numero_notificaciones = response.total_registros != 0 ? response.total_registros : '';
					$('.numero_notificaciones').html(html_numero_notificaciones);
					var limite_notificaciones = response.total_registros > 3 ? 3 : response.total_registros;
					var html_mensajes = '';
					for(var i = 0; i < limite_notificaciones; i++){
						html_mensajes += Bells.obtener_notificacion_bells(response.notificacion[i]);
					}
					$('#contenedor_notificaciones_no_leidas_menu').html(html_mensajes);
				}
			}
		);
	},

	obtener_notificacion_bells : function(notificacion){
		var fecha_enviado = new Date(notificacion.fecha);
		var html = '<a href="#" id="notificacion_no_leida_menu_'+notificacion.id_notificacion+'" class="dropdown-item leer_notificacion_menu" data-id_notificacion="'+notificacion.id_notificacion+'">' +
			'<i class="fas fa-envelope mr-2"></i> ' + notificacion.asunto.substring(0,20) + ' ...' +
			'<span class="float-right text-muted text-sm">'+fecha_enviado.toLocaleDateString()+'</span>'+
			'</a>';
		return html;
	},

	mostrar_notificacion_menu_modal : function(id_notificacion){
		Comun.obtener_contenido_peticion_html(
			base_url + 'Notificaciones/lectura/' + id_notificacion ,{},
			function(response){
				$('#modal_body_visor_imagen').html(response);
				Comun.mostrar_ocultar_modal('#modal_visor_imagen',true);
				$('#notificacion_no_leida_menu_'+id_notificacion).remove();
				var num_notificaciones = parseInt($('.numero_notificaciones').html()) - 1; 
				num_notificaciones == 0 ? $('.numero_notificaciones').html('') : $('.numero_notificaciones').html(num_notificaciones)
				$('.regresar_notificaciones').remove();
				$('#modal_visor_imagen').find('div.modal-dialog').addClass('modal-lg');
			},
		);
	}

};
