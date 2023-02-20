<!-- paginacion -->
<?php
$data_paginacion = array(
    'url_paginacion' => 'GaleriaCTN/buscar_galeria_publicacion_ctn',
    'conteiner_resultados' => '#conteiner_resultados_publicacion_ctn',
    'form_busqueda' => '',
    'id_paginacion' => uniqid(),
    'tipo_registro' => 'Cursos'
);
$this->load->view('default/paginacion_tablero',$data_paginacion);
?>

<?php if(isset($publicaciones_ctn_galeria) && is_array($publicaciones_ctn_galeria) && sizeof($publicaciones_ctn_galeria) != 0): ?>
    <?php foreach ($publicaciones_ctn_galeria as $index => $pc): ?>
        <div class="card mb-3">
            <div class="container">
                <div class="row">
                    <div class="form-group col-lg-4 col-md-8 col-sm-12 col-12">
                        <div id="carousel_galeria_publicacion_ctn_<?=$pc->id_publicacion_ctn?>" class="carousel slide img_galeria_publicacion" data-ride="carousel" data-interval="8000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100 img-thumbnail" src="<?=$pc->banner_curso?>" alt="<?=$pc->nombre_archivo?>">
                                </div>
                                <?php foreach ($pc->img_galeria as $img): ?>
                                    <div class="carousel-item">
                                        <img class="d-block w-100 img-thumbnail" src="<?=$img->ruta_documento?>" alt="<?=$img->nombre?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <a class="carousel-control-prev" href="#carousel_galeria_publicacion_ctn_<?=$pc->id_publicacion_ctn?>" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel_galeria_publicacion_ctn_<?=$pc->id_publicacion_ctn?>" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </div>
                    </div>
                    <div class="form-group col-lg-8 col-md-4 col-sm-12 col-12">
                        <p>
                            <span class="negrita"><?=$pc->nombre_curso_comercial?></span> <span class="help-span">Área temática: <?=$pc->area_tematica?></span>
                        </p>
                        <p>
                            <span>Impartido el: </span><span class="negrita"><?=fechaBDToHtml($pc->fecha_inicio)?></span>
                        </p>
                        <p class="text-justify"><?=$pc->descripcion?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
