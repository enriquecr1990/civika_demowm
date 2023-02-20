<div class="modal fade" role="dialog" id="modal_bitacora_error_view">
    <div class="modal-dialog modal-xlg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title">Detalle bitacora error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12">
                        <pre id="content_json_bitacora_error"><?= $bitacora_error->post_usr ?></pre>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <p>
                            <?=$bitacora_error->respose_error?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm btn-pill" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>