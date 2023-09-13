<?php if(perfil_permiso_operacion_menu('catalogos.modificar')):?>
	<li class="nav-item <?=isset($sidebar) && in_array($sidebar,array('cat_bienvenida')) ? ' menu-is-opening menu-open':''?>" >
		<a href="<?=base_url()?>usuario" class="nav-link <?=isset($sidebar) && in_array($sidebar,array('cat_bienvenida')) ? ' active':''?>">
			<i class="nav-icon fas fa-list"></i>
			<p>
				Catalogos
				<i class="right fas fa-angle-left"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="<?=base_url()?>Catalogos/bienvenida" class="nav-link <?=isset($sidebar) && $sidebar == 'cat_bienvenida' ? 'active':''?>">
					<i class="nav-icon fas fa-comment"></i>
					<p>Mensaje de bienvenida</p>
				</a>
			</li>
		</ul>
	</li>
<?php endif; ?>
