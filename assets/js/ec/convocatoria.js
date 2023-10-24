$(document).ready(function(){

	$(document).on('click','#btn_buscar_convocatoria_ec',function(){
		Convocatoria.tablero();
	});

	$(document).on('click','#agregar_convocatoria_estandar_competencia',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		Convocatoria.agregar_modificar_convocatoria(id_estandar_competencia);
	});

	$(document).on('click','#btn_guardar_form_ec_convocatoria',function(){
		var id_estandar_competencia_convocatoria = $(this).data('id_estandar_competencia_convocatoria');
		Convocatoria.guardar_form_convocatoria(id_estandar_competencia_convocatoria);
	});

	$(document).on('click','.modificar_convocatoria_ec',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_estandar_competencia_convocatoria = $(this).data('id_estandar_competencia_convocatoria');
		Convocatoria.agregar_modificar_convocatoria(id_estandar_competencia,id_estandar_competencia_convocatoria);
	});

	$(document).on('click','.clonar_convocatoria_ec',function(){
		var id_estandar_competencia_convocatoria = $(this).data('id_estandar_competencia_convocatoria');
		Convocatoria.clonar_convocatoria(id_estandar_competencia_convocatoria);
	});

	$(document).on('change','.costo_convocatoria',function(){
		var suma = 0;
		$('.costo_convocatoria').each(function(){
			suma += $(this).val() != '' ? parseFloat($(this).val()) : 0;
		});
		$('#input_costo').val(suma.toFixed(2));
	});

	//funcionalidad para el paginado por scroll
	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			if(Math.round($(window).scrollTop()) == Math.round($(document).height() - $(window).height())){
				pagina_select++;
				Convocatoria.tablero(false,pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

	Convocatoria.iniciar();

});

var Convocatoria = {

	iniciar : function(){
		$('#btn_buscar_convocatoria_ec').trigger('click');
	},

	tablero : function(inicial = true,pagina = 1, registros = 5){
		var post = {
			id_estandar_competencia : $('#id_estandar_competencia').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_convocatoria_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'ConvocatoriasEC/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_convocatoria_ec').html(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'ConvocatoriasEC/tablero/' + pagina + '/' + registros,
				post,
				function(response){
					$('#contenedor_resultados_convocatoria_ec').append(response);
					Comun.tooltips();
					$('.popoverShowHTML').trigger('click');
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

	agregar_modificar_convocatoria :function(id_estandar_competencia, id_estandar_competencia_convocatoria = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'ConvocatoriasEC/agregar_modificar_convocatoria/'+id_estandar_competencia + '/' + id_estandar_competencia_convocatoria,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_convocatoria_ec',true);
				Convocatoria.iniciar_editor_summernote();
		});
	},

	clonar_convocatoria :function(id_estandar_competencia_convocatoria = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'ConvocatoriasEC/clonar_convocatoria/' + id_estandar_competencia_convocatoria,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_convocatoria_ec',true);
				Convocatoria.iniciar_editor_summernote();
		});
	},

	iniciar_editor_summernote : function(){
		Comun.iniciar_editor_summernote('#input_textarea_proposito','Describa el proposito de la convocatoria',150);
		Comun.iniciar_editor_summernote('#input_textarea_descripcion','Descripción de la convocatoria',150);
		Comun.iniciar_editor_summernote('#input_textarea_sector_descripcion','Describa el detalle del sector',150);
		Comun.iniciar_editor_summernote('#input_textarea_perfil','Descripción del perfil del candidato',150);
		Comun.iniciar_editor_summernote('#input_textarea_duracion_descripcion','Descripción de la duración de la convocatoria',150);
	},

	validar_form_convocatoria : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_convocatoria',Comun.reglas_validacion_form());
		if(form_valido){
			/*let actividades = $('#tbody_destino_actividades').find('tr');
			if(actividades.length == 0){
				form_valido = false;
				Comun.mensaje_operacion('Error, debe ingresar por lo menos una actividad del instrumento','error');
			}*/
		}
		return form_valido;
	},

	guardar_form_convocatoria : function(id_estandar_competencia_convocatoria = ''){
		if(Convocatoria.validar_form_convocatoria()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_convocatoria',
				base_url + 'ConvocatoriasEC/guardar_convocatoria/' + id_estandar_competencia_convocatoria,
				function(response){
					if(response.success){
						$('#form_agregar_modificar_convocatoria').trigger('reset');
						Comun.mensajes_operacion(response.msg,'success');
						Comun.mostrar_ocultar_modal('#modal_form_convocatoria_ec',false);
						Convocatoria.iniciar();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}
	},



};
