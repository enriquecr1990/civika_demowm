<?php
$numero_actividades = 0;
$numero_actividades_finalizadas = 0;
?>
<?php if(isset($puede_cargar_evidencia_ati) && $puede_cargar_evidencia_ati): ?>
	<?php if(isset($estandar_competencia_instrumento) && is_array($estandar_competencia_instrumento) && sizeof($estandar_competencia_instrumento) != 0): ?>
		<label class="col-form-label">Instrumentos de evaluación</label>
		<div class="callout callout-success">
			<h5>Información importante</h5>
			<p>
				A continuación carga tus evidencias y para cada archivo que subas, seleciona el instrumento al que
				corresponda del listado correspondiente; para poder continuar al paso de "Juicio de Competencia", es
				necesario entregar todas las evidencias para obtener el estatus de "FINALIZADA"
			</p>
		</div>

		<div class="col-md-12">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Carga de evidencia</h3>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-md-4">
							<strong>Subir evidencia</strong>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<input type="file" id="doc_evidencia_ati" name="doc_evidencia_ati"
									   data-div_procesando="#archivo_link_instrumento_act" accept="*/*"
									   class="doc_evidencia_ati_alumno">
								<div id="procesando_doc_evidencia_ati"></div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">
								<input type="url" placeholder="URL de video - YouTube" id="url_evidencia" class="form-control col-md-10">
								<button type="button" class="btn btn-sm btn-outline-success add_url_evidencia"
										data-input_url="#url_evidencia"
										data-contenedor_destino="#tbody_contenedor_doc_evidencia_ati" ><i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>

					<div class="row form-group" style="display: none" id="contenedor_archivo_link_instrumentos_act">
						<form id="form_agregar_evidencia_instrumento_alumno">
							<div class="row form-group">
								<div class="col-md-3" id="archivo_link_instrumento_act"></div>
								<div class="col-md-8 contenedor_select_instrumento_evidencia" style="display: none">
									<select id="select_instrumento_evidencia" class="custom-select" multiple name="ec_instrumento_alumno_evidencia[]">
										<?php foreach ($estandar_competencia_instrumento as $index_eci => $eci): ?>
											<?php if(in_array($eci->id_cat_instrumento,array(INSTRUMENTO_GUIA_OBSERVACION,INSTRUMENTO_LISTA_COTEJO))): ?>
												<optgroup label="<?=$eci->nombre?>">
													<?php if(isset($eci->actividades) && is_array($eci->actividades)):?>
														<?php foreach ($eci->actividades as $index_act => $act): ?>
															<option value="<?=$act->id_ec_instrumento_has_actividad?>"><?=$act->actividad?></option>
														<?php endforeach; ?>
													<?php endif; ?>
												</optgroup>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
									<span class="text-muted">Puedes seleccionar mas de una actividad a reportar; para realizarlo, deja presionada la tecla CTRL de tu teclado y sin soltar ve seleccionando las opciones deseadas</span>
								</div>
								<div class="col-md-1 contenedor_select_instrumento_evidencia"style="display: none">
									<button type="button" id="btn_guardar_evidencia_candidato" class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i></button>
									<button type="button" id="btn_cancelar_evidencia_candidato" class="btn btn-sm btn-outline-danger"><i class="fa fa-ban"></i></button>
								</div>
							</div>
						</form>
					</div>

					<div class="form-group row">
						<div class="col-md-12 table-responsive p-0">
							<table class="table table-striped">
								<thead>
								<th>No</th>
								<th>Evidencia</th>
								<th>Técnicas e instrumentos de evaluación</th>
								<th></th>
								</thead>
								<tbody id="tbody_contenedor_doc_evidencia_ati">
								<?php if(isset($actividades_tecnicas_instrumentos_alumno) && is_array($actividades_tecnicas_instrumentos_alumno) && !empty($actividades_tecnicas_instrumentos_alumno)): ?>
								<?php else: ?>
									<tr>
										<td colspan="4" class="text-center">Sin registros encontrados</td>
									</tr>
								<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<div class="callout callout-danger">
		<h5>Información importante</h5>
		<p>No es posible cargar la evidencia de las técnicas, instrumentos y actividades del estándar de competencia hasta que realize la evaluación diagnóstica</p>
	</div>
<?php endif;?>
<input type="hidden" id="numero_actividades" value="<?=$numero_actividades?>">
<input type="hidden" id="numero_actividades_finalizadas" value="<?=$numero_actividades_finalizadas?>">

<div class="form-group row justify-content-between">
	<div class="col-lg-6 text-left">
		<button type="button" class="btn btn-sm btn-outline-info btn_paso_anterior_pasos" data-anterior_link="#tab_evaluacion_requerimientos-tab">
			<i class="fa fa-backward"></i> Anterior
		</button>
	</div>
	<div class="col-lg-6 text-right">
		<button type="button" data-siguiente_link="#tab_jucio_competencia-tab" data-numero_paso="4" disabled="disabled"
				class="btn btn-outline-success btn-sm guardar_progreso_pasos">Siguiente <i class="fa fa-forward"></i></button>
	</div>
</div>
