<?php if(perfil_permiso_operacion_menu('todos.todos')):?>
	<li class="nav-item <?=isset($sidebar) && in_array($sidebar,array('salida_correo')) ? ' menu-is-opening menu-open':''?>" >
		<a href="<?=base_url()?>usuario" class="nav-link nav-link-wm <?=isset($sidebar) && in_array($sidebar,array('salida_correo')) ? ' active':''?>">
			<i class="nav-icon fas fa-cogs"></i>
			<p>
				Configuración
				<i class="right fas fa-angle-left"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="<?=base_url()?>Configuracion/salida_correo" class="nav-link nav-link-wm <?=isset($sidebar) && $sidebar == 'salida_correo' ? 'active':''?>">
					<i class="nav-icon fas fa-mail-bulk"></i>
					<p>Salida de correo</p>
				</a>
			</li>
		</ul>
	</li>
<?php endif; ?>
