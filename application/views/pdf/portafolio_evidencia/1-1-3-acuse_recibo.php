<table>
	<tr>
		<td style="width: 30%" class="centrado">
			<img src="<?=base_url()?>assets/imgs/logos/logo_red_conocer.png"  style="width: 200px; height: auto">
		</td>
		<td style="width: 35%; padding-top: 50px" class="centrado titulo_encabezado_diagnostico">
			Acuso de recibo de los derechos y obligaciones del usuario
			<br><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?>
		</td>
		<td style="width: 35%" class="centrado">
			<img src="<?=base_url()?>assets/imgs/logos/logo_civika_pdf.png"  style="width: 200px; height: auto">
		</td>
	</tr>
</table>

<table class="margenes" width="100%">
	<tr>
		<td class="centrado titulo_encabezado_diagnostico">Acuse de recibo de los derechos y obligaciones</td>
	</tr>
	<tr>
		<td class="centrado">
			<img src="<?=base_url()?>/assets/imgs/logos/acuse_recibo_derechos_obligaciones.jpg" alt="Acuse de rebibo de los derechos y obligaciones">
		</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td rowspan="4" style="width: 30%" class="no_borde_superior no_borde_inferior no_borde_izquierdo"></td>
		<td colspan="2" style="width: 40%" class="centrado contenido_tabla_diagnostico fondo_gris negritas">Recibí original "Tríptico de los derechos y obligaciones del Usuario"</td>
		<td rowspan="4" style="width: 30%" class="no_borde_superior no_borde_inferior no_borde_derecho"></td>
	</tr>
	<tr>
		<td colspan="2" class="centrado contenido_tabla_diagnostico">
			<img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
			<br><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="centrado contenido_tabla_diagnostico negritas fondo_gris">
			Nombre y firma del usuario/candidato
		</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico derecha"><br>Fecha: &nbsp;<br></td>
		<td class="centrado contenido_tabla_diagnostico" style="color: dodgerblue"><?=fechaBDToHtml($usuario_has_ec->fecha_registro)?></td>
	</tr>
</table>

<!-- nueva pagina con orientacion horizontal landscape -->
<pagebreak orientation="P" margin-top="0" margin-bottom="0" />
<div class="contenedor_encabezado_eva_diagnostica">
	<img class="img_encabezado_diagnostico" src="<?=base_url()?>assets/imgs/logos/footer_pdf.png">
</div>
<br><br>
<table>
	<tr>
		<td style="width: 30%"></td>
		<td style="width: 35%; padding-top: 50px" class="centrado titulo_encabezado_diagnostico">
			COPIA DE INE DEL CANDIDATO
			<br><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?>
		</td>
		<td style="width: 35%"></td>
	</tr>
</table>
<br>
<table class="margenes" width="100%">
	<?php if(isset($cedula_anverso) && is_object($cedula_anverso)): ?>
		<tr>
			<td class="centrado"><img class="img_expediente_digital" src="<?=base_url().$cedula_anverso->ruta_directorio.$cedula_anverso->nombre?>"></td>
			<td class="centrado" ><img class="img_expediente_digital" src="<?=base_url().$cedula_anverso->ruta_directorio.$cedula_anverso->nombre?>"></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td class="centrado"><img class="img_expediente_digital" src="<?=base_url().$ine_anverso->ruta_directorio.$ine_anverso->nombre?>"></td>
		<td class="centrado"><img class="img_expediente_digital" src="<?=base_url().$ine_reverso->ruta_directorio.$ine_reverso->nombre?>"></td>
	</tr>
</table>
