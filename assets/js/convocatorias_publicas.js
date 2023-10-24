$(document).ready(function(){

	$(document).on('click','.ver_detalle_convocatoria',function(){
		var id_estandar_competencia_convocatoria = $(this).data('id_estandar_competencia_convocatoria');
		ConvocatoriasPublicas.detalle(id_estandar_competencia_convocatoria);
	});

	ConvocatoriasPublicas.tablero();

});

var ConvocatoriasPublicas = {

	tablero : function(inicial = true,pagina = 1, registros = 5){
		var post = {
			id_estandar_competencia : $('#id_estandar_competencia').val()
		};
		//condicional para el scroll de obtener los registros :-D
		if(inicial){
			$('#contenedor_resultados_convocatoria_ec').html(overlay);
			Comun.obtener_contenido_peticion_html(
				base_url + 'Publico/tablero/' + pagina + '/' + registros,
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
				base_url + 'Publico/tablero/' + pagina + '/' + registros,
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

	detalle :function(id_estandar_competencia_convocatoria = ''){
		Comun.obtener_contenido_peticion_html(base_url + 'Publico/detalle/'+ id_estandar_competencia_convocatoria,{},
			function(response){
				$('#contenedor_modal_primario').html(response);
				Comun.mostrar_ocultar_modal('#modal_convocatoria_ec_detalle',true);
			}
		);
	},

}
