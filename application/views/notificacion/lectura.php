<div class="card card-success card-outline">
	<div class="card-header">
		<h3 class="card-title">Notificación</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="row">
			<div class="col-md-2"><strong>Para:</strong></div>
			<div class="col-md-10"><span><?=$notificacion->destinatario?></span></div>
		</div>
		<div class="row">
			<div class="col-md-2"><strong>De:</strong></div>
			<div class="col-md-10"><span><?=$notificacion->remitente?></span></div>
		</div>
		<div class="row">
			<div class="col-md-2"><strong>Fecha:</strong></div>
			<div class="col-md-10"><span><?=fechaHoraBDToHTML($notificacion->fecha)?></span></div>
		</div>
		<div class="row">
			<div class="col-md-2"><strong>Asunto:</strong></div>
			<div class="col-md-10"><span><?=$notificacion->asunto?></span></div>
		</div>
		<?php if(isset($archivos) && is_array($archivos) && sizeof($archivos)): ?>
			<hr>
			<div class="row">
				<strong class="col-md-2">Adjuntos:</strong>
				<div class="col-md-10">
					<ul>
						<?php foreach ($archivos as $a):?>
							<li><a href="<?=base_url().$a->ruta_directorio.$a->nombre?>" target="_blank"><?=$a->nombre?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<hr>
		<div class="row">
			<label class="col-md-2">Mensaje:</label>
			<div class="col-md-10">
				<?=$notificacion->mensaje?>
			</div>
		</div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
		<div class="float-right">
		</div>
		<button type="button" class="btn btn-default regresar_notificaciones"><i class="fas fa-backward"></i> Regresar</button>
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->
