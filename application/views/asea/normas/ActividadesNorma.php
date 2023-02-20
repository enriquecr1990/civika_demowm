<div class="panel-group" id="acordion" role="tablist" aria-multiselectable="true">
    <?php foreach($actividades_norma as $index => $an): ?>
        <div class="panel panel-default">
            <div id="heading_<?=$index?>" class="panel-heading" role="tab" data-toggle="collapse"
                 data-parent="#acordion" href="#actividad_<?=$index?>"
                 aria-expanded="true" aria-controls="collapse">
                <?=$an->descripcion?>
            </div>
            <div id="actividad_<?=$index?>" class="panel-collapse collapse <?=$index == 0 ? 'in':''?>"
                 role="tabpanel" aria-labelledby="heading_<?=$index?>">
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <label>Objetivo: </label><?=$an->objetivo?>
                        </div>
                    </div>
                    <div class="centrado">
                        <video controls class="videos_sistema" style="width: 100%">
                            <source src="<?=base_url().$an->url_video?>" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>