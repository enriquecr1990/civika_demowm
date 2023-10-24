<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header'); ?>
	<!-- /.content-header -->

	<!-- Main content -->
	<input hidden id="id_estandar_competencia" value="<?= isset($estandar) ? $estandar : '' ?>">
	<section class="content" id="tablero_estandar_competencia">

		<div class="container-fluid mb-3">
			<div class="row mb-03">
				<div class="col-md-6">
					<button hidden type="button" id="btn_buscar_entregables"></button>
				</div>
				<div class="col-md-6 text-right">
					<button type="button" id="btn_nuevo_entregable" class="btn btn-sm btn-outline-success"><i
							class="fa fa-plus-square"></i> Nuevo
					</button>
				</div>
			</div>

		</div>

		<div class="card">
			<div class="card-body">
				<?php if (isset($entregables) && sizeof($entregables) != 0): ?>

					<div id="contenedor_entregables" class="row">
					</div>
					<div class="row text-right">
						<div class="col mb-3">
							<button id="btn-liberar" class="btn btn-outline-success">Liberar</button>
						</div>
					</div>
				<?php else: ?>
					<div class="row">
						<div class="col">
							<div class="callout callout-warning">
								<h5>Lo siento</h5>
								<p>No se encontro registros de búsqueda</p>
							</div>
						</div>
					</div>
				<?php endif; ?>


			</div>
		</div>

	</section>
	<!-- /.content -->

	<div id="contenedor_modal_entregable">
		<?php $this->load->view('entregables/modal_formulario'); ?>
	</div>

</div>


<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
