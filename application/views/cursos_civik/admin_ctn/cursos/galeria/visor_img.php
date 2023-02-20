<div class="modal fade" role="dialog" id="modal_visor_galeria_publicacion_ctn">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php if(isset($glaeria_imagenes) && is_array($instructores) && sizeof($instructores) != 0): ?>
            <?php else: ?>
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="alert alert-light">
                            Sin registro de imagenes de galeria
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>