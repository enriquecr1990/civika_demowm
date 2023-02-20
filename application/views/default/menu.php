<nav id="nav">
    <img class="img_menu_logo" src="<?=base_url()?>extras/imagenes/logo/wm_logo.png" alter="Seguridad-WM" width="35px" >
    <ul>
        <li <?=isset($seccion) && $seccion == 'Inicio' ? 'class="current"':''?>><a href="<?= base_url() ?>"><i class="fa fa-home"></i> <span class="title_menu">Inicio</span></a></li>

        <?php if (isset($usuario) && $usuario !== false): ?>
            <?php if($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin'): ?>
                <?php $this->load->view('default/menu/administrador'); ?>
            <?php endif; ?>
            <?php if($usuario->tipo_usuario == 'instructor' ): ?>
                <?php $this->load->view('default/menu/instructor'); ?>
            <?php endif; ?>
            <?php if($usuario->tipo_usuario == 'alumno'): ?>
                <?php $this->load->view('default/menu/alumno'); ?>
            <?php endif; ?>
            <li <?=isset($seccion) && $seccion == 'Usuario' ? 'class="current"':''?>>
                <a href="#">
                    <?php if(isset($usuario->foto_perfil) && is_object($usuario->foto_perfil)): ?>
                        <img class="img_perfil_menu" src="<?=$usuario->foto_perfil->ruta_documento?>">
                    <?php else: ?>
                        <img class="img_perfil_menu" src="<?=base_url()?>extras/imagenes/logo/person.png">
                    <?php endif; ?>
                    <span id="usuario_sistema" class="title_menu"><?= $usuario->nombre.' '.$usuario->apellido_p ?></span> <i class="fa fa-caret-down"></i>
                </a>
                <ul>
                    <li>
                        <a href="<?=base_url()?>ControlUsuarios/perfil"><i class="fa fa-user"></i> Perfil</a>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>Login/cerrarSesion"><i class="fa fa-sign-out"></i> Cerrar sesión</a>
                    </li>
                </ul>
            </li>
        <?php else: ?>
            <li><a href="<?=base_url().'Login'?>"><i class="fa fa-sign-in"></i>Iniciar sesión</a></li>
        <?php endif; ?>
    </ul>

</nav>