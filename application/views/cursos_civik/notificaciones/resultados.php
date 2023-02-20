<div class="row">
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (isset($array_notificaciones) && is_array($array_notificaciones) && sizeof($array_notificaciones) != 0): ?>
            <?php foreach ($array_notificaciones as $n): ?>
                <div class="card <?=$n->notificacion_leida ? '':'mensaje_no_leido'?>">
                    <div class="card-body">
                        <ul>
                            <li><i class="fa fa-user"></i> <?=$n->nombre_envia.' '.$n->apellido_p_envia?></li>
                            <li><i class="fa fa-calendar"></i> <?=fechaHoraBDToHTML($n->fecha)?></li>
                            <li><i class="fa fa-pencil-square"> </i><?=$n->mensaje?></li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-light">
                No tiene notificaciones registradas en el sistema
            </div>
        <?php endif; ?>
    </div>
</div>