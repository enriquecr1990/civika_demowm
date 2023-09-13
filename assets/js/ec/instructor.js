$(document).ready(function(){

	$(document).on('click','.btn_evidencia_ati_alumno',function () {
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		EvaluadoresEC.ver_entregables_ati(id_estandar_competencia,id_usuario);
	});

	$(document).on('click','.btn_evaluaciones_alumno',function () {
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		var es_evaluacion = $(this).data('es_evaluacion') != undefined && $(this).data('es_evaluacion') == 'si' ? true : false;
		EvaluadoresEC.ver_evaluaciones_alumno(id_estandar_competencia,id_usuario,es_evaluacion);
	});

	$(document).on('click','.btn_encuesta_satisfaccion_lectura',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		EvaluadoresEC.ver_encuesta_satisfacion_alumno(id_estandar_competencia,id_usuario);
	});
	
	$(document).on('click','.btn_cargar_expediente_alumno',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		EvaluadoresEC.ver_expediente_candidato(id_estandar_competencia,id_usuario);
	});

	$(document).on('click','.txt_guardar_comentario_instructor',function(){
		var id_body_comentarios = $(this).data('id_body_comentarios');
		var id_ec_instrumento_alumno = $(this).data('id_ec_instrumento_alumno');
		var valor = $('#txt_comentarios_candidato_'+id_ec_instrumento_alumno).val();
		if(valor.length > 0){
			EvaluadoresEC.guardar_comentario_instructor(id_body_comentarios,id_ec_instrumento_alumno,valor);
		}
	});

	$(document).on('click','.buscar_preguntas_evaluacion',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		EvaluadoresEC.obtener_preguntas_evaluacion(id_evaluacion);
	});

	$(document).on('click','.btn_actualizar_ec_instrumento_alumno_proceso',function(){
		EvaluadoresEC.procesar_ATI($(this));
	});

	$(document).on('click','.btn_ver_intentos_evaluacion',function(){
		var info_oculta = $(this).hasClass('btn_info_oculta');
		var mostrar_instentos = $(this).data('mostrar_instentos');
		if(info_oculta){
			$(this).removeClass('btn_info_oculta');
			$(this).find('i').removeClass('').addClass('');
			$(mostrar_instentos).fadeIn();
		}else{
			$(this).addClass('btn_info_oculta');
			$(this).find('i').removeClass('').addClass('');
			$(mostrar_instentos).fadeOut();
		}
	});

	$(document).on('click','.ver_evaluacion_respuestas_candidato',function(){
		var id_usuario_has_evaluacion_realizada = $(this).data('id_usuario_has_evaluacion_realizada');
		EvaluadoresEC.ver_evaluacion_lectura(id_usuario_has_evaluacion_realizada);
	});

	$(document).on('click','.btn_cerrar_modal_evidencia_respuestas',function(){
		EvaluadoresEC.regresar_modal_evaluacion_usuario();
	});

	$(document).on('click','#btn_date_fecha_envio_ati',function(){
		var validar_form = Comun.validar_form('#form_acuerdos_evaluacion',Comun.reglas_validacion_form());
		if(validar_form){
			EvaluadoresEC.guardar_fecha_envio_evidencia_ati_ped($(this));
		}
	});

	$(document).on('change','#input_fecha_evidencia_ati',function(){
		var fecha_evidencia = $(this).val();
		var dia_max_revision = Comun.sumar_dias_habiles_calendario(fecha_evidencia,8); //obtener la fecha limite
		$('#input_fecha_revision_ati').attr('min',fecha_evidencia);
		$('#input_fecha_revision_ati').attr('max',dia_max_revision);
	});

	$(document).on('click','#btn_update_resultados_evaluacion',function(){
		var id_usuario_has_estandar_competencia = $(this).data('id_usuario_has_estandar_competencia');
		EvaluadoresEC.guardar_form_resultados_evaluacion(id_usuario_has_estandar_competencia);
	});

	//funcionalidad para el paginado por scroll
	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			var wst = Math.round($(window).scrollTop());
			var dhwh = Math.round($(document).height() - $(window).height());
			if(wst == dhwh){
				pagina_select++;
				var id_estandar_competencia = $('#val_id_estandar_competencia').val();
				EvaluadoresEC.cargar_alumnos_estandar_competencia(false,id_estandar_competencia,pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});

	EvaluadoresEC.iniciar_carga_alumnos_ec();

});

var EvaluadoresEC = {

	iniciar_carga_alumnos_ec : function() {
		var id_estandar_competencia = $('#val_id_estandar_competencia').val();
		EvaluadoresEC.cargar_alumnos_estandar_competencia(true,id_estandar_competencia);
	},

	cargar_alumnos_estandar_competencia : function(inicial = true, id_estandar_competencia,pagina = 1, limit = 5){
		if(inicial){
			$('#contenedor_resultado_tablero_alumnos_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'EvaluadoresEC/tablero_alumnos/'+id_estandar_competencia+'/'+pagina+'/'+limit,{},
				function(response){
					$('#contenedor_resultado_tablero_alumnos_ec').html(response);
				}
			);
		}else{
			$('#overlay_full_page').fadeIn();
			Comun.obtener_contenido_peticion_html(
				base_url + 'EvaluadoresEC/tablero_alumnos/'+id_estandar_competencia+'/'+pagina+'/'+limit,{},
				function(response){
					$('#contenedor_resultado_tablero_alumnos_ec').append(response);
					$('#overlay_full_page').fadeOut();
				}
			);
		}
	},

	ver_entregables_ati : function(id_estandar_competencia,id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluadoresEC/evidencia_ati_alumno/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				Comun.mostrar_ocultar_modal('#modal_evidencia_ati_alumno',true);
				//determinamos el navegador para cambiar el mensaje de ayuda de la hora
				if(bowser.name != undefined && bowser.name == 'Firefox'){
					$('.smal_hora_envio').html('Formato de 24 hrs');
				}else{
					$('.smal_hora_envio').html('Formato de 12 hrs');
				}
				Comun.desabilitar_fines_semana_calendario('#input_fecha_evidencia_ati','#error_fecha_evidencia');
				Comun.desabilitar_fines_semana_calendario('#input_fecha_revision_ati','#error_fecha_revision');
				var fecha_evidencia = $('#input_fecha_evidencia_ati').val();
				if(fecha_evidencia != ''){
					var dia_max_revision = Comun.sumar_dias_habiles_calendario(fecha_evidencia,8); //obtener la fecha limite
					$('#input_fecha_revision_ati').attr('min',fecha_evidencia);
					$('#input_fecha_revision_ati').attr('max',dia_max_revision);
				}
			}
		);
	},

	ver_evaluaciones_alumno : function(id_estandar_competencia,id_usuario_alumno,es_evaluacion){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/resultados_evaluacion_usuario/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				$('.span_calificacion_evidencia').each(function(){
					var calificacion = $(this).data('calificacion');
					$(this).addClass(EvaluadoresEC.obtener_class_calificacion(calificacion));
				});
				$('input.calificacion_alta').each(function () {
					var id_index = $(this).data('id_index');
					var calificacion_alta = $(this).val();
					$('span#span_calificacion_alta_'+id_index).html(calificacion_alta).addClass(EvaluadoresEC.obtener_class_calificacion(calificacion_alta));
				});
				if(es_evaluacion){
					$('#titulo_modal_evidencia').html('Evaluación Diagnóstica');
					$('#modal_tablero_evaluacion_diagnostica').show();
					$('#modal_tablero_cedula_evaluacion').hide();
				}else{
					$('#titulo_modal_evidencia').html('Cédula de evaluación');
					$('#modal_tablero_evaluacion_diagnostica').hide();
					$('#modal_tablero_cedula_evaluacion').show();
				}
				Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion',true);
			}
		);
	},

	ver_encuesta_satisfacion_alumno : function(id_estandar_competencia,id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'encuesta_candidato/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_encuesta_satisfaccion_respuestas',true);
			}
		);
	},

	ver_expediente_candidato : function(id_estandar_competencia, id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluadoresEC/expediente_candidato/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_expediente_candidato',true);
				Comun.funcion_fileinput('#doc_ficha_registro_pdf','Ficha de registro');
				EvaluadoresEC.iniciar_carga_expediente_ficha_registro_pdf($('#doc_ficha_registro_pdf'),'#procesando_doc_ficha_registro_pdf');
				Comun.funcion_fileinput('#doc_instrumento_evaluacion_pdf','Instrumento de evaluación');
				EvaluadoresEC.iniciar_carga_expediente_instrumento_evaluacion_pdf($('#doc_instrumento_evaluacion_pdf'),'#procesando_doc_instrumento_evaluacion_pdf');
				Comun.funcion_fileinput('#doc_certificado_laboral_pdf','Certificado laboral');
				EvaluadoresEC.iniciar_carga_expediente_certificado_laboral_pdf($('#doc_certificado_laboral_pdf'),'#procesando_doc_certificado_laboral_pdf');
			},'post'
		);
	},

	guardar_comentario_instructor : function(id_body_comentarios,id_ec_instrumento_alumno, comentario){
		Comun.obtener_contenido_peticion_json(
			base_url + 'EvaluadoresEC/guardar_comentario',
			{
				comentario : comentario,
				id_ec_instrumento_alumno : id_ec_instrumento_alumno,
				quien : 'instructor'
			},
			function(response){
				if(response.success){
					var html_row_comentario = '' +
						'<tr>' +
						'	<td>Evaluador</td>' +
						'	<td>'+comentario+'</td>' +
						'	<td>'+new Date().toLocaleString('es-MX',{hour12: true})+'</td>' +
						'</tr>'
					$(id_body_comentarios).append(html_row_comentario);
					Comun.mensajes_operacion(response.msg,'success');
					$('#txt_comentarios_candidato_'+id_ec_instrumento_alumno).val('');
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			},'post'
		);
	},

	guardar_fecha_envio_evidencia_ati_ped : function(input){
		var post = {
			id_estandar_competencia : input.data('id_estandar_competencia'),
			id_usuario : input.data('id_usuario_alumno'),
			lugar_presentacion_resultados : $('#slt_lugar_revision').val(),
			descripcion_presentacion_resultados : $('#input_descripcion_lugar').val(),
			fecha_evidencia_ati : $('#input_fecha_evidencia_ati').val() + ' ' + $('#input_hora_evidencia_ati').val(),
			fecha_presentacion_resultados : $('#input_fecha_revision_ati').val() + ' ' + $('#input_hora_revision_ati').val(),
		};
		Comun.obtener_contenido_peticion_json(
			base_url + 'EvaluadoresEC/guardar_fecha_evidencia_ati',post,
			function(response){
				if(response.success){
					Comun.mensaje_operacion(response.msg,'confirmed');
				}else{
					Comun.mensajes_operacion(response.msg,'error')
				}
			},'post'
		);
	},

	procesar_ATI : function(boton){
		var id_ec_instrumento_alumno = boton.data('id_ec_instrumento_alumno');
		var proceso_ati = boton.data('proceso_ati');
		var id_cat_proceso = 1;
		var label_estatus = 'Enviada por el candidato';
		var label_class = 'badge-info';
		switch (proceso_ati) {
			case 'observar': id_cat_proceso = 3; label_estatus = 'Evidencia con observaciones'; label_class='badge-danger'; break;
			case 'liberar': id_cat_proceso = 4; label_estatus='Finalizada'; label_class='badge-success'; break;
		}
		Comun.obtener_contenido_peticion_json(
			base_url + 'EvaluadoresEC/actualizar_ati/' + id_ec_instrumento_alumno,
			{id_cat_proceso : id_cat_proceso},
			function(response){
				if(response.success){
					var contenedor = boton.closest('div.contenedor_evidencia_alumno');
					contenedor.find('textarea#txt_comentarios_candidato_'+id_ec_instrumento_alumno).closest('div.row').remove();
					contenedor.find('span.evidencia_alumno_ati_span_'+id_ec_instrumento_alumno).html(label_estatus).removeClass('badge-info').addClass(label_class);
					boton.closest('div.row').find('.btn_actualizar_ec_instrumento_alumno_proceso').remove();
					Comun.mensajes_operacion(response.msg,'success');
					EvaluadoresEC.validar_input_fecha_envio_ati_instructor();
					Comun.ocultar_tooltips();
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			},'post'
		);
	},

	obtener_preguntas_evaluacion : function(id_evaluacion){
		$('#contenedor_preguntas_preview').fadeIn();
		$('#card_body_preguntas_preview').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/preguntas_evaluacion/' + id_evaluacion,{},
			function(response){
				$('#card_body_preguntas_preview').html(response);
				$('.columna_operaciones_preguntas_eva').hide();
				Comun.tooltips();
				$('.popoverShowImage').trigger('click');
			}
		);
	},

	obtener_class_calificacion : function(calificacion){
		var class_etiqueta = 'badge badge-danger';
		if(calificacion >= 70 && calificacion < 80){
			class_etiqueta = 'badge badge-warning';
		}if(calificacion >= 80 && calificacion < 90){
			class_etiqueta = 'badge badge-info';
		}if(calificacion >= 90){
			class_etiqueta = 'badge badge-success';
		}
		return class_etiqueta;
	},

	ver_evaluacion_lectura : function(id_usuario_has_evaluacion_realizada){
		Comun.obtener_contenido_peticion_html(
			base_url + 'ver_evaluacion/' + id_usuario_has_evaluacion_realizada,{},
			function(response){
				$('#contenedor_modal_sedundario').html(response);
				EvaluadoresEC.procesar_class_calificacion();
				Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion',false);
				Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion_respuestas',true);
			}
		)
	},

	regresar_modal_evaluacion_usuario : function(){
		Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion_respuestas',false);
		Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion',true);
	},

	procesar_class_calificacion : function(){
		$('.span_calificacion_evidencia').each(function(){
			var calificacion = $(this).data('calificacion');
			var class_etiqueta = 'badge badge-danger';
			if(calificacion >= 70 && calificacion < 80){
				class_etiqueta = 'badge badge-warning';
			}if(calificacion >= 80 && calificacion < 90){
				class_etiqueta = 'badge badge-info';
			}if(calificacion >= 90){
				class_etiqueta = 'badge badge-success';
			}
			$(this).addClass(class_etiqueta);
		});
	},

	validar_input_fecha_envio_ati_instructor : function(){
		var num_archivos = $('span.evidencia_alumno_ati_span').length;
		var span_evidencia_alumno_ati = $('span.evidencia_alumno_ati_span');
		var num_archivos_finalizados = 0;
		span_evidencia_alumno_ati.each(function(index,elm){
			var span_leyen = $(elm).html();
			span_leyen == 'Finalizada' ? num_archivos_finalizados++ : false;
		});
		$('#div_input_fecha_envio_ati').fadeOut();
		$('#div_leyend_fecha_envio_ati').fadeIn();
		if(num_archivos == num_archivos_finalizados){
			$('#div_input_fecha_envio_ati').fadeIn();
			$('#div_leyend_fecha_envio_ati').fadeOut();
			Comun.mensaje_operacion('Se finalizaron las evidencias de trabajo del candidato, es posible registrar los acuerdos de la evaluación (aparece al principio de está ventana emergente)','success',5000);
		}
	},

	iniciar_carga_expediente_ficha_registro_pdf : function(input_file,div_procesando){
		Comun.iniciar_carga_documento(input_file,'#procesando_doc_ficha_registro_pdf', function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'EvaluadoresEC/agregar_archivo_expediente_digital',
				{
					id_archivo : archivo.id_archivo,
					id_estandar_competencia : $('#id_estandar_competencia').val(),
					id_usuario : $('#id_usuario_alumno').val(),
					id_cat_expediente_ped : 1,
				},function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						var html_documento = '<ul>' +
							'<li>Expediente PDF:'+archivo.nombre+'</li>' +
							'<li>Fecha de carga: '+archivo.fecha+'</li>' +
							'<li>' +
							'<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"' +
							'   href="'+base_url + archivo.ruta_directorio + archivo.nombre+'">' +
							'<i class="fa fa-eye"></i> Ver archivo' +
							'</a>' +
							'</li>' +
							'</ul>';
						$('#contenedor_doc_ficha_registro_pdf').html(html_documento);
						$('#procesando_doc_ficha_registro_pdf').hide();
					}else{
						$(div_procesando).hide();
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_expediente_instrumento_evaluacion_pdf : function(input_file,div_procesando){
		Comun.iniciar_carga_documento(input_file,'#procesando_doc_ficha_registro_pdf', function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'EvaluadoresEC/agregar_archivo_expediente_digital',
				{
					id_archivo : archivo.id_archivo,
					id_estandar_competencia : $('#id_estandar_competencia').val(),
					id_usuario : $('#id_usuario_alumno').val(),
					id_cat_expediente_ped : 2,
				},function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						var html_documento = '<ul>' +
							'<li>Expediente PDF:'+archivo.nombre+'</li>' +
							'<li>Fecha de carga: '+archivo.fecha+'</li>' +
							'<li>' +
							'<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"' +
							'   href="'+base_url + archivo.ruta_directorio + archivo.nombre+'">' +
							'<i class="fa fa-eye"></i> Ver archivo' +
							'</a>' +
							'</li>' +
							'</ul>';
						$('#contenedor_doc_instrumento_evaluacion_pdf').html(html_documento);
						$('#procesando_doc_ficha_registro_pdf').hide();
					}else{
						$(div_procesando).hide();
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	iniciar_carga_expediente_certificado_laboral_pdf : function(input_file,div_procesando){
		Comun.iniciar_carga_documento(input_file,'#procesando_doc_ficha_registro_pdf', function(archivo){
			Comun.obtener_contenido_peticion_json(
				base_url + 'EvaluadoresEC/agregar_archivo_expediente_digital',
				{
					id_archivo : archivo.id_archivo,
					id_estandar_competencia : $('#id_estandar_competencia').val(),
					id_usuario : $('#id_usuario_alumno').val(),
					id_cat_expediente_ped : 3,
				},function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						var html_documento = '<ul>' +
							'<li>Expediente PDF:'+archivo.nombre+'</li>' +
							'<li>Fecha de carga: '+archivo.fecha+'</li>' +
							'<li>' +
							'<a class="btn btn-success btn-sm archivo_doc_evidencia_ati" target="_blank"' +
							'   href="'+base_url + archivo.ruta_directorio + archivo.nombre+'">' +
							'<i class="fa fa-eye"></i> Ver archivo' +
							'</a>' +
							'</li>' +
							'</ul>';
						$('#contenedor_doc_certificado_laboral_pdf').html(html_documento);
						$('#procesando_doc_ficha_registro_pdf').hide();
					}else{
						$(div_procesando).hide();
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		});
	},

	validar_form_resultados_evaluacion : function(){
		var validar = Comun.validar_form('#form_resultados_evaluacion',Comun.reglas_validacion_form());
		return validar;
	},

	guardar_form_resultados_evaluacion : function(id_usuario_has_ec){
		if(EvaluadoresEC.validar_form_resultados_evaluacion()){
			Comun.enviar_formulario_post(
				'#form_resultados_evaluacion',
				base_url + 'EvaluadoresEC/guardar_form_resultados_evaluacion/'+id_usuario_has_ec,
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			)
		}
	}

};
