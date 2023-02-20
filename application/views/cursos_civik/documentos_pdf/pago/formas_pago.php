<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Formas de Pago</title>
	<link href="<?= base_url('extras/css/formas_pago.css') ?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="salto_linea30"></div>
	<h3>FORMAS DE PAGO:</h3>
	<?php foreach ($catalogo_formas_pago as $cfg): ?>

		<table class="tw">
			<tr>
				<td class="negrita">
					<ul>
						<li><?=$cfg->titulo_pago?></li>
					</ul>
				</td>

			</tr>
			<?php if($cfg->banco != ''):?>

				<tr>
					<td>
						&nbsp;&nbsp;&nbsp;Banco: &nbsp;<?=$cfg->banco?>

					</td>
				</tr>
			<?php endif; ?>
			<?php if($cfg->numero_tarjeta != ''):?>
				<tr>
					<td>
						&nbsp;&nbsp;&nbsp;Numero de Tarjeta:&nbsp; <?=$cfg->numero_tarjeta?> 
					</td>
				</tr>
			<?php endif; ?>

			<?php if($cfg->cuenta != ''):?>

				<tr>
					<td>
						&nbsp;&nbsp;&nbsp;Numero de cuenta:&nbsp; <?=$cfg->cuenta?>
					</td>
				</tr>
			<?php endif; ?>
			<?php if($cfg->titular != ''):?>

				<tr>
					<td>
						&nbsp;&nbsp;&nbsp;A nombre de <?=$cfg->titular?>
					</td>
				</tr>
			<?php endif; ?>
			<?php if($cfg->clabe != ''):?>

				<tr>
					<td>
						&nbsp;&nbsp;&nbsp;Clabe interbancaria:&nbsp; <?=$cfg->clabe?>
					</td>
				</tr>
			<?php endif; ?>

		</table>
	<?php endforeach; ?>
	
	<div class="salto_linea15"></div>
	<table>
		<tr>
			<td style="text-align: justify;">
                <?php echo nl2br($catalogo_forma_pago_detalle->descripcion); ?>

			</td>
		</tr>
		
	</table>

</body>
</html>	