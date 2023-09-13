<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<meta name="author" content="Enrique Corona Ricaño">
	<meta name="description" content="Sistema Integral de Portafolio de Evidencias PED  Civika Holding Latinoamérica, S.A. de C.V.">
	<meta name="keywords" content="Portafolio de evidencias Civika, PED Civika, https://civika.edu.mx">

	<!-- css para el admin lte -->
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frm/adm_lte/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frm/adm_lte/dist/css/adminlte.min.css">
	<!-- CSS para el plugin de las notificaciones del sistema -->
	<link href="<?=base_url()?>assets/frm/watnotif/css/bubble/watnotif.right-top-bubble.min.css" rel="stylesheet" type="text/css">

	<link href="<?= base_url() ?>assets/css/comun.css" rel="stylesheet">

	<!-- CSS extras -->
	<?php if (isset($extra_css) && is_array($extra_css)): ?>
		<?php foreach ($extra_css as $css): ?>
			<link href="<?=$css?>?ver=<?php echo uniqid(); ?>" rel="stylesheet" type="text/css">
		<?php endforeach;?>
	<?php endif;?>

	<!-- icono -->
	<link href="<?=base_url()?>assets/imgs/logos/icono.png" rel="shortcut icon">

	<title>Sistema Integral PED</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="<?=base_url()?>assets/imgs/logos/icono.png" alt="Civika Holding" height="60" width="60">
	</div>

	<!-- Navbar -->
	<?php $this->load->view('menu/top'); ?>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<?php $this->load->view('menu/base'); ?>
	<!-- /.Main Sidebar Container -->
