<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Constancia CIGEDE UATX</title>

    <link href="<?= base_url() . 'extras/css/comunPDF.css' ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . 'extras/css/constancias/fdh.css' ?>" rel="stylesheet" type="text/css">
    <!-- CSS para el sistema -->
    <link href="<?= base_url() . 'extras/css/comun.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png' ?>" rel="shortcut icon">
</head>
<body>

    <?php foreach ($Constancia_Cigede as $index => $cigede): ?>
    <?php
    $CI = &get_instance();
    $CI->load->library('ciqrcode');
    $qr_image=rand().'.png';
    $params['data'] = $cigede->link_to_qr2;
    $params['level'] = 'l';
    $params['size'] = 2;
    $params['savename'] =FCPATH."imagenes/FDH".$qr_image;
    //if(file_exists($params['savename'])){
        if($CI->ciqrcode->generate($params))
        {
            //$data['img_url']=$qr_image;
            $cigede->fdh_img = $qr_image;
        }
    //}
    ?>


    <div class="salto_linea_espacio_100"></div>
    <div class="salto_linea_espacio_50"></div>
    <div class="salto_linea_espacio_20"></div>

    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        LA ENTIDAD DE CERTIFICACIÓN Y EVALUACIÓN DE COMPETENCIAS LABORALES
        <br>DE LA FUNDACIÓN PARA EL DESARROLLO HUMANO CÍVIKA, A.C.
        <br>OTORGA EL PRESENTE RECONOCIMIENTO A
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="nombre_instructor_curso centrado">
        <i><?= $cigede->Nombre_alumno ?></i>
    </div>

    <div class="salto_linea_espacio_10"></div>
    <div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
        POR HABER ACREDITADO SATISFACTORIAMENTE EL CURSO
    </div>

    <div class="salto_linea_espacio_10"></div>

    <!-- determinar el tamaño de letra dependiendo del numero de caracteres -->
    <?php $font_size ='40px';
    $leng_nombre_ctn = strlen($cigede->nombre_curso);
    if($leng_nombre_ctn > 75 && $leng_nombre_ctn <= 140){
    $font_size = '35px';
}if($leng_nombre_ctn > 140){
$font_size = '30px';
}
?>

<div class="nombre_curso_impartido centrado" style="font-size: <?=$font_size?>" >
    "<?= strMayusculas($cigede->nombre_curso) ?>"
</div>

<div class="salto_linea_espacio_10"></div>
<div class="titulo_constancia_instructor entidad_certificacion_titulo centrado">
    REALIZADO EN <?= strMayusculas($cigede->direccion_imparticion) ?>,
    <?= strMayusculas(rango_fecha_castellano($cigede->fecha_inicio, $cigede->fecha_fin)) ?>.
    CON UNA DURACIÓN DE <?= $cigede->duracion ?> HORAS.
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


<table class="w100">
 <tr>
    <td class="w26"></td>
    <td class="w50" align="center"> 
     <ul>
        <dt>   <img src="<?=base_url()?>/extras/imagenes/firmas/firma_dra_rmmm.png">
        </dt>
        <dt>__________________________________________________</dt>
        <dt class="titulo_constancia_instructor entidad_certificacion_titulo centrado">DRA. ROSA MARÍA MACÍAS MUÑOZ
            <br>DIRECTORA</dt>
        </ul>
    </td>
    <td align="center">
      <ul>
        <dt class="auten"> QR de Autenticidad</dt>
        <dt> <img  src="<?=base_url('imagenes/FDH'.$cigede->fdh_img); ?>" alt="QR_FDH"> </dt>
        <dt class="folio_constancia_instructor"> Folio: <?= $cigede->folio_habilidades ?></dt>
    </ul>
    <br><br>

</td>


</tr>
</table>
<div class="salto_linea_espacio_5"></div>


<?php if ($index < sizeof($Constancia_Cigede) - 1): ?>
<div class="salto_pagina"></div>
<?php endif; ?>

<?php endforeach; ?>

</body>
</html>