<div class="row">
    <div class="form-group col-lg-12 col-md-12 col-sm-12">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" >
                <div class="carousel-item active banner_civik">
                    <img class="d-block w-100 " src="<?=base_url().'extras/imagenes/logo/proximamente.jpg'?>" alt="Cursos proximos">
                    <div class="carousel-caption d-md-block banner_civik_body">
                        <div class="alert mensaje_banner">
                            <label class="mensaje_banner_titulo">OFERTA EDUCATIVA</label>
                            Contamos con más de 400 cursos registrados ante la STPS<br>
                            Esté atento en la plataforma para los proximos cursos a publicarse
                        </div>
                    </div>
                </div>
                <?php if(isset($cursos_proximos) && $cursos_proximos): ?>
                    <?php foreach ($cursos_proximos as $index => $cp): ?>
                        <div class="carousel-item banner_civik">
                            <?php
                            $indice_img = $index % 3;
                            $url_banner = base_url()."extras/imagenes/logo/proximamente_".$indice_img."jpg";
                            if(isset($cp->documento_banner) && is_object($cp->documento_banner)){
                                $url_banner = $cp->documento_banner->ruta_documento;
                            }
                            ?>
                            <img class="d-block w-100 " src="<?=$url_banner?>" alt="Proximos cursos">
                            <div class="carousel-caption d-md-block banner_civik_body">
                                <div class="alert mensaje_banner">
                                    <label class="mensaje_banner_titulo"><?=strtoupper($cp->nombre)?></label>
                                    Proximamente el curso, esté atento a la plataforma
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if(isset($cursos_proximos) && $cursos_proximos): ?>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>