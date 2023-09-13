$(document).ready(function (){

	$(document).on('click','#agregar_configuracion_correo',function(){
		SalidaCorreo.agregar_modificar_config_correo();
	});

	$(document).on('click','.modificar_config_correo',function(){
		var id_config_correo = $(this).data('id_config_correo');
		SalidaCorreo.agregar_modificar_config_correo(id_config_correo)
	});

	$(document).on('click','#btn_guardar_form_config_correo',function(){
		var id_config_correo = $(this).data('id_config_correo');
		SalidaCorreo.guardar_config_correo(id_config_correo);
	});

	$(document).on('click','#btn_buscar_configuracion_correo',function (){
		SalidaCorreo.buscar_config_correo();
	});

	SalidaCorreo.buscar_config_correo();

});

var SalidaCorreo = {

	buscar_config_correo : function(){
		$('#contenedor_resultados_configuracion_correo').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Configuracion/buscar_config_correo', {},
			function(response){
				$('#contenedor_resultados_configuracion_correo').html(response);
				Comun.tooltips();
			}
		);
	},

	agregar_modificar_config_correo : function (id_config_correo = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Configuracion/agregar_modificar_salida_correo/'+id_config_correo,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_config_correo',true);
			});
	},

	validar_form : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_config_correo',Comun.reglas_validacion_form());
		if(form_valido){

		}
		return form_valido;
	},

	guardar_config_correo : function(id_config_correo){
		if(SalidaCorreo.validar_form()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_config_correo',
				base_url + 'Configuracion/guardar_salida_correo/' + id_config_correo,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_config_correo',false);
						Comun.mensajes_operacion(response.msg,'success');
						SalidaCorreo.buscar_config_correo();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	}

};
