<!-- /.content-wrapper -->
<footer class="main-footer">
	<strong>Copyright &copy; 2021 - Civika Holding.</strong>
	Todos los derechos reservados
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 0.9.0
	</div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<div id="contenedor_modal_primario"></div>
<div id="contenedor_modal_sedundario"></div>

<div id="modal_confirmacion_operacion">
	<div class="modal fade" id="modal_confirmacion_general" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Mensaje de confirmación</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="url_confirmacion_general">
					<input type="hidden" id="btn_trigger_success" >
					<label id="msg_confirmacion_general"></label>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">No</button>
					<button type="button" id="btn_confirmar_operacion_general" class="btn btn-sm btn-outline-primary">Si</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<div id="modal_informacion_operacion_sistema">
	<div class="modal fade" id="modal_informacion_sistema" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Mensaje del Sistema</h4>
					<button type="button" class="close btn_cerrar_informacion_sistema" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<label id="msg_informacion_advertencia"></label>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-success btn_cerrar_informacion_sistema" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<div id="modal_ver_imagen">
	<div class="modal fade" id="modal_visor_imagen" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body" id="modal_body_visor_imagen">
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<!-- overlay full page -->
<div id="overlay_full_page" style="display: none;"></div>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/moment/moment.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/frm/adm_lte/dist/js/adminlte.js"></script>
<!-- InputMask -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/inputmask/jquery.inputmask.min.js"></script>

<!-- scripts externos -->
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>assets/frm/adm_lte/plugins/jquery-validation/localization/messages_es.js"></script>

<!-- scripts del plugin de notificaciones del sistema -->
<script src="<?=base_url()?>assets/frm/watnotif/js/watnotif-1.0.min.js"></script>

<script>
	var base_url = '<?=base_url()?>';
	var overlay = '' +
			'<div class="row">' +
			'	<div class="form-group col-sm-12 text-center">' +
			'		<div class="overlay">' +
			'			<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
			'			<div class="text-bold pt-2">Procesando...</div>' +
			'		</div>' +
			'	</div>' +
			'</div>';
	var extenciones_files_img = '<?=EXTENSIONES_FILES_IMG?>';
	var extenciones_files_pdf = '<?=EXTENSIONES_FILES_PDF?>';
	var extenciones_files_ati = '<?=EXTENSIONES_FILES_ATI?>';
	var extenciones_files_all = '<?=EXTENSIONES_FILES_ALL?>';
	var es_development = '<?=es_development()?>';
	var es_pruebas = '<?=es_pruebas()?>';
	var es_produccion = '<?=es_produccion()?>';
	var existe_login = '<?=sesionActive() != false ? true : false?>';
</script>

<script src="<?=base_url()?>assets/js/comun.js"></script>
<script src="<?=base_url()?>assets/js/login.js"></script>
<?php if(sesionActive() != false): ?>
	<script src="<?=base_url()?>assets/js/bells.js"></script>
	<script src="<?=base_url()?>assets/js/catalogos.js"></script>
<?php endif; ?>

<!-- js extras y secundarios se cargan conforme al modulo-->
<?php if (isset($extra_js)): ?>
	<?php foreach ($extra_js as $js): ?>
		<script src="<?=$js?>?ver=<?php echo uniqid(); ?>"></script>
	<?php endforeach;?>
<?php endif;?>

</body>
</html>
