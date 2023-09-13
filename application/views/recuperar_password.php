<!DOCTYPE html>
<html lang="en">
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
	<!-- CSS para el plugin de las notificaciones del sistema -->
	<link href="<?=base_url()?>assets/frm/watnotif/css/bubble/watnotif.right-top-bubble.min.css" rel="stylesheet" type="text/css">

	<!-- icono -->
	<link href="<?=base_url()?>assets/imgs/logos/icono.png" rel="shortcut icon">

	<title>Sistema Integral PED</title>
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="card card-outline card-primary">
		<div class="card-header text-center">
			<img src="<?=base_url()?>assets/imgs/logos/icono.png" width="40px" height="40px" /> <span class="h3">Sistema Integral <b>PED</b></span>
		</div>
		<div class="card-body">
			<p class="login-box-msg">¿No recuerda su contraseña? Enviaremos un mail al correo registrado para su recuperación.</p>
			<form id="form_recuperar_password">
				<div class="input-group mb-3">
					<input type="text" name="usuario" class="form-control" data-rule-required="true" placeholder="Cuenta de usuario">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button type="button" id="recuerar_password" class="btn btn-primary btn-block">Solicitar cambio de contraseña</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
			<p class="mt-3 mb-1">
				<a href="<?=base_url()?>login">Iniciar sesión</a>
			</p>
		</div>
		<!-- /.login-card-body -->
	</div>
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
</script>

<script src="<?=base_url()?>assets/js/comun.js"></script>
<script src="<?=base_url()?>assets/js/login.js"></script>
</body>
</html>
