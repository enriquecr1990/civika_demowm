<?php if (isset($estandar_competencia) && sizeof($estandar_competencia) != 0): ?>
	<?php foreach ($estandar_competencia as $index => $ec): ?>
		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 d-flex align-items-stretch flex-column">
			<!-- Widget: user widget style 1 -->
			<div class="card card-widget widget-user">
				<!-- Add the bg color to the header using any of the bg-* classes -->
				<div class="widget-user-header text-white" style="background: url(<?=base_url().$ec->ruta_directorio.$ec->nombre?> ) center center; background-size: cover">
<!--					<h3 class="widget-user-desc text-center" ><?=$ec->codigo?></h3>-->
				</div>
				<div class="widget-user-image">
					<img class="img-circle" src="<?=isset($ec->instructor->foto_perfil) ? $ec->instructor->foto_perfil : base_url().'assets/imgs/iconos/admin.png' ?>"
						 alt="<?=$ec->instructor->nombre.' '.$ec->instructor->apellido_p?>">
				</div>
				<div class="card-body mt-2">
					<div class="row text-justify">
						<?php if(strlen($ec->codigo.'-'.$ec->titulo) > 140): ?>
							<p>
								<?=substr($ec->codigo.'-'.$ec->titulo,0,140)?><span class="span_titulo_ec">...</span><span class="complemento_titulo_ec" style="display: none;"><?=substr($ec->titulo,140)?></span>
								<button type="button" class="btn btn-sm btn-default btn_ver_titulo_completo_ec mostrar_todo"><i class="fa fa-eye"></i></button>
							</p>
						<?php else: ?>
							<?=$ec->codigo.'-'.$ec->titulo?>
						<?php endif ?>
						<p>
							<b>Evaluador: </b><?=$ec->instructor->nombre.' '.$ec->instructor->apellido_p.' '.$ec->instructor->apellido_m?>
						</p>
					</div>
				</div>
				<div class="card-footer p-1 ">
					<div class="text-right">
						<a class="btn btn-sm btn-success" href="<?=base_url()?>AlumnosEC/ver_progreso/<?=$ec->id_estandar_competencia?>/<?=$ec->instructor->id_usuario?>"
						   data-toggle="tooltip" title="Ver progreso">
							<i class="fa fa-tasks"></i> Progreso: <?=number_format(($ec->progreso_pasos / 6) * 100,2)?>%
						</a>

					</div>
					<!-- /.row -->
				</div>
			</div>
			<!-- /.widget-user -->
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<?php $this->load->view('default/sin_datos'); ?>
<?php endif; ?>
<!-- /.card-body -->
