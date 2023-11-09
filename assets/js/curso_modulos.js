$(document).ready(function(){
	
	$(document).on('click','#btn_buscar_ec_curso_modulos',function(){
		CursoModulo.tablero();
	});


	$(document).on('click','#agregar_ec_curso_modulo',function(){
		var id_ec_curso = $(this).data('id_ec_curso');
		CursoModulo.agregar_modificar_ecc_modulo(id_ec_curso);
	});

	$(document).on('click','#btn_guardar_form_ec_curso_modulo',function(){
		var id_ec_curso = $(this).data('id_ec_curso');
		CursoModulo.guardar_ec_curso_modulo(id_ec_curso);
	});
	
	$(document).on('click','.modificar_ec_curso_modulo',function(){
		var id_ec_curso = $(this).data('id_ec_curso');
		var id_ec_curso_modulo = $(this).data('id_ec_curso_modulo');
		CursoModulo.agregar_modificar_ecc_modulo(id_ec_curso,id_ec_curso_modulo);
	});

	$(document).on('click','.agregar_ec_curso_modulo_temario',function(){
		var id_ec_curso_modulo = $(this).data('id_ec_curso_modulo');
		CursoModulo.agregar_modificar_eccm_temario(id_ec_curso_modulo);
	});

	$(document).on('click','#btn_guardar_form_ec_curso_modulo_temario',function(){
		var id_ec_curso_modulo = $(this).data('id_ec_curso_modulo');
		CursoModulo.guardar_ec_curso_modulo_temario(id_ec_curso_modulo);
	});
	
	
	$(document).on('click','.modificar_ec_curso_modulo_temario',function(){
		var id_ec_curso_modulo = $(this).data('id_ec_curso_modulo');
		var id_ec_curso_modulo_temario = $(this).data('id_ec_curso_modulo_temario');
		CursoModulo.agregar_modificar_eccm_temario(id_ec_curso_modulo,id_ec_curso_modulo_temario);
	});


	CursoModulo.tablero();

});

var CursoModulo = {

	
	tablero : function(){
		var id_ec_curso = $('#id_ec_curso').val();
			$('#contenedor_resultados_cursos_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'curso/tablero_curso_modulos/' + id_ec_curso ,{},
				function(response){
					$('#contenedor_resultados_ec_curso_modulos').html(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
				}
			);
	},

	agregar_modificar_ecc_modulo : function(id_ec_curso,id_ec_curso_modulo = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Curso/agregar_modificar_curso_modulo/'+id_ec_curso + '/' + id_ec_curso_modulo,{},
			function(response){
				$('#contenedor_modal_curso_modulo').html(response);
				// $('#card_formulario_ati').fadeIn();
				// $('#card_resultados_ati').fadeOut();
				Comun.mostrar_ocultar_modal('#modal_form_curso_modulo',true);
				Comun.tooltips();
				
				Comun.iniciar_editor_summernote_link_video("#objetivo_general", "Describa el objetivo general");
				Comun.iniciar_editor_summernote_link_video("#objetivos_especificos", "Describa los objetivos especificos");
			});
	},

	guardar_ec_curso_modulo : function(id_ec_curso = ''){
	
		Comun.removeClassInvalidError("form_agregar_modificar_ec_curso_modulo");
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_ec_curso_modulo',
			base_url + 'Curso/guardar_form_curso_modulo/' + id_ec_curso,
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_form_curso_modulo',false);
					Comun.mensajes_operacion(response.msg,'success');
					CursoModulo.tablero();
				}else{
					if(response.code == 400){
						$.each(response.msg,function(i,val){			
							$('#'+i).addClass('is-invalid')			
							$('#'+i).after('<span id="input_codigo-error" class="error help-block invalid-feedback">'+val+'</span>');
						})
					}
					else{
					Comun.mensajes_operacion(response.msg,'error',5000);
					}
					
				}
			}
		)
	},

	agregar_modificar_eccm_temario : function(id_ec_curso_modulo,id_ec_curso_modulo_temario = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Curso/agregar_modificar_curso_modulo_temario/'+id_ec_curso_modulo + '/' + id_ec_curso_modulo_temario,{},
			function(response){
				$('#contenedor_modal_curso_modulo_temario').html(response);
				// $('#card_formulario_ati').fadeIn();
				// $('#card_resultados_ati').fadeOut();
				Comun.mostrar_ocultar_modal('#modal_form_curso_modulo_temario',true);
				Comun.tooltips();
				Comun.funcion_fileinput('#archivo_eccmt','Archivo temario');
				CursoModulo.iniciar_carga_archivo();
				Comun.iniciar_editor_summernote_link_video("#instrucciones", "Describa las instrucciones del tema");
				Comun.iniciar_editor_summernote_link_video("#contenido_curso", "Describa el contenido del tema");
			});
	},

	iniciar_carga_archivo : function(){
		Comun.iniciar_carga_documento_all('#archivo_eccmt','#procesando_archivo_eccmt',function(archivo){
			$('#id_archivo').val(archivo.id_archivo);
			var html_img = '<p><a href="' + base_url + archivo.ruta_directorio + archivo.nombre +'" target="_blank"> '+ archivo.nombre +' </a><em class="fa fa-times-circle eliminar_archivo" style="color: red"></em></p>';
			$('#procesando_archivo_eccmt').html(html_img);
		})
	},

	validar_form_ec_curso_modulo_temario : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_ec_curso_modulo_temario',Comun.reglas_validacion_form());
		return form_valido;
	},

	guardar_ec_curso_modulo_temario : function(id_ec_curso_modulo = ''){
	
		Comun.removeClassInvalidError("form_agregar_modificar_ec_curso_modulo_temario");
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_ec_curso_modulo_temario',
			base_url + 'Curso/guardar_form_curso_modulo_temario/' + id_ec_curso_modulo,
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_form_curso_modulo_temario',false);
					Comun.mensajes_operacion(response.msg,'success');
					CursoModulo.tablero();
				}else{
					if(response.code == 400){
						$.each(response.msg,function(i,val){			
							$('#'+i).addClass('is-invalid')			
							$('#'+i).after('<span id="input_codigo-error" class="error help-block invalid-feedback">'+val+'</span>');
						})
					}
					else{
					Comun.mensajes_operacion(response.msg,'error',5000);
					}
					
				}
			}
		)
	},


}
