<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Constancia CIGEDE UATX</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url().'extras/css/constancias/instructores.css'?>" rel="stylesheet" type="text/css">
    <!-- CSS para el sistema -->
    <link href="<?= base_url() . 'extras/css/comun.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<div class="salto_linea_espacio"></div>
<div class="salto_linea_espacio"></div>
<div class="salto_linea_espacio_10"></div>
<div class="salto_linea_espacio_20"></div>

<div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
    LA ENTIDAD DE CERTIFICACIÓN Y EVALUACIÓN DE COMPETENCIAS
    <br>LABORALES CÍVIKA
    <br>OTORGA EL PRESENTE RECONOCIMIENTO A
</div>

<div class="salto_linea_espacio_10"></div>
<div class="nombre_instructor_curso centrado">
    <?=strMayusculas($instructor->nombre.' '.$instructor->apellido_p.' '.$instructor->apellido_m)?>
</div>

<div class="salto_linea_espacio_10"></div>
<div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
    POR LA IMPARTICIÓN DEL CURSO DE CAPACITACIÓN DENOMINADO
</div>

<div class="salto_linea_espacio_10"></div>
<div class="nombre_curso_impartido centrado">
    "<?=strMayusculas($publicacion_ctn->nombre_curso_comercial)?>"
</div>

<div class="salto_linea_espacio_10"></div>
<div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
    REALIZADO EN <?=strMayusculas($publicacion_ctn->direccion_imparticion)?>,
    <?=strMayusculas(rango_fecha_castellano($publicacion_ctn->fecha_inicio,$publicacion_ctn->fecha_fin))?>.
    CON UNA DURACIÓN DE <?=$publicacion_ctn->duracion?> HORAS.
</div>

<div class="salto_linea_espacio_20"></div>
<div class="salto_linea_espacio_20"></div>
<?php if(strlen($publicacion_ctn->nombre_curso_comercial) <= 40): ?>
    <div class="salto_linea_espacio_20"></div>
    <div class="salto_linea_espacio_10"></div>
<?php endif; ?>
<?php if(strlen($publicacion_ctn->nombre_curso_comercial) > 40 && strlen($publicacion_ctn->nombre_curso_comercial) <= 75): ?>
    <div class="salto_linea_espacio_20"></div>
<?php endif; ?>
<div class="centrado">
    __________________________________________________
</div>
<div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
    DRA. ROSA MARÍA MACÍAS MUÑOZ
    <br>DIRECTORA
</div>

<div class="salto_linea_espacio_10"></div>
<div class="folio_constancia_instructor">
    Folio: IMP-0<?=date('y',strtotime($publicacion_ctn->fecha_fin))?>-<?=date('is')?>
</div>

</body>
</html>