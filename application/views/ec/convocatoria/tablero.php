<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia_convocatoria">
		<?php if((isset($estandar_competencia_evaluacion) && is_object($estandar_competencia_evaluacion)
							&& isset($instructores_asignados) && sizeof($instructores_asignados) != 0)): ?>

			<div class="container-fluid mb-3">
				<div class="row">
					<div class="col-md-6" style="display: none;" >
						<input type="hidden" id="id_estandar_competencia" value="<?=$estandar_competencia->id_estandar_competencia?>">
						<div class="input-group">
							<input type="text" id="input_buscar_estandar_competencia" class="form-control form-control-lg" name="busqueda" placeholder="Escribe algo para buscar">
							<div class="input-group-append">
								<button type="button" id="btn_buscar_convocatoria_ec" class="btn btn-lg btn-default" data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
						<small class="form-text text-muted">Escribe algun texto de referencia, puedes buscar entre nombre, apellidos, correo, telefono o CURP; cuando termines pulsa en el boton del icono de buscar</small>
					</div>
					<?php if(perfil_permiso_operacion_menu('estandar_competencia.agregar')): ?>
						<div class="col-md-12 text-right">
							<button type="button" id="agregar_convocatoria_estandar_competencia"
								data-id_estandar_competencia="<?=$estandar_competencia->id_estandar_competencia?>"
								class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nueva</button>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="card card-solid" id="card_resultados_convocatoria_ec">
				<div class="card-body pb-0">
					<div class="row">
						<div>
						<?php if (isset($estandar_competencia)): ?>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Estándar de competencia: </label>
								<span class="col-sm-8 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
							</div>
						<?php endif; ?>

						<hr>
						<div class="form-group row">
							<label class="col-form-label">Convocatorias publicadas</label>
						</div>

						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive p-0">
									<table class="table table-striped">
										<thead>
										<tr>
											<th>ID</th>
											<th>Titulo</th>
											<th style="min-width: 300px;">Programación y costos</th>
											<th>Datos Generales</th>
											<th>Estatus</th>
											<th>Operaciones</th>
										</tr>
										</thead>
										<tbody id="contenedor_resultados_convocatoria_ec">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="contenedor_resultados_convocatoria_ec"></div>
				</div>
			</div>			
			

		<?php else: ?>
			<div class="card card-solid" id="card_resultados_convocatoria_ec">
				<div class="card-body pb-0">
					<div class="form-group row">
						<div class="callout callout-warning col-md-12">
							<h5>Lo siento</h5>
							<p>Para poder realizar la publicación de una convocatoria, es necesario que registre:</p>
							<ol>
								<li>La evaluación diagnóstica liberada <span class="badge badge-dark"><?=isset($estandar_competencia_evaluacion) && is_object($estandar_competencia_evaluacion) != 0 ? 'OK':'Falta'?></span></li>
								<li>Asignar por lo menos un evaluador al Estándar de competencia <span class="badge badge-dark"><?=isset($instructores_asignados) && sizeof($instructores_asignados) != 0 ? 'OK':'Falta'?></span></li>
							</ol>
							<p>Los puntos que aparecen como <span class="badge badge-dark">Falta</span>, son aquellos que aún no esta cargado al sistema</p>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
