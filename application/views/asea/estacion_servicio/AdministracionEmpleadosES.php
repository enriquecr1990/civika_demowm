<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>

<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">Evaluacion norma Asea</div>
        <div class="panel-body">
            <?php $this->load->view('asea/estacion_servicio/FormControlEmpleadosEs'); ?>
        </div>
    </div>
</div>

<div id="conteiner_empleado_cursar_norma_asea"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>