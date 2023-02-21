<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="author" content="Mtro. Enrique Corona Ricaño - Civika Holding Latinoamerica">
    <meta name="description" content="Evaluaciones online para grupo Walmart Mexico - Civika Holding Latinoamérica, S.A. de C.V.">
    <meta name="keywords" content="Evaluaciones online Civika Holding, Cívika, Civika Holding, civika.com.mx">

    <!-- CSS de bootstrap -->
    <link href="<?=base_url() . 'extras/plugins/bootstrap/css/bootstrap.min.css'?>" rel="stylesheet" type="text/css">

    <!--CSS for templates-->
    <link href="<?=base_url() . 'extras/template/arcana/css/main.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url() . 'extras/template/shards/css/shards.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url() . 'extras/template/shards/css/shards-demo.css'?>" rel="stylesheet" type="text/css">

    <!-- CSS del plugin de fileupload -->
    <link href="<?=base_url() . 'extras/plugins/fileinput/css/fileinput.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url() . 'extras/plugins/fileupload/css/jquery.fileupload.css'?>" rel="stylesheet" type="text/css">

    <!-- CSS para el plugin de las notificaciones del sistema -->
    <link href="<?=base_url()?>extras/plugins/watnotif/css/bubble/watnotif.right-top-bubble.min.css" rel="stylesheet" type="text/css">

    <!-- CSS para el sistema -->
    <link href="<?=base_url() . 'extras/css/comun.css'?>?ver=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css">

    <!-- CSS extras -->
    <?php if (isset($extra_css) && is_array($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link href="<?=$css?>?ver=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css">
        <?php endforeach;?>
    <?php endif;?>

    <!-- icono -->
    <link href="<?=base_url() . 'extras/imagenes/logo/wm_logo.png'?>" rel="shortcut icon">

    <title>Seguridad-WM</title>
</head>
<body>
<div id="backgroundImage" class="fullscreen-bg"></div>
<div id="page-wrapper">

    <!-- Header -->
    <div id="header">

        <!-- Logo -->
        <span id="logo" style="display: none">
            <img src="<?=base_url()?>extras/imagenes/logo/civika.png" alter="Fundación CIVIK" width="6%"> Centro Educativo Campus Cívika
        </span>
        <!-- se carga el menu -->

        <?php $this->load->view('default/menu')?>

    </div><!-- end header -->

