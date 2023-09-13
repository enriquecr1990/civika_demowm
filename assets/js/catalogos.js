$(document).ready(function() {

	$(document).on('change','.slt_cat_estado',function(){
		var slt = $(this);
		Catalogos.obtener_municipios(slt);
	});

	$(document).on('change','.slt_cat_municipio',function(){
		var slt = $(this);
		Catalogos.obtener_localidades(slt);
	});

});

var Catalogos = {

	slt_procesando: '<option value="">Buscando...</option>',

	obtener_municipios: function (slt) {
		var id_slt_municipios = slt.data('id_slt_municipios');
		var id_cat_estado = slt.val();
		$(id_slt_municipios).html(Catalogos.slt_procesando);
		Comun.obtener_contenido_peticion_json(
			base_url + 'Catalogos/municipio/' + id_cat_estado, {},
			function (response) {
				if (response.success) {
					var html_options = '<option value="">--Seleccione--</option>';
					$.each(response.data.cat_municipio, function (index, municipio) {
						html_options += '<option value="' + municipio.id_cat_municipio + '">' + municipio.nombre + '</option>';
					});
					$(id_slt_municipios).html(html_options);
					$(id_slt_municipios).removeAttr('disabled');
				} else {
					Comun.mensajes_operacion(response.msg, 'error');
				}
			}
		);
	},

	obtener_localidades : function (slt) {
		var id_slt_localidades = slt.data('id_slt_localidades');
		var id_cat_municipio = slt.val();
		$(id_slt_localidades).html(Catalogos.slt_procesando);
		Comun.obtener_contenido_peticion_json(
			base_url + 'Catalogos/localidad/' + id_cat_municipio, {},
			function (response) {
				if (response.success) {
					var html_options = '<option value="">--Seleccione--</option>';
					$.each(response.data.cat_localidad, function (index, localidad) {
						html_options += '<option value="' + localidad.id_cat_localidad + '">' + localidad.nombre + '</option>';
					});
					$(id_slt_localidades).html(html_options);
					$(id_slt_localidades).removeAttr('disabled');
				} else {
					Comun.mensajes_operacion(response.msg, 'error');
				}
			}
		);
	},


};
