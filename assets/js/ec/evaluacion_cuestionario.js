$(document).ready(function(){

	$(document).on('click','#btn_buscar_ec_evaluacion_cuestionario',function(){
		CuestionarioATI.obtener_evaluaciones();
	});

	$(document).on('click','#agregar_evaluacion_ec',function(){
		CuestionarioATI.agregar_modificar_evaluacion_ec();
	});

	$(document).on('click','.modificar_evaluacion_ec',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		CuestionarioATI.agregar_modificar_evaluacion_ec(id_evaluacion);
	});

	$(document).on('click','#btn_guardar_form_evaluacion_ec',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		CuestionarioATI.guardar_form_evaluacion_ec(id_evaluacion);
	});

	$(document).on('change','#cat_evaluacion',function () {
		var id_cat_evaluacion = $(this).val();
		CuestionarioATI.obtener_ec_evaluacion(id_cat_evaluacion);
	});

	$(document).on('click','.agregar_pregunta_evaluacion',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		CuestionarioATI.agregar_pregunta_evaluacion_ec(id_evaluacion);
	});

	$(document).on('click','.modificar_pregunta_evaluacion',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		var id_banco_pregunta = $(this).data('id_banco_pregunta');
		CuestionarioATI.agregar_pregunta_evaluacion_ec(id_evaluacion,id_banco_pregunta);
	});

	$(document).on('change','#slt_opcion_pregunta_form',function(){
		var id_cat_tipo_opciones_pregunta = $(this).val();
		CuestionarioATI.cargar_complemento_opciones_pregunta(id_cat_tipo_opciones_pregunta);
	});

	$(document).on('click','.buscar_preguntas_evaluacion',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		CuestionarioATI.obtener_preguntas_evaluacion(id_evaluacion);
	});

	$(document).on('click','#guardar_preguntas_evaluacion_ec',function(){
		var id_evaluacion = $(this).data('id_evaluacion');
		var id_banco_pregunta = $(this).data('id_banco_pregunta');
		CuestionarioATI.guardar_form_registro_pregunta_opciones(id_evaluacion,id_banco_pregunta);
	});

	$(document).on('click','#agregar_opcion_pregunta_img_uo',function(){
		setTimeout(function(){
			Comun.funcion_fileinput('.img_foto_opcion_pregunta_uo','');
			CuestionarioATI.iniciar_carga_imagen_pregunta_uo();
		},100);
	});

	$(document).on('click','.actualizar_rows_respuestas_preguntas_relacionales',function(e){
		e.preventDefault();
		CuestionarioATI.actualizar_secuenciales_preguntas_relaciones();
	});

	CuestionarioATI.obtener_evaluaciones();

});

var CuestionarioATI = {

	evaluaciones : [],

	complemento_opciones_pregunta : [],

	obtener_evaluaciones : function(){
		var id_ec_instrumento_has_actividad = $('#input_id_ec_instrumento_has_actividad').val();
		$('#contenedor_resultados_ec_evaluacion').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/resultado_cuestionario_ati/' + id_ec_instrumento_has_actividad,{},
			function(response){
				$('#contenedor_resultados_ec_evaluacion_cuestionario').html(response);
				if($('#btn_sin_modificar_evaluacion').length != 0){
					var id_evaluacion = $('#btn_sin_modificar_evaluacion').val();
					$('#btn_editar_evaluacion_'+id_evaluacion).trigger('click');
					Comun.mensaje_operacion('Detectamos que no ha modificado el formulario de la evaluación, le pedimos lo revise conforme a las necesidades del cuestionario','error',5000);
				}
				Comun.tooltips();
				$('.buscar_preguntas_evaluacion').trigger('click');
			}
		);
	},

	obtener_preguntas_evaluacion : function(id_evaluacion){
		$('#contenedor_preguntas_evaluacion_'+id_evaluacion).html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/preguntas_evaluacion_cuestionario/' + id_evaluacion,{},
			function(response){
				$('#contenedor_preguntas_evaluacion_'+id_evaluacion).html(response);
				Comun.tooltips();
				$('.popoverShowImage').trigger('click');
			}
		);
	},

	agregar_modificar_evaluacion_ec : function(id_evaluacion = ''){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/agregar_modificar_ec/cuestionario/' + id_evaluacion,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_ec_evaluacion',true);
				if(id_evaluacion != '' && $('#descripcion_actividad').length != 0){
					$('#input_titulo').val($('#descripcion_actividad').html());
				}
			}
		);
	},

	validar_form_evaluacion_ec : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_evaluacion_ec',Comun.reglas_validacion_form());
		return form_valido;
	},

	guardar_form_evaluacion_ec : function(id_evaluacion = ''){
		if(CuestionarioATI.validar_form_evaluacion_ec()){
			var id_estandar_competencia = $('#input_id_estandar_competencia').val();
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_evaluacion_ec',
				base_url + 'EvaluacionEC/guardar_evaluacion_ec/' + id_estandar_competencia + '/' + id_evaluacion,
				function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_ec_evaluacion',false);
						Comun.mensajes_operacion(response.msg,'success');
						CuestionarioATI.obtener_evaluaciones();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, Hay campos requeridos en el formulario','error');
		}
	},

	obtener_ec_evaluacion : function(id_cat_evaluacion){
		if(id_cat_evaluacion == ''){
			CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'vacio','');
		}else{
			var msg = '<div class="callout callout-warning"><h5>Aviso importante: </h5><p>se detecto que ya existe una evaluación de este tipo, se cargaran los datos guardados previamente y podrá actualizarlos (si la evaluación se encontraba eliminada, se reactivará nuevamente)</p></div>';
			if(CuestionarioATI.evaluaciones[id_cat_evaluacion] == undefined){
				var id_estandar_competencia = $('#input_id_estandar_competencia').val();
				Comun.obtener_contenido_peticion_json(
					base_url + 'EvaluacionEC/obtener_ec_evaluacion/' + id_estandar_competencia + '/' + id_cat_evaluacion,{},
					function(response){
						if(response.success){
							if(response.data != undefined && response.data != false){
								CuestionarioATI.evaluaciones[id_cat_evaluacion] = response.data;
								if(CuestionarioATI.evaluaciones[id_cat_evaluacion].liberada == 'si'){
									msg = '<div class="callout callout-success"><h5>Aviso importante: </h5><p>se detecto que ya existe una evaluación de este tipo y que se libero a los candidatos, por tanto no podrá editarse</p></div>'
									CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'lectura',msg);
								}else{
									CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'editable',msg);
								}
							}else{
								CuestionarioATI.evaluaciones[id_cat_evaluacion] = false;
								CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'vacio','');
							}
						}else{
							Comun.mensajes_operacion(response.msg,'error',5000);
						}
					}
				);
			}else{
				if(CuestionarioATI.evaluaciones[id_cat_evaluacion] != false){
					if(CuestionarioATI.evaluaciones[id_cat_evaluacion].liberada == 'si'){
						msg = '<div class="callout callout-success"><h5>Aviso importante: </h5><p>se detecto que ya existe una evaluación de este tipo y que se libero a los candidatos, por tanto no podrá editarse</p></div>'
						CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'lectura',msg);
					}else{
						CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'editable',msg);
					}
				}else{
					CuestionarioATI.procesar_formulario_contenido(id_cat_evaluacion,'vacio','');
				}
			}
		}
	},

	procesar_formulario_contenido : function(id_cat_evaluacion,tipo,msg){
		switch (tipo) {
			case 'vacio':
				$('#contenedor_msg_ec_evaluacion').html(msg);
				$('#input_titulo').removeAttr('disabled').val('');
				$('#input_tiempo').removeAttr('disabled').val('');
				$('#input_intentos').removeAttr('disabled').val('');
				$('#btn_guardar_form_evaluacion_ec').fadeIn().attr('data-id_evaluacion','');
				break;
			case 'editable':
				$('#contenedor_msg_ec_evaluacion').html(msg);
				$('#input_titulo').removeAttr('disabled').val(CuestionarioATI.evaluaciones[id_cat_evaluacion].titulo);
				$('#input_tiempo').removeAttr('disabled').val(CuestionarioATI.evaluaciones[id_cat_evaluacion].tiempo);
				$('#input_intentos').removeAttr('disabled').val(CuestionarioATI.evaluaciones[id_cat_evaluacion].intentos);
				$('#btn_guardar_form_evaluacion_ec').fadeIn().attr('data-id_evaluacion',CuestionarioATI.evaluaciones[id_cat_evaluacion].id_evaluacion);
				break;
			case 'lectura':
				$('#contenedor_msg_ec_evaluacion').html(msg);
				$('#input_titulo').attr('disabled',true).val(CuestionarioATI.evaluaciones[id_cat_evaluacion].titulo);
				$('#input_tiempo').attr('disabled',true).val(CuestionarioATI.evaluaciones[id_cat_evaluacion].tiempo);
				$('#input_intentos').attr('disabled',true).val(CuestionarioATI.evaluaciones[id_cat_evaluacion].intentos);
				$('#btn_guardar_form_evaluacion_ec').fadeOut().attr('data-id_evaluacion',CuestionarioATI.evaluaciones[id_cat_evaluacion].id_evaluacion);
				break;
		}
	},

	agregar_pregunta_evaluacion_ec : function(id_evaluacion,id_banco_pregunta = ''){
		Comun.obtener_contenido_peticion_html(
			base_url + 'EvaluacionEC/agregar_pregunta/' + id_evaluacion + '/' + id_banco_pregunta,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.tooltips();
				Comun.mostrar_ocultar_modal('#modal_form_evaluacion_pregunta',true);
				Comun.funcion_fileinput('.img_foto_opcion_pregunta_uo','');
				CuestionarioATI.iniciar_carga_imagen_pregunta_uo();
			}
		);
	},

	cargar_complemento_opciones_pregunta : function(id_cat_tipo_opciones_pregunta){
		if(CuestionarioATI.complemento_opciones_pregunta[id_cat_tipo_opciones_pregunta] == undefined){
			$('#destino_registro_opciones_pregunta_complemento').html(overlay);
			if(id_cat_tipo_opciones_pregunta != ''){
				Comun.obtener_contenido_peticion_html(
					base_url + 'EvaluacionEC/complemento_pregunta_opciones/' + id_cat_tipo_opciones_pregunta,{},
					function(response){
						//CuestionarioATI.complemento_opciones_pregunta[id_cat_tipo_opciones_pregunta] = response;
						$('#destino_registro_opciones_pregunta_complemento').html(response);
						if(id_cat_tipo_opciones_pregunta == 7){
							$('#modal_tamanio_preguntas_evaluacion').removeClass('modal-lg');
							$('#modal_tamanio_preguntas_evaluacion').addClass('modal-xl');
						}else{
							$('#modal_tamanio_preguntas_evaluacion').addClass('modal-lg');
							$('#modal_tamanio_preguntas_evaluacion').removeClass('modal-xl');
						}
						Comun.funcion_fileinput('.img_foto_opcion_pregunta_uo','');
						CuestionarioATI.iniciar_carga_imagen_pregunta_uo();
					}
				);
			}else{
				$('#destino_registro_opciones_pregunta_complemento').html('');
				Comun.mensaje_operacion('Seleccione un tipo de pregunta para continuar','confirmed')
			}
		}else{
			$('#destino_registro_opciones_pregunta_complemento').html(CuestionarioATI.complemento_opciones_pregunta[id_cat_tipo_opciones_pregunta]);
			if(id_cat_tipo_opciones_pregunta == 7){
				$('#modal_tamanio_preguntas_evaluacion').removeClass('modal-lg');
				$('#modal_tamanio_preguntas_evaluacion').addClass('modal-xl');
			}else{
				$('#modal_tamanio_preguntas_evaluacion').addClass('modal-lg');
				$('#modal_tamanio_preguntas_evaluacion').removeClass('modal-xl');
			}
			Comun.funcion_fileinput('.img_foto_opcion_pregunta_uo','');
			Comun.funcion_fileinput('.img_foto_opcion_pregunta_uo','');
			CuestionarioATI.iniciar_carga_imagen_pregunta_uo();
		}
	},

	validar_form_registro_pregunta_opciones : function (){
		$('.error').remove();
		var msg_error = [];
		var form_valido = Comun.validar_form('#form_guardar_pregunta_evaluacion',Comun.reglas_validacion_form());
		var form = $('#form_guardar_pregunta_evaluacion');
		var count_respuestas_incorrectas = 0;
		var count_respuestas_correctas = 0;
		var num_rows_preguntas = 0;
		var num_imegenes_pregunta = 0;
		if(form_valido){
			if($('#tbody_opciones_pregunta').find('tr').length == 0){
				form_valido = false;
				msg_error.push('Para continuar, es necesario que registre respuestas a la pregunta');
			}else{
				//apartado de validaciones secundarias a las validaciones general
				var slt_opcion_pregunta_form_val = parseInt($('#slt_opcion_pregunta_form').val());
				switch (slt_opcion_pregunta_form_val) {
					case 1:
						count_respuestas_incorrectas = form.find('input.radio_verdadero_incorrecta:checked').length;
						if(count_respuestas_incorrectas != 1){
							form_valido = false;
							msg_error.push('Solo es posible tener una respuesta correcta y una incorrecta');
						}
						break;
					case 2: case 4:
						count_respuestas_correctas = form.find('input.radio_verdadero_correcta:checked').length;
						count_respuestas_incorrectas = form.find('input.radio_verdadero_incorrecta:checked').length;
						if(count_respuestas_correctas != 1 || count_respuestas_correctas == 0){
							form_valido = false;
							msg_error.push('Es necesario que registre una respuesta como correcta');
						}if(count_respuestas_incorrectas == 0){
							form_valido = false;
							msg_error.push('Es necesario que registre por lo menos una respuesta incorrecta');
						}
						if(slt_opcion_pregunta_form_val == 4){
							num_rows_preguntas = form.find('#tbody_opciones_pregunta tr').length;
							num_imegenes_pregunta = form.find('.image_opcion_pregunta').length;
							if(num_rows_preguntas != num_imegenes_pregunta){
								form_valido = false;
								msg_error.push('Debe registrar la imagen en cada una de las respuestas');
							}
						}
						break;
					case 3: case 5:
						count_respuestas_correctas = form.find('input.radio_verdadero_correcta:checked').length;
						count_respuestas_incorrectas = form.find('input.radio_verdadero_incorrecta:checked').length;
						if(count_respuestas_correctas < 2){
							form_valido = false;
							msg_error.push('Debe registrar por lo menos dos respuestas como correctas');
						}if(count_respuestas_incorrectas < 1){
							form_valido = false;
							msg_error.push('Debe registrar por lo menos una respuesta como incorrecta');
						}
						if(slt_opcion_pregunta_form_val == 5){
							num_rows_preguntas = form.find('#tbody_opciones_pregunta tr').length;
							num_imegenes_pregunta = form.find('.image_opcion_pregunta').length;
							if(num_rows_preguntas != num_imegenes_pregunta){
								form_valido = false;
								msg_error.push('Debe registrar la imagen en cada una de las respuestas');
							}
						}
						break;
					case 6: case 7:
						var array_consecutivo = new Array();
						var contador_consecutivos = [];
						var rows_preguntas = form.find('#tbody_opciones_pregunta tr');
						rows_preguntas.each(function () {
							var consecutivo = parseInt($(this).find('.consecutivo').val());
							contador_consecutivos[consecutivo] = 0;
							array_consecutivo.push(consecutivo);
						});
						//buscar algun consecutivo mayor al numero de respuestas
						var consecutivo_mayor = array_consecutivo.filter(v => v > rows_preguntas.length);
						if(consecutivo_mayor.length != 0){
							form_valido = false;
							msg_error.push('Existe una secuencia que es mayor al número de opciones');
						}else{
							rows_preguntas.each(function () {
								var consecutivo = parseInt($(this).find('.consecutivo').val());
								contador_consecutivos[consecutivo]++;
							});
							contador_consecutivos.forEach(function (value,index) {
								if(value > 1){
									form_valido = false;
									msg_error.push('La secuencia de la opción "'+index+'" se repite, favor de verificar');
								}
							})
						}
						break;
				}
			}
		}
		Comun.mensajes_operacion(msg_error,'error');
		return form_valido;
	},

	guardar_form_registro_pregunta_opciones : function(id_evaluacion,id_banco_pregunta = ''){
		if(CuestionarioATI.validar_form_registro_pregunta_opciones()){
			Comun.enviar_formulario_post('#form_guardar_pregunta_evaluacion',
				base_url + 'EvaluacionEC/guardar_pregunta_evaluacion/'+id_evaluacion + '/' + id_banco_pregunta,function(response){
					if(response.success){
						Comun.mostrar_ocultar_modal('#modal_form_evaluacion_pregunta',false);
						Comun.mensajes_operacion(response.msg,'success');
						$('#btn_buscar_pregunta_'+id_evaluacion).trigger('click');
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}
	},

	iniciar_carga_imagen_pregunta_uo : function () {
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var id_cat_expediente = 2;
		var destino_input_imagen = '';
		var destino_src_imagen = '';
		var destino_procesando_imagen = '';
		$('.img_foto_opcion_pregunta_uo').fileupload({
			url : base_url + 'Uploads/uploadFileComunImg',
			dataType: 'json',
			start: function (e,data) {
				//$(div_procesando).html(overlay);
			},
			//tiempo de ejecucion
			add: function (e,data) {
				destino_input_imagen = data.fileInput.data('destino_input_imagen');
				destino_src_imagen = data.fileInput.data('destino_src_imagen');
				destino_procesando_imagen = data.fileInput.data('destino_procesando_imagen');
				$(destino_procesando_imagen).html(overlay);
				nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
				data.formData = {
					filename : nombre_archivo
				};
				var goUpload = true;
				var uploadFile = data.files[0];
				var regExp = "\.(" + extenciones_files_img + ")$";
				regExp = new RegExp(regExp);
				if(!regExp.test(uploadFile.name.toLowerCase())){
					Comun.mensaje_operacion('Archivo no es admitido o no es válido','error');
					goUpload = false;
				}if(uploadFile.size > 15000000){
					Comun.mensaje_operacion('El archivo que intenta subir es mayor a 5 Mb','error');
					goUpload = false;
				}if(goUpload){
					data.submit();
				}
			},
			done:function (e,data) {
				if(data.result.success){
					var archivo = data.result.archivo;
					$(destino_input_imagen).val(archivo.id_archivo);
					$(destino_input_imagen).addClass('image_opcion_pregunta');
					$(destino_src_imagen).attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
					$(destino_procesando_imagen).html('');
				}else{
					Comun.mensaje_operacion(data.result.msg,'error');
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				Comun.mensaje_operacion('Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde','error');
			}
		});
	},

	actualizar_secuenciales_preguntas_relaciones : function(){
		var consecutivo = 1;
		$('#tbody_opciones_pregunta tr').each(function(){
			var row = $(this);
			row.find('input.consecutivo_derecho').val(consecutivo);
			row.find('span.consecutivo_derecho').html(consecutivo);
			consecutivo++;
		});
	},

};
