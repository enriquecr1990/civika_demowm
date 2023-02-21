<?php if($publicacion_ctn->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO): ?>
    <?php if(isset($publicacion_ctn->tiene_constancia_externa) && $publicacion_ctn->tiene_constancia_externa == 'no'): ?>
        <ul class="text-center">
            <?php if(isset($evaluaciones_alumno) && is_array($evaluaciones_alumno)): ?>
            <?php foreach ($evaluaciones_alumno as $ea): ?>
                    <li class="mb-3">
                        <a href="<?=base_url().'DocumentosPDF/constancia_wm/'.$publicacion_ctn->id_publicacion_ctn.'/'.$ea?>"
                           class="btn btn-info btn-sm btn-pill mr-3"
                           data-toggle="tooltip"
                           title="Ver Constancia WM" target="_blank">
                            <i class="fa fa-download fa-white"></i> Constancia WM
                        </a>
                    </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php else: ?>
        <ul class="text-justify">
            <li class="mb-3">
                <span class="negrita"> <i>Este curso proporciona una constancia externa a nosotros, nos contactaremos a la brevedad para explicarle el proceso de entrega y recepción de su constancia</i></span>
            </li>
        </ul>
    <?php endif; ?>
<?php endif; ?>