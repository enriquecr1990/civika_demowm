<!-- nueva pagina con orientacion horizontal landscape -->
<!-- nueva pagina con orientacion horizontal landscape -->
<?php $this->load->view('pdf/header_paginas');?>
<sethtmlpageheader name="header_img_civika_diagnostico" value="on" show-this-page="1" />
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td class="izquierda fondo_gris contenido_tabla_diagnostico negritas cursivas" style="width: 25%">Nombre del candidato:</td>
		<td class="negritas contenido_tabla_diagnostico mayusculas" style="color: dodgerblue"><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></td>
	</tr>
	<tr>
		<td class="izquierda fondo_gris contenido_tabla_diagnostico negritas cursivas">Estándar de competencia:</td>
		<td class="justificado contenido_tabla_diagnostico negritas cursivas"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></td>
	</tr>
	<tr>
		<td class="izquierda fondo_gris contenido_tabla_diagnostico negritas cursivas">Fecha de aplicación:</td>
		<td class="negritas contenido_tabla_diagnostico" style="color: dodgerblue"><?=fechaBDToHtml($evaluacion_diagnostica_realizada->fecha_enviada)?></td>
	</tr>
	<tr>
		<td class="izquierda fondo_gris contenido_tabla_diagnostico negritas cursivas">Introducción:</td>
		<td>
			El objetivo del diagnóstico es identificar las posibilidades de éxito que se tiene para someterse a un
			proceso de evaluación en relación con los requerimientos señalados en el Estándar de Competencia.
		</td>
	</tr>
	<tr>
		<td class="izquierda fondo_gris contenido_tabla_diagnostico negritas cursivas">Instrucciones:</td>
		<td>
			<ul>
				<li>Lea cuidadosamente cada uno de los reactivos antes de emitir su respuesta.</li>
				<li>Dé a conocer sus dudas al responsable de la evaluación para un buen desarrollo.</li>
				<li>El tiempo establecido para la aplicación de la evaluación será máximo 20 minutos.</li>
				<!--<li>Dentro del paréntesis, escriba una letra (de la "a" a la "j") según corresponda.</li>-->
			</ul>
		</td>
	</tr>
</table>
<br>
<br>
<?php if(isset($preguntas_evaluacion)): ?>
	<?php foreach ($preguntas_evaluacion as $index => $prt): ?>
		<?php if(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_VERDADERO_FALSO,OPCION_UNICA_OPCION,OPCION_IMAGEN_UNICA_OPCION))): ?>
			<table class="margenes" width="100%" >
				<tr>
					<td colspan="4">
						<?=$index + 1?>.- <?=$prt->pregunta?>
						<?php if(!isset($respuestas_candidato[$prt->id_banco_pregunta]) || !$respuestas_candidato[$prt->id_banco_pregunta]): ?>
							<span class="respuesta_evaluacion respuesta_incorrecta">Incorrecta</span>
						<?php else: ?>
							<span class="respuesta_evaluacion respuesta_correcta">Correcta</span>
						<?php endif; ?>
					</td>
				</tr>
				<!-- opciones pregunta -->
				<!-- para preguntas con input de radio -->
				<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
					<?=($index_op == 0 || ($index_op) % 3 == 0) ? '<tr>':''?>
						<td class="evaluacion_opciones">
							<input type="radio" <?=in_array($op->id_opcion_pregunta,$prt->respuesta_candidato)? 'checked="checked"':''?> >&nbsp;<?=$op->descripcion?>
							<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
								<img class="img_opciones_pregunta" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
							<?php endif; ?>
						</td>
					<?=($index_op == 0 || ($index_op + 1) % 3 == 0) ? '</tr>':''?>
				<?php endforeach; ?>
			</table>
		<?php elseif(in_array($prt->id_cat_tipo_opciones_pregunta,array(OPCION_OPCION_MULTIPLE,OPCION_IMAGEN_OPCION_MULTIPLE))): ?>
			<table class="margenes" width="100%" >
				<tr>
					<td colspan="4">
						<?=$index + 1?>.- <?=$prt->pregunta?>
						<?php if(!isset($respuestas_candidato[$prt->id_banco_pregunta]) || !$respuestas_candidato[$prt->id_banco_pregunta]): ?>
							<span class="respuesta_evaluacion respuesta_incorrecta">Incorrecta</span>
						<?php else: ?>
							<span class="respuesta_evaluacion respuesta_correcta">Correcta</span>
						<?php endif; ?>
					</td>
				</tr>
				<!-- opciones pregunta -->
				<!-- para preguntas con input de checkbox -->
				<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
					<?=($index_op == 0 || ($index_op) % 3 == 0) ? '<tr>':''?>
					<td class="evaluacion_opciones">
						<input type="checkbox" <?=in_array($op->id_opcion_pregunta,$prt->respuesta_candidato)? 'checked="checked"':''?> >&nbsp;<?=$op->descripcion?>
						<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
							<img class="img_opciones_pregunta" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
						<?php endif; ?>
					</td>
					<?=($index_op == 0 || ($index_op + 1) % 3 == 0) ? '</tr>':''?>
				<?php endforeach; ?>
			</table>
		<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_SECUENCIAL): ?>
			<table class="margenes" width="100%" >
				<tr>
					<td colspan="4">
						<?=$index + 1?>.- <?=$prt->pregunta?>
						<?php if(!isset($respuestas_candidato[$prt->id_banco_pregunta]) || !$respuestas_candidato[$prt->id_banco_pregunta]): ?>
							<span class="respuesta_evaluacion respuesta_incorrecta">Incorrecta</span>
						<?php else: ?>
							<span class="respuesta_evaluacion respuesta_correcta">Correcta</span>
						<?php endif; ?>
					</td>
				</tr>
				<!-- opciones pregunta -->
				<!-- para preguntas con input de checkbox -->
				<?php foreach ($prt->opciones_pregunta as $index_op => $op): ?>
					<tr>
						<td style="width: 10%" class="centrado"><input type="text" value="<?=$prt->respuesta_candidato[$index_op]?>"></td>
						<td colspan="3">
							<?=$op->descripcion?>
							<?php if(isset($op->archivo_imagen_respuesta) && is_object($op->archivo_imagen_respuesta)): ?>
								<img class="img_opciones_pregunta" src="<?=base_url().$op->archivo_imagen_respuesta->ruta_directorio.$op->archivo_imagen_respuesta->nombre?>" alt="<?=$op->archivo_imagen_respuesta->nombre?>">
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php elseif($prt->id_cat_tipo_opciones_pregunta == OPCION_RELACIONAL): ?>
			<table class="margenes" width="100%" >
				<tr>
					<td colspan="4">
						<?=$index + 1?>.- <?=$prt->pregunta?>
						<?php if(!isset($respuestas_candidato[$prt->id_banco_pregunta]) || !$respuestas_candidato[$prt->id_banco_pregunta]): ?>
							<span class="respuesta_evaluacion respuesta_incorrecta">Incorrecta</span>
						<?php else: ?>
							<span class="respuesta_evaluacion respuesta_correcta">Correcta</span>
						<?php endif; ?>
					</td>
				</tr>
				<!-- opciones pregunta -->
				<!-- para preguntas con input de checkbox -->
				<?php foreach ($prt->opciones_pregunta_izq as $index_op => $op): ?>
					<tr>
						<!-- izq -->
						<td style="width: 5%;" class="centrado"><strong><?=$op->consecutivo?></strong></td>
						<td><?=$op->descripcion?></td>
						<!-- der -->
						<td style="width: 10%;" class="centrado"><input type="text" value="<?=$prt->respuesta_candidato[$index_op]?>"></td>
						<td><?=$prt->opciones_pregunta_der[$index_op]->descripcion?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>

<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td class="centrado titulo_encabezado_diagnostico fondo_gris">Conclusión</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico no_borde_izquierdo no_borde_derecho no_borde_inferior">
			Para tomar una decisión acerca de ingresar a un proceso de evaluación con fines de certificación, tome en cuenta las siguientes recomendaciones:
		</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td style="width: 33.33%" class="centrado fondo_gris contenido_tabla_diagnostico">Rango de aciertos</td>
		<td style="width: 33.33%" class="centrado fondo_gris contenido_tabla_diagnostico">Posibilidades de éxito</td>
		<td style="width: 33.33%" class="centrado fondo_gris contenido_tabla_diagnostico">Sugerencia</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico izquierda">De 0 a <?=$rango_aciertos[0]?> reactivos correcto </td>
		<td class="contenido_tabla_diagnostico negritas centrado">Bajas</td>
		<td class="contenido_tabla_diagnostico izquierda">Tomar curso de capacitación antes de la evaluación</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico izquierda">De <?=$rango_aciertos[0] + 1?> a <?=$rango_aciertos[1]?> reactivos correcto </td>
		<td class="contenido_tabla_diagnostico centrado negritas">Medias</td>
		<td class="contenido_tabla_diagnostico izquierda">Tomar alineación antes de la evaluación</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico izquierda">De <?=$rango_aciertos[1] + 1?> a <?=sizeof($preguntas_evaluacion)?> reactivos correcto </td>
		<td class="contenido_tabla_diagnostico centrado negritas">Altas</td>
		<td class="contenido_tabla_diagnostico izquierda">Iniciar el proceso de evaluación</td>
	</tr>
</table>
<br>
<table class="table_bordes margenes_ficha_registro" width="100%" border="1">
	<tr>
		<td class="fondo_gris negritas contenido_tabla_diagnostico" style="width: 45%">Resultado </td>
		<td rowspan="4" class="no_borde_superior no_borde_inferior"></td>
		<td class="fondo_gris negritas contenido_tabla_diagnostico" style="width: 45%">Decisión del Candidato</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico izquierda">Respuestas Correctas, Calificación: <?=isset($calificacion_evaluacion) ? $calificacion_evaluacion : ''?></td>
		<td rowspan="2" class="contenido_tabla_diagnostico">
			Decisión
			<br><br>
			<input type="radio" name="decision_alumno" <?=isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada->decision_candidato == 'tomar_capacitacion' ? 'checked="checked"':''?>>Tomar capacitación previo a la Evaluación<br>
			<input type="radio" name="decision_alumno" <?=isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada->decision_candidato == 'tomar_alineacion' ? 'checked="checked"':''?>>Tomar alineación previo a la Evaluación<br>
			<input type="radio" name="decision_alumno" <?=isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada->decision_candidato == 'tomar_proceso' ? 'checked="checked"':''?>>Iniciar el proceso de Evaluación<br>
			<input type="radio" name="decision_alumno" <?=isset($evaluacion_diagnostica_realizada) && $evaluacion_diagnostica_realizada->decision_candidato == 'otro' ? 'checked="checked"':''?>>Otra
			<br>Especificar:<br>
			<?=$evaluacion_diagnostica_realizada->descripcion_candidato_otro?>
		</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico izquierda">
			Sugerencia:
			<br><br>
			<input type="radio" name="decision_aplicador" <?=isset($check_resultado_evaluacion_sistema) && $check_resultado_evaluacion_sistema == 'tomar_capacitacion' ? 'checked="checked"':''?>>Tomar capacitación previo a la Evaluación<br>
			<input type="radio" name="decision_aplicador" <?=isset($check_resultado_evaluacion_sistema) && $check_resultado_evaluacion_sistema == 'tomar_alineacion' ? 'checked="checked"':''?>>Tomar alineación previo a la Evaluación<br>
			<input type="radio" name="decision_aplicador" <?=isset($check_resultado_evaluacion_sistema) && $check_resultado_evaluacion_sistema == 'tomar_proceso' ? 'checked="checked"':''?>>Iniciar el proceso de Evaluación<br>
			<br>
		</td>
	</tr>
	<tr>
		<td class="contenido_tabla_diagnostico centrado">
			Firma del aplicador
			<br><img class="foto_firma" src="<?=base_url().$foto_firma_instructor->ruta_directorio.$foto_firma_instructor->nombre?>" alt="Foto firma instructor" >
			<br><?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m?>
		</td>
		<td class="contenido_tabla_diagnostico centrado">
			Firma del candidato
			<br><img class="foto_firma" src="<?=base_url().$foto_firma->ruta_directorio.$foto_firma->nombre?>" alt="Foto firma" >
			<br><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?>
		</td>
	</tr>
</table>
