<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<meta name="author" content="Enrique Corona Ricaño">
	<meta name="description" content="Sistema Integral de Portafolio de Evidencias PED  Civika Holding Latinoamérica, S.A. de C.V.">
	<meta name="keywords" content="Portafolio de evidencias Civika, PED Civika, Certificaciones Walmart México, Walmart México">

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

	<title>Certificaciones WM MXCAM - Cívika</title>
</head>
<body class="layout-top-nav" style="height: auto;">
<div id="backgroundImage" class="fullscreen-bg"></div>
<div class="wrapper">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="<?=base_url()?>assets/imgs/logos/wm_logo.png" alt="Certificaciones Wal-Mart Civika Holding" height="60" width="60">
	</div>

	<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
		<div class="container">
			<a href="<?=base_url()?>" class="navbar-brand">
				<img src="<?=base_url()?>assets/imgs/logos/icono.png" alt="WalMart" class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">Certificaciones</span>
			</a>
			<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse order-3" id="navbarCollapse">

				<ul class="navbar-nav">
					<li class="nav-item">
						<a href="index3.html" class="nav-link">Home</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">Contact</a>
					</li>
			
				</ul>
			</div>
		</div>
	</nav>
