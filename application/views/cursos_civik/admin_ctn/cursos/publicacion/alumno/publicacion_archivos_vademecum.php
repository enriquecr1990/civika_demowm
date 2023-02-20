<div class="modal fade" role="dialog" id="modal_publicacion_archivos_vademun">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <label>Contenido</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <th width="8%">#</th>
                                <th>Tema</th>
                                <th>Ver vídeo</th>
                                <th width="8%">Descargar material</th>
                                </thead>
                                <tbody>
                                <?php if(isset($archivos_vademecum) && is_array($archivos_vademecum) && sizeof($archivos_vademecum) != 0): ?>
                                    <?php foreach ($archivos_vademecum as $index => $av):?>
                                        <tr>
                                            <td><?=$index+1?></td>
                                            <td>
                                                <label><?=$av->titulo?></label>
                                                <span class="help-span"><?=$av->descripcion?></span>
                                            </td>
                                            <td>
                                                <?php if(isset($av->url_video) && existe_valor($av->url_video)): ?>
                                                    <a href="<?=$av->url_video?>" target="_blank" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-youtube-play"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge badge-light">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?=$av->ruta_documento?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-download"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay archivos de material de apoyo</td>
                                </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <table>

                </table>
            </div>

            <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-success btn-pill btn-sm publicacion_aceptar_descarga_vademecum"
                        data-id_alumno_inscrito_ctn_publicado="<?=$id_alumno_inscrito_ctn_publicado?>">
                    Aceptar descarga
                </button>
            </div>

        </div>
    </div>
</div>