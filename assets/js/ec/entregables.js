


$(document).ready(function (){

	methods.buscarEntregables();

	$(document).on('click','#btn_nuevo_entregable',function(){
		methods.agregarModificar();
	});
	$(document).on('click','.modificar_entregable',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		methods.agregarModificar(id);
	});

	$(document).on('click','#btn_buscar_entregables',function(){
		methods.buscarEntregables();
	});

	$(document).on('click','#btn_guardar_form_entregable',function(e){
		e.preventDefault();
		methods.guardar_entregable();
	});
	$(document).on('click','#btn-liberar',function(e){
		methods.liberar_entregables();
	});

	$(window).scroll(function(){
		//validamos lo del scroll
		var pagina_select = $('#paginacion_usuario').val();
		var max_paginacion = $('#paginacion_usuario').data('max_paginacion');
		if(pagina_select < max_paginacion){
			if(Math.round($(window).scrollTop()) == Math.round($(document).height() - $(window).height())){
				pagina_select++;
				CatSector.buscarSectores(pagina_select);
				$('#paginacion_usuario').val(pagina_select);
			}
		}
	});
});

var methods = {
	agregarModificar : function(id = 0){
		if (id !== 0){
			Comun.obtener_contenido_peticion_html(base_url +'Entregable/obtener_entregable/'+id+'/'+this.idEstandar(),{},function (response) {
				$('#contenedor_modal_entregable').html(response);
				Comun.mostrar_ocultar_modal('#modal_form_entregable',true);
				Comun.funcion_fileinput('#material_apoyo','Archivo de apoyo');
				methods.iniciar_carga_material_apoyo();
			})
		}else{
			Comun.mostrar_ocultar_modal('#modal_form_entregable',true);
			Comun.funcion_fileinput('#material_apoyo','Archivo de apoyo');
			methods.iniciar_carga_material_apoyo();
		}


	},

	guardar_entregable : function (){
		Comun.removeClassInvalidError('form_agregar_modificar_entregable');
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_entregable',
			base_url + 'Entregable/guardar_entregable',
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_form_entregable',false);
					Comun.mensajes_operacion(response.msg,'success');
					Comun.recargar_pagina(base_url + 'evidencias_esperadas/'+ methods.idEstandar(),2000);
					methods.buscarEntregables();
				}else{
					if(response.code === 400){
						$.each(response.msg,function(i,val){
							$('#'+i).addClass('is-invalid')
							$('#'+i).after('<span id="input_codigo-error" class="error help-block invalid-feedback">'+val+'</span>');
						})
					}
					else{
						Comun.mensajes_operacion(response.msg,'error',5000);
					}
				}
			},
			{id_estandar_comptencia: this.idEstandar()}
		)
	},

	liberar_entregables : function (){
		Comun.obtener_contenido_peticion_json(
			base_url + 'Entregable/liberar_entregables/'+methods.idEstandar(),
			{},
			function(response){
				if(response.success){
					Comun.mensajes_operacion(response.msg,'success');
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},
	buscarEntregables : function (pagina = 1, registros = 10){
		$('#contenedor_entregables').html(overlay);
		Comun.obtener_contenido_peticion_html(
			base_url +'Entregable/obtener_entregables/'+pagina+'/'+registros,{id_estandar_competencia : this.idEstandar()},
			function(response){
				$('#contenedor_entregables').html(response);

			},
		);
	},
	iniciar_carga_material_apoyo : function(){
		Comun.iniciar_carga_documento('#material_apoyo','#procesando_material_apoyo',function(archivo){
			$('#input_material_apoyo').val(archivo.id_archivo);
			var html_img = '<p>archivo.nombre <em class="fa fa-times-circle eliminar_archivo" style="color: red"></em></p>';
			$('#procesando_material_apoyo').html(html_img);
		})
	},
	idEstandar(){
		return $('#id_estandar_competencia').val();
	}
};
