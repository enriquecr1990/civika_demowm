<div class="modal fade" role="dialog" id="modal_carta_descriptiva_ctn">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Carta descriptiva - <?= $publicacion_ctn->nombre_curso_comercial ?></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="alert alert-light">
                    <label><?= nl2br($publicacion_ctn->descripcion) ?></label>
                </div>

                <ul>
                    <li><i class="fa fa-calendar fa-2x"></i> <span
                        class="negrita">Fecha límite de inscripción: </span><?= fechaBDToHtml($publicacion_ctn->fecha_limite_inscripcion) ?>
                    </li>
                    <li><i class="fa fa-calendar fa-2x"></i> <span
                        class="negrita">Fecha de impartición: </span><?= fechaBDToHtml($publicacion_ctn->fecha_inicio) ?>
                    </li>
                    <li><i class="fa fa-clock-o fa-2x"></i> <span
                        class="negrita">Horario: </span><?= strMinusculas($publicacion_ctn->horario) ?></li>
                        <li><i class="fa fa-clock-o fa-2x"></i> <span
                            class="negrita">Duración: </span><?= $publicacion_ctn->duracion ?> (Valor de la
                            constancia: <?= $publicacion_ctn->duracion_constancia ?>)
                        </li>
                        <li><i class="fa fa-map-marker fa-2x"></i> <span
                            class="negrita">Lugar: </span><?= $publicacion_ctn->direccion_imparticion ?>
                            <a target="_blank" href="<?= $publicacion_ctn->mapa ?>" class="btn btn-sm btn-outline-info">Ver
                            Mapa</a>
                        </li>
                        <li>
                            <i class="fa fa-commenting fa-2x"></i> <span class="negrita">Objetivo:</span>
                            <?= nl2br($curso_taller_norma->objetivo) ?>
                        </li>
                        <?php if ($sede_presencial): ?>
                            <li>
                                <i class="fa fa-book fa-2x"></i> <span class="negrita">Entrada libre:</span>
                                <?= nl2br($sede_presencial->entrada_libre) ?>
                            </li>
                            <li>
                                <i class="fa fa-money fa-2x"></i> <span class="negrita">Descuentos sobre precio de lista:</span>
                                <?= nl2br($sede_presencial->descuento_descripcion) ?>
                            </li>
                        <?php endif; ?>
                        <li>
                            <i class="fa fa-users fa-2x"></i> <span class="negrita">Instructor(es)</span>
                            <ul>
                                <?php foreach ($instructor_asignado as $ia): ?>
                                    <li>
                                        <?= $ia->nombre . ' ' . $ia->apellido_p . ' ' . $ia->apellido_m ?>
                                   <!-- ,      <?= $ia->titulo ?> en <?= $ia->profesion ?>
                                   (<?= $ia->experiencia_curricular ?>)-->
                               </li>
                           <?php endforeach; ?>
                       </ul>
                   </li>

                   <?php foreach ($instructor_asignado as $fila): ?>     
                      <li>
                         <?php if(isset($fila->preparacion_academica) && is_array($fila->preparacion_academica) && sizeof($fila->preparacion_academica) != ''): ?>
                         <i class="fa fa-graduation-cap fa-2x"></i> <span class="negrita">Formación Adémica:</span>
                         <ul>
                            <?php foreach ($fila->preparacion_academica as $instructor): ?>
                                <li>
                                 <?= $instructor->profesion_carrera. ' ' .'egresado de la universidad '. ' '  .$instructor->institucion_academica. ' ' . 'terminando su carrera en el año'. ' '   . fechaBDToHtml($instructor->fecha_termino)
                                 ?>


                             </li>
                         <?php endforeach; ?>
                     </ul>
                 <?php endif; ?>

             </li>
             <li>
               <?php if(isset($fila->certificacion_curso_instructor) && is_array($fila->certificacion_curso_instructor) && sizeof($fila->certificacion_curso_instructor) != ''): ?>
               <i class="fa fa-certificate fa-2x"></i> <span class="negrita">Certificaciones, Diplomados y Cursos:</span>
               <ul>
                  <?php foreach ($fila->certificacion_curso_instructor as $certificaciones): ?>
                    <li>
                     <?= $certificaciones->nombre. ' ' .'lo ubtuvo de la institucion'. ' '  .$certificaciones->institucion. ' ' . 'con fecha de termino'. ' '   . fechaBDToHtml($certificaciones->fecha_finalizacion)?>
                 </li>
             <?php endforeach; ?>
         </ul>
     <?php endif; ?>
 </li>
 <li>
    <?php if(isset($fila->experiencia_laboral) && is_array($fila->experiencia_laboral) && sizeof($fila->experiencia_laboral) != ''): ?>
    <i class="fa fa-briefcase fa-2x"></i> <span class="negrita">Experiencia Laboral:</span>
    <ul>           
      <?php foreach ($fila->experiencia_laboral as $experiencia): ?>
        <li>
         <?= 'Trabjo en'. ' ' .$experiencia->puesto_trabajo. ' ' .'en la empresa'.  ' '  .$experiencia->empresa. ' ' . 'de '. ' '   . fechaBDToHtml($experiencia->fecha_ingreso). ' ' . ' a' .' ' .fechaBDToHtml($experiencia->fecha_termino)?>
     </li>
 <?php endforeach; ?>
<?php endif; ?>
</ul>
</li>
<?php endforeach; ?>

<li>
    <i class="fa fa-book fa-2x"></i> <span
    class="negrita">Eje temático: </span><?= nl2br($publicacion_ctn->eje_tematico); ?>
</li>
<!--se anexa el campo adicionales con condicion por si el campo es null (ucav)-->
<?php if ($publicacion_ctn->adicionales != null): ?>
    <li>
        <i class="fa fa-info-circle fa-2x"></i> <span
        class="negrita">Adicionales: </span><?= nl2br($publicacion_ctn->adicionales); ?>
    </li>
<?php endif; ?>

<li>
    <i class="fa fa-certificate fa-2x"></i> <span class="negrita">Valor curricular:</span>
    <?php foreach ($valor_curricular as $vc): ?>
        <ul>
            <li><?= $vc->constancia ?></li>
        </ul>
    <?php endforeach; ?>
</li>
<?php if (isset($material_didactico) && is_array($material_didactico) && sizeof($material_didactico) != 0): ?>
<li>
    <i class="fa fa-bookmark fa-2x"> </i><span class="negrita">Material didáctico:</span>
    <ul>
        <?php foreach ($material_didactico as $m): ?>
            <li>
                <?php if ($m->documento_publico == 'si'): ?>
                    <a href="<?= $m->ruta_documento ?>" target="_blank"><?= $m->titulo ?></a>
                    <?php else: ?>
                        <?= $m->titulo ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endif; ?>

<?php if(isset($coffe_break) && existe_valor($coffe_break)): ?>
<li>
    <i class="fa fa-coffee fa-2x"></i> <span class="negrita">Coffee Break: </span>
    <?= $coffe_break->nombre ?> (<?= $coffe_break->descripcion_break_curso ?>)
</li>
<?php endif; ?>

<li>
   <i class="fa fa-dollar fa-2x"></i> <span class="negrita">Formas de pago:</span>
   <?php foreach ($formas_pago as $forpa): ?>
    <ul>
       <li class="negrita"> <?= $forpa->titulo_pago ?></li>
       <?php if($forpa->banco != ''):?>
        <li> <?= 'Banco:'.' '. $forpa->banco ?></li>
    <?php endif; ?> 
    <?php if($forpa->numero_tarjeta != ''):?> 
        <li> <?='Numero de Tarjeta:' .' '.$forpa->numero_tarjeta ?></li>                <?php endif; ?> 
        <?php if($forpa->cuenta != ''):?>    
            <li> <?='Numero de cuenta:' . ' '. $forpa->cuenta ?></li>
        <?php endif; ?> 
        <?php if($forpa->titular != ''):?>
            <li> <?='A nombre de' . ' '.$forpa->titular ?></li>
        <?php endif; ?> 
        <?php if($forpa->clabe != ''):?>        
            <li> <?='Clabe interbancaria:'. ' '.$forpa->clabe ?></li>
        <?php endif; ?>        
    </ul>
<?php endforeach; ?>
<br><br>
<div align="justify" class="col-md-12 col-sm-12">
    <?php echo nl2br($formas_pago_detalle->descripcion); ?>
</div>
<br>
<ul>
    <li>  
        <p class="negrita">EN CASO DE REQUERIR FACTURA EL PRECIO ES MÁS I.V.A.</p>
    </li>
</ul>
</div>

<div class="modal-footer">
    <?php $inscripcion = true;
    $es_admin = false;
    if (isset($usuario) && $usuario) {
        if ($usuario->tipo_usuario != 'alumno') {
            $inscripcion = false;
        }
        if ($usuario->tipo_usuario == 'administrador' || $usuario->tipo_usuario == 'admin') {
            $es_admin = true;
        }
    }
    ?>
    <?php if ($inscripcion): ?>
        <?php if (isset($publicacion_ctn->alumno_inscripcion) && $publicacion_ctn->alumno_inscripcion): ?>
            <?php
            $leyenda = 'En proceso de inscripcion';
            $leyenda_detalle = '';
            $class = 'warning';
            $class_detalle = 'warning';
            $update_datos = true;
            if ($publicacion_ctn->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_EN_VALIDACION) {
                $leyenda = 'Pago en validación';
                $leyenda_detalle = 'Preinscripción realizada / pago en validación';
                $class = 'light';
                $update_datos = false;
            }
            if ($publicacion_ctn->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_OBSERVADO) {
                $leyenda = 'Pago observado';
                $leyenda_detalle = 'Preinscripción realizada / pago observado';
                $class = 'danger';
                $class_detalle = 'danger';
            }
            if ($publicacion_ctn->alumno_inscripcion->id_catalogo_proceso_inscripcion == PROCESO_PAGO_FINALIZADO_INSCRITO) {
                $leyenda = 'Inscrito';
                $leyenda_detalle = 'Inscripción realizada / pago validado';
                $class = 'success';
                $class_detalle = 'success';
                $update_datos = false;
            }
            ?>
            <span class="btn btn-sm btn-pill btn-<?= $class ?>" data-toggle="tooltip"
              title="Ver detalle"><?= $leyenda ?></span>
              <?php if ($update_datos): ?>
                <br>
                <a href="<?= base_url() . 'InscripcionesCTN/actualizarDatosAlumno/' . $publicacion_ctn->id_publicacion_ctn ?>"
                 class="btn btn-sm btn-pill btn-info" data-toggle="tooltip"
                 title="Ver detalle">Continuar proceso de inscripcion</a>
             <?php endif; ?>
             <?php else: ?>
                <?php $leyenda_detalle = ''; ?>
                <a href="<?= base_url() . 'InscripcionesCTN/registroCursoTallerNorma/' . $publicacion_ctn->id_publicacion_ctn ?>"
                 class="btn btn-sm btn-pill btn-success">Inscribirme</a>
             <?php endif; ?>
         <?php endif; ?>
         <button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cerrar</button>
     </div>

 </div>
</div>
</div>