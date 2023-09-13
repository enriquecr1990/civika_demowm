$(document).ready(function(){

	$(document).on('click','#modificar_usuario_instructor',function (e) {
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilInstructor.modal_modificar_usr(id_usuario)
	});

	$(document).on('click','#btn_guardar_form_usuario',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilInstructor.guardar_usuario(id_usuario);
	});

	$(document).on('click','#btn_actualizar_password_perfil',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilInstructor.actualizar_password(id_usuario);
	});

	$(document).on('click','#tab_curriculum',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilInstructor.obtener_tab_curriculum(id_usuario);
	});

	$(document).on('click','#tab_expediente_digital',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilInstructor.obtener_tab_expediente_digital(id_usuario);
	});

});

var PerfilInstructor = {

	modal_modificar_usr : function(id_usuario){
		Comun.obtener_contenido_peticion_html(base_url + 'Perfil/agregar_modificar_usuario/instructor/' + id_usuario,
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
		if(PerfilInstructor.validar_form_usuario()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_usr',
				base_url + 'Perfil/guardar_form_usuario/instructor/' + id_usuario,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_usr',false);
						Comun.mensajes_operacion(response.msg,'success');
						Comun.recargar_pagina(base_url + 'perfil',2000);
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	actualizar_password : function(id_usuario){
		var reglas_validacion = Comun.reglas_validacion_form();
		var extra_reglas = {
			input_password_nueva : 'required',
			input_password_repetir : {
				equalTo : '#input_password_nueva'
			}
		};
		if(Comun.validar_form('#actualizar_password_perfil',Comun.assing_array(reglas_validacion,extra_reglas))){
			Comun.enviar_formulario_post(
				'#actualizar_password_perfil',
				base_url + 'Perfil/update_password/' + id_usuario,
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('#actualizar_password_perfil').trigger('reset');
						$('a.mi_perfil_mi_informacion').trigger('click');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	obtener_tab_curriculum : function(id_usuario = ''){
		$('#curriculum').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_curriculum/' + id_usuario,{},
			function(response){
				$('#curriculum').html(response);
				PerfilInstructor.iniciar_editor_summernote();
			}
		)
	},

	obtener_tab_expediente_digital : function(id_usuario = ''){
		$('#content_tab_expediente_digital').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_expediente_digital/' + id_usuario,{},
			function(response){
				$('#content_tab_expediente_digital').html(response);
				Comun.funcion_fileinput('#img_perfil','Foto perfil');
				Comun.funcion_fileinput('#img_firma_digital','Firma digitalizada');
				PerfilInstructor.iniciar_carga_imagen_perfil('#procesando_img_foto_perfil',id_usuario);
				PerfilInstructor.iniciar_carga_imagen_firma_digital('#procesando_img_firma_digital',id_usuario);
			}
		)
	},

	iniciar_editor_summernote : function(){
		$('#editor_curriculum').summernote({
			minHeight : 300,
			lang : 'es-ES',
			placeholder : 'Escribe tu curriculum en el editor de texto',
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

	iniciar_carga_imagen_perfil : function (div_procesando,id_usuario) {
		Comun.iniciar_carga_imagen('.img_foto_perfil',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_foto_perfil/'+archivo.id_archivo + '/' + id_usuario,{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_perfil').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_imagen_firma_digital : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('.archivo_expediente_imagen',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/8',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_firma').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		},'si');
	},

};
