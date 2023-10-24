$(document).ready(function () {

	$(document).on('click','#btn_buscar_usuarios',function(e){
		e.preventDefault();
		UsuarioAdmin.buscar_usuarios_tablero_root();
	});

	$(document).on('click','#btn_buscar_administradores',function(e){
		e.preventDefault();
		UsuarioAdmin.buscar_usuarios_tablero_admin();
	});

	$(document).on('click','#btn_buscar_instructores',function(e){
		e.preventDefault();
		UsuarioAdmin.buscar_usuarios_tablero_evaluadores();
	});

	$(document).on('click','#btn_buscar_candidatos',function(e){
		e.preventDefault();
		UsuarioAdmin.buscar_usuarios_tablero_candidatos();
	});

	$(document).on('click','#agregar_administrador',function(e){
		e.preventDefault();
		UsuarioAdmin.agregar_modificar_usr();
	});

	$(document).on('click','#agregar_instructor',function(e){
		e.preventDefault();
		UsuarioAdmin.agregar_modificar_usr('instructor');
	});

	$(document).on('click','#agregar_candidato',function(e){
		e.preventDefault();
		UsuarioAdmin.agregar_modificar_usr('candidato');
	});

	$(document).on('click','#btn_guardar_form_usuario',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		UsuarioAdmin.guardar_usuario(id_usuario);
	});

	$(document).on('click','.modificar_usuario',function(e){
		e.preventDefault();
		var tipo_usuario = $(this).data('tipo_usuario');
		var id_usuario = $(this).data('id_usuario');
		UsuarioAdmin.agregar_modificar_usr(tipo_usuario,id_usuario);
	});

	$(document).on('click','.modificar_password_usuario',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		UsuarioAdmin.iniciar_modificar_password_usuario(id_usuario);
	});

	$(document).on('click','#btn_guardar_pass_usr',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		UsuarioAdmin.guardar_cambiar_password(id_usuario);
	});

	//funcion para hacer el scroll de los registros de los usuarios
	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var proceso_paginacion = $('#paginacion_usuario').data('proceso_paginacion');
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			if(Math.round($(window).scrollTop()) == Math.round($(document).height() - $(window).height())){
				pagina_select++;
				switch(proceso_paginacion){
					case 'usuarios':
						UsuarioAdmin.buscar_usuarios_tablero_root(false,pagina_select);
						break;
					case 'administradores':
						UsuarioAdmin.buscar_usuarios_tablero_admin(false,pagina_select);
						break;
					case 'instructores':
						UsuarioAdmin.buscar_usuarios_tablero_evaluadores(false,pagina_select);
						break;
					case 'candidatos':
						UsuarioAdmin.buscar_usuarios_tablero_candidatos(false,pagina_select);
						break;
				}
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

});

var UsuarioAdmin = {

	buscar_usuarios_tablero_root : function(inicial = true,pagina = 1, registros = 10){
		var post = {
			busqueda : $('#input_buscar_usuarios').val()
		};
		if(inicial){
			$('#contenedor_resultados_usuario').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_root/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').html(response);
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_root/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').append(response);
					$('#overlay_full_page').fadeOut();
					Comun.tooltips();
				}
			);
		}
	},

	buscar_usuarios_tablero_admin : function(inicial = true, pagina = 1, registros = 10){
		var post = {
			busqueda : $('#input_buscar_usuarios').val()
		};
		if(inicial){
			$('#contenedor_resultados_usuario').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_administradores/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').html(response);
					$('#overlay_full_page').fadeOut();
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_administradores/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').append(response);
					$('#overlay_full_page').fadeOut();
					Comun.tooltips();
				}
			);
		}
	},

	buscar_usuarios_tablero_evaluadores : function(inicial = true, pagina = 1, registros = 10){
		var post = {
			busqueda : $('#input_buscar_usuarios').val()
		};
		if(inicial){
			$('#contenedor_resultados_usuario').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_evaluadores/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').html(response);
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_evaluadores/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').append(response);
					$('#overlay_full_page').fadeOut();
					Comun.tooltips();
				}
			);
		}
		
	},

	buscar_usuarios_tablero_candidatos : function(inicial = true, pagina = 1, registros = 10){
		var post = {
			busqueda : $('#input_buscar_usuarios').val()
		};
		if(inicial){
			$('#contenedor_resultados_usuario').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_candidatos/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').html(response);
					Comun.tooltips();
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Usuario/tablero_candidatos/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_usuario').append(response);
					$('#overlay_full_page').fadeOut();
					Comun.tooltips();
				}
			);
		}
	},

	//funcion para cargar la modal de agregar o modificar un usuario
	agregar_modificar_usr : function(tipo = 'admin',id_usuario = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Usuario/agregar_modificar_usuario/' + tipo + '/' + id_usuario,
			{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_usr',true);
				$('[data-mask]').inputmask();
		});
	},

	validar_form_usuario : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_usr',Comun.reglas_validacion_form());
		if(form_valido){
			var input_correo = $('#form_agregar_modificar_usr').find('input#input_correo').val();
			if(Comun.validar_correo(input_correo) == null){
				form_valido = false;
				Comun.mensaje_operacion('Error, el correo no tiene el formato correcto','error');
			}
			if($('#form_agregar_modificar_usr').find('input#input_curp').length == 1){
				var input_curp = $('#input_curp').val();
				if(Comun.validar_curp(input_curp) == null){
					form_valido = false;
					Comun.mensaje_operacion('El CURP no tiene la estructura correcta','error');
				}
			}
		}
		return form_valido;
	},

	guardar_usuario : function(id_usuario = ''){
		var tipo_usuario = $('#tipo_usuario').val();
		if(UsuarioAdmin.validar_form_usuario()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_usr',
				base_url + 'Usuario/guardar_form_usuario/' + tipo_usuario + '/' + id_usuario,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_usr',false);
						Comun.mensajes_operacion(response.msg,'success');
						$('#input_buscar_usuarios').val('');
						$('#input_buscar_usuarios').closest('div').find('button').trigger('click');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	iniciar_modificar_password_usuario : function(id_usuario){
		Comun.obtener_contenido_peticion_html(
		base_url + 'Usuario/actualizar_contrasena_usuario/' + id_usuario,
		{},
		function(response){
			$('#contenedor_modal_primario').html(response);
			Comun.mostrar_ocultar_modal('#modal_cambiar_password_usuario',true);
		});
	},

	guardar_cambiar_password : function(id_usuario){
		if(Comun.validar_form('#form_actualizar_password')){
			Comun.enviar_formulario_post(
				'#form_actualizar_password',
				base_url + 'Usuario/guardar_nueva_contrasena_usuario/' + id_usuario,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_cambiar_password_usuario',false);
						Comun.mensajes_operacion(response.msg,'success');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	}

};
