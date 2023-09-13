$(document).ready(function(){

	$(document).on('click','#iniciar_sesion',function(e){
		e.preventDefault();
		Login.iniciar_sesion();
	});

	$(document).on('click','#cerrar_sesion',function(e){
		e.preventDefault();
		Login.cerrar_sesion();
	});

	$(document).on('click','#recuerar_password',function(e){
		e.preventDefault();
		Login.recuperar_password();
	});

});

var Login = {

	existe_login : false,

	iniciar_sesion : function(){
		//validar formulario
		if(Comun.validar_form('#form_login',Comun.reglas_validacion_form())){
			Comun.enviar_formulario_post('#form_login',base_url + 'Login/iniciar_sesion',function(response){
				if(response.success){

					Comun.recargar_pagina(base_url + 'admin',100);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			})
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	cerrar_sesion : function(){
		Comun.obtener_contenido_peticion_json(base_url + 'Login/cerrar_sesion',{},function(response){
			if(response.success){
				Comun.recargar_pagina(base_url,100);
			}else{
				Comun.mensajes_operacion(response.msg,'error');
			}
		})
	},

	recuperar_password : function(){
		var form_valid = Comun.validar_form('#form_recuperar_password',Comun.reglas_validacion_form());
		if(form_valid){
			Comun.enviar_formulario_post(
				'#form_recuperar_password',
				base_url + 'Login/mail_recovery_pass',
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'confirmed',3000);
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		}
	}

};
