$(document).ready(function(){

	$(document).on('click','#registrar_cuenta_convocatoria',function(e){
		e.preventDefault();
		ConvocatoriaLogin.registrar_cuenta();
	});

	$(document).on('change','#switch_procedencia_extranjera',function(){
		let checked = $(this).is(':checked');
		if(checked){
			$('#input_curp').fadeOut();
			$('#input_curp_registro_convocatoria').val('');
			$('#input_extranjero').fadeIn();
			$('#span_registro_convocatoria').html('Clave de identificación');
		}else{
			$('#input_curp').fadeIn();
			$('#input_clave_extranjera_registro_convocatoria').val('');
			$('#input_extranjero').fadeOut();
			$('#span_registro_convocatoria').html('Clave Unica de Registro de Población CURP');
		}
	});

	$(document).on('click','#btn_aceptar_registro_convocatoria',function(){
		$('#iniciar_sesion').trigger('click');
	});
	
	Comun.tooltips();

});

var ConvocatoriaLogin = {

	registrar_cuenta : function(){
		if(ConvocatoriaLogin.validar_form_registro()){
			Comun.enviar_formulario_post(
				'#form_registro_usuario_convocatoria',
				base_url + 'Publico/registarCandidato' ,
				function(response){
					if(response.success){
						//en caso de que sea correcto el registro, mandaremos al perfil del usuario 
						//de preferencia con autologin al sistema
						//validar el autologin haciendo uso del login.js
						//Comun.mensajes_operacion(response.msg,'success');
						Comun.mostrar_mensaje_advertencia(response.msg);
						$('#input_usuario_login').val(response.data.usuario);
						$('#input_contrasena_login').val(response.data.password);
						// $('#iniciar_sesion').trigger('click');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}
	},

	validar_form_registro : function(){
		var form_valido = Comun.validar_form('#form_registro_usuario_convocatoria',Comun.reglas_validacion_form());
		if(form_valido){
			let es_extranjero = $('#switch_procedencia_extranjera').is(':checked');
			if(!es_extranjero){
				var strCURP = $('#input_curp_registro_convocatoria').val();
				if(Comun.validar_curp(strCURP) == null){
					form_valido = false;
					Comun.mensaje_operacion('El CURP no tiene la estructura correcta','error');
				}
			}
		}
		return form_valido;
	}
	

};
