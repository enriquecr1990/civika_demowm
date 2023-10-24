<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<div class="container-fluid mb-3">
			<div class="row mb-03">
				<div class="col-md-6">
							<button hidden type="button" id="btn_buscar_sectores"></button>
				</div>
				<div class="col-md-6 text-right">
					<button type="button" id="btn_nuevo_sector" class="btn btn-sm btn-outline-success"><i class="fa fa-plus-square"></i> Nuevo</button>
				</div>
			</div>

		</div>

		<div class="card">
			<div class="card-body">
				<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nombre</th>
						<th scope="col">Acciones</th>
					</tr>
					</thead>
					<tbody id="contenido_tabla_sectores">
					<?php if($pagina_select ==1 ): ?>
						<input type="hidden" id="paginacion_usuario" value="<?=$pagina_select?>" data-max_paginacion="<?=$paginas?>">
					<?php endif; ?>
					<?php $this->load->view('catalogo/tablas/tabla_sectores')?>
					</tbody>
				</table>
			</div>
		</div>

	</section>
	<!-- /.content -->

	<div id="contenedor_modal_sector">
		<?php $this->load->view('catalogo/formulario/form_sector'); ?>
	</div>

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
