<label class="col-form-label">Instrumentos de evaluación</label>
<div class="callout callout-success">
	<h5>Información importante</h5>
	<p>
		A continuación carga tus evidencias conforme a las instrucciones correspondientes, para poder pasar al paso de "Juicio de Competencia", es necesario entragar todas las evidencias y esten en estatus de "FINALIZADA"
	</p>
</div>
<section class="content" id="tablero-evidencias_candidato">
		<div class="card">
			<div class="card-body">
				<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
					<div id="contenedor_candidato_entregable" class="row">
						<div class="col">
							<?php $this->load->view('entregables/candidato/tablero_evidencias_candidato'); ?>
						</div>
					</div>
				<?php else: ?>
					<div class="row">
						<div class="col">
							<div class="callout callout-warning">
								<h5>Lo siento</h5>
								<p>No se encontro registros de búsqueda</p>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</section>




