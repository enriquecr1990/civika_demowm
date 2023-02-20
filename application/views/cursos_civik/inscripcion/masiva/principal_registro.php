<!-- cargar header del proyecto -->
<?php $this->load->view('default/header') ?>


<div class="container">

    <div class="card">
        <div class="card-header">
            <label>Inscripcion de trabajadores para el curso</label>
        </div>
        <div class="card-body" id="validacion_registro_empresa_trabajadores">
            <?php $this->load->view('cursos_civik/inscripcion/masiva/form_validar_rfc'); ?>
        </div>
    </div>

</div>

<div id="container_operacion_carta_descriptiva"></div>

<!-- cargar footer del proyecto -->
<?php $this->load->view('default/footer') ?>