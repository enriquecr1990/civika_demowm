$(document).ready(function(){

	$(document).on('click','.generar_portafolio_evidencia',function(){
		var id_usuario_alumno = $(this).data('id_usuario_alumno');
		var id_usuario_instructor = $(this).data('id_usuario_instructor');
		var id_estandar_competencia = $(this).data('id_estandar_competencia');
		PortafolioEvidencia.generar_pdf_portafolio_evidencia(id_usuario_alumno,id_usuario_instructor,id_estandar_competencia);
	});

});

var PortafolioEvidencia = {

	archivos_temporales : [],

	generar_pdf_portafolio_evidencia : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		PortafolioEvidencia.archivos_temporales = [];
		$('#contenedor_generador_evidencias').html('<div class="form-group row">' +
			'<div class="col-lg-12 alert alert-info">' +
			'Se está validando la información en el sistema y si se cumplen los datos se procederá a generar el Portafolio de evidencias en PDF, espere que termine y no cierre esta ventana o la refresque' +
			'</div>' +
			'</div>');
		$('.btn_close_modal_generar_evidencia').attr('disabled',true);
		Comun.mostrar_ocultar_modal('#modal_generar_portafolio_evidencia',true);
		PortafolioEvidencia.validar_informacion_generar_ped_pdf(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
	},

	validar_informacion_generar_ped_pdf : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_datos_validacion_sistema" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_datos_validacion_sistema">Validando la información almacenada en el sistema</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/validar_datos_generar_ped_pdf/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					var html_procesar_datos_validacion_sistema = '';
					var validaciones = true;
					//validamos la información del sistema
					if(!response.validaciones.evaluacion_diagnostica_realizada){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Candidato no ha realizado y enviado la evaluación diagnóstica.</li>';
					}if(!response.validaciones.cargo_evidencia_ati){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Falta la carga de los instrumentos de evaluación y liberarlos.</li>';
					}if(!response.validaciones.cargo_expediente_digital_ped){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Falta la carga del expediente digital PED (ficha de registro, instrumento de evaluación CONOCER ó Certificado de Competencia laboral).</li>';
					}if(!response.validaciones.firma_evaluador){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Falta la firma del evaluador asignado.</li>';
					}if(!response.validaciones.candidato_expediente_digital){
						validaciones = false;
						html_procesar_datos_validacion_sistema += response.validaciones.legend_candidato_expediente_digital;
					}if(!response.validaciones.fecha_evidencia_ati_evaluador){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Falta la actualización de la fecha de los instrumentos de evaluación.</li>';
					}if(!response.validaciones.candidato_encuesta_satisfacion){
						validaciones = false;
						html_procesar_datos_validacion_sistema += '<li>Falta que el candidato realize la encuesta de satisfacción</li>';
					}

					if(validaciones){
						$('#procesar_datos_validacion_sistema').html(
							'			<i class="fas fa-2x fa-thumbs-up"></i>' +
							'			<div class="text-bold pt-2">OK</div>'
						);
						$('#label_procesar_datos_validacion_sistema').html('Se validó la información del sistema y cuenta con todo lo necesario para generar el PED-PDF');
						PortafolioEvidencia.obtener_data_portafolio_evidencia(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
					}else{
						$('#procesar_datos_validacion_sistema').html(
							'			<i class="fas fa-2x fa-thumbs-down"></i>' +
							'			<div class="text-bold pt-2">Error</div>'
						);
						$('#label_procesar_datos_validacion_sistema').html(html_procesar_datos_validacion_sistema);
						$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
						Comun.mensaje_operacion('Hay información en el sistema que no se encuentra, favor de validar e intente más tarde','error');
					}
				}else{
					$('#procesar_datos_validacion_sistema').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_datos_validacion_sistema').html('No fue posible validar los datos del sistema, favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	obtener_data_portafolio_evidencia : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_datos_portafolio_evidencias" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_datos_portafolio_evidencias">Procesando los datos del portafolio de evidencias</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/obtener_data_portafolio_evidencia/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					$('#procesar_datos_portafolio_evidencias').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					if(response.existe_ped){
						$('#label_procesar_datos_portafolio_evidencias').html('Ya existia este portafolio, se mostrará o descargará el PDF del mismo');
						var iframe = '<div class="row form-group">' +
							'	<div class="col-lg-12">' +
							'		<iframe src="'+response.doc_portafolio_evidencia+'" height="350px" width="100%"></iframe>' +
							'	</div>' +
							'</div>';
						$('#contenedor_generador_evidencias').append(iframe);
						$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					}else{
						$('#label_procesar_datos_portafolio_evidencias').html('Datos del portafolio, se obtuvieron correctamente');
						PortafolioEvidencia.generar_pdf_portada_ficha_registro(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
					}
				}else{
					$('#procesar_datos_portafolio_evidencias').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_datos_validacion_sistema').html('No fue posible validar los datos del sistema, favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	generar_pdf_portada_ficha_registro : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_pdf_portada_ficha_registro" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_pdf_portada_ficha_registro">Generando el PDF (Portada - Ficha de registro)</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/generar_pdf_portada_to_ficha_registro/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					$('#procesar_pdf_portada_ficha_registro').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					$('#label_procesar_pdf_portada_ficha_registro').html('PDF generado correctamente (Portada - ficha de registro)');
					PortafolioEvidencia.archivos_temporales.push(response.data.documento);
					PortafolioEvidencia.generar_pdf_diagnostico(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
				}else{
					$('#procesar_pdf_portada_ficha_registro').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_pdf_portada_ficha_registro').html('No fue posible generar el PDF (Portada - Ficha de registro), favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	generar_pdf_diagnostico : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_pdf_evaluacion_diagnostica" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_pdf_evaluacion_diagnostica">Generando el PDF (Evaluación diagnóstica)</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/generar_pdf_diagnostico/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					$('#procesar_pdf_evaluacion_diagnostica').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					$('#label_procesar_pdf_evaluacion_diagnostica').html('PDF generado correctamente (Evaluación diagnostica)');
					PortafolioEvidencia.archivos_temporales.push(response.data.documento);
					PortafolioEvidencia.generar_pdf_acuse_plan_evaluacion(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
				}else{
					$('#procesar_pdf_evaluacion_diagnostica').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_pdf_evaluacion_diagnostica').html('No fue posible generar el PDF (Evaluación diagnóstica), favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	generar_pdf_acuse_plan_evaluacion : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_pdf_acuse_plan_evaluacion" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_pdf_acuse_plan_evaluacion">Generando el PDF (Acuse de recibido - plan de evaluación)</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/generar_pdf_acuse_to_plan_evaluacion/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					$('#procesar_pdf_acuse_plan_evaluacion').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					$('#label_procesar_pdf_acuse_plan_evaluacion').html('PDF generado correctamente (Acuse de recibido - plan de evaluación)');
					PortafolioEvidencia.archivos_temporales.push(response.data.documento);
					PortafolioEvidencia.generar_pdf_cierre_entrega_certificado(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
				}else{
					$('#procesar_pdf_acuse_plan_evaluacion').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_pdf_acuse_plan_evaluacion').html('No fue posible generar el PDF (Acuse de recibido - plan de evaluación), favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	generar_pdf_cierre_entrega_certificado : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_pdf_cierre_entrega_certificado" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_pdf_cierre_entrega_certificado">Generando el PDF (Cierre de evaluación - Entrega de Certificado)</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/generar_pdf_cierre_eva_to_entrega_certificado/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,{},
			function(response){
				if(response.success){
					$('#procesar_pdf_cierre_entrega_certificado').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					$('#label_procesar_pdf_cierre_entrega_certificado').html('PDF generado correctamente (Cierre de evaluación - Entrega de Certificado)');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					PortafolioEvidencia.archivos_temporales.push(response.data.documento);
					PortafolioEvidencia.conjuntar_archivos_portafolio_evidencia(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia);
				}else{
					$('#procesar_pdf_cierre_entrega_certificado').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_pdf_cierre_entrega_certificado').html('No fue posible generar el PDF (Cierre de evaluación - Entrega de Certificado), favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	conjuntar_archivos_portafolio_evidencia : function(id_usuario_alumno,id_usuario_instructor,id_estandar_comptencia){
		var html_procesar_datos = '<div class="row form-group">' +
			'	<div class="col-sm-2">' +
			'		<div class="overlay" id="procesar_pdf_conjunto_ped" style="background-color: white; color: green">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'	<div class="col-sm-10">' +
			'		<label id="label_procesar_pdf_conjunto_ped">Conjuntando los archivos PDF del PED</label>' +
			'	</div>' +
			'</div>';
		$('#contenedor_generador_evidencias').append(html_procesar_datos);
		Comun.obtener_contenido_peticion_json(
			base_url + 'DocsPDF/generando_pdf_completo/'+id_usuario_alumno+'/'+id_usuario_instructor+'/'+id_estandar_comptencia,
			{docs_generados : PortafolioEvidencia.archivos_temporales},
			function(response){
				if(response.success){
					$('#procesar_pdf_conjunto_ped').html(
						'			<i class="fas fa-2x fa-thumbs-up"></i>' +
						'			<div class="text-bold pt-2">OK</div>'
					);
					$('#label_procesar_pdf_conjunto_ped').html('Se genero el PDF del PED correctamente');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					var iframe = '<div class="row form-group">' +
						'	<div class="col-lg-12">' +
						'		<iframe src="'+base_url+response.data.ruta_directorio+response.data.nombre+'" height="350px" width="100%"></iframe>' +
						'	</div>' +
						'</div>';
					$('#contenedor_generador_evidencias').append(iframe);
				}else{
					$('#procesar_pdf_conjunto_ped').html(
						'			<i class="fas fa-2x fa-thumbs-down"></i>' +
						'			<div class="text-bold pt-2">Error</div>'
					);
					$('#label_procesar_pdf_conjunto_ped').html('No fue posible generar el PDF del PED completo, favor de intentar más tarde');
					$('.btn_close_modal_generar_evidencia').removeAttr('disabled');
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	}

};
