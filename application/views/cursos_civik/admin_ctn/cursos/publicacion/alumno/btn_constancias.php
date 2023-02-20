<?php if($publicacion_ctn->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO): ?>
    <?php if(isset($publicacion_ctn->tiene_constancia_externa) && $publicacion_ctn->tiene_constancia_externa == 'no'): ?>
        <ul class="text-center">
            <?php if(isset($publicacion_ctn->aplica_dc3) && $publicacion_ctn->aplica_dc3 ): ?>
                <li class="mb-3">
                    <a href="<?=base_url().'DocumentosPDF/constancia_dc3/'.$publicacion_ctn->id_alumno.'/'.$publicacion_ctn->id_publicacion_ctn?>"
                       class="btn btn-info btn-sm btn-pill mr-3"
                       data-toggle="tooltip"
                       title="Ver DC-3" target="_blank">
                        <i class="fa fa-download fa-white"></i> DC-3
                    </a>
                </li>
            <?php endif; ?>
            <?php if(isset($publicacion_ctn->aplica_fdh) && $publicacion_ctn->aplica_fdh): ?>
                <li class="mb-3">
                    <a href="<?=base_url().'DocumentosPDF/constancia_fdh_alumno/'.$publicacion_ctn->id_publicacion_ctn.'/'.$publicacion_ctn->id_alumno?>"
                       class="btn btn-primary btn-sm btn-pill mr-3"
                       data-toggle="tooltip"
                       title="Ver DC-3" target="_blank">
                        <i class="fa fa-download fa-white"></i> FDH
                    </a>
                </li>
            <?php endif; ?>
            <?php if(isset($publicacion_ctn->aplica_habilidades) && $publicacion_ctn->aplica_habilidades ): ?>
                <li class="mb-3">
                    <a href="<?=base_url().'DocumentosPDF/habilidades_const/'.$publicacion_ctn->id_alumno .'/'.$publicacion_ctn->id_publicacion_ctn?>"
                       class="btn btn-success btn-sm btn-pill mr-3"
                       data-toggle="tooltip"
                       title="Ver Constancia Habilidades" target="_blank">
                        <i class="fa fa-download fa-white"></i> Habilidades
                    </a>
                </li>
            <?php endif;?>
            <?php if(isset($publicacion_ctn->aplica_otra) && $publicacion_ctn->aplica_otra ): ?>
                <li><span class="help-span"><?=$publicacion_ctn->aplica_otra->especifique_otra_constancia?></span></li>
                <li class="mb-3">
                    <a href="<?=base_url().'DocumentosPDF/constancia_cigede/'.$publicacion_ctn->id_alumno .'/'.$publicacion_ctn->id_publicacion_ctn?>"
                       class="btn btn-warning btn-sm btn-pill mr-3 text-white"
                       data-toggle="tooltip"
                       title="Ver Constancia Cigede" target="_blank">
                        <i class="fa fa-download fa-white"></i> Otra
                    </a>
                </li>
            <?php endif;?>
        </ul>
    <?php else: ?>
        <ul class="text-justify">
            <li class="mb-3">
                <span class="negrita"> <i>Este curso proporciona una constancia externa a nosotros, nos contactaremos a la brevedad para explicarle el proceso de entrega y recepción de su constancia</i></span>
            </li>
        </ul>
    <?php endif; ?>
<?php endif; ?>