<?php if(isset($estandar_competencia_convocatoria) && is_array($estandar_competencia_convocatoria) && !empty($estandar_competencia_convocatoria)): ?>
	<?php foreach($estandar_competencia_convocatoria as $index => $convocatoria): ?>
		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
			<div class="card" style="width: 18rem;">
				<img src="<?=base_url().$convocatoria->ruta_directorio.$convocatoria->nombre?>" class="card-img-top img-convocatoria-publicada" alt="...">
				<div class="card-body text-justify">
					<p class="card-text" >
						<?php if(strlen($convocatoria->titulo) > 100): ?>
							<span data-toggle="tooltip" title="<?=$convocatoria->titulo?>">
								<?=substr($convocatoria->titulo,0,100).'...'?>
							</span>
						<?php else: ?>
							<span><?=$convocatoria->titulo?></span>
						<?php endif; ?>
						
					 </p>
				</div>
				<div class="card-footer text-right">
					<button type="button" class="btn btn-sm btn-outline-secondary ver_detalle_convocatoria" data-id_estandar_competencia_convocatoria="<?=$convocatoria->id_estandar_competencia_convocatoria?>">
						<i class="fa fa-eye"></i> Ver detalle
					</button>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<div class="card card-solid" id="card_resultados_convocatoria_ec">
		<div class="card-body pb-0">
			<div class="form-group row">
				<div class="callout callout-warning col-md-12">
					<h5>Aviso IMPORTANTE</h5>
					<p>
						En este momento no contamos con convocatorias vigentes o se está cargando la información 
						de los Estándares de Competencia por parte de la entidad certificadora y/o el evaluador
					</p>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>
