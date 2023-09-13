<p class="centrado titulo_ficha_registro" style="padding-top: 15px">
	Ficha de Registro
</p>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td class="titulo_tabla_ficha_registro" style="width: 28% !important;">Estandar de:</td>
		<td colspan="6" style="font-size: 10pt; font-family: Arial; width: 45%"
			class="justificado"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?>
		</td>
		<td class="titulo_tabla_ficha_registro derecha" style="width: 5%;">Fecha:</td>
		<td style="width: 20%; font-size: 10pt; font-family: Arial;" class="centrado"><?= date('Y-m-d') ?></td>
	</tr>
	<tr>
		<td colspan="9" style="font-family: Arial; font-size: 12pt">DATOS PERSONALES</td>
	</tr>
	<tr>
		<td colspan="9" class="contenido_tabla_ficha_registro justificado no_borde_inferior">
			El Consejo Nacional de Normalización y Certificación de Competencias Laborales (CONOCER) solicita al
			candidato la autorización para la publicación de los datos personales a fin de dar cumplimiento a lo
			dispuesto en el capítulo séptimo de las Reglas Generales y criterios para la integración del Sistema
			Nacional de Competencias, referente al “Registro Nacional de Personas Con Competencias Certificadas” (RENAP)
			(1) por medio del cual las personas con competencias certificadas, pueden voluntariamente dar a conocer sus
			datos personales, para facilitar su localización, en caso de que organizaciones sindicales, empresas, sector
			académico, sector social o público, o alguna otra institución pública o privada, requieran personal con
			competencias certificadas en determinada función individual.
		</td>
	</tr>
	<tr>
		<td colspan="4" class="centrado contenido_tabla_ficha_registro no_borde_superior no_borde_inferior no_borde_derecho">
			SI ( x ) NO ( )
		</td>
		<td colspan="5" class="no_borde_superior no_borde_izquierdo"></td>
	</tr>
	<tr>
		<td colspan="4" rowspan="12" style="width: 45%; border-top-color: white; text-align: justify" class="contenido_tabla_ficha_registro no_borde_superior no_borde_inferior">
			Doy mi consentimiento al CONOCER para que, en términos del artículo 21 (2) de la Ley Federal de
			Transparencia y Acceso a la Información Pública Gubernamental, difunda, distribuya y publique la
			información contenida en el documento que se inscribe, para los propósitos del RENAP. Lo anterior, sin perjuicio de
			que estoy enterado de que en términos del artículo 22, fracción III (3) de la misma Ley, no es necesario mi
			consentimiento respecto de información que se transmita entre sujetos obligados o entre dependencias y
			entidades, cuando los datos respectivos se utilicen para el ejercicio de facultades propias de los
			mismos.
		</td>
		<td rowspan="5" class="centrado" style="width: 15%">
			<img class="foto_certificado" src="<?=base_url().$foto_certificados->ruta_directorio.$foto_certificados->nombre?>" alt="Foto perfil">
		</td>
		<td colspan="2" style="width: 22%" class="contenido_tabla_ficha_registro derecha negritas">Nombre:</td>
		<td colspan="2" style="width: 14%" class="contenido_tabla_ficha_registro"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></td>
	</tr>
	<tr>
		<td colspan="2" class="contenido_tabla_ficha_registro derecha negritas">Lugar de nacimiento:</td>
		<td colspan="2" class="contenido_tabla_ficha_registro"><?=$usuario_alumno->lugar_nacimiento?></td>
	</tr>
	<tr>
		<td colspan="2" class="contenido_tabla_ficha_registro derecha negritas">Nacionalidad:</td>
		<td colspan="2" class="contenido_tabla_ficha_registro"><?=$usuario_alumno->nacionalidad?></td>
	</tr>
	<tr>
		<td colspan="2" class="contenido_tabla_ficha_registro derecha negritas">CURP:</td>
		<td colspan="2" class="contenido_tabla_ficha_registro"><?=$usuario_alumno->curp?></td>
	</tr>
	<tr>
		<td class="contenido_tabla_ficha_registro derecha negritas">Genero:</td>
		<td class="contenido_tabla_ficha_registro centrado"><?=$usuario_alumno->genero == 'm' ? 'Masculino':'Femenino'?></td>
		<td class="contenido_tabla_ficha_registro derecha negritas" style="width: 12%">Fecha de nacimiento:</td>
		<td class="contenido_tabla_ficha_registro centrado"><?=fechaBDToHtml($usuario_alumno->fecha_nacimiento)?></td>
	</tr>
	<tr>
		<td colspan="5" class="contenido_tabla_ficha_registro negritas centrado">Domicilio Particular</td>
	</tr>
	<tr>
		<td colspan="3" class="contenido_tabla_ficha_registro centrado">
			<?=$datos_domicilio->calle.' #'.$datos_domicilio->numero_ext?>
			<?php if(isset($datos_domicilio->numero_int) && $datos_domicilio->numero_int =! ''): ?>
				int: <?=$datos_domicilio->numero_int?>
			<?php endif;?>
			entre calle xicohtencatl y IV señorios
		</td>
		<td class="contenido_tabla_ficha_registro centrado"><?=$datos_domicilio->codigo_postal?></td>
		<td class="contenido_tabla_ficha_registro centrado"><?=$datos_domicilio->localidad?></td>
	</tr>
	<tr>
		<td colspan="3" class="contenido_tabla_ficha_registro negritas centrado">Calle y Número</td>
		<td class="contenido_tabla_ficha_registro negritas centrado">CP</td>
		<td class="contenido_tabla_ficha_registro negritas centrado">Colonia</td>
	</tr>
	<tr>
		<td colspan="3" class="contenido_tabla_ficha_registro centrado"><?=$datos_domicilio->municipio?></td>
		<td colspan="2" class="contenido_tabla_ficha_registro centrado"><?=$datos_domicilio->estado?></td>
	</tr>
	<tr>
		<td colspan="3" class="contenido_tabla_ficha_registro negritas centrado">Ciudad</td>
		<td colspan="2" class="contenido_tabla_ficha_registro negritas centrado">Entidad Federativa</td>
	</tr>
	<tr>
		<td colspan="3" class="contenido_tabla_ficha_registro centrado"><?=$usuario_alumno->correo?></td>
		<td class="contenido_tabla_ficha_registro centrado"><?=$usuario_alumno->telefono?></td>
		<td class="contenido_tabla_ficha_registro centrado"><?=$usuario_alumno->celular?></td>
	</tr>
	<tr>
		<td rowspan="2" colspan="3" class="contenido_tabla_ficha_registro negritas centrado">E-mail</td>
		<td rowspan="2" class="contenido_tabla_ficha_registro negritas centrado">Teléfono</td>
		<td rowspan="2" class="contenido_tabla_ficha_registro negritas centrado">Celular</td>
	</tr>
	<tr>
		<td colspan="4" class="centrado no_borde_superior contenido_tabla_ficha_registro">
			Firma
			<br>
			<img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
		</td>
	</tr>
	<tr>
		<td colspan="9" class="contenido_tabla_ficha_registro justificado">
			"Los datos personales recabados serán protegidos y serán incorporados y tratados en el Sistema de datos
			personales RENAP con fundamento en las reglas generales y criterios para integración y operación del Sistema
			Nacional de Competencias y cuya finalidad es integrar una base de datos con información sobre las personas
			que han obtenido uno o más Certificados de Competencia, con base en Estándares de Competencia inscritos en
			el Registro Nacional de Estándares de Competencia, el cual fue registrado en el Listado de Sistemas de Datos
			Personales ante el Instituto Federal de Acceso a la Información Pública (www.ifai.org.mx) y podrán ser
			trasmitidos a sujetos obligados o dependencias y entidades con la finalidad del uso en facultades propias de
			las mismas. Además de otras transmisiones previstas en Ley. La Unidad Administrativa responsable del Sistema
			es el Consejo Nacional de Normalización y Certificación de Competencias Laborales y la dirección donde el
			usuario podrá ejercer los derechos de acceso y corrección ante la misma es Av. Barranca del Muerto 275 Col.
			San José Insurgentes C.P. 03900, Ciudad de México. Lo anterior se informa en cumplimiento del Decimoséptimo
			de los lineamientos de protección de Datos Personales, publicados en el Diario Oficial de la Federación el
			30 de septiembre de 2005. El CONOCER deberá informar al Instituto, dentro de los primeros diez días hábiles
			de enero y julio de cada año, lo siguiente: a) Los sistemas de datos personales, b) Cualquier modificación o
			cancelación de dichos sistemas, c) Cualquier transmisión de sistemas de datos personales de conformidad a
			los dispuesto por los Lineamientos Vigésimo quinto y Vigésimo sexto de los Lineamientos de protección de
			Datos Personales."
			<br><br><br>
		</td>
	</tr>
</table>

<p class="justificado pie_pagina_ficha_registro margenes_ficha_registro">
	(1) EL RENAP, tiene como objetivo fundamental integrar una base de datos con información sobre las personas que han obtenido uno o más Certificados de Competencia, con base en Estándares de Competencia inscritos en el Registro Nacional de estándares de Competencias.
	<br>(2) Los sujetos obligados no podrán difundir, distribuir o comercializar los datos personales contenidos en los sistemas de información, desarrollados en el ejercicio de sus funciones, salvo que haya mediado el consentimiento expreso, por escrito o por un medio de autenticación similar, de los individuos a que haga referencia la información.
	<br>(3) No se requerirá el consentimiento de los individuos para proporcionar los datos personales en los siguientes casos: III. Cuando se transmitan entre sujetos obligados o entre dependencias y entidades,siempre y cuando los datos se utilicen para el ejercicio de facultades propias de los mismos.
</p>
<p class="derecha contenido_tabla_ficha_footer margenes_ficha_registro">
	<?=date('d/m/Y')?>
	<br/> Imagen candidato: <?=$foto_firma->nombre?>
</p>
