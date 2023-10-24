
	<section class="content" id="tablero_formulario_preguntas_abiertas">
		<div class="card card-solid mt-3">
			<div class="card-header">
				<h2>Formulario</h2>
			</div>
			<div class="card-body pb-0" style="overflow: auto;max-height: 15em;">
				<div id="contenedor_respuestas_abiertas_entregable">
					<?php if (isset($respuestas)): ?>
						<?php foreach ($respuestas as $index => $pa): ?>

							<div class="form-group row">
								<label class="col-form-label col-sm-12"
									   for="txt_pregunta_abierta_<?= $index ?>""><?= $pa->pregunta_formulario_abierto ?></label>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<p><?= $pa->respuesta_pregunta_formulario_abierto ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

		</div>

	</section>
