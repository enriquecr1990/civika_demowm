<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div id="conteniner_mensajes_sistema_asea"></div>

    <div class="col-sm-12 centrado">
        <?php if(isset($mensaje)): ?>
            <div class="alert alert-warning mensajes_sistema_asea">
                <button id="btn_close_alert_inicio_sistema" type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="glyphicon glyphicon-warning-sign"></i>&nbsp;
                <?=$mensaje?>
            </div>
        <?php endif; ?>
    </div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>