<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Constancia CIGEDE UATX</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <!-- CSS para el sistema -->
    <link href="<?= base_url() . 'extras/css/comun.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

<div class="salto_linea_espacio"></div>
<div class="salto_linea_espacio"></div>
<div class="salto_linea_espacio"></div>
<div class="salto_linea_espacio_20"></div>

<?php foreach ($Constancia_Cigede as $index => $cigede): ?>

    <table style="font-size: 16px; padding-top: 120px !important; min-height: 100px; max-height: 100px; text-align: center"
           class="contenido_const_cigede w100 texto_blanco">
        <tr>
            <td>LA COORDINACIÓN INSTITUCIONAL DE GESTIÓN Y DESARROLLO EMPRESARIAL</td>
        </tr>
        <tr>
            <td>DE LA UNIVERSIDAD AUTÓNOMA DE TLAXCALA, Y LA ENTIDAD DE CERTIFICACÓN Y EVALUACIÓN DE</td>
        </tr>
        <tr>
            <td>COMPETENCIAS DE LA FUNDACIÓN PÁRA EL DESARROLLO HUMANO CÍVIKA, A.C.</td>
        </tr>
    </table>
    <table style="min-height: 70px; max-height:70px; font-size: 16px; text-align: center"
           class="w100 contenido_const_cigee texto_blanco">
        <tr>
            <td>OTORGAN LA PRESENTE CONSTANCIA A:</td>
        </tr>
    </table>
    <div class="salto_linea_espacio_7"></div>
    <div class="salto_linea_espacio_10"></div>
    <table style="min-height: 50px; max-height:50px; text-align: center; font-size: 26px"
           class="w100 contenido_const_cigede negrita">
        <tr>
            <td style=""><i><?= $cigede->Nombre_alumno ?></i></td>
        </tr>
    </table>
    <div class="salto_linea_espacio_7"></div>
    <table style="min-height: 50px; max-height:50px; text-align: center; font-size: 16px;"
           class="w100 contenido_const_cigede">
        <tr>
            <td>POR HABER ACREDITADO SATISFACTORIAMENTE EL TALLER:</td>
        </tr>
    </table>
    <div class="salto_linea_espacio_3"></div>

    <table style="min-height: 50px; max-height:50px; text-align: center; font-size: 26px;"
           class="w100 contenido_const_cigede negrita">
        <tr>
            <td style="padding-left: 70px; padding-right: 70px; ">
                <i>"<?= strMayusculas($cigede->nombre_curso_comercial) ?>"</i></td>
        </tr>
    </table>
    <div class="salto_linea_espacio_7"></div>
    <table style="font-size: 16px; padding-top: 120px !important; min-height: 100px; max-height: 100px; text-align: center"
           class="contenido_const_cigede w100">
        <tr>
            <td>CON UNA DURACIÓN DE <?= $cigede->duracion ?> HORAS.</td>
        </tr>
        <tr>
            <td>IMPARTIDO EL <?php $cadena = fechaCastellano($cigede->fecha_fin);
                echo $cadena_devuelta = strtoupper($cadena); ?>, EN EL CAMPUS CÍVIKA DE LA CIUDAD DE APIZACO.
            </td>
        </tr>
        <tr>
            <td>Apizaco, Tlaxcala., a <?php $str = $cigede->fecha_fin;
                echo fechaCastellano(strtoupper($str)); ?>.
            </td>
        </tr>
    </table>
    <div class="salto_linea_espacio"></div>
    <div class="salto_linea_espacio_15"></div>
    <div class="salto_linea_espacio_10"></div>
    <?php if ($cigede->salto_linea_firma): ?>
        <div class="salto_linea_espacio_10"></div>
        <div class="salto_linea_espacio_5"></div>
    <?php endif; ?>

    <table style="min-height: 20px; max-height:20px; font-size: 12px; font-weight: bold"
           class="contenido_const_cigede w100">
        <tr>
            <td class="w5"></td>
            <td class=" w26 texto_blanco" style="text-align: center">MTRO. JOSE LUIS PARRA GUTIERREZ</td>
            <td class=" w26 texto_blanco" style="text-align: center">DRA. ROSA MACÍAS MUÑOZ</td>
            <td class=" w26"
                style="text-align: center; "><?= strMayusculas($cigede->Nombre_Instructor) ?></td>
            <td class="w10"></td>
        </tr>
        <tr>
            <td class="w5"></td>
            <td class="w26 texto_blanco" style="text-align: center">COORDINADOR CIGEDE UATX</td>
            <td class="w26 texto_blanco" style="text-align: center">DIRECTORA E.C.E. CÍVIKA</td>
            <td class="w26" style="text-align: center; ">INSTRUCTOR</td>
            <td class="w10"></td>
        </tr>
    </table>

    <?php if ($index < $numero_alumnos - 1): ?>
        <div class="salto_pagina"></div>
        <div class="salto_linea_espacio"></div>
        <div class="salto_linea_espacio"></div>
        <div class="salto_linea_espacio"></div>
        <div class="salto_linea_espacio_20"></div>
    <?php endif; ?>

<?php endforeach; ?>
</body>
</html>