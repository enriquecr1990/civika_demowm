<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" id="tablero_perfil_permisos">

		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					<label for="cat_perfil" class="col-form-label col-md-3">Perfil del usuario</label>
					<select id="cat_perfil" class="custom-select form-control-border col-md-9" name="id_cat_instrumento" required>
						<?php if(isset($cat_perfil)): ?>
							<?php foreach ($cat_perfil as $cp): ?>
								<option value="<?=$cp->id_cat_perfil?>"><?=$cp->nombre?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>
		</div>

		<div class="card card-solid mt-3">
			<div class="card-body pb-0">
				<div class="row" id="contenedor_resultados_perfil_permiso">
					<?php $this->load->view('perfil_permisos/resultado_tablero'); ?>
				</div>
			</div>
		</div>

	</section>
	<!-- /.content -->

</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
