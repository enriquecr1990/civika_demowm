<?php $this->load->view('default/header'); ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php $this->load->view('menu/content_header');?>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content" id="tablero_formulario_preguntas_abiertas">
		<div class="form-group row">
					<div class="col-sm-6">
						<button type="button" style="display: none" id="btn_buscar_preguntas_abiertas">buscar</button>
					</div>
				</div>
			<div class="form-group row">
				<div class="col-sm-12 text-right">

				<input type="hidden" id="input_id_entregable_evidencia" value="<?=isset($id_entregable_evidencia) ? $id_entregable_evidencia : ''?>">
				<?php if(perfil_permiso_operacion_menu('preguntas_evaluacion.agregar')):?>
					<button id="agregar_pregunta_abierta"
							class="btn btn-outline-info btn-sm align" data-toggle="tooltip"
							title="Agregar pregunta abierta"
							data-id_entregable_evidencia="<?=$id_entregable_evidencia?>"
							type="button" ><i class="fa fa-list-alt"></i> Agregar pregunta
					</button>
				<?php endif; ?>
				</div>
			</div>
			<div class="card card-solid mt-3">
				<input hidden id="id_formulario" value="<?= isset($id_formulario) ? $id_formulario : ''?>">
				<div class="card-body pb-0">
					<div id="contenedor_preguntas_abiertas_entregable_<?=$id_entregable_evidencia?>"></div>
				</div>
			</div>

		</section>
		<!-- /.content -->

	</div>
	<!-- /.content-wrapper -->

<?php $this->load->view('default/footer'); ?>
