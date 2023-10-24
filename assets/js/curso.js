$(document).ready(function(){
	
	$(document).on('click','#btn_buscar_ec_curso',function(){
		Curso.tablero();
	});

	$(document).on('click','#agregar_estandar_competencia_curso',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		Curso.agregar_modificar_ec_curso(id_estandar_competencia);
	});

	$(document).on('click','#btn_guardar_form_ec_curso',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		Curso.guardar_ec_curso(id_estandar_competencia);
	});
	
	
	$(document).on('click','#modificar_estandar_competencia_curso',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_ec_curso = $(this).data('id_ec_curso');
		Curso.agregar_modificar_ec_curso(id_estandar_competencia,id_ec_curso);
	});
	
	$(document).on('click','.ver_detalle_curso_ec',function(){
		var id_ec_curso = $(this).data('id_ec_curso');
		Curso.detalle(id_ec_curso);
	});

	Curso.tablero();

});

var Curso = {

	
	tablero : function(inicial = true,pagina = 1, registros = 5){
		var post = {
			id_estandar_competencia : $('#id_estandar_competencia').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_cursos_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Curso/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_cursos_ec').html(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'Curso/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_cursos_ec').append(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

	agregar_modificar_ec_curso : function(id_estandar_competencia,id_ec_curso = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Curso/agregar_modificar_curso/'+id_estandar_competencia + '/' + id_ec_curso,{},
			function(response){
				$('#contenedor_modal_curso').html(response);
				// $('#card_formulario_ati').fadeIn();
				// $('#card_resultados_ati').fadeOut();
				Comun.mostrar_ocultar_modal('#modal_form_curso',true);
				Comun.tooltips();
				Comun.funcion_fileinput('#img_banner_ec_curso','Imágen Banner');
				Curso.iniciar_carga_img_banner();
				Comun.iniciar_editor_summernote("#txt_que_aprenderas_curso", "Describa lo que aprendera el candidato en el curso");
			});
	},

	iniciar_carga_img_banner : function(){
		Comun.iniciar_carga_imagen('#img_banner_ec_curso','#procesando_img_banner_ec_curso',function(archivo){
			$('#input_id_archivo_banner_ec_curso').val(archivo.id_archivo);
			var html_img = '<img src="'+base_url + archivo.ruta_directorio + archivo.nombre+'" style="max-width: 120px" class="img-fluid img-thumbnail" alt="Imagen banner EC">';
			$('#procesando_img_banner_ec_curso').html(html_img);
		})
	},

	validar_form_ec_curso : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_ec_curso',Comun.reglas_validacion_form());
		if(form_valido){
			if($('#input_id_archivo_banner_ec_curso').val() == ''){
				form_valido = false;
				Comun.mensaje_operacion('El archivo de imagen para el banner es requerido','error');
				$('#procesando_img_banner_ec_curso').html('<span class="badge badge-danger">El banner es requerido</span>')
			}
		}
		return form_valido;
	},

	guardar_ec_curso : function(id_estandar_competencia = ''){
		if(Curso.validar_form_ec_curso()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_ec_curso',
				base_url + 'Curso/guardar_form/' + id_estandar_competencia,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_curso',false);
						Comun.mensajes_operacion(response.msg,'success');
						Curso.tablero();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos','error');
		}
	},

	detalle :function(id_ec_curso = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Curso/detalle/'+ id_ec_curso,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_curso_modulo_detalle',true);
			}
		);
	},


}
