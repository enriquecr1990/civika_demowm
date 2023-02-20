<div class="modal fade" role="dialog" id="modal_empleado_es_cursar_norma_asea">
    <div class="modal-dialog modal-lg" role="document" style="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="display: none"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Curso norma Asea</h5>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group mensajes_sistema_asea">
                    <div class="col-sm-12">
                        <div class="alert alert-warning">
                            <button id="btn_close_alert_info_curso_norma" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            En cada actividad se encuentra el video respectivo, inicielo y espere a que aparezca el boton de <label>Terminar curso</label>  y pueda tomarse como cursado</div>
                    </div>
                </div>
                <input type="hidden" id="tiempo_actividades" value="<?=$tiempo_actividades?>">
                <div class="col-sm-12">
                    <div id="conteiner_mensajes_sistema_cursar_norma"></div>
                </div>
                <?php $this->load->view('asea/normas/ActividadesNorma'); ?>
                <div class="form-group">
                    <div class="col-sm-12 centrado">
                        <button class="btn btn-info btn-sm registrar_curso_norma_empleado_es" data-id_normas_asea="<?=$normas_asea->id_normas_asea?>"
                                data-dismiss="modal" style="display: none"><i class="glyphicon glyphicon-ok"></i>&nbsp;Terminar curso</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>