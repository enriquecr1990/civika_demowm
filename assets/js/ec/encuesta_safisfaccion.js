$(document).ready(function(){

	$(document).on('click','#btn_guardar_encuesta_satisfaccion',function(){
		var id_usuario_has_ec = $(this).data('id_usuario_has_ec');
		EncuestaSatisfaccion.enviar_encuesta(id_usuario_has_ec);
	});

	$(document).on('click','#btn_guardar_encuesta_satisfaccion_pasos',function(){
		var id_usuario_has_ec = $(this).data('id_usuario_has_ec');
		EncuestaSatisfaccion.enviar_encuesta_pasos(id_usuario_has_ec);
	});

});

var EncuestaSatisfaccion = {

	validar_form_encuesta : function(){
		var form_validar = Comun.validar_form('#form_encuesta_satisfaccion',Comun.reglas_validacion_form());
		return form_validar;
	},


	enviar_encuesta : function(id_usuario_has_ec){
		if(EncuestaSatisfaccion.validar_form_encuesta()){
			EncuestaSatisfaccion.guardar_encuesta_satisfacion(id_usuario_has_ec)
		}
	},

	guardar_encuesta_satisfacion : function(id_usuario_has_ec){
		Comun.enviar_formulario_post(
			'#form_encuesta_satisfaccion',
			base_url + 'EncuestaSatisfaccion/guardar_encuesta_satisfacion/' + id_usuario_has_ec,
			function(response){
				if(response.success){
					Comun.mostrar_mensaje_advertencia(response.msg);
					setTimeout(function(){
						Comun.recargar_pagina(base_url + 'estandar_competencia');
					},1500);
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	enviar_encuesta_pasos : function(id_usuario_has_ec){
		if(EncuestaSatisfaccion.validar_form_encuesta()){
			EncuestaSatisfaccion.guardar_encuesta_satisfacion_pasos(id_usuario_has_ec)
		}
	},

	guardar_encuesta_satisfacion_pasos : function(id_usuario_has_ec){
		Comun.enviar_formulario_post(
			'#form_encuesta_satisfaccion',
			base_url + 'EncuestaSatisfaccion/guardar_encuesta_satisfacion/' + id_usuario_has_ec,
			function(response){
				if(response.success){
					Comun.mensajes_operacion(response.msg);
					CandidatoEC.pasos.encuesta_satisfaccion();
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},


};
