$(document).ready(function(){

	$(document).on('click','.btn_cargar_evidencia_ati_alumno',function () {
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		CandidatoEC.ver_entregables_ati(id_estandar_competencia,id_usuario);
	});

	$(document).on('click','.btn_evaluaciones_ec',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_usuario = $(this).data('id_usuario');
		CandidatoEC.ver_evaluaciones_ec(id_estandar_competencia,id_usuario);
	});

	$(document).on('click','.ver_evaluacion_respuestas_candidato',function(){
		var id_usuario_has_evaluacion_realizada = $(this).data('id_usuario_has_evaluacion_realizada');
		CandidatoEC.ver_evaluacion_lectura(id_usuario_has_evaluacion_realizada);
	});

	$(document).on('click','.btn_cerrar_modal_evidencia_respuestas',function(){
		CandidatoEC.regresar_modal_evaluacion_usuario();
	});

	$(document).on('click','.txt_guardar_comentario_candidato',function(e){
		e.preventDefault();
		var id_body_comentarios = $(this).data('id_body_comentarios');
		var id_entregable = $(this).data('id_entregable');
		var valor = $('#txt_comentarios_candidato_'+id_entregable).val();
		if(valor.length > 0){
			CandidatoEC.guardar_comentario(id_body_comentarios,id_entregable,valor);
		}
	});

	$(document).on('click','.txt_guardar_comentario_candidato_progreso',function(e){
		e.preventDefault();
		var id_body_comentarios = $(this).data('id_body_comentarios');
		var id_entregable = $(this).data('id_entregable');
		var valor = $('#txt_comentarios_candidato_'+id_entregable).val();
		if(valor.length > 0){
			CandidatoEC.guardar_comentario(id_body_comentarios,id_entregable,valor);
		}
	});

	$(document).on('click','.btn_actualizar_ec_instrumento_alumno_proceso',function(){
		CandidatoEC.procesar_ATI($(this));
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

	$(document).on('change','#txt_observaciones_candidato',function(){
		Comun.guardar_modificacion_input($(this));
		$('#contenedor_pasos_juicio_competencia').find('button.guardar_progreso_pasos').removeAttr('disabled');
	});

	$(document).on('click','.guardar_progreso_pasos',function(){
		var id_usuario_has_estandar_competencia = $('#input_id_usuario_has_estandar_competencia').val();
		var numero_paso = $(this).data('numero_paso');
		var siguiente_link = $(this).data('siguiente_link');
		CandidatoEC.guardar_progreso_paso(id_usuario_has_estandar_competencia,numero_paso,siguiente_link);
		//apartado para habilitar el siguiente link
	});

	//CandidatoEC.steper_init();

	//apartado para los pasos

	$(document).on('click','#tab_derechos_obligaciones-tab',function(){
		CandidatoEC.pasos.derechos_obligaciones();
	});

	$(document).on('click','#tab_evaluacion_diagnostica-tab',function(){
		CandidatoEC.pasos.evaluacion_diagnostica();
	});


	$(document).on('click','#tab_evaluacion_requerimientos-tab',function(){
		CandidatoEC.pasos.evaluacion_requerimientos();
	});

	$(document).on('click','#tab_modulo_capacitacion-tab',function(){
		CandidatoEC.pasos.modulo_capacitacion();
	});

	$(document).on('click','#tab_evidencias-tab',function(){
		CandidatoEC.pasos.evidencias();
	});

	$(document).on('click','#tab_jucio_competencia-tab',function(){
		CandidatoEC.pasos.juicio_competencia();
	});

	$(document).on('click','#tab_certificado-tab',function(){
		CandidatoEC.pasos.certificado_ec();
	});

	$(document).on('click','#tab_encuesta_satisfaccion-tab',function(){
		CandidatoEC.pasos.encuesta_satisfaccion();
	});

	$(document).on('click','#btn_siguiente_expediente_digital',function(){
		CandidatoEC.pasos.expediente_digital();
	});

	$(document).on('click','#btn_acepto_terminos_certificacion_ec',function(){
		var id_usuario_has_ec = $(this).data('id_usuario_has_ec');
		var parametros = {
			campo_actualizar : 'carta_compromiso',
			campo_actualizar_valor : 'si',
			tabla_actualizar : 'usuario_has_estandar_competencia',
			id_actualizar : 'id_usuario_has_estandar_competencia',
			id_actualizar_valor : id_usuario_has_ec,
		};
		Comun.obtener_contenido_peticion_json(
			base_url + 'Admin/actualizar_comun',parametros,
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_ficha_carta_compromiso_candidato',false);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	});

	$(document).on('click','#btn_cancelar_evidencia_candidato',function(){
		$('#contenedor_archivo_link_instrumentos_act').fadeOut();
		$('.contenedor_select_instrumento_evidencia').hide();
		$('#archivo_link_instrumento_act').html('');
		$('#select_instrumento_evidencia').val('');
	});

	$(document).on('click','.add_url_evidencia',function(){
		var input_url = $(this).data('input_url');
		var id_ec_instrumento_alumno = $(this).data('id_ec_instrumento_alumno');
		var contenedor_destino = $(this).data('contenedor_destino');
		var string_url = $(input_url).val();
		if(string_url != "" && Comun.validar_url(string_url)){
			Comun.obtener_contenido_peticion_json(
				base_url + 'AlumnosEC/actualizar_ati/'+id_ec_instrumento_alumno,
				{
					url_video : string_url
				},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						var html_documento = '' +
							'<div class="col-md-4">' +
							'<a target="_blank" class="archivo_doc_evidencia_ati" href="'+string_url+'">' +
							'' + string_url + '' +
							'</a>' +
							'<button type="button" data-tag_parent="div" data-tabla_eliminar="ec_instrumento_alumno_evidencias" data-id_eliminar="id_ec_instrumento_alumno_evidencias" class="btn btn-sm btn-outline-danger btn_eliminar_comun_sistema" ' +
							'data-id_eliminar_valor="'+response.data.id_insert+'"><i class="fa fa-trash"></i></button>' +
							'</div>' +
							'';
						$(contenedor_destino).append(html_documento);
						$(input_url).val('');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		}else{
			Comun.mensaje_operacion("El URL es requerido o es un link no válido",'error');
		}
	});

	$(document).on('click','.btn_paso_anterior_pasos',function(){
		var anterior_link = $(this).data('anterior_link');
		$(anterior_link).trigger('click');
	});

	$(document).on('click','.eliminar-archivo-alumno',function(){
		var id_archivo_instrumento = $(this).data('id_archivo_instrumento');
		var id_entregable_alumno_archivo = $(this).data('id_entregable_alumno_archivo');
		var id_entregable = $(this).data('id_entregable');
		CandidatoEC.eliminarArchivo(id_archivo_instrumento,id_entregable_alumno_archivo,id_entregable)
	})
	$(document).on('click','.boton-enviar-entregable',function(){
		var id_entregable = $(this).data('id_entregable');
		var id_entregable_formulario = $(this).data('id_entregable_formulario');
		CandidatoEC.cambiar_estatus_entregable_alumno(id_entregable,2, id_entregable_formulario)
	})

	if(!window.location.pathname.includes('/estandar_competencia')){
		CandidatoEC.pasos.derechos_obligaciones();
		$('a#menu_bars').trigger('click');
		//validamos en que paso se encuentra el usuario
		var progreso_pasos = parseInt($('#input_pregreso_pasos').val());
		switch (progreso_pasos){
			case 1: $('#tab_evaluacion_diagnostica-tab').trigger('click'); break;
			case 2: $('#tab_evaluacion_requerimientos-tab').trigger('click'); break;
			case 3: $('#tab_modulo_capacitacion-tab').trigger('click'); break;
			case 4: $('#tab_evidencias-tab').trigger('click');break;
			case 5: $('#tab_jucio_competencia-tab').trigger('click');break;
			case 6: $('#tab_certificado-tab').trigger('click');break;
			case 7: $('#tab_encuesta_satisfaccion-tab').trigger('click');break;
		}
		setTimeout(function(){
			CandidatoEC.pasos.modal_informacion();
		},1000);
	}

});

var CandidatoEC = {

	ver_entregables_ati : function(id_estandar_competencia,id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'AlumnosEC/evidencia_ati/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				Comun.funcion_fileinput('.doc_evidencia_ati_alumno','Evidencia PDF/Imágenes');
				Comun.mostrar_ocultar_modal('#modal_cargar_evidencia_ati_alumno',true);
				CandidatoEC.inicializar_input_file_entregables();
			}
		);
	},

	guardar_comentario : function(id_body_comentarios,id_entregable, comentario){
		var id_usuario_alumno = $('#input_id_usuario_alumno').val();
		Comun.obtener_contenido_peticion_json(
			base_url + 'EvaluadoresEC/guardar_comentario',
			{
				comentario : comentario,
				id_entregable : id_entregable,
				id_usuario_alumno : id_usuario_alumno,
				quien : 'alumno'
			},
			function(response){
				if(response.success){
					var html_row_comentario = '' +
						'<tr>' +
						'	<td>Candidato</td>' +
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

	procesar_ATI : function(boton){
		var id_ec_instrumento_alumno = boton.data('id_ec_instrumento_alumno');
		var id_cat_proceso = 2;
		var label_estatus = 'Evidencia enviada';
		var label_class = 'badge-primary';
		var contenedor = boton.closest('div.contenedor_evidencia_alumno');
		var is_cuestionario = boton.data('is_cuestionario') != undefined && boton.data('is_cuestionario') == 'si' ? true : false;
		if(contenedor.find('a.archivo_doc_evidencia_ati').length != 0 || is_cuestionario){
			Comun.obtener_contenido_peticion_json(
				base_url + 'EvaluadoresEC/actualizar_ati/' + id_ec_instrumento_alumno,
				{id_cat_proceso : id_cat_proceso},
				function(response){
					if(response.success){
						contenedor.find('textarea').closest('div.row').remove();
						contenedor.find('button.btn_actualizar_ec_instrumento_alumno_proceso').remove();
						contenedor.find('input#doc_evidencia_ati_'+id_ec_instrumento_alumno).closest('div.contenedor_file_input_pdf').remove();
						contenedor.find('span.evidencia_alumno_ati_span').html(label_estatus).removeClass('badge-info').addClass(label_class);
						$('#evaluacion_cuestionario_'+id_ec_instrumento_alumno).remove();
						Comun.mensajes_operacion(response.msg,'success');
						Comun.ocultar_tooltips();
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				},'post'
			);
		}else{
			Comun.mensaje_operacion('Para continuar, es necesario que adjunte por lo menos una evidendia PDF/Imágen/URL de video','error',5000);
		}
	},

	inicializar_input_file_entregables : function(){
		$.each($('.doc_evidencia_ati_alumno'),function(index,input){
			CandidatoEC.iniciar_carga_doc_evidencia_old('#'+input.id);
		});
	},

	iniciar_carga_doc_evidencia_old : function(input_file,div_procesando,id){
		CandidatoEC.iniciar_carga_archivos_ati(input_file,function(archivo,id_entregable,div_procesando){
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			Comun.obtener_contenido_peticion_json(
				base_url + 'AlumnosEC/actualizar_ati/'+id_entregable+'/'+id_usuario_alumno,
				{
					id_archivo_instrumento : archivo.id_archivo_instrumento
				},
				function(response){
					if(response.success){
						Comun.mensajes_operacion(response.msg,'success');
						var html_documento = '<tr>' +
							'<td>'+archivo.id_archivo_instrumento+'</td>' +
							'<td>'+archivo.nombre+'</td>' +
							'<td>' +
							'<button class="btn btn-sm btn-danger  eliminar-archivo-alumno"' +
							'data-id_archivo_instrumento="'+archivo.id_archivo_instrumento+'"' +
							'data-id_entregable="'+response.data.id_entregable+'"' +
							'data-id_entregable_alumno_archivo="'+response.data.id_insert+'"' +
							'><em class="fa fa-trash"></em>' +
							'</button>' +
							'</td>' +
							'</tr>';
						$('#tabla_evidencias_'+id_entregable).append(html_documento);
						$(div_procesando).hide();
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		},id);
	},


	ver_evaluaciones_ec : function(id_estandar_competencia,id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/resultados_evaluacion_usuario/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				$('.span_calificacion_evidencia').each(function(){
					var calificacion = $(this).data('calificacion');
					$(this).addClass(CandidatoEC.obtener_class_calificacion(calificacion));
				});
				$('input.calificacion_alta').each(function () {
					var id_index = $(this).data('id_index');
					var calificacion_alta = $(this).val();
					$('span#span_calificacion_alta_'+id_index).html(calificacion_alta).addClass(CandidatoEC.obtener_class_calificacion(calificacion_alta));
				});
				Comun.mostrar_ocultar_modal('#modal_evidencia_evaluacion',true);
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
				CandidatoEC.procesar_class_calificacion();
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

	expediente_digital : function(id_estandar_competencia,id_usuario_alumno){
		Comun.obtener_contenido_peticion_html(
			base_url + 'AlumnosEC/expediente_digital/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_expediente_digital_candidato',true);
			},'post'
		);
	},

	iniciar_carga_archivos_ati : function(input_file,funcion_response){
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var div_procesando = $(input_file).data('div_procesando');
		var id_entregable = $(input_file).data('id_entregable');
		$(input_file).fileupload({
			url : base_url + 'Uploads/uploadFileATICandidato',
			dataType: 'json',
			start: function (e,data) {
				$('#contenedor_archivo_link_instrumentos_act').fadeIn();
				$('#archivo_link_instrumento_act').html(overlay);
			},
			//tiempo de ejecucion
			add: function (e,data) {
				nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
				data.formData = {
					filename : nombre_archivo
				};
				var goUpload = true;
				var uploadFile = data.files[0];
				var regExp = "\.(" + extenciones_files_ati + ")$";
				regExp = new RegExp(regExp);
				if(!regExp.test(uploadFile.name.toLowerCase())){
					Comun.mensaje_operacion('Archivo no es admitido o no es válido','error');
					goUpload = false;
					$(div_procesando).html('');
				}if(uploadFile.size > 15000000){
					Comun.mensaje_operacion('El archivo que intenta subir es mayor a 5 Mb','error');
					goUpload = false;
					$(div_procesando).html('');
				}if(goUpload){
					data.submit();
				}
			},
			done:function (e,data) {
				if(data.result.success){
					var archivo = data.result.archivo;
					funcion_response(archivo,id_entregable);
				}else{
					Comun.mensaje_operacion(data.result.msg,'error');
					$(div_procesando).html('');
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Comun.mensaje_operacion('Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','error');
			}
		});
	},

	guardar_progreso_paso : function(id_usuario_has_ec,paso,siguiente_link){
		Comun.obtener_contenido_peticion_json(
			base_url + 'AlumnosEC/guardar_progreso_pasos/'+id_usuario_has_ec+'/'+paso,{},
			function(response){
				if(!response.success){
					Comun.mensajes_operacion(response.msg,'error');
				}else{
					//habilitamos el siguiente link correspondiente
					$(siguiente_link).removeClass('disabled').addClass('text-green').trigger('click');
				}
			}
		);
	},

	eliminarArchivo(id_archivo_instrumento, id_entregable_alumno_archivo, id_entregable){
		Comun.obtener_contenido_peticion_json(base_url +'Entregable/eliminar_archivo/'+id_archivo_instrumento+'/'+ id_entregable_alumno_archivo,{},function (response) {

			if (response.success){
				var trs = '';
				response.data.forEach(item => {
					trs = trs + '<tr>' +
						'<td>'+item.id_archivo_instrumento+'</td>' +
						'<td>'+item.nombre+'</td>' +
						'<td>' +
						'<button class="btn btn-sm btn-danger  eliminar-archivo-alumno"' +
						'data-id_archivo_instrumento="'+item.id_archivo_instrumento+'"' +
						'data-id_entregable="'+id_entregable+'"' +
						'data-id_entregable_alumno_archivo="'+item.id_entregable_alumno_archivo+'"' +
						'><em class="fa fa-trash"></em>' +
						'</button>' +
						'</td>' +
						'</tr>'
				} )
				$('#tabla_evidencias_'+id_entregable).html(trs);
			}

		})
	},
	cambiar_estatus_entregable_alumno(id_entregable, id_estatus, id_entregable_formulario = null){
		var id_usuario_alumno = $('#input_id_usuario_alumno').val();
		Comun.obtener_contenido_peticion_json(base_url +'Entregable/cambiar_estatus/'+id_entregable+'/'+ id_estatus+'/'+id_usuario_alumno+'/'+id_entregable_formulario,{},function (response) {
			if (response.success) {
				Comun.mensajes_operacion( ['Evidencia enviada al evaluador'], 'success');
				CandidatoEC.pasos.evidencias();
			}else {
				Comun.mensajes_operacion(response.msg, 'error');
			}
		})
	},

	pasos : {
		modal_informacion : function(){
			//mostraremos los datos de las modales siempre y cuando se encuentren los datos validos
			if(ValidacionDatos.datos_validos){
				var id_estandar_competencia = $('#input_id_estandar_competencia').val();
				//cargar la modal de informacion para la ficha de registro
				Comun.obtener_contenido_peticion_json(
					base_url + 'AlumnosEC/ficha_carta_compromiso/' + id_estandar_competencia,{},
					function(response){
						if(response.success && response.data.mostrar_modal){
							$('#contenedor_modal_primario').html(response.data.html_ficha_carta_compromiso);
							Comun.mostrar_ocultar_modal('#modal_ficha_carta_compromiso_candidato',true);
						}
					}
				);
			}
		},

		evaluacion_diagnostica : function (){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			$('#contenedor_eva_diagnostica').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'AlumnosEC/ver_progreso_evaluacion_diagnostica/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
				function(response){
					$('#contenedor_eva_diagnostica').html(response);
					$('.span_calificacion_evidencia').each(function(){
						var calificacion = $(this).data('calificacion');
						$(this).addClass(CandidatoEC.obtener_class_calificacion(calificacion));
					});
					$('input.calificacion_alta').each(function () {
						var id_index = $(this).data('id_index');
						var calificacion_alta = $(this).val();
						$('span#span_calificacion_alta_'+id_index).html(calificacion_alta).addClass(CandidatoEC.obtener_class_calificacion(calificacion_alta));
					});
				}
			)
		},

		derechos_obligaciones : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			if($('#tab_derechos_obligaciones').html() == ''){
				$('#tab_derechos_obligaciones').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_derechos_obligaciones/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
					function(response){
						$('#tab_derechos_obligaciones').html(response);
					}
				)
			}
		},

		evaluacion_requerimientos : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			var id_usuario_evaluador = $('#input_id_usuario_evaluador').val();
			if($('#tab_evaluacion_requerimientos').html() == ''){
				$('#tab_evaluacion_requerimientos').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_evaluacion_requerimientos/' + id_estandar_competencia + '/' + id_usuario_alumno + '/' + id_usuario_evaluador,{},
					function(response){
						$('#tab_evaluacion_requerimientos').html(response);
					}
				)
			}
		},

		modulo_capacitacion : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			var id_usuario_evaluador = $('#input_id_usuario_evaluador').val();
			if($('#tab_modulo_capacitacion').html() == ''){
				$('#tab_modulo_capacitacion').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_modulos_capacitacion/' + id_estandar_competencia + '/' + id_usuario_alumno + '/' + id_usuario_evaluador,{},
					function(response){
						$('#tab_modulo_capacitacion').html(response);
					}
				)
			}
		},

		evidencias : function (){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			//if($('#contenedor_pasos_evidencias').html() == ''){
				$('#contenedor_pasos_evidencias').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'Entregable/index_candidato/' + id_estandar_competencia+'/'+id_usuario_alumno,{},
					function(response){
						$('#contenedor_pasos_evidencias').html(response);
						Comun.funcion_fileinput('.doc_evidencia_ati_alumno','Subir Evidencia');
						CandidatoEC.inicializar_input_file_entregables();
						CandidatoEC.procesar_class_calificacion();

						if($('#numero_actividades').val() != 0 && ($('#numero_actividades').val() == $('#numero_actividades_finalizadas').val())){
							$('#contenedor_pasos_evidencias').find('button.guardar_progreso_pasos').removeAttr('disabled');
						}
						Comun.tooltips();
					}
				);
			//}
		},



		juicio_competencia : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			var id_usuario_evaluador = $('#input_id_usuario_evaluador').val();
			if($('#contenedor_pasos_juicio_competencia').html() == ''){
				$('#contenedor_pasos_juicio_competencia').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_juicio_evaluacion/' + id_estandar_competencia + '/' + id_usuario_alumno + '/' + id_usuario_evaluador,{},
					function(response){
						$('#contenedor_pasos_juicio_competencia').html(response);
					}
				);
			}
		},

		certificado_ec : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			var id_usuario_evaluador = $('#input_id_usuario_evaluador').val();
			if($('#contenedor_pasos_certificados').html() == ''){
				$('#contenedor_pasos_certificados').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_certificado_ec/' + id_estandar_competencia + '/' + id_usuario_alumno + '/' + id_usuario_evaluador,{},
					function(response){
						$('#contenedor_pasos_certificados').html(response);
					}
				);
			}
		},

		encuesta_satisfaccion : function(){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			if($('#contenedor_pasos_encuesta_satisfacion').html() == ''){
				$('#contenedor_pasos_encuesta_satisfacion').html(overlay);
				Comun.obtener_contenido_peticion_html(
					base_url + 'AlumnosEC/ver_progreso_encuesta_satisfaccion/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
					function(response){
						$('#contenedor_pasos_encuesta_satisfacion').html(response);
					}
				);
			}
		},

		expediente_digital : function (){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			var id_usuario_alumno = $('#input_id_usuario_alumno').val();
			$('#contenedor_pasos_expediente_digital').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'AlumnosEC/ver_progreso_expediente_digital/' + id_estandar_competencia + '/' + id_usuario_alumno,{},
				function(response){
					$('#contenedor_pasos_expediente_digital').html(response);
				}
			)
		}
	}

};

var stepper;
