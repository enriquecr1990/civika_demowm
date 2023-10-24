$(document).ready(function (){

	$(document).on('click','#btn_nuevo_sector',function(){
		CatSector.agregarModificar();
	});
	$(document).on('click','.modificar_sector',function(){
		var id = $(this).data('id');
		CatSector.agregarModificar(id);
	});

	$(document).on('click','#btn_buscar_sectores',function(){
		CatSector.buscarSectores();
	});

	$(document).on('click','#btn_guardar_form_sector',function(e){
		e.preventDefault();
		CatSector.guardar_sector();
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

var CatSector = {

	agregarModificar : function(id = 0){
		console.log(id);
		if (id !== 0){
			$('#contenedor_modal_sector').empty();
			Comun.obtener_contenido_peticion_html('obtener_sector/'+id,{},function (response) {
				$('#contenedor_modal_sector').append(response);
				Comun.mostrar_ocultar_modal('#modal_form_sector',true);
			})
		}else{
			Comun.mostrar_ocultar_modal('#modal_form_sector',true);
		}

	},

	guardar_sector : function (){
		Comun.enviar_formulario_post(
			'#form_agregar_modificar_sector',
			base_url + 'Catalogos/guardar_sector/',
			function(response){
				if(response.success){
					Comun.mostrar_ocultar_modal('#modal_form_sector',false);
					Comun.mensajes_operacion(response.msg,'success');
					Comun.recargar_pagina(base_url + 'catalogos/sectores',2000);
				}else{
					Comun.mensajes_operacion(response.msg,'error',5000);
				}
			}
		)
	},
	buscarSectores : function (pagina = 1, registros = 15) {
		Comun.obtener_contenido_peticion_html(
			base_url +'Catalogos/obtener_sectores/' + pagina + '/' + registros,
			{},
			function(response){
				$('#contenido_tabla_sectores').append(response);
			}
		);
	}
};
