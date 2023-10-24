<div class="form-group row">
	<div class="col-sm-12 text-right">
		<button type="button" class="btn btn-sm btn-outline-success btn_modificar_empresa"
				data-id_usuario="<?=$usuario->id_usuario?>"
				data-id_datos_empresa="" id="btn_agregar_empresa">
			<i class="fa fa-plus"> Agregar</i>
		</button>
	</div>
</div>
<hr>
<div class="form-group row">
	<?php if(isset($datos_empresa) && is_array($datos_empresa) && sizeof($datos_empresa) != 0): ?>
		<?php foreach ($datos_empresa as $de): ?>
			<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
				<div class="card bg-light d-flex flex-fill">
					<div class="card-body pt-0">
						<?php if($de->vigente == 'si'): ?>
							<div class="ribbon ribbon-wrapper">
								<div class="ribbon bg-success">
									Actual
								</div>
							</div>
						<?php endif; ?>

						<div class="row">
							<div class="col-10 mt-3">
								<ul class="ml-4 mb-0 fa-ul">
									<li class="small"><?=$de->nombre?></li>
									<li class="small"><?=$de->rfc?></li>
									<li class="small"><?=$de->domicilio_fiscal?></li>
									<li class="small"><?=$de->telefono?></li>
									<li class="small"><?=$de->correo?></li>
									<li class="small"><?=$de->representante_legal?></li>
									<li class="small"><?=$de->representante_trabajadores?></li>
									<li class="smal">
										<img class="profile-user-img img-fluid img-circle img_foto_certificado" src="<?=base_url().$de->ruta_directorio_logo.'/'.$de->nombre_archivo_logo?>" alt="Logotipo empresa">
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
							<button type="button" class="btn btn-outline-info btn-sm btn_modificar_empresa" data-id_datos_empresa="<?=$de->id_datos_empresa?>"
									data-id_usuario="<?=$usuario->id_usuario?>"
									data-toggle="tooltip" title="Modificar empresa">
								<i class="fas fa-edit"></i>
							</button>
							<button type="button" class="btn btn-sm btn-outline-danger iniciar_confirmacion_operacion" data-toggle="tooltip" title="Eliminar empresa"
									data-msg_confirmacion_general="¿Esta seguro de eliminar la Empresa?, esta acción no podrá revertirse"
									data-url_confirmacion_general="<?=base_url()?>Perfil/eliminar_empresa/<?=$de->id_datos_empresa?>" data-btn_trigger="#tab_datos_empresa">
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
