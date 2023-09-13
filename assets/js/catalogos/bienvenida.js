$(document).ready(function (){

	$(document).on('click','#btn_guardar_msg_bienvenida',function(){
		CatBienvenida.guardar_msg_bienvenida();
	});

	CatBienvenida.iniciar_editor_summernote();

});

var CatBienvenida = {

	iniciar_editor_summernote : function(){
		$('#textarea_msg_bienvenida').summernote({
			minHeight : 300,
			lang : 'es-ES',
			placeholder : 'Escribe el mensaje para el candidato de bienvenida',
			codeviewFilter: false,
			codeviewIframeFilter: true,
			toolbar : [
				['style', ['bold', 'italic', 'underline']],
				['font',['fontname','fontsize','forecolor']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'picture', 'video']],
				['view', [ 'help']],
			]
		});
	},

	guardar_msg_bienvenida : function(){
		var id_cat_msg_bienvenida = $('#input_id_msg_bienvenida').val();
		Comun.obtener_contenido_peticion_json(
			base_url + 'Catalogos/guardar_msg_bienvenida/'+ id_cat_msg_bienvenida,
			{nombre : $('#textarea_msg_bienvenida').val()},
			function(response){
				if(response.success){
					Comun.mensajes_operacion(response.msg);
				}else{
					Comun.mensajes_operacion(response.msg,'error');
				}
			}
		);
	}

};
