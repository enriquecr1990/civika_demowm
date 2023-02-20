<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<!-- contenido de la pagina -->

<div class="row col-sm-12">
    <button class="btn btn-info" data-toggle="modal" data-target="#primer_modal" >Modal Bootstrap</button>
</div>

<div class="modal fade" role="dialog" id="primer_modal">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal de Bootstrap</h4>
            </div>
            <div class="modal-body">
                <!-- menu principal -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills">
                                <li class="active"><a data-toggle="tab" href="#opcion_1">Opcion 1</a></li>
                                <li><a data-toggle="tab" href="#opcion_2">Opcion 2</a></li>
                                <li><a data-toggle="tab" href="#opcion_3">Opcion 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- centenido de menu principal -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="opcion_1">
                        <p>&nbsp;</p>
                        <div class="container">
                            <div class="col-md-3">
                                <ul class="nav nav-tabs nav-stacked">
                                    <li class="active"><a data-toggle="tab" href="#opcion_1_1">Opcion 1-1</a></li>
                                    <li><a data-toggle="tab" href="#opcion_1_2">Opcion 1-2</a></li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="opcion_1_1">
                                        contenido de la opcion 1 1
                                    </div>
                                    <div class="tab-pane fade" id="opcion_1_2">
                                        contenido de la opcion 2 1
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="opcion_2">
                        opcion 2
                    </div>
                    <div class="tab-pane fade" id="opcion_3">
                        opcion 3
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>