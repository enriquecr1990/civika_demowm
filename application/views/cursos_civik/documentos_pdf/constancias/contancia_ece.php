<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Constancia ECE</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/constancias/ece.css' ?>" rel="stylesheet" type="text/css">
    <!-- CSS para el sistema -->
    <link href="<?= base_url() . 'extras/css/comun.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<?php foreach ($Constancia_Cigede as $index => $cigede): ?>

    <div class="salto_linea_espacio_100"></div>
    <div class="salto_linea_espacio_50"></div>
    <div class="salto_linea_espacio_10"></div>

    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        LA ENTIDAD DE CERTIFICACIÓN Y EVALUACIÓN DE COMPETENCIAS LABORALES ECE312-17
        <br>DE LA FUNDACIÓN PARA EL DESARROLLO HUMANO CÍVIKA, A.C.
        <br>OTORGA LA PRESENTE CONSTANCIA A
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="nombre_instructor_curso centrado">
        <i><?= $cigede->Nombre_alumno ?></i>
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        POR HABER ACREDITADO CON MÁS DEL 98% DE EFECTIVIDAD EL CUESTIONARIO DE CONOCIMIENTOS
        <br>DEL INSTRUMENTO DE EVALUACIÓN DE COMPETENCIA DEL ESTANDAR
    </div>

    <div class="salto_linea_espacio_10"></div>

    <div class="nombre_curso_impartido centrado" style="font-size: <?=$font_size?>" >
        "<?= strMayusculas($cigede->nombre_curso) ?>"
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        APLICADO <!--<?= strMayusculas($cigede->direccion_imparticion) ?>-->
        <?= strMayusculas(rango_fecha_castellano($cigede->fecha_inicio, $cigede->fecha_fin)) ?>.
        POR LO QUE EN UN TÉRMINO NO MAYOR A 28
        <br>DÍAS HÁBILES, RECIBIRÁ SU CERTIFICADO DE COMPETENCIA LABORAL
    </div>

    <div class="salto_linea_espacio_20"></div>
    <!--
    <?php if (strlen($cigede->nombre_curso_comercial) <= 40): ?>
        <div class="salto_linea_espacio_20"></div>
        <div class="salto_linea_espacio_10"></div>
    <?php endif; ?>
    <?php if (strlen($cigede->nombre_curso_comercial) > 40 && strlen($cigede->nombre_curso_comercial) <= 75): ?>
        <div class="salto_linea_espacio_20"></div>
    <?php endif; ?>
    -->
    <div class="centrado">
        <img src="<?=base_url()?>/extras/imagenes/firmas/firma_jlsh.png">
        <br>__________________________________________________
    </div>
    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        DR. JOSÉ LUIS SALAZAR HERNÁNDEZ
        <br>DIRECTOR
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="folio_constancia_instructor centrado">
        Folio: <?= $cigede->folio_habilidades ?>
    </div>

    <?php if ($index < sizeof($Constancia_Cigede) - 1): ?>
        <div class="salto_pagina"></div>
    <?php endif; ?>

<?php endforeach; ?>

</body>
</html>