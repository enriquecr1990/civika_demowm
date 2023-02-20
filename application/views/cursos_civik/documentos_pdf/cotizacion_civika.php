<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Cotización Civika</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/cotizacion.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<p class="derecha contenido_cotizacion">
    <strong>
        Folio cotización: <?=$cotizacion->folio_cotizacion?>
        <br>Apizaco, Tlaxcala a <?= existe_valor($cotizacion->fecha_envio) ? fechaCastellano($cotizacion->fecha_envio) : 'Sin fecha' ?>
        <br>Asunto: Cotización Curso
        <br>"<?= $curso_taller_norma->nombre ?>"
    </strong>
</p>

<p class="izquierda contenido_cotizacion">
    Estimada: <?= $cotizacion->persona_recibe ?>
    <br><?= $cotizacion->empresa ?>
    <br>P R E S E N T E
</p>

<p class="justificado contenido_cotizacion">
    Nosotros somos Grupo Cívika, Una Empresa y una Fundación que desde hace más de 10 años hemos contribuido a la
    capacitación, profesionalización y aumento de la productividad y el desarrollo humano en empresas, cámaras,
    universidades, instituciones y municipios de los Estados de Puebla y Tlaxcala. Somos una Entidad de Certificación y
    Evaluación de Competencias Laborales del CONOCER. Tenemos más de 400 cursos con DC-3 registrados en la Secretaría de
    Trabajo y Previsión Social. Nuestros servicios tienen calidad ISO 9001:2015 y están validados por registros ante
    CONACYT, SEDESOL y TOEFL International.
</p>

<p class="justificado contenido_cotizacion">
    Agradecemos la oportunidad que nos brinda de poner a su amable consideración la presente cotización en materia de
    capacitación:
</p>

<table class="w100 bordes contenido_cotizacion">
    <tr>
        <td class="relleno centrado">Curso</td>
        <td class="relleno centrado w30">Objetivo</td>
        <td class="relleno centrado">Temario</td>
        <td class="relleno centrado">Participantes</td>
        <td class="relleno centrado">Duración</td>
        <td class="relleno centrado">Costo</td>
    </tr>
    <tr>
        <td><?=$curso_taller_norma->nombre?></td>
        <td class="justificado"><?=nl2br($curso_taller_norma->objetivo)?></td>
        <td class="justificado"><?=nl2br($cotizacion->temario)?></td>
        <td class="centrado"><?=$cotizacion->participantes?></td>
        <td><?=$cotizacion->duracion?> horas</td>
        <td>
            $<?=!is_null($cotizacion->iva) && $cotizacion->iva != '' && $cotizacion->iva != 0 ?
                number_format(($cotizacion->duracion * $cotizacion->costo_hora) * (1 + ($cotizacion->iva/100)),2) :
                number_format($cotizacion->duracion * $cotizacion->costo_hora,2)?>
        </td>
    </tr>
</table>

<p class="izquierda contenido_cotizacion">
    Notas comerciales
    <br>
</p>

<p class="justificado contenido_cotizacion">
    <?= nl2br($cotizacion->notas_comerciales) ?>
</p>

<!--<div class="salto_pagina"></div>-->

<p class="justificado contenido_cotizacion">
    Sin más por el momento, me reitero a sus órdenes para cualquier duda o comentario, haciendo válida la presente para
    enviarles un cordial saludo.
    <br>A t e n t a m e n t e
</p>

<p>
    <img src="<?= base_url() ?>extras/imagenes/firmas/vamm.PNG" width="120px">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="<?= base_url() ?>extras/imagenes/logo/sello_civika.png" width="120px">
</p>

<p class="izquierda contenido_cotizacion">
    Vanessa Alejandra Macías Martínez
    <br>Vinculación
    <br>Cel: (045) 241 135 62 52
    <br>E-mail: vanessa96vamm@hotmail.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vanessa@civika.edu.mx&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hola@civika.edu.mx
    <br>Visite nuestro website para conocer la oferta de educación continua abierta al público en general: <a
            href="http://civika.edu.mx" target="_blank">http://civika.edu.mx</a>
</p>

</body>
</html>