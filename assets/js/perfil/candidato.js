$(document).ready(function(){

	$(document).on('click','#modificar_usuario_candidato',function (e) {
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		var is_admin = $(this).data('is_admin') != undefined ? $(this).data('is_admin') : 'no';
		PerfilCandidato.modal_modificar_usr(id_usuario,is_admin);
	});

	$(document).on('click','#btn_guardar_form_usuario',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		var modificacion_from_perfil = $(this).data('modificacion_from_perfil') != undefined ? $(this).data('modificacion_from_perfil') : 'no';
		PerfilCandidato.guardar_usuario(id_usuario,modificacion_from_perfil);
	});

	$(document).on('click','#btn_actualizar_password_perfil',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilCandidato.actualizar_password(id_usuario);
	});

	$(document).on('click','#tab_curriculum',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilCandidato.obtener_tab_curriculum(id_usuario);
	});

	$(document).on('click','#tab_direcciones',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilCandidato.obtener_tab_direcciones(id_usuario);
	});

	$(document).on('click','#tab_datos_empresa',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilCandidato.obtener_tab_empresa(id_usuario);
	});

	$(document).on('click','#tab_expediente_digital',function(e){
		e.preventDefault();
		var id_usuario = $(this).data('id_usuario');
		PerfilCandidato.obtener_tab_expediente_digital(id_usuario);
	});

	//apartado para las direcciones
	$(document).on('click','.btn_modificar_direccion',function () {
		var id_usuario = $(this).data('id_usuario');
		var id_datos_domicilio = $(this).data('id_datos_domicilio');
		PerfilCandidato.modal_direccion(id_usuario,id_datos_domicilio);
	});

	$(document).on('click','#btn_guardar_form_domicilio',function(){
		var id_usuario = $(this).data('id_usuario');
		var id_datos_domicilio = $(this).data('id_datos_domicilio');
		PerfilCandidato.guardar_domicilio(id_usuario,id_datos_domicilio);
	});

	//apartado para los datos de empresa
	$(document).on('click','.btn_modificar_empresa',function () {
		var id_usuario = $(this).data('id_usuario');
		var id_datos_empresa = $(this).data('id_datos_empresa');
		PerfilCandidato.modal_empresa(id_usuario,id_datos_empresa);
	});

	$(document).on('click','#btn_guardar_form_empresa',function(){
		var id_usuario = $(this).data('id_usuario');
		var id_datos_empresa = $(this).data('id_datos_empresa');
		PerfilCandidato.guardar_empresa(id_usuario,id_datos_empresa);
	});

});

var PerfilCandidato = {

	modal_modificar_usr : function(id_usuario,is_admin = 'no'){
		Comun.obtener_contenido_peticion_html(base_url + 'Perfil/agregar_modificar_usuario/candidato/' + id_usuario + '/' + is_admin,
			{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_usr',true);
				$('[data-mask]').inputmask();
			});
	},

	modal_direccion : function(id_usuario,id_datos_domicilio = ''){
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/agregar_modificar_direccion/' + id_usuario + '/' + id_datos_domicilio,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_domicilio',true);
			}
		);
	},

	modal_empresa : function(id_usuario,id_datos_empresa = ''){
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/agregar_modificar_empresa/' + id_usuario + '/' + id_datos_empresa,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_empresa',true);
				Comun.funcion_fileinput('#img_logotipo_emp','Logotipo');
				PerfilCandidato.iniciar_carga_img_logo_empresa();
			}
		);
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

	validar_form_direccion : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_domicilio',Comun.reglas_validacion_form());
		if(form_valido){

		}
		return form_valido;
	},

	validar_form_empresa : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_empresa',Comun.reglas_validacion_form());
		if(form_valido){

		}
		return form_valido;
	},

	guardar_usuario : function(id_usuario = '',modificacion_from_perfil = 'no'){
		var tipo_usuario = $('#tipo_usuario').val();
		if(PerfilCandidato.validar_form_usuario()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_usr',
				base_url + 'Perfil/guardar_form_usuario/candidato/' + id_usuario,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_usr',false);
						Comun.mensajes_operacion(response.msg,'success');
						if(modificacion_from_perfil == 'no' || (response.perfil_usuario_modificacion != undefined && response.perfil_usuario_modificacion == 'alumno')){
							Comun.recargar_pagina(base_url + 'perfil',2000);
						}else{
							Comun.recargar_pagina(base_url + 'Perfil/editar/'+id_usuario,2000);
						}
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	guardar_domicilio : function(id_usuario,id_datos_domicilio = ''){
		if(PerfilCandidato.validar_form_direccion()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_domicilio',
				base_url + 'Perfil/guardar_domicilio/' + id_usuario + '/' + id_datos_domicilio,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_domicilio',false);
						Comun.mensajes_operacion(response.msg,'success');
						$('#tab_direcciones').trigger('click');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	guardar_empresa : function(id_usuario,id_datos_empresa = ''){
		if(PerfilCandidato.validar_form_empresa()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_empresa',
				base_url + 'Perfil/guardar_empresa/' + id_usuario + '/' + id_datos_empresa,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_empresa',false);
						Comun.mensajes_operacion(response.msg,'success');
						$('#tab_datos_empresa').trigger('click');
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

	obtener_tab_curriculum : function(id_usuario){
		$('#curriculum').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_curriculum/' + id_usuario,{},
			function(response){
				$('#curriculum').html(response);
				PerfilCandidato.iniciar_editor_summernote();
			}
		)
	},

	obtener_tab_direcciones : function(id_usuario){
		$('#content_tab_mi_direccion').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_direcciones/'+id_usuario,{},
			function(response){
				$('#content_tab_mi_direccion').html(response);
				Comun.tooltips()
			}
		);
	},

	obtener_tab_empresa : function(id_usuario){
		$('#content_tab_datos_empresa').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_empresa/'+id_usuario,{},
			function(response){
				$('#content_tab_datos_empresa').html(response);
				Comun.tooltips()
			}
		);
	},

	obtener_tab_expediente_digital : function(id_usuario){
		$('#content_tab_expediente_digital').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'Perfil/obtener_tab_expediente_digital/'+id_usuario,{},
			function(response){
				$('#content_tab_expediente_digital').html(response);
				Comun.funcion_fileinput('#img_perfil','Foto de perfil');
				Comun.funcion_fileinput('#img_certificados','Foto certificados');
				Comun.funcion_fileinput('#img_firma_digital','Firma digitalizada');
				Comun.funcion_fileinput('#img_foto_ine_anverso','INE anverso');
				Comun.funcion_fileinput('#img_foto_ine_reverso','INE reverso');
				Comun.funcion_fileinput('#img_foto_cedula_anverso','Cédula anverso');
				Comun.funcion_fileinput('#img_foto_cedula_reverso','Cédula reverso');
				Comun.funcion_fileinput('#doc_curp_candidato','Curp en PDF');
				Comun.bootstrap_switch();
				PerfilCandidato.iniciar_carga_imagen_perfil(id_usuario);
				PerfilCandidato.iniciar_carga_imagen_certificados('#procesando_img_foto_certificados',id_usuario);
				PerfilCandidato.iniciar_carga_imagen_firma_digital('#procesando_img_firma_digital',id_usuario);
				PerfilCandidato.iniciar_carga_imagen_ine_anverso('#procesando_img_ine_anverso',id_usuario);
				PerfilCandidato.iniciar_carga_imagen_ine_reverso('#procesando_img_ine_reverso',id_usuario);
				PerfilCandidato.iniciar_carga_imagen_cedula_anverso('#procesando_img_cedula_anverso',id_usuario);
				PerfilCandidato.iniciar_carga_imagen_cedula_reverso('#procesando_img_cedula_reverso',id_usuario);
				PerfilCandidato.iniciar_carga_doc_curp(id_usuario);
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

	iniciar_carga_imagen_perfil : function (id_usuario) {
		Comun.iniciar_carga_imagen('.img_foto_perfil','#procesando_img_foto_perfil',function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_foto_perfil/'+archivo.id_archivo,{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_perfil').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$('#procesando_img_foto_perfil').html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
			//como para los alumnos aplica la foto de certificados se manda el mismo archivo con la funcionalidad del de certificados
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/2',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_certificado').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		})
	},

	iniciar_carga_imagen_certificados : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_certificados',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/2',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_certificado').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_imagen_firma_digital : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_firma_digital',div_procesando,function(archivo){
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

	iniciar_carga_imagen_ine_anverso : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_foto_ine_anverso',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/3',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_ine_anverso').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_imagen_ine_reverso : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_foto_ine_reverso',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/4',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_ine_reverso').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_imagen_cedula_anverso : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_foto_cedula_anverso',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/5',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_cedula_anverso').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_imagen_cedula_reverso : function(div_procesando,id_usuario){
		Comun.iniciar_carga_imagen('#img_foto_cedula_reverso',div_procesando,function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/6',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('.img_foto_cedula_reverso').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
						$(div_procesando).html('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_doc_curp : function(id_usuario){
		Comun.iniciar_carga_documento('#doc_curp_candidato','#procesando_doc_curp_candidato',function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'Perfil/actualizar_expediente_digital/'+archivo.id_archivo+'/'+id_usuario+'/7',{},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						$('#doc_curp_candidato_link').attr('href',base_url + archivo.ruta_directorio + archivo.nombre);
						$('#procesando_doc_curp_candidato').html('');
						$('#legend_cargo_curp_candidato').html('<span class="text-sm text-muted">* Se cargo el CURP previamente, de click en la imagen de arriba para visualizarla</span>');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_img_logo_empresa : function(){
		Comun.iniciar_carga_imagen('#img_logotipo_emp','#procesando_img_logotipo_emp',function(archivo){
			$('#input_id_archivo_logotipo').val(archivo.id_archivo);
			var html_img = '<img src="'+base_url + archivo.ruta_directorio + archivo.nombre+'" style="max-width: 120px" class="img-fluid img-thumbnail" alt="Imagen logotipo empresa">';
			$('#procesando_img_logotipo_emp').html(html_img);
		})
	}

};
