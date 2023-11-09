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
					<?php if (isset($liberado) && !$liberado): ?>
						<button type="button" id="btn_nuevo_entregable" class="btn btn-sm btn-outline-success"><i
								class="fa fa-plus-square"></i> Nuevo
						</button>
					<?php endif; ?>
				</div>
			</div>

		</div>

		<div class="card">
			<div class="card-body">
				<div id="contenedor_entregables">
				</div>
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
