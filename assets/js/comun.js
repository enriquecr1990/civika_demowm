$(document).ready(function(){

	$(document).on('click','.ver_password',function(e){
		e.preventDefault();
		var id_password = $(this).data('id_password');
		if($(this).hasClass('no_password')){
			$(this).removeClass('no_password');
			$(this).addClass('si_password');
			$(this).find('i').removeClass('fa-eye');
			$(this).find('i').addClass('fa-eye-slash');
			$(id_password).attr('type','text')
		}else{
			$(this).removeClass('si_password');
			$(this).addClass('no_password');
			$(id_password).attr('type','password');
			$(this).find('i').addClass('fa-eye')
			$(this).find('i').removeClass('fa-eye-slash')
		}
	});

	$(document).on('click','.iniciar_confirmacion_operacion',function(e){
		e.preventDefault();
		var msg_confirmacion_general = $(this).data('msg_confirmacion_general');
		var url_confirmacion_general = $(this).data('url_confirmacion_general');
		var btn_trigger = $(this).data('btn_trigger');
		Comun.mostrar_mensaje_confirmacion_gral(msg_confirmacion_general,url_confirmacion_general,btn_trigger);
	});

	$(document).on('click','#btn_confirmar_operacion_general',function(e){
		e.preventDefault();
		var url_confirmacion = $('#url_confirmacion_general').val();
		var btn_trigger_success = $('#btn_trigger_success').val();
		Comun.obtener_contenido_peticion_json(
			url_confirmacion,{},
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_confirmacion_general',false);
					Comun.mensajes_operacion(response.msg,'success');
					$(btn_trigger_success).trigger('click');
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		);
	});

	$(document).on('click','.btn_iniciar_modificacion',function(e){
		e.preventDefault();
		Comun.campo_modificar_comun($(this),true);
	});

	$(document).on('click','.btn_cancelar_modificacion',function(e){
		e.preventDefault();
		Comun.campo_modificar_comun($(this),false);
	});

	$(document).on('click','.btn_guardar_modificacion',function(e){
		e.preventDefault();
		Comun.guardar_modificacion($(this));
	});

	$(document).on('change','.input_modificacion_update',function(e){
		//e.preventDefault();
		Comun.guardar_modificacion_input($(this));
	});

	$(document).on('click','.btn_eliminar_comun_sistema',function(e){
		Comun.eliminar_comun($(this));
	});

	$(document).on('click','.check_show_hide_componente',function(e){
		var value = $(this).val();
		var destino_show_hide = $(this).data('destino_show_hide');
		if(value == 'si'){
			$(destino_show_hide).fadeIn();
		}else{
			$(destino_show_hide).fadeOut();
		}
	});

	$(document).on('click','.slt_mostrar_ocultar',function(){
		let contenedor_detalle = $(this).data('contenedor_detalle');
		let input_detalle = $(this).data('input_detalle');
		let id_show = $(this).data('id_show');
		let val_slt = $(this).val();
		if(val_slt == id_show){
			$(contenedor_detalle).fadeIn();
		}else{
			$(input_detalle).val('');
			$(contenedor_detalle).fadeOut();
		}
	});

	$(document).on('click','.agregar_row_comun',function(){
		Comun.agregar_rows_tabla($(this));
	});

	$(document).on('click','.eliminar_registro_comun',function(){
		var row = $(this).closest('tr');
		row.remove();
	});

	$(document).on('change','.input_str_mayus',function () {
		Comun.str_mayus($(this));
	});

	$(document).on('click','.popoverShowImage',function () {
		var src_img = $(this).data('src_image');
		var nombre_archivo = $(this).data('nombre_archivo');
		var width_img = '80%';
		var height_img = '80%';
		if($(this).data('width_img') != undefined && $(this).data('width_img') != ''){
			width_img = $(this).data('width_img');
		}if($(this).data('height_img') != undefined && $(this).data('height_img') != ''){
			height_img = $(this).data('height_img');
		}
		$(this).popover({
			html :true,
			trigger: 'hover',
			title: nombre_archivo,
			//placement: 'top',
			content: function () {
				return '<img src="'+src_img+'" width="'+width_img+'" height="'+height_img+'" />'
			}
		});
	});

	$(document).on('click','.popoverShowHTML',function(){
		var contenedor_html = $(this).data('contenedor_html');
		var title_popover = $(this).data('title_popover')
		$(this).popover({
			html : true,
			trigger : 'hover',
			title : title_popover,
			content: function(){
				return $(contenedor_html).html();
			}
		});
	});

	$(document).on('click','.btn_ver_imagen_modal',function(){
		var src_img = $(this).data('src_image');
		var nombre_archivo = $(this).data('nombre_archivo');
		var img_html = '<img src="'+src_img+'" alt="'+nombre_archivo+'" width="100%">';
		$('#modal_body_visor_imagen').html(img_html);
		Comun.mostrar_ocultar_modal('#modal_visor_imagen',true);
	});

	Comun.tooltips();
	Comun.funcion_menu_search();

});

var Comun = {

	validar_form : function (id_form,options){
		var validator = $(id_form).validate(options);
		validator.form();
		var result = validator.valid();
		return result;
	},

	reglas_validacion_form : function(){
		var rules = {
			errorElement: "span",
			errorPlacement: function ( error, element ) {
				// Add the `help-block` class to the error element
				error.addClass( "help-block invalid-feedback" );

				// Add `has-feedback` class to the parent div.form-group
				// in order to add icons to inputs
				element.parents( ".form-group" ).addClass( "has-feedback" );

				if ( element.prop( "type" ) === "checkbox" ) {
					error.insertAfter( element.parent( "label" ) );
				} else {
					error.insertAfter( element );
				}

				// Add the span element, if doesn't exists, and apply the icon classes to it.
			},
			success: function ( label, element ) {
				// Add the span element, if doesn't exists, and apply the icon classes to it.
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
				//$( element ).next( "span" ).addClass( "fa-exclamation" ).removeClass( "fa-check" );
			},
			unhighlight: function ( element, errorClass, validClass ) {
				$( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
				//$( element ).next( "span" ).addClass( "fa-check" ).removeClass( "fa-exclamation" );
			}
		}
		return rules;
	},

	validar_curp : function(stringValidar){
		//return stringValidar.match(/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[0-9]{2}$/);//
		return stringValidar.match(/^[A-ZÑ]{4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{6}[A-Z0-9]{1}[0-9]{1}$/);
	},

	validar_rfc : function(stringValidar){
		return stringValidar.match(/^[A-ZÑ]{3,4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3}$/);
	},

	validar_correo : function(stringValidar){
		return stringValidar.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	},

	validar_url : function(strUrl){
		try{
			var url = new URL(strUrl);
			return true;
		}catch (_){
			return false;
		}
	},

	validar_string_no_vacio : function(stringValidar){
		return stringValidar !== "";
	},

	mostrar_ocultar_modal : function(id_modal,mostrar,position_centered = false){
		if(position_centered){
			$(id_modal).find('div.modal-dialog').addClass('modal-dialog-centered');
		}
		if(mostrar){
			$(id_modal).modal({backdrop: 'static', keyboard: false, focus : true});
			$(id_modal).modal('show');
		}else{
			$(id_modal).modal('hide');
		}
	},

	//// Can be: "default, "confirmed", "success", "error";
	mensaje_operacion : function(msg,type = 'confirmed',time = 3500){
		var time_growl = 6000;
		if(time != undefined && time != '' && time > 6000){
			time_growl = parseInt(time);
		}
		new Notif(msg,type).display(time_growl);
	},

	mensajes_operacion : function(msgs,type = 'confirmed',time = 3500){
		$.each(msgs,function(index,msg){
			Comun.mensaje_operacion(msg,type,time);
		});
	},

	//funcion para obtener el html como respuesta de una peticion de un controllador
	obtener_contenido_peticion_html : function (url,parametros,processor,metodo) {
		if (!metodo) {
			metodo = "POST";
		}
		$.ajax({
			type : metodo,
			data : parametros,
			dataType: "html",
			url : url,
			success : function (data) {
				processor(data,true);
			},
			error : function (xhr,ajaxOptions,thrownError) {
				var msg = 'Lo siento, no pudimos procesar tu petición, error en el servidor';
				var type = 'error';
				console.log(xhr.status);
				switch (xhr.status) {
					case 303:
					case 401:
						Comun.mensaje_operacion('Lo siento, la sesión en el sistema expiró','confirmed');
						Comun.recargar_pagina(base_url + 'login');
						break;
					case 403:
						msg = 'Lo siento, no tiene permisos para esta operación';
						type = 'confirmed';
						break;
					case 404:
						msg = 'Lo siento, No encontramos el sitio o petición que intenta acceder';
						type = 'error';
						break;
				}
				Comun.mensaje_operacion(msg,type);
				processor(msg,false);
				// alert(xhr.status);
				// alert(thrownError);
				// processor("No se pudo establecer con el servidor",false);
			}
		});
	},

	obtener_contenido_peticion_json : function (url,parametros,processor,metodo) {
		if (!metodo) {
			metodo = "POST";
		}
		$.ajax({
			type : metodo,
			data : parametros,
			dataType: "json",
			url : url,
			success : function (data) {
				processor(data,true);
			},
			error : function (xhr,ajaxOptions,thrownError) {
				var msg = 'Lo siento, no pudimos procesar tu petición, error en el servidor';
				var type = 'error';
				console.log(xhr.status);
				switch (xhr.status) {
					case 303:
					case 401:
						Comun.mensaje_operacion('Lo siento, la sesión en el sistema expiró','confirmed');
						Comun.recargar_pagina(base_url + 'login');
						break;
					case 403:
						msg = 'Lo siento, no tiene permisos para esta operación';
						type = 'confirmed';
						break;
					case 404:
						msg = 'Lo siento, No encontramos el sitio o petición que intenta acceder';
						type = 'error';
						break;
				}
				Comun.mensaje_operacion(msg,type);
				//alert(xhr.status);
				//alert(thrownError);
				//processor("No se pudo establecer con el servidor",false);
			}
		});
	},

	enviar_formulario_post : function (id_formulario,url,processor,parametros) {
		$.ajax({
			type : "POST",
			url : url,
			data : $(id_formulario).serialize()+Comun.serializar_json_formulario(parametros),
			dataType : "json",
			success:function (data) {
				processor(data);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var msg = 'Lo siento, no pudimos procesar tu petición, error en el servidor';
				var type = 'error';
				switch (xhr.status) {
					case 401:
					case 303:
						Comun.mensaje_operacion('Lo siento, la sesión en el sistema expiró','confirmed');
						Comun.recargar_pagina(base_url + 'login');
						break;
					case 403:
						msg = 'Lo siento, no tiene permisos para esta operación';
						type = 'confirmed';
						break;
					case 404:
						msg = 'Lo siento, No encontramos el sitio o petición que intenta acceder';
						type = 'error';
						break;
				}
				Comun.mensaje_operacion(msg,type);
				//alert(xhr.status);
				//alert(thrownError);
				//processor(errorResponse);
			}
		});
	},

	//funcion que nos devuel el post de un formulario para enviarlo al controller
	obtener_post_formulario : function (id_formulario) {
		return $(id_formulario).serialize()+Comun.serializar_json_formulario(undefined);
	},

	//funcion que nos permite serializar en json el post un formulario
	serializar_json_formulario : function (json) {
		var strSerialized = '';
		if(json != null){
			$.each(json,function (key,value) {
				strSerialized += strSerialized == "" ? '&'+key+'='+value : '&'+key+'='+value;
			});
		}
		return strSerialized;
	},

	str_mayus : function(input){
		var value = input.val();
		input.val(value.toUpperCase());
	},

	autoguardado_campo_formulario : function(campo){
		var url_peticion = campo.data('url_peticion');
		var post = {
			tabla_update : campo.data('tabla_update'),
			campo_update : campo.data('campo_update'),
			id_campo_update : campo.data('id_campo_update'),
			id_value_update : campo.data('id_value_update'),
			value_update : campo.val()
		};
		$.ajax({
			type: 'POST',
			url: url_peticion,
			data:post,
			dataType:'json',
			success:function(response){
				var random = $.now();
				var class_msg = 'badge-danger';
				var msg = 'Sin guardar :-(';
				var time_out = 2000;
				if(response.exito){
					class_msg = 'badge-success';
					msg = 'Guardado :-D';
				}else{
					if(response.msg != ''){
						msg = response.msg;
						time_out = 4000;
					}
				}
				var span_save = '<span id="'+random+'" class="'+class_msg+' msg_validacion_encuesta">'+msg+'</span>';
				campo.parent().append(span_save);
				setTimeout(function(){
					$('#'+random).fadeOut();
				},time_out);
				setTimeout(function(){
					$('#'+random).remove();
				},4100);
			},
			error: function (xhr) {
				alert(xhr.status);
			}
		});
	},

	copiar_link_al_portapapeles : function (elemento){
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(elemento).text()).select();
		document.execCommand("copy");
		$temp.remove();
	},

	obtener_sumatoria_tabla(tabla,input,destino){
		var sumatoria = 0;
		$(tabla).find(input).each(function(){
			sumatoria += parseInt($(this).val());
		});
		$(destino).html(sumatoria)
	},

	recargar_pagina : function(url_redirect,time = 3000){
		setTimeout(function(){
			location.href = url_redirect;
		},time);
	},

	addExtraScript : function(url_js){
		$.getScript(url_js,function(){});
	},

	tooltips : function(){
		$('[data-toggle="tooltip"]').tooltip({
			placement : 'bottom'
		});
	},

	ocultar_tooltips : function(){
		$('.tooltip-inner').hide();
	},

	mostrar_mensaje_advertencia : function(msg_confirmacion){
		$('#msg_informacion_advertencia').html(msg_confirmacion);
		Comun.mostrar_ocultar_modal('#modal_informacion_sistema',true);
	},
	
	mostrar_mensaje_confirmacion_gral : function(msg_confirmacion,url_confirmacion,btn_trigger){
		$('#msg_confirmacion_general').html(msg_confirmacion);
		$('#url_confirmacion_general').val(url_confirmacion);
		$('#btn_trigger_success').val(btn_trigger);
		Comun.mostrar_ocultar_modal('#modal_confirmacion_general',true);
	},

	assing_array : function (array_firts,array_second){
		var objs = [array_firts,array_second],
			result =  objs.reduce(function (r, o) {
				Object.keys(o).forEach(function (k) {
					r[k] = o[k];
				});
				return r;
			}, {});
		return result;
	},

	campo_modificar_comun : function(btn,actualizar = true){
		var id_btn_iniciar_mod = btn.data('id_btn_iniciar_mod');
		var span_leyenda = btn.data('span_leyenda');
		var id_input_editar = btn.data('id_input_editar');
		var id_btn_guardar_mod = btn.data('id_btn_guardar_mod');
		var id_btn_cancelar_mod = btn.data('id_btn_cancelar_mod');
		var id_div_editor = btn.data('id_div_editor') != undefined ? btn.data('id_div_editor') : false;
		if(actualizar){
			$(id_btn_iniciar_mod).hide();
			$(span_leyenda).hide();
			if(id_div_editor != false){
				$(id_div_editor).show();
			}else{
				$(id_input_editar).show();
			}
			$(id_btn_guardar_mod).show();
			$(id_btn_cancelar_mod).show();
		}else{
			$(id_btn_iniciar_mod).show();
			$(span_leyenda).show();
			if(id_div_editor != false){
				$(id_div_editor).hide();
			}else{
				$(id_input_editar).hide();
			}
			$(id_btn_guardar_mod).hide();
			$(id_btn_cancelar_mod).hide();
		}
	},

	guardar_modificacion : function(btn){
		var span_leyenda = btn.data('span_leyenda');
		var id_input_editar = btn.data('id_input_editar');
		var type_input = btn.data('type_input') != undefined ? btn.data('type_input') : 'input';
		var parametros = {
			campo_actualizar : btn.data('campo_actualizar'),
			campo_actualizar_valor : $(id_input_editar).val(),
			tabla_actualizar : btn.data('tabla_actualizar'),
			id_actualizar : btn.data('id_actualizar'),
			id_actualizar_valor : btn.data('id_actualizar_valor'),
		};
		Comun.obtener_contenido_peticion_json(
			base_url + 'Admin/actualizar_comun',parametros,
			function(response){
				if(response.success){
					Comun.mensajes_operacion(response.msg,'success');
					switch (type_input) {
						case 'select':
							var leyenda = $(id_input_editar).find('option[value="'+parametros.campo_actualizar_valor+'"]').html();
							$(span_leyenda).html(leyenda);
							break;
						default:
							$(span_leyenda).html(parametros.campo_actualizar_valor);
							break;
					}
					Comun.campo_modificar_comun(btn,false);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},

	eliminar_comun : function(btn){
		var tag_parent = btn.data('tag_parent');
		var parametros = {
			tabla_eliminar : btn.data('tabla_eliminar'),
			id_eliminar : btn.data('id_eliminar'),
			id_eliminar_valor : btn.data('id_eliminar_valor'),
		};
		Comun.obtener_contenido_peticion_json(
			base_url + 'Admin/eliminar_comun',parametros,
			function(response){
				if(response.success){
					Comun.mensajes_operacion(response.msg,'success');
					btn.closest(tag_parent).remove();
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},

	guardar_modificacion_input : function(input){
		var mostrar_mensaje_update = input.data('mostrar_mensaje') != undefined && input.data('mostrar_mensaje') == 'si' ? true : false;
		var parametros = {
			campo_actualizar : input.data('campo_actualizar'),
			campo_actualizar_valor : input.val(),
			tabla_actualizar : input.data('tabla_actualizar'),
			id_actualizar : input.data('id_actualizar'),
			id_actualizar_valor : input.data('id_actualizar_valor'),
		};
		Comun.obtener_contenido_peticion_json(
			base_url + 'Admin/actualizar_comun',parametros,
			function(response){
				if(response.success){
					if(mostrar_mensaje_update){
						Comun.mensajes_operacion(response.msg,'success');
					}
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},

	funcion_fileinput : function(input_file,strLabel){
		var strEtiqueta = 'Examinar';
		if(strLabel != undefined && strLabel != ''){
			strEtiqueta = strLabel;
		}
		$(input_file).fileinput({
			showCaption: false,
			showPreview: false,
			showUpload: false,
			showRemove: false,
			removeLabel: '',
			removeIcon: '<i class="fa fa-upload"></i> ',
			browseClass: 'btn btn-outline-dark btn-sm',
			browseLabel: strEtiqueta,
			browseIcon: '<i class="fa fa-upload"></i>&nbsp;',
		});
	},

	bootstrap_switch : function(){
		$("input[data-bootstrap-switch]").each(function(){
			$(this).bootstrapSwitch('state', $(this).prop('checked'));
		})
	},

	iniciar_carga_imagen : function(input_file,div_procesando,funcion_response,transparente = ''){
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var id_cat_expediente = 2;
		var img_destino = '';
		var identificador_row = '';
		$(input_file).fileupload({
			url : base_url + 'Uploads/uploadFileComunImg/' + transparente,
			dataType: 'json',
			start: function (e,data) {
				$(div_procesando).html(overlay);
			},
			//tiempo de ejecucion
			add: function (e,data) {
				id_cat_expediente = data.fileInput.data('id_cat_expediente');
				img_destino = data.fileInput.data('destino_img');
				identificador_row = data.fileInput.data('identificador_row');
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
					funcion_response(archivo);
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

	iniciar_carga_documento : function(input_file,div_procesando,funcion_response,id = false){
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var id_cat_expediente = 2;
		$(input_file).fileupload({
			url : base_url + 'Uploads/uploadFileComunPDF',
			dataType: 'json',
			start: function (e,data) {
				$(div_procesando).html(overlay);
			},
			//tiempo de ejecucion
			add: function (e,data) {
				id_cat_expediente = data.fileInput.data('id_cat_expediente');
				nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
				data.formData = {
					filename : nombre_archivo
				};
				var goUpload = true;
				var uploadFile = data.files[0];
				var regExp = "\.(" + extenciones_files_pdf + ")$";
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
					funcion_response(archivo,id,div_procesando);
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

	agregar_rows_tabla : function (btn_lnk){
		var destino = $(btn_lnk.data("destino"));
		var html = $(btn_lnk.data("origen")).html();

		html = html.replace("<!--","");
		html = html.replace("-->","");
		html = html.replace(/\{id}/g, $.now()); //replace("{id}",$.now());

		destino.append(html);
	},

	iniciar_select2 : function(){
		$('.select2').select2();
	},

	desabilitar_fines_semana_calendario : function(id_input,id_error){
		$(document).on('change',id_input,function(){
			var fecha_selecionada = new Date($(id_input).val());
			var dia_seleccionada = fecha_selecionada.getDay();
			if(dia_seleccionada >= 5){
				$(id_input).val('');
				$(id_error).fadeIn();
				setTimeout(function(){
					$(id_error).fadeOut();
				},3000);
			}
		});
	},

	sumar_dias_habiles_calendario : function(fecha_inicial,numero_dias){
		var fecha = new Date(fecha_inicial); //toLocaleDateString('en-CA') para formatear 'YYYY-mm-dd'
		var sum_dias = 0;
		while(sum_dias <= numero_dias){
			var dia = fecha.getDay();
			//para ver si es un fin de semana (sabado y domingo)
			if(dia < 5){
				sum_dias++;
			}
			fecha.setDate(fecha.getDate() + 1);
		}
		return fecha.toLocaleDateString('en-CA');
	},

	funcion_menu_search : function (){
		$('[data-widget="sidebar-search"]').SidebarSearch({
			notFoundText : "No hay opciones",
		});
	},

	iniciar_editor_summernote : function(textarea,placeholder,minHeight = 300){
		$(textarea).summernote({
			minHeight : minHeight,
			lang : 'es-ES',
			placeholder : placeholder,
			codeviewFilter: false,
			codeviewIframeFilter: true,
			toolbar : [
				['style', ['bold', 'italic', 'underline']],
				['font',['fontname','fontsize','forecolor']],
				['para', ['ul', 'ol', 'paragraph']],
				//['insert', ['link', 'picture', 'video']],
				['view', [ 'help']],
			]
		});
	},

	iniciar_carga_documento_all : function(input_file,div_procesando,funcion_response,id = false){
		//funcion para cargar archivo via ajax
		var nombre_archivo;
		var id_cat_expediente = 2;
		$(input_file).fileupload({
			url : base_url + 'Uploads/uploadFileComunAll',
			dataType: 'json',
			start: function (e,data) {
				$(div_procesando).html(overlay);
			},
			//tiempo de ejecucion
			add: function (e,data) {
				id_cat_expediente = data.fileInput.data('id_cat_expediente');
				nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\",""); //use to chrome
				data.formData = {
					filename : nombre_archivo
				};
				var goUpload = true;
				var uploadFile = data.files[0];
				var regExp = "\.(" + extenciones_files_all + ")$";
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
					funcion_response(archivo,id,div_procesando);
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

	removeClassInvalidError(formulario){
		$("#"+formulario).find(".is-invalid").removeClass("is-invalid");
		$("#"+formulario).find(".invalid-feedback").remove();

	}
};
