<div class="form-group row">
	<div class="col-sm-12 text-right">
		<button type="button" class="btn btn-sm btn-outline-success btn_modificar_direccion"
				data-id_usuario="<?=$usuario->id_usuario?>"
				data-id_datos_domicilio="" id="btn_agregar_direccion">
			<i class="fa fa-plus"> Agregar</i>
		</button>
	</div>
</div>
<hr>
<div class="form-group row">
	<?php if(isset($datos_domicilio) && is_array($datos_domicilio) && sizeof($datos_domicilio) != 0): ?>
		<?php foreach ($datos_domicilio as $dd): ?>
			<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
				<div class="card bg-light d-flex flex-fill">
					<div class="card-body pt-0">
						<?php if($dd->predeterminado == 'si'): ?>
							<div class="ribbon ribbon-wrapper">
								<div class="ribbon bg-success">
									Principal
								</div>
							</div>
						<?php endif; ?>

						<div class="row">
							<div class="col-12 mt-3">
								<ul class="ml-4 mb-0 fa-ul text-muted">
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-road"></i></span>Calle: <?=$dd->calle?></li>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-sort-numeric-asc"></i></span><?=' Número Ext. '.$dd->numero_ext. ' - Num int. '.$dd->numero_int?></li>
									<li class="small"><span class="fa-li"></span>Código postal: <?=$dd->codigo_postal?></li>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marked-alt"></i></span><?=$dd->localidad.', '.$dd->municipio.', '.$dd->estado?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
							<button type="button" class="btn btn-outline-info btn-sm btn_modificar_direccion" data-id_datos_domicilio="<?=$dd->id_datos_domicilio?>"
									data-id_usuario="<?=$usuario->id_usuario?>"
									data-toggle="tooltip" title="Modificar dirección">
								<i class="fas fa-edit"></i>
							</button>
							<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar dirección"
									data-msg_confirmacion_general="¿Esta seguro de eliminar la dirección?, esta acción no podrá revertirse"
									data-url_confirmacion_general="<?=base_url()?>Perfil/eliminar_domicilio/<?=$dd->id_datos_domicilio?>" data-btn_trigger="#tab_direcciones">
								<i class="fas fa-trash"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<?php $this->load->view('default/sin_datos'); ?>
	<?php endif;?>
</div>
