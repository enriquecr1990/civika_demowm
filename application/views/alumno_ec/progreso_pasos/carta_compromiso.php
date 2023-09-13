<?php $domicilio = $datos_domicilio->calle . ' No. ' . $datos_domicilio->numero_ext;
if (!is_null($datos_domicilio->numero_int) && $datos_domicilio->numero_int != '') {
	$domicilio .= ' int: ' . $datos_domicilio->numero_int;
}
$domicilio .= ', ' . $datos_domicilio->localidad . ', ' . $datos_domicilio->municipio . ', ' . $datos_domicilio->estado . ', CP: ' . $datos_domicilio->codigo_postal;
?>
<div class="modal fade" id="modal_ficha_carta_compromiso_candidato" aria-modal="true" role="dialog">
	<div class="modal-dialog  modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Términos y condiciones</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">

					<div class="col-lg-12">
						<div class="callout callout-danger">
							<h5>Información importante</h5>
							<p>
								A continuación se mostrará los datos que tiene actualmente registrados en el sistema, favor
								de revisar la ficha de registro, leer detenidamente la carta compromiso y aceptar los términos para poder
								continuar con el proceso de certificación del Estandar de Competencia
							</p>
						</div>
					</div>


					<!-- ficha de registro -->
					<div class="col-lg-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Ficha de registro</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>

							<div class="card-body">
								<div class="form-group row">
									<strong class="col-lg-12">Datos personales</strong>
									<div class="col-lg-4">
										<label>Foto de perfil</label>
										<img class="img-thumbnail img-fluid" src="<?=base_url().$foto_certificado_candidato->ruta_directorio.$foto_certificado_candidato->nombre?>" alt="Foto de perfil">
										<label>Firma digital</label>
										<img src="<?= base_url() . $firma_candidato->ruta_directorio . $firma_candidato->nombre ?>"
											 alt="Firma digital" style="max-width: 80px">
									</div>
									<div class="col-lg-8">
										 <div class="form-group row">
											 <label class="col-sm-4">Nombre</label>
											 <span class="col-sm-8"><?=$datos_usuario->nombre ?> <?=$datos_usuario->apellido_p?> <?=$datos_usuario->apellido_m?></span>
											 <label class="col-sm-4">CURP</label>
											 <span class="col-sm-8"><?=$datos_usuario->curp ?></span>
											 <label class="col-sm-4">Genero</label>
											 <span class="col-sm-8"><?=$datos_usuario->genero == 'm' ? 'Masculino' : 'Femenino'?></span>
											 <label class="col-sm-4">Cumpleaños</label>
											 <span class="col-sm-8"><?=isset($datos_usuario->fecha_nacimiento) && ($datos_usuario->fecha_nacimiento != '' || $datos_usuario->fecha_nacimiento == '0000-00-00') ? fecha_castellano_sin_anio($datos_usuario->fecha_nacimiento) : 'Sin dato'?></span>
											 <label class="col-sm-4">Lugar de nacimiento</label>
											 <span class="col-sm-8"><?=$datos_usuario->lugar_nacimiento?></span>
											 <label class="col-sm-4">Nacionalidad:</label>
											 <span class="col-sm-8"><?=$datos_usuario->nacionalidad?></span>
											 <label class="col-sm-4">Número de celular:</label>
											 <span class="col-sm-8"><?=$datos_usuario->celular?></span>
											 <label class="col-sm-4">Número de casa:</label>
											 <span class="col-sm-8"><?=$datos_usuario->telefono?></span>
											 <label class="col-sm-4">Sector productivo de trabajo:</label>
											 <span class="col-sm-8"><?=isset($datos_usuario->sector_productivo) ? $datos_usuario->sector_productivo : 'Sin datos'?></span>
											 <label class="col-sm-4">Domicilio:</label>
											 <span class="col-sm-8"><?=$domicilio?></span>
										 </div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- carta compromiso -->
					<div class="col-lg-12">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Carta compromiso</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>

							<div class="card-body">
								<div class="form-group row">
									<div class="col-md-12 text-right">
										Sistema Integral PED
										- <?= isset($usuario_has_ec) ? fechaBDToHtml($usuario_has_ec->fecha_registro) : 'Sin Fecha' ?>
										.
										<br>Asunto: Carta Compromiso.
									</div>
									<div class="col-md-12 text-left">
										<label>
											C. José Luis Salazar Hernández
											<br>Director Académico
											<br>Entidad de Certificación y Evaluación de Competencias Laborales Cívika ECE
											312-17.
											<br>FUNDACIÓN PARA EL DESARROLLO HUMANO CÍVIKA, A.C.
											<br>P R E S E N T E
										</label>
									</div>
									<div class="col-md-12 text-justify">
										El que suscribe
										C. <?= isset($usuario) ? $usuario->datos_usuario->nombre . ' ' . $usuario->datos_usuario->apellido_p . ' ' . $usuario->datos_usuario->apellido_m : '' ?>
										con domicilio en
										<?= $domicilio ?>,
										bajo protesta de decir verdad, apercibido de la responsabilidad en que incurre todo
										aquel que no se conduce con verdad,
										me encuentro realizando el
										<strong class="mayusculas"><?= $estandar_competencia->codigo . ' ' . $estandar_competencia->titulo ?></strong>,
										por lo que,
										bajo protesta de decir verdad, apercibido de la responsabilidad en que incurre todo
										aquel que no se conduce con verdad,
										me comprometo a realizar dicho proceso bajo los siguientes lineamientos:
										<ol>
											<li>En todo momento seré yo quien realice las actividades y evidencias
												solicitadas en cada módulo. No delegaré a otra persona realizarlo.
											</li>
											<li>Sólo utilizaré el material descargable de la plataforma de Cívika, para
												efectos de este proceso de certificación. No podré reproducirlo sin
												autorización por escrita de sus autores. Reconozco que el material didáctico
												está diseñado para ser una guía para mí y no debe ser usado para fines
												diferentes a este proceso de certificación. Declaro que, los videos,
												podcast, presentaciones, documentación de apoyo, y demás material didáctico
												proporcionado en la plataforma online, son propiedad intelectual de Cívika.
											</li>
											<li>No haré mal uso o uso distinto, a los documentos que descarguen y contengan
												la imagen institucional de Cívika (logos, encabezados, pie de página, etc.)
												Los documentos descargables, así como la imagen institucional que llegarán a
												contener, declaro que son propiedad de Cívika y estoy consciente de los
												delitos que son el robo de identidad así como las sanciones y penas a que me
												puedo hacer acreedor por hacer mal uso de los elementos y componentes de
												dicha imagen institucional.
											</li>
											<li>A partir de hoy, me comprometo a entregar en plazo no mayor a 30 días
												naturales, las actividades y evidencias solicitadas en la plataforma.
											</li>
										</ol>
									</div>
									<div class="col-md-12 text-justify">
										Agradezco, el hecho de que si en algún módulo tengo dudas o no he podido realizar
										correctamente lo solicitado, en el área de "Tutores" mandaré un mensaje para
										solicitar ayuda en el desahogo de mis dudas.

										Agradeciendo su atención, aprovecho la oportunidad para externarle un cordial
										saludo.
										Atentamente:
									</div>
									<div class="col-md-12 text-center">
										NOMBRE: <span
												class="mayusculas"><?= isset($usuario) ? $usuario->datos_usuario->nombre . ' ' . $usuario->datos_usuario->apellido_p . ' ' . $usuario->datos_usuario->apellido_m : '' ?></span>
										<br><img src="<?= base_url() . $firma_candidato->ruta_directorio . $firma_candidato->nombre ?>"
												alt="Firma digital" style="max-width: 120px">
										<br>____________________
										<br>DIRECCIÓN: <span class="mayusculas"><?= $domicilio ?></span>
										<br>CELULAR: <?= isset($usuario->datos_usuario->celular) ? $usuario->datos_usuario->celular : 'Sin registro' ?>
										<br>TELEFONO: <?= isset($usuario->datos_usuario->telefono) ? $usuario->datos_usuario->telefono : 'Sin registro' ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<p>
					He leido la información correspondiente a la ficha de registro y la carta compromiso, declaro que acepto los terminos en los apartados anteriores para proceder con el proceso de Certificación del Estandar de Competencia
				</p>
				<button type="button" class="btn btn-sm btn-success"
						data-id_usuario_has_ec="<?=$usuario_has_ec->id_usuario_has_estandar_competencia?>"
						id="btn_acepto_terminos_certificacion_ec">Acepto</button>
				<a href="<?=base_url()?>estandar_competencia" class="btn btn-sm btn-danger">No acepto</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
