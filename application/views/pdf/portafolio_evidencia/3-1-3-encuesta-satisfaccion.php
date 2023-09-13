<!-- nueva pagina con orientacion horizontal landscape -->
<pagebreak orientation="P" margin-top="150" margin-bottom="45" />
<?php $this->load->view('pdf/header_paginas');?>
<?php $this->load->view('pdf/footer_paginas');?>
<sethtmlpageheader name="header_img_civika_cedula_evaluacion" value="on" show-this-page="1" />
<sethtmlpagefooter name="footer_direccion_civika_encuesta" value="on"  show-this-page="1" />

<table class="table_bordes margenes_ficha_registro" width="100%">
	<tr>
		<td class="centrado negritas mayusculas" style="font-size: 14px; !importan">
			Encuesta de satisfacción del proceso de evaluación-certificación
		</td>
	</tr>
    <tr>
        <td class="centrado negritas mayusculas" style="font-size: 12px; !importan">
            Su opinion es muy importante
        </td>
    </tr>
</table>
<br>

<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Nombre del Estándar de Competencia:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=$estandar_competencia->titulo?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Código del Estándar de Competencia:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
			<?=$estandar_competencia->codigo?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Nombre del candidato:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas texto_azul">
            <?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Fecha:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas texto_azul">
            <?= fechaBDToHtml($usuario_has_ec->fecha_registro)?>
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Propósito:</td>
		<td class="contenido_tabla_plan_evaluacion ">
            Con la finalidad de elevar la calidad del servicio relacionado con el proceso de evaluación y la atención del servicio, solicito su opinión en cuanto al cumplimiento
		</td>
    </tr>
    <tr>
        <td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas derecha" style="width: 25%">Instrucciones:</td>
		<td class="contenido_tabla_plan_evaluacion ">
            Señale con una "X" para cada factor en las columnas de la derecha el grado de evaluación que otorgue de acuerdo a la sieguiente codigicación: 
            1. Muy de Acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/01_icon_muy_feliz.png" class="img_encuesta_satisfaccion" alt="Muy feliz">),
			2. De acuerdo (<img src="<?=base_url()?>assets/imgs/iconos/02_icon_feliz.png" class="img_encuesta_satisfaccion" alt="Feliz">),
			3. Parcialmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/03_icon_triste.png" class="img_encuesta_satisfaccion" alt="Triste">),
			4. Totalmente en Desacuerdo (<img src="<?=base_url()?>assets/imgs/iconos/04_icon_muy_triste.png" class="img_encuesta_satisfaccion" alt="Muy triste">).
		</td>
    </tr>
</table>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr>
        <td class="fondo_gris centrado contenido_tabla_plan_evaluacion negritas" style="width: 80%">Aspecto a evaluar:</td>
		<td class="contenido_tabla_plan_evaluacion fondo_gris centrado">
            <img src="<?=base_url()?>assets/imgs/iconos/01_icon_muy_feliz.png" class="img_encuesta_satisfaccion" alt="Muy feliz">
        </td>
        <td class="contenido_tabla_plan_evaluacion fondo_gris centrado">
            <img src="<?=base_url()?>assets/imgs/iconos/02_icon_feliz.png" class="img_encuesta_satisfaccion" alt="Feliz">
        </td>
        <td class="contenido_tabla_plan_evaluacion fondo_gris centrado">
            <img src="<?=base_url()?>assets/imgs/iconos/03_icon_triste.png" class="img_encuesta_satisfaccion" alt="Triste">
        </td>
        <td class="contenido_tabla_plan_evaluacion fondo_gris centrado">
            <img src="<?=base_url()?>assets/imgs/iconos/04_icon_muy_triste.png" class="img_encuesta_satisfaccion" alt="Muy triste">
        </td>
    </tr>
	<?php foreach ($respuestas_encuesta_satisfacion as $index => $r): ?>
		<tr>
			<td class="contenido_tabla_plan_evaluacion">
				<?=$index + 1?>.- <?=$r->pregunta?>
			</td>
			<td class="contenido_tabla_plan_evaluacion centrado negritas"><?=$r->respuesta == 1 ? 'X':''?></td>
			<td class="contenido_tabla_plan_evaluacion centrado negritas"><?=$r->respuesta == 2 ? 'X':''?></td>
			<td class="contenido_tabla_plan_evaluacion centrado negritas"><?=$r->respuesta == 3 ? 'X':''?></td>
			<td class="contenido_tabla_plan_evaluacion centrado negritas"><?=$r->respuesta == 4 ? 'X':''?></td>
		</tr>
	<?php endforeach; ?>
    <tr>
        <td colspan="5" class="contenido_tabla_plan_evaluacion">
            <strong>Observaciones: </strong>(Mencione brevemente algunas sugerencias para mejorar el servicio)
            <p class="justificado texto_azul negritas"><?=$usuario_has_encuesta->observaciones?></p><br>
        </td>
    </tr>
</table>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
    <tr class="">
        <td class="centrado contenido_tabla_plan_evaluacion negritas no_borde_todos" >
            <p class="texto_azul"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></p>
            <p>
                <img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
            </p>
            _________________________________________
            <br>Nombre y Firma
        </td>
    </tr>
</table>
