<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_estandar_competencia_ati">

			<div class="container-fluid mb-3">
				<div class="row">
					<div class="col-md-6"  >
						<div class="input-group" style="display: none;">
							<div class="input-group-append">
								<button type="button" data-id_estandar_competencia="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>"
										id="btn_buscar_estandar_competencia_ati" class="btn btn-lg btn-default">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<?php if(isset($existe_evidencia_alumnos) && !$existe_evidencia_alumnos): ?>
							<?php if(perfil_permiso_operacion_menu('tecnicas_instrumentos.agregar')): ?>
								<button type="button" id="agregar_estandar_competencia_ati" class="btn btn-sm btn-outline-success"
										data-id_estandar_competencia="<?=isset($id_estandar_competencia) ? $id_estandar_competencia : ''?>" >
									<i class="fa fa-plus-square"></i> Nuevo instrumento
								</button>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="card card-solid" id="card_formulario_ati" style="display: none">
				<div class="card-body pb-0" id="contenedor_formulario_ati"></div>
			</div>

			<div class="card card-solid" id="card_resultados_ati">
				<div class="card-body pb-0">
					<div id="contenedor_resultados_estandar_competencia_ati"></div>
				</div>
			</div>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
