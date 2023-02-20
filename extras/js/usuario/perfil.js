$(document).ready(function () {

    // cachar el evento por id de un boton (selector del JavaScript/Jquery)
    $('body').on('click', '#input_recibir_correo', function () {
        var value_input = $(this).is(":checked");
        var suscripcion_correo = "no";
        if (value_input == true) {
            suscripcion_correo = "si";
        }
        $.ajax({
            type: "POST",
            url: base_url + 'ControlUsuarios/actualizar_suscripcion_correo/' + suscripcion_correo,
            data: {},
            // como me va a responder la URL (json,html)
            dataType: "json",
            success: function (response) {
                if (response.exito) {
                    Comun.mensaje_operacion('success', response.msg);
                } else {
                    Comun.mensaje_operacion('error', response.msg);

                }
            },
            error: function (xhr) {
                alert(xhr.status);

            }
        });
        //alert(suscripcion_correo);
    });

    Comun.funcion_fileinput('Actualizar foto de perfil');

    Perfil.iniciar_carga_archivos_foto_perfil();
    Perfil.iniciar_carga_archivos_firma_instructor();
});

var Perfil = {

    iniciar_carga_archivos_foto_perfil: function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var img_profile_previus = '';
        $('.fileUploadFotoPerfil').fileupload({
            url: base_url + 'Uploads/uploadFileImgFotoPerfil',
            dataType: 'json',
            start: function () {
                img_profile_previus = $('#container_foto_perfil').html();
                $('#container_foto_perfil').html(loader_gif_transparente);
            }, //tiempo de ejecucion
            add: function (e, data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\", ""); //use to chrome
                data.formData = {
                    filename: nombre_archivo,
                    id_usuario: data.fileInput.data('id_usuario')
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if (!regExp.test(uploadFile.name.toLowerCase())) {
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error', 'Archivo no es una imagen admitida', '', 8000);
                    goUpload = false;
                }
                if (uploadFile.size > 15000000) {
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error', 'El archivo es mayor a 5 Mb', '', 8000);
                    goUpload = false;
                }
                if (goUpload) {
                    data.submit();
                }
            },
            done: function (e, data) {
                if (data.result.exito) {
                    var img_perfil = data.result.documento.ruta_documento;
                    $('img.img_perfil_menu').attr('src', img_perfil);
                    $('#container_foto_perfil').html('<img class="img-thumbnail img_perfil" src="' + img_perfil + '">');
                } else {
                    Comun.mensaje_operacion('error', data.result.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Comun.mensaje_operacion('error', 'Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde', '', 8000);
            }
        });
    },


    iniciar_carga_archivos_firma_instructor: function () {
        //funcion para cargar archivo via ajax
        var nombre_archivo;
        var html_respuesta = '';
        var img_profile_previus = '';
        $('.fileUploadFirmaInstructor').fileupload({
            url: base_url + 'Uploads/uploadFileComunImg',
            dataType: 'json',
            start: function () {
                $('#contenedor_firma_instructor').html(loader_gif_transparente);
            }, //tiempo de ejecucion
            add: function (e, data) {
                nombre_archivo = data.fileInput.val().replace("C:\\fakepath\\", ""); //use to chrome
                data.formData = {
                    filename: nombre_archivo,
                    id_usuario: data.fileInput.data('id_usuario')
                };
                var goUpload = true;
                var uploadFile = data.files[0];
                var regExp = "\.(" + extenciones_files_img + ")$";
                regExp = new RegExp(regExp);
                if (!regExp.test(uploadFile.name.toLowerCase())) {
                    //alert('Archivo no es una imagen admitida');
                    Comun.mensaje_operacion('error', 'Archivo no es una imagen admitida', '', 8000);
                    goUpload = false;
                }
                if (uploadFile.size > 15000000) {
                    //alert('el archivo es mayor a 5 Mb');
                    Comun.mensaje_operacion('error', 'El archivo es mayor a 5 Mb', '', 8000);
                    goUpload = false;
                }
                if (goUpload) {
                    data.submit();
                }
            },
            done: function (e, data) {
                if (data.result.exito) {
                    var img_perfil = data.result.documento.ruta_documento;
                    var input_hidden_id_documento_firma = '<input type="hidden" name="usuario_instructor[id_documento_firma]" value="' + data.result.documento.id_documento + '">';
                    $('#contenedor_firma_instructor').html('<img class="" width="100px" height="70px" src="' + img_perfil + '">');
                    $('#contenedor_firma_instructor').append(input_hidden_id_documento_firma);
                } else {
                    Comun.mensaje_operacion('error', data.result.msg);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Comun.mensaje_operacion('error', 'Ocurrio un error al tratar de subir su archivo, favor de intentar más tarde', '', 8000);
            }
        });
    },

}