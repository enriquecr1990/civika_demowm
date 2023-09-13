<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?=isset($titulo_documento) ? $titulo_documento : 'Sistema integral PED'?></title>

	<link rel="stylesheet" href="<?=base_url()?>assets/css/pdf/comun.css">

	<?php if(isset($extra_css_pdf)): ?>
		<?php foreach ($extra_css_pdf as $css): ?>
			<link rel="stylesheet" href="<?=$css?>">
		<?php endforeach; ?>
	<?php endif; ?>

</head>
<body>
