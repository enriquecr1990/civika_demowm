$(document).ready(function(){

	$(document).on('click','#btn_enviar_examen',function(e){
		e.preventDefault();
		Examen.enviar_respuestas();
	});

	$(document).on('click','#btn_enviar_examen_tiempo',function(){
		Examen.enviar_respuestas_tiempo();
	});

	$(document).on('click','#btn_guardar_decision_candidato',function(){
		Examen.guardar_form_decision_candidato();
	});

	//if(es_pruebas == 1 || es_produccion == 1){
	if(true){
		$('#menu_lateral_izquierdo').fadeOut();
		$('#menu_superior').fadeOut();

		$(document).on("keydown", function(e) {
			Examen.desabilitar_ctrl_actualizacion(e);
		});
		
		//modal para mostrar el mensaje
		$(document).on("mouseleave",function(){
			if(Examen.intento_salir <= 1 ){
				Comun.mostrar_mensaje_advertencia("Se detectó que quiere salir del evaluación, estó ocasionará el marcarlo como realizado y no podrá realizar otro");
				Examen.intento_salir++;
			}if(Examen.intento_salir == 2){
				Examen.intento_salir++;
				Comun.mostrar_mensaje_advertencia("Se enviará de forma automática la evaluación diagnóstica, se pide que marque su selección de la decisión");
				setTimeout(function(){
					Examen.enviar_formulario_respuestas();
					Comun.mostrar_ocultar_modal('#modal_informacion_sistema',false);
				},5000);
			}
		});

		window.onbeforeunload = function(){
			if(Examen.intento_salir < 2){
				return "Se detecto que quiere salir del evaluación, esto ocasionará el marcarlo como realizado y no podra realizar otro";
			}
		}

		$(window).keyup(function (e) {
			if (e.keyCode == 44) {
				//cuando se detecta la tecla 44 (o sea, print paint) ejecutamos la función copyToClipboard()
				Examen.quitar_imprimir_pantalla();
			}
		});
	}

	$(document).on("keydown", function(e) {
		e = e || window.event;
		console.log(e.keyCode);
		//combinacion teclas CTRL + tecla
		if (e.ctrlKey) {
			var c = e.which || e.keyCode;
			if (c == 67) { // + C
				e.preventDefault();
				e.stopPropagation();
				Comun.mostrar_mensaje_advertencia("Error, por razones de seguridad no esta permitido copiar información de la evaluación");
			}
		}
	});

	Examen.inicializar_funciones_examen();

});

var Examen = {

	intento_salir : 0,

	inicializar_funciones_examen : function(){
		Examen.ocultar_menu_examen();
		Examen.iniciar_cuenta_atras();
		Examen.procesar_class_calificacion();
		$('.popoverShowImage').trigger('click');
	},

	ocultar_menu_examen : function(){
		$('a.nav-link').trigger('click');
	},

	iniciar_cuenta_atras : function(){
		var tiempo = $('#tiempo_minutos').length;
		if(tiempo > 0){
			var fecha_inicio = new Date();
			var minutos = parseInt($('#tiempo_minutos').val());
			var milisegundo = minutos * 60000;
			var limite_envio = new Date(fecha_inicio.getTime() + milisegundo);
			console.log(limite_envio);
			Examen.evento_transcurrido_tiempo(milisegundo);
			$('#reloj_contador').countdown(limite_envio,function(event){
				var reloj = '<i class="fa fa-clock"></i> <span id="horas">%H</span>:<span id="minutos">%M</span>:<span id="segundos">%S</span>';
				/*var reloj = '' +
					'<div class="inner">' +
					'<span id="horas">%H</span>:<span id="minutos">%M</span>:<span id="segundos">%S</span>' +
					'</div>' +
					'<div class="icon">' +
					'	<i class="fa fa-clock"></i>' +
					'</div>';*/
				$(this).html(event.strftime(reloj));
			});
		}
	},

	evento_transcurrido_tiempo : function (tiempo){
		setTimeout(function () {
			$('#reloj_contador').fadeOut();
			$('#btn_enviar_examen_tiempo').trigger('click');
		},tiempo);
	},

	validar_form_examen : function(){
		var form_valido = Comun.validar_form('#form_evaluacion_examen',Comun.reglas_validacion_form());
		if(form_valido){

		}
		return form_valido;
	},

	validar_form_decision_candidato : function(){
		var form_valido = Comun.validar_form('#form_guardar_decision_candidato',Comun.reglas_validacion_form());
		if(form_valido){

		}
		return form_valido;
	},

	enviar_respuestas : function(){
		if(Examen.validar_form_examen()){
			Examen.enviar_formulario_respuestas();
		}else{
			Comun.mensaje_operacion('Error, hay preguntas sin responder en su evaluación; favor de revisar','error',5000);
		}
	},

	enviar_respuestas_tiempo : function(){
		Examen.enviar_formulario_respuestas();
	},

	enviar_formulario_respuestas : function(){
		Comun.enviar_formulario_post(
			'#form_evaluacion_examen',
			base_url + 'AlumnosEC/guardar_respuestas',
			function(response){
				if(response.success){
					$('#contenedor_modal_primario').html(Examen.obtener_html_modal_respuestas_evaluacion());
					Comun.mostrar_ocultar_modal('#modal_confirmacion_respuestas_evaluacion',true);
					$('#calificación_evaluacion').html(response.data.calificacion).addClass(response.data.tag);
					$('#dictamen_calificacion').html(response.data.evaluacion_sistema).addClass(response.data.tag);
					$('#input_id_evaluacion_realizada').val(response.data.id_usuario_has_evaluacion_realizada);
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	guardar_form_decision_candidato : function(){
		if(Examen.validar_form_decision_candidato()){
			Comun.enviar_formulario_post(
				'#form_guardar_decision_candidato',
				base_url + 'AlumnosEC/guardar_decision',
				function(response){
					if(response.success){
						$('.btn_cerrar_confirmacion_evaluacion').fadeIn();
						$('#btn_guardar_decision_candidato').fadeOut();
						$('#slt_decision_candidato_evaluacion').attr('disabled',true);
						$('#input_decision_candidato').attr('disabled',true);
						Comun.mensaje_operacion(response.msg,'success');
					}else{
						Comun.mensajes_operacion(response.msg,'error');
					}
				}
			);
		}else{
			Comun.mensaje_operacion('Error, hay campos requeridos en el formulario, favor de validar','error');
		}
	},

	obtener_html_modal_respuestas_evaluacion : function(){
		var id_estandar_competencia = $('#id_estandar_competencia').val();
		var id_usuario_evaluador = $('#id_usuario_evaluador').val();
		var html_modal_confirmación_respuestas = '' +
			'<div class="modal fade" id="modal_confirmacion_respuestas_evaluacion" aria-modal="true" role="dialog">' +
				'<div class="modal-dialog modal-dialog-centered">' +
					'<div class="modal-content">' +
						'<div class="modal-header">' +
							'<h4 class="modal-title">Mensaje de confirmación</h4>' +
							//'<button type="button" class="close btn_cerrar_confirmacion_evaluacion" style="display: none" data-dismiss="modal" aria-label="Close">' +
							//'<span aria-hidden="true">×</span>' +
							//'</button>' +
						'</div>' +
						'<div class="modal-body">' +
							'<div class="callout callout-success">' +
								'<p>Con base en la cantidad de respuestas correctas y calificación de: <label class="" id="calificación_evaluacion"></label>, se te recomienda: <label class="" id="dictamen_calificacion"></label>' +
								'</p>' +
							'</div>' +
							'<div class="callout callout-danger">' +
								'<p>No obstante te pedimos a continuación seleccionar tu decisión</p>' +
							'</div>' +
							'<form id="form_guardar_decision_candidato">' +
								'<input type="hidden" name="id_usuario_has_evaluacion_realizada" id="input_id_evaluacion_realizada" value="">' +
								'<div class="row form-group">' +
									'<div class="col-lg-12">' +
										'<label for="slt_decision_candidato_evaluacion">Decisión del candidato</label>' +
										'<select class="custom-select slt_mostrar_ocultar" id="slt_decision_candidato_evaluacion" ' +
												'data-contenedor_detalle="#descripcion_decision_candidato_evaluacion" ' +
												'data-input_detalle="#input_decision_candidato" data-id_show="otro" name="decision_candidato" data-rule-required="true">' +
											'<option value="">--Seleccione--</option>' +
											'<option value="tomar_capacitacion">Tomar capacitación previo a la Evaluación</option>' +
											'<option value="tomar_alineacion">Tomar alineación previo a la Evaluación</option>' +
											'<option value="tomar_proceso">Iniciar el proceso de Evaluación</option>' +
											'<option value="otro">Otra</option>' +
										'</select>' +
									'</div>	' +
								'</div>	' +
								'<div class="row form-group">' +
									'<div class="col-lg-12" id="descripcion_decision_candidato_evaluacion" style="display: none;">' +
										'<label for="input_decision_candidato">Describa su decisión</label>' +
										'<input type="text" id="input_decision_candidato" data-rule-required="true" name="descripcion_candidato_otro" class="form-control" placeholder="Describe tu decisión">' +
									'</div>' +
								'</div>' +
							'</form>' +
						'</div>' +
						'<div class="modal-footer justify-content-between">' +
							'<button type="button" class="btn btn-sm btn-success" id="btn_guardar_decision_candidato"><i class="fa fa-save"></i>Guardar decisión</button>' +
							'<a href="'+base_url+'AlumnosEC/ver_progreso/'+id_estandar_competencia+'/'+id_usuario_evaluador+'" style="display: none" class="btn btn-primary btn_cerrar_confirmacion_evaluacion">Cerrar</a> ' +
						'</div>' +
					'</div>' +
					'<!-- /.modal-content -->' +
					'</div>' +
				'<!-- /.modal-dialog -->' +
			'</div>';
		return html_modal_confirmación_respuestas;
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

	pantalla_completa : function(){
		setTimeout(function(){
			var element = document.documentElement;
			if(element.requestFullscreen)
				element.requestFullscreen();
			else if(element.mozRequestFullScreen != undefined)
				element.mozRequestFullScreen();
			else if(element.webkitRequestFullscreen != undefined)
				element.webkitRequestFullscreen();
			else if(element.msRequestFullscreen != undefined)
				element.msRequestFullscreen();
		},1000)
	},

	quitar_pantalla_completa : function(){
		if(document.exitFullscreen)
			document.exitFullscreen();
		else if(document.mozCancelFullScreen)
			document.mozCancelFullScreen();
		else if(document.webkitExitFullscreen)
			document.webkitExitFullscreen();
		else if(document.msExitFullscreen)
			document.msExitFullscreen();
	},

	desabilitar_ctrl_actualizacion : function(e){
		e = e || window.event;
		console.log(e.keyCode);
		if(e.keyCode == 116){ //tecla F5
			e.preventDefault();
			e.stopPropagation();
			Examen.intento_salida_evaluacion();
		}

		//combinacion teclas CTRL + tecla
		if (e.ctrlKey) {
			var c = e.which || e.keyCode;
			if (c == 82) { // + R
				e.preventDefault();
				e.stopPropagation();
				Examen.intento_salida_evaluacion();
			}if (c == 67) { // + C
				e.preventDefault();
				e.stopPropagation();
				Comun.mostrar_mensaje_advertencia("Error, por razones de seguridad no esta permitido copiar información del evaluación");
			}
		}

		//combinacion tecla ALT + back
		if(e.altKey){
			var c = e.which || e.keyCode;
			if(c == 37){
				e.preventDefault();
				e.stopPropagation();
				Examen.intento_salida_evaluacion();
			}
		}
	},

	quitar_imprimir_pantalla : function(){
		// creamos un elemento input oculto ("hidden")
		var aux = document.createElement("input");
		// asignamos un valor al elemento en el atributo "value"
		aux.setAttribute("value", "Débido a las medidas de seguridad del sistema, no esta permitido realizar impresión de pantalla de esta página.");
		// agregamos el elemento al body de nuestra web
		document.body.appendChild(aux);
		// seleccionamos el contenido (el texto)
		aux.select();
		// copiamos el texto seleccionado
		document.execCommand("copy");
		// removemos el input oculto del body
		document.body.removeChild(aux);
		//alert("Print Screen Deshabilitado.");
		Comun.mostrar_mensaje_advertencia("Error, por razones de seguridad no esta permitido imprimir pantalla");
	},

	intento_salida_evaluacion : function(){
		if(Examen.intento_salir == 0){
			Comun.mostrar_mensaje_advertencia("Se detectó que quiere salir del evaluación, estó ocasionará el marcarlo como realizado y no podrá realizar otro");
		}if(Examen.intento_salir == 1){
			Comun.mostrar_mensaje_advertencia("Se enviará de forma automática la evaluación diagnostica, se pide que marque su selección de la decisión");
			$('.btn_cerrar_informacion_sistema').fadeOut();
			setTimeout(function(){
				Examen.enviar_formulario_respuestas();
				Comun.mostrar_ocultar_modal('#modal_informacion_sistema',false);
			},5000);
		}
		Examen.intento_salir++;
	}

};
