<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Evaluacion Civika</title>


    <link href="<?= base_url() . 'extras/css/pdf/evaluacion_ctn.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<!-- datos del usuario -->
<table class="w-100 bordes_gafete">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td class="w-50 izquierda">
            <?php if(isset($usuario->foto_perfil) && is_object($usuario->foto_perfil)): ?>
                <img src="<?=$usuario->foto_perfil->ruta_documento?>" class="img_evaluacion_conocimiento">
            <?php else: ?>
                <img src="<?=base_url()?>extras/imagenes/logo/person.png">
            <?php endif; ?>
        </td>
        <td class="w-50 centrado">
            <img src="<?=$qr_image_WM?>" width="150px" height="150px">
        </td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td colspan="2">
            <span class="titulo_empresa"><?=$empresa->nombre?></span>
            <br><span class="texto_ayuda_evaluacion">Empresa contratista</span>
        </td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td class="w-100" colspan="2" style="background-color: #FDBB30 !important; " >
            <?php if(isset($usuario) && is_object($usuario)): ?>
                <span><?=$usuario->nombre.' '.$usuario->apellido_p.' '.$usuario->apellido_m?></span>
            <?php endif; ?>
        </td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td><span class="texto_ayuda_evaluacion">Nombre</span></td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td class="w-100" colspan="2" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->curp?></span>
            <?php endif; ?>
        </td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td colspan="2"><span class="texto_ayuda_evaluacion">CURP</span></td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td class="w-100" colspan="2" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->puesto?></span>
            <?php endif; ?>
        </td>
        <td class="w10"></td>
    </tr>
    <tr>
        <td class="w10"></td>
        <td colspan="2"><span class="texto_ayuda_evaluacion">Puesto</span></td>
        <td class="w10"></td>
    </tr>

    <tr>
        <td class="w10"></td>
        <td colspan="2" class="centrado">
            <img src="<?= base_url('extras/imagenes/logo/logo_wm_constancias.jpg') ?>" width="200px" height="50px">
        </td>
        <td class="w10"></td>
    </tr>
</table>


</body>
</html>