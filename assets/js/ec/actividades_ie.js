$(document).ready(function(){

	$(document).on('click','#btn_buscar_estandar_competencia_ati',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		ActividadesTecnicasInstrumentos.cargar_ati(id_estandar_competencia);
	});

	$(document).on('click','#agregar_estandar_competencia_ati',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		ActividadesTecnicasInstrumentos.agregar_modificar_ec_ati(id_estandar_competencia);
	});

	$(document).on('click','#btn_guardar_form_ec_ati',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		ActividadesTecnicasInstrumentos.guardar_form_ati(id_estandar_competencia);
	});

	/*$(document).on('change','#cat_instrumento',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_cat_instrumento = $(this).val();
		ActividadesTecnicasInstrumentos.opciones_instrumento_actividad();
		if(id_cat_instrumento != ''){
			ActividadesTecnicasInstrumentos.actividades_de_instrumentos(id_estandar_competencia,id_cat_instrumento);
		}
	});*/

	$(document).on('click','.btn_nueva_actividad_instrumento',function(){
		setTimeout(function(){
			ActividadesTecnicasInstrumentos.opciones_instrumento_actividad();
		},100);
	});

	$(document).on('click','.modificar_estandar_competencia_ati',function(){
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		var id_ec_instrumento_has_actividad = $(this).data('id_ec_instrumento_has_actividad');
		ActividadesTecnicasInstrumentos.agregar_modificar_ec_ati(id_estandar_competencia,id_ec_instrumento_has_actividad);
	});

	$(document).on('click','#btn_cancelar_form_ati',function(){
		$('#card_formulario_ati').fadeOut();
		$('#card_resultados_ati').fadeIn();
	});

	$(document).on('click','#btn_agregar_video_ati',function(){
		var string_url = $("#input_url_video").val();
		if(string_url != "" && Comun.validar_url(string_url)){
			var video = '<li style="list-style: none">' +
				'<input type="hidden" name="archivo_video[][url_video]" value="'+string_url+'">' +
				'<a href="'+string_url+'" class="btn btn-sm btn-outline-success mb-1" target="_blank"><i class="fa fa-eye"></i> '+string_url+'</a>' +
				'<button type="button" class="btn btn-sm btn-outline-danger eliminar_archivo_video_instrumento" data-toggle="tooltip" title="Eliminar archivo/video"><i class="fa fa-trash"></i></button>' +
				'</li>';
			$('#destino_files_ati').append(video);
			$("#input_url_video").val('')
		}else{
			Comun.mensaje_operacion("El URL es requerido o es un link no válido",'error');
		}
	});

	$(document).on('click','.eliminar_archivo_video_instrumento',function(){
		$(this).closest('li').remove();
	});

	ActividadesTecnicasInstrumentos.iniciar_ati();
});

var ActividadesTecnicasInstrumentos = {

	iniciar_ati : function(){
		$('#btn_buscar_estandar_competencia_ati').trigger('click');
	},

	cargar_ati : function(id_estandar_competencia){
		$('#contenedor_resultados_estandar_competencia_ati').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url + 'TecnicasInstrumentos/resultado_ati/' + id_estandar_competencia,{},
			function(response){
				$('#contenedor_resultados_estandar_competencia_ati').html(response);
				Comun.tooltips();
			}
		);
	},

	actividades_de_instrumentos : function(id_estandar_competencia,id_cat_instrumento){
		Comun.obtener_contenido_peticion_json(
			base_url + 'TecnicasInstrumentos/resultado_actividades_de_instrumento/' + id_estandar_competencia + '/' + id_cat_instrumento,{},
			function(response){
				if(response.success){
					if(response.ec_instrumento_has_actividad != undefined && response.ec_instrumento_has_actividad.length != 0){
						var msg = '<div class="callout callout-warning"><h5>Aviso importante: </h5><p>Este instrumento ya esta dado de alta en la EC, se cargara la información previamente guardada para su actualización</p></div>';
						$('#msg_form_ec_ati').html(msg);
					}else{
						$('#msg_form_ec_ati').html('');
					}
					ActividadesTecnicasInstrumentos.obtener_rows_actividades(response.ec_instrumento_has_actividad);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		);
	},

	agregar_modificar_ec_ati : function(id_estandar_competencia,id_ec_instrumento_has_actividad = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'TecnicasInstrumentos/agregar_modificar_ati/'+id_estandar_competencia + '/' + id_ec_instrumento_has_actividad,{},
			function(response){
				$('#contenedor_modal_instrumento').html(response);
				// $('#card_formulario_ati').fadeIn();
				// $('#card_resultados_ati').fadeOut();
				Comun.mostrar_ocultar_modal('#modal_form_instrumento',true);
				Comun.tooltips();
			});
	},

	validar_form_ati : function(){
		var form_valido = Comun.validar_form('#form_agregar_modificar_ec_ati',Comun.reglas_validacion_form());
		if(form_valido){
			/*let actividades = $('#tbody_destino_actividades').find('tr');
			if(actividades.length == 0){
				form_valido = false;
				Comun.mensaje_operacion('Error, debe ingresar por lo menos una actividad del instrumento','error');
			}*/
		}
		return form_valido;
	},

	guardar_form_ati : function(id_estandar_competencia){
		if(ActividadesTecnicasInstrumentos.validar_form_ati()){
			Comun.enviar_formulario_post(
				'#form_agregar_modificar_ec_ati',
				base_url + 'TecnicasInstrumentos/guardar_ati/' + id_estandar_competencia,
				function(response){
					if(response.success){
						$('#card_formulario_ati').fadeOut();
						$('#card_resultados_ati').fadeIn();
						$('#form_agregar_modificar_ec_ati').trigger('reset');
						Comun.mensajes_operacion(response.msg,'success');
						ActividadesTecnicasInstrumentos.iniciar_ati();
					}else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			);
		}
	},

	opciones_instrumento_actividad : function(){
		var id_cat_instrumento = $('#cat_instrumento').val();
		$('option.actividad_instrumento').hide();
		$('option.actividad_instrumento_'+id_cat_instrumento).show();
		//del ultimo row
		var ultimo_row = $('#tbody_destino_actividades tr').last();
		var input_file = ultimo_row.find('.files_ati');
		var id_manipulador = input_file.data('identificador');
		Comun.iniciar_editor_summernote('#det_instrucciones_'+id_manipulador,'Intrucciones de la actividad');
		Comun.funcion_fileinput('#'+input_file.attr('id'),'Subir Archivo');
		ActividadesTecnicasInstrumentos.iniciar_carga_archivos_ati(
		'#'+input_file.attr('id'),
		function(archivo,div_procesando,file_destino,identificador){
			//$('.img_foto_certificado').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
			var archivo = '<li>' +
				'<input type="hidden" name="actividades_ec['+identificador+'][][id_archivo]" value="'+archivo.id_archivo+'">' +
				'<a href="'+base_url + archivo.ruta_directorio + archivo.nombre+'" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i> Ver archivo</a>' +
				'</li>';
			$(div_procesando).html('');
			$(file_destino).append(archivo)
		});
},

	obtener_rows_actividades : function(array_actividades_instrumento){
		$('#tbody_destino_actividades').html('');
		$.each(array_actividades_instrumento,function(index, registro){
			var row_limpio = $('#new_row_actividad').html();
			row_limpio = row_limpio.replace("<!--","");
			row_limpio = row_limpio.replace("-->","");
			row_limpio = row_limpio.replace(/\{id}/g, registro.id_ec_instrumento_has_actividad); //replace("{id}",$.now());
			$('#tbody_destino_actividades').append(row_limpio);
			Comun.funcion_fileinput('#files_ati_'+registro.id_ec_instrumento_has_actividad,'Subir Archivo');
			ActividadesTecnicasInstrumentos.iniciar_carga_archivos_ati(
			'#files_ati_'+registro.id_ec_instrumento_has_actividad,
			function(archivo,div_procesando,file_destino,identificador){
				//$('.img_foto_certificado').attr('src',base_url + archivo.ruta_directorio + archivo.nombre);
				var archivo = '<li>' +
					'<input type="hidden" name="actividades_ec['+identificador+'][][id_archivo]" value="'+archivo.id_archivo+'">' +
					'<a href="'+base_url + archivo.ruta_directorio + archivo.nombre+'" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-eye"></i> Ver archivo</a>' +
					'</li>';
				$(div_procesando).html('');
				$(file_destino).append(archivo)
			});
			$('#det_actividad_'+registro.id_ec_instrumento_has_actividad).val(registro.actividad);
		});
		ActividadesTecnicasInstrumentos.opciones_instrumento_actividad();
	},

	iniciar_carga_archivos_ati : function(input_file,funcion_response){
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var div_procesando = $(input_file).data('div_procesando');
		var file_destino = $(input_file).data('file_destino');
		var identificador = $(input_file).data('identificador');
		$(input_file).fileupload({
			url : base_url + 'Uploads/uploadFileATI',
			dataType: 'json',
			start: function (e,data) {
				$(div_procesando).html(overlay);
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
					funcion_response(archivo,div_procesando,file_destino,identificador);
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

};
