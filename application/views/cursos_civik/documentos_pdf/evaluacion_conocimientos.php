<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Evaluacion Civika</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/pdf/evaluacion_ctn.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<table class="w100">
    <tr>
        <td class="derecha">
            <img src="<?= base_url() . 'extras/imagenes/logo/certificacion_wm.png' ?>" width="100%" height="190px" alt=""/>
        </td>
    </tr>
</table>
<br>
<span class="titulo_evaluacion_conocimientos">EVALUACIÓN DE CONOCIMIENTOS</span>
<br>
<br>
<span class="titulo_evaluacion_conocimientos"><strong><?=isset($publicacion->nombre) ? $publicacion->nombre : 'SUPERVISIÓN DE SEGURIDAD EN OBRAS NUEVAS Y REMODELACIONES PARA CASCO ROJO DE CONTRATISTAS.'?></strong></span>
<br>
<br>

<!-- datos del usuario -->
<table class="w100">
    <tr>
        <td class="w-50 izquierda">
            <?php if(isset($usuario->foto_perfil) && is_object($usuario->foto_perfil)): ?>
                <img src="<?=$usuario->foto_perfil->ruta_documento?>" class="img_evaluacion_conocimiento">
            <?php else: ?>
                <img src="<?=base_url()?>extras/imagenes/logo/person.png">
            <?php endif; ?>
            <br>
            <span class="titulo_empresa"><?=$empresa->nombre?></span>
            <br>
            <span class="texto_ayuda_evaluacion">Empresa contratista</span>
        </td>
        <td class="w-50 bordes centrado">
            <span class="titulo_calificacion" style="width: 100% !important;">CALIFICACIÓN</span>
            <br>
            <?php $color_calificacion = 'red';
            if($calificacion > 79 && $calificacion < 95){
                $color_calificacion = 'yellow';
            }if($calificacion > 94){
                $color_calificacion = 'green';
            }
            ?>

            <span class="calificacion" style="color: <?=$color_calificacion?>"><?=$calificacion?></span>
        </td>
    </tr>
</table>

<br>

<table class="w100">
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; " >
            <?php if(isset($usuario) && is_object($usuario)): ?>
                <span><?=$usuario->nombre.' '.$usuario->apellido_p.' '.$usuario->apellido_m?></span>
            <?php endif; ?>
        </td>
        <td class="w10"></td>
        <td class="w-50 centrado" rowspan="6">
            <img src="<?=$qr_image_WM?>" width="150px" height="150px">
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">Nombre</span></td>
    </tr>
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->curp?></span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">CURP</span></td>
    </tr>
    <tr>
        <td class="w-50" style="background-color: #FDBB30 !important; ">
            <?php if(isset($usuario_alumno) && is_object($usuario_alumno)): ?>
                <span><?=$usuario_alumno->puesto?></span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td><span class="texto_ayuda_evaluacion">Puesto</span></td>
    </tr>

</table>
<br>
<table class="w100">
    <tr>
        <td class="w5"></td>
        <td class="centrado" style="background-color: red;"><span class="semaforo_evaluacion_rojo">Aun no competente de 0% a 79%</span></td>
        <td class="w5"></td>
        <td class="centrado" style="background-color: yellow" ><span class=" semaforo_evaluacion">Competente de 80% a 94%</span></td>
        <td class="w5"></td>
        <td class="centrado" style="background-color: green"><span class=" semaforo_evaluacion">Competente de 95% a 100%</span></td>
        <td class="w5"></td>
    </tr>
</table>

</body>
</html>