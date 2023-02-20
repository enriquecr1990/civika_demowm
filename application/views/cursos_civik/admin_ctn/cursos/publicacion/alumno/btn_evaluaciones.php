<ul class="list-group">
    <!-- evaluacion diagnostica -->
    <?php if (isset($pc->prueba_diagnostica) && is_object($pc->prueba_diagnostica)): ?>
        <li class="list-group-item text-center">
            <p class="mt-1 mb-0"><span class="badge badge-light"><?=isset($pc->prueba_diagnostica->titulo_evaluacion) && existe_valor($pc->prueba_diagnostica->titulo_evaluacion) ? $pc->prueba_diagnostica->titulo_evaluacion : 'Evaluación diagnóstica'?></span></p>
            <?php if ($pc->prueba_diagnostica->publicacion_aprobada): ?>
                <p class="mt-1 mb-0">
                    Aprobado: <span class="badge badge-<?= $pc->prueba_diagnostica->etiqueta_evaluacion ?>"><?= $pc->prueba_diagnostica->calificacion_aprobada ?></span>
                </p>
            <?php else: ?>
                <?php if ($pc->prueba_diagnostica->puede_realizar_evaluacion): ?>
                    <p class="mt-1 mb-0">
                        <a class="btn btn-sm btn-pill btn-info" href="<?= base_url() ?>Alumnos/evaluacion_diagnostica/<?= $pc->id_publicacion_ctn ?>">
                            Realizar examen
                        </a>
                    </p>
                <?php else: ?>
                    <p class="mt-1 mb-0">
                        <span class="badge badge-danger">Intentos agotados</span>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    <?php endif; ?>

    <!-- evaluacion final -->
    <?php if (isset($pc->prueba_final) && is_object($pc->prueba_final)): ?>
        <li class="list-group-item text-center">
            <p class="mt-1 mb-0"><span class="badge badge-light"><?=isset($pc->prueba_final->titulo_evaluacion) && existe_valor($pc->prueba_final->titulo_evaluacion) ? $pc->prueba_final->titulo_evaluacion : 'Evaluación final'?></span></p>
            <?php if ($pc->prueba_final->publicacion_aprobada): ?>
                <p class="mt-1 mb-0">
                    Aprobado: <span class="badge badge-<?= $pc->prueba_final->etiqueta_evaluacion ?>"><?= $pc->prueba_final->calificacion_aprobada ?></span>
                </p>
                <?php
                    if($pc->id_catalogo_tipo_publicacion != CURSO_EVALUACION_ONLINE){
                        $data['publicacion_ctn'] = $pc;
                        $this->load->view('cursos_civik/admin_ctn/cursos/publicacion/alumno/btn_constancias', $data);
                    }
                ?>
            <?php else: ?>
                <?php if ($pc->prueba_final->puede_realizar_evaluacion): ?>
                    <p class="mt-1 mb-0">
                        <a class="btn btn-sm btn-pill btn-info" href="<?= base_url() ?>Alumnos/evaluacion_final/<?= $pc->id_publicacion_ctn ?>">
                            Realizar examen
                        </a>
                    </p>
                <?php else: ?>
                    <p class="mt-1 mb-0">
                        <span class="badge badge-danger">Intentos agotados</span>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    <?php endif; ?>
    <li class="list-group-item text-center">
        <button type="button" class="btn btn-sm btn-pill btn-primary ver_resultados_evaluacion"
                data-id_publicacion_ctn="<?=$pc->id_publicacion_ctn?>"
                data-id_alumno="<?=$pc->id_alumno?>">Ver examenes</button>
    </li>
</ul>