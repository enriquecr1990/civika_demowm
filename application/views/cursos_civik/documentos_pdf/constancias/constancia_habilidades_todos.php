<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">

    <title>Constancia de Habilidades</title>
    <link href="<?=base_url().'extras/css/comunPDF.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url().'extras/css/constancias/habilidades.css'?>" rel="stylesheet" type="text/css">

    <!-- CSS para el sistema -->
    <link href="<?= base_url().'extras/css/comun.css' ?>" rel="stylesheet" type="text/css">

    <link href="<?= base_url() . 'extras/imagenes/logo/icono.png'?>" rel="shortcut icon">
</head>

<body>
    <?php foreach ($Constancia as $index => $datos_cons): ?>
        <?php
        $CI = &get_instance();
        $CI->load->library('ciqrcode');
        $qr_image=rand().'.png';
        $params['data'] = $datos_cons->link_to_qr1;
        $params['level'] = 'l';
        $params['size'] = 1;
        $params['savename'] =FCPATH."imagenes/HB".$qr_image;
        //if(file_exists($params['savename'])){
            if($CI->ciqrcode->generate($params))
            {
                //$data['img_url']=$qr_image;
                $datos_cons->hb_img = $qr_image;
            }
        //}
        ?>


        <div class="salto_linea_espacio"></div>
        <div class="salto_linea_espacio"></div>

        <table style="font-size: 21px; padding-top: 120px !important; min-height: 100px; max-height: 100px; text-align: center" class="negrita contenido_const w100">
            <tr>
                <td>CONSTANCIA DE COMPETENCIAS O  HABILIDADES LABORALES</td>
            </tr>
            <tr>
                <td>Cívika Holding Latinoamérica, S.A. De C.V. (R.F.C. CHL111213MX1)</td>
            </tr>
            <tr>
                <td>Otorga la presente a:</td>
            </tr>
        </table>
        <div class="salto_linea_espacio_5"></div>

        <table style="min-height: 70px; max-height:70px; font-size: 40px; text-align: center" class="w100 nombre_alumno negrita">
            <tr>
                <td> <?=$datos_cons->Nombre_alumno?></td>
            </tr>
        </table>
        <div class="salto_linea_espacio_5"></div>

        <table style="min-height: 50px; max-height:50px; text-align: center; font-size: 21px" class="w100 contenido_const negrita">
            <tr>
                <td>Con Clave Única de Registro de Población: <?=$datos_cons->curp?></td>
            </tr>
            <tr>
                <td>Puesto: <?=$datos_cons->puesto?></td>
            </tr>
            <tr>
                <td>Por haber acreditado satisfactoriamente el curso:</td>
            </tr>
        </table>

        <!-- determinar el tamaño de letra dependiendo del numero de caracteres -->
        <?php $font_size ='45px';
        $leng_nombre_ctn = strlen($datos_cons->nombre_ctn);
        if($leng_nombre_ctn > 75 && $leng_nombre_ctn <= 140){
            $font_size = '40px';
        }if($leng_nombre_ctn > 140){
            $font_size = '35px';
        }
        ?>
        <table style="line-height:.8em; font-size: <?=$font_size?>; text-align: center" class="w100 nombre_curso negrita">
            <tr>
                <td style="vertical-align: middle; padding-left: 22px;padding-right:  22px;">"<?=$datos_cons->nombre_ctn?>"</td>
            </tr>
        </table>

        <table style="min-height: 40px; max-height:40px; vertical-align:middle; font-size: 19px; text-align: center" class="w100 contenido_const negrita">
            <tr>
                <td>Impartido el <?php echo fechaCastellano($datos_cons->fecha_fin); ?>, en el aula de capacitación del plantel Cívika 90342.</td>
            </tr>
            <tr>
                <td>Con una duración de <?=$datos_cons->duracion?> horas.</td>
            </tr>
        </table>

        <table style="min-height: 40px; max-height:40px; vertical-align:middle; font-size: 19px; text-align: center" class="w100 contenido_const negrita">
            <tr>
                <td class="w15"></td>
                <td style="text-align: center" class="w45">Catálogo nacional de Ocupaciones:  <?=$datos_cons->clave_ocupacion_especifica.' '.$datos_cons->ocupacion_especifica?>.</td>
                <td style="text-align: left">Área Temática: <?=$datos_cons->clave_area_tematica.' '.$datos_cons->Denominacion_Curso?>.</td>
            </tr>
        </table>

        <table style="min-height: 40px; max-height:40px; vertical-align:middle; font-size: 14px; text-align: center" class="w100 contenido_const negrita">
            <tr>
                <td>Los datos se asientan en esta constancia bajo protesta de decir verdad, apercibidos de la responsabilidad en que incurre todo aquel que no se conduce con verdad.</td>
            </tr>
        </table>

        <table style="min-height: 20px; max-height:20px; vertical-align:middle; font-size: 14px; text-align: center" class="w100 contenido_const negrita">
            <tr>
                <td class="w13"></td>
                <td style="text-align: left">Agente capacitador</td>
                <td style="text-align: left" class="w58">Por la Comisión Mixta de Capacitación, Adiestramiento y Productividad</td>
            </tr>
        </table>

        <?php if(!(isset($datos_cons->ruta_documento_firma) && existe_valor($datos_cons->ruta_documento_firma))): ?>
            <div class="salto_linea_espacio"></div>
            <div class="salto_linea_espacio_13"></div>
            <div class="salto_linea_espacio_7"></div>
            <?php if($datos_cons->salto_linea_dc3_habilidades): ?>
                <div class="salto_linea_espacio_13"></div>
                <div class="salto_linea_espacio_1"></div>
            <?php endif;?>
        <?php else: ?>
            <div class="salto_linea_espacio_13"></div>
            <div class="salto_linea_espacio_7"></div>
        <?php endif; ?>

        <?php if(isset($datos_cons->ruta_documento_firma) && existe_valor($datos_cons->ruta_documento_firma)): ?>
            <table style="min-height: 20px; max-height:20px; font-size: 14px; font-weight: bold" class="w100">
                <tr>
                    <td class="w5"></td>
                    <td class="contenido_const w26" style="text-align: center">
                        <img src="<?=base_url().$datos_cons->ruta_documento_firma?>" alt="Firma instructor" width="100px" height="65px"><br>
                    </td>
                    <td class="contenido_const w26" style="text-align: center"></td>
                    <td class="contenido_const w26" style="text-align: center"></td>
                    <td class="w10"></td>
                </tr>
            </table>

        <?php endif; ?>

        <table style="min-height: 20px; max-height:20px; font-size: 14px; font-weight: bold" class="w100">
            <tr>
                <td class="w5"></td>
                <td class="contenido_const w26" style="text-align: center">
                    Instructor
                </td>
                <td class="contenido_const w26" style="text-align: center">Por la empresa</td>
                <td class="contenido_const w26" style="text-align: center">Por los trabajadores</td>
                <td class="w10"></td>
            </tr>
            <tr>
                <td class="w5"></td>
                <td class="contenido_const w26" style="text-align: center">
                    <?=strMayusculas($datos_cons->Nombre_Instructor)?>
                </td>
                <td class="contenido_const w26" style="text-align: center"><?=strMayusculas($datos_cons->representante_legal)?> </td>
                <td class="contenido_const w26" style="text-align: center"><?=strMayusculas($datos_cons->representante_trabajadores)?></td>
                <td class="w10"></td>
            </tr>
        </table>

        <table class="w100">
            <tr>
                <td class="w45"></td>
                <td class="w30">  </td>
                <td class="folio" align="center">
                  <ul>
                    <dt> <img  src="<?=base_url('imagenes/HB'.$datos_cons->hb_img); ?>" alt="QR_habilida"> </dt><br>
                    <dt> Folio: </dt>
                    <dt><?=$datos_cons->folio_habilidades?></dt>
                </ul class="salto_linea_espacio_1">
                
            </td>
            
            
        </tr>
    </table>
    

    <?php if($index < $numero_alumnos - 1):?>
        <div class="salto_pagina"></div>
    <?php endif;?>
<?php endforeach; ?>
</body>
</html>