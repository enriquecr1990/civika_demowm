<li <?=isset($seccion) && $seccion == 'Administrar CTN' ? 'class="current"':''?>>
    <a href="#" ><i class="fa fa-bars"></i> <span class="title_menu">Administrar CTN</span></a>
    <ul>
        <li>
            <a href="#">Cursos</a>
            <ul>
                <li ><a href="<?=base_url()?>AdministrarCTN/cursos">Listado de Cursos STPS</a></li>
                <li ><a href="<?=base_url()?>AdministrarCTN/ver_publicaciones_ctn">Cursos Publicados</a></li>
            </ul>
        </li>
    </ul>
</li>

<li <?=isset($seccion) && $seccion == 'Usuarios' ? 'class="current"':''?>>
    <a href="<?=base_url().'ControlUsuarios'?>" ><i class="fa fa-users"></i> <span class="title_menu">Usuarios</span></a>
</li>
