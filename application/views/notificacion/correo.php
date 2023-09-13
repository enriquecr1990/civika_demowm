<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Integral PED - Civika</title>

</head>
<body style="background-color: whitesmoke">

<table width="100%">

	<tr>
		<td style="width: 20%"></td>
		<td style="width: 60%; background-color: black; color: lightgrey !important;text-align: center !important;border-radius: 10px !important;padding-top: 5px !important;padding-left: 5px !important;padding-right: 5px !important;padding-bottom: 5px !important;">
			<p style="font-size: 30px;font-weight: bold;display: contents;">Sistema Integral PED - Civika</p>
		</td>
		<td style="width: 20%"></td>
	</tr>

	<tr>
		<td style="width: 20%"></td>
		<td style="width: 60%; height: auto; !important;border-radius: 10px !important;background-color: white !important; padding-top: 5px !important;padding-bottom: 5px !important;padding-left: 5px !important;padding-right: 5px !important;">
			<?php if(isset($notificacion->asunto)): ?>
				<strong>Asunto: <?=$notificacion->asunto?></strong><br>
			<?php endif;?>
			<?php if(isset($notificacion->mensaje)): ?>
				<?=$notificacion->mensaje?>
			<?php endif; ?>
			<?php if(isset($archivos) && is_array($archivos) && sizeof($archivos)): ?>
				<hr>
				<strong>Adjuntos:</strong>
				<ul>
					<?php foreach ($archivos as $a):?>
						<li><a href="<?=base_url().$a->ruta_directorio.$a->nombre?>" target="_blank"><?=$a->nombre?></a></li>
					<?php endforeach;?>
				</ul>
			<?php endif; ?>
		</td>
		<td style="width: 20%"></td>
	</tr>


	<tr>
		<td style="width: 20%"></td>
		<td style="width: 60%; background-color: black; color: lightgrey !important;text-align: center !important;border-radius: 10px !important;padding-top: 5px !important;padding-left: 5px !important;padding-right: 5px !important;padding-bottom: 5px !important; font-style: italic !important;">
			<p>
				Este mensaje es enviado automaticamente por el sistema, no es necesario responder <br>al correo ya que no cuenta habilitada la bandeja de entrada
				<br>Puede darse de baja de nuestras promociones dando click en: <a href="<?=base_url()?>unsubscribe">"Darse de baja"</a> <br/> solo que seguira recibiendo correos de las notificaciones y avisos del sistema
			</p>
			<hr>
			<p>
				Centro Educativo Campus Civika. Ferrocarril Mexicano 286. <br>Colonia 20 de noviembre. Apizaco, Tlax. C.P. 90341
			</p>
		</td>
		<td style="width: 20%"></td>
	</tr>

</table>

</body>
</html>
