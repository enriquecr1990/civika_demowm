<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<input type="hidden" id="input_id_estandar_competencia" value="<?=isset($estandar_competencia) ? $estandar_competencia->id_estandar_competencia : ''?>">
		<input type="hidden" id="input_id_usuario_alumno" value="<?=isset($usuario) ? $usuario->id_usuario : ''?>">
		<input type="hidden" id="input_id_usuario_evaluador" value="<?=isset($evaluador) ? $evaluador->id_usuario : ''?>">
		<input type="hidden" id="input_id_usuario_has_estandar_competencia" value="<?=isset($usuario_has_ec) ? $usuario_has_ec->id_usuario_has_estandar_competencia : ''?>">
		<input type="hidden" id="input_pregreso_pasos" value="<?=isset($progreso_pasos) ? $progreso_pasos : 0?>">

		<div class="row">
			<div class="col-md-12">

				<div class="card card-primary card-outline">
					<div class="card-body">
						<div class="row">
							<div class="col-5 col-sm-3">
								<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link active text-green" id="tab_evaluacion_diagnostica-tab" data-toggle="pill" href="#tab_evaluacion_diagnostica"
									   role="tab" aria-controls="tab_evaluacion_diagnostica" aria-selected="true">
										<i class="fa fa-tasks"></i> Evaluación diagnóstica
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 1 ? 'text-green':'disabled'?>" id="tab_derechos_obligaciones-tab"  data-toggle="pill" href="#tab_derechos_obligaciones"
									   role="tab" aria-controls="tab_derechos_obligaciones" aria-selected="false">
										<i class="fa fa-file-alt"></i> Derechos y obligaciones
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 2 ? 'text-green':'disabled'?>" id="tab_evaluacion_requerimientos-tab"  data-toggle="pill" href="#tab_evaluacion_requerimientos"
									   role="tab" aria-controls="tab_evaluacion_requerimientos" aria-selected="false">
										<i class="fa fa-list-alt"></i> Plan de evaluación/requerimientos
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 3 ? 'text-green':'disabled'?>" id="tab_evidencias-tab"  data-toggle="pill" href="#tab_evidencias"
									   role="tab" aria-controls="tab_evidencias" aria-selected="false">
										<i class="fa fa-folder-open"></i> Evidencias
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 4 ? 'text-green':'disabled'?>" id="tab_jucio_competencia-tab"  data-toggle="pill" href="#tab_jucio_competencia"
									   role="tab" aria-controls="tab_jucio_competencia" aria-selected="false">
										<i class="fa fa-check-circle"></i> Juicio de competencia
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 5 ? 'text-green':'disabled'?>" id="tab_certificado-tab"  data-toggle="pill" href="#tab_certificado"
									   role="tab" aria-controls="tab_certificado" aria-selected="false">
										<i class="fa fa-certificate"></i> Certificado del EC
									</a>
									<a class="nav-link <?=isset($progreso_pasos) && $progreso_pasos >= 6 ? 'text-green':'disabled'?>" id="tab_encuesta_satisfaccion-tab"  data-toggle="pill" href="#tab_encuesta_satisfaccion"
									   role="tab" aria-controls="tab_encuesta_satisfaccion" aria-selected="false">
										<i class="fa fa-question"></i> Encuesta de satisfacción
									</a>
								</div>
							</div>
							<div class="col-7 col-sm-9">
								<div class="tab-content" id="vert-tabs-tabContent">
									<div class="tab-pane text-left fade active show" id="tab_evaluacion_diagnostica" role="tabpanel" aria-labelledby="tab_evaluacion_diagnostica-tab">
										<div id="contenedor_eva_diagnostica"></div>
									</div>
									<div class="tab-pane fade" id="tab_derechos_obligaciones" role="tabpanel" aria-labelledby="tab_derechos_obligaciones-tab"></div>
									<div class="tab-pane fade" id="tab_evaluacion_requerimientos" role="tabpanel" aria-labelledby="tab_evaluacion_requerimientos-tab"></div>
									<div class="tab-pane fade" id="tab_evidencias" role="tabpanel" aria-labelledby="tab_evidencias-tab">
										<div id="contenedor_pasos_evidencias"></div>
									</div>
									<div class="tab-pane fade" id="tab_jucio_competencia" role="tabpanel" aria-labelledby="tab_jucio_competencia-tab">
										<div id="contenedor_pasos_juicio_competencia"></div>
									</div>
									<div class="tab-pane fade" id="tab_jucio_competencia" role="tabpanel" aria-labelledby="tab_jucio_competencia-tab">
										<div id="contenedor_pasos_certificado_ec"></div>
									</div>
									<div class="tab-pane fade" id="tab_certificado" role="tabpanel" aria-labelledby="tab_certificado-tab">
										<div id="contenedor_pasos_certificados"></div>
									</div>
									<div class="tab-pane fade" id="tab_encuesta_satisfaccion" role="tabpanel" aria-labelledby="tab_encuesta_satisfaccion-tab">
										<div id="contenedor_pasos_encuesta_satisfacion"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-primary collapsed-card">
					<div class="card-header">
						<label class="modal-title">Estándar de Competencia y Datos del evaluador</label>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<span class="col-sm-12 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
						</div>
						<div class="form-group row">
							<div class="col-md-8">
								<h6 class="lead"><b>Evaluador: </b><?=isset($evaluador) ? $evaluador->nombre.' '.$evaluador->apellido_p.' '.$evaluador->apellido_m : ''?></h6>
								<ul class="ml-4 mb-0 fa-ul text-muted">
									<?php if(isset($evaluador->profesion)): ?>
										<li class="small"><span class="fa-li"><i class="fas fa-lg fa-user-graduate"></i></span> Profesión: <?=$evaluador->profesion?></li>
									<?php endif; ?>
									<?php if(isset($evaluador->puesto)): ?>
										<li class="small"><span class="fa-li"><i class="fas fa-lg fa-globe-americas"></i></span> Puesto: <?=$evaluador->puesto?></li>
									<?php endif; ?>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span><a href="mailto:<?=$evaluador->correo?>"><?=$evaluador->correo?></a> </li>
									<li class="small"><span class="fa-li"><i class="fas fa-lg fa-mobile"></i></span><?=$evaluador->celular?></li>
									<?php if(isset($evaluador->telefono) && $evaluador->telefono != ''): ?>
										<li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><?=$evaluador->telefono?></li>
									<?php endif; ?>
								</ul>
							</div>
							<div class="col-md-4 text-center">
								<img style="max-width: 150px" src="<?=isset($evaluador->foto_perfil) ? $evaluador->foto_perfil : base_url().'assets/imgs/iconos/admin.png' ?>" alt="<?=$evaluador->nombre.' '.$evaluador->apellido_p?>" class="img-circle img-fluid">
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /.row -->

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
