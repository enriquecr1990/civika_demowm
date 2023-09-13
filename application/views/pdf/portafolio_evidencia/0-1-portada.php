<!-- primera página -->
<br/><br/>
<p class="centrado titulo">
	Portafolio de <br>Evidencias
</p>
<hr>
<br><br>
<p class="texto_encabezado margenes">
	Nombre del candidato:  <br><strong><?=$usuario_alumno->nombre.' '.$usuario_alumno->apellido_p.' '.$usuario_alumno->apellido_m?></strong>
</p>

<br>
<p class="texto_encabezado margenes justificado">
	<?=$estandar_competencia->codigo.' '.$estandar_competencia->titulo?>
</p>

<p class="texto_encabezado margenes">
	Evaluador Independiente: <br><strong><?=$usuario_instructor->nombre.' '.$usuario_instructor->apellido_p.' '.$usuario_instructor->apellido_m.' '.$usuario_instructor->codigo_evaluador?></strong>
</p>

<br><br><br><br>
<hr>
<img class="img_footer" src="<?=base_url()?>assets/imgs/logos/footer_pdf.png">
<!-- fin primera pagina -->
