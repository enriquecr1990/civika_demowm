$(document).ready(function(){

	ValidacionDatos.validar_datos_perfil();

});

var ValidacionDatos = {

	datos_validos : true,

	validar_datos_perfil : function(){
		Comun.obtener_contenido_peticion_json(
			base_url + 'Perfil/validacion_campos_perfil',{},
			function(response){
				if(response.success){
					if(response.usuario_update_datos){
						var msg_validacion = '';
						$.each(response.msg,function(index,msg){
							msg_validacion += '<li>'+msg+'</li>';
						});
						var msg_general = '' +
							'<div class="callout callout-danger">' +
								'<h5>Información importante</h5>' +
								'<p>' +
									'Se ha detectado en el sistema que no ha actualizado toda la información de su perfil, se le pide de favor lo realize; ' +
									'a continuación aparece un listado de los datos que le faltan' +
								'</p>' +
								'<p>'+msg_validacion+'</p>' +
								'<p>Puede dar clic <a href="'+base_url+'perfil">aquí</a> para poder actualizar sus datos.</p>' +
							'</div>';

						Comun.mostrar_mensaje_advertencia(msg_general);
						$('.btn_cerrar_informacion_sistema').fadeOut();
						ValidacionDatos.datos_validos = false;
					}
				}
			}
		);
	}

};
