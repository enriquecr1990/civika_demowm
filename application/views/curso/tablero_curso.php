<?php $this->load->view('default/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php $this->load->view('menu/content_header');?> 
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" style="margin-left: 5% !important; margin-right: 5% !important">
		<input type="hidden" id="id_estandar_competencia" value="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>" >
		<div class="input-group" style="display: none;">
			<div class="input-group-append">
				<button type="button" data-id_estandar_competencia="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>"
						id="btn_buscar_ec_curso" class="btn btn-lg btn-default">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>

		<div class="col-md-12 text-left">
			<label class="col-sm-2 col-form-label">Estándar de competencia: </label><span
					class="col-sm-10 col-form-label"><?= $estandar_competencia->codigo . ' - ' . $estandar_competencia->titulo ?></span>
		</div>
		<div class="container-fluid mb-12">
			
			<div class="col-md-12 text-right">
				<?php if(perfil_permiso_operacion_menu('curso_ec.agregar')): ?>
					<button type="button" id="agregar_estandar_competencia_curso" class="btn btn-md btn-outline-success"
							data-id_estandar_competencia="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>" >
						<i class="fa fa-plus-square"></i> Nuevo módulo de capacitación</button>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="row" id="contenedor_resultados_cursos_ec"></div>

	</section>
	<!-- /.content -->

	<div id="contenedor_modal_curso"></div>
	
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('default/footer', ['is_public' => true]); ?>
