<?php if(perfil_permiso_operacion_menu('estandar_competencia.consultar')):?>
	<li class="nav-header">Estándar de competencia</li>
	<li class="nav-item">
		<a href="<?=base_url()?>estandar_competencia" class="nav-link <?=isset($sidebar) && $sidebar == 'estandar_competencias' ? 'active':''?>">
			<i class="nav-icon far fa-list-alt"></i>
			<p><?=isset($usuario) && in_array($usuario->perfil,array('root','admin')) ? 'Listado':'Mis EC'?></p>
		</a>
	</li>
<?php endif; ?>
