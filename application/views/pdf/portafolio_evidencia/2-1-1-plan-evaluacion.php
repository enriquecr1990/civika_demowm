<!-- nueva pagina con orientacion horizontal landscape -->
<pagebreak orientation="P" margin-top="150" margin-bottom="45" />
<?php $this->load->view('pdf/header_paginas');?>
<?php $this->load->view('pdf/footer_paginas');?>
<sethtmlpageheader name="header_img_civika" value="on" show-this-page="1" />
<sethtmlpagefooter name="footer_direccion_civika" value="on"  show-this-page="1" />

<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" style="width: 25%">Evaluador:</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
			<?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m?>
		</td>
	</tr>
	<tr>
		<td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" >Centro de evaluación:</td>
		<td class="contenido_tabla_plan_evaluacion">
			Fundación para el Desarrollo Humano Cívika
		</td>
	</tr>
	<tr>
		<td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" >Fecha:</td>
		<td class="contenido_tabla_plan_evaluacion">
			<?=
			fechaBDToHtml($usuario_has_ec->fecha_registro)
			?>
		</td>
	</tr>
	<tr>
		<td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" >Estándar de Competencia:</td>
		<td class="contenido_tabla_plan_evaluacion negritas">
			<?= $estandar_competencia->codigo . ' "' . $estandar_competencia->titulo,'"' ?>
		</td>
	</tr>
	<tr>
		<td class="fondo_gris derecha contenido_tabla_plan_evaluacion negritas" >Candidato</td>
		<td class="contenido_tabla_plan_evaluacion mayusculas">
			<?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
		</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td colspan="5" class="centrado negritas contenido_tabla_plan_evaluacion fondo_gris">
			Resultado del Diagnóstico
		</td>
	</tr>
	<tr>
		<td style="width: 80%"  class="negritas contenido_tabla_plan_evaluacion fondo_gris">
			<?php if(isset($check_resultado_evaluacion_sistema)): ?>
				<?php switch ($check_resultado_evaluacion_sistema){
					case 'tomar_capacitacion':
						echo 'Se sugirió tomar capacitación previo a la Evaluación: ';
						break;
					case 'tomar_alineacion':
						echo 'Se sugirió tomar alineación previo a la Evaluación: ';
						break;
					default:
						echo 'Se sugirio iniciar el proceso de Evaluación: ';
						break;
				}?>
			<?php endif; ?>
			<?=$respuestas_correctas_candidato?> de <?=$numero_preguntas_evaluacion?> aciertos
		</td>
		<td style="width: 5%" class="centrado negritas contenido_tabla_plan_evaluacion fondo_gris">
			Si
		</td>
		<td style="width: 5%" class="contenido_tabla_plan_evaluacion centrado negritas">
			<?=isset($evaluacion_diagnostica_realizada) && in_array($evaluacion_diagnostica_realizada->decision_candidato,array('tomar_capacitacion','tomar_alineacion','otro')) ? 'X':'' ?>
		</td>
		<td style="width: 5%" class="centrado negritas contenido_tabla_plan_evaluacion fondo_gris">
			No
		</td>
		<td style="width: 5%" class="contenido_tabla_plan_evaluacion centrado negritas">
			<?=isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada->decision_candidato == 'tomar_proceso' ? 'X':'' ?>
		</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td style="width: 5%" class="fondo_gris centrado contenido_tabla_plan_evaluacion negritas">
			No.
		</td>
		<td style="width: 40%" class="fondo_gris centrado contenido_tabla_plan_evaluacion negritas">
			Actividades y forma a desarrollar
		</td>
		<td style="width: 40%" class="fondo_gris centrado contenido_tabla_plan_evaluacion negritas">
			Técnicas e instrumentos de evaluación
		</td>
		<td style="width: 15%" class="fondo_gris centrado contenido_tabla_plan_evaluacion negritas">
			Fecha
		</td>
	</tr>
	<?php foreach ($estandar_competencia_instrumento as $eci): ?>
		<?php foreach ($eci->actividades as $index => $a): ?>
			<tr>
				<td class="contenido_tabla_plan_evaluacion centrado">
					<?=$index + 1?>
				</td>
				<td class="contenido_tabla_plan_evaluacion">
					<?=$a->actividad?>
				</td>
				<?php if($index == 0):?>
					<td class="centrado contenido_tabla_plan_evaluacion" rowspan="<?=sizeof($eci->actividades)?>">
						<?=$eci->nombre?>
					</td>
				<?php endif; ?>
				<td class="izquierda contenido_tabla_plan_evaluacion">
					<?=$usuario_has_ec->fecha_evidencia_ati ? fechaBDToHtml($usuario_has_ec->fecha_evidencia_ati) : 'Sin fecha registrada'?>
				</td>
			</tr>
		<?php endforeach;?>
	<?php endforeach;?>
</table>

<!-- nueva pagina con orientacion horizontal landscape -->
<pagebreak orientation="P" margin-top="150" margin-bottom="45" />
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td colspan="2" class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Requerimientos para el desarrollo de la evaluación
		</td>
	</tr>
	<tr>
		<td style="width: 15%" class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Cantidad
		</td>
		<td class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Requerimiento
		</td>
	</tr>
	<?php foreach ($estandar_competencia_requerimientos as $ecr):?>
		<tr>
			<td class="contenido_tabla_plan_evaluacion centrado">
				<?=$ecr->cantidad?>
			</td>
			<td class="contenido_tabla_plan_evaluacion">
				<?=$ecr->descripcion?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td colspan="2" class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Requerimientos para el desarrollo de la evaluación
		</td>
	</tr>
	<tr>
		<td style="10%" class="contenido_tabla_plan_evaluacion negritas fondo_gris derecha">
			Primer criterio:
		</td>
		<td class="contenido_tabla_plan_evaluacion">
			La suma total del peso relativo a los reactivos del IEC que se aplique sea igual o mayor a: <strong><?=$estandar_competencia->calificacion_juicio?></strong>
		</td>
	</tr>
	<tr>
		<td style="13%" class="contenido_tabla_plan_evaluacion negritas fondo_gris derecha">
			Segundo criterio:
		</td>
		<td class="contenido_tabla_plan_evaluacion">
			Existe al menos un reactivo cumplido para cada criterio de evaluación, aplica para reactivos de producto, desempeño.
		</td>
	</tr>
</table>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td colspan="3" class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Acuerdo para el desarrollo de la evaluación
		</td>
	</tr>
	<tr>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Lugar
		</td>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Fecha
		</td>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Horario
		</td>
	</tr>
	<tr>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion">Fundación para el Desarrollo Humano Cívika</td>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion centrado"><?=$usuario_has_ec->fecha_evidencia_ati?></td>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion centrado"><?=$usuario_has_ec->hora_evidencia_ati?> HRS.</td>
	</tr>
</table>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td colspan="3" class="centrado contenido_tabla_plan_evaluacion negritas fondo_gris">
			Acuerdo para la presentación de los resultados de la evaluación
		</td>
	</tr>
	<tr>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Lugar
		</td>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Fecha
		</td>
		<td style="33.33%" class="contenido_tabla_plan_evaluacion negritas fondo_gris centrado">
			Horario
		</td>
	</tr>
	<tr>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion">
			<?= $usuario_has_ec->lugar_presentacion_resultados == 'civika' ? 'Fundación para el Desarrollo Humano Cívika' : $usuario_has_ec->descripcion_presentacion_resultados ?>
		</td>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion centrado"><?=$usuario_has_ec->fecha_presentacion_resultados?></td>
		<td style="width: 33.33% !important;" class="contenido_tabla_plan_evaluacion centrado"><?=$usuario_has_ec->hora_presentacion_resultados?> HRS.</td>
	</tr>
</table>
<br>
<p class="margenes izquierda contenido_tabla_plan_evaluacion">
	Se proporcionó al Candidato información suficiente y detallada respecto a:
</p>
<ul class="margenes justificado contenido_tabla_plan_evaluacion">
	<li>Los desempeños, productos conocimientos a demostrar durante la evaluación, así como los lugares, fechas y horarios en que se realizará.</li>
	<li>Los derechos y obligaciones de los usuarios del Sistema Nacional de Competencias.</li>
	<li>El lugar y fecha para la entrega del Certificado.</li>
	<li>Los mecanismos de operación y registro de resultados de evaluación en el Sistema Integral de Información (SII).</li>
</ul>
<!-- firmas -->
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td style="width: 5%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_todos">
			<img class="foto_firma" src="<?=base_url().$foto_firma_instructor->ruta_directorio.$foto_firma_instructor->nombre?>" alt="Foto firma" >
		</td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_todos">
			<img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
		</td>
		<td style="width: 5%" class="no_borde_todos no_borde_todos"></td>
	</tr>
	<tr>
		<td style="width: 5%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_todos"><?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m?></td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_todos"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></td>
		<td style="width: 5%" class="no_borde_todos no_borde_todos"></td>
	</tr>
	<tr>
		<td style="width: 5%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_izquierdo no_borde_derecho no_borde_inferior">
			<strong>Nombre del evaluador</strong>
		</td>
		<td style="width: 10%" class="no_borde_todos"></td>
		<td style="width: 40%" class="contenido_tabla_plan_evaluacion centrado no_borde_izquierdo no_borde_derecho no_borde_inferior">
			<strong>Nombre del candidato</strong>
			<br>Estoy de acuerdo
		</td>
		<td style="width: 5%" class="no_borde_todos"></td>
	</tr>
</table>
