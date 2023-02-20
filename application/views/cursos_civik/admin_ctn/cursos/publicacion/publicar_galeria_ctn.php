<div class="modal fade" role="dialog" id="modal_publicacion_galeria_ctn">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Galeria de imágenes <?= $curso_taller_norma->tipo ?></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">

                <input id="id_publicacion_ctn" type="hidden" value="<?=$publicacion_ctn->id_publicacion_ctn?>">

                <div id="mensajes_img_galeria_ctn" class="mensajes_sistema_civik"></div>

                <div class="row">
                    <div class="form-group col-lg-11 col-md-11 col-sm-11 col-11 text-right">
                        <input id="input_galeria_ctn" type="file" class="file fileUploadGaleriaCTN"
                               accept="image/*" name="img_galeria_ctn">
                    </div>
                    <div id="loader_img_galeria_ctn" class="form-group col-lg-1 col-md-1 col-sm-1 col-1 text-center" style="display: none">
                        <div style="text-align: center;"><img
                                src="<?php echo base_url("extras/imagenes/loaders/loader04.gif") ?>" width="75px"
                                href="75px"></div>
                    </div>
                </div>

                <div class="row" id="galeria_imagenes_ctn">
                    <?php if (isset($publicacion_ctn_galeria) && is_array($publicacion_ctn_galeria) && sizeof($publicacion_ctn_galeria) != 0): ?>
                        <?php foreach ($publicacion_ctn_galeria as $gc): ?>
                            <div id="img_publicacion_galeria_ctn_<?=$gc->id_documento?>" class="form-group col-lg-3 col-md-4 col-sm-6 col-12" >
                                <div class="card text-white text-right">
                                    <img class="card-img" src="<?= $gc->ruta_documento ?>">
                                    <div class="card-overlay-galeria">
                                        <button type="button" class="btn btn-pill btn-sm btn-danger eliminar_foto_galeria_pub_ctn"
                                                data-url_operacion="<?=base_url().'AdministrarCTN/eliminar_img_galeria/'.$gc->id_documento?>"
                                                data-msg_operacion="Se eliminará la imágen de la galeria <label>¿deseá continuar?</label>"
                                                data-remove_html="#img_publicacion_galeria_ctn_<?=$gc->id_documento?>"
                                                data-msg_show_growl="#mensajes_img_galeria_ctn">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-pill btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>
</div>