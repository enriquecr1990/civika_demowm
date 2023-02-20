<?php foreach ($contenido as $index => $c): ?>
    <?php if($c['es_carpeta']): ?>
        <div class="panel panel-info">
            <div class="panel-body">
                <button type="button" class="btn btn-sm btn-primary boton_carpeta collapsed" data-toggle="collapse" data-target="#contenido_<?=$c['nombre_carpeta']?>_<?=$index?>">
                    <i class="glyphicon glyphicon-folder-open"></i>&nbsp;<?=$c['nombre_carpeta']?>
                </button>
                <div class="collapse" id="contenido_<?=$c['nombre_carpeta']?>_<?=$index?>">
                    <?php $this->load->view('asea/normas/ContenidoCarpeta',array('contenido'=>$c['contenido'])); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-sm-12">
            <video controls style="width: 30%">
                <source src="<?=base_url().$c['ruta_archivo'].'/'.$c['nombre_archivo']?>" type="video/mp4">
            </video>
            <i class="glyphicon glyphicon-film"></i><?=$c['nombre_archivo']?>
            <button type="button" class="btn btn-xs btn-info seleccionar_archivo_video"
                    data-destino_video="<?=$destino_video?>"
                    data-url_video="<?=$c['ruta_archivo'].'/'.$c['nombre_archivo']?>"
                    data-nombre_video="<?=$c['nombre_archivo']?>">
                <i class="glyphicon glyphicon-check"></i>&nbsp;Seleccionar
            </button>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
