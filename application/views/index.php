<?php $this->load->view('default/header') ?>

<div class="container">

    <?php if(isset($cursos_disponibles) && is_array($cursos_disponibles) && sizeof($cursos_disponibles) != 0 ):?>
        <div class="row">
            <?php foreach ($cursos_disponibles as $index => $cd): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 popoverDescripcion"
                     data-titulo_curso="<?=$cd->nombre?>"
                     data-aling_placement="<?=$index % 2 == 0 ? 'right':'left'?>"
                     data-content_curso_html="#contenido_curso_<?=$index?>">
                    <div id="contenido_curso_<?=$index?>" style="display: none">
                        <ul>
                            <li><i class="fa fa-calendar"></i> Fecha: <?=fechaBDToHtml($cd->fecha_inicio)?></li>
                            <li><i class="fa fa-clock-o"></i> Horario: <?=$cd->horario?></li>
                            <li><i class="fa fa-clock-o"></i> Duración: <?=$cd->duracion?></li>
                            <li><i class="fa fa-map-marker"></i> Lugar: <?=$cd->direccion_imparticion?></li>
                            <li><i class="fa fa-user-secret"></i> Instructor: <?=$cd->instructor?></li>
                            <li><i class="fa fa-commenting"></i> Objetivo: <?=$cd->objetivo?></li>
                        </ul>
                    </div>
                    <div class="card">
                        <img class="card-img-top" src="<?=base_url().$cd->img_banner?>"
                             alt="<?=$cd->nombre?>">
                        <div class="card-body">
                            <h5 class="card-title"><?=$cd->nombre?></h5>
                            <p class="card-text">
                                <span>
                                    <?=substr($cd->objetivo,0,120).'...'?>
                                </span><br>
                                <span class="help-span"><?=$cd->instructor?></span><label>$<?=number_format($cd->costo,2)?></label>
                            </p>
                            <div class="text-right">
                                <a href="<?=base_url().'InscripcionesCTN/registroCursoTallerNorma/'.$cd->id_publicacion_ctn.'/'.$cd->id_instructor?>"
                                   class="btn btn-sm btn-pill btn-success">Inscribirme</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div id="conteiner_operacion_inscripcion_alumno"></div>

<?php $this->load->view('default/footer') ?>