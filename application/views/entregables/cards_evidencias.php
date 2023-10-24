<?php if (isset($entregables) && sizeof($entregables) != 0): ?>
		<?php foreach ($entregables as $index => $item): ?>
			<div class="col-3 mb-3">
				<div class="card" style="height: 100%;">
					<div class="card-body">
						<div class="row">
							<div class="col-10">
								<h5 class="card-title text-bold">

									<?php if ($item->tipo_entregable == "prod") : ?>
										<em style="color: var(--blue)" class="fa fa-file mr-1"></em>
									<?php  endif; ?>

									<?php if ($item->tipo_entregable == "form") : ?>
										<em style="color: var(--dark)" class="fa fa-list mr-1"></em>
									<?php  endif; ?>

									<?php if ($item->tipo_entregable == "cuest") : ?>
										<em style="color: var(--green)" class="fa fa-question mr-1"></em>
									<?php  endif; ?>


									<?= $item->nombre ?></h5>
							</div>
							<div class="col-2">
								<div class="dropdown">
									<button id="edit" class="btn btn-sm btn-light dropdown-toggle" type="button"
											data-toggle="dropdown" aria-expanded="fal|">
										<em class="fa fa-ellipsis-v"></em>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item modificar_entregable" data-id="<?= $item->id_entregable ?>" href="#">Editar</a>
										<a class="dropdown-item iniciar_confirmacion_operacion"
										   data-msg_confirmacion_general="¿Esta seguro de eliminar el entregable?, esta acción no podrá revertirse"
										   data-url_confirmacion_general="<?=base_url()?>Entregable/eliminar/<?=$item->id_entregable?>"
										   data-btn_trigger="#btn_buscar_sectores"
										   href="#">Eliminar</a>
										<?php
										if ($item->tipo_entregable == "form") : ?>
										<a class="dropdown-item" href="<?= base_url().'preguntas_abiertas/'.$item->id_entregable?>">Cargar formulario</a>
										<?php  endif; ?>

										<?php
										if ($item->tipo_entregable == "cuest") : ?>
										<a class="dropdown-item" href="<?= base_url().'evaluacion_entregable/'.$item->id_entregable?>">Cargar cuestionario</a>
										<?php  endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<?php foreach ($item->instrumentos as $i => $instrumento): ?>
								<div class="col-12 lines-2">
									<em style="font-size: xx-small" class="fa fa-circle"></em>
									<span
										title="La carta descriptiva elaborada."> <?= $instrumento->actividad ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
<?php endif;?>
