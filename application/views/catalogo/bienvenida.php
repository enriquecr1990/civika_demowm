<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_estandar_competencia">

		<div class="card">
			<div class="card-body">
				<div class="form-group row">
					<input type="hidden" id="input_id_msg_bienvenida" value="<?=$cat_msg_bienvenida->id_cat_msg_bienvenida?>">
					<div class="col-lg-12">
						<textarea id="textarea_msg_bienvenida" name="mensaje_bienvenida" class="form-control" data-rule-required="true" ><?=$cat_msg_bienvenida->nombre?></textarea>
					</div>
					<div class="col-lg-12 text-right">
						<button id="btn_guardar_msg_bienvenida" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-save"></i> Guardar</button>
					</div>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
