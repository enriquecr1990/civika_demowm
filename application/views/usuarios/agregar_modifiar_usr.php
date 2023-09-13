<div class="modal fade" id="modal_form_usr" aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=isset($usuario) ? 'Actualizar':'Nuevo'?> <?=isset($tipo_usuario) ? $tipo_usuario : ''?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form_agregar_modificar_usr">
				<input type="hidden" name="update_datos" value="<?=isset($usuario) ? $usuario->update_datos + 1 : 0?>">
				<div class="modal-body">
					<?php if(isset($tipo_usuario) && $tipo_usuario == 'admin'): ?>
						<?php $this->load->view('usuarios/form_admin'); ?>
					<?php endif?>
					<?php if(isset($tipo_usuario) && $tipo_usuario == 'evaluador'): ?>
						<?php $this->load->view('usuarios/form_instructor'); ?>
					<?php endif?>
					<?php if(isset($tipo_usuario) && $tipo_usuario == 'candidato'): ?>
						<?php $this->load->view('usuarios/form_candidato'); ?>
					<?php endif?>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" id="btn_guardar_form_usuario"
							data-modificacion_from_perfil="<?=isset($modificacion_from_perfil) ? $modificacion_from_perfil : 'no'?>"
							data-id_usuario="<?=isset($usuario) ? $usuario->id_usuario : ''?>" class="btn btn-sm btn-outline-primary">Guardar</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
