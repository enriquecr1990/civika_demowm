<div class="modal fade" role="dialog" id="modal_registrar_video_norma_actividad">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Seleccionar video norma</h5>
            </div>
            <form class="form-horizontal" id="form_seleccionar_video_actividad">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="panel panel-success">
                                <div class="panel-body">
                                    <?php if(is_array($ruta_videos)): ?>
                                        <?php $this->load->view('asea/normas/ContenidoCarpeta',array('contenido'=>$ruta_videos)); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>