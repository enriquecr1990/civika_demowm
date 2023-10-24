<div class="modal fade" id="modal_convocatoria_ec_detalle" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Convocatoria del Estándar de Competencia</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<img src="<?=base_url().$estandar_competencia_convocatoria->ruta_directorio.$estandar_competencia_convocatoria->nombre?>" class="img-thumbnail" alt="Convocatoria Estandar de competencia">
					</div>
					<div class="col-sm-3"></div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="col-form-label">Estandar de competencia: </label> <span><?=$estandar_competencia_convocatoria->titulo?></span>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12"><i class="fa fa-calendar"></i> Fechas:</div>
					<div class="col-sm-12">
						<label class="col-form-label">Programa del &nbsp;</label><span><?=fecha_castellano_sin_anio($estandar_competencia_convocatoria->programacion_inicio)?></span>
						<label class="col-form-label"> al &nbsp;</label><span><?=fechaCastellano($estandar_competencia_convocatoria->programacion_fin)?></span>
					</div>
					<div class="col-sm-12">
						<label class="col-form-label">Alineación del &nbsp;</label><span><?=fecha_castellano_sin_anio($estandar_competencia_convocatoria->alineacion_inicio)?></span>
						<label class="col-form-label"> al &nbsp;</label><span><?=fechaCastellano($estandar_competencia_convocatoria->alineacion_fin)?></span>
					</div>
					<div class="col-sm-12">
						<label class="col-form-label">Evaluación del &nbsp;</label><span><?=fecha_castellano_sin_anio($estandar_competencia_convocatoria->evaluacion_inicio)?></span>
						<label class="col-form-label"> al &nbsp;</label><span><?=fechaCastellano($estandar_competencia_convocatoria->evaluacion_fin)?></span>
					</div>
					<div class="col-sm-12">
						<label class="col-form-label">Evaluación del &nbsp;</label><span><?=fecha_castellano_sin_anio($estandar_competencia_convocatoria->certificado_inicio)?></span>
						<label class="col-form-label"> al &nbsp;</label><span><?=fechaCastellano($estandar_competencia_convocatoria->certificado_fin)?></span>
					</div>
				
				</div>

				<div class="form-group row">
					<?php if(existe_valor($estandar_competencia_convocatoria->proposito)): ?>
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-book"></i> Propósito:</label>
							<div><?=$estandar_competencia_convocatoria->proposito?></div>
						</div>
					<?php endif ?>
					<?php  if(existe_valor($estandar_competencia_convocatoria->descripcion)): ?>
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-book-open"></i> Descripción:</label>
							<div><?=$estandar_competencia_convocatoria->descripcion?></div>
						</div>
					<?php endif; ?>
					<?php  if(existe_valor($estandar_competencia_convocatoria->sector_descripcion)): ?>
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-industry"></i> Sector: </label> <span><?=$estandar_competencia_convocatoria->nombre_sector?></span>
							<div><?=$estandar_competencia_convocatoria->sector_descripcion?></div>
						</div>
					<?php endif; ?>
					<?php  if(existe_valor($estandar_competencia_convocatoria->perfil)): ?>
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-user-graduate"></i> Perfil</label>
							<div><?=$estandar_competencia_convocatoria->perfil?></div>
						</div>
					<?php endif; ?>
					<?php  if(existe_valor($estandar_competencia_convocatoria->duracion_descripcion)): ?>
						<div class="col-sm-12">
							<label for="input_textarea_proposito" class="col-form-label"><i class="fa fa-clock"></i> Duración</label>
							<div><?=$estandar_competencia_convocatoria->duracion_descripcion?></div>
						</div>
					<?php endif; ?>
					
				</div>

				<div class="form-group row">
					<label class="col-sm-12 col-form-label"><i class="fa fa-money-bill"></i> Costos: </label>
					<div class="col-sm-3">
						<label for="input_costo_alineacion" class="col-form-label">Alineación:</label> <span>$<?=$estandar_competencia_convocatoria->costo_alineacion?></span>
					</div>
					<div class="col-sm-3">
						<label for="input_costo_evaluacion" class="col-form-label">Evaluación:</label> <span>$<?=$estandar_competencia_convocatoria->costo_evaluacion?></span>
					</div>
					<div class="col-sm-3">
						<label for="input_costo_certificado" class="col-form-label">Certificado:</label> <span>$<?=$estandar_competencia_convocatoria->costo_certificado?></span>
					</div>
					<div class="col-sm-3">
						<label for="input_costo" class="col-form-label">Total:</label> <span>$<?=$estandar_competencia_convocatoria->costo?></span>
					</div>
				</div>

			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
				<?php if(isset($usuario) && is_object($usuario)): ?>
					<?php if(isset($existe_usuario_ec) && $existe_usuario_ec): ?>
						<span class="badge badge-success"></span>Estas registrado</span>
					<?php else: ?>
					<?php endif; ?>
				<?php else: ?>
					<a href="<?=base_url()?>registro/<?=$estandar_competencia_convocatoria->id_estandar_competencia_convocatoria?>"
						class="btn btn-sm btn-outline-primary">Registrarme</a>
				<?php endif; ?>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
