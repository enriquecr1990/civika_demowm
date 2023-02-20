<li <?=isset($seccion) && $seccion == 'Mis cursos' ? 'class="current"':''?>>
    <a data-toogle="tooltip" title="Mis cursos" href="<?=base_url().'Alumnos/mis_cursos'?>" ><i class="fa fa-bars"></i> <span class="title_menu">Mis cursos</span></a>
</li>

<li <?=isset($seccion) && $seccion == 'Mis evaluaciones' ? 'class="current"':''?>>
    <a data-toogle="tooltip" title="Mis cursos" href="<?=base_url().'Alumnos/mis_evaluaciones_online'?>" ><i class="fa fa-archive"></i> <span class="title_menu">Mis evaluaciones</span></a>
</li>