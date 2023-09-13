<?php if(isset($config_correo) && sizeof($config_correo) != 0): ?>
	<?php foreach ($config_correo as $index => $cc): ?>
		<tr>
			<td><?=$cc->id_config_correo?></td>
			<td><?=$cc->smtp_secure.' / '.$cc->host.' / '.$cc->port?></td>
			<td><?=$cc->usuario.' / '.$cc->password?></td>
			<td><?=$cc->name?></td>
			<td>
				<?php if($cc->activo == 'si'): ?>
					<span class="badge badge-success">Si</span>
				<?php else: ?>
					<span class="badge badge-danger">No</span>
				<?php endif; ?>
			</td>
			<td>
				<?php if(perfil_permiso_operacion_menu('todos.todos')): ?>
					<button type="button" data-id_config_correo="<?=$cc->id_config_correo?>"
							data-toggle="tooltip" title="Modificar configuración de correo"
							class="btn btn-sm btn-outline-primary modificar_config_correo"><i class="fa fa-edit"></i> Editar</button>
					<?php if($cc->activo == 'no'): ?>
						<button type="button" class="btn btn-sm btn-outline-success iniciar_confirmacion_operacion"
								data-toggle="tooltip" title="Activar configuración"
								data-msg_confirmacion_general="¿Esta seguro de activar esta configuración para la salida de correos"
								data-url_confirmacion_general="<?=base_url()?>Configuracion/activar_config_correo/<?=$cc->id_config_correo?>"
								data-btn_trigger="#btn_buscar_configuracion_correo">
							<i class="fas fa-arrow-circle-up"></i> Activar
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="6" class="text-center">
			Sin registros encontrados
		</td>
	</tr>
<?php endif; ?>
