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

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frm/adm_lte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frm/adm_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/frm/adm_lte/dist/css/adminlte.min.css">

	<link href="<?= base_url() ?>assets/css/comun.css" rel="stylesheet">

	<!-- CSS para el plugin de las notificaciones del sistema -->
	<link href="<?=base_url()?>assets/frm/watnotif/css/bubble/watnotif.right-top-bubble.min.css" rel="stylesheet" type="text/css">


	<!-- icono -->
	<link href="<?=base_url()?>assets/imgs/logos/icono.png" rel="shortcut icon">

	<title>Certificaciones WalMart Civika</title>
</head>
<body class="hold-transition login-page">
<div id="backgroundImage" class="fullscreen-bg"></div>
<div class="login-box">
	<!-- /.login-logo -->
	<div class="card card-outline">
		<div class="card-header text-center">
			<img src="<?=base_url()?>assets/imgs/logos/icono.png" width="40px" height="40px" /> <span class="h3">Certificaciones WalMart</span>
		</div>
		<div class="card-body">
			<p class="login-box-msg">Ingrese sus datos para iniciar sesión</p>

			<form id="form_login" method="post">
				<?php if(isset($id_convocatoria) && $id_convocatoria != ''): ?>
					<input type="hidden" name="id_convocatoria" value="<?=$id_convocatoria?>">
				<?php endif; ?>
				<div class="mb-3">
					<input type="text" data-rule-required="true" name="usuario" class="form-control" placeholder="Nombre de usuario" value="<?=isset($usuario_login) ? $usuario_login:''?>" >
				</div>
				<div class="mb-3">
					<input id="input_contrasena_login" type="password" data-rule-required="true" name="password" class="form-control" placeholder="Contraseña">
				</div>
				<div class="row">
					<div class="col-4">
						<button type="button" data-toggle="tooltip"  data-placement="right" title="Ver contraseña" class="input-group-text ver_password no_password" data-id_password="#input_contrasena_login"><i class="fas fa-eye"></i></button>
					</div>
					<div class="col-4">
						<a href="<?=base_url()?>" class="btn btn-danger btn-block">Cancelar</a>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button type="button" id="iniciar_sesion" class="btn btn-primary btn-block">Entrar</button>
					</div>
					<!-- /.col -->
				</div>
			</form>

			<p class="mb-1">
				<a href="<?=base_url()?>recuperar_password">No recuerdo mi contraseña</a>
			</p>
			<!--<p class="mb-0">
				<a href="register.html" class="text-center">Register a new membership</a>
			</p>-->
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url()?>assets/frm/adm_lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/frm/adm_lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/frm/adm_lte/dist/js/adminlte.min.js"></script>

<!-- scripts externos -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery-validation/localization/messages_es.js"></script>

<!-- scripts del plugin de notificaciones del sistema -->
<script src="<?=base_url()?>assets/frm/watnotif/js/watnotif-1.0.min.js"></script>

<script>
	var base_url = '<?=base_url()?>';
	var existe_login = '<?=sesionActive() != false ? true : false?>';

</script>

<script src="<?=base_url()?>assets/js/comun.js"></script>
<script src="<?=base_url()?>assets/js/login.js"></script>
</body>
</html>
