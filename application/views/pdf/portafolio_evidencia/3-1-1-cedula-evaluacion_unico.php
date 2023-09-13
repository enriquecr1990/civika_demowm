<!-- nueva pagina con orientacion horizontal landscape -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php $this->load->view('pdf/header_paginas');?>
<?php $this->load->view('pdf/footer_paginas');?>
<sethtmlpageheader name="header_img_civika_cedula_evaluacion" value="on" show-this-page="1" />
<sethtmlpagefooter name="footer_direccion_civika" value="on"  show-this-page="1" />

<table class="table_bordes margenes_ficha_registro" width="100%">
	<tr>
		<td class="centrado negritas" style="font-size: 12px; !importan">
			Cédula de Evaluación
		</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Evaluador:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
			<?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Centro de Evaluación:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
			ECE312-17 Fundación para el Desarrollo Humano Cívika
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Candidato:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
            <?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Estándar de Competencia:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
            <strong><?=$estandar_competencia->codigo.' "'.$estandar_competencia->titulo.'"'?></strong>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Fecha:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
            <?=fechaBDToHtml($usuario_has_ec->fecha_registro)?>
		</td>
    </tr>
</table>

<br>

<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas " style="width: 25%">Mejores prácticas:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=$usuario_has_ec->mejores_practicas?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas " style="width: 25%">Áreas de oportunidad:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=$usuario_has_ec->areas_oportunidad?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas " style="width: 25%">Criterios de Evaluación que no se cubrieron:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=$usuario_has_ec->criterio_no_cubiertos?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" style="width: 25%">Recomendaciones:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=$usuario_has_ec->recomendaciones?>
		</td>
    </tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td class="fondo_gris contenido_tabla_plan_evaluacion negritas centrado mayusculas" style="width: 25%">Juicio de evaluación:</td>
    </tr>
    <tr>
        <td class="no_borde_superior texto_blanco no_borde_inferior">
            x
        </td>
    </tr>
    <tr>
        <td class="contenido_tabla_plan_evaluacion centrado no_borde_superior no_borde_inferior">
			<strong><?=$usuario_has_ec->jucio_evaluacion == 'competente' ? 'COMPETENTE':'NO COMPETENTE'?></strong>
		</td>
    </tr>
    <tr>
        <td class="no_borde_superior texto_blanco">
            x
        </td>
    </tr>
</table>

<!-- firmas -->
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado fondo_gris negritas">Evaluador</td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado fondo_gris negritas">Candidato</td>
    </tr>
    <tr>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_inferior"></td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_inferior">Estoy de acuerdo con el juicio de evaluación y satisfecho con los comentarios emitidos</td>
    </tr>
	<tr>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_superior no_borde_inferior">
			<img class="foto_firma" src="<?=base_url().$foto_firma_instructor->ruta_directorio.$foto_firma_instructor->nombre?>" alt="Foto firma" >
		</td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_superior no_borde_inferior">
			<img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
		</td>
	</tr>
	<tr>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_superior"><?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m?></td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado no_borde_superior">
            <?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
        </td>
	</tr>
	<tr>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado ">
			<strong>Nombre y firma</strong>
		</td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 45%" class="contenido_tabla_plan_evaluacion centrado">
			<strong>Nombre y firma</strong>
		</td>
	</tr>
</table>
<br>
<!-- notas -->
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
		<td style="width: 15%" class="contenido_tabla_plan_evaluacion centrado fondo_gris negritas no_borde_derecho">Notas</td>
		<td style="" class="contenido_tabla_plan_evaluacion justificado fondo_gris no_borde_izquierdo">
            <ul>
                <li>El juicio de Competencia emitido, está sujeto a la ratificación o rectificación del dictamen emitido por (Razón social o denominación de la ECE o OC)</li>
                <li>El candidato pagará el importe establecido para el certificado, sí y solo si su Juicio de Competencia resultara ser competente.</li>
            </ul>
        </td>
    </tr>
</table>
<br>
<!-- notas -->
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td  style="width: 15%" class="contenido_tabla_plan_evaluacion centrado fondo_gris negritas">Observaciones:</td>
        <td class="contenido_tabla_plan_evaluacion">
			<?=!is_null($usuario_has_ec->observaciones_candidato) || $usuario_has_ec->observaciones_candidato == '' ? 'Ninguna':$usuario_has_ec->observaciones_candidato?>
		</td>
    </tr>
</table>
