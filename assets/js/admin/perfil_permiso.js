$(document).ready(function(){

	$(document).on('change','#cat_perfil',function(){
		PerfilPermisos.procesar_modulos_permiso_perfil();
	});

	$(document).on('click','.input_check_modulo_permiso',function(){
		var id_cat_modulo = $(this).data('id_cat_modulo');
		var id_cat_permiso = $(this).val();
		var is_checked = $(this).is(':checked');
		if(is_checked){
			PerfilPermisos.agregar_modulo_permiso(id_cat_modulo,id_cat_permiso);
		}else{
			PerfilPermisos.quitar_modulo_permiso(id_cat_modulo,id_cat_permiso);
		}
	});

	PerfilPermisos.procesar_modulos_permiso_perfil();

});

var PerfilPermisos = {

	procesar_modulos_permiso_perfil : function(){
		var id_cat_perfil = $('#cat_perfil').val();
		$('.input_check_modulo_permiso').removeAttr('checked');
		PerfilPermisos.obtener_modulo_permiso(id_cat_perfil);
	},

	obtener_modulo_permiso : function(id_cat_perfil){
		Comun.obtener_contenido_peticion_json(
			base_url + 'PerfilPermiso/modulo_permiso/'+id_cat_perfil,{},
			function(response){
				if(response.success){
					$.each(response.modulo_permiso,function(index,it){
						$('#check_permiso_'+it.id_cat_modulo+'_'+it.id_cat_permiso).attr('checked',true);
					});
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	agregar_modulo_permiso : function(id_cat_modulo,id_cat_permiso){
		var post = {
			id_cat_perfil : $('#cat_perfil').val(),
			id_cat_modulo : id_cat_modulo,
			id_cat_permiso : id_cat_permiso
		};
		Comun.obtener_contenido_peticion_json(
			base_url+'PerfilPermiso/agregar_modulo_permiso',post,
			function(response){
				if(!response.success){
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	},

	quitar_modulo_permiso : function(id_cat_modulo,id_cat_permiso){
		var post = {
			id_cat_perfil : $('#cat_perfil').val(),
			id_cat_modulo : id_cat_modulo,
			id_cat_permiso : id_cat_permiso
		};
		Comun.obtener_contenido_peticion_json(
			base_url+'PerfilPermiso/quitar_modulo_permiso',post,
			function(response){
				if(!response.success){
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	}

}
